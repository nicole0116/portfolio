<?php
  try {
    require_once('../pdo.php');
    $sql = "update `card` set card_type = :card_type 
    where card_no = :card_no";
    $res = $pdo->prepare($sql);
    $res->bindParam('card_type', $_POST['card_type']);
    $res->bindParam('card_no', $_POST['card_no']);
    $res->execute();
  
    echo json_encode(['status' => 'success', 'content' => '異動成功']);
  } catch (PDOException $e) {
    echo $e->getLine();
    echo $e->getMessage();
  }