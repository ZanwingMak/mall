<?php

define('PERMISSION',true);
//定义一个变量为true，然后在“禁止用户直接地址栏访问的文件”里检测该变量，
//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
require('./include/init.php');

$goods_id = isset($_GET['goods_id'])?$_GET['goods_id']+0:0;

//查询商品信息
$goods = new GoodsModel();
$good = $goods->find($goods_id);
if(empty($good)){
    header('location: index.php');
    exit;
}

$cat = new CatModel();

//取出树状导航
$cats = $cat->select();//获取所有栏目
$sort = $cat->getCatTree($cats,0,1);//排序


//取出面包屑导航
$cat_id = $good['cat_id'];
$addr = $cat->getTree($cat_id);

//商品浏览历史
if(!isset($_SESSION['history_goods'][0])){
    array_unshift($_SESSION['history_goods'],array(
        'goods_id'=>$goods_id,
        'goods_name'=>$good['goods_name'],
        'shop_price'=>$good['shop_price'],
        'thumb_img'=>$good['thumb_img'],''));
}else{
    if($_SESSION['history_goods'][0]['goods_id']!=$goods_id){
        if(count($_SESSION['history_goods'])==5){
            array_pop($_SESSION['history_goods']);
        }
        array_unshift($_SESSION['history_goods'],array(
            'goods_id'=>$goods_id,
            'goods_name'=>$good['goods_name'],
            'shop_price'=>$good['shop_price'],
            'thumb_img'=>$good['thumb_img'],''));
    }
}


include(ROOT.'./view/front/shangpin.html');

?>