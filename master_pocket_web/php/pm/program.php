<?php
session_start();
try {
  require_once('../pdo.php');

  switch ($_POST['type']) {
      // case "add_program":
      //   $sql = 'insert into `program` (mem_no,  pro_col, pro_title) values (:mem_no, :pro_col, :pro_title)';
      //   $res = $pdo->prepare($sql);
      //   $_SESSION['mem_no'] = 1; //-----------------------------
      //   $res->bindValue(':mem_no', $_SESSION['mem_no']);
      //   $res->bindValue(':pro_col', $_POST['pro_col']);
      //   $res->bindValue(':pro_title', $_POST['pro_title']);
      //   $res->execute();
      //   $lastId = $pdo->lastInsertId();

      //   $sql = "insert into `join_program` (mem_no, pro_no) values( ?, $lastId)";
      //   $join = $pdo->prepare($sql);
      //   $join->bindValue(1, $_SESSION["mem_no"]);
      //   $join->execute();

      //   echo $lastId;
      //   break;

    case "complete_program":
      $sql = "update `program` set pro_sta = :pro_sta 
        where pro_no = :pro_no";
      $res = $pdo->prepare($sql);
      $res->bindParam(':pro_sta', $_POST['pro_sta']);
      $res->bindParam(':pro_no', $_POST['pro_no']);
      $res->execute();

      echo json_encode(['status' => 'success', 'content' => '加入已完成專案']);
      break;

    case "delete_program":
      $sql = "delete FROM `program` WHERE `pro_no` = :pro_no";
      $res = $pdo->prepare($sql);
      $res->bindParam(':pro_no', $_POST['pro_no']);
      $res->execute();

      echo json_encode(['status' => 'success', 'content' => '刪除該專案']);
      break;

    case "mem_data":
      // $sql = 'select jp.inv_by_mem,jp.pro_no,jp.pro_mem_inv,m.mem_name,m.mem_id,m.headshot
      // FROM `join_program` jp,`member` m 
      // where jp.inv_by_mem=m.mem_no and
      // m.mem_no = :mem_no';

      $sql = 'select m.mem_name,m.mem_id,m.headshot,m.mem_no,jp.pro_mem_inv FROM `join_program` jp,`member` m 
      where jp.mem_no=m.mem_no and jp.pro_mem_inv=1 and jp.pro_no=:pro_no';
      $res = $pdo->prepare($sql);
      // $_SESSION['mem_no'] = 1; //-----------------------------
      // $res->bindValue(':mem_no', $_SESSION['mem_no']);
      $res->bindValue(':pro_no', $_POST['pro_no']);
      $res->execute();
      if ($res->rowCount()) {
        $members = $res->fetchAll(PDO::FETCH_ASSOC);
        $member_arr = [];  //program_memeber
        foreach ($members as $member) {
          $member_arr[] = [
            "mem_no" => $member["mem_no"],
            "member_name" => $member["mem_name"],
            "userId" => $member["mem_id"],
            "src" =>  './userImg/'.$member["headshot"],
            "check" =>  './img/unchecked_d.3b5daaa1.svg',
            // "uncolor" =>  false
          ];
        }
      }
      echo json_encode(['status' => 'success', 'data' => $member_arr]);

      break;
  }
} catch (PDOException $e) {
  echo $e->getLine();
  echo $e->getMessage();
}
