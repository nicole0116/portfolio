<?php
  try{
    require_once('../pdo.php');
    $sql = 'select * from `mall_product` where index_on = 1';
    $res = $pdo->prepare($sql);
    $res->execute();
    if($res->rowCount()){
      $products = $res->fetchAll(PDO::FETCH_ASSOC);
      $data = [];
      foreach($products as $product){
        $data[] = [
          'name'=>$product['product_name'],
          'content'=>$product['product_desc'],
          'src'=>[
            $product['product_src'],
            $product['product_bg_src'],
            $product['product_slide_img'],
          ]
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