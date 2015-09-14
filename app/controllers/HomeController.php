<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccountController
 *
 * @author ALLAN
 */

class HomeController extends BaseController {


    public function showWelcome() {
        return View::make('hello');
    }

    public function article() {
        return View::make('article_post', array('article_info' => Post::get_post_detail(Input::get('article_id'))));
    }
    
    
    public function loginWithFacebook() {

        // get data from input
        $code = Input::get( 'code' );

        // get fb service
        $fb = OAuth::consumer( 'Facebook' );

        // check if code is valid

        // if code is provided get user data and sign in
        if ( !empty( $code ) ) {

            // This was a callback request from facebook, get the token
            $token = $fb->requestAccessToken( $code );

            // Send a request with it
            $result = json_decode( $fb->request( '/me' ), true );

            $message = 'Your unique facebook user id is: ' . $result['id'] . ' and your name is ' . $result['name'];
            echo $message. "<br/>";

            //Var_dump
            //display whole array().
            dd($result);

        }
        // if not ask for permission first
        else {
            // get fb authorization
            $url = $fb->getAuthorizationUri();

            // return to facebook login url
             return Redirect::to( (string)$url );
        }

    }
    
    
    public function getCampaignDetails($campaign_id){
		$uniqid = Helpers::getUniqueCampaignID($campaign_id);
		$myDetails = Helper::getCampaignSummary($uniqid);
		$myVideo = Helper::getVideoContent($uniqid);
		if (empty($myVideo)) {
               $myVideo[0] = new stdClass();
               $myVideo[0]->video_url = "no video";
        }
		
		if(\Request::ajax())
            return View::make('campaign_details',compact('myVideo', 'myDetails',  'campaign_id'));
        
	}

}
