<?php

//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
defined('PERMISSION')||exit('非法访问');


//记录信息到日志
//如果文件大于1M，备份并新建一份。
class log{

    const LOGFILE = 'curr.log';//日志文件名称

    //写日志
    public static function write($cont){
        $cont .= "\r\n";
        //判断是否需要备份
        $log = self::isBak();//返回日志文件的地址/路径
        $fh = fopen($log,'ab');
        fwrite($fh,$cont);
        fclose(($fh));
    }
    //备份日志
    public static function bak(){
        //把日志文件改名并存储起来
        $log = ROOT.'data/log/'.self::LOGFILE;
        $bak = ROOT.'data/log/'.date('YmdHis').'.bak';
        if(file_exists($bak)){
            $bak = ROOT.'data/log/'.date('YmdHis').'_'.mt_rand(10000,99999).'.bak';
        }
        return rename($log,$bak);
    }
    //获取并判断日志的大小
    public static function isBak(){
        $log = ROOT.'data/log/'.self::LOGFILE;
        if(!file_exists($log)){//如果文件不存在
            touch($log);//快速创建文件
            return $log;
        }
        //如果存在，判断大小
        //先清除缓存
        clearstatcache(true,$log);
        $size = filesize($log);
        if($size<=1024*1024){  //小于1M
            return $log;
        }
        // 大于1M
        if(!self::bak()){
            return $log;
        }else{
            touch($log);
            return $log;
        }
    }
}

?>