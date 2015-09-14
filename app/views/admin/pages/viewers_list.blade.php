@extends('admin.layouts.default')
@section('content')


<section class="content-header">
    <h1>
        Viewers List

    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">My Campaign Viewers</li>
        <br />


    </ol>
</section>


<!-- Main content -->
<section class="content">
    <?php      error_log($entre_id);      
		if(empty($entre_id) || strtolower(Session::get('account_type')) == 'admin'){
			$result = DB::table('tbl_campaigns')
				->select(DB::raw('mradi_campaignviews.user_id, upper(concat(accounts_dbx.firstname, " ", accounts_dbx.lastname)) as Viewer, upper(tbl_campaigns.campaigname) as "Campaign Name", tbl_campaigns.campaignstatus, sum(mradi_campaignviews.no_of_views)  as viewCount, mradi_campaignviews.date'))
				->leftJoin('tbl_campaign_summary', 'tbl_campaigns.id', '=', 'tbl_campaign_summary.id')
				->leftJoin('mradi_campaignviews', 'tbl_campaigns.uniqueid', '=', 'mradi_campaignviews.campaign_id')
				->leftJoin('accounts_dbx', 'mradi_campaignviews.user_id', '=', 'accounts_dbx.account_id')
				->where('tbl_campaigns.campaignstatus', '=', 'Ongoing')
				->orderby('mradi_campaignviews.time_viewed', 'desc')
				->groupBy('mradi_campaignviews.user_id', 'mradi_campaignviews.date')
				->skip(Session::get('rec_per_page') * (Input::get('page') - 1))
				->take(Session::get('rec_per_page'))
				->get();
		}else{
			if(strtolower(Session::get('account_type')) == 'investor'){
				$uCondition = "mradi_campaignviews.user_id =".$entre_id."";
			}elseif(strtolower(Session::get('account_type')) == 'entrepreneur'){
				$uCondition = "tbl_campaigns.user_id = ".$entre_id."";
			}
			$result = DB::table('tbl_campaigns')
				->select(DB::raw('mradi_campaignviews.user_id, upper(concat(accounts_dbx.firstname, " ", accounts_dbx.lastname)) as Viewer, upper(tbl_campaigns.campaigname) as "Campaign Name", tbl_campaigns.campaignstatus,  sum(mradi_campaignviews.no_of_views)  as viewCount, mradi_campaignviews.date'))
				->leftJoin('tbl_campaign_summary', 'tbl_campaigns.id', '=', 'tbl_campaign_summary.id')
				->leftJoin('mradi_campaignviews', 'tbl_campaigns.uniqueid', '=', 'mradi_campaignviews.campaign_id')
				->leftJoin('accounts_dbx', 'mradi_campaignviews.user_id', '=', 'accounts_dbx.account_id')
				->whereRaw($uCondition)
				->where('tbl_campaigns.campaignstatus', '=', 'Ongoing')
				->orderby('mradi_campaignviews.time_viewed', 'desc')
				->groupBy('mradi_campaignviews.user_id', 'mradi_campaignviews.date')
				->skip(Session::get('rec_per_page') * (Input::get('page') - 1))
				->take(Session::get('rec_per_page'))
				->get();
		}
                 
	if(!empty($result)){
		echo Helpers::generateGrid(
            array("title" => "My Campaign Viewers",
                "print" => false,
                "view" => "",
                "search" => false,
                "checkbox" => false,
                "col_number" => false,
                "total_pages" => 30,
                "actions" => "",
                "filters" => array(),
                "isReport" => (Session::get('account_type') == 'ADMIN' ? false : false),
                "data" => $result));
     }else{
		echo "<h4> No records to show </h4>"; 
	 }
    ?>
</section><!-- /.content -->
@stop

