@extends('admin.layouts.default')
@section('content')
    
	
<section class="content-header">
<h1>
    My Transactions  
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">My Transactions</li>
</ol>
</section>
<!-- Main content -->
<section class="content">
	<div id="hd" name="hd">
		<h1> Please complete your transaction below... </h1> <hr />
	</div>
<?php 
	$transaction = $objects; //var_dump($objects); echo "<hr>"; var_dump(Input::all());//exit;
	if(!empty($transaction) && is_null(Input::get('JP_PASSWORD'))){  ?>
		<div  class="col-md-6" id="jambo" name="jambo">
		<form method="post" action="https://www.jambopay.com/JPExpress.aspx" target="output_frame">
		<input type="hidden" name="jp_item_type" value="cart"/>
		<input type="hidden" name="jp_item_name" value="Mradi Credit"/>
		<input type="hidden" name="order_id" value="{{ $transaction->order_id }}"/>
		<input type="hidden" name="jp_business" value="demo@webtribe.co.ke"/>
		<input type="hidden" name="jp_amount_1" value="{{ $transaction->amount }}"/>
		<input type="hidden" name="jp_amount_2" value="0"/>
		<input type="hidden" name="jp_amount_5" value="0"/>
		<input type="hidden" name="jp_payee" value="gikiruchegeh@gmail.com"/>
		<input type="hidden" name="jp_shipping" value="Mradi"/>
		<input type="hidden" name="jp_rurl" value="http://mradi.com/wallet?sid=1&tid={{ $transaction->id }}&uid=<?=Session::get('account_id')?>"/>
		<input type="hidden" name="jp_furl" value="http://mradi.com/walletc?sid=2&tid={{ $transaction->id }}&uid=<?=Session::get('account_id')?>"/>
		<input type="hidden" name="jp_curl" value="http://mradi.com/walletc?sid=3&tid={{ $transaction->id }}&uid=<?=Session::get('account_id')?>"/>
		<input type="image" name="jambo" id="jambo" src="https://www.jambopay.com/jp_image/paynow.png"/>
		</form>									
		</div>
		
		
		<div id="myframe" name="myframe" >
			<iframe name="output_frame" src="" id="output_frame" width="80%" height="700px" scrolling="no" frameborder="0"> </iframe
		</div>
				
<?php
    }else{
		echo "<h4> Transaction Error, please try again later. </h4>";
	}
?>



<script src="<?=url()?>/app/views/admin/js/jquery.min.js"></script>
<script type="text/javascript">		
		$("#myframe").hide();
		
		 $("#jambo").click(function(){
			$("#jambo").hide();
			$("#hd").hide();
			$("#myframe").show();
			});
</script>

</section><!-- /.content -->
@stop
	
	
