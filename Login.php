<!DOCTYPE html>

<?php 
session_destroy();
session_start(); ?>

<html>
	<head>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		<title>RazorPortal</title>
	</head>
	
	 <?php		
		//check if post
		if($_SERVER["REQUEST_METHOD"] == "POST") 
		{
			if(empty($_POST["username"]) || empty($_POST["password"])) //check if both username and password have been input
			{
				echo "Must provide both username and password"; 		
			}
			else 
			{
				//connect to localhost
				
				$servername = "localhost";
				$conn = new mysqli($servername, 'root', 'tu3xooGh');
				
				if($conn -> connect_error) {
					echo "Connection failed: " . $conn -> connect_error;
				}
				else {
					echo "Connected successfully";
				}
			
				//open razorportal database
				$openDB = "USE razorportal;";
			
				if($conn -> query($openDB) === TRUE)
					echo "DATABASE ACCESS SUCCESSFUL\n";
				else
					echo "ERROR ACCESSING DATABASE\n" . $conn -> error;
				
				//build user check script
				$UserCheck = "SELECT * FROM user WHERE username = " . "'" . $_POST["username"] . "'";
				$UserCheck .= "AND password = " . "'" . $_POST["password"] . "'" . ";";
				
				//var_dump($UserCheck);
				$result = $conn -> query($UserCheck);
				
				//check if user exists 
				if($result -> num_rows > 0) {
					echo "Log In Success!!";
					$_SESSION["username"] = $_POST["username"];
					echo $_SESSION["username"]; 

					$addpoint = "UPDATE user SET points=points+1 WHERE username='" . $_POST["username"] . "';";
					$conn -> query($addpoint);

					?>

					<script>
						window.location = 'http://uaf59189.ddns.uark.edu/profile.php';
					</script>
					<?php
				}
				else {
					echo "Username and Password do not match or can not be found";
					session_destroy();
				}
				
				$conn -> close();
			}
	    }
	?>
	
	<body>  
		<div class="container-fluid">
			<h1 class="text-center" style="font-size:150px"> RazorPortal </h1> <br><br>
				<form class="form-horizontal" method = "post">
				
					
					<div class="form-group">
						<label for="username" class="col-sm-offset-4 col-sm-1">Username:</label>
						<div class="col-sm-2">
							<input type="text" class="form-control" id="username" name="username" placeholder="Enter Username">
						</div>
					</div>
				
					
					<div class="form-group">
						<label for="password" class="col-sm-offset-4 col-sm-1">Password:</label>
						<div class="col-sm-2">
							<input type="password" class="form-control" id="password" name="password" placeholder="Password">
						</div>
					</div>
					
					<div class="text-center">
						<button type="submit" class="btn btn-default">Submit</button><br><br>
				  </div>
					
				</form> 
				<form method="link" action="CreateAccount.php">
					<div class="text-center">
						<button type="submit" class="btn btn-default">Create Account</button>
					</div>
				</form>
				
		</div>
  </body>
</html>