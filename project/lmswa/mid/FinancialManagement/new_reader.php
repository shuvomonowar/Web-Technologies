<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>New Reader</title>
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
		$uname = "";
		//$unameErrMsg = "";
		$ac_type = "";
		//$acErrmsg = "";
		
		$sunErrMsg = "";
		$dcsn = FALSE;

		if(!isset($_COOKIE['username'])) {
			session_unset();
			session_destroy();
			header("Location: ../MyProfile/login.php");
		}
		if(!isset($_SESSION['svalue'])) {
			include "../MyProfile/logout.php";
		}

		if ($_SERVER['REQUEST_METHOD'] === "POST") {

			function test_input($data) {
				$data = htmlspecialchars($data);
				return $data;
			}

			$uname = test_input($_POST['uname']);
			$ac_type = isset($_POST['actype']) ? test_input($_POST['actype']) : "";
			
			
			if (empty($uname)) {
				//$unameErrMsg = " User name is not be empty";
				$dcsn = FALSE;
			}
			if ($ac_type == "Not Selected") {
				//$cpasswordErrMsg = "  Confirm password is not be empty";
				$sunErrMsg = " *Please select valid account type.";
				$dcsn = FALSE;
			}
			else {
				$dcsn = TRUE;
			}

			if(!isset($_COOKIE['username'])) {
				session_unset();
				session_destroy();
				header("Location: login.php");
			}
			if(isset($_POST['submit'])) {
				if(isset($_SESSION['svalue'])) {
					if($dcsn) {
						if(file_exists('client_data.json')) {
							function get_input_exist_file() {
								$cnt = TRUE;
								$jsonfile = 'client_data.json';
							   
								$readjsonfile = file_get_contents($jsonfile);
								$datadriven = json_decode($readjsonfile, TRUE);
								$arr_len = count($datadriven);
								for($i = 0; $i < $arr_len; $i++) {
									if($datadriven[$i]['UserName'] === $GLOBALS['uname']) {
										$cnt = FALSE;
										break;							
									}
								}
	
								if($cnt) {
									$datastore = array(
										'UserName' => $GLOBALS['uname'],
										'AccType' => $GLOBALS['ac_type']
									);
	
									$datadriven[] = $datastore;
									$final_data = json_encode($datadriven);
									if(file_put_contents($jsonfile, $final_data)) {
										header("Location: rfam.php");
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
								$jsonfile = "client_data.json";
								$jsonfileAd = fopen($jsonfile, "w");
								
								$datadriven = array();
								$datastore = array(
									'UserName' => $GLOBALS['uname'],
									'AccType' => $GLOBALS['ac_type']
								);
	
								$datadriven[] = $datastore;
								$final_data = json_encode($datadriven);
								fclose($jsonfileAd);
	
								if(file_put_contents($jsonfile, $final_data)) {
									header("Location: rfam.php");
								}
							}
	
							assign_input_new_file();
						}
					}
				}	
			}
		}
		include '../head.php';
	?>
	<br><br>

	<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
		<fieldset><br>
			<legend id="lgstyle">New Reader Account</legend><br>
			<select name="actype" id="actype">
				  <option value="Not Selected">--Select Account Type--</option>
				  <option value="Reader">Reader</option>
				  <option value="Librarian">Librarian</option>
				  <option value="Vendor">Vendor</option>
			</select><br><br>
			<label for="name">User Name</label><br>
			<input type="text" name="uname" id="uname" value="<?php echo $uname ?>" required><br><br>
			
			<input type="submit" name="submit" class="sbutton" value="Add Account"><br><br>
		</fieldset>
	</form>
	<div class="emstyle">
			<br><?php echo $sunErrMsg; ?>
	</div>
	<?php include '../footer.php'; ?><br>
</body>
</html>