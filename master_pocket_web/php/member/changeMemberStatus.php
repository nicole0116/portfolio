<?php
try {
  require_once('../pdo.php');
  $sql = "update `member` set mem_status = :mem_status where mem_no = :mem_no";
  $res = $pdo->prepare($sql);
  $res->bindParam('mem_no', $_POST['mem_no']);
  $res->bindParam('mem_status', $_POST['mem_status']);
  $res->execute();
  echo json_encode(['status'=>'success', 'content'=>'修改成功']);
} catch (PDOException $e) {
  echo $e->getLine();
  echo $e->getMessage();
}