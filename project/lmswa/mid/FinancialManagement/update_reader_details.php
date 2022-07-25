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

		if(!isset($_COOKIE['username'])) {
			session_unset();
			session_destroy();
			header("Location: ../MyProfile/login.php");
		}
		if(!isset($_SESSION['svalue'])) {
				header("Location: ../MyProfile/logout.php");
		}

		if ($_SERVER['REQUEST_METHOD'] === "POST") {

			if(isset($_POST['usubmit'])) {
				if(isset($_SESSION['svalue'])) {
					function test_input($data) {
						$data = htmlspecialchars($data);
						return $data;
					}

					$uname = test_input($_POST['uname']);
					$totBalance = test_input($_POST['totbalance']);
					$dueBalance = test_input($_POST['duebalance']);
					$status = test_input($_POST['status']);

					$jsonfile = 'reader_financial_data.json';
								       
					$readjsonfile = file_get_contents($jsonfile);
					$datadriven = json_decode($readjsonfile, TRUE);
					$arr_len = count($datadriven);
					for($i = 0; $i < $arr_len; $i++) {
						if($datadriven[$i]['UserName'] === $_COOKIE['usrname']) {
							$datadriven[$i]["TotalBalance"] = $totBalance;
							$datadriven[$i]["DueBalance"] = $dueBalance;
							$datadriven[$i]["Status"] = $status;

							$data_input = json_encode($datadriven, JSON_PRETTY_PRINT);
							if(file_put_contents($jsonfile, $data_input)) {
								//$smessage = " *Profile information updated successfully.";
								header("Location: rfam.php");
							}		
								
							break;					
						}
					}
				}
			}
			
			if(isset($_POST['dsubmit'])) {
				if(isset($_SESSION['svalue'])) {
					$jsonfile1 = 'reader_financial_data.json';
								       
					$readjsonfile1 = file_get_contents($jsonfile1);
					$datadriven1 = json_decode($readjsonfile1, TRUE);
					$arr_len1 = count($datadriven1);
					for($k = 0; $k < $arr_len1; $k++) {
						if($datadriven1[$k]['UserName'] === $_COOKIE['usrname']) {
							unset($datadriven1[$k]);
		
							$data_input1 = json_encode($datadriven1);
							if(file_put_contents($jsonfile1, $data_input1)) {
								header("Location: rfam.php");
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
		$uname = "";
		$totBalance = "";
		$dueBalance = "";
		$status = "";

		if ($_SERVER['REQUEST_METHOD'] === "GET") {
			$uname = $_COOKIE['usrname'];
			$jsonfile3 = 'reader_financial_data.json';
					       
			$readjsonfile3 = file_get_contents($jsonfile3);
			$datadriven3 = json_decode($readjsonfile3, TRUE);
			$arr_len3 = count($datadriven3);
			for($p = 0; $p < $arr_len3; $p++) {
				if($datadriven3[$p]['UserName'] === $_COOKIE['usrname']) {
					$uname = $datadriven3[$p]['UserName'];
					$totBalance = $datadriven3[$p]['TotalBalance'];
					$dueBalance = $datadriven3[$p]['DueBalance'];
					$status = $datadriven3[$p]['Status'];

					break;					
				}
		    }
		}
	?>

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
			
			<input type="submit" name="usubmit" class="sbutton" value="Update Record"><br>
			<input type="submit" name="dsubmit" class="sbutton" value="Delete Record"><br><br>
		</fieldset>
	</form>
	<div class="emstyle">
			<br><?php echo $sunErrMsg; ?>
	</div>
	<?php include '../footer.php'; ?><br>
</body>
</html>