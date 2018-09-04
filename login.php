<?php
session_start();

//判断名字是否存在，如果存在，验证密码，如果不存在，直接存入
if (isset($_POST["name"])) {
    $content = file_get_contents('user.txt');
    $name = $_POST["name"];
    $user = getUser($_POST['name'],$content);
    if ($user) {
        $type = $user['type'];
        $newcontent = preg_replace("/#$name#([0|1])#/","#$name#1#",$content);
        file_put_contents('user.txt',$newcontent);
        $_SESSION['username'] = $name;
        $_SESSION['type'] = $user['type'];
        $data['res'] = 0;
        $data['msg'] = "登录成功";
    } else {
        $filename="user.txt";
        $handle=fopen($filename,"a+");
        $str=fwrite($handle,"\n#$name#1#");
        fclose($handle);
        $_SESSION['username'] = $_POST["name"];
        $_SESSION['type'] = 1;
        $data['res'] = 0;
        $data['msg'] = "注册成功";
    }
    echo json_encode($data);
}

/**
 * 从存储用户信息的文件user.txt中获取用户信息
 * @param $name 用户名
 * @return $user ['name']:用户名
 *               ['type']:状态
 */
function getUser($name,$content) {
    if(preg_match_all("/#$name#([0|1])#/i", $content, $matches)) {
        $user['name'] = $name;
        $user['type'] = $matches[1][0];
    }
    return $user;
}