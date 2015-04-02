

<?php
   session_start();
   ?>
<!DOCTYPE php>
<html>
   <head>
      <style>
         table {
         border-collapse:collapse;
         float: center;
		 font-size: large;
         }
         table,td,th {
         border: 3px solid white;
         color: white;
         }
         th {
         background-color: #990000;
         color: white;
         }
         h1{ 	
         color: white; 
         text-align: center;
         font-size: 700%; 
         font-family: "Arial Black", Gadget, sans-serif}
         p {
         font-family: 'Gill Sans';
         text-align: center;
         color: white;
         }
         body {
         /*background-image: url("http://csce.uark.edu/~ndtaylor/razorback.jpg");*/
         background-color: #990000;
         background-size: auto;
         background-repeat: no-repeat;
         }
         ul {
         font-family: 'Gill Sans';
         list-style-type: none;
         margin: 0;
         padding: 0;
         overflow: hidden;
         }
         li {
         float: left;
         }
         a {
         font-family: 'Gill Sans';
         display: block;
         width: 190px;
         background-color: white;
         }
         form{	color: white; 
         text-align: center;
         font-size: large;
         font-family: "Arial Black", Gadget, sans-serif;
         line-height: 30px}
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
   </head>
   <body>
      <?php
         //Only run if submitting a class
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
      <br>
      <form name="editForm" action="profile.php" method="post" >
         Class Code: <input type="text" name="ccode"> 
		 Time: <input type="text" name="time"> 
         Building: <input type="text" name="building"> <br>
         Class Name: <input style = "margin-right:10px" type="text" name="cname"> 
         Days: <input type="text" name="days"> 
         Room: <input type="text" name="room"><br> <br>
         <input class="myButton" type="submit" value="Add Class" name="addclass">
      </form>
      <form method="link" action="Login.php">
         <input class="myButton" type="submit" value="Log Out" name="logout">
      </form>
   </body>
</html>

