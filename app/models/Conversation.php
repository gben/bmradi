<?php

/**
 * Description of Conversation
 *
 * @author clement
 */
class Conversation {

    public static function saveEmail() {
        $attachment_ref = '';
        if (Input::hasFile('attachment')) {
            $attachment_ref = Helpers::getUniqueID();
            Helpers::uploadCampaignFile(Input::file('attachment'), $attachment_ref);
        }
        DB::table('mradi_outbox_email_log')
                ->insert(array(
                    "sender" => Helpers::getGlobalValue('SYSTEM_EMAIL'),
                    "message" => Input::get('message'),
                    "subject" => Input::get('subject'),
                    "email_cc" => Input::get('email_cc'),
                    "email_bcc" => Input::get('email_bcc'),
                    "email_to" => Input::get('email_to'),
                    "attachment_ref" => $attachment_ref));

        return true;
    }

    public static function readConversation($conversationId) {
        
    }

    public static function getTopConversation() {
        
    }

    public static function getMessageCount($sender = '') {
        $query = DB::table("mradi_messages");
        $query->leftJoin("accounts_dbx", function($join) {
                    $join->on("accounts_dbx.account_id", "=", "mradi_messages.target_user_id");
                });
        if ($sender != '')
            $query->where("mradi_messages.source_user_id", '=', $sender);
        return count($query->where("mradi_messages.target_user_id", '=', Session::get("account_id"))
                        ->whereIn("mradi_messages.status", array('0'))
                        ->get());
    }
    public static function getConversationCount() {
        $query = DB::table("mradi_messages");
        
        return count($query->whereNotIn('status',array('2'))
                        ->groupBy("message_hash")
                        ->get());
    }
    public static function deleteConversation($conversationId) {
        
    }

    public static function updateConversation($message_hash) {
        DB::table('mradi_messages')
                ->where('message_hash', $message_hash)
                ->where('target_user_id', Session::get('account_id'))
                ->update(array('status' => 1, 'time_read' => date('Y-m-d H:i:s')));
    }

