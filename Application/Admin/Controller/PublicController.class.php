<?php
namespace Admin\Controller;
use Think\Controller;
class PublicController extends Controller {
    
    
    /**
     * 获取商家总收益
     * @param  $bun_id 商家id
     * @return float
     **/
    public function getAllBunPro($bun_id=0)
    {
        $where['business_id'] = $bun_id;
        $res = M('consume_list')->where($where)->sum('consume_money');
        return $res;
    }

    /**

     * 清空指定的表
     * @param  $table 表名字
     */
    public function emptyTable($table='')
    {
        return M($table)->where("1=1")->delete();
    }
    
    /**
     *  初始化商家盈利统计表
     */
    public function addBunAllData()
    {
        $bunIdList = M('business')->field('business_id')->select();
        $dataList = array();
        foreach ($bunIdList as $k=>$v){
            $id = $v['business_id'];
            $dataList[$k]['business_id'] = $v['business_id'];
            $dataList[$k]['business_info_total'] = $this->getAllBunPro($id);
        }
        $this->emptyTable('business_info');
        $res = M('business_info')->addAll($dataList);
        return $res;
    }

}