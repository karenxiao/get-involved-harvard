<?
	/*
	 * 	use Facebook cookie's stored user id to get "favorites" information from mysql database and display on the page 
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


    // connect to database server
	$connection = @mysql_connect(DB_SERVER, DB_USER, DB_PASS);
	@mysql_select_db(DB_NAME, $connection);

	// store user id into its own variable
	$uid = $cookie['uid'];
	
	// connect to database server
	if (($connection = @mysql_connect(DB_SERVER, DB_USER, DB_PASS)) === FALSE)
		die('Could not connect: ' . mysql_error());

	// select database
	if (@mysql_select_db(DB_NAME, $connection) === FALSE)
		die('Could not connect: ' . mysql_error());
		
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by Free CSS Templates
-->


<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">

<head>
	<title>Get Involved Harvard | Favorites</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="images/favicon.ico">
	<link href="style.css" rel="stylesheet" type="text/css" />
	<script src="search.js" type="text/javascript"></script>
	<script src="orglist.js" type="text/javascript"></script>
	<script src="http://connect.facebook.net/en_US/all.js"></script>
</head>

<body>
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
			<img src="images/icon.jpg" alt="" width="30" height="30" class="image" />
			<h2>Your Favorites</h2>
			
			<div>Manage your list of favorites, or search for more organizations <a href="search.php" accesskey="3" title="">here</a></p></div>
			
			<div id="result">
			
			<table id="results">
				<? 	// perform query to get array of favorites
				$sql = "SELECT * FROM favorites WHERE uid = '$uid' ORDER BY favs ASC"; ?>
				<? $results = mysql_query($sql); ?>
				<script type="text/javascript">
					// create a table to store favorites and formatting
					var favtable = ""
				</script>
				<? 	// loop through array to get all the favorites names
				while ($row = mysql_fetch_array($results)): ?>
					<script type="text/javascript">
						// store array elements
						var neworgnames = escape('<?= $row['favs'] ?>');
						var orgnames = '<?= $row['favs'] ?>';
						// create the html tags and put info into string
						favtable += "<tr><td id='"+neworgnames+"'><p id='orgname'><a href='javascript:dropdownfav(&#39;"+neworgnames+"&#39;);'>"+orgnames+"</a></p></td></tr>"

					</script>
			<? endwhile ?>
			</table></div>
			<script type="text/javascript">
					// print string onto webpage
					document.getElementById("results").innerHTML = favtable;
			</script>
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
