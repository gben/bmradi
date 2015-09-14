@extends('admin.layouts.default')
@section('content')

<section class="content-header">
                    <h1>
                        Dashboard
                        @if(Session::get('account_type')=='ADMIN')
                            <small>Control panel</small>
                        @endif
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
				@if(Session::get('account_type')=='ADMIN')
				<!-- Small boxes (Stat box) -->
                    <div class="row">
						
						               
                        
                        <!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>
                                        @if($result = Helpers::getTotalInvestorBid(session::get('account_id'), true))
												 
													{{ number_format($result[0]->amount, 2) }}
											@else
												{{ number_format(0, 2) }}
											@endif
                                    </h3>
                                    <p>
                                        Active Investments
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-cash"></i>
                                </div>
                                {{HTML::link("wallet","View Statement... ",array("class"=>"small-box-footer "))}}
                                </a>
                            </div>
                        </div>
                        
                        <!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>
                                        @if($result = Helpers::getTotalInvestorBid(session::get('account_id')))
												 
													{{ number_format($result->sum('amount'), 2) }}
											@else
												{{ number_format(0, 2) }}
											@endif
                                    </h3>
                                    <p>
                                        Total Investments
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-cash"></i>
                                </div>
                                {{HTML::link("wallet","View Statement... ",array("class"=>"small-box-footer "))}}
                                </a>
                            </div>
                        </div>
              
						
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>
                                        <?=Helpers::getTotalCampaigns()?>
                                    </h3>
                                    <p>
                                        Campaigns
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                {{HTML::link(URL::route('campaigns_list'),"More info... ",array("class"=>"small-box-footer "))}}
                               
