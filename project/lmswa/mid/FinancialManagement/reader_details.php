<?php
	session_start();
?>
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
		$uname = "";
		//$unameErrMsg = "";
		$totBalance = "";
		$dueBalance = "";
		$status = "";
		
		$sunErrMsg = "";
		$dcsn = TRUE;

		if(isset($_COOKIE['usrname'])) {
			$uname = $_COOKIE['usrname'];
		}
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

			$totBalance = test_input($_POST['totbalance']);
			$dueBalance = test_input($_POST['duebalance']);
			$status = test_input($_POST['status']);
			
			

			if(!isset($_COOKIE['username'])) {
				session_unset();
				session_destroy();
				header("Location: ../MyProfile/login.php");
			}
			if(isset($_POST['submit'])) {
				if(isset($_SESSION['svalue'])) {
					if($dcsn) {
						if(file_exists('reader_financial_data.json')) {
							function get_input_exist_file() {
								$cnt = TRUE;
								$jsonfile = 'reader_financial_data.json';
							   
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
										'TotalBalance' => $GLOBALS['totBalance'],
										'DueBalance' => $GLOBALS['dueBalance'],
										'Status' => $GLOBALS['status']
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
								$jsonfile = "reader_financial_data.json";
								$jsonfileAd = fopen($jsonfile, "w");
								
								$datadriven = array();
								$datastore = array(
									'UserName' => $GLOBALS['uname'],
									'TotalBalance' => $GLOBALS['totBalance'],
									'DueBalance' => $GLOBALS['dueBalance'],
									'Status' => $GLOBALS['status']
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
			<legend id="lgstyle">Add Reader Financial Details</legend><br>
			<label for="name">User Name</label><br>
			<input type="text" name="uname" id="uname" value="<?php echo $uname ?>" readonly><br><br>
			<label for="totbl">Total Balance</label><br>
			<input type="text" name="totbalance" id="totbl" value="<?php echo $totBalance ?>" required><br><br>
			<label for="duebl">Due Balance</label><br>
			<input type="text" name="duebalance" id="duebl" value="<?php echo $dueBalance ?>" required><br><br>
			<label for="status">Status</label><br>
			<input type="text" name="status" id="status" value="<?php echo $status ?>" required><br><br>
			
			<input type="submit" name="submit" class="sbutton" value="Add Record"><br><br>
		</fieldset>
	</form>
	<div class="emstyle">
			<br><?php echo $sunErrMsg; ?>
	</div>
	<?php include '../footer.php'; ?><br>
</body>
</html>