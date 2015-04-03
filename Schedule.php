<style type="text/css">
	@import url('MainStyle.css');
</style>

<!DOCTYPE php>


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




<html>
	<body  link = "white" vlink = "white">

	<ul>
		<li><a href="profile.php">Home</a></li>
		<li><a href="Schedule.php">Edit Schedule</a></li>
		<li><a href="Map.asp">Campus Map</a></li>
		<li><a href="Social.asp">Social Wall</a></li>
		<li><a href="Rewards.asp">Rewards</a></li>
	 </ul> 
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
	</table>
	
	<form name="editForm" action="Schedule.php" method="post" >
		 <br>
         Class Code: <input type="text" name="ccode"> 
		 Time: <input type="text" name="time"> 
         Building: <select name="building">
	 	
		<?php
			//Get buildinglist
			$getBuildings = "SELECT name FROM buildings;";
			$buildings = $conn->query($getBuildings);
			while ($row2 = $buildings->fetch_array(MYSQLI_ASSOC)){
				echo "<option>".$row2['name']."</option>";
			}
		?>

		</select> <br> 
         Class Name: <input type="text" name="cname"> 
         Days: <input type="text"  name="days"> 
         Room: <input type="text" name="room"><br> <br>
         <input class="myButton" type="submit" value="Add Class" name="addclass">
      </form>
	  
	<form name="delete" action="Schedule.php" method="post">
		<br>
		Class Code: <input type="text" name="DelCcode"> 
		<input class="myButton" name = "deleteclass" type="submit" value="Delete Class">
	</form>
	
	<?php
		$conn->close();	
	?>
	
	</body>
   </html>