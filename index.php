<?php

	include('resources/properties.php');
	include('components/connection.php');
	include('functional/uni-auth.php');

	if(USER_LOGGED) {
		if(!check_user($UserID, $conn)) {
			logout();
		} else {
			header("Location: main.php");
		}
	} else { 
?>
	<!DOCTYPE>
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
			
			<link rel="stylesheet" type="text/css" href="./styles/bootstrap-styles.css"/>
			<link rel="stylesheet" type="text/css" href="./styles/bootstrap.min.css"/>
			<link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
			<link rel="stylesheet" type="text/css" href="./styles/style.css"/>
			
			<title>Далекобій</title>
		</head>
		<body>
			<div class="container">
				<div class="row">
					<form class="form-signin mg-btm" id="site-login" action="<?=$_SERVER['PHP_SELF'];?>" method="POST">
						<h3 class="heading-desc">Вхід на сайт</h3>

						<div class="main">	
							<label class="input-field-label">Логін</label>    
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								<input type="text" class="form-control" name="user" id="login" placeholder="Login" autofocus>
							</div>
							<label class="input-field-label">Пароль</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
								<input type="password" class="form-control" name="pass" id="login-pass" placeholder="Password">
							</div>
					
							<div class="row">
								<div class="col-xs-6 col-md-6">
									 
								</div>
								<div class="col-xs-6 col-md-6 pull-right">
									<button type="submit" name="login" class="btn btn-large btn-success pull-right">Увійти</button>
								</div>
							</div>
						</div>
					
						<span class="clearfix"></span>	

						<div class="login-footer">
							<div class="row">
								<div class="col-xs-6 col-md-6">
									<div class="left-section">
										<a href="https://www.linkedin.com/in/vania-kapitan-77096575" target="_blank">Ivan Kapitan © 2016</a>
									</div>
								</div>
								<div class="col-xs-6 col-md-6 pull-right"></div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</body>		
		<script src="./js/jQuery/jquery-2.2.0.min.js"></script>
		<script src="./js/app.loginization.js"></script>
	
	</html>
<?php
}
?>