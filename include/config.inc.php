<?php

//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
defined('PERMISSION')||exit('非法访问');


//配置文件

$_CFG = array();

$_CFG['host'] = 'localhost';
$_CFG['username'] = 'root';
$_CFG['password'] = '123456';
$_CFG['db'] = 'mall';
$_CFG['char'] = 'utf8'; //如果要utf8，不要写utf-8



?>