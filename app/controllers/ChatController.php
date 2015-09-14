<?php

class ChatController extends BaseController {

    public function SendChat() {
        /*
         * get the recipient
         */
        if (Input::get('contact_list') == '') {
            $target = DB::select("SELECT target_user_id,source_user_id from mradi_messages where message_hash = ?", array(
                        Input::get('message_')
                    ));
            $target = ($target[0]->source_user_id==Session::get('account_id')?$target[0]->target_user_id:$target[0]->source_user_id);
        } else {
            $target = Input::get('contact_list');
        }
        $source = Session::get('account_id');
        DB::select("update mradi_messages set message_hash=? where (source_user_id = ? and target_user_id = ?) 
                or (source_user_id = ? and target_user_id = ?)",array(Input::get('message_'),$source,$target,$target,$source));
      
        $queries = DB::getQueryLog();
        $last_query = end($queries);
        Helpers::logData(print_r($last_query,true));

        DB::table('mradi_messages')->insert(array(
            'target_user_id' => $target,
            'source_user_id' => Session::get('account_id'),
            'message' => Input::get('message'),
            'message_hash' => Input::get('message_')
        ));
        if (Input::get('contact_list') != '')
            return Redirect::to(URL::previous());
        else
            return Response::make('OK', 200);
    }

}

