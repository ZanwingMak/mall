<?php

define('PERMISSION',true);
//定义一个变量为true，然后在“禁止用户直接地址栏访问的文件”里检测该变量，
//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
require('../include/init.php');

//print_r($_POST);
if( !isset($_SESSION['username'])||empty($_SESSION['username']) || !isset($_SESSION['user_id']) || empty($_SESSION['user_id']) ){
    echo '请先<span><a href="../login.php">登录</a></span>';
}elseif(isset($_SESSION['username']) && $_SESSION['username']=='admin' && isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) ){
        //表中有的字段，但传来的字段中没有，所以我们要手动添加，然后同意过滤
        //直接添加再data数组(如：$data['xxxx']=$_POST['xxx']*$_POST['xxx']...)里也可，
        //但最好加到POST数组里，统一过滤一下
        //重量需要2个POST过来的值，但表中是没有这两个字段
        if(!$_POST){
            exit('发布失败，没有接收到数据，如您上传了过大的文件会出现该情况。&nbsp;<span><a href="javascript:history.go(-1);">&#9666;返回上一步</a></span>');
        }
        $_POST['weight'] = $_POST['goods_weight'] * $_POST['weight_unit'];
        //添加商品的时间(改：交由_autoFill处理)
        //$_POST['add_time'] = time();

        $data = array();
        $goods = new GoodsModel();

        //自动过滤
        $data = $goods->_facade($_POST);
        //print_r($data);

        //自动填充
        $data = $goods->_autoFill($data);
        //print_r($data);

        //如过没输入货号则自动生成
        if(empty($data['goods_sn'])){
            $data['goods_sn'] = $goods->createSN();
        }

        //自动验证
        if(!$goods->_validate($data)){
            //echo '没通过检验<br/>';
            //print_r($goods->getErr());
            echo '数据不合法<br/>';
            echo implode('<br/>',$goods->getErr());
            echo '&nbsp;<span><a href="javascript:history.go(-1);">&#9666;返回上一步</a></span>';
            exit;
        }

        //上传图片
        $uptools = new UploadTools();
        $uptools->setExt('jpg,jpeg,gif,png,bmp');
        $uptools->setSize(1);
        $ori_img_path = '';
        if(!$ori_img_path = $uptools->upload('ori_img')){
            $err = $uptools->getErr();
            if($err['err_code']==4){
                echo '请上传商品图片,错误代码：'.$err['err_code'];
                echo '&nbsp;<span><a href="javascript:history.go(-1);">&#9666;返回上一步</a></span>';
            }else{
                echo $err['err_msg'].',错误代码：'.$err['err_code'];
                echo '&nbsp;<span><a href="javascript:history.go(-1);">&#9666;返回上一步</a></span>';
            }
            exit;
        }

        if($ori_img_path){
            $data['ori_img'] = $ori_img_path;

            //如果原始图上传成功
            //就生成商品页面的中等尺寸的商品缩略图 300*400
            $ori_img = ROOT.$ori_img_path;//加上绝对路径

            $goods_img  = dirname($ori_img).'/../goods_img/goods_'.basename($ori_img);
            if(ImageTools::thumb($ori_img,$goods_img,300,400)){
                $data['goods_img'] = str_replace(ROOT,'',$goods_img);
            }

            //再生成搜索浏览时的小尺寸缩略图160*220
            $thumb_img  = dirname($ori_img).'/../thumb_img/thumb_'.basename($ori_img);
            if(ImageTools::thumb($ori_img,$thumb_img,160,220)){
                $data['thumb_img'] = str_replace(ROOT,'',$thumb_img);
            }
        }
        if($goods->add($data)){
            header("refresh:5;url=goodslist.php");
            echo '商品发布成功,5秒后自动返回商品列表。';
            echo '&nbsp;<span><a href="javascript:history.go(-1);">&#9666;返回上一步</a></span>';

        }else{
            echo '商品发布失败!';
            echo '&nbsp;<span><a href="javascript:history.go(-1);">&#9666;返回上一步</a></span>';
        }

        /*之前的手动过滤和验证
        $data['goods_name'] = trim($_POST['goods_name']);//商品名称
        $data['goods_sn'] = trim($_POST['goods_sn']);//商品序列号
        $data['goods_id'] = trim($_POST['goods_id']);//商品id
        $data['cat_id'] = $_POST['cat_id'] + 0;//分类id
        $data['shop_price'] = $_POST['shop_price'] + 0;//本店价格
        $data['market_price'] = $_POST['market_price'] + 0;//市场价格
        $data['goods_desc'] = trim($_POST['goods_desc']);//商品描述
        //$_POST['goods_weight']; 重量(不含单位)
        //$_POST['weight_unit']; 重量单位(千克为1 克为0.001)
        $data['weight'] = $_POST['goods_weight'] * $_POST['weight_unit']; //重量(单位：千克)
        $data['goods_number'] = trim($_POST['goods_number']);//数量
        $data['keywords'] = trim($_POST['keywords']);//关键词
        $data['goods_brief'] = trim($_POST['goods_brief']);//简介
        $data['is_best'] = isset($_POST['is_best'])?1:0;
        $data['is_new'] = isset($_POST['is_new'])?1:0;
        $data['is_hot'] = isset($_POST['is_hot'])?1:0;
        $data['is_on_sale'] = isset($_POST['is_on_sale'])?1:0;

        if($data['goods_name'] == ''){
            echo '请填写商品名称!';
            exit;
        }elseif($data['goods_sn'] == ''){
            echo '请正确填写序列号!';
            exit;
        }elseif($data['shop_price'] == '' || $data['shop_price'] < 0){
            echo '请正确填写本店价格!';
            exit;
        }elseif($data['market_price'] == '' || $data['market_price'] < 0 ){
            echo '请正确填写市场价格!';
            exit;
        }elseif($data['goods_number'] == '' || $data['goods_number'] < 0){
            echo '请填写库存数量!';
            exit;
        }elseif($data['keywords'] == ''){
            echo '请填写关键词!';
            exit;
        }else{
            //print_r($data);
            if($goods->add($data)){
                echo '商品发布成功!';
            }else{
                echo '商品发布失败!';
            }
        }*/
}elseif(isset($_SESSION['username']) && $_SESSION['username']!='admin' && isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
    echo '您不是管理员，请使用管理员账号进行<span><a href="../login.php">登录</a></span>';
}else{
    header("refresh:5;url=../login.php");
    echo '系统出错,5秒后自动前往用户登录界面。';
}



?>