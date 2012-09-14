<?
	/*
	 * 	use the user id from cookie to delete favorites from database using AJAX
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
	// get the organization name sent by rmfav function
	$q = $_GET["q"];
		
	// connect to database server
	if (($connection = @mysql_connect(DB_SERVER, DB_USER, DB_PASS)) === FALSE)
		die('Could not connect: ' . mysql_error());

	// select database
	if (@mysql_select_db(DB_NAME, $connection) === FALSE)
		die('Could not connect: ' . mysql_error());
	// query to delete element in the table
	$sql = "DELETE FROM favorites WHERE uid = '$uid' AND favs = '$q'";
	mysql_query($sql);
	// close connection to database
	mysql_close($connection);
?>
	
	
	