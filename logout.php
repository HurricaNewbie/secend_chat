<?php
session_start();
$content = file_get_contents('user.txt');
$name = $_SESSION['username'];
$newcontent = preg_replace("/#$name#([0|1])#/","#$name#0#",$content);
file_put_contents('user.txt',$newcontent);
$_SESSION = [];
session_destroy();
$data['res'] = 0;
$data['msg'] = "退出成功";
exit(json_encode($data));