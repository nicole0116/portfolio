<?php
try {
  // $dsn = "mysql:host=localhost;port=8889;dbname=dd104g3;charset=utf8";
  // $user = "root";
  // $password = "root";
  // $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
  // $pdo = new PDO($dsn, $user, $password, $options);

  require_once('../pdo.php');
  $sql = "select * from `orders` ORDER BY `orders`.`order_no` DESC";
  $orders = $pdo->query($sql);

  if( $orders->rowCount() == 0 ){ //找不到
    //傳回空的JSON字串
    echo json_encode(['status'=>'error', 'content'=>"查無資料"]);
  }else{ //找得到
    //取回一筆資料
    $backOrders = $orders->fetchAll(PDO::FETCH_ASSOC);
    //送出json字串
    echo json_encode(['status'=>'success', 'data'=>$backOrders]);
  }	
} catch (PDOException $e) {
  echo $e->getMessage();
}
?>

