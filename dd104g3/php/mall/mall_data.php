<?php
try{
  require_once("../pdo.php");
  $sql = "select * from `mall_product` where product_type=:product_type and product_on = 1";
  $product = $pdo->prepare($sql);
  $product->bindValue(":product_type", $_POST["product_type"]);
  // $product->bindValue(":product_num", $_GET["product_num"]);
  $product->execute();
  if( $product->rowCount() == 0 ){ //找不到
    //傳回空的JSON字串
    echo json_encode(['status'=>'error', 'content'=>"查無資料"]);
  }else{ //找得到
    //取回一筆資料
    $productRow = $product->fetchAll(PDO::FETCH_ASSOC);
    // $memRow = $member->fetchObject();  //$memRow->memName
    //送出json字串
    echo json_encode(['status'=>'success', 'data'=>$productRow]);
  }	
  
}catch(PDOException $e){
  echo $e->getMessage();
}
?>