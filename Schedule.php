<!DOCTYPE php>
<html>
	<style>
	
	.myButton {
      background-color:#CC0000;
      border:1px solid #a4b6ed;
      display:inline-block;
      cursor:pointer;
      color:#ffffff;
      font-family:arial;
      font-size:17px;
      padding:13px 18px;
      text-decoration:none;
      text-shadow:0px 1px 0px #2f6627;
      }
      
      .myButton:hover {
      background-color:#8f0000;
      }
      
      .myButton:active {
      position:relative;
      top:1px;
      }
	</style>
	
	<body> 
	
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
	
	<form name="editForm" action="profile.php" method="post" >
         Class Code: <input type="text" name="ccode"> 
		 Time: <input type="text" name="time"> 
         Building: <input type="text" name="building"> <br>
         Class Name: <input style = "margin-right:10px" type="text" name="cname"> 
         Days: <input type="text" name="days"> 
         Room: <input type="text" name="room"><br> <br>
         <input class="myButton" type="submit" value="Add Class" name="addclass">
      </form>
	
	
	<p> Schedule </p> </body>