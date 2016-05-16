<?php

define('PERMISSION',true);
//定义一个变量为true，然后在“禁止用户直接地址栏访问的文件”里检测该变量，
//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
require('../../../include/init.php');

$fields = array(
    'goods_id',
    'goods_sn',
    'format',
    'cat_id'
);

//过滤其它参数
foreach ($_GET as $key=>$value) {
    if(!in_array($key,$fields)){
        unset($_GET[$key]);
    }
}

$goods_id = isset($_GET['goods_id'])?$_GET['goods_id']+0:0;
$goods_sn = isset($_GET['goods_sn'])?$_GET['goods_sn']:0;
$format = isset($_GET['format'])?$_GET['format']:'json';
$cat_id = isset($_GET['cat_id'])?$_GET['cat_id']+0:0;


if( isset($_GET['goods_id']) || isset($_GET['goods_sn']) || isset($_GET['format']) || isset($_GET['cat_id']) ){

    function createXML($arr, $xml) {
        foreach($arr as $k=>$v) {
            if(is_array($v)) {
                $x = $xml->addChild($k);
                create($v, $x);
            }else $xml->addChild($k, $v);
        }
    }

    function print_result($format,$good){
        if($format=='xml'){
            $xml = simplexml_load_string('<!DOCTYPE results [
                                            <!ENTITY nbsp " ">
                                            <!ENTITY copy "©">
                                            <!ENTITY reg "®">
                                            <!ENTITY trade "™">
                                            <!ENTITY mdash "—">
                                            <!ENTITY ldquo "“">
                                            <!ENTITY rdquo "”">
                                            <!ENTITY pound "£">
                                            <!ENTITY yen "¥">
                                            <!ENTITY euro "€">
                                            ]>
                                            <results/>');
            createXML($good, $xml);
            header('Content-type:text/xml');
            echo $xml->saveXML();
        }elseif($format=='json'){
            header('Content-type:text/json');
            echo json_encode($good);
        }
    }

    $goods = new GoodsModel();

    if($goods_id){
        $good = $goods->find($goods_id);
        print_result($format,$good);
    }elseif($goods_sn){
        $good = $goods->findbysn($goods_sn);
        print_result($format,$good);
    }elseif($cat_id){
        $goodslist = $goods->catGoods($cat_id);
        $data = array();
        foreach($goodslist as $k=>$v){
            foreach($v as $key=>$value){
                $data[$v['goods_id']] = $v['goods_name'];
            }
        }
        print_result('json',$data);
    }
}else{
    exit("请输入正确的参数!<br>例如[format不传默认json]：<br>单个商品信息[支持xml和json,返回商品的所有信息]：<br>12450.xyz/mall/api/goods/info?goods_id=24&format=xml<br>12450.xyz/mall/api/goods/info?goods_sn=AUTOSN20160507723873&format=json<br>分类下的所有商品[只支持json,返回[goods_id商品ID:goods_name商品名称]]：<br>12450.xyz/mall/api/goods/info?cat_id=4&format=json");
}

?>