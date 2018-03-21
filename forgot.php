<?php
	session_start();
	if (($_SESSION["username"]) != null) {
            session_destroy();
    }
?>
<html>
	<head>
	<title>Login</title>
	<style type="text/css">
	</style>
	</head>
	<body>
		<h1>Reset Password</h1>
		<?php
			//Set variables to empty values
			$emailErr = "";
			$email= "";
			$fail = 0;
			
			if($_SERVER["REQUEST_METHOD"] == "POST"){
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
				
				//Matches email and resets password
				if($fail == 0){
					//The password always resets to 'password1' for now. Ideally, it should be randomly generated.
					$password = hash('sha256', 'password1' . 'AwesomeSalt');
					//$password = md5(sanitize("password1") . "AmazingSalt");
					$conn = pg_connect("host=localhost dbname=a2 user=postgres password=password");
									$result = pg_query($conn, "UPDATE users SET password = '$password' WHERE email = '$_POST[email]'");
					alert("Password reset!");
					//Send to another page
					header("Location: login.php");
					exit();
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
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
				<table>
					<tr>
						<td align=right>
							Email Address:
						</td>
						<td>
							<input type="text" name="email"/>
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
			<?php
				echo $emailErr;
			?>
			<br>
			<a href="login.php">Back</a>
	</body>
</html>
