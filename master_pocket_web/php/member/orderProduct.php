<?php
try {
  require_once('../pdo.php');
    $sql = 'select * from `order_item` where order_no	= :order_no';
    $res = $pdo->prepare($sql);
    $res->bindParam(':order_no', $_POST['order_no']);
    $res->execute();
    if($res->rowCount()){
      $products = $res->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode(['status'=>"success", 'data'=>$products]);
    }else {
      echo json_encode(['status'=>"error", 'content'=>'查無資料']);
    }
} catch (PDOException $e) {
  echo $e->getLine();
  echo $e->getMessage();
}
