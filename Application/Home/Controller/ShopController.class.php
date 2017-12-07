<?php
namespace Home\Controller;
use Think\Controller;
class BusinessController extends Controller {

    public function __construct()
    {
        parent::__construct();
    }

    /*
     * 跳转商品添加页面
     * */
    public function addGoods()
    {
        $this->display("Index/AddShop");
    }
   
}