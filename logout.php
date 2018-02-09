<?php
	session_start();
	
	$_SESSION["login"] = false;
	$_SESSION["username"] = null;
	
	header('Location: ./');
	die();
?>