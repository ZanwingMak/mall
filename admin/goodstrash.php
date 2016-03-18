<?php

define('PERMISSION',true);
//定义一个变量为true，然后在“禁止用户直接地址栏访问的文件”里检测该变量，
//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
require('../include/init.php');

/*
 * 接收goods_id
 * 调用trash方法
 */
if( !isset($_SESSION['username'])||empty($_SESSION['username']) || !isset($_SESSION['user_id']) || empty($_SESSION['user_id']) ){
    echo '请先<span><a href="../login.php">登录</a></span>';
}elseif(isset($_SESSION['username']) && $_SESSION['username']=='admin' && isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) ){
    if(isset($_GET['act']) && $_GET['act']=='show'){
        //这个部分是打印所有的放入回收站商品
        $goods = new GoodsModel();
        $goodslist = $goods->getTrash();
        include(ROOT.'view/admin/templates/goodslist.html'); //一个页面多个功能
    }else{
        $goods_id = $_GET['goods_id'] + 0;
        $goods = new GoodsModel();

        if($goods->trash($goods_id)){
            header("refresh:5;url=goodslist.php");
            echo '成功放入回收站,5秒后自动返回商品列表。';
            echo '&nbsp;<span><a href="javascript:history.go(-1);">&#9666;返回上一步</a></span>';
        }else{
            echo '放入回收站失败';
            echo '&nbsp;<span><a href="javascript:history.go(-1);">&#9666;返回上一步</a></span>';
        }
        //彻底删除、恢复商品(移出回收站)功能
        //。。。。
    }
}elseif(isset($_SESSION['username']) && $_SESSION['username']!='admin' && isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
    echo '您不是管理员，请使用管理员账号进行<span><a href="../login.php">登录</a></span>';
}else{
    header("refresh:5;url=../login.php");
    echo '系统出错,5秒后自动前往用户登录界面。';
}

?>