<?php

// echo $_REQUEST["index_on"] ." <br>";
// echo $_REQUEST["product_on"];
$errMsg = "";
//連線資料庫
try {
  require_once("../pdo.php");

  if ($_FILES['product_src']['error'] === 4) {
    // $from = $_POST["product_src_hidden"];
    // $to = substr($_POST["product_src_hidden"], 12, 0);
    $fileName1 =  $_POST["product_src_hidden"];

  } else {
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
  }


  if ($_FILES['product_bg_src']['error'] === 4) {
    // $from = $_POST["product_bg_hidden"];
    // $to = substr($_POST["product_bg_hidden"], 12, 0);
    $fileName2 =  $_POST["product_bg_hidden"];
  } else {
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
  }

 if ($_FILES['product_slide_img']['error'] === 4) {
    // $from = $_POST["product_slide_hidden"];
    // $to = substr($_POST["product_slide_hidden"], 12, 0);
    $fileName3 =  $_POST["product_slide_hidden"];
  } else {
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
  }

  $sql = "UPDATE `mall_product` SET product_price=:product_price, product_src=:product_src,product_color=:product_color,product_desc=:product_desc,product_bg_src=:product_bg_src,product_slide_img=:product_slide_img,index_on=:index_on,product_on=:product_on WHERE product_no = :product_no";
  $product = $pdo->prepare($sql);
  $product->bindValue(":product_no", $_POST["product_no"]);
  $product->bindValue(":product_price", $_POST["product_price"]);
  $product->bindValue(":product_src", $fileName1);
  $product->bindValue(":product_color", $_POST["product_color"]);
  $product->bindValue(":product_desc", $_POST["product_desc"]);
  $product->bindValue(":product_bg_src", $fileName2);
  $product->bindValue(":product_slide_img", $fileName3);
  $product->bindValue(":index_on", $_REQUEST["index_on"]);
  $product->bindValue(":product_on", $_REQUEST["product_on"]);
  $product->execute();
  echo "<script> {window.alert('修改成功');location.href='../../back.html'} </script>";
  // echo "修改成功";
  // header("Location: ../../back.html");
  
} catch (PDOException $e) {
  $errMsg .= "錯誤原因 : " . $e->getMessage() . "<br>";
  $errMsg .= "錯誤行號 : " . $e->getLine() . "<br>";
}

?>