<?php
try {
  require_once('../pdo.php');
  $sql = 'select * FROM `join_program` j 
  JOIN `program` p on (j.pro_no = p.pro_no)
  JOIN `todo_content` t on (p.pro_no = t.pro_no)
  where j.mem_no = :mem_no AND pro_mem_inv = 1 AND pro_sta = 0 AND t.todo_cont_clock = 1';
  $res = $pdo->prepare($sql);
  $res->bindParam('mem_no', $_POST['mem_no']);
  $res->execute();
  if($res->rowCount()){
    $clockList = $res->fetchAll(PDO::FETCH_ASSOC);
    foreach($clockList as $list){
      $data[] = [
        'color'=> $list['pro_col'],
        'todoId'=>$list['todo_no'],
        'todoContentId'=>$list['todo_cont_no'],
        'projectId'=>$list['pro_no'],
        'cardId'=>$list['card_no'],
        'info'=>[
          'content'=>$list['todo_cont'],
          'id'=>$list['todo_cont_no'],
          'isClock'=>$list['todo_cont_clock'] ? true : false,
          'status'=>$list['todo_cont_sta'] ? true : false,
          'timer'=>$list['todo_timer']
        ]
      ];
    }
    echo json_encode(['status' => 'success', 'data' => $data], JSON_NUMERIC_CHECK);
  }else {
    echo json_encode(['status' => 'error', 'content' => '沒有資料']);
  }
} catch (PDOException $e) {
  echo $e->getLine();
  echo $e->getMessage();
}
