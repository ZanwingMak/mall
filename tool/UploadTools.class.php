<?php

//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
defined('PERMISSION')||exit('非法访问');

/*
 * 单文件上传类
 */

/*
 * 上传文件
 * 配置允许的后缀
 * 配置允许的大小
 * 随机生成目录
 * 随机生成文件名
 *
 * 获取文件的后缀
 * 判断文件的后缀
 *
 * 良好的报错的支持
 */
class UploadTools{
    protected $allowExt = 'jpg,jpeg,gif,png,bmp';
    protected $maxSize = 1; //2M，M为单位

    //protected $file = NULL; //准备储存上传文件的信息用的

    protected $errorno = 0;//错误代码
    protected $error = array(
        0 => '没有错误',
        1 => '上传文件超出系统限制',
        2 => '上传文件大小超出网页表单页面',
        3 => '文件只有部分被上传',
        4 => '没有文件被上传',
        // 5呢？
        6 => '找不到临时文件夹',
        7 => '文件写入失败',
        8 => '不允许的文件类型',
        9 => '文件大小超出了类的允许范围',
        10 => '创建目录失败',
        11 => '文件移动失败'
    );

    public function upload($key){
        if(!isset($_FILES[$key])){
            return false;
        }

        $file = $_FILES[$key];

        //检验上传有没有成功
        if($file['error'] != 0){
            $this->errorno = $file['error'];
            return false;
        }

        //检查后缀
        $ext = $this->getExt($file['name']);
        if(!$this->isAllowExt($ext)){
            $this->errorno = 8;
            return false;
        }
        //检查大小
        if(!$this->isAllowSize($file['size'])){
            $this->errorno = 9;
            return false;
        }

        //通过

        //创建目录
        $dir = $this->mk_dir($key);
        if($dir == false){
            $this->errorno = 10;
            return false;
        }
        //生成随机文件名
        $newname = $this->randName().'.'.$ext;
        $file_path = $dir.'/'.$newname;
        //移动
        if(!move_uploaded_file($file['tmp_name'],$file_path)){
            $this->errorno = 11;
            return false;
        }

        //上传成功
        return str_replace(ROOT,'',$file_path);
        //把ROOT路径替换成空字符串，因为图片路径不应该用绝对路径来保存在数据库里
    }

    //获取错误信息
    public function getErr(){
        return array('err_msg'=>$this->error[$this->errorno],'err_code'=>$this->errorno);
    }


    /*
    protected function getFile($key){
        $this->file = $_FILES[$key]; //  $_FILES['file']  为了方便，
                                     //  如$this->file['name']，$this->file['size']
    }
     */

    /*
     * parm String $file
     * return String $ext 后缀
     */
    protected function getExt($name){
        $tmp = explode('.',$name);
        return end($tmp);
    }

    /*
     * parm string $exts 允许的后缀
     */
    public function setExt($exts){
        $this->allowExt = $exts;
    }
    //允许的文件大小
    public function setSize($num){
        $this->maxSize = $num;
    }

    /*
     * parm String $ext 后缀
     * return bool
     */
    protected function isAllowExt($ext){
        //防止后缀大小写问题
        return in_array(strtolower($ext),explode(',',strtolower($this->allowExt)));
    }

    //检查文件的大小
    protected function isAllowSize($size){
        return $size <= ($this->maxSize * 1024 * 1024);
    }

    //按日期创建目录的方法
    protected function mk_dir($key){
        $dir = ROOT.'data/images/'.date('Ymd',time()).'/'.$key;  //应该Ymd即可，当前为及时获得效果，所以加上时分
        //创建目录
        if(is_dir($dir)){
            return $dir;
        }else{
            mkdir($dir,0777,true); // 0777：权限，true：级联目录
            return $dir;
        }
        /*
        //短路判断方法
        if(is_dir($dir)||mkdir('./'.$dir,0777,true)){
            return $dir;
        }else{
            return false;
        }
        */
    }
    //生成随机文件名
    protected function randName($length = 20){
        $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz0123456789';
        return substr(str_shuffle($str),0,$length); //打乱顺序，截取前20位
    }

}

/*
 * 多文件上传类
 */

?>