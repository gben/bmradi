<?php

class CampaignController extends BaseController {

    public function logOut() {
        Session::flush();
        return Redirect::to('/');
    }

    public function SaveCampaignSummary() {
        $rules = array(
            'listing_logo' => 'required',
            'business_name' => 'required|between:1,50',
            'business_summary' => 'required|between:2,140',
            'min_investment' => 'required|numeric',
            'money_valuation' => 'numeric',
            'max_investment' => 'required|numeric',
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
                        ->with('activetab',Input::get('activetab'));
        } else {
            Helpers::logData("Saving Campaign Summary");
            if(Helpers::isNewCampaign(Input::get('campaign'), 1))
            {
                DB::table('tbl_campaign_summary')->insert(
                    array(
                        'campaign_id' => Input::get('campaign'),
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
            }else{               
             DB::table('tbl_campaign_summary')->where('campaign_id', Input::get('campaign'))->update(
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
            }
            return Redirect::to(URL::route('campaign_info', array(
                    'campaign' => Input::get('campaign')))
                  )->with('activetab',Input::get('activetab'));
        }
    }

    public function SaveCompanyDetails() {
        DB::table('tbl_company_info')->insert(
                array('id' => Input::get(''),
                    'campaign_id' => Input::get('campaign'),
                    'country_of_ops' => Input::get(''),
                    'incorporation_no' => Input::get(''),
                    'incorporation_date' => Input::get(''),
                    'incorporation_cert' => Input::get(''),
                    'postal_address' => Input::get(''),
                    'physical_address' => Input::get(''),
                    'nominal_capital' => Input::get(''),
                    'share_value' => Input::get(''),
                    'allocated_shares' => Input::get(''),
                    'total_no_shares' => Input::get(''),
                    'director_loans' => Input::get(''),
                    'no_directors' => Input::get(''),
                    'no_shareholders' => Input::get(''),
                    'product_description' => Input::get(''),
                    'product_use' => Input::get(''),
                    'customer_base' => Input::get(''),
                    'age_group' => Input::get(''),
                    'location' => Input::get(''),
                    'category' => Input::get(''),
                    'customer_xtics' => Input::get(''),
                    'other_info' => Input::get(''),
                    'revenue' => Input::get(''),
                    'sale_size' => Input::get(''),
                    'advantages' => Input::get(''),
                    'challenges' => Input::get(''),
                    'accomplishments' => Input::get(''),
                    'awards' => Input::get(''),
                    'article_link' => Input::get(''),
                    'status' => Input::get(''),
                    'completion_time' => Input::get(''))
        );
    }

    public function SaveMarketDescription() {
        DB::table('tbl_campaign_market')->insert(
                array('id' => Input::get(''),
                    'campaign_id' => Input::get('campaign'),
                    'target_market' => Input::get(''),
                    'gender' => Input::get(''),
                    'age_group' => Input::get(''),
                    'location' => Input::get(''),
                    'category' => Input::get(''),
                    'characteristics' => Input::get(''),
                    'other' => Input::get(''),
                    'reach' => Input::get(''),
                    'growth_desc' => Input::get(''),
                    'biz_industry' => Input::get(''),
                    'plyr_in_industry' => Input::get(''),
                    'plyr_ent_last_year' => Input::get(''),
                    'growth' => Input::get(''),
                    'graph' => Input::get(''),
                    'new_trends' => Input::get(''),
                    'market_share' => Input::get(''),
                    'status' => Input::get(''),
                    'completion_time' => Input::get(''))
        );
    }

    public function SaveProposal() {
        DB::table('tbl_campaign_proposal')->insert(
                array('id' => Input::get(''),
                    'campaign_id' => Input::get(''),
                    'no_shares_on_offer' => Input::get(''),
                    'percent_equity_on_offer' => Input::get(''),
                    'share_price' => Input::get(''),
                    'min_indie_investment' => Input::get(''),
                    'max_indie_investment' => Input::get(''),
                    'board_seat' => Input::get(''),
                    'board_seat_investment' => Input::get(''),
                    'board_no_shares' => Input::get(''),
                    'dividends_policy' => Input::get(''),
                    'voting_rights' => Input::get(''),
                    'investor_industry' => Input::get(''),
                    'investor_input' => Input::get(''),
                    'funds_use' => Input::get(''),
                    'status' => Input::get(''),
                    'completion_time' => Input::get(''))
        );
    }

    public function SaveTeam() {
        DB::table('tbl_campaign_team')->insert(
                array('id' => Input::get(''),
                    'campaign_id' => Input::get(''),
                    'name' => Input::get(''),
                    'title' => Input::get(''),
                    'role' => Input::get(''),
                    'qualifications' => Input::get(''),
                    'experience' => Input::get(''),
                    'description' => Input::get(''),
                    'picture' => Input::get(''),
                    'cv' => Input::get(''),
                    'status' => Input::get(''),
                    'completion_time' => Input::get(''))
        );
    }

    public function SaveSummaryStatement() {
        DB::table('tbl_campaign_closeup')->insert(
                array('proposal_summary' => Input::get(''))
        );
    }

    public function SaveFinancials() {
        DB::table('tbl_campaign_closeup')->insert(
                array('financials' => Input::get(''))
        );
    }

    public function SaveBusinessPlan() {
        DB::table('tbl_campaign_closeup')->insert(
                array('business_plan' => Input::get(''))
        );
    }

    public function SaveVideo() {
        DB::table('tbl_campaign_closeup')->insert(
                array(
                    'video' => Input::get(''))
        );
    }

}

