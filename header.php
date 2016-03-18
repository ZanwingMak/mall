<?php
//define('PERMISSION',true);
//定义一个变量为true，然后在“禁止用户直接地址栏访问的文件”里检测该变量，
//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
//require('./include/init.php');

$cat = new CatModel();
$sons = $cat->getSon(3);//获取cat_id为3的子孙栏目
$cats = $cat->select();

$car = CarTools::getCar();
$cargoodskind = $car->getGoodsKind();
$totalamount = $car->getGoodsTotalAmount();

include(ROOT.'./view/front/header.html');
?>