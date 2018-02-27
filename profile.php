<!--
3.	A user profile management experience, which only a valid logged-in user can visit and edit. Visiting this page before authenticating should redirect a user to the login/registration page. On successful authentication, the user must be redirected back to their profile page. The profile page should allow the user to upload a small graphic as their avatar as well as allowing them to change their basic details. Re-authentication is required to change the user’s password.
-->
<?php
	session_start();
?>
<html>
	<head>
	<title>Profile</title>
	<style type="text/css">
	</style>
	<?php 
		if (($_SESSION["username"]) == null) {
			header("Location: login.php");
			exit();
		}
	?>
	</head>
	<body>
		<h3>User: <?php echo $_SESSION["username"] ?></h3>
		<?php $conn = pg_connect("host=localhost dbname=a2 user=postgres password=password");
		$val = $_SESSION['username'];
		$result = pg_query($conn, "SELECT * FROM users WHERE username='" . $val ."';");
		$row = pg_fetch_row($result);?>
		<form action="login.php" method="POST" >
			<table>
				<tr>
					<td>Email: </td>
					<td><?php echo $row[2] ?></td>
				</tr>
				<tr>
					<td>Avatar: </td>
					<td>The last avatar</td>
				</tr>
				<tr>
					<td><input type="submit" name="submit" /></td>
					<td></td>
				</tr>			
			</table>
		</form>
	</body>
</html>
