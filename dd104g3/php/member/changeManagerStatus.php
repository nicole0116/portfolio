<?php
try {
  require_once('../pdo.php');
  $sql = "update `manager` set mgr_sta = :mgr_sta where mgr_no = :mgr_no";
  $res = $pdo->prepare($sql);
  $res->bindParam('mgr_no', $_POST['mgr_no']);
  $res->bindParam('mgr_sta', $_POST['mgr_sta']);
  $res->execute();
  echo json_encode(['status'=>'success', 'content'=>'修改成功']);
} catch (PDOException $e) {
  echo $e->getLine();
  echo $e->getMessage();
}