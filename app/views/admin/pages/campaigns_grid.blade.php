@extends('admin.layouts.default')
@section('content')

    {{'';if(strtoupper(Session::get('account_type'))!='ENTREPRENEUR')
        Campaign::viewedCampaign($campaign);}}



<section class="content-header">
    <h1>
        Campaign Profile 
    </h1>

    <ol class="breadcrumb">  

        <li>{{HTML::link(URL::route('dashboard'),'Home')}}</li>
        <li class="">{{HTML::link(URL::route('campaigns_grid_list'),'Campaigns List')}}</li>
        <li class="active">Campaign Info</li>
    </ol>
</section>
{{ Session::get('_response') }}
<div style="float:right; margin:5px 15px"></div>
{{'';$cam_action = Helpers::getCampaignAppAction(Helpers::getCampaignID($campaign))}}
@if(strtoupper(Session::get('account_type')) == 'ADMIN' && strpos($cam_action,'button') !== false)
<div id="new_campaign" style="width:50%;margin:5px 15px 0 15px">
    {{ Session::get('err') }}         
</div>
@endif
<!-- Main content -->
<section class="content">

<!--@if ($errors->has()) <div class="callout callout-danger"><p> Oops! Please correct the fields highlighted</p></div> @endif-->
    <div class="row">
        <div class="col-md-6" style="width:100% !important">
            <?php
            $campaignSummary = Helper::getCampaignSummary($campaign);

            if (((empty($campaignSummary) || count($campaignSummary) == 0 ) || Input::old()) && Session::get('activetab') == 'tab_1') { // if((count($campaignSummary[0])<=0 && Input::old()))
                $campaignSummary[0] = new stdClass();
                $campaignSummary[0]->listing_logo = Input::old('listing_logo');
                $campaignSummary[0]->business_name = Input::old('business_name');
                $campaignSummary[0]->business_summary = Input::old('business_summary');
                $campaignSummary[0]->min_investment = Input::old('min_investment');
                $campaignSummary[0]->percent_equity = Input::old('min_inv_percent');
                $campaignSummary[0]->pre_money_valuation = Input::old('money_valuation');
                $campaignSummary[0]->max_investment = Input::old('max_investment');
                $campaignSummary[0]->max_percent_equity = Input::old('max_inv_percent');
                $campaignSummary[0]->money_use = Input::old('money_util');
                $campaignSummary[0]->categories = Input::old('categories');
                $campaignSummary[0]->facebook = Input::old('facebook_address');
                $campaignSummary[0]->twitter = Input::old('twitter_address');
                $campaignSummary[0]->linkedin = Input::old('linkedin_address');
                $campaignSummary[0]->website = Input::old('website_address');
            }
            $campaign_category = Helper::get_all_categories($campaignSummary[0]->categories[0]);
            ?>

            <div style="background-color: #5CB85C; height:300px; width:auto;border-radius: 10px;">
                <div style="height:80px;padding: 20px ">{{HTML::link(URL::route('campaigns_grid_list'),"Back to Campaigns..",array("class"=>"btn btn-warning btn-sm btn-flat pull-right"))}}</div>
                <div style="background-color: #fff;">
                    <div style="float: left; width:250px; margin-top: -40px; margin-left: 20px; border-radius: 10px; height:220px; background-color: #fff;">

                        <!--                        <div style="text-align:  center; border-top-left-radius: 10px !important; border-top-right-radius: 10px;padding: 1px; border-width: 3px;" class="containerImg">-->
                        {{''; $file = Helpers::getUploadedFileDetails($campaignSummary[0]->listing_logo);
                        $file_name = '';
                        if(empty($file))
                        $file_name = 'no-image.png';
                        else
                        $file_name = $file[0]->file_alias;
                        }}

                        {{HTML::image('assets/'.$file_name, $campaignSummary[0]->business_name.' logo',array("width"=>"250px","height"=>"200px","style"=>"border-radius: 10px;"))}}

                        <!--                    </div>-->

                    </div>

                    <div style="height:220px;  background-color: #fff; padding-top: 5px; margin-left: 300px">
						<?php
							if(strtolower(Helpers::getCampaignStatus($campaign)->campaignstatus) == 'ongoing' || strtolower(Helpers::getCampaignStatus($campaign)->campaignstatus) == 'closed'){
						?>
                        <section class="content-header"> <h1>{{Helpers::getCampaignID($campaign,true)}}</h1> </section>
                        <h4>{{Campaign::getTotalViews($campaign)}} Views</h4>
                        <span style="width:40% !important;">
									<?php
										 //total amount bidded
										$myBid = Helpers::getTotalBidded($campaign);
										$totalBid = $myBid ? $myBid->total_bidded : '0';
										//campaign value
										$investment = Helpers::getTotalInvestment($campaign);
										$campaignValue = $investment ? $investment[0]->total_investment : 0;

										//$percentage_share_completion = ($item->share_bought * 100) / $item->no_of_shares;
										$percentage_share_completion = ($totalBid * 100) / $campaignValue;
									?>
                            <div class="progress" style="width: 40%; text-align: center; ">

                                <div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percentage_share_completion; ?>%;">
                                    <span class="sr-only" style="position: relative !important;"><?php echo $percentage_share_completion; ?>% Complete</span>
                                </div>
                            </div>
                        </span>
                        <br />
                   <?php }else{ echo "<br /><br /><br /><br />"; } ?>
                        
                        <div class="col-md-6">
							<div class="col-md-8">
								<?php 
                                                                       $cpStatus = strtoupper(Helpers::getCampaignStatus($campaign)->campaignstatus);
									if((strtolower(Session::get('account_type')) == 'admin' || strtolower(Session::get('account_type')) == 'entrepreneur')  && (strtolower(Helpers::getCampaignStatus($campaign)->campaignstatus) == 'ongoing' || strtolower(Helpers::getCampaignStatus($campaign)->campaignstatus) == 'closed')){
										
										echo '<button type="button" id="bid" name="bid" class ="btn btn-sm btn-flat" style="width: 200px; margin-right:70px; font-size:large;">
										' . HTML::link('bid/'.$campaign,'View Bids ('.$cpStatus.')') . ' </button>';
									}
								
									if(strtoupper(Session::get('account_type')) == 'INVESTOR'){
										$bidded = Helpers::getBidded(Session::get('account_id'), $campaign);
										if($bidded){
											echo '<a><button type="button" id="bid" name="bid" class ="btn btn-sm btn-flat" style="width: 200px; margin-right:70px; font-size:large;">
											' . HTML::link('bid/'.$campaign,'View Bids ('.$cpStatus.')') . ' </button></a>';
										}else{							
											echo '<a><button type="button" id="bid" name="bid" class ="btn btn-warning btn-sm btn-flat" style="width: 60px; margin-right:100px; font-size:large;">
											' . HTML::linkRoute('campaign.bid','Bid',$campaign, ['data-toggle'=>'modal','data-target'=>'#myModal']) . ' </button></a>';
										}
									}else{								
										echo $cam_action;
									}
								?>
										
							</div>
														
							<div class="col-md-4 grid">
								
								<?php
									$res = CampaignController::getLikes($campaign); 
								?>
								<div class="col-md-6">
									<input type="button" value="<?php echo $res->likes; ?>" class="button_like" id="linkeBtn" />
								</div>
								
							</div>
						</div>
                         
                    </div>

                </div>
            </div>
            <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />            

            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li><a href="#tab_1" data-toggle="tab">Campaign Summary</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Company Details</a></li>
                    <li><a href="#tab_3" data-toggle="tab">Market Description</a></li>
                    <li><a href="#tab_4" data-toggle="tab">Proposal</a></li>
                    <li><a href="#tab_5" data-toggle="tab">Team</a></li>
                    <li><a href="#tab_6" data-toggle="tab">Summary Statement</a></li>
                    <li><a href="#tab_7" data-toggle="tab">Financials</a></li>
                    <li><a href="#tab_8" data-toggle="tab">Business Plan</a></li>
                    <li><a href="#tab_9" data-toggle="tab">Video</a></li>

                    <!--<li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>-->
                </ul>

                <div class="tab-content">

                    <div class="tab-pane active" id="tab_1">

                        <div class="col-md-6" style="width:100% !important;">

                            <div class="box box-solid" >
                                <div class="box-header">

                                    <h3 class="box-title" style="color: rgb(45, 195, 45) !important; ">Summary </h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <dl class="dl-horizontal">
                                        <dt>Business Name:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{$campaignSummary[0]->business_name}} </dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt>Business Summary:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{$campaignSummary[0]->business_summary}} </dd>
                                    </dl>
                                </div><!-- /.box-body -->

                                <div class="box-header">

                                    <!--                                <h3 class="box-title" style="color: rgb(45, 195, 45) !important; ">Basic Details </h3>-->
                                </div><!-- /.box-header -->

                            </div><!-- /.box -->
                        </div>
                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />
                        <br />
                        <div class="col-md-6" style="width:100% !important;">
                            <div class="box box-solid">
                                <div class="box-header">
                                    <h3 class="box-title"  style="color: rgb(45, 195, 45) !important;">Investment Summary </h3>
                                </div><!-- /.box-header -->
                                <div class="box-body row">

                                    <div class="col-xs-8"> 
                                        <dl class="dl-horizontal">
                                            <dt style="text-align: left; white-space:normal; ">Investment Information:</dt>
                                            <dd style="color:rgb(49, 29, 142)" ><table class="table table-striped">
                                                    <tbody> 
                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">Minimum Investment Sought:</td>
                                                            <td style="color:rgb(49, 29, 142)" >{{$campaignSummary[0]->min_investment}}</td>
                                                        </tr>
                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">Minimum percentage of equity:</td>
                                                            <td style="color:rgb(49, 29, 142)" >{{$campaignSummary[0]->percent_equity}} </td>
                                                        </tr>
                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">Pre-Money Valuation:</td>
                                                            <td style="color:rgb(49, 29, 142)" >{{$campaignSummary[0]->pre_money_valuation}}</td>
                                                        </tr>
                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">Maximum Investment Sought:</td>
                                                            <td style="color:rgb(49, 29, 142)" >{{$campaignSummary[0]->max_investment}}</td>
                                                        </tr>
                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">Maximum percentage of equity:</td>
                                                            <td style="color:rgb(49, 29, 142)" >{{$campaignSummary[0]->max_percent_equity}}</td>
                                                        </tr>

                                                    </tbody>

                                                </table></dd>
                                        </dl>

                                        <dl class="dl-horizontal">
                                            <dt style="text-align: left; white-space:normal; ">How the money will be used:</dt>
                                            <dd style="color:rgb(49, 29, 142)" >{{$campaignSummary[0]->money_use}}</dd>
                                        </dl> 
                                    </div>
                                    <br />



                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />
                        <br />

                        <div class="col-md-6" style="width:100% !important;">
                            <div class="box box-solid">
                                <div class="box-header">

                                    <h3 class="box-title" style="color: rgb(45, 195, 45) !important;">Business Sector </h3>
                                </div><!-- /.box-header -->
                                <div class="box-body row">
                                    <div class="col-xs-8"> 
                                        <dl class="dl-horizontal">
                                            <dt style="text-align: left; white-space:normal; ">Business Category:</dt>
                                            <dd style="color:rgb(49, 29, 142)" >{{$campaign_category[0]->title}}</dd>
                                        </dl>

                                        <dl class="dl-horizontal">
                                            <dt style="text-align: left; white-space:normal; ">Web presence:</dt>
                                            <dd>
                                                <table class="table table-striped">
                                                    <tbody> 

                                                        <tr>
                                                    <a class="btn btn-block btn-social btn-vk" {{($campaignSummary[0]->website!=''?'href="'.$campaignSummary[0]->website.'" target="_blank"':'')}} > 
                                                        <i class="fa fa-vk"></i> &nbsp;{{$campaignSummary[0]->website}}
                                                    </a>
                                                    </tr>
                                                    <tr>
                                                    <a class="btn btn-block btn-social btn-facebook" {{($campaignSummary[0]->facebook!=''?'href="'.$campaignSummary[0]->facebook.'" target="_blank"':'')}}> 
                                                        <i class="fa fa-facebook"></i>&nbsp; {{$campaignSummary[0]->facebook}}
                                                    </a>
                                                    </tr>
                                                    <tr>
                                                    <a class="btn btn-block btn-social btn-twitter" {{($campaignSummary[0]->twitter!=''?'href="'.$campaignSummary[0]->twitter.'" target="_blank"':'')}}> 
                                                        <i class="fa fa-twitter"></i> &nbsp;{{$campaignSummary[0]->twitter}}
                                                    </a>
                                                    </tr>
                                                    <tr>
                                                    <a class="btn btn-block btn-social btn-linkedin" {{($campaignSummary[0]->linkedin!=''?'href="'.$campaignSummary[0]->linkedin.'" target="_blank"':'')}}> 
                                                        <i class="fa fa-linkedin"></i>&nbsp; {{$campaignSummary[0]->linkedin}}
                                                    </a>
                                                    </tr>

                                                    </tbody>

                                                </table>
                                            </dd>


                                        </dl>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />

                    </div> <!--end of tab_1 -->



                    <div class="tab-pane" id="tab_2">
                        <?php
                        $companyDetails = Helper::getCampaignDetails($campaign);

                        if (empty($companyDetails) || ( Input::old() && Session::get('activetab') == 'tab_2')) {
                            $companyDetails[0] = new stdClass();
                            $companyDetails[0]->country_name = Input::old('country_of_ops');
                            //$companyDetails[0]->country_of_ops = Input::old('country_of_ops'); 
                            $companyDetails[0]->incorporation_no = Input::old('incorporation_no');
                            $companyDetails[0]->incorporation_date = Input::old('incorporation_date');
                            $companyDetails[0]->postal_address = Input::old('postal_address');
                            $companyDetails[0]->physical_address = Input::old('physical_address');
                            $companyDetails[0]->nominal_capital = Input::old('nominal_capital');
                            $companyDetails[0]->share_value = Input::old('share_value');
                            $companyDetails[0]->allocated_shares = Input::old('allocated_shares');
                            $companyDetails[0]->unallocated_shares = Input::old('unallocated_shares');
                            $companyDetails[0]->total_no_shares = Input::old('total_no_shares');
                            $companyDetails[0]->director_loans = Input::old('director_loans');
                            $companyDetails[0]->no_directors = Input::old('no_directors');
                            $companyDetails[0]->no_shareholders = Input::old('no_shareholders');
                            $companyDetails[0]->product_description = Input::old('product_description');
                            $companyDetails[0]->product_use = Input::old('product_use');
                            $companyDetails[0]->customer_base = Input::old('customer_base'); //gender
                            $companyDetails[0]->age_group = Input::old('age_group');
                            $companyDetails[0]->location = Input::old('location');
                            $companyDetails[0]->category = Input::old('category'); //profession
                            $companyDetails[0]->customer_xtics = Input::old('customer_xtics');
                            $companyDetails[0]->other_info = Input::old('other_info');
                            $companyDetails[0]->revenue = Input::old('revenue');
                            $companyDetails[0]->sale_size = Input::old('sale_size');
                            $companyDetails[0]->advantages = Input::old('advantages');
                            $companyDetails[0]->challenges = Input::old('challenges');
                            $companyDetails[0]->accomplishments = Input::old('accomplishments');
                        }
                        ?>
                        <div class="col-md-6" style="width:100% !important">
                            <div class="box box-solid">
                                <div class="box-header">

                                    <h3 class="box-title" style="color: rgb(45, 195, 45) !important; ">Company Details </h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Country of Operation:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{$companyDetails[0]->country_name}}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Incorporation No.:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{$companyDetails[0]->incorporation_no}}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Date of Incorporation:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{$companyDetails[0]->incorporation_date}}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Certificate of Incorporation:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >
                                            {{''; $file = Helpers::getUploadedFileDetails($companyDetails[0]->incorporation_cert)}}
                                            @if(!empty($file))
                                            {{HTML::link("/download/" . $file[0]->file_alias," ". $file[0]->file_name,array('class'=>'fa fa-download'))}}
                                            @endif                                           
                                        </dd>
                                    </dl>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                        <br />
                        <div class="col-md-6" style="width:100% !important">
                            <div class="box box-solid">
                                <div class="box-header">
                                    <h3 class="box-title"  style="color: rgb(45, 195, 45) !important;">Address </h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Postal Address:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{$companyDetails[0]->postal_address}}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Physical Address:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{$companyDetails[0]->physical_address}} </dd>
                                    </dl>

                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />
                        <br />

                        <div class="col-md-6" style="width:100% !important">
                            <div class="box box-solid">
                                <div class="box-header">

                                    <h3 class="box-title" style="color: rgb(45, 195, 45) !important;">Share Structure </h3>
                                </div><!-- /.box-header -->



                                <div class="box-body row">
                                    <div class="col-xs-8">
                                        <dl class="dl-horizontal">
                                            <!--<dt style="text-align: left; white-space:normal; ">Nominal Capital:</dt>-->
                                            <dd style="color:rgb(49, 29, 142)" >
                                                <table class="table table-striped">
                                                    <tbody>
                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">Nominal Capital:</td>
                                                            <td style="color:rgb(49, 29, 142)" >{{$companyDetails[0]->nominal_capital}}</td>
                                                        </tr>
                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">Per value of share:</td>
                                                            <td style="color:rgb(49, 29, 142)" >{{ $companyDetails[0]->share_value }}</td>
                                                        </tr>
                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">Allocated shares:</td>
                                                            <td style="color:rgb(49, 29, 142)" >{{ $companyDetails[0]->allocated_shares }}</td>
                                                        </tr>
                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">Unallocated shares:</td>
                                                            <td style="color:rgb(49, 29, 142)" >{{ $companyDetails[0]->unallocated_shares }}</td>
                                                        </tr>
                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">Total number of shares:</td>
                                                            <td style="color:rgb(49, 29, 142)" >{{ $companyDetails[0]->total_no_shares }}</td>
                                                        </tr>
                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">Directors loan:</td>
                                                            <td style="color:rgb(49, 29, 142)" >{{ $companyDetails[0]->director_loans }}</td>
                                                        </tr>                                

                                                    </tbody>
                                                </table>

                                            </dd>
                                        </dl>

                                    </div>
                                </div><!-- /.box-body -->


                            </div><!-- /.box -->
                        </div>
                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />
                        <br />

                        <div class="col-md-6" style="width:100% !important">
                            <div class="box box-solid">
                                <div class="box-header">
                                    <h3 class="box-title"  style="color: rgb(45, 195, 45) !important;">Corporate Governance </h3>
                                </div><!-- /.box-header -->
                                <div class="box-body row">

                                    <div class="col-xs-8">
                                        <dl class="dl-horizontal">
                                            <dt style="text-align: left; white-space:normal; ">Number of Directors:</dt>
                                            <dd style="color:rgb(49, 29, 142)" >
                                                <table class="table table-striped">
                                                    <tbody> 
                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">Number of Directors:</td>
                                                            <td style="color:rgb(49, 29, 142)" >{{ $companyDetails[0]->no_directors }}</td>
                                                        </tr>
                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">Number of Shareholders:</td>
                                                            <td style="color:rgb(49, 29, 142)" >{{ $companyDetails[0]->no_shareholders }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </dd>
                                        </dl>

                                    </div>

                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />
                        <br />

                        <div class="col-md-6" style="width:100% !important">
                            <div class="box box-solid">
                                <div class="box-header">
                                    <h3 class="box-title"  style="color: rgb(45, 195, 45) !important;">Business Description </h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Product/Service provided:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $companyDetails[0]->product_description }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Reason why service/product is needed:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $companyDetails[0]->product_use }} </dd>
                                    </dl>


                                    <div class="row">
                                        <div class="col-xs-8"> 


                                            <dl class="dl-horizontal">
                                                <dt style="text-align: left; white-space:normal; ">Customer Base:</dt>
                                                <dd style="color:rgb(49, 29, 142)" >
                                                    <table class="table table-striped">
                                                        <tbody> 
                                                            <tr class="dl-horizontal"> <td style="color:rgb(49, 29, 142)" >Gender </td> <td> {{ $companyDetails[0]->customer_base }} </td> </tr> 
                                                            <tr class="dl-horizontal"> <td style="color:rgb(49, 29, 142)" >Age group </td> <td> {{ str_replace(';','-',$companyDetails[0]->age_group) }} </td> </tr> 
                                                            <tr class="dl-horizontal"> <td style="color:rgb(49, 29, 142)" >Location </td> <td> {{ $companyDetails[0]->location }} </td> </tr> 
                                                            <tr class="dl-horizontal"> <td style="color:rgb(49, 29, 142)" >Profession </td> <td> {{ $companyDetails[0]->category }} </td> </tr> 
                                                            <tr class="dl-horizontal"> <td style="color:rgb(49, 29, 142)" >Characteristics </td> <td> {{ $companyDetails[0]->customer_xtics }} </td> </tr> 
                                                            <tr class="dl-horizontal"> <td style="color:rgb(49, 29, 142)" >Other </td> <td> {{ $companyDetails[0]->other_info }} </td> </tr>
                                                        </tbody>
                                                    </table>

                                                </dd> 



                                            </dl>

                                        </div>
                                    </div>





                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Ways the business makes money:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $companyDetails[0]->revenue }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Average size of scale:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $companyDetails[0]->sale_size }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">The advantages the business have in this space:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $companyDetails[0]->advantages }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Challenges and how we face them:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $companyDetails[0]->challenges }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Accomplishments:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $companyDetails[0]->accomplishments }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Awards and Certificates:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >
                                            {{''; $award = Helpers::getUploadedFileDetails($companyDetails[0]->awards)}}

											@if(!empty($award))
												@foreach($award as $file)
													@if(!empty($file->file_name))
														{{HTML::link("/download/" . $file->file_alias," ". $file->file_name,array('class'=>'fa fa-download')) . "<br/>"}}
													@endif
												@endforeach
											@endif <br />
                                        </dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Links of Articles:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >
                                            {{''; $article = Helpers::getUploadedFileDetails($companyDetails[0]->article_link)}}

											@if(!empty($article))
												@foreach($article as $file)
													@if(!empty($file->file_name))
														{{HTML::link("/download/" . $file->file_alias," ". $file->file_name,array('class'=>'fa fa-download')) . "<br/>" }}
													@endif
												@endforeach
											@endif

                                        </dd>
                                    </dl>

                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />
                        <br />
                    </div>




                    <div class="tab-pane" id="tab_3">
                        <?php
                        $marketInfo = Helper::getMarketInfo($campaign);

                        if (empty($marketInfo) || ( Input::old() && Session::get('activetab') == 'tab_3')) { // if((count($campaignSummary[0])<=0 && Input::old()))
                            $marketInfo[0] = new stdClass();
                            $marketInfo[0]->target_market = Input::old('target_market');
                            $marketInfo[0]->gender = Input::old('gender_2');
                            $marketInfo[0]->age_group = Input::old('age_group_2');
                            $marketInfo[0]->location = Input::old('location_2');
                            $marketInfo[0]->category = Input::old('category_2');
                            $marketInfo[0]->characteristics = Input::old('characteristics_2');
                            $marketInfo[0]->other = Input::old('other_2');
                            $marketInfo[0]->reach = Input::old('reach');
                            $marketInfo[0]->growth_desc = Input::old('growth_desc');
                            $marketInfo[0]->biz_industry = Input::old('biz_industry');
                            $marketInfo[0]->plyr_in_industry = Input::old('plyr_in_industry');
                            $marketInfo[0]->plyr_ent_last_year = Input::old('plyr_ent_last_year');
                            $marketInfo[0]->growth = Input::old('growth');
                            $marketInfo[0]->new_trends = Input::old('new_trends');
                            $marketInfo[0]->market_share = Input::old('market_share');
                        }
                        ?>
                        <div class="col-md-6" style="width:100% !important">
                            <div class="box box-solid">
                                <div class="box-header">

                                    <h3 class="box-title" style="color: rgb(45, 195, 45) !important; ">Target market description </h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Target market:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $marketInfo[0]->target_market }}</dd>
                                    </dl>

                                    <div class="row">
                                        <div class="col-xs-8"> 


                                            <dl class="dl-horizontal">
                                                <dt style="text-align: left; white-space:normal; ">Description:</dt>

                                                <dd style="color:rgb(49, 29, 142)" >
                                                    <table class="table table-striped">
                                                        <tbody>

                                                            <tr class="dl-horizontal"> <td style="color:rgb(49, 29, 142)" >Gender </td> <td> {{ $marketInfo[0]->gender }} </td> </tr>
                                                            <tr class="dl-horizontal"> <td style="color:rgb(49, 29, 142)" >Age group </td> <td> {{ str_replace(';','-',$marketInfo[0]->age_group) }} </td> </tr>
                                                            <tr class="dl-horizontal"> <td style="color:rgb(49, 29, 142)" >Location </td> <td> {{ $marketInfo[0]->location }} </td> </tr>
                                                            <tr class="dl-horizontal"> <td style="color:rgb(49, 29, 142)" >Profession </td> <td> {{ $marketInfo[0]->category }} </td> </tr>
                                                            <tr class="dl-horizontal"> <td style="color:rgb(49, 29, 142)" >Characteristics </td> <td> {{ $marketInfo[0]->characteristics }} </td> </tr>
                                                            <tr class="dl-horizontal"> <td style="color:rgb(49, 29, 142)" >Other </td> <td> {{ $marketInfo[0]->other }} </td>

                                                        </tbody>
                                                    </table>

                                                </dd> 

                                            </dl>


                                        </div>
                                    </div>



                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Means of reaching the target market:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $marketInfo[0]->reach }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Expansion of the market and how this is achieved:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $marketInfo[0]->growth_desc }}</dd>
                                    </dl>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />
                        <br />
                        <div class="col-md-6" style="width:100% !important">
                            <div class="box box-solid">
                                <div class="box-header">
                                    <h3 class="box-title"  style="color: rgb(45, 195, 45) !important;">Industry Description </h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Industry the business falls under:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $marketInfo[0]->biz_industry }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Number of Players in the industry</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $marketInfo[0]->plyr_in_industry }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Number of Players that have joined in the last year:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $marketInfo[0]->plyr_ent_last_year }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Growth of business in the last 3 years:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $marketInfo[0]->growth }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Charts/Graphs:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >
                                            <a> 
                                                Chart.pdf
                                            </a> <br />
                                            <a> 
                                                Chart B.pdf
                                            </a> <br />
                                            <a> 
                                                Graph.pdf
                                            </a>  <br />
                                            <a> 
                                                Graph B.pdf
                                            </a>
                                        </dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Emerging trends:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $marketInfo[0]->new_trends }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">My market share:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $marketInfo[0]->market_share }}</dd>
                                    </dl>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />

                    </div> <!-- end of tab_3 -->


                    <div class="tab-pane" id="tab_4">
                        <?php
                        $proposal = Helper::getCampaignProposal($campaign);

                        if (empty($proposal) || ( Input::old() && Session::get('activetab') == 'tab_4')) { // if((count($campaignSummary[0])<=0 && Input::old()))
                            $proposal[0] = NEW stdClass();
                            $proposal[0]->no_shares_on_offer = Input::OLD('no_shares_on_offer');
                            $proposal[0]->percent_equity_on_offer = Input::OLD('percent_equity_on_offer');
                            $proposal[0]->share_price = Input::OLD('share_price');
                            $proposal[0]->total_investment = Input::OLD('total_investment');
                            $proposal[0]->min_indie_investment = Input::OLD('min_indie_investment');
                            $proposal[0]->min_indv_shares = Input::OLD('min_indv_shares');
                            $proposal[0]->max_indie_investment = Input::OLD('max_indie_investment');
                            $proposal[0]->max_indv_shares = Input::OLD('max_indv_shares');
                            $proposal[0]->max_no_inv = Input::OLD('max_no_inv');
                            $proposal[0]->min_no_inv = Input::OLD('min_no_inv');
                            $proposal[0]->board_seat = Input::OLD('board_seat');
                            $proposal[0]->board_seat_investment = Input::OLD('board_seat_investment');
                            $proposal[0]->board_no_shares = Input::OLD('board_no_shares');
                            $proposal[0]->dividends_policy = Input::OLD('dividends_policy');
                            $proposal[0]->voting_rights = Input::OLD('voting_rights');
                            $proposal[0]->investor_industry = Input::OLD('investor_industry');
                            $proposal[0]->investor_input = Input::OLD('investor_input');
                            $proposal[0]->funds_use = Input::OLD('funds_use');
                        }
                        ?>

                        <div class="col-md-6" style="width:100% !important">
                            <div class="box box-solid">
                                <div class="box-header">

                                    <h3 class="box-title" style="color: rgb(45, 195, 45) !important; ">Investment description </h3>
                                </div><!-- /.box-header -->
                                <div class="box-body row">
                                    <div class="col-xs-8">  

                                        <dl class="dl-horizontal">
                                            <dt style="text-align: left; white-space:normal; ">Shares</dt>
                                            <dd style="color:rgb(49, 29, 142)" >
                                                <table class="table table-striped">
                                                    <tbody> 
                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">No. of shares on offer</td>
                                                            <td style="color:rgb(49, 29, 142)" >{{ $proposal[0]->no_shares_on_offer }}</td>
                                                        </tr>

                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">% of equity on offer</td>
                                                            <td style="color:rgb(49, 29, 142)" >{{ $proposal[0]->percent_equity_on_offer }}</td>
                                                        </tr>
                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">Price per share</td>
                                                            <td style="color:rgb(49, 29, 142)" >{{ $proposal[0]->share_price }}</td>
                                                        </tr>

                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">Total investment</td>
                                                            <td style="color:rgb(49, 29, 142)" >{{ $proposal[0]->total_investment }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </dd>
                                        </dl>

                                        <hr />



                                        <dl class="dl-horizontal">
                                            <dt style="text-align: left; white-space:normal; ">Investment</dt>
                                            <dd style="color:rgb(49, 29, 142)" >
                                                <table class="table table-striped">
                                                    <tbody> 
                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">Minimum individual investment:</td>
                                                            <td style="color:rgb(49, 29, 142)" >{{ $proposal[0]->min_indie_investment }}</td>
                                                        </tr>
                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">No. of shares:</td>
                                                            <td style="color:rgb(49, 29, 142)" >{{ $proposal[0]->min_indv_shares }}</td>
                                                        </tr>

                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">Maximum individual investment:</td>
                                                            <td style="color:rgb(49, 29, 142)" >{{ $proposal[0]->max_indie_investment }}</td>
                                                        </tr>
                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">No. of shares:</td>
                                                            <td style="color:rgb(49, 29, 142)" >{{ $proposal[0]->max_indv_shares }}</td>
                                                        </tr>
                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">Maximum number of investors:</td>
                                                            <td style="color:rgb(49, 29, 142)" >{{ $proposal[0]->max_no_inv }}</td>
                                                        </tr>
                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">Minimum number of investors:</td>
                                                            <td style="color:rgb(49, 29, 142)" >{{ $proposal[0]->min_no_inv }}</td>
                                                        </tr>

                                                    </tbody>
                                                </table>

                                            </dd>
                                        </dl>

                                        <hr />


                                        <dl class="dl-horizontal">

                                            <dd style="color:rgb(49, 29, 142)" >
                                                <table class="table table-striped">
                                                    <tbody> 
                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">Is there a board seat offering?:</td>
                                                            <td style="color:rgb(49, 29, 142)" >{{ $proposal[0]->board_seat }}</td>
                                                        </tr>
                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">For what size of investment?:</td>
                                                            <td style="color:rgb(49, 29, 142)" >{{ $proposal[0]->board_seat_investment }}</td>
                                                        </tr>
                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">No of shares:</td>
                                                            <td style="color:rgb(49, 29, 142)" >{{ $proposal[0]->board_no_shares }}</td>
                                                        </tr>

                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">Policy on dividends:</td>
                                                            <td style="color:rgb(49, 29, 142)" >{{ $proposal[0]->dividends_policy }}</td>
                                                        </tr>
                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">Voting rights:</td>
                                                            <td style="color:rgb(49, 29, 142)" >{{ $proposal[0]->voting_rights }}</td>
                                                        </tr>

                                                    </tbody>
                                                </table>

                                            </dd>
                                        </dl>


                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />
                        <br />
                        <div class="col-md-6" style="width:100% !important">
                            <div class="box box-solid">
                                <div class="box-header">
                                    <h3 class="box-title"  style="color: rgb(45, 195, 45) !important;">Investor Description </h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Industry from which the Investor will come from:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $proposal[0]->investor_industry }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Input i am looking for from the investor:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $proposal[0]->investor_input }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">How the funds will be used:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $proposal[0]->funds_use }}</dd>
                                    </dl>

                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />

                    </div> <!-- end of tab_4 -->

                    <div class="tab-pane" id="tab_5">
                        <?php
                        $team = Helper::getTeamDetails($campaign);

                        if (empty($team) || ( Input::old() && Session::get('activetab') == 'tab_5')) { // if((count($campaignSummary[0])<=0 && Input::old()))
                            $team[0] = new stdClass();
                            $team[0]->name = Input::old('name');
                            $team[0]->title = Input::old('title');
                            $team[0]->role = Input::old('role');
                            $team[0]->experience = Input::old('experience');
                            $team[0]->qualifications = Input::old('qualifications');
                            $team[0]->description = Input::old('description');
                        }
                        ?>


                        <div class="col-md-6" style="width:100% !important">
                            <div class="box box-solid">
                                <div class="box-header">

                                    <h3 class="box-title" style="color: rgb(45, 195, 45) !important; ">Team Members </h3>
                                </div><!-- /.box-header -->
                                <div class="box-body row">
									
                                    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
									  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
									  
									  <script>
										  $(function() {
											$( "#ttabs" ).tabs();
										  });
									  </script>
									<div id="ttabs">
										<?php 
											$team_list = Helper::getTeamList($campaign);
											$tab_head = "<ul>";
											$tab_body = "";
											$i = 0;
											
											foreach($team_list as $val){
												if($file = Helpers::getUploadedFileDetails($val->picture)){
													$picVal = HTML::image('assets/'.$file[0]->file_alias, $val->name,array("width"=>"100px","height"=>"100px","style"=>"border-radius: 10px;"));
												}else{
													$picVal = HTML::image('assets/no-image.png', $val->name,array("width"=>"100px","height"=>"100px","style"=>"border-radius: 10px;"));
												}
												$cvVal = "";
												if($file = Helpers::getUploadedFileDetails($val->cv)){
													$cvVal = HTML::link("/download/" . $file[0]->file_alias," ". $file[0]->file_name,array('class'=>'fa fa-download'));
												}	
													
												$i++;
												$tab_head .= '<li><a href="#tabs-'.$i.'">Team '.$i.'</a></li>';
												$tab_body .= '<div id="tabs-'.$i.'">';
												$tab_body .= '
													 
														<dl class="dl-horizontal">
															<dt style="color:rgb(49, 29, 142)" >
																<div style=" height:200px; width:auto ;  border-bottom-left-radius: 10px">
																	<div style="background-color: #fff;">
																		<div style="float: left; width:100px; margin-top: 1px; margin-left: 20px; border-radius: 10px; height:100px; background-color: #fff;">
																				'.$picVal.'
																		</div>
																	</div>
																</div>
															</dt>
															<dd>';
												
												$tab_body .= '<table class="table table-striped">
                                                    <tbody>   

                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">Name:</td>
                                                            <td style="color:rgb(49, 29, 142)" >'.$val->name.'</td>
                                                        </tr>

                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">Title:</td>
                                                            <td style="color:rgb(49, 29, 142)" >'.$val->title.'</td>
                                                        </tr>
                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">Role:</td>
                                                            <td style="color:rgb(49, 29, 142)" >'.$val->role.'</td>
                                                        </tr>

                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">Qualification:</td>
                                                            <td style="color:rgb(49, 29, 142)" >'.$val->qualifications.'</td>
                                                        </tr>

                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">Past Experience:</td>
                                                            <td style="color:rgb(49, 29, 142)" >'.$val->experience.'</td>
                                                        </tr>
                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">Brief description:</td>
                                                            <td style="color:rgb(49, 29, 142)" >'.$val->description.' </td>
                                                        </tr>
                                                        <tr class="dl-horizontal">
                                                            <td style="text-align: left; white-space:normal; ">Curriculum Vitae:</td>
                                                            <td style="color:rgb(49, 29, 142)" >
                                                                '.$cvVal.'
                                                            </td>
                                                        </tr>      
                                                    </tbody>
                                                </table>';
												
												$tab_body .= "</dd></dl></div>";
											}
											$tab_head .= "</ul>";
											echo $tab_head . $tab_body;
										?>
									</div><!--end div ttabs -->

                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />

                    </div> <!-- end of tab_5 -->


                    <div class="tab-pane" id="tab_6">
                        <?php
                        $summaryStatement = Helper::getSummaryStatement($campaign);

                        if (empty($summaryStatement) || ( Input::old() && Session::get('activetab') == 'tab_6')) { // if((count($campaignSummary[0])<=0 && Input::old()))
                            $summaryStatement[0] = NEW stdClass();
                            $summaryStatement[0]->summary = Input::OLD('summary');
                        }
                        ?>
                        <div class="col-md-6" style="width:100% !important">
                            <div class="box box-solid">
                                <div class="box-header">

                                    <h3 class="box-title" style="color: rgb(45, 195, 45) !important; ">Company Summary </h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Brief description:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $summaryStatement[0]->summary }}</dd>
                                    </dl>


                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />

                    </div> <!-- end of tab_6 -->

                    <div class="tab-pane" id="tab_7">
                        <?php
							$financialStatement = Helper::getFinancialStatement($campaign);

							if (empty($financialStatement) || ( Input::old() && Session::get('activetab') == 'tab_7')) { // if((count($campaignSummary[0])<=0 && Input::old()))
								$financialStatement[0] = NEW stdClass();
								$financialStatement[0]->financial_statement = Input::OLD('f_statement');
							}
                        ?>
                        <div class="col-md-6" style="width:100% !important">
                            <div class="box box-solid">
                                <div class="box-header">

                                    <h3 class="box-title" style="color: rgb(45, 195, 45) !important; ">Company Financials </h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Financials:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >
											{{''; $file = Helpers::getUploadedFileDetails($financialStatement[0]->financial_statement)}}
                                            @if(!empty($file))
                                            {{HTML::link("/download/" . $file[0]->file_alias," ". $file[0]->file_name,array('class'=>'fa fa-download'))}}
                                            @endif 
										</dd>
                                    </dl>


                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />

                    </div> <!-- end of tab_7 -->

                    <div class="tab-pane" id="tab_8">
                        <div class="col-md-6" style="width:100% !important">
                            <div class="box box-solid">
                                <div class="box-header">

                                    <h3 class="box-title" style="color: rgb(45, 195, 45) !important; ">Coming soon... </h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">




                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />

                    </div> <!-- end of tab_8 -->
                    <div class="tab-pane" id="tab_9">
                        <div class="col-md-6" style="width:100% !important">
                            <div class="box box-solid">
                                <div class="box-header">

                                    <h3 class="box-title" style="color: rgb(45, 195, 45) !important; ">Short video pitch for campaign </h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Video:</dt>
                                        <dd style="color:rgb(49, 29, 142)" ><textarea class="form_control" rows="8" style="width:100% !important;"></textarea></dd>
                                    </dl>


                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />

                    </div> <!-- end of tab_8 -->


                </div><!-- /.tab-content -->
            </div><!-- nav-tabs-custom -->
        </div><!-- /.col -->

			

    </div> 
    
    <!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
			</div><!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->

</section><!-- /.content -->


<script src="<?=url()?>/app/views/admin/js/jquery.min.js"></script>
<script type="text/javascript">
	
	$(document).ready(function(){
		$('.button_like').click(function(){
			$('.button_unlike').removeClass('dislike-h');    
			$(this).addClass('like-h');
			$.ajax({
				type:"POST",
				url:"/campaign/like",
				
				/*data:'userid='+"<?=Session::get('account_id')?>"+'&like_action=like&pageID='+"<?=$campaign ?>",*/
				data: {action:"getLikes", userid:"<?=Session::get('account_id')?>", pageID:"<?=$campaign?>", like_action:"like"},
				success: function(data){
					$("#linkeBtn").val(data);
				}
			});
		});
		
		$('.button_unlike').click(function(){
			$('.button_like').removeClass('dislike-h');    
			$(this).addClass('like-h');
			$.ajax({
				type:"POST",
				url:"/campaign/like",
				data: {action:"getLikes", userid:"<?=Session::get('account_id')?>", pageID:"<?=$campaign?>", like_action:"unlike"},
				success: function(data){
					$("#unlinkeBtn").val(data);
				}
			});
		});
		
	});
       

</script>


@stop
