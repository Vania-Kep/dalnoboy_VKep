<?php
session_start();
$conn = mysqli_connect('localhost','root','','dalekoboi_test') or die(mysqli_connect_error());
mysqli_select_db($conn, 'dalekoboi_test') or die(mysqli_connect_error());
mysqli_query($conn, 'SET NAMES utf8');
$conn->set_charset("utf8");
?>