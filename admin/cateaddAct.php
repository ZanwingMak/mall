<?php
define('PERMISSION',true);
//定义一个变量为true，然后在“禁止用户直接地址栏访问的文件”里检测该变量，
//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
require('../include/init.php');
/*
 * 作用：
 * 接收cateadd.php表单页面发来的数据
 * 并调用model，把数据库入库
 */

if( !isset($_SESSION['username'])||empty($_SESSION['username']) || !isset($_SESSION['user_id']) || empty($_SESSION['user_id']) ){
    echo '请先<span><a href="../login.php">登录</a></span>';
}elseif(isset($_SESSION['username']) && $_SESSION['username']=='admin' && isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) ){
    //接收数据
    //print_r($_POST);

    //检验数据
        $data = array();
        if(empty($_POST['cat_name'])){
            exit('栏目名不能为空&nbsp;<span><a href="javascript:history.go(-1);">&#9666;返回上一步</a></span>');
        }elseif(false){//判断intro及父栏目id是否合法

        }else{
            $data['cat_name'] = $_POST['cat_name'];
            $data['parent_id'] = $_POST['parent_id'];
            $data['intro'] = $_POST['intro'];
        }
    //print_r($data);



    //实例化model，并调用model的相关方法
        $cat = new CatModel();
        if($cat->add($data)){ //不应该在这里直接echo应该交给view，现在暂时这样
            header("refresh:5;url=catelist.php");
            echo '栏目添加成功,5秒后自动返回分类列表。';
            echo '&nbsp;<span><a href="javascript:history.go(-1);">&#9666;返回上一步</a></span>';
        }else{
            echo '栏目添加失败';
            echo '&nbsp;<span><a href="javascript:history.go(-1);">&#9666;返回上一步</a></span>';
        }
}elseif(isset($_SESSION['username']) && $_SESSION['username']!='admin' && isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
    echo '您不是管理员，请使用管理员账号进行<span><a href="../login.php">登录</a></span>';
}else{
    header("refresh:5;url=../login.php");
    echo '系统出错,5秒后自动前往用户登录界面。';
}




?>