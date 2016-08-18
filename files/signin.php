<?php
	require("functions.php");

	if(Login($_POST["username"],$_POST["password"]))
	{
		$_SESSION["validations"] = array();
		header('Location:login.php');
	}
	else
	{
		session_start();
		$_SESSION["validations"] = array();
		$_SESSION["messages"] = array();
		header('Location:main.php');
	}
?>