
<?php
try {
  require_once('../pdo.php');

  $sql = "insert into `orders` (`product_price`,`mem_no`,`cret_date`,`ship_addr`,`receiver_name`,`receiver_tel`,`order_sta`) values (:product_price,:mem_no, NOW(),:ship_addr,:receiver_name,:receiver_tel,1)";
  $cart = $pdo->prepare($sql);
  $cart->bindValue(":product_price", $_REQUEST["product_price"]);
  $cart->bindValue(":mem_no", $_REQUEST["mem_no"]);
  $cart->bindValue(":ship_addr", $_REQUEST["ship_addr"]);
  $cart->bindValue(":receiver_name", $_REQUEST["receiver_name"]);
  $cart->bindValue(":receiver_tel", $_REQUEST["receiver_tel"]);
  $cart->execute();
  $lastId = $pdo->lastInsertId();
  echo $lastId;
  
} catch (PDOException $e) {
  echo $e->getMessage();
}
?>