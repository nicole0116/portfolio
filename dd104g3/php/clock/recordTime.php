<?php
try {
  require_once('../pdo.php');
  $sql = "update `todo_content` set todo_timer =:timer where todo_cont_no = :todo_cont_no";
  $res = $pdo->prepare($sql);
  $res->bindParam('timer', $_POST['timer']);
  $res->bindParam('todo_cont_no', $_POST['todo_cont_no']);
  $res->execute();
  echo json_encode(['status' => 'success', 'content' => '更新成功']);
} catch (PDOException $e) {
  echo $e->getLine();
  echo $e->getMessage();
}
