<?php

//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
defined('PERMISSION')||exit('非法访问');

class GoodsModel extends Model{
    protected $table = 'goods';
    protected $primarykey = 'goods_id';
    //自动过滤
    protected $fields = array(//这里先手动写好，以后再改成自动分析 desc
        'goods_id',
        'goods_sn',
        'weight',
        'cat_id',
        'brand_id',
        'goods_name',
        'shop_price',
        'market_price',
        'goods_number',
        'click_count',
        'goods_brief',
        'goods_desc',
        'keywords',
        'ori_img',
        'goods_img',
        'thumb_img',
        'is_on_sale',
        'is_delete',
        'is_best',
        'is_new',
        'is_hot',
        'add_time',
        'last_update'
    );
    //自动填充
    protected $_auto = array(
        array('is_new','value',0),
        array('is_best','value',0),
        array('is_hot','value',0),
        array('add_time','function','time')
    );
    //自动验证
    /*
     * 格式 $this->_valid = array(
     *      array('验证的字段名',0/1/2(验证的场景,0：字段有就判断，没有就不判断，
     *            1:必须检查，2：字段有就判断，没有就不判断，值为空不判断。),
     *            '报错信息','require(必须)/in(某几种情况)/between(范围)/
     *            length(某个范围)')
     * );
     */
    protected $_valid = array(
        array('goods_name',1,'商品名必须在4到100个字符以内','length','4,100'),
        array('goods_sn',1,'商品序列号必须在5到25个字符以内','length','5,25'),
        array('shop_price',1,'本店价格必须在0~1000000以内','between','0,1000000'),
        array('market_price',1,'市场价格必须在0~1000000以内','between','0,1000000'),
        array('weight',2,'商品重量必须在0~10000千克以内','between','0,10000'),
        array('goods_number',1,'库存数量必须在0~100000以内','between','0,100000'),
        array('goods_brief',2,'商品描述必须在10到300个字符以内','length','10,300'),
        //array('keywords',1,'关键词不能为空','require'),
        array('cat_id',1,'请选择商品分类','between','1,99999999'),
        array('cat_id',1,'栏目id必须是整型值','number'),
        array('is_new',0,'is_new只能是0或1','in','0,1'),
        array('is_best',0,'is_best只能是0或1','in','0,1'),
        array('is_hot',0,'is_hot只能是0或1','in','0,1')
    );


    /*
     * 作用：把商品放到回收站，即is_delete字段置为1
     * parm int id
     * return bool
     */

    public function trash($id){
        return $this->update(array('is_delete'=>1),$id);
    }

    public function getGoods(){
        $sql = 'select * from goods where is_delete=0';
        return $this->db->getAll($sql);
    }

    public function getTrash(){
        $sql = 'select * from goods where is_delete=1';
        return $this->db->getAll($sql);
    }

    //如果没输入货号，则自动创建商品的货号
    public function createSN(){
        $sn = 'AUTOSN'.date('Ymd').mt_rand(100000,999999);
        $sql = 'select count(*) from '.$this->table." where goods_sn='".$sn."'";
        return $this->db->getOne($sql)?$this->createSN():$sn;
    }

    //随机取出指定条数的新品
    public function getRandNew($n=5){
        $sql = 'select goods_id,goods_name,shop_price,market_price,thumb_img,ori_img from '.$this->table.' where is_new = 1 and is_on_sale = 1 and is_delete = 0 order by rand() limit '.$n;
        return $this->db->getAll($sql);
    }
    //随机取出指定条数的热门商品
    public function getRandHot($n=5){
        $sql = 'select goods_id,goods_name,shop_price,market_price,thumb_img,ori_img from '.$this->table.' where is_hot = 1 and is_on_sale = 1 and is_delete = 0 order by rand() limit '.$n;
        return $this->db->getAll($sql);
    }
    //随机取出指定条数的精品
    public function getRandBest($n=5){
        $sql = 'select goods_id,goods_name,shop_price,market_price,thumb_img,ori_img from '.$this->table.' where is_best = 1 and is_on_sale = 1 and is_delete = 0 order by rand() limit '.$n;
        return $this->db->getAll($sql);
    }
    //随机取5条上架的商品
    public function getRandOnSale($n=5){
        $sql = 'select goods_id,goods_name,shop_price,market_price,thumb_img,ori_img from '.$this->table.' where is_on_sale = 1 and is_delete = 0 order by rand() limit '.$n;
        return $this->db->getAll($sql);
    }
    //取出指定栏目的商品
    /*错误示范：
     * $cat_id = $_GET['cat_id'];
     * $sql = select ... from goods where cat_id = $cat_id;
     * 因为$cat_id对应的栏目有可能是个大栏目，而大栏目下面没有商品。
     * 商品放在了大栏目下面的子栏目里
     * 所以，正确的做法是找出$cat_id的所有子孙栏目，
     * 然后再去查所有$cat_id及其子孙栏目下的商品。
     */
    public function catGoods($cat_id,$offset=0,$limit=5){//$offset偏移量，$limit=取出的条目
        if(isset($offset) && isset($limit)){
            $limit_sentence = ' limit '.$offset.','. $limit;
        }else{
            $limit_sentence = '';//即无限制，取出所有的数据
        }
        $category = new CatModel();
        $cats = $category->select();//取出所有的栏目
        $sons = $category->getCatTree($cats,$cat_id);//取出子孙栏目
        $sub = array();
        $sub[] = $cat_id;//先把传来的$cat_id自身放进去查本栏目下的商品，
                         //然后再找出子孙栏目的cat_id，去查其栏目下的商品，
                         //如没有子孙栏目，则只需查自身栏目下的商品即可。
        if(!empty($sons)){//有子孙栏目
            foreach($sons as $value){
                $sub[] = $value['cat_id'];
            }
        }
        $in = implode(',',$sub);//用逗号隔开
        $sql = 'select goods_id,goods_name,shop_price,market_price,thumb_img,ori_img from '.$this->table.' where cat_id in ('.$in.') and is_on_sale=1 and is_delete=0 order by add_time desc'.$limit_sentence;
        return $this->db->getAll($sql);
    }

