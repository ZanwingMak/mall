演示地址：http://12450.xyz/mall
Github：https://github.com/maizhenying09/mall
代码：http://pan.baidu.com/s/1mh0TRtQ 密码: t36d

记得先到目录include打开config.inc.php修改数据库配置

然后导入数据库数据

mall_insert.sql 有数据

mall.sql 无数据，最好自己重新创建，添加数据。

然后到127.0.0.1/register.php注册admin用户名

进入后台：127.0.0.1/admin

添加商品分类和商品

注意：

./include/init.php

define('ROOT',str_replace('\','/',dirname(dirname(FILE))).'/');

路径是：/服务器根目录到商城根目录/

./include/ueditor_upload_path.php

define('UPLOADROOT',str_replace($SERVER['DOCUMENT_ROOT'],'',str_replace('\','/',dirname (dirname(__FILE_))).'/'));

路径是：/商城根目录/

数据库的goods表 goods_desc列是商品说明

路径可能不适合你的环境 需要自己改一下，批量替换一下就好了