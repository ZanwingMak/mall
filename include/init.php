<?php

//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
defined('PERMISSION')||exit('非法访问');


//初始化文件
//初始化当前的绝对路径
//换成正接线是因为win/linux都支持正斜线，而linux不支持反斜线。
define('ROOT',str_replace('\\','/',dirname(dirname(__FILE__))).'/');
//define('ROOT',str_replace('\\','/',dirname(__DIR__)).'/'); // __DIR__需要php5.3版本及以上
define('DEBUG',true);

session_start();
if(!isset($_SESSION['history_goods'])){//商品浏览历史
    $_SESSION['history_goods'] = array();
}

//引入

/*
require(ROOT.'include/db.class.php');
require(ROOT.'include/mysql.class.php');
require(ROOT.'Model/Model.class.php');
require(ROOT.'Model/TestModel.class.php');
require(ROOT.'include/conf.class.php');
require(ROOT.'include/log.class.php');
*/

require(ROOT.'include/lib_base.php');
//自动载入(引入)
function __autoload($class){
    if(strtolower(substr($class,-5)) == 'model'){
        require(ROOT.'Model/'.$class.'.class.php');
    }elseif(strtolower(substr($class,-5)) == 'tools'){
        require(ROOT.'tool/'.$class.'.class.php');
    }else{
        require(ROOT.'include/'.$class.'.class.php');
    }

}

//过滤参数，用地柜的方式过滤$_GET,$_POST,$_COOKIE
$_GET = _addslashes($_GET);
$_POST = _addslashes($_POST);
$_COOKIE = _addslashes($_COOKIE);

//报错级别
if(defined('DEBUG')){
    error_reporting(E_ALL);
}else{
    error_reporting(0);
}


?>