<?php 
	
	header("Content-type: application/pdf");
	
	session_start();
	
	include_once 'twConfig.php';
	//require('lib/phpToPDF.php');
	require_once 'lib/dompdf/autoload.inc.php';
	
	use Dompdf\Dompdf;
	
	$username = $_SESSION['userData']['username'];
	
	$twitterId = $_SESSION['request_vars']['user_id'];
	$oauthToken = $_SESSION['request_vars']['oauth_token'];
	$oauthTokenSecret = $_SESSION['request_vars']['oauth_token_secret'];
		
	$twClient = new TwitterOAuth($consumerKey, $consumerSecret, $oauthToken, $oauthTokenSecret);
	
	if(isset($_GET['screen_name'])){
		
		$username = $_GET['screen_name'];
		
		if(trim($username)==""){
			
			echo "Don't act smart!";
			
		}else if($username=="hometimeline"){
			
			
			$myTweets = $twClient->get('statuses/home_timeline', array('screen_name' => $username, 'count' => 10));
			
			$Tweets = array();
			
				$my_html='<HTML>';
				$my_html.='<head>
							<link href="http://www.ttcvaibhav.ml/css/bootstrap.min.css" rel="stylesheet">
							<link href="http://www.ttcvaibhav.ml/css/font-awesome.min.css" rel="stylesheet">
							<link href="http://www.ttcvaibhav.ml/css/lightbox.css" rel="stylesheet"> 
							<link href="http://www.ttcvaibhav.ml/css/animate.min.css" rel="stylesheet"> 
							<link href="http://www.ttcvaibhav.ml/css/main.css" rel="stylesheet">
							<link href="http://www.ttcvaibhav.ml/css/responsive.css" rel="stylesheet">
							</head>';
				$my_html.='<body>';
				$my_html.='<table>';
				$my_html.='<div class="container">';
				$my_html.='<h1 style="text-align:center;">@'.$_SESSION['userData']['username'].'\'s Home Timeline Tweets</h1><hr/>';
			
					foreach($myTweets as $tweet){
						
							$my_html.='
								<div class="row" style="margin:0px; padding:0px 15px; ">
									<div class="col-md-8 col-md-offset-2" style="">
										<div class="single-blog two-column" >
										   
											<div class="post-content overflow" style="background-color:#f7f7f7;padding:25px;border-radius:5px;">
												<ul class="nav nav-justified post-nav">
													<li><a href="#">Posted on '.date('d-m-Y', strtotime($tweet->created_at)).'</a></li>
												</ul>
												
												<h3 class="post-author"><a href="#">Posted by @'.$tweet->user->screen_name.'</a></h3>
												<p><blockquote>'.$tweet->text.'</blockquote></p>
												
												<div class="post-bottom overflow">
													<ul class="nav nav-justified post-nav">
														<li><a href="#"> '.$tweet->favorite_count.' Love</a></li>
														<li><a href="#"> '.$tweet->retweet_count.' Retweets</a></li>
														
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>';
						 
						
					}
			
				
				
				$my_html.='</div>';
				$my_html.='</body>';
				$my_html.='</html>';
			
			
			
			$filename = $_SESSION['userData']['username']."_".$username."_tweets.pdf";
			
			/*  //Set Your Options -- we are saving the PDF as 'my_filename.pdf' to a 'my_pdfs' folder
			$pdf_options = array(
			  "source_type" => 'html',
			  "source" => $my_html,
			  "action" => 'save',
			  "save_directory" => 'my_pdfs',
			  "file_name" => $filename);

			//echo $my_html;
			//Code to generate PDF file from options above
			phptopdf($pdf_options);
			$pdf_options["action"]="download";
			phptopdf($pdf_options); */
			
			
			$dompdf = new Dompdf();
			$dompdf->loadHtml($my_html);

			$dompdf->setPaper('A4', 'portrait');

			$dompdf->render();

			//$dompdf->stream($filename,array('Attachment'=>false)); 
			echo $dompdf->output(); 
			
			exit(0);
		}else{
	
			$myTweets = $twClient->get('statuses/user_timeline', array('screen_name' => $username, 'count' => 10));
			
			$Tweets = array();
			
			$my_html='<HTML>';
				$my_html.='<head>
							<link href="http://www.ttcvaibhav.ml/css/bootstrap.min.css" rel="stylesheet">
							<link href="http://www.ttcvaibhav.ml/css/font-awesome.min.css" rel="stylesheet">
							<link href="http://www.ttcvaibhav.ml/css/lightbox.css" rel="stylesheet"> 
							<link href="http://www.ttcvaibhav.ml/css/animate.min.css" rel="stylesheet"> 
							<link href="http://www.ttcvaibhav.ml/css/main.css" rel="stylesheet">
							<link href="http://www.ttcvaibhav.ml/css/responsive.css" rel="stylesheet">
							
							</head>';
				$my_html.='<body>';
				$my_html.='<table>';
				$my_html.='<div class="container">';
				$my_html.='<h1 style="text-align:center;">@'.$username.'\'s Tweets</h1><hr/>';
			
					foreach($myTweets as $tweet){
						
							$my_html.='
								<div class="row" style="margin:0px; padding:0px 15px; ">
									<div class="col-md-8 col-md-offset-2" style="">
										<div class="single-blog two-column" >
										   
											<div class="post-content overflow" style="background-color:#f7f7f7;padding:25px;border-radius:5px;">
												<ul class="nav nav-justified post-nav">
													<li><a href="#">Posted on '.date('d-m-Y', strtotime($tweet->created_at)).'</a></li>
												</ul>
												 
												<h3 class="post-author"><a href="#">Posted by @'.$username.'</a></h3>
												<p><blockquote>'.$tweet->text.'</blockquote></p>
												
												<div class="post-bottom overflow">
													<ul class="nav nav-justified post-nav">
														<li><a href="#"> '.$tweet->favorite_count.' Love</a></li>
														<li><a href="#"> '.$tweet->retweet_count.' Retweets</a></li>
														
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>';
						 
						
					}
			
				
				
				$my_html.='</div>';
				$my_html.='</body>';
				$my_html.='</html>';
				
				
			$filename = $username."_tweets.pdf";
			
			

			/*//Set Your Options -- we are saving the PDF as 'my_filename.pdf' to a 'my_pdfs' folder
			$pdf_options = array(
			  "source_type" => 'html',
			  "source" => $my_html,
			  "action" => 'save',
			  "save_directory" => 'my_pdfs',
			  "file_name" => $filename);
			
			//echo $my_html;
			
			//Code to generate PDF file from options above
			phptopdf($pdf_options);
			$pdf_options["action"]="download";
			phptopdf($pdf_options);*/
			
			
			$dompdf = new Dompdf();
			$dompdf->loadHtml(html_entity_decode($my_html));

			$dompdf->setPaper('A4', 'portrait');

			$dompdf->render();
		
			echo $dompdf->output(); 
			exit(0);
		}
	}else{
		
		echo "Don't act smart!";
	}
	exit(0);
	
?>