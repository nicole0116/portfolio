<?php
try {
  require_once('../pdo.php');
  $sql = "update `todo_content` 
  set todo_cont_sta = :todo_cont_sta
  where todo_cont_no = :todo_cont_no";
  $res = $pdo->prepare($sql);
  $res->bindParam('todo_cont_sta', $_POST['todo_cont_sta']);
//   $res->bindParam('todo_cont_clock', $_POST['todo_cont_clock']);
  $res->bindParam('todo_cont_no', $_POST['todo_cont_no']);
  $res->execute();
  echo json_encode(['status' => 'success', 'content' => '更新成功']);
} catch (PDOException $e) {
  echo $e->getLine();
  echo $e->getMessage();
}
