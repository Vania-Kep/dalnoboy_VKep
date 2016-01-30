<?php
/*
Needs:
Mysql & PHP5
Created connection to MySQL and runed session
Созданое подключение к MySQL и запущеная сессия =)

(c)2016 Ivan Kapitan
*/

##Constants
define('USERS_TABLE','users');
define('SID',session_id());
define("SESSION_LIFE_TIME", 500);



##Functions defenition

function logout() {
	unset($_SESSION['uid']);	//Удаляем из сессии ID пользователя
    setcookie ("sid", '', time());
    die(header('Location: index.php'));
}

function login($username,$password, $conn)    {
    $result = mysqli_query($conn, "SELECT * FROM `".USERS_TABLE."` WHERE `username`='$username' AND `password`='$password';")
        or die(mysqli_connect_error());
    $USER = mysqli_fetch_array($result,1); //Генерирует удобный массив из результата запроса
    if(!empty($USER)) { //Если массив не пустой (это значит, что пара имя/пароль верная)
        $_SESSION = array_merge($_SESSION,$USER); //Добавляем массив с пользователем к массиву сессии
        setcookie ("sid", md5(SID), time()+SESSION_LIFE_TIME);
        
        mysqli_query($conn, "UPDATE `".USERS_TABLE."` SET `sid`='".SID."' WHERE `uid`='".$USER['uid']."';")
            or die(mysqli_connect_error());
        return true;
    }
    else {
        return false;
    }
}

function updateSessionLifeTime() {
    if (isset($_COOKIE['sid'])) {
        setcookie ("sid", md5(SID), time()+SESSION_LIFE_TIME);
    }
}

function check_user($uid, $conn) {
    $result = mysqli_query($conn, "SELECT `sid` FROM `".USERS_TABLE."` WHERE `uid`='$uid';") or die(mysqli_connect_error());
    $sid = array_values($result->fetch_array(MYSQLI_ASSOC));
    $sid = $sid[0];

    $notExparedSession = ($_COOKIE["sid"] == md5(SID));
    
    return ($sid==SID && $notExparedSession) ? true : false;
}

function admin_permissions($uid, $conn) {
    $result = mysqli_query($conn, "SELECT `sid`, `permissions` FROM `".USERS_TABLE."` WHERE `uid`='$uid';") or die(mysqli_connect_error());
    $data = mysqli_fetch_array($result,1);
    $sid = $data["sid"];
    $userPermissions = $data["permissions"];

    return ($sid==SID && $userPermissions == 'admin') ? true : false;
}


##Действия - если пользователь авторизирован
if(isset($_SESSION['uid']) && isset($_COOKIE['sid'])) { //Если была произведена авторизация, то в сессии есть uid

    //Константу удобно проверять в любом месте скрипта
    define('USER_LOGGED',true);
    //Создаём удобные переменные
    //Все поля таблицы пользователей записываются в сесси (см. стр. 35-37)
    //Таким образом, после добавления нового поля в таблицу надо дописть лишь одну строку
    $UserName = $_SESSION['username'];
    $UserPass = $_SESSION['password'];
    $UserID = $_SESSION['uid'];
}
else {
    define('USER_LOGGED',false);
}

## check user permissions permissines
# 1 - admin
# 2 - moderator
# 3 - reader
function checkUserPermissiones($uid, $conn, $perms) {
    $result = mysqli_query($conn, "SELECT `sid`, `permissions` FROM `".USERS_TABLE."` WHERE `uid`='$uid';") or die(mysqli_connect_error());
    $data = mysqli_fetch_array($result,1);
    $sid = $data["sid"];
    $userPermissions = $data["permissions"];

    return ( $sid==SID && $userPermissions == $perms ) ? true : false;
}

function actionCanceledByPerms() {
    header('Refresh: 3; index.php');
    die("<div style='margin: auto; width: 350px;'><h3>$ress_error_actionCanceled</br>$ress_error_dontHavePermissions</h3></div>");
}

##Loginization process
if (isset($_POST['login'])) {
    
    if(get_magic_quotes_gpc()) { //Если слеши автоматически добавляются
        $_POST['user']=stripslashes($_POST['user']);
        $_POST['pass']=stripslashes($_POST['pass']);
    }
    $user = mysqli_real_escape_string($conn, $_POST['user']);
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);
    $pass = md5($pass);

    if(login($user,$pass, $conn)) {
		header("Location: main.php");
    }
    else {
        header('Refresh: 3;');
        die($ress_wrongLoginOrPass = "<div style='margin: auto; width: 350px;'><h3>".$ress_wrongLoginOrPass."</h3></div>");
    }
    
}

##LogOut process
if(isset($_GET['logout'])) {
    logout();
}
?>