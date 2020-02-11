<?php
try {
  require_once('../pdo.php');
  $pro_no = $_POST['pro_no'];
  $sql = 'select * from `card` where pro_no = :pro_no';
  $cardRes = $pdo->prepare($sql);
  $cardRes->bindParam('pro_no', $pro_no);
  $cardRes->execute();
  $data = [];
  if($cardRes->rowCount()){
    $cards = $cardRes->fetchAll(PDO::FETCH_ASSOC);
    $cardInfo = [];
    foreach($cards as $card){
      $sql = "select p.mem_no, m.mem_name, m.mem_id, headshot 
      from `person_in_charge` p
      JOIN `member` m on m.mem_no = p.mem_no
      WHERE card_no = {$card['card_no']}";
      $cardMemberRes = $pdo->prepare($sql);
      $cardMemberRes->execute();
      $cardMember = [];
      if($cardMemberRes->rowCount()){
        $cardMember = $cardMemberRes->fetchAll(PDO::FETCH_ASSOC);
      }

      $cardInfo[] = [
        'id'=>$card['card_no'],
        'status'=>$card['card_sta'] ? true : false,
        'title'=>$card['card_name'],
        'deadLine'=>$card['card_date'],
        'type'=>$card['card_type'],
        'files'=>[],
        'content'=>[],
        'cardMember'=>$cardMember
      ];
    }
    $sql = 'select * from `card_file` where pro_no = :pro_no';
    $fileRes = $pdo->prepare($sql);
    $fileRes->bindParam('pro_no', $pro_no);
    $fileRes->execute();
    if($fileRes->rowCount()){
      $files = $fileRes->fetchAll(PDO::FETCH_ASSOC);
      foreach($files as $file){
        $cardIndex = array_search($file['card_no'], array_column($cardInfo, 'id'));
        $cardInfo[$cardIndex]['files'][] = [
          'id'=>$file['file_no'],
          'name'=>$file['file_name'],
          'src'=>$file['file_src']
        ];
      }
    }
    $sql = 'select * from `todo` where pro_no = :pro_no';
    $todoRes = $pdo->prepare($sql);
    $todoRes->bindParam('pro_no', $pro_no);
    $todoRes->execute();
    if($todoRes->rowCount()){
      $todos = $todoRes->fetchAll(PDO::FETCH_ASSOC);
      foreach($todos as $todo){
        $cardIndex = array_search($todo['card_no'], array_column($cardInfo, 'id'));
        $cardInfo[$cardIndex]['content'][] = [
          'id'=>$todo['todo_no'],
          'title'=>$todo['todo_title'],
          'lists'=>[]
        ];
      }
    }
    $sql = 'select * from `todo_content` where pro_no = :pro_no';
    $todoContentRes = $pdo->prepare($sql);
    $todoContentRes->bindParam('pro_no', $pro_no);
    $todoContentRes->execute();
    if($todoContentRes->rowCount()){
      $todoContents = $todoContentRes->fetchAll(PDO::FETCH_ASSOC);
      foreach($todoContents as $todoContent){
        $cardIndex = array_search($todoContent['card_no'], array_column($cardInfo, 'id'));
        $contentIndex = array_search($todoContent['todo_no'], array_column($cardInfo[$cardIndex]['content'], 'id'));
        $cardInfo[$cardIndex]['content'][$contentIndex]['lists'][] = [
          'id'=>$todoContent['todo_cont_no'],
          'content'=>$todoContent['todo_cont'],
          'isClock'=>$todoContent['todo_cont_clock'] ? true : false,
          'status'=>$todoContent['todo_cont_sta'] ? true : false,
          'timer'=>$todoContent['todo_timer']
        ];
      }
    }

    $step0 = [];
    $step1 = [];
    $step2 = [];
    foreach($cardInfo as $info){
      switch ($info['type']){
        case '0':
          $step0[] = $info;
          break;
        case '1':
          $step1[] = $info;
          break;
        default:
          $step2[] = $info;
      }
    }
    $data = [$step0, $step1, $step2];
  }
  echo json_encode(['status' => 'success', 'cards' => $data]);
} catch (PDOException $e) {
  echo $e->getLine();
  echo $e->getMessage();
}
