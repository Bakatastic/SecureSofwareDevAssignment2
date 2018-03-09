<?php
	session_start();
	if (isset($_SESSION['fromProfile'])) {
		$checkProfile = $_SESSION['fromProfile'];
	} else 	{
		$checkProfile = $_SESSION['fromProfile'];
	}
	
    if ((($_SESSION["username"]) != null) && ($_SESSION['Change'] != 1)) {
        session_destroy();
    }
?>
<html>
	<head>
	<title>Login</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	</head>
	<body>
		<h1>Login</h1>
		<?php
			//Set variables to empty values
			$usernameErr = $paswordErr = $otherErr = "";
			$username = $password= "";
			$fail = 0;
			$conn = pg_connect("host=localhost dbname=a2 user=postgres password=password");
			
			if($_SERVER["REQUEST_METHOD"] == "POST"){
				//Username regex to sanitize input before comparing database
				if(empty($_POST["username"])){
					$usernameErr = "Username is required<br>";
					$fail = 1;
				}
				else{
					$username = sanitize($_POST["username"]);
					//Check input
					if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
						$usernameErr = "Incorrect Username<br>";
						$fail = 1;
					}
				}
				
				//Password regex to sanitize input before comparing database
				if(empty($_POST["password"])){
					$passwordErr = "Password is required<br>";
					$fail = 1;
				}
				else{
					$password = sanitize($_POST["password"]);
					//Check input
					if(!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $password)){
						$passwordErr = "Incorrect Password format. Use at least 8 characters, 1 letter and 1 number<br>";
						$fail = 1;
					}
					//Encrypt
					$password = md5($password . "AmazingSalt");
				}
				
				//Add to database if regex check passes
				if($fail == 0){
					$result = pg_query($conn, "SELECT * FROM users WHERE username='$username'");
					while($user = pg_fetch_row($result)){
						//Matches credentials
						
						if($username == $user[0] && $password == $user[1]){
							if($user[6] == 'f'){
								$otherErr = "Account not approved";
							}
							else if($user[7] == 't'){
								$otherErr = "Account locked";
							}
							else if($user[9] == 'f'){
								$otherErr = "Account is not Activated";
							}
							else{
								//Login stuff
								$_SESSION["username"] = $_POST["username"];
								//Send to another page
								if ($checkProfile == 1)
								{							
									$checkProfile = 0;
									//destination if coming from Profile.php
									header("Location: profile.php");
									exit();
								} else 
								{
									//checks if the change password flag is up. redirects to correct page
									if ($_SESSION['Change'] == 1){
										$_SESSION['Change'] = 2;
										header("Location: profile.php");
										exit();
									} else {
										//if everything is successful. neutral destination
										if ($user[5] == 't'){
											$_SESSION['admin'] = 1;
										}
										header("Location: postManagement.php");
										exit();
									}
								}
							}
						}
						else{
							//$otherErr = "Incorrect username or password";
							$otherErr = "$username . $user[0] . $password . $user[1]";
							//Increment failed login attempts. Lock if 5 fails
							//$result = pg_query($conn, "SELECT * FROM users");
							if($user[8]<4){ //It says 4 here, but in practice, it's 5.
								if($user[7] == 'f'){
									$result = pg_query($conn, "UPDATE users SET failedattempts = failedattempts + 1 WHERE username = '$_POST[username]';");
								}
								else{
									$otherErr = "Account locked";
								}
							}
							else{
								$result = pg_query($conn, "UPDATE users SET accountlock = TRUE, failedattempts = 0 WHERE username = '$_POST[username]';");
							}
						}
					}
				}
			}
			
			function sanitize($input){
				$input = trim($input);
				$input = stripslashes($input);
				$input = htmlspecialchars($input);
				return $input;
			}
		?>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
			<div class="form-group">
				<label for='inputUsername'>Username:</label>
				<input type="text" name="username" id="inputUsername" class="form-control"/>
				<br>
				<label for='inputPassword'>Password:</label> 
				<input type="password" name="password" id="inputPassword" class="form-control"/>
				<br>
				<input type="submit" name="submit" value='Login' class="btn"/>
			</div>
		</form>
		<br>
		Don't have an account? <a href="register.php">Register!</a>
		<br>
		<a href="forgot.php">Forgot Password</a>
	</body>
</html>
