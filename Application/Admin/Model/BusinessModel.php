<?php
namespace Home\Model;
use Think\Model;
class BusinessModel extends Model{

    protected $table = 'business';
    protected $pk = 'business_id';

    public function __construct()
    {
        parent::__construct();
        echo  1234;
    }
    protected $_validate = array(
        array('business_account','','输入的信息已经存在！',0,'unique',1), // 在新增的时候验证name字段是否唯一
        array('business_email','','输入的信息已经存在！',0,'unique',1), // 在新增的时候验证name字段是否唯一
        array('agin_business_pass','password','确认密码不正确',0,'confirm'), // 验证确认密码是否和密码一致
    );
}