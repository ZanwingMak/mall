<?php

define('PERMISSION',true);
//定义一个变量为true，然后在“禁止用户直接地址栏访问的文件”里检测该变量，
//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
require('./include/init.php');

$goods = new GoodsModel();

//随机取出5条新品
$newgoodslist = $goods->getRandNew(5);

//随机取出指定栏目的商品
//ACGN相关商品
$animegoods_id = 3;
$animegoodslist = $goods->catGoods($animegoods_id,0,5);//取3号栏目下的，偏移量为0，取5条，按添加时间倒序

//随机取出5条热门商品
$hotgoodslist = $goods->getRandHot(5);

//随机取出5条精品
$bestgoodslist = $goods->getRandBest(5);

//随机取5条上架的商品
$onsalegoodslist = $goods->getRandOnSale(5);

//随机获取3条热门商品
$hotgoodslistthree = $goods->getRandHot(3);

//随机获取3条上架的商品
$onsalegoodslistthree = $goods->getRandOnSale(3);

//随机获取3条精品
$bestgoodslistthree = $goods->getRandBest(3);

include(ROOT.'./view/front/index.html');

?>