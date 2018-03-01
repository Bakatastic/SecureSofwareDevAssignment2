<?php
	session_start();
?>
<html>
	<head>
	<title></title>
	<style type="text/css">
		ul {
			list-style-type: none;
			margin: 0;
			padding: 0;
		}

		li {
			display: inline;
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
			<table>
				<?php $conn = pg_connect("host=localhost dbname=a2 user=postgres password=password");
					$result = pg_query($conn, "SELECT * FROM users;");
					$row = pg_fetch_row($result);
					
					while ($row = pg_fetch_row($result))
					{
						echo "<tr><td><a href='userDetails.php?username=" . $row[0]. "'>" . $row[0] . "</a></td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td></tr>";
					}
				?>
			</table>
		</div>
		
	</body>
</html>
