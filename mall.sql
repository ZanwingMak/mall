
#栏目表
create table category(
  cat_id int auto_increment primary key,
  cat_name varchar(20) not null default '',
  intro varchar(100) not null default '',
  parent_id int not null default 0
)engine myisam charset utf8;

#商品表
create table if not exists `goods`(
  `goods_id` int(15) unsigned not null auto_increment,
  `goods_sn` char(25) not null default '',
  `weight` double(10,2) not null default '0.00',
  `cat_id` smallint(8) not null default '0',
  `brand_id` smallint(8) not null default '0',
  `goods_name` varchar(40) not null default '',
  `shop_price` decimal(10,2) not null default '0.00',
  `market_price` decimal(10,2) not null default '0.00',
  `goods_number` smallint(8) not null default '1',
  `click_count` decimal(8,3) not null default '0.000',
  `goods_brief` varchar(300) not null default '',
  `goods_desc` text not null,
  `keywords` varchar(100) not null default '',
  `thumb_img` varchar(100) not null default '',
  `goods_img` varchar(100) not null default '',
  `ori_img` varchar(100) not null default '',
  `is_on_sale` tinyint(4) not null default '1',
  `is_delete` tinyint(4) not null default '0',
  `is_best` tinyint(4) not null default '0',
  `is_new` tinyint(4) not null default '0',
  `is_hot` tinyint(4) not null default '0',
  `add_time` int(10) unsigned not null default '0',
  `last_update` int(10) unsigned not null default '0',
  primary key (`goods_id`),
  unique key `goods_sn` (`goods_sn`)
)engine=MyISAM default charset=utf8 auto_increment=1;

#用户表
create table user(
user_id int unsigned not null auto_increment primary key,
username varchar (30) not null default '',
email varchar(40) not null default '',
password char(32) not null default '',
regtime int unsigned not null default 0,
lastlogin int unsigned not null default 0
)engine=MyISAM charset utf8;

#订单表
create table orderinfo(
  order_id int unsigned auto_increment primary key,
  order_sn char(30) not null default '',
  user_id int unsigned not null default 0,
  username varchar (30) not null default '',
  receiver varchar (40) not null default '',
  address varchar(120) not null default '',
  zipcode varchar(10) not null default '',
  email varchar(50) not null default '',
  tel varchar(20) not null default '',
  best_time varchar(20) default '',
  add_time int unsigned not null default 0,
  order_amount decimal(10,2) not null default 0.0,
  payment tinyint(1) not null default 0
)engine=MyISAM charset utf8;

#订单与商品的对应表
#(因为1个订单有多个商品,如何找出?当这2张表的order_id==order_id且order_sn==order_sn时)
create table ordergoods(
  og_id int unsigned auto_increment primary key,#流水id
  order_id int unsigned not null default 0,
  order_sn char(20) not null default '',
  goods_id int(15) unsigned not null default 0,
  goods_name varchar(40) not null default '',
  goods_buy_num smallint not null default 1,
  shop_price decimal(10,2) not null default 0.0,
  subtotal decimal(10,2) not null default 0.0
)engine=MyISAM charset utf8;