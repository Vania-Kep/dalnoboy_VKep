<?php
	include('resources/properties.php');
	include('components/connection.php');
	include('functional/uni-auth.php');

	if(!USER_LOGGED || !check_user($UserID, $conn)) {
		header("Location: main.php");
	} else {
		if (isset($_POST['change'])) {
		    if(get_magic_quotes_gpc()) { //Если слеши автоматически добавляются
		        $_GET['username']=stripslashes($_GET['username']);
		        $_POST['old-pass']=stripslashes($_POST['old-pass']);
		        $_POST['new-pass']=stripslashes($_POST['new-pass']);
		        $_POST['new-re-pass']=stripslashes($_POST['new-re-pass']);
		    }
		    $username = mysqli_real_escape_string($conn, $_GET['username']);
		    $oldPass = mysqli_real_escape_string($conn, $_POST['old-pass']);
		    $newPass = mysqli_real_escape_string($conn, $_POST['new-pass']);
		    $newRePass = mysqli_real_escape_string($conn, $_POST['new-re-pass']);

		    //find user with current user name
		    $oldPass = md5($oldPass);
		    $result = mysqli_query($conn, "SELECT * FROM `".USERS_TABLE."` WHERE `username`='$username' AND `password`='$oldPass' AND `sid`='".SID."';")
		        or die(mysqli_connect_error());
		    $USER = mysqli_fetch_array($result,1); //Генерирует удобный массив из результата запроса
		    if(empty($USER)) {
		        header('Refresh: 3;');
		        die("<div style='margin: auto; width: 350px;'><h3>$ress_error_wrongData</h3></div>");
		    } else if ($newPass!=$newRePass) {
		        header('Refresh: 3;');
		        die("<div style='margin: auto; width: 350px;'><h3>$ress_error_passwordsDontMatch</h3></div>");
		    } else {
   				updateSessionLifeTime();
   				
		    	$newPass = md5($newPass);
		    	mysqli_query($conn, "UPDATE `".USERS_TABLE."` SET `password`='$newPass' WHERE `username`='$username' AND `sid`='".SID."';")
		            or die(mysqli_connect_error());

		        header('Refresh: 3; main.php');
		        die("<div style='margin: auto; width: 350px;'><h3>$ress_passWasChangedSuccesfuly</h3></div>");
		    }

		}

		$pageTitle = 'Change my Password';
		$pageID = 'myPassChange';
?>

<!DOCTYPE>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="./styles/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="./styles/bootstrap-styles.css">
		<link rel="stylesheet" type="text/css" href="./styles/style.css">
		
		<title><?=$pageTitle?></title>

		<style type="text/css">
		.change-pass-block{
			width: 25%;
			min-width: 255px;
			position: absolute;
			left: 35%;
			box-shadow: 0 0 3px 3px #888;
    		border-radius: 2px;
    		padding: 20px;
    		margin-top: 10px;
		}
		span.error.form-error{
			font-weight: bold;
   			color: red;
		}
		</style>
	</head>
	<body class='register_pt them'>
		<?php include 'header.php';?>

		<div class="change-pass-block">
			<h3>Change my password</h3>
			<form class="" id="site-change-my-pass" action="?username=<?=$_SESSION['username']?>" method="POST">
				<div class='row'>
					<span class="collumn-1">Login:</span>
					<input type="text" disabled="disabled" class="form-control" name="username" id="username" value="<?=$_SESSION['username']?>">
				</div>
				<div class='row'>
					<span class="collumn-1">Current Password:</span>
					<input type="password" class="form-control" name="old-pass" id="old-pass" placeholder="Pass" >
				</div>
				<div class='row'>
					<span class="collumn-1">New Password:</span>
					<input type="password" class="form-control" name="new-pass" id="new-pass" placeholder="Pass" >
					<input type="password" class="form-control" name="new-re-pass" id="new-re-pass" placeholder="Re-Pass" >
				</div>
				<div class='row error'>
					<span class="error form-error"></span>
				</div>
				<div class='row'>
					<a href="main.php?" class="btn btn-default">Cancel</a>
					<button type="submit" name="change" class="btn btn-default">Change</button>
				</div>
			</form>
		</div>

	</body>	
		<script src="./js/jQuery/jquery-2.2.0.min.js"></script>
		<script type="text/javascript">
			$("body").on("submit", "#site-change-my-pass", function(e) {
			var oldPass = $("#old-pass"),
				newPass = $("#new-pass"),
				newRePass = $("#new-re-pass");

			var errorMessage = "";

			var newUserRegisterData = [oldPass, newPass, newRePass];

			$("#site-change-my-pass input").removeClass("error");
			$(this).find(".form-error").html(errorMessage).hide();

			if( $.trim(oldPass.val()) == "" || $.trim(newPass.val()) == "" || $.trim(newRePass.val()) == "" ) {
				e.preventDefault();

				errorMessage = "Введіть всі дані!";
				$(this).find(".form-error").html(errorMessage).show();
			//	alert(errorMessage);

				for (var i = (newUserRegisterData.length-1); i >= 0; i--) {
					if ( $.trim(newUserRegisterData[i].val()) == "" ) {
						newUserRegisterData[i].addClass("error");
						newUserRegisterData[i].focus();
					}
				}
			} else if (newPass.val() != newRePass.val()) {
				e.preventDefault();
				newPass.addClass("error");
				newRePass.addClass("error");

				errorMessage = "Паролі не співпадають!";
				$(this).find(".form-error").html(errorMessage).show();
				//alert(errorMessage);
				newPass.focus();
			}
			
			
		});
		</script>
</html>
<?php } ?>