<?php
	session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Profile</title>
	<style>
		#welcome, #user {
			display: inline;
		}

		.pdsubmit {
			background-color: darkgray;
		    color: black;
		    padding: 5px 10px;
	    	text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
			margin: 4px 2px;
			cursor: pointer;
			border: none;
		}

		.lgnd_style {
			font-size: 20px;
			color: blue;
		}
	</style>
</head>
<body>
	<?php
		if(!isset($_COOKIE['username'])) {
			session_unset();
			session_destroy();
			header("Location: login.php");
		}
		if(!isset($_SESSION['svalue'])) {
				header("Location: logout.php");
		}
		if(isset($_POST['pdedit'])) {
			if(isset($_SESSION['svalue'])) {
				header("Location: profile_edit.php");
			}
		}

		include '../head.php';
	?><br><br>
	<div>
		<h3 id="welcome">Welcome</h1>
		<h3 id="user" style="color: limegreen;"> <?php echo $_SESSION['svalue'] ?> </h3>
	</div><br>

	<?php 
		$fname = "";
		$uname = "";
		$gender = "";
		$email = "";
		$mobileno = "";
		$country = "";
		$password = "";

		
		/*
		$my_details = array("fname" => "", "uname" => "", "gender" => "", "email" => "", "mobileno" => "", "password" => "",);
		*/

		if ($_SERVER['REQUEST_METHOD'] === "GET") {
			$jsonfile = 'my_data.json';
					       
			$readjsonfile = file_get_contents($jsonfile);
			$datadriven = json_decode($readjsonfile, TRUE);
			$arr_len = count($datadriven);
			for($i = 0; $i < $arr_len; $i++) {
				if($datadriven[$i]['UserName'] === $_SESSION['svalue']) {
					$fname = $datadriven[$i]['FullName'];
					$uname = $datadriven[$i]['UserName'];
					$gender = $datadriven[$i]['Gender'];
					$email = $datadriven[$i]['Email'];
					$mobileno = $datadriven[$i]['MobileNo'];
					$country = $datadriven[$i]['Country'];
					$password = $datadriven[$i]['Password'];

					break;					
				}
		    }
		}
	?>
	<br>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" novalidate>
		<fieldset>
			<legend class="lgnd_style">Profile Details</legend><br>
			<label for="fname">Full Name</label><br>
			<input type="text" id="fname" name="fname" value="<?php echo $fname ?>" readonly><br><br>
			<label for="name">User Name</label><br>
			<input type="text" name="uname" id="uname" value="<?php echo $uname ?>" readonly><br><br>
			<label for="gender">Gender</label><br>
			<input type="text" name="gender" id="gender" value="<?php echo $gender ?>" readonly><br><br>
			<label for="email">Email</label><br>
			<input type="email" name="email" id="email" value="<?php echo $email ?>" readonly><br><br>
			<label for="mobileno">Mobile No</label><br>
			<input type="text" name="mobileno" id="mobileno" value="<?php echo $mobileno ?>" readonly><br><br>
			<label for="country">Country</label><br>
			<input type="text" name="country" id="country" value="<?php echo $country ?>" readonly><br><br>
			<input type="submit" name="pdedit" class="pdsubmit" value="Edit Details">
		</fieldset><br><br>
	</form>
	<div><?php include '../footer.php' ?></div><br><br>
</body>
</html>