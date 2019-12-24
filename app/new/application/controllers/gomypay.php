<?
class Gomypay extends MY_Controller
{
    public $language = '';

    public function __construct()//初始化
    {
        parent::__construct();

        //mac
        header('Access-Control-Allow-Origin: *');

        //helper
        $this->load->helper('url');

        // language
        $this -> load -> helper('language');
        if(!$this -> session -> userdata('lang'))
            $this -> language['lang'] = $this -> session -> set_userdata('lang', 'zh-tw');
        else
            $this -> language['lang'] = $this -> session -> userdata('lang');

        $this -> lang -> load('controllers/gomypay', $this -> $language['lang']);
        $this -> language['TransactionFails'] = lang('TransactionFails');
        $this -> language['TransactionFailContactStore'] = lang('TransactionFailContactStore');
        $this -> language['TradingSuccess'] = lang('TradingSuccess');
        $this -> language['ConnectionError'] = lang('ConnectionError');
        $this -> language['Shipment_1'] = lang('Shipment_1');
        $this -> language['SystemLinking'] = lang('SystemLinking');

        //model
        $this->load->model('gomypay_model', 'mod_gomypay');

        //host
        $this->data['host']=$this->get_host_config();

        //domain id
        if($this->session->userdata('session_domain'))
            $this->data['domain_id'] = $this->session->userdata('session_domain');
        else
            $this->data['domain_id'] = $this->data['host']['domain_id'];

        //web config
        $this->data['web_config'] = $this->get_web_config($this->data['domain_id']);

        //購物車開放狀態判斷
        if($this->data['web_config']['cart_status'] == 0)
        {
            redirect('/index/error');
        }
        // 0: sandbox ; 1: truely
        $this -> mode  = 1;
    }
    

    /******************
     * cset_code : 行動商店店碼
     * id        : order 流水編號
     * order_id  : order 訂單 id
     ******************/
    public function trade($cset_code, $id, $order_id)
    {
        /******************************************************************************************
         * -----------------------------------------------------------------------------------------
         * 「訂單產生」參數設定說明 :
         * -----------------------------------------------------------------------------------------
         * e_orderno                : 訂單編號          Varchar(20)     (必填，限定英文或數位或底線，其他不可) 
         * e_url                    : 回傳網址          Varchar(100)    (必填)
         * e_no                     : 商店代號          Varchar(10)     (必填，賣家商店代號)
         * e_storename              : 商店名稱          Varchar(50)     (若空白則為客戶名稱)
         * e_Lang                   : 語言              Varchar(10)     (預設為BIG5)        
         * e_Cur                    : 支付幣別          Varchar(10)     (新台幣(NT)為預設)
         * e_money                  : 交易金額          float           (須大於30)
         * str_check                : MD5 32位元編碼    Varchar(32)     (必填， e_orderno . e_no . e_money . 交易驗證密碼 串接後轉為 MD5 編碼)
         * e_name                   : 消費者姓名        Varchar(20)     (必填，勿填寫英數字)
         * e_telm                   : 消費者手機        Varchar(20)     (必填，數字；不可全形)
         * e_email                  : 消費者Email       Varchar(100)    (必填，不可全形)
         * e_info                   : 商品資訊          Varchar(200)    (必填)
         *
         * *****************************************************************************************/

        // 元素準備
        $language = $this -> language;
        $store  = $this -> mod_gomypay -> select_from('iqr_cart', array('cset_code' => $cset_code));
        $order  = $this -> mod_gomypay -> select_from('order', array('id' => $id, 'order_id' => $order_id));
        $iqrt   = $this -> mod_gomypay -> select_from('iqr_trans', array('cset_id' => $store['cset_id'], 'pway_id' => 6));
        $logist = $this -> mod_gomypay -> select_from('iqr_logistics', array('iqrt_id' => $order['lway_iqrt_id']));
        $logist_info = $this -> mod_gomypay -> select_from('logistics_way', array('lway_id' => $logist['lway_id']));

        if($order['status'] == 0 && $order['product_flow'] == 0)
        {
            $now = time();
            $trade_date = date("Y/m/d H:i:s", $now);
            $time_mark = date("YmdHis", $now);
            $order_no = $this -> mod_gomypay -> generatorPassword(6, $time_mark);
            $this -> mod_gomypay -> update_set('order', 'id', $id, array('trade_no' => $order_no));
        
            if($order['pay_way_id'] == 6)
            {
                $mode = $this -> mode;
                switch ($mode)
                {
                    case 0:
                        $data['gateway_url'] = 'http://test.gomypay.asia/Shopping/creditpay.asp';
                        break;
                    
                    case 1:
                        $data['gateway_url'] = 'https://gomypay.asia/Shopping/creditpay.asp';
                        break;
                }
                
                $items = $this->get_serialstr($order['details'], '++');
                foreach($items as $key => $value)
                {
                    $details = explode('*#', $value);
                    $prd     = $this -> mod_gomypay ->select_from('products', array('prd_id' => $details[0])); // 產品資料
                    $item[$key] = $prd['prd_name'].'x'.$details[1];
                    $logist_data = false;
                }
                if($logist_info && $order['lway_price'] != 0)
                {
                    $item[$key + 1]  = $language['Shipment_1'];
                    $logist_data = true;
                }

                foreach ($item as $item_key => $item_value)
                {
                    if($item_key == 0 )
                        $items = $item_value.',';
                    else
                        $items .= $item_value.',';
                }

                $form_array = array(
                        'e_orderno'     => $order_no,
                        'e_url'         => base_url() . 'gomypay/gomypay_return',
                        // 'e_backend_url' => base_url() . 'gomypay/bstr_check',
                        'e_no'          => $iqrt['business_account'],
                        'e_storename'   => $store['cset_name'],
                        'e_Lang'        => 'utf-8',
                        'e_money'       => $order['total_price'],
                        'e_name'        => $order['name'],
                        'e_telm'        => $order['phone'],
                        'e_email'       => $order['email'],
                        'e_info'        => $items
                );

                $check_ready = $order_no . $iqrt['business_account'] . $order['total_price'] . $iqrt['business_hashiv'];
                $str_check   = md5($check_ready);
                $form_array['str_check'] = $str_check;

                foreach($form_array as $key => $val)
                {
                    $form_info .= "<input type='hidden' name='" . $key . "' value='" . $val . "'><BR>";
                }
                // $form_info .= "<input type='submit' name='form_submit' value='送出'>";
                $data['form_info'] = $form_info;

            }
            else
            {
                $this -> script_message($language['ConnectionError'], '/cart/store/'.$store['cset_code']);
            }
            echo '<span style="font-family: 微軟正黑體; font-size: 1em;">'.$language['SystemLinking'].'</span><br>';
        }
        else
        {
            $this -> script_message($language['TransactionFails'], '/cart/store/'.$store['cset_code']);
        }
        
        $this -> load -> view('cart/gomypay_form', $data);
    }

