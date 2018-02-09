<?php
	include 'settings.php';

	function blog_db_connect() {
		$credentials = getCredentials();
		$ret_db = new mysqli($credentials->host, $credentials->username, $credentials->password, $credentials->database);
		
		// Check connection
		if (mysqli_connect_errno())
		{
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		  
		return $ret_db;
	}
?>