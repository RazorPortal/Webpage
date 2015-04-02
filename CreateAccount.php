<!DOCTYPE php>
<html>
   <head>
   <style>
      body{	background-color: #990000}
      h1{ 	color: white; 
      text-align: center;
      font-size: 900%; 
      font-family: "Arial Black", Gadget, sans-serif}
      form{	color: white; 
      text-align: center;
      font-size: large;
      font-family: "Arial Black", Gadget, sans-serif;
      line-height: 15px}
      
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
		.FormStyle input {
		position: relative;
		left: 75px;
		line-height: 24px;
		top: 0px;
		}
			
   </style>
   </head>

	  <body>

	<?php
		$status = "";
		$username = $password = $email = "";

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		if(empty($_POST["username"]) || empty($_POST["password"]) ||
				empty($_POST["password2"]) || empty($_POST["email"])) {
				echo "Must fill out entire form"; 		
				}
		else if($_POST["password"] != $_POST["password2"]) 
		{
			echo "Passwords must match";
		}
		else {
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
				echo "ERROR CREATING DATABASE\n" . $conn -> error;
			
			$UserCheck = "SELECT username FROM user WHERE username = " . "'" . $_POST["username"] . "' " . ";";
			var_dump($UserCheck);
			$result = $conn -> query($UserCheck);
				
			//check if user exists 
			if($result -> num_rows > 0) {
				echo "Username is taken";
			}
			else {
				$query2 = "INSERT INTO user (username, password)";
				$query2 .= " VALUES (" . "'" . $_POST["username"] . "'";
				$query2 .= " , " . "'" . $_POST["password"] . "'" . ");";
				
				if($conn -> query($query2) === TRUE)
					echo "DATABASE ACCESS SUCCESSFUL\n";
				else
					echo "ERROR CREATING DATABASE\n" . $conn -> error;
			
			}
			
			$conn -> close();

		}
	
	}
	?>

     	<form class = "FormStyle" method="POST">
         Username: <input style="margin-left:23px;" type="text" name="username"> <br>
         UARK E-mail: <input type="text" name="email"> <br>
         Password: <input style="margin-left:30px;" type="password" name="password"> <br>
         Re-Enter Password: <input style="margin-right:52px;" type="password" name="password2"> <br> 
         <input style="margin-top:15px; margin-left:150px;" class="myButton" type="submit" value="Create Account"> 
      </form>
	</body>
</html>

