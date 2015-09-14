@extends('admin.layouts.default')

@section('content')



<section class="content-header">

    <h1>

        Activity Logs

    </h1>

    <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Reports</li>

        <li class="active">Activity Reports</li>

    </ol>

</section>



<!-- Main content -->

<section class="content">

    <?php

    $query = DB::table("mradi_audit_trail_log");

    

    /*

     * Data Filters

     */

    $filter_array = '';

    if (Session::get('FilterArray') != '')

        $filter_array = Session::get('FilterArray');

    if (Input::get("datefrom")!='' || !empty($filter_array['datefrom'])) {

        #Clear or assign

        $filter_array['datefrom'] = (Input::get("datefrom") == '' && Input::get("_token") != '' ? '' :

                        (Input::get("datefrom") != '' ? Input::get("datefrom") : $filter_array['datefrom']));

        if ($filter_array['datefrom'] != '')

            $query->where('date_created', '>=', (Input::get("datefrom") != '' ? Input::get("datefrom") : $filter_array['datefrom']).' 00:00:00');

    }

    if (Input::get("dateto")!='' || !empty($filter_array['dateto'])) {

        #Clear or assign

        $filter_array['dateto'] = (Input::get("dateto") == '' && Input::get("_token") != '' ? '' :

                        (Input::get("dateto") != '' ? Input::get("dateto") : $filter_array['dateto']));

        if ($filter_array['dateto'] != '')

            $query->where('date_created', '<=', (Input::get("dateto") != '' ? Input::get("dateto") : $filter_array['dateto']).' 23:59:59');

    }

    Session::put('FilterArray', $filter_array); 

    

    

    if (Input::get("table_search") != '') {

        $searchColumns = array("user", 'action', 'date_created');

        $query->Where(function($query)use($searchColumns){

            foreach ($searchColumns as $item) {

                $query->orWhere(

                        $item, 'LIKE', "%" . Input::get("table_search") . "%");

            }

        });

    }

    

    $total_pages = count($query->get());

    $result = $query

            ->skip(Session::get('rec_per_page') * (Input::get('page') - 1))

            ->take(Session::get('rec_per_page'))

            ->select(array('audit_id AS primarykey', "user as Actioned_by", "action as activity", 'date_created as Activity_time'))

            ->orderBy('date_created', 'desc')

            ->get();

    

    echo Helpers::generateGrid(

            array("title" => "Viewing Detailed Activity Report",

                "print" => false,

                "view" => "roles",

                "search" => false,

                "checkbox" => false,

                "col_number" => false,

                "total_pages" => $total_pages,

                "actions" => "",

                "filters" => array("date"),

                "isReport" => false,

                "data" => $result));

    ?>

</section><!-- /.content -->

@stop