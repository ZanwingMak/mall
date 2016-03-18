<?php

//用户登录页面
define('PERMISSION',true);
//定义一个变量为true，然后在“禁止用户直接地址栏访问的文件”里检测该变量，
//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
require('./include/init.php');
if(isset($_POST['act']) && $_POST['act'] == 'act_login'){
    if(strtolower($_POST['vcode'])!=strtolower($_COOKIE['vcode'])){
        header("refresh:2;url=login.php");
        $msg = '验证码不正确...2秒后自动跳转到登录页面';
        include(ROOT.'view/front/msg.html');
        exit;
    }else{
        setcookie('vcode','',time()-1);
    }
    //说明是点击了登录按钮过来的
    //接收用户名和密码，进行验证...
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = new UserModel();

    //合法性检测

    if(!$user->set_valid(array(
        array('username',1,' 请填写用户名','require'),
        array('username',1,'用户名必须在5-25个字符内','length','5,25'),
        array('password',1,'请输入密码','require'),
        array('password',1,'密码必须在8-25个字符内','length','8,25')
    ))){
        header("refresh:5;url=index.php");
        $msg = '登录系统出错,请稍后再试...5秒后自动跳转到商城首页';
        include(ROOT.'view/front/msg.html');
        exit;
    }

    if(!$user->_validate($_POST)){
        $msg = implode('<br/>',$user->getErr());
        include(ROOT.'view/front/msg.html');
        exit;
    }

    //核对用户名和密码
    $row = $user->checkUser($username,$password);
    if(empty($row)){
        header("refresh:3;url=login.php");
        $msg = '用户名或密码不正确...3秒后自动跳转到登录页面 ';
    }else{
        $lastlogin = $row['lastlogin'];
        if($lastlogin == '0'){
            $lastlogintime = '首次登录';
        }else{
            $lastlogintime = date('Y-m-d H:i:s',$lastlogin);
        }
        $user->setLastloginTime($row['user_id']);
        header("refresh:3;url=index.php");
        $msg = '登录成功(上次登录时间：'.$lastlogintime.')...3秒后自动跳转到商城首页';
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['last_login'] = $lastlogintime;
        if(isset($_POST['remember']) && $_POST['remember']==1){
            setcookie('remember_username',$username,time()+14*24*60*60);
        }elseif(isset($_SESSION['username']) && !isset($_POST['remember'])){
            setcookie('remember_username',$username,time()-1);
        }
    }
    include(ROOT.'view/front/msg.html');

}elseif(isset($_SESSION['username'])){
    if(isset($_GET['act'])&&$_GET['act']=='exit') {
        unset($_SESSION['username']);
        $car = CarTools::getCar();
        $car->clearCar();
        header("refresh:3;url=login.php");
        $msg = '退出登录成功...3秒后自动跳转到登录页面';
    }else{
        header("refresh:3;url=index.php");
        $msg = '您已经登录了,不能进行该操作...3秒后自动跳转到商城首页';
    }
    include(ROOT.'view/front/msg.html');
}else{
    //准备登录

    include(ROOT.'./view/front/denglu.html');
}

?>