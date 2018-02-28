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
		.container {
			width: 75%;
			height-min: 50px;
			background: black;
			margin: auto;
			padding:10px;
		}
		.avatar {
			width: 15%;
			background: red;
			float: left;
		}
		.HeaderText {
			margin-left: 15%;
			background: white;
		}
	</style>
	</head>
	<body>

		<?php
		$conn = pg_connect("host=localhost dbname=a2 user=postgres password=password");
		$result = pg_query($conn, "SELECT * FROM posts ORDER BY postid DESC");
		while($row = pg_fetch_row($result)){
			//MISSING AVATAR PLEASE ADD
			echo "<div style='border-style:solid; border-width:1px; padding:5px;'> INSERT AVATAR HERE " . $row[2] . "<br>" . $row[1] . "</div><br>";
			//echo "<tr><td>" . $row[2] . "</td><td>" . $row[1] . "</td></tr>";
		}
		?>
	</body>
</html>
