<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Registration</title>
	<style>
		fieldset {
			margin-left: 0px;
			margin-right: 0px;
		}

		#lgstyle {
			font-size: 20px;
			color: blue;
		}

		#h4lbrk {
			display: inline;
		}

		.sbutton {
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

		.emstyle {
			font-size: 15px;
			color: red;
		}
	</style>
</head>
<body>
	<?php 
		$fname = "";
		//$fnameErrMsg = "";
		$uname = "";
		//$unameErrMsg = "";
		$gender = "";
		//$genderErrMsg = "";
		$email = "";
		//$emailErrMsg = "";
		$mobileno = "";
		//$mobilenoErrMsg = "";
		$country = "";
		//$countryErrMsg = "";
		$password = "";
		//$passwordErrMsg = "";
		$cpassword = "";
		$cpasswordErrMsg = "";

		$sunErrMsg = "";

		$dcsn = FALSE;

		if ($_SERVER['REQUEST_METHOD'] === "POST") {

			function test_input($data) {
				$data = htmlspecialchars($data);
				return $data;
			}

			$fname = test_input($_POST['fname']);
			$uname = test_input($_POST['uname']);
			$gender = isset($_POST['gender']) ? test_input($_POST['gender']) : "";
			$email = test_input($_POST['email']);
			$mobileno = test_input($_POST['mobileno']);
			$country = isset($_POST['country']) ? test_input($_POST['country']) : "";
			$password = test_input($_POST['password']);
			$cpassword = test_input($_POST['cpassword']);

			if (empty($fname)) {
				//$fnameErrMsg = " Full name is not be empty";
				$dcsn = FALSE;
			}
			else if(!empty($fname)) {
				if (!preg_match("/^[a-zA-Z ]*$/",$fname)) {
					//$fnameErrMsg = "  Try using valid character";
					$dcsn = FALSE;
				}
			}

			if (empty($uname)) {
				//$unameErrMsg = " User name is not be empty";
				$dcsn = FALSE;
			}
       		if (empty($gender)) {
				//$genderErrMsg = "  Gender is not be unselected";
				$dcsn = FALSE;
			}
			if (empty($email)) {
				//$emailErrMsg = "  Email is not be empty";
				$dcsn = FALSE;
			}
			if (empty($mobileno)) {
				//$mobilenoErrMsg =  "  Mobile no is not be empty";
				$dcsn = FALSE;
			}
			if ($country == "Not Selected") {
				//$cpasswordErrMsg = "  Confirm password is not be empty";
				$sunErrMsg = " *Please select valid country name.";
				$dcsn = FALSE;
			}
			if (empty($password)) {
				//$passwordErrMsg = "  Password is not be empty";
				$dcsn = FALSE;
			}
			if (empty($cpassword)) {
				//$countryErrMsg = " *Please select valid country name.";
				$dcsn = FALSE;
			}
			else if ($password != $cpassword) {
				//$cpasswordErrMsg = " *Confirm password is not match with password.";
				$sunErrMsg = " *Confirm password is not match with password.";
				$dcsn = FALSE;
			}

			if (!empty($fname) && preg_match("/^[a-zA-Z ]*$/",$fname) && !empty($uname) && !empty($gender) && !empty($email) && !empty($mobileno) && !empty($password) && !empty($cpassword) && $password === $cpassword) {
				$dcsn = TRUE;
			}


			if(isset($_POST['submit'])) {
				if($dcsn) {
					if(file_exists('my_data.json')) {
						function get_input_exist_file() {
							$cnt = TRUE;
							$jsonfile = 'my_data.json';
					       
						    $readjsonfile = file_get_contents($jsonfile);
							$datadriven = json_decode($readjsonfile, TRUE);
							$arr_len = count($datadriven);
							for($i = 0; $i < $arr_len; $i++) {
								if($datadriven[$i]['UserName'] === $GLOBALS['uname'] || $datadriven[$i]['Email'] === $GLOBALS['email']) {
									$cnt = FALSE;
									break;							
								}
						    }

						    if($cnt) {
						    	$datastore = array(
							        'FullName' => $_POST['fname'],
							        'UserName' => $_POST['uname'],
							        'Gender' => $_POST['gender'],
									'Email' => $_POST['email'],
									'MobileNo' => $_POST['mobileno'],
									'Country' => $_POST['country'],
									'Password' => $_POST['password']
						        );

						        $datadriven[] = $datastore;
						        $final_data = json_encode($datadriven, JSON_PRETTY_PRINT);
						        if(file_put_contents($jsonfile, $final_data)) {
						        	header("Location: login.php");
						        }
						    }
						    else {
						    	$GLOBALS['sunErrMsg'] = " *Provided username or email is already taken. Please, try using different username.";
						    }
						
			       		}

			       		get_input_exist_file();
					}
					else {
						function assign_input_new_file() {
							$jsonfile = "my_data.json";
							$jsonfileAd = fopen($jsonfile, "w");
							
							$datadriven = array();
					        $datastore = array(
					        'FullName' => $_POST['fname'],
					        'UserName' => $_POST['uname'],
					        'Gender' => $_POST['gender'],
							'Email' => $_POST['email'],
							'MobileNo' => $_POST['mobileno'],
							'Country' => $_POST['country'],
							'Password' => $_POST['password'],
							'CPassword' => $_POST['cpassword']
					        );

					        $datadriven[] = $datastore;
					        $final_data = json_encode($datadriven);
					        fclose($jsonfileAd);

					        if(file_put_contents($jsonfile, $final_data)) {
						        header("Location: login.php");
						    }
			        	}

			        	assign_input_new_file();
			        }
				}
			}
		}
	?>

	<br>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
		<fieldset>
			<legend id="lgstyle">Sign Up Form</legend><br>
			<label for="fname">Full Name</label><br>
			<input type="text" id="fname" name="fname" value="<?php echo $fname ?>" required><br><br>
			<label for="name">User Name</label><br>
			<input type="text" name="uname" id="uname" value="<?php echo $uname ?>" required><br><br>
			<label>Gender</label>
			<input type="radio" name="gender" id="male" value="Male" required>
			<label for="male">Male</label>
			<input type="radio" name="gender" id="female" value="Female">
			<label for="female">Female</label><br><br>
			<label for="email">Email</label><br>
			<input type="email" name="email" id="email" value="<?php echo $email ?>" required><br><br>
			<label for="mobileno">Mobile No</label><br>
			<input type="text" name="mobileno" id="mobileno" value="<?php echo $mobileno ?>" required><br><br>
			<label for="country">Country</label>
			<select name="country" id="country">
				  <option value="Not Selected">--Select Country--</option>
				  <option value="Bangladesh">Bangladesh</option>
				  <option value="India">India</option>
				  <option value="Saudi Arabia">Saudi Arabia</option>
				  <option value="USA">USA</option>
				  <option value="Australia">Australia</option>
			</select><br><br>
			<label for="password">Password</label><br>
			<input type="text" name="password" id="password" value="<?php echo $password ?>" required><br><br>
			<label for="cpassword">Confirm Password</label><br>
			<input type="text" name="cpassword" id="cpassword" value="<?php echo $cpassword ?>" required><br><br>
			<input type="submit" name="submit" class="sbutton" value="Sign Up"><br><br>
			<div>
				<h4 id="h4lbrk">Already have an account?</h4>
				<a href="login.php" target="_self">Sign In</a>
			</div><br>
		</fieldset>
	</form>
	<div class="emstyle">
			<br><?php echo $sunErrMsg; ?>
	</div>
	<?php include '../footer.php'; ?><br>
</body>
</html>