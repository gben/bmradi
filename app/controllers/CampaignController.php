<?php

class CampaignController extends BaseController {

    public function SaveNewCampaign() {
        $rules = array(
            'campaign_name' => 'required|min:1'
        );
        $validator = Validator::make(Input::all(), $rules);
        $isUnique = Helpers::isCampaignNameUnique(trim(Input::get('campaign_name')));
        $messages = $validator->messages();
        if ($validator->fails() || !$isUnique) {
            return Redirect::to(URL::previous())
                            ->withErrors($validator)
                            ->withInput()
                            ->with('unique', (!$isUnique ? "Oops! Campaign name already exists. Please enter another name" : ''));
        } else {
            $campaignID = Str::quickRandom(6) . strtotime('now') . Session::get("account_id");
            DB::table('tbl_campaigns')->insert(
                    array(
                        'uniqueid' => $campaignID,
                        'user_id' => Session::get("account_id"),
                        'creationtime' => date("Y-m-d H:i:s"),
                        'lastupdatetime' => date("Y-m-d H:i:s"),
                        'campaignstatus' => 'Draft',
                        'campaigname' => Input::get('campaign_name'),
                        'approvalstatus' => 'Pending'
            ));
            $u = URL::route('campaign_info', array(
                        'campaign' => $campaignID
                    ));
            return Redirect::to($u);
        }
    }

    public function SaveCampaignSummary() {
        $rules = array(
            'listing_logo' => 'required_if:listing_logo_h,0|image',
            'business_name' => 'required|between:1,50',
            'business_summary' => 'required|between:2,140',
            //'min_investment' => 'required|numeric',
            'money_valuation' => 'numeric',
            'max_investment' => 'numeric',
            'money_util' => 'required|between:2,300',
            'categories' => 'required',
            'website_address' => 'url',
            'facebook_address' => 'url',
            'twitter_address' => 'url',
            'linkedin_address' => 'url',
        );
        $validator = Validator::make(Input::all(), $rules);

        // check if the validator failed -----------------------
        if ($validator->fails()) {
            return Redirect::to(URL::previous())
                            ->withErrors($validator)
                            ->withInput()
                            ->with('activetab', Input::get('activetab'));
        } else {
			
            if (Helpers::isNewCampaign(Input::get('campaign'), 1)) {
				$campaign_logo_ref = Helpers::getUniqueID();
                
                DB::table('tbl_campaign_summary')->insert(
                        array(
                            'listing_logo' => $campaign_logo_ref,
                            'campaign_id' => Helpers::getCampaignID(Input::get('campaign')),
                            'business_name' => Input::get('business_name'),
                            'business_summary' => Input::get('business_summary'),
                            'min_investment' => Helpers::getGlobalValue('MINIMUM_INV_SOUGHT'),
                            'percent_equity' => Input::get('min_inv_percent'),
                            'pre_money_valuation' => Input::get('money_valuation'),
                            'max_investment' => Input::get('max_investment'),
                            'max_percent_equity' => Input::get('max_inv_percent'),
                            'money_use' => Input::get('money_util'),
                            'categories' => Input::get('categories'),
                            'facebook' => Input::get('facebook_address'),
                            'twitter' => Input::get('twitter_address'),
                            'linkedin' => Input::get('linkedin_address'),
                            'website' => Input::get('website_address')
                ));
                /*
                 * Insert upload file data
                 */
                $listing_logo_file = Helpers::uploadCampaignFile(Input::file('listing_logo'), $campaign_logo_ref);
                Helpers::uploadFileData($campaign_logo_ref, $listing_logo_file['original'], $listing_logo_file['alias']);
                /*
                 * Progress Campaign progress
                 */
                Helpers::progressCampaign(Input::get('campaign'), 1);
            } else {
                DB::table('tbl_campaign_summary')->where('campaign_id', Helpers::getCampaignID(Input::get('campaign')))->update(
                        array(
                            'business_name' => Input::get('business_name'),
                            'business_summary' => Input::get('business_summary'),
                            'min_investment' => Input::get('min_investment'),
                            'percent_equity' => Input::get('min_inv_percent'),
                            'pre_money_valuation' => Input::get('money_valuation'),
                            'max_investment' => Input::get('max_investment'),
                            'max_percent_equity' => Input::get('max_inv_percent'),
                            'money_use' => Input::get('money_util'),
                            'categories' => Input::get('categories'),
                            'facebook' => Input::get('facebook_address'),
                            'twitter' => Input::get('twitter_address'),
                            'linkedin' => Input::get('linkedin_address'),
                            'website' => Input::get('website_address')
                ));
                $campaign_logo_ref = Input::get('listing_logo_h');
                if (Input::hasFile('listing_logo')) {
                    /*
                     * Insert upload file data
                     */
                    $listing_logo_file = Helpers::uploadCampaignFile(Input::file('listing_logo'), $campaign_logo_ref);
                    //Helpers::uploadFileData(Input::get('listing_logo_h'), $listing_logo_file['original'], $listing_logo_file['alias'], true);
                }
            }
            $tab = explode("_", Input::get('activetab'));
            $active_tab = "tab_" . ($tab[1] + 1); 
            return Redirect::to(URL::route('campaign_info', array(
                                'campaign' => Input::get('campaign')))
                    )->with('activetab', $active_tab);
        }
    }

