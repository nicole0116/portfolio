<?php
  try{
    require_once('../pdo.php');
    $memNo = $_POST['mem_no'];
    $sql = 'insert into `program` (mem_no,  pro_col, pro_title) values (:mem_no, :pro_col, :pro_title)';
    $res = $pdo->prepare($sql);
    $res->bindParam(':mem_no', $memNo);
    $res->bindParam(':pro_col', $_POST['pro_col']);
    $res->bindParam(':pro_title', $_POST['pro_title']);
    $res->execute();
    $lastId = $pdo->lastInsertId();
    $sql = "insert into `join_program` 
    (mem_no, inv_by_mem, pro_no, pro_mem_inv) 
    values ($memNo, $memNo, $lastId, 1)";
    $res = $pdo->prepare($sql);
    $res->execute();
    echo json_encode(['status'=>'success', 'content'=>'新建成功', 'data'=>$lastId]);
  }catch(PDOException $e){
    echo $e->getLine();
    echo $e->getMessage();
  }