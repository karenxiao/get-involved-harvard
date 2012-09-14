<?
	/*
	 * 	PHP uses facebook source code to use facebook cookie to create a user cookie 
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
	
	// store user id into its own variable
	$uid = $cookie['uid'];
	
	// get organization name sent by adfav function
	$q = $_GET["q"];
		
	// connect to database server
	if (($connection = @mysql_connect(DB_SERVER, DB_USER, DB_PASS)) === FALSE)
		die('Could not connect: ' . mysql_error());

	// select database
	if (@mysql_select_db(DB_NAME, $connection) === FALSE)
		die('Could not connect: ' . mysql_error());
	
	// check to make sure a user has logged in and the organization name is valid
	if ( $q != "" && $uid != 0 )
	{
		// perform query to insert favorite, if duplicate, nothing changes
		$sql = "INSERT INTO favorites ( uid, favs ) VALUES ( '$uid', '$q' )";
		mysql_query($sql);
	}
	
	// perform query to select this user's favorites in the database 
	$sql = "SELECT * FROM favorites WHERE uid = '$uid' ORDER BY favs ASC";
	$results = mysql_query($sql);

	// store the favorites in a formatted string 
	$favslist = "";
	// loop through all the favorites
	while( $row = mysql_fetch_array($results) )
	{
		$favslist = $favslist . "<li>" . $row['favs'] . "</li>";
	}
	// send string back to adfav function
	echo $favslist;
	// close connection to database
	mysql_close($connection);
?>
	
	
	
	
	
	
	
	
	
	
	
	
	