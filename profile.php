<!--
3.	A user profile management experience, which only a valid logged-in user can visit and edit. Visiting this page before authenticating should redirect a user to the login/registration page. On successful authentication, the user must be redirected back to their profile page. The profile page should allow the user to upload a small graphic as their avatar as well as allowing them to change their basic details. Re-authentication is required to change the user�s password.
-->
<?php
	session_start();
?>
<html>
	<head>
	<title>Profile</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<?php 
		$_SESSION['fromProfile'] = 0;
		if (($_SESSION["username"]) == null) {
			$_SESSION["fromProfile"] = 1;
			header("Location: login.php");
			exit();
		}			
		
		if ($_SESSION["Change"] == 1) {
			session_destroy();
		}
	?>
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
		<h3>User: <?php echo $_SESSION["username"] ?></h3>
		<?php $conn = pg_connect("host=localhost dbname=a2 user=postgres password=password");
		$val = $_SESSION['username'];
		$result = pg_query($conn, "SELECT * FROM users WHERE username='" . $val ."';");
		$row = pg_fetch_row($result);?>
		<form action="profile.php" method="post" enctype="multipart/form-data" >
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
		<br><br><br>
		<form action="profile.php" method="post" >
			<div class="form-group">
				<h3>Change Password</h3>
				<label>New Password: </label>
				<input type="password" name="newPassword" id="newPassword" class="form-control">
				<br>
				<label>Confirm Password: </label>
				<input type='password' name='confirmPassword' id='confirmPassword' class="form-control">
				<br>
				<input type="submit" name="changePassword" class="btn"/>
			</div>
		</form>
	</body>
	<?php 
		$directory = "images/";
		$user = $_SESSION['username'];
		$email = $_POST["newEmail"];
		//$bio = htmlentities($_POST["newBio"]);
		$bio = sanitize($_POST["newBio"]);
		$target_file = $directory . basename($_FILES['imgUpload']['name']);
		$checkFile = basename($_FILES['imgUpload']['name']);

		//checks if the third phase in changing password
		if ($_SESSION['Change'] == 2){ 
			$conn = pg_connect("host=localhost dbname=a2 user=postgres password=password");
			if ($conn) {
				//uploads new password
				$newPassword = $_SESSION['newPassword'];
				$result = pg_query($conn, "UPDATE users SET password = '$newPassword' WHERE username = '$user'");
				exit();
				alert("Password Changed");
			} else {
				alert("conn failed");
			}
		}
		
		if (isset($_POST["submit"])) {
			//checks the file if empty or not. if empty don't insert new file
			if($email != "") { 
				$email = sanitize($email);
				//Check input
				if(preg_match("/^[a-zA-Z0-9.!#$%&'*+=?^_`{|}~-]{1,}@[a-zA-Z0-9]{1,}\.[a-zA-Z0-9]{1,}$/", $email)){
					//checks the file if empty or not. if empty don't insert new file
					if ($checkFile == "") {
						$query = "UPDATE users SET email='$email', bio='$bio' WHERE username='$user';";
						$result=pg_query($conn,$query);
					} else {
						$fileInfo = getimagesize($_FILES["imgUpload"]["tmp_name"]);
						$imageType = $fileInfo[2];
						if (in_array($imageType, array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP))) {
							if (move_uploaded_file($_FILES["imgUpload"]["tmp_name"], $target_file)) {
								$query = "UPDATE users SET avatar='$target_file', email='$email', bio='$bio' WHERE username='$user';";
								$result=pg_query($conn,$query);
							}
						} else {
							alert("bad file");
						}
					}
				}	
			} 
		} else if (isset($_POST["changePassword"])) {
			$fail = 0;
			if(empty($_POST["newPassword"])){
				$passwordErr = "Password is required<br>";
				$fail = 1;
			}
			else{
				$password = sanitize($_POST["newPassword"]);
				$confirmPassword = sanitize($_POST["confirmPassword"]);
				//Check input
				if(!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,40}$/", $password)){
					$passwordErr = "Enter a password with at least 8 letters and numbers<br>";
					$fail = 1;
				}
				
				if ($password != $confirmPassword)
				{
					$passwordErr = "Passwords do not match<br>";
					$fail = 1;
				}
				//Encrypt
				$password = hash('sha256', $password . 'AwesomeSalt');
				//$password = md5($password . "AmazingSalt");			
			}
			
			//Add to database if regex check passes
			if($fail == 0){
				alert("password Changed");
				$_SESSION["Change"] = 1;
				$_SESSION["fromProfile"] = 0;
				$_SESSION["newPassword"] = $password;
				header("Location: login.php");
				exit();		
			} else 
			{
				alert($passwordErr);
			}
		}
		
		function sanitize($input){
			$input = trim($input);
			$input = stripslashes($input);
			//$input = str_replace("'",'"', $input);
			$input = htmlspecialchars($input);
			return $input;
		}
	
		function alert($msg) {
			echo "<script type='text/javascript'>alert('$msg');</script>";
		}
	?>
</html>
