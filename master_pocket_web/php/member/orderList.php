<?php
try {
  require_once('../pdo.php');
    $sql = 'select order_no, cret_date, atr_date, cel_date
    FROM `orders` 
    where mem_no = :mem_no AND order_sta != 4';
    $res = $pdo->prepare($sql);
    $res->bindParam(':mem_no', $_POST['mem_no']);
    $res->execute();
    if($res->rowCount()){
      $list = $res->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode(['status'=>"success", 'data'=>$list]);
    }else {
      echo json_encode(['status'=>"error", 'content'=>'查無資料']);
    }
} catch (PDOException $e) {
  echo $e->getLine();
  echo $e->getMessage();
}
