<?php

define('PERMISSION',true);
//定义一个变量为true，然后在“禁止用户直接地址栏访问的文件”里检测该变量，
//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
require('./include/init.php');
$goods = new GoodsModel();
$goodslist = array();
$keywords = '';
if(isset($_POST['keywords']) && isset($_GET['keywords'])){
    $keywords = $_POST['keywords'];
}
if(isset($_POST['keywords']) || isset($_GET['keywords'])){
    $keywords = isset($_POST['keywords'])?$_POST['keywords']:$_GET['keywords'];
}
$goodslist = $goods->select_goods_by_keyword($keywords);

$page = isset($_GET['page'])?$_GET['page']+0:1;
if($page<1){
    $page = 1;
}

//分页操作
$total_num = count($goodslist);
$each_page_num = 12;//每页取8条
if($page > ceil($total_num/$each_page_num)){
    $page = 1;
}
$offset = ($page-1)*$each_page_num;//偏移量,跳过了($page-1)*$each_page_num条
//即从第$offset+1条开始取
$pagetools = new PageTools($total_num,$each_page_num,$page);//total_num,each_page_num,page
$pagecode = $pagetools->show();
$total_page = $pagetools->get_total_page();
$page_url = $pagetools->get_url();
if($page>$total_page){
    $page = 1;
}

$goodslist = array_slice($goodslist,$each_page_num*($page-1),$each_page_num*$page);

$cat = new CatModel();
//取出树状导航
$cats = $cat->select();//获取所有栏目
$sort = $cat->getCatTree($cats,0,1);//排序

include(ROOT.'./view/front/lanmu.html');


?>