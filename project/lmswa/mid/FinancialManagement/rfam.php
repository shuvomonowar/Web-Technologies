<?php
	session_start();

	$cookie_name = "usrname";
	$cookie_value = "kk";
	setcookie($cookie_name, $cookie_value, time() + 3600, "/");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>RFAM</title>
	<style>
		.tclass {
		  	margin-left: auto;
		  	margin-right: auto;
		  	width: 50%;
		}

		.edetails {
			text-align: center;
			padding: 15px;
			width: 61%;
		}

		table, th, td {
		 	border: 1px solid black;
		 	border-collapse: collapse;
		}

		th, td {
		  	padding: 15px;
		}

		#nra_style {
			display: inline;
		}

		#lgstyle {
			font-size: 20px;
			color: blue;
		}

		.udemsg {
			font-size: 15px;
			color: red;
			padding-left: 490px;
		}

		.unemstyle {
			font-size: 15px;
			color: red;
		}
	</style>
</head>
<body>
	<?php
		if(!isset($_COOKIE['username'])) {
			session_unset();
			session_destroy();
			header("Location: ../MyProfile/login.php");
		}
		if(!isset($_SESSION['svalue'])) {
			include "../MyProfile/logout.php";
		}

		$uname = "";
		$unameDataErrmsg = "";
		$unameErrMsg = "";
		$tbalance = "";
		$dbalance = "";
		$status = "";

		$dcsn = FALSE;

		$addbtn = 'disabled';
		$upbtn = 'disabled';


		if ($_SERVER['REQUEST_METHOD'] === "POST") {

			function test_input($data) {
				$data = htmlspecialchars($data);
				return $data;
			}

			$uname = test_input($_POST['uname']);

			/*
			if (empty($username)) {
				$unameErrMsg = " User name is not be empty";
			}
			if (empty($password)) {
				$passwordErrMsg = "Password is not be empty";
			}
			*/

			if(isset($_POST['search'])) {
				$cdrive = array();
				$cstore = array('CookieValue' => $_POST['uname']);
				$cdrive[] = $cstore;
		        $cdfinal = json_encode($cdrive);		   
				if(file_put_contents('pcookie.json', $cdfinal)) {
						        //header("Location: login.php");
				}
				if(file_exists('client_data.json')) {
					$jsonfile = 'client_data.json';
					$readjsonfile = file_get_contents($jsonfile);
					$datadriven = json_decode($readjsonfile, TRUE);
					$arr_len = count($datadriven);

					for($i = 0; $i < $arr_len; $i++) {
						if($datadriven[$i]['UserName'] == $uname && $datadriven[$i]['AccType'] == "Reader") {
							//$dcsn = TRUE;

							if(file_exists('reader_financial_data.json')) {
								$jsonfile1 = 'reader_financial_data.json';
								$readjsonfile1 = file_get_contents($jsonfile1);
								$datadriven1 = json_decode($readjsonfile1, TRUE);
								$arr_len1 = count($datadriven1);

								for($j = 0; $j < $arr_len1; $j++) {
									if($datadriven1[$j]['UserName'] == $uname) {
										$addbtn = 'disabled';
										$upbtn = 'enabled';

										$uname = $datadriven1[$j]['UserName'];
										$tbalance = $datadriven1[$j]['TotalBalance'];
										$dbalance = $datadriven1[$j]['DueBalance'];
										$status = $datadriven1[$j]['Status'];

										break;
									}
									else {
										$addbtn = 'enabled';
										$upbtn = 'disabled';
										//$unameDataErrmsg = " *Reader account financial data is not added yet. Please add reader account financial data using add record option.";
									}
								}

								break;
							}
							else {
								$addbtn = "enabled";
								$upbtn = "disabled";
								//$unameDataErrmsg = " *Reader account financial data is not added yet. Please add reader account financial data using add record option.";
							}

							break;
						}
						else {
							//$unameErrMsg = " *Reader is not registered yet. Please, add reader account using add reader option.";
						}
					}
				}
				else {
					//$unameErrMsg = " *User is not registered yet. Please, add user account using add user option.";
				}
			}
		}

		if(isset($_POST['addacc'])) {
			$cread = file_get_contents('pcookie.json');
			$cdriven = json_decode($cread, TRUE);
			$clen = count($cdriven);
			$cookie_value = $cdriven[$clen-1]['CookieValue'];
			setcookie($cookie_name, $cookie_value, time() + 36000, "/");

			header('Location: reader_details.php');
		}

		if(isset($_POST['update'])) {
			$cread = file_get_contents('pcookie.json');
			$cdriven = json_decode($cread, TRUE);
			$clen = count($cdriven);
			$cookie_value = $cdriven[$clen-1]['CookieValue'];
			setcookie($cookie_name, $cookie_value, time() + 36000, "/");

			header('Location: update_reader_details.php');
		}
		
		include '../head.php';
	?><br><br>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
		<fieldset>
		<legend id="lgstyle">User Reader</legend><br>
			<label for="uname">User Name</label>
			<input type="text" name="uname" id="uname" value="<?php echo $uname; ?>" required>
			<input type="submit" name="search" value="Search"><br><br>
			<h4 id="nra_style">Want to add new user?<a href="new_reader.php" target="_self">Add Reader</a></h4>
		</fieldset><br>
		<div class="unemstyle">
			<?php echo $unameErrMsg; ?>
		</div>
	</form><br><br><br>
	<table class="tclass">
		<caption style="font-size: x-large;">Reader Financial Account Details</caption>
		<tr>
			<th>User Name</th>
			<th>Total Balance</th>
			<th>Due Balance</th>
			<th>Status</th>
		</tr>
		<tr>
			<td><?php echo $uname; ?></td>
			<td><?php echo $tbalance; ?></td>
			<td><?php echo $dbalance; ?></td>
			<td><?php echo $status; ?></td>
		</tr>
	</table>
	<div class="edetails">
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
			<input type="submit" name="addacc" value="Add Record" <?php echo $addbtn; ?>> <input type="submit" name="update" value="Update Record" <?php echo $upbtn; ?>>
		</form><br>
		<div class="udemsg">
			<?php echo $unameDataErrmsg; ?>
		</div>
	</div>
	<?php include '../footer.php' ?><br><br>
</body>
</html>