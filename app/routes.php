<?php

Route::get('/', function() {

            $home_page_array = array('index3', 'index4');
            $template_chooser = rand(0, 1);
            //return View::make($home_page_array[$template_chooser], array('sticky' => true)); 
            return View::make('index4', array('sticky' => true));
            //return View::make('investortab', array('sticky' => true)); 
        });
Route::get('/campaign', array(
    "as" => "campaign_page", function() {
        return View::make('_default_campaign_temp', array(
                    'c_data' => Campaign::get_campaign_by_campaign_id($_GET['q'])
                        )
        );
    })
);
Route::get('/contact_us', array(
    "as" => "contact_us", function() {
        return View::make('contacts');
    })
);
Route::get('/campaigns', array(
    "as" => "campaigns", function() {
        return View::make('campaigns');
    })
);

Route::get('/fund_a_campaign', array(
    "as" => "fac", function() {
        return View::make('fund_a_campaign');
    })
);


Route::get('/start_a_campaign', array(
    "as" => "sac", function() {
        return View::make('start_a_campaign');
    })
);
Route::get('/enterpreneur_survey', array(
    "as" => "ent_view", function() {
        $account_id = Session::get('account_id');
        if (!isset($account_id) || $account_id < 0) {
            return Redirect::route('login');
        }
        else
            return View::make('enterpreneur_qns');
    })
);
Route::get('/investor_survey', array(
    "as" => "inv_view", function() {
        $account_id = Session::get('account_id');
        if (!isset($account_id) || $account_id < 0) {
            return Redirect::route('login');
        }
        else
            return View::make('investor_qns');
    })
);

Route::get('/create_new_campaign', array("before" => "auth_check", "as" => "create_new_campaign", function() {
        return View::make(strtolower(Session::get('account_type')) . '.frm_campaign');
    }));

Route::get('/entrepreneur', array(
    "before" => "auth_check", "as" => "entrepreneur", function() {
        return View::make(strtolower(Session::get('account_type')) . '.entrepreneur');
    })
);

Route::get('/investors', array(
    "before" => "auth_check", "as" => "investors", function() {
        return View::make(strtolower(Session::get('account_type')) . '.investors');
    })
);

Route::get('/manage_campaigns', array(
    "before" => "auth_check", "as" => "manage_campaigns", function() {
        return View::make(strtolower(Session::get('account_type')) . '.campaigns');
    })
);

Route::get('/manage_categories', array(
    "before" => "auth_check", "as" => "manage_categories", function() {
        return View::make(strtolower(Session::get('account_type')) . '.categories');
    })
);

Route::get('/about', array(
    "as" => "about",
    function() {
        return View::make('about');
    })
);

Route::get('/howitworks', array(
    "as" => "howitworks",
    function() {
        return View::make('how_it_works_page');
    }
        )
);


Route::get('/system_settings', array(
    "as" => "system_settings",
    function() {
        return View::make(strtolower(Session::get('account_type')) . '.settings');
    }
        )
);

Route::get('/dashboard', array(
    "before" => "auth_check", "as" => "dashboard", function() {
        return View::make('admin.pages.dashboard');
    }
        )
);

Route::post('/prx_user_authentication', array(
    "uses" => "AuthController@validateUser",
    "as" => "prx_user_authentication"
        )
);


//subscribe
Route::post('/subscribe', array(
    "uses" => "SubscriptionController@subscribeProcess",
    "as" => "subscribe"
        )
);



Route::get('/join', array("as" => "join", function() {
        return View::make('join');
    }
));


Route::get('/blog', array("as" => "blog", function() {
        return View::make('blog');
    }
));


Route::post('/create_new_account', array("uses" => "AccountController@SaveAccount", "as" => "create_new_account"));


Route::get('/logout', array(
    "uses" => "AuthController@logOut", "as" => "logout"
        )
);


Route::get('/login', array("as" => "login", function() {
        return View::make('login');
    }
));


Route::get('/my_account', array("as" => "my_account", function() {
        return View::make('_account');
    }
));

Route::get('/summary', array("as" => "summary", function() {
        return View::make('_summary');
    }
));