    public static function getConversationList($user_id, $allConversation = false) {
        if ($allConversation) {
            $result = DB::Select("SELECT COUNT(message_hash) AS convs,source_user_id AS sender_id,
                (SELECT CONCAT(firstname,' ', lastname) 
                FROM accounts_dbx WHERE account_id = mradi_messages.source_user_id)  AS sender,
                (SELECT email_address FROM accounts_dbx WHERE account_id = mradi_messages.source_user_id)  AS sender_email,
                (SELECT CONCAT(firstname,' ', lastname) 
                FROM accounts_dbx WHERE account_id = mradi_messages.target_user_id)  AS recipient,
                (SELECT email_address FROM accounts_dbx WHERE account_id = mradi_messages.target_user_id)  AS recipient_email,
                message_hash, `time_sent`, MIN(`mradi_messages`.`status`)AS STATUS FROM `mradi_messages` 
                LEFT JOIN `accounts_dbx` ON `accounts_dbx`.`account_id` = `mradi_messages`.`target_user_id`
                WHERE `mradi_messages`.`status` IN (0,1) GROUP BY message_hash order by time_sent desc limit ? offset ?", array(Session::get('rec_per_page'), (Session::get('rec_per_page') * ((Input::get('page') == '' ? 0 : (Input::get('page') - 1))))));
        } else {
            $result = DB::Select("SELECT (select COUNT(message_hash) from mradi_messages where `target_user_id` = ?) AS convs,source_user_id as sender_id,(SELECT CONCAT(firstname,' ', lastname" . (strtoupper(Session::get('account_type')) == 'ADMIN' ? ",' - ',email_address" : '') . ") 
                FROM accounts_dbx WHERE account_id = mradi_messages.source_user_id)  AS sender,(SELECT CONCAT(firstname,' ', lastname" . (strtoupper(Session::get('account_type')) == 'ADMIN' ? ",' - ',email_address" : '') . ") 
                FROM accounts_dbx WHERE account_id = mradi_messages.target_user_id)  AS recipient,message_hash, `time_sent`, (select MIN(`mradi_messages`.`status`) from mradi_messages where `mradi_messages`.`target_user_id` = ?)AS status FROM `mradi_messages` 
                LEFT JOIN `accounts_dbx` ON `accounts_dbx`.`account_id` = `mradi_messages`.`target_user_id`
                WHERE (`mradi_messages`.`target_user_id` = ? or `mradi_messages`.`source_user_id` =?) AND `mradi_messages`.`status` IN (0,1) GROUP BY message_hash  order by time_sent desc limit ? offset ?", array(Session::get("account_id"), Session::get("account_id"), Session::get("account_id"), Session::get("account_id"), Session::get('rec_per_page'), (Session::get('rec_per_page') * ((Input::get('page') == '' ? 0 : (Input::get('page') - 1))))));
        }

        return array('records' => $result, 'total_pages' => count($result));
    }

    public static function getChats($message_hash,$data) {
        if($data=='')
            Conversation::updateConversation($message_hash);
        $result = DB::Select("SELECT target_user_id as recipient_id,source_user_id as sender_id,(SELECT CONCAT(firstname,' ', lastname) 
                FROM accounts_dbx WHERE account_id = mradi_messages.source_user_id)  AS sender,CONCAT(firstname,' ', lastname) as recipient,
                `time_sent`,`mradi_messages`.`message`,(case when time_read is not null then 1 else 0 end)as time_read FROM `mradi_messages` 
                LEFT JOIN `accounts_dbx` ON `accounts_dbx`.`account_id` = `mradi_messages`.`target_user_id`
                WHERE message_hash = ? AND `mradi_messages`.`status` IN (0,1) order by time_sent asc", array($message_hash));

        return $result;
    }

    public static function getContactList() {
        $query = DB::table('accounts_dbx');
        switch (strtoupper(Session::get('account_type'))) {
            case 'ADMIN':
                $query->join("mradi_accounts_profile", function($join) {
                                    $join->on("accounts_dbx.account_id", "=", "mradi_accounts_profile.account_id");
                                })
                        ->where('intrash', '=', 'NO')
                        ->whereNotIn('account_type', array('ADMIN'))
                        ->where('accounts_dbx.account_id', '<>', Session::get('account_id'))
                        ->select('accounts_dbx.account_id', 'firstname', 'lastname', 'account_type', 'email_address')
                        ->orderBy('account_type');
                break;
            case 'INVESTOR':
                $query->join("mradi_accounts_profile", function($join) {
                                    $join->on("accounts_dbx.account_id", "=", "mradi_accounts_profile.account_id");
                                })
                        ->where('intrash', '=', 'NO')
                        ->where('account_type', '=', 'ENTREPRENEUR')
                        ->where('accounts_dbx.account_id', '<>', Session::get('account_id'))
                        ->select('accounts_dbx.account_id', 'firstname', 'lastname', 'account_type')
                        ->orderBy('account_type');
                break;
            case 'ENTREPRENEUR':
                $query->join("mradi_accounts_profile", function($join) {
                                    $join->on("accounts_dbx.account_id", "=", "mradi_accounts_profile.account_id");
                                })
                        ->where('intrash', '=', 'NO')
                        ->where('account_type', '=', 'INVESTOR')
                        ->where('accounts_dbx.account_id', '<>', Session::get('account_id'))
                        ->select('accounts_dbx.account_id', 'firstname', 'lastname', 'account_type')
                        ->orderBy('account_type');
                break;
            default:
                break;
        }
        $resultAll[0] = $query->get();
        /*
         * Admin Contact
         */
        $resultAll[1] = DB::table('accounts_dbx')->where('intrash', '=', 'NO')
                ->where('account_type', '=', 'ADMIN')
                ->where('accounts_dbx.account_id', '<>', Session::get('account_id'))
                ->select('accounts_dbx.account_id', 'firstname', 'lastname', 'account_type')
                ->orderBy('account_type')
                ->get();

        $chatList = array('' => 'Select Recipient');
        $Investors = array();
        $Entre = array();
        $admin = array();
        foreach ($resultAll as $result) {
            foreach ($result as $contact) {
                if ($contact->account_type == 'INVESTOR') {
                    $Investors[$contact->account_id] = $contact->firstname . ' ' . $contact->lastname;
                } elseif ($contact->account_type == 'ENTREPRENEUR') {
                    $Entre[$contact->account_id] = $contact->firstname . ' ' . $contact->lastname;
                } elseif ($contact->account_type == 'ADMIN') {
                    $admin[$contact->account_id] = $contact->firstname . ' ' . $contact->lastname;
                }
            }
        }

        if (strtoupper(Session::get('account_type')) == 'INVESTOR' || strtoupper(Session::get('account_type')) == 'ENTREPRENEUR') {
            if (count($admin) > 0)
                $chatList['MradiFund'] = $admin;
        }
        if (count($Investors) > 0)
            $chatList['Investors'] = $Investors;
        if (count($Entre) > 0)
            $chatList['Entrepreneurs'] = $Entre;

        return Form::select('contact_list', $chatList, '', array('class' => "form-control"));
    }

    public static function getMsgStatus($message_hash) {
        $rs = DB::Select("select MIN(`mradi_messages`.`status`) as status,source_user_id from mradi_messages where `mradi_messages`.`target_user_id` = ? and message_hash = ?", array(Session::get('account_id'), $message_hash));
        if ($rs[0]->source_user_id == '')
            return 1;
        else
            return $rs[0]->status;
    }

    public static function getMsgCount($message_hash) {
        $rs = DB::Select("select count(message_hash) as messages from mradi_messages where `mradi_messages`.`target_user_id` = ? and message_hash = ? and status = 0", array(Session::get('account_id'), $message_hash));
        return $rs[0]->messages;
    }

    public static function getEmailContactList($field_name) {
        $Investors['all_investors'] = 'All Investors';
        $Entrepreneurs['all_entrepreneurs'] = 'All Entrepreneurs';
        $Subscribers['all_subscribers'] = 'All Subscribers';

        $contacts = array('Investors', 'Entrepreneurs', 'Subscribers');
        foreach ($contacts as $contact) {
            switch ($contact) {
                case 'Investors';
                    $listing = Investors::getInvestorslist();
                    break;
                case 'Entrepreneurs';
                    $listing = Entrepreneurs::getEntrepreneurslist();
                    break;
                case 'Subscribers';
                    $listing = Subscribers::getSubscriberslist();
                    break;
            }
            foreach ($listing as $item) {
                switch ($contact) {
                    case 'Investors';
                        $Investors[$item->key_] = $item->value;
                        break;
                    case 'Entrepreneurs';
                        $Entrepreneurs[$item->key_] = $item->value;
                        break;
                    case 'Subscribers';
                        $Subscribers[$item->key_] = $item->value;
                        break;
                }
            }
        }
        $emailList = array('' => 'Select Recipients');
        if (count($Subscribers) > 1) {
            $emailList['Subcscribers'] = array('all_subscribers' => 'All Subcscribers');
        }
        if (count($Investors) > 1) {
            $emailList['Investors'] = $Investors;
        }
        if (count($Entrepreneurs) > 1) {
            $emailList['Entrepreneurs'] = $Entrepreneurs;
        }

        return Form::select($field_name, $emailList, '', array('class' => "form-control"));
    }

}

?>
