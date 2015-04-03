<?php

class Database{
	//Connect to razorportal database
	public function connect(){
		$conn = new mysqli('localhost', 'root', 'tu3xooGh');
		if($conn -> connect_error) {
			die("Connection failed: " . $conn -> connect_error);
		}

		//use Razorportal MYSQL database
		$query = "USE razorportal;";
		if($conn -> query($query) !== TRUE)
			echo "ERROR OPENING DATABASE\n" . $conn -> error;
		
		return $conn;
	}
}

?>
