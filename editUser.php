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
	<title>Edit User</title>
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
		<?php $conn = pg_connect("host=localhost dbname=a2 user=postgres password=password");
		$val = $_SESSION['username'];
		$result = pg_query($conn, "SELECT * FROM users WHERE username='" . $_GET['username'] ."';");
		$row = pg_fetch_row($result);?>
		<div>
			<form action="editUser.php" method="post" enctype="multipart/form-data" >
			<h3><?php echo $_GET['username']?></h3>
			<input type="hidden" name="hiddenUser" value="<?php echo $_GET['username']?>">
			<input type="hidden" name="imgSrc" value="<?php echo $_GET['avatar']?>">
			<div class="form-group">
				<label>Avatar: </label>
				<br>
				<img height='50px' width='50px' src='<?php if (isset($_POST["submit"])){ echo "images/" . basename($_FILES['imgUpload']['name']); } else { echo $row[3]; } ?>'/>
				<input type="file" name="imgUpload" id="imgUpload" accept="image/*" >
			</div>
			<div class="form-group">
				<label for='emailInput'>Email:</label>
				<input id='emailInput' type='text' class="form-control" value='<?php if (isset($_POST["submit"])){ echo $_POST['newEmail']; } else { echo $row[2]; } ?>' name='newEmail'>
				<br>
				<label for='newBio'>Bio:</label> 
				<textarea id='newBio' name="newBio" class="form-control"><?php if (isset($_POST["submit"])){ echo $_POST['newBio']; } else { echo $row[4]; } ?></textarea>
				<br>
				<input type="submit" name="submit" value='Update' class="btn"/>
			</div>
		</form>
		</div>
		<?php 
			$directory = "images/";
			$user = $_POST['hiddenUser'];
			$email = $_POST["newEmail"];
			$bio = sanitize($_POST["newBio"]);
			$target_file = $directory . basename($_FILES['imgUpload']['name']);
			$checkFile = basename($_FILES['imgUpload']['name']);
			
			if (isset($_POST["submit"])) {
				//checks the file if empty or not. if empty don't insert new file
				if($email != "") { 
					$email = sanitize($email);
					//Check input
					if(preg_match("/^[a-zA-Z0-9.!#$%&'*+=?^_`{|}~-]{1,}@[a-zA-Z0-9]{1,}\.[a-zA-Z0-9]{1,}$/", $email)){
									
						if ($checkFile == "") {
							$bio = sanitize($bio);
							$email = sanitize($email);
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
					} else {
						echo "<p>Email regex not good</p><br>";
					}
				} else {
					echo "<p>Email is Required</p><br>";
				}
			}
			function sanitize($input){
				$input = trim($input);
				$input = stripslashes($input);
				$input = str_replace("'",'"', $input);
				$input = htmlspecialchars($input);
				return $input;
			}
			
			function alert($msg) {
				echo "<script type='text/javascript'>alert('$msg');</script>";
			}
		?>
	</body>
</html>
