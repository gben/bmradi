<?php

class AccountController extends BaseController {

    public function SaveAccount() {
        /*
         * Validate input values
         */
        $rules = array(
            'firstname' => 'required|min:2',
            'lastname' => 'required|min:2',
            'email' => 'required|email',
            'account_type' => 'required',
            'gender' => 'required',
            'country' => 'required|min:1',
            'phone_number' => 'required|min:4'
        );
        $validator = Validator::make(Input::all(), $rules);
        $messages = $validator->messages();
        if ($validator->fails()) {
            return Redirect::to(URL::previous())
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $results = DB::select('select * from accounts_dbx where email_address = ? and account_type = ?', array(Input::get('email'), Input::get('account_type')));
            $password = str_random(6) . rand(100, 999);
            if (empty($results)) {
                if (
                        DB::table('accounts_dbx')->insert(
                                array(
                                    'firstname' => Input::get('firstname'),
                                    'lastname' => Input::get('lastname'),
                                    'email_address' => Input::get('email'),
                                    'account_type' => Input::get('account_type'),
                                    'password' => hash('sha256', $password), //Encrypt password
                                    'date_created' => date('Y-m-d H:i:s'),
                                    'account_status' => 'ACTIVE',
                                    'gender' => Input::get('gender'),
                                    'country' => Input::get('country'),
                                    'phone' => Input::get('phone_number'),
                                )
                        )
                ) {
                    Session::put('email_names', Input::get('firstname') . ' ' . Input::get('lastname'));
                    Session::put('email_message', "Your Mradifund account has been created successfully. <br /> Email : " . Input::get('email') . " <br /> Password : $password ");
                    $data = array(
                        'message' => "Your Mradifund account has been created successfully. <br /> Email : " . Input::get('email') . " <br /> Password : $password "
                    );
                    /*
                     * Send Login Email details and Log
                     */
                    if (Mail::send('emails.notice', $data, function($message) {
                                        $message->to(Input::get('email'), Input::get('firstname') . ' ' . Input::get('lastname'))->subject('Mradi Account');
                                    })) {
                        Helpers::logEmailMessage(
                                array(
                            "sender" => Helpers::getGlobalValue('SYSTEM_EMAIL'),
                            "recipient" => Input::get('email'),
                            "message" => str_replace($password, "xxxxxxx", Session::get('email_message')),
                            "subject" => "Mradi Account",
                            "source" => 'System'), true);
                    } else {
                        Helpers::logEmailMessage(
                                array(
                            "sender" => Helpers::getGlobalValue('SYSTEM_EMAIL'),
                            "recipient" => Input::get('email'),
                            "message" => str_replace($password, "xxxxxxx", Session::get('email_message')),
                            "subject" => "Mradi Account",
                            "source" => 'System'), false);
                    }
                    Session::flash('common_feedback', '<div class="alert alert-success" style="width: 500px;">New mradi account request has been successfully sent! Please check your email for further instructions.</div>');
                    return View::make('common_feedback');
                } else {
                    Session::flash('common_feedback', '<div class="alert alert-warning" style="width: 500px;">Error creating a new Mradifund account request. Please try again later</div>');
                    return View::make('common_feedback');
                }
            } else {
                Session::flash('common_feedback', '<div class="alert alert-warning" style="width: 500px;">You already have an existing account, click ' . HTML::link('login', 'here') . ' to login.</div>');
                return View::make('common_feedback');
            }
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

    /*
     * Score the investor selection
     */

    public function scoreInvestor() {
        $ct = 7;
        $correct = 0;
        for ($i = 1; $i <= $ct; $i++) {
            (Helpers::isAnsCorrect($i, Input::get('ent_qns_' . $i)) ? $correct++ : '');
        }
        if ($correct == 7) {
            //Update to passed_test
            DB::table('accounts_dbx')
                    ->where('account_id', Session::get('account_id'))
                    ->update(array(
                        'passed_test' => 'YES'
                    ));
            Helpers::logAction("Passed Investor test");
            Session::flash('common_title', 'Congratulations!');
            Session::flash('common_feedback', '<div class="alert alert-warning" style="width:80%;margin:auto">
                 Congratulations! Please complete your profile to finish the registration process.</br></div>');
            return Redirect::route('campaigns_grid_list');
        } else {
            //Send feedback as failed
            Helpers::logAction("Failed Investor test");
            Session::flash('common_title', 'Almost there...');
            Session::flash('common_feedback', '<div class="alert alert-warning" style="width:80%;margin:auto">
                        You didn\'t meet the required criteria. Please click ' . HTML::link(URL::route('logout'), 'here') . ' for more information on investment.</div><br/>
                            <div style="width:80%;margin:auto;text-align:center">' . HTML::link(URL::route('logout'), 'Retake questionnaire later', array("class" => "btn btn-flat btn-success")) . '  
                            ' . HTML::link(URL::route('inv_view'), 'Retake questionnaire immediately', array("class" => "btn btn-flat btn-success")) . '</div>');
            return Redirect::route('feed_back');
        }
        
    }

    /*
     *  score the entrepreneur 
     */

    public function scoreEntrepreneur() {
        $ct = 6;
        $correct = 0;
        $failed = array();
        for ($i = 1; $i <= $ct; $i++) {
            (Input::get('ent_qns_' . $i) == 'YES' ? $correct++ : $failed[] = Helpers::getFailed($i + 7));
        }
        $conditions = '<ul>';
        foreach ($failed as $que) {
            $conditions .= "<li>$que</li>";
        }
        $conditions .= '</ul>';
        if ($correct == 6) {
            //Update to passed_test
            DB::table('accounts_dbx')
                    ->where('account_id', Session::get('account_id'))
                    ->update(array(
                        'passed_test' => 'YES'
                    ));
            Helpers::logAction("Passed entrepreneur test");
            Session::flash('common_title', 'Congratulations!');
            Session::flash('common_feedback', '<div class="alert alert-warning" style="width:80%;margin:auto">
                 Congratulations! Please complete your profile to finish the registration process.</br></div>');
            return Redirect::route('campaigns_grid_list');
        } else {
            //Send feedback as failed
            Helpers::logAction("Failed Entrepreneur test");
            Session::flash('common_title', 'Not yet there...');
            Session::flash('common_feedback', '<div class="alert alert-warning" style="width:80%;margin:auto">
                        You didn\'t meet the required criteria, ensure that :' . $conditions . '                    
                        then revist Mradifund once you have met these conditions.</div><br/>
                         <div style="width:80%;margin:auto;text-align:center">' . HTML::link(URL::route('logout'), 'Try again later', array("class" => "btn btn-flat btn-success")) . '</div>');
        
            return Redirect::route('feed_back');
        }
        
    }

    /*
     * Save User Profile details
     */

    public function saveProfile() {
        /*
         * Validate input values
         */
        $rules = array(
            'date_of_birth' => 'required|date',
            'id_passport' => 'required|min:2',
            'pin_number' => 'required',
            'brief_desc' => 'required',
            'photo' => 'image'
        );
        $validator = Validator::make(Input::all(), $rules);
        $messages = $validator->messages();
        if ($validator->fails()) {
            return Redirect::to(URL::previous())
                            ->withErrors($validator)
                            ->withInput();
        } else {
            /*
             * check if new profile creation
             */
             $photo_ref = Helpers::getUniqueID();
            if (!Helpers::profileComplete()) { //Create
                Helpers::logAction("Complete creation of their profile");
                DB::table('mradi_accounts_profile')->insert(
                        array(
                            'account_id' => Session::get('account_id'),
                            'date_of_birth' => Input::get('date_of_birth'),
                            'id_passport' => Input::get('id_passport'),
                            'pin_number' => Input::get('pin_number'),
                            'address' => Input::get('postal_addr'),
                            'description' => Input::get('brief_desc'),
                            'location' => Input::get('location'),
                            'profile_pic' => $photo_ref
                ));
                /*
                 * Add array map
                 */
                $interests = Input::get('interest');
                foreach ($interests as $key => $value) {
                    DB::table('mradi_interests_map')->insert(
                            array(
                                'account_id'=>Session::get('account_id'),
                                'category_id'=>$value
                    ));
                }
                if (Input::hasFile('photo')) {
                    $file = Helpers::uploadCampaignFile(Input::file('photo'), $photo_ref);
                }
                if (strtoupper(Session::get('account_type')) == 'INVESTOR') {
                    return Redirect::route('campaigns_grid_list');
                } else {
                    return Redirect::route('campaigns_list');
                }
            } else { //Update
                Helpers::logAction("Updated their profile");
                DB::table('mradi_accounts_profile')
                        ->where('account_id', Session::get('account_id'))
                        ->update(array(
                            'date_of_birth' => Input::get('date_of_birth'),
                            'id_passport' => Input::get('id_passport'),
                            'pin_number' => Input::get('pin_number'),
                            'address' => Input::get('postal_addr'),
                            'description' => Input::get('brief_desc'),
                            'location' => Input::get('location')
                        ));
                /*
                 * Update Interests
                 */
                DB::table('mradi_interests_map')
                        ->where('account_id', Session::get('account_id'))
                        ->delete();
                $interests = Input::get('interest');
                foreach ($interests as $key => $value) {
                    DB::table('mradi_interests_map')->insert(
                            array(
                                'account_id'=>Session::get('account_id'),
                                'category_id'=>$value
                    ));
                }
                if (Input::hasFile('photo')) {
                    $file = Helpers::uploadCampaignFile(Input::file('photo'), $photo_ref);
                    Helpers::uploadFileData(Input::get('photo_h'), $file['original'], $file['alias']);
                }
                return Redirect::route('profile');
            }
        }
    }


	public function postProfileEdit(){
		$data = [
            'phone' => Input::get('phone'),
            'address' => Input::get('address'),
            'location' => Input::get('location'),			
        ];
        $rules = [
            'phone' => 'required',
            'address' => 'required',
            'location' => 'required',
            
        ];
        
        if (Input::hasFile('photo')) {
			$photo_ref = Helpers::getUniqueID();
			$data['profile_pic'] = $photo_ref;
			
            $file = Helpers::uploadCampaignFile(Input::file('photo'), $photo_ref);
        }
        
        $valid = Validator::make($data, $rules);
        
        if ($valid){
			$user_id = Input::get('id');
			array_filter($data);
			$details = array();
			foreach($data as $k=>$dt){
				if($k != 'phone'){
					$details[$k] =  $dt;
				}
			}
						
			 Helpers::logAction("Profile Edit");
             DB::table('mradi_accounts_profile')
				->where('account_id', Session::get('account_id'))
                ->update($details);
                
             DB::table('accounts_dbx')
				  ->where('account_id', Session::get('account_id'))
				  ->update(array(
                      'phone' => Input::get('phone'),
					));
            
			Session::flash('common_feedback', '<div class="alert alert-success" style="width: 500px;">Profile updated.</div>');
			return View::make('admin.pages.my_profile');	
		}
		Session::flash('common_feedback', '<div class="alert alert-warning" style="width: 500px;">Error updating profile. Please try again later</div>');
        return View::make('admin.pages.my_profile');
	}
	
	public function getProfileEdit($user_id){
		$profileDetails = Helper::getProfileDetails($user_id);
		$myProfile = $profileDetails[0]; //var_dump($myProfile); exit;
		
		if(\Request::ajax())
            return View::make('admin.pages.edit_profile',compact('myProfile', 'user_id'));
        
	}


}

