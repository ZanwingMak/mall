<?php

//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
defined('PERMISSION')||exit('非法访问');
class CarTools{
    private static $ins = null;
    private $items = array();
    //public $sign = 0;测试用

    final protected function __construct(){
        //$this->sign = mt_rand(1,100000);测试用 | 即切换页面仍然不变
    }
    final protected function __clone(){
    }

    //获取实例
    private static function getIns(){
        if(!(self::$ins instanceof self)){
            self::$ins = new self();
        }
        return self::$ins;
    }
    //把购物车的单例对象放到session里
    public static function getCar(){
        if(!isset($_SESSION['car']) || !($_SESSION['car'] instanceof self)){//instanceof (1)判断一个对象是否是某个类的实例,(2)判断一个对象是否实现了某个接口
            $_SESSION['car'] = self::getIns();
        }
        return $_SESSION['car'];
    }

    /* 添加商品到购物车
     * parm int $goods_id 商品id、主键
     * parm string $goods_name 商品名称
     * parm float $price 商品价格
     * parm int $num 数量
     */
    public function addItem($goods_id,$goods_name,$shop_price,$num=1){
        if($this->goodsisexist($goods_id)){//如果该商品已经在购物车里，直接加其数量
            $this->addNum($goods_id,$num);
        }else{
            $item = array();
            $item['goods_name'] = $goods_name;
            $item['shop_price'] = $shop_price;
            $item['num'] = $num;
            $this->items[$goods_id] = $item;
        }
        /*
        $this->items[$goods_id] = array();
        $this->items[$goods_id]['goods_name'] = $goods_name;
        $this->items[$goods_id]['shop_price'] = $shop_price;
        $this->items[$goods_id]['num'] = $num;
        */

    }

    /*
     * 判断某商品是否已存在(已经在购物车里了)
     */
    public function goodsisexist($goods_id){
        return array_key_exists($goods_id,$this->items);
    }

    /*
     * 直接修改购物车中的商品数量
     * parm int $goods_id 商品主键,id
     * parm int $num 某个商品修改后的数量，即直接把某商品的数量改为$num
     */
    public function changeNum($goods_id,$num=1){
        if(!$this->goodsisexist($goods_id)){ //商品不在购物车里
            return false;
        }else{
            $this->items[$goods_id]['num'] = $num;
        }
    }

    /*
     * 增加商品数量
     */
    public function addNum($goods_id,$num=1){
        if($this->goodsisexist($goods_id)){
            $this->items[$goods_id]['num'] = $this->items[$goods_id]['num'] + $num;
        }
    }

    /*
     * 减少商品数量
     */
    public function minusNum($goods_id,$num=1){
        if($this->goodsisexist($goods_id)){
            $this->items[$goods_id]['num'] -= $num;
        }
        //如果减到了0，从购物车里删掉该商品
        //if($this->items[$goods_id]['num']<1){
        //    $this->delItem($goods_id);
        //}
    }

    /*
     * 删除该商品
     */
    public function delItem($good_id){
        unset($this->items[$good_id]);
    }

    /*
     * 清空购物车
     */
    public function clearCar(){
        $this->items = array();
    }

    /*
     * 查询购物车中有多少种商品
     */
    public function getGoodsKind(){
        return count($this->items);
    }

    /*
     * 查询购物车中商品的个数
     */
    public function getGoodsNum(){
        if($this->getGoodsKind() == 0){
            return 0;
        }
        $sum = 0;
        foreach($this->items as $item){
            $sum += $item['num'];
        }
        return $sum;
    }

    /*
     * 查询购物车中商品的总金额
     */
    public function getGoodsTotalAmount(){
        if($this->getGoodsKind()==0){
            return 0;
        }
        $totalamount = 0.0;
        foreach($this->items as $item){
            $totalamount += $item['shop_price'] * $item['num'];
        }
        return $totalamount;
    }

    /*
     * 返回购物车中的所有商品
     */
    public function getAllGoods(){
        return $this->items;
    }

}

/*
$car = CarTool::getCar();

if(!isset($_GET['test'])){
    $_GET['test'] = '';
}
if($_GET['test'] == 'add'){
    $car->addItem(1,'111',111,1);
    print_r($car->getAllGoods());
}elseif($_GET['test'] == 'clear'){
    $car->clearCar();
    print_r($car->getAllGoods());
}elseif($_GET['test'] == 'show'){
    print_r($car->getAllGoods());
}elseif($_GET['test'] == 'total'){
    echo $car->getGoodsTotalAmount();
}else{
    print_r($car);
}
*/

?>