//account_approval
Route::get('/account_approval', array(
    "uses" => "AccountController@accountApproval",
    "as" => "account_approval"
        )
);
//campaign_approval
Route::get('/campaign_approval', array(
    "uses" => "CampaignsController@CampaignApproval",
    "as" => "campaign_approval"
        )
);
//campaign_approval
Route::get('/feedback', array("as" => 'feed_back', function() {
        if (Session::get('common_feedback') == '') {
            return Redirect::route('dashboard');
        }
        else
            return View::make('common_feedback');
    })
);
//ent_qns
Route::post('/ent_qns', array(
    "before" => "csrf", "as" => "ent_qns", "uses" => 'AccountController@scoreEntrepreneur'
        )
);
//Save Profile details
Route::post('/complete_my_profile', array(
    "before" => "csrf", "as" => "complete_my_profile", "uses" => 'AccountController@saveProfile'
        )
);

//ent_qns
Route::post('/inv_qns', array(
    "before" => "csrf", "as" => "inv_qns", "uses" => 'AccountController@scoreInvestor'
        )
);
/*
 * Send Feedback Processing
 */
Route::post('/sendmessage', array("before" => "crsf", function() {
        $data = array(
            'description' => Input::get('description'),
            'names' => Input::get('names'),
            'email_address' => Input::get('email_address')
        );
        Mail::send('emails.feedback', $data, function($message) {
                    $message->to('info@mradifund.com', 'Mradifund Info')->subject('Website Feedback ' . Input::get('names'));
                });
        return Response::make("<b>We value your feedback. Thank you</b>", 200);
    }));

//admin subscriptions

Route::get('/subscribers', array(
    "before" => "auth_check", "as" => "subscribers", function() {
        return View::make(strtolower(Session::get('account_type')) . '.subscribers');
    }
        )
);


Route::get('/send_newsletter', array(
    "before" => "auth_check", "as" => "send_newsletter", function() {
        return View::make(strtolower(Session::get('account_type')) . '.subscribers_send_newsletter');
    }
        )
);

//verify_email


Route::get('/verify_email', array("uses" => "SubscriptionController@verifyEmail", "as" => "verify_email"));


Route::get('/outbox', array(
    "before" => "auth_check", "as" => "outbox", function() {
        return View::make(strtolower(Session::get('account_type')) . '.subscribers_outbox');
    }
        )
);


//emails_send_email
Route::get('/emails_send_email', array(
    "before" => "auth_check", "as" => "emails_send_email", function() {
        return View::make(strtolower(Session::get('account_type')) . '.emails_send_email');
    }
        )
);
Route::get('/complete_profile', array("as" => "complete_profile", function() {
        $account_id = Session::get('account_id');
        if (!isset($account_id) || $account_id < 0) {
            return Redirect::route('login');
        }
        else
            return View::make('profile');
    }
        )
);
Route::get('/change_password', array("as" => "change_password", function() {
        $account_id = Session::get('account_id');
        if (!isset($account_id) || $account_id < 0) {
            return Redirect::route('login');
        }
        else
            return View::make('change_password');
    })
);

Route::filter('auth_check', function() {
            $account_id = Session::get('account_id');

            if (isset($account_id) && $account_id > 0) {
                /*
                 * add extra checks
                 */
                if (Helpers::CheckChangePassword()) {
                    return Redirect::route('change_password');
                } else {
                    if (strtoupper(Session::get('account_type')) != 'ADMIN') {
                        if (!Helpers::passedTest()) {
                            if (strtoupper(Session::get('account_type')) == 'INVESTOR')
                                return Redirect::route('inv_view');
                            else
                                return Redirect::route('ent_view');
                        }else {
                            if (!Helpers::profileComplete()) {
                                return Redirect::route('complete_profile');
                            } elseif (Helpers::getTotalCampaigns(true) == 0 
                                    && strtoupper(Session::get('account_type')) == 'ENTREPRENEUR') {
                                //return Redirect::route('campaigns_list');
                                return View::make('admin.pages.campaign_list');
                            }
                        }
                    }
                }
            } else {
                return Redirect::to('/login');
            }
        });
