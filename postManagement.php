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
	</head>
	<body>
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
		
		
		
		$result = pg_query($conn, "SELECT * FROM posts WHERE username = '$_SESSION[username]' ORDER BY postid DESC");
		while($row = pg_fetch_row($result)){
			//MISSING AVATAR PLEASE ADD
			echo "<div style='border-style:solid; border-width:1px;'> INSERT AVATAR HERE " . $row[2] . "<br>" . $row[1] . "<br><a href='newPost.php?id=" . $row[0] . "'>Edit</a>&nbsp<a href='postManagement.php?id=" . $row[0] . "'>Delete</a></div><br>";
		}
		?>
	</body>
</html>