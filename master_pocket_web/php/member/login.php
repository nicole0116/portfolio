<?php
  try{
    require_once('../pdo.php');
    $jsonData = json_decode(file_get_contents('php://input'), true);
    $sql = 'select * from `member` where mem_id = :mem_id && mem_psw = :mem_psw';
    $res = $pdo->prepare($sql);
    $res->bindParam(':mem_id', $jsonData['mem_id']);
    $res->bindParam(':mem_psw', $jsonData['mem_psw']);
    $res->execute();

    if($res->rowCount()){
      $member = $res->fetchObject();
      if(!$member->mem_status){
        echo json_encode(['status'=>'error', 'content'=>'此帳號以遭停權']);
        exit();
      }
      echo json_encode([
        'status'=>'success', 
        'content'=>'登入成功', 
        'data'=>$member
      ]);
      session_start();
      foreach($member as $key=>$info){
        $_SESSION[$key] = $info;
      }
    }else {
      echo json_encode(['status'=>'error', 'content'=>'帳號或密碼錯誤']);
    }
  }catch(PDOException $e){
    echo $e->getLine();
    echo $e->getMessage();
  }