<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Twitter Timeline Challenge [Vaibhav Patel] | RTCamp</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/lightbox.css" rel="stylesheet"> 
    <link href="css/animate.min.css" rel="stylesheet"> 
	<link href="css/main.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">


    <link rel="shortcut icon" href="images/ico/favicon.ico">
	
	<?php
		

		include_once 'twConfig.php';
		
		
		if(isset($_REQUEST['oauth_token']) && ($_SESSION['token'] !== $_REQUEST['oauth_token'])){
			unset($_SESSION['token']);
			unset($_SESSION['token_secret']);
		}
	
	?>
	
	
	<style>
		#slider-tweets{
			color: rgb(38, 219, 228);
			text-shadow: 1px 1px 1px #fff;
			background-color: #000;
			opacity: 0.7;
			padding: 25px;
			border-radius: 3px;
			word-wrap: break-word;
			font-size: 138%;
		}
		#slider-tweets-meta{
			background-color: #000;
			opacity: 0.7;
			padding: 10px;
			border-radius: 3px;
		}
	</style>
	
	<style>
		.no-js #loader { display: none;  }
		.js #loader { display: block; position: absolute; left: 100px; top: 0; }
		.se-pre-con {
			position: fixed;
			left: 0px;
			top: 0px;
			width: 100%;
			height: 100%;
			z-index: 9999;
			background: url(images/ajax-loader.gif) center no-repeat #fff;
		}
		
		
	</style>
	
</head><!--/head-->

