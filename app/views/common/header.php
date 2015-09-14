<!DOCTYPE html>
<html>
    <head>
        <title>Mradifund</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?php echo url(); ?>/media/css/verticaltabs.css" rel="stylesheet"/>
        <link href="<?php echo url(); ?>/media/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="<?php echo url(); ?>/media/css/mradi_layout.css" rel="stylesheet" media="screen">
        <link href="<?php echo url(); ?>/media/css/jquery-ui-1.10.2.custom.css" rel="stylesheet" media="screen">
        
        <style>
            @import url('<?php echo url(); ?>/media/fonts/Kirvy-Regular.css');
            @import url('<?php echo url(); ?>/media/fonts/Kirvy-Bold.css');
            @import url('<?php echo url(); ?>/media/fonts/Kirvy-Thin.css');
            @import url('<?php echo url(); ?>/media/fonts/Kirvy-Light.css');
        #logo-div
            {
                background: url('<?php echo url(); ?>/media/img/logo.jpg') no-repeat ;
            }
        </style>
    </head>
    <body>
        <div id="header">
            <div id="logo-div" style="width:80%; margin: auto;height:100%">
        <div class='row center-block' style="width: 100%;"> 
            <span class='login_holder'>
     
                <a href='<?= route('login'); ?>'> <span class="glyphicon glyphicon-log-in"></span> Login</a> | <a href='<?= route('join'); ?>'>Join Us</a> 
       
            </span><br />
                <span class='login_holder'>                  <div class="row center-block" style='width: 30%;  margin: 0 auto; margin-top: 65px; margin-left: 30px;'>

    <div class="row center-block" style="width: 630px;">
        <div class="col-lg-12">
            <?php echo Form::open(array('route' => 'subscribe')); ?>
            <div class="input-group" style="z-index:2">
                
                <input type="text" name="subscribers_email" class="form-control" placeholder="Email Address" style="height:30px;"/>               
                <span class="input-group-btn" >
                    <button class="btn btn-default" type="submit" style="height:30px; padding-top: 1px">Subscribe for updates</button>
                </span>
                
            </div><!-- /input-group -->
            <?php echo Form::close(); ?>
        </div><!-- /.col-lg-6 -->
    </div><!-- /.col-lg-6 -->
</div> </span>
             
            <hr width="57%" style="float:right; padding-right: 0px; margin-left: 0%;"/>
        </div>
        
        
            <div class="row" style="width: 100%; margin: 0 auto;">
                <div class="navbar-header">
                    <!--<img src='<?php echo url(); ?>/media/img/logo.jpg'>-->               </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a class="navbar-brand" href="#"></a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right" style="font-size: 16px;">
                        <li><?= link_to('/', 'Home'); ?></li>
                        <li><?= link_to('/about', 'About Mradi'); ?></li>
                        <li><?= link_to('/howitworks', 'How It works'); ?></li>
                        <li><?= link_to('/campaigns', 'Campaigns'); ?></li>
                        <li><?= link_to('/blog', 'Blog'); ?></li>
                        <li><?= link_to('/contact_us', 'Contact Us'); ?></li> <br />
             
                    </ul>
                    
                </div> <!--/.nav-collapse -->
    
            </div></div>
        </div>

                            
                            
                            
                            