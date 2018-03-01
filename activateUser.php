<!--
6.	A user administration page. An administrative user should be able to create, edit, approve and delete users.
-->
<?php
	session_start();
?>
<html>
	<head>
	<title>Activate User</title>
	<style type="text/css">
		ul {
			list-style-type: none;
			margin: 0;
			padding: 0;
		}

		li {
			display: inline;
		}
		
		input[type=submit] {
			width: 20em;
		}
	</style>
	</head>
	<body>
		<ul>
			<li><a href="postManagement.php">Post Management</a></li>
			<li><a href="profile.php">Profile</a></li>
			<li><a href="newPost.php">New Post</a></li>
			<li><a href="userAdmin.php">User Admin</a></li>
			<li><a href="visitorBlog.php">Visitor Blog</a></li>
			<li><a href="login.php">Logout</a></li>
		</ul>
		
		<div>
			<h3>Activate <?php echo $_GET['username'] ?></h3>
			<form action="activateUser.php" method="post" >
				<input type="submit" width='20px'  value="Yes" name='submit' />
				<input type="hidden" name="hiddenUser" value="<?php echo $_GET['username'] ?>" />
			</form>
		</div>
		<?php 
			if (isset($_POST["submit"])){
				$user = $_POST['hiddenUser'];
				$conn = pg_connect("host=localhost dbname=a2 user=postgres password=password");
				$query = "UPDATE users SET activated='true' WHERE username='$user';";
				$result = pg_query($conn,$query);
				echo $query;
				header("Location: login.php");
				exit();				
			}
		?>
	</body>
</html>
