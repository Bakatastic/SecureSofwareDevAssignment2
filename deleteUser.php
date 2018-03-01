<!--
6.	A user administration page. An administrative user should be able to create, edit, approve and delete users.
-->
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
						echo "<tr><td>$row[0]</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td><td><a href='editUser.php?username='" . $row[0] . ">edit</a></td><td><a href='approveUser.php?username='" . $row[0] . ">approve</a></td><td><a href='deleteUser.php?username='" . $row[0] . ">delete</a></td></tr>";
					}
				?>
			</table>
		</div>
		
	</body>
</html>
