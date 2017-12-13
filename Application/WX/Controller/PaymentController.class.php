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
//        获取配置文件支付接口需要的数据
        $this->payment = C('PAPMENT');
        $this->autograph = $this->__getAutograph();
        dump($this->payment);
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
        //参与签名
        $url = 'http://openapi.caibaopay.com/gatewayOpen.htm';
        $where['amount'] = '1';
        $where['app'] = $this->payment['app'];
        $where['channel'] = '1';
        $where['local_order_no'] = 'OPENAPI201712122111542860432';
        $where['operator_id'] = $this->payment['operator_id'];
        $where['subject'] = 'text';
        $where['timestamp'] = '1513084314619';
        $where['un_discount_amount'] = '0';
        $where['key'] = $this->payment['key'];
//        不参与签名
        $list = $this->__buildQuery($where);
        $list['command'] = 'caibao.pay.scan';
        $list['notify_url'] = '';
        $list['version'] = '1.0';
        //合并成统一的数据
        $data = array_merge($where,$list);
        //curl 调用支付
        $info = $this->curl_post($url,$data);
        dump($info);
        return $info;
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
        $list['sign'] = md5($resStr);
        $list['signString'] = $resStr;
        return  $list;
    }

    /*
     * CURL GEI
     * */
    public static function curl_get($url){

        $testurl = $url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $testurl);
        //参数为1表示传输数据，为0表示直接输出显示。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //参数为0表示不带头文件，为1表示带头文件
        curl_setopt($ch, CURLOPT_HEADER,0);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
    /*
     * url:访问路径
     * array:要传递的数组
     * CURL POST
     * */
    public static function curl_post($url,$array){

        $curl = curl_init();
        //设置提交的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);
        //设置post数据
        $post_data = $array;
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //获得数据并返回
        return $data;
    }

}