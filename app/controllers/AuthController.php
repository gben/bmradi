<?php

class AuthController extends BaseController 
{
    public function validateUser() {
        $email = Input::get('_username');
        $password  = hash('sha256', Input::get('_password'));
        $account_type = (Input::get('account_type')=='other'?'Admin':Input::get('account_type'));
       
        $results = DB::select("select * from accounts_dbx where email_address = ? and password = ? and account_type = ?", array($email, $password,$account_type)); 
        if(empty($results)){
            Helpers::logAction($email." attempted to login as ". $account_type,false);
            Helpers::logData("select * from accounts_dbx where email_address = $email and password = $password and account_type = $account_type");
            Session::flash('login_message', '<div class="alert alert-danger" style="width: 500px;">Error login! Please try again</div>');
            return Redirect::route('login');
        } else{
            $status = '';            
            foreach($results as $item){
                Session::put('email_address', $item->email_address);
                Session::put('account_id', $item->account_id);
                Session::put('username', $item->email_address);
                Session::put('firstname',$item->firstname);
                Session::put('fullnames',$item->firstname. " " . $item->lastname);
                Session::put('membersince',date("M. Y", strtotime($item->date_created)));
                Session::put('country', $item->country);
                Session::put('gender', $item->gender);
                Session::put('phone_no', $item->phone);
                Session::put('account_type', $item->account_type);
                Session::put('rec_per_page',Helpers::getGlobalValue('RECORDS_PER_PAGE'));
                Session::put('template_price',Helpers::getGlobalValue('TEMPLATE_COST'));
                $status = $item->account_status;
            }
            Helpers::logAction("Logged in successfully");
            
            if($status == 'ACTIVE')
            {
                return Redirect::route('dashboard');                
            }else
            {
                Session::flash('login_message', '<div class="alert alert-danger" style="width: 500px;">Error login! Account hasn\'t been activated yet</div>');
                return Redirect::route('login');
            }            
        }
    }
    public function changePassword()
    {
        $rules = array(
            'password' => 'required|min:8',
            'password_confirm' => 'required|min:8|same:password'
        );
        $validator = Validator::make(Input::all(), $rules);
        $messages = $validator->messages();
        if ($validator->fails()) {
            return Redirect::to(URL::previous())
                            ->withErrors($validator);
        }else
        {
            /*
             * update to changed password
             */
            DB::table('accounts_dbx')
                    ->where('account_id', Session::get('account_id'))
                    ->update(array(
                        'password' => hash('sha256', Input::get('password')),
                        'change_password'=>'1',
                        'last_updated'=>date('Y-m-d H:i:s')
                    ));
            Helpers::logAction("Changed password");
            return Redirect::route('dashboard');
        }
    }
    public function logOut(){
        Session::flush(); 
        return Redirect::to('/'); 
    }    
}
?>
