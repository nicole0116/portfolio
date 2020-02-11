<?php
  session_start();
  require_once('../pdo.php');
  if(isset($_SESSION['mem_no'])){
    $member = array(
      'mem_no'=>$_SESSION['mem_no'], 'mem_id'=>$_SESSION['mem_id'], 
      'mem_psw'=>$_SESSION['mem_psw'], 'ring_no'=>$_SESSION['ring_no'], 
      'mem_name'=>$_SESSION['mem_name'], 'mem_email'=>$_SESSION['mem_email'],
      'headshot'=>$_SESSION['headshot'], 'mem_addr'=>$_SESSION['mem_addr'],
      'mem_tel'=>$_SESSION['mem_tel'], 'mem_status'=>$_SESSION['mem_status'],
    );
    echo json_encode(['status'=>'success', 'data'=>$member]);
  }else {
    echo json_encode(['status'=>'error', 'content'=>'尚未登入']);
  }