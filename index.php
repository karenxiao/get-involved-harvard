<?
	/*
	 * 	PHP uses facebook source code to use facebook cookie to create a user cookie for later use
	 */
	
	
	// use constants stored in constants.php
	require_once("constants.php");
	
	// get facebook cookie and make new cookie
	function get_facebook_cookie($app_id, $application_secret) 
	{
		$args = array();
		parse_str(trim(@$_COOKIE['fbs_' . $app_id], '\\"'), $args);
		ksort($args);
		$payload = '';
		
		foreach ($args as $key => $value) 
		{
			if ($key != 'sig') 
			{
				$payload .= $key . '=' . $value;
			}
		}
		if (md5($payload . $application_secret) != @$args['sig']) 
		{
			return null;
		}
		return $args;
	}
	// store the newly created cookie
	$cookie = get_facebook_cookie(FACEBOOK_APP_ID, FACEBOOK_SECRET);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by Free CSS Templates
-->


<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">

<head>
	<title>Get Involved Harvard</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="Keywords" content="harvard, student organizations, clubs, search" />
	<meta name="Description" content="Easily search for and browse Harvard's many student organizations!" />
	<link rel="shortcut icon" href="images/favicon.ico">
	<link href="style.css" rel="stylesheet" type="text/css" />
	<script src="search.js" type="text/javascript"></script>
	<script src="orglist.js" type="text/javascript"></script>
	<script src="http://connect.facebook.net/en_US/all.js"></script>
</head>

<body onload="wait();">
	<div id="header">
		<ul id="menu">
			<li><a href="index.php" accesskey="1" title="">Home</a></li>
			<li><a href="search.php" accesskey="2" title="">Search</a></li>
			<li><a href="favorites.php" accesskey="3" title="">Favorites</a></li>
		</ul>

	</div>
	<div id="content">
	
		<div id="colOne">
			<div id="logo">
				<h1><a href="index.php">Get Involved Harvard</a></h1>
			</div>
			
			
			<div class="box">
				<p class="indent1">
					<fb:login-button autologoutlink="true"></fb:login-button>
					<p class="indent1"><fb:like href="getinvolvedharvard.com" width="200"></fb:like></p>
				</p>
				<div id="fb-root"></div>
			</div>
		</div>
		
		
		<div id="colTwo">
		<div class="bottom">
			<img src="images/icon.jpg" alt="" width="30" height="30" class="image" />
			<h2>Welcome to Get Involved Harvard!</h2>
			<br>
			<p>Ever feel overwhelmed by Harvard's numerous and diverse student organizations? Get Involved Harvard allows you to search for organizations by your preferences and find clubs that match your interests. The club's description, contact information and website are all a mouse click away. In addition, the website features instant search capabilities and allows you to create a list of your favorite organizations.</p>
		</div>
		
		
		<div>
			<img src="images/square.jpg" alt="" width="75" height="75" class="square" />	
			<h3>Search</h3>
			<h4><strong>Get instant results</strong> | <a href="search.php">Search Now!</a></h4>
			<p>Our instant search feature allows you to input key words according to your interests and search clubs and organizations by category. You can narrow your search by putting your preferences for the size of the club and the purpose of the organization.</p>
		</div>
		
		<div>
			<img src="images/square1.jpg" alt="" width="75" height="75" class="square" />
			<h3>Favorites</h3>
			<h4><strong>Create a list of your favorites</strong> | <a href="favorites.php">View your favorites!</a></h4>
			<p>Create a list of your favorite organizations so you can easily return later and review the organizations. If you want to be able to review the list later, just sign in with your Facebook profile.</p>
		</div>
		
		<div>
			<img src="images/square2.jpg" alt="" width="75" height="75" class="square" />
			<h3>Login</h3>
			<h4><strong>Easy Login</strong> | <a href="search.php">Search Now!</a></h4>
			<p>Logging in to the site is easy! All you need is your Facebook account and you'll be able to save your information. Don't forget to like our page and tell all your friends that you are using Get Involved Harvard!</p>
		</div>
		
		</div>
	</div>
	<div id="footer">
		<p>Copyright (c) 2010 Get Involved Harvard. All rights reserved. CS50. Kai Fei & Karen Xiao. Source of information: Harvard Office of Student Life: http://osl.fas.harvard.edu/</p>
	</div>

    <script>
		// Facebook source code for authenticating Facebook session
		FB.init({appId: '<?= FACEBOOK_APP_ID ?>', status: true, cookie: true, xfbml: true});
		FB.Event.subscribe('auth.sessionChange', function(response) 
		{
				window.location.reload();
		});
    </script>
</body>
</html>
