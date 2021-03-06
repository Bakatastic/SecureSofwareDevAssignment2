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
	<title>Approve</title>
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
		<?php 
			$conn = pg_connect("host=localhost dbname=a2 user=postgres password=password");
			$result = pg_query($conn, "SELECT * FROM users WHERE username='$_GET[username]';");
			$row = pg_fetch_row($result);	
			$user = $row[0];
		?>
		<h3>User: <?php echo $row[0] ?></h3>
		<div>
				<?php 
					if ($row[6] == 't'){
						echo "<p>Unapprove $user?</p>";
					} else {
						echo "<p>Approve $user?</p>";
					}
				?>
			<form action='approveUser.php' method="post">
				<input type="hidden" name="approveUser" value="<?php echo $_GET['username']?>">
				<input type='submit' value='Approve' class='btn' width='20px' name='approve'>
			</form>
			<form action='approveUser.php' method="post">
				<input type="hidden" name="unapproveUser" value="<?php echo $_GET['username']?>">
				<input type='submit' value='Revoke Approval' class='btn' width='20px' name='unapprove'>
			</form>			
		</div>
		<?php	
			if(isset($_POST['approve'])) {
				$query = "UPDATE users SET approved='true' Where username='$_POST[approveUser]'";
				$result=pg_query($conn,$query);
				activation($_POST['approveUser']);
				header("Location: userAdmin.php");
				exit();		
			} else if(isset($_POST['unapprove'])) {				
				$query = "UPDATE users SET approved='false' Where username='$_POST[unapproveUser]'";
				$result=pg_query($conn,$query);
				header("Location: userAdmin.php");
				exit();		
			}
			
			function activation($activateUser) {
				$conn = pg_connect("host=localhost dbname=a2 user=postgres password=password");
				$activationLink = "/activateUser.php?username=$activateUser";
				$query = "INSERT INTO logs (logtext, username) VALUES ('$activationLink', '$activateUser');";
				$result=pg_query($conn,$query);
			}
			
			function alert($msg) {
				echo "<script type='text/javascript'>alert('$msg');</script>";
			}
		?>
	</body>
</html>
