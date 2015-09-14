<?php include 'common/headerC.php'; ?>

<div class="videoContainer" style="position: relative">    
    <video id="myVideo" height="66%" width="100%"  poster= "<?php echo url(); ?>/media/img/81.png" src="<?php echo url(); ?>/media/video/videoxx.mp4" style="margin-top: 0px;" controls>
        Your browser does not support the  element.   
    </video>
    
</div>
<div class="subscribe"><center><span class="sub-span">Subscribe</span><div class="subscribe-show" style="z-index:2"><div class="input-group">
                
                <input type="text" name="subscribers_email" class="form-control" placeholder="Email Address" style="height:30px;">               
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit" style="height:30px; padding-top: 1px">Subscribe Newsletter</button>
                </span>
                
            </div></div></center></div>

<div class="video_spacer"></div>
<div id="sticky-anchor"></div>
<?php include 'common/headerB.php'; ?>


<center><h1 style="color: #57A0C9; font-size: 40px; font-family: 'Kirvy-regular'; clear: both;">Over <b>KES <?= number_format(Helpers::getTotalInvestorBid("guest")->sum('Amount'), 2); ?></b> Raised</h1></center>


<!--<div style='height: 720px;'></div> -->
<div style="width: 100%; clear: both; background: url('<?php echo url(); ?>/media/img/xcx.jpg') no-repeat; padding: 20px; margin-top: 30px">   
    <div class="jumbotron center-block" style='border-top: 1px #ccc solid; clear: both; width: 70%; background-color: #96864C; background-color: rgba(252, 228, 106, 0.8); padding: 20px;  margin-top: 30px;'>
        <h3 style='color: #fff;' class="mradi_header">Mradifund</h3>
        <p class="lead" style='font-size: 1.1em;  color: #000000; '>
            <span style=""><b>Mradifund is an online fundraising platform. We connect small business owners with investors who provide the expansion
                    capital and mentorship they need to get to the next level. <br />At the same time, we give investors an opportunity to hand pick  
                    small companies to privately invest it, allowing them to diversify their portfolios and find the next big thing before it 
                    blows up, all while helping small businesses grow. </b>
                <p><a class="btn btn-success" href='<?php route('login'); ?>' role="button">Start a Campaign</a>  <a class="btn btn-success" href='<?php route('login'); ?>' role="button">Fund a Campaign</a></p>
    </div>
</div>


<!--<div style="width: 100%; clear: both; background-color: #dbdbdb; padding: 5px; text-align: center;">   
    <h4 style="color: #333;">Explore and fund great projects</h4>
</div> -->
<div class="video_spacer"></div> 






<div class="row featured_campaign_holder_D">

    <div class="row center-block" style=" width: 1000px;  text-align: center; margin: 0 auto; padding-top: 10px; padding-bottom: 10px;">
         <!--<div class='temp_one_index_campaign_holder_D'>
                 <img src='<?php echo url() . "/media/images/images1.jpg"; ?>' height="180px" width='100%' />
                <div >
                    <div class="panel-body" style='height: 50px;'>
                        <div>
                           <a href='<?= route("login"); ?>'> <b>Invest</b></a>
                             
                            
                            
                        </div>
                    </div>
                    <div class="panel-footer" style='height: 100px;'>
                        
                        <p>Be involved in the next big thing! <br />Start by helping a brother out.</p>
                        
                    </div>
                </div>                    
            </div>-->
        
         <div class='temp_one_index_campaign_holder_D' style="margin-left: 200px !important;">
                <img src='<?php echo url() . "/media/images/download3.jpg"; ?>' height="180px" width='100%' />
                <div >
                    <div class="panel-body" style='height: 50px;'>
                        <div>
                            <a href='<?= route("join"); ?>'> <b>Raise Funds</b></a>
                            
                        </div>
                    </div>
                    <div class="panel-footer" style='height: 130px;'>
                        <p>Invite your friends, family and the crowd to invest in your campaigns.<br /> Lure in the investors by giving them what they want.</p>
                        
                        
                    </div>
                </div>                    
            </div>

            <div class='temp_one_index_campaign_holder_D'>
                <img src='<?php echo url() . "/media/images/images.jpg"; ?>' height="180px" width='100%' />
                <div class="">
                    <div class="panel-body" style='height: 50px;'>
                        <div>
                            <a href='<?= route("campaigns"); ?>'> <b>Discover Campaign </b></a>
                            
                        </div>
                    </div>
                    <div class="panel-footer" style='height: 130px;'>
                        
                        <p>Explore our list of campaigns and get inspired, <br /> learn more and choose to make a difference.</p>
                        
                    </div>
                </div>                    
            </div>
 </div>
