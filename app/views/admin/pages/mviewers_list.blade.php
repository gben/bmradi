@extends('admin.layouts.default')
@section('content')


<section class="content-header">
    <h1>
        Viewers List

    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">My Campaign Viewers</li>
        <br />


    </ol>
</section>


<!-- Main content -->
<section class="content">
    <?php            
		$result = Campaign::getMultipleViews();
                 
	if(!empty($result)){
		echo Helpers::generateGrid(
            array("title" => "My Campaign Viewers",
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

