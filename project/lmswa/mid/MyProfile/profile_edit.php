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
		$fname = "";
		$uname = "";
		$gender = "";
		$email = "";
		$mobileno = "";
		$country = "";
		$password = "";

		//$smessage = "";
		//$emessage = "";

		if(!isset($_COOKIE['username'])) {
			session_unset();
			session_destroy();
			header("Location: login.php");
		}
		if(!isset($_SESSION['svalue'])) {
				header("Location: logout.php");
		}
		if(isset($_POST['pdsave'])) {
			if(isset($_SESSION['svalue'])) {
				if ($_SERVER['REQUEST_METHOD'] === "POST") {
					function test_input($data) {
						$data = htmlspecialchars($data);
						return $data;
					}

					$fname = test_input($_POST['fname']);
					$gender = test_input($_POST['gender']);
					$mobileno = test_input($_POST['mobileno']);
					$country = test_input($_POST['country']);

					$jsonfile = 'my_data.json';
							       
					$readjsonfile = file_get_contents($jsonfile);
					$datadriven = json_decode($readjsonfile, TRUE);
					$arr_len = count($datadriven);
					for($i = 0; $i < $arr_len; $i++) {
						if($datadriven[$i]['UserName'] === $_SESSION['svalue']) {
							$datadriven[$i]["FullName"] = $fname;
							$datadriven[$i]["Gender"] = $gender;
							$datadriven[$i]["MobileNo"] = $mobileno;
							$datadriven[$i]["Country"] = $country;

							$data_input = json_encode($datadriven, JSON_PRETTY_PRINT);
							if(file_put_contents($jsonfile, $data_input)) {
								//$smessage = " *Profile information updated successfully.";
								header("Location: profile.php");
						    }		
							
							break;					
						}
				    }
				}
			}
		}

		include '../head.php';
	?>
	<br><br>

	<?php 
		$fname = "";
		$gender = "";
		$mobileno = "";
		$country = "";

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
					$gender = $datadriven[$i]['Gender'];
					$mobileno = $datadriven[$i]['MobileNo'];
					$country = $datadriven[$i]['Country'];

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
			<input type="text" id="fname" name="fname" value="<?php echo $fname ?>" required><br><br>
			<label for="gender">Gender</label><br>
			<input type="text" name="gender" id="gender" value="<?php echo $gender ?>" required><br><br>
			<label for="mobileno">Mobile No</label><br>
			<input type="text" name="mobileno" id="mobileno" value="<?php echo $mobileno ?>" required><br><br>
			<label for="country">Country</label><br>
			<input type="text" name="country" id="country" value="<?php echo $country ?>" required><br><br>
			<input type="submit" name="pdsave" class="pdsubmit" value="Save">
		</fieldset><br><br>
	</form>
	<div><?php include '../footer.php' ?></div><br><br>
</body>
</html>