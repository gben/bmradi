@extends('admin.layouts.default')
@section('content')
    
@if(Session::has('_response'))
	<!-- Main content -->
	<section class="content">
		{{ Session::get('_response') }}
@else
	<section class="content-header">
	<h1>
		@if(strtolower(session::get('account_type')) != "admin")
			<?php $profileDetails = Helpers::getProfileDetails(); ?>
			Campaign Bids for : {{ strtoupper(session::get('account_type')) . " - " . strtoupper($profileDetails[0]->firstname) . " " .  strtoupper($profileDetails[0]->lastname) }}
		@else
			Recent Campaign Bids
		@endif
	</h1>
	
	<div class="row"  style="background-color:#DBE6E0;">
		<div class="col-md-3">
			<h4>
				<?php $bids = $totalInvestorBid ? $totalInvestorBid->count() : '0'; ?>
				Bids (Total) : {{ $bids }}
			</h4>
		</div>
		<div class="col-md-5">
			<h4>
				<?php $tBid = $totalInvestorBid ? number_format($totalInvestorBid->sum('Amount'), 2) : number_format(0, 2); ?>
				Total Amount Bidded : {{ "KShs." . $tBid}}
			</h4>
		</div>
		<div class="col-md-4">
			<h4>
				A/c Balance : {{ "KShs." . number_format($myBalance,2) }}
			</h4>
		</div>
	</div>
	
	<div class="row" style="background-color:#B6C5BE;">
		<div class="col-md-2"> </div>
		<div class="col-md-4">
			<h4>
				<?php $bids = $totalOnlineBid ? $totalOnlineBid[0]->count : '0'; ?>
				Bids(Online) : {{ $bids }}
			</h4>
		</div>
		<div class="col-md-4">
			<h4>
				<?php $tBid = $totalOnlineBid ? number_format($totalOnlineBid[0]->amount, 2) : number_format(0, 2); ?>
				Amount Bidded(Online) : {{ "KShs." . $tBid }}
			</h4>
		</div>
		<div class="col-md-2"> </div>
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
	$category[""] = "Select Status";
	$category["All"] = "All";
	$category["Ongoing"] = "Ongoing";
	$category["Closed"] = "Closed";
	
	if(!empty($mytransactions)){ 
		$i = count($mytransactions);
?>
	{{ Form::open(array('url'=>URL::to('campaign_bid_list'), 'name'=>'bidDetails', 'methode'=>'get')) }}
	{{ Form::select('categories_list',@$category,Input::get('categories_list'),array("style"=>"width:40% !important; margin-left: 0px;","class"=>"form-control")) }} 
	
	<hr />
	<table class="table table-striped table-bordered">
    <thead>
        <tr>
			<td>#</td>
			<td><b>Campaign Name</b></td>
			
		@if(strtolower(Session::get('account_type')) == 'investor')
            <td><b>Order ID</b></td>
            <td><b>Bid Amount</b></td>
            <td><b>Campaign Status</b></td>
            <td><b>Bid Date</b></td>
        @else
			<td><b>No. Of Bids</b></td>  
			<td><b>Total Bidded</b></td>
			<td><b>Campaign Balance</b></td>
			<td><b>Campaign Status</b></td>
            <td><b>Last Bid</b></td>
        @endif
        </tr>
    </thead>
    <tbody>
    @foreach($mytransactions as $transaction)
		
        <tr>
			<td>{{ $i-- }}</td>
			<td> <?php $hLink = URL::route('campaigns_grid_info', array('campaign' => $transaction->campaign_id)); ?>
				{{
					HTML::link($hLink, strtoupper(Helpers::getCampaignID($transaction->campaign_id, true)), array("class" => ""));
				}}
			</td>
            
		@if(strtolower(Session::get('account_type')) == 'investor')
            <td>{{ $transaction->order_id }}</td>
            <td>{{ number_format($transaction->amount,2) }}</td>
            <td>{{ strtoupper($transaction->campaignstatus) }}</td>
            <td>{{ $transaction->updated_at }}</td>
        
        @else
			<td>
				{{
					HTML::link('bid/'.$transaction->campaign_id, $transaction->count, array("class" => ""));
				}}</td>
			<td>{{ number_format($transaction->totalBid,2) }}</td>
			<td>{{  
					number_format((Helpers::getCampaignProposal($transaction->campaign_id)[0]->total_investment - $transaction->totalBid),2)
			}}</td>
			<td>{{ strtoupper($transaction->campaignstatus) }}</td>
            <td>{{ $transaction->updated_at }}</td>
        @endif        
        </tr>
    @endforeach
    </tbody>
</table>	

<?php
    }else{
		echo "<h4> No records to show. </h4>";
	}
?>

{{ $mytransactions->links() }}


{{ Form::close() }}

</section><!-- /.content -->
@stop
	
	
