<!DOCTYPE HTML>
<html>
<head>
	<title>Battle Bros</title>
	<link rel="stylesheet" type="text/css" href="./style.css">
	<meta charset="UTF-8">
	<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1, user-scalable=1\"/> 
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	
	<script type="text/javascript">
		
		$( document ).ready(function() {
			//setInterval(function () {change()}, 100);
		});
		
		function showLoginForm(){
			document.getElementById("loginp").innerHTML = "<form class=\"login\" method=\"post\">Username: <input type=\"text\" name=\"username\">Password: <input type=\"password\" name=\"password\"><input type=\"submit\" value=\"Login\" name=\"login\"></form>";
		}
		
	</script>
	
	
</head>


<body >

	<?php
		//check if user is mobile
		require_once 'Mobile_Detect.php';
		$detect = new Mobile_Detect;
		$detect->deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
		if ($detect->deviceType != "computer") {
			echo "You are on a mobile device!";
		}
	
		function login($user, $pass){
			$servername = "hopper.wlu.ca";
			$username = "glen9190";
			$password = "Let4rokok";
			$dbname = "glen9190";
			$conn = new mysqli($servername, $username, $password, $dbname);// Create connection
			if ($conn->connect_error) {// Check connection
				die("Connection failed: " . $conn->connect_error);
			}
			
			$sql = "SELECT username, password FROM BattleBros WHERE username = '$user' AND password = '$pass'";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				return "<div style=\"padding-bottom:1%;\"><span style=\"display:block;float:right;\">Welcome $user! <span><input type=\"submit\" value=\"Logout\" name=\"logout\" onClick=\"showLoginForm()\"></div>";
			} else {
				return "Invalid Login";
			}
			$conn->close();
		}
		
		function loginForm(){
			return "<form class=\"login\" method=\"post\"> 
						Username: <input type=\"text\" name=\"username\">
						Password: <input type=\"password\" name=\"password\">
						<input type=\"submit\" value=\"Login\" name=\"login\">
					</form>";
		}
		
	?>
	
	<div>
		<p id="loginp">
			<?php 
				if (isset($_POST['login'])) 
				{
					$result = login($_POST["username"], $_POST["password"]);
					if ($result == "Invalid Login"){
						echo "<span style=\"color:#990000;float:right;\">Invalid Login</span>" . "<br>" . loginForm();
					}else{
						echo $result;
					}
				}else{
					echo loginForm();
				}
			?>
		</p>
	</div>
	
	
	<div class="header">
		<img src="Header2.png" alt="Battle Bros" id="BBtitle"></img>	
	</div>
	
	<div class="createaccount">
		<a href="createAccount.php"> 
			<img src="NewAccount.png" alt="Create Account" id="BBcreate"></img>
		</a>
	</div>
	
	<div class="playnow">
		<a href="nodejs/gameplay.html"> 
			<img src="PlayNow.png" alt="PlayNow" id="BBplay"></img>
		</a>
	</div>
	
	
	<footer style="padding-top:50px;width:300px;display:block;margin-left:42.2%;">
		<p>Copyright 2015 Lee Glendenning</p>
	</footer>

</body>


</html>