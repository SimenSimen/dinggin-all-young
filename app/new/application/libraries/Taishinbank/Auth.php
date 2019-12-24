<?php 
class Auth
{
    protected $url = '',
              $mid = '', 
              $tid = '',    
              $pay_type = '',
                
              $cur = '', 
              $order_desc = '', 
              $post_back_url = '',
              $result_url = '',
              $device = '';
    public    $tx_type = '';  

    public function __construct()//初始化
    {
        $this -> url = 'https://tspg.taishinbank.com.tw/tspgapi/restapi/auth.ashx';
        $this -> mid = '000812660108330';
        $this -> tid = 'T0000000';
        $this -> pay_type = 1;
        $this -> tx_type = 1;
        $this -> cur = 'NTD';
        $this -> order_desc = '國鼎行動商務系統';
        $this -> post_back_url = 'http://www.gbshop.com.tw/taishin/front_result';
        $this -> result_url = 'https://www.gbshop.com.tw/taishin/back_result';
        $this -> get_layout();
    }

    public function creditcard($order_id, $price)
    {
        $data = array(
            'sender'    => 'rest',
            'ver'       => '1.0.0',
            'mid'       => $this -> mid,
            'tid'       => $this -> tid,
            'pay_type'  => (int) $this -> pay_type,
            'tx_type'   => (int) $this -> tx_type,
            'params'    => array(
                'layout'        => (string) $this -> device,
                'order_no'      => (string) $order_id,
                'amt'           => (string) $price,
                'cur'           => $this -> cur,
                'order_desc'    => $this -> order_desc,
                'capt_flag'     => '0',
                'post_back_url' => $this -> post_back_url,
                'result_url'    => $this -> result_url
            )
        );
        $JSON_data = json_encode($data);
      
        $ch = curl_init($this -> url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $JSON_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($JSON_data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $response_obj = curl_exec($ch);
        //close connection
        curl_close($ch);
        $response_array = $this -> decode_object($response_obj);
        if ($response_array['params']['hpp_url'] && $response_array['params']['ret_code'] == '00')
            $e = array('getMessage' => $response_array['params']['hpp_url'], 'getCode' => $response_array['params']['ret_code']);
        else
            $e = array('getMessage' => 'Error Processing Request', 'getCode' => $response_array['params']['ret_code']);
        
        return $e;
    }

    private function get_layout()
    {
        if(preg_match('/(Android)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
            $this -> device = '2';
        else if(preg_match('/(iPhone|iPad|iPod)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
            $this -> device = '2';
        else if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows') > 0)
            $this -> device = '1';
        else
            $this -> device = '1';
    }

    private function decode_object($object)
    {
        return json_decode($object, true);
    }

    public function other($order_no, $price='')
    {
        $this -> url = 'https://tspg-t.taishinbank.com.tw/tspgapi/restapi/other.ashx';
        $data = array(
            'sender'    => 'rest',
            'ver'       => '1.0.0',
            'mid'       => $this -> mid,
            'tid'       => $this -> tid,
            'pay_type'  => (int) $this -> pay_type,
            'tx_type'   => (int) $this -> tx_type,
            'params'    => array(
                // 'ret_code' => '00',
                'order_no'      => (string) $order_no,
                'amt'           => (string) $price,
                'result_flag'   => (string) 1,
            )
        );
        // print_r($data);
        // break;
        $JSON_data = json_encode($data);
        $ch = curl_init($this -> url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $JSON_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($JSON_data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $response_obj = curl_exec($ch);
        //close connection
        curl_close($ch);
        $response_array = $this -> decode_object($response_obj);

        // if ($response_array['params']['hpp_url'] && $response_array['params']['ret_code'] == '00')
        //     $e = array('getMessage' => $response_array['params']['hpp_url'], 'getCode' => $response_array['params']['ret_code']);
        // else
        //     $e = array('getMessage' => 'Error Processing Request', 'getCode' => $response_array['params']['ret_code']);
        $e = $response_array;

        return $e;
    }
}
