@extends('admin.layouts.default')

@section('content')

	        <section class="content-header">

<h1>

    Investors

    

</h1>

<ol class="breadcrumb">

    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

	<li class="active">Account Administration</li>

    <li class="active">Investors</li>

</ol>

</section>



<!-- Main content -->

<section class="content">

    <?php

    

        $query = DB::table("accounts_dbx");

        $query->leftJoin("countries_dbx", function($join) {

                        $join->on("countries_dbx.code", "=", "accounts_dbx.country");

                    });

        if(Input::get("table_search")!='')

        {

            //$query->where("email_address",'LIKE',"%". Input::get("table_search") ."%");

            $searchColumns = array("firstname",'lastname','countries_dbx.id','phone','email_address','date_created'

                    ,'account_status','gender');

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

    if (Input::get("datefrom")!='' || isset($filter_array['datefrom'])) {

        #Clear or assign

        $filter_array['datefrom'] = (Input::get("datefrom") == '' && Input::get("_token") != '' ? '' :

                        ( Input::get("datefrom") != '' ? Input::get("datefrom") : $filter_array['datefrom']));

        if ($filter_array['datefrom'] != '')

            $query->where('date_created', '>=', (Input::get("datefrom") != '' ? Input::get("datefrom") : $filter_array['datefrom']) . ' 00:00:00');

    }

    if (Input::get("dateto")!='' || isset($filter_array['dateto'])) {

        #Clear or assign

        $filter_array['dateto'] = (Input::get("dateto") == '' && Input::get("_token") != '' ? '' :

                        ( Input::get("dateto") != '' ? Input::get("dateto") : $filter_array['dateto']));

        if ($filter_array['dateto'] != '')

            $query->where('date_created', '<=', (Input::get("dateto") != '' ? Input::get("dateto") : $filter_array['dateto']) . ' 23:59:59');

    }

    if (Input::get("active_status")!='' || isset($filter_array['active_status'])) {

        #Clear or assign

        $filter_array['active_status'] = (Input::get("active_status") == '' && Input::get("_token") != '' ? '' :

                        ( Input::get("active_status") != '' ? Input::get("active_status") : $filter_array['active_status']));

        if ($filter_array['active_status'] != '')

            $query->where('account_status', '=', (Input::get("active_status") != '' ? Input::get("active_status") : $filter_array['active_status']));

    }

    Session::put('FilterArray', $filter_array);

        

        $total_pages = count($query->where("account_type",'=','INVESTOR')->get());

        $result = $query

                ->skip(Session::get('rec_per_page')*(Input::get('page')-1))

                ->take(Session::get('rec_per_page'))

                ->where("account_type",'=','INVESTOR')

                ->select(array('account_id AS primarykey',"firstname as first_name",'lastname as last_name','countries_dbx.id','phone','email_address','date_created'

                    ,'account_status as status','gender'))

                ->get();

        echo Helpers::generateGrid(

            array("title"=>"Viewing Listing of investors",

                "print"=>false,

                "view"=>"investor",

                "search"=>false,

                "checkbox"=>false,

                "col_number"=>false,

                "total_pages"=>$total_pages,

                "actions"=>"",

                "filters"=>array("investors","date",),

                "isReport"=>true,

                "data"=>$result));

    ?>

</section><!-- /.content -->

@stop

	

	