<?php

//用户登录页面
define('PERMISSION',true);
//定义一个变量为true，然后在“禁止用户直接地址栏访问的文件”里检测该变量，
//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
require('./include/init.php');

$vc = new ImageTools();
$vcode = $vc->vcode();
setcookie('vcode',$vcode);//先创建cookie
//$_COOKIE['vcode'] = $vcode;//再把值赋给cookie，这样cookie就能即时生效，不用等刷新  //好像没必要而且效果一样。。。。注释之~