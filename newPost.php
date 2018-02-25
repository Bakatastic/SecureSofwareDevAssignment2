<!--
Create a new blog post (or edit an existing post). The user should be able to create a blog post that will be published to the main blog page. Blog posts should be capable of containing images, hyperlinks and videos as well as an array of formatting options for headings, lists, etc. Ideally, a blog author should be able to write HTML or Markup to create a post.
-->
<html>
	<head>
	<title>New Post</title>
	<style type="text/css">
	</style>
	</head>
	<body>
		<h3>Create a Post</h3>
		<form action="login.php" method="POST" >
			<table>
				<tr>
					<td>Subject: </td>
					<td><input type="text" name="userInput" required /></td>
				</tr>
				<tr>
					<td>Content: </td>
					<td><textarea name="content" cols="40" rows="5"></textarea></td>
				</tr>
				<tr>
					<td><input type="submit" name="submit" /></td>
					<td></td>
				</tr>			
			</table>
			<?php
				//if this page loads up as a POST (after somebody clicks submit
				if (isset($_POST['submit'])) {  
					//add post to db here
					$conn = pg_connect("host=localhost dbname=tempDB user=tempUser password=tempPsw");
					$query = "INSERT INTO table VALUES ();";
					$result = pg_query($query); 
				
					if (/*validated*/) {
						//I think this can be used to forward the page to the blog page
						header('Location: target-page.php');
						exit();
					}
				}
			?>
		</form>
	</body>
</html>
