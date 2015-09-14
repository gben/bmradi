<?php

class WalletController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//get all investor credits		
		// load the view and pass the all transactions
		if(strtolower(Session::get('account_type')) == 'admin'){
			$transactions = DB::select(DB::raw('select mws.* from mradiwallettransactions mws
							inner join 
							(select max(id) as tid, user_id from mradiwallettransactions group by user_id order by tid desc) drv 
							on mws.id = drv.tid'));
			$pageNumber = Input::get('page', 1);
			$perpage = 15;
			
			$slice = array_slice($transactions, $perpage * ($pageNumber - 1), $perpage);
			$transactions = Paginator::make($slice, count($transactions), $perpage);			
			
			$myBalance = Helpers::investorBalance(Session::get('account_id'), true);
		}else{
			$transactions = Mradiwallettransaction::where('user_id', Session::get('account_id'))->orderBy('id','desc')->paginate(15);
			$myBalance = Helpers::investorBalance(Session::get('account_id'));
		}
		
		$totalInvestorBid = Helpers::getTotalInvestorBid(Session::get('account_id'));

        return View::make('admin.pages.investor_transactions')
			->with(compact('totalInvestorBid', 'myBalance'))
           ->withObjects($transactions);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//insert new records
		return View::make('admin.pages.investor_credit');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//log to file
		$file = fopen(storage_path()."/logs/trans_logs.txt","a");
		foreach(Input::all() as $k => $val){
			fwrite($file, $k . " --- " . $val . "\n");
		}
		fwrite($file, "\n\n *********************************** \n\n\n");
		fclose($file);
		//end log to file
		
		//process jambopay response
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
            if (md5(utf8_encode($str)) === $JP_PASSWORD && $user_id == Session::get('account_id')) {//Log Transaction in transactionlogs
                //error_log("success");
                $trans_id = e(Input::get('tid'));
                $transaction = Mraditransactionlog::find($trans_id);
				$transaction->trx_id = $trx_id;
				$transaction->currency = e(Input::get('JP_CURRENCY'));
				$transaction->timestamp = e(Input::get('JP_TIMESTAMP'));
				$transaction->password = e(Input::get('JP_PASSWORD'));
				$transaction->channel = $channel;
				$transaction->mradistatustransaction_id = e(Input::get('sid'));
				$transaction->save();
				
				if(e(Input::get('sid')) == '1'){
					//insert transaction into investor wallet and update balance
					$investor_balance = Helpers::investorBalance($user_id);
					
					$transaction = new Mradiwallettransaction;
					$transaction->user_id = e(Input::get('uid'));
					$transaction->order_id = e(Input::get('JP_MERCHANT_ORDERID'));
					$transaction->mraditransactionlog_id = $trans_id;
					$transaction->campaign_id = e(Input::get('JP_ITEM_NAME'));
					$transaction->mraditransactiontype_id = 1;
					$transaction->credit = e(Input::get('JP_AMOUNT'));
					$transaction->balance = $JP_AMOUNT + $investor_balance;
					$transaction->save();
					
					Session::flash('_response', '<div style="width: 98%"><div class="alert alert-success alert-dismissable">
                                <i class="fa fa-check"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <b> Successfully creditted your wallet. </b>
                                </div></div>');
				}elseif(e(Input::get('sid')) == 2){
					Session::flash('_response', '<div style="width: 98%"><div class="alert alert-danger alert-dismissable">
                                <i class="fa fa-check"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <b> Transaction Failed!! Please check your balance and try again later. </b>
                                </div></div>');
				}
                                
                return Redirect::to('wallet');
				
            } else{
				//INVALID TRANSACTION
				$trans_id = e(Input::get('tid'));
                $transaction = Mraditransactionlog::find($trans_id);
				$transaction->trx_id = $trx_id;
				$transaction->currency = e(Input::get('JP_CURRENCY'));
				$transaction->timestamp = e(Input::get('JP_TIMESTAMP'));
				$transaction->password = e(Input::get('JP_PASSWORD'));
				$transaction->channel = $channel;
				$transaction->mradistatustransaction_id = 4;
				$transaction->save();
				
				Session::flash('_response', '<div style="width: 98%"><div class="alert alert-danger alert-dismissable">
                                <i class="fa fa-ban"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <b>Alert!</b> Invalid Transaction! Please check with your admin or try again later. </div></div>');
                return Redirect::to('wallet');
			}
		}elseif(empty($JP_PASSWORD) && $amount = Input::get('amount')){
		
			$rules = array(
				'amount'       => 'required|integer',
			);
			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails()) {
				return Redirect::to('wallet/create')
					->withErrors($validator)
					->withInput(Input::except('password'));
			} else {
				// store
				$order_id = mt_rand(101010, 999999);
				$transaction = new Mraditransactionlog;
				$transaction->amount = Input::get('amount');
				$transaction->order_id = $order_id;
				$transaction->user_id = Session::get('account_id');
				$transaction->item_name = "mradi wallet";
				$transaction->mraditransactiontype_id = 1;
				$transaction->save();

				//get transaction details to process
				$transactions = Mraditransactionlog::find($transaction->id);
				return View::make('admin.pages.jambo_form')
					->withObjects($transactions);
			}
		}
		
		Session::flash('_response', '<div style="width: 98%"><div class="alert alert-danger alert-dismissable">
                                <i class="fa fa-ban"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <b>Alert!</b> System Error! Please confirm amount is greater than 0 or check with your admin and try again later. </div></div>');
        return Redirect::to('wallet');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, $option = false)
	{ 
		if(strtolower(Session::get('account_type')) == 'admin'){
			$transactions = Mradiwallettransaction::where('user_id', $id)->orderBy('id','desc')->paginate(15);
			$myBalance = Helpers::investorBalance($id);
			
			$totalInvestorBid = Helpers::getTotalInvestorBid($id, false, true);
			
			return View::make('admin.pages.investor_transactions_admin')
					->with(compact('totalInvestorBid', 'myBalance'))
				   ->withObjects($transactions);
		}else{
			//get transactions of a single investor
			$transactions = Mraditransactionlog::find($id);
			// show the view and pass the investor transactions to it
			return View::make('admin.pages.jambo_form')
				->withObjects($transactions);
		}
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//run update
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
	
	public function getCancel(){
		//log to file
		$file = fopen(storage_path()."/logs/trans_logs.txt","a");
		foreach(Input::all() as $k => $val){
			fwrite($file, $k . " --- " . $val . "\n");
		}
		fwrite($file, "\n\n *********************************** \n\n\n");
		fclose($file);
		//end log to file
		
		$trans_id = e(Input::get('tid'));
		$status_id = e(Input::get('sid'));
        $transaction = Mraditransactionlog::find($trans_id);
		$transaction->mradistatustransaction_id = $status_id;
		$transaction->save();
		
		if($status_id == 2){
			Session::flash('_response', '<div style="width: 98%"><div class="alert alert-danger alert-dismissable">
                             <i class="fa fa-ban"></i>
                             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                             <b>Alert!</b> Transaction Failed!! Please confirm your balance and try again later. </div></div>');
		}elseif($status_id == 3){
			Session::flash('_response', '<div style="width: 98%"><div class="alert alert-danger alert-dismissable">
                             <i class="fa fa-ban"></i>
                             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                             <b>Alert!</b> Transaction Cancelled!! </div></div>');
		}else{
			Session::flash('_response', '<div style="width: 98%"><div class="alert alert-danger alert-dismissable">
                             <i class="fa fa-ban"></i>
                             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                             <b>Alert!</b> Unknown Transaction!! </div></div>');
		}
		
        return Redirect::to('wallet');
	}


}