<!--                                <a href="#" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>-->
                            </div>
                        </div><!-- ./col -->
                        
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-orange">
                                <div class="row inner">
                                    <div class="col-lg-6 col-xs-6">
                                         <h3>
											 
											 @if($result = Helpers::getTotalInvestorBid(session::get('account_id'), true))
												 <?php $total=0; $tCount = count($result); $i=0; count($result) ?>
												@for($i=0;$i<$tCount;$i++)
													{{ $result[$i]->count }}
												@endfor
											@else
												{{ "0" }}
											@endif
										</h3>
										<p>
											Active Bids
										</p>
                                    </div>
									<div class="col-lg-6 col-xs-6">
                                         <h3>
											 @if($result = Helpers::getTotalInvestorBid(session::get('account_id')))
												 {{ $result->count(); }}
											@else
												{{ "0" }}
											@endif
											
										</h3>
										<p>
											Total Bids
										</p>
                                    </div>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-ios7-briefcase"></i>
                                </div>
                               {{HTML::link('bid','More info...',array("class"=>"small-box-footer"))}}  
                            </div>
                        </div><!-- ./col -->
                        
				<!-- Small boxes (Stat box) -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>
                                        <?=Helpers::getTotalCampaigns('', 'Ongoing')?>
                                    </h3>
                                    <p>
                                        Ongoing Campaigns
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-ios7-speedometer"></i>
                                </div>
                                {{HTML::link(URL::route('cgrid_list', 'ongoing'),'More info...',array("class"=>"small-box-footer"))}}                     
                            </div>
                        </div><!-- ./col -->
                        
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-purple">
                                <div class="inner">
                                    <h3>
                                         <?=Helpers::getTotalClosedCampaigns(null, 'Closed')?>
                                    </h3>
                                    <p>
                                        Closed Campaigns
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-ios7-locked"></i>
                                </div>
                               {{HTML::link(URL::route('cgrid_list', 'closed'),'More info...',array("class"=>"small-box-footer"))}}  
                            </div>
                        </div><!-- ./col -->
                      
                        
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>
                                        <?=Helpers::getTotalClosedCampaigns($is_admin = true, "success")?>
                                    </h3>
                                    <p>
                                       Successful Campaigns
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-checkmark-circled"></i>
                                </div>
                                {{HTML::link(URL::route('cgrid_list', 'success'),"More info... ",array("class"=>"small-box-footer "))}}
                            </div>
                        </div><!-- ./col -->
                        
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>
                                        <?=Helpers::getTotalClosedCampaigns($is_admin = true, "fail")?>
                                    </h3>
                                    <p>
                                       Unsuccessful Campaigns
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-close-circled"></i>
                                </div>
                                {{HTML::link(URL::route('cgrid_list', 'fail'),"More info... ",array("class"=>"small-box-footer "))}}
                            </div>
                        </div><!-- ./col -->
                        
                        
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>
                                        <?=Helpers::getTotalInvestors()?>
                                    </h3>
                                    <p>
                                        Total Investors
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                {{HTML::link(URL::route('investors'),"View Investors",array("class"=>"small-box-footer "))}}
                            </div>
                        </div><!-- ./col -->
                        
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3>
                                         <?=Helpers::getTotalEntrepreneurs()?>
                                    </h3>
                                    <p>
                                        Total Entrepreneurs
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                 {{HTML::link(URL::route('entrepreneur'),"View Entrepreneurs",array("class"=>"small-box-footer "))}}
                            </div>
                        </div><!-- ./col -->
                        
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>
                                        <?=Helpers::getTotalSubscriptions()?>
                                    </h3>
                                    <p>
                                       Newsletter Subscriptions
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                {{HTML::link(URL::route('subscr_acc'),"View Subscriptions",array("class"=>"small-box-footer "))}}
                            </div>
                        </div><!-- ./col -->
                        
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-olive">
                                <div class="row inner">
                                    <div class="col-lg-6 col-xs-6">
                                         <?php $campaigns = Campaign::getMyViews("", $is_admin = true);
                                         $count = 0; 
												foreach($campaigns as $c){
													//var_dump($c->no_of_views);
													$count += $c->no_of_views;
												}
												echo "<h3>".$count . " </h3>";
                                         
                                         ?>
                                         <p> Total Views</p>
                                    </div>
									<div class="col-lg-6 col-xs-6">
                                         <?php $campaigns = Campaign::getMyViews('today', $is_admin = true);
                                         $count = 0;
												foreach($campaigns as $c){
													$count += $c->no_of_views;
												}
												echo "<h3>".$count . " </h3>";
                                         
                                         ?>
                                         <p> Today </p>
                                    </div>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-android-lightbulb"></i>
                                </div>
                               {{HTML::link(URL::route('viewers_list'),'More info...',array("class"=>"small-box-footer"))}}  
                            </div>
                        </div><!-- ./col -->
                        
                        <!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>
                                        @if($result = Helpers::getTemplateTransactions())
											{{ number_format($result->sum('amount'), 2) }}
										@else
											{{ number_format(0, 2) }}
										@endif
                                    </h3>
                                    <p>
                                        Templates
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-cash"></i>
                                </div>
                                {{HTML::link("template_list","View Details... ",array("class"=>"small-box-footer "))}}
                                
                                </a>
                            </div>
                        </div>
                        <!-- end -->
                        
                    </div><!-- /.row -->
                    
                    
