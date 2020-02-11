<?php
  try{
    require_once('../pdo.php');
    $jsonData = json_decode(file_get_contents('php://input'), true);
    $memId = $jsonData['mem_id'];
    $sql = 'select * from `member` where mem_id = :mem_id';
    $check = $pdo->prepare($sql);
    $check->bindParam(':mem_id', $memId);
    $check->execute();
    if($check->rowCount())echo json_encode(['status'=>'error', 'content'=>'帳號已使用']);
    else {
      $headShot = isset($jsonData['headshot']) ? $jsonData['headshot'] : false;
      if($headShot && (
        $jsonData['file_ext'] === 'jpg' || $jsonData['file_ext'] === 'jpeg' ||
        $jsonData['file_ext'] === 'gif' || $jsonData['file_ext'] === 'png' ||
        $jsonData['file_ext'] === 'svg'
      )){
        $upload_dir = '../../userImg//';
        if(!file_exists($upload_dir)) mkdir($upload_dir);
        
        $headShot = str_replace("data:{$jsonData['file_type']};base64,", '', $headShot);
        $base64 = base64_decode($headShot);
        $nowDate = date('Ymd_Gis');
        $imgName = "$nowDate$memId" . ".{$jsonData['file_ext']}";
        $uploadImg = $upload_dir . $imgName;
        
        file_put_contents($uploadImg, $base64);
      }
      $sql = 'insert into `member` (mem_id, mem_psw, mem_email, headshot) values (:mem_id, :mem_psw, :mem_email, :headshot)';
      $res = $pdo->prepare($sql);
      $res->bindParam(':mem_id', $memId);
      $res->bindParam(':mem_psw', $jsonData['mem_psw']);
      $res->bindParam(':mem_email', $jsonData['mem_email']);
      $res->bindParam(':headshot', $imgName);
      $res->execute();
      echo json_encode(['status'=>'success', 'content'=>'註冊成功']);
    }
  }catch(PDOException $e){
    echo $e->getLine();
    echo $e->getMessage();
  }