<?php
try {
  require_once('../pdo.php');
  $sql = "update `member` set ring_no =:ring_no where mem_no = :mem_no";
  $res = $pdo->prepare($sql);
  $res->bindParam('mem_no', $_POST['mem_no']);
  $res->bindParam('ring_no', $_POST['ring_no']);
  $res->execute();
  session_start();
  $_SESSION['ring_no'] = $_POST['ring_no'];
  echo json_encode(['status' => 'success', 'content' => '更新成功']);
} catch (PDOException $e) {
  echo $e->getLine();
  echo $e->getMessage();
}