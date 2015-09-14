 <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
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
                        </div>
                        <div class="pull-left info">
                            <p>Hello, <?=ucfirst(Session::get('firstname'))?></p>
                        </div>
                    </div>
                    <!-- search form -->
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <!--  Sidebar Menus -->
                       <?php 
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$modules = Dashboard::get_modules(); 

//dd($recent_campaigns);
$i = 0;
foreach ($modules as $item) {

    $menus = Dashboard::get_first_level_menus($item->module); 
    $list_menus = '';
    $isTopLevel = false;
    /*
     * Get the menu items
     */
    foreach ($menus as $menu) {
        if ($menu->is_menu == 2) {
            $isTopLevel = true;
            $list_menus = $menu->url;
            break;
        }
        else{
            
            if(strtoupper(Session::get('account_type'))=='ENTREPRENEUR' || strtoupper(Session::get('account_type'))=='INVESTOR'){
				///if(URL::to('nerds'))
				//$list_menus .= '<li>'.link_to_route($menu->url, $menu->menu_name) .'</li>';
				$list_menus .= '<li><a href="' . URL::to($menu->url) . '"><i class="fa fa-angle-double-right"></i> ' . $menu->menu_name . '</a></li>';
			} else{
				$list_menus .= '<li><a href="' . URL::to($menu->url)  . '"><i class="fa fa-angle-double-right"></i> ' . $menu->menu_name . '</a></li>';
			}
           }
    }
    /*
     * Determine Classes to add on the sidebar menu items
     */
    $class = '';
    $i++;
    if (strtolower($item->module) == 'dashboard' && (Route::current()->getName() == 'dashboard')) {
        $class = 'active ';
    }elseif (strtolower($item->module) == 'reports'  && (Route::current()->getName() == 'ongoing_cp_report' || Route::current()->getName() == 'shelved_cp_report' || Route::current()->getName() == 'closed_cp_report' || Route::current()->getName() == 'all_cp_report'  || Route::current()->getName() == 'activity_report')) {
        $class = 'active ';
    }elseif (strtolower($item->module) == 'mailbox'  && (Route::current()->getName() == 'conversation' || Route::current()->getName() == 'all_conversations')) {
        $class = 'active ';
    }elseif (strtolower($item->module) == 'campaigns' && (Route::current()->getName() == 'campaigns_list' || Route::current()->getName() == 'campaigns_grid_list')) {
        $class = 'active ';
    }elseif (strtolower($item->module) == 'finance' && (Route::current()->getName() == 'income_gen')) {
        $class = 'active ';
    }elseif (strtolower($item->module) == 'accounts administration'  && (Route::current()->getName() == 'subscr_acc' || Route::current()->getName() == 'entrepreneur_acc' || Route::current()->getName() == 'investor_acc' || Route::current()->getName() == 'roles')) {
        $class = 'active ';
    }
    
    
    if (count($menus) > 0 && !$isTopLevel) {
        $class .= "treeview";
    }
    /*
     * Determine if its a top level menu
     * top_level = is_menu = 2
     */
    if (!$isTopLevel) {
        echo '<li class="' . $class . ' ">
            <a href="#">
                <i class="fa fa-dashboard"></i> <span>' . $item->module . '</span>
            <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">';
        echo $list_menus;
        echo '</ul>';
    } else {
        echo '<li class="' . $class . ' ">
            <a href="'.$list_menus.'">
                <i class="fa fa-dashboard"></i> <span>' . $item->module . '</span>
            </a>';
    }
    echo '</li>';
}
?>
                    </ul>
                </section>
                <!-- /.sidebar -->


