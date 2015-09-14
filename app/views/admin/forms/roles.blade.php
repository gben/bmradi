<style type="text/css">
    table.bottomBorder { border-collapse:collapse; width: 80%;margin: 10px}
    table.bottomBorder td, table.bottomBorder th { border-bottom:1px solid #eee;padding:2px; text-align:left;}
    table.bottomBorder th {  border-bottom: navy solid thin;padding: 5px !important;margin-top: 2px; border-top: navy solid thin; border-left: none; border-right: none; font-size: 12px; font-weight: bold; background-color:#cfcfcf; color:navy; }
    table.bottomBorder td { background-color:#f9f9f9; }
</style>
<?php
	$inRole = array();
        $roleName = '';
	if(!empty($cell))
	{
            $rs = DB::select("SELECT title FROM role WHERE id = ?",array($cell));
            $roleName = $rs[0]->title;
            $rsRole = DB::select("select permission from permissionmap where role = ?",array($cell));
            foreach($rsRole as $roleI)
            {
                $inRole[] = $roleI->permission;
            }            
	}
        $modules = DB::select("SELECT distinct(module)
                                from permission 
                                where MENU_NAME IS NOT NULL AND IS_MENU = 1
                                ORDER BY ID asc
                                ");
        
?>{{ Form::open(array('name'=>'roles','url'=>'/save/roles')) }}
    <label>
        <span>Role</span>
        {{ Form::hidden('rolename_h',$roleName)}}
        <input type="text" name="title" originalvalue="<?=$roleName?>" value="<?=$roleName?>" maxlength="32" class="required" placeholder="Enter role" disabled>
    </label>
    <?php
    echo '<div class="rowCell">
            <span class="titleCell">Select/De-select All Permissions</span>
         <span class="contentCell"> <input type="checkbox" value="all" name="permission[]" class="joinoptions" >All</label></span>
         </div>';
    echo "<table class='bottomBorder'>";
    foreach($modules as $row)
    {
        echo '<tr><th>' . $row->module . '</th><th>View</th><th>Add/Create</th><th>Edit</th><th>Delete/Remove</th></tr>';
        $permissions = DB::select("SELECT ID,DESCRIPTION,MENU_NAME,TITLE
                                                from permission 
                                                where 
                                                    MODULE=? 
                                                    AND MENU_NAME IS NOT NULL AND IS_MENU = 1
                                                ORDER BY ID asc
                                            ",array($row->module));
      foreach($permissions as $rowI)
      {
            $roleItem = explode('.',$rowI->TITLE);
            $roleItem = $roleItem[0];
            $checked = '';
            echo '<tr><td><b>' . $rowI->MENU_NAME . '</b></td>';

            $menu_roles = array("SELECT"=>'',"INSERT"=>'',"UPDATE"=>'',"DELETE"=>'');
            $permName = '';
            $statement = DB::select("SELECT ID,TITLE,DESCRIPTION FROM permission WHERE TITLE like ?",array("$roleItem.%"));
            foreach($statement as $rowx)
            {
                if(strpos($rowx->TITLE,'.select.')!== false || strpos($rowx->TITLE,'.access.')!== false || strpos($rowx->TITLE,'.browse.')!== false)
                {
                    $menu_roles["SELECT"] = $rowx->ID;
                }
                elseif(strpos($rowx->TITLE,'.insert.')!== false || strpos($rowx->TITLE,'.create.')!== false)
                {
                    $menu_roles["INSERT"] = $rowx->ID;
                }
                elseif(strpos($rowx->TITLE,'.update')!== false)
                {
                    $menu_roles["UPDATE"] = $rowx->ID;
                }
                elseif (strpos($rowx->TITLE,'.delete')!== false) {
                    $menu_roles["DELETE"] = $rowx->ID;
                }
                $permName[$rowx->ID] = $rowx->DESCRIPTION;
            }
            echo '<td>'.($menu_roles["SELECT"] != '' ?'<input type="checkbox" name="permission[]" value="' . $menu_roles["SELECT"] . '" class="joinoptions" ' . (in_array($menu_roles["SELECT"], $inRole)?'checked':'') . '>':'').'</td>';
            echo '<td>'.($menu_roles["INSERT"] != '' ?'<input type="checkbox" name="permission[]" value="' . $menu_roles["INSERT"] . '" class="joinoptions" ' . (in_array($menu_roles["INSERT"], $inRole)?'checked':'') . '>':'').'</td>';
            echo '<td>'.($menu_roles["UPDATE"] != '' ?'<input type="checkbox" name="permission[]" value="' . $menu_roles["UPDATE"] . '" class="joinoptions" ' . (in_array($menu_roles["UPDATE"], $inRole)?'checked':'') . '>':'').'</td>';
            echo '<td>'.($menu_roles["DELETE"] != '' ?'<input type="checkbox" name="permission[]" value="' . $menu_roles["DELETE"] . '" class="joinoptions" ' . (in_array($menu_roles["DELETE"], $inRole)?'checked':'') . '>':'').'</td>';
}
        echo '</tr>';
    }
    echo "</table>";
    ?>
    <span class="gridFormButtons">
        <!--<input type="submit" name="save" value="Save" class="gridPrimaryButtonSubmit btn btn-flat btn-success">-->
        <?=(Helpers::hasPermission("role", "insert")?'<input type="submit" name="save" value="Save" class="gridPrimaryButtonSubmit btn btn-flat btn-success">':'')?>
        <input type="button" name="cancel" value="Cancel" class="btn btn-flat btn-success">
        <input type="hidden" name="cell" value="<?=$cell?>"/>
    </span>
{{ Form::close() }}
@include('admin.includes.lessfooter')