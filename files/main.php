<html>
<head>
		<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
		
		<!-- Bootstrap CDN -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"/>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

		<!-- Font Awsome CDN -->
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css"/>
		
		<link rel="stylesheet" type="text/css" href="main.css">
		
		<script>
			$(function(){
				$("#submit").click(function(){
					var message = [];
					var title = $("#title").val();
					var pword = $("#password").val();
					
					if(title == ""){
						message.push("Task title required");
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
						
						$("#frmTask").submit(function(e){
							e.preventDefault();
						});
					}else{
						$("#frmTask").submit(function(e){ return true; });
					}
				});
			});
		</script>
</head>

<body>
	<div class="container">
		<div class="main-login main-center">
			<div class="page-header main-header">
				<?php 
					session_start();
					if(isset($_SESSION['uname']))
					{
						echo '<h1>'.$_SESSION['uname'].'</h1>';
					}
					else
					{
						header('Location:registration.php');
					}
				?>
				<br/>
				<a href="signout.php" class="btn btn-info main-header" role="button">Logout</a>
			</div>
			
			<div class="row">				
				<?php
					require("functions.php");
					
					$result = GetTask($_SESSION["uname"]);
					
					while($row = $result->fetch_assoc()){
						echo '<div class="col-md-12">';
						$date = strtotime('Y-m-d',strtotime($row['dateAssigned'])+(24*3600*7));
						echo '<h4>'.$row['task'];
						
						
						if($date <= date("Y-m-d"))
						{
							echo ' (Pending)';
						}
						
						echo'</h4>';
						
						echo '<p>'.$row['description'].'</p>';
						echo '<div>';
					}
				?>
			</div>
			
			<div class="row" id="dummy">
				<?php 
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
				<form class="form-horizontal" id="frmTask" method="post" action="task.php">
					<div class="form-group">
						<label for="title" class="control-label">Title</label>
						<div class="input-group">
							<input type="text" class="form-control" name="title" id="title"  maxlength="128" placeholder="Title"/>
						</div>
					</div>
					
					<div class="form-group">
						<label for="title" class="control-label">Description</label>
						<div class="input-group">
							<textarea class="form-control" id="description" name="description" rows="5" placeholder="Description" maxlength="512"></textarea>
						</div>
					</div>
					
					<div class="form-group ">
						<button type="submit" id="submit" class="btn btn-primary">Add</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>