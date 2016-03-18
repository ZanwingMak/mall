<?php
define('PERMISSION',true);
//定义一个变量为true，然后在“禁止用户直接地址栏访问的文件”里检测该变量，
//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
require('./include/init.php');

if( !isset($_SESSION['username'])||empty($_SESSION['username']) || !isset($_SESSION['user_id']) || empty($_SESSION['user_id']) ){
    header("refresh:2;url=login.php");
    $msg = '请先登录..2秒后自动跳转';
    include(ROOT.'view/front/msg.html');
    exit;
}

include(ROOT.'./view/front/zhongxin.html');

?>