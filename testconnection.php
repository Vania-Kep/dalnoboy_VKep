<?php
  $link = mysqli_connect('localhost', 'dalekoboi_test', '1111', 'dalekoboi_test');
  if (!$link) {
      die('Невозможно соединиться: ' . mysqli_error());
  }
  echo 'Успешно соединено';
  mysqli_close($link);
?>