/*
 * Portal Routes
 * Route group using auth_check
 */

Route::group(array("before" => "auth_check"), function() {
//            Route::get('/change_password', array("as" => "change_password", function() {
//                    return View::make('change_password');
//                }
//                    )
//            );

            Route::get('/master_records', array("as" => "masterrecords", function() {
                    return View::make('admin.pages.master_records');
                }
                    )
            );
            Route::get('/activity_reports', array("as" => "activity_report", function() {
                    return View::make('admin.pages.activity_report');
                }
                    )
            );
            Route::get('/all_cp_report', array("as" => "all_cp_report", function() {
                    return View::make('admin.pages.all_cp_report');
                }
                    )
            );
            Route::get('/ongoing_cp_report', array("as" => "ongoing_cp_report", function() {
                    return View::make('admin.pages.ongoing_cp_report');
                }
                    )
            );
            Route::get('/closed_cp_report', array("as" => "closed_cp_report", function() {
                    return View::make('admin.pages.closed_cp_report');
                }
                    )
            );
            Route::get('/shelved_cp_report', array("as" => "shelved_cp_report", function() {
                    return View::make('admin.pages.shelved_cp_report');
                }
                    )
            );
            /*Route::get('/income_gen', array("as" => "income_gen", function() {
                    return View::make('admin.pages.income_gen');
                }
                    )
            );*/
            Route::get('/income_gen', ['as' => 'income_gen', 'uses' => 'CampaignController@getTemplateList']);
            Route::get('/shares', array("as" => "shares", function() {
                    return View::make('admin.pages.shares');
                }
                    )
            );
            Route::get('/investor_acc', array("as" => "investor_acc", function() {
                    return View::make('admin.pages.investor_acc');
                }
                    )
            );
            Route::get('/entre_acc', array("as" => "entrepreneur_acc", function() {
                    return View::make('admin.pages.entre_acc');
                }
                    )
            );
            Route::get('/subscriptions', array("as" => "subscr_acc", function() {
                    return View::make('admin.pages.subscr_acc');
                }
                    )
            );
            Route::get('/inbox', array("as" => "inbox", function() {
                    return View::make('admin.pages.outbox', array('campaign' => 'KyCM1p14151068056'));
                }
                    )
            );
            Route::get('/all_conversations', array("as" => "all_conversations", function() {
                    return View::make('admin.pages.all_conversations');
                }
                    )
            );
            Route::get('/profile', array("as" => "view_profile", function() {
                    return View::make('admin.pages.my_profile');
                }
                    )
            );
            
            Route::get('/profile/{user_id}/edit', ['as' => 'profile.edit', 'uses' => 'AccountController@getProfileEdit']);
            
            Route::get('/campaign_bid/{campaign_id}', ["as" => "campaign.bid", 'uses' => 'CampaignController@getBidCampaign'] );

            Route::post('/profile/update', ['as' => 'profile.update', 'uses' => 'AccountController@postProfileEdit']);
            
            Route::post('/campaign/like', ['as' => 'campaign.like', 'uses' => 'CampaignController@getLikes']);
            
            Route::resource('wallet', 'WalletController');
            
            Route::resource('bid', 'BidController');
            
            Route::get('/wallet', ['as' => 'wallet', 'uses' => 'WalletController@Index']);
            
            Route::get('/walletc', ['as' => 'walletc', 'uses' => 'WalletController@getCancel']);
            
            Route::get('/credit_wallet', ['as' => 'credit.wallet', 'uses' => 'CampaignController@getCredit']);
            
            Route::get('/debit_wallet', ['as' => 'debit.wallet', 'uses' => 'CampaignController@getCredit']);
            
            Route::get('/template_list', ['as' => 'template.list', 'uses' => 'CampaignController@getTemplateList']);
            
            Route::post('/campaign_bid_list', ['as' => 'campaign.bids', 'uses' => 'BidController@getList']);
            
            Route::post('/template', ['as' => 'template', function() {
                    return View::make('admin.pages.get_template');
                }]);
                
            Route::get('/template', ['as' => 'template', function() {
                    return View::make('admin.pages.get_template');
                }]);
            
            Route::get('/my-feeds', ['as' => 'feeds', function() {
                    return View::make('admin.pages.my_feeds');
                }]);
            
            Route::get('/conversation', array("as" => "conversation", function() {
                    return View::make('admin.pages.conversation');
                }
                    )
            );
            Route::get('/compose', array("as" => "compose", function() {
                    return View::make('admin.pages.compose');
                }
                    )
            );
            Route::get('/notification', array("as" => "notification", function() {
                    return View::make('admin.pages.notification');
                }
                    )
            );
            Route::get('/investors', array("as" => "investors", function() {
                    return View::make('admin.pages.investors');
                }
                    )
            );
            Route::get('/entrepreneur', array("as" => "entrepreneur", function() {
                    return View::make('admin.pages.entrepreneur');
                }
                    )
            );
            Route::get('/campaigns_list', array("as" => "campaigns_list", function() {
                    return View::make('admin.pages.campaign_list');
                }
                    )
            );
            Route::get('/views_list/{campaign_id?}', array("as" => "views_list", function($campaign_id=null) {
                    return View::make('admin.pages.view_list',["campaign_id"=>$campaign_id]);
                }
                    )
            );
            Route::get('/viewers_list/', array("as" => "viewers_list", function() {
                    return View::make('admin.pages.viewers_list',["entre_id"=>Session::get('account_id')]);
                }
                    )
            );
            Route::get('/mviewers_list/', array("as" => "mviewers_list", function() {
                    return View::make('admin.pages.mviewers_list',["entre_id"=>Session::get('account_id'), 'multiple'=>true]);
                }
                    )
            );
            Route::get('/cgrid_list/{my_Status?}', array("as" => "cgrid_list", function($my_Status=null) {
                    return View::make('admin.pages.campaigns_grid_list', ["campaign" => Input::get('campaign'), "my_Status"=> $my_Status]);
                }
                    )
            );
            Route::get('/campaigns_grid_list/{my_Status?}', array("as" => "campaigns_grid_list", function($my_Status=null) {
                    return View::make('admin.pages.campaigns_grid_list', ["campaign" => Input::get('campaign'), "my_Status"=> $my_Status]);
                }
                    )
            );
            Route::get('/campaigns_detailed_info', array("as" => "campaigns_grid_info", function() {
                    return View::make('admin.pages.campaigns_grid', array("campaign" => Input::get('campaign')));
                }
                    )
            );
            Route::get('/roles', array("as" => "roles", function() {
                    return View::make('admin.pages.roles');
                }
                    )
            );
            Route::get('/campaign_info', array("as" => "campaign_info", function() {
                    Session::flash("activetab", (Session::get('activetab') == '' ? 'tab_1' : Session::get('activetab')));
                    return View::make('admin.pages.create_campaign', array("campaign" => Input::get('campaign')));
                }
            ));
        });

