@extends('admin.layouts.default')

@section('content')

<section class="content-header">

    <h1>

        Subscriptions



    </h1>

    <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Subscriptions</li>

    </ol>

</section>

<!-- Main content -->

<section class="content">

    <?php

    $query = DB::table("subscribers");

    if (Input::get("table_search") != '') {

        $searchColumns = array('email_address', 'date_subscribed', 'status');

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

        if ($filter_array['datefrom'] != '')

            $query->where('date_subscribed', '>=', (Input::get("datefrom") != '' ? Input::get("datefrom") : $filter_array['datefrom']) . ' 00:00:00');

    }

    if (Input::get("dateto")!='' || !empty($filter_array['dateto'])) {

        #Clear or assign

        $filter_array['dateto'] = (Input::get("dateto") == '' && Input::get("_token") != '' ? '' :

                        ( Input::get("dateto") != '' ? Input::get("dateto") : $filter_array['dateto']));

        if ($filter_array['dateto'] != '')

            $query->where('date_subscribed', '<=', (Input::get("dateto") != '' ? Input::get("dateto") : $filter_array['dateto']) . ' 23:59:59');

    }

    if (Input::get("active_status")!='' || !empty($filter_array['active_status'])) {

        #Clear or assign

        $filter_array['active_status'] = (Input::get("active_status") == '' && Input::get("_token") != '' ? '' :

                        ( Input::get("active_status") != '' ? Input::get("active_status") : $filter_array['active_status']));

        if ($filter_array['active_status'] != '')

            $query->where('status', '=', (Input::get("active_status") != '' ? Input::get("active_status") : $filter_array['active_status']));

    }

    Session::put('FilterArray', $filter_array);

   



    $total_pages = count($query->get());

    $result = $query->skip(Session::get('rec_per_page') * (Input::get('page') - 1))

            ->take(Session::get('rec_per_page'))

            ->select(array('subscriber_id as primarykey', "email_address", 'date_subscribed as date_subscribed_*'

                , 'status as subscription_status'))

            ->get();



    echo Helpers::generateGrid(

            array("title" => "Viewing Listing of Newsletter subscriptions",

                "print" => false,

                "view" => "newsletter",

                "search" => false,

                "checkbox" => false,

                "col_number" => false,

                "total_pages" => $total_pages,

                "actions" => "",

                "filters" => array("ACTIVE_STATUS","date"),

                "isReport" => false,

                "data" => $result));

    ?>

</section><!-- /.content -->

@stop