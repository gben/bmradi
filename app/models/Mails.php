<?php

class Mails {
    
    public static function get_all_mails(){
        return DB::select('select id, date_sent, message, status, username from mails left join accounts_dbx on mails.sent_by = accounts_dbx.account_id');
    }
}