@elseif(Session::get('account_type')=='ENTREPRENEUR')
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>
                                        {{Helpers::getTotalCampaigns(true)}}
                                    </h3>
                                    <p>
                                        Campaigns
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                {{HTML::link(URL::route('campaigns_grid_list'),'More info...',array("class"=>"small-box-footer"))}}                     
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3>
                                        <?=Helpers::getTotalShelvedCampaigns()?>
                                    </h3>
                                    <p>
                                        Shelved Campaigns
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-android-storage"></i>
                                </div>
                                {{HTML::link(URL::route('cgrid_list', 'shelved'),'More info...',array("class"=>"small-box-footer"))}}  
                            </div>
                        </div><!-- ./col -->
                        
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>
                                         <?=Helpers::getTotalOngoingCampaigns()?>
                                    </h3>
                                    <p>
                                        Ongoing Campaigns
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-ios7-speedometer"></i>
                                </div>
                               {{HTML::link(URL::route('cgrid_list', 'ongoing'),'More info...',array("class"=>"small-box-footer"))}}  
                            </div>
                        </div><!-- ./col -->
                        
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-purple">
                                <div class="inner">
                                    <h3>
                                         <?=Helpers::getTotalClosedCampaigns()?>
                                    </h3>
                                    <p>
                                        Closed Campaigns
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-ios7-locked"></i>
                                </div>
                               {{HTML::link(URL::route('cgrid_list', 'closed'),'More info...',array("class"=>"small-box-footer"))}}  
                            </div>
                        </div><!-- ./col -->
                        
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-olive">
                                <div class="row inner">
                                    <div class="col-lg-6 col-xs-6">
                                         <?php $campaigns = Campaign::getMyViews();
                                         $count = 0;
												foreach($campaigns as $c){
													//var_dump($c->no_of_views);
													$count += $c->no_of_views;
												}
												echo "<h3>".$count . " </h3>";
                                         
                                         ?>
                                         <p> Total Views</p>
                                    </div>
									<div class="col-lg-6 col-xs-6">
                                         <?php $campaigns = Campaign::getMyViews('today');
                                         $count = 0;
												foreach($campaigns as $c){
													$count += $c->no_of_views;
												}
												echo "<h3>".$count . " </h3>";
                                         
                                         ?>
                                         <p> Today </p>
                                    </div>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-android-social-user"></i>
                                </div>
                               {{HTML::link(URL::route('viewers_list'),'More info...',array("class"=>"small-box-footer"))}}  
                            </div>
                        </div><!-- ./col -->
                        
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>
                                         @if($result = Campaign::getMultipleViews()) 
											{{ @count($result); }}
										@else
											{{ "0" }}
                                        @endif
                                    </h3>
                                    <p>
                                        Multiple Views
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-android-friends"></i>
                                </div>
                               {{HTML::link(URL::route('mviewers_list'),'More info...',array("class"=>"small-box-footer"))}}  
                            </div>
                        </div><!-- ./col -->
                        
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-orange">
                                <div class="row inner">
                                    <div class="col-lg-6 col-xs-6">
                                         <h3>
											 
											 @if($result = Helpers::getTotalInvestorBid(session::get('account_id'), true))
												 <?php $total=0; $tCount = count($result); $i=0; count($result) ?>
												@for($i=0;$i<$tCount;$i++)
													{{ $result[$i]->count }}
												@endfor
											@else
												{{ "0" }}
											@endif
										</h3>
										<p>
											Ongoing Bids
										</p>
                                    </div>
									<div class="col-lg-6 col-xs-6">
                                         <h3>
											 @if($result = Helpers::getTotalInvestorBid(session::get('account_id')))
												 {{ $result->count(); }}
											@else
												{{ "0" }}
											@endif
											
										</h3>
										<p>
											Total Bids
										</p>
                                    </div>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-ios7-briefcase"></i>
                                </div>
                               {{HTML::link('bid','More info...',array("class"=>"small-box-footer"))}}  
                            </div>
                        </div><!-- ./col -->
                        
                        
                                                
          
                        
<!--                        <div class="col-lg-3 col-xs-6">
                             small box 
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>
                                        <?php //echo Helpers::getTotalSubscriptions(); ?>
                                    </h3>
                                    <p>
                                       Newsletter Subscriptions
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                               {{HTML::link(URL::route('campaigns_list'),'More info...',array("class"=>"small-box-footer"))}}  
                            </div>
                        </div> ./col -->
                    </div><!-- /.row -->
                    
                    
