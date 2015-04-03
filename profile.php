<style type="text/css">
	@import url('MainStyle.css');
</style>

<?php
   session_start();
   
    //connect to server
	 $conn = new mysqli('localhost', 'root', 'tu3xooGh');
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
   ?>
   
<!DOCTYPE php>
<html>
   <head>
      <style>
         h1{ 	
         color: white; 
         text-align: center;
         font-size: 700%; 
         font-family: "Arial Black", Gadget, sans-serif}
         }
      </style>
   </head>
   <body   link = "white" vlink = "white">
   
	 <ul>
		<li><a href="profile.php">Home</a></li>
		<li><a href="Schedule.php">Edit Schedule</a></li>
		<li><a href="Map.php">Campus Map</a></li>
		<li><a href="Social.php">Social Wall</a></li>
		<li><a href="Rewards.php">Rewards</a></li>
	 </ul> 
	 
    <?php
		if($_SERVER["REQUEST_METHOD"] == "POST") {        
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
				 if($conn -> query($insertrow) === TRUE)
					echo "DATABASE ACCESS SUCCESSFUL\n";
				 else
					echo "ERROR INSERTING INTO DATABASE\n" . $conn -> error;
				 }
			}
		 }
		 //Greeting
		 echo "<h1> " . $_SESSION["username"] . "'s Profile</h1>"
    ?>
	
      <table align="center">
         <tr>
            <th>Class Code</th>
            <th>Class Name</th>
            <th>Days</th>
            <th>Time</th>
            <th>Building</th>
            <th>Room</th>
         </tr>
		 
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
      </table>
      <br>
   </body>
<?php
	$conn->close();	
?>
</html>

