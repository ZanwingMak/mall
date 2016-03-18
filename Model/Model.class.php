<?php

//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
defined('PERMISSION')||exit('非法访问');


class Model{
    protected $table = NULL; //model所控制的表
    protected $db = NULL; //引入的mysql对象

    protected $primarykey = '';//主键
    //自动过滤
    protected $fields = array();
    //自动填充
    protected $_auto = array();
    //自动验证
    protected $_valid = array();
    //错误提示
    protected $error = array();


    public function __construct(){
        $this->db = mysql::getIns();
    }

    public function table($table){
        $this->table = $table;
    }

    /*
     * 自动过滤：
     * 负责把传来的数组
     * 清除掉不用的单元
     * 留下与表的字段对应的单元
     * 思路：
     * 循环数组，分别判断其key，是否是表的字段
     * 自然要现有表的字段
     *
     * 表的字段可以desc表名来分析
     * 也可以手动写好
     * 以tp为例，两者都行
     *
     * 自动分析肯定是要消耗资源的
     * 这里先手动写好，以后再改
     */
    public function _facade($array=array()){
        $data = array();
        foreach ($array as $key=>$value) {
            if(in_array($key,$this->fields)){ //判断$key是否是表的字段
                $data[$key] = $value;
            }
        }
        return $data;
    }

    /*
     * 自动填充：
     * 负责把表中需要的值，而$_POST又没传的字段，赋上值
     * 比如 $_POST里没有add_time，即商品的添加时间，
     * 则自动把time()的返回值赋过来
     */
    public function _autoFill($data){
        foreach($this->_auto as $key=>$value){
            if(!array_key_exists($value[0],$data)){ // $value[0]：字段名
                //查看你的数组有没有我给定的字段，如果没有就给你加上
                switch($value[1]){ // $value[1]：类型
                    case 'value':
                        $data[$value[0]] = $value[2];// $value[2]：参数
                        break;
                    case 'function':
                        $data[$value[0]] = call_user_func($value[2]);//回调函数
                        //$data[$value[0]] = $value[2](); //也行
                        break;
                    default:
                        break;
                }
            }
        }
        return $data;
    }

    //自动验证
    /*
     * 格式 $this->_valid = array(
     *      array('验证的字段名',0/1/2(验证的场景),'报错信息','require(必须)/in(某几种
     *            情况)/between(范围)/length(某个范围)','xxxx')
     * );
     * protected $_valid = array(
        array('goods_name',1,'商品名不能为空','require',''),
        array('cat_id',1,'栏目id必须是整型值','number',''),
        array('shop_price',1,'本店价格必须在0~100000之间','between','0,100000'),
        array('goods_breif',2,'商品简介必须在10到100个字符之间','length','10,100'),
        array('is_new',0,'is_new只能是0或1','in','0,1')
        );
     */
    public function _validate($data){
        if(empty($this->_valid)){ //如果没有验证规则
            return true;
        }else{
            $this->error = array();
            foreach($this->_valid as $key=>$value){
                switch($value[1]){
                    case 1: //必须检验
                        if(!isset($data[$value[0]])){
                            $this->error[] = $value[2];
                            return false;
                        }
                        if(!$this->check($data[$value[0]],$value[3],isset($value[4])?$value[4]:'')){
                            $this->error[] = $value[2];
                            return false;
                        }
                        break;
                    case 0: //字段有就判断，没有就不判断
                        if(isset($data[$value[0]])){ //有字段，但值为空也算,也判断
                            if(!$this->check($data[$value[0]],$value[3],isset($value[4])?$value[4]:'')){
                                $this->error[] = $value[2];
                                return false;
                            }
                        }
                        break;
                    case 2:
                        if(isset($data[$value[0]]) && !empty($data[$value[0]])){
                            //字段有就判断，没有就不判断，值为空不判断
                            if(!$this->check($data[$value[0]],$value[3],isset($value[4])?$value[4]:'')){
                                $this->error[] = $value[2];
                                return false;
                            }
                        }
                        break;
                    default:
                        return true;
                        break;
                }
            }
            return true;
        }
    }

    protected function check($value,$rule='',$parm=''){
        switch($rule){
            case 'require':
                return !empty($value);
                //直接return了就不用break了
            case 'number':
                return is_numeric($value);
            case 'in':
                $tmp = explode(',',$parm);
                return in_array($value,$tmp);
            case 'between':
                list($min,$max) = explode(',',$parm);
                return ($value>=$min && $value<=$max);
            case 'length':
                list($min,$max) = explode(',',$parm);
                return strlen($value)>=$min && strlen($value)<=$max; //可以去用mb_strlen
            case 'email':
                //判断$value是否是email，可以用正则表达式，但这里暂时不用(没学)
                //所以此处用系统函数
                return filter_var($value,FILTER_VALIDATE_EMAIL) !== false;
                //这里如果通过检测则返回email地址，否则返回false，但我们只要true、false即可，所以加上!==好一点。
            default:
                return false;

        }
    }

    public function getErr(){
        return $this->error;
    }


    /*
     * 在model父类里，写最基本的增删改查操作
     */

    //增
    //parm array $data
    //return bool
    public function add($data){
        return $this->db->autoExecute($this->table,$data);
    }

    //删
    //parm int $id 主键
    //return int 影响的行数
    public function delete($id){
        $sql = 'delete from '.$this->table.' where '.$this->primarykey.'='.$id;
        if($this->db->query($sql)){
            return $this->db->affected_rows();
        }else{
            return false;
        }
    }

    //改
    //parm array $data
    //parm int $id
    //return int 影响行数
    public function update($data,$id){
        $rs = $this->db->autoExecute($this->table,$data,'update',' where '.$this->primarykey.'='.$id);
        if($rs){
            return $this->db->affected_rows();
        }else{
            return false;
        }
    }

    //查
    //return 整个Array(暂时)
    public function select(){
        $sql = 'select * from '.$this->table;
        return $this->db->getAll($sql);
    }
    //查一个
    //parm int $id
    //return Array
    public function find($id){
        $sql = 'select * from '.$this->table.' where '.$this->primarykey.'='.$id;
        return $this->db->getRow($sql);
    }

    //返回最新的auto_increment列的自增长的值(mysql.class.php里)
    public function return_auto_increment(){
        return $this->db->insert_id();
    }
}

?>