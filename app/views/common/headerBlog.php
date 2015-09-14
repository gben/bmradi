<!DOCTYPE html>
<html>
    <head>
        <title>Mradifund</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?php echo url(); ?>/media/css/verticaltabs.css" rel="stylesheet"/>
        <link href="<?php echo url(); ?>/media/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="<?php echo url(); ?>/media/css/mradi_layout.css" rel="stylesheet" media="screen">
        
        <style>
            @import url('<?php echo url(); ?>/media/fonts/Kirvy-Regular.css');
            @import url('<?php echo url(); ?>/media/fonts/Kirvy-Bold.css');
            @import url('<?php echo url(); ?>/media/fonts/Kirvy-Thin.css');
            @import url('<?php echo url(); ?>/media/fonts/Kirvy-Light.css');
        </style>
    </head>
    <body>
        
        
        
        <div id="headerl" style="border-bottom: 5px solid #ffe366;">
<div class='row center-block' style="width: 80%;"> 
            <span class='login_holder'>                       
                
                <a href='<?= route('login'); ?>'> <span class="glyphicon glyphicon-log-in"></span> Login</a> | <a href='<?= route('join'); ?>'>Join Us</a>
            </span><br />
            <hr/>
        </div>
            <div class="row" style="width: 80%; margin: 0 auto;">
               
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
                        <li><?= link_to('/contact_us', 'Contact Us'); ?></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>

                            