    public function gomypay_return()
    {
        $language = $this -> language;
        
        $str_ok     = $this -> input -> post('str_ok');
        $str_no     = $this -> input -> post('str_no');
        $e_Cur      = $this -> input -> post('e_Cur');
        $e_money    = $this -> input -> post('e_money');
        $str_check  = $this -> input -> post('str_check');
        $e_orderno  = $this -> input -> post('e_orderno');
        $e_no       = $this -> input -> post('e_no');
        $e_date     = $this -> input -> post('e_date');
        $e_time     = $this -> input -> post('e_time');
        $re_date    = $this -> input -> post('re_date');
        $re_time    = $this -> input -> post('re_time');
        $e_outlay   = $this -> input -> post('e_outlay');
        $str_msg    = $this -> input -> post('str_msg');
        $bstr_msg   = $this -> input -> post('bstr_msg');
        $rstr_msg   = $this -> input -> post('rstr_msg');

        $order = $this -> mod_gomypay -> select_from('order', array('trade_no' => $e_orderno, 'total_price' => $e_money));
        $iqrt  = $this -> mod_gomypay -> select_from('iqr_trans', array('iqrt_id' => $order['iqrt_id']));
        $store = $this -> mod_gomypay -> select_from('iqr_cart', array('cset_id' => $iqrt['cset_id']));
        $return_check_ready = $str_ok . $e_orderno . $iqrt['business_account'] . $e_money .  $str_no .  $iqrt['business_hashiv'];

        if(md5($return_check_ready) == $str_check)
        {
            $insert_data = array(
                'str_ok'       => $str_ok,    
                'str_no'       => $str_no,    
                'e_Cur'        => $e_Cur,
                'e_money'      => $e_money,    
                'str_check'    => $str_check,    
                'e_orderno'    => $e_orderno,    
                'e_no'         => $e_no,
                'e_datetime'   => $e_date . ' ' . $e_time,
                're_datetime'  => $re_date . ' ' . $re_time,    
                'e_outlay'     => $e_outlay,    
                'str_msg'      => $str_msg,    
                'bstr_msg'     => $bstr_msg,    
                'rstr_msg'     => $rstr_msg,    
                'str_check'    => $str_check
            );
            $trade_id = $this -> mod_gomypay -> insert_into('gomypay_trade_log', $insert_data);

            $update_data = array(
                'gid'         => $trade_id,
                'status'      => '1',
                'gomypay_no'  => $str_no,
                'trade_date'  => $e_date . ' ' . $e_time,
            );
            $this -> mod_gomypay -> update_set('order', 'trade_no', $e_orderno, $update_data);
           
            $this -> script_message($language['TradingSuccess'], '/cart/store/'.$store['cset_code']);
        }
        else
            $this -> script_message($language['TransactionFailContactStore'], '/cart/store/'.$store['cset_code']);
        // $this -> load -> view('test', $data);
    }

}
