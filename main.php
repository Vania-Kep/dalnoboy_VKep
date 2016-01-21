<?php
	include('connection.php');
	include('uni-auth.php');
	if(!USER_LOGGED || !check_user($UserID, $conn)) {
		header("Location: index.php");
} else {?>
<!DOCTYPE>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="./styles/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="./styles/bootstrap-styles.css">
		<link rel="stylesheet" type="text/css" href="./styles/style.css">
		
		<script src="./js/jQuery/jquery-2.2.0.min.js"></script>
		<title>Далекобій</title>
	</head>
	<body class='main_pt them'>
		<?php include 'header.php';?>
		<div id="wrapper">
			<div class="db-table">
				<table class="table">
				  <thead class="thead-inverse">
				    <tr>
				      <th>#</th>
				      <th>First Name</th>
				      <th>Last Name</th>
				      <th>Username</th>
				    </tr>
				  </thead>
				  <tbody>
				    <tr class="success">
				      <th scope="row">1</th>
				      <td>Mark</td>
				      <td>Otto</td>
				      <td>@mdo</td>
				    </tr>
				    <tr>
				      <th scope="row">2</th>
				      <td>Jacob</td>
				      <td>Thornton</td>
				      <td>@fat</td>
				    </tr>
				    <tr>
				      <th scope="row">3</th>
				      <td>Larry</td>
				      <td>the Bird</td>
				      <td>@twitter</td>
				    </tr>
				  </tbody>
				</table>
			</div>
			<div class="new-db-row">
				<form>
					
				</form>
			</div> 
		</div>
		<div id="footer">
		</div>
	</body>	
</html>
<?php } ?>
