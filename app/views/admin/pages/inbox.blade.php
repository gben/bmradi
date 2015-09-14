@extends('admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Campaign Profile
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">MailBox</li>
        <li class="active">Inbox</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <h2 class="page-header"></h2>
    <!--@if ($errors->has()) <div class="callout callout-danger"><p> Oops! Please correct the fields highlighted</p></div> @endif-->
    <div class="row">
        <div class="col-md-6" style="width:100% !important">
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
                        <?php
                        $campaignSummary = Helper::getCampaignSummary($campaign);

                        if ((empty($campaignSummary) || Input::old()) && Session::get('activetab') == 'tab_1') { // if((count($campaignSummary[0])<=0 && Input::old()))
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
                        ?>
                        <div class="col-md-6" style="width:100% !important">
                            <div class="box box-solid">
                                <div class="box-header">

                                    <h3 class="box-title" style="color: rgb(45, 195, 45) !important; ">Basic Details </h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Logo:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >
                                            {{''; $file = Helpers::getUploadedFileDetails($campaignSummary[0]->listing_logo) }}
                                            {{HTML::image('asset/$file[0]->file_alias', $campaignSummary[0]->business_name.' logo',array("width"=>"400px","height"=>"300px"))}}
                                        </dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Name of business:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{$campaignSummary[0]->business_name}}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Summary:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{$campaignSummary[0]->business_summary}} </dd>
                                    </dl>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />
                        <br />
                        <div class="col-md-6" style="width:100% !important">
                            <div class="box box-solid">
                                <div class="box-header">

                                    <h3 class="box-title"  style="color: rgb(45, 195, 45) !important;">Investment Summary </h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Minimum Investment Sought:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{$campaignSummary[0]->min_investment}}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Minimum percentage of equity:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{$campaignSummary[0]->percent_equity}} </dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Pre-Money Valuation:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{$campaignSummary[0]->pre_money_valuation}}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Maximum Investment Sought:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{$campaignSummary[0]->max_investment}}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Maximum percentage of equity:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{$campaignSummary[0]->max_percent_equity}}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">How the money will be used:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{$campaignSummary[0]->money_use}}</dd>
                                    </dl>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />
                        <br />

                        <div class="col-md-6" style="width:100% !important">
                            <div class="box box-solid">
                                <div class="box-header">

                                    <h3 class="box-title" style="color: rgb(45, 195, 45) !important;">Business Sector </h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Business Category:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{$campaignSummary[0]->categories}}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Web presence:</dt>
                                        <dd>
                                            <a class="btn btn-block btn-social btn-vk"  style="width: 50% !important;"> 
                                                <i class="fa fa-vk"></i> &nbsp;{{$campaignSummary[0]->website}}
                                            </a>
                                        </dd>
                                        <dd>
                                            <a class="btn btn-block btn-social btn-facebook" style="width: 50% !important;"> 
                                                <i class="fa fa-facebook"></i>&nbsp; {{$campaignSummary[0]->facebook}}
                                            </a>
                                        </dd>
                                        <dd>
                                            <a class="btn btn-block btn-social btn-twitter"  style="width: 50% !important;"> 
                                                <i class="fa fa-twitter"></i> &nbsp;{{$campaignSummary[0]->twitter}}
                                            </a>
                                        </dd>
                                        <dd>
                                            <a class="btn btn-block btn-social btn-linkedin"  style="width: 50% !important;"> 
                                                <i class="fa fa-linkedin"></i>&nbsp; {{$campaignSummary[0]->linkedin}}
                                            </a>
                                        </dd>

                                    </dl>

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
                                            <a> 
                                                Certificate of incoporation.pdf
                                            </a>
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
                                <div class="box-body">

                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Nominal Capital:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{$companyDetails[0]->nominal_capital}}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Per value of share:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $companyDetails[0]->share_value }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Allocated shares:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $companyDetails[0]->allocated_shares }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Unallocated shares:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $companyDetails[0]->unallocated_shares }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Total number of shares:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $companyDetails[0]->total_no_shares }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Directors loan:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $companyDetails[0]->director_loans }}</dd>
                                    </dl>

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
                                <div class="box-body">
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Number of Directors:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $companyDetails[0]->no_directors }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Number of Shareholders:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $companyDetails[0]->no_shareholders }}</dd>
                                    </dl>

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
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Customer Base:</dt>
                                        <dd style="color:rgb(49, 29, 142)" ><b>Gender</b> : {{ $companyDetails[0]->customer_base }} </dd> <br />
                                        <dd style="color:rgb(49, 29, 142)" ><b>Age group</b> : {{ $companyDetails[0]->age_group }} </dd> <br />
                                        <dd style="color:rgb(49, 29, 142)" ><b>Location</b> : {{ $companyDetails[0]->location }} </dd> <br />
                                        <dd style="color:rgb(49, 29, 142)" ><b>Profession</b> : {{ $companyDetails[0]->category }} </dd> <br />
                                        <dd style="color:rgb(49, 29, 142)" ><b>Characteristics</b> : {{ $companyDetails[0]->customer_xtics }} </dd> <br />
                                        <dd style="color:rgb(49, 29, 142)" ><b>Other</b> : {{ $companyDetails[0]->other_info }} </dd>
                                    </dl>
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
                                            <a> 
                                                Certificates.pdf
                                            </a> <br />
                                            <a> 
                                                Certificates B.pdf
                                            </a> <br />
                                            <a> 
                                                Awards.pdf
                                            </a>  <br />
                                            <a> 
                                                Awards B.pdf
                                            </a>
                                        </dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Links of Articles:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >
                                            <a style=""> 
                                                Links of Articles.pdf
                                            </a>

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
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Description:</dt>
                                        <dd style="color:rgb(49, 29, 142)" ><b>Gender</b> : {{ $marketInfo[0]->gender }} </dd> <br />
                                        <dd style="color:rgb(49, 29, 142)" ><b>Age group</b> : {{ $marketInfo[0]->age_group }} </dd> <br />
                                        <dd style="color:rgb(49, 29, 142)" ><b>Location</b> : {{ $marketInfo[0]->location }} </dd> <br />
                                        <dd style="color:rgb(49, 29, 142)" ><b>Profession</b> : {{ $marketInfo[0]->category }} </dd> <br />
                                        <dd style="color:rgb(49, 29, 142)" ><b>Characteristics</b> : {{ $marketInfo[0]->characteristics }} </dd> <br />
                                        <dd style="color:rgb(49, 29, 142)" ><b>Other</b> : {{ $marketInfo[0]->other }} </dd>
                                    </dl>
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
                                <div class="box-body">
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">No. of shares on offer:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $proposal[0]->no_shares_on_offer }}</dd>
                                    </dl>

                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">% of equity on offer:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $proposal[0]->percent_equity_on_offer }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Price per share:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $proposal[0]->share_price }}</dd>
                                    </dl>
                                    <hr />
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Total investment:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $proposal[0]->total_investment }}</dd>
                                    </dl>
                                    <hr />
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Minimum individual investment:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $proposal[0]->min_indie_investment }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">No. of shares:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $proposal[0]->min_indv_shares }}</dd>
                                    </dl>
                                    <hr />
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Maximum individual investment:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $proposal[0]->max_indie_investment }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">No. of shares:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $proposal[0]->max_indv_shares }}</dd>
                                    </dl>
                                    <hr />
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Maximum number of investors:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $proposal[0]->max_no_inv }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Minimum number of investors:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $proposal[0]->min_no_inv }}</dd>
                                    </dl>
                                    <hr />
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Is there a board seat offering?:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $proposal[0]->board_seat }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">For what size of investment?:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $proposal[0]->board_seat_investment }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">No of shares:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $proposal[0]->board_no_shares }}</dd>
                                    </dl>
                                    <hr />
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Policy on dividends:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $proposal[0]->dividends_policy }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Voting rights:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $proposal[0]->voting_rights }}</dd>
                                    </dl>

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
                                <div class="box-body">
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Photo:</dt>
                                        <dd style="color:rgb(49, 29, 142)" ><textarea class="form_control" rows="3" style="width:20% !important;"></textarea></dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Name:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $team[0]->name }}</dd>
                                    </dl>

                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Title:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $team[0]->title }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Role:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $team[0]->role }}</dd>
                                    </dl>

                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Qualification:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $team[0]->qualifications }}</dd>
                                    </dl>

                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Past Experience:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $team[0]->experience }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Brief description:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >{{ $team[0]->description }} </dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt style="text-align: left; white-space:normal; ">Curriculum Vitae:</dt>
                                        <dd style="color:rgb(49, 29, 142)" >
                                            <a> 
                                                Curriculum Vitae.pdf
                                            </a>
                                        </dd>
                                    </dl>

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

                                    <h3 class="box-title" style="color: rgb(45, 195, 45) !important; ">SummaryTeam Members </h3>
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

</section><!-- /.content -->
@stop