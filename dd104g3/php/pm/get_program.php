<?php
// session_start();
// $_SESSION['mem_no'] = 1;//test
try {
  require_once('../pdo.php');
  $step0_arr = array(); //card_list_todo
  $step1_arr = array(); //card_list_doing
  $step2_arr = array(); //card_list_done
  $step0 = array("cards" => array(), "type" => "card_list_todo"); //card_list_todo
  $step1 = array("cards" => array(), "type" => "card_list_doing"); //card_list_doing
  $step2 = array("cards" => array(), "type" => "card_list_done"); //card_list_done
  $sql = "select  c.card_no, 
                  c.pro_no, 
                  jp.pro_mem_no_string, 
                  card_name, 
                  pic.card_mem_no_string, 
                  DATE_FORMAT(`card_date`, '%Y-%m-%d %H:%i') AS `card_date`, 
                  card_type, 
                  card_sta, 
                  t.todo_no, 
                  todo_title, 
                  file_no, 
                  file_name, 
                  file_src, 
                  todo_cont_no, 
                  todo_cont, 
                  todo_cont_sta, 
                  todo_cont_clock, 
                  todo_timer 
          from `dd104g3`.`card` c
          LEFT JOIN `dd104g3`.`todo` t on c.pro_no = t.pro_no AND c.card_no = t.card_no 
          LEFT JOIN `dd104g3`.`card_file` f on f.pro_no = c.pro_no AND f.card_no = c.card_no 
          LEFT JOIN `dd104g3`.`todo_content` tc on tc.pro_no = c.pro_no AND tc.todo_no = t.todo_no 
          LEFT JOIN ( SELECT `join_program`.`pro_no`, 
                      GROUP_CONCAT(`join_program`.`mem_no`) AS 'pro_mem_no_string' 
                      FROM `dd104g3`.`join_program` 
                      WHERE `join_program`.`pro_mem_inv` = 1 
                      GROUP BY `join_program`.`pro_no`) jp 
          ON c.pro_no = jp.pro_no
          LEFT JOIN ( SELECT `person_in_charge`.`card_no`, 
                      GROUP_CONCAT(`person_in_charge`.`mem_no`) AS 'card_mem_no_string' 
                      FROM `dd104g3`.`person_in_charge` 
                      GROUP BY `person_in_charge`.`card_no`) pic 
          ON c.card_no = pic.card_no  
          WHERE c.pro_no = :pro_no
          order by c.card_no";
  $res = $pdo->prepare($sql);
  $res->bindParam(':pro_no', $_POST['pro_no']);
  $res->execute();
  if ($res->rowCount()) {
    $cards = $res->fetchAll(PDO::FETCH_ASSOC);
    $prevCardId = null;
    $prevTodoId = null;
    foreach ($cards as $card) {
      $todo_list_content_detail_arr = [];
      $filebox_arr = [];
      $dateline_text = '未完成';
      $calendar_date = '未設定';
      if($card['card_sta'] == 1) {
        $dateline_text = '完成';
      }
      if($card['card_date'] !== null) {
        $calendar_date = $card['card_date'];
      }else if($card['card_date'] == null){
        $calendar_date='未設定';
      }
      switch($card['card_type'])
      {
        case "0":
          if(isset($step0_arr[$card['card_no']]) == true)
          {
            if($card['todo_title'] != NULL)
            {
              $step0_arr[$card['card_no']]['todo_list_content_detail'][$card['todo_no']]['title'] = $card['todo_title'];
              $step0_arr[$card['card_no']]['todo_list_content_detail'][$card['todo_no']]['todo_no'] = $card['todo_no'];
              if($card['todo_cont'] != NULL)
              {
                (int)$card['todo_cont_sta'] == 0 ? $todo_cont_sta = false: $todo_cont_sta = true;
                (int)$card['todo_cont_clock'] == 0 ? $todo_cont_clock = false: $todo_cont_clock = true;
                $step0_arr[$card['card_no']]['todo_list_content_detail'][$card['todo_no']]['lists'][$card['todo_cont_no']] = array("todo_cont_no" => $card['todo_cont_no'], "content" => $card['todo_cont'], "status" => $todo_cont_sta, "text" => $todo_cont_sta, "tomato_color"=>$todo_cont_clock,"todo_cont_sta"=>'0');
              }else{
                $step0_arr[$card['card_no']]['todo_list_content_detail'][$card['todo_no']]['lists'] = array();
              }
              $step0_arr[$card['card_no']]['todo_list_content_detail'][$card['todo_no']]['showname'] = false;
              $step0_arr[$card['card_no']]['todo_list_content_detail'][$card['todo_no']]['test_title_name'] = true;
              $step0_arr[$card['card_no']]['todo_list_content_detail'][$card['todo_no']]['test'] = '';
            }
            if($card['file_name'] != NULL)
            {
              $pic=explode(".",$card['file_name'])[1];
              if ($pic == "jpg" || $pic == "png" || $pic == "gif" || $pic == "svg") {
                $pic = null;
              }
              $step0_arr[$card['card_no']]['filebox'][$card['file_no']] = array("file_no"=> $card['file_no'], "name"=> $card['file_name'], "source" => $card['file_src'],"title"=> $pic);
            }
          }else{
            if($card["pro_mem_no_string"] != NULL)
            {
              $pro_member_arr = explode(',',$card["pro_mem_no_string"]);
            }else{
              $pro_member_arr = array();
            }
            if($card["card_mem_no_string"] != NULL)
            {
              $card_member_arr = explode(',',$card["card_mem_no_string"]);
            }else{
              $card_member_arr = array();
            }
            if($card['todo_title'] != NULL)
            {
              $todo_list_content_detail_arr[$card['todo_no']]['title'] = $card['todo_title'];
              $todo_list_content_detail_arr[$card['todo_no']]['todo_no'] = $card['todo_no'];
              if($card['todo_cont'] != NULL)
              {
                (int)$card['todo_cont_sta'] == 0 ? $todo_cont_sta = false: $todo_cont_sta = true;
                (int)$card['todo_cont_clock'] == 0 ? $todo_cont_clock = false: $todo_cont_clock = true;
                $todo_list_content_detail_arr[$card['todo_no']]['lists'][0] = array("todo_cont_no" => $card['todo_cont_no'],"content" => $card['todo_cont'], "status" => $todo_cont_sta, "status" => $todo_cont_sta, "text" => $todo_cont_sta, "tomato_color" => $todo_cont_clock,"todo_cont_sta"=>'0');
              }else{
                $todo_list_content_detail_arr[$card['todo_no']]['lists'] = [];
              }
              $todo_list_content_detail_arr[$card['todo_no']]['showname'] = false;
              $todo_list_content_detail_arr[$card['todo_no']]['test_title_name'] = true;
              $todo_list_content_detail_arr[$card['todo_no']]['test'] = '';
            }else{
              $todo_list_content_detail_arr = [];
            }
            if($card['file_name'] != NULL)
            {
              $pic=explode(".",$card['file_name'])[1];
              if ($pic == "jpg" || $pic == "png" || $pic == "gif" || $pic == "svg") {
                $pic = null;
              }
              $filebox_arr[$card['file_no']]['file_no'] = $card['file_no'];
              $filebox_arr[$card['file_no']]['name'] = $card['file_name'];
              $filebox_arr[$card['file_no']]['source'] = $card['file_src'];
              $filebox_arr[$card['file_no']]['title'] =$pic;
            }else{
              $filebox_arr = [];
            }
            (int)$card['card_sta'] == 0 ? $card_sta = false: $card_sta = true;
            $step0_arr[$card['card_no']] = array("card_no"=> $card['card_no'], "card_name"=> trim($card['card_name']), "card_member" => $pro_member_arr, "showhideMember" => false, "member_input" => "", "member_inout" => [], "todo_list_content_detail" => $todo_list_content_detail_arr, "dateline" => $card_sta, "dateline_text" => $dateline_text, "calendar_date" => $calendar_date, "filebox" => $filebox_arr, "file_switch" => false);
          }
          ksort($step0_arr[$card['card_no']]['todo_list_content_detail']);
          if($card['todo_no'] != null)
          {
            ksort($step0_arr[$card['card_no']]['todo_list_content_detail'][$card['todo_no']]['lists']);
          }
          ksort($step0_arr[$card['card_no']]['filebox']);
          break;
        case "1":
          if(isset($step1_arr[$card['card_no']]) == true)
          {
            if($card['todo_title'] != NULL)
            {
              $step1_arr[$card['card_no']]['todo_list_content_detail'][$card['todo_no']]['title'] = $card['todo_title'];
              $step1_arr[$card['card_no']]['todo_list_content_detail'][$card['todo_no']]['todo_no'] = $card['todo_no'];
              if($card['todo_cont'] != NULL)
              {
                (int)$card['todo_cont_sta'] == 0 ? $todo_cont_sta = false: $todo_cont_sta = true;
                (int)$card['todo_cont_clock'] == 0 ? $todo_cont_clock = false: $todo_cont_clock = true;
                $step1_arr[$card['card_no']]['todo_list_content_detail'][$card['todo_no']]['lists'][$card['todo_cont_no']] = array("todo_cont_no" => $card['todo_cont_no'], "content" => $card['todo_cont'], "status" => $todo_cont_sta, "status" => $todo_cont_sta, "text" => $todo_cont_sta,"tomato_color"=>$todo_cont_clock);
              }else{
                $step1_arr[$card['card_no']]['todo_list_content_detail'][$card['todo_no']]['lists'] = array();
              }
              $step1_arr[$card['card_no']]['todo_list_content_detail'][$card['todo_no']]['showname'] = false;
              $step1_arr[$card['card_no']]['todo_list_content_detail'][$card['todo_no']]['test_title_name'] = true;
              $step1_arr[$card['card_no']]['todo_list_content_detail'][$card['todo_no']]['test'] = '';
            }
            if($card['file_name'] != NULL)
            {
              $pic=explode(".",$card['file_name'])[1];
              if ($pic == "jpg" || $pic == "png" || $pic == "gif" || $pic == "svg") {
                $pic = null;
              }
              $step1_arr[$card['card_no']]['filebox'][$card['file_no']] = array("file_no"=> $card['file_no'], "name"=> $card['file_name'], "source" => $card['file_src'],"title"=> $pic);

            }
          }else{
            if($card["pro_mem_no_string"] != NULL)
            {
              $pro_member_arr = explode(',',$card["pro_mem_no_string"]);
            }else{
              $pro_member_arr = array();
            }
            if($card["card_mem_no_string"] != NULL)
            {
              $card_member_arr = explode(',',$card["card_mem_no_string"]);
            }else{
              $card_member_arr = array();
            }
            if($card['todo_title'] != NULL)
            {
              $todo_list_content_detail_arr[$card['todo_no']]['title'] = $card['todo_title'];
              $todo_list_content_detail_arr[$card['todo_no']]['todo_no'] = $card['todo_no'];
              if($card['todo_cont'] != NULL)
              {
                (int)$card['todo_cont_sta'] == 0 ? $todo_cont_sta = false: $todo_cont_sta = true;
                (int)$card['todo_cont_clock'] == 0 ? $todo_cont_clock = false: $todo_cont_clock = true;
                $todo_list_content_detail_arr[$card['todo_no']]['lists'][$card['todo_cont_no']] = array("todo_cont_no" => $card['todo_cont_no'], "content" => $card['todo_cont'], "status" => $todo_cont_sta, "status" => $todo_cont_sta, "text" => $todo_cont_sta, "tomato_color" => $todo_cont_clock,"todo_cont_sta"=>'0');
              }else{
                $todo_list_content_detail_arr[$card['todo_no']]['lists'] = [];
              }
              $todo_list_content_detail_arr[$card['todo_no']]['showname'] = false;
              $todo_list_content_detail_arr[$card['todo_no']]['test_title_name'] = true;
              $todo_list_content_detail_arr[$card['todo_no']]['test'] = '';
            }else{
              $todo_list_content_detail_arr = [];
            }
            if($card['file_name'] != NULL)
            {
              $pic=explode(".",$card['file_name'])[1];
              if ($pic == "jpg" || $pic == "png" || $pic == "gif" || $pic == "svg") {
                $pic = null;
              }
              $filebox_arr[$card['file_no']]['file_no'] = $card['file_no'];
              $filebox_arr[$card['file_no']]['name'] = $card['file_name'];
              $filebox_arr[$card['file_no']]['source'] = $card['file_src'];
              $filebox_arr[$card['file_no']]['title'] =$pic;
            }else{
              $filebox_arr = [];
            }
            (int)$card['card_sta'] == 0 ? $card_sta = false: $card_sta = true;
            $step1_arr[$card['card_no']] = array("card_no"=> $card['card_no'], "card_name"=> trim($card['card_name']), "card_member" => $pro_member_arr, "showhideMember" => false, "member_input" => "", "member_inout" => [], "todo_list_content_detail" => $todo_list_content_detail_arr, "dateline" => $card_sta, "dateline_text" => $dateline_text, "calendar_date" => $calendar_date, "filebox" => $filebox_arr, "file_switch" => false);
          }
          ksort($step1_arr[$card['card_no']]['todo_list_content_detail']);
          if($card['todo_no'] != null)
          {
            ksort($step1_arr[$card['card_no']]['todo_list_content_detail'][$card['todo_no']]['lists']);
          }
          ksort($step1_arr[$card['card_no']]['filebox']);
          break;
        case "2":
          if(isset($step2_arr[$card['card_no']]) == true)
          {
            if($card['todo_title'] != NULL)
            {
              $step2_arr[$card['card_no']]['todo_list_content_detail'][$card['todo_no']]['title'] = $card['todo_title'];
              $step2_arr[$card['card_no']]['todo_list_content_detail'][$card['todo_no']]['todo_no'] = $card['todo_no'];
              if($card['todo_cont'] != NULL)
              {
                (int)$card['todo_cont_sta'] == 0 ? $todo_cont_sta = false: $todo_cont_sta = true;
                (int)$card['todo_cont_clock'] == 0 ? $todo_cont_clock = false: $todo_cont_clock = true;
                $step2_arr[$card['card_no']]['todo_list_content_detail'][$card['todo_no']]['lists'][$card['todo_cont_no']] = array("todo_cont_no" => $card['todo_cont_no'], "content" => $card['todo_cont'], "status" => $todo_cont_sta, "status" => $todo_cont_sta, "text" => $todo_cont_sta,"tomato_color"=>$todo_cont_clock,"todo_cont_sta"=>'0');
              }else{
                $step2_arr[$card['card_no']]['todo_list_content_detail'][$card['todo_no']]['lists'] = array();
              }
              $step2_arr[$card['card_no']]['todo_list_content_detail'][$card['todo_no']]['showname'] = false;
              $step2_arr[$card['card_no']]['todo_list_content_detail'][$card['todo_no']]['test_title_name'] = true;
              $step2_arr[$card['card_no']]['todo_list_content_detail'][$card['todo_no']]['test'] = '';
            }
            if($card['file_name'] != NULL)
            {
              $pic=explode(".",$card['file_name'])[1];
              if ($pic == "jpg" || $pic == "png" || $pic == "gif" || $pic == "svg") {
                $pic = null;
              }
              $step2_arr[$card['card_no']]['filebox'][$card['file_no']] = array("file_no"=> $card['file_no'], "name"=> $card['file_name'], "source" => $card['file_src'],"title"=> $pic);
            }
          }else{
            if($card["pro_mem_no_string"] != NULL)
            {
              $pro_member_arr = explode(',',$card["pro_mem_no_string"]);
            }else{
              $pro_member_arr = array();
            }
            if($card["card_mem_no_string"] != NULL)
            {
              $card_member_arr = explode(',',$card["card_mem_no_string"]);
            }else{
              $card_member_arr = array();
            }
            if($card['todo_title'] != NULL)
            {
              $todo_list_content_detail_arr[$card['todo_no']]['title'] = $card['todo_title'];
              $todo_list_content_detail_arr[$card['todo_no']]['todo_no'] = $card['todo_no'];
              if($card['todo_cont'] != NULL)
              {
                (int)$card['todo_cont_sta'] == 0 ? $todo_cont_sta = false: $todo_cont_sta = true;
                (int)$card['todo_cont_clock'] == 0 ? $todo_cont_clock = false: $todo_cont_clock = true;
                $todo_list_content_detail_arr[$card['todo_no']]['lists'][$card['todo_cont_no']] = array("todo_cont_no" => $card['todo_cont_no'], "content" => $card['todo_cont'], "status" => $todo_cont_sta, "status" => $todo_cont_sta, "text" => $todo_cont_sta, "tomato_color" =>$todo_cont_clock,"todo_cont_sta"=>'0');
              }else{
                $todo_list_content_detail_arr[$card['todo_no']]['lists'] = [];
              }
              $todo_list_content_detail_arr[$card['todo_no']]['showname'] = false;
              $todo_list_content_detail_arr[$card['todo_no']]['test_title_name'] = true;
              $todo_list_content_detail_arr[$card['todo_no']]['test'] = '';
            }else{
              $todo_list_content_detail_arr = [];
            }
            if($card['file_name'] != NULL)
            {
              $pic=explode(".",$card['file_name'])[1];
              if ($pic == "jpg" || $pic == "png" || $pic == "gif" || $pic == "svg") {
                $pic = null;
              }
              $filebox_arr[$card['file_no']]['file_no'] = $card['file_no'];
              $filebox_arr[$card['file_no']]['name'] = $card['file_name'];
              $filebox_arr[$card['file_no']]['source'] = $card['file_src'];
              $filebox_arr[$card['file_no']]['title'] =$pic;
            }else{
              $filebox_arr = [];
            }
            (int)$card['card_sta'] == 0 ? $card_sta = false: $card_sta = true;
            $step2_arr[$card['card_no']] = array("card_no"=> $card['card_no'], "card_name"=> trim($card['card_name']), "card_member" => $pro_member_arr, "showhideMember" => false, "member_input" => "", "member_inout" => [], "todo_list_content_detail" => $todo_list_content_detail_arr, "dateline" => $card_sta, "dateline_text" => $dateline_text, "calendar_date" => $calendar_date, "filebox" => $filebox_arr, "file_switch" => false);
          }
          ksort($step2_arr[$card['card_no']]['todo_list_content_detail']);
          if($card['todo_no'] != null)
          {
            ksort($step2_arr[$card['card_no']]['todo_list_content_detail'][$card['todo_no']]['lists']);
          }
          ksort($step2_arr[$card['card_no']]['filebox']);
          break;
        default:
          break;
      }
    }
    $x = 0;
    foreach($step0_arr as $card_no => $value)
    {
      $step0['cards'][$x] = $value;
      $step0['cards'][$x]['todo_list_content_detail'] = [];
      $y = 0;
      foreach($value['todo_list_content_detail'] as $todo_no => $value2)
      {
        $step0['cards'][$x]['todo_list_content_detail'][$y] = $value2;
        $step0['cards'][$x]['todo_list_content_detail'][$y]['lists'] = [];
        $z = 0;
        foreach($value2['lists'] as $todo_cont_no => $value3)
        {
          $step0['cards'][$x]['todo_list_content_detail'][$y]['lists'][$z] = $value3;
          $z++;
        }
        $y++;
      }
      $step0['cards'][$x]['filebox'] = [];
      $i = 0;
      foreach($value['filebox'] as $file_no => $value2)
      {
        $step0['cards'][$x]['filebox'][$i] = $value2;
        $i++;
      }
      $x++;
    }
    $x = 0;
    foreach($step1_arr as $card_no => $value)
    {
      $step1['cards'][$x] = $value;
      $step1['cards'][$x]['todo_list_content_detail'] = [];
      $y = 0;
      foreach($value['todo_list_content_detail'] as $todo_no => $value2)
      {
        $step1['cards'][$x]['todo_list_content_detail'][$y] = $value2;
        $step1['cards'][$x]['todo_list_content_detail'][$y]['lists'] = [];
        $z = 0;
        foreach($value2['lists'] as $todo_cont_no => $value3)
        {
          $step1['cards'][$x]['todo_list_content_detail'][$y]['lists'][$z] = $value3;
          $z++;
        }
        $y++;
      }
      $step1['cards'][$x]['filebox'] = [];
      $i = 0;
      foreach($value['filebox'] as $file_no => $value2)
      {
        $step1['cards'][$x]['filebox'][$i] = $value2;
        $i++;
      }
      $x++;
    }
    $x = 0;
    foreach($step2_arr as $card_no => $value)
    {
      $step2['cards'][$x] = $value;
      $step2['cards'][$x]['todo_list_content_detail'] = [];
      $y = 0;
      foreach($value['todo_list_content_detail'] as $todo_no => $value2)
      {
        $step2['cards'][$x]['todo_list_content_detail'][$y] = $value2;
        $step2['cards'][$x]['todo_list_content_detail'][$y]['lists'] = [];
        $z = 0;
        foreach($value2['lists'] as $todo_cont_no => $value3)
        {
          $step2['cards'][$x]['todo_list_content_detail'][$y]['lists'][$z] = $value3;
          $z++;
        }
        $y++;
      }
      $step2['cards'][$x]['filebox'] = [];
      $i = 0;
      foreach($value['filebox'] as $file_no => $value2)
      {
        $step2['cards'][$x]['filebox'][$i] = $value2;
        $i++;
      }
      $x++;
    }
    
    // echo json_encode($step0_arr);
    // echo  json_decode(json_encode(array($step0, $step1, $step2)),true);
  }
  echo json_encode(array($step0, $step1, $step2));
} catch (PDOException $e) {
  echo $e->getLine();
  echo $e->getMessage();
}
