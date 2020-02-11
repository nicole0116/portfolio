<?php
  try{
    require_once('../pdo.php');
    $sql = 'select j.pro_no, m.mem_id, m.mem_name, m.headshot, p.pro_title from `join_program` j
    JOIN `member` m on m.mem_no = j.inv_by_mem
    JOIN `program` p on p.pro_no = j.pro_no
    WHERE j.mem_no = :mem_no AND pro_mem_inv = 0 AND inv_sta = 0';
    $res = $pdo->prepare($sql);
    $res->bindParam('mem_no', $_POST['mem_no']);
    $res->execute();
    if($res->rowCount()){
      $message = $res->fetchAll(PDO::FETCH_ASSOC);
      $data = [];
      foreach($message as $info){
        $data[] = [
          'inviteMemberId'=>$info['mem_id'],
          'inviteMemberName'=>$info['mem_name'],
          'inviteHeadShot'=>$info['headshot'],
          'inviteProjectId'=>$info['pro_no'],
          'inviteProject'=>$info['pro_title']
        ];
      }
      echo json_encode(['status'=>'success', 'data'=>$data]);
    }else {
      echo json_encode(['status'=>'error', 'content'=>'查無資料']);
    }
  }catch(PDOException $e){
    echo $e->getLine();
    echo $e->getMessage();
  }