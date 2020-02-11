<?php
  try{
    require_once('../pdo.php');
    $mgrId = $_POST['mgr_id'];
    $sql = 'select * from `manager` where mgr_id = :mgr_id';
    $check = $pdo->prepare($sql);
    $check->bindParam(':mgr_id', $mgrId);
    $check->execute();
    if($check->rowCount())echo json_encode(['status'=>'error', 'content'=>'帳號已使用']);
    else {
      $sql = 'insert into `manager` (mgr_id, mgr_psw) values (:mgr_id, :mgr_psw)';
      $res = $pdo->prepare($sql);
      $res->bindParam(':mgr_id', $mgrId);
      $res->bindParam(':mgr_psw', $_POST['mgr_psw']);
      $res->execute();
      echo json_encode(['status'=>'success', 'content'=>'新增成功']);
    }
  }catch(PDOException $e){
    echo $e->getLine();
    echo $e->getMessage();
  }