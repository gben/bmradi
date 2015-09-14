<?php

class SendEmailController extends BaseController {

    public function SendEmail() {
        /*
         * validate the Inputs sent
         */
        $rules = array(
            'email_cc'  =>  "required_if:email_to,''|required_if:email_bcc,''", 
            'email_to'  =>  "required_if:email_cc,''|required_if:email_bcc,''",
            'email_bcc' =>  "required_if:email_cc,''|required_if:email_to,''", 
            'message'   =>  'required',
            'subject'   =>  'required'
        );
        $messages = array(
            "required_without" => "Please select atleast one recipient",
            "subject.required"=>"Please enter message subject",
            "message.required"=>"Please enter message to send",
        );
        $validator = Validator::make(Input::all(), $rules,$messages);       
        $messages = $validator->messages();
        if ($validator->fails()) {
            return Redirect::to(URL::previous())
                            ->withErrors($validator)
                            ->withInput();
        } else {
            if(Conversation::saveEmail())
            {
                Session::flash('_feedback', '<div class="alert alert-info alert-dismissable">
                                <i class="fa fa-info"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Alert!</b>
                                Email has been successfully queued for sending</div>');
                //Helpers::uploadCampaignFile(Input::file('attachment'), $attachment_ref);
                return Redirect::to(URL::route('conversation'));
            }  else {
                Session::flash('_feedback', '<div class="alert alert-info alert-dismissable">
                                <i class="fa fa-info"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><b>Alert!</b>
                                Error occured, please try again later</div>');
                return Redirect::to(URL::route('conversation'));
            }
        }
    }

}

