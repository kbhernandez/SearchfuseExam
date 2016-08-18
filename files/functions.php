<?php
	require("globalInc.php");
	
	function DbConnection()
	{
		global $host;
		global $user;
		global $pass;
		global $name;
		
		$db = new mysqli($host, $user, $pass, $name);
		
		if($db->connect_errno > 0)
		{
			die('Unable to connect to database [' . $db->connect_error . ']');
		}
		
		return $db;
	}
	
	function RegisterValidate($email,$uname,$pword,$pword2)
	{
		session_start();
		$_SESSION["messages"] = array();
		$hasMesseges = false;
		if($email == null)
		{
			$message = "Enter email address";
			array_push($_SESSION["messages"],$message);
			$hasMesseges = true;
		}
		else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$message = "Invalid email format";
			array_push($_SESSION["messages"],$message);
			$hasMesseges = true;
		}
		
		if($uname == null)
		{
			$message = "Enter username";
			array_push($_SESSION["messages"],$message);
			$hasMesseges = true;
		}
		
		if($pword == null)
		{
			$message = "Enter password";
			array_push($_SESSION["messages"],$message);
			$hasMesseges = true;
		}
		else if (strlen($pword)  < 8)
		{
			$message = "Passwords must have at least 8 characters";
			array_push($_SESSION["messages"],$message);
			$hasMesseges = true;
		}
		else
		{
			if($pword2 == null)
			{
				$message = "Confirm password";
				array_push($_SESSION["messages"],$message);
				$hasMesseges = true;
			}
			else if($pword != $pword2)
			{
				$message = "Password doesn't match";
				array_push($_SESSION["messages"],$message);
				$hasMesseges = true;
			}
		}
		
		return $hasMesseges;
		
	}
	
	function RegisterUser($email,$uname,$pword,$pword2)
	{
		if(RegisterValidate($email,$uname,$pword,$pword2))
		{
			return true;
		}
		
		$db = DbConnection();
		$sql = "SELECT uname,pword FROM users WHERE uname ='".$uname."' LIMIT 1";
		
		if(!$result = $db->query($sql))
		{
			die('There was an error running the query [' . $db->error . ']');
		}
		
		while($row = $result->fetch_assoc()){
			echo $row['username'] . '<br />';
		}
		
		if($result->num_rows < 1)
		{
			$sql = "INSERT INTO users(email,uname,pword,type) VALUES('".$email."','".$uname."','".SHA1($pword)."','mem')";
			
			if(!$db->query($sql))
			{
				die('Error : ('. $mysqli->errno .') '. $mysqli->error);
			}
			
			$db->close();
		}
		
		return false;
	}
	
	function LoginValidate($uname,$pword)
	{
		session_start();
		$_SESSION["messages"] = array();
		$hasMesseges = false;

		if($uname == null)
		{
			$message = "Enter username";
			array_push($_SESSION["messages"],$message);
			$hasMesseges = true;
		}
		
		if($pword == null)
		{
			$message = "Enter password";
			array_push($_SESSION["messages"],$message);
			$hasMesseges = true;
		}
		
		return $hasMesseges;
		
	}
	
	function Login($uname,$pword)
	{
		if(LoginValidate($uname,$pword))
		{
			return true;
		}
		
		$db = DbConnection();
		$sql = "SELECT uname,pword FROM users WHERE uname ='".$uname."' LIMIT 1";
		
		if(!$result = $db->query($sql))
		{
			die('There was an error running the query [' . $db->error . ']');
		}
		
		if($result->num_rows >= 1)
		{
			$row = $result->fetch_assoc();
			if($row["pword"] == SHA1($pword))
			{
				session_start();
				$_SESSION["messages"] = array();
				$_SESSION["uname"] = $row["uname"];
			}
			else
			{
				session_start();
				$_SESSION["messages"] = array("Wrong Username and/or Password");
			}
		}
		else
		{
			session_start();
			$_SESSION["messages"] = array("Wrong Username and/or Password");
		}
		
		return false;
	}
	
	function ValidateTask($title,$desc)
	{
		$_SESSION["messages"] = array();
		$hasMesseges = false;
		
		if($title == null)
		{
			$message = "Task title is required";
			array_push($_SESSION["messages"],$message);
			$hasMesseges = true;
		}
		
		return $hasMesseges;
	}
	
	function AddTask($uname,$title,$desc)
	{
		if(ValidateTask($title,$desc))
		{
			return true;
		}
		
		$db = DbConnection();
		
		$sql = "INSERT INTO tasks VALUES('".$uname."','".$title."','".$desc."',NOW())";
			
		if(!$db->query($sql))
		{
			die('Error : ('. $mysqli->errno .') '. $mysqli->error);
		}
		
		$db->close();
		
		return false;
	}
	
	function GetTask($uname)
	{
		$db = DbConnection();
		$sql = "SELECT task,description,dateAssigned FROM tasks WHERE uname ='".$uname."'";
		
		if(!$result = $db->query($sql))
		{
			die('There was an error running the query [' . $db->error . ']');
		}
		
		return $result;
	}
?>