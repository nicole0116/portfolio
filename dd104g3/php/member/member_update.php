<?php
  try{
    require_once('../pdo.php');
    $memNo = $_POST['mem_no'];
    $memName = $_POST['mem_name'] ? $_POST['mem_name'] : null;
    $memTel = $_POST['mem_tel'] ? $_POST['mem_tel'] : null;
    $memAddr = $_POST['mem_addr'] ? $_POST['mem_addr'] : null;
    $memEmail = $_POST['mem_email'] ? $_POST['mem_email'] : null;
    $headShot = $_POST['headshot'] !== 'null' ? $_POST['headshot'] : false;
    if(isset($_POST['file_type']) && (
      $_POST['file_ext'] === 'jpg' || $_POST['file_ext'] === 'jpeg' ||
      $_POST['file_ext'] === 'gif' || $_POST['file_ext'] === 'png' ||
      $_POST['file_ext'] === 'svg'
    )){
      $upload_dir = '../../userImg//';
      if(!file_exists($upload_dir)) mkdir($upload_dir);

      $headShot = str_replace("data:{$_POST['file_type']};base64,", '', $headShot);
      $base64 = base64_decode($headShot);
      $nowDate = date('Ymd_Gis');
      $imgName = "$nowDate{$_POST['mem_id']}" . ".{$_POST['file_ext']}";
      $uploadImg = $upload_dir . $imgName;
      
      file_put_contents($uploadImg, $base64);
    }
    $imgName = isset($imgName) ? $imgName : $headShot;
    $sql = 'update `member` 
    set mem_name = :mem_name, mem_tel = :mem_tel, mem_addr = :mem_addr, mem_email = :mem_email, headshot = :headshot
    where mem_no = :mem_no';
    $res = $pdo->prepare($sql);
    $res->bindParam('mem_name', $memName);
    $res->bindParam('mem_tel', $memTel);
    $res->bindParam('mem_addr', $memAddr);
    $res->bindParam('mem_no', $memNo);
    $res->bindParam('mem_email', $memEmail);
    $res->bindParam('headshot', $imgName);
    $res->execute();

    $sql = "select * from `member` where mem_no = $memNo";
    $res = $pdo->prepare($sql);
    $res->execute();
    if($res->rowCount()){
      $member = $res->fetchObject();
      session_start();
      foreach($member as $key=>$info){
        $_SESSION[$key] = $info;
      }
    }

    
    echo json_encode(['status'=>'success', 'content'=>'修改成功']);
  }catch(PDOException $e){
    echo $e->getLine();
    echo $e->getMessage();
  }