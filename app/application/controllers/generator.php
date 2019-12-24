<?php
class Generator extends MY_Controller
{
	public $data='';
	public $language='';

	public function __construct() // 初始化
	{
		parent::__construct();

        // helper
        $this->load->helper('url');
        
        // language
		$this -> load -> helper('language');
		if(!$this -> session -> userdata('lang'))
			$this -> data['lang'] = $this -> session -> set_userdata('lang', 'zh-tw');
		else
			$this -> data['lang'] = $this -> session -> userdata('lang');

			$this -> lang -> load('views/business/edit', $this -> data['lang']);
			// language_top
			$this -> data['Edit_Web_version'] = lang('Edit_Web_version');
			$this -> data['Edit_APP_version'] = lang('Edit_APP_version');
			$this -> data['Edit_Sign_out'] = lang('Edit_Sign_out');
			$this -> data['Edit_Signed_in'] = lang('Edit_Signed_in'); 
			$this -> data['Edit_Maturity'] = lang('Edit_Maturity');
			$this -> data['Edit_Day'] = lang('Edit_Day');
			// language_business_header     
            $this -> data['Edit_Personal_information'] = lang('Edit_Personal_information');
            $this -> data['Edit_Style_Settings'] = lang('Edit_Style_Settings');
            $this -> data['Edit_Cover_photo_set'] = lang('Edit_Cover_photo_set');
            $this -> data['Edit_Style_setting'] = lang('Edit_Style_setting');
            $this -> data['Edit_settings_action_Stores'] = lang('Edit_settings_action_Stores');
            $this -> data['Edit_Text_classification_set'] = lang('Edit_Text_classification_set');
            $this -> data['Edit_Albums_and_Accessories'] = lang('Edit_Albums_and_Accessories');
            $this -> data['Edit_New_Album'] = lang('Edit_New_Album');
            $this -> data['Edit_Album_Management'] = lang('Edit_Album_Management');
            $this -> data['Edit_Attachment_Manager'] = lang('Edit_Attachment_Manager');
            $this -> data['Edit_QR_code_style'] = lang('Edit_QR_code_style');
            $this -> data['Edit_APP_Edition'] = lang('Edit_APP_Edition');
            $this -> data['Edit_Web_version'] = lang('Edit_Web_version');
            $this -> data['Edit_Contacts'] = lang('Edit_Contacts');
            $this -> data['Edit_Form_Tools'] = lang('Edit_Form_Tools');
            $this -> data['Edit_Custom_Forms'] = lang('Edit_Custom_Forms');
            $this -> data['Edit_Tell_a_friend_Voucher'] = lang('Edit_Tell_a_friend_Voucher');
            $this -> data['Edit_Action_Shop'] = lang('Edit_Action_Shop');
            $this -> data['Edit_Basic_settings'] = lang('Edit_Basic_settings');
            $this -> data['Edit_Commodity_Management'] = lang('Edit_Commodity_Management');
            $this -> data['Edit_Order_Management'] = lang('Edit_Order_Management');
            $this -> data['Edit_Orders_Search'] = lang('Edit_Orders_Search');
            $this -> data['Edit_control_center'] = lang('Edit_control_center');
            $this -> data['Edit_change_Password'] = lang('Edit_change_Password');
            $this -> data['Edit_System_flow'] = lang('Edit_System_flow');
            $this -> data['Edit_Member_Management'] = lang('Edit_Member_Management');
            $this -> data['Edit_Key_state'] = lang('Edit_Key_state');
            $this -> data['Edit_APP_setting'] = lang('Edit_APP_setting');
            $this -> data['Edit_Automatic_packing'] = lang('Edit_Automatic_packing');
            $this -> data['Edit_Application_shelves'] = lang('Edit_Application_shelves');
            $this -> data['Edit_Push_application'] = lang('Edit_Push_application');
            $this -> data['Edit_Added_Management'] = lang('Edit_Added_Management');
		// language_business_header_title
            $this -> data['Edit_Business_Information_Systemsnt'] = lang('Edit_Business_Information_Systemsnt');
            $this -> data['Edit_still_cover_formula'] = lang('Edit_still_cover_formula');
            $this -> data['Edit_commerce_system_styles'] = lang('Edit_commerce_system_styles');
            $this -> data['Edit_store_style_action'] = lang('Edit_store_style_action');
            $this -> data['Edit_title_text_style'] = lang('Edit_title_text_style');
            $this -> data['Edit_systems_albums_Category'] = lang('Edit_systems_albums_Category');
            $this -> data['Edit_commerce_system_Album'] = lang('Edit_commerce_system_Album');
            $this -> data['Edit_business_systems_Accessories'] = lang('Edit_business_systems_Accessories');
            $this -> data['Edit_APP_version_QRcode'] = lang('Edit_APP_version_QRcode');
            $this -> data['Edit_web_version_QRcode'] = lang('Edit_web_version_QRcode');
            $this -> data['Edit_contacts_QRcode_styles'] = lang('Edit_contacts_QRcode_styles');
            $this -> data['Edit_system_custom_form'] = lang('Edit_system_custom_form');
            $this -> data['Edit_commerce_system'] = lang('Edit_commerce_system');
            $this -> data['Edit_APP_installer'] = lang('Edit_APP_installer');
            $this -> data['Edit_apply_through'] = lang('Edit_apply_through');
            $this -> data['Edit_application_APP'] = lang('Edit_application_APP');
            $this -> data['Edit_URL_shelves'] = lang('Edit_URL_shelves');
        // language_order   
        	$this -> lang -> load('controllers/generator', $this -> data['lang']);
        	$SharingPreferences = lang('SharingPreferences');
			$ReferenceSet = lang('ReferenceSet');
        	$this -> data['ouput_Order_inquiries_export'] = lang('ouput_Order_inquiries_export');
        	$this -> data['ouput_Total_Export_Report'] = lang('ouput_Total_Export_Report');
        	$this -> data['ouput_Export_Report'] = lang('ouput_Export_Report');
        	$this -> data['ouput_Order_Date'] = lang('ouput_Order_Date');
        	$this -> data['ouput_product_name'] = lang('ouput_product_name');
        	$this -> data['ouput_Purchaser_mail_box'] = lang('ouput_Purchaser_mail_box');
        	$this -> data['ouput_Telephone_Order'] = lang('ouput_Telephone_Order');
        	$this -> data['ouput_Order_Status'] = lang('ouput_Order_Status');
        	$this -> data['ouput_new_order'] = lang('ouput_new_order');
        	$this -> data['ouput_Processing'] = lang('ouput_Processing');
        	$this -> data['ouput_Shipped'] = lang('ouput_Shipped');
        	$this -> data['ouput_cancel_order'] = lang('ouput_cancel_order');
        	$this -> data['ouput_Transaction_complete'] = lang('ouput_Transaction_complete');
        	$this -> data['ouput_Return'] = lang('ouput_Return');
        	$this -> data['ouput_Replacement'] = lang('ouput_Replacement');
        	$this -> data['ouput_Any'] = lang('ouput_Any');
        	$this -> data['ouput_Unpaid'] = lang('ouput_Unpaid');
        	$this -> data['ouput_Already_paid'] = lang('ouput_Already_paid');
        	$this -> data['ouput_Refund'] = lang('ouput_Refund');
        	$this -> data['ouput_Change_Order_Status'] = lang('ouput_Change_Order_Status');
        	$this -> data['ouput_No_information'] = lang('ouput_No_information');
           	$this -> data['ouput_Payment_status'] = lang('ouput_Payment_status');
        	$this -> data['ouput_payment_method'] = lang('ouput_payment_method');
   			$this -> data['ouput_Change_Order_Status'] = lang('ouput_Change_Order_Status');
			$this -> data['ouput_Inquire'] = lang('ouput_Inquire');
		//language_excel_output
			$this ->language['ouput_Order_Status'] = lang('ouput_Order_Status');
			$this ->language['ouput_Order_Number'] = lang('ouput_Order_Number');
			$this ->language['ouput_Order_Date'] = lang('ouput_Order_Date');
			$this ->language['ouput_Purchaser'] = lang('ouput_Purchaser');
			$this ->language['ouput_Items'] = lang('ouput_Items');
			$this ->language['ouput_total_amount'] = lang('ouput_total_amount');
			$this ->language['ouput_Payment_status'] = lang('ouput_Payment_status');
			$this ->language['ouput_operating'] = lang('ouput_operating');
			$this ->language['ouput_Purchaser'] = lang('ouput_Purchaser');
			$this ->language['ouput_Telephone_purchase'] = lang('ouput_Telephone_purchase');
			$this ->language['ouput_Purchaser_mailbox'] = lang('ouput_Purchaser_mailbox');
			$this ->language['ouput_Recipient_address'] = lang('ouput_Recipient_address');
			$this ->language['ouput_Invoice'] = lang('ouput_Invoice');
			$this ->language['ouput_Invoice_TongBian'] = lang('ouput_Invoice_TongBian');
			$this ->language['ouput_Invoice_address'] = lang('ouput_Invoice_address');
			$this ->language['ouput_payment_method'] = lang('ouput_payment_method');
			$this ->language['ouput_Shipping_methods'] = lang('ouput_Shipping_methods');
			$this ->language['ouput_Trading_Order_Number'] = lang('ouput_Trading_Order_Number');
			$this ->language['ouput_Fu_Bao_European_Order'] = lang('ouput_Fu_Bao_European_Order');
			$this ->language['ouput_MasterCard_Order'] = lang('ouput_MasterCard_Order');
			$this ->language['ouput_Payment_time'] = lang('ouput_Payment_time');
			

		//$this -> data['Edit_Web_version'] = lang('Edit_Web_version');

        // base_url
        $this->data['base_url'] = base_url();

        // model
		$this->load->model('generator_model', 'mod_generator');

        // host
        $this->data['host'] = $this->get_host_config();

        // domain id
        if($this->session->userdata('session_domain'))
            $this->data['domain_id'] = $this->session->userdata('session_domain');
        else
            $this->data['domain_id'] = $this->data['host']['domain_id'];

        // web config
        $this->data['web_config'] = $this->get_web_config($this->data['domain_id']);
        $this->data['menu_width'] = ($this->data['web_config']['cart_status'] == 1) ? '124px' : '141px'; //menu width

        // member_account
        $m = $this->mod_generator->select_from('member', array('member_id'=>$this->session->userdata('member_id')));

		//購物車開放狀態判斷
		if($this->data['web_config']['cart_status'] == 0)
		{
			redirect('/index/error');
		}

		//id on 菜單高亮處理
		$id_on_index = substr($_SERVER['REQUEST_URI'], 6);
		if(($pos = strpos($id_on_index, '/')) !== false)
		{
			$id_on_index = substr($id_on_index, 0, $pos);
		}
		if(!empty($id_on))
			unset($id_on);
		$this->data['id_on'][$id_on_index] = 'on';
		
		//auth
		if($this->session->userdata('member_id') == 1)
		{
			redirect('/admin/panel');
		}

        // 使用者auth功能設定
        if($this->session->userdata('user_auth') != '')
            $auth = $this->session->userdata('user_auth');
        else
            $auth = $this->session->userdata('auth');
        $this->data['user_auth'] = $auth;
        if($this->data['web_config']['auth_level_num'] == 2)
        { // 只有兩層
            switch ($auth)
            {
                case '01': // 第一層

                    $auth_cols  = '<a href="/share/setting/'.$auth.'" title="'.$SharingPreferences.'" alt="'.$SharingPreferences.'" style="width: '.$this->data['menu_width'].'; font-size:16px;">'.$SharingPreferences.'</a>';
                    $auth_title = $SharingPreferences;

                    break;

                case '02': // 第二層

                    $auth_cols  = '<a href="/quote/setting/'.$auth.'" title="'.$ReferenceSet.'" alt="'.$ReferenceSet.'" style="width: '.$this->data['menu_width'].'; font-size:16px;">'.$ReferenceSet.'</a>';
                    $auth_title = $ReferenceSet;

                    break;
            }
        }
        else
        {
            switch ($auth)
            {
                case '01': // 第一層

                    $auth_cols  = '<a href="/share/setting/'.$auth.'" title="'.$SharingPreferences.'" alt="'.$SharingPreferences.'" style="width: '.$this->data['menu_width'].'; font-size:16px;">'.$SharingPreferences.'</a>';
                    $auth_title = $SharingPreferences;

                    break;

                case '02': // 第二層

                    $auth_cols_1  = '<a href="/middle/setting/'.$auth.'/share" title="'.$SharingPreferences.'" alt="'.$SharingPreferences.'" style="width: '.$this->data['menu_width'].'; font-size:16px;">'.$SharingPreferences.'</a>';
                    $auth_title_1 = $SharingPreferences;
                    $auth_cols_2  = '<a href="/middle/setting/'.$auth.'/quote" title="'.$ReferenceSet.'" alt="'.$ReferenceSet.'" style="width: '.$this->data['menu_width'].'; font-size:16px;">'.$ReferenceSet.'</a>';
                    $auth_title_2 = $ReferenceSet;
                    
                    break;

                case '03': // 第三層

                    $auth_cols  = '<a href="/quote/setting/'.$auth.'" title="'.$ReferenceSet.'" alt="'.$ReferenceSet.'" style="width: '.$this->data['menu_width'].'; font-size:16px;">'.$ReferenceSet.'</a>';
                    $auth_title = $ReferenceSet;
                    
                    break;
            }
        }
        $this->data['auth_cols']  = $auth_cols;
        $this->data['auth_title'] = $auth_title;

        // 通用頂部(Web Header)資訊
        $this->data['iqr_qrcode_box'] = base_url().'business/iqrc/'.$this->session->userdata('member_id');      // 名片qrcode彈出視窗網址
        $this->data['app_qrcode_box'] = base_url().'business/iqrc/'.$this->session->userdata('member_id').'/2'; // 名片qrcode彈出視窗網址
        $this->data['account']        = $m['account']; // 登入身分
        $deadline                     = ($this->data['web_config']['g_deadline_status'] == 0) ? $m['deadline'] : $this->data['web_config']['global_deadline'] ; // 期限
        $this->data['deadline']       = date('Y-m-d H:i', $deadline);           // 顯示期限
        $this->data['days']           = round(($deadline - time()) / 86400);    // 期限天數

        // 判斷使用期限
        if($this->session->userdata('member_id') && $this->session->userdata('member_id') != '')
        {
            if(!$this->check_deadline($data['web_config'], $this->session->userdata('member_id')))
            {
                redirect('/index/error');
            }
        }
        
        // 設定web banner
        $this->data['web_banner_dir'] = $this->set_web_banner_dir($this->data['domain_id'], $this->data['web_config']['web_banner'], $this->data['host']['domain']);

        $this->data['real_ip'] = $this->get_realip();
        
		// 設定上架資料
		$this->data['release_setting'] = $m['instore'];
	}