</div>


<div class="video_spacer"></div> 
<center><h1 style="color: #57A0C9; font-size: 40px; font-family: 'Kirvy-regular'; clear: both;">...Explore great projects</h1></center>

<!-- <div class="center-block" style=" color: rgb(108, 194, 200); font-size: 40px; font-family: 'Kirvy-regular'; margin-top: 70px; text-align: center;">
    <h2 class="bold_header">Featured Campaigns</h2>
</div> -->


<div class="row featured_campaign_holder">

    <div class="row center-block" style=" width: 1000px;  text-align: center; margin: 0 auto;">
        <?php
        $recent_campaigns = Campaign::get_campaigns("guest"); //$recent_campaigns = Campaign::get_recent_campaigns(3);

        //dd($recent_campaigns);

        foreach ($recent_campaigns as $item) {
             //total amount bidded
				$myBid = Helpers::getTotalBidded($item->uniqueid);
				$totalBid = $myBid ? $myBid->total_bidded : '0';
				//campaign value
				$investment = Helpers::getTotalInvestment($item->uniqueid);
				$campaignValue = $investment ? $investment[0]->total_investment : 0;

                //$percentage_share_completion = ($item->share_bought * 100) / $item->no_of_shares;
                $percentage_share_completion = ($totalBid * 100) / $campaignValue;

            //echo $percentage_share_completion; exit;
            ?>

            <div class='temp_one_index_campaign_holder' style="height: auto !important;">
                <?php
						$file = Helpers::getUploadedFileDetails($item->listing_logo);
						if (empty($file)){
							$image = 'no-image.png';
						}else{
							$image = $file[0]->file_alias;
						}
							
						echo HTML::image("/assets/$image", $item->campaigname . ' campaign logo', array("height" => "180px", "width" => "100%"));
					?>
                <div class="" >
                    <div class="panel-body" style='height: 100px;'>
                        <div style="color: #57A0C9;">
                            <h4><?php echo $item->campaigname; ?></h4>
                            <div class="progress">
                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percentage_share_completion; ?>%;">
                                    <span class="sr-only"><?php echo $percentage_share_completion; ?>% Complete</span>
                                </div>
                            </div><!---->
                        </div>
                    </div>
                    <div class="panel-footer" style='height: 130px;'>
							<h5>Total Value <?php echo number_format($campaignValue,2); ?> </h5>

                            <h5>Invested <?php echo number_format($totalBid,2); ?> </h5>

                            <h5>Remaining <?php echo number_format(($campaignValue - $totalBid),2); ?> </h5>
                            
                            <h5> <a>
								<?php echo HTML::linkRoute('cdetails.view','View Details',$item->id, ['data-toggle'=>'modal','data-target'=>'#myModal']); ?> </a> 
							</h5>

                        </div><!---->
                </div>                    
            </div>

        <?php } ?>



        <div style="clear: both;"></div>
       <?php echo $recent_campaigns->links(); ?> 

    </div>
</div>

<div class="video_spacer"></div> 

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        </div><!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->




<div class="row" style='width: 80%; margin: 0 auto; margin-top: 0px;'>
    <center>
        <div><hr /></div>
        <!-- <div class="video_spacer"></div> -->
        <center><h1 style="color: #57A0C9; font-size: 40px; font-family: 'Kirvy-regular'; clear: both;">...Our Esteemed Partners</h1></center>

        <img src="<?php echo url(); ?>/media/img/partners/logo_list_01.png" />
        <img src="<?php echo url(); ?>/media/img/partners/logo_list_02.png" />
        <img src="<?php echo url(); ?>/media/img/partners/logo_list_03.png" />
        <img src="<?php echo url(); ?>/media/img/partners/1.jpg" />
        <div><hr /></div>
    </center>
</div>


<div class="video_spacer"></div> 
<center><h1 style="color: #57A0C9; font-size: 30px; font-family: 'Kirvy-regular'; clear: both;">Create the world you want! Connect to your future!</h1></center>



<?php include 'common/footer.php'; ?>
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
