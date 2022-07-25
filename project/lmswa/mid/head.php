<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Header</title>
	<style>
		.header {
			color: dimgrey;
			text-align: center;
			font-size: 12px;
			background-color: ghostwhite;
			padding-top: 20px;
		}
		.navbar {
			overflow: hidden;
			font: 15px Arial, sans-serif;
		}

		.navbar a {
		  	float: left;
		  	text-align: center;
		  	padding: 14px 16px;
		  	text-decoration: none;
		  	color: black;
		}

		.subnav {
		  	float: left;
			overflow: hidden;
		}

		.subnav .subnavbtn {
		  	border: none;
		  	outline: none;
		  	padding: 14px 16px;
		  	background-color: inherit;
		  	font-size: 15px;
			margin: 0;
		}

		.subnavcontent {
			display: none;
			position: absolute;
			width: 127%;
			z-index: 1;
			margin: 0
		}

		.subnavcontent a {
		  	float: left;
		  	text-decoration: none;
		}
		
		.subnav:hover .subnavcontent {
		  	display: block;
		}

		ul {
			list-style-type: none;
			margin: 0;
			padding: 0;
			width: 127px;
			background-color: ghostwhite;
		}

		li a {
			display: block;
			padding: 8px 16px;
			text-decoration: none;
			background-color: ghostwhite;
		}

		li a:hover {
		  	color: blue;
		}

		#myprofile {
			background-color: inherit;
			color: green;
			border: none;
			width: 127px;
			padding: 15px 16px;
			text-decoration: none;
			display: block;
			cursor: pointer;
			font-size: 14px;
			font-weight: bold;
			text-align: center;
		}

		#settings, #lgout {
			background-color: inherit;
			border: none;
			width: 127px;
			padding: 15px 16px;
			text-decoration: none;
			display: block;
			cursor: pointer;
			font-size: 14px;
		}

		#myprofile:hover {
			color: limegreen;
		}

		#settings:hover, #lgout:hover, #rfam:hover, #lfam:hover, #vfam:hover, #efam:hover {
		  	color: blue;
		}

		#rfam, #lfam, #vfam, #efam {
			background-color: inherit;
			border: none;
			padding: 15px 16px;
			text-decoration: none;
			display: block;
			cursor: pointer;
			font-size: 14px;
			width:127px;
		}

	</style>
</head>
<body>
	<?php
		if(isset($_SESSION['svalue'])) {
			if(isset($_POST['logout'])) {
				header('Location: ../MyProfile/logout.php');
			}
		}
		else {
			header("Location: ../MyProfile/login.php");
		}

		if(isset($_SESSION['svalue'])) {
			if(isset($_POST['myprofile'])) {
				header("Location: ../MyProfile/profile.php");
			}
		}

		if(isset($_SESSION['svalue'])) {
			if(isset($_POST['settings'])) {
				header("Location: ../MyProfile/account.php");
			}
		}

		if(isset($_SESSION['svalue'])) {
			if(isset($_POST['rfam'])) {
				header("Location: ../FinancialManagement/rfam.php");
			}
		}
	?>
	<div class="header">
		<h1>Library Management System</h1>
		<div class="navbar">
			<a href="../MyProfile/portal.php">Home</a>
			<div class="subnav">
				<button class="subnavbtn">Profile</button>
				<div class="subnavcontent">
					<ul>
						<li><form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"><input type="submit" id="myprofile" name="myprofile" value="<?php echo $_SESSION['svalue'] ?>"></form></li>
						<li><form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"><input type="submit" id="settings" name="settings" value="Settings"></form></li>
						<li><form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"><input type="submit" id="lgout" name="logout" value="Logout"></form></li>
					</ul>	
				</div>
			</div>
			<div class="subnav">
				<button class="subnavbtn">Management</button>
				<div class="subnavcontent">
					<ul>
						<li><form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"><input type="submit" id="rfam" name="rfam" value="RFAM"></form></li>
						<li><form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"><input type="submit" id="lfam" name="lfam" value="LFAM"></form></li>
						<li><form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"><input type="submit" id="vfam" name="vfam" value="VFAM"></form></li>
						<li><form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"><input type="submit" id="efam" name="efam" value="EFAM"></form></li>
					</ul>
					
				</div>
			</div>
			<div class="subnav">
				<button class="subnavbtn">Others</button>
				<div class="subnavcontent">
					<ul>
						<li><a href="#fd">Form Download</a></li>
					</ul>
				</div>
			</div>
			<div class="subnav">
				<button class="subnavbtn">Message</button>
				<div class="subnavcontent">
					<ul>
						<li><a href="https://mail.google.com/mail/u/0/#inbox" target="_parent">Email</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</body>
</html>