	// --------------------------------------------------------
	// export_order : 訂單查詢/匯出
	// --------------------------------------------------------
	// 訂單查詢/匯出
	public function order()
	{
		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{	
			//未登入
			$this->myredirect('/index/login', '請先登入', 5);
			return 0;
		}
		else
		{   $data = $this -> data; // data
			$this -> lang -> load('controllers/generator', $data['lang']);
			$data['ouput_Order_Status'] = lang('ouput_Order_Status');
			$data['ouput_Order_Number'] = lang('ouput_Order_Number');
			$data['ouput_Order_Date'] = lang('ouput_Order_Date');
			$data['ouput_Purchaser'] = lang('ouput_Purchaser');
			$data['ouput_Items'] = lang('ouput_Items');
			$data['ouput_total_amount'] = lang('ouput_total_amount');
			$data['ouput_Payment_status'] = lang('ouput_Payment_status');
			$data['ouput_operating'] = lang('ouput_operating');

			$data['data_array_show'] = 1;
			$data['mid'] = $member_id = $this -> session -> userdata('member_id');

            switch ($data['lang']) {
                case 'zh-tw':
                    $views_lang = '1';
                    break;
                case 'zh-cn':
                    $views_lang = '2';
                    break;
                case 'english':
                    $views_lang = '3';
                    break;
            }

			$payment_way = $this -> mod_generator -> select_account_payment($member_id);
			foreach ($payment_way as $key => $value)
            {
                $payment_way[$key]['pway_name'] = $value['pway_name_'. $views_lang];                
            }
            $data['payment_way'] = $payment_way;
            if($this -> input -> post('export_btn'))
			{
				// input 
				$s_date = $this -> input -> post('start_date');
				$e_date = $this -> input -> post('end_date');
				$prd_name = $this -> input -> post('prd_name');
				$email = $this -> input -> post('email');
				$phone = $this -> input -> post('phone');
				$product_flow = $this -> input -> post('product_flow');
				$pay_way_id = $this -> input -> post('pay_way_id');
				$status = $this -> input -> post('status');

				$data['post'] = $this -> input -> post();
				
				$data_where = array(
					'card_owner' 	=> $this -> session -> userdata('member_id'),
					'prd_name'      => $prd_name,
				);
				$data_where1 = array(
					'product_flow'	=> $product_flow,
					'status'		=> $status,
					'pay_way_id'	=> $pay_way_id,
					'email'			=> $email,
					'phone'			=> $phone
				);
				
				$s = $s_date ." 00:00:00";
				$e = $e_date ." 23:59:59";
				$s = strtotime($s);
				$e = strtotime($e);

				$data['data_array_show'] = 3;
				$data['order'] = $order = $this -> mod_generator -> select_like_group_by('order_details', 'date', desc, $data_where, $data_where1, $s, $e);
				if(!empty($order))
				{
					$data['data_array_show'] = 2; 
					$data['title_array'] = array(
						'ouput_Order_Status'	=>$data['ouput_Order_Status'],
						'ouput_Order_Number'	=>$data['ouput_Order_Number'],
						'ouput_Order_Date'	=>$data['ouput_Order_Date'],
						'ouput_Purchaser'	=>$data['ouput_Purchaser'],
						'ouput_Items'	=>$data['ouput_Items'],
						'ouput_total_amount'	=>$data['ouput_total_amount'],
						'ouput_Payment_status'	=>$data['ouput_Payment_status'],
						'ouput_operating'	=>$data['ouput_operating']
					);
					foreach ($order as $key => $value)
					{
						$data['data_array'][$key]['product_flow_name'] = $value['product_flow_name'];
						$data['data_array'][$key]['status_name'] = $value['status_name'];
						$data['data_array'][$key]['order_id'] = $value['order_id'];
						$data['data_array'][$key]['date'] = date('Y-m-d', $value['date']);
						$data['data_array'][$key]['name'] = $value['name'];
						$details_array = $this -> mod_generator -> get_order_details($value['id']);
						$details= $this -> product_getter($details_array);
						$data['data_array'][$key]['details'] = $details;
						$data['data_array'][$key]['total_price'] = $value['total_price'];
						$data['data_array'][$key]['id'] = $value['id'];
					}
				}
			}
			$this -> load -> view('generator/order', $data);
		}
	}

