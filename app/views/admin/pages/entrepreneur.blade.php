@extends('admin.layouts.default')
@section('content')
            <section class="content-header">
<h1>
    Entrepreneurs
    
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Entrepreneurs</li>
</ol>
</section>

<!-- Main content -->
<section class="content">
<?php
        $query = DB::table("accounts_dbx");
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
        
        $total_pages = count($query->where("account_type",'=','ENTREPRENEUR')->get()); //DB::table("accounts_dbx").
        $result = $query
                ->skip(Session::get('rec_per_page')*(Input::get('page')-1))
                ->take(Session::get('rec_per_page'))
                ->where("account_type",'=','ENTREPRENEUR')
                ->select(array('account_id AS primarykey',"firstname as first_name",'lastname as last_name','country','phone','email_address','date_created'
                    ,'account_status as status','gender'))
                ->get();
        
        echo Helpers::generateGrid(
            array("title"=>"Viewing Listing of Entrepreneur",
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