    public function SaveCompanyDetails() {
        $rules = array(
            'country_of_ops' => 'required',
            'incorporation_no' => 'required',
            'incorporation_date' => 'required',
            'incorporation_cert' => 'image|required_if:incorporation_cert_h,0',
            'postal_address' => 'required',
            'physical_address' => 'required',
            'nominal_capital' => 'required|numeric',
            'share_value' => 'required|numeric',
            'allocated_shares' => 'required|numeric',
            'unallocated_shares' => 'required|numeric',
            'director_loans' => 'required|numeric',
            'no_directors' => 'required|integer',
            'no_shareholders' => 'required|integer',
            'product_description' => 'required',
            'product_use' => 'required',
            'customer_base' => 'required', //gender
            'age_group' => 'required',
            'location' => 'required',
            'category' => 'required', //profession
            'customer_xtics' => 'required',
            'revenue' => 'required',
            'sale_size' => 'required',
            'advantages' => 'required',
            'challenges' => 'required',
            'accomplishments' => 'required',
            'awards_search' => 'image',
            'article_link' => 'image'
        );
        $validator = Validator::make(Input::all(), $rules);

        // check if the validator failed -----------------------
        if ($validator->fails()) {
            return Redirect::to(URL::previous())
                            ->withErrors($validator)
                            ->withInput()
                            ->with('activetab', Input::get('activetab'));
        } else {            
            if (Helpers::isNewCampaign(Input::get('campaign'), 2)) {
				$incorporation_cert_ref = Helpers::getUniqueID();
				$award_ref = Helpers::getUniqueID();
				$article_ref = Helpers::getUniqueID();
				
                DB::table('tbl_campaign_companyinfo')->insert(
                        array(
                            'campaign_id' => Helpers::getCampaignID(Input::get('campaign')),
                            'country_of_ops' => Input::get('country_of_ops'),
                            'incorporation_cert' => $incorporation_cert_ref,
                            'incorporation_no' => Input::get('incorporation_no'),
                            'incorporation_date' => Input::get('incorporation_date'),
                            'postal_address' => Input::get('postal_address'),
                            'physical_address' => Input::get('physical_address'),
                            'nominal_capital' => Input::get('nominal_capital'),
                            'share_value' => Input::get('share_value'),
                            'allocated_shares' => Input::get('allocated_shares'),
                            'unallocated_shares' => Input::get('unallocated_shares'),
                            'total_no_shares' => Input::get('allocated_shares') + Input::get('unallocated_shares'),
                            'director_loans' => Input::get('director_loans'),
                            'no_directors' => Input::get('no_directors'),
                            'no_shareholders' => Input::get('no_shareholders'),
                            'product_description' => Input::get('product_description'),
                            'product_use' => Input::get('product_use'),
                            'customer_base' => Input::get('customer_base'), //gender
                            'age_group' => Input::get('age_group'),
                            'location' => Input::get('location'),
                            'category' => Input::get('category'), //profession
                            'customer_xtics' => Input::get('customer_xtics'),
                            'other_info' => Input::get('other_info'),
                            'revenue' => Input::get('revenue'),
                            'sale_size' => Input::get('sale_size'),
                            'advantages' => Input::get('advantages'),
                            'challenges' => Input::get('challenges'),
                            'accomplishments' => Input::get('accomplishments'),
                            'awards' => $award_ref,
                            'article_link' => $article_ref
                        )
                );
                /*
                 * Insert upload file data
                 */
                $file = Helpers::uploadCampaignFile(Input::file('incorporation_cert'), $incorporation_cert_ref);
                Helpers::uploadFileData($incorporation_cert_ref, $file['original'], $file['alias']);
                if (Input::hasFile('awards_search')) {
                    $file = Helpers::uploadCampaignFile(Input::file('awards_search'), $award_ref);
                    Helpers::uploadFileData($award_ref, $file['original'], $file['alias']);
                }
                if (Input::hasFile('articles_search')) {
                    $file = Helpers::uploadCampaignFile(Input::file('articles_search'), $article_ref);
                    Helpers::uploadFileData($article_ref, $file['original'], $file['alias']);
                }
                /*
                 * Progress Campaign progress
                 */
                Helpers::progressCampaign(Input::get('campaign'), 2);
            } else {
				$incorporation_cert_ref = Input::get('incorporation_cert_h');
				$award_ref = Input::get('awards_search_h');
				$article_ref = Input::get('articles_search_h');
                DB::table('tbl_campaign_companyinfo')->where('campaign_id', Helpers::getCampaignID(Input::get('campaign')))->update(
                        array(
                            'country_of_ops' => Input::get('country_of_ops'),
                            //'incorporation_cert' => $incorporation_cert_ref,
                            'incorporation_no' => Input::get('incorporation_no'),
                            'incorporation_date' => Input::get('incorporation_date'),
                            'postal_address' => Input::get('postal_address'),
                            'physical_address' => Input::get('physical_address'),
                            'nominal_capital' => Input::get('nominal_capital'),
                            'share_value' => Input::get('share_value'),
                            'allocated_shares' => Input::get('allocated_shares'),
                            'unallocated_shares' => Input::get('unallocated_shares'),
                            'total_no_shares' => Input::get('allocated_shares') + Input::get('unallocated_shares'),
                            'director_loans' => Input::get('director_loans'),
                            'no_directors' => Input::get('no_directors'),
                            'no_shareholders' => Input::get('no_shareholders'),
                            'product_description' => Input::get('product_description'),
                            'product_use' => Input::get('product_use'),
                            'customer_base' => Input::get('customer_base'),
                            'age_group' => Input::get('age_group'),
                            'location' => Input::get('location'),
                            'category' => Input::get('category'),
                            'customer_xtics' => Input::get('customer_xtics'),
                            'other_info' => Input::get('other_info'),
                            //'awards' => $award_ref,
                            //'article_link' => $article_ref
                        )
                );
                /*
                 * Insert upload file data
                 */
                if (Input::hasFile('incorporation_cert')) {
                    $file = Helpers::uploadCampaignFile(Input::file('incorporation_cert'), $incorporation_cert_ref);
                    //Helpers::uploadFileData(Input::get('incorporation_cert_h'), $file['original'], $file['alias'], true);
                }
                if (Input::hasFile('awards_search')) {
                    $file = Helpers::uploadCampaignFile(Input::file('awards_search'), $award_ref);
                    //Helpers::uploadFileData(Input::get('awards_search_h'), $file['original'], $file['alias']);
                }
                if (Input::hasFile('articles_search')) {
                    $file = Helpers::uploadCampaignFile(Input::file('articles_search'), $article_ref);
                    //Helpers::uploadFileData(Input::get('articles_search_h'), $file['original'], $file['alias']);
                }
            }
            $tab = explode("_", Input::get('activetab'));
            $active_tab = "tab_" . ($tab[1] + 1); 
            return Redirect::to(URL::route('campaign_info', array(
                                'campaign' => Input::get('campaign')))
                    )->with('activetab', $active_tab);
        }
    }

