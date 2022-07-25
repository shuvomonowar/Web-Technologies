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
			border: none;
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
		if(isset($_POST['adedit'])) {
			if(isset($_SESSION['svalue'])) {
				header("Location: account_edit.php");
			}
			else {
				header("Location: login.php");
			}
		}

		include '../head.php';
	?><br><br>

	<?php 
		$acc_type = "Accountant";
		$email = "";
		$password = "";

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
			<legend id="acstyle">Account Details</legend><br>
			<label for="actype">Account Type</label><br>
			<input type="text" id="actype" name="actype" value="<?php echo $acc_type; ?>" readonly><br><br>
			<label for="email">Email</label><br>
			<input type="email" id="email" name="email" value="<?php echo $email ?>" readonly><br><br>
			<label for="pword">Password</label><br>
			<input type="text" name="password" id="pword" value="<?php echo $password ?>" readonly><br><br>
			<input type="submit" name="adedit" class="acesubmit" value="Edit Details">
		</fieldset>
	</form>
	<div>
		<?php include '../footer.php'; ?>
	</div>
</body>
</html>