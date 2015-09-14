<?php include 'common/header.php'; ?>
<div class="videoContainerA" style="position: relative">
 
    <video id="myVideo" height="50%" width="100%" poster= "<?php echo url(); ?>/media/img/81.png" style="/*margin-top: 50px;*/" src="<?php echo url(); ?>/media/video/videoxx.mp4"  controls>
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
<center><h1 style="color: #57A0C9; font-size: 40px; font-family: 'Kirvy-regular'; clear: both;">Over <b>KES 32,900, 988</b> Raised</h1></center>


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

    <div class="row center-block" style=" width: 1000px;  text-align: center; margin: 0 auto; padding-top: 20px; padding-bottom: 20px;">
       

             <!--<div class='temp_one_index_campaign_holder_DD' >
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
        $recent_campaigns = Campaign::get_recent_campaigns(3);

        //dd($recent_campaigns);

        foreach ($recent_campaigns as $item) {
            $image_name = $item->promotional_logo;
            $percentage_share_completion = ($item->share_bought * 100) / $item->no_of_shares;

            //echo $percentage_share_completion; exit;
            ?>

            <div class='temp_one_index_campaign_holder' style="height: auto !important;">
                <img src='<?php echo url() . "/_image/_Profile_pix/$image_name"; ?>' height="180px" width='100%' />
                <div class="" >
                    <div class="panel-body" style='height: 100px;'>
                        <div style="color: #57A0C9;">
                            <h4>Coming soon..</h4>
                            <!--<div class="progress">
                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percentage_share_completion; ?>%;">
                                    <span class="sr-only"><?php echo $percentage_share_completion; ?>% Complete</span>
                                </div>
                            </div>-->
                        </div>
                    </div>
                   <!-- <div class="panel-footer" style='height: 100px;'>
                        <h5><?php echo number_format($item->no_of_shares); ?> Shares </h5>
                        <h6><?php echo number_format($item->no_of_shares - $item->share_bought); ?> Remaining |  Days Remaining</h6>
                    </div>-->
                </div>                    
            </div>

        <?php } ?>



        <div style="clear: both;"></div>
        <ul class="pagination pagination-lg">
            <li><a href="#">&laquo;</a></li>
            <li><a href="#">&raquo;</a></li>
        </ul>

    </div>
</div>

<div class="video_spacer"></div> 






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
                            







                            
                            
                            
                            
                            
                            
                            
                            
                            
