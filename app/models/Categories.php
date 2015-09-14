<?php

class Categories {
    
    
    public static function get_categories(){
        return DB::select('select * from categories_dbx order by title desc');
    }
    
    
}