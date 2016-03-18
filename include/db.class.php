<?php

//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
defined('PERMISSION')||exit('非法访问');


//数据库类
//因为不清楚到底采用什么数据库，所以写个接口

abstract class db{
    /*
    连接数据库
    parms $host 服务器地址
    parms $username 用户名
    parms $password 密码
    return bool
    */
    public abstract function connect($host,$username,$password);

    /*
    发送查询
    parms $sql 发送的sql语句
    return mixed bool/resource
    */
    public abstract function query($sql);

    /*
    查询多行数据
    parms $sql selecet型语句
    return array/bool
    */
    public abstract function getAll($sql);

    /*
    查询单行数据
    parms $sql selecet型语句
    return array/bool
    */
    public abstract function getRow($sql);

    /*
    查询单个数据
    parms $sql selecet型语句
    return array/bool
    */
    public abstract function getOne($sql);

    /*
    自动执行insert/update语句
    parms $sql selecet型语句
    return array/bool

    $this->autoExecute('user',array('username'=>'zhangsan','email'=>'zhangsan@gmail.com'),'insert');
    将自动形成 insert into user (username,email) values ('zhangsan','zhangsan@gmail.com');
    */
    public abstract function autoExecute($table,$data,$act='insert',$where='');



}


?>