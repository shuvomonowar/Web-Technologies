<?php
	session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Forgotten Password</title>
	<style>
		#acstyle {
			font-size: 20px;
			color: blue;
		}

		#h4lbrk {
			display: inline;
		}

		.acesubmit {
			background-color: darkgray;
		    color: blace;
		    padding: 5px 10px;
	    	text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
			margin: 4px 2px;
			cursor: pointer;
			border: none;
		}

		.emstyle {
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
		$npassword = "";
		$cpassword = "";

		$uname_mail = "";
		$acerr_message = "";
		$dcsn = TRUE;
		
		if(isset($_POST['adsave'])) {
			if ($_SERVER['REQUEST_METHOD'] === "POST") {
				function test_input($data) {
					$data = htmlspecialchars($data);
					return $data;
				}

				$uname_mail = test_input($_POST['uname_mail']);
				$npassword = test_input($_POST['npassword']);
				$cpassword = test_input($_POST['cpassword']);

				$jsonfile = 'my_data.json';
							       
				$readjsonfile = file_get_contents($jsonfile);
				$datadriven = json_decode($readjsonfile, TRUE);
				$arr_len = count($datadriven);
				for($i = 0; $i < $arr_len; $i++) {
					if($datadriven[$i]['UserName'] === $uname_mail || $datadriven[$i]['Email'] === $uname_mail) {
						$fname = $datadriven[$i]['FullName'];
						$uname = $datadriven[$i]['UserName'];
						$gender = $datadriven[$i]['Gender'];
						$mobileno = $datadriven[$i]['MobileNo'];
						$email = $datadriven[$i]['Email'];
						$country = $datadriven[$i]['Country'];
	
						if($npassword == $cpassword) {
							$password = $npassword;
						}
						else {
							$dcsn = FALSE;
							$acerr_message = " *New password and confirm password should be same.";
						}

						if($dcsn) {
							$data_store = array(
							'FullName' => $fname,
							'UserName' => $uname,
							'Gender' => $gender,
							'Email' => $email,
							'MobileNo' => $mobileno,
							'Country' => $country,
							'Password' => $password
							);

							$fdata_store[] = $data_store;
							$data_input = json_encode($fdata_store);
							if(file_put_contents($jsonfile, $data_input)) {
								header("Location: login.php");
							}						
						}
						break;
				    }
				    else {
				    	$acerr_message = " *Account not found.";
				    }
				}
			}
		}

		if(isset($_POST['signin'])) {
			header("Location: login.php");
		}
	?>


	<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
		<br><br>
		<fieldset>
			<legend id="acstyle">Reset Password</legend><br>
			<label for="uname_mail">Username or Email</label>
			<input type="text" name="uname_mail" id="uname_mail" value="<?php echo $uname_mail; ?>" required><br><br>
			<label for="npword">New Password</label><br>
			<input type="text" name="npassword" id="npword" value="<?php echo $npassword; ?>" required><br><br>
			<label for="cpword">Confirm Password</label><br>
			<input type="text" name="cpassword" id="cpword" value="<?php echo $cpassword; ?>" required><br><br>
			<input type="submit" name="adsave" class="acesubmit" value="Update Details"><br><br>
			<div>
				<h4 id="h4lbrk">Don't need to update?</h4>
				<a href="login.php">Sign In</a>
			</div>
		</fieldset><br>
		<div class="emstyle">
			<?php echo $acerr_message; ?>
		</div>
	</form>
	<div>
		<?php include '../footer.php'; ?>
	</div>
</body>
</html>