<?php

class Accounts {
    
    
    public static function save(){
        dd(Input::get());
    }
    public static function update_account(){
    
    }  
    
    public static function get_all_investors(){
        $sql = "select * from accounts_dbx where account_type='INVESTOR'";
        return DB::select($sql);
    }
    
    
    public static function get_all_entrepreneur(){
        $sql = "select * from accounts_dbx where account_type='ENTREPRENEUR'";
        return DB::select($sql);
    }
    
    public static function get_account_by_account_id($account_id){
        return DB::select('select * from accounts_dbx where account_id = ?', array($account_id));
    }
    
    public static function set_approval(){
        
    }    
    
    public static function set_status(){
        
    }
       
}