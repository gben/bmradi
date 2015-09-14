<?php

class Subscribers {
    public static function get_subscribers(){
        return DB::select('select * from subscribers');
    }
    public static function getSubscribersList()
    {
        return DB::select("Select email_address as key_,email_address as value from subscribers where status = 'ACTIVE'");
    }
}
