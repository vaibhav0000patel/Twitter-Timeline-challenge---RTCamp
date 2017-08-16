<?php 
	
	session_start();

		include_once 'twConfig.php';
		
		if(isset($_REQUEST['oauth_token']) && $_SESSION['token'] !== $_REQUEST['oauth_token']){
			//Remove token from session
			unset($_SESSION['token']);
			unset($_SESSION['token_secret']);
		}
		
		if(isset($_SESSION['status']) && $_SESSION['status'] == 'verified' && !empty($_SESSION['request_vars'])){
			
			$username = $_SESSION['request_vars']['screen_name'];
			$twitterId = $_SESSION['request_vars']['user_id'];
			$oauthToken = $_SESSION['request_vars']['oauth_token'];
			$oauthTokenSecret = $_SESSION['request_vars']['oauth_token_secret'];
			
				
			$twClient = new TwitterOAuth($consumerKey, $consumerSecret, $oauthToken, $oauthTokenSecret);
		
			if(isset($_POST['fetch_tweets'])){
				
				$screen_name = $_POST['screen_name'];
				$myTweets = $twClient->get('statuses/user_timeline', array('screen_name' => $screen_name, 'count' => 10));
				
				
				echo json_encode($myTweets);
			}else if(isset($_POST['fetch_users'])){
				
				$q = $_POST['q'];
				$myTweets = $twClient->get('users/search', array('q' => $q, 'count' => 10));
				
				
				echo json_encode($myTweets);
			}
			
		}


?>