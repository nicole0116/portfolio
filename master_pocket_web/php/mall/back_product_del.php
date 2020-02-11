<?php

$errMsg = "";
//連線資料庫
try {
  require_once("../pdo.php");

  $sql = "DELETE FROM  `mall_product` WHERE product_no = :product_no";
  $product = $pdo->prepare($sql);
  $product->bindValue(":product_no", $_REQUEST["product_no"]);
  $product->execute();
  echo "<script> {window.alert(' 刪除成功');location.href='../../back.html'} </script>";
  
} catch (PDOException $e) {
  $errMsg .= "錯誤原因 : " . $e->getMessage() . "<br>";
  $errMsg .= "錯誤行號 : " . $e->getLine() . "<br>";
}

?>