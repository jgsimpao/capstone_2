<?php
	require_once('libraries/Bhutanio/BEncode/BEncode.php');
	require_once('libraries/connection.php');
	require_once('libraries/library.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title><?php echo get_title(); ?></title>
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="images/logo/favicon.png">
	<!-- Bootstrap -->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<!-- Customized Stylesheet -->
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<div class="wrapper">
<?php
		require_once('partials/header.php');
		require_once('partials/alert.php');
		display_content();
		require_once('partials/footer.php');
?>
	</div>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<!-- jquery.inputFileText -->
	<script type="text/javascript" src="js/jquery-input-file-text.js"></script>
	<!-- Customized JavaScript -->
	<script type="text/javascript" src="js/script.js"></script>
</body>
</html>
