@extends('admin.layouts.default')
@section('content')


<section class="content-header">
    <h1>
        Campaigns List

    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">My Campaigns</li>
        <br />


    </ol>
</section>
@if(strtoupper(Session::get('account_type')) == 'ENTREPRENEUR')
<div style="padding-top: 10px; padding-left: 20px;">
    {{ Session::get('_response') }}
    <div id="new_campaign" style="width:50%">
        
        <div class="box box-solid bg-yellow">
            <div class="box-header">
                <h2 class="box-title" style="font-size: 30px !important">Create New Campaign</h2>
            </div>
            <div class="box-body">
                @if ($errors->has()||Session::get('unique')!='') <div class="callout callout-danger"><p> {{$errors->first('campaign_name')}} {{Session::get('unique')}} </p></div> @endif
                {{ Form::open(array('url'=>'save/newCampaign','name'=>'create_campaign')) }}
                <div class="input-group input-group-sm  @if ($errors->has('campaign_name')) has-error @endif">
                    {{ Form::text('campaign_name',Input::old('campaign_name'),
                    array('class'=>'form-control','placeholder'=>'Enter campaign name...','length'=>'50')) }}
                    <span class="input-group-btn">
                        {{ Form::submit('Go',array('class'=>'btn btn-info btn-flat')) }}
                    </span>
                </div>
                {{ Form::close() }}
            </div><!-- /.box-body -->
        </div>

    </div>

</div>
@endif
<!-- Main content -->
<section class="content">
    <?php
    $query = DB::table("tbl_campaigns");

    if (Input::get("table_search") != '') {
        //$query->where("email_address",'LIKE',"%". Input::get("table_search") ."%");
        $searchColumns = array("campaigname as Campaign_name", "creationtime as Creation_time", "lastupdatetime as Last_update_time",
            "campaignstatus as Campaign_status", "approvalstatus as approval_status");
        foreach ($searchColumns as $item) {
            $query->orWhere($item, 'LIKE', "%" . Input::get("table_search") . "%");
        }
    }
    $total_pages = count(strtoupper(Session::get("account_type")) != 'ADMIN'?
            $query->where("user_id", '=', Session::get("account_id"))->orderby('creationtime', 'desc')->get():'');
    if (strtoupper(Session::get("account_type")) == 'ADMIN') {
        $result = $query
                ->skip(Session::get('rec_per_page') * (Input::get('page') - 1))
                ->take(Session::get('rec_per_page'))
                ->whereRaw("campaignstatus in('Ongoing', 'Closed') and approvalstatus = 'Approved'")
                ->select(array('id AS primarykey', "campaigname as Campaign_name", "creationtime as Creation_time", "lastupdatetime as Last_update_time",
                    "campaignstatus as Campaign_status", "approvalstatus as approval_status", "closingstatus as closing_status"))
                ->orderby('creationtime', 'desc')
                ->get();
    } else {
        $result = $query
                ->skip(Session::get('rec_per_page') * (Input::get('page') - 1))
                ->take(Session::get('rec_per_page'))
                ->where("user_id", '=', Session::get("account_id"))
                ->select(array('id AS primarykey', "campaigname as Campaign_name", "creationtime as Creation_time", "lastupdatetime as Last_update_time",
                    "campaignstatus as Campaign_status", "approvalstatus as approval_status", "closingstatus as closing_status"))
                ->orderby('creationtime', 'desc')
                ->get();
    }

    echo Helpers::generateGrid(
            array("title" => "Viewing Listing of My Campaigns",
                "print" => false,
                "view" => "campaigns",
                "search" => false,
                "checkbox" => false,
                "col_number" => false,
                "total_pages" => $total_pages,
                "actions" => "",
                "filters" => array("date"),
                "isReport" => (Session::get('account_type') == 'ADMIN' ? false : false),
                "data" => $result));
    ?>
</section><!-- /.content -->
@stop

