@extends('admin.layouts.default')

@section('content')





<section class="content-header">

    <h1> Latest Feeds  </h1>

    <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Feeds</li>

    </ol>

</section>

 <?php							
	$query = DB::table("tbl_campaigns");
	$query->leftJoin("tbl_campaign_summary", "tbl_campaign_summary.campaign_id", "=", "tbl_campaigns.id")
	->leftJoin("accounts_dbx", "accounts_dbx.account_id", "=", "tbl_campaigns.user_id");
								
	$result = $query
	->orderby('creationtime', 'desc')
	->skip(Session::get('rec_per_page') * (Input::get('page') - 1))
	->take(Session::get('rec_per_page'))
	->get();												
?>

<!-- Main content -->
<section class="content">
	<div class="row" style="padding:0px 20px;">
        <div class="col-xs-10" style=" min-height:50px;">
			<div class="col-xs-2">  </div>
			<div class="col-xs-2"> <b> Created By </b> </div>
			<div class="col-xs-2"> Campaign Name </div>
			<div class="col-xs-1"> Country </div>
			<div class="col-xs-1"> Location </div>
			<div class="col-xs-1"> Campaign Status </div> 
			<div class="col-xs-2"> Time Created </div>
		</div>
	</div>

	<?php $i=1; foreach($result as $item){  ?>
    <!-- Feeds BEGIN -->
    <div class="row" style="padding:0px 20px;">
        <div class="col-xs-10">
            <div class="box box-solid">
                <div class="box-body"> 
                    <div class="row" style="padding-left:10px;">
						
						<?php
							if(strtolower($item->account_type) != "admin"){
								$profileDetails = Helpers::getProfileDetails($item->account_id);
								if(!empty($profileDetails)){
									$file = Helpers::getUploadedFileDetails($profileDetails[0]->profile_pic);
								}
								$file_name = '';
								if(empty($file))
									{ $file_name = 'no-image.png'; }
								else
									{ $file_name = $file[0]->file_alias; }
							}else{
								$file_name = "ll.jpg";
							}
							?>
						<div class="col-xs-2"> {{ HTML::image('assets/'.$file_name, $item->firstname,array("class"=>"img-circle", "width"=>"75px","height"=>"50px")) }} </div>
						<div class="col-xs-2"> {{ $item->firstname . " " . $item->lastname }} </div>
						<div class="col-xs-2"> {{ $item->campaigname }} </div>
						<div class="col-xs-1"> {{ $item->country }} </div>
						<div class="col-xs-1"> {{ $item->location }} </div>
						<div class="col-xs-1"> {{ $item->campaignstatus }} </div> 
						<div class="col-xs-2"> {{ $item->creationtime }} </div>

                    </div><!-- /.row --> 
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col (MAIN) -->
    </div>
    <!-- feed END -->
    <?php } ?>

</section><!-- /.content -->

@stop



