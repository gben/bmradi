<?php

class SubscriptionController extends BaseController {

    public function subscribeProcess() {

        $rs = DB::select("SELECT status FROM subscribers WHERE email_address = ?", array(Input::get('subscribers_email')));
        if (count($rs) == 0) {
            if (DB::table('subscribers')->insert(
                            array(
                                'email_address' => Input::get('subscribers_email'),
                                'date_subscribed' => date('Y-m-d H:i:s')
                    ))) {
                Session::put('email_message', 'Thank you for subscribing please click here to verify: ' . link_to_route('verify_email', 'Verify email', array('email_address' => Input::get('subscribers_email'))));
                $data = array(
                    'message' => "Your Mradifund account has been created successfully awaiting approval. We will get back at you shortly on the same. Regards"
                );

                Mail::send('emails.notice', $data, function($message) {
                            $message->to(Input::get('subscribers_email'), Input::get('firstname') . ' ' . Input::get('lastname'))->subject('Mradi Account');
                        });
                Session::flash('common_feedback', '<div class="alert alert-success" style="width: 500px;">Thank you for subscribing to our newsletter. Please check verify through your email</div>');
                return View::make('common_feedback');
            } else {
                Session::flash('common_feedback', '<div class="alert alert-warning" style="width: 500px;">Error subscribing. Please try again later</div>');
                return View::make('common_feedback');
            }
        } else {
            if ($rs[0]->status == 'INACTIVE') {
                DB::table('subscribers')->where('email_address' , Input::get('subscribers_email'))->update(
                            array('date_subscribed' => date('Y-m-d H:i:s'))
                    );
                Session::put('email_message', 'Thank you for subscribing please click here to verify: ' . link_to_route('verify_email', 'Verify email', array('email_address' => Input::get('subscribers_email'))));
                $data = array(
                    'message' => "Your Mradifund account has been created successfully awaiting approval. We will get back at you shortly on the same. Regards"
                );

                Mail::send('emails.notice', $data, function($message) {
                            $message->to(Input::get('subscribers_email'), Input::get('firstname') . ' ' . Input::get('lastname'))->subject('Mradi Account');
                        });
                Session::flash('common_feedback', '<div class="alert alert-success" style="width: 500px;">Thank you for subscribing to our newsletter. Please check verify through your email</div>');
                return View::make('common_feedback');
            } else { //Active
                Session::flash('common_feedback', '<div class="alert alert-success" style="width: 500px;">You have an active newsletter subscription. Thank you</div>');
                return View::make('common_feedback');
            }
        }
    }
    
    
    public function verifyEmail(){
        if (DB::table('subscribers')->where('email_address', Input::get('email_address'))->update(array('status' => 'ACTIVE'))) {
            Session::put('email_message', 'Your Mradifund subscription has been successfully verified. We shall keep you posted!');
            $data = array(
                'message' => "Your Mradifund subscription has been successfully verified. We shall keep you posted!"
            );

            Mail::send('emails.notice', $data, function($message) {
                $message->to(Input::get('email_address'), Input::get('firstname') . ' ' . Input::get('lastname'))->subject('Mradi Account');
            });
            Session::flash('common_feedback', '<div class="alert alert-success" style="width: 500px;">Thank you for subscribing to our newsletter. We shall keep you posted!</div>');
            return View::make('common_feedback');
            
            
        } else {
            Session::flash('common_feedback', '<div class="alert alert-warning" style="width: 500px;">You have an active newsletter subscription. Thank you</div>');
            return View::make('common_feedback');
        }
    }

}