<body>
	<div class="se-pre-con"></div>
	<header id="header">      
        
        <div class="navbar navbar-inverse" role="banner">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a class="navbar-brand" href="index.html">
                        <h1><img src="images/rtcamp-logo.svg" style="width:208px;" alt="logo"></h1>
                    </a>
                    
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="active"><a href="index.php">Home</a></li>
						<?php if(isset($_SESSION['status']) && $_SESSION['status'] == 'verified' && !empty($_SESSION['request_vars'])){ ?>
							<li ><a href="logout.php">Logout</a></li>
						<?php } ?>
					</ul>
                </div>
                
            </div>
        </div>
    </header>
    <!--/#header-->

	<?php 
						
		if(isset($_SESSION['status']) && $_SESSION['status'] == 'verified' && !empty($_SESSION['request_vars'])){
			
			$username = $_SESSION['request_vars']['screen_name'];
			$twitterId = $_SESSION['request_vars']['user_id'];
			$oauthToken = $_SESSION['request_vars']['oauth_token'];
			$oauthTokenSecret = $_SESSION['request_vars']['oauth_token_secret'];
			$profilePicture	 = $_SESSION['userData']['picture'];
				
			$twClient = new TwitterOAuth($consumerKey, $consumerSecret, $oauthToken, $oauthTokenSecret);
			
		
	?>
	
	
				<section id="page-breadcrumb">
					<div class="vertical-center sun">
						 <div class="container">
							<div class="row">
								<div class="action">
									
									<div class="col-md-2 col-xs-12">
										<div class="pull-left">
											<a href="#twitter_user_name" id="<?php echo $_SESSION['userData']['username']; ?>" onclick="show_tweets(this)"><img src="<?php echo $profilePicture; ?>" style="width:81px; margin: 15px 0px;"/></a>
										</div>
										
									</div>
									<div class="col-md-10 col-xs-12" >
										<div class="row"><h1 class="title"><a href="#twitter_user_name" id="<?php echo $_SESSION['userData']['username']; ?>" onclick="show_tweets(this)" ><?php echo $_SESSION['userData']['first_name'].' '.$_SESSION['userData']['last_name']; ?></a><a href="#twitter_user_name" id="<?php echo $_SESSION['userData']['username']; ?>" onclick="show_tweets(this)" style="margin-left:7px;"><button type="button" class="btn btn-md btn-primary"><i class="fa fa-twitter"> </i> Show my Tweets</button></a></h1></div>
										<div class="row"><p><a href="#twitter_user_name" id="<?php echo $_SESSION['userData']['username']; ?>" onclick="show_tweets(this)" ><?php echo $_SESSION['userData']['username'];?></a></p></div>
										<br/>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
				<!--/#action-->
				
				<section id="blog" class="padding-top padding-bottom">
					<div class="container">
					
					<?php $myHomeTweets = $twClient->get('statuses/home_timeline', array('screen_name' => $username, 'count' => 10)); ?>
									
									
						<div class="row">
						
						
							<div id="carousel-container" style="margin-bottom:30px;">
								
								<h2 class="page-header" style="margin-bottom:45px;"><span id="twitter_user_name" >Home Timeline</span> Tweets <span class="carousel-container-se-pre-con" style="display:none;"><image src="images/ajax-loader.gif" ></span></h2>
								<div id="carousel-tweets" class="carousel slide" data-ride="carousel">
									<ol class="carousel-indicators visible-xs">
										<?php for($i=0;$i<sizeof($myHomeTweets);$i++){ ?>
										<li data-target="#carousel-tweets" data-slide-to="<?php echo $i; ?>" <?php if($i==0){ echo 'class="active"'; } ?>></li>
										<?php } ?>
									</ol>
									
									<div class="carousel-inner">
										<?php $i=0; ?>
										<?php foreach($myHomeTweets as $Tweet){ ?>
											<div class="item <?php if($i==0){echo "active"; $i++;} ?>">
												<div class="main-slider">
													<img src="images/home/slider/hill.png" class="slider-hill" alt="slider image">
													
												</div>
												<div class="carousel-caption">
													<h1 id="slider-tweets" ><?php echo $Tweet->user->name; ?> : "<?php echo $Tweet->text; ?>"</h1>
													<p id="slider-tweets-meta" ><?php echo date('d-m-Y', strtotime($Tweet->created_at)); ?></p>
												</div>
											</div>
										<?php } ?>
									</div>
									<a class="left carousel-control hidden-xs" href="#carousel-tweets" data-slide="prev">
										<span class="glyphicon glyphicon-chevron-left"></span>
									</a>
									<a class="right carousel-control hidden-xs" href="#carousel-tweets" data-slide="next">
										<span class="glyphicon glyphicon-chevron-right"></span>
									</a>
								</div><!--/#carousel-example-generic-->
							</div>
						
						</div>
						<div class="row">
							<div class="col-md-1 col-sm-1"></div>
							<div class="col-md-7 col-sm-5" style="">
								
									<?php $myTweets = $twClient->get('statuses/user_timeline', array('screen_name' => $username, 'count' => 10)); ?>
								
									<h2>My Tweets <span style="margin:0px;" align="right"><a href="download_tweets_csv.php" target="_blank" style="margin-left:7px;"><button type="button" class="btn btn-md btn-primary"><i class="fa fa-download"></i> Download My Tweets</button></a></span></h2>
								
									<div class="row" style="padding:10px; margin:0px; height: 700px;overflow: auto;">
									
										<?php foreach($myTweets  as $tweet){ ?>	
											<div class="row" style="margin:0px; padding:0px 15px; background-color:#f7f7f7;">
												<div class="single-blog two-column">
												   
													<div class="post-content overflow">
														<ul class="nav nav-justified post-nav">
															<li><a href="#"><i class="fa fa-tag"></i><?php echo date('d-m-Y', strtotime($tweet->created_at)); ?></a></li>
														</ul>
														
														<h3 class="post-author"><a href="#">Posted by <?php echo $username; ?></a></h3>
														<p><blockquote><?php echo $tweet->text; ?></blockquote></p>
														
														<div class="post-bottom overflow">
															<ul class="nav nav-justified post-nav">
																<li><a href="#"><i class="fa fa-heart"></i><?php echo $tweet->favorite_count; ?> Love</a></li>
																<li><a href="#"><i class="fa fa-retweet"></i><?php echo $tweet->retweet_count; ?> Retweets</a></li>
																
															</ul>
														</div>
													</div>
												</div>
											</div>
										<?php } ?>
									
									</div>
									<br/>
									
								   
							</div>
							<div class="col-md-1 col-sm-1"></div>
							<div class="col-md-3 col-sm-5" style="padding:10px;">
								<div class="sidebar blog-sidebar">
									<div class="sidebar-item  recent">
										
										<?php $myFollowers =  $twClient->get('followers/list', array('screen_name' => $username, 'count' => 10)); ?>
										
										<div class="row" style="margin:0px;">
											<div class="form-group">
												<span id="search_followers_loader" style="display:none;"><image src="images/ajax-loader.gif" ></span><input type="text" list="followers_name_list" placeholder="Search Follower" id="followers_name" name="followers_name" class="form-control" >
												<datalist id="followers_name_list">
													<?php foreach($myFollowers->users as $Followers){ ?>
														  <option value="<?php echo $Followers->screen_name; ?>"><?php echo $Followers->name; ?></option>
														  
													<?php } ?>
												</datalist>
											</div>
											<div class="form-group">
												<a href="#twitter_user_name"><input type="button" id="" name="search_follower" onclick="show_tweets(this)" class="btn btn-submit" value="Show Tweets"></a>
											</div>
										</div>
									
										
										
										<h3>Followers</h3>
										
										<div id="followers_list">
										
											<div class="row" style="padding:10px; margin:0px; height: 600px;overflow: auto;">
												<?php foreach($myFollowers->users as $Followers){ ?>
												<div class="media" >
													<div class="pull-left">
														<a href="#twitter_user_name" id="<?php echo $Followers->screen_name; ?>" onclick="show_tweets(this)"><img src="<?php echo $Followers->profile_image_url; ?>" style="width:52px" alt=""></a>
														
													</div>
													<div class="media-body">
														<h4><a href="#twitter_user_name" id="<?php echo $Followers->screen_name; ?>" onclick="show_tweets(this)" ><?php echo $Followers->name; ?></a></h4>
														<p><?php echo "@".$Followers->screen_name; ?></p>
													</div>
												</div>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
				
				<div class="row" id="followers_tweets">
				
				</div>
    <!--/#blog-->
	<?php } else if(isset($_REQUEST['oauth_token']) && $_SESSION['token'] == $_REQUEST['oauth_token']){ 
		
			$twClient = new TwitterOAuth($consumerKey, $consumerSecret, $_SESSION['token'] , $_SESSION['token_secret']);
	
			//Get OAuth token
			$access_token = $twClient->getAccessToken($_REQUEST['oauth_verifier']);
			
			//If returns success
			if($twClient->http_code == '200'){
				//Storing access token data into session
				$_SESSION['status'] = 'verified';
				$_SESSION['request_vars'] = $access_token;
				
				//Get user profile data from twitter
				$userInfo = $twClient->get('account/verify_credentials');
				
				$name = explode(" ",$userInfo->name);
				$fname = isset($name[0])?$name[0]:'';
				$lname = isset($name[1])?$name[1]:'';
				$profileLink = 'https://twitter.com/'.$userInfo->screen_name;
				$twUserData = array(
					'oauth_provider'=> 'twitter',
					'oauth_uid'     => $userInfo->id,
					'first_name'    => $fname,
					'last_name'     => $lname,
					'email'         => '',
					'gender'        => '',
					'locale'        => $userInfo->lang,
					'picture'       => $userInfo->profile_image_url,
					'link'          => $profileLink,
					'username'		=> $userInfo->screen_name
				);
				
				//$userData = $user->checkUser($twUserData);
				
				//Storing user data into session
				$_SESSION['userData'] = $twUserData;
				
				//Remove oauth token and secret from session
				unset($_SESSION['token']);
				unset($_SESSION['token_secret']);
				
				//Redirect the user back to the same page
				?><script> location.replace("index.php"); </script><?php
				
			}else{
				echo '<h3 style="color:red">Some problem occurred, please try again.</h3>';
			}
			
		}else{
			
			
			//Fresh authentication
			$twClient = new TwitterOAuth($consumerKey, $consumerSecret);
			$request_token = $twClient->getRequestToken($redirectURL);
			
			//Received token info from twitter
			$_SESSION['token']		 = $request_token['oauth_token'];
			$_SESSION['token_secret']= $request_token['oauth_token_secret'];
			
			//If authentication returns success
			if($twClient->http_code == '200'){
				//Get twitter oauth url
				$authUrl = $twClient->getAuthorizeURL($request_token['oauth_token']);
				
				//Display twitter login button
				
				?>
				
					<div id="feature-container" style="margin: 2% 0%;">
						<div class="row" align="center">
							<div class="col-sm-12 wow fadeInUp" data-wow-duration="500ms" data-wow-delay="300ms">
								<div class="feature-inner">
									<?php echo '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'">'; ?>
									<div class="icon-wrapper">
										<i class="fa fa-2x fa-twitter"></i>
									</div>
									<h2>Login to your Twitter Account</h2>
									<?php echo '</a>'; ?>
								</div>
							</div>
						</div>
					</div>
				
				
				<?php
				
				
			}else{
				echo '<h3 style="color:red">Error connecting to twitter! try again later!</h3>';
			}
		
		
		}
		
		?>
	
	
    <footer id="footer">
        <div class="container">
            <div class="row">
				
				<div class="col-sm-12 text-center bottom-separator">
					<img src="images/home/under.png" class="img-responsive inline" alt="">
				</div>
                <div class="col-md-4 col-sm-6">
                   
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="contact-info bottom">
                        <h2>Contacts</h2>
                        <address>
                        E-mail: <a href="mailto:vaibhav0000patel@gmail.com">vaibhav0000patel@gmail.com</a> <br> 
                        Phone: +91 78 78 438050 <br> 
                        </address>

                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="contact-form bottom">
                        <h2>Send a message</h2>
                        <form id="main-contact-form" name="contact-form" method="post" action="sendemail.php">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" required="required" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" required="required" placeholder="Email Id">
                            </div>
                            <div class="form-group">
                                <textarea name="message" id="message" required="required" class="form-control" rows="8" placeholder="Your text here"></textarea>
                            </div>                        
                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-submit" value="Submit">
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </footer>
    <!--/#footer-->


    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/lightbox.min.js"></script>
    <script type="text/javascript" src="js/wow.min.js"></script>
    <script type="text/javascript" src="js/audio.min.js"></script>
 
    
    <script>
		audiojs.events.ready(function() {
			var as = audiojs.createAll();
		});
    </script>
	<script>
		$(window).load(function() {
			// Animate loader off screen
			$(".se-pre-con").fadeOut("slow");
			//$(".carousel-container-se-pre-con").hide("slow");
		});
		
	</script>
	
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	  <script>
		$(document).ready(function(){ 
		
			$('#followers_name').change(function(){
			  var follower = $('#followers_name').val();
			  $('input[name="search_follower"]').attr('id',follower);
		  });
		  $('#followers_name').keyup(function(){
			  var follower = $('#followers_name').val();
			  $('input[name="search_follower"]').attr('id',follower);
			  $('#search_followers_loader').show();
			  $('input[name="search_follower"]').attr('disabled','disabled');
			  $('#followers_name_list').empty();
			  $.ajax({
						 type: "POST",
						 data:{fetch_users:'fetch_users',q:follower},
						 url: "ajaxapi.php",
						
						  success: function(result) 
						 {
							
							
							
							
							$('input[name="search_follower"]').removeAttr('disabled');
							
							 response = JSON.parse(result);
							
							for(var i = 0; i < response.length; i++){
								console.log(response[i].text); // Object with id and time
								$('#followers_name_list').append('<option value="'+response[i].screen_name+'"><img src="'+response[i].profile_image_url+'">'+response[i].name+'</option>');
								
							}
							if(response.length==0){
								
							}
							
							
							$('#search_followers_loader').hide();
							
						 }  
					});
			  
			  
		  });
		  $('#followers_name').focus(function(){
			  var follower = $('#followers_name').val();
			  $('input[name="search_follower"]').attr('id',follower);
		  });
		  $('#followers_name').blur(function(){
			  var follower = $('#followers_name').val();
			  $('input[name="search_follower"]').attr('id',follower);
		  });
		  $('input[name="search_follower"]').click(function(e){
			  var follower = $('#followers_name').val();
				  if(follower.trim()==""){
					$('#followers_name_error').html("Required");
					
				  }else{
					 $('#followers_name_error').html("");
					$('input[name="search_follower"]').attr('id',follower);
				  }
		  });
		  
		  
		  
		  
		  
		  
		  
		  
		});
  </script>
	
	
	<script>
	
	
	
		function formatDate(value){
			var dt = new Date(value);
		   return dt.getDate() + "-" + (dt.getMonth()+1) + "-" + dt.getFullYear();
		}
		
		function show_tweets(x){
				var screen_name = x.getAttribute("id");
				if(screen_name==""){}else{
					
					$(".carousel-container-se-pre-con").show();
					$(".carousel").css('opacity','0.5');
					$.ajax({
						 type: "POST",
						 data:{fetch_tweets:'fetch_tweets',screen_name:screen_name},
						 url: "ajaxapi.php", 
						
						  success: function(result) 
						 {
							 //alert(result);
							
							//$('#followers_list').append(result);
							
							$(".carousel-container-se-pre-con").fadeOut("slow");
							$(".carousel").css('opacity','1');
							$('.carousel-indicators').empty();
							$('.carousel-inner').empty();
							$('#twitter_user_name').html("@"+screen_name+"'s");
							
							
							 response = JSON.parse(result);
							
								
								
									for(var i = 0; i < response.length; i++){
										console.log(response[i].text); // Object with id and time
										$('.carousel-indicators').append('<li data-target="#carousel-tweets" data-slide-to="'+i+'" '+((i==0)?'class="active"':'')+' ></li>');
										$('.carousel-inner').append('<div class="item '+((i==0)?'active':'')+' "><div class="main-slider"><img src="images/home/slider/hill.png" class="slider-hill" alt="slider image"></div><div class="carousel-caption"><h1 id="slider-tweets" >'+response[i].text+'</h1><p id="slider-tweets-meta" >'+formatDate(response[i].created_at)+'</p></div></div>');
									
									}
						 if(response.length==0){
									var i=0;
									$('.carousel-indicators').append('<li data-target="#carousel-tweets" data-slide-to="'+i+'" '+((i==0)?'class="active"':'')+' ></li>');
									$('.carousel-inner').append('<div class="item '+((i==0)?'active':'')+' "><div class="main-slider"><img src="images/home/slider/hill.png" class="slider-hill" alt="slider image"></div><div class="carousel-caption"><h1 id="slider-tweets" >@'+screen_name+' has no tweets!!</h1><p id="slider-tweets-meta" > Select search another user!</p></div></div>');
							}
							
						 }  
					});
					
				}
		}
		
	</script>
	
    <script type="text/javascript" src="js/masonry.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>    
</body>
</html>
