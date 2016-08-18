<?php
	require("functions.php");
	
	session_start();
	if(AddTask($_SESSION["uname"],$_POST["title"],$_POST["description"]))
	{
		header('Location:main.php');
	}
	else
	{
		session_start();
		$_SESSION["validations"] = array();
		$_SESSION["messages"] = array();
		header('Location:main.php');
	}
?>