	// 產品字串拆解
	private function product_getter($items)
	{
        foreach ($items as $key => $value)
        {
        	if($key != 0)
        		$this -> item .= '/' . $value['name'] . 'x' . $value['quantity'];
        	else
        		$this -> item = $value['name'] . 'x' . $value['quantity'];
        }
        return $this -> item;
	}

    // 區間 xls 匯出
	public function export_order_xls()
	{
		// input 
		switch ($this -> data['lang']) {
				case 'zh-tw':
					$lang_number = '1';
					break;
				case 'zh-cn':
					$lang_number = '2';
					break;
				case 'english':
					$lang_number = '3';
					break;
			}
		$s_date = $this -> input -> post('start_date');
		$e_date = $this -> input -> post('end_date');
		$prd_name = $this -> input -> post('prd_name');
		$email = $this -> input -> post('email');
		$phone = $this -> input -> post('phone');
		$product_flow = $this -> input -> post('product_flow');
		$pay_way_id = $this -> input -> post('pay_way_id');
		$status = $this -> input -> post('status');

		$data_where = array(
			'card_owner' 	=> $this -> session -> userdata('member_id'),
			'prd_name'      => $prd_name,
		);
		$data_where1 = array(
			'status'		=> $status,
			'product_flow'	=> $product_flow,
			'pay_way_id'	=> $pay_way_id,
			'email'			=> $email,
			'phone'			=> $phone,
		);

		$s = $s_date ." 00:00:00";
		$e = $e_date ." 23:59:59";
		$s = strtotime($s);
		$e = strtotime($e);
		
		$order = $this -> mod_generator -> order_subquery('order_details', 'date', desc, $data_where, $data_where1, $s, $e);
		if(!empty($order))
		{
			$data['data_array_show'] = 2; 
			$data['title_array'] = array(
				'ouput_Order_Status'  => $lang['ouput_Order_Status'],				
				'ouput_Order_Number'  => $lang['ouput_Order_Number'],
				'ouput_Order_Date'  => $lang['ouput_Order_Date'],
				'ouput_Purchaser'  => $lang['ouput_Purchaser'],
				'ouput_Items'  => $lang['ouput_Items'],
				'ouput_total_amount'  => $lang['ouput_total_amount'],
				'ouput_Payment_status'  => $lang['ouput_Payment_status'],
				'ouput_operating'  => $lang['ouput_operating'],
				'ouput_Purchaser'  => $lang['ouput_Purchaser'],
				'ouput_Telephone_purchase'  => $lang['ouput_Telephone_purchase'],
				'ouput_Purchaser_mailbox'  => $lang['ouput_Purchaser_mailbox'],
				'ouput_Recipient_address'  => $lang['ouput_Recipient_address'],
				'ouput_Invoice'  => $lang['ouput_Invoice'],
				'ouput_Invoice_TongBian'  => $lang['ouput_Invoice_TongBian'],
				'ouput_Invoice_address'  => $lang['ouput_Invoice_address'],
				'ouput_payment_method'  => $lang['ouput_payment_method'],
				'ouput_Shipping_methods'  => $lang['ouput_Shipping_methods'],
				'ouput_Trading_Order_Number'  => $lang['ouput_Trading_Order_Number'],
				'ouput_Fu_Bao_European_Order'  => $lang['ouput_Fu_Bao_European_Order'],
				'ouput_MasterCard_Order'  => $lang['ouput_MasterCard_Order'],
				'ouput_Payment_time'  => $lang['ouput_Payment_time'],

			);

			foreach ($order as $key => $value)
			{
				// product_flow_name : 0,新訂單 1,處理中 2,已出貨 3,取消交易 4,交易完成 5,退貨 6,換貨
				$data['data_array'][$key][] = $value['product_flow_name'];

				$data['data_array'][$key][] = $value['order_id'];
				
				// 條件撈取
				$details_array = $this -> mod_generator -> get_order_details($value['id']);
				$details = $this -> product_getter($details_array);
				$data['data_array'][$key][] = $details;

				$data['data_array'][$key][] = $value['total_price'];
				$data['data_array'][$key][] = $value['name'];
				$data['data_array'][$key][] = $value['phone'];
				$data['data_array'][$key][] = $value['email'];
				$data['data_array'][$key][] = $value['zip'] . $value['county'] . $value['area'] . $value['address'];
				$data['data_array'][$key][] = $value['receipt_title'];
				$data['data_array'][$key][] = $value['receipt_code'];
				$data['data_array'][$key][] = $value['receipt_zip'] . $value['receipt_county'] . $value['receipt_area'] . $value['receipt_address'];
				
				// 條件撈取
				// 付款方式
				$payment = $this -> mod_generator -> select_from('payment_way', array('pway_id' => $value['pay_way_id']));
				$data['data_array'][$key][] = $payment['pway_name_'.$lang_number];
				// 物流方式
				$lway = $this -> mod_generator -> select_from('logistics_way', array('lway_id' => $value['lway_id']));
				$data['data_array'][$key][] = $lway['lway_name'];
				
				// 條件撈取
				// status_name : 0,未付款 1,已付款 2,退款
				$data['data_array'][$key][] = $value['status_name'];
				
				$data['data_array'][$key][] = $value['trade_no'];
				$data['data_array'][$key][] = $value['allpay_no'];
				$data['data_array'][$key][] = $value['gomypay_no'];
				$data['data_array'][$key][] = $value['trade_date'];
			}
			$this->export_xls($data['title_array'], $data['data_array'], date("Y-m-d", time()));
		}
		else
			$this -> script_message('查無資料', '/generator/order');
	}

