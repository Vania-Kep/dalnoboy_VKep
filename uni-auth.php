<?php
/*
Универсальный скрипт авторизации.
Используется сессии для хранения данных.
Скрипт типа "всё-в-одном" - его необходимо
включать в каждый файл для использования.
Распространяется по лицензии BSD.

+Требования:
+-Mysql & PHP5
+-Созданое подключение к MySQL и запущеная сессия =)

(c)2016 Ivan Kapitan
*/

##Определяем константы
define('USERS_TABLE','users');
define('SID',session_id());
define("SESSION_LIFE_TIME", 5400);
##Определяем функции
//Функция выхода.
//Пользователь считается авторизированым, если в сессии присутствует uid
//см. "Действия - если пользователь авторизирован".
function logout() {
	unset($_SESSION['uid']);	//Удаляем из сессии ID пользователя
    setcookie ("sid", '', time());
    die(header('Location: index.php'));
}

//Функция входа.
//Все выбраные поля записываются в сессию.
//Таким образом, при каждом просмотре страницы не надо выбирать их заново.
//Для обновления информации из БД можно пользоваться этой же функцией - имя и пароль
//хранятся в сессиях
function login($username,$password, $conn)    {
    $result = mysqli_query($conn, "SELECT * FROM `".USERS_TABLE."` WHERE `username`='$username' AND `password`='$password';")
        or die(mysqli_connect_error());
    $USER = mysqli_fetch_array($result,1); //Генерирует удобный массив из результата запроса
    if(!empty($USER)) { //Если массив не пустой (это значит, что пара имя/пароль верная)
        $_SESSION = array_merge($_SESSION,$USER); //Добавляем массив с пользователем к массиву сессии
        setcookie ("sid", SID, time()+SESSION_LIFE_TIME);
        
        mysqli_query($conn, "UPDATE `".USERS_TABLE."` SET `sid`='".SID."' WHERE `uid`='".$USER['uid']."';")
            or die(mysqli_connect_error());
        return true;
    }
    else {
        return false;
    }
}
//  
function updateSessionLifeTime() {
    if (isset($_COOKIE['sid'])){
        setcookie ("sid", SID, time()+SESSION_LIFE_TIME);
    }
}

//Функция проверки залогинности пользователя.
//При входе, ID сессии записывается в БД.
//Если ID текущей сессии и SID из БД не совпадают, производится logout.
//Благородя этому нельзя одновременно работать под одним ником с разных браузеров.
function check_user($uid, $conn) {
    $result = mysqli_query($conn, "SELECT `sid` FROM `".USERS_TABLE."` WHERE `uid`='$uid';") or die(mysqli_connect_error());
    $sid = array_values($result->fetch_array(MYSQLI_ASSOC))[0];
    
    $notExparedSession = ($_COOKIE["sid"] == SID);
    
    return ($sid==SID && $notExparedSession) ? true : false;
}
function admin_permissions($uid, $conn) {
    updateSessionLifeTime();

    $result = mysqli_query($conn, "SELECT `sid`, `permissions` FROM `".USERS_TABLE."` WHERE `uid`='$uid';") or die(mysqli_connect_error());
    $data = mysqli_fetch_array($result,1);
    $sid = $data["sid"];
    $userPermissions = $data["permissions"];

    return ($sid==SID && $userPermissions == 'admin') ? true : false;
}


##Действия - если пользователь авторизирован
if(isset($_SESSION['uid'])) { //Если была произведена авторизация, то в сессии есть uid

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

##Действия при попытке входа
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
        die("<div style='margin: auto; width: 350px;'><h3>Неправильний логін або пароль!</h3></div>");
    }
    
}

##Действия при попытке выхода
if(isset($_GET['logout'])) {
    logout();
}

##Действия при попытке регистрации
if(isset($_GET['register'])) {
   if ( USER_LOGGED && admin_permissions($UserID, $conn) ) {
        header("Location: register.php");
   } else {
        header("Location: main.php");
   }
}

##
if(isset($_GET['main'])) {
    header("Location: main.php");
}
?>