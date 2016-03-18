<?php
define('PERMISSION',true);
//定义一个变量为true，然后在“禁止用户直接地址栏访问的文件”里检测该变量，
//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
require('../include/init.php');


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
            $cat_id = $_POST['cat_id'] + 0;
        }
    //print_r($data);

    //调用model来更改
        $cat = new CatModel();

        $trees = $cat->getTree($data['parent_id']);
        $flag = true;
        foreach($trees as $value){
            if($value['cat_id'] == $cat_id){
                $flag = false;
                break;
            }
        }
        if(!$flag){
            exit('上级分类选择有误');
        }

        if($cat ->update($data,$cat_id)){
            header("refresh:5;url=catelist.php");
            echo '修改成功,5秒后自动返回分类列表。';
            echo '&nbsp;<span><a href="javascript:history.go(-1);">&#9666;返回上一步</a></span>';
        }else{
            echo '修改失败';
            echo '&nbsp;<span><a href="javascript:history.go(-1);">&#9666;返回上一步</a></span>';
        }
}elseif(isset($_SESSION['username']) && $_SESSION['username']!='admin' && isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
    echo '您不是管理员，请使用管理员账号进行<span><a href="../login.php">登录</a></span>';
}else{
    header("refresh:5;url=../login.php");
    echo '系统出错,5秒后自动前往用户登录界面。';
}




?>