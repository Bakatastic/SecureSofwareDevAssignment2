<!--
6.	A user administration page. An administrative user should be able to create, edit, approve and delete users.
-->
<?php
	session_start();
	if (!isset($_SESSION['admin'])){
		header("Location: login.php");
		exit();
	}
?>
<html>
	<head>
	<title>Delete User</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	</head>
	<body>
		<nav class="navbar navbar-default">
			<ul class="nav navbar-nav">
				<li><a href="postManagement.php">Post Management</a></li>
				<li><a href="profile.php">Profile</a></li>
				<li><a href="newPost.php">New Post</a></li>
				<li><a href="userAdmin.php">User Admin</a></li>
				<li><a href="visitorBlog.php">Visitor Blog</a></li>
				<li><a href="login.php">Logout</a></li>
			</ul>
		</nav>	
		
		<div>
			<h3>Delete <?php echo $_GET['username'] ?></h3>
			<table>
				<tr>
				
					<td>
						<form action="deleteUser.php" method="post" >
							<div class="form-group">
								<input type="submit" width='20px' class="btn" value="Yes" name='submit' />
								<input type="hidden" name="hiddenUser" value="<?php echo $_GET['username'] ?>" />
							</div>
						</form>
						<form action="userAdmin.php" method="post" >
							<div class="form-group">
								<input type="submit" value="No" width='20px' class="btn" name='submit' />
							</div>
						</form>
						
					</td>
				</tr>
			</table>
		</div>
	</body>
	<?php 
		$conn = pg_connect("host=localhost dbname=a2 user=postgres password=password");
		$user = $_POST['hiddenUser'];
		if (isset($_POST["submit"])) {
			//delete from logs
			$query = "DELETE FROM logs WHERE username='$user';";
			$result = pg_query($query);
			//delete from users
			$query = "DELETE FROM users WHERE username='$user';";
			$result = pg_query($query);
			header("Location: userAdmin.php");
			exit();	
		}
	?>
</html>
