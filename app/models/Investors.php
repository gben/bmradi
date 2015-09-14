<?php

class Investors {
    public static function getInvestorsList()
    {
         return DB::table('accounts_dbx')
                ->join("mradi_accounts_profile", function($join) {
                                    $join->on("accounts_dbx.account_id", "=", "mradi_accounts_profile.account_id");
                                })
                        ->where('intrash', '=', 'NO')
                        ->where('account_type', '=', 'INVESTOR')
                        ->where('accounts_dbx.account_id', '<>', Session::get('account_id'))
                        ->select('email_address as key_', 'email_address as value')
                        ->orderBy('account_type')
                        ->get();
    }
}
