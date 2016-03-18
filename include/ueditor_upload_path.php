<?php

//ueditor编辑器文件上传路径前缀,后缀在 lib/ueditor/php目录里配置
//获取服务器根目录目录到商城目录的路径
define('UPLOADROOT',str_replace($_SERVER['DOCUMENT_ROOT'],'',str_replace('\\','/',dirname(dirname(__FILE__))).'/'));
//print_r(UPLOADROOT);

?>