<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Registration</title>
	<style>
		#filename {
			position: relative;
			top: 20px;
			left: 300px;
			font-weight: bolder;
		}
	</style>
</head>
<body>

	<?php 
		$firstname = "";
		$firstnameErrMsg = "";
		$lastname = "";
		$lastnameErrMsg = "";
		$gender = "";
		$genderErrMsg = "";
		$email = "";
		$emailErrMsg = "";
		$mobileno = "";
		$mobilenoErrMsg = "";
		$address1 = "";
		$address1ErrMsg = "";
		$country = "";
		$countryErrMsg = "";

		if ($_SERVER['REQUEST_METHOD'] === "POST") {

			function test_input($data) {
				$data = htmlspecialchars($data);
				return $data;
			}

			$firstname = test_input($_POST['firstname']);
			$lastname = test_input($_POST['lastname']);
			$gender = isset($_POST['gender']) ? test_input($_POST['gender']) : "";
			$email = test_input($_POST['email']);
			$mobileno = test_input($_POST['mobileno']);
			$address1 = test_input($_POST['address1']);
			$country = isset($_POST['country']) ? test_input($_POST['country']) : "";

			$message = "";
			if (empty($firstname)) {
				$message .= "First Name is Empty";
				$firstnameErrMsg = $message;
				$message = "";
			}
			else if(!empty($firstname)) {
				if (!preg_match("/^[a-zA-Z ]*$/",$firstname)) {
					$message .= "Try using valid character";
					$firstnameErrMsg = $message;
					$message = "";
				}
				else {
					$message .= $firstname;
					$firstname = $message;
					$message = "";
				}
			}
			if (empty($lastname)) {
				if (!preg_match("/^[a-zA-Z ]*$/",$lastname)) {
					$message .= "Try using valid character";
					$lastnameErrMsg = $message;
					$message = "";
				}
				else {
					$message .= "Last Name is Empty";
					$lastnameErrMsg = $message;
					$message = "";
				}
				
			}
			else if(!empty($lastname)) {
				$message .= $lastname;
				$lastname = $message;
				$message = "";
			}
			if (empty($gender)) {
				$message .= "Gender is not Selected";
				$gender = $message;
				$message = "";
			}
			else if(!empty($gender)) {
				$message .= $gender;
				$gender = $message;
				$message = "";
			}
			if (empty($email)) {
				$message .= "Email is Empty";
				$emailErrMsg = $message;
				$message = "";
			}
			else if(!empty($email)) {
				$message .= $email;
				$email = $message;
				$message = "";
			}
			if (empty($mobileno)) {
				$message .= "Mobileno is Empty";
				$mobilenoErrMsg = $message;
				$message = "";
			}
			else if(!empty($mobileno)) {
				$message .= $mobileno;
				$mobileno = $message;
				$message = "";
			}
			if (empty($address1)) {
				$message .= "Street/House/Road is Empty";
				$address1ErrMsg = $message;
				$message = "";
			}
			else if(!empty($address1)) {
				$message .= $address1;
				$address1 = $message;
				$message = "";
			}
			if (!isset($country) or empty($country)) {
				$message .= "Country is not Seletectd";
				$countryErrMsg = $message;
				$message = "";
			}
			else if(!empty($country)) {
				$message .= $country;
				$country = $message;
				$message = "";
			}
		}
	?>

	<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" novalidate>
		<fieldset>
			<legend>General</legend>

			<label for="fname">First Name</label>
			<input type="text" name="firstname" id="fname" value="<?php echo $firstname; ?>">
			

			<span><?php echo $firstnameErrMsg; ?></span>
			<br><br>

			<label for="lname">Last Name</label>
			<input type="text" name="lastname" id="lname" value="<?php echo $lastname; ?>">

			<span><?php echo $lastnameErrMsg; ?></span>
			<br><br>

			<label>Gender</label>
			<input type="radio" name="gender" id="male">
			<label for="male">Male</label>
			<input type="radio" name="gender" id="female">
			<label for="female">Female</label>
			<span><?php echo $gender; ?></span>
			<span><?php echo $genderErrMsg; ?></span>
			
			<br><br>

			<p id="filename">Group_01_20-43036-1</p>

		</fieldset>

		<fieldset>
			<legend>Contact</legend>

			<label for="email">Email</label>
			<input type="email" name="email" id="email" value="<?php echo $email; ?>">
			<span><?php echo $emailErrMsg; ?></span>

			<br><br>

			<label for="mobileno">Mobile No</label>
			<input type="text" name="mobileno" id="mobileno" value="<?php echo $mobileno; ?>">
			<span><?php echo $mobilenoErrMsg; ?></span>

			<br><br>

		</fieldset>

		<fieldset>
			<legend>Address</legend>

			<label for="address1">Street/House/Road</label>
			<input type="text" name="address1" id="address1" value="<?php echo $address1; ?>">
			<span><?php echo $address1ErrMsg; ?></span>

			<br><br>

			<label for="country">Country</label>
			<select name="country" id="country">
				<option value="Bangladesh">Bangladesh</option>
				<option value="USA">United States of America</option>
			</select>
			<span><?php echo $country; ?></span>
			<span><?php echo $countryErrMsg; ?></span>

			<br><br>

		</fieldset>

		<input type="submit" name="submit" value="Register">
	</form>

</body>
</html>