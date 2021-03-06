<?php
namespace Home\Controller;
use Think\Controller;
class AgentController extends Controller {

    public function __construct()
    {
        parent::__construct();
        if(empty($_SESSION['Home'])){
            A('Login')->login('Index/Index');
            die;
        }
    }


    public function addAgent()
    {
        if(empty(I('post.'))){
            $this->display('Index/AddAgent');
        }else{

            $agent = M('agent');
            $where1['agent_email'] = I('post.agent_email');
            $where2['agent_iphone'] = I('post.agent_iphone');
            if($agent->where($where1)->select() or $agent->where($where2)->select()){
                $this->error('邮箱或者手机号已存在');
                die;
            }
            $picinfo = $this->__uploadFile();
            $data['agent_license'] = $picinfo[0]['savepath'].$picinfo[0]['savename'];
            $data['agent_id_face'] = $picinfo[1]['savepath'].$picinfo[1]['savename'];
            $data['agent_id_con'] = $picinfo[2]['savepath'].$picinfo[2]['savename'];
            $data['agent_iphone'] = I('post.agent_iphone');
            $data['agent_email'] = I('post.agent_email');
            $data['agent_pass'] = md5(md5(I('post.agent_pass')));

            $res = M('agent')->add($data);
            if($res){
                $this->success('新的代理商已经生成');
            }else{
                $this->success('添加失败');
            }
        }

    }


    /*
     *代理商列表
     * */
    public function agentList()
    {
        $agent = M('agent');
        $list = $agent->select();
        $this->assign('list',$list);
        $this->display('Index/agentList');
    }

    /*
     * 禁用以及使用等状态
     * */
    public function updateStatus()
    {
        $agent = M('agent');
        $data = I('get.');
        $res = $agent->save($data);
        if($res){
            $this->success('操作成功');
        }
    }
    
    /*
     * 添加key 和 app
     * */
    public function addKeyApp()
    {
        if(empty(I('post.'))){
            $list =  M('agent')->field('app,key')->find(I('get.agent_id'));
            $this->assign('list',$list);
            $this->display('Index/addKeyApp');
        }else{
            $where['agent_id'] = I('post.agent_id');
            $data['app']= I('post.app');
            $data['key']= I('post.key');
            $res = M('agent')->where($where)->save($data);
            if($res){
                $this->success('添加成功');
            }
        }
    }

    private function __uploadFile()
    {
        $config = array(
            'maxSize'    =>    3145728,
            'savePath'   =>    '/Agent/',
            'saveName'   =>    array('uniqid',''),
            'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
            'autoSub'    =>    true,
            'subName'    =>    array('date','Ymd'),
        );
        $upload = new \Think\Upload($config);// 实例化上传类
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功 获取上传文件信息
            return $info;
        }
    }

    public function updateAgent()
    {
        $where = I('get.');
        $list = M('agent')->where($where)->find();
        if(empty(I('post.'))){
            $list = M('agent')->where($where)->find();
            $this->assign('list',$list);
            $this->display('Index/updateAgent');
        }else{
            //post 有值，执行修改
            $data = array_filter(I('post.'));
            $agent = M('agent');
            $where1['agent_email'] = I('post.agent_email');
            $where2['agent_iphone'] = I('post.agent_iphone');
            if($agent->where($where1)->select() or $agent->where($where2)->select()){
                $this->error('邮箱或者手机号已存在');
                die;
            }
            if(!empty($data['agent_pass'])){
                $data['agent_pass'] = md5(md5($data['agent_pass']));
            }
            $arr = $_FILES['photo']['error'];
            if(in_array(0,$arr)){
                $picinfo = $this->__uploadFile();
            }
  /*          dump($_FILES);
            if(array_key_exists('name',$_FILES['photo'])){
                echo 1234;
                dump($_FILES);

            }*/
            $pic['agent_license'] = $picinfo[0]['savepath'].$picinfo[0]['savename'];
            $pic['agent_id_face'] = $picinfo[1]['savepath'].$picinfo[1]['savename'];
            $pic['agent_id_con'] = $picinfo[2]['savepath'].$picinfo[2]['savename'];
            $data = array_filter(array_merge($pic,$data));
            $res = M('agent')->where($where)->save($data);
            if($res){
            foreach($pic as $k=>$v){
                if($v!=''){
                    @unlink('./Uploads/'.$list[$k]);
                }
            }
                $this->success('修改成功',U('Agent/agentList'));
            }else{
                $this->error('修改失败');
            }


        }
    }

    private function __array_remove_empty($arr){
        $narr = array();
        while(list($key, $val) = each($arr)){
            if (is_array($val)){
                $val = $this->__array_remove_empty($val);
                // does the result array contain anything?
                if (count($val)!=0){
                    // yes :-)
                    $narr[$key] = $val;
                }
            }
            else {
                if (trim($val) != ""){
                    $narr[$key] = $val;
                }
            }
        }
        unset($arr);
        return $narr;
    }
}