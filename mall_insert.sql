-- --------------------------------------------------------
-- 主机:                           127.0.0.1
-- 服务器版本:                        5.5.47 - MySQL Community Server (GPL)
-- 服务器操作系统:                      Win32
-- HeidiSQL 版本:                  9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 导出 mall 的数据库结构
CREATE DATABASE IF NOT EXISTS `mall` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `mall`;


-- 导出  表 mall.category 结构
CREATE TABLE IF NOT EXISTS `category` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `intro` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  mall.category 的数据：20 rows
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` (`cat_id`, `cat_name`, `intro`, `parent_id`) VALUES
	(4, '动漫周边', '', 3),
	(3, 'ACGN相关', '', 0),
	(5, 'BD', '', 12),
	(6, '游戏', '', 3),
	(7, 'PS', '', 6),
	(8, 'XBOX', '', 6),
	(10, '漫画', '', 3),
	(11, '轻小说', '', 3),
	(12, '动画', '', 3),
	(13, 'DVD', '', 12),
	(14, '音乐', '', 3),
	(15, 'CD', '', 14),
	(16, '海报', '', 14),
	(18, '水杯', '', 4),
	(20, '手办', '', 4),
	(21, 'T - shirt', '', 4),
	(22, '背包', '', 4),
	(23, '抱枕', '', 4),
	(24, '正版', '', 20),
	(25, '国产', '', 20);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;


-- 导出  表 mall.goods 结构
CREATE TABLE IF NOT EXISTS `goods` (
  `goods_id` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `goods_sn` char(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cat_id` smallint(8) NOT NULL DEFAULT '0',
  `brand_id` smallint(8) NOT NULL DEFAULT '0',
  `goods_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `weight` double(10,2) NOT NULL DEFAULT '0.00',
  `shop_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `goods_number` smallint(8) NOT NULL DEFAULT '1',
  `click_count` decimal(8,3) NOT NULL DEFAULT '0.000',
  `goods_brief` varchar(300) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `goods_desc` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `thumb_img` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `goods_img` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ori_img` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `is_on_sale` tinyint(4) NOT NULL DEFAULT '1',
  `is_delete` tinyint(4) NOT NULL DEFAULT '0',
  `is_best` tinyint(4) NOT NULL DEFAULT '0',
  `is_new` tinyint(4) NOT NULL DEFAULT '0',
  `is_hot` tinyint(4) NOT NULL DEFAULT '0',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `last_update` int(10) unsigned NOT NULL DEFAULT '0',
  `keywords` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`goods_id`),
  UNIQUE KEY `goods_sn` (`goods_sn`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  mall.goods 的数据：18 rows
/*!40000 ALTER TABLE `goods` DISABLE KEYS */;
INSERT INTO `goods` (`goods_id`, `goods_sn`, `cat_id`, `brand_id`, `goods_name`, `weight`, `shop_price`, `market_price`, `goods_number`, `click_count`, `goods_brief`, `goods_desc`, `thumb_img`, `goods_img`, `ori_img`, `is_on_sale`, `is_delete`, `is_best`, `is_new`, `is_hot`, `add_time`, `last_update`, `keywords`) VALUES
	(1, 'AUTOSN20160311110350', 4, 0, '尚萌特供 礼物 开学福袋 动漫福袋 shamoe傻萌 动漫周边福利', 0.00, 98.00, 198.00, 999, 0.000, '', '<p><img src="/mall/data/upload/image/20160317/TB2.lADdXXXXXbUXpXXXXXXXXXX_!!349072314.jpg" alt="TB2.lADdXXXXXbUXpXXXXXXXXXX_!!349072314.jpg"/></p>', 'data/images/20160311/ori_img/../thumb_img/thumb_4VyoH1fWp30mcAeiL6Mb.jpg', 'data/images/20160311/ori_img/../goods_img/goods_4VyoH1fWp30mcAeiL6Mb.jpg', 'data/images/20160311/ori_img/4VyoH1fWp30mcAeiL6Mb.jpg', 1, 0, 0, 1, 1, 1457633383, 0, ''),
	(2, 'AUTOSN20160311586473', 21, 0, '预售包邮 初音未来miku 魔术师初音 动漫白色T恤 二次元双面短袖', 10.00, 69.00, 169.00, 200, 0.000, '', '<p><img src="/mall/data/upload/image/20160317/TB26B9.kFXXXXccXXXXXXXXXXXX_!!349072314.jpg"/></p>', 'data/images/20160311/ori_img/../thumb_img/thumb_9zvZnK0uYwFcmeWjtx1H.jpg', 'data/images/20160311/ori_img/../goods_img/goods_9zvZnK0uYwFcmeWjtx1H.jpg', 'data/images/20160311/ori_img/9zvZnK0uYwFcmeWjtx1H.jpg', 1, 0, 1, 1, 0, 1457633469, 0, ''),
	(3, 'AUTOSN20160311962835', 22, 0, '尚萌 Love Live 南小鸟 动漫原宿学生单肩书包 电脑包 包邮', 0.00, 99.00, 199.00, 100, 0.000, '', '<p><img src="/mall/data/upload/image/20160317/TB2Cmo.jVXXXXbpXXXXXXXXXXXX_!!349072314.jpg" alt="TB2Cmo.jVXXXXbpXXXXXXXXXXXX_!!349072314.jpg"/><img src="/mall/data/upload/image/20160317/TB2jZ33jVXXXXcnXXXXXXXXXXXX_!!349072314.jpg" alt="TB2jZ33jVXXXXcnXXXXXXXXXXXX_!!349072314.jpg"/><img src="/mall/data/upload/image/20160317/TB2c8IQjVXXXXalXpXXXXXXXXXX_!!349072314.jpg" alt="TB2c8IQjVXXXXalXpXXXXXXXXXX_!!349072314.jpg"/><img src="/mall/data/upload/image/20160317/TB2JRU_jVXXXXbuXXXXXXXXXXXX_!!349072314.jpg" alt="TB2JRU_jVXXXXbuXXXXXXXXXXXX_!!349072314.jpg"/><img src="/mall/data/upload/image/20160317/TB2DzExjVXXXXXeXFXXXXXXXXXX_!!349072314.jpg" alt="TB2DzExjVXXXXXeXFXXXXXXXXXX_!!349072314.jpg"/><img src="/mall/data/upload/image/20160317/TB2ZJJbkXXXXXa5XXXXXXXXXXXX_!!349072314.jpg" alt="TB2ZJJbkXXXXXa5XXXXXXXXXXXX_!!349072314.jpg"/><img src="/mall/data/upload/image/20160317/TB2wO.tjVXXXXXjXFXXXXXXXXXX_!!349072314.jpg" alt="TB2wO.tjVXXXXXjXFXXXXXXXXXX_!!349072314.jpg"/><img src="/mall/data/upload/image/20160317/TB23kw9jVXXXXbTXXXXXXXXXXXX_!!349072314.jpg" alt="TB23kw9jVXXXXbTXXXXXXXXXXXX_!!349072314.jpg"/></p>', 'data/images/20160311/ori_img/../thumb_img/thumb_n5dX0PyQtiMf3xqhYkHc.jpg', 'data/images/20160311/ori_img/../goods_img/goods_n5dX0PyQtiMf3xqhYkHc.jpg', 'data/images/20160311/ori_img/n5dX0PyQtiMf3xqhYkHc.jpg', 1, 0, 1, 1, 0, 1457633547, 0, ''),
	(4, 'AUTOSN20160311288864', 22, 0, '现货包邮 缘之空 周边 春日野穹 穹妹 动漫原宿电脑双肩背包书包', 0.00, 98.00, 198.00, 300, 0.000, '', '<p><img src="/mall/data/upload/image/20160317/TB2cIqhgVXXXXaEXXXXXXXXXXXX_!!349072314.jpg" alt="TB2cIqhgVXXXXaEXXXXXXXXXXXX_!!349072314.jpg"/><img src="/mall/data/upload/image/20160317/TB2No9mgVXXXXXzXXXXXXXXXXXX_!!349072314.jpg" alt="TB2No9mgVXXXXXzXXXXXXXXXXXX_!!349072314.jpg"/><img src="/mall/data/upload/image/20160317/TB2nYGegVXXXXbdXXXXXXXXXXXX_!!349072314.jpg" alt="TB2nYGegVXXXXbdXXXXXXXXXXXX_!!349072314.jpg"/><img src="/mall/data/upload/image/20160317/TB2oWRPgVXXXXcnXpXXXXXXXXXX_!!349072314.jpg" alt="TB2oWRPgVXXXXcnXpXXXXXXXXXX_!!349072314.jpg"/><img src="/mall/data/upload/image/20160317/TB2GtN.gVXXXXcmXXXXXXXXXXXX_!!349072314.jpg" alt="TB2GtN.gVXXXXcmXXXXXXXXXXXX_!!349072314.jpg"/><img src="/mall/data/upload/image/20160317/TB24V8TgVXXXXboXpXXXXXXXXXX_!!349072314.jpg" alt="TB24V8TgVXXXXboXpXXXXXXXXXX_!!349072314.jpg"/><img src="/mall/data/upload/image/20160317/TB2aTJTgVXXXXa9XpXXXXXXXXXX_!!349072314.jpg" alt="TB2aTJTgVXXXXa9XpXXXXXXXXXX_!!349072314.jpg"/></p>', 'data/images/20160311/ori_img/../thumb_img/thumb_eQO2vLS4X8UYVo5EzfZH.jpg', 'data/images/20160311/ori_img/../goods_img/goods_eQO2vLS4X8UYVo5EzfZH.jpg', 'data/images/20160311/ori_img/eQO2vLS4X8UYVo5EzfZH.jpg', 1, 0, 0, 1, 1, 1457633583, 0, ''),
	(5, 'AUTOSN20160311873627', 22, 0, '包邮 初音未来snow miku 铃兰花雪初音 动漫周边原宿双肩学生书包', 0.00, 98.00, 198.00, 100, 0.000, '', '<p><img src="/mall/data/upload/image/20160317/TB2OdrMXpXXXXchXpXXXXXXXXXX_!!349072314.jpg" alt="TB2OdrMXpXXXXchXpXXXXXXXXXX_!!349072314.jpg"/><img src="/mall/data/upload/image/20160317/TB2wkYyaXXXXXbhXpXXXXXXXXXX_!!349072314.jpg" alt="TB2wkYyaXXXXXbhXpXXXXXXXXXX_!!349072314.jpg"/><img src="/mall/data/upload/image/20160317/TB2ePeacXXXXXX0XpXXXXXXXXXX_!!349072314.jpg" alt="TB2ePeacXXXXXX0XpXXXXXXXXXX_!!349072314.jpg"/><img src="/mall/data/upload/image/20160317/TB2G5iacXXXXXaYXXXXXXXXXXXX_!!349072314.jpg" alt="TB2G5iacXXXXXaYXXXXXXXXXXXX_!!349072314.jpg"/><img src="/mall/data/upload/image/20160317/TB2lTqacXXXXXXWXpXXXXXXXXXX_!!349072314.jpg" alt="TB2lTqacXXXXXXWXpXXXXXXXXXX_!!349072314.jpg"/><img src="/mall/data/upload/image/20160317/TB2d7GbcXXXXXaNXXXXXXXXXXXX_!!349072314.jpg" alt="TB2d7GbcXXXXXaNXXXXXXXXXXXX_!!349072314.jpg"/><img src="/mall/data/upload/image/20160317/TB2VaObcXXXXXaNXXXXXXXXXXXX_!!349072314.jpg" alt="TB2VaObcXXXXXaNXXXXXXXXXXXX_!!349072314.jpg"/><img src="/mall/data/upload/image/20160317/TB2p5OacXXXXXckXXXXXXXXXXXX_!!349072314.jpg" alt="TB2p5OacXXXXXckXXXXXXXXXXXX_!!349072314.jpg"/><img src="/mall/data/upload/image/20160317/TB2Ad1acXXXXXXTXpXXXXXXXXXX_!!349072314.jpg" alt="TB2Ad1acXXXXXXTXpXXXXXXXXXX_!!349072314.jpg"/><img src="/mall/data/upload/image/20160317/TB2tqR.cXXXXXcXXXXXXXXXXXXX_!!349072314.jpg" alt="TB2tqR.cXXXXXcXXXXXXXXXXXXX_!!349072314.jpg"/></p>', 'data/images/20160311/ori_img/../thumb_img/thumb_251k0FUyp7xrYSNZMeKA.jpg', 'data/images/20160311/ori_img/../goods_img/goods_251k0FUyp7xrYSNZMeKA.jpg', 'data/images/20160311/ori_img/251k0FUyp7xrYSNZMeKA.jpg', 1, 0, 0, 1, 1, 1457633624, 0, ''),
	(6, 'AUTOSN20160311755542', 21, 0, '尚萌包邮 害怕 T恤限定 动漫二次元白色长袖短袖T恤全幅', 0.00, 45.00, 66.00, 67, 0.000, '', '<p><img src="/mall/data/upload/image/20160317/TB2fz_OkFXXXXXNXpXXXXXXXXXX_!!349072314.jpg" alt="TB2fz_OkFXXXXXNXpXXXXXXXXXX_!!349072314.jpg"/></p>', 'data/images/20160311/ori_img/../thumb_img/thumb_TQir4OymEfUYLeBRIKxA.jpg', 'data/images/20160311/ori_img/../goods_img/goods_TQir4OymEfUYLeBRIKxA.jpg', 'data/images/20160311/ori_img/TQir4OymEfUYLeBRIKxA.jpg', 1, 0, 1, 1, 0, 1457633666, 0, ''),
	(7, 'AUTOSN20160311709162', 21, 0, '东方project 大小姐 蕾米莉亚 动漫黑色T恤二次元短袖 预售包邮', 0.00, 69.00, 79.00, 99, 0.000, '', '<p><img src="/mall/data/upload/image/20160317/TB2lrJDkFXXXXadXXXXXXXXXXXX_!!349072314.jpg" alt="TB2lrJDkFXXXXadXXXXXXXXXXXX_!!349072314.jpg"/></p>', 'data/images/20160311/ori_img/../thumb_img/thumb_YhHJQ0qaOwASW3c9CbgZ.jpg', 'data/images/20160311/ori_img/../goods_img/goods_YhHJQ0qaOwASW3c9CbgZ.jpg', 'data/images/20160311/ori_img/YhHJQ0qaOwASW3c9CbgZ.jpg', 1, 0, 0, 0, 0, 1457633729, 0, ''),
	(8, 'AUTOSN20160311370653', 15, 0, '代购拼单所有CD 日本ACG动漫音乐OPED代购 万能专用链接 包邮包税', 0.00, 1.00, 99.00, 5, 0.000, '', '<p><img src="/mall/data/upload/image/20160317/TB2o2b9dVXXXXa5XXXXXXXXXXXX_!!372973950.jpg" alt="TB2o2b9dVXXXXa5XXXXXXXXXXXX_!!372973950.jpg"/><img src="/mall/data/upload/image/20160317/TB2pnHLdVXXXXcaXpXXXXXXXXXX_!!372973950.jpg" alt="TB2pnHLdVXXXXcaXpXXXXXXXXXX_!!372973950.jpg"/><img src="/mall/data/upload/image/20160317/TB2KFL0dVXXXXXnXpXXXXXXXXXX_!!372973950.jpg" alt="TB2KFL0dVXXXXXnXpXXXXXXXXXX_!!372973950.jpg"/></p>', 'data/images/20160311/ori_img/../thumb_img/thumb_WpRHU7LSfkIa6xET38tZ.jpg', 'data/images/20160311/ori_img/../goods_img/goods_WpRHU7LSfkIa6xET38tZ.jpg', 'data/images/20160311/ori_img/WpRHU7LSfkIa6xET38tZ.jpg', 1, 0, 1, 0, 0, 1457633801, 0, ''),
	(9, 'AUTOSN20160311975356', 25, 0, '国产2015雪初音未来特别版miku三款Q版手办模型公仔雪兔玩偶包邮', 0.00, 85.00, 99.00, 50, 0.000, '', '<p><img src="/mall/data/upload/image/20160317/TB2LmgodFXXXXaiXXXXXXXXXXXX_!!52076163.jpg" alt="TB2LmgodFXXXXaiXXXXXXXXXXXX_!!52076163.jpg"/><img src="/mall/data/upload/image/20160317/TB2N73odFXXXXX9XXXXXXXXXXXX_!!52076163.jpg" alt="TB2N73odFXXXXX9XXXXXXXXXXXX_!!52076163.jpg"/><img src="/mall/data/upload/image/20160317/TB2yAv4dFXXXXbuXpXXXXXXXXXX_!!52076163.jpg" alt="TB2yAv4dFXXXXbuXpXXXXXXXXXX_!!52076163.jpg"/><img src="/mall/data/upload/image/20160317/TB2QPD5dFXXXXboXpXXXXXXXXXX_!!52076163.jpg" alt="TB2QPD5dFXXXXboXpXXXXXXXXXX_!!52076163.jpg"/><img src="/mall/data/upload/image/20160317/TB23JIgdFXXXXcDXXXXXXXXXXXX_!!52076163.jpg" alt="TB23JIgdFXXXXcDXXXXXXXXXXXX_!!52076163.jpg"/></p>', 'data/images/20160311/ori_img/../thumb_img/thumb_VCzrywZDM8SFRLBNgtnp.jpg', 'data/images/20160311/ori_img/../goods_img/goods_VCzrywZDM8SFRLBNgtnp.jpg', 'data/images/20160311/ori_img/VCzrywZDM8SFRLBNgtnp.jpg', 1, 0, 1, 1, 0, 1457633974, 0, ''),
	(10, 'AUTOSN20160311106938', 25, 0, '约会大作战Q版精灵时崎狂三灵装换脸手办模型萌萌哒带大钟实拍', 0.00, 79.00, 179.00, 50, 0.000, '', '<p><img src="/mall/data/upload/image/20160317/TB2m7E8cVXXXXciXXXXXXXXXXXX_!!52076163.jpg" alt="TB2m7E8cVXXXXciXXXXXXXXXXXX_!!52076163.jpg"/><img src="/mall/data/upload/image/20160317/TB24wxbdXXXXXaOXXXXXXXXXXXX_!!52076163.jpg" alt="TB24wxbdXXXXXaOXXXXXXXXXXXX_!!52076163.jpg"/><img src="/mall/data/upload/image/20160317/TB2KsRhdXXXXXXBXXXXXXXXXXXX_!!52076163.jpg" alt="TB2KsRhdXXXXXXBXXXXXXXXXXXX_!!52076163.jpg"/></p>', 'data/images/20160311/ori_img/../thumb_img/thumb_1idW9Zq8H4JVCz2AGwaf.jpg', 'data/images/20160311/ori_img/../goods_img/goods_1idW9Zq8H4JVCz2AGwaf.jpg', 'data/images/20160311/ori_img/1idW9Zq8H4JVCz2AGwaf.jpg', 1, 0, 1, 0, 0, 1457634068, 0, ''),
	(11, 'AUTOSN20160311723114', 18, 0, '现货 轻音少女唯梓喵秋山澪全乐队5人便装陶瓷马克杯子带手把水杯', 0.00, 49.00, 149.00, 200, 0.000, '', '<p><img src="/mall/data/upload/image/20160317/TB26yeKXpXXXXbRXpXXXXXXXXXX_!!52076163.jpg" alt="TB26yeKXpXXXXbRXpXXXXXXXXXX_!!52076163.jpg"/><img src="/mall/data/upload/image/20160317/TB2gHcHdXXXXXawXXXXXXXXXXXX_!!52076163.jpg" alt="TB2gHcHdXXXXXawXXXXXXXXXXXX_!!52076163.jpg"/></p>', 'data/images/20160311/ori_img/../thumb_img/thumb_3GuVW6ZMDXkgnbjCOsc7.jpg', 'data/images/20160311/ori_img/../goods_img/goods_3GuVW6ZMDXkgnbjCOsc7.jpg', 'data/images/20160311/ori_img/3GuVW6ZMDXkgnbjCOsc7.jpg', 1, 0, 0, 1, 1, 1457634246, 0, ''),
	(12, 'AUTOSN20160311366847', 18, 0, '现货 请问要来点兔子吗香风智乃理世全员陶瓷马克杯子带手把玻璃杯', 0.00, 65.00, 165.00, 250, 0.000, '', '<p><img src="/mall/data/upload/image/20160317/TB2IQQIdXXXXXXVXXXXXXXXXXXX_!!52076163.jpg" alt="TB2IQQIdXXXXXXVXXXXXXXXXXXX_!!52076163.jpg"/><img src="/mall/data/upload/image/20160317/TB2.e.KdXXXXXXvXXXXXXXXXXXX_!!52076163.jpg" alt="TB2.e.KdXXXXXXvXXXXXXXXXXXX_!!52076163.jpg"/><img src="/mall/data/upload/image/20160317/TB2M4ExdXXXXXcFXXXXXXXXXXXX_!!52076163.jpg" alt="TB2M4ExdXXXXXcFXXXXXXXXXXXX_!!52076163.jpg"/><img src="/mall/data/upload/image/20160317/TB2s3.sdXXXXXXgXpXXXXXXXXXX_!!52076163.jpg" alt="TB2s3.sdXXXXXXgXpXXXXXXXXXX_!!52076163.jpg"/></p>', 'data/images/20160311/ori_img/../thumb_img/thumb_2tCueZBbXoNxQLYg37wM.jpg', 'data/images/20160311/ori_img/../goods_img/goods_2tCueZBbXoNxQLYg37wM.jpg', 'data/images/20160311/ori_img/2tCueZBbXoNxQLYg37wM.jpg', 1, 0, 1, 1, 0, 1457634303, 0, ''),
	(13, 'AUTOSN20160311493133', 25, 0, '约会大作战精灵四糸乃Q版四系乃连衣裙灵装四款手办模型公仔包邮', 0.00, 99.00, 199.00, 130, 0.000, '', '<p><img src="/mall/data/upload/image/20160317/TB29JZDdFXXXXcsXpXXXXXXXXXX_!!52076163.jpg" alt="TB29JZDdFXXXXcsXpXXXXXXXXXX_!!52076163.jpg"/><img src="/mall/data/upload/image/20160317/TB2fck1dFXXXXaLXXXXXXXXXXXX_!!52076163.jpg" alt="TB2fck1dFXXXXaLXXXXXXXXXXXX_!!52076163.jpg"/><img src="/mall/data/upload/image/20160317/TB2krg0dFXXXXbbXXXXXXXXXXXX_!!52076163.jpg" alt="TB2krg0dFXXXXbbXXXXXXXXXXXX_!!52076163.jpg"/><img src="/mall/data/upload/image/20160317/TB2B_sGdFXXXXbiXpXXXXXXXXXX_!!52076163.jpg" alt="TB2B_sGdFXXXXbiXpXXXXXXXXXX_!!52076163.jpg"/><img src="/mall/data/upload/image/20160317/TB27SsQdFXXXXXkXpXXXXXXXXXX_!!52076163.jpg" alt="TB27SsQdFXXXXXkXpXXXXXXXXXX_!!52076163.jpg"/></p>', 'data/images/20160311/ori_img/../thumb_img/thumb_bFcaJyA2QNIrkGu1Lw34.jpg', 'data/images/20160311/ori_img/../goods_img/goods_bFcaJyA2QNIrkGu1Lw34.jpg', 'data/images/20160311/ori_img/bFcaJyA2QNIrkGu1Lw34.jpg', 1, 0, 1, 1, 0, 1457634372, 0, ''),
	(14, 'AUTOSN20160311566308', 24, 0, '缘之空 手办 春日野穹 体操服 可拆卸 换装 布料 高质量 升级版', 0.00, 129.00, 169.00, 50, 0.000, '', '<p><img src="/mall/data/upload/image/20160317/TB2ZUTWcXXXXXa_XXXXXXXXXXXX-759923247.jpg" alt="TB2ZUTWcXXXXXa_XXXXXXXXXXXX-759923247.jpg"/><img src="/mall/data/upload/image/20160317/TB2c4nZcXXXXXbkXXXXXXXXXXXX-759923247.jpg" alt="TB2c4nZcXXXXXbkXXXXXXXXXXXX-759923247.jpg"/><img src="/mall/data/upload/image/20160317/TB27GDRcXXXXXaTXpXXXXXXXXXX-759923247.jpg" alt="TB27GDRcXXXXXaTXpXXXXXXXXXX-759923247.jpg"/></p>', 'data/images/20160311/ori_img/../thumb_img/thumb_DsH8z1W4CrjZRo0n97Pk.jpg', 'data/images/20160311/ori_img/../goods_img/goods_DsH8z1W4CrjZRo0n97Pk.jpg', 'data/images/20160311/ori_img/DsH8z1W4CrjZRo0n97Pk.jpg', 1, 0, 1, 0, 1, 1457634427, 0, ''),
	(18, 'AUTOSN20160311617073', 23, 0, '干物妹小埋公仔抱枕靠垫动漫周边泡沫粒子玩偶靠枕毛绒玩具娃娃布', 0.00, 39.00, 59.00, 45, 0.000, '', '<p><img src="/mall/data/upload/image/20160317/TB2OmopfXXXXXa0XpXXXXXXXXXX_!!1974443190.jpg" alt="TB2OmopfXXXXXa0XpXXXXXXXXXX_!!1974443190.jpg"/></p>', 'data/images/20160311/ori_img/../thumb_img/thumb_5mWyraz1KkMpUo8qG24H.jpg', 'data/images/20160311/ori_img/../goods_img/goods_5mWyraz1KkMpUo8qG24H.jpg', 'data/images/20160311/ori_img/5mWyraz1KkMpUo8qG24H.jpg', 1, 0, 0, 1, 1, 1457655933, 0, ''),
	(16, 'AUTOSN20160311398379', 23, 0, '绝对萌域 萌羽十二生肖猴年本命年动漫周边枕头二次元抱枕长靠枕', 0.00, 49.00, 99.00, 99, 0.000, '', '<p><img src="/mall/data/upload/image/20160317/TB2qCndlXXXXXchXXXXXXXXXXXX_!!66280588.jpg" alt="TB2qCndlXXXXXchXXXXXXXXXXXX_!!66280588.jpg"/><img src="/mall/data/upload/image/20160317/TB2dZ6qlXXXXXaAXXXXXXXXXXXX_!!66280588.jpg" alt="TB2dZ6qlXXXXXaAXXXXXXXXXXXX_!!66280588.jpg"/><img src="/mall/data/upload/image/20160317/TB20iK4lXXXXXahXpXXXXXXXXXX_!!66280588.jpg" alt="TB20iK4lXXXXXahXpXXXXXXXXXX_!!66280588.jpg"/><img src="/mall/data/upload/image/20160317/TB2RQ_qlXXXXXahXXXXXXXXXXXX_!!66280588.jpg" alt="TB2RQ_qlXXXXXahXXXXXXXXXXXX_!!66280588.jpg"/></p>', 'data/images/20160311/ori_img/../thumb_img/thumb_NFbeUoiQsY432WDm8qC6.jpg', 'data/images/20160311/ori_img/../goods_img/goods_NFbeUoiQsY432WDm8qC6.jpg', 'data/images/20160311/ori_img/NFbeUoiQsY432WDm8qC6.jpg', 1, 0, 0, 1, 0, 1457634632, 0, ''),
	(17, 'AUTOSN20160311970234', 23, 0, 'bilibili经典款小电视抱枕B站毛绒玩具哔哩哔哩动漫周边公仔', 0.00, 139.00, 189.00, 90, 0.000, '', '<p><img src="/mall/data/upload/image/20160317/TB2tZPGbVXXXXXLXXXXXXXXXXXX_!!1791797968.jpg" alt="TB2tZPGbVXXXXXLXXXXXXXXXXXX_!!1791797968.jpg"/><img src="/mall/data/upload/image/20160317/TB2q8vsbVXXXXaGXpXXXXXXXXXX_!!1791797968.jpg" alt="TB2q8vsbVXXXXaGXpXXXXXXXXXX_!!1791797968.jpg"/></p>', 'data/images/20160311/ori_img/../thumb_img/thumb_rSCuEiWLANI34HQhdow2.jpg', 'data/images/20160311/ori_img/../goods_img/goods_rSCuEiWLANI34HQhdow2.jpg', 'data/images/20160311/ori_img/rSCuEiWLANI34HQhdow2.jpg', 1, 0, 0, 0, 1, 1457634709, 0, ''),
	(19, 'AUTOSN20160317749046', 23, 0, '包邮原创!舰队collection 岛风动漫等身抱枕套 二次元周边 长枕', 0.00, 270.00, 230.00, 178, 0.000, '', '<p><img src="/mall/data/upload/image/20160317/1458157836171524.jpg" alt="1458157836171524.jpg"/><img src="/mall/data/upload/image/20160317/1458157836470595.jpg" alt="1458157836470595.jpg"/><img src="/mall/data/upload/image/20160317/1458157836126384.jpg" alt="1458157836126384.jpg"/><img src="/mall/data/upload/image/20160317/1458157836836796.jpg" alt="1458157836836796.jpg"/><img src="/mall/data/upload/image/20160317/1458157836967354.jpg" alt="1458157836967354.jpg"/><img src="/mall/data/upload/image/20160317/1458157836576625.jpg" alt="1458157836576625.jpg"/><img src="/mall/data/upload/image/20160317/1458157836643239.jpg" alt="1458157836643239.jpg"/></p>', 'data/images/20160317/ori_img/../thumb_img/thumb_VUfgHJNAy1K2scMRrdhW.jpg', 'data/images/20160317/ori_img/../goods_img/goods_VUfgHJNAy1K2scMRrdhW.jpg', 'data/images/20160317/ori_img/VUfgHJNAy1K2scMRrdhW.jpg', 1, 0, 1, 1, 1, 1458158426, 0, '');
/*!40000 ALTER TABLE `goods` ENABLE KEYS */;


-- 导出  表 mall.ordergoods 结构
CREATE TABLE IF NOT EXISTS `ordergoods` (
  `og_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL DEFAULT '0',
  `order_sn` char(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `goods_id` int(15) unsigned NOT NULL DEFAULT '0',
  `goods_name` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `goods_buy_num` smallint(9) NOT NULL DEFAULT '1',
  `shop_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`og_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  mall.ordergoods 的数据：0 rows
/*!40000 ALTER TABLE `ordergoods` DISABLE KEYS */;
/*!40000 ALTER TABLE `ordergoods` ENABLE KEYS */;


-- 导出  表 mall.orderinfo 结构
CREATE TABLE IF NOT EXISTS `orderinfo` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_sn` char(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `receiver` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address` varchar(120) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `zipcode` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tel` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `best_time` varchar(25) COLLATE utf8_unicode_ci DEFAULT '',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `order_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  mall.orderinfo 的数据：0 rows
/*!40000 ALTER TABLE `orderinfo` DISABLE KEYS */;
/*!40000 ALTER TABLE `orderinfo` ENABLE KEYS */;


-- 导出  表 mall.user 结构
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` char(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `regtime` int(10) unsigned NOT NULL DEFAULT '0',
  `lastlogin` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  mall.user 的数据：1 rows
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`user_id`, `username`, `email`, `password`, `regtime`, `lastlogin`) VALUES
	(1, 'test123456', 'test123@test.com', '47ec2dd791e31e2ef2076caf64ed9b3d', 1458303753, 0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
