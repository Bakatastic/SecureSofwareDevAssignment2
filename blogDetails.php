<!--
The main blog page. Visitors to the blog should be able to view a summary of recent blog entries and click on a blog post for an expanded/detailed view of that specific post. Blog posts should indicate the author and show their avatar.
-->
<?php
	session_start();
?>
<html>
	<head>
	<title>View Blogs</title>
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
		<?php
		$conn = pg_connect("host=localhost dbname=a2 user=postgres password=password");
		$result = pg_query($conn, "SELECT posts.*, users.avatar FROM posts INNER JOIN users ON posts.username = users.username ORDER BY postid DESC;");
		while($row = pg_fetch_row($result)){
			$post = htmlspecialchars_decode($row[1]);
			echo "<a href='blogDetails.php?id=" . $row[0] . "' style='text-decoration:none;color:black'><div style='border-style:solid; border-width:1px; padding:5px;'> <img src='" . $row[3] . "' width='50px' height='50px' >" . $row[2] . "<br>" . $post . "</div></a><br>";
			//echo "<tr><td>" . $row[2] . "</td><td>" . $row[1] . "</td></tr>";
		}
		?>
		<br>
		<a href="visitorBlog.php">Back</a>
	</body>
</html>
