@extends('admin.layouts.default')
@section('content')
    
@if(Session::has('_response'))
	<!-- Main content -->
	<section class="content">
		{{ Session::get('_response') }}
@else
	<section class="content-header">
	<h1>
		Financials Template Purchases
	</h1>
	
	<div class="row"  style="background-color:#DBE6E0;">
		<div class="col-md-6">
			<h4>
				<?php $purchases = $transList ? $transList->count() : '0'; ?>
				Total Purchases : {{ $purchases }}
			</h4>
		</div>
		<div class="col-md-6">
			<h4>
				<?php $tBid = $transList ? number_format($transList->sum('amount'), 2) : number_format(0, 2); ?>
				Total Amount : {{ "KShs." . $tBid}}
			</h4>
		</div>
	</div>
		
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Template Purchases</li>
	</ol>
	</section>
	<!-- Main content -->
	<section class="content">

@endif

<?php 
	$mytransactions = $transList;
	
	if(!empty($mytransactions)){ 
		$i = count($mytransactions);
?>
	
	<table class="table table-striped table-bordered">
    <thead>
        <tr>
			<td>#</td>
			<td><b>Entrepreneur Name</b></td>
			<td><b>Phone</b></td>
			<td><b>Campaign Name</b></td>
			<td><b>Order ID</b></td>
			<td><b>Transaction ID</b></td>
            <td><b>Amount</b></td>
            <td><b>Currency</b></td>
            <td><b>Channel</b></td>
			<td><b>Date</b></td>
        </tr>
    </thead>
    <tbody>
    @foreach($mytransactions as $transaction) <?php //var_dump($transaction);exit; ?>
		
        <tr>
			<td>{{ $i-- }}</td>
			<td>{{ $transaction->firstname . " " . $transaction->lastname }}</td>
			<td>{{ $transaction->phone }}</td>
			<td> <?php $hLink = URL::route('campaigns_grid_info', array('campaign' => Helpers::getUniqueCampaignID($transaction->campaign_id))); ?>
				{{
					HTML::link($hLink, strtoupper(Helpers::getCampaignID(Helpers::getUniqueCampaignID($transaction->campaign_id), true)), array("class" => ""));
				}}
			</td>
            <td>{{ $transaction->order_id }}</td>
            <td>{{ $transaction->trx_id }}</td>
            <td>{{ number_format($transaction->amount,2) }}</td>
            <td>{{ $transaction->currency }}</td>
            <td>{{ $transaction->channel }}</td>
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

{{ $mytransactions->links() }}

</section><!-- /.content -->
@stop
	
	
