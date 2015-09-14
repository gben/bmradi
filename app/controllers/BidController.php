<?php

class BidController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//get all bids		
		// load the view and pass the all transactions
		if(strtolower(Session::get('account_type')) == 'admin'){	
			$transactions = DB::select(DB::raw('select mcb.*, drv.*, tbl_campaigns.campaignstatus from mradicampaignbids mcb inner join
							(SELECT campaign_id as cid, count(id) as count, max(total_bidded) as totalBid, max(updated_at) as last_bid
							from mradicampaignbids group by campaign_id order by id desc) drv
							on mcb.campaign_id = drv.cid
							inner join tbl_campaigns on mcb.campaign_id = tbl_campaigns.uniqueid
							group by mcb.campaign_id'));
			$pageNumber = Input::get('page', 1);
			$perpage = 15;
			
			$slice = array_slice($transactions, $perpage * ($pageNumber - 1), $perpage);
			$transactions = Paginator::make($slice, count($transactions), $perpage);
		}elseif(strtolower(Session::get('account_type')) == 'entrepreneur'){
			$con = "where ".strtolower(Session::get('account_type'))."_id = " . Session::get('account_id');
			$transactions = DB::select(DB::raw('select mcb.*, drv.*, tbl_campaigns.campaignstatus from mradicampaignbids mcb 
							inner join
							(SELECT campaign_id as cid, count(id) as count, max(total_bidded) as totalBid, max(updated_at) as last_bid
							from mradicampaignbids '.$con.' group by campaign_id order by id desc) drv
							on mcb.campaign_id = drv.cid
							inner join tbl_campaigns on mcb.campaign_id = tbl_campaigns.uniqueid
							group by mcb.campaign_id'));
			$pageNumber = Input::get('page', 1);
			$perpage = 15;
			
			$slice = array_slice($transactions, $perpage * ($pageNumber - 1), $perpage);
			$transactions = Paginator::make($slice, count($transactions), $perpage);
		}else{
			//$transactions = Mradicampaignbid::where(strtolower(Session::get('account_type')).'_id', Session::get('account_id'))->orderBy('id','desc')->paginate(15);
			$con = "where ".strtolower(Session::get('account_type'))."_id = " . Session::get('account_id');
			$transactions = DB::select(DB::raw('select mcb.*, drv.*, tbl_campaigns.campaignstatus from mradicampaignbids mcb 
							inner join
							(SELECT campaign_id as cid, count(id) as count, max(total_bidded) as totalBid, max(updated_at) as last_bid
							from mradicampaignbids '.$con.' group by campaign_id order by id desc) drv
							on mcb.campaign_id = drv.cid
							inner join tbl_campaigns on mcb.campaign_id = tbl_campaigns.uniqueid
							
							group by mcb.campaign_id'));
			$pageNumber = Input::get('page', 1);
			$perpage = 15;
			
			$slice = array_slice($transactions, $perpage * ($pageNumber - 1), $perpage);
			$transactions = Paginator::make($slice, count($transactions), $perpage);
		}
		
		$totalInvestorBid = Helpers::getTotalInvestorBid(Session::get('account_id'));
		
		$totalOnlineBid = Helpers::getTotalInvestorBid(Session::get('account_id'), true);
		
		$myBalance = Helpers::investorBalance(Session::get('account_id'));
		
        return View::make('admin.pages.campaign_bids')
			->with(compact('totalInvestorBid', 'myBalance', 'totalOnlineBid'))
           ->withObjects($transactions);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//save bid
		//log to file
		$file = fopen(storage_path()."/logs/trans_bids.txt","a");
		foreach(Input::all() as $k => $val){
			fwrite($file, $k . " --- " . $val . "\n");
		}
		fwrite($file, "\n\n *********************************** \n\n\n");
		fclose($file);
		//end log to file
		
		$rules = array(
			'bid_amt'       => 'required|numeric|min:1',
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::back()
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// get params n process bid
			$user_id = Session::get('account_id');
			$min_amt = e(Input::get('min_investment'));
			$max_amt = e(Input::get('max_investment')); 
			$total_bidded = e(Input::get('total_bidded'));
			$bid_balance = e(Input::get('amt_remaining')); 
			$bid_amt = e(Input::get('bid_amt'));
			$investor_balance = e(Input::get('investor_balance'));
			$campaign_id = Helpers::getCampaignID(e(Input::get('campaign_id')));
			$campaign_name = strtoupper(Helpers::getCampaignID(e(Input::get('campaign_id')),true));
			$order_id = mt_rand(1010101, 9010901);
			
			if($investor_balance < $bid_amt ){
				Session::flash('_response', '<div style="width: 98%"><div class="alert alert-danger alert-dismissable">
                                <i class="fa fa-check"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <b> Bidding Failed!! You do no have sufficient balance in your wallet. </b>
                                </div></div>');				
			}elseif(($bid_amt < $min_amt) || ($bid_amt > $max_amt) ){
				Session::flash('_response', '<div style="width: 98%"><div class="alert alert-danger alert-dismissable">
                                <i class="fa fa-check"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <b> Bidding Failed!! You must bid within the limits provided '.$min_amt.' <= Your Bid <= '.$max_amt.' </b>
                                </div></div>');				
			}elseif($bid_amt > $bid_balance){
				Session::flash('_response', '<div style="width: 98%"><div class="alert alert-danger alert-dismissable">
                                <i class="fa fa-check"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <b> Bidding Failed!! Your bid is beyond maximum limit, you can only bid a max of $bid_balance. </b>
                                </div></div>');				
			}else{
				//process bid
				$details = Helpers::getCampaignID(e(Input::get('campaign_id')),'',true);
				$entrepreneur_id = $details->user_id;
				$bidTrans = new Mradicampaignbid;
				$bidTrans->investor_id = Session::get('account_id');
				$bidTrans->entrepreneur_id = $entrepreneur_id;
				$bidTrans->campaign_id = e(Input::get('campaign_id'));
				$bidTrans->order_id = $order_id;
				$bidTrans->mraditransactiontype_id = 2;
				$bidTrans->amount = $bid_amt;
				$bidTrans->total_bidded = ($total_bidded + $bid_amt);
				$bidTrans->save();

				//debit investor
				$investor_balance = Helpers::investorBalance($user_id);
				$mybid = new Mradiwallettransaction;
				$mybid->user_id = Session::get('account_id');
				$mybid->order_id = $order_id;
				$mybid->mradicampaignbid_id = $bidTrans->id;
				$mybid->campaign_id = $campaign_id;
				$mybid->mraditransactiontype_id = 2;
				$mybid->debit = $bid_amt;
				$mybid->balance = $investor_balance - $bid_amt;
				$mybid->save();
				
				//credit entrepreneur
				$entrepreneur_balance = Helpers::investorBalance($entrepreneur_id, false, $campaign_id);
				$mybid = new Mradiwallettransaction;
				$mybid->user_id = $entrepreneur_id;
				$mybid->order_id = $order_id;
				$mybid->mradicampaignbid_id = $bidTrans->id;
				$mybid->campaign_id = $campaign_id;
				$mybid->mraditransactiontype_id = 2;
				$mybid->credit = $bid_amt;
				$mybid->balance = $entrepreneur_balance + $bid_amt;
				$mybid->save();
				
				Session::flash('_response', '<div style="width: 98%"><div class="alert alert-success alert-dismissable">
                                <i class="fa fa-check"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <b> Transaction Successful!! Your have successfully bidded <i>'.$campaign_name.'</i> with <i>KShs. '.number_format($bid_amt, 2).'</i> <br /> New A/c Balance <i>KShs. '.number_format(($investor_balance - $bid_amt),2).'</i> </b>
                                </div></div>');	
			}
			return Redirect::to('bid/'.Input::get('campaign_id'));
		}
        return Redirect::back();
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($campaign_id)
	{	
		$transactions = Mradicampaignbid::where('campaign_id', $campaign_id)
							->orderBy('id','desc')
							->paginate(15);
		
		//total amount bidded
		$myBid = Helpers::getTotalBidded($campaign_id);
		$totalBid = $myBid ? $myBid->total_bidded : '0';
		//campaign value
		$investment = Helpers::getTotalInvestment($campaign_id);
		$campaignValue = $investment ? $investment[0]->total_investment : 0;
		//no of investors
		$investorCount = $transactions->count();
		//online bids
		$totalOnlineBid = Helpers::getTotalInvestorBid(Session::get('account_id'), true);
		
        return View::make('admin.pages.campaign_bid_view')
			->with(compact('campaign_id', 'totalBid', 'campaignValue', 'investorCount', 'totalOnlineBid'))
            ->withObjects($transactions);
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
		//
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
	
	
	public function getList($status = false)
	{
		//get all bids		
		// load the view and pass the all transactions
		$status = e(Input::get('categories_list'));
		if($status == "" || $status == "All" ){
			$condition = "";
		}else{
			$condition = " where tbl_campaigns.campaignstatus = '".$status."'";
		}
		if(strtolower(Session::get('account_type')) == 'admin'){	
			$transactions = DB::select(DB::raw('select mcb.*, drv.*, tbl_campaigns.campaignstatus from mradicampaignbids mcb
							inner join
							(SELECT campaign_id as cid, count(id) as count, max(total_bidded) as totalBid, max(updated_at) as last_bid
							from mradicampaignbids group by campaign_id order by id desc) drv
							on mcb.campaign_id = drv.cid
							inner join tbl_campaigns on mcb.campaign_id = tbl_campaigns.uniqueid
							'.$condition.'
							group by mcb.campaign_id'));
			$pageNumber = Input::get('page', 1);
			$perpage = 15;
			
			$slice = array_slice($transactions, $perpage * ($pageNumber - 1), $perpage);
			$transactions = Paginator::make($slice, count($transactions), $perpage);
		}elseif(strtolower(Session::get('account_type')) == 'entrepreneur'){
			$con = "where ".strtolower(Session::get('account_type'))."_id = " . Session::get('account_id');
			$transactions = DB::select(DB::raw('select mcb.*, drv.*, tbl_campaigns.campaignstatus from mradicampaignbids mcb 
							inner join
							(SELECT campaign_id as cid, count(id) as count, max(total_bidded) as totalBid, max(updated_at) as last_bid
							from mradicampaignbids '.$con.' group by campaign_id order by id desc) drv
							on mcb.campaign_id = drv.cid
							inner join tbl_campaigns on mcb.campaign_id = tbl_campaigns.uniqueid
							'.$condition.'
							group by mcb.campaign_id'));
			$pageNumber = Input::get('page', 1);
			$perpage = 15;
			
			$slice = array_slice($transactions, $perpage * ($pageNumber - 1), $perpage);
			$transactions = Paginator::make($slice, count($transactions), $perpage);
		}else{
			//$transactions = Mradicampaignbid::where(strtolower(Session::get('account_type')).'_id', Session::get('account_id'))->orderBy('id','desc')->paginate(15);
			$con = "where ".strtolower(Session::get('account_type'))."_id = " . Session::get('account_id');
			$transactions = DB::select(DB::raw('select mcb.*, drv.*, tbl_campaigns.campaignstatus from mradicampaignbids mcb 
							inner join
							(SELECT campaign_id as cid, count(id) as count, max(total_bidded) as totalBid, max(updated_at) as last_bid
							from mradicampaignbids '.$con.' group by campaign_id order by id desc) drv
							on mcb.campaign_id = drv.cid
							inner join tbl_campaigns on mcb.campaign_id = tbl_campaigns.uniqueid
							'.$condition.'
							group by mcb.campaign_id'));
			$pageNumber = Input::get('page', 1);
			$perpage = 15;
			
			$slice = array_slice($transactions, $perpage * ($pageNumber - 1), $perpage);
			$transactions = Paginator::make($slice, count($transactions), $perpage);
		}
		
		$totalInvestorBid = Helpers::getTotalInvestorBid(Session::get('account_id'));
		
		$totalOnlineBid = Helpers::getTotalInvestorBid(Session::get('account_id'), true);
		
		$myBalance = Helpers::investorBalance(Session::get('account_id'));
		
        return View::make('admin.pages.campaign_bids')
			->with(compact('totalInvestorBid', 'myBalance', 'totalOnlineBid'))
           ->withObjects($transactions);
	}


}
