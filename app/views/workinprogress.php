<?php include 'common/header.php'; ?>
<div>



    <div class="row" style='width: 1000px; margin: 0 auto; margin-top: 30px;'>


        <div class="row">

            <div class="col-sm-12 blog-main">

                <div class="blog-post">
                    <div class="panel panel-default" style="text-align: center !important;">
                     <?php
                        $countries = Helper::get_all_countries();
                       /* foreach($countries as $col)
                        { 
                            echo $col->id."-".$col->code;
                        }  */    
                        //print_r($countries);
                     ?>
                        
                        <img src="<?php echo url(); ?>/media/images/develop.png"/>
                    </div>
                </div>

            </div><!-- /.blog-main -->

            <div class="col-sm-2 col-sm-offset-1 blog-sidebar">
               

        </div><!-- /.row -->


    </div>

</div>


<?php include 'common/footer.php'; ?>