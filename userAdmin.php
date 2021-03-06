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
	<title>User Administrator</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<style>
		table {
			display: block;
			overflow-x: auto;
		}
	</style>
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
			<table class='table'>
				<tr>
					<th>Username</th>
					<th>Email</th>
					<th>AvatarFilename</th>
					<th>Admin</th>
					<th>Approved</th>
					<th>Locked</th>
					<th>Attempts</th>
					<th>Activated</th>
					<th></th>
					<th></th>
				</tr>
				<?php $conn = pg_connect("host=localhost dbname=a2 user=postgres password=password");
					$result = pg_query($conn, "SELECT * FROM users;");
					while ($row = pg_fetch_row($result))
					{
						if ($row[6] == 't') {
							$approveStatus = 'approved';
						} else  {
							$approveStatus = 'unapproved';
						}
						
						if ($row[5] == 't') {
							$role = 'admin';
						} else  {
							$role = 'user';
						}
						
						if ($row[7] == 't') {
							$lockStatus = 'Locked';
						} else  {
							$lockStatus = 'Unlocked';
						}
						
						if ($row[9] == 't'){
							$activationStatus = 'activated';
						} else {
							$activationStatus = 'unactivated';
						}
						
						echo "<tr><td>$row[0]</td><td>$row[2]</td><td>$row[3]</td><td>$role</td><td><a href='approveUser.php?username=" . $row[0] . "'>$approveStatus</a></td><td>$lockStatus</td><td>$row[8]</td><td><a href='activateUser.php?username=$row[0]'>$activationStatus</a></td><td><a href='editUser.php?username=" . $row[0] . "'>edit</a></td><td><a href='deleteUser.php?username=" . $row[0] . "'>delete</a></td></tr>";
					}
					
					function alert($msg) {
						echo "<script type='text/javascript'>alert('$msg');</script>";
					}
					
				?>
			</table>
		</div>
		
	</body>
</html>
