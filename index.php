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


//获取banner和链接
function get_extension($file){
	return pathinfo($file, PATHINFO_EXTENSION);
}
function mk_dir($dir){
	if(is_dir($dir)){
		return $dir;
	}else{
		mkdir($dir,0777,true); // 0777：权限，true：级联目录
		return $dir;
	}
}
function mk_file($file_path){
	if(file_exists($file_path)){
		return $file_path;
	}else{
		$file = fopen($file_path, "w");
		$txt = ";当首个字符为';'时，表示无视该行(注释)，如需生效请删除';'\n;请按照下面的例子配置banner\n;图片文件名.扩展名|超链接\n1.jpg | http://12450.xyz\n;如需默认banner，请按照下面的例子进行配置\n;图片文件名.扩展名→超链接\ndefault1.jpg → http://12450.xyz";
		fwrite($file, $txt);
		fclose($file);
		return $file_path;
	}
}
function TrimArray($Input){
	if (!is_array($Input))
		return trim($Input);
	return array_map('TrimArray', $Input);
}
$dir = ROOT.'banner';
$dir = mk_dir($dir);
$file_path = $dir.'/imgs_links.ini';
$file_path = mk_file($file_path);
$myfile = fopen($file_path, "r") or die('无法打开'.$file_path.'文件!');
// 输出单行直到 end-of-file
$imgs_links = array();
$default_imgs_links = array();
while(!feof($myfile)) {
	$line = fgets($myfile);
	if($line==''){
		continue;
	}
	$firstchar = substr($line,0,1);
	if($firstchar==';'||$firstchar=='；'){
		continue;
	}
	if(strpos($line,'|') !== true){
		if(strpos($line,'→') === false){
			$imgs_links[] = explode("|",$line);
		}
	}
	if(strpos($line,'|') === false){
		if(strpos($line,'→') !== true){
			$default_imgs_links[] = explode("→",$line);
		}
	}
}
fclose($myfile);

$imgs_links = TrimArray($imgs_links);
$imgs_links_count = count($imgs_links);
$default_imgs_links = TrimArray($default_imgs_links);
$default_imgs_links_count = count($default_imgs_links);

if($imgs_links_count == 0){
	if($default_imgs_links_count == 0){
		$default_imgs_links[] = ['default.jpg','#'];
	}
	$imgs_links = $default_imgs_links;
	$imgs_links_count = count($imgs_links);
}
if($imgs_links_count == 1){
	$imgs_links_count = 0;
}
include(ROOT.'./view/front/index.html');

?>