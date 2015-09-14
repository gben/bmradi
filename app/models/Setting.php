<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Setting
 *
 * @author ALLAN
 */
class Setting {
    
    public static function get_settings(){
        return DB::select('select * from env_variables_dbx');
    }
    
}
