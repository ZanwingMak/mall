<?php

//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
defined('PERMISSION')||exit('非法访问');

class CatModel extends Model{
    protected $table = 'category';

    /*
     * 给我一个关键数组，键->表中的列，值->表中的值，
     * add()函数自动插入该行数据
     */

    public function add($data){
        return $this->db->autoExecute($this->table,$data);//默认insert 所以可以不写'insert'参数
    }

    //获取本表下的所有数据
    public function select(){
        $sql = 'select cat_id,cat_name,parent_id from '.$this->table;
        return $this->db->getAll($sql);
    }

    //根据主键取出一行数据
    public function find($cat_id){
        $sql = 'select * from '.$this->table.' where cat_id='.$cat_id;
        return $this->db->getRow($sql);
    }


    /*
     * 获得栏目树
     * 无限级分类
     * pram: int $id
     * return $id 栏目的子孙树
     */
    public function getCatTree($arr,$id=0,$lev=0){
        $tree = array();
        if($arr){
            foreach($arr as $value){
                if($value['parent_id']==$id){
                    $value['lev'] = $lev;
                    $tree[] = $value;

                    $tree = array_merge($tree,$this->getCatTree($arr,$value['cat_id'],$lev+1));
                }
            }
        }

        return $tree;
    }

    /*
     * 查子栏目
     * parm: int $id
     * return $id栏目下的子栏目
     */
    public function getSon($id){
        $sql = 'select cat_id,cat_name,parent_id from '.$this->table.' where parent_id='.$id;
        return $this->db->getAll($sql);
    }

    /*
     * parm: int $id
     * return array $id栏目的家谱树
     */
    public function getTree($id){
        $tree = array();
        $cats = $this->select();
        while($id>0){
            foreach($cats as $value){
                if($value['cat_id'] == $id){
                    $tree[] = $value;
                    $id = $value['parent_id'];
                    break;
                }
            }
        }
        return array_reverse($tree);
    }



    //删除栏目
    public function delete($cat_id){
        $sql = 'delete from '.$this->table.' where cat_id='.$cat_id;
        $this->db->query($sql);
        return $this->db->affected_rows();
    }

    //修改栏目
    public function update($data,$cat_id){
        $this->db->autoExecute($this->table,$data,'update',' where cat_id='.$cat_id);
        return $this->db->affected_rows();
    }


}


?>