<style type="text/css">
	@import url('MainStyle.css');
</style>

<?php 
session_destroy();
session_start(); ?>

<!DOCTYPE php>
<html>

	 <?php		
		//check if post
		if($_SERVER["REQUEST_METHOD"] == "POST") 
		{
			if(empty($_POST["username"]) || empty($_POST["password"])) //check if both username and password have been input
			{
				echo "Must provide both username and password"; 		
			}
			else 
			{
				//connect to localhost
				
				$servername = "localhost";
				$conn = new mysqli($servername, 'root', 'tu3xooGh');
				
				if($conn -> connect_error) {
					echo "Connection failed: " . $conn -> connect_error;
				}
				else {
					echo "Connected successfully";
				}
			
				//open razorportal database
				$openDB = "USE razorportal;";
			
				if($conn -> query($openDB) === TRUE)
					echo "DATABASE ACCESS SUCCESSFUL\n";
				else
					echo "ERROR ACCESSING DATABASE\n" . $conn -> error;
				
				//build user check script
				$UserCheck = "SELECT * FROM user WHERE username = " . "'" . $_POST["username"] . "'";
				$UserCheck .= "AND password = " . "'" . $_POST["password"] . "'" . ";";
				
				//var_dump($UserCheck);
				$result = $conn -> query($UserCheck);
				
				//check if user exists 
				if($result -> num_rows > 0) {
					echo "Log In Success!!";
					$_SESSION["username"] = $_POST["username"];
					echo $_SESSION["username"]; ?>
					<script>
						window.location = 'http://uaf59189.ddns.uark.edu/profile.php';
					</script>
					<?php
				}
				else {
					echo "Username and Password do not match or can not be found";
					session_destroy();
				}
				
				$conn -> close();
			}
	    }
	?>
	
   <style>
      h1{ 	color: white; 
      text-align: center;
      font-size: 900%; 
      font-family: "Arial Black", Gadget, sans-serif}
   </style>
   <head>
      <title> RazorPortal </title>
      <h1> RazorPortal </h1>
   <body>
   
	
      <form method = "post">
         Username: <input style = "margin-left: 50px;" type="text" name="username"> <br> <br>
         Password: <input style = "margin-left: 55px;" type="password" name="password"> <br> <br>
         <input style="margin-top:15px; margin-left:150px;" class="myButton" type="submit" value="Log In" action = $_SERVER['PHP_SELF']>    
      </form> 
    
  	  <form method="link" action="CreateAccount.php">
	    	<input style="margin-top:15px; margin-left:150px;" class="myButton" type="submit"  value="Create Account">
      </form>
   </body>
   </head>
</html>


