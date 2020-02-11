<?php

$errMsg = "";
// 連線資料庫



try {
  require_once("../pdo.php");

    $_POST["product_num"] = substr($_POST["product_no"],0,3);
   
    if ($_FILES['product_src']['error'] === UPLOAD_ERR_OK) {
      $from = $_FILES['product_src']['tmp_name'];
      $to = "../../img/mall_img/" . $_FILES['product_src']['name'];
      $fileName1 =  "img/mall_img/" . $_FILES["product_src"]["name"];
      if (copy($from, $to)) {
        echo "上傳成功 <br>";
      } else {
        echo "上傳失敗 <br>";
      }
    }
  
    if ($_FILES['product_bg_src']['error'] === UPLOAD_ERR_OK) {
      $from = $_FILES['product_bg_src']['tmp_name'];
      $to = "../../img/mall_img/" . $_FILES['product_bg_src']['name'];
      $fileName2 =  "img/mall_img/" . $_FILES["product_bg_src"]["name"];
      if (copy($from, $to)) {
        echo "上傳成功 <br>";
      } else {
        echo "上傳失敗 <br>";
      }
    }

    if ($_FILES['product_slide_img']['error'] === UPLOAD_ERR_OK) {
      $from = $_FILES['product_slide_img']['tmp_name'];
      $to = "../../img/mall_img/" . $_FILES['product_slide_img']['name'];
      $fileName3 =  "img/mall_img/" . $_FILES["product_slide_img"]["name"];
      if (copy($from, $to)) {
        echo "上傳成功 <br>";
      } else {
        echo "上傳失敗 <br>";
      }
    }
    // mall_product
    // product_no=:product_no,product_name=:product_name,product_price=:product_price, product_src=:product_src,product_color=:product_color,product_desc=:product_desc,product_type=:product_type,product_bg_src=:product_bg_src,product_slide_img=:product_slide_img,index_on=:index_on,product_on=:product_on"

  $sql = "INSERT INTO `mall_product`(product_no,product_num,product_name,product_price,product_src,product_color,product_desc,product_type,product_bg_src,product_slide_img,index_on,product_on) VALUES(:product_no,:product_num,:product_name,:product_price,:product_src,:product_color,:product_desc,:product_type,:product_bg_src,:product_slide_img,:index_on,:product_on)";
  $product = $pdo->prepare($sql);
  $product->bindValue(":product_no", $_POST["product_no"]);
  $product->bindValue(":product_num", $_POST["product_num"]);
  $product->bindValue(":product_name", $_POST["product_name"]);
  $product->bindValue(":product_price", $_POST["product_price"]);
  $product->bindValue(":product_src", $fileName1);
  $product->bindValue(":product_color", $_POST["product_color"]);
  $product->bindValue(":product_desc", $_POST["product_desc"]);
  $product->bindValue(":product_type", $_POST["product_type"]);
  $product->bindValue(":product_bg_src", $fileName2);
  $product->bindValue(":product_slide_img", $fileName3);
  $product->bindValue(":index_on", $_REQUEST["index_on"]);
  $product->bindValue(":product_on", $_REQUEST["product_on"]);
  $product->execute();
  echo "<script> {window.alert('新增成功');location.href='../../back.html'} </script>";
  // echo "修改成功";
  // header("Location: ../../back.html");
  
} catch (PDOException $e) {
  $errMsg .= "錯誤原因 : " . $e->getMessage() . "<br>";
  $errMsg .= "錯誤行號 : " . $e->getLine() . "<br>";
}
// ?>