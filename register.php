<?php
	session_start();
	if (($_SESSION["username"]) != null) {
        session_destroy();
    }
?>
<html>
	<head>
		<title>
			Register
		</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="styles/style.css">
	</head>
	<body>
		<h1>Create New User</h1>
		<?php
			//Set variables to empty values
			$usernameErr = $paswordErr = $emailErr = "";
			$username = $password = $email = "";
			$fail = 0;
			
			if($_SERVER["REQUEST_METHOD"] == "POST"){
				//Username regex
				if(empty($_POST["username"])){
					$usernameErr = "Username is required<br>";
					$fail = 1;
				}
				else{
					$username = sanitize($_POST["username"]);
					//Check input
					if(!preg_match("/^[a-zA-Z0-9]{1,20}$/", $username)){
						$usernameErr = "Only letters and allowed<br>";
						$fail = 1;
					}
				}
				
				//Password regex
				if(empty($_POST["password"])){
					$passwordErr = "Password is required<br>";
					$fail = 1;
				}
				else{
					$password = sanitize($_POST["password"]);
					//Check input
					if(!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,40}$/", $password)){
						$passwordErr = "Enter a password with at least 8 letters and numbers<br>";
						$fail = 1;
					}
					//Encrypt
					$password = hash('sha256', $password . 'AwesomeSalt');
					//$password = md5($password . "AmazingSalt");
				}
				
				//Email regex
				if(empty($_POST["email"])){
					$emailErr = "Email is required<br>";
					$fail = 1;
				}
				else{
					$email = sanitize($_POST["email"]);
					//Check input
					if(!preg_match("/^[a-zA-Z0-9.!#$%&'*+=?^_`{|}~-]{1,}@[a-zA-Z0-9]{1,}\.[a-zA-Z0-9]{1,}$/", $email)){
						$emailErr = "Enter a proper email<br>";
						$fail = 1;
					}
				}
				
				//Add to database if regex check passes
				if($fail == 0){
					$conn = pg_connect("host=localhost dbname=a2 user=postgres password=password");
					if ($conn) {
						//DO NOT CHANGE PLEASE I SPENT A MILLENIA FIXING THIS ONE LINE
						//TOO BAD I CHANGED IT AND THERE'S NOTHING YOU CAN DO ABOUT IT HAHAHAHAHAHAHAHAHAHAHAHA! SUCK IT.
						$query = "INSERT INTO users (username, password, email, avatar, adminRole, approved, accountLock, failedAttempts, activated) VALUES ('$_POST[username]','$password','$_POST[email]', 'images/default.jpg', FALSE, FALSE, FALSE, 0, FALSE);";
						$result = pg_query($conn, $query);
						alert("User Added");
						header("Location: login.php");
						exit();
					} else {
						alert("conn failed");
					}
					
				} else 
				{
					alert("Failed");
				}
			}
			
			function sanitize($input){
				$input = trim($input);
				$input = stripslashes($input);
				$input = htmlspecialchars($input);
				return $input;
			}
			
			function alert($msg) {
				echo "<script type='text/javascript'>alert('$msg');</script>";
			}
		?>
			<!-- Will redirect to self-->
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
			<div class="form-group">
				<label for='userInput'>Username: </label>
				<input type="text" id="userInput" name="username" class="form-control"/>
				<br>
				<label for='passInput'>Password: </label>
				<input type="password" id='passInput' name="password" class="form-control"/>
				<br>
				<label for='emailInput'>Email Address: </label>
				<input type="text" id="emailInput" name="email" class="form-control"/>
				<br>
				<input type="submit" class='btn'/>
			</div>
		</form>
		<?php
			echo $usernameErr;
			echo $passwordErr;
			echo $emailErr;
		?>
		<br>
		Have an account? <a href="login.php">Login!</a>
	</body>
</html>