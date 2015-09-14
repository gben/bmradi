<?php

class invController extends BaseController {

    public function EditAccount() {
       
        $entre_data = array();
        if (DB::table('accounts_dbx')->where('account_id', Input::get('id'))->update(array('account_status' => Input::get('action')))) {
            $entre_data = DB::select("SELECT firstname,lastname,email_address from accounts_dbx where account_id = ?", array(Input::get('id')));
            if (Input::get('send_email') == '1') {
                if (Input::get('action') == 'ACTIVE') {
                    Session::put('email_names', $entre_data[0]->firstname . ' ' . $entre_data[0]->lastname);
                    Session::put('email_message', 'Your Mradifund account has been activated. You can now login and access your account');
                    $data = array(
                        'message' => "Your Mradifund account has been activated. You can now login and access your account"
                    );

                    Mail::send('emails.notice', $data, function($message) {
                                $entre_data = DB::select("SELECT firstname,lastname,email_address from accounts_dbx where account_id = ?", array(Input::get('id')));
                                $message->to($entre_data[0]->email_address, $entre_data[0]->firstname . ' ' . $entre_data[0]->lastname)->subject('Mradi Account');
                            });
                } else {
                    Session::put('email_names', $entre_data[0]->firstname . ' ' . $entre_data[0]->lastname);
                    Session::put('email_message', 'Your Mradifund account has been deactivated. Please contact us for more information');
                    $data = array(
                        'message' => "Your Mradifund account has been deactivated. Please contact us for more information"
                    );

                    Mail::send('emails.notice', $data, function($message) {
                                $entre_data = DB::select("SELECT firstname,lastname,email_address from accounts_dbx where account_id = ?", array(Input::get('id')));
                                $message->to($entre_data[0]->email_address, $entre_data[0]->firstname . ' ' . $entre_data[0]->lastname)->subject('Mradi Account');
                            });
                    //return Redirect::route(Input::get('route'));
                }
            }
            return Response::make("OK",200);
        } else {
            return Response::make("OK",200);
        }
    }

    public function SaveAccount() {
        $results = DB::select('select * from accounts_dbx where username= ?', array(Input::get('username')));
        if (empty($results)) {
            if (
                    DB::table('accounts_dbx')->insert(
                            array(
                                'firstname' => Input::get('firstname'),
                                'lastname' => Input::get('lastname'),
                                'email_address' => Input::get('email'),
                                'account_type' => Input::get('account_type'),
                                'username' => Input::get('username'),
                                'password' => hash('sha256', Input::get('password')), //Encrypt password
                                'date_created' => date('Y-m-d H:i:s'),
                                'account_status' => 'INACTIVE',
                                'gender' => Input::get('gender')
                            )
                    )
            ) {
                $account_type = Input::get('account_type');
                $now = new DateTime();
                $results = DB::table('questionaire_details')->insert(
                        array(
                            'email' => Input::get('email'),
                            'acc_type' => $account_type,
                            'date_created' => $now->format('Y-m-d H:i:s')
                        ));

                $ct = 7;
                if ($account_type == 'INVESTOR') {
                    $ct = 7;
                } elseif ($account_type == 'ENTREPRENEUR') {
                    $ct = 6;
                }
                for ($i = 1; $i <= $ct; $i++) {
                    DB::table('inv_entre_questionaire')->insert(
                            array(
                                'email' => Input::get('email'),
                                'question_id' => $i,
                                'answer' => Input::get('ent_qns_' . $i),
                                'acc_type' => $account_type
                    ));
                }

                Session::put('email_names', Input::get('firstname') . ' ' . Input::get('lastname'));
                Session::put('email_message', 'Your Mradifund account has been created successfully awaiting approval. We will get back at you shortly on the same. Regards');
                $data = array(
                    'message' => "Your Mradifund account has been created successfully awaiting approval. We will get back at you shortly on the same. Regards"
                );

                Mail::send('emails.notice', $data, function($message) {
                            $message->to(Input::get('email'), Input::get('firstname') . ' ' . Input::get('lastname'))->subject('Mradi Account');
                        });

                Session::flash('common_feedback', '<div class="alert alert-success" style="width: 500px;">New mradi account request has been successfully sent! Please check your email for further instructions.</div>');
                return View::make('common_feedback');
            } else {
                Session::flash('common_feedback', '<div class="alert alert-warning" style="width: 500px;">Error creating a new Mradifund account request. Please try again later</div>');
                return View::make('common_feedback');
            }
        } else {
            Session::flash('common_feedback', '<div class="alert alert-warning" style="width: 500px;">The username selected is already in use. Please try again</div>');
            return View::make('common_feedback');
        }
    }

    public function accountApproval() {
        if (DB::table('accounts_dbx')->where('account_id', Input::get('account_id'))->update(array('account_status' => Input::get('status_action')))) {



            if (Input::get('status_action') == 'ACTIVE') {
                Session::put('email_names', Input::get('firstname') . ' ' . Input::get('lastname'));
                Session::put('email_message', 'Your Mradifund account has been activated. You can now login and access your account');
                $data = array(
                    'message' => "Your Mradifund account has been activated. You can now login and access your account"
                );


                Mail::send('emails.notice', $data, function($message) {
                            $message->to(Input::get('email_address'), Input::get('firstname') . ' ' . Input::get('lastname'))->subject('Mradi Account');
                        });
                return Redirect::route(Input::get('redirect_route'));
            } else {
                Session::put('email_names', Input::get('firstname') . ' ' . Input::get('lastname'));
                Session::put('email_message', 'Your Mradifund account has been deactivated. Please contact us for more information');
                $data = array(
                    'message' => "Your Mradifund account has been deactivated. Please contact us for more information"
                );

                Mail::send('emails.notice', $data, function($message) {
                            $message->to(Input::get('email_address'), Input::get('firstname') . ' ' . Input::get('lastname'))->subject('Mradi Account');
                        });
                return Redirect::route(Input::get('redirect_route'));
            }
        } else {

            Redirect::route(Input::get('redirect_route'));
        }
    }

}

