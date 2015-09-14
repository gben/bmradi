<?php
/*
 * 11	shares.select.permission	Finance	Shares	1	1	2	10	Shares	shares	1343412676
 * */
class Dashboard{    
    
    public static function get_first_level_menus($module){
        $rr = DB::select("SELECT module, menu_name, url, id,is_menu FROM permission 
            WHERE id IN (SELECT permission FROM permissionmap WHERE role IN (SELECT ID FROM role WHERE title = ?))
                AND menu_level = 1 AND is_menu >= 1 AND module = ? 
                    order by menu_pos asc", array((strtoupper(Session::get('account_type'))=='ADMIN'?'Administrator':Session::get('account_type')),$module));
		return $rr;
    }
    public static function get_second_level_menus($module,$parent_menu){
        return DB::select("SELECT menu_name,url,id FROM permission 
            WHERE id IN (SELECT permission FROM permissionmap 
            WHERE role IN (SELECT ID FROM role WHERE title = ?)) 
                AND is_menu= 1 AND menu_level = 2 AND module = ?  
                    AND child_of = ? 
                        order by menu_pos asc", array((strtoupper(Session::get('account_type'))=='ADMIN'?'Administrator':Session::get('account_type')),$module,$parent_menu));
    }
    
    public static function get_modules(){
       return DB::select("SELECT DISTINCT(module) FROM permission WHERE module IN(SELECT module from module_map where ".Session::get('account_type')." = 1) ORDER BY module"); 
    }
    
    
    public static function get_recent_campaigns($count){
        return DB::select('select * from campaign_dbx order by date_created desc limit ?', array($count));
    }
    
    public static function save_new_campaign(){
        
    } 
}
