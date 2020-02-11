<?php
  try{
    require_once('../pdo.php');
    $sql = "select * from `member` where mem_id = :invite_id";
    $res = $pdo->prepare($sql);
    $res->bindParam('invite_id', $_POST['invite_id']);
    $res->execute();
    if($res->rowCount()){
      $member = $res->fetchObject();
      $sql = "insert into `join_program` (mem_no, inv_by_mem, pro_no, inv_sta)
      values ({$member->mem_no}, :inv_by_mem, :pro_no, 0)
      ON DUPLICATE KEY UPDATE inv_sta = 0, inv_by_mem = :inv_by_mem";
      $inviteRes = $pdo->prepare($sql);
      $inviteRes->bindParam('inv_by_mem', $_POST['mem_no']);
      $inviteRes->bindParam('pro_no', $_POST['pro_no']);
      $inviteRes->execute();
      echo json_encode(['status'=>'success', 'content'=>'邀請成功']);
    }else {
      echo json_encode(['status'=>'error', 'content'=>'查無此會員']);
    }
  }catch(PDOException $e){
    echo $e->getLine();
    echo $e->getMessage();
  }
?>

