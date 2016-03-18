<?php

//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
defined('PERMISSION')||exit('非法访问');


//递归转义数组
function _addslashes($arr){
    foreach($arr as $key=>$value){
        if(is_string($value)){
            $arr[$key] = addslashes($value);
        }elseif(is_array($value)){ //如果是数组，调用自身再次转义
            $arr[$key] = _addslashes($value);
        }
    }
    return $arr;
}

?>