	// 總訂單匯出
	public function export()
	{
		$lang = $this -> language;
		$data_where = array(
			'card_owner' 	=> $this -> session -> userdata('member_id'),
		);
		
		$order = $this -> mod_generator -> select_All_order('order_details', 'date', desc, $data_where);
		if(!empty($order))
		{
			$data['data_array_show'] = 2; 
			$data['title_array'] = array(
				'ouput_Order_Status'  => $lang['ouput_Order_Status'],				
				'ouput_Order_Number'  => $lang['ouput_Order_Number'],
				'ouput_Order_Date'  => $lang['ouput_Order_Date'],
				'ouput_Purchaser'  => $lang['ouput_Purchaser'],
				'ouput_Items'  => $lang['ouput_Items'],
				'ouput_total_amount'  => $lang['ouput_total_amount'],
				'ouput_Payment_status'  => $lang['ouput_Payment_status'],
				'ouput_operating'  => $lang['ouput_operating'],
				'ouput_Purchaser'  => $lang['ouput_Purchaser'],
				'ouput_Telephone_purchase'  => $lang['ouput_Telephone_purchase'],
				'ouput_Purchaser_mailbox'  => $lang['ouput_Purchaser_mailbox'],
				'ouput_Recipient_address'  => $lang['ouput_Recipient_address'],
				'ouput_Invoice'  => $lang['ouput_Invoice'],
				'ouput_Invoice_TongBian'  => $lang['ouput_Invoice_TongBian'],
				'ouput_Invoice_address'  => $lang['ouput_Invoice_address'],
				'ouput_payment_method'  => $lang['ouput_payment_method'],
				'ouput_Shipping_methods'  => $lang['ouput_Shipping_methods'],
				'ouput_Trading_Order_Number'  => $lang['ouput_Trading_Order_Number'],
				'ouput_Fu_Bao_European_Order'  => $lang['ouput_Fu_Bao_European_Order'],
				'ouput_MasterCard_Order'  => $lang['ouput_MasterCard_Order'],
				'ouput_Payment_time'  => $lang['ouput_Payment_time'],
			);

			foreach ($order as $key => $value)
			{
				// product_flow_name : 0,新訂單 1,處理中 2,已出貨 3,取消交易 4,交易完成 5,退貨 6,換貨
				$data['data_array'][$key][] = $value['product_flow_name'];

				$data['data_array'][$key][] = $value['order_id'];
				
				// 條件撈取
				$details_array = $this -> mod_generator -> get_order_details($value['id']);
				$details = $this -> product_getter($details_array);
				$data['data_array'][$key][] = $details;

				$data['data_array'][$key][] = $value['total_price'];
				$data['data_array'][$key][] = $value['name'];
				$data['data_array'][$key][] = $value['phone'];
				$data['data_array'][$key][] = $value['email'];
				$data['data_array'][$key][] = $value['zip'] . $value['county'] . $value['area'] . $value['address'];
				$data['data_array'][$key][] = $value['receipt_title'];
				$data['data_array'][$key][] = $value['receipt_code'];
				$data['data_array'][$key][] = $value['receipt_zip'] . $value['receipt_county'] . $value['receipt_area'] . $value['receipt_address'];
				
				// 條件撈取
				// 付款方式
				$payment = $this -> mod_generator -> select_from('payment_way', array('pway_id' => $value['pay_way_id']));
				$data['data_array'][$key][] = $payment['pway_name_'.$lang_number];

				// 物流方式
				$lway = $this -> mod_generator -> select_from('logistics_way', array('lway_id' => $value['lway_id']));
				$data['data_array'][$key][] = $lway['lway_name'];
				
				// 條件撈取
				// status_name : 0,未付款 1,已付款 2,退款
				$data['data_array'][$key][] = $value['status_name'];
				
				$data['data_array'][$key][] = $value['trade_no'];
				$data['data_array'][$key][] = $value['allpay_no'];
				$data['data_array'][$key][] = $value['gomypay_no'];
				$data['data_array'][$key][] = $value['trade_date'];
			}
			$this->export_xls($data['title_array'], $data['data_array'], date("Y-m-d", time()));
		}
		else
			$this -> script_message('查無資料', '/generator/order');
	}

