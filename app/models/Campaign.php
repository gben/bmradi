<?php

class Campaign {

    public static function get_campaign_by_account_id($account_id) {
        return DB::select('select * from campaign_dbx where account_id = ?', array($account_id));
    }

    public static function get_campaign_by_campaign_id($campaign_id) {
        return DB::select('select * from campaign_dbx where campaign_id = ?', array($campaign_id));
    }

    public static function get_campaigns($category = "", $mystatus=false) {
       
        if($category != "guest" && strtoupper(Session::get('account_type')) == 'ENTREPRENEUR')
        {
            $searchParams = array();
            $searchParams[]=Session::get('account_id');
             if(!($category=='0'||$category==''||$category=='All')){
                $cat = "AND categories = ? ";
                $searchParams[] = $category;
            }
            else{
                $cat = '';
                //$catVal = '';
            }
            $xCondition = '';
            if($mystatus && strlen($mystatus) > 0){
				if($mystatus == "ongoing"){
					$xCondition = " AND tc.campaignstatus = ? AND tc.approvalstatus = ?";
					$searchParams[] = $mystatus;
					$searchParams[] = "Approved";
				}else{
					$xCondition = " AND tc.campaignstatus = ?";
					$searchParams[] = $mystatus;
				}
			}
            
            
            return DB::select("SELECT tc.id, tc.uniqueid,tc.campaigname,ts.listing_logo,ts.`business_summary` FROM tbl_campaigns tc LEFT JOIN tbl_campaign_summary ts ON ts.`campaign_id` = tc.`id`
                WHERE tc.user_id = ? $cat $xCondition order by tc.creationtime desc",$searchParams);
        }
        elseif($category != "guest" && strtoupper(Session::get('account_type')) == 'ADMIN')
        {
			$catVal = array();
            if(!($category=='0'||$category==''||$category=='All')){
                $cat = 'AND categories = ?';
                $catVal[] = $category;
            }
            else{
                $cat = '';
            }
            
            $xCondition = '';
            if($mystatus && strlen($mystatus) > 0){
				if($mystatus == "ongoing"){
					$xCondition = " AND tc.campaignstatus = ? AND tc.approvalstatus = ?";
					$catVal[] = $mystatus;
					$catVal[] = "Approved";
				}elseif($mystatus == "success" || $mystatus == "fail"){
					$xCondition = " AND tc.campaignstatus = ? AND tc.approvalstatus = ? AND tc.closingstatus = ?";
					$catVal[] = "Closed";
					$catVal[] = "Approved";
					$catVal[] = $mystatus;
				}else{
					$xCondition = " AND tc.campaignstatus = ?";
					$catVal[] = $mystatus;
				}
			}
            
            return DB::select("SELECT tc.id, tc.uniqueid,tc.campaigname,ts.listing_logo,ts.`business_summary` FROM tbl_campaigns tc LEFT JOIN tbl_campaign_summary ts ON ts.`campaign_id` = tc.`id`
                    WHERE LOWER(campaignstatus) <> 'draft'  $cat $xCondition order by tc.creationtime desc",$catVal);
            
        }
        elseif($category != "guest" && strtoupper(Session::get('account_type')) == 'INVESTOR')
        {
			$catVal = array();
            if(!($category=='0'||$category==''||$category=='All')){
                $cat = 'AND categories = ?';
                $catVal[] = $category;
            }
            else{
                $cat = '';
            }
            
            $xCondition = '';
            if($mystatus && strlen($mystatus) > 0){
				if($mystatus == "ongoing"){
					$xCondition = " AND tc.campaignstatus = ? AND tc.approvalstatus = ?";
					$catVal[] = $mystatus;
					$catVal[] = "Approved";
				}else{
					$xCondition = " AND tc.campaignstatus = ?";
					$catVal[] = $mystatus;
				}
			}
            
            return DB::select("SELECT tc.id, tc.uniqueid,tc.campaigname,ts.listing_logo,ts.`business_summary` FROM tbl_campaigns tc LEFT JOIN tbl_campaign_summary ts ON ts.`campaign_id` = tc.`id`
                    WHERE Approvalstatus = 'Approved' AND LOWER(campaignstatus)='ongoing' $cat $xCondition order by tc.creationtime desc",$catVal);
        }
        else{
			$transactions = DB::select(DB::raw("SELECT tc.id, tc.uniqueid,tc.campaigname,ts.listing_logo,ts.`business_summary` FROM tbl_campaigns tc LEFT JOIN tbl_campaign_summary ts ON ts.`campaign_id` = tc.`id`
                    WHERE Approvalstatus = 'Approved' order by tc.creationtime desc"));
			$pageNumber = Input::get('page', 1);
			$perpage = 3;
			
			$slice = array_slice($transactions, $perpage * ($pageNumber - 1), $perpage);
			$transactions = Paginator::make($slice, count($transactions), $perpage);
			return $transactions;
			/*return DB::select("SELECT tc.id, tc.uniqueid,tc.campaigname,ts.listing_logo,ts.`business_summary` FROM tbl_campaigns tc LEFT JOIN tbl_campaign_summary ts ON ts.`campaign_id` = tc.`id`
                    WHERE Approvalstatus = 'Approved' order by tc.creationtime desc LIMIT 3"); */
		}
    }

    public static function get_recent_campaigns($count = 10) {
        return DB::select('select * from campaign_dbx order by date_created desc limit ?', array($count));
    }

    public static function save_new_campaign() {
        
    }
    /*
     * Register campaign viewed details
     */
    public static function viewedCampaign($campaignID)
    {
        /*
         * Check if a previous entry exists
         */
        $views = DB::select('select view_id from mradi_campaignviews where user_id = ? and campaign_id = ? and date = ?',array(Session::get('account_id'),$campaignID, date("Y-m-d")));
        if(empty($views))
        {
            //Insert into the database
            DB::table('mradi_campaignviews')
                    ->insert(array(
                        'user_id'   =>Session::get('account_id'),
                        'campaign_id'=>$campaignID,
                        'date' => date("Y-m-d")
                    ));
        }else
        {
            //Update and increment number of views
            DB::table('mradi_campaignviews')
                    ->where('view_id',$views[0]->view_id)
                    ->increment('no_of_views',1,array(
                        'time_viewed'=>DB::raw('CURRENT_TIMESTAMP')
                    ));
        }
    }
    public static function getTotalViews($campaignID = false, $user = false)
    {
		$conditions = array();
		if($user && !empty($user)){
			$conditions['field'] = 'user_id';
			$conditions['value'] = $user;			
		}
		if($campaignID && !empty($campaignID)){
			$conditions['field'] = 'campaign_id';
			$conditions['value'] = $campaignID;
		}//var_dump($conditions);
		
		$views = DB::table('mradi_campaignviews');
		
		foreach ($conditions as $condition) {
			$views = $views->where($conditions['field'], '=', $conditions['value']);
		}
		
		$views = $views->sum('no_of_views');
		
        //Getcount of views
        /*$views = DB::table('mradi_campaignviews')
                ->where('campaign_id',$campaignID)
                ->sum('no_of_views');*/
        return $views;
    }
    
    public static function getMyViews($str = false, $is_admin = false){
		$condition = "";
		if($is_admin){
			if(!empty($str)){
				$date = date('Y-m-d');
				$result = DB::table('tbl_campaigns')
					->select('mradi_campaignviews.user_id', 'tbl_campaigns.uniqueid', 'tbl_campaigns.campaigname', 'tbl_campaigns.campaignstatus', 'tbl_campaign_summary.business_summary', 'mradi_campaignviews.no_of_views')
					->leftJoin('tbl_campaign_summary', 'tbl_campaigns.id', '=', 'tbl_campaign_summary.id')
					->leftJoin('mradi_campaignviews', 'tbl_campaigns.uniqueid', '=', 'mradi_campaignviews.campaign_id')
					->where('tbl_campaigns.campaignstatus','=','Ongoing')
					->whereRaw('mradi_campaignviews.date =\''.$date.'%\'')
					->get();
			}else{
				$result = DB::table('tbl_campaigns')
					->select('mradi_campaignviews.user_id', 'tbl_campaigns.uniqueid', 'tbl_campaigns.campaigname', 'tbl_campaigns.campaignstatus', 'tbl_campaign_summary.business_summary', 'mradi_campaignviews.no_of_views')
					->leftJoin('tbl_campaign_summary', 'tbl_campaigns.id', '=', 'tbl_campaign_summary.id')
					->leftJoin('mradi_campaignviews', 'tbl_campaigns.uniqueid', '=', 'mradi_campaignviews.campaign_id')
					->where('tbl_campaigns.campaignstatus','=','Ongoing')
					->get();
			}
		}else{
			if(strtolower(Session::get('account_type')) == 'investor'){
				$uCondition = "mradi_campaignviews.user_id =".Session::get('account_id')."";
			}elseif(strtolower(Session::get('account_type')) == 'entrepreneur'){
				$uCondition = "tbl_campaigns.user_id = ".Session::get('account_id')."";
			}
			if(!empty($str)){
				$date = date('Y-m-d');
				$result = DB::table('tbl_campaigns')
					->select('mradi_campaignviews.user_id', 'tbl_campaigns.uniqueid', 'tbl_campaigns.campaigname', 'tbl_campaigns.campaignstatus', 'tbl_campaign_summary.business_summary', 'mradi_campaignviews.no_of_views')
					->leftJoin('tbl_campaign_summary', 'tbl_campaigns.id', '=', 'tbl_campaign_summary.id')
					->leftJoin('mradi_campaignviews', 'tbl_campaigns.uniqueid', '=', 'mradi_campaignviews.campaign_id')
					->whereRaw($uCondition)
					->where('tbl_campaigns.campaignstatus','=','Ongoing')
					->whereRaw('mradi_campaignviews.date =\''.$date.'%\'')
					->get();
			}else{
				$result = DB::table('tbl_campaigns')
					->select('mradi_campaignviews.user_id', 'tbl_campaigns.uniqueid', 'tbl_campaigns.campaigname', 'tbl_campaigns.campaignstatus', 'tbl_campaign_summary.business_summary', 'mradi_campaignviews.no_of_views')
					->leftJoin('tbl_campaign_summary', 'tbl_campaigns.id', '=', 'tbl_campaign_summary.id')
					->leftJoin('mradi_campaignviews', 'tbl_campaigns.uniqueid', '=', 'mradi_campaignviews.campaign_id')
					->whereRaw($uCondition)
					->where('tbl_campaigns.campaignstatus','=','Ongoing')
					->get();
			}
		}
		
		return $result;
	}
	
	public static function getRecentlyViewedCampaigns(){
		$result = DB::table('tbl_campaigns')
			->select(DB::raw('tbl_campaigns.uniqueid, tbl_campaigns.campaigname, tbl_campaigns.campaignstatus, sum(mradi_campaignviews.no_of_views) as totalviews, mradi_campaignviews.time_viewed'))
			->leftJoin('mradi_campaignviews', 'tbl_campaigns.uniqueid', '=', 'mradi_campaignviews.campaign_id')
			->orderby('mradi_campaignviews.time_viewed', 'desc')
			->groupBy('tbl_campaigns.uniqueid', 'mradi_campaignviews.view_id')
			->having('totalviews', '>=', 1)
			->take(3)
			->get();
			
		return $result;
	}
	
	public static function getMultipleViews($str = false){
		$condition = "";
		$result = DB::table('tbl_campaigns')
				->select(DB::raw('tbl_campaigns.uniqueid, concat(accounts_dbx.firstname, " ", accounts_dbx.lastname) as fullName, tbl_campaigns.campaigname, tbl_campaigns.campaignstatus, sum(mradi_campaignviews.no_of_views)  as viewCount,  mradi_campaignviews.time_viewed'))
				->leftJoin('tbl_campaign_summary', 'tbl_campaigns.id', '=', 'tbl_campaign_summary.id')
				->leftJoin('mradi_campaignviews', 'tbl_campaigns.uniqueid', '=', 'mradi_campaignviews.campaign_id')
				->leftJoin('accounts_dbx', 'mradi_campaignviews.user_id', '=', 'accounts_dbx.account_id')
				->orderby('mradi_campaignviews.time_viewed', 'desc')
				->where('tbl_campaigns.user_id', '=', Session::get('account_id'))
				->where('tbl_campaigns.campaignstatus','=','Ongoing')
				->groupBy('mradi_campaignviews.user_id')
				->having('viewCount', '>', '1')
				->get();
		
		return $result;
	}
	

}
