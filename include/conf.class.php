<?php

//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
defined('PERMISSION')||exit('非法访问');


//配置文件读写类
class conf{
    protected static $ins = null;
    protected $data = array();
    final protected function __construct(){
        //一次性吧配置文件信息度过来，赋给data属性
        //以后就不用再管配置文件了
        //再要配置的值时，直接从data属性里找就可以了
        include(ROOT.'include/config.inc.php');
        $this->data = $_CFG;
    }
    final protected function __clone(){
    }

    public static function getIns(){
        if(self::$ins instanceof self){//如果是自身的实例
            return self::$ins;
        }else{
            self::$ins = new self();
            return self::$ins;
        }
    }

    //用魔术方法，读取data内的信息
    public function __get($key){
        if(array_key_exists($key,$this->data)){
            return $this->data[$key];
        }else{
            return null;
        }
    }

    //用魔术方法，再运行期，动态增加或改变配置选项
    public function __set($key,$value){
        $this->data[$key] = $value;
    }

}
/* 调试
$conf = conf::getIns();
//读取并存储ok
//print_r($conf);

echo $conf->host.'<br>';
echo $conf->username.'<br>';
var_dump($conf->shabi);

//动态的追加选项
echo $conf->shabi = '傻逼!';
*/

?>