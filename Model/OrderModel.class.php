<?php

//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
defined('PERMISSION')||exit('非法访问');

class OrderModel extends Model{
    protected $table = 'orderinfo';
    protected $primarykey = 'order_id';
    protected $fields = array(      //这里可以用desc来获取列名
      'order_id',
      'order_sn',
      'user_id',
      'username',
      'receiver',
      'address',
      'zipcode',
      'email',
      'tel',
      'best_time',
      'add_time',
      'order_admount',
      'payment'
    );

    //自动填充
    protected $_auto = array(
        array('payment','value',0),
        array('add_time','function','time')
    );

    //自动验证
    /*
     * 格式 $this->_valid = array(
     *      array('验证的字段名',0/1/2(验证的场景,0：字段有就判断，没有就不判断，
     *            1:必须检查，2：字段有就判断，没有就不判断，值为空不判断。),
     *            '报错信息','require(必须)/in(某几种情况)/between(范围)/
     *            length(某个范围)')
     * );
     */
    protected $_valid = array(
        array('receiver',1,'收货人必须在40个字符以内','length','1,40'),
        array('address',1,'收货地址必须在10-40个字符以内','length','10,120'),
        array('zipcode',1,'邮政编码必须在5-10个字符以内','length','5,10'),
        array('email',1,'邮箱非法','email'),
        array('tel',1,'联系电话必须在20个字符以内','length','1,20'),
        array('payment',1,'请选择支付方式','between','1,10'),
        array('best_time',2,'最佳送货时间必须在20个字符以内','length','1,20')
    );

    public function set_valid($array){
        if($this->_valid = $array){
            return true;
        }else{
            return false;
        }
    }

    public function create_order_sn(){
        $sn = 'OI'.date('YmdHis').mt_rand(10000,99999);
        $sql = 'select count(*) from '.$this->table." where order_sn='".$sn."'";
        return $this->db->getOne($sql)?$this->create_order_sn():$sn;
    }

    //撤销订单
    public function del_order($order_id){
        //删除订单
        $this->delete($order_id);
        //删除对应订单的商品
        $ordergoods = new OrderGoodsModel();
        if($ordergoods->del_order_goods($order_id)){
            return true;
        }else{
            return false;
        }
    }

}

?>