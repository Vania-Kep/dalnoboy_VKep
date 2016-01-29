<?php
	include('resources\properties.php');
	include('components\connection.php');
	include('functional\uni-auth.php');
	include('functional\user-managment.php');


	if(!USER_LOGGED || !admin_permissions($UserID, $conn)) {
		header("Location: main.php");
	} else {
		$pageTitle = 'Users managment';
		$pageID = 'usersManagment';
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
	<body class='register_pt them'>
		<?php include 'header.php';?>

		<div class="users-managment-block">
			<form class="" id="show-users" action="users.php?users=1" method="POST">
				<table class="table" style="width:400px">
				  <thead class="thead-inverse">
				    <tr>
				      <th>X</th>
				      <th>id</th>
				      <th>Login</th>
				      <th>Permissions</th>
				    </tr>
				  </thead>
				  <tbody>
				  <?php
				  	$users = getUsers($conn);
				  	$i = 0;
				  	while($user = $users->fetch_array())
					{$i++;
				?>
					<tr>
				      <td><input type="radio" name="getUsr" value="usr<?=$user['uid']?>"></td>
				      <th scope="row"><?=$i?></th>
				      <td><?=$user['username']?></td>
				      <td><?=$user['permissions']?></td>
				    </tr>
				<?php
					}
				?>
				  </tbody>
				</table>
				<div class='row error'>
					<span class="error form-error"></span>
				</div>
				<div class='row'>
					<!--<button type="submit" name="edit" id="edit" class="btn btn-default">Edit</button>-->
					<button type="submit" name="remove" id="remove" class="btn btn-default">Remove</button>
				</div>
			</form>
			<!--Users managment block end-->
		</div>

		<div class="register-block border-decorator">
			<form class="" id="site-register" action="users.php?users=1" method="POST">
				<div class='row'>
					<span class="collumn-1">Login:</span>
					<input type="text" class="form-control" name="new-user" id="new-user" placeholder="Login" autofocus>
				</div>
				<div class='row'>
					<span class="collumn-1">Password:</span>
					<input type="password" class="form-control" name="new-user-pass" id="new-user-pass" placeholder="Pass" >
					<input type="password" class="form-control" name="new-user-re-pass" id="new-user-re-pass" placeholder="Re-Pass" >
				</div>
				<div class='row'>
					<span class="collumn-1">Permissions:</span>
					<select name='new-user-permissions' id="new-user-permissions" class="form-control">
						<option value="" selected disabled="disabled">Select user permissions</option>					
						<option value="admin">admin</option>	
						<option value="moderator">moderator</option>
						<option value="reader">reader</option>
					</select>
				</div>
				<div class='row error'>
					<span class="error form-error"></span>
				</div>
				<div class='row'>
					<button type="submit" name="registrate" class="btn btn-default">Registrate</button>
				</div>
			</form>
		</div>
	</body>	
		<script src="./js/jQuery/jquery-2.2.0.min.js"></script>
		<script src="./js/jQuery/jquery-ui.js"></script>
		<script src="./js/app.dialog.js"></script>
		<script src="./js/app.users.js"></script>
</html>
<?php } ?>