@elseif(Session::get('account_type')=='INVESTOR')
			<div class="row">
				
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-orange">
                                <div class="row inner">
                                    <div class="col-lg-6 col-xs-6">
                                         <h3>
											 
											 @if($result = Helpers::getTotalInvestorBid(session::get('account_id'), true))
												 <?php $total=0; $tCount = count($result); $i=0; count($result) ?>
												@for($i=0;$i<$tCount;$i++)
													{{ $result[$i]->count }}
												@endfor
											@else
												{{ "0" }}
											@endif
										</h3>
										<p>
											Active Bids
										</p>
                                    </div>
									<div class="col-lg-6 col-xs-6">
                                         <h3>
											 @if($result = Helpers::getTotalInvestorBid(session::get('account_id')))
												 {{ $result->count(); }}
											@else
												{{ "0" }}
											@endif
											
										</h3>
										<p>
											Total Bids
										</p>
                                    </div>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-ios7-briefcase"></i>
                                </div>
                               {{HTML::link('bid','More info...',array("class"=>"small-box-footer"))}}  
                            </div>
                        </div><!-- ./col -->
                        
				<!-- Small boxes (Stat box) -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>
                                        <?=Helpers::getTotalCampaigns('', 'Ongoing')?>
                                    </h3>
                                    <p>
                                        Ongoing Campaigns
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-ios7-speedometer"></i>
                                </div>
                                {{HTML::link(URL::route('cgrid_list', 'ongoing'),'More info...',array("class"=>"small-box-footer"))}}                     
                            </div>
                        </div><!-- ./col -->
                        
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-purple">
                                <div class="inner">
                                    <h3>
                                         <?=Helpers::getTotalClosedCampaigns(null, 'Closed')?>
                                    </h3>
                                    <p>
                                        Closed Campaigns
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-ios7-locked"></i>
                                </div>
                               {{HTML::link(URL::route('cgrid_list', 'closed'),'More info...',array("class"=>"small-box-footer"))}}  
                            </div>
                        </div><!-- ./col -->
                      <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-olive">
                                <div class="row inner">
                                    <div class="col-lg-6 col-xs-6">
                                         <?php $campaigns = Campaign::getMyViews();
                                         $count = 0;
												foreach($campaigns as $c){
													//var_dump($c->no_of_views);
													$count += $c->no_of_views;
												}
												echo "<h3>".$count . " </h3>";
                                         
                                         ?>
                                         <p> Total Views</p>
                                    </div>
									<div class="col-lg-6 col-xs-6">
                                         <?php $campaigns = Campaign::getMyViews('today');
                                         $count = 0;
												foreach($campaigns as $c){
													$count += $c->no_of_views;
												}
												echo "<h3>".$count . " </h3>";
                                         
                                         ?>
                                         <p> Today </p>
                                    </div>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-android-friends"></i>
                                </div>
                               {{HTML::link(URL::route('viewers_list'),'More info...',array("class"=>"small-box-footer"))}}  
                            </div>
                        </div><!-- ./col -->  
                        
                        
                        
                        <!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>
                                        @if($result = Helpers::getTotalInvestorBid(session::get('account_id'), true))
												 
													{{ number_format($result[0]->amount, 2) }}
											@else
												{{ number_format(0, 2) }}
											@endif
                                    </h3>
                                    <p>
                                        Active Investments
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-cash"></i>
                                </div>
                                {{HTML::link("wallet","View Statement... ",array("class"=>"small-box-footer "))}}
                                </a>
                            </div>
                        </div>
                        
                        <!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>
                                        @if($result = Helpers::getTotalInvestorBid(session::get('account_id')))
												 
													{{ number_format($result->sum('amount'), 2) }}
											@else
												{{ number_format(0, 2) }}
											@endif
                                    </h3>
                                    <p>
                                        Total Investments
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-cash"></i>
                                </div>
                                {{HTML::link("wallet","View Statement... ",array("class"=>"small-box-footer "))}}
                                </a>
                            </div>
                        </div>
                        
                        <!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3>
                                        @if($result = Helpers::investorBalance(session::get('account_id'))) 
											{{ number_format($result,2) }}
										@else
											{{ number_format(0,2) }}
                                        @endif
                                    </h3>
                                    <p>
                                        Account Balance
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-cash"></i>
                                </div>
                                {{HTML::link("wallet","View Statement... ",array("class"=>"small-box-footer "))}}
                                    
                                </a>
                            </div>
                        </div>
                        
                        
                        
<!--                        <div class="col-lg-3 col-xs-6">
                             small box 
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>
                                        <?//=Helpers::getTotalSubscriptions()?>
                                    </h3>
                                    <p>
                                       Newsletter Subscriptions
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div> ./col -->
                    </div><!-- /.row -->
@endif
                </section><!-- /.content -->
    @stop
