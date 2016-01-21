<?php

include('connection.php'); 

include('uni-auth.php');

if(USER_LOGGED) { 
    if(!check_user($UserID, $conn)) logout();
?>
    <h1>Здравствуйте, <?php echo $UserName; ?>!</h1>
    <h2>Ваш ID: <?php echo $UserID; ?>.</h2>
    <h4><a href="?logout">Выход</a></h4>
<?php
}
else { ?>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <table>
    <tr>
    <td>Имя:</td><td><input type="text" name="user"></td>
    </tr>
    <tr>
    <td>Пароль:</td><td><input type="password" name="pass"></td>
    </tr>
    <tr>
    <td colspan="2"><input type="submit" name="login" value="Войти"></td>
    </tr>
    </table>
    </form>
<?php
}
?>