	// public function test()
	// {
	// 	$data = $this -> mod_generator -> select_from_order('order', 'id', asc);
	// 	foreach ($data as $skey => $svalue)
	// 	{
	// 		$item = $this -> get_serialstr($svalue['details'], '++');
	// 		foreach ($item as $key => $value) {
 //            	$details = explode('*#', $value);
 //            	$prd = $this -> mod_generator -> select_from('products', array('prd_id' => $details[0])); // 產品資料
 //            	$number = $details[1];
	// 			$name = $prd['prd_name'];
	// 			if(!empty($prd))
	// 			{
	// 					$status = (string)$svalue['status'];
	// 				$insert_data = array(
	// 					'oid'			=> $svalue['id'],
	// 					'by_id'			=> $svalue['by_id'],
	// 					'order_id'		=> $svalue['order_id'],
	// 					'card_owner'	=> $svalue['card_owner'],
	// 					'prd_name'		=> $name,
	// 					'price'			=> $prd['prd_price00'],
	// 					'number'		=> $number,
	// 					'total_price'	=> $number * $prd['prd_price00'],
	// 					'date'			=> $svalue['date'],
	// 				);
	// 				$this -> mod_generator -> insert_into('order_details', $insert_data);
	// 			}
	// 		}
	// 	}
	// 	echo 'finish';
	// }
}
