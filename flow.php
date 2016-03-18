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

//判断用户操作
$act = isset($_GET['act'])?$_GET['act']:'buy';

$car = CarTools::getCar();//获取购物车实例
$goods = new GoodsModel();
if($act == 'buy'){//把商品加到购物车动作
    //如果传了$goods_id和$num过来就表示购买商品，否则表示查看购物车
    $goods_id = isset($_GET['goods_id'])?$_GET['goods_id']+0:null;
    $num = isset($_GET['num'])?$_GET['num']+0:null;
    if(isset($_GET['num'])&&$_GET['num']<=0){
        $msg = '请正确填写购买数量...';
        include(ROOT.'view/front/msg.html');
        exit;
    }
    if($goods_id){//如果$goods_id为真，表示想把商品放到购物车里
        $g = $goods->find($goods_id);
        if(!empty($g)){//有此商品
            //判断此商品是否在回收站
            //此商品是否已下架
            //此商品库存够不够
            if($g['is_delete']==1 || $g['is_on_sale']==0){
                header("refresh:3;url=index.php");
                $msg = '此商品已下架,无法进行购买...3秒后自动跳转到商城首页';
                include(ROOT.'view/front/msg.html');
                exit;
            }
            //把商品加到购物车里
            $car->addItem($goods_id,$g['goods_name'],$g['shop_price'],$num);

            $AllGoods = $car->getAllGoods();
            //判断该商品库存够不够
            if($AllGoods[$goods_id]['num']>$g['goods_number']){
                //库存不足，把刚才加进来的撤回
                $car->minusNum($goods_id,$num);
                $msg = '此商品库存不足';
                include(ROOT.'view/front/msg.html');
                exit;
            }
        }
    }
    $AllGoods = $car->getAllGoods();
    if(empty($AllGoods)){//如果购物车为空，返回首页
        header("refresh:3;url=index.php");
        $msg = '您的购物车里没有商品...3秒后自动跳转到商城首页';
        include(ROOT.'view/front/msg.html');
        exit;
    }

    //获取购物车里的商品的详细信息
    $CarAllGoodsInfo = $goods->getCarGoodsInfo($AllGoods);
    $totalamount = $car->getGoodsTotalAmount();
    $markettotalamount = 0.0;
    foreach($CarAllGoodsInfo as $value){
        $markettotalamount += $value['market_price'] * $value['num'];
    }
    $discount = $markettotalamount-$totalamount;
    if($markettotalamount!=0.0){
        $per = round($discount/$markettotalamount*100,2);
    }else{
        $per = 0;
    }
    include(ROOT.'./view/front/jiesuan.html');
    exit;

}elseif($act == 'clear'){
    $car->clearCar();
    header("refresh:3;url=index.php");
    $msg = '购物车已清空...3秒后自动跳转到商城首页';
    include(ROOT.'view/front/msg.html');
    exit;
}elseif($act == 'del'){
    $goods_id = isset($_GET['goods_id'])?$_GET['goods_id']+0:null;
    $car->delItem($goods_id);
    header("location:flow.php");
    exit;
}elseif($act == 'submit'){
    $AllGoods = $car->getAllGoods();
    if(empty($AllGoods)){//如果购物车为空，返回首页
        header("refresh:3;url=index.php");
        $msg = '您的购物车里没有商品...3秒后自动跳转到商城首页';
        include(ROOT.'view/front/msg.html');
        exit;
    }
    $goods_ids = array();
    $nums = array();
    if(isset($_GET['goods_ids']) && isset($_GET['nums'])){
        //$_GET['goods_ids'] = $_GET['goods_ids'] + 0;
        //$_GET['nums'] = $_GET['nums'] + 0;
        $goods_ids = explode(',',$_GET['goods_ids']);
        $nums = explode(',',$_GET['nums']);
    }else{
        $_GET['goods_ids'] = null;
        $_GET['nums'] = null;
    }
    $change = array();
    if(count($goods_ids)==count($nums)){
        for($i=0;$i<count($goods_ids);$i++){
            $change[$goods_ids[$i]+0] = $nums[$i]+0;
        }
        foreach($change as $key=>$value){
            $g = $goods->find($key);
            if(!empty($g)){//有此商品
                //判断此商品是否在回收站
                //此商品是否已下架
                //此商品库存够不够
                if($g['is_delete']==1 || $g['is_on_sale']==0){
                    $msg = '';
                    if(mb_strlen($g['goods_name'],'utf-8')>15){
                        $msg = (mb_substr($g['goods_name'],0,15,'utf-8').'...');
                    }else{
                        $msg =  $g['goods_name'];
                    }
                    header("refresh:3;url=flow.php");
                    $msg = '【'.$msg.'】商品已下架,无法进行购买...3秒后自动返回';
                    include(ROOT.'view/front/msg.html');
                    exit;
                }
            //修改商品数量
            $car->changeNum($key,$value);
            $AllGoods = $car->getAllGoods();
            if(empty($AllGoods)){//如果购物车为空，返回首页
                header("refresh:3;url=index.php");
                $msg = '您的购物车里没有商品...3秒后自动跳转到商城首页';
                include(ROOT.'view/front/msg.html');
                exit;
            }
            if(!isset($AllGoods[$key]['num'])){
                header("refresh:3;url=flow.php");
                if($g['goods_name']){
                    $msg = '参数有误：购物车里没有此商品【'.$g['goods_name'].'】...3秒后自动返回';
                }else{
                    $msg = '参数有误...3秒后自动返回';
                }
                include(ROOT.'view/front/msg.html');
                exit;
            }else{
                if($AllGoods[$key]['num']<=0){
                    header("refresh:3;url=flow.php");
                    $msg = '【'.$g['goods_name'].'】商品的购买数量有误...3秒后自动返回';
                    include(ROOT.'view/front/msg.html');
                    exit;
                }
            }
            //判断该商品库存够不够
            if($AllGoods[$key]['num']>$g['goods_number']){
                //库存不足
                header("refresh:3;url=flow.php");
                $msg = $g['goods_name'].'商品库存不足...3秒后自动返回';
                include(ROOT.'view/front/msg.html');
                exit;
                }
            }
        }
    }
    //获取购物车里的商品的详细信息
    $CarAllGoodsInfo = $goods->getCarGoodsInfo($AllGoods);
    $totalamount = $car->getGoodsTotalAmount();
    $markettotalamount = 0.0;
    foreach($CarAllGoodsInfo as $value){
        $markettotalamount += $value['market_price'] * $value['num'];
    }
    $discount = $markettotalamount-$totalamount;
    if($markettotalamount!=0.0){
        $per = round($discount/$markettotalamount*100,2);
    }else{
        $per = 0;
    }
    include(ROOT.'view/front/tijiao.html');
}elseif($act = 'done'){
    $data = array();
    $order = new OrderModel();
    //获取购物车的所有商品,先提前获取了,万一提交订单成功的同时,SESSION被恶意清掉就麻烦了。
    $AllGoods = $car->getAllGoods();
    //自动过滤
    $data = $order->_facade($_POST);
    //自动填充
    $data = $order->_autoFill($data);
    //自动检验
    if(!$order->_validate($data)){
        $msg = implode('<br/>',$order->getErr());
        include(ROOT.'view/front/msg.html');
        exit;
    }
    //写入总金额
    $order_amount = $data['order_amount'] = $car->getGoodsTotalAmount();
    //写入用户id和用户名，从session读取
    $data['user_id'] = $_SESSION['user_id'];
    $data['username'] = $_SESSION['username'];
    //创建订单号
    $order_sn = $data['order_sn'] = $order->create_order_sn();
    if(!$AllGoods){
        header("refresh:3;url=index.php");
        $msg = '您的购物车里没有商品...3秒后自动跳转到商城首页';
        include(ROOT.'view/front/msg.html');
        exit;
    }else{
        if(!$order->add($data)){
            $msg = '订单提交失败';
            $msg = $g['goods_name'].'商品库存不足...3秒后自动返回';
            include(ROOT.'view/front/msg.html');
            exit;
        }
    }
    //获取刚刚产生的order_id
    $order_id = $order->return_auto_increment();
    //订单写入成功，接下来要写入订单商品
    //然后把商品写入订单商品表
    $ordergoods = new OrderGoodsModel();
    $cnt = 0;
    $change_goods_number = array();
    foreach($AllGoods as $key=>$value){
        //收集订单中所有商品的goods_id和购买数量，
        //当整个订单写入成功时，同意减少库存，如果写入失败，则不减少库存。
        $change_goods_number[$key] = $value['num'];
        $data = array();
        $data['order_id'] = $order_id;
        $data['order_sn'] = $order_sn;
        $data['goods_id'] = $key;
        $data['goods_name'] = $value['goods_name'];
        $data['goods_buy_num'] = $value['num'];
        $data['shop_price'] = $value['shop_price'];
        $data['subtotal'] = $value['shop_price']*$value['num'];
        if($ordergoods->add($data)){
            //插入成功 cnt+1
            $cnt += 1;
            //因为只有全部都插入成功了，才能算真正的成功
        }
    }
    if(count($AllGoods) !== $cnt){//购物车里的商品没有全部入库成功
        //撤销此订单
        $order->del_order($order_id);
        header("refresh:3;url=flow.php");
        $msg = '订单提交失败...3秒后自动跳转到购物车页面';
        include(ROOT.'view/front/msg.html');
        exit;
    }
    //订单商品写入成功个，整个订单写入成功
    //修改订单商品里的所有商品库存
    $goods = new GoodsModel();
    foreach($change_goods_number as $key=>$value){
        $goods_id = $key;
        $buy_num = $value;
        $goods->changeGoodsNumber($goods_id,$buy_num);
    }
    //清空购物车
    $car->clearCar();
    include(ROOT.'view/front/order.html');
}


?>