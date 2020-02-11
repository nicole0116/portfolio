<?php
session_start();
session_destroy();
echo json_encode(['status'=>'success', 'content'=>'登出成功']);