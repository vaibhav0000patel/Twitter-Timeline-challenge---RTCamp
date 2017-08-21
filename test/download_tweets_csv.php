<?php 
	session_start();
	
	include_once 'twConfig.php';
	
	$username = $_SESSION['userData']['username'];
	
	//$username = $_SESSION['request_vars']['screen_name'];
	$twitterId = $_SESSION['request_vars']['user_id'];
	$oauthToken = $_SESSION['request_vars']['oauth_token'];
	$oauthTokenSecret = $_SESSION['request_vars']['oauth_token_secret'];
		
	$twClient = new TwitterOAuth($consumerKey, $consumerSecret, $oauthToken, $oauthTokenSecret);
	
	$myTweets = $twClient->get('statuses/user_timeline', array('screen_name' => $username, 'count' => 10));
	
	$Tweets = array();
	
	foreach($myTweets as $tweet){
		$temp = array();
		array_push($temp,$username);
		array_push($temp,$tweet->text);
		array_push($temp,$tweet->created_at);
		array_push($Tweets,$temp);
	}
	
	$filename = $username."_tweets.csv";
	$fp = fopen('php://output', 'w');
	
	header('Content-type: application/csv');
	header('Content-Disposition: attachment; filename='.$filename);
	//while($row = $Tweets) {
		
	foreach($Tweets as $tw){	
		fputcsv($fp,$tw);
	}
	
	//}
	//exit;
?>