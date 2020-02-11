<?php
try {
  require_once('../pdo.php');
  $sql = "select * from `manager`";
  $res = $pdo->prepare($sql);
  $res->execute();
  if($res->rowCount()){
    $manager = $res->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['status'=>'success', 'data'=>$manager], JSON_NUMERIC_CHECK);
  }else {
    echo json_encode(['status'=>'error', 'content'=>'查無資料']);
  }
} catch (PDOException $e) {
  echo $e->getLine();
  echo $e->getMessage();
}