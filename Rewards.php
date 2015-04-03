<style type="text/css">
	@import url('MainStyle.css');
</style>

<!DOCTYPE php>
<?php
	include 'database.class.php';
	
	//Connect to razorportal database
	$database = new Database();
	$conn = $database->connect();
?>
<html>
	<body  link = "white" vlink = "white">

	<ul>
		<li><a href="profile.php">Home</a></li>
		<li><a href="Schedule.php">Edit Schedule</a></li>
		<li><a href="Map.php">Campus Map</a></li>
		<li><a href="Social.php">Social Wall</a></li>
		<li><a href="Rewards.php">Rewards</a></li>
	 </ul> 

	<h1 align="center">Leaderboard</h1>
	
	<table align="center" name="leaderboard">
		 <tr>
            <th>Rank</th>
            <th>Username</th>
            <th>Points</th>
         </tr>
         <tr>
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
         </tr> 
	</table>

	<?php
		$conn->close();	
	?>

	</body>
   </html>
