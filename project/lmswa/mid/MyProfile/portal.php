<?php
	session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="refresh" content="7">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>My Profile</title>
	<style>
		.homemsg {
			text-align: center;
			font-size: 200%;
		}
	</style>
</head>
<body>
	<?php
		if(isset($_SESSION["svalue"])) {
			include '../head.php'; 
		}
		else {
			header("Location: login.php");
		}
		
		if(!isset($_COOKIE['username'])) {
			session_unset();
			session_destroy();
			header("refresh:0; url=http://localhost/project/lmswa/mid/MyProfile/login.php");
		}
		if(!isset($_SESSION['svalue'])) {
				header("Location: logout.php");
		}
	?>

	<div class="homemsg">
		<h1>Welcome</h1>
	</div>
	<br>
	<?php
		include '../footer.php'
	?>
	<br><br>
</body>
</html>