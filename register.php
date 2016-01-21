<?php
include('connection.php');
include('uni-auth.php');
if(!USER_LOGGED || !admin_permissions($UserID, $conn)) {
	header("Location: main.php");
} else {?>

<!DOCTYPE>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="./styles/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="./styles/bootstrap-styles.css">
		<link rel="stylesheet" type="text/css" href="./styles/style.css">
		
		<script src="./js/jQuery/jquery-2.2.0.min.js"></script>
		<title>Registration</title>
	</head>
	<body class='register_pt them'>
		<?php include 'header.php';?>

		<div class="register-block">
			<form class="" id="site-register" action="register.php?users=1" method="POST">
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
					<select name='new-user-permissions' id="new-user-permissions">
						<option value="" selected disabled="disabled">Select user permissions</option>					
						<option value="admin">admin</option>	
						<option value="moderator">moderator</option>
						<option value="reader">reader</option>
					</select>
				</div>
				<div class='row'>
					<button type="submit" name="registrate" class="btn btn-default">Registrate</button>
				</div>
			</form>
		</div>
		<div>
			<form class="" id="show-users" action="register.php?users=1" method="POST">
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
				  	while($user = $users->fetch_array())
					{
				?>
					<tr>
				      <td><input type="radio" name="getUsr" value="usr<?=$user['uid']?>"></td>
				      <th scope="row"><?=$user['uid']?></th>
				      <td><?=$user['username']?></td>
				      <td><?=$user['permissions']?></td>
				    </tr>
				<?php
					}
				?>
				  </tbody>
				</table>

				<div class='row'>
					<button type="submit" name="edit" id="edit" class="btn btn-default">Edit</button>
					<button type="submit" name="remove" id="remove" class="btn btn-default">Remove</button>
				</div>
			</form>
		</div>

	</body>	
		<script src="./js/jQuery/jquery-2.2.0.min.js"></script>
		<script src="./js/app.users.js"></script>
</html>
<?php 
}
?>

<?php
if (isset($_POST['registrate'])) {
	if(get_magic_quotes_gpc()) { //Если слеши автоматически добавляются
        $_POST['new-user']=stripslashes($_POST['new-user']);
        $_POST['new-user-pass']=stripslashes($_POST['new-user-pass']);
        $_POST['new-user-re-pass']=stripslashes($_POST['new-user-re-pass']);
        $_POST['new-user-permissions']=stripslashes($_POST['new-user-permissions']);
    }
    $newUser = mysqli_real_escape_string($conn, $_POST['new-user']);
    $newUserPass = mysqli_real_escape_string($conn, $_POST['new-user-pass']);
    $newUserRePass = mysqli_real_escape_string($conn, $_POST['new-user-re-pass']);

    //find user with current user name
    $result = mysqli_query($conn, "SELECT * FROM `".USERS_TABLE."` WHERE `username`='$newUser';") or die(mysqli_connect_error());

    if ($newUser == "" || $newUserPass == "" || $newUserRePass == "" || !isset($_POST['new-user-permissions'])) {
        header('Refresh: 5;');
        die("<div class='register-info'><h3>Введіть всі дані!</h3></div><div class='loader-bg'></div>");
    } else if (mysqli_num_rows($result) > 0) {
        header('Refresh: 5;');
        die("<div class='register-info'><h3>Логін вже зайнятий!</br>Виберіть інший логін. </h3></div><div class='loader-bg'></div>");
    } else if ( $newUserPass != $newUserRePass ) {
        header('Refresh: 5;');
        die("<div class='register-info'><h3>Паролі не співпадають! </h3></div><div class='loader-bg'></div>");
    } else {
      //  header('Refresh: 5;');
        die("<div class='register-info'><h3>Паролі не співпадають! </h3></div><div class='loader-bg'></div>");
   		$newUserPermissions = mysqli_real_escape_string($conn, $_POST['new-user-permissions']);
    	//registrate($conn, $newUser, $newUserPass, $newUserPermissions);
    }
}
function registrate($conn, $newUser, $newUserPass, $newUserPermissions) {
	$newUserPass = md5($newUserPass);
	mysqli_query($conn, "INSERT INTO `".USERS_TABLE."` (`username`,`password`, `permissions`) VALUES ('$newUser','$newUserPass', '$newUserPermissions')");

	return ;
}

function getUsers($conn) {
	$result = mysqli_query($conn, "SELECT `uid`, `username`, `permissions` FROM `".USERS_TABLE."`;") or die(mysqli_connect_error());
  //  $data = array_values($result->fetch_array(MYSQLI_ASSOC));
    return $result ;
}


if (isset($_POST['remove'])) {
	header('Refresh: 5;');
    die("<div class='loader-indicator'><h3>".($_POST['getUsr'])."</h3></div><div class='loader-bg'></div>");
}
if (isset($_POST['edit'])) {
	header('Refresh: 2;');
    die("<div class='register-info'><h3>".$_POST['getUsr']."</h3></div><div class='loader-bg'></div>");
}





?>