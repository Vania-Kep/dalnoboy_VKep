<?php
$mysql_host = "mysql12.000webhost.com";
$mysql_username = "a5080943_dbVKep";
$mysql_userPass = "dalnoboyVKep2016";
$mysql_databaseName = "a5080943_dalnob"; 

session_start();
//$conn = mysqli_connect('localhost','root','','dalekoboi_test') or die(mysqli_connect_error());
$conn = mysqli_connect($mysql_host, $mysql_username, $mysql_userPass, $mysql_databaseName) or die(mysqli_connect_error());
mysqli_select_db($conn, $mysql_databaseName) or die(mysqli_connect_error());
mysqli_query($conn, 'SET NAMES utf8');
$conn->set_charset("utf8");
?>