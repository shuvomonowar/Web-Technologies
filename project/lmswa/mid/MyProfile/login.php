<?php
	session_start();

	$cookie_name = "username";
	$cookie_value = "shuvomonowar";
	setcookie($cookie_name, $cookie_value, time() + 10, "/");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="refresh" content="10">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Log In</title>
	<style>
		#filename {
			position: relative;
			top: 20px;
			left: 300px;
			font-weight: bolder;
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
		$uname_mail = "";
		//$uname_mailErrMsg = "";
		$uname = "";
		$password = "";
		//$passwordErrMsg = "";
		$allErrMsg = "";

		$dcsn = FALSE;

		if ($_SERVER['REQUEST_METHOD'] === "POST") {

			function test_input($data) {
				$data = htmlspecialchars($data);
				return $data;
			}

			$uname_mail = test_input($_POST['uname_mail']);
			$password = test_input($_POST['pword']);

			/*
			if (empty($username)) {
				$unameErrMsg = " User name is not be empty";
			}
			if (empty($password)) {
				$passwordErrMsg = "Password is not be empty";
			}
			*/

			$jsonfile = 'my_data.json';
			$readjsonfile = file_get_contents($jsonfile);
			$datadriven = json_decode($readjsonfile, TRUE);
			$arr_len = count($datadriven);

			for($i = 0; $i < $arr_len; $i++) {
				if(($datadriven[$i]['UserName'] == $uname_mail  && $datadriven[$i]['Password'] == $password) || ($datadriven[$i]['Email'] == $uname_mail  && $datadriven[$i]['Password'] == $password)) {
					$uname = $datadriven[$i]['UserName'];
					$dcsn = TRUE;
				}
				else {
					$allErrMsg = "*Try using valid username and password";
				}
			}
			

			if($dcsn) {
				$_SESSION["svalue"] = $uname;
				if(isset($_POST['remember'])) {
					if(isset($_POST['signin'])) {
						if(isset($_COOKIE[$cookie_name])) {
							if(count($_COOKIE) > 0) {
								header("Location: portal.php");
							}
						}
					}
				}
				else if(!isset($_POST['remember'])) {
					setcookie($cookie_name, $cookie_value, time()+360000, "/");
					if(isset($_POST['signin'])) {
						header("Location: portal.php");
					}
				}
			}
		}
	?>

	<br>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" novalidate>
		<fieldset>
			<legend id="lgstyle">Sign In Form</legend><br>
			<label for="uname_mail">Username or Email</label>
			<input type="text" name="uname_mail" id="uname_mail" value="<?php echo $uname_mail ?>" required><br><br>
			<label for="pword">Password</label>
			<input type="text" name="pword" id="pword" value="<?php echo $password ?>" required><br><br>
			<input type="checkbox" id="remember" name="remember" value="">
	  		<label for="remember"> Remember me</label><br><br>
			<input type="submit" name="signin" class="sbutton" value="Sign In">
			<div>
				<h4></h4><a href="forget_password.php" target="_self">Forgotten password?</a><br><br>
			</div>
			<div>
				<h4 id="h4lbrk">Don't have an account?</h4>
				<a href="registration.php" target="_self">Sign Up</a>
			</div><br>
		</fieldset><br>
		<div class="emstyle">
			<?php echo $allErrMsg ?>
		</div><br>
	</form>
</body>
</html>