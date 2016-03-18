<?php

define('PERMISSION',true);
//定义一个变量为true，然后在“禁止用户直接地址栏访问的文件”里检测该变量，
//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
require('../include/init.php');

/*
 * 思路：
 * 接收goods_id
 * 实例化goodsModel
 * 调用find方法
 * 展示商品信息
 */
if( !isset($_SESSION['username'])||empty($_SESSION['username']) || !isset($_SESSION['user_id']) || empty($_SESSION['user_id']) ){
    echo '请先<span><a href="../login.php">登录</a></span>';
}elseif(isset($_SESSION['username']) && $_SESSION['username']=='admin' && isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) ){
    $goods_id = $_GET['goods_id'] + 0;
    $goods = new GoodsModel();
    $g = $goods->find($goods_id);
    if(!empty($g)){
        print_r($g);
    }else{
        echo '商品不存在';
        echo '&nbsp;<span><a href="javascript:history.go(-1);">&#9666;返回上一步</a></span>';
        exit;
    }
}elseif(isset($_SESSION['username']) && $_SESSION['username']!='admin' && isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
    echo '您不是管理员，请使用管理员账号进行<span><a href="../login.php">登录</a></span>';
}else{
    header("refresh:5;url=../login.php");
    echo '系统出错,5秒后自动前往用户登录界面。';
}


?>