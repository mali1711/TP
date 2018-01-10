<?php
namespace Users\Controller;
use Think\Controller;
/*
 *  分享逻辑以及显示
 * */
class ShareController extends Controller {

    /*
     * 查看分享详情
     * */
    public function showShareDetail()
    {
        $id = I('get.id');
        //判断访问这个网页是否通过点击别人的分享来进行访问的
        dump(I('get.users'));
        if(I('get.users_id')){
            $this->getShareInfo(I('get.users_id'),$id);
        }
        $share = M('Share');
        $list['share_desc'] = $share->find($id)['share_desc'];
        $list['share_desc'] = html_entity_decode($list['share_desc']);
        $list['userid'] = $_SESSION['user']['userinfo']['users_id'];
        $list['url'] =  'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'/users_id/'.$list['userid'];//定义访问的url
        $this->assign('list',$list);
        $this->display('Index/showShareDetail');
    }

    /*
     *用户通过连接，进入分享内容
     * */
    public function getShareInfo($users_id,$share_id)
    {
        $be_share_detail = M('be_share_detail');
        $where['users_id'] =$users_id;
        $where['share_id'] =$share_id;
        $res = $be_share_detail->where($where)->find();
        //分享的链接已经被点过
        if($res){
            $data['be_share_detail_person'] = $res['be_share_detail_person'].',,'.$_SERVER["REMOTE_ADDR"];
            $per = ',,'.$_SERVER["REMOTE_ADDR"];
            if(strpos($res['be_share_detail_person'],$per)===false){
                $be_share_detail->where($where)->save($data);
            }

        }else{
            $data['users_id'] =$users_id;
            $data['share_id'] =$share_id;
            $data['be_share_detail_person'] = ',,'.$_SERVER["REMOTE_ADDR"];
            $data['be_share_addtime'] = time();
            $be_share_detail->add($data);
        }
        $arr = explode(',,',$res['be_share_detail_person']);
        $shareNum = count($arr)-1;//一共有多少人访问该用户分享的链接

    }

}