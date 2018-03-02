<!--
6.	A user administration page. An administrative user should be able to create, edit, approve and delete users.
-->
<?php
	session_start();
		if (!isset($_SESSION['admin'])){
		header("Location: login.php");
		exit();
	}
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
			<form action="editUser.php" method="post" enctype="multipart/form-data" >
			<h3><?php echo $_GET['username']?></h3>
			<input type="hidden" name="hiddenUser" value="<?php echo $_GET['username']?>">
			<table>
				<tr>
					<td>Avatar: </td>
					<td><img height='30px' width='30px' src='<?php if (isset($_POST["submit"])){ echo "images/" . basename($_FILES['imgUpload']['name']); } else { echo $row[3]; } ?>'/></td>
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
		<?php 
			$directory = "images/";
			$user = $_POST['hiddenUser'];
			$email = $_POST["newEmail"];
			$bio = htmlentities($_POST["newBio"]);
			$target_file = $directory . basename($_FILES['imgUpload']['name']);
			$checkFile = basename($_FILES['imgUpload']['name']);
			
			if (isset($_POST["submit"])) {
				//checks the file if empty or not. if empty don't insert new file
				if ($checkFile == "") {
					$query = "UPDATE users SET email='$email', bio='$bio' WHERE username='$user';";
					$result=pg_query($conn,$query);
					header("Location: userAdmin.php");
					exit();		
				} else {
					$fileInfo = getimagesize($_FILES["imgUpload"]["tmp_name"]);
					$imageType = $fileInfo[2];
					if (in_array($imageType, array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP))) {
						if (move_uploaded_file($_FILES["imgUpload"]["tmp_name"], $target_file)) {
							$query = "UPDATE users SET avatar='$target_file', email='$email', bio='$bio' WHERE username='$user';";
							$result=pg_query($conn,$query);
							header("Location: userAdmin.php");
							exit();		
						}
					}
				}
			}
			function alert($msg) {
				echo "<script type='text/javascript'>alert('$msg');</script>";
			}
		?>
	</body>
</html>
