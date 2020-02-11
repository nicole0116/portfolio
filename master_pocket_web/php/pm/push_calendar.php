<?php
try {
  require_once('../pdo.php');
  session_start();
  switch ($_POST['type']) {
    case "push_calendar_cards":
      $cards_arr = [];
      $calendar_cards_arr = [];  //program_memeber
      $calendar_cards_data_arr = [];  //program_memeber
      $sql = " SELECT c.card_no, 
      c.pro_no, 
      c.card_name, 
      DATE_FORMAT(c.`card_date`, '%Y-%m-%d %H:%i') AS `card_date`, 
      c.card_type,
      c.card_sta,
      p.pro_col, 
      p.pro_sta, 
      tc.todo_cont_no, 
      tc.todo_cont_sta,
      jp.mem_no
FROM `card` c 
LEFT JOIN `program` p ON c.pro_no=p.pro_no 
LEFT JOIN `todo_content` tc ON tc.card_no=c.card_no 
LEFT JOIN `join_program` jp ON jp.pro_no=c.pro_no 
WHERE card_date is not null AND c.card_sta=0 AND p.pro_sta=0 and jp.mem_no=:mem_no
ORDER BY c.card_date, c.pro_no";
      $res = $pdo->prepare($sql);
      $res->bindValue(':mem_no', $_SESSION["mem_no"]);
      $res->execute();
      if ($res->rowCount()) {
        $calendar_cards = $res->fetchAll(PDO::FETCH_ASSOC);
        foreach ($calendar_cards as $key => $card) {
          $calendar_date_arr = explode(" ", $card["card_date"]);
          $calendar_date = $calendar_date_arr[0];
          if (isset($cards_arr[$card["card_no"]]) == FALSE) {
            $cards_arr[$card["card_no"]] = $key;
            if ($card["todo_cont_sta"] == 1) {
              $todo_cont_sta_checked = 1;
            } else {
              $todo_cont_sta_checked = 0;
            }
            if ($card["todo_cont_sta"] == null) {
              $todo_cont_sta_sum = 0;
            } else {
              $todo_cont_sta_sum = 1;
            }
            switch ($card["card_type"]) {
              case 0:
                $card_type = 'card_list_todo';
                break;
              case 1:
                $card_type = 'card_list_doing';
                break;
              case 2:
                $card_type = 'card_list_done';
                break;
            }
            $calendar_cards_arr[$calendar_date][$key] = [
              "card_name" => $card["card_name"],
              "card_date" => $card["card_date"],
              "pro_col" => $card["pro_col"],
              "pro_sta" => $card["pro_sta"],
              "pro_no" => $card["pro_no"],
              "card_no" => $card["card_no"],
              "card_type" => $card_type,
              "todo_cont_sta_checked" => $todo_cont_sta_checked,
              "todo_cont_sta_sum" => $todo_cont_sta_sum
            ];
          } else {
            if ($card["todo_cont_sta"] == 1) {
              $calendar_cards_arr[$calendar_date][$cards_arr[$card["card_no"]]]["todo_cont_sta_checked"] += 1;
            }
            if ($card["todo_cont_sta"] == null) {
              $todo_cont_sta_sum = 0;
            } else {
              $calendar_cards_arr[$calendar_date][$cards_arr[$card["card_no"]]]["todo_cont_sta_sum"] += 1;
            }
          }
          ksort($calendar_cards_arr[$calendar_date]);
        }
        $calendar_cards_data_arr = $calendar_cards_arr;
        foreach ($calendar_cards_arr as $calendar_date => $value) {
          $x = 0;
          $calendar_cards_data_arr[$calendar_date] = [];
          foreach ($value as $key => $value2) {
            $calendar_cards_data_arr[$calendar_date][$x] = $value2;
            $x++;
          }
        }
      }
      echo json_encode($calendar_cards_data_arr);
      break;
  }
} catch (PDOException $e) {
  echo $e->getLine();
  echo $e->getMessage();
}
