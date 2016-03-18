<?php

define('PERMISSION',true);
//定义一个变量为true，然后在“禁止用户直接地址栏访问的文件”里检测该变量，
//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
require('./include/init.php');

if(isset($_POST['act']) && $_POST['act'] == 'act_register'){
    $user = new UserModel();

    $data = $user->_autoFill($_POST);//自动填充
    /*
     * 调用自动检验功能
     * 用户名8-20个字符之内
     * email检测
     * password不能为空
     */
    if(!$user->_validate($_POST)){
        $msg = implode('<br/>',$user->getErr());
        include(ROOT.'view/front/msg.html');
        exit;
    }
    if($user->checkUser($_POST['username'])){
        $msg = '用户名已存在';
        include(ROOT.'view/front/msg.html');
        exit;
    }
    if(!$user->checkp1p2($data)){
        $msg = '两次输入的密码不一致';
        include(ROOT.'view/front/msg.html');
        exit;
    }
//print_r($data);exit;
    $data = $user->_facade($data); //自动过滤
//print_r($data);exit;
    if($user->reg($data)){
        header("refresh:5;url=login.php");
        $msg = '用户注册成功...5秒后自动跳转到登录页面';
    }else{
        header("refresh:5;url=index.php");
        $msg = '用户注册失败';
    }
//引入view
    include(ROOT.'view/front/msg.html');
}elseif(isset($_SESSION['username']) && !empty($_SESSION['username']) && isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
    header("refresh:5;url=index.php");
    $msg = '您已经登录了,不能进行该操作...5秒后自动跳转到商城首页';
    include(ROOT.'view/front/msg.html');
}else{
    //准备注册
    include(ROOT.'./view/front/zhuce.html');
}

?>