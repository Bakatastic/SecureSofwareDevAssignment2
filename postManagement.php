<?php
	session_start();
	if (($_SESSION["username"]) == null) {
		header("Location: login.php");
		exit();
	}
?>
<html>
	<head>
	<title>Your Posts</title>
	<style type="text/css">
		ul {
			list-style-type: none;
			margin: 0;
			padding: 0;
		}

		li {
			display: inline;
		}
		
		img {
			max-width: 100%;
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
		
		//Precaution to disallow the deletion of other user's posts
		if($_GET["id"]){
			$result = pg_query($conn, "SELECT * FROM posts WHERE postid = '$_GET[id]' AND username = '$_SESSION[username]'");
			if($result){
				$query = "DELETE FROM posts WHERE postid='$_GET[id]';";
				$result = pg_query($query);
			}
		}
		
		$result = pg_query($conn, "SELECT posts.*, users.avatar FROM posts INNER JOIN users ON posts.username = users.username WHERE posts.username = '$_SESSION[username]' ORDER BY postid DESC;");
		while($row = pg_fetch_row($result)){
			$post = htmlspecialchars_decode($row[1]);
			//God bless this one line.
			echo "<div style='border-style:solid; border-width:1px; padding:5px;'> <img src='" . $row[3] . "' width='50px' height='50px' > " . $row[2] . "<br>" . $post . "<br><a href='newPost.php?id=" . $row[0] . "'>Edit</a>&nbsp<a href='postManagement.php?id=" . $row[0] . "'>Delete</a></div><br>";
		}
		?>
	</body>
</html>