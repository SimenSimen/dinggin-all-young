<?php
class Photo_category extends MY_Controller
{
	public $data="";
	private $error="";
	public $Clanguage='';
	
	public function __construct()
	{
		parent::__construct();

		// language
        $this -> load -> helper('language');
        if(!$this -> session -> userdata('lang'))
        {
            $this -> session -> set_userdata('lang', 'zh-tw');
            $this -> data['lang'] = $this -> session -> userdata('lang');
        }
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

        // language
        $this -> lang -> load('controllers/photo_category', $this -> data['lang']);
        $ReferenceSet = lang('ReferenceSet');
        $SharingSet = lang('SharingSet');
        $this -> Clanguage['ParameterError'] = lang('ParameterError');
        $this -> Clanguage['PleaseLogin'] = lang('PleaseLogin');
        $this -> Clanguage['ScanName'] = lang('ScanName');


		//helper
		$this->load->helper('url');
		// base_url
		$this->data['base_url'] = base_url();
		
		// model
		$this->load->model('business_model', 'mod_business');
		
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
		$m = $this->mod_business->select_from('member', array('member_id'=>$this->session->userdata('member_id')));
		
		//id on 菜單高亮處理
		$id_on_index = substr($_SERVER['REQUEST_URI'], 10);
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
		
				$auth_cols  = '<a href="/share/setting/'.$auth.'" title="'.$SharingSet.'" alt="'.$SharingSet.'" style="width: '.$this->data['menu_width'].'; font-size:16px;">'.$SharingSet.'</a>';
				$auth_title = $SharingSet;
		
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
		
					$auth_cols  = '<a href="/share/setting/'.$auth.'" title="'.$SharingSet.'" alt="'.$SharingSet.'" style="width: '.$this->data['menu_width'].'; font-size:16px;">'.$SharingSet.'</a>';
					$auth_title = $SharingSet;
		
					break;
		
				case '02': // 第二層
		
					$auth_cols_1  = '<a href="/middle/setting/'.$auth.'/share" title="'.$SharingSet.'" alt="'.$SharingSet.'" style="width: '.$this->data['menu_width'].'; font-size:16px;">'.$SharingSet.'</a>';
					$auth_title_1 = $SharingSet;
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
		
		// 設定 web banner
		$this->data['web_banner_dir'] = $this->set_web_banner_dir($this->data['domain_id'], $this->data['web_config']['web_banner'], $this->data['host']['domain']);
		
		$this->data['real_ip'] = $this->get_realip();
		
		// 設定上架資料
		$this->data['release_setting'] = $m['instore'];

		//亂碼
		header("Content-Type:text/html; charset=utf-8");
	}

	//列表
	public function main()
	{
		$Clanguage = $this -> Clanguage;

		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{
			//未登入
			$this->myredirect('/index/login', $Clanguage['PleaseLogin'], 5);
			return 0;
		}
		else
		{
			$data=$this->data;

			// language
            $this -> lang -> load('views/business/photo_category', $data['lang']);
            $data['Delete'] = lang('Delete');
            $data['NotFirefoxChromIE'] = lang('NotFirefoxChromIE');
            $data['AlbumAdd'] = lang('AlbumAdd');
            $data['Modify'] = lang('Modify');
            $data['Add'] = lang('Add');
            $data['_AddAlbum'] = lang('_AddAlbum');
            $data['SortSave'] = lang('SortSave');
            $data['AlbumName'] = lang('AlbumName');
            $data['Sort'] = lang('Sort');
            $data['Successful_save'] = lang('Successful_save');

           


			$this->load->model("photo_category_model");
			$data["list_data"]=$this->photo_category_model->get_photo_category();
			$data["error"]=$this->error;
			$this -> load -> view('business/photo_category', $data);
		}
	}

	//新增資料
	public function add_data()
	{
		$Clanguage = $this -> Clanguage;
		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{
			//未登入
			$this->myredirect('/index/login', $Clanguage['PleaseLogin'], 5);
			return 0;
		}
		else
		{
			$this->error="";
			if(!$this->SetReLoadCheck("SS")){
				if(!$this->input->post('d_name') || empty($_POST['d_name']) ){
					$this->error=$Clanguage['ScanName'];
				}
				if(empty($_POST['d_name'])){
					$this->error=$Clanguage['ScanName'];
				}
			
				if(empty($this->error)){
					$this->load->model("photo_category_model");
					$data=array(
						"d_name"=>$this->input->post("d_name")
						,"d_content"=>""
					);
					$this->error=$this->photo_category_model->add_photo_category($data,$this->input->post('d_name'));
				}
			}
			$this->main();
		}
	}

	//修改資料
	public function edit_data()
	{
		$Clanguage = $this -> Clanguage;
		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{
			//未登入
			$this->myredirect('/index/login', $Clanguage['PleaseLogin'], 5);
			return 0;
		}
		else
		{
			$this->error="";
			if(!$this->SetReLoadCheck("SS")){
				if(!$this->input->post('d_id') || empty($_POST['d_id'])){
					$this->error=$Clanguage['ParameterError'];
				}
				if(!$this->input->post('d_name') || empty($_POST['d_name'])){
					$this->error=$Clanguage['ScanName'];
				}
				if(empty($this->error)){
					$this->load->model("photo_category_model");
					$data=array(
						"d_name"=>$this->input->post("d_name")
					);
					$this->error=$this->photo_category_model->edit_photo_category($data,$this->input->post('d_id'),$this->input->post('d_name'));
				}
			}
			$this->main();
		}
	}

	//刪除資料
	public function del_data()
	{
		$Clanguage = $this -> Clanguage;
		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{
			//未登入
			$this->myredirect('/index/login', $Clanguage['PleaseLogin'], 5);
			return 0;
		}
		else
		{
			$this->error="";
			if(!$this->SetReLoadCheck("SS")){
				if(!$this->input->post('d_id') || empty($_POST['d_id'])){
					$this->error=$Clanguage['ParameterError'];
				}
				else{
					$photo_category = $this -> mod_business -> select_from('photo_category', array('d_id' => $this -> input -> post('d_id')));
				}
				if(!empty($photo_category['d_photo'])){
					$this -> error = $Clanguage['ParameterError'];
				}
				if(empty($this->error)){
					$this->load->model("photo_category_model");
					$this->error=$this->photo_category_model->del_photo_category($this->input->post('d_id'));
				}
			}
			$this->main();
		}
	}

	// 排序儲存
	public function sort_data()
	{
		$Clanguage = $this -> Clanguage;
		$this -> error = "";
		if(!$this -> input -> post('sort_data'))
		{
			$this -> error = $Clanguage['ParameterError'];
		}
		else
		{
			$sort = $this -> input -> post('sort_data');
			foreach ($sort as $key => $value)
			{
				$this -> mod_business -> update_set('photo_category', 'd_id', $value['value'], array('d_sort' => $key + 1));
			}
			echo 'refresh';
		}
	}

	//檢查是否按下重新整理
	//use
	private function SetReLoadCheck($ST)
	{
		@session_start();
		$run=false;
		$parm=$this->input->post('parm');
		if(!empty($parm)){
			if(isset($_SESSION[$ST.'_parm'])){
				if($_SESSION[$ST.'_parm']!=$parm){
					$_SESSION[$ST.'_parm']=$parm;
				}
				else{
					$run=true;
				}
			}
			else{
				$_SESSION[$ST.'_parm']=$parm;
			}
		}
		@session_write_close();
		return $run;
	}
}
