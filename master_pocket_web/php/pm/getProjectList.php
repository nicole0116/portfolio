<?php
  try{
    require_once('../pdo.php');
    $sql = 'select * FROM `join_program` j JOIN `program` p 
    on (j.pro_no = p.pro_no)
    where j.mem_no = :mem_no AND pro_mem_inv = 1 AND pro_sta = 0';
    $res = $pdo->prepare($sql);
    $res->bindParam(':mem_no', $_POST['mem_no']);
    $res->execute();
    if($res->rowCount() !== 0){
      $projects = $res->fetchAll(PDO::FETCH_ASSOC);
      $info = array();
      foreach($projects as $project){
        $sql = "select j.mem_no, m.mem_name, m.mem_id, headshot from `join_program` j
        JOIN `member` m on m.mem_no = j.mem_no AND pro_mem_inv = 1
        where pro_no = {$project['pro_no']}";
        $memberRes = $pdo->prepare($sql);
        $memberRes->execute();
        if($memberRes->rowCount() !== 0){
          $members = $memberRes->fetchAll(PDO::FETCH_ASSOC);
          // $memberList = [];
          // foreach($members as $member){
          //   $memberList[] = [
          //     'headshot'=>$member['headshot'],
          //     'mem_id'=>$member['mem_id'],
          //     'mem_no'=>$member['mem_no'],
          //     'mem_name'=>$member['mem_name'],
          //     'status'=>false
          //   ];
          // }
        }
        $info[] = [
          'id'=>$project['pro_no'],
          'memberList'=>$members,
          'info'=>array(
            'title'=>$project['pro_title'],
            'color'=>$project['pro_col']
          ),
          'list'=>array(
            array(
              'status'=>'待辦事項',
              'todo'=>array()
            ),
            array(
              'status'=>'進行中',
              'todo'=>array()
            ),
            array(
              'status'=>'已完成',
              'todo'=>array()
            )
          )
        ];
      }
      echo json_encode(['status'=>'success', 'data'=>$info]);
    }else{
      echo json_encode(['status'=>'error', 'content'=>'沒有資料']);
    }
  }catch(PDOException $e){
    echo $e->getLine();
    echo $e->getMessage();
  }