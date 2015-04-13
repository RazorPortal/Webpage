<!DOCTYPE html>

<?php
	include 'database.class.php';
	
	//Connect to razorportal database
	$database = new Database();
	$conn = $database->connect();
?>

<html>	
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
						<li><a href="Social.php">Social Wall</a></li> 
						<li class="active"><a href="Rewards.php">Rewards</a></li> 
				  </ul>
				</div>
			</div>
		</nav>
		
		<div class="container-fluid">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Rank</th>
						<th>Username</th>
						<th>Points</th>
					</tr>
				</thead>
				<tbody>
					 <?php
            //Get schedule from RAZORPORTAL sql
            $getRanks = "SELECT username, points FROM user ORDER BY points DESC LIMIT 25;";
            $schedule = $conn->query($getRanks);

            $rank = 1;
            while ($row = $schedule->fetch_array(MYSQLI_ASSOC)) {
							echo "<tr>";
							echo "<td>".$rank."</td>";
							echo "<td>".$row['username']."</td>";
							echo "<td>".$row['points']."</td>";
							echo "</tr>";

							++$rank;
            }
            ?>
				</tbody>
			</table>
		</div>
		<br>
		<?php
			$conn->close();	
		?>
		
	 </body>
</html>
		