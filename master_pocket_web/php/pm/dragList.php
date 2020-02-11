<?php
  try {
    require_once('../pdo.php');
    $sql = "update `card` set card_type = :card_type 
    where pro_no = :pro_no and card_no = :card_no";
    $res = $pdo->prepare($sql);
    $res->bindParam('card_type', $_POST['step']);
    $res->bindParam('pro_no', $_POST['pro_no']);
    $res->bindParam('card_no', $_POST['card_no']);
    $res->execute();
    echo json_encode(['status' => 'success', 'content' => '更動完成']);
  } catch (PDOException $e) {
    echo $e->getLine();
    echo $e->getMessage();
  }