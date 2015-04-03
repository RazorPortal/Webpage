<style type="text/css">
	@import url('MainStyle.css');
</style>

<!DOCTYPE php>

<?php session_start(); ?>
<html>
	<body  link = "white" vlink = "white">

	<ul>
		<li><a href="profile.php">Home</a></li>
		<li><a href="Schedule.php">Edit Schedule</a></li>
		<li><a href="Map.asp">Campus Map</a></li>
		<li><a href="Social.php">Social Wall</a></li>
		<li><a href="Rewards.asp">Rewards</a></li>
	 </ul> 
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
			 $conn -> close();
		}
		
		if(isset($_POST["deleteclass"])) {
			if(empty($_POST["DelCcode"])) {
				echo "You must include a class code to delete a class";
			}
			else{
				$check = "DELETE FROM schedule WHERE classcode = '" . $_POST["DelCcode"] . "';";
				var_dump($check);
				if($conn -> query($check) === TRUE)
					echo "Database access successful";
				else
					echo "Database error";
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
            $servername = "localhost"; //uaf59189.ddns.uark.edu
            $conn = new mysqli($servername, 'root', 'tu3xooGh');
            if($conn -> connect_error) {
				die("Connection failed: " . $conn -> connect_error);
            }
            echo "Connected successfully";
            $query = "USE razorportal;";
            if($conn -> query($query) === TRUE)
				echo "DATABASE ACCESS SUCCESSFUL\n";
            else
				echo "ERROR OPENING DATABASE\n" . $conn -> error;
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
			
            $conn -> close();
            ?>
	</table>
	<form name="editForm" action="Schedule.php" method="post" >
		 <br>
		 Post a status: <input type="text" name="status">

         <input class="myButton" type="submit" value="Submit" name="addclass">
      </form>
	  
	
	</body>
   </html>