    public function SaveMarketInfo() {
        $rules = array(
            'target_market' => 'required',
            'gender_2' => 'required',
            'age_group_2' => 'required',
            'location_2' => 'required',
            'category_2' => 'required',
            'characteristics_2' => 'required',
            'other_2' => 'required',
            'reach' => 'required',
            'growth_desc' => 'required',
            'biz_industry' => 'required',
            'plyr_in_industry' => 'required',
            'plyr_ent_last_year' => 'required',
            'growth' => 'required',
            'new_trends' => 'required',
            'market_share' => 'required',
            'charts_search' => 'mimes:jpg,jpeg,png,pdf'
        );
        $validator = Validator::make(Input::all(), $rules);

        // check if the validator failed -----------------------
        if ($validator->fails()) {
            return Redirect::to(URL::previous())
                            ->withErrors($validator)
                            ->withInput()
                            ->with('activetab', Input::get('activetab'));
        } else {
            
            if (Helpers::isNewCampaign(Input::get('campaign'), 3)) {
				$charts_search_ref = Helpers::getUniqueID();
				
                DB::table('tbl_campaign_market')->insert(
                        array(
                            'campaign_id' => Helpers::getCampaignID(Input::get('campaign')),
                            'target_market' => Input::get('target_market'),
                            'gender' => Input::get('gender_2'),
                            'age_group' => Input::get('age_group_2'),
                            'location' => Input::get('location_2'),
                            'category' => Input::get('category_2'),
                            'characteristics' => Input::get('characteristics_2'),
                            'other' => Input::get('other_2'),
                            'reach' => Input::get('reach'),
                            'growth_desc' => Input::get('growth_desc'),
                            'biz_industry' => Input::get('biz_industry'),
                            'plyr_in_industry' => Input::get('plyr_in_industry'),
                            'plyr_ent_last_year' => Input::get('plyr_ent_last_year'),
                            'growth' => Input::get('growth'),
                            'new_trends' => Input::get('new_trends'),
                            'market_share' => Input::get('market_share'),
                            'graph' => $charts_search_ref
                        )
                );
                if (Input::hasFile('charts_search')) {
                    $file = Helpers::uploadCampaignFile(Input::file('charts_search'), $charts_search_ref);
                    Helpers::uploadFileData($charts_search_ref, $file['original'], $file['alias']);
                }
                Helpers::progressCampaign(Input::get('campaign'), 3);
            } else {
                DB::table('tbl_campaign_market')->where('campaign_id', Helpers::getCampaignID(Input::get('campaign')))->update(
                        array(
                            'target_market' => Input::get('target_market'),
                            'gender' => Input::get('gender_2'),
                            'age_group' => Input::get('age_group_2'),
                            'location' => Input::get('location_2'),
                            'category' => Input::get('category_2'),
                            'characteristics' => Input::get('characteristics_2'),
                            'other' => Input::get('other_2'),
                            'reach' => Input::get('reach'),
                            'growth_desc' => Input::get('growth_desc'),
                            'biz_industry' => Input::get('biz_industry'),
                            'plyr_in_industry' => Input::get('plyr_in_industry'),
                            'plyr_ent_last_year' => Input::get('plyr_ent_last_year'),
                            'growth' => Input::get('growth'),
                            'new_trends' => Input::get('new_trends'),
                            'market_share' => Input::get('market_share')
                        )
                );
                $charts_search_ref = Input::get('charts_search_h');
                if (Input::hasFile('charts_search')) {
                    $file = Helpers::uploadCampaignFile(Input::file('charts_search'), $charts_search_ref);
                    //Helpers::uploadFileData(Input::get('charts_search_h'), $file['original'], $file['alias']);
                }
            }
            $tab = explode("_", Input::get('activetab'));
            $active_tab = "tab_" . ($tab[1] + 1); 
            return Redirect::to(URL::route('campaign_info', array(
                                'campaign' => Input::get('campaign')))
                    )->with('activetab', $active_tab);
        }
    }

