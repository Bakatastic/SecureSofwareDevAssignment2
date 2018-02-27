<!--
The main blog page. Visitors to the blog should be able to view a summary of recent blog entries and click on a blog post for an expanded/detailed view of that specific post. Blog posts should indicate the author and show their avatar.
-->
<!-- 
Reference on expanding/closing blog post using jquery
http://jsfiddle.net/eK8X5/13261/
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
		$result = pg_query($conn, "SELECT * FROM posts");
		while($row = pg_fetch_row($result)){
			//MISSING AVATAR PLEASE ADD
			echo "<div style='border-style:solid; border-width:1px;'> INSERT AVATAR HERE " . $row[2] . "<br>" . $row[1] . "</div><br>";
			//echo "<tr><td>" . $row[2] . "</td><td>" . $row[1] . "</td></tr>";
		}
		/*
		<?php 
						$conn = pg_connect("host=localhost dbname=a1_users user=postgres password=password");
						
						$result = pg_query($conn, "SELECT * FROM users");
						
						while ($row = pg_fetch_row($result))
						{
							echo "<tr><td><a href='userDetails.php?username=" . $row[0]. "'>" . $row[0] . "</a></td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td></tr>";
						}
					?>	
		*/
		?>
	</body>
</html>
