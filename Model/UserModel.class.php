<?php

//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
defined('PERMISSION')||exit('非法访问');

class UserModel extends Model{
    protected $table = 'user';
    protected $primarykey = 'user_id';
    protected $fields = array(
                        'user_id',
                        'username',
                        'email',
                        'password',
                        'regtime',
                        'lastlogin'
                        );

    //自动填充
    protected $_auto = array(
        array('agreement','value',0),
        array('regtime','function','time')
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
        array('username',1,'用户名必须在5-20个字符以内','length','5,20'),
        array('email',1,'邮箱非法','email'),
        array('password',1,'密码必须在8-25个字符以内','length','8,25'),
        array('conform_password',1,'确认密码必须在8-25个字符以内','length','8,25'),
        array('agreement',1,'您未接受《用户协议》','in','1'),
    );

    public function set_valid($array){
        if($this->_valid = $array){
            return true;
        }else{
            return false;
        }
    }

    public function checkp1p2($data){
        if($data['password']==$data['conform_password']){
            return true;
        }else{
            return false;
        }
    }
    public function reg($data){
        if($data['password']){
            $data['password'] = $this->encPassword($data['password']);
        }
        return $this->add($data); //用md5覆盖传来的密码，然后在这里写入数据库
    }
    protected function encPassword($password){
        return md5($password);
    }

    /*
     * 根据用户名查询用户信息
     */
    public function checkUser($username,$password=''){
        if($password == ''){
            $sql = 'select count(*) from '.$this->table." where username='".$username."'";
            return $this->db->getOne($sql);
        }else{
            $sql = 'select user_id,username,email,password,lastlogin from '.$this->table." where username='".$username."'";
            $row = $this->db->getRow($sql);
            if(empty($row)){
                return false;
            }elseif($row['password'] == $this->encPassword($password)){
                return $row;
            }else{
                return false;
            }
        }

    }

    public function setLastloginTime($user_id){
        $this->update(array('lastlogin'=>time()),$user_id);
    }
}

?>