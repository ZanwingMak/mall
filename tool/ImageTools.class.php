<?php

//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
defined('PERMISSION')||exit('非法访问');

class ImageTools{
    //分析图片的信息
    //return array()
    protected static function imageInfo($image_path){
        //判断图片是否存在
        if(!file_exists($image_path)){
            return false;
        }
        $info = getimagesize($image_path);
        if($info == false){
            return false;
        }
        list($img['width'],$img['height'],$img['ext_code']) = $info;
        $tmp = explode('/',$info['mime']);
        $img['ext'] = $tmp[1];
        return $img;
    }

    /*
     * 加水印功能
     * parm String $dst 待操作图片
     * parm String $watermark 水印小图
     * parm String $save_path 保存路径，不填则默认替换原始图
     * pos 水印位置：0左上角，1右上角，2右下角，3左下角，4正中间
     * alpha 透明度
     */
    public static function addWatermark($dst,$watermark,$save_path=NULL,$pos=2,$alpha=50){
        //先保证2个图片都存在
        if(!file_exists($dst) || !file_exists($watermark)){
            return false;
        }
        $dinfo = self::imageInfo($dst);
        $winfo = self::imageInfo($watermark);
        if($winfo['width']>$dinfo['width'] || $winfo['height']>$dinfo['height']){
            return false;
        }
        //这里是动态函数，下面要动态加载
        $dfunc = 'imagecreatefrom'.$dinfo['ext'];
        $wfunc = 'imagecreatefrom'.$winfo['ext'];

        if(!function_exists($dfunc) || !function_exists($wfunc)){
            return false;
        }

        //动态加载函数来创建画布
        $dimg = $dfunc($dst);
        $wimg = $wfunc($watermark);

        //水印缩放(水印视大图尺寸而进行缩放)
        $wwidth = $winfo['width'];
        $wheight = $winfo['height'];
        $wimg_p = $wimg;
        if(($dinfo['width']/$winfo['width'])<10){
            //$percent = round($winfo['width']/$dinfo['width'],4);
            //$percent = 1.1 - $percent; //如果设成1的话，当percent=0时就挂了
            $percent = 1.1 - min($winfo['width']/$dinfo['width'],$winfo['height']/$dinfo['height']);
            $wwidth = $winfo['width']*$percent;
            $wheight = $winfo['height']*$percent;
            //创建新画布（新尺寸）
            $wimg_p = imagecreatetruecolor($wwidth,$wheight);
            imagecopyresampled($wimg_p,$wimg,0,0,0,0,$wwidth,$wheight, $winfo['width'],$winfo['height']);
        }
        //水印位置的坐标
        switch($pos){
            case 0: //左上角
                $posx = 0+5;
                $posy = 0+5;
                break;
            case 1: //右上角
                $posx = $dinfo['width']-$wwidth-10;
                $posy = 0+5;
                break;
            case 3: //左下角
                $posx = 0+5;
                $posy = $dinfo['height']-$wheight-10;
                break;
            case 4: //正中间
                $posx = $dinfo['width']/2-$wwidth/2;
                $posy = $dinfo['height']/2-$wheight/2;
                break;
            default: //默认：右下角
                $posx = $dinfo['width']-$wwidth-10;
                $posy = $dinfo['height']-$wheight-10;
                break;
        }

        //加水印(如何做到支持透明水印呢？)
        imagecopymerge($dimg,$wimg_p,$posx,$posy,0,0,$wwidth,$wheight,$alpha);

        //保存
        if(!$save_path){//如果没传保存路径过来
            $save_path = $dst;
            unlink($dst);//删除原图
        }
        if(!is_dir(dirname($save_path))){
            mkdir(dirname($save_path),0777,true); // 0777：权限，true：级联目录
        }
        $createfunc = 'image'.$dinfo['ext'];
        $createfunc($dimg,$save_path);

        //test:
        //header("Content-type: " . image_type_to_mime_type($dinfo['ext_code']));
        //$createfunc($dimg);

        imagedestroy($wimg_p);
        imagedestroy($wimg);
        imagedestroy($dimg);

        return true;
    }

