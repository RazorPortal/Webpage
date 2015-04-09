<!DOCTYPE html>
<html>	
	<head lang="en">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		<title> RazorPortal </title>
	</head>

	<?php 
		//BEGIN SESSION
		session_start(); 
	?>

	<?php
		//useful PHP functions
		
		function ConnectDB($conn) 
		{
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
		}
		
		function QueryCheck($conn, $query) {
			if($conn -> query($query) === TRUE)
				echo "DATABASE ACCESS SUCCESSFUL\n";
				else
				echo "ERROR INSERTING INTO DATABASE\n" . $conn -> error;
		}		
	?>

	<body>

		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="#">RazorPortal</a>
				</div>
				<div>
					<ul class="nav navbar-nav">
						<li><a href="profile.php">Home</a></li>
						<li class="active"><a href="Schedule.php">Edit Schedule</a></li>
						<li><a href="Social.php">Social Wall</a></li> 
						<li><a href="Rewards.php">Rewards</a></li> 
					</ul>
				</div>
			</div>
		</nav>
			
	<?php
		 //Only run if submitting/deleting a class
		 if($_SERVER["REQUEST_METHOD"] == "POST") {
			 
				//connect to server
			$conn = new mysqli('localhost', 'root', 'tu3xooGh');
			connectDB($conn);
			
			if (isset($_POST["addclass"])){
				 //Check for empty fields on class submission
				 if(empty($_POST["ccode"]) || empty($_POST["cname"]) ||
					empty($_POST["days"]) || empty($_POST["time"]) || empty($_POST["building"]) || empty($_POST["room"])) {
					echo "You must fill out entire form to add a new class";
				 }
				 else{
					 //Insert values to mysql database
					 $insertrow = "INSERT INTO schedule (username, classcode, classname, days, time, building, room)";
					 $insertrow .= " VALUES (" . "'" . $_SESSION["username"] . "'";
					 $insertrow .= " , " . "'" . $_POST["ccode"] . "'";
					 $insertrow .= " , " . "'" . $_POST["cname"] . "'";
					 $insertrow .= " , " . "'" . $_POST["days"] . "'";
					 $insertrow .= " , " . "'" . $_POST["time"] . "'";
					 $insertrow .= " , " . "'" . $_POST["building"] . "'";
					 $insertrow .= " , " . "'" . $_POST["room"] . "'" . ");";
					 var_dump($insertrow);
				 QueryCheck($conn, $insertrow);
				 }
			}
			
			if(isset($_POST["deleteclass"])) {
				if(empty($_POST["DelCcode"])) {
					echo "You must include a class code to delete a class";
				}
				else{
					$delete = "DELETE FROM schedule WHERE classcode = '" . $_POST["DelCcode"] . "';";
					$checkSQL = "SELECT * FROM schedule WHERE classcode = '" . $_POST["DelCcode"] . "';";
					
					$check = $conn -> query($checkSQL);
					if($check -> num_rows > 0) {
						QueryCheck($conn, $delete);
					}
					else
						echo "Class must exist";
				}
			}
		}
	?>
	

		<div class="container-fluid">
			<h1 class="text-center" style="font-size:150px"></h1> <br><br>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Class Code</th>
						<th>Class Name</th>
						<th>Days</th>
						<th>Time</th>
						<th>Building</th>
						<th>Room</th>
					</tr>
				</thead>
				<tbody>
					<?php
									//Connect to SQL database
						$conn = new mysqli('localhost', 'root', 'tu3xooGh');
						ConnectDB($conn);
			
						//Get schedule from RAZORPORTAL sql
						$getSchedule = "SELECT classcode, classname, days, time, building, room FROM schedule WHERE username = \"" . $_SESSION["username"] . "\";";
						$schedule = $conn->query($getSchedule);
						//if($schedule === TRUE)
						// echo "DATABASE ACCESS SUCCESSFUL\n";
						//else
						//echo "ERROR ACCESSING INTO DATABASE\n" . $conn -> error;
						//Iterate over query results until table is finished.
						while ($row = $schedule->fetch_array(MYSQLI_ASSOC)) {
							echo "<tr>";
							echo "<td>".$row['classcode']."</td>";
							echo "<td>".$row['classname']."</td>";
							echo "<td>".$row['days']."</td>";
							echo "<td>".$row['time']."</td>";
							echo "<td>".$row['building']."</td>";
							echo "<td>".$row['room']."</td>";
							echo "</tr>";
									}
					?>
				</tbody>
			</table>
		</div>
		<br>
		
		<div class="container-fluid">
			<form name="editForm" class="form-inline" style="margin-bottom:25px" action="Schedule.php" method = "post">
			
				<div class="form-group col-sm-offset-3">
					<label for="ccode">Class Code:</label>
					<div>
						<input type="text" class="form-control" id="ccode" name="ccode" placeholder="Class Code">
					</div>
				</div>

				
				<div class="form-group">
					<label for="time">Class Time:</label>
					<div>
						<input type="text" class="form-control" id="time" name="time" placeholder="Class Time">
					</div>
				</div>
				
				<div class="form-group">
					<label for="building">Building:</label>
					<div>
						<select class="form-control" id="building" name="building">
						
								<?php
									//Get buildinglist
									$getBuildings = "SELECT name FROM buildings;";
									$buildings = $conn->query($getBuildings);
									while ($row2 = $buildings->fetch_array(MYSQLI_ASSOC)){
										echo "<option>".$row2['name']."</option>";
									}
								?>
								
						</select>
					</div>
				</div>
						
				<div class="form-group col-sm-offset-3">
					<label for="cname" >Class Name:</label>
					<div>
						<input type="text" class="form-control" id="cname" name="cname" placeholder="Class Name">
					</div>
				</div>

					
				<div class="form-group">
					<label for="days">Days:</label>
					<div>
						<input type="text" class="form-control" id="days" name="days" placeholder="Days">
					</div>
				</div>
				
				<div class="form-group">
					<label for="room">Room:</label>
					<div>
						<input type="text" class="form-control" id="room" name="room" placeholder="Room">
					</div>
				</div>
				
				<div class="text-center">
					<br><button type="submit" class="btn btn-default" name="addclass">Add Class</button>
				</div>
			</form>
			
			<form name="delete" class="form-inline" action="Schedule.php" method = "post">
				<div class="form-group col-sm-offset-4">
					<label for="DelCcode">Class Code:</label>
					<div>
						<input type="text" class="form-control" id="DelCcode" name="DelCcode" placeholder="Class Code">
						<button type="submit" class="btn btn-default" name="deleteclass">Delete Class</button>
					</div>
				</div>
			</form>
		</div>
		
		<?php
			$conn->close();	
		?>		
		
	</body>
</html>