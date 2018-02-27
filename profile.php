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
			header("Location: login.php"); /* Redirect browser */
			exit();
		}
	?>
	</head>
	<body>
		<h3>User : <?php echo $_SESSION["username"] ?></h3>
		<form action="login.php" method="POST" >
			<table>
				<tr>
					<td>Username: </td>
					<td><input type="text" name="userInput" required /></td>
				</tr>
				<tr>
					<td>Password: </td>
					<td><input type="text" name="emailInput" required /></td>
				</tr>
				<tr>
					<td><input type="submit" name="submit" /></td>
					<td></td>
				</tr>			
			</table>
		</form>
	</body>
</html>
