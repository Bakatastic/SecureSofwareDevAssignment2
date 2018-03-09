<!--
The main blog page. Visitors to the blog should be able to view a summary of recent blog entries and click on a blog post for an expanded/detailed view of that specific post. Blog posts should indicate the author and show their avatar.
-->
<?php
	session_start();
?>
<html>
	<head>
	<title>View Blogs</title>
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
		$result = pg_query($conn, "SELECT posts.*, users.avatar FROM posts INNER JOIN users ON posts.username = users.username ORDER BY postid DESC;");
		while($row = pg_fetch_row($result)){
			$post = htmlspecialchars_decode($row[1]);
			echo "<a href='blogDetails.php?id=" . $row[0] . "' style='text-decoration:none;color:black'><div style='border-style:solid; border-width:1px; padding:5px;'> <img src='" . $row[3] . "' width='50px' height='50px' >" . $row[2] . "<br>" . $post . "</div></a><br>";
		}
		?>
	</body>
</html>
