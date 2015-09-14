<h3>&nbsp;</h3>
<div class="list-group">
    
    <?php 
    
        /*
         * If the user has logged in as the administrator
         */
        if(Session::get('account_type') == 'ADMIN') { 
            echo link_to_route('dashboard', 'Dashboard', null, array('class' => 'list-group-item'));
            echo link_to_route('subscribers', 'Subscriptions', null, array('class' => 'list-group-item')); 
            echo link_to_route('emails_send_email', 'Email', null, array('class' => 'list-group-item')); 
            echo link_to_route('manage_campaigns', 'Campaigns', null, array('class' => 'list-group-item')); 
            echo link_to_route('entrepreneur', 'Enterpreneurs', null, array('class' => 'list-group-item')); 
            echo link_to_route('investors', 'Investors', null, array('class' => 'list-group-item')); 
            //echo link_to_route('blog_manager', 'Blog', null, array('class' => 'list-group-item')); 
            //echo link_to_route('summary', 'Reports', null, array('class' => 'list-group-item'));   
            //echo link_to_route('system_settings', 'Site Settings', null, array('class' => 'list-group-item')); 
        }
        
        /*
         * If the user has logged in as the entrepreneur
         */
        if(Session::get('account_type') == 'ENTREPRENEUR') { 
            echo link_to_route('dashboard', 'Dashboard', null, array('class' => 'list-group-item'));
            echo link_to_route('manage_campaigns', 'Manage Campaigns', null, array('class' => 'list-group-item')); 
            echo link_to_route('summary', 'Reports', null, array('class' => 'list-group-item')); 
            echo link_to_route('system_settings', 'Profile settings', null, array('class' => 'list-group-item')); 
        }
        
        /*
         * If the user has logged in as the investor then load the investor dashboard
         */
        if(Session::get('account_type') == 'INVESTOR') { 
            echo link_to_route('dashboard', 'Dashboard', null, array('class' => 'list-group-item'));
            echo link_to_route('manage_campaigns', 'My Equity', null, array('class' => 'list-group-item')); 
            echo link_to_route('summary', 'Reports', null, array('class' => 'list-group-item')); 
            echo link_to_route('system_settings', 'Profile settings', null, array('class' => 'list-group-item')); 
        }
        
    ?>
</div>
