<?php

$campaignID = $_POST['pageID'];
$like_option = $_POST['like_action'];
$user_id = $_POST['userid'];

$conn = mysqli_connect("localhost", "germinit_dbx", "mr@di20!5", "germinit_mradi_dbx");


 if(!empty($campaignID) && !empty($like_option) && !empty($user_id)){ 
		
		$result = mysqli_query($conn, "select `like`, `unlike` from mradi_campaign_like where campaign_id = '".$campaignID."' and user_id ='".$user_id."'");
		$row = mysqli_fetch_array($result);
		
		
		/*DB::table('mradi_campaign_like')
			->select(DB::raw('`like`, `unlike`'))
			->where('campaign_id', '=', "$campaignID")
			->where('user_id', '=', $user_id)
			->get();*/
		
		if(empty($row)){
			$res = mysqli_query($conn, "insert into mradi_campaign_like set user_id='".$user_id."', campaign_id='".$campaignID."', `like`=1");
			/*DB::table('mradi_campaign_like')
                    ->insert(array(
                        'user_id'   =>Session::get('account_id'),
                        'campaign_id'=>$campaignID,
                        'like' => '1'
                    ));*/
		}else{error_log("increment");
			$like       = $row['like'];
			$unlike     = $row['unlike'];
			
			$res = mysqli_query($conn, "update mradi_campaign_like set `$like_option` = `$like_option` +1 where campaign_id='".$campaignID."' and user_id='".$user_id."'");
			
			/*DB::table('mradi_campaign_like')
                    ->where('campaign_id',$campaignID)
                    ->where('user_id', '=', Session::get('account_id'))
                    ->increment($like_option,1);*/
		
			if(isset($_COOKIE["counter_gang"]))
			{
				return $result;
			}
			setcookie("mradi_counter", "liked", time()+3600*24, "/like-unlike-campaign/", ".mradi.com");
			
		}
                    
           /* $result = DB::table('mradi_campaign_like')
			->select(DB::raw('sum(`like`) as likes, sum(`unlike`) as unlikes'))
			->where('campaign_id', '=', "$campaignID")
			->get();*/
			
			$result = mysqli_query($conn, "select `like`, `unlike` from mradi_campaign_like where campaign_id = '".$campaignID."'");
			$row = mysqli_fetch_array($result);
			
			echo $row[$like_option];
			exit;
			//return $row;
		
	}
