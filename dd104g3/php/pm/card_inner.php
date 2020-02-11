<?php
try {
  require_once('../pdo.php');
  session_start();
  // $_SESSION['mem_no'] = 1; //test
  // $_POST['type'] = 'add_file';
  switch ($_POST['type']) {
    case "add_card":
      $pro_no = $_POST['pro_no'];
      $card_name = $_POST['card_name'];
      $sql = 'insert into `card` 
        (pro_no, card_name) values 
        (:pro_no, :card_name)';
      $res = $pdo->prepare($sql);
      $res->bindParam(':pro_no', $pro_no);
      $res->bindParam(':card_name', $card_name);
      $res->execute();
      $lastCardId = $pdo->lastInsertId();
      $sql = "insert into `person_in_charge` 
      (mem_no, card_no) values 
      (:mem_no, :card_no)";
      $join = $pdo->prepare($sql);
      $join->bindValue(':mem_no', $_SESSION["mem_no"]);
      $join->bindValue(':card_no', $lastCardId);
      $join->execute();
      // require_once('get_program.php');
      echo json_encode(['status' => 'success', 'content' => '新建卡片成功']);
      break;

    case "delete_card":
      $sql = "delete FROM `card` WHERE `card_no` = :card_no";
      $res = $pdo->prepare($sql);
      $res->bindValue('card_no', $_POST['card_no']);
      $res->execute();

      echo json_encode(['status' => 'success', 'content' => '刪除卡片']);
      break;

    case "update_card_title":

      $sql = "update `card` set card_name = :card_name 
            where `card_no` = :card_no";
      $res = $pdo->prepare($sql);
      $res->bindParam(':card_name', $_POST['card_name']);
      $res->bindParam(':card_no', $_POST['card_no']);
      $res->execute();

      echo json_encode(['status' => 'success', 'content' => '修改卡片標題成功']);
      break;


    case "add_todo":
      $sql = 'insert into `todo` 
          ( `todo_no`,`pro_no`,`card_no`,`todo_title`
          ) values 
          (null ,:pro_no, :card_no, :todo_title)';
      $todos = $pdo->prepare($sql);
      $todos->bindValue(":pro_no", $_POST["pro_no"]);
      $todos->bindValue(":card_no", $_POST["card_no"]);
      $todos->bindValue(":todo_title", $_POST["todo_title"]);
      $todos->execute();
      echo json_encode(['status' => 'success', 'content' => '增加待辦事項成功']);
      $todos_id = $pdo->lastInsertId();


      break;
    case "delete_todo":

      $sql = "delete FROM `todo` WHERE `todo_no` = :todo_no";
      $res = $pdo->prepare($sql);
      $res->bindValue(':todo_no', $_POST["todo_no"]);
      $res->execute();
      echo json_encode(['status' => 'success', 'content' => '刪除代辦事項']);
      break;

    case "update_todo":


      $sql = "update `todo` set todo_title = :todo_title 
        where todo_no = :todo_no";
      $res = $pdo->prepare($sql);
      $res->bindParam(':todo_title', $_POST['todo_title']);
      $res->bindParam(':todo_no', $_POST['todo_no']);
      $res->execute();

      echo json_encode(['status' => 'success', 'content' => '修改清單標題成功']);
      break;



    case "add_todo_content":
      $sql = 'insert into `todo_content` 
              (`todo_cont_no`,`pro_no`,`card_no`,`todo_no`,`todo_cont`,`todo_cont_sta`,`todo_timer`,`todo_cont_clock`
              ) values 
              (null ,:pro_no, :card_no, :todo_no, :todo_cont, :todo_cont_sta, :todo_timer, :todo_cont_clock)';
      $todos = $pdo->prepare($sql);
      $todos->bindValue(":pro_no", $_POST["pro_no"]);
      $todos->bindValue(":card_no", $_POST["card_no"]);
      $todos->bindValue(":todo_no", $_POST["todo_no"]);
      $todos->bindValue(":todo_cont", $_POST["todo_cont"]);
      $todos->bindValue(":todo_cont_sta", 0);
      $todos->bindValue(":todo_timer", 10);
      $todos->bindValue(":todo_cont_clock", 0);
      $todos->execute();
      echo json_encode(['status' => 'success', 'content' => '更新待辦事項成功']);


      break;

    case "delete_todo_content":

      $sql = "delete FROM `todo_content` WHERE `todo_cont_no` = :todo_cont_no";
      $res = $pdo->prepare($sql);
      $res->bindValue(':todo_cont_no', $_POST["todo_cont_no"]);
      $res->execute();
      echo json_encode(['status' => 'success', 'content' => '刪除待辦事項子項目']);
      break;


    case "update_todo_content":

      $sql = "update `todo_content` set todo_cont_sta = :todo_cont_sta 
                where todo_cont_no = :todo_cont_no";
      $res = $pdo->prepare($sql);
      // $current_cont_sta=$_POST['todo_cont_sta']=='0'?$_POST['todo_cont_sta']='1':$_POST['todo_cont_sta']='0';
      $res->bindParam(':todo_cont_sta', $_POST['todo_cont_sta']);
      $res->bindParam(':todo_cont_no', $_POST['todo_cont_no']);
      $res->execute();

      echo json_encode(['status' => 'success', 'content' => '更改子項目成功']);
      break;


    case "update_onload_tomato":

      $sql = "update `todo_content` set todo_cont_clock = :todo_cont_clock 
                where todo_cont_no = :todo_cont_no";
      $res = $pdo->prepare($sql);
      $res->bindParam(':todo_cont_clock', $_POST['todo_cont_clock']);
      $res->bindParam(':todo_cont_no', $_POST['todo_cont_no']);
      $res->execute();

      echo json_encode(['status' => 'success', 'content' => '加入番茄鐘']);
      break;

    case "add_file":
     
      
      if ($_FILES['upFile']['error'] === UPLOAD_ERR_OK) {
        $from = $_FILES['upFile']['tmp_name'];
        $pro_card_no = '';
        if (file_exists("../../pmFiles") === false) {
          mkdir("../../pmFiles");
        }
        $pro_no = $_POST["pro_no"];
        $card_no = $_POST["card_no"];
        // $fileder_path = "fileder/".$pro_no."_".$card_no;
        // if (file_exists($fileder_path) === false) {
        //   mkdir($fileder_path);
        // }
        $pro_card_no = $_POST["pro_no"]."_".$_POST["card_no"]."/";
        //將檔案copy到要放的路徑
        $fileInfoArr = pathinfo($_FILES["upFile"]["name"]);
        $fileName = $_POST["file_name"];  //8.gif
  
        $from = $_FILES["upFile"]["tmp_name"];
        $to = '../../pmFiles/'.$fileName;
        $realpath="./pmFiles/".$fileName;
        if (copy($from, $to)) {
          $sql = "insert into `card_file` (`pro_no`, `card_no`, `file_name`, `file_src`) values(:pro_no, :card_no, :file_name, :file_src)";
          $files = $pdo->prepare($sql);
          $files->bindValue(":pro_no", $_POST["pro_no"]);
          $files->bindValue(":card_no", $_POST["card_no"]);

          $files->bindValue(":file_name", $_POST["file_name"]);
          $files->bindValue(":file_src", $realpath);
          $files->execute();

          //取得自動創號的key值
          $file_id = $pdo->lastInsertId();
          echo json_encode(['status' => 'success', 'content' => '上傳檔案成功','data'=>$realpath,'file_no'=>$file_id]);

        }
      
      }



    
      // if( $_FILES["upFile"]["error"] == UPLOAD_ERR_OK){
      // $sql = "insert into `card_file` (`file_no`, `pro_no`, `card_no`, `todo_no`, `file_name`, `file_src`) values(null, :pro_no, :card_no, :todo_no, :file_name, '')";
      // $files = $pdo->prepare($sql);
      // $files->bindValue(":pro_no", $_POST["pro_no"]);
      // $files->bindValue(":card_no", $_POST["card_no"]);
      // $files->bindValue(":todo_no", 0);
      // $files->bindValue(":file_name", $_POST["file_name"]);
      // $files->bindValue(":file_src", $_POST["file_src"]);
      // $files->execute();

      // //取得自動創號的key值
      // $file_id = $pdo->lastInsertId();

    

      break;

    case "delete_file":
      $sql = "delete FROM `card_file` WHERE file_no = :file_no";
      $res = $pdo->prepare($sql);
      $res->bindValue('file_no', $_POST['file_no']);
      $res->execute();

      echo json_encode(['status' => 'success', 'content' => '刪除檔案']);
      break;
  }
} catch (PDOException $e) {
  echo $e->getLine();
  echo $e->getMessage();
}