    public function catGoodsCount($cat_id){
        $category = new CatModel();
        $cats = $category->select();//取出所有的栏目
        $sons = $category->getCatTree($cats,$cat_id);//取出子孙栏目
        $sub = array();
        $sub[] = $cat_id;//先把传来的$cat_id自身放进去查本栏目下的商品，
        //然后再找出子孙栏目的cat_id，去查其栏目下的商品，
        //如没有子孙栏目，则只需查自身栏目下的商品即可。
        if(!empty($sons)){//有子孙栏目
            foreach($sons as $value){
                $sub[] = $value['cat_id'];
            }
        }
        $in = implode(',',$sub);//用逗号隔开
        $sql = 'select count(*) from '.$this->table.' where cat_id in ('.$in.') and is_on_sale=1 and is_delete=0 order by add_time desc';
        return $this->db->getOne($sql);
    }


    public function findbysn($sn){
        $sql = 'select * from '.$this->table.' where goods_sn='.'"'.$sn.'"';
        return $this->db->getRow($sql);
    }

    /*
     * 获取购物车中商品的详细信息
     * parm array $item 购物车中的商品数组
     * return 商品数组的详细信息
     */
    public function getCarGoodsInfo($AllGoods){
        foreach($AllGoods as $key=>$value){
            $sql = 'select goods_id,goods_name,thumb_img,shop_price,market_price,goods_number from '.$this->table.' where goods_id='.$key;
            $row = $this->db->getRow($sql);
            $AllGoods[$key]['thumb_img'] = $row['thumb_img'];
            $AllGoods[$key]['market_price'] = $row['market_price'];
            $AllGoods[$key]['goods_number'] = $row['goods_number'];
        }
        return $AllGoods;

    }

    public function changeGoodsNumber($goods_id,$buy_num){
        $goods = $this->find($goods_id);
        $changenum = $goods['goods_number'] - $buy_num;
        $sql = 'update '.$this->table.' set goods_number = '.$changenum.' where goods_id = '.$goods_id;
        return $this->db->query($sql);
    }

    public function select_goods_by_keyword($k)
    {
        $keywords = explode(' ', $k);
        $tmp_keywords = $keywords;
        foreach ($keywords as $key => $value) {
            if (strpos($value, 'new') !== false || strpos($value, '新品') !== false) {
                unset($keywords[$key]);
            }
            if (strpos($value, 'best') !== false || strpos($value, '推荐') !== false) {
                unset($keywords[$key]);
            }
            if (strpos($value, 'hot') !== false || strpos($value, '热门') !== false) {
                unset($keywords[$key]);
            }
        }
        if(!isset($keywords[0])){
            $sql = 'select goods_id,goods_name,thumb_img,shop_price,market_price,is_new,is_best,is_hot from ' . $this->table . ' where goods_name like ' . '"' . '%%"';
        }else{
            $sql = 'select goods_id,goods_name,thumb_img,shop_price,market_price,is_new,is_best,is_hot from ' . $this->table . ' where goods_name like ' . '"' . '%' . $keywords[0] . '%"';
        }

        if (count($keywords) > 1) {
            for ($i = 1; $i < count($keywords); $i++) {
                $sql = $sql . ' and goods_name like ' . '"' . '%' . $keywords[$i] . '%"';
            }
        }
        if (in_array('new', $tmp_keywords) || in_array('新品', $tmp_keywords)) {
            $sql = $sql . ' and is_new = 1';
        } elseif (in_array('best', $tmp_keywords) || in_array('推荐', $tmp_keywords)) {
            $sql = $sql . ' and is_best = 1';
        } elseif (in_array('hot', $tmp_keywords) || in_array('热门', $tmp_keywords)) {
            $sql = $sql . ' and is_hot = 1';
        }
        return $this->db->getAll($sql);
    }
}

?>