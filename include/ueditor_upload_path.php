<?php

//ueditor编辑器文件上传路径前缀,后缀在 lib/ueditor/php目录里配置

define('UPLOADROOT',str_replace($_SERVER['DOCUMENT_ROOT'],'',str_replace('\\','/',dirname(dirname(__FILE__))).'/'));
//print_r(UPLOADROOT);

?>