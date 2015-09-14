<?php
class RolesController extends BaseController {

    public function SaveRoles() {
        if (strtoupper(Input::get('save')) == 'SAVE') {
            DB::table('permissionmap')->where('role', Input::get('cell'))->delete();
            $perm_array = Input::get('permission');
            foreach ($perm_array as $key => $value) {
                DB::table('permissionmap')->insert(
                array(
                'role' =>Input::get('cell'),
                'permission' => $value,
                'creationTime' => strtotime(date("Y-m-d H:i:s"))
                ));
            }
            Session::flash('_feedback', '<div class="alert alert-info alert-dismissable">
                                        <i class="fa fa-info"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Alert!</b> '.Input::get('rolename_h').' permissions have been successfully updated</div>');
            Helpers::logAction(Input::get('rolename')." Permissions updated");
            return Redirect::to(URL::previous());
        } elseif (strtoupper(Input::get('delete')) == 'DELETE') {
            return Redirect::to(URL::previous());
        }
    }
}