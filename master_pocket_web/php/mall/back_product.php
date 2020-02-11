<?php
try{
  require_once("../pdo.php");
  $sql = "select * from `mall_product`";

  $product = $pdo->prepare($sql);
  $product->execute();
  $productRows = $product->fetchAll(PDO::FETCH_ASSOC);

  // echo  $productRow;
  echo json_encode($productRows);
  
}catch(PDOException $e){
  echo "例外行號 : ", $e->getLine(), "<br>";
  echo "例外原因 : ", $e->getMessage(), "<br>";

}
?>


