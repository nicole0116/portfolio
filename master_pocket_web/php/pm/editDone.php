<?php
try {
  require_once('../pdo.php');
  $jsonData = json_decode(file_get_contents('php://input'), true);
  $pro_no = $jsonData['projectId'];
  $card_type = $jsonData['step'];
  $data = $jsonData['card'];
  $sql = "delete FROM `card` WHERE card_no = :card_no";
  $res = $pdo->prepare($sql);
  $res->bindParam('card_no', $data['id']);
  $res->execute();

  $cardDate = $data['deadLine'] == '未設定' ? null : $data['deadLine'];
  $cardStatus = $data['status'] ? '1' : '0';
  $sql = 'insert into `card` 
    (pro_no, card_no,  card_name, card_type, card_date, card_sta) values 
    (:pro_no, :card_no, :card_name, :card_type, :card_date, :card_sta)';
  $res = $pdo->prepare($sql);
  $res->bindParam(':pro_no', $pro_no);
  $res->bindParam(':card_no', $data['id']);
  $res->bindParam(':card_name', $data['title']);
  $res->bindParam(':card_type', $card_type);
  $res->bindParam(':card_date', $cardDate);
  $res->bindParam(':card_sta', $cardStatus);
  $res->execute();
  if (isset($data['content'])) {
    foreach ($data['content'] as $info) {
      $sql = 'insert into `todo` 
        (card_no, pro_no, todo_title) values
        (:card_no, :pro_no, :todo_title)';
      $res = $pdo->prepare($sql);
      $res->bindParam(':card_no', $data['id']);
      $res->bindParam(':pro_no', $pro_no);
      $res->bindParam(':todo_title', $info['title']);
      $res->execute();
      if (isset($info['lists'])) {
        $lastId = $pdo->lastInsertId();
        foreach ($info['lists'] as $list) {
          $listStatus = $list['status'] ? '1' : '0';
          $isClock = $list['isClock'] ? '1' : '0';
          $sql = 'insert into `todo_content` 
            (todo_no, pro_no, card_no, todo_cont, todo_cont_sta, todo_timer, todo_cont_clock) values 
            (:todo_no, :pro_no, :card_no, :todo_cont, :todo_cont_sta, :todo_timer, :todo_cont_clock)';
          $res = $pdo->prepare($sql);
          $res->bindParam(':todo_no', $lastId);
          $res->bindParam(':pro_no', $pro_no);
          $res->bindParam(':card_no', $data['id']);
          $res->bindParam(':todo_cont', $list['content']);
          $res->bindParam(':todo_cont_sta', $listStatus);
          $res->bindParam(':todo_timer', $list['timer']);
          $res->bindParam(':todo_cont_clock', $isClock);
          $res->execute();
        }
      }
    }
  }
  if (isset($data['files'])){
    foreach ($data['files'] as $file){
      if(isset($file['type'])){
        $upload_dir = '../../pmFiles//';
        if(!file_exists($upload_dir)) mkdir($upload_dir);
  
        $fileData = $file['src'];
        $fileData = str_replace("data:{$file['type']};base64,", '', $fileData);
        $base64 = base64_decode($fileData);
        $nowDate = date('Ymd_Gis');
        $fileName = "$nowDate{$file['name']}";
        $uploadFile = $upload_dir . $fileName;
        
        file_put_contents($uploadFile, $base64);
      }
      $fileSrc = isset($fileName) ? "./pmFiles/".$fileName : $file['src'];
      $sql = 'insert into `card_file` 
        (card_no, pro_no, file_name, file_src) values
        (:card_no, :pro_no, :file_name, :file_src)';
      $res = $pdo->prepare($sql);
      $res->bindParam(':card_no', $data['id']);
      $res->bindParam(':pro_no', $pro_no);
      $res->bindParam(':file_name', $file['name']);
      $res->bindParam(':file_src', $fileSrc);
      $res->execute();
    }
  }
  if(isset($data['cardMember'])){
    foreach ($data['cardMember'] as $member){
      $sql = 'insert into `person_in_charge` 
        (mem_no, card_no) values
        (:mem_no, :card_no)';
      $res = $pdo->prepare($sql);
      $res->bindParam(':mem_no', $member['mem_no']);
      $res->bindParam(':card_no', $data['id']);
      $res->execute();
    }
  }
  echo json_encode(['status' => 'success', 'content' => '編輯完成']);
} catch (PDOException $e) {
  echo $e->getLine();
  echo $e->getMessage();
}
