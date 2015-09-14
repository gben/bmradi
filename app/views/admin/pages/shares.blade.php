@extends('admin.layouts.default')
@section('content')
    
	
	        <section class="content-header">
<h1>
    Shares
    
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Finance</li>
    <li class="active">Shares</li>
</ol>
</section>

<!-- Main content -->
<section class="content">
<?php
$query = DB::table("tbl_campaign_summary");
$query->join("tbl_campaigns","campaign_id","=","campaign_id");

       // $query->where("account_type",'=','ENTREPRENEUR');
        if(Input::get("table_search")!='')
        {
            //$query->where("email_address",'LIKE',"%". Input::get("table_search") ."%");
            $searchColumns = array("firstname",'lastname','country','phone','email_address','date_created'
                    ,'account_status','gender');
            foreach($searchColumns as $item)
            {
                $query->orWhere($item,'LIKE',"%". Input::get("table_search") ."%");
            }
        }        
        
        $total_pages = count($query->get()); //DB::table("accounts_dbx").
        $result = $query
                ->skip(Session::get('rec_per_page')*(Input::get('page')-1))
                ->take(Session::get('rec_per_page'))
                ->select(array('campaign_id AS primarykey',"Business_name",'Business_summary','campaignstatus as campaign_status','creationtime as creation_time'))
                ->get();
        
        echo Helpers::generateGrid(
            array("title"=>"Viewing Shares Allocation Report",
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