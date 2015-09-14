@extends('admin.layouts.default')
@section('content')
    
@if(Session::has('_response'))
	<!-- Main content -->
	<section class="content">
		{{ Session::get('_response') }}
@else
	<section class="content-header">
	<h1>
		<?php $campaign_name = Helpers::getCampaignID($campaign_id, true); ?>
			{{ "<h2>Campaign Bids for : " . strtoupper($campaign_name) . "</h2>" }}
	</h1>
	
	<div class="row"  style="background-color:#DBE6E0;">
		<div class="col-md-3">
			<h4>
				No Of Investors : {{ $investorCount }}
			</h4>
		</div>
		<div class="col-md-5">
			<h4>
				Total Amount Bidded : {{ "KShs." . number_format($totalBid, 2)}}
			</h4>
		</div>
		<div class="col-md-4">
			<h4>
				Balance : {{ "KShs." . number_format(($campaignValue - $totalBid),2) }}
			</h4>
		</div>
	</div>
	
	
	
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">My Campaign Bids</li>
	</ol>
	</section>
	<!-- Main content -->
	<section class="content">

@endif

<?php 
	$mytransactions = $objects;
	if(!empty($mytransactions)){  //var_dump($mytransactions);
		
?>
	
	<table class="table table-striped table-bordered">
    <thead>
        <tr>
			<td>#</td>
			<td><b>Campaign Name</b></td>
            <td><b>Investor Name</b></td>  
            <td><b>Order ID</b></td>
            <td><b>Bid Amount</b></td>
			<td><b>Total Bidded</b></td>
			<td><b>Campaign Balance</b></td>
			<td><b>Campaign Status</b></td>
            <td><b>Bid Date</b></td>
        </tr>
    </thead>
    <tbody>
    @foreach($mytransactions as $transaction)
		
        <tr>
			<td>{{ $transaction->id }}</td>
			<td><?php $hLink = URL::route('campaigns_grid_info', array('campaign' => $transaction->campaign_id)); ?>
				{{
					HTML::link($hLink, strtoupper(Helpers::getCampaignID($transaction->campaign_id, true)), array("class" => ""));
				}}
			</td>
            <?php $investor = Helpers::getinvestorDetails($transaction->investor_id); ?>
			<td>{{ @strtoupper($investor->firstname . " " . $investor->lastname) }}</td>
			<td>{{ $transaction->order_id }}</td>
            <td>{{ number_format($transaction->amount,2) }}</td>
			<td>{{ number_format($transaction->total_bidded,2) }}</td>
			<td>{{  
					number_format((Helpers::getCampaignProposal($transaction->campaign_id)[0]->total_investment - $transaction->total_bidded),2)
			}}</td>
			<td>{{ strtoupper(Helpers::getCampaignID($transaction->campaign_id, '', true)->campaignstatus) }}</td>
            <td>{{ $transaction->updated_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>	

<?php
    }else{
		echo "<h4> No records to show. </h4>";
	}
?>
{{$mytransactions->links()}}
</section><!-- /.content -->
@stop
	
	
