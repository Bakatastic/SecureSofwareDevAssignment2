<html>
	<head>
		<title>
			Register
		</title>
	</head>
	<body>
		<h1>Create New User</h1>
		<?php
			//Set variables to empty values
			$usernameErr = $paswordErr = "";
			$username = $password= "";
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
					$password = md5($password);
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
					alert("pass");
					$conn = pg_connect("host=localhost dbname=a2 user=postgres password=password");
					if ($conn) {
						//alert("conn pass");
						$query = "INSERT INTO users (username, password) VALUES ('$_POST[username]','$_POST[password]');";
						$result = pg_query($query);
						alert("User Added");
					} else {
						alert("conn failed");
					}
					
				} else 
				{
					alert("fail");
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
		<table>
			<!-- Will redirect to self-->
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
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
			</form>
		</table>
		<?php
			echo $usernameErr;
			echo $passwordErr;
		?>
	</body>
</html>