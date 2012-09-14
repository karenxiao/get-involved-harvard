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
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 2.5 License
-->


<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">

<head>
	<title>Get Involved Harvard</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="images/favicon.ico">
	<link href="style.css" rel="stylesheet" type="text/css" />
	<script src="search.js" type="text/javascript"></script>
	<script src="orglist.js" type="text/javascript"></script>
</head>

<body onload="wait(); adfav('');">
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
			
			<div class="indent1">
				YOUR FAVORITES:<p><a href="favorites.php" accesskey="3">View a more detailed list</a></p>
				<div id="favs"></div>
			</div>
		</div>
		
		
		<div id="colTwo">
			<img src="images/icon.jpg" alt="" width="30" height="30" class="image" />
			<h2>Search for Student Organizations</h2>
			<div>
				<form name="keyword" method="post">
				<table>
				<tr>
					<td>
						Search: <input id="searchtext" type="text" name="query" onKeyUp="wait();">
					</td>
				</tr>
				<tr>
					<td>
						<ul>
						Size:
							<li><input type="checkbox" name="anynumber" value="Any" checked="checked" onClick="checkcat('anynumber');">Any</input></li>
							<li><input type="checkbox" name="number" value="1-9" onClick="checkcat('number');">1-9</input></li>
							<li><input type="checkbox" name="number" value="10-25" onClick="checkcat('number');">10-25</input></li>
							<li><input type="checkbox" name="number" value="26-50" onClick="checkcat('number');">26-50</input></li>
							<li><input type="checkbox" name="number" value="51-75" onClick="checkcat('number');">51-75</input></li>
							<li><input type="checkbox" name="number" value="76-100" onClick="checkcat('number');">76-100</input></li>
							<li><input type="checkbox" name="number" value="&gt; 100" onClick="checkcat('number');">&gt; 100</input></li>
						</ul>
					</td>
					<td>
						<ul>
						Category:
							<li><input type="checkbox" name="anycategory" value="Any" checked="checked" onClick="checkcat('anycategory');">Any</input></li>
							<li><input type="checkbox" name="category" value="Academic & Pre-Professional" onClick="checkcat('category');">Academic & Pre-Professional</input></li>
							<li><input type="checkbox" name="category" value="Arts" onClick="checkcat('category');">Arts</input></li>
							<li><input type="checkbox" name="category" value="Campus Life" onClick="checkcat('category');">Campus Life</input></li>
							<li><input type="checkbox" name="category" value="Cultural & Racial Initiatives" onClick="checkcat('category');">Cultural & Racial Initiatives</input></li>
							<li><input type="checkbox" name="category" value="Gender & Sexuality" onClick="checkcat('category');">Gender & Sexuality</input></li>
							<li><input type="checkbox" name="category" value="Government & Politics" onClick="checkcat('category');">Government & Politics</input></li>
						</ul>
					</td>
					<td>
						<ul>	
							<li><input type="checkbox" name="category" value="Health & Wellness" onClick="checkcat('category');">Health & Wellness</input></li>
							<li><input type="checkbox" name="category" value="Media & Publications" onClick="checkcat('category');">Media & Publications</input></li>
							<li><input type="checkbox" name="category" value="Public Service" onClick="checkcat('category');">Public Service</input></li>
							<li><input type="checkbox" name="category" value="Recreation" onClick="checkcat('category');">Recreation</input></li>
							<li><input type="checkbox" name="category" value="Religious Groups" onClick="checkcat('category');">Religious Groups</input></li>
							<li><input type="checkbox" name="category" value="Social" onClick="checkcat('category');">Social</input></li>
							<li><input type="checkbox" name="category" value="Women&#39;s Initiatives" onClick="checkcat('category');">Women's Initiatives</input></li>
						</ul>
					</td>
				</tr>
				</table>
				</form>
			</div>
				
			<div id="result"><table id="results"></table></div>
		</div>
	</div>
	<div id="footer">
		<p>Copyright (c) 2010 Get Involved Harvard. All rights reserved. CS50. Kai Fei & Karen Xiao. Source of information: Harvard Office of Student Life: http://osl.fas.harvard.edu/</p>
		<p><a href="#header">Back To Top</a></p>
	</div>
	<script src="http://connect.facebook.net/en_US/all.js"></script>
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