    /*
     * 等比例缩放，两边留白
     */
    public static function thumb($dst,$save_path=NULL,$width=200,$height=200){
        //判断待处理的图片是否存在
        $dinfo = self::imageInfo($dst);
        if($dinfo == false){
            return false;
        }
        //计算缩放比例
        $calc = min($width/$dinfo['width'],$height/$dinfo['height']);
        //创建原始图的画布
        $dfunc = 'imagecreatefrom'.$dinfo['ext'];
        $dimg = $dfunc($dst);
        //创建缩略图画布
        $timg = imagecreatetruecolor($width,$height);
        //创建白色填充缩略画布
        $white = imagecolorallocate($timg,255,255,255);
        //填充缩略画布
        imagefill($timg,0,0,$white);
        //复制并缩略
        $dwidth = (int)$dinfo['width']*$calc;
        $dheight = (int)$dinfo['height']*$calc;
        $paddingx = (int)($width-$dwidth)/2;
        $paddingy = (int)($height-$dheight)/2;
        imagecopyresampled($timg,$dimg,$paddingx,$paddingy,0,0,$dwidth,$dheight,$dinfo['width'],$dinfo['height']);
        //保存图片
        if(!$save_path){
            $save_path = $dst;
            unlink($dst);
        }
        if(!is_dir(dirname($save_path))){
            mkdir(dirname($save_path),0777,true); // 0777：权限，true：级联目录
        }
        $createfunc = 'image'.$dinfo['ext'];
        $createfunc($timg,$save_path);

        //test:
        //header('Content-type: '.image_type_to_mime_type($dinfo['ext_code']));
        //$createfunc($timg);

        imagedestroy($dimg);
        imagedestroy($timg);
        return true;
    }

    //验证码
    public static function vcode($width=60,$height=30){

        $dst = imagecreatetruecolor($width,$height);
        $src = imagecreatetruecolor($width,$height);
        //不填充默认黑色
        //背景
        $dst_bg = imagecolorallocate($dst,0,0,0); //黑色
        $src_bg = imagecolorallocate($src,0,0,0); //黑色
        imagefill($dst,0,0,$dst_bg);
        imagefill($src,0,0,$src_bg);

        //写字
        //imagestring 水平地华一行字符串

        //bool imagestring(resource $image,int $font,int $x,int $y,string $s,int $col)
        //画布资源，字体大小（1-5），字符最左上角的x坐标，y坐标，要写的字符，颜色
        function one_vcode($src,$lv,$width,$height){
            $str = substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789'),0,1);
            $rand_color = imagecolorallocate($src,mt_rand(100,255),mt_rand(100,255),mt_rand(100,255));
            $size = mt_rand(4,5);
            $x = $lv*12 + mt_rand(2,$width/4-10)+$size;
            $y = mt_rand($height*0.1,$height*0.4);
            imagestring($src,$size,$x,$y,$str,$rand_color);
            return $str;
        }

        $vcode = '';
        for($i=0;$i<4;$i++){
            $vcode = $vcode.one_vcode($src,$i,$width,$height);
        }

        //验证码扭曲
        for($i=0;$i<$width;$i++){
            //根据正弦曲线计算上下波动的posY
            $offset = 4; //最大波动几个像素
            $round = 1; //扭曲2个周期，即4PI
            $posY = round(sin($i*$round*2*M_PI/60)*$offset);//根据正弦曲线，计算偏移
            imagecopy($dst,$src,$i,$posY,$i,0,1,25);
        }


        //干扰线
        for($i=0;$i<mt_rand(1,2);$i++){
            imageline($dst,0,mt_rand($height*0.1,$height*0.9),$width,mt_rand($height*0.1,$height*0.9),imagecolorallocate($dst,mt_rand(150,255),mt_rand(150,255),mt_rand(150,255)));
        }

        $vcode = strtolower($vcode);
        //echo $vcode;

        header('content-type: image/jpeg');
        imagejpeg($dst);

        imagedestroy($src);
        imagedestroy($dst);

        return $vcode; //返回验证码字符串
    }

}

?>