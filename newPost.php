<?php
	session_start();
	if (($_SESSION["username"]) == null) {
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
		<h1>New Post</h1>
		<?php
			//Set variables to empty values
			$postErr = "";
			$posttext = "";
			$fail = 0;
			
			if($_SERVER["REQUEST_METHOD"] == "POST"){
				//Password regex to sanitize input before comparing database
				if(empty($_POST["posttext"])){
					$postErr = "Enter a post<br>";
					$fail = 1;
				}
				else{
					$posttext = sanitize($_POST["posttext"]);
				}
				//Add to database if regex check passes
				if($fail == 0){
					$conn = pg_connect("host=localhost dbname=a2 user=postgres password=password");
					if($conn){
						$query = "INSERT INTO posts (posttext, username) VALUES ('$posttext','$_SESSION[username]');";
						$result = pg_query($query);
					}
					else {
						alert("conn failed");
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
				<table>
					<tr>
						<td align=right>
							Post:
						</td>
						<td>
							<input type="text" name="posttext"/>
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
			<?php
				echo $postErr;
			?>
	</body>
</html>
