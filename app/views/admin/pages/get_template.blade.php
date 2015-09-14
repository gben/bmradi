@extends('admin.layouts.default')
@section('content')
    
	
<section class="content-header">

</section>
<!-- Main content -->
<section class="content">
	{{ Session::get('_response') }}
<?php
	
	if(is_null(Input::get('sid')) && is_null(Input::get('JP_PASSWORD'))){
		$transaction = array();
		$transaction['user_id'] = Session::get('account_id');
		$transaction['order_id'] = mt_rand(11111111, 99999999);
		$transaction['amount'] = Session::get('template_price');
		$transaction['campaign_id'] = e(Helpers::getCampaignID(Input::get('campaign')));
		$transaction['item_name'] = "Mradi Purchase";
		$res = Helpers::getTemplate($transaction); //var_dump($res);exit;
		$email = session::get('email_address'); //exit;  ?>
		
		<div  class="col-md-6" id="jambo" name="jambo">
		<form method="post" action="https://www.jambopay.com/JPExpress.aspx" target="_blank">
		<input type="hidden" name="jp_item_type" value="cart"/>
		<input type="hidden" name="jp_item_name" value="{{ $transaction['item_name'] }}"/>
		<input type="hidden" name="order_id" value="{{ $transaction['order_id'] }}"/>
		<input type="hidden" name="jp_business" value="demo@webtribe.co.ke"/>
		<input type="hidden" name="jp_amount_1" value="{{ $transaction['amount'] }}"/>
		<input type="hidden" name="jp_amount_2" value="0"/>
		<input type="hidden" name="jp_amount_5" value="0"/>
		<input type="hidden" name="jp_payee" value="{{ $email }}"/>
		<input type="hidden" name="jp_shipping" value="Mradi"/>
		<input type="hidden" name="jp_rurl" value="http://mradi.com/template?sid=1&oid={{ $res->id }}&uid=<?=Session::get('account_id')?>"/>
		<input type="hidden" name="jp_furl" value="http://mradi.com/template?sid=2&oid={{ $res->id }}&uid=<?=Session::get('account_id')?>"/>
		<input type="hidden" name="jp_curl" value="http://mradi.com/template?sid=3&oid={{ $res->id }}&uid=<?=Session::get('account_id')?>"/>
		<input type="image" name="jambo" id="jambo" src="https://www.jambopay.com/jp_image/paynow.png"/>
		</form>									
		</div>
		
		
		<div id="myframe" name="myframe" >
			<iframe name="output_frame" src="" id="output_frame" width="80%" height="700px" scrolling="no" frameborder="0"> </iframe
		</div>
				
<?php
    }elseif(Input::get('sid') !== null){ 
		
		$JP_PASSWORD = Input::get('JP_PASSWORD');
		if ((isset($JP_PASSWORD) && strlen($JP_PASSWORD) > 0)) {	//success response from jambopay....			
			$sharedkey = '6127482F-35BC-42FF-A466-276C577E7DF3';
			$JP_MERCHANT_ORDERID = Input::get('JP_MERCHANT_ORDERID');
			$JP_AMOUNT = Input::get('JP_AMOUNT');
			$JP_CURRENCY = Input::get('JP_CURRENCY');
			$JP_TIMESTAMP = Input::get('JP_TIMESTAMP');
			$user_id = e(Input::get('uid'));
			$trx_id = e(Input::get('JP_TRANID'));
			$channel = e(Input::get('JP_CHANNEL'));
			
            $str = $JP_MERCHANT_ORDERID . $JP_AMOUNT . $JP_CURRENCY . $sharedkey . $JP_TIMESTAMP;
			//**************** VERIFY *************************
            if (md5(utf8_encode($str)) === $JP_PASSWORD && $user_id == Session::get('account_id')) {
				$trans_id = e(Input::get('oid'));
				$transaction = Mradiwallettemplate::find($trans_id);
				$transaction->trx_id = $trx_id;
				$transaction->currency = e(Input::get('JP_CURRENCY'));
				$transaction->timestamp = e(Input::get('JP_TIMESTAMP'));
				$transaction->password = e(Input::get('JP_PASSWORD'));
				$transaction->channel = e(Input::get('JP_CHANNEL'));
				$transaction->mradistatustransaction_id = e(Input::get('sid'));
				$transaction->save();
				$cout = '<div style="width: 98%"><div class="alert alert-success alert-dismissable">
                                <i class="fa fa-check"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <b> Successfully purchase Financial Template. Please check your email '.session::get('email_address').' for download link.</b>
                                </div></div>';
                $Details = Helpers::getProfileDetails();           
                Helpers::sendMail(array(
                    "names"     =>$Details[0]->firstname .' '.$Details[0]->lastname,
                    "message"   => 'Click on this link to download your template   www.mradi.com/ref=fin-900.doc',
                    "to"        =>session::get('email_address')
                ), true);
                
                $cid = Mradiwallettemplate::find($trans_id);
			}
		}elseif(Input::get('sid') != '1'){
				$trans_id = e(Input::get('oid'));
				$transaction = Mradiwallettemplate::find($trans_id);
				$transaction->mradistatustransaction_id = e(Input::get('sid'));
				$transaction->save();
				
				$cid = Mradiwallettemplate::find($trans_id);
				
				if(Input::get('sid') == '2'){error_log("cancelling flush");
					$cout = '<div style="width: 98%"><div class="alert alert-danger alert-dismissable">
                                <i class="fa fa-check"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <b> Transaction Failed!! Please check your balance and try again later. </b>
                                </div></div>';
				}elseif(Input::get('sid') == '3'){
					$cout = '<div style="width: 98%"><div class="alert alert-danger alert-dismissable">
                                <i class="fa fa-check"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <b> Transaction Cancelled!! Please try again later. </b>
                                </div></div>';
				}
			}
			echo $cout;
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
	
	
