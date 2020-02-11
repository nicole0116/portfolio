<?php 
  $dsn = "mysql:host=localhost;port=3306;dbname=dd104g3;charset=utf8";
  $user = "root";
  $password = "nicole0116";
  $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
  $pdo = new PDO($dsn, $user, $password, $options);
?>