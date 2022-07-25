<?php
	session_start();
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Logout</title>
</head>
<body>
	<?php 
		session_unset();
		session_destroy();
		header("Location: login.php");
	?>
</body>
</html>