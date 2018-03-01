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
		<?php $conn = pg_connect("host=localhost dbname=a2 user=postgres password=password");
		$val = $_SESSION['username'];
		$result = pg_query($conn, "SELECT * FROM users WHERE username='" . $_GET['username'] ."';");
		$row = pg_fetch_row($result);?>
		<div>
			<form action="userAdmin.php" method="post" enctype="multipart/form-data" >
			<table>
				<tr>
					<td>Avatar: </td>
					<td><img height='30px' width='30px' src='<?php if (isset($_POST["submit"])){ echo basename($_FILES['imgUpload']['name']); } else { echo $row[3]; } ?>'/></td>
				</tr>
				<tr>
					<td>Upload file:</td>
					<td><input type="file" name="imgUpload" id="imgUpload" ></td>
				</tr>
				<tr>
					<td>Email: </td>
					<td><input type='text' value='<?php if (isset($_POST["submit"])){ echo $_POST['newEmail']; } else { echo $row[2]; } ?>' name='newEmail'></td>
				</tr>
				<tr>
					<td>Bio: </td>
					<td><textarea id='newBio' name="newBio"><?php if (isset($_POST["submit"])){ echo $_POST['newBio']; } else { echo $row[4]; } ?></textarea></td>
				</tr>
				<tr>
					<td><input type="submit" name="submit" /></td>
					<td></td>
				</tr>			
			</table>
		</form>
		</div>
		
	</body>
</html>
