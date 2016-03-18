<?php

define('PERMISSION',true);
//定义一个变量为true，然后在“禁止用户直接地址栏访问的文件”里检测该变量，
//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
require('./include/init.php');


$cat_id = isset($_GET['cat_id'])?$_GET['cat_id']+0:0;
$page = isset($_GET['page'])?$_GET['page']+0:1;
if($page<1){
    $page = 1;
}

$goods = new GoodsModel();


//分页操作
$total_num = $goods->catGoodsCount($cat_id);
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

$cat = new CatModel();
$category = $cat->find($cat_id);
if(empty($category)){
    header('location: index.php');
    exit;
}

//取出树状导航
$cats = $cat->select();//获取所有栏目
$sort = $cat->getCatTree($cats,0,1);//排序
//取出面包屑导航
$addr = $cat->getTree($cat_id);



//取出栏目下的商品
$goodslist = $goods->catGoods($cat_id,$offset,$each_page_num);//不传后面2个参数表示取出所有


include(ROOT.'./view/front/lanmu.html');

?>