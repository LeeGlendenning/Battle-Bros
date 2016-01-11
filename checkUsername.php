<?php

	

	
	$user = $_POST["username"];
	
	$servername = "hopper.wlu.ca";
	$username = "glen9190";
	$password = "Let4rokok";
	$dbname = "glen9190";
	$conn = new mysqli($servername, $username, $password, $dbname);// Create connection

	if ($conn->connect_error) {// Check connection
		
		die("Connection failed: " . $conn->connect_error);
	}
	
	
	$sql = "SELECT username FROM BattleBros WHERE username = '$user'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo "true";
	} else {
		echo "false";
	}
	$conn->close();
	
?>