/*
 * AJAX Request processing
 */
Route::post('/fetchview', array('before' => 'csrf', 'uses' => function() {
        $data = Input::all();
        if (Request::ajax()) {
            $returnPage = "";
            $info='';
            switch (strtoupper($data['view'])) {
                case "ENTREPRENEUR":
                    $returnPage = "admin.viewinfo.acc_admin_entre";
                    break;
                case "INVESTOR":
                    $returnPage = "admin.viewinfo.acc_admin_inv";
                    break;
                case "SUBSCRIPTION":
                    $returnPage = "admin.viewinfo.acc_admin_subscr";
                    break;
                case "ROLES":
                    $returnPage = "admin.viewinfo.acc_roles";
                    break;
                case "CAMPAIGNS":
                    $returnPage = "admin.viewinfo.campaigns";
                    break;
                case "CONVERSATION":
                    $returnPage = "admin.viewinfo.conversation";
                    break;
                case "CONVERSATIONS":
                    $returnPage = "admin.viewinfo.conversations";
                    $info = 'all';
                    break;
                default:
                    $returnPage = "";
                    break;
            }
            //return $returnPage;
            return View::make($returnPage, array("row_id" => $data['key'],"data"=>$info));
        }
    }));


/*
 * AJAX Request processing For AJAX edit requests
 */
