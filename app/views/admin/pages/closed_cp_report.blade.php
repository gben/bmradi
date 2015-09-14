@extends('admin.layouts.default')

@section('content')

        <section class="content-header">

<h1>

    Closed Campaigns

    

</h1>

<ol class="breadcrumb">

    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

	<li class="active">Reports</li>

    <li class="active">Closed Campaigns</li>

</ol>

</section>



<!-- Main content -->

<section class="content">

<?php

$query = DB::table("tbl_campaigns");

    $query->leftJoin("tbl_campaign_summary", function($join) {

                        $join->on("tbl_campaign_summary.campaign_id", "=", "tbl_campaigns.id");

                    })

            ->leftJoin("accounts_dbx", function($join) {

                        $join->on("accounts_dbx.account_id", "=", "tbl_campaigns.user_id");

                    })

            ->where('campaignstatus', '=', 'closed');

                    

    if (Input::get("table_search") != '') {

        $searchColumns = array("campaigname", "creationtime", "lastupdatetime",

            "campaignstatus", "approvalstatus");

        $query->Where(function($query)use($searchColumns) {

                    foreach ($searchColumns as $item) {

                        $query->orWhere(

                                $item, 'LIKE', "%" . Input::get("table_search") . "%");

                    }

                });

    }



    /*

     * Data Filters

     */

    $filter_array = '';

    if (Session::get('FilterArray') != '')

        $filter_array = Session::get('FilterArray');

    if (Input::get("datefrom")!='' || !empty($filter_array['datefrom'])) {

        #Clear or assign

        $filter_array['datefrom'] = (Input::get("datefrom") == '' && Input::get("_token") != '' ? '' :

                        ( Input::get("datefrom") != '' ? Input::get("datefrom") : $filter_array['datefrom']));

        if ($filter_array[

                'datefrom'] != '')

            $query->where('creationtime', '>=', (Input::get("datefrom") != '' ? Input::get("datefrom") : $filter_array['datefrom']) . ' 00:00:00');

    }

    if (Input::get("dateto")!='' || !empty($filter_array['dateto'])) {

        #Clear or assign

        $filter_array['dateto'] = (Input::get("dateto") == '' && Input::get("_token") != '' ? '' :

                        ( Input::get("dateto") != '' ? Input::get("dateto") : $filter_array['dateto']));

        if (

                $filter_array['dateto'] != '')

            $query->where('creationtime', '<=', (Input::get("dateto") != '' ? Input::get("dateto") : $filter_array['dateto']) . ' 23:59:59');

    } Session::put('FilterArray', $filter_array);



    $total_pages = count(strtoupper(Session::get("account_type")) != 'ADMIN' ?

                    $query->where("user_id", '=', Session::get("account_id"))->get() : $query->get());

    if (strtoupper(Session::get("account_type")) != 'ADMIN')

        $query->where("user_id", '=', Session::get("account_id"));

    

    $result = $query

            ->skip(Session::get('rec_per_page') * (Input::get('page') - 1))

            ->take(Session::get('rec_per_page'))

            ->select(array('tbl_campaigns.id AS primarykey', "campaigname as Campaign_name", "business_name", "email_address", "creationtime as Creation_time_*", "lastupdatetime as Last_update_time",

                "campaignstatus as Campaign_status", "approvalstatus as approval_status"))

            ->get();        

        echo Helpers::generateGrid(

            array("title"=>"Viewing All Detailed Close Campaigns Report",

                "print"=>false,

                "search"=>false,

                "view"=>"report",

                "checkbox"=>false,

                "col_number"=>false,

                "total_pages"=>$total_pages,

                "actions"=>"",

                "filters"=>array("date"),

                "isReport"=>false,

                "data"=>$result));

    ?>

</section><!-- /.content -->

@stop