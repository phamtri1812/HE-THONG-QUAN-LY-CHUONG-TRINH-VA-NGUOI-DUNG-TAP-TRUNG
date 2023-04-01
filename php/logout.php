<?php require_once("../connect/connection.php");
	error_reporting(0); 
	session_start();
	$logout=$_POST["logout"];
	if($logout=="YES"){
		session_destroy();
		header("Location:../index.php");
	}
?>