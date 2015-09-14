@extends('admin.layouts.default')
@section('content')
            <section class="content-header">
<h1>
    Entrepreneurs
    
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Accounts Administration</li>
    <li class="active">Entrepreneurs</li>
</ol>
</section>

<!-- Main content -->
<section class="content">
<?php
        $result = DB::select("SELECT account_id AS primarykey, firstname, lastname,country,phone,email_address,date_created,account_status,gender FROM accounts_dbx WHERE account_type='ENTREPRENEUR'");
        echo Helpers::generateGrid(
            array("title"=>"Viewing Listing of Entrepreneur",
                "print"=>false,
                "search"=>false,
                "view"=>"ENTREPRENEUR",
                "checkbox"=>false,
                "col_number"=>false,
                "pagination"=>"",
                "actions"=>"",
                "filters"=>array("date"),
                "isReport"=>true,
                "data"=>$result));
    ?>

</section><!-- /.content -->
@stop