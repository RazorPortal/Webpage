<!DOCTYPE html>

<html>
	<head>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

		<title>Create Account</title>
	</head>

	<?php
		$status = "";
		$username = $password = $email = "";

		if($_SERVER["REQUEST_METHOD"] == "POST") {
			if(empty($_POST["username"]) || empty($_POST["password"]) ||
					empty($_POST["password2"]) || empty($_POST["email"])) {
					echo "Must fill out entire form"; 		
					}
			else if($_POST["password"] != $_POST["password2"]) 
			{
				echo "Passwords must match";
			}
			
			else {
				$servername = "localhost"; //uaf59189.ddns.uark.edu
				
				$conn = new mysqli($servername, 'root', 'tu3xooGh');
				if($conn -> connect_error) {
					die("Connection failed: " . $conn -> connect_error);
				}
				
				$query = "USE razorportal;";
				
				$conn -> query($query);
				
				$UserCheck = "SELECT username FROM user WHERE username = " . "'" . $_POST["username"] . "' " . ";";
				var_dump($UserCheck);
				$result = $conn -> query($UserCheck);
					
				//check if user exists 
				if($result -> num_rows > 0) {
					echo "Username is taken";
				}
				else {
					$query2 = "INSERT INTO user (username, password)";
					$query2 .= " VALUES (" . "'" . $_POST["username"] . "'";
					$query2 .= " , " . "'" . $_POST["password"] . "'" . ",0);";
					
					$conn -> query($query2);
				}
				
				$conn -> close();

		}
	
	}
	?>
	
	<body>	 
		<div class="container-fluid">
			<h1 class="text-center" style="font-size:150px; margin-bottom:50px">Create Account</h1>
			<form class="form-horizontal" method = "post">
				<div class="form-group">
					<label for="username" class="col-sm-offset-4 col-sm-1">Username:</label>
					<div class="col-sm-2">
						<input type="text" class="form-control" id="username" name="username" placeholder="Enter Username">
					</div>
				</div>
				
				<div class="form-group">
					<label for="email" class="col-sm-offset-4 col-sm-1">UARK email:</label>
					<div class="col-sm-2">
						<input type="text" class="form-control" id="email" name="email" placeholder="Enter UARK email">
					</div>
				</div>
			
				<div class="form-group">
					<label for="password" class="col-sm-offset-4 col-sm-1">Password:</label>
					<div class="col-sm-2">
						<input type="password" class="form-control" id="password" name="password" placeholder="Password">
					</div>
				</div>
				
				<div class="form-group">
					<label for="password2" class="col-sm-offset-4 col-sm-1">Re-Enter Password:</label>
					<div class="col-sm-2">
						<input type="password" class="form-control" id="password2" name="password2" placeholder="Password">
					</div>
				</div>
				
				<div class="text-center">
					<button type="submit" class="btn btn-default">Create Account</button><br><br>
				</div>
			</form> 
			
			<form method="link" action="Login.php">
				<div class="text-center">
					<button type="submit" class="btn btn-default">Back to Main Page</button>
				</div>
			</form>
		</div>
	</body>
</html>

