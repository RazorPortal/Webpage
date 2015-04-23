<!DOCTYPE html>
<html>

	<?php
	session_start();

	//connect to server
	$conn = new mysqli('localhost', 'root', 'tu3xooGh');
	if($conn -> connect_error) {
		die("Connection failed: " . $conn -> connect_error);
	}

	//user Razorportal MYSQL database
	$query = "USE razorportal;";
	$conn -> query($query);
	?>
	
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
					<a class="navbar-brand" href="profile.php">RazorPortal</a>
				</div>
				<div>
					<ul class="nav navbar-nav">
						<li class="active"><a href="profile.php">Home</a></li>
						<li><a href="Schedule.php">Edit Schedule</a></li>
						<li><a href="Social.php">Social Wall</a></li> 
						<li><a href="Rewards.php">Rewards</a></li> 
				  </ul>
				</div>
			</div>
		</nav>
		
		<?php
			echo "<h1 class='text-center' style='font-size:150px'> " . $_SESSION["username"] . "'s Profile</h1>"
		?>
		
		<div class="container-fluid">
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
						//Get schedule from RAZORPORTAL sql
						$getSchedule = "SELECT classcode, classname, days, time, building, room FROM schedule WHERE username = \"" . $_SESSION["username"] . "\";";
						$schedule = $conn->query($getSchedule);
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
	  
	  <form method="link" action="Login.php">
			<div class="text-center">
				<input class="btn btn-default" type="submit" value="Log Out">
			</div>
		</form>
  </body>
	
	<?php
		$conn->close();	
	?>

</html>

