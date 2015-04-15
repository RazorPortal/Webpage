<!DOCTYPE html>
<html>	
	<?php session_start(); ?>
	<head lang="en">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		<title> RazorPortal </title>
	</head>
	
	<body>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="#">RazorPortal</a>
				</div>
				<div>
					<ul class="nav navbar-nav">
						<li><a href="profile.php">Home</a></li>
						<li><a href="Schedule.php">Edit Schedule</a></li>
						<li class="active"><a href="Social.php">Social Wall</a></li> 
						<li><a href="Rewards.php">Rewards</a></li> 
				  </ul>
				</div>
			</div>
		</nav>
		
		<?php
				//Only run if submitting/deleting a class
			if($_SERVER["REQUEST_METHOD"] == "POST") {
				$servername = "localhost"; //uaf59189.ddns.uark.edu
					 
					 //connect to server
					 $conn = new mysqli($servername, 'root', 'tu3xooGh');
					 if($conn -> connect_error) {
						die("Connection failed: " . $conn -> connect_error);
					 }
					 echo "Connected successfully";
					 
					 //user Razorportal MYSQL database
					 $query = "USE razorportal;";
					 if($conn -> query($query) === TRUE)
						echo "DATABASE ACCESS SUCCESSFUL\n";
					else
						echo "ERROR OPENING DATABASE\n" . $conn -> error;
					
			if (isset($_POST["wallsubmit"])){
				 //Check for empty fields on class submission
				 if(empty($_POST["status"])) {
					echo "You must fill out entire form to post a status";
				 }
				 else{
					 //Insert values to mysql database
					 $insertrow = "INSERT INTO wall (user, status)";
					 $insertrow .= " VALUES (" . "'" . $_SESSION["username"] . "'";
					 $insertrow .= " , " . "'" . $_POST["status"] . "'" . ");";
					 var_dump($insertrow);

					 $addpoint = "UPDATE user SET points=points+1 WHERE username='" . $_SESSION["username"] . "';";
					 $conn -> query($addpoint);
				 
				 if($conn -> query($insertrow) === TRUE)
					echo "DATABASE ACCESS SUCCESSFUL\n";
				 else
					echo "ERROR INSERTING INTO DATABASE\n" . $conn -> error;
				 }
				 $conn -> close();
			}
			
			if(isset($_POST["Submit"])) {
				if(empty($_POST["wallsubmit"])) {
					echo "Your post is empty, by the way";
				}
					
			 }
			}
		?>
	
		 
		<div class="container-fluid">
			<h1 class="text-center" style="font-size:150px"> Social Wall </h1> <br><br>

			<div class="col-sm-offset-3 col-sm-8">
			
			<?php
				//Connect to SQL database
				$servername = "localhost"; //uaf59189.ddns.uark.edu
				$conn       = new mysqli($servername, 'root', 'tu3xooGh');
				
				if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
				}
				
				echo "Connected successfully";
				$query = "USE razorportal;";
				if ($conn->query($query) === TRUE)
						echo "DATABASE ACCESS SUCCESSFUL\n";
				else
						echo "ERROR OPENING DATABASE\n" . $conn->error;
				
				//Get schedule from RAZORPORTAL sql
				$getWall     = "SELECT user, status FROM wall";
				$wall        = $conn->query($getWall);

				while ($row = $wall->fetch_array(MYSQLI_ASSOC)) {
						echo "<p><strong>" . $row['user'] . ": " . "</strong>";
						echo $row['status'] . "</p>";						
				}

				$conn->close();
			?>
			</div>
		
			<form class="form-inline" action="Social.php" method = "post">
		
				<div class="form-group col-sm-offset-5">
					<div>
						<input type="text" class="form-control" id="status" name="status" placeholder="Post a Status">
					</div>
				</div>
				
				<button type="submit" class="btn btn-default" name="wallsubmit">Submit</button><br><br>
				
			</form>
		</div>
		
	</body>
</html>