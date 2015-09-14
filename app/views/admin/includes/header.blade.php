<a href="dashboard" class="logo">
    <!-- Add the class icon to your logo image or logo icon to add the margining -->
    Mradifund
</a>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </a>
    <div class="navbar-right">
        <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->
            
            
            <!-- feedsrunner -->
            <li class="">
               <?=link_to_route('feeds', '', [], ["class"=>"fa fa-refresh"]) ?>
             </li>
            
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-user"></i>
                    <span><?=ucfirst(Session::get('username'))?> <i class="caret"></i></span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header bg-light-blue">
                        <?php
							if(strtolower(session::get('account_type')) != "admin"){
								$profileDetails = Helpers::getProfileDetails();
								$file = Helpers::getUploadedFileDetails($profileDetails[0]->profile_pic);
								$file_name = '';
								if(empty($file))
									{ $file_name = 'no-image.png'; }
								else
									{ $file_name = $file[0]->file_alias; }
						?>
								{{ HTML::image('assets/'.$file_name, $profileDetails[0]->firstname,array("class"=>"img-circle", "width"=>"250px","height"=>"150px")) }}
						<?php
							}else{
						?>
							{{ HTML::image('assets/'.'ll.jpg', "Profile Image", array("class"=>"img-circle", "width"=>"250px","height"=>"150px")) }}
						<?php } ?>
						
                        <p>
                            <?=ucfirst(Session::get('fullnames'))?> - <?=ucfirst(strtolower(Session::get('account_type')))?>
                            <small>Member since <?=Session::get('membersince')?></small>
                        </p>
                    </li>
                    <!-- Menu Body -->
                    <!--<li class="user-body">
                        <div class="col-xs-4 text-center">
                            <a href="#">Followers</a>
                        </div>
                        <div class="col-xs-4 text-center">
                            <a href="#">Sales</a>
                        </div>
                        <div class="col-xs-4 text-center">
                            <a href="#">Friends</a>
                        </div>
                    </li>-->
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                            @if(strtoupper(Session::get('account_type'))!='ADMIN')
                            {{'';$u = URL::route('view_profile');}}
                            {{HTML::link($u, 'Profile',array('class'=>'btn btn-default btn-flat'))}}
                            @endif
<!--                            <a href="#" class="btn btn-default btn-flat">Profile</a>-->
                        </div>
                        <div class="pull-right">
                            <?=link_to_route('logout', 'Sign out', null, array('class' => 'btn btn-default btn-flat'))?>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
