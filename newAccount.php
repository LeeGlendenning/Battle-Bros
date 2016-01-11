<?php
	$user = $_POST["user"];
	$pass = $_POST["pass"];
	$email = $_POST["email"];
	
	$servername = "hopper.wlu.ca";
	$username = "glen9190";
	$password = "Let4rokok";
	$dbname = "glen9190";
	$conn = new mysqli($servername, $username, $password, $dbname);// Create connection
	if ($conn->connect_error) {// Check connection
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql = "INSERT INTO BattleBros (username, password, email) VALUES ('$user', '$pass', '$email')";
	$result = $conn->query($sql);
	$conn->close();
	
?>