Route::post('/edit/{file_name}', array('before' => 'csrf', 'uses' => function($file_name) {
        if (Request::ajax()) {
            return View::make("admin.forms.$file_name", array("cell" => Input::get('cell')));
            //Route::post('/edit/{file_name}', array('uses' => 'entreController@EditRoles'));
        }
    }));


/*
 * AJAX Request processing For AJAX Save requests
 */
if (Request::is('save/*')) {
    if (Request::ajax()) {
        Route::post("/save/{file_name}", $file_name . "Controller@Save" . $file_name);
    } else {
        // validation successful ---------------------------
        $file_name = Request::segment(2);
        switch ($file_name) {
            case 'campaignSummary':
            case 'companyDetails':
            case 'marketInfo':
            case 'proposal':
            case 'team':
            case 'summaryStatement':
            case 'financials':
            case 'businessPlan':
            case 'video':
            case 'newCampaign':
                Route::post('/save/{file_name}', array('before' => 'csrf', 'uses' => "CampaignController@Save" . ucwords($file_name)));
                break;
            default:
                Route::post("/save/{file_name}", ucwords($file_name) . "Controller@Save" . ucwords($file_name));
                break;
        }
    }
};
/*
 * Change Password Route
 */
Route::post('/prx_change_password', array(
    'before' => 'csrf',
    "uses" => "AuthController@changePassword",
    "as" => "prx_change_password"
        )
);
Route::group(array('before' => array('csrf', 'auth_check')), function() {
            if (Request::ajax()) {
                Route::post('/info/update/entrepreneur', array('uses' => 'entreController@EditAccount'));
                Route::post('/info/update/investor', array('uses' => 'invController@EditAccount'));
            }
            Route::post('/campaigns_grid_list', array("as" => "campaigns_grid_list", function() {
                    return View::make('admin.pages.campaigns_grid_list');
                }));
        });
Route::get('/download/{file_name}', function($file_name) {
            $file = storage_path() . "/campaigns/" . $file_name;
            if (File::exists($file) && $mimeType = Helpers::getImageContentType($file)) {
                $response = Response::download($file, $file_name, array('Content-Type' => $mimeType));
                ob_end_clean();
                return $response;
            }
            else
                return Response::make("File does not exist.", 404);
        });
if (Request::is('campaign/*')) {
    $file_name = Request::segment(2);    
    Route::post("/campaign/{file_name}/{campaign_id}", "CampaignController@" . ucwords($file_name) . 'Campaign');
}

// get the cuteness level of a puppy
    Route::get('campaign1/{func}/{campaign_id}', function($func, $campaign_id) 
    {
		//Route::post('/post/{post}/update', ['as' => 'post.update', 'uses' => 'PostController@updatePost']);
        //Route::post("/campaign1/{file_name}/{campaign_id}", ["uses" => "CampaignController@" . ucwords($func) . 'Campaign']);
        $app = app();
		$controller = $app->make('CampaignController');
		return $controller->callAction(ucwords($func) . 'Campaign', ['campaign_id' => $campaign_id]);
    });


Route::get('/remove/{reference}/{file_name}', function($reference,$file_name) {
            $file = storage_path() . "/campaigns/" . $file_name;
            if (File::exists($file)) {
                Helpers::removeFile($reference,$file_name,$file);
                return Redirect::to(URL::previous());
            }
            else
                return Response::make("File does not exist.", 404);
        });
///if (Request::ajax()) {
    Route::post("/send/chat", array('uses'=>"ChatController@SendChat"));
//}

if (Request::is('chats/*')) {
    if (Request::ajax()) {
        Route::get("/chats/{file_name}/{view}", array('uses' => function($file_name,$view) {
            return View::make("admin.viewinfo.chat", array("row_id" => $file_name,"data"=>$view));
    }));
    }
}
/*
 * Send email
 */
 Route::post("/send/email", array('uses'=>"SendEmailController@SendEmail"));
 
 Route::get('/cdetails/{cid}/view', ['as' => 'cdetails.view', 'uses' => 'HomeController@getCampaignDetails']);
