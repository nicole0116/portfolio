<?php
  try{
    require_once('../pdo.php');
    require('./PHPMailer-6.1.4/src/Exception.php');
    require('./PHPMailer-6.1.4/src/PHPMailer.php');
    require('./PHPMailer-6.1.4/src/SMTP.php');
    $jsonData = json_decode(file_get_contents('php://input'), true);
    $sql = 'select * from `member` where mem_id = :mem_id AND mem_email = :mem_email';
    $res = $pdo->prepare($sql);
    $res->bindParam('mem_id', $jsonData['mem_id']);
    $res->bindParam('mem_email', $jsonData['mem_email']);
    $res->execute();
    if($res->rowCount()){
      $member = $res->fetchObject();
      $mail = new PHPMailer\PHPMailer\PHPMailer();
      $mail->IsSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;
      $mail->IsHTML(true);
      $mail->Username = "ccpopocket@gmail.com";
      $mail->Password = "masterpocketdd104g3";
      $mail->CharSet = "utf-8";
      $mail->Encoding = "base64";
      $mail->SetFrom("ccpopocket@gmail.com");
      $mail->Subject = "Master Pocket Password";
      $mail->Body = " 
      親愛的會員 : $member->mem_id 你好, <br\>
      以下是你於本網站所申請之密碼 : <br\>
      $member->mem_psw <br\>
      請妥善保管，非常感謝您的使用。";
      $mail->AddAddress("{$member->mem_email}");
      if(!$mail->Send()) {
        echo json_encode(['status'=>'error', 'content'=>$mail->ErrorInfo]);
      } else {
        echo json_encode(['status'=>'success', 'content'=>'寄信成功! 請至信箱查收']);
      }
    }else {
      echo json_encode(['status'=>'error', 'content'=>'查無此使用者信箱']);
    }
  }catch(PDOException $e){
    echo $e->getLine();
    echo $e->getMessage();
  }