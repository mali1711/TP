<?php
/**
 * Created by PhpStorm.
 * User: Mali
 * Date: 2017/12/6
 * Time: 20:48
 */
namespace Admin\Controller;
use Think\Controller;
class ShareController extends CommonController{
    public function __construct()
    {
        parent::__construct();
    }

    /*
     * 添加分享活动
     * */
    public function AddShare()
    {
        $this->display('Index/AddShare');
    }

    /*
     * 执行添加
     * */
    public function doAddShare()
    {

        $data = I('post.');
        $data['business_id'] = $_SESSION['Admin']['business_id'];
        $data['share_pic'] = $this->__uploadFile('share_pic','ShareImages/',164,164);
        $data['share_addtime'] = date('Y-m-d H:i:s');
        $share = M("share"); // 实例化User对象
        if($share->add($data)){
            $this->success('分享活动添加成功');
        }else{
            $this->success('分享活动添加失败');
        }
    }

    /*
     * 查看分享列表
     * */
    public function shareList()
    {
        $where['business_id'] = $_SESSION['Admin']['business_id'];
        $share = M('share');
        $list = $share->where($where)->select();
        $this->assign('list',$list);
        $this->display('Index/ShareList');
    }

    /*
     * 删除分享
     * todo
     * */
    public function delShare()
    {
        $share = M('share');
        $id = I('get.id');
        if($this->delReward($id)){
            $pic = $share->find($id)['share_pic'];
            $img = './Uploads'.$pic;
            @unlink($img);
            $share->delete($id);
            $this->success('删除成功');
        }else{
            $this->error('删除有误');
        }
    }

    /*
     * 删除奖励
     * */
    public function delReward($id)
    {
        $reward = M('reward');
        $where['share_id'] = $id;
        return $reward->where($where)->delete();
    }

    /*
     * 添加奖励方式
     * */
    public function addReward()
    {
        $where['share_id'] = I('get.id');
        $reward = M('reward');
        $list = $reward->where($where)->find();
//        查看优惠券,修改信息
        if($list){
            $this->updateReward($list);
//         添加优惠券
        }else{
            $this->doAddReward();
        }

    }

    /*
     *修改优惠券
     * todo
     * */
    public function updateReward($list=0)
    {
        if(empty(I('post.'))){
            $coupons = M('coupons');
            $where['business_id'] = $_SESSION['Admin']['business_id'];
            $couponsList = $coupons->where($where)->select();
            $this->assign('couponsList',$couponsList);
            $this->assign('list',$list);
            $this->display('Index/UpdateReward');
        }else{
//            修改
            $reward = M('reward');
            $data = I('post.');
            $data['reward_addtime'] = date('Y-m-d H:i:s');
            $where['share_id'] = $data['share_id'];
            unset($data['share_id']);
            $res = $reward->where($where)->save($data);
            if($res){
                $this->success('修改成功',U('Share/shareList'));
            }else{
                $this->error('修改失败');
            }
        }
    }

    public function text()
    {
        $reward = M('reward');
        $data['reward_red_packets'] = 10;
        $reward->where('share_id=1')->save($data);
        echo $reward->getLastSql();
    }

    /*
     * 添加优惠券
     * */
    public function doAddReward()
    {
        if(empty(I('post.'))){
            $coupons = M('coupons');
            $share = M('share');
            $where['business_id'] = $_SESSION['Admin']['business_id'];
            $couponsList = $coupons->where($where)->select();
            $id = I('get.id');
            $this->assign('id',$id);
            $this->assign('couponsList',$couponsList);
            $this->display('Index/AddReward');
        }else{
//            执行添加
            $reward = M('reward');
            $data = I('post.');
            $data['reward_addtime'] = date('Y-m-d H:i:s');
            $res = $reward->add($data);
            if($res){
                $this->success('添加成功',U('Share/shareList'));
            }else{
                $this->error('添加失败');
            }
        }
    }


}