<?php
try {

  require_once('../pdo.php');
  if ($_REQUEST["order_sta"] == '2') {
    $sql = "update `orders` set order_sta = :order_sta , atr_date = NOW() where order_no = :order_no;";
    $orderstatus = $pdo->prepare($sql);
    $orderstatus->bindValue(":order_no", $_REQUEST["order_no"]);
    $orderstatus->bindValue(":order_sta", $_REQUEST["order_sta"]);
    $orderstatus->execute();
  }elseif($_REQUEST["order_sta"] == '3'){
    $sql = "update `orders` set order_sta = :order_sta , cel_date = NOW() where order_no = :order_no;";
    $orderstatus = $pdo->prepare($sql);
    $orderstatus->bindValue(":order_no", $_REQUEST["order_no"]);
    $orderstatus->bindValue(":order_sta", $_REQUEST["order_sta"]);
    $orderstatus->execute();
  }
} catch (PDOException $e) {
  echo $e->getMessage();
}
