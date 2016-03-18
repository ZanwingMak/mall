<?php

/* 分页类
 *
 * 总条数：$total_num
 * 每页条数：$each_page_num
 * 当前页：$page
 *
 * 分页原理的2个公式：
 *
 * 总页数：$total_page = ceil($total/$echo_page_num) //相除，向上取整
 *
 * 第$page页，显示第几条到第几条?
 * 第$page页，说明跳过了$page-1页，
 * 每页有$each_page_num条，说明跳过了($page-1)*$each_page_num条，
 * 即从第($page-1)*$each_page_num+1条开始取，取$each_page_num条。
 */

//分页导航的生成
//应根据页码来生成，但同时不能把地址栏的其他参数搞丢
//所以需要先把地址栏获取并保存

class PageTools{
    protected $total_num = 0;
    protected $each_page_num = 8;
    protected $page = 1;

    public function __construct($total_num,$each_page_num=false,$page=false){
        $this->total_num = $total_num;
        if($each_page_num){
            $this->each_page_num = $each_page_num;
        }
        if($page){
            $this->page = $page;
        }
    }
    public function get_total_page(){
        return ceil($this->total_num/$this->each_page_num);
    }

    //获取地址栏地址并将参数进行重组拼接
    public function get_url(){
        $uri = $_SERVER['REQUEST_URI'];
        $parse = parse_url($uri);
        $param = array();
        if(isset($parse['query'])){
            //void parse_str ( string $str [, array &$arr ] )没有返回值，得放第二参数里
            parse_str($parse['query'],$param);//将字符串解析成多个变量，放到数组里
        }

        //不管$param数组里有没有page参数，都unset一下page，确保没有page参数
        //即保存除page之外的所有参数
        unset($param['page']);

        $url = $parse['path'].'?';
        if(!empty($param)){//如果有其它参数
            $param = http_build_query($param);//拼接成url的参数，如：id=123&cat=321
            $url = $url.$param.'&'; //xxxx.php?id=123&cat=321&
        }//如果没有其它参数就不用加&符号了~
        return $url;
    }

    //创建分页导航
    public function show(){
        $total_page = $this->get_total_page();
        $url = $this->get_url();
        //计算页面导航
        $nav = array();
        $nav[0] = '<span class="page_now">'.$this->page.'</span> ';
        $front_page = $this->page - 1;
        $next_page = $this->page + 1;
        for($left=$this->page-1,$right=$this->page+1;($left>=1||$right<=$total_page)&&count($nav)<5;$left--,$right++){
            if($left>=1){
                //在最前面插
                array_unshift($nav,'<a href="'.$url.'page='.$left.'">['.$left.']</a> ');
            }
            if($right<=$total_page){
                //在最后面插
                array_push($nav,'<a href="'.$url.'page='.$right.'">['.$right.']</a> ');
            }
        }
        if($this->page>1){
            array_unshift($nav,'<a href="'.$url.'page='. $front_page .'">[上一页]</a> ');
            array_unshift($nav,'<a href="'.$url.'page=1">[首页]</a> ');
        }
        if($this->page<$total_page){
            array_push($nav,'<a href="'.$url.'page='. $next_page .'">[下一页]</a> ');
            array_push($nav,'<a href="'.$url.'page='.$total_page.'">[末页('.$total_page.')]</a> ');
        }
        return implode('',$nav) ;//把数组按第一个参数的字符来分割并转换成字符串

    }

}


?>