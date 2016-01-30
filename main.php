<?php
	include('components/connection.php');
	include('functional/uni-auth.php');
	
	if(!USER_LOGGED || !check_user($UserID, $conn)) {
		header("Location: index.php");
	} else {
		$pageTitle = 'Далекобій';
		$pageID = 'main';
?>
<!DOCTYPE>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="./styles/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="./styles/bootstrap-styles.css">
		<link rel="stylesheet" type="text/css" href="./styles/style.css">
		
		<title><?=$pageTitle?></title>
	</head>
	<body class='main_pt them'>
		<?php include 'header.php';?>
		<div id="wrapper">
			
		</div>

		<div id="footer">
		</div>
	</body>
	<script src="./js/jQuery/jquery-2.2.0.min.js"></script>

</html>
<?php } ?>
