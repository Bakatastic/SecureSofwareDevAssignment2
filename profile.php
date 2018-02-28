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
		<form action="profile.php" method="post" enctype="multipart/form-data" >
			<table>
				<tr>
					<td>Avatar: </td>
					<td><img height='30px' width='30px' src='<?php echo $row[3] ?>'/></td>
				</tr>
				<tr>
					<td>Upload file:</td>
					<td><input type="file" name="imgUpload" id="imgUpload" ></td>
				</tr>
				<tr>
					<td>Email: </td>
					<td><?php echo $row[2] ?></td>
				</tr>
				<tr>
					<td>Bio: </td>
					<td><?php echo $row[4] ?></td>
				</tr>
				<tr>
					<td><input type="submit" name="submit" /></td>
					<td></td>
				</tr>			
			</table>
		</form>
		
	</body>
	<?php 
		$directory = "images/";
		$user = $_SESSION['username'];
		$target_file = $directory . basename($_FILES['imgUpload']['name']);
		alert($target_file);
		if(isset($_POST["submit"])) {
			//$query = "UPDATE users SET (avatar) = ('" . $target_file . "') WHERE username= ' " . $_SESSION["username"] . "';";
			echo "<p>UPDATE users SET avatar='$target_file' WHERE username='$user';</p>";
			if (move_uploaded_file($_FILES["imgUpload"]["tmp_name"], $target_file)) {
				$query = "UPDATE users SET avatar='$target_file' WHERE username='$user';";

			}
		}
		function alert($msg) {
			echo "<script type='text/javascript'>alert('$msg');</script>";
		}
	?>
</html>
