<?php
namespace WX\Controller;
use Think\Controller;

/*
 * 微信认证
 * */

class PaymentController extends Controller{


    private $payment;
    private $autograph;

    public function __construct()
    {
        parent::__construct();
        $this->payment = C('PAPMENT');
        $this->autograph = $this->__getAutograph();
    }

    /*
     * 获取   签名
     * */
    private function __getAutograph()
    {
        $array = array(
            'amount'=>'100',
            'app'=>'zyptestapp',
            'barcode'=>'123123123123',
            'local_order_no'=>'localorderno123123123123',
            'operator_id'=>'axgdfdafd34124',
            'subject'=>'这是一笔支付订单',
            'timestamp'=>'1460512556270',
            'key'   =>  'thisistestkey'
        );
        return $this->__buildQuery($array);
    }

    /*
     * 条码支付
     * */
    public function barcode()
    {
        $res = $this->autograph;
    }

    /*
     * 扫码支付
     * */
    public function saoMaZhiFu()
    {
        
    }

    /*
     * h5支付
     * */
    public function h5ZhiFu()
    {
        
    }

    /*
     * 处理返回值
     * */
    public function returnPymentInfo()
    {

    }



    
/*
 *  获取签名
 *
 * @param $array，需要签名的字符串，顺序不能乱
 * 
 * */
    private function __buildQuery($array = '')
    {
        $result_array = array();
        $str = '';
        foreach($array as $k=>$v){
            $str .= '&'.$k.'='.$v;
        }
        $resStr =  substr($str,1);
        return  md5($resStr);
    }
}