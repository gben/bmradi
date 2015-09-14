@extends('admin.layouts.default')
@section('content')
    
@if(Session::has('_response'))
	<!-- Main content -->
	<section class="content">
		{{ Session::get('_response') }}
@else
	<section class="content-header">
	<h1>
		@if(strtolower(Session::get('account_type')) == 'admin')
			MradiFund Accounts Statement Summary  
		@else
			MradiFund Account Statement  
		@endif
	</h1>
	
	<div class="row">
		<div class="col-md-4">
			<h3>
				@if(strtolower(Session::get('account_type')) == 'admin')
					<?php $bids = $totalInvestorBid ? $totalInvestorBid->count() : '0'; ?>
					Investments : {{ $bids }}
				@else
					<?php $bids = $totalInvestorBid ? $totalInvestorBid->count() : '0'; ?>
					No Of Bids : {{ $bids }}
				@endif
			</h3>
		</div>
		<div class="col-md-4">
			<h3>
				<?php $tBid = $totalInvestorBid ? number_format($totalInvestorBid->sum('Amount'), 2) : number_format(0, 2); ?>
				Total Investment : {{ "KShs." . $tBid}}
			</h3>
		</div>
		<div class="col-md-4">
			<h3>
				@if(strtolower(Session::get('account_type')) == 'admin')
					Total Deposits : {{ "KShs." . number_format($myBalance,2) }}
				@else
					A/c Balance : {{ "KShs." . number_format($myBalance,2) }}
				@endif
			</h3>
		</div>
	</div>
	
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">My Transactions</li>
	</ol>
	</section>
	<!-- Main content -->
	<section class="content">

@endif

<?php
	$mytransactions = $objects;
	if(!empty($mytransactions)){ $i = count($mytransactions); //var_dump($mytransactions); ?>
	
	<table class="table table-striped table-bordered">
    <thead>
        <tr>
		@if(strtolower(Session::get('account_type')) == 'admin')
			<td>#</td>
			<td>User Name</td>
            <td>Amount</td>
            <td>Balance</td>
            <td>Date</td>
		@else
			<td>#</td>
			<td>Transaction Type</td>
            <td>Order ID</td>
            @if(strtolower(Session::get('account_type')) == 'entrepreneur')
				<td>Investor</td>
			@else
				<td>Transaction ID</td>
				<td>Currency</td>
				<td>Channel</td>
            @endif
            <td>Amount</td>
            <td>Balance</td>
            <td>Date</td>
        @endif
        </tr>
    </thead>
    <tbody>
    @foreach($mytransactions as $transaction)
        <tr>
		@if(strtolower(Session::get('account_type')) == 'admin')
			<td>{{ $i-- }}</td>
			<td>
					<?php $investor = Helpers::getinvestorDetails($transaction->user_id); ?>
					{{ HTML::link('wallet/'.$transaction->user_id, @strtoupper($investor->firstname . " " . $investor->lastname), array("class" => "")) }}
			</td>
            <td>{{ $amount = $transaction->credit > 0 ? number_format($transaction->credit,2) . " (+)" : number_format($transaction->debit,2) . " (-)" }}</td>
            <td>{{ number_format($transaction->balance,2) }}</td>
            <td>{{ $transaction->updated_at }}</td>
		@else
			<td>{{ $transaction->id }}</td>
			<td>{{ $transaction->mraditransactiontype['desc'] }}</td>
            <td>{{ $transaction->order_id }}</td>
            @if(strtolower(Session::get('account_type')) == 'entrepreneur')
				<td> @if($transaction->mraditransactiontype['id'] == '2')
						<?php $investor = Helpers::getinvestorDetails($transaction->mradicampaignbid['investor_id']); ?>
					    {{ @strtoupper($investor->firstname . " " . $investor->lastname) }}
					@endif </td>
			@else
				 <td> @if($transaction->mraditransactiontype['id'] == '1')
					 {{ $transaction->mraditransactionlog['trx_id'] }}
					@endif </td>
			   
				<td>@if($transaction->mraditransactiontype['id'] == '1')
						{{ $transaction->mraditransactionlog['currency'] }}
					@endif</td>
				<td>@if($transaction->mraditransactiontype['id'] == '1')
						{{ $transaction->mraditransactionlog['channel'] }}
					@endif</td>
			@endif
            <td>{{ $amount = $transaction->credit > 0 ? number_format($transaction->credit,2) . " (+)" : number_format($transaction->debit,2) . " (-)" }}</td>
            <td>{{ number_format($transaction->balance,2) }}</td>
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
{{$mytransactions->links()}}
</section><!-- /.content -->
@stop
	
	
