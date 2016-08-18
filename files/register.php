<?php
	require("functions.php");
	
	if(RegisterUser($_POST["email"],$_POST["username"],$_POST["password"],$_POST["confirm"]))
	{
		header('Location:registration.php');
	}
	else
	{
		session_start();
		$_SESSION["validations"] = array("Registration success!");
		header('Location:login.php');
	}
?>