<!DOCTYPE html>
<html lang="en">
    <head> 
		<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
		
		<!-- Bootstrap CDN -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"/>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

		<!-- Font Awsome CDN -->
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css"/>
		
		<link rel="stylesheet" type="text/css" href="login.css">
		
		<script>
			$(function(){
				$("#submit").click(function(){
					var message = [];
					var uname = $("#username").val();
					var pword = $("#password").val();
					
					if(uname == ""){
						message.push("Enter Username");
					}
					
					if(pword == ""){
						message.push("Enter Password");
					}
					else if(pword.length < 8){
						message.push("Passwords must have at least 8 characters");
					}

					if(message.length > 0){
						var messageStr = '<div class="alert alert-danger">';
						var i = 0;
						while(i != message.length){
							messageStr += message[i] + "<br/>";
							i+=1;
						}
						messageStr += "</div>"
						
						if($(".alert-danger").length > 0){
							$(".alert-danger").remove();
						}
						
						$(".main-center").prepend(messageStr);
						
						$("#frm").submit(function(e){
							e.preventDefault();
						});
					}else{
						$("#frm").submit(function(e){ return true; });
					}
				});
			});
		</script>
		
		<title>Login</title>
	</head>
	<body>
		<div class="container">
			<div class="main-login main-center">
				<?php 
					session_start();
					if(isset($_SESSION["messages"]) && count($_SESSION["messages"]) > 0)
					{
						echo '<div class="alert alert-danger">';
						
						foreach($_SESSION["messages"] as $message)
						{
							echo $message.'<br/>';
						}
						
						echo '</div>';
					}

					if(isset($_SESSION["validations"]) && count($_SESSION["validations"]) > 0)
					{
						echo '<div class="alert alert-success">';
						
						foreach($_SESSION["validations"] as $message)
						{
							echo $message.'<br/>';
						}
						
						echo '</div>';
					}
				?>
				<form class="form-horizontal" id="frm" method="post" action="signin.php">
					<div class="form-group">
						<label for="username" class="cols-sm-2 control-label">Username</label>
						<div class="cols-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user" aria-hidden></i></span>
								<input type="text" class="form-control" name="username" id="username"  placeholder="Enter your Username"/>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="password" class="cols-sm-2 control-label">Password</label>
						<div class="cols-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden></i></span>
								<input type="password" class="form-control" name="password" id="password"  placeholder="Enter your Password"/>
							</div>
						</div>
					</div>

					<div class="form-group ">
						<button type="submit" id="submit" class="btn btn-primary btn-lg btn-block login-button">Login</button>
					</div>
					<div class="login-register">
						<a href="registration.php">Signup</a>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>