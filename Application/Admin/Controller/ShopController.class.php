<?php
namespace Admin\Controller;
use Think\Controller;
class ShopController extends Controller {


    /*
     * 修改商品
     * 修改商品
     * */
    public function updateGoods()
    {

        $goodsDetails = M('bun_goods')->find($_GET['id']);
        $goodsDetails['bun_goods_desc'] = html_entity_decode($goodsDetails['bun_goods_desc']);
        $this->assign('info',$goodsDetails);
        $this->display('Index/UpdateGoods');
    }

    public function doUpdateGoods()
    {

        $bun_goods = M('bun_goods');
        //初始化数据
        $_POST['bun_goods_status'] or $_POST['bun_goods_status']=NULL;
        $_POST['bun_goods_desc'] = htmlentities($_POST['bun_goods_desc']);
        $info = $bun_goods->find($_POST['bun_goods_id']);
        //如果详情页改变了，删除详情信息，但是不删除其他文件
        if($_POST['bun_goods_desc'] != $info['']){
            $pic = '';
            $this-$this->__delgoodsImage($pic,$_POST['bun_goods_id'],TURE);
        }
        $res = $bun_goods->save($_POST);
        //如果修改成功，删除多余文件
        if($res){
            //如果上传了新的展示文件，就删除原来的文件,但是不删除详情信息
            if($_FILES['bun_goods_pic']['name']!= ''){
                $pic = ['bun_goods_pic'];
                $this-$this->__delgoodsImage($pic,$_POST['bun_goods_id'],FALSE);
            }
            $this->success('修改成功',U('Shop/goodslist'));
        }else{
            $this->error('修改失败');
        }
    }

    /*
     * 跳转商品添加页面
     * */
    public function addGoods()
    {
        $this->display("Index/AddShop");
    }

    /*
     * 商品添加动作
     * */
    public function doAddGoods()
    {
        $_POST['bun_goods_pic'] = $this->__uploadFile();
        $_POST['business_id'] = $_SESSION['Admin']['business_id'];
        if (empty($_POST['bun_goods_pic'])) {
            $this->error('上传上传失败');
        } else {
            $bun_goods = M("bun_goods");
            if ($bun_goods->create()) {
                $result = $bun_goods->add(); // 写入数据到数据库
                if ($result) {
                    $this->success('商品上传成功');
                }
            }

        }
    }

    /*
     * 图片上传
     * */
    private function __uploadFile()
    {
        $config = array(
            'maxSize'    =>    3145728,
            'savePath'   =>    '/GoodsImages/',
            'saveName'   =>    array('uniqid',''),
            'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
            'autoSub'    =>    true,
            'subName'    =>    array('date','Ymd'),
        );
        $upload = new \Think\Upload($config);// 实例化上传类
        // 上传单个文件
        $info   =   $upload->uploadOne($_FILES['bun_goods_pic']);
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功 获取上传文件信息
            $image = new \Think\Image();
            $src = "./Uploads".$info['savepath'].$info['savename'];
            $image->open($src);
            $image->thumb(164,164)->save('./Uploads'.$info['savepath'].$info['savename']);
            return $info['savepath'].$info['savename'];
        }
    }

    /*
     * 查看商品列表
     * */
    public function goodslist()
    {
        $where['business_id'] = $_SESSION['Admin']['business_id'];
        $bun_goods = M("bun_goods");
        $list = $bun_goods->where($where)->select();
        $this->assign('goodlist',$list);
        $this->display('Index/Goodlist');
    }

    /*
     * 删除商品
     * $sta=TURE 删除详情图片，否则不删除详情图片
     * */
    public function delGoods($id=0,$sta=TURE)
    {
        if(!empty($_GET['id'])){
            $id = $_GET['id'];
        }
        $bun_goods = M('bun_goods');
        $list = $bun_goods->find($id);
        $pic =$list['bun_goods_pic'];
        $this->__delgoodsImage($pic,$id,$sta);
        if($bun_goods->delete($id)){
            $this->__delgoodsImage($pic,$id,$sta);
            $this->goodslist();
        }else{
            $this->error('商品删除出现问题');
        }

    }

    /*
     * 删除商品照片
     * */
    public function __delgoodsImage($pic,$id,$sta=TURE)
    {
        //删除商品标题图片
        $img = './Uploads'.$pic;
        if (file_exists($img)) {
            unlink($img);
        }
        if($sta){
            $this->delGoodsDetailImage($id);
        }

    }

    /*
     * 删除商品详情里面的图片
     * @:$id  商品详情id
     * */
    public function delGoodsDetailImage($id=39)
    {

        $bun_goods = M('bun_goods');
        $imgList = html_entity_decode($bun_goods->find($id)['bun_goods_desc']);
        $preg = "/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/";
        preg_match_all($preg, $imgList, $imgArr);
        $imglist = $imgArr['1'];
        foreach ($imglist as $v) {
            $res = explode('/',$v,5)[4];
            unlink($res);
        }

    }

}