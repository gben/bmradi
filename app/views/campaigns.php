 <?php include 'common/header.php'; ?>
<div class="row center-block" style="width: 80%; margin-top: 30px; clear: both;">

    <div class="col-lg-12">


        <div class="input-group">

            <input type="text" class="form-control" placeholder="search...">

            <span class="input-group-btn">

                <button class="btn btn-success" type="button">Search Campaign</button>

            </span>

        </div><!-- /input-group -->

    </div><!-- /.col-lg-6 -->

</div><!-- /.col-lg-6 -->





<div class="row" style='width: 80%; margin: 0 auto; margin-top: 30px;'>



    <div class="col-md-3">

        <div class="list-group">

            <a href="#" class="list-group-item active">Recent</a>

            <?php

				$categories = Helpers::get_all_categories();

				foreach ($categories as $category_item) {

					echo '<a href="#" class="list-group-item">' . $category_item->title . '</a>';

				}

            ?>

        </div>

    </div>

	

    <div class="col-md-9">



        <div class="row" style='width: 800px; margin: 0 auto;'>



            <?php

            $recent_campaigns = Campaign::get_campaigns("guest"); //Campaign::get_recent_campaigns();



            //dd($recent_campaigns);



            foreach ($recent_campaigns as $item) {

                $image_name = $item->listing_logo; //promotional_logo;
                
                //total amount bidded
				$myBid = Helpers::getTotalBidded($item->uniqueid);
				$totalBid = $myBid ? $myBid->total_bidded : '0';
				//campaign value
				$investment = Helpers::getTotalInvestment($item->uniqueid);
				$campaignValue = $investment ? $investment[0]->total_investment : 0;

                //$percentage_share_completion = ($item->share_bought * 100) / $item->no_of_shares;
                $percentage_share_completion = ($totalBid * 100) / $campaignValue;



                //echo $percentage_share_completion; //exit;

                ?>

                <div class='campaign_holder campaign_holder' style="height: auto !important;">
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
                                        <span class="sr-only" style="position:inherit;"><?php echo $percentage_share_completion; ?>% Complete</span>

                                    </div>

                                </div> <!---->

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



            <span class='center-block' style='clear: both; margin: 0 auto; width: 40%;'  >



                <button class='btn btn-success' style='margin: 30px;'>See More...</button>

            </span>

        </div>

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

    <div style="clear: both;"></div>

</div>



</div>





<?php include 'common/footer.php'; ?>
                            
