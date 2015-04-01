<?php
   session_start();
   ?>
<!DOCTYPE php>
<html>
   <head>
      <style>
         table,td,th {
         border: 1px solid green;
         }
         th {
         background-color: green;
         color: white;
         }
         p {
         font-family: 'Gill Sans';
         text-align: center;
         color: black;
         }
         body {
         /*background-image: url("http://csce.uark.edu/~ndtaylor/razorback.jpg");*/
         background-color: white;
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
         echo "<p>Hello! Welcome to " . $_SESSION["username"] . "'s profile page!!</p>"
         ?>
      <table>
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
      <form name="editForm" action="profile.php" method="post">
         Class Code: <input type="text" name="ccode">
         Class Name: <input type="text" name="cname">
         Days: <input type="text" name="days">
         Time: <input type="text" name="time">
         Building: <input type="text" name="building">
         Room: <input type="text" name="room"><br>
         <input type="submit" value="Add Class" name="addclass">
      </form>
	  <form method="link" action="Login.php">
         <input type="submit" value="Log Out" name="logout">
      </form>
   </body>
</html>
