<?php
try {
  require_once('../pdo.php');
  $jsonData = json_decode(file_get_contents('php://input'), true);
  $pro_no = $jsonData['projectId'];
  $data = $jsonData['card'];
  $cardDate = $data['deadLine'] == '未設定' ? null : $data['deadLine'];
  $cardStatus = $data['status'] ? '1' : '0';
  $sql = 'insert into `card` 
    (pro_no, card_name, card_date, card_sta) values 
    (:pro_no, :card_name, :card_date, :card_sta)';
  $res = $pdo->prepare($sql);
  $res->bindParam(':pro_no', $pro_no);
  $res->bindParam(':card_name', $data['title']);
  $res->bindParam(':card_date', $cardDate);
  $res->bindParam(':card_sta', $cardStatus);
  $res->execute();
  $lastCardId = $pdo->lastInsertId();
  if ($data['content']) {
    foreach ($data['content'] as $info) {
      $sql = 'insert into `todo` 
        (card_no, pro_no, todo_title) values
        (:card_no, :pro_no, :todo_title)';
      $res = $pdo->prepare($sql);
      $res->bindParam(':card_no', $lastCardId);
      $res->bindParam(':pro_no', $pro_no);
      $res->bindParam(':todo_title', $info['title']);
      $res->execute();
      $lastId = $pdo->lastInsertId();
      if ($info['lists']) {
        foreach ($info['lists'] as $list) {
          $listStatus = $list['status'] ? '1' : '0';
          $isClock = $list['isClock'] ? '1' : '0';
          $sql = 'insert into `todo_content` 
            (todo_no, pro_no, card_no, todo_cont, todo_cont_sta, todo_cont_clock) values 
            (:todo_no, :pro_no, :card_no, :todo_cont, :todo_cont_sta, :todo_cont_clock)';
          $res = $pdo->prepare($sql);
          $res->bindParam(':todo_no', $lastId);
          $res->bindParam(':pro_no', $pro_no);
          $res->bindParam(':card_no', $lastCardId);
          $res->bindParam(':todo_cont', $list['content']);
          $res->bindParam(':todo_cont_sta', $listStatus);
          $res->bindParam(':todo_cont_clock', $isClock);
          $res->execute();
        }
      }
    }
  }
  echo json_encode(['status' => 'success', 'content' => '新建成功', 'data'=>$lastCardId]);
} catch (PDOException $e) {
  echo $e->getLine();
  echo $e->getMessage();
}
