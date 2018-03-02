<?php
	session_start();
	if (($_SESSION["username"]) == null) {
			header("Location: login.php");
			exit();
		}
?>
<html>
	<head>
	<title>New Post</title>
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
		<h1>New Post</h1>
		<?php
			//Set variables to empty values
			$postErr = "";
			$posttext = "";
			$fail = 0;
			$conn = pg_connect("host=localhost dbname=a2 user=postgres password=password");
			if($_SERVER["REQUEST_METHOD"] == "POST"){
				if(!$_GET["id"]){
					if(empty($_POST["posttext"])){
						$postErr = "Enter a post<br>";
						$fail = 1;
					}
					else{
						$posttext = sanitize($_POST["posttext"]);
					}
					//Add to database if regex check passes
					if($fail == 0){
						if($conn){
							$query = "INSERT INTO posts (posttext, username) VALUES ('$posttext','$_SESSION[username]');";
							$result = pg_query($query);
							header("Location: visitorBlog.php");
							exit();
						}
						else {
							alert("conn failed");
						}
					}
				}
				else{
					if(empty($_POST["posttext"])){
						$postErr = "Enter a post<br>";
						$fail = 1;
					}
					else{
						$posttext = sanitize($_POST["posttext"]);
					}
					//Add to database if regex check passes
					if($fail == 0){
						if($conn){
							$result = pg_query($conn, "UPDATE posts SET posttext = '$posttext' WHERE postid = '$_GET[id]' AND username = '$_SESSION[username]'");
							header("Location: visitorBlog.php");
							exit();
						}
						else {
							alert("conn failed");
						}
					}
				}

			}
			
			function sanitize($input){
				$input = trim($input);
				$input = stripslashes($input);
				$input = str_replace("'",'"', $input);
				$input = htmlspecialchars($input);
				return $input;
			}
		?>
		<form action = "
		<?php
			//For new posts
			if(!$_GET["id"]){
				echo htmlspecialchars($_SERVER["PHP_SELF"]);
			}
			//For edits
			else{
				
				echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $_GET["id"] . "&edit=true";
			}
		?>
		" method="POST" id="newpost">
				<table>
					<tr>
						<td align=right>
							Post:
						</td>
						<td>
							<textarea name="posttext" form="newpost" rows="5" cols="50"><?php
								//If editing, grab all text from db
								if($_GET["id"]){
									$result = pg_query($conn, "SELECT * FROM posts WHERE postid = '$_GET[id]' AND username = '$_SESSION[username]'");
									while($row = pg_fetch_row($result)){
										
										echo $row[1];
									}
								}
							?>
							</textarea>
						</td>
					</tr>
					<tr>
						<td>
						</td>
						<td align=center>
							<input type="submit"/>
						</td>
					</tr>
				</table>
			</form>
			<br>
			<?php
				echo $postErr;
			?>
	</body>
</html>
