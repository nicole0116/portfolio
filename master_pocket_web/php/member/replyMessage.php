<?php
  try{
    require_once('../pdo.php');
    $reply = $_POST['reply'] === 'true' ? '1' : '0';
    $sql = 'update `join_program`
    set pro_mem_inv = :reply, inv_sta = 1
    where mem_no = :mem_no AND pro_no = :pro_no';
    $res = $pdo->prepare($sql);
    $res->bindParam('reply', $reply);
    $res->bindParam('mem_no', $_POST['mem_no']);
    $res->bindParam('pro_no', $_POST['pro_no']);
    $res->execute();
    echo json_encode(['status'=>'success', 'content'=>'修改成功']);
  }catch(PDOException $e){
    echo $e->getLine();
    echo $e->getMessage();
  }