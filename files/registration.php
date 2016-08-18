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
		
		<link rel="stylesheet" type="text/css" href="registration.css">

		<script>
			function isValidEmailAddress(emailAddress) {
				var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
				return pattern.test(emailAddress);
			}
			
			$(function(){
				$("#submit").click(function(){
					var message = [];
					var email = $("#email").val();
					var uname = $("#username").val();
					var pword = $("#password").val();
					var pword2 = $("#confirm").val();
					
					if(email == ""){
						message.push("Enter email address");
					}
					else if(!isValidEmailAddress(email)){
						message.push("Invalid email format");
					}
					
					if(uname == ""){
						message.push("Enter Username");
					}
					
					if(pword == ""){
						message.push("Enter Password");
					}
					else if(pword.length < 8){
						message.push("Passwords must have at least 8 characters");
					}
					else
					{
						if(pword2 == ""){
							message.push("Confirm Password");
						}
						else if(pword != pword2){
							message.push("Password doesn't match");
						}
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
						
						$("#frmRegister").submit(function(e){
							e.preventDefault(function(e){ return true; });
						});
					}else{
						$("#frm").submit(function(e){ return true; });
					}
				});
			});
		</script>
		
		<title>Register</title>
	</head>
	
	<body>
		<div class="container">
			<div class="main-login main-center">
				<?php 
					session_start();
					if($_SESSION["messages"] != null || count($_SESSION["messages"]) > 0)
					{
						echo '<div class="alert alert-danger">';
						
						foreach($_SESSION["messages"] as $message)
						{
							echo $message.'<br/>';
						}
						
						echo '</div>';
					}
				?>
				<form class="form-horizontal" id="frmRegister" method="post" action="register.php">
					<div class="form-group">
						<label for="email" class="cols-sm-2 control-label">Your Email</label>
						<div class="cols-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-envelope" aria-hidden></i></span>
								<input type="text" class="form-control" name="email" id="email"  placeholder="Enter your Email"/>
							</div>
						</div>
					</div>

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

					<div class="form-group">
						<label for="confirm" class="cols-sm-2 control-label">Confirm Password</label>
						<div class="cols-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden></i></span>
								<input type="password" class="form-control" name="confirm" id="confirm"  placeholder="Confirm your Password"/>
							</div>
						</div>
					</div>

					<div class="form-group ">
						<button type="submit" id="submit" class="btn btn-primary btn-lg btn-block login-button">Register</button>
					</div>
					<div class="login-register">
						<a href="login.php">Login</a>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>