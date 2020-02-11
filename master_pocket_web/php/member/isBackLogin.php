<?php
  session_start();
  require_once('../pdo.php');
  if(isset($_SESSION['mgr_no'])){
    $member = array(
      'mgr_no'=>$_SESSION['mgr_no'], 'mgr_name'=>$_SESSION['mgr_name'], 
      'mgr_id'=>$_SESSION['mgr_id'], 'mgr_email'=>$_SESSION['mgr_email'], 
      'mgr_sta'=>$_SESSION['mgr_sta']
    );
    echo json_encode(['status'=>'success', 'data'=>$member]);
  }else {
    echo json_encode(['status'=>'error', 'content'=>'尚未登入']);
  }