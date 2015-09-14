@extends('admin.layouts.default')
@section('content')


<section class="content-header">
    <h1>
        Campaign Views List

    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Campaign Views</li>
        <br />


    </ol>
</section>


<!-- Main content -->
<section class="content">
    <?php            
		if($campaign_id == null){
			$result = DB::table("mradi_campaignviews")
			 ->select(DB::raw('tbl_campaigns.uniqueid, upper(tbl_campaigns.campaigname) as "Campaign Name", tbl_campaigns.campaignstatus, 
	 accounts_dbx.account_type,  sum(mradi_campaignviews.no_of_views) as Views, mradi_campaignviews.time_viewed'))
			 ->leftjoin('tbl_campaigns', 'tbl_campaigns.uniqueid','=','mradi_campaignviews.campaign_id')
			 ->leftjoin('accounts_dbx', 'accounts_dbx.account_id', '=', 'mradi_campaignviews.user_id')
			 ->orderby('mradi_campaignviews.time_viewed', 'desc')
			 ->groupby('mradi_campaignviews.user_id', 'mradi_campaignviews.date')
			 ->having('Views', '>=', '1')
			 ->skip(Session::get('rec_per_page') * (Input::get('page') - 1))
			 ->take(Session::get('rec_per_page'))
			 ->get();
		}else{
			$result = DB::table("mradi_campaignviews")
			 ->select(DB::raw('tbl_campaigns.uniqueid, upper(tbl_campaigns.campaigname) as "Campaign Name", tbl_campaigns.campaignstatus, 
	 accounts_dbx.account_type,  sum(mradi_campaignviews.no_of_views) as Views, mradi_campaignviews.time_viewed'))
			 ->leftjoin('tbl_campaigns', 'tbl_campaigns.uniqueid','=','mradi_campaignviews.campaign_id')
			 ->leftjoin('accounts_dbx', 'accounts_dbx.account_id', '=', 'mradi_campaignviews.user_id')
			 ->where('mradi_campaignviews.campaign_id', '=', $campaign_id)
			 ->orderby('mradi_campaignviews.time_viewed', 'desc')
			 ->groupby('mradi_campaignviews.user_id', 'mradi_campaignviews.date')
			 ->having('Views', '>=', '1')
			 ->skip(Session::get('rec_per_page') * (Input::get('page') - 1))
			 ->take(Session::get('rec_per_page'))
			 ->get();
		}
		
                 
	if(!empty($result)){
		echo Helpers::generateGrid(
            array("title" => "Campaign Views",
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
		echo "<h4> No records to show. </h4>";
	}
    ?>
</section><!-- /.content -->
@stop

