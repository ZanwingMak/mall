演示地址：http://mall.laji.blog

原文：http://laji.blog/archives/code/php/2016/03/19/mall.html

Github：https://github.com/xiaomai0830/mall

---------------

API使用方法[format不传默认json]：

单个商品信息[支持xml和json,返回商品的所有信息]：

xxxx.com/mall/api/goods/info?goods_id=24&format=xml

xxxx.com/mall/api/goods/info?goods_sn=AUTOSN20160507723873&format=json

分类下的所有商品[只支持json,返回[goods_id商品ID:goods_name商品名称]]：

xxxx.com/mall/api/goods/info?cat_id=4&format=json

---------------

记得先到目录include打开config.inc.php修改数据库配置

然后导入数据库数据

mall_with_data.sql 有数据

mall_without_data.sql 无数据，最好自己重新创建，添加数据，记得到data目录下把以前的数据删了。

然后到127.0.0.1/register.php注册admin用户名

进入后台：127.0.0.1/admin

添加商品分类和商品

首页轮播banner：

在banner目录里，请使用notepad++等高级工具来编辑imgs_links.ini，不要用记事本！

下载地址：https://notepad-plus-plus.org/download/

如果没有banner目录和imgs_links.ini，访问首页后会自动生成，请按照例子进行配置。

当首个字符为';'时，表示无视该行(注释)，如需生效请删除';'

banner图片请放在banner目录下,尺寸730x426。


注意：

./include/init.php

define('ROOT',str_replace('\','/',dirname(dirname(FILE))).'/');

路径是：/服务器根目录到商城根目录/

./include/ueditor_upload_path.php

define('UPLOADROOT',str_replace($SERVER['DOCUMENT_ROOT'],'',str_replace('\','/',dirname (dirname(__FILE_))).'/'));

路径是：/商城根目录/

数据库的goods表 goods_desc列是商品说明

路径可能不适合你的环境 需要自己改一下，批量替换一下就好了
