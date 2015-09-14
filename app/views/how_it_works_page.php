                                                                                                                                <style type="text/css">
    body { display: block; }
    p.alert:target { display: none; }


#button ul {
    list-style: none;
    margin: 0;
    padding: 0;
    border: none;
}
    
#button li {
    border-bottom: 0px solid #90bade;
    margin: 0;
    list-style: none;
    list-style-image: none;
}
    
#button li a {
    display: block;
    padding: 5px 5px 5px 0.5em;
    border-left: 10px solid rgba(16, 29, 32, 0.06);
    border-bottom:  #90bade thin solid;
    background-color: #ecf0f1;
    color: #529FC7;
    text-decoration: none;
    width: 100%;
}
#button a:link {display: block; width: 240px; height: 29px; padding: 10px;   font-weight: bold;color: #529FC7;  text-decoration: none;}
#button a:visited  {display: block; width: 240px; height: 29px; padding: 10px;   font-weight: bold;color: #333333;  text-decoration: none;}  
    
/*html>body #button li a {
    width: 90%;
}*/

#button li a:hover {
   /* border-left: 10px solid #ecf0f1;
    border-right: 10px solid #ecf0f1;*/
    background-color: #898989;
    color: #FCE36C;
}
</style>

<?php include 'common/header.php'; ?>
<div>



    <div class="row" style='width: 90%; margin: 0 auto; margin-top: 30px;  '>


        <div class="row">

            <div class="col-sm-12 blog-main">

                <div class="blog-post">



                    <div class="panel panel-default">
                        <div class="panel-heading">

                          

                            <div class="blog-header">
                                <h1 class="blog-title">How it works</h1>

                            </div>
                        </div>
                        <div class="panel-body">


                            <!--  <div class="row featured_campaign_holder_C"> -->

                            <div class="row center-block" style=" width: 100%;  text-align: center; margin: 0 auto; padding-top: 10px; padding-bottom: 10px;"> 


                                <div class='temp_one_index_campaign_holder_E' style="margin-left: 290px;">
                                    <img src='<?php echo url() . "/media/images/investor2.jpg"; ?>' height="100px" width='140px' style="padding-top: 1px;" />
                                    <div class="">
                                        <div class="panel-body" style='height: 50px;'>
                                            <div>
                                                <a href='<?= route("campaigns"); ?>' style="font-size:30px;font-family: 'Kirvy-regular'"> <b>Investor </b></a>

                                            </div>
                                        </div>
                                        <div class="panel-footer" style='height: 250px;'>

                                            <p>MradiFund makes it easy for you to discover viable enterprises that are looking for expansion capital, make investments in the ones you like and keep track of the investments you have made, all through a straightforward online platform.</p> <br />
                                            
                                            <a class="btn btn-success htw" href="#invest_mradi" id="investing_mradi_btn" role="button" id="example-show"  class="alert">View more..</a>


                                        </div>
                                    </div>                    
                                </div>
                                <div class='temp_one_index_campaign_holder_E'>
                                    <img src='<?php echo url() . "/media/images/entre2.jpg"; ?>' height="100px" width='140px' style="padding-top: 1px;"/>
                                    <div >
                                        <div class="panel-body" style='height: 50px;'>
                                            <div>
                                                <a href='<?= route("join"); ?>' style="font-size:30px;font-family: 'Kirvy-regular'"> <b>Entrepreneur</b></a>

                                            </div>
                                        </div>
                                        <div class="panel-footer" style='height: 250px;'>
                                            <p>MradiFund provides a cheap and efficient way to raise funds for expansion from a large pool of investors. The platform allows you to have a snapshot view of your pitches progress and keep your potential investors in the loop as you continue to grow your business. </p> 
                                            <a class="btn btn-success htw" href="#ent_mradi" id="ent_mradi_btn" role="button" style="visibility: visible;">View more..</a>


                                        </div>
                                    </div>                    
                                </div>


                            </div>
                            <!-- </div>-->



                        </div>
                    </div>
                </div>





            </div><!-- /.blog-main -->
            <a id="invest_mradi">&nbsp;</a>
            <div id="investing_mradi" style="display: none">
                <div class="verticalslider" id="textExample" style="width: 100% !important; height: 800px !important; ">
                    <ul class="verticalslider_tabs" >
                        <li class="activeTab"><a href="#">Investing with MradiFund</a></li>
                        <li><a href="#">Why Invest in SMEs? </a></li>  
                        <li><a href="#">What to look for in SMEs?</a></li>
                        <li><a href="#">Rights & Protections</a></li>
                    </ul>
                    <ul class="verticalslider_contents">

                        <div class="row featured_campaign_holder_C" style="background-color: #ffffff !important;">

                            <div class="row center-block" style=" width: 900px;  text-align: center; margin: 0 auto; padding-top: 10px; padding-bottom: 10px;">
                                <text align="left">  <p> All the businesses listed on the platform go through a verification process to make sure that what they say on their pitch  is clear <br/> and not misleading. Your input, judgment and research are important, but you can rest assured that we are checking things too. 
                                <br/>
                                </p></text>
                                 <br/>  
                                <div class='temp_one_index_campaign_holder_C'><div class="box" style="background: url('<?php echo url() . "/media/images/Discover.gif"; ?>') no-repeat; background-size:100% 190px;height:190px;width:100%">
                                   
                                    <a href="#">
                                    <div class="overlay" style='color: #000;'>                                              
                                        <b> <p> <align="center"> Register onto the investors network on MradiFund and browse all the investments that meet your criteria.
                                            </align>  </p></b>
                                    </div></a>
                                    </div> <div style="z-index:100">
                                                <b>Discover</b>
                                                
                                            </div>                 
                                </div>
                                <div class='temp_one_index_campaign_holder_C'><div class="box" style="background: url('<?php echo url() . "/media/images/bidding.jpg"; ?>') no-repeat; background-size:100% 190px;height:190px;width:100%">
                                   
                                    <a href="#">
                                    <div class="overlay" style='color: #000;'>                                              
                                        <b>  <p>As low as KES 100,000 in any investment you choice, confident that you will receive your money back if the target amount is not reached.</p></b>
                                    </div></a>
                                    </div> <div>
                                                 <b>Bid </b>

                                            </div>               
                                </div>
                                <div class='temp_one_index_campaign_holder_C' style="padding-left: 10px;"><div class="box" style="background: url('<?php echo url() . "/media/images/Agreement.gif"; ?>') no-repeat; background-size:100% 190px;height:190px;width:100%">
                                   
                                    <a href="#">
                                    <div class="overlay" style='color: #000;'>                                              
                                        <b>     <p>Receive a shareholders agreement that explicitly states your ownership terms and rights and own part of a company you believe in.</p>		</b>				  

                                    </div></a>
                                    </div> <div>
                                                 <b>Own</b>

                                            </div>               
                                </div> </div>
                        </div>



                        <li style="width:70%;">                                          
                            <!--<h2>Why Invest in SMEs?</h2> -->

                            <br />
                            <b>1.They can be extremely profitable.</b> <br />
                            <p>Returns from investments in growing businesses have historically produced significantly higher results.Although 
                                most growing businesses eventually fail, the few that succeed bring up the earnings of the entire asset class. 
                                Therefore, with proper diversification, it is possible to keep your capital growing significantly more than in 
                                other investment channels such as fixed income and bonds. </p> <hr width="100%" style="float:left; padding-right: 0px;"  />	<br />
                            <b>2.It gives you a chance to be a part of 'the next big thing' </b>
                            <p>You can browse through thousands of viable businesses and choose to be a part of those with potential 
                                to be game changers while they are still growing. Imagine being one of the first investors in Facebook 5 years ago!
                            </p>
                            <hr width="100%" style="float:left; padding-right: 0px;"  />	<br />			


                            <b>3.You get to be a part of innovation and economic growth.</b> <br />
                            <p>By supporting growing businesses through the platform, you are allowing them the  
                                opportunity to keep innovating, providing jobs, developing solutions that help others and contribute to the economy. This is a feel good factor other traditional investments lack. 
                            </p>
                            <hr width="100%" style="float:left; padding-right: 0px;"  />	<br />

                            <b>4.You can support your family and friends in a structured, professional setting.</b> <br />
                            <p>MradiFund gives you a platform to invest in friends and family with great business ideas using the 
                                right  professional and legal channels.  It saves you all the hassle that comes with lending money to 
                                family and friends the 'jua kali' way. </p>
                        </li>

                        <li style="width:70%;"> 
                            <br />
                            Although all the businesses on MradiFund are vetted and verified, there are still a few factors investors should<br/> consider when picking a venture to back.<br /> 
                            <br /> <img src='<?php echo url() . "/media/images/theidea.jpg"; ?>' style="height:200px;"   align="left" /> <b> &nbsp; &nbsp; 1.The Idea </b>
                            <p> &nbsp; &nbsp;As an investor, you should pick projects with ideas and concepts you understand <br /> &nbsp; &nbsp;and are passionate about.It is difficult to help a business grow if you know nothing<br /> &nbsp; &nbspabout it. </p>  <br clear="ALL"/>               
                        <br /><u><b>2.The Team</b></u>
                        <p>A great idea could fail if it is being executed by the wrong people.  
                            The management team in place should be<br /> experienced in their role, 
                            passionate about the company and dedicated to propelling their <br  /><br  />business.
                            &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<img src='<?php echo url() . "/media/images/teamA.jpg"; ?>' style="height:200px; width:600px;"   align="middle" />  </p>
                        <br clear="ALL"/>
                        
                        
                        
                        <u><b>3.The Plan</b></u>
                        <br  />
                        <img src='<?php echo url() . "/media/images/register-icon.png"; ?>' style="height:200px; padding-right: 190px; "   align="right" /> <br  />
                        <p>Do the business owners have a good plan going forward? Are they being innovative in their expansion? <br /> Do you agree with the direction they want to take?  <br clear="ALL"/>
                        </p>
                        </li>

                        <li> <p> Coming soon... </p></li>
                    </ul>
                </div> 
            </div>
            
            
            
            <a id="ent_mradi">&nbsp;</a>
            <div id="entre_mradi" style="display: none">
                <div class="verticalslider" id="textExample2" style="width: 100% !important; ">
                    <ul class="verticalslider_tabs">
                        <li class="activeTab"><a href="#">Raising Funds</a></li>
                        <li><a href="#">Why Use MradiFund?</a></li>  
                        <li><a href="#L1">Succeed in Crowdfunding</a></li>
                        <li><a href="#">Rights & Protections</a></li>
                        <li><a href="#">Fees</a></li>
                    </ul>	

                    <ul class="verticalslider_contents">

                        
                        
                        <div class="row featured_campaign_holder_C" style="background-color: #ffffff !important;">
                            
                            <div class="row center-block" style=" width: 900px;  text-align: center; margin: 0 auto; padding-top: 10px; padding-bottom: 10px;">
                            <text align="left"> <p>MradiFund allows you to save time that would otherwise be spent away from your business by providing the tools to produce and market one polished and effective pitch that all your potential investors can view online.<br/></p> </text><br/>
                                <div class='temp_one_index_campaign_holder_C'><div class="box" style="background: url('<?php echo url() . "/media/images/YES-register-YP.png"; ?>') no-repeat; background-size:100% 190px;height:190px;width:90%">
                                   
                                    <a href="#">
                                    <div class="overlay" style='color: #000;'>                                              
                                        <b>  <p>Register onto the entrepreneurs' network on MradiFund and use the platform to reach potential investors
                                                    </p></b>
                                    </div></a>
                                    </div> <div>
                                                <b>Register</b> <br />
                                                
                                            </div>                
                                </div>
                                    
                                <div class='temp_one_index_campaign_holder_C'><div class="box" style="background: url('<?php echo url() . "/media/images/salespitchvideo.jpg"; ?>') no-repeat; background-size:100% 190px;height:190px;width:100%">
                                   
                                    <a href="#">
                                    <div class="overlay" style='color: #000;'>                                              
                                        <b>  <p>Use templates provided by MradiFund to create an effective and interactive fundraising campaign which you can use to attract investors
                                                        </p></b>
                                    </div></a>
                                    </div> <div>
                                                 <b>Create your pitch  </b>

                                            </div>               
                                </div>
                            
                                <div class='temp_one_index_campaign_holder_C' style="padding-left: 10px;"><div class="box" style="background: url('<?php echo url() . "/media/images/closedeal.jpg"; ?>') no-repeat; background-size:100% 190px;height:190px;width:100%">
                                   
                                    <a href="#">
                                    <div class="overlay" style='color: #000;'>                                              
                                        <b> <p> Reach out to investors within the MradiFund network and on social media to hit your funding target. Close the deal with one of our legal partners
                                                </p></b>
                                    </div></a>
                                    </div> <div>
                                               <b>Close the Deal</b>

                                            </div>               
                                </div>
                                
                            </div>
                        </div>
                        
                        
                        
                        
                        <li style="width:70%;"> 
                                <b>1.Easy to Use Profile Builder</b>
                                <p>Mradifund has an easy to use template to build a comprehensive and compelling pitch that can be used to fundraise. 
                                    This allows you to direct all potential investors to the same pitch deck regardless of where they are in the world. 
                                    Additionally, you can leverage your own social network as well as that of MradiFund.<p> 
                                    <hr width="100%" style="float:left; padding-right: 0px;"  />	<br />	
                                <b>2.Added validation of the business</b>
                                <p>Once your business is successfully funded through MradiFund, it automatically means you have acquired support of
                                    paying customers and future brand ambassadors & mentors. If you can manage to get several people to give you
                                    monetary backing, you must have something good, right? </p>
                                <hr width="100%" style="float:left; padding-right: 0px;"  />	<br />	
                                <b>3.Cheaper, faster and more efficient</b>
                                <p>Fundraising through MradiFund costs much less than going to a bank or a traditional venture capital fund for expansion
                                    capital. If you do your planning well, it also takes a shorter time. Lastly, since everything is consolidated to one platform, 
                                    the hassle of coordinating several investors is reduced significantly. </p>
                                <hr width="100%" style="float:left; padding-right: 0px;"  />	<br />	
                                <b>4.Future Fundraising</b>
                                <p>MradiFund allows you to start building a track record through investor comments and a fundraising history. Once you are 
                                    successfully funded, it gets easier to raise additional funds in the future should you need them. </p>
                            
                        </li>

                        <li style="width :70%;"> 
                            <p>How to Succeed in Crowd Funding ..Coming soon</p>  <br/>
                            <hr width="62%" style="float:left; padding-right: 0px;"  />	<br />									
                        </li>


                        <li style="width :70%;"> 
                            <p>Rights and Protection ..Coming soon</p>  <br/>
                            <hr width="62%" style="float:left; padding-right: 0px;"  />	<br />	   
                        </li>



                        <li style="width :70%;"> 
                            <p>Fees ..Coming soon</p>  <br/>
                            <hr width="62%" style="float:left; padding-right: 0px;"  />	<br />	 
                        </li>



                    </ul>                                        		
                </div> 
            </div>


        </div>

    </div>


    <?php include 'common/footer.php'; ?>
                           
                            
                            
                            
                            