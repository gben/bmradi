@extends('admin.layouts.default')

@section('content')



<section class="content-header">

    <h1>

        Campaign Profile

    </h1>

    <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Campaigns</li>

        <li class="active">My Campaigns</li>

    </ol>

</section>

{{ Session::get('_response') }}

<!-- Main content -->

<section class="content">

    <div style="width: 20%;float: left"><h2 class="page-header">{{ Helpers::getCampaignID(Input::get('campaign'),true) }}</h2></div>

    <div style="margin-top: 10px">

        {{ Form::open(array('url'=>'','files'=>true, 'name'=>'campaignAction')) }}

        {{Helpers::getCampaignAppAction(Helpers::getCampaignID(Input::get('campaign')),true)}}

        {{Form::close()}}

    </div>

    @if ($errors->has()) <div class="callout callout-danger"><p> Oops! Please correct the fields highlighted</p></div> @endif

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



                    <div class="tab-pane" id="tab_1">

                        {{ Form::open(array('url'=>'save/campaignSummary','files'=>true, 'name'=>'campaignsummary')) }}

                        {{ Form::hidden('activetab','tab_1') }}

                        {{ Form::hidden('campaign',$campaign) }}

                        <?php

                        $campaignSummary = Helper::getCampaignSummary($campaign);



                        if (empty($campaignSummary) && (Session::get('activetab') == 'tab_1' || Input::get('activetab') == 'tab_1' ) ) { 

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

                        <b>Basic Details:</b> 

                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />



                        <label for="listing_logo">Logo Upload</label>

                        <div style="margin-left: 140px !important;">

                            {{ Form::hidden('listing_logo_h',($campaignSummary[0]->listing_logo==''?'0':$campaignSummary[0]->listing_logo)) }}

                            <div class="form-group @if ($errors->has('listing_logo')) has-error @endif">

                                {{ Form::file('listing_logo',array("accept"=>"image/*","class"=>"form-control")) }}

                            </div>

                            {{''; $file = Helpers::getUploadedFileDetails($campaignSummary[0]->listing_logo)}}

                            @if(!empty($file))

                            {{HTML::link("/download/" . $file[0]->file_alias," ". $file[0]->file_name,array('class'=>'fa fa-download'))}}

                            @endif

                        </div>



                        <label for="business_name">Name of business</label>

                        <div style="margin-left: 140px !important;">

                            <div class="form-group @if ($errors->has('business_name')) has-error @endif">

                                {{ Form::text('business_name',$campaignSummary[0]->business_name,array("placeholder"=>"50 characters..","class"=>"form-control")) }} 

                            </div>

                        </div>



                        <label for="business_summary">Summary</label>

                        <div style="margin-left: 140px !important;">

                            <div class="form-group @if ($errors->has('business_summary')) has-error @endif">

                                {{ Form::textarea('business_summary',$campaignSummary[0]->business_summary,array("placeholder"=>"Short description of what the company does. 140 characters..","class"=>"form-control","rows"=>"3")) }} 

                            </div>

                        </div>

                        <br />

                        <b>Investment Summary:</b>

                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />



                        <label for="">Minimum Investment Sought</label>

                        <label for="" style="margin-left: 514px !important;">Minimum percentage of equity </label>



                        <div style="margin-left: 140px !important;">



                            <div class="input-group @if ($errors->has('min_inv_percent')) has-error @endif">

                                <div class="input-group-addon" style="">

                                    <i class="fa fa-money"></i>

                                </div>

                                {{ Form::text('min_investment',Helpers::getGlobalValue('MINIMUM_INV_SOUGHT'),array("style"=>"width:40% !important","class"=>"form-control",'readonly')) }}



                                <?php

                                for ($i = 1; $i < 100; $i++) {

                                    $perEquity[$i] = $i;

                                }

                                ?>

                                {{ Form::select('min_inv_percent',@$perEquity,$campaignSummary[0]->percent_equity,array("style"=>"width:40% !important; margin-left: 160px;","class"=>"form-control pull-right")) }} 

                                <span class="input-group-addon">%</span>



                            </div>

                        </div>

                        <br />

                        <label for="money_valuation">Pre-Money Valuation</label>

                        <div style="margin-left: 140px !important;">

                            <div class="input-group @if ($errors->has('money_valuation')) has-error @endif">

                                <div class="input-group-addon" style="">

                                    <i class="fa fa-money"></i>

                                </div>

                                {{ Form::text('money_valuation',$campaignSummary[0]->pre_money_valuation,array("style"=>"width:38% !important","class"=>"form-control")) }}  

                                <button type="submit" class="btn btn-primary btn-flat">Calculate</button>

                            </div>

                        </div>



                        <br />

                        <hr />



                        <label for="max_investment">Maximum Investment Sought : Incase of Overfunding</label>

                        <label for="max_investment" style="margin-left: 365px !important;">Maximum percentage of equity </label> 



                        <div style="margin-left: 140px !important;">



                            <div class="input-group  @if ($errors->has('max_investment')) has-error @endif">





                                <div class="input-group-addon" style="">

                                    <i class="fa fa-money"></i>

                                </div>

                                {{ Form::text('max_investment',$campaignSummary[0]->max_investment,array("style"=>"width:40% !important","class"=>"form-control")) }}

                                <?php

                                for ($i = 1; $i < 100; $i++) {

                                    $perEquity[$i] = $i;

                                }

                                ?>

                                {{ Form::select('max_inv_percent',@$perEquity,$campaignSummary[0]->max_percent_equity,array("style"=>"width:40% !important; margin-left: 160px;","class"=>"form-control pull-right")) }} 

                                <span class="input-group-addon">%</span>



                            </div>

                        </div>

                        <hr />

                        <br />

                        <label for="exampleInputFile">What is the money going to be used for?</label>

                        <div style="margin-left: 140px !important;">

                            <div class="form-group @if ($errors->has('money_util')) has-error @endif">

                                {{ Form::textarea('money_util',$campaignSummary[0]->money_use,array("placeholder"=>"Short description of how the money is going to be used. 300 characters..","class"=>"form-control","rows"=>"3")) }}

                            </div>

                        </div>



                        <b>Business Sector:</b>

                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />



                        <label for="categories">Category under which the business falls</label>



                        <div style="margin-left: 140px !important;">

                            <?php

                            $rs = DB::select("SELECT ID,TITLE FROM mradi_categories WHERE INTRASH='NO'");

                            foreach ($rs as $cats) {

                                $categories[$cats->ID] = $cats->TITLE;

                            }

                            ?>

                            {{ Form::select('categories',@$categories,$campaignSummary[0]->categories,array("style"=>"width:40% !important; margin-left: 0px;","class"=>"form-control")) }} 

                        </div>



                        <b>Web Presence:</b>

                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />

                        <div style="margin-left: 140px !important;">

                            <div class="form-group">                                

                                <div class="checkbox @if ($errors->has('website_address')) has-error @endif">Website                                   

                                    {{ Form::text('website_address',$campaignSummary[0]->website,array("style"=>"width:60%; margin-left: 0px;","class"=>"form-control","placeholder"=>" Your Website address...")) }}

                                </div>

                                <div class="checkbox @if ($errors->has('facebook_address')) has-error @endif">Facebook

                                    {{ Form::text('facebook_address',$campaignSummary[0]->facebook,array("style"=>"width:60%; margin-left: 0px;","class"=>"form-control","placeholder"=>" Your Facebook page...")) }}

                                </div>

                                <div class="checkbox @if ($errors->has('twitter_address')) has-error @endif">Twitter

                                    {{ Form::text('twitter_address',$campaignSummary[0]->twitter,array("style"=>"width:60%; margin-left: 0px;","class"=>"form-control","placeholder"=>" Your Twitter handle...")) }}

                                </div>

                                <div class="checkbox @if ($errors->has('linkedin_address')) has-error @endif">LinkedIn

                                    {{ Form::text('linkedin_address',$campaignSummary[0]->linkedin,array("style"=>"width:60%; margin-left: 0px;","class"=>"form-control","placeholder"=>" Your LinkedIn page...")) }}

                                </div>

                            </div>

                        </div>

                        <div class="box-footer" style="text-align: center">

                            {{ Form::submit('Save',array("class"=>"btn btn-flat btn-success")) }}

                        </div>

                        {{ Form::close() }}                        

                    </div>



                    <!-- /.box-body -->



                    <div class="tab-pane" id="tab_2">{{ Form::open(array('url'=>'save/companyDetails','files'=>true, 'name'=>'companydetails')) }}

                        {{ Form::hidden('activetab','tab_2') }}

                        {{ Form::hidden('campaign',$campaign) }}

                        <?php

                        $companyDetails = Helper::getCampaignDetails($campaign);



                        if (empty($companyDetails) || ( Input::old() && Session::get('activetab') == 'tab_2')) {

                            $companyDetails[0] = new stdClass();

                            $companyDetails[0]->country_of_ops = Input::old('country_of_ops');

                            $companyDetails[0]->incorporation_no = Input::old('incorporation_no');

                            $companyDetails[0]->incorporation_date = Input::old('incorporation_date');

                            $companyDetails[0]->incorporation_cert = Input::old('incorporation_cert');

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

                            $companyDetails[0]->awards = Input::old('awards_search');

                            $companyDetails[0]->article_link = Input::old('articles_search');

                        }

                        ?>

                        <b>Company Details:</b>

                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />



                        <label for="exampleInputFile">Country of Operation</label> : **If not Kenya, Kindly incorporate in Kenya first

                        <div  class="form-group @if ($errors->has('country_of_ops')) has-error @endif" style="margin-left: 140px !important;">



                            <?php

                            $rs = DB::select("SELECT ID,CODE FROM countries_dbx ");

                            foreach ($rs as $cats) {

                                $countries[$cats->CODE] = $cats->ID;

                            }

                            ?>

                            {{ Form::select('country_of_ops',@$countries,$companyDetails[0]->country_of_ops,array("style"=>"width:40% !important; margin-left: 0px;","class"=>"form-control")) }} 

                        </div>



                        <br />

                        <label for="exampleInputFile">Incorporation Number</label>

                        <label for="exampleInputFile" style="margin-left: 550px !important;">Date of Incorporation</label>

                        <div style="margin-left: 140px !important;">

                            <div class="input-group @if ($errors->has('incorporation_no')) has-error @endif" >

                                 <div class="input-group-addon" style="">

                                    <i class="fa fa-info"></i>

                                </div>

                                {{ Form::text('incorporation_no',$companyDetails[0]->incorporation_no,array("placeholder"=>"50 characters..","class"=>"form-control","style"=>"width:40% !important;")) }}



                                

                                <div class="form-group @if ($errors->has('incorporation_date')) has-error @endif">

                                {{ Form::text('incorporation_date',$companyDetails[0]->incorporation_date,array(

                                "class"=>"form-control pull-right","style"=>"width:40% !important; margin-left: 160px !important;","data-inputmask"=>"'alias': 'yyyy/mm/dd'","data-mask"=>'')) }}

                                

                                </div>

                                <div class="input-group-addon" style="">

                                    <i class="fa fa-calendar"></i>

                                </div>

                            </div>

                        </div>







                        <br />

                        <label for="exampleInputFile">Upload scan of cert of Incorporation</label>

                        <div style="margin-left: 140px !important;">



                            {{ Form::hidden('incorporation_cert_h',($companyDetails[0]->incorporation_cert==''?'0':$companyDetails[0]->incorporation_cert)) }}

                            <div class="form-group @if ($errors->has('incorporation_cert')) has-error @endif">

                                {{ Form::file('incorporation_cert',array("accept"=>"image/*","class"=>"form-control")) }}

                            </div>

                            {{''; $file = Helpers::getUploadedFileDetails($companyDetails[0]->incorporation_cert)}}

                            @if(!empty($file))

                            {{HTML::link("/download/" . $file[0]->file_alias," ". $file[0]->file_name,array('class'=>'fa fa-download'))}}
                            @endif

                        </div>



                        <b>Address:</b>

                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />





                        <label for="exampleInputFile">Postal Address</label>

                        <label for="exampleInputFile" style="margin-left: 600px !important;">Physical Address</label>

                        <div style="margin-left: 140px !important;">

                            <div class="input-group @if ($errors->has('postal_address')) has-error @endif " >

                                <div class="input-group-addon" style="">

                                    <i class="fa fa-location-arrow"></i>

                                </div>

                                {{ Form::text('postal_address',$companyDetails[0]->postal_address,array("placeholder"=>"P.O.Box..","class"=>"form-control","style"=>"width:40%;")) }}



                                <div class="form-group @if ($errors->has('physical_address')) has-error @endif " >

                                    {{ Form::text('physical_address',$companyDetails[0]->physical_address,array("placeholder"=>"Street, building, road...","class"=>"form-control pull-right","style"=>"width:40%;margin-left: 160px !important;")) }}



                                </div>

                                <div class="input-group-addon" style="">

                                    <i class="fa fa-road"></i>

                                </div>

                            </div>

                            

                        </div>



                        

                        <br />





                        <b>Share Structure: </b>(in Kshs.)

                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />



                        <label for="exampleInputFile">Nominal Capital</label>

                        <label for="exampleInputFile" style="margin-left: 590px !important;">Per Value of Share</label>

                        <div style="margin-left: 140px !important;">

                            <div class="input-group @if ($errors->has('nominal_capital')) has-error @endif ">



                               

                                 <div class="input-group-addon" style="">

                                <i class="fa fa-money"></i>

                            </div>

                                

                                {{ Form::text('nominal_capital',$companyDetails[0]->nominal_capital,array("class"=>"form-control","style"=>"width:40% !important;")) }}



                                <div class="form-group @if ($errors->has('share_value')) has-error @endif ">

                                    {{ Form::text('share_value',$companyDetails[0]->share_value,array("class"=>"form-control pull-right","style"=>"width:40%; margin-left: 160px !important;")) }}

                                </div>

                                 <div class="input-group-addon" style="">

                                <i class="fa fa-money"></i>

                            </div>

                            </div>

                        </div>



                        <label for="exampleInputFile">Allocated Shares</label>

                        <label for="exampleInputFile" style="margin-left: 587px !important;">Unallocated Shares</label>

                        <div  class="input-group @if ($errors->has('allocated_shares')) has-error @endif" style="margin-left: 140px !important;">

                            <div class="input-group-addon" style="">

                                    <i class="fa fa-info"></i>

                                </div>

                            {{ Form::text('allocated_shares',$companyDetails[0]->allocated_shares,array("class"=>"form-control","style"=>"width:40%;")) }}





                            <div  class="form-group @if ($errors->has('unallocated_shares')) has-error @endif" style="margin-left: 140px !important;">

                                {{ Form::text('unallocated_shares',$companyDetails[0]->unallocated_shares,array("class"=>"form-control pull-right","style"=>"width:48%; margin-left: 160px !important;")) }}



                            </div>

                            <div class="input-group-addon" style="">

                                    <i class="fa fa-info"></i>

                                </div>



                        </div>





                        



                        <label for="exampleInputFile">Total number of Shares</label>



                        <div  class="form-group @if ($errors->has('total_no_shares')) has-error @endif" style="margin-left: 140px !important;">



                            <div class="input-group">

                                 <div class="input-group-addon" style="">

                                <i class="fa fa-info"></i>

                            </div>

                                {{ Form::text('total_no_shares','',array("class"=>"form-control","style"=>"width:39% !important;",'disabled')) }}



                            </div>

                        </div>



                        <label for="exampleInputFile">Director's loan</label>



                        <div  class="form-group @if ($errors->has('director_loans')) has-error @endif"   style="margin-left: 140px !important;">



                            <div class="input-group">



                                <div class="input-group-addon" style="">

                                <i class="fa fa-money"></i>

                            </div>

                                {{ Form::text('director_loans',$companyDetails[0]->director_loans,array("class"=>"form-control","style"=>"width:38% !important;")) }}

                            </div>

                        </div>



                        

                        <br />

                        <b>Corporate Governance:</b>

                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />



                        <label for="exampleInputFile">Number of Directors</label>

                        <label for="exampleInputFile" style="margin-left: 568px !important;">Number of Shareholders</label>

                        <div  class="input-group @if ($errors->has('no_directors')) has-error @endif"  style="margin-left: 140px !important;">

                            <div class="input-group-addon" style="">

                                <i class="fa fa-info"></i>

                            </div>

                            {{ Form::text('no_directors',$companyDetails[0]->no_directors,array("class"=>"form-control","style"=>"width:40%;")) }}

                            <div  class="form-group @if ($errors->has('no_shareholders')) has-error @endif">

                                {{ Form::text('no_shareholders',$companyDetails[0]->no_shareholders,array("class"=>"form-control pull-right","style"=>"width:40%; margin-left: 160px !important;")) }}



                            </div>

                            <div class="input-group-addon" style="">

                                <i class="fa fa-info"></i>

                            </div>

                        </div>


                        <br />

                        <b>Description of business</b> (This should give a clear picture of what the business does and how it is positioned in the industry)

                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />



                        <label for="exampleInputFile">What is the product or service provided?</label>

                        <div style="margin-left: 140px !important;">

                            <div class="form-group @if ($errors->has('product_description')) has-error @endif">

                                {{ Form::textarea('product_description',$companyDetails[0]->product_description,array("placeholder"=>"McDonald's is a fast food resturant that provides cheap, quick food to its customers","class"=>"form-control","rows"=>"3" )) }} 

                            </div>

                        </div>



                        <label for="exampleInputFile">Why is it needed?</label>

                        <div style="margin-left: 140px !important;">

                            <div class="form-group @if ($errors->has('product_use')) has-error @endif">

                                {{ Form::textarea('product_use',$companyDetails[0]->product_use,array("placeholder"=>"Describe the problem it solves or the product it improves upon","class"=>"form-control","rows"=>"3" )) }} 

                            </div>

                        </div> 



                        <label for="exampleInputFile">Describe your current customer base</label>

                        <div  style="margin-left: 140px !important;">

                            <label for="exampleInputFile">Gender</label>

                            <div class="form-group @if ($errors->has('customer_base')) has-error @endif" >

                                <div class="checkbox" style="margin-top: 0px !important;">



                                    {{ Form::radio('customer_base', 'male', ($companyDetails[0]->customer_base=='male'?true:'')) }} Male

                                    {{ Form::radio('customer_base', 'female',($companyDetails[0]->customer_base=='female'?true:'')) }} Female

                                    {{ Form::radio('customer_base', 'both',($companyDetails[0]->customer_base=='both'?true:'')) }} Both



                                </div></div>

                            <label for="exampleInputFile">Age group</label>

                            <div class="form-group @if ($errors->has('age_group')) has-error @endif" >

                                {{''; $age_group = explode(';',$companyDetails[0]->age_group) }}

                                <div class="input-group" style="width:70%">

                                    <input id="age_group" type="text" name="age_group" data-from="{{(count($age_group)>1?$age_group[0]:0)}}" data-to="{{(count($age_group)>1?$age_group[1]:50)}}" value="" />

                                    <!--{{ Form::text('age_group',$companyDetails[0]->age_group,array("placeholder"=>"Give a range or write 'all' if it targets everyone","class"=>"form-control","style"=>"width:207% !important")) }}-->

                                </div>

                            </div>



                            <label for="exampleInputFile">Location</label>

                            <label for="exampleInputFile" style="margin-left: 500px !important;">Profession/category</label>

                            <div class="input-group @if ($errors->has('location')) has-error @endif" >

                                <div class="input-group-addon" style="">

                                    <i class="fa fa-info"></i>

                                </div>

                                {{ Form::text('location',$companyDetails[0]->location,array("placeholder"=>"Geographical targets","class"=>"form-control","style"=>"width:40% !important")) }}

                                <div class="form-group @if ($errors->has('category')) has-error @endif" >

                                    {{ Form::text('category',$companyDetails[0]->category,array("placeholder"=>"Breitling watches target pilots","class"=>"form-control pull-right","style"=>"width:40% !important; margin-left: 160px !important; ")) }}

                                </div>

                                <div class="input-group-addon" style="">

                                    <i class="fa fa-info"></i>

                                </div>



                            </div>



                            

                            

                            <label for="exampleInputFile">Characteristics</label>

                            <label for="exampleInputFile"  style="margin-left: 460px !important;">Other</label>

                            <div class="input-group @if ($errors->has('customer_xtics')) has-error @endif" >

                                <div class="input-group-addon" style="">

                                    <i class="fa fa-info"></i>

                                </div>

                                    {{ Form::text('customer_xtics',$companyDetails[0]->customer_xtics,array("placeholder"=>"Describe the characteristics your ideal customer has","class"=>"form-control","style"=>"width:40% !important")) }}

                                <div class="form-group @if ($errors->has('other_info')) has-error @endif" >

                                    {{ Form::text('other_info',$companyDetails[0]->other_info,array("placeholder"=>"Any additional description not captured above","class"=>"form-control pull-right","style"=>"width:40% !important; margin-left: 160px !important; ")) }}

                                </div>

                                    <div class="input-group-addon" style="">

                                    <i class="fa fa-info"></i>

                                </div>

                            </div>



                            

                     

                        </div> 

                        <br />

                        <label for="exampleInputFile">How does it make money?</label>

                        <div style="margin-left: 140px !important;">

                            <div class="form-group @if ($errors->has('revenue')) has-error @endif">

                                {{ Form::textarea('revenue',$companyDetails[0]->revenue,array("placeholder"=>"Describe the revenue streams and models","class"=>"form-control","rows"=>"3")) }}



                            </div>

                        </div> 



                        <label for="exampleInputFile">What is the average size of a sale?</label>

                        <div style="margin-left: 140px !important;">

                            <div class="form-group @if ($errors->has('sale_size')) has-error @endif">

                                {{ Form::textarea('sale_size',$companyDetails[0]->sale_size,array("class"=>"form-control","rows"=>"3")) }}



                            </div>

                        </div>



                        <label for="exampleInputFile">What advantages do you have in this space?</label>

                        <div style="margin-left: 140px !important;">

                            <div class="form-group @if ($errors->has('advantages')) has-error @endif">

                                {{ Form::textarea('advantages',$companyDetails[0]->advantages,array("class"=>"form-control","rows"=>"3")) }}



                            </div>

                        </div>



                        <label for="exampleInputFile">What are the challenges and how do you face them?</label>

                        <div style="margin-left: 140px !important;">

                            <div class="form-group @if ($errors->has('challenges')) has-error @endif">

                                {{ Form::textarea('challenges',$companyDetails[0]->challenges,array("class"=>"form-control","rows"=>"3")) }}

                            </div>

                        </div>



                        <label for="exampleInputFile">What are the accomplishments so far?</label>

                        <div style="margin-left: 140px !important;">

                            <div class="form-group @if ($errors->has('accomplishments')) has-error @endif">

                                {{ Form::textarea('accomplishments',$companyDetails[0]->accomplishments,array("class"=>"form-control","rows"=>"3")) }}

                            </div>

                        </div>



                        <label for="exampleInputFile">Upload photos of any awards & certificates</label>

                        <div style="margin-left: 140px !important;">

                            {{ Form::hidden('awards_search_h',($companyDetails[0]->awards==''?'0':$companyDetails[0]->awards)) }}

                            <div class="form-group @if ($errors->has('awards_search')) has-error @endif">

                                {{ Form::file('awards_search',array("accept"=>"image/*")) }}

                            </div>

                            {{''; $file = Helpers::getUploadedFileDetails($companyDetails[0]->awards)}}

                            @if(!empty($file))

                            {{HTML::link("/download/" . $file[0]->file_alias," ". $file[0]->file_name,array('class'=>'fa fa-download'))}}

                            @endif

                        </div>

                        <br />

                        <label for="exampleInputFile">Upload any links of articles</label>

                        <div style="margin-left: 140px !important;">

                            {{ Form::hidden('articles_search_h',($companyDetails[0]->article_link==''?'0':$companyDetails[0]->article_link)) }}

                            <div class="form-group @if ($errors->has('articles_search')) has-error @endif">

                                {{ Form::file('articles_search',array("accept"=>"image/*")) }}

                            </div>

                            {{''; $file = Helpers::getUploadedFileDetails($companyDetails[0]->article_link)}}

                            @if(!empty($file))

                            {{HTML::link("/download/" . $file[0]->file_alias," ". $file[0]->file_name,array('class'=>'fa fa-download'))}}

                            @endif

                        </div>

                        <div class="box-footer" style="text-align: center">

                            {{ Form::submit('Save',array("class"=>"btn btn-flat btn-success")) }}

                        </div>

                        {{ Form::close() }}

                    </div>





                    <div class="tab-pane" id="tab_3">{{ Form::open(array('url'=>'save/marketInfo','files'=>true, 'name'=>'marketinfo')) }}

                        {{ Form::hidden('activetab','tab_3') }}

                        {{ Form::hidden('campaign',$campaign) }}

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

                            $marketInfo[0]->graph = Input::old('charts_search');

                        }

                        ?>



                        This is an overview of the market the business is in, how it is growing and the potential it holds

                        <br />

                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />



                        <b>Target Market Description:</b>

                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />



                        <label for="exampleInputFile">What is your target market?</label>

                        <div style="margin-left: 140px !important;">

                            <div class="form-group @if ($errors->has('target_market')) has-error @endif">

                                {{ Form::textarea('target_market',$marketInfo[0]->target_market,array("class"=>"form-control","rows"=>"3")) }} 

                            </div>

                        </div>

                        <label for="exampleInputFile">Describe your target market?</label>

                        <div style="margin-left: 140px !important;">

                            <label for="exampleInputFile">Gender</label>

                            <div class="form-group @if ($errors->has('gender_2')) has-error @endif">

                                <div class="checkbox" style="margin-top: 0px !important;">

                                    {{ Form::radio('gender_2', 'male', ($marketInfo[0]->gender=='male'?true:'')) }} Male

                                    {{ Form::radio('gender_2', 'female',($marketInfo[0]->gender=='female'?true:'')) }} Female

                                    {{ Form::radio('gender_2', 'both',($marketInfo[0]->gender=='both'?true:'')) }} Both

                                </div>



                            </div>

                            <label for="exampleInputFile">Age group</label>

                            <div class="form-group @if ($errors->has('age_group_2')) has-error @endif">

                                {{''; $age_group = explode(';',$marketInfo[0]->age_group) }}

                                <div class="input-group" style="width:70%">

                                    <input id="age_group_2" type="text" name="age_group_2" data-from="{{(count($age_group)>1?$age_group[0]:0)}}" data-to="{{(count($age_group)>1?$age_group[1]:50)}}" value="" /><br/>

                                    <!--{{ Form::text('age_group_2',$marketInfo[0]->age_group,array("placeholder"=>"Give a range or write 'all' if it targets everyone","class"=>"form-control","style"=>"width:207% !important")) }}-->



                                </div>



                            </div>




                 <label for="exampleInputFile">Location</label>

                            <label for="exampleInputFile" style="margin-left: 499px !important;">Profession/category</label>

                            <div class="input-group @if ($errors->has('location_2')) has-error @endif" >

                                <div class="input-group-addon" style="">

                                    <i class="fa fa-info"></i>

                                </div>

                                {{ Form::text('location_2',$marketInfo[0]->location,array("placeholder"=>"Geographical targets","class"=>"form-control","style"=>"width:40% !important")) }}

                                <div class="form-group @if ($errors->has('category')) has-error @endif" >

                                   {{ Form::text('category_2',$marketInfo[0]->category,array("placeholder"=>"Breitling watches target pilots","class"=>"form-control pull-right","style"=>"width:40% !important; margin-left: 160px !important;")) }}

                                </div>

                                <div class="input-group-addon" style="">

                                    <i class="fa fa-info"></i>

                                </div>



                            </div>



                            <label for="exampleInputFile">Characteristics</label>

                            <label for="exampleInputFile"  style="margin-left: 460px !important;">Other</label>

                            <div class="input-group @if ($errors->has('characteristics_2')) has-error @endif" >

                                <div class="input-group-addon" style="">

                                    <i class="fa fa-info"></i>

                                </div>

                                    {{ Form::text('characteristics_2',$marketInfo[0]->characteristics,array("placeholder"=>"Describe the characteristics your ideal customer has","class"=>"form-control","style"=>"width:40% !important")) }}

                                <div class="form-group @if ($errors->has('other_2')) has-error @endif" >

                                    {{ Form::text('other_2',$marketInfo[0]->other,array("placeholder"=>"Any additional description not captured above","class"=>"form-control pull-right","style"=>"width:40% !important; margin-left: 160px !important;")) }}

                                </div>

                                    <div class="input-group-addon" style="">

                                    <i class="fa fa-info"></i>

                                </div>

                            </div>

                            

                        </div> 

                        <br />

                        <label for="exampleInputFile">How do  you reach them?</label>

                        <div style="margin-left: 140px !important;">

                            <div class="form-group @if ($errors->has('reach')) has-error @endif">

                                {{ Form::textarea('reach',$marketInfo[0]->reach,array("placeholder"=>"Describe the advertising & marketing you undertake","class"=>"form-control","rows"=>"3")) }}



                            </div>

                        </div>



                        <label for="exampleInputFile">Can the market expand? How? </label>

                        <div style="margin-left: 140px !important;">

                            <div class="form-group @if ($errors->has('growth_desc')) has-error @endif">

                                {{ Form::textarea('growth_desc',$marketInfo[0]->growth_desc,array("placeholder"=>"How do you plan to scale? New locations? New age group? Cater to different categories?","class"=>"form-control","rows"=>"3")) }}

                            </div>

                        </div>





                        <b>Industry Description:</b>

                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />



                        <label for="exampleInputFile">Which industry does the business fall under?</label>

                        <div style="margin-left: 140px !important;">

                            <div class="form-group @if ($errors->has('biz_industry')) has-error @endif">

                                {{ Form::textarea('biz_industry',$marketInfo[0]->biz_industry,array("placeholder"=>"Toyota is in the automobile industry","class"=>"form-control","rows"=>"3")) }}

                            </div>

                        </div>



                        <label for="exampleInputFile">How many players in the industry?</label>

                        <div style="margin-left: 140px !important;">

                            <div class="form-group @if ($errors->has('plyr_in_industry')) has-error @endif">

                                {{ Form::textarea('plyr_in_industry',$marketInfo[0]->plyr_in_industry,array("placeholder"=>"Give an approximation in your target location, and in the world","class"=>"form-control","rows"=>"3")) }}

                            </div>

                        </div>



                        <label for="exampleInputFile">How many have entered in the last year?</label>

                        <div style="margin-left: 140px !important;">

                            <div class="form-group @if ($errors->has('plyr_ent_last_year')) has-error @endif">

                                {{ Form::textarea('plyr_ent_last_year',$marketInfo[0]->plyr_ent_last_year,array("placeholder"=>"Give an approximation in your target location, and in the world","class"=>"form-control","rows"=>"3")) }}

                            </div>

                        </div>

                        <label for="exampleInputFile">How much has it grown in the past three years?</label>

                        <div style="margin-left: 140px !important;">

                            <div class="form-group @if ($errors->has('growth')) has-error @endif">

                                {{ Form::textarea('growth',$marketInfo[0]->growth,array("placeholder"=>"Give an approximation in your target location, and in the world","class"=>"form-control","rows"=>"3")) }}

                            </div>

                        </div>



                        <label for="charts_search">Upload any Charts/Graphs</label>

                        <div style="margin-left: 140px !important;">                            

                            {{ Form::hidden('charts_search_h',($marketInfo[0]->graph==''?'0':$marketInfo[0]->graph)) }}

                            <div class="form-group @if ($errors->has('charts_search')) has-error @endif">

                                {{ Form::file('charts_search',array("accept"=>"image/pdf")) }} 

                            </div>

                            {{''; $file = Helpers::getUploadedFileDetails($marketInfo[0]->graph)}}

                            @if(!empty($file))

                            {{HTML::link("/download/" . $file[0]->file_alias," ". $file[0]->file_name,array('class'=>'fa fa-download'))}}

                            @endif

                        </div>

                        <br />

                        <label for="exampleInputFile">What new trends are emerging?</label>

                        <div style="margin-left: 140px !important;">

                            <div class="form-group @if ($errors->has('new_trends')) has-error @endif">

                                {{ Form::textarea('new_trends',$marketInfo[0]->new_trends,array("placeholder"=>"Brief description on the new things happening","class"=>"form-control","rows"=>"3")) }}

                            </div>

                        </div>



                        <label for="exampleInputFile">What is your market share?</label>

                        <div style="margin-left: 140px !important;">

                            <div class="form-group @if ($errors->has('market_share')) has-error @endif">

                                {{ Form::textarea('market_share',$marketInfo[0]->market_share,array("placeholder"=>"Give an approximation in your target location, and in the world","class"=>"form-control","rows"=>"3")) }}

                            </div>

                        </div>





                        <div class="box-footer" style="text-align: center">

                            {{ Form::submit('Save',array("class"=>"btn btn-flat btn-success")) }}

                        </div>{{ Form::close() }}

                    </div>





                    <div class="tab-pane" id="tab_4"> {{ Form::open(array('url'=>'save/proposal','files'=>true, 'name'=>'proposal')) }}

                        {{ Form::hidden('activetab','tab_4') }}

                        {{ Form::hidden('campaign',$campaign) }}

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

                        This should give a detailed explanation of the investment being sought and the terms & conditions it comes with

                        <br />

                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />



                        <b>Investment Description:</b>

                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />





                        <table style="width:100%;">

                            <tr >  

                                <td><label for="exampleInputFile">No. of Shares on offer?</label></td> 

                                <td><label for="exampleInputFile" style="margin-left: 190px !important;">% of equity on offer</label></td> 

                                <td><label for="exampleInputFile" style="margin-left: 220px !important;">Price Per Share</label></td> 



                            </tr>

                            <tr>

                                <td> <div class="form-group @if ($errors->has('no_shares_on_offer')) has-error @endif" style="margin-left: 140px !important;">

                                        <div class="input-group">

                                            <div class="input-group-addon" style="">

                                                <i class="fa fa-info"></i>

                                            </div>

                                            {{ Form::text('no_shares_on_offer',$proposal[0]->no_shares_on_offer,array("class"=>"form-control","style"=>"width:100% !important")) }}

                                        </div>

                                    </div>

                                </td> 

                                <td><div class="form-group @if ($errors->has('percent_equity_on_offer')) has-error @endif" style="margin-left: 190px !important;">

                                        <div class="input-group">

                                            <?php

                                            for ($i = 1; $i < 100; $i++) {

                                                $perEquity[$i] = $i;

                                            }

                                            ?><span class="input-group-addon">%</span>

                                            {{ Form::select('percent_equity_on_offer',@$perEquity,$proposal[0]->percent_equity_on_offer,array("class"=>"form-control","style"=>"width:90% !important")) }}                                         </div>

                                    </div>

                                </td> 

                                <td>

                                    <div class="form-group @if ($errors->has('share_price')) has-error @endif" style="margin-left: 220px !important;">

                                        <div class="input-group">

                                            <div class="input-group-addon" style="">

                                                <i class="fa fa-money"></i>

                                            </div>

                                            {{ Form::text('share_price',$proposal[0]->share_price,array("class"=>"form-control","style"=>"width:90% !important")) }}

                                        </div>

                                    </div>

                                </td> 

                            </tr>

                        </table>

                        <label for="exampleInputFile">Total Investment</label>

                        <div style="margin-left: 140px !important;">

                            <div class="form-group @if ($errors->has('total_investment')) has-error @endif">

                                <div class="input-group">

                                    <div class="input-group-addon" style="">

                                        <i class="fa fa-money"></i>

                                    </div>

                                    {{ Form::text('total_investment',$proposal[0]->total_investment,array("class"=>"form-control","style"=>"width:40% !important","disabled"=>'')) }}



                                </div>

                            </div>

                        </div>

                        <hr style="width:100%;"/>



                       

                    <label for="exampleInputFile">Minimum Individual Investment?</label></td> 

                    <label for="exampleInputFile" style="margin-left: 490px !important;">No. of shares </label></td> 





                    <div  class=input-group @if ($errors->has('min_indie_investment')) has-error @endif" style="margin-left: 140px !important;">

                        <div class="input-group-addon" style="">

                            <i class="fa fa-info"></i>

                        </div>

                        {{ Form::text('min_indie_investment',$proposal[0]->min_indie_investment,array("class"=>"form-control","style"=>"width:40% !important")) }}

                        <div class="form-group @if ($errors->has('min_indv_shares')) has-error @endif"  >

                            

                            {{ Form::text('min_indv_shares',$proposal[0]->min_indv_shares,array("class"=>"form-control pull-right","style"=>"width:40% !important; margin-left: 160px !important","disabled"=>'')) }}





                        </div>

                        <div class="input-group-addon" style="">

                                <i class="fa fa-info"></i>

                            </div>

                    </div>



                    <label for="exampleInputFile">Maximum Individual Investment?</label></td> 

                    <label for="exampleInputFile" style="margin-left: 487px !important;">No. of shares </label></td> 



                    <div class="input-group @if ($errors->has('max_indie_investment')) has-error @endif" style="margin-left: 140px !important;">

                        <div class="input-group-addon" style="">

                            <i class="fa fa-info"></i>

                        </div>

                        {{ Form::text('max_indie_investment',$proposal[0]->max_indie_investment,array("class"=>"form-control","style"=>"width:40% !important")) }}

                        <div class="form-group @if ($errors->has('max_indv_shares')) has-error @endif" >



                            {{ Form::text('max_indv_shares',$proposal[0]->max_indv_shares,array("class"=>"form-control pull-right","style"=>"width:40% !important; margin-left: 160px !important","disabled"=>'')) }}



                        </div>

                        <div class="input-group-addon" style="">

                            <i class="fa fa-info"></i>

                        </div>

                    </div>


                    <label for="exampleInputFile">Maximum number of Investors</label>

                    <label for="exampleInputFile" style="margin-left: 505px !important;">Minimum number of Investors</label>

                    <div class="input-group @if ($errors->has('max_no_inv')) has-error @endif" style="margin-left: 140px !important;">

                        <div class="input-group-addon" style="">

                            <i class="fa fa-info"></i>

                        </div>

                        {{ Form::text('max_no_inv',$proposal[0]->max_no_inv,array("class"=>"form-control","style"=>"width:40% !important","disabled")) }}

                        <div  class="form-group @if ($errors->has('min_no_inv')) has-error @endif" >



                            {{ Form::text('min_no_inv',$proposal[0]->min_no_inv,array("class"=>"form-control pull-right","style"=>"width:40% !important; margin-left: 160px !important","disabled")) }}

                        </div>

                        <div class="input-group-addon" style="">

                            <i class="fa fa-info"></i>

                        </div>

                    </div>

                        

                        <label for="exampleInputFile">Is there a board seat offering? </label>

                        <div class="form-group @if ($errors->has('board_seat')) has-error @endif" style="margin-left: 140px !important;">

                            <div class="radio" style="margintrue-top: 0px !important;">

                                {{ Form::radio('board_seat', 'yes',($proposal[0]->board_seat=='yes'?true:'')) }} Yes

                                {{ Form::radio('board_seat', 'no',($proposal[0]->board_seat=='no'?true:'')) }} No

                            </div>



                        </div>

                        

                        

                        <label for="exampleInputFile">For what size of investment? </label>:

                        <label for="exampleInputFile" style="margin-left: 516px !important;">No. of Shares?</label>: 



                        <div class="input-group @if ($errors->has('board_seat_investment')) has-error @endif" style="margin-left: 140px !important;">

                            <?php

                            for ($i = 0; $i < 100; $i++) {

                                $perEquity[$i] = $i;

                            }

                            ?><span class="input-group-addon">%</span>

                            {{ Form::select('board_seat_investment',@$perEquity,$proposal[0]->board_seat_investment,array("style"=>"width:39% !important;","class"=>"form-control")) }} 



                            <div class="form-group @if ($errors->has('board_no_shares')) has-error @endif" >

                                {{ Form::text('board_no_shares',$proposal[0]->board_no_shares,array("class"=>"form-control pull-right","style"=>"width:40% !important; margin-left: 106px !important","disabled")) }}



                            </div>   

                            <div class="input-group-addon" style="">

                                <i class="fa fa-info"></i>

                            </div>

                        </div>



                        <label for="exampleInputFile">What is the policy on dividends?</label>

                        <div style="margin-left: 140px !important;">

                            <div class="form-group @if ($errors->has('dividends_policy')) has-error @endif">

                                {{ Form::textarea('dividends_policy',$proposal[0]->dividends_policy,array("placeholder"=>"Describe the circumstance under which dividends would be paid","class"=>"form-control","rows"=>"3")) }}

                            </div>

                        </div>



                        <label for="exampleInputFile">Voting Rights?</label>

                        <div style="margin-left: 140px !important;">

                            <div class="form-group @if ($errors->has('voting_rights')) has-error @endif">

                                {{ Form::textarea('voting_rights',$proposal[0]->voting_rights,array("placeholder"=>"Describe the voting rights of additional investors","class"=>"form-control","rows"=>"3")) }}

                            </div>

                        </div>



                        <b>Investor Description:</b>

                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />



                        <label for="exampleInputFile">What industry would you want the investor to come from? </label>

                        <div style="margin-left: 140px !important;">

                            <div class="form-group @if ($errors->has('investor_industry')) has-error @endif">

                                {{ Form::textarea('investor_industry',$proposal[0]->investor_industry,array("class"=>"form-control","rows"=>"3")) }}

                            </div>

                        </div>

                        <label for="exampleInputFile">What kind of input are you looking for from an investor? </label>

                        <div style="margin-left: 140px !important;">

                            <div class="form-group @if ($errors->has('investor_input')) has-error @endif">

                                {{ Form::textarea('investor_input',$proposal[0]->investor_input,array("class"=>"form-control","rows"=>"3")) }}

                            </div>

                        </div>



                        <label for="exampleInputFile">Describe Use of Funds</label>

                        <div style="margin-left: 140px !important;">

                            <div class="form-group @if ($errors->has('funds_use')) has-error @endif">

                                {{ Form::textarea('funds_use',$proposal[0]->funds_use,array("class"=>"form-control","rows"=>"3", "placeholder"=>"It is recommended to write this up on a word processor then past into the text box")) }}

                            </div>

                        </div>

                        <div class="box-footer" style="text-align: center">

                            {{ Form::submit('Save',array("class"=>"btn btn-flat btn-success")) }}

                        </div>

                        {{ Form::close() }}

                    </div>



                    <div class="tab-pane" id="tab_5">
						  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
						  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
						  
						  <script>
							  $(function() {
								$( "#ttabs" ).tabs();
							  });
						  </script>
						<div id="ttabs">
						<?php
							$team = Helper::getTeamDetails($campaign);
							$total_members = $team[0]->team_count;
							$tab_head = "<ul>";
							$tab_body = "";
							$i = 0;
							if (empty($team) || ($total_members < 5) || ( Input::old() && Session::get('activetab') == 'tab_5')) {
								//no team members added or less than 5
								if($total_members >= 1){
									$team_list = Helper::getTeamList($campaign);
									while($i <= $total_members){
										if(!isset($team_list[$i])){
											$val = new stdClass();
											$val->id = Input::old('id');
											$val->name = Input::old('name');
											$val->title = Input::old('title');
											$val->role = Input::old('role');
											$val->experience = Input::old('experience');
											$val->qualifications = Input::old('qualifications');
											$val->description = Input::old('description');
											$val->cv = Input::old('cv');
											$val->picture = Input::old('picture');
										}else{
											$val = $team_list[$i];
										}
										
										$j = $i+1;
										$tab_head .= '<li><a href="#tabs-'.$j.'">Team '.$j.'</a></li>';
										$tab_body .= '<div id="tabs-'.$j.'">';
										$tab_body .= Form::open(array('url'=>'save/team','files'=>true, 'name'=>'team'));
										$tab_body .= Form::hidden('activetab','tab_5');
										$tab_body .= Form::hidden('campaign',$campaign);
										$tab_body .= Form::hidden('team_id',$val->id);
										
										$nmErr = $errors->has("name") ? "has-error":"";
										$ttErr = $errors->has("title") ? "has-error":"";
										$rlErr = $errors->has("role") ? "has-error":"";
										$qfErr = $errors->has("qualifications") ? "has-error":"";
										$xpErr = $errors->has("experience") ? "has-error":"";
										$dsErr = $errors->has("description") ? "has-error":"";
										$pcErr = $errors->has("pics_search") ? "has-error":"";
										$picVal = "";
										if($file = Helpers::getUploadedFileDetails($val->picture)){
											$picVal = HTML::link("/download/" . $file[0]->file_alias," ". $file[0]->file_name,array('class'=>'fa fa-download'));
										}
										$cvErr = $errors->has("cv_search") ? "has-error":"";
										$cvVal = "";
										if($file = Helpers::getUploadedFileDetails($val->cv)){
											$cvVal = HTML::link("/download/" . $file[0]->file_alias," ". $file[0]->file_name,array('class'=>'fa fa-download'));
										}						
								 
										$tab_body .= '<label for="name">Name</label>
										<div class="form-group '.$nmErr.'" style="margin-left: 140px !important;">
											<div class="input-group">
												<span class="input-group-addon "></span>
												'.Form::text('name',$val->name,array("class"=>"form-control","style"=>"width:70% !important;" )).'
											</div>
										</div>

										<label for="title">Title</label>
										<div class="form-group '.$ttErr.'" style="margin-left: 140px !important;">
											<div class="input-group">
												<span class="input-group-addon "></span>
												'.Form::text('title',$val->title,array("class"=>"form-control","style"=>"width:70% !important;" )).'
											</div>
										</div>

										<label for="role">Role</label>
										<div style="margin-left: 140px !important; ">
											<div class="form-group '.$rlErr.'">
												'.Form::textarea('role',$val->role,array("placeholder"=>"What do they do in the company?","class"=>"form-control","rows"=>"3")).'
											</div>
										</div>

										<label for="qualifications">Qualification</label>
										<div style="margin-left: 140px !important;">
											<div class="form-group '.$qfErr.'">
												'.Form::textarea('qualifications',$val->qualifications,array("placeholder"=>"What are their academic and technical qualifications","class"=>"form-control","rows"=>"3")).'
											</div>
										</div>

										<label for="experience">Past Experience</label>
										<div style="margin-left: 140px !important;">
											<div class="form-group '.$xpErr.'">
												'.Form::textarea('experience',$val->experience,array("placeholder"=>"What relevant past experience do they have?","class"=>"form-control","rows"=>"3")).'
											</div>
										</div>

										<label for="description">Brief Description</label>
										<div style="margin-left: 140px !important;">
											<div class="form-group '.$dsErr.'">
												'.Form::textarea('description',$val->description,array("placeholder"=>"Fun/Interesting Facts..","class"=>"form-control","rows"=>"3")).' 
											</div>
										</div>
										
										<label for="pics_search">Upload Picture</label>
										<div style="margin-left: 140px !important;">
											'.Form::hidden('pics_search_h',($val->picture==''?'0':$val->picture)).'
											<div class="form-group '.$pcErr.'">
												'.Form::file('pics_search',array("accept"=>"image/*")).'
											</div> '. $picVal	.'
										</div>
										
										<label for="exampleInputFile">Upload CV</label> (in PDF)
										<div style="margin-left: 140px !important;">                            
											'.Form::hidden('cv_search_h',($val->cv==''?'0':$val->cv)).'
											<div class="form-group '.$cvErr.'">
												'.Form::file('cv_search',array("accept"=>"*")).'
											</div>'. $cvVal .'
										</div>
										
										<div class="box-footer" style="text-align: center">
											'.Form::submit('Save',array("class"=>"btn btn-flat btn-success")).'
										</div>';

										$tab_body .= Form::close();
										$tab_body .= "</div>";
										$i++;
									}
								$tab_head .= "</ul>";
								}else{
										$val = new stdClass();
										$val->id = Input::old('id');
										$val->name = Input::old('name');
										$val->title = Input::old('title');
										$val->role = Input::old('role');
										$val->experience = Input::old('experience');
										$val->qualifications = Input::old('qualifications');
										$val->description = Input::old('description');
										$val->cv = Input::old('cv');
										$val->picture = Input::old('picture');
										 //var_dump($val);exit;
										$j = $i+1;
										$tab_head .= '<li><a href="#tabs-'.$j.'">Team '.$j.'</a></li>';
										$tab_body .= '<div id="tabs-'.$j.'">';
										$tab_body .= Form::open(array('url'=>'save/team','files'=>true, 'name'=>'team'));
										$tab_body .= Form::hidden('activetab','tab_5');
										$tab_body .= Form::hidden('campaign',$campaign);
										$tab_body .= Form::hidden('team_id',$val->id);
										
										$nmErr = $errors->has("name") ? "has-error":"";
										$ttErr = $errors->has("title") ? "has-error":"";
										$rlErr = $errors->has("role") ? "has-error":"";
										$qfErr = $errors->has("qualifications") ? "has-error":"";
										$xpErr = $errors->has("experience") ? "has-error":"";
										$dsErr = $errors->has("description") ? "has-error":"";
										$pcErr = $errors->has("pics_search") ? "has-error":"";
										$picVal = "";
										if($file = Helpers::getUploadedFileDetails($val->picture)){
											$picVal = HTML::link("/download/" . $file[0]->file_alias," ". $file[0]->file_name,array('class'=>'fa fa-download'));
										}
										$cvErr = $errors->has("cv_search") ? "has-error":"";
										$cvVal = "";
										if($file = Helpers::getUploadedFileDetails($val->cv)){
											$cvVal = HTML::link("/download/" . $file[0]->file_alias," ". $file[0]->file_name,array('class'=>'fa fa-download'));
										}						
								 
										$tab_body .= '<label for="name">Name</label>
										<div class="form-group '.$nmErr.'" style="margin-left: 140px !important;">
											<div class="input-group">
												<span class="input-group-addon "></span>
												'.Form::text('name',$val->name,array("class"=>"form-control","style"=>"width:70% !important;" )).'
											</div>
										</div>

										<label for="title">Title</label>
										<div class="form-group '.$ttErr.'" style="margin-left: 140px !important;">
											<div class="input-group">
												<span class="input-group-addon "></span>
												'.Form::text('title',$val->title,array("class"=>"form-control","style"=>"width:70% !important;" )).'
											</div>
										</div>

										<label for="role">Role</label>
										<div style="margin-left: 140px !important; ">
											<div class="form-group '.$rlErr.'">
												'.Form::textarea('role',$val->role,array("placeholder"=>"What do they do in the company?","class"=>"form-control","rows"=>"3")).'
											</div>
										</div>

										<label for="qualifications">Qualification</label>
										<div style="margin-left: 140px !important;">
											<div class="form-group '.$qfErr.'">
												'.Form::textarea('qualifications',$val->qualifications,array("placeholder"=>"What are their academic and technical qualifications","class"=>"form-control","rows"=>"3")).'
											</div>
										</div>

										<label for="experience">Past Experience</label>
										<div style="margin-left: 140px !important;">
											<div class="form-group '.$xpErr.'">
												'.Form::textarea('experience',$val->experience,array("placeholder"=>"What relevant past experience do they have?","class"=>"form-control","rows"=>"3")).'
											</div>
										</div>

										<label for="description">Brief Description</label>
										<div style="margin-left: 140px !important;">
											<div class="form-group '.$dsErr.'">
												'.Form::textarea('description',$val->description,array("placeholder"=>"Fun/Interesting Facts..","class"=>"form-control","rows"=>"3")).' 
											</div>
										</div>
										
										<label for="pics_search">Upload Picture</label>
										<div style="margin-left: 140px !important;">
											'.Form::hidden('pics_search_h',($val->picture==''?'0':$val->picture)).'
											<div class="form-group '.$pcErr.'">
												'.Form::file('pics_search',array("accept"=>"image/*")).'
											</div> '. $picVal	.'
										</div>
										
										<label for="exampleInputFile">Upload CV</label> (in PDF)
										<div style="margin-left: 140px !important;">                            
											'.Form::hidden('cv_search_h',($val->cv==''?'0':$val->cv)).'
											<div class="form-group '.$cvErr.'">
												'.Form::file('cv_search',array("accept"=>"*")).'
											</div>'. $cvVal .'
										</div>
										
										<div class="box-footer" style="text-align: center">
											'.Form::submit('Save',array("class"=>"btn btn-flat btn-success")).'
										</div>';

										$tab_body .= Form::close();
										$tab_body .= "</div>";
										$i++;
								}
							}else{
								//5 members
								$team_list = Helper::getTeamList($campaign);
								foreach($team_list as $val){
									$i++;
									$tab_head .= '<li><a href="#tabs-'.$i.'">Team '.$i.'</a></li>';
									$tab_body .= '<div id="tabs-'.$i.'">';
									$tab_body .= Form::open(array('url'=>'save/team','files'=>true, 'name'=>'team'));
									$tab_body .= Form::hidden('activetab','tab_5');
									$tab_body .= Form::hidden('campaign',$campaign);
									$tab_body .= Form::hidden('team_id',$val->id);
									
									$nmErr = $errors->has("name") ? "has-error":"";
									$ttErr = $errors->has("title") ? "has-error":"";
									$rlErr = $errors->has("role") ? "has-error":"";
									$qfErr = $errors->has("qualifications") ? "has-error":"";
									$xpErr = $errors->has("experience") ? "has-error":"";
									$dsErr = $errors->has("description") ? "has-error":"";
									$pcErr = $errors->has("pics_search") ? "has-error":"";
									$picVal = "";
									if($file = Helpers::getUploadedFileDetails($val->picture)){
										$picVal = HTML::link("/download/" . $file[0]->file_alias," ". $file[0]->file_name,array('class'=>'fa fa-download'));
									}
									$cvErr = $errors->has("cv_search") ? "has-error":"";
									$cvVal = "";
									if($file = Helpers::getUploadedFileDetails($val->cv)){
										$cvVal = HTML::link("/download/" . $file[0]->file_alias," ". $file[0]->file_name,array('class'=>'fa fa-download'));
									}						
							 
									$tab_body .= '<label for="name">Name</label>
									<div class="form-group '.$nmErr.'" style="margin-left: 140px !important;">
										<div class="input-group">
											<span class="input-group-addon "></span>
											'.Form::text('name',$val->name,array("class"=>"form-control","style"=>"width:70% !important;" )).'
										</div>
									</div>

									<label for="title">Title</label>
									<div class="form-group '.$ttErr.'" style="margin-left: 140px !important;">
										<div class="input-group">
											<span class="input-group-addon "></span>
											'.Form::text('title',$val->title,array("class"=>"form-control","style"=>"width:70% !important;" )).'
										</div>
									</div>

									<label for="role">Role</label>
									<div style="margin-left: 140px !important; ">
										<div class="form-group '.$rlErr.'">
											'.Form::textarea('role',$val->role,array("placeholder"=>"What do they do in the company?","class"=>"form-control","rows"=>"3")).'
										</div>
									</div>

									<label for="qualifications">Qualification</label>
									<div style="margin-left: 140px !important;">
										<div class="form-group '.$qfErr.'">
											'.Form::textarea('qualifications',$val->qualifications,array("placeholder"=>"What are their academic and technical qualifications","class"=>"form-control","rows"=>"3")).'
										</div>
									</div>

									<label for="experience">Past Experience</label>
									<div style="margin-left: 140px !important;">
										<div class="form-group '.$xpErr.'">
											'.Form::textarea('experience',$val->experience,array("placeholder"=>"What relevant past experience do they have?","class"=>"form-control","rows"=>"3")).'
										</div>
									</div>

									<label for="description">Brief Description</label>
									<div style="margin-left: 140px !important;">
										<div class="form-group '.$dsErr.'">
											'.Form::textarea('description',$val->description,array("placeholder"=>"Fun/Interesting Facts..","class"=>"form-control","rows"=>"3")).' 
										</div>
									</div>
									
									<label for="pics_search">Upload Picture</label>
									<div style="margin-left: 140px !important;">
										'.Form::hidden('pics_search_h',($val->picture==''?'0':$val->picture)).'
										<div class="form-group '.$pcErr.'">
											'.Form::file('pics_search',array("accept"=>"image/*")).'
										</div> '. $picVal	.'
									</div>
									
									<label for="exampleInputFile">Upload CV</label> (in PDF)
									<div style="margin-left: 140px !important;">                            
										'.Form::hidden('cv_search_h',($val->cv==''?'0':$val->cv)).'
										<div class="form-group '.$cvErr.'">
											'.Form::file('cv_search',array("accept"=>"*")).'
										</div>'. $cvVal .'
									</div>
									
									<div class="box-footer" style="text-align: center">
										'.Form::submit('Save',array("class"=>"btn btn-flat btn-success")).'
									</div>';

									$tab_body .= Form::close();
									$tab_body .= "</div>";
								}
								$tab_head .= "</ul>";
							}
							
							echo $tab_head . $tab_body;
						?>
					</div>
					                        
                  </div>





                    <div class="tab-pane" id="tab_6">

                        {{ Form::open(array('url'=>'save/summaryStatement','files'=>true, 'name'=>'summarystatement')) }}

                        {{ Form::hidden('activetab','tab_6') }}

                        {{ Form::hidden('campaign',$campaign) }}

                        <?php

                        $summaryStatement = Helper::getSummaryStatement($campaign);



                        if (empty($summaryStatement) || ( Input::old() && Session::get('activetab') == 'tab_6')) { // if((count($campaignSummary[0])<=0 && Input::old()))

                            $summaryStatement[0] = NEW stdClass();

                            $summaryStatement[0]->summary = Input::OLD('summary');

                        }

                        ?>



                        <b>Summary of the whole proposal:</b>

                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />



                        <div class="form-group @if ($errors->has('summary')) has-error @endif">

                            {{ Form::textarea('summary',$summaryStatement[0]->summary,array("placeholder"=>"A paragraph wrapping up the whole proposal","class"=>"form-control")) }}

                        </div>

                        <div class="box-footer" style="text-align: center">

                            {{ Form::submit('Save',array("class"=>"btn btn-flat btn-success")) }}

                        </div>

                        {{ Form::close() }}

                    </div>





                    <div class="tab-pane" id="tab_7">

                        {{ Form::open(array('url'=>'save/financials','files'=>true, 'name'=>'financials')) }}
                        {{ Form::hidden('activetab','tab_7') }}

                        {{ Form::hidden('campaign',$campaign) }}
                        
                         <?php

                        $financialStatement = Helper::getFinancialStatement($campaign);



                        if (empty($financialStatement) || ( Input::old() && Session::get('activetab') == 'tab_7')) {
                            $financialStatement[0] = NEW stdClass();
                            $financialStatement[0]->financial_statement = Input::OLD('f_statement');
                        }

                        ?>
                        
                        

                        <b>Financial Statement - Upload Statement</b>

                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />
                        
                        <div style="margin-left: 140px !important;">

                            {{ Form::hidden('f_statement_h',($financialStatement[0]->financial_statement==''?'0':$financialStatement[0]->financial_statement)) }}

                            <div class="form-group @if ($errors->has('listing_logo')) has-error @endif">

                                {{ Form::file('f_statement',array("accept"=>"image/*","class"=>"form-control")) }}

                            </div>

                            {{''; $file = Helpers::getUploadedFileDetails($financialStatement[0]->financial_statement)}}

                            @if(!empty($file))

                            {{HTML::link("/download/" . $file[0]->file_alias," ". $file[0]->file_name,array('class'=>'fa fa-download'))}}

                            @endif

                        </div>

                        <div class="box-footer" style="text-align: center">

                            {{ Form::submit('Save',array("class"=>"btn btn-flat btn-success")) }}

                        </div>

                        {{ Form::close() }}
                        
                        
                        
                         <b>Financial Statement - Buy Template</b>

                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />
                        
                        <div style="margin-left: 140px !important;">
							
							{{ Form::open(array('url'=>'template/', 'name'=>'templates')) }}
							{{ Form::hidden('activetab','tab_7') }}

							{{ Form::hidden('campaign',$campaign) }}

                        </div>

                        <div class="box-footer" style="text-align: center">

                            {{ Form::submit('Buy Template',array("class"=>"btn btn-flat btn-success")) }}

                        </div>

							{{ Form::close() }}

                    </div>





                    <div class="tab-pane" id="tab_8">

                        {{ Form::open(array('url'=>'save/businessPlan','files'=>true, 'name'=>'businessplan')) }}
                        
                        {{ Form::hidden('activetab','tab_8') }}

                        {{ Form::hidden('campaign',$campaign) }}

                        <b>Coming soon...</b>

                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />

                        <div class="box-footer" style="text-align: center">

                            {{ Form::submit('Save',array("class"=>"btn btn-flat btn-success")) }}

                        </div>

                        {{ Form::close() }}

                    </div>





                    <div class="tab-pane" id="tab_9">

                        {{ Form::open(array('url'=>'save/video','files'=>true, 'name'=>'video')) }}

                        {{ Form::hidden('activetab','tab_9') }}

                        {{ Form::hidden('campaign',$campaign) }}

                        <?php

                        $video = Helper::getVideoContent($campaign);



                        if (empty($video) || ( Input::old() && Session::get('activetab') == 'tab_9')) { // if((count($campaignSummary[0])<=0 && Input::old()))

                            $video[0] = new stdClass();

                            $video[0]->video_url = Input::old('pitch_video');

                        }

                        ?>

                        <b>Upload a short video pitch for your campaign</b>

                        <hr style="width : 100%; margin-top: 0px !important; margin-bottom: 5px !important; border-color: rgba(252, 228, 106, 0.8);" />



                        <br />

                        {{ Form::hidden('pitch_video_h',($video[0]->video_url==''?'0':$video[0]->video_url)) }}

                        <label for="exampleInputFile">Video URL</label> 

                        <div  class="form-group @if ($errors->has('pitch_video')) has-error @endif" style="margin-left: 140px !important;">





                            <div class="form-group @if ($errors->has('pitch_video')) has-error @endif">

                                <!--{{ Form::file('pitch_video',array("accept"=>"video/*","class"=>"form-control")) }}-->

                                {{Form::text('pitch_video',$video[0]->video_url,array("class"=>"form-control"))}}

                            </div>

                            <!--                            {{''; //$file = Helpers::getUploadedFileDetails($video[0]->video_name)}}

                                                        @if(!empty($file))

                                                        {{'';//HTML::link("/download/" . $file[0]->file_alias," ". $file[0]->file_name,array('class'=>'fa fa-download'))}}

                                                        @endif-->

                        </div>

                        <div class="box-footer" style="text-align: center">

                            {{ Form::submit('Save',array("class"=>"btn btn-flat btn-success")) }}

                        </div>

                        {{ Form::close() }}

                    </div>



                    <!-- /.tab-pane -->

                </div><!-- /.tab-content -->

            </div><!-- nav-tabs-custom -->

        </div><!-- /.col -->





    </div> 



</section><!-- /.content -->

@stop
