<?php
	session_start();
    if (($_SESSION["username"]) != null) {
            header("Location: login.php");
            exit();
     }
?>
<html>
	<head>
	<title>Login</title>
	<style type="text/css">
	</style>
	</head>
	<body>
		<h1>Login</h1>
		<?php
			//Set variables to empty values
			$usernameErr = $paswordErr = "";
			$username = $password= "";
			$fail = 0;
			
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
						$passwordErr = "Incorrect Password<br>";
						$fail = 1;
					}
					//Encrypt
					$password = md5($password . "AmazingSalt");
				}
				
				//Add to database if regex check passes
				if($fail == 0){
					$conn = pg_connect("host=localhost dbname=a2 user=postgres password=password");
									$result = pg_query($conn, "SELECT * FROM users");
					while($user = pg_fetch_row($result)){
						//This assumes that the username is the first column in the table
						if($username == $user[0] && $password == $user[1]){
							//Login stuff
							echo "Logged in!";
							$_SESSION["username"] = $_POST["username"];
							//Send to another page
							header("Location: profile.php");
							exit();
						}
					}
					//Place failed to login message here somewhere
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
				<table>
					<tr>
						<td align=right>
							Username:
						</td>
						<td>
							<input type="text" name="username"/>
						</td>
					</tr>
					<tr>
						<td align=right>
							Password:
						</td>
						<td>
							<input type="text" name="password"/>
						</td>
					</tr>
					<tr>
						<td>
						</td>
						<td align=center>
							<input type="submit"/>
						</td>
					</tr>
				</table>
			</form>
			<br>
			<a href="forgot.php">Forgot Password</a>
	</body>
</html>
