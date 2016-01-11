<!DOCTYPE HTML>
<html>
	<head>
		<title>Battle Bros</title>
		<link rel="stylesheet" type="text/css" href="./style.css">
		<meta charset="UTF-8">
		<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1, user-scalable=1\"/> 
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		
		<script type="text/javascript">
			/*var pass1;
			var pass2;
			$( document ).ready(function() {
				$("#Submit").click(function(){
					pass1 = document.forms["register"]["password"].value;
					pass2 = document.forms["register"]["password2"].value;
					console.log(pass1 + " " + pass2);
				}); 
			});*/
			
			function checkForm(user, pass1, pass2, email){
				if (checkPasswords(pass1, pass2) && checkEmail(email)){
						$.post("newAccount.php", //Required URL of the page on server
						{ // Data Sending With Request To Server
							user:user,
							pass:pass1,
							email:email
						},
						function(result){ // Required Callback Function
							document.getElementById("error").innerHTML = "Account successfully created!";
						});
				}
			}
			
			function checkPasswords(pass1, pass2){
				
				if (pass1.localeCompare(pass2) == 0){
					return true;
				}else{
					document.getElementById("error").innerHTML = "Passwords don't match";
					return false;
				}
			}
			
			function checkEmail(email){
				var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
				if (re.test(email) == true){
					return true;
				}else{
					document.getElementById("error").innerHTML = "Invalid email address";
					return false;
				}
			}
			
		</script>
		
		
	</head>


	<body>
		
		
		<div style="padding-bottom:1%;">
			<a href="BattleBros.php" id="home">Home</a>
		</div>
		
		<div class="header">
			<img src="CreateAccount.png" alt="Battle Bros" style="width:50%;padding-bottom:5%;" id="BBtitle"></img>	
		</div>
		
		
		
		<div id="createDiv">
			<form name="register" id='register' action='' method='post' accept-charset='UTF-8'>
				<fieldset >
					<legend>Register</legend>
					<br>
					<p>
					<label style="color:#DD0000;" id="error">
						<?php
							if (isset($_POST['Submit'])) 
							{
								$user = $_POST["username"];
								$pass1 = $_POST["password"];
								$pass2 = $_POST["password2"];
								$email = $_POST["email"];
								
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
									echo "Username in use";
								} else {
									echo '<script> checkForm(\'' . $user . '\', \'' . $pass1 . '\', \'' . $pass2 . '\', \'' . $email . '\'); </script>';
								}
								$conn->close();
							}
						?>
					</label>
					<br><br>
					</p><p>
					<label for="username">Username:</label>
					<input type='text' name='username' id='username' maxlength="50" /><br><br>
					</p><p>
					<label for="password">Password:</label>
					<input type='password' name='password' id='password' maxlength="50" /><br><br>
					</p><p>
					<label for="password2">Re-enter Password:</label>
					<input type='password' name='password2' id='password2' maxlength="50" /><br><br>
					</p><p>
					<label for="email">Email Address:</label>
					<input type='text' name='email' id='email' maxlength="50" /><br><br><br>
					<input type='submit' name='Submit' value='Submit' id="submit"/>
					</p>
				</fieldset>
			</form>
		</div>
		
		<footer style="padding-top:50px;width:300px;display:block;margin-left:42.2%;">
			<p>Copyright 2015 Lee Glendenning</p>
		</footer>
	</body>
</html>