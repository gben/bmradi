@extends('admin.layouts.default')

@section('content')



<section class="content-header">

    <h1>

        Campaign Profile 

    </h1>

    <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Campaigns</li>

        <li class="active">View Campaigns</li>

    </ol>

</section>

<!-- Main content -->

<section class="content">

    {{ Form::open(array('url'=>URL::to('campaigns_grid_list'),'files'=>true, 'name'=>'companydetails')) }}

    <div style="margin-left: 0 !important;">

        <?php

        $rs = DB::select("SELECT ID,TITLE FROM mradi_categories WHERE INTRASH='NO'");

        $categories['0'] = 'Select Category under which the business falls';

        $categories['All'] = 'View All';

        foreach ($rs as $cats) {

            $categories[$cats->ID] = $cats->TITLE;

        }

        ?>

        {{ Form::select('categories_list',@$categories,Input::get('categories_list'),array("style"=>"width:40% !important; margin-left: 0px;","class"=>"form-control")) }} 

        

    </div>

    {{ Form::close() }}

    {{Helpers::generateCampaignGridList([], $my_Status)}}

    

</section><!-- /.content -->

@stop
