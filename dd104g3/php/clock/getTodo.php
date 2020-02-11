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
        // 'todoContentId'=>$list['todo_cont_no'],
          'id'=>$list['todo_cont_no'],
          'title'=>$list['todo_cont'],
          'runstatus'=>0,
          'currentTime'=>0,
          'totalTime'=>$list['todo_timer'],
          'complete'=>$list['todo_cont_sta'] ? true : false,
          'isClock'=>$list['todo_cont_clock'] ? true : false,
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
