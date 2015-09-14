@extends('admin.layouts.default')
@section('content')
    
	
	        <section class="content-header">
<h1>
    User Roles    
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">User Roles</li>
</ol>
</section>
<!-- Main content -->
<section class="content">
    <?=Session::get('_feedback')?>
<?php
    
        $query = DB::table("role");
       // $query->where("account_type",'=','ENTREPRENEUR');
        if(Input::get("table_search")!='')
        {
            //$query->where("email_address",'LIKE',"%". Input::get("table_search") ."%");
            $searchColumns = array("title");
            foreach($searchColumns as $item)
            {
                $query->orWhere($item,'LIKE',"%". Input::get("table_search") ."%");
            }
        }
        $total_pages = count($query->where("intrash",'=','NO')->get());
        $result = $query
                ->skip(Session::get('rec_per_page')*(Input::get('page')-1))
                ->take(Session::get('rec_per_page'))
                ->where("intrash",'=','NO')
                ->select(array('id AS primarykey',"ID","title as Role_name"))
                ->get();
        echo Helpers::generateGrid(
            array("title"=>"Viewing Listing of Roles",
                "print"=>false,
                "view"=>"roles",
                "search"=>false,
                "checkbox"=>false,
                "col_number"=>false,
                "total_pages"=>$total_pages,
                "actions"=>"",
                "filters"=>array(""),
                "isReport"=>true,
                "data"=>$result));
    ?>
</section><!-- /.content -->
@stop
	
	