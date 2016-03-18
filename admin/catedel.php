<?php

define('PERMISSION',true);
//定义一个变量为true，然后在“禁止用户直接地址栏访问的文件”里检测该变量，
//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
require('../include/init.php');

/*
 * 思路：
 * 接收cat_id
 * 调用model
 * 删除cat_id
 */
if( !isset($_SESSION['username'])||empty($_SESSION['username']) || !isset($_SESSION['user_id']) || empty($_SESSION['user_id']) ){
    echo '请先<span><a href="../login.php">登录</a></span>';
}elseif(isset($_SESSION['username']) && $_SESSION['username']=='admin' && isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) ){
    $cat_id = $_GET['cat_id'] + 0;

    /*
     * 判断该栏目是否有子栏目
     * 如果有子栏目，则该栏目不允许删除
     *
     * 思路：
     * 无限级分类有3个基本应用
     * 1：查子栏目
     * 2：查子孙栏目
     * 3：查家谱树
     *
     * 我们可以再model里写一个方法，专门查子栏目
     * 调用一下，并判断
     */

    $cat = new CatModel();

    $sons = $cat->getSon($cat_id);
    if(!empty($sons)){
        exit('该分类下有子栏目，不允许删除。&nbsp;<span><a href="javascript:history.go(-1);">&#9666;返回上一步</a></span>');
    }


    if($cat->delete($cat_id)){
        header("refresh:5;url=catelist.php");
        echo '删除成功,5秒后自动返回分类列表。';
        echo '&nbsp;<span><a href="javascript:history.go(-1);">&#9666;返回上一步</a></span>';
    }else{
        echo '删除失败';
        echo '&nbsp;<span><a href="javascript:history.go(-1);">&#9666;返回上一步</a></span>';
    }
}elseif(isset($_SESSION['username']) && $_SESSION['username']!='admin' && isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
    echo '您不是管理员，请使用管理员账号进行<span><a href="../login.php">登录</a></span>';
}else{
    header("refresh:5;url=../login.php");
    echo '系统出错,5秒后自动前往用户登录界面。';
}

?>