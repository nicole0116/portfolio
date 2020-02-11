<?php
try {
  require_once('../pdo.php');
  $sql = "select * from `member`";
  $res = $pdo->prepare($sql);
  $res->execute();
  if($res->rowCount()){
    $members = $res->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['status'=>'success', 'data'=>$members], JSON_NUMERIC_CHECK);
  }else {
    echo json_encode(['status'=>'error', 'content'=>'查無資料']);
  }
} catch (PDOException $e) {
  echo $e->getLine();
  echo $e->getMessage();
}