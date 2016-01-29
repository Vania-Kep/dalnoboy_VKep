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
        die("<div class='register-info'><h3>$ress_fillAllData</h3></div><div class='loader-bg'></div>");
    } else if (mysqli_num_rows($result) > 0) {
        header('Refresh: 5;');
        die("<div class='register-info'><h3>$ress_error_loginUsed</br>$ress_chooseAnotherLogin</h3></div><div class='loader-bg'></div>");
    } else if ( $newUserPass != $newUserRePass ) {
        header('Refresh: 5;');
        die("<div class='register-info'><h3>$ress_error_passwordsDontMatch</h3></div><div class='loader-bg'></div>");
    } else {
        $newUserPermissions = mysqli_real_escape_string($conn, $_POST['new-user-permissions']);
        registrate($conn, $newUser, $newUserPass, $newUserPermissions);
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


 
if (isset($_POST['remove']) && isset($_POST['getUsr'])) {
    $userId = $_POST['getUsr'];
    $userId = str_replace("usr", '', $userId);
    mysqli_query($conn, "DELETE FROM `users` WHERE `users`.`uid` = $userId") or die("$ress_error_userDoesntRemoved");
}
?>