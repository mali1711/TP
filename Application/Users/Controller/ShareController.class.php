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


}