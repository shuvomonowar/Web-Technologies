<?php
	session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<style>
		#acstyle {
			font-size: 20px;
			color: blue;
		}

		.acesubmit {
			background-color: darkgray;
		    color: black;
		    padding: 5px 10px;
	    	text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
			margin: 4px 2px;
			cursor: pointer;
		}

		.errmsg {
			font-size: 15px;
			color: red;
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
		$nemail = "";
		$npassword = "";
		$cpassword = "";

		$err_message = "";
		$dcsn = TRUE;
		
		if(!isset($_COOKIE['username'])) {
			session_unset();
			session_destroy();
			header("Location: login.php");
		}
		if(!isset($_SESSION['svalue'])) {
				header("Location: logout.php");
		}
		if(isset($_POST['adsave'])) {
			if(isset($_SESSION['svalue'])) {
				if ($_SERVER['REQUEST_METHOD'] === "POST") {
					function test_input($data) {
						$data = htmlspecialchars($data);
						return $data;
					}

					$nemail = test_input($_POST['nemail']);
					$npassword = test_input($_POST['npassword']);
					$cpassword = test_input($_POST['cpassword']);

					$jsonfile = 'my_data.json';
							       
					$readjsonfile = file_get_contents($jsonfile);
					$datadriven = json_decode($readjsonfile, TRUE);
					$arr_len = count($datadriven);
					for($i = 0; $i < $arr_len; $i++) {
						if($datadriven[$i]['UserName'] === $_SESSION['svalue']) {
							$fname = $datadriven[$i]['FullName'];
							$uname = $datadriven[$i]['UserName'];
							$gender = $datadriven[$i]['Gender'];
							$mobileno = $datadriven[$i]['MobileNo'];
							//$email = $datadriven[$i]['Email'];
							//$password = $datadriven[$i]['Password'];
							$country = $datadriven[$i]['Country'];

							if(empty($nemail)) {
								$email = $datadriven[$i]['Email'];
								//$dcsn = TRUE;
							}
							else {
								$email = $nemail;
								//$dcsn = TRUE;
							}

							if(empty($npassword) && empty($cpassword)) {
								$password = $datadriven[$i]['Password'];
								//$dcsn = TRUE;
							}
							else if((empty($npassword) && !empty($cpassword)) || (!empty($npassword) && empty($cpassword))) {
								$dcsn = FALSE;
								$err_message = " *New password and confirm password should be same.";
							}
							else {
								if($npassword == $cpassword) {
									$password = $npassword;
									//$dcsn = TRUE;
								}
								else {
									$dcsn = FALSE;
									$err_message = " *New password and confirm password should be same.";
								}
							}

							if(empty($nemail) && empty($npassword) && empty($cpassword)) {
								$dcsn = FALSE;
								$err_message = " *Email, password and new password all this three terms could not be empty at the same time.";
							}

							if($dcsn) {
								$datadriven[$i]["Email"] = $email;
								$datadriven[$i]["Password"] = $password;
								$data_input = json_encode($datadriven, JSON_PRETTY_PRINT);
								if(file_put_contents($jsonfile, $data_input)) {
									//$smessage = " *Profile information updated successfully.";
									header("Location: logout.php");
							    }

							    break;
							}
							else {
								header("Location: account_edit.php");
							}						
						}
				    }
				}
			}
		}

		/*
		if($dcsn == FALSE) {
			$err_message = " *New password and confirm password should be same.";
			header("Location: account_edit.php");
		}
		else {
			$err_message = "";
		}
		*/

		include '../head.php';
	?>
	<br><br>

	<?php
		$email = "";
		//$nemail = "";
		$password = "";
		//$npassword = "";
		//$cpassword = "";

		if ($_SERVER['REQUEST_METHOD'] === "GET") {
			$jsonfile = 'my_data.json';
					       
			$readjsonfile = file_get_contents($jsonfile);
			$datadriven = json_decode($readjsonfile, TRUE);
			$arr_len = count($datadriven);
			for($i = 0; $i < $arr_len; $i++) {
				if($datadriven[$i]['UserName'] === $_SESSION['svalue']) {
					$email = $datadriven[$i]['Email'];
					$password = $datadriven[$i]['Password'];

					break;					
				}
		    }
		}
	?>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" novalidate>
		<fieldset>
			<legend id="acstyle">Update Account Details</legend><br>
			<label for="email">Current Email</label><br>
			<input type="email" id="email" name="email" value="<?php echo $email ?>" readonly><br><br>
			<label for="nemail">New Email</label><br>
			<input type="email" id="nemail" name="nemail" value="<?php echo $nemail ?>"><br><br>
			<label for="pword">Current Password</label><br>
			<input type="text" name="password" id="pword" value="<?php echo $password ?>" readonly><br><br>
			<label for="npword">New Password</label><br>
			<input type="text" name="npassword" id="npword" value="<?php echo $npassword ?>"><br><br>
			<label for="cpword">Confirm Password</label><br>
			<input type="text" name="cpassword" id="cpword" value="<?php echo $cpassword ?>"><br><br>
			<input type="submit" name="adsave" class="acesubmit" value="Update">
		</fieldset><br>
		<div class="errmsg">
			<?php echo $err_message; ?>
		</div>
	</form>
	<div><?php include '../footer.php'; ?></div><br><br><br>
</body>
</html>