    public function SaveProposal() {

        $rules = array(
            'no_shares_on_offer' => 'required',
            'percent_equity_on_offer' => 'required|integer|min:1',
            'share_price' => 'required',
            'min_indie_investment' => 'required|integer|min:1',
            'max_indie_investment' => 'required|integer|min:1',
            'board_seat' => 'required',
            'board_seat_investment' => 'required_if:board_seat,yes',
            'dividends_policy' => 'required',
            'voting_rights' => 'required',
            'investor_industry' => 'required',
            'investor_input' => 'required',
            'funds_use' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // check if the validator failed -----------------------
        if ($validator->fails()) {
            return Redirect::to(URL::previous())
                            ->withErrors($validator)
                            ->withInput()
                            ->with('activetab', Input::get('activetab'));
        } else {
            if (Helpers::isNewCampaign(Input::get('campaign'), 4)) {
                DB::table('tbl_campaign_proposal')->insert(
                        array(
                            'campaign_id' => Helpers::getCampaignID(Input::get('campaign')),
                            'no_shares_on_offer' => Input::get('no_shares_on_offer'),
                            'percent_equity_on_offer' => Input::get('percent_equity_on_offer'),
                            'share_price' => Input::get('share_price'),
                            'total_investment' => Input::get('share_price') * Input::get('no_shares_on_offer'),
                            'min_indie_investment' => Input::get('min_indie_investment'),
                            'min_indv_shares' => ceil((Input::get('share_price') * Input::get('no_shares_on_offer')) / Input::get('min_indie_investment')),
                            'max_indie_investment' => Input::get('max_indie_investment'),
                            'max_indv_shares' => ceil((Input::get('share_price') * Input::get('no_shares_on_offer')) / Input::get('max_indie_investment')),
                            'max_no_inv' => ceil(Input::get('min_indie_investment') / Input::get('share_price')),
                            'min_no_inv' => ceil(Input::get('max_indie_investment') / Input::get('share_price')),
                            'board_seat' => Input::get('board_seat'),
                            'board_seat_investment' => (Input::get('board_seat') == 'yes' ? Input::get('board_seat_investment') : ''),
                            'board_no_shares' => (Input::get('board_seat') == 'yes' ? ceil(Input::get('board_seat_investment') * Input::get('no_shares_on_offer') * 0.01) : ''),
                            'dividends_policy' => Input::get('dividends_policy'),
                            'voting_rights' => Input::get('voting_rights'),
                            'investor_industry' => Input::get('investor_industry'),
                            'investor_input' => Input::get('investor_input'),
                            'funds_use' => Input::get('funds_use')
                        )
                );
                Helpers::progressCampaign(Input::get('campaign'), 4);
            } else {
                DB::table('tbl_campaign_proposal')->where('campaign_id', Helpers::getCampaignID(Input::get('campaign')))->update(
                        array(
                            'no_shares_on_offer' => Input::get('no_shares_on_offer'),
                            'percent_equity_on_offer' => Input::get('percent_equity_on_offer'),
                            'share_price' => Input::get('share_price'),
                            'total_investment' => Input::get('share_price') * Input::get('no_shares_on_offer'),
                            'min_indie_investment' => Input::get('min_indie_investment'),
                            'min_indv_shares' => ceil((Input::get('share_price') * Input::get('no_shares_on_offer')) / Input::get('min_indie_investment')),
                            'max_indie_investment' => Input::get('max_indie_investment'),
                            'max_indv_shares' => ceil((Input::get('share_price') * Input::get('no_shares_on_offer')) / Input::get('max_indie_investment')),
                            'max_no_inv' => ceil(Input::get('min_indie_investment') / Input::get('share_price')),
                            'min_no_inv' => ceil(Input::get('max_indie_investment') / Input::get('share_price')),
                            'board_seat' => Input::get('board_seat'),
                            'board_seat_investment' => (Input::get('board_seat') == 'yes' ? Input::get('board_seat_investment') : ''),
                            'board_no_shares' => (Input::get('board_seat') == 'yes' ? ceil(Input::get('board_seat_investment') * Input::get('no_shares_on_offer') * 0.01) : ''),
                            'dividends_policy' => Input::get('dividends_policy'),
                            'voting_rights' => Input::get('voting_rights'),
                            'investor_industry' => Input::get('investor_industry'),
                            'investor_input' => Input::get('investor_input'),
                            'funds_use' => Input::get('funds_use')
                        )
                );
            }
            $tab = explode("_", Input::get('activetab'));
            $active_tab = "tab_" . ($tab[1] + 1); 
            return Redirect::to(URL::route('campaign_info', array(
                                'campaign' => Input::get('campaign')))
                    )->with('activetab', $active_tab);
        }
    }

    public function SaveTeam() { //var_dump(Input::all());exit;
        $rules = array(
            'name' => 'required',
            'title' => 'required',
            'role' => 'required',
            'experience' => 'required',
            'qualifications' => 'required',
            'description' => 'required',
            'cv_search' => 'required_if:cv_search_h,0|image',
            'pics_search' => 'required_if:pics_search_h,0|image'
        );
        $validator = Validator::make(Input::all(), $rules);

        // check if the validator failed -----------------------
        if ($validator->fails()) {
            return Redirect::to(URL::previous())
                            ->withErrors($validator)
                            ->withInput()
                            ->with('activetab', Input::get('activetab'));
        } else { 
			
            if (Helpers::isNewCampaign(Input::get('campaign'), 5)) { 
				$cv_search_ref = Helpers::getUniqueID();
				$pics_search_ref = Helpers::getUniqueID();
            
                DB::table('tbl_campaign_team')->insert(
                        array(
                            'campaign_id' => Helpers::getCampaignID(Input::get('campaign')),
                            'name' => Input::get('name'),
                            'title' => Input::get('title'),
                            'role' => Input::get('role'),
                            'experience' => Input::get('experience'),
                            'qualifications' => Input::get('qualifications'),
                            'description' => Input::get('description'),
                            'picture' => $pics_search_ref,
                            'cv' => $cv_search_ref
                        )
                );
                $file = Helpers::uploadCampaignFile(Input::file('pics_search'), $pics_search_ref);
                Helpers::uploadFileData($pics_search_ref, $file['original'], $file['alias']);

                $file = Helpers::uploadCampaignFile(Input::file('cv_search'), $cv_search_ref);
                Helpers::uploadFileData($cv_search_ref, $file['original'], $file['alias']);

                Helpers::progressCampaign(Input::get('campaign'), 5);
            }elseif(null !== Input::get('team_id') && Input::get('team_id') > 0){//update team member
				DB::table('tbl_campaign_team')->where('id', Input::get('team_id'))->update(
                        array(
                            'name' => Input::get('name'),
                            'title' => Input::get('title'),
                            'role' => Input::get('role'),
                            'experience' => Input::get('experience'),
                            'qualifications' => Input::get('qualifications'),
                            'description' => Input::get('description')
                        )
                );
                $cv_search_ref = Input::get('cv_search_h');
				$pics_search_ref = Input::get('pics_search_h');
				
                if (Input::hasFile('pics_search')) {
                    $file = Helpers::uploadCampaignFile(Input::file('pics_search'), $pics_search_ref);
                    //Helpers::uploadFileData(Input::get('pics_search_h'), $file['original'], $file['alias'], true);
                }
                if (Input::hasFile('cv_search')) {
                    $file = Helpers::uploadCampaignFile(Input::file('cv_search'), $cv_search_ref);
                    //Helpers::uploadFileData(Input::get('cv_search_h'), $file['original'], $file['alias'], true);
                }
			}else { //new member
				$cv_search_ref = Helpers::getUniqueID();
				$pics_search_ref = Helpers::getUniqueID();
            
                DB::table('tbl_campaign_team')->insert(
                        array(
                            'campaign_id' => Helpers::getCampaignID(Input::get('campaign')),
                            'name' => Input::get('name'),
                            'title' => Input::get('title'),
                            'role' => Input::get('role'),
                            'experience' => Input::get('experience'),
                            'qualifications' => Input::get('qualifications'),
                            'description' => Input::get('description'),
                            'picture' => $pics_search_ref,
                            'cv' => $cv_search_ref
                        )
                );
                $file = Helpers::uploadCampaignFile(Input::file('pics_search'), $pics_search_ref);
                Helpers::uploadFileData($pics_search_ref, $file['original'], $file['alias']);

                $file = Helpers::uploadCampaignFile(Input::file('cv_search'), $cv_search_ref);
                Helpers::uploadFileData($cv_search_ref, $file['original'], $file['alias']);
                
            }
            $tab = explode("_", Input::get('activetab'));
            $active_tab = "tab_" . ($tab[1] + 1); 
            return Redirect::to(URL::route('campaign_info', array(
                                'campaign' => Input::get('campaign')))
                    )->with('activetab', $active_tab);
        }
    }

    public function SaveSummaryStatement() {
        $rules = array(
            'summary' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // check if the validator failed -----------------------
        if ($validator->fails()) {
            return Redirect::to(URL::previous())
                            ->withErrors($validator)
                            ->withInput()
                            ->with('activetab', Input::get('activetab'));
        } else {
            if (Helpers::isNewCampaign(Input::get('campaign'), 6)) {
                DB::table('tbl_campaign_summary_stmnt')->insert(
                        array(
                            'campaign_id' => Helpers::getCampaignID(Input::get('campaign')),
                            'summary' => Input::get('summary'))
                );
                Helpers::progressCampaign(Input::get('campaign'), 6);
            } else {
                DB::table('tbl_campaign_summary_stmnt')->where('campaign_id', Helpers::getCampaignID(Input::get('campaign')))->update(
                        array('summary' => Input::get('summary'))
                );
            }
            $tab = explode("_", Input::get('activetab'));
            $active_tab = "tab_" . ($tab[1] + 1); 
            return Redirect::to(URL::route('campaign_info', array(
                                'campaign' => Input::get('campaign')))
                    )->with('activetab', $active_tab);
        }
    }

    public function SaveFinancials() { error_log("save financial....");
		$rules = array(
            'f_statement' => 'image|required_if:f_statement_h,0'
        );
        $validator = Validator::make(Input::all(), $rules);

        // check if the validator failed -----------------------
        if ($validator->fails()) {
            return Redirect::to(URL::previous())
                            ->withErrors($validator)
                            ->withInput()
                            ->with('activetab', Input::get('activetab'));
        } else {            
            if (Helpers::isNewCampaign(Input::get('campaign'), 7)) {
				$f_statement_ref = Helpers::getUniqueID();
				
                DB::table('tbl_campaign_financials')->insert(
                        array(
                            'campaign_id' => Helpers::getCampaignID(Input::get('campaign')),
                            'financial_statement' => $f_statement_ref,
                        )
                );
                // Insert upload file data
                $file = Helpers::uploadCampaignFile(Input::file('f_statement'), $f_statement_ref);
                
                // Progress Campaign progress
                Helpers::progressCampaign(Input::get('campaign'), 7);
            } else {
				$f_statement_ref = Input::get('f_statement_h');
				
                // Insert upload file data
                if (Input::hasFile('f_statement')) {error_log("saving image....");
                    $file = Helpers::uploadCampaignFile(Input::file('f_statement'), $f_statement_ref);
                }
                
            }
            $tab = explode("_", Input::get('activetab'));
            $active_tab = "tab_" . ($tab[1] + 1); 
            return Redirect::to(URL::route('campaign_info', array(
                                'campaign' => Input::get('campaign')))
                    )->with('activetab', $active_tab);
        }
            
    }

    public function SaveBusinessPlan() {
        DB::table('tbl_campaign_business_plan')->insert(
                array('campaign_id' => Helpers::getCampaignID(Input::get('campaign')))
        );
        
        Helpers::progressCampaign(Input::get('campaign'), 8);
        
            $tab = explode("_", Input::get('activetab'));
            $active_tab = "tab_" . ($tab[1] + 1); 
            return Redirect::to(URL::route('campaign_info', array(
                                'campaign' => Input::get('campaign')))
                    )->with('activetab', $active_tab);
    }

    public function SaveVideo() {
        $rules = array(
            'pitch_video' => 'required|url'
        );
        $validator = Validator::make(Input::all(), $rules);

        // check if the validator failed -----------------------
        if ($validator->fails()) {
            return Redirect::to(URL::previous())
                            ->withErrors($validator)
                            ->withInput()
                            ->with('activetab', Input::get('activetab'));
        } else {
            if (Helpers::isNewCampaign(Input::get('campaign'), 9)) {
                //$video_ref = Helpers::getUniqueID();
                DB::table('tbl_campaign_video')->insert(
                        array(
                            'campaign_id' => Helpers::getCampaignID(Input::get('campaign')),
                            'video_url' => Input::get('pitch_video'))
                );
                /*
                 * Insert upload file data
                 */
                //$file = Helpers::uploadCampaignFile(Input::file('pitch_video'));
                //Helpers::uploadFileData($video_ref, $file['original'], $file['alias']);
                /*
                 * Progress Campaign progress
                 */
                Helpers::progressCampaign(Input::get('campaign'), 9);
            } else {
                DB::table('tbl_campaign_video')->where('campaign_id', Helpers::getCampaignID(Input::get('campaign')))->update(
                        array(
                            'video_url' => Input::get('pitch_video'))
                );
//                if (Input::hasFile('pitch_video')) {
//                    /*
//                     * Insert upload file data
//                     */
//                    $file = Helpers::uploadCampaignFile(Input::file('pitch_video'));
//                    Helpers::uploadFileData(Input::get('pitch_video_h'), $file['original'], $file['alias'], true);
//                }
            }
           // $tab = explode("_", Input::get('activetab'));
           if(Helpers::isCampaignComplete(Input::get('campaign'))){
			   Session::flash('_response', '<div style="width: 98%"><div class="alert alert-success alert-dismissable">
                                <i class="fa fa-check"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <b> Campaign details completed, please go through to confirm details before you publish. </b>
                                </div></div>');
		   }else{
			   Session::flash('_response', '<div style="width: 98%"><div class="alert alert-danger alert-dismissable">
                                <i class="fa fa-ban"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <b>Alert!</b> Campaign not yet complete, please fill all the tabs. </div></div>');
		   }
            $active_tab = "tab_1"; 
            return Redirect::to(URL::route('campaign_info', array(
                                'campaign' => Input::get('campaign')))
                    )->with('activetab', $active_tab);
        }
    }

    /*
     * Process Campaign Actions
     */

    public function ApproveCampaign() {
        $rules = array(
            'comment' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // check if the validator failed -----------------------
        if ($validator->fails()) {
            return Redirect::to(URL::previous())
                            ->withErrors($validator)
                            ->with('err', '<div class="alert alert-danger alert-dismissable">
                                <i class="fa fa-ban"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <b>Alert!</b> Please enter your comment below.
                            </div>');
        } else {
            $campaign_id = Request::segment(3);
            if (Helpers::isCampaignComplete(Helpers::getCampaignID($campaign_id))) {
                $rs = DB::select("select id,campaigname,user_id from tbl_campaigns where campaignstatus = 'Published' and approvalstatus = 'Pending' 
                         and uniqueid = ?", array($campaign_id));
                if (count($rs[0]) > 0 && strtoupper(Session::get('account_type')) == 'ADMIN') {
					$ongoing_user_campaign = Helpers::getOngoingCampaigns($rs[0]->user_id);
					if(!isset($ongoing_user_campaign[0])){
						DB::table('tbl_campaigns')->where('uniqueid', $campaign_id)->update(
								array(
									'campaignstatus' => 'Ongoing',
									'approvalstatus' => 'Approved')
						);
						
						Session::flash('_response', '<div style="width: 98%"><div class="alert alert-success alert-dismissable">
                                <i class="fa fa-check"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <b>' . $rs[0]->campaigname . '!</b> campaign approved.
                                </div></div>');
					}else{
						DB::table('tbl_campaigns')->where('uniqueid', $campaign_id)->update(
								array(
									'campaignstatus' => 'Shelved',
									'approvalstatus' => 'Approved')
						);
						
						Session::flash('_response', '<div style="width: 98%"><div class="alert alert-success alert-dismissable">
                                <i class="fa fa-check"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <b>' . $rs[0]->campaigname . '!</b> campaign <i>shelved</i>. Entrepreneur has an ongoing campaign - <b>'.$ongoing_user_campaign[0]->campaigname.'</b>
                                </div></div>');
					}
                    
                    $Details = Helpers::getProfileDetails($rs[0]->user_id);
                    Helpers::sendMail(array(
                        "names"     =>$Details[0]->firstname .' '.$Details[0]->lastname,
                        "message"   =>Input::get('comment'),
                        "status"    =>'Approved!',
                        "to"        =>$Details[0]->email_address
                    ));
                } else {
                    Session::flash('_response', '<div style="width: 98%"><div class="alert alert-danger alert-dismissable">
                                <i class="fa fa-ban"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <b>Alert!</b> campaign status change failed. Please try again later.
                                </div></div>');
                }
            } else {
                Session::flash('_response', '<div style="width: 98%"><div class="alert alert-danger alert-dismissable">
                                <i class="fa fa-ban"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <b>Alert!</b> campaign status change failed. Please try again later.
                                </div></div>');
            }
            return Redirect::to(URL::previous());
        }
    }

    public function RejectCampaign() {
        $rules = array(
            'comment' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // check if the validator failed -----------------------
        if ($validator->fails()) {
            return Redirect::to(URL::previous())
                            ->withErrors($validator)
                            ->with('err', '<div class="alert alert-danger alert-dismissable">
                                <i class="fa fa-ban"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <b>Alert!</b> Please enter your comment below.
                            </div>');
        } else {
            $campaign_id = Request::segment(3);
            if (Helpers::isCampaignComplete(Helpers::getCampaignID($campaign_id))) {
                $rs = DB::select("select id,campaigname,user_id from tbl_campaigns where campaignstatus = 'Published' and approvalstatus = 'Pending' 
                         and uniqueid = ?", array($campaign_id));
                if (count($rs[0]) > 0 && strtoupper(Session::get('account_type')) == 'ADMIN') {
                    DB::table('tbl_campaigns')->where('uniqueid', $campaign_id)->update(
                            array(
                                'approvalstatus' => 'pending',
                                'campaignstatus' => 'draft')
                    );
                    Session::flash('_response', '<div style="width: 98%"><div class="alert alert-success alert-dismissable">
                                <i class="fa fa-check"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <b>' . $rs[0]->campaigname . '!</b> campaign marked for review.
                                </div></div>');
                    $Details = Helpers::getProfileDetails($rs[0]->user_id);
                    Helpers::sendMail(array(
                        "names"     =>$Details[0]->firstname .' '.$Details[0]->lastname,
                        "message"   =>Input::get('comment'),
                        "status"    =>'sent back for review.',
                        "to"        =>$Details[0]->email_address
                    ));
                } else {
                    Session::flash('_response', '<div style="width: 98%"><div class="alert alert-danger alert-dismissable">
                                <i class="fa fa-ban"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <b>Alert!</b> campaign status change failed. Please try again later.
                                </div></div>');
                }
            } else {
                Session::flash('_response', '<div style="width: 98%"><div class="alert alert-danger alert-dismissable">
                                <i class="fa fa-ban"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <b>Alert!</b> campaign status change failed. Please try again later.
                                </div></div>');
            }
            return Redirect::to(URL::previous());
        }
    }

    public function DeactivateCampaign() {
        $rules = array(
            'comment' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // check if the validator failed -----------------------
        if ($validator->fails()) {
            return Redirect::to(URL::previous())
                            ->withErrors($validator)
                            ->with('err', '<div class="alert alert-danger alert-dismissable">
                                <i class="fa fa-ban"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <b>Alert!</b> Please enter your comment below.
                            </div>');
        } else {
            $campaign_id = Request::segment(3);
            if (Helpers::isCampaignComplete(Helpers::getCampaignID($campaign_id))) {
                $rs = DB::select("select id,campaigname,user_id from tbl_campaigns where campaignstatus = 'Published' and approvalstatus = 'Pending' 
                         and uniqueid = ?", array($campaign_id));
                if (count($rs[0]) > 0 && strtoupper(Session::get('account_type')) == 'ADMIN') {
                    DB::table('tbl_campaigns')->where('uniqueid', $campaign_id)->update(
                            array('approvalstatus' => 'Rejected')
                    );
                    Session::flash('_response', '<div style="width: 98%"><div class="alert alert-success alert-dismissable">
                                <i class="fa fa-check"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <b>' . $rs[0]->campaigname . '!</b> campaign rejected.
                                </div></div>');
                    $Details = Helpers::getProfileDetails($rs[0]->user_id);
                    Helpers::sendMail(array(
                        "names"     =>$Details[0]->firstname .' '.$Details[0]->lastname,
                        "message"   =>Input::get('comment'),
                        "status"    =>'Rejected.',
                        "to"        =>$Details[0]->email_address
                    ));
                } else {
                    Session::flash('_response', '<div style="width: 98%"><div class="alert alert-danger alert-dismissable">
                                <i class="fa fa-ban"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <b>Alert!</b> campaign status change failed. Please try again later.
                                </div></div>');
                }
            } else {
                Session::flash('_response', '<div style="width: 98%"><div class="alert alert-danger alert-dismissable">
                                <i class="fa fa-ban"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <b>Alert!</b> campaign status change failed. Please try again later.
                                </div></div>');
            }
            return Redirect::to(URL::previous());
        }
    }

    public function PublishCampaign() {
        $campaign_id = Request::segment(3);
        if (Helpers::isCampaignComplete(Helpers::getCampaignID($campaign_id))) {
            $rs = DB::select("select id,campaigname from tbl_campaigns where campaignstatus = 'draft' and approvalstatus = 'Pending' 
                         and uniqueid = ?", array($campaign_id));
            if (count($rs[0]) > 0 && strtoupper(Session::get('account_type')) == 'ENTREPRENEUR') {
                DB::table('tbl_campaigns')->where('uniqueid', $campaign_id)->update(
                        array(
                            'campaignstatus' => 'published')
                );
                Session::flash('_response', '<div style="width: 98%"><div class="alert alert-success alert-dismissable">
                                <i class="fa fa-check"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <b>' . $rs[0]->campaigname . '!</b> campaign has been published successfully.
                                </div></div>');
            } else {
                Session::flash('_response', '<div style="width: 98%"><div class="alert alert-danger alert-dismissable">
                                <i class="fa fa-ban"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <b>Alert!</b> campaign publishing failed. Please try again later.
                                </div></div>');
            }
        } else {
            Session::flash('_response', '<div style="width: 98%"><div class="alert alert-danger alert-dismissable">
                                <i class="fa fa-ban"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <b>Alert!</b> campaign publishing failed. Please try again later.
                                </div></div>');
        }
        return Redirect::to(URL::previous());
    }
    
    public function campaignLike($user_id, $campaignID, $like_option){
		Helpers::getLikes($user_id, $campaignID, $like_option);
	}
	
	
	public static function getLikes($campaignID = false, $user_id=false){		
		if (Request::ajax() && empty($campaignID))
		{
			$campaignID = Input::get('pageID');
			$like_option = Input::get('like_action');
			$user_id = Input::get('userid');
			$date = date('Y-m-d');

			$result = DB::table('mradi_campaign_like')
				->select(DB::raw('`like`, `unlike`, `date`'))
				->where('campaign_id', '=', "$campaignID")
				->where('user_id', '=', "$user_id")
				->get();
			
			if(empty($result)){
				DB::table('mradi_campaign_like')
						->insert(array(
							'user_id'   =>$user_id,
							'campaign_id'=>$campaignID,
							'like' => '1',
							'date' => $date
						));
			}else{
				$like       = $result[0]->like;
				$unlike     = $result[0]->unlike;
				$ldate 		= $result[0]->date;
				
				if($ldate < $date){			
					DB::table('mradi_campaign_like')
						->where('campaign_id',$campaignID)
						->where('user_id', '=', $user_id)
						->increment($like_option,1,array(
                        'date'=>$date
                    ));
				}								
			}
			
				$result = DB::table('mradi_campaign_like')
				->select(DB::raw('`'.$like_option.'`'))
				->where('campaign_id', '=', "$campaignID")
				->get();
							
				if(empty($result)){
					$result[0] = new stdClass();
					$result[0]->likes = 0;
					$result[0]->unlikes = 0;
				}else{
					$count = 0;
					foreach($result as $arr){
						$count += $arr->$like_option;
					}
					
					echo $count;
					die();
				}
		}else{
			$result = DB::table('mradi_campaign_like')
				->select(DB::raw('sum(`like`) as likes, sum(`unlike`) as unlikes'))
				->where('campaign_id', '=', "$campaignID")
				->get();
				
			if(empty($result)){error_log("empty1 -- " );
				$result[0] = new stdClass();
				$result[0]->likes = 0;
				$result[0]->unlikes = 0;
			}
			
			return $result[0];
		}
		
	}    


	public function getBidCampaign($campaignID){
		$campaign = Helpers::getCampaignSummary($campaignID); 
		
		//total investment sought
		$totatInvestment = Helpers::getTotalInvestment($campaignID);
		$cValue = $totatInvestment[0]->total_investment;
		
		//bidding done
		$myBid = Helpers::getTotalBidded($campaignID);
		$totalBid = $myBid ? $myBid->total_bidded : '0'; 
		
		//investor balance
		$user_id = Session::get('account_id');
		$investor_balance = Helpers::investorBalance($user_id);
		
		if(\Request::ajax())
            return View::make('admin.pages.bidder',compact('campaign', 'campaignID', 'cValue', 'totalBid', 'investor_balance'));
	}
	
	public function getTemplateList(){
		$transList = Helpers::getTemplateTransactions(); 
        
        return View::make('admin.pages.template_trans',compact('transList'));
	}
		
		
		
}

