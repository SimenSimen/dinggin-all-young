<?php
class Index extends MY_Controller
{
	public $data='';
	public $language='';

	public function __construct()//初始化
	{
		parent::__construct();

		// language
		$this -> load -> helper('language');
		if(!$this -> session -> userdata('lang') || $this -> session -> userdata('lang') == 'zh-tw')
		{
			$this -> session -> set_userdata('lang', 'TW');
			$this -> data['lang'] = $this -> session -> userdata('lang');
		}
		else
			$this -> data['lang'] = $this -> session -> userdata('lang');
		$this -> load -> model('language_model', 'mod_language');
		$lang = $this -> mod_language -> converter('14', $this -> session -> userdata('lang'));
		$this -> data = array_merge($this -> data, $lang);

		//model
		$this->load->model('index_model', 'mod_index');
		$this->load->model('news_model', 'mod_news');
		//library
		$this->load->library('encrypt');
		$this->load->library('mylib/useful');
		//banner
		$this->load->model(array('banner_model'));
		$this->data['banner'] = $this->banner_model->getMyAd();
		//helper
		$this->load->helper('url');
		//host
		$this->data['host']=$this->get_host_config();
		//domain id
		if($this->session->userdata('session_domain'))
			$this->data['domain_id']=$this->session->userdata('session_domain');
		else
			$this->data['domain_id']=$this->data['host']['domain_id'];

		//web config
		$this->data['web_config']=$this->get_web_config($this->data['domain_id']);

	}
	//商城首頁
	public function index(){
		@session_start();
		//語言包
		if($_GET['isapp']=='app'){
			$this->session->set_userdata('isapp', true);//判斷是不是APP
		}
		if(isset($_GET['utm_source']) and $_GET['utm_source']=='affiliates'){
			setcookie("upline",'FA-AM888');
		}
		
		
		if($this->data['web_config']['is_transfer']==1){
			$this->useful->AlertPage('/'.$this->data['web_config']['transfer']);
		} else {
			$data = [];
			/** load the languages packages */
			$this->lang->load('views/' . $this->indexViewPath . '/index', $this->data['lang']);
			
			/** turn off breadcrumbs */
			$data['breadcrumbOff'] = true;

			$data['newProducts'] = [];
			$data['brands'] = [];
			$data['productCategorys'] = [];
			$data['banners'] = [];
			$data['test'] = 12313;
			
			$this->load->view($this->indexViewPath . '/header', $data);
			$this->load->view($this->indexViewPath . '/index', $data);
			$this->load->view($this->indexViewPath . '/footer', $data);
		}
	}

	public function about($s_id=0){
		@session_start();
		//撈取關於我們單筆資料
		if(empty($s_id)){
			$about_data=$this->mymodel->get_about_data($this->setlang);
			$id=$about_data[0]['did'];
			if(!empty($about_data)){
				echo '<script>window.location.href="/index/about/'.$id.'"</script>';
			}else{
				echo '<script>window.location.href="/index"</script>';
			}
		}
		$aboutdata=$this->mymodel->get_about_one_data($s_id,$this->setlang);
		if(empty($aboutdata)){
			$about_data=$this->mymodel->get_about_data($this->setlang);
			$id=$about_data[0]['did'];
			echo '<script>window.location.href="/index/about/'.$id.'"</script>';
		}
		$data['about']=$aboutdata;

		$this->DataName='about';
		$this->lang=$this->lmodel->config('1',$this->setlang);
		$data['path_title']='<li><span>'.$this->lang["$this->DataName"].'</span></li>';
		$data['path_title']=$data['path_title'].'<li><a href="/index/about/'.$s_id.'"><span>'.$aboutdata['name'].'</span></a></li>';
		$data['banner']='';
		//撈取關於我們list
		$data['side_link_type']=$this->mymodel->get_about_data($this->setlang);
		$data['s_id']=$s_id;
		$data['banner']=$this->data['banner'];

		//view
		$this->load->view('index/header'.$this->style, $data);
		$this->load->view('index/about/about_nav', $data);
		$this->load->view('index/about/about_show', $data);
		$this->load->view('index/footer'.$this->style, $data);
	}
	//最新消息
	public function news(){
		@session_start();
		$this->DataName='service';
		$this->lang=$this->lmodel->config('1',$this->setlang);
		$service_data=$this->mymodel->get_service_data($this->setlang);
		$id=$service_data[0]['did'];
		if(!empty($service_data)){
			echo '<script>window.location.href="/index/news_detail/'.$id.'"</script>';
		}else{
			echo '<script>window.location.href="/index"</script>';
		}
		//$data['path_title']='<li><a href="/index/news"><span>'.$this->lang["$this->DataName"].'</span></a></li>';
		//$data['banner']=$this->data['banner'];
		//$data['title'] = $this->lang["$this->DataName"];
		//撈取最新消息list
		//$data['list']=$this->mymodel->get_service_data($this->set_language);
		//$data['side_link_type']=$this->mymodel->get_service_data($this->set_language);
		//$data['s_id']=$s_id;
		//view
		//$this->load->view('index/header'.$this->style, $data);
		//$this->load->view('index/news/news_nav', $data);
		//$this->load->view('index/news/news', $data);
		//$this->load->view('index/footer'.$this->style, $data);
	}
	public function news_detail($s_id){
		@session_start();
		//撈取最新消息單筆資料
		$servicedata=$this->mymodel->get_service_one_data($s_id,$this->set_language);
		if(empty($servicedata)){
			echo '<script>window.location.href="/index/news"</script>';
		}
		$data['service']=$servicedata;
		$this->DataName='service';
		$this->lang=$this->lmodel->config('1',$this->setlang);
		$data['path_title']='<li><a href="/index/news"><span>'.$this->lang["$this->DataName"].'</span></a></li>'.'<li><a href="/index/news_detail/'.$s_id.'"><span>'.$servicedata['name'].'</span></a></li>';
		$data['banner']=$this->data['banner'];
		$data['side_link_type']=$this->mymodel->get_service_data($this->set_language);
		$data['s_id']=$s_id;
		//view
		$this->load->view('index/header'.$this->style, $data);
		$this->load->view('index/news/news_nav', $data);
		$this->load->view('index/news/news_detail', $data);
		$this->load->view('index/footer'.$this->style, $data);
	}

	//農業關懷,美學生活(最新消息)
	public function content($element = '',$category_id = 0,$account = ''){
		$data = $this -> mod_views -> category_list($element);
		@session_start();
		$this->DataName='news';
		$this->lang=$this->lmodel->config('1',$this->setlang);
		$data['path_title']='<li><a href="/index/content/'.$element.'"><span>'.$this->lang["$element"].'</span></a></li>';
		$data['banner']=$this->data['banner'];
		$data['title'] = $this->lang["$this->DataName"];
		//語言包
		$this->lang=$this->lmodel->config('3',$this->setlang);
		if(!empty($data['list'])){
			if($category_id==0){
				$data['category_id']=$category_id=$data['list'][0]['id'];
			}
			$data['list_detail']=$this->mymodel->get_news_data($category_id);
			if(empty($data['list_detail'])){//此分類無資料
				echo "<script>window.location.href='/index/content/'$element</script>";
			}
			$data['category_type'] = (!empty($auth_category['type'])) ? $auth_category['type'] : $element;
			$data['category_id']=$category_id;
			//抓現在目錄名稱
			$category_name='';
			foreach ($data['list'] as $key => $value):
				if($value['id']==$category_id){
					$category_name=$value['name'];
				}
			endforeach;

			$data['path_title']=$data['path_title'].'<li><a href="/index/content/'.$element.'/'.$category_id.'"><span>'.$category_name.'</span></a></li>';
		}else{
			echo '<script>window.location.href="/index"</script>';
		}
		if(empty($data['list_detail'])){
			echo '<script>window.location.href="/index/content/'.$element.'"</script>';
		}
		$data['category_name']=$category_name;
		$data['element']=$element;
		//view
		$this->load->view('index/header'.$this->style, $data);
		$this->load->view('index/content/content_nav', $data);
		$this->load->view('index/content/content', $data);
		$this->load->view('index/footer'.$this->style, $data);
	}
	//detail
	public function content_detail($element, $category_id, $id = '',$isshareurl='',$docallapp='',$account = ''){
		$data = $this -> mod_views -> category_list($element);
		$auth_category = $this -> mod_views -> select_from('auth_category', array('type', 'c_name as name', 'category_id as id'), array('category_id' => $category_id, 'lang_type' => $this->setlang), 'row');
		$data['title'] = $auth_category['name'];
		$data['category_type'] = (!empty($auth_category['type'])) ? $auth_category['type'] : $element;
		$enews	= $this->mymodel->OneSearchSql('enews','enews_id',array('enews_id'=>$id,'category_id'=>$category_id,'enable'=>'1'));
		if(empty($enews)){
			echo '<script>window.location.href="/index/content/'.$element.'"</script>';
		}
		//撈取單筆
		$news=$this->mymodel->get_news_one_data($id);
		$data['news']=$news;
		$this->DataName='news';
		$this->lang=$this->lmodel->config('1',$this->setlang);
		$data['path_title']='<li><a href="/index/content"><span>'.$this->lang["$element"].'</span></a></li>';
		$category_name='';
		//抓現在目錄名稱
		if(!empty($data['list'])){
			foreach ($data['list'] as $key => $value):
				if($value['id']==$category_id){
					$category_name=$value['name'];
				}
			endforeach;
		}
		$data['path_title']=$data['path_title'].'<li><a href="/index/content/'.$element.'/'.$category_id.'"><span>'.$category_name.'</span></a></li>';
		$data['path_title']=$data['path_title'].'<li><a href="/index/content_detail/'.$element.'/'.$category_id.'/'.$id.'"><span>'.$news['name'].'</span></a></li>';
		$data['banner']=$this->data['banner'];
		$data['category_id']=$category_id;
		$data['category_name']=$category_name;
		$data['element']=$element;
		//view
		$this->load->view('index/header'.$this->style, $data);
		$this->load->view('index/content/content_nav', $data);
		$this->load->view('index/content/content_detail', $data);
		$this->load->view('index/footer'.$this->style, $data);
	}

	//芬芳美學沙龍(活動花絮 分類)
	public function photo($type_id = 0){
		if($type_id==0){
			$photo_type=$this->mymodel->select_page_form('photo_type','','d_id',array('lang_type'=>$this->setlang,'d_enable'=>'Y'),'d_sort');
			if(!empty($photo_type)){
				echo '<script>window.location.href="/index/photo/'.$photo_type['0']['d_id'].'"</script>';
			}else{
				echo '<script>window.location.href="/index"</script>';
			}
		}
		$photo_type= $this->mymodel->OneSearchSql('photo_type','d_name, d_content',array('d_id'=>$type_id));
		$data = $this -> mod_views -> category_list('photo', $type_id);
		@session_start();
		$this->DataName='album';
		$this->lang=$this->lmodel->config('41',$this->setlang);
		$data['path_title']='<li><a href="/index/photo"><span>'.$this->lang_menu["$this->DataName"].'</span></a></li><li><a href="/index/photo/"'.$type_id.'><span>'.$photo_type["d_name"].'</span></a></li>';
		$data['banner']='';
		$data['side_link_type']=$this->mymodel->select_page_form('photo_type','','d_id, d_name',array('lang_type'=>$this->setlang,'d_enable'=>'Y'),'d_sort');
		$data['title'] = $photo_type['d_name'];
		$data['category_id']=$type_id;
		$data['d_content']=$photo_type['d_content'];
		$data['banner']=$this->data['banner'];
		//view
		$this->load->view('index/header'.$this->style, $data);
		$this->load->view('index/photo/photo_nav', $data);
		$this->load->view('index/photo/photo', $data);
		$this->load->view('index/footer'.$this->style, $data);
	}
	//芬芳美學沙龍(活動花絮)detail
	public function photo_detail($category_id = 0){
		@session_start();
		$this->DataName='album';
		$photo_category	= $this->mymodel->OneSearchSql('photo_category','d_id,d_type',array('d_id'=>$category_id,'d_enable'=>'Y'));
		$photo_type		= $this->mymodel->OneSearchSql('photo_type','d_id,d_name, d_content',array('d_id'=>$photo_category['d_type'],'d_enable'=>'Y'));
		if(empty($photo_category)){
			echo '<script>window.location.href="/index/photo"</script>';
		}
		$this->lang=$this->lmodel->config('41',$this->setlang);
		$data['path_title']='<li><span>'.$this->lang_menu["$this->DataName"].'</span></li>';
		$data['banner']='';
		$data['side_link_type']=$this->mymodel->select_page_form('photo_type','','d_id, d_name',array('lang_type'=>$this->setlang,'d_enable'=>'Y'),'d_sort');
		$data['category_id']=$photo_category['d_type'];
		$data['d_content']=$photo_type['d_content'];

		//抓取第2層相片
		$data['list_photo']=$this->mymodel->get_photo_data($category_id);

		//抓取第1層相簿名稱
		$photodata=$this->mymodel->get_photo_one_data($category_id);

		//影片標題
		$data['d_video_name']=explode('*#',$photodata['d_video_name']);
		//影片連結
		$data['d_video_link']=explode('*#',$photodata['d_video_link']);

		$data['banner']=$this->data['banner'];
		$data['photo']=$photodata;
		$data['path_title']=$data['path_title'].'<li><a href="/index/photo/'.$photo_category['d_type'].'"><span>'.$photo_type['d_name'].'</span></a></li>'.'<li><a href="/index/photo_detail/'.$category_id.'"><span>'.$photodata['d_name'].'</span></a></li>';
		$data['body_class']='products';

		//view
		$this->load->view('index/header'.$this->style, $data);
		$this->load->view('index/photo/photo_nav', $data);
		$this->load->view('index/photo/photo_detail', $data);
		$this->load->view('index/footer'.$this->style, $data);
	}


	public function s_lang($case = '')
	{
		switch ($case) {
			case '1':
				$this -> session -> set_userdata('lang', 'EN');
				break;
			case '2':
				$this -> session -> set_userdata('lang', 'JAP');
				break;
			default:
				$this -> session -> set_userdata('lang', 'TW');
				break;
		}
	}

	//時間
	public function showtime($time='')
	{
		echo date_default_timezone_get().'<br>';
		echo time().'<br>';
		echo date('Y-m-d H:i:s', time()).'<br>';

		if($time != '')
		{
			echo '<br>';
			echo $time.'<br>';
			echo date('Y-m-d H:i:s', $time).'<br>';
		}

		return 0;
	}

	//錯誤頁面
	public function error()
	{
		// content , http error, header title
		show_error('無此頁面', '404', 'Error');
		// $this->myredirect(base_url(), '無此頁面', 5);
		return 0;
	}

	//註冊頁面
	public function register($auth='')
	{
		//data
		$data=$this->data;
		$language = $this -> language;
		$this -> lang -> load('register', $data['lang']);
		$data['_Registered'] = lang('_Registered');
		$data['NotFirefoxChromIE'] = lang('NotFirefoxChromIE');
		$data['Registered'] = lang('Registered');
		$data['ActionBusiness'] = lang('ActionBusiness');
		$data['AccountNumber'] = lang('AccountNumber');
		$data['Password'] = lang('Password');
		$data['CheckPassword'] = lang('CheckPassword');
		$data['Email'] = lang('Email');
		$data['CardNumber'] = lang('CardNumber');
		$data['LicenseKey'] = lang('LicenseKey');
		$data['ScanRightNum'] = lang('ScanRightNum');
		$data['SendRegisteredData'] = lang('SendRegisteredData');
		$data['ReturnsLogin'] = lang('ReturnsLogin');
		$data['SendRegisteredDataNow'] = lang('SendRegisteredDataNow');

		//檢查公司註冊入口驗證碼
		if($auth != '')
		{
			if($this->session->userdata('session_domain') || ($auth == $this->encrypt->decode($data['web_config']['register_code'])))
			{
				//入口代入form action
				$data['register_code']=$auth;

				if(!$this->input->post('account'))
				{
					//驗證碼設定
					$len=5;
					$num=$this->random_vcode($len);
					$this->session->unset_userdata('VCODE');
					for($i = 0; $i < $len; $i++)
					{
						$this->session->set_userdata('VCODE', $this->session->userdata('VCODE').$num[$i]);
					}
					$s_vcode=$this->my_encrypt_encode($this->session->userdata('VCODE'));
					$vode_link=base_url().'index/vcode/'.$len.'/?s='.$s_vcode;
					$data['img']='<img id="vcode_img" src="'.$vode_link.'">';
					$data['hiddenvcode']=$s_vcode;

					//base_url()
					$data['base_url']=base_url();

					//view
					$this->load->view('register', $data);
				}
				else
				{
					//現在時間
					$now_time=time();

					//deadline
					if($this->input->post('key_value') != -1)
					{
						$effectiveDate=date('Y-m-d', $now_time);
						$keys_data=$this->mod_index->select_from('keys', array('key_value'=>$this->input->post('key_value')));
						$deadline=strtotime("+".$keys_data['key_power']." months", strtotime($effectiveDate));
					}
					else
					{
						$effectiveDate=date('Y-m-d', $now_time);
						$deadline=strtotime("+12 months", strtotime($effectiveDate));
					}
					$deadline=$deadline+86400;

					//密碼加密
					$usr_password=$this->encrypt->encode($this->input->post('password'));

					//會員資料
					$member_info=array(
						'account'	=> $this->input->post('account'),
						'domain_id'	=> $data['domain_id'],
						'password'	=> $usr_password,
						'email'		=> $this->input->post('email'),
						'addtime'	=> $now_time,
						'deadline'	=> $deadline,
						'auth'		=> '0'.$data['web_config']['auth_level_num']//預設層級-最底層
					);
					$member_id = $this->mod_index->insert_into('member', $member_info);
					$domin0 = $this -> mod_index -> select_from('domain', array('domain_id' => $data['domain_id']));
					$shelf_info = array(
						'member_id' 	=> $member_id,
						'shelf_HD_url'  => 'images/web_style_images/'.$domin0['domain'].'/app_welcome_page/icon.png',
						'type'			=> 0
					);
					$shelf_id = $this->mod_index->insert_into('application_shelves',$shelf_info);

					//行動名片欄位
					$iqr_info=array(
						'member_id'			 => $member_id,
						'banner_status'		 => 0,
						'banner_status_name' => '',
						'theme_id'			 => 1,
						'theme_bg_type'		 => 0,
						'cart_id'			 => 1
					);
					$iqr_id = $this->mod_index->insert_into('iqr', $iqr_info);

					//商店
					if($data['web_config']['cart_status'] == 1)
					{
						//cset_code
						$this->load->model('cart_model', 'mod_cart');
						$cset_code=$this->mod_cart->make_random_cset_code(12);

						$cart_data=array(
							'member_id'		 => $member_id,
							'cset_code'		 => $cset_code,
							'cset_name'		 => $language['ActionStore'],
							'cset_active'	 => 0
						);
						$cart_id = $this->mod_index->insert_into('iqr_cart', $cart_data);

						// 新增付款方式到 iqr_trans 對應 cset_id
						$payment_way = $this->mod_cart->select_from_order('payment_way', 'pway_id', 'asc', array('active'=>1));
						foreach($payment_way as $key => $value)
						{
							$insert_data = array(
								'cset_id' 	=> $cart_id,
								'pway_id'	=> $value['pway_id'],
								'active'	=> $value['default_active']
							);
							$iqrt_id = $this->mod_cart->insert_into('iqr_trans', $insert_data);
						}

						$logistics_way = $this -> mod_cart -> select_from_order('logistics_way', 'lway_id', 'asc', array('active' => 1));
						foreach ($logistics_way as $key => $value)
						{
							$insert_logistics = array(
								'cset_id'	=> $cart_id,
								'lway_id'	=> $value['lway_id'],
								'active'	=> $value['default_active']
							);
							$logistics_id = $this->mod_cart->insert_into('iqr_logistics', $insert_logistics);
						}
					}

					//會員圖檔資料夾
					$img_url = $this->mod_index->create_dir($member_id);
					$this->mod_index->update_set('member', 'member_id', $member_id, array('img_url'=>$img_url));

					//金鑰狀態更新
					$this->mod_index->update_set('keys', 'key_value', $this->input->post('key_value'), array('key_use'=>1, 'member_id'=>$member_id, 'ip'=>$this->get_realip()));

					//設定ckeditor使用的資料夾路徑
					$this->start_session(3600);
					$_SESSION['member_id'] 	  = $member_id;
					$_SESSION['IsAuthorized'] = true;
					$_SESSION['img_url'] 	  = $img_url.'ckfinder_image/';

					//建立QRcode and 空的QRcode內嵌圖片
					$this->mod_index->create_qrcode_style($member_id, 0);//iqr
					$this->mod_index->create_qrcode_style($member_id, 1);//mecard
					$this->mod_index->create_qrcode_style($member_id, 2);//iqr app

					//寄送註冊成功信
					$domain_data=$this->mod_index->select_from('domain', array('domain_id'=>$data['domain_id']));
					//主旨
					$subject=$data['host']['company'].' '.$language['ActionBusinessLetter'];
					//內容
					$message=''.
						"<p>".$language['_RegistrationSuccess']."</p>".
						"<p>".$language['AccountIs']."：".$this->input->post('account')."</p>".
						"<p>".$language['PasswordIs']."：".$this->input->post('password')."</p>".
						"<p>{unwrap}<a href='http://".$domain_data['domain']."/index/login'>".$language['LogInTo']."</a>{/unwrap}</p>".
						"<hr>".
						"<p>".$language['DoNotDirectlyReply']."</p>";
					//寄信
					$this->mod_index->send_mail($data['host']['domain'], $data['web_config']['title'], $this->input->post('email'), $subject, $message);
					$this->mod_index->send_mail($data['host']['domain'], $data['web_config']['title'], 'alice@netnews.com.tw', $subject.'(傳銷版)', $message);

					if(!empty($domain_data['sys_mail']))
					{
						$mail_array = $this -> mod_index ->  mail_setter($domain_data['sys_mail']);
						foreach ($mail_array as $key => $value)
						{
							$this->mod_index->send_mail($data['host']['domain'], $data['web_config']['title'], $value, $subject. '(傳銷版)', $message);
						}
					}

					//自動登入
					if($this->input->post('key_value') != -1)
					{
						$this->session->set_userdata('member_id', $member_id);
						$this->session->set_userdata('domain_id', $data['domain_id']);
						$this->session->set_userdata('auth', '0'.$data['web_config']['auth_level_num']);
						$this->myredirect('/business/edit', $language['RegistrationSuccess'], 5);
					}
					else
					{//後台開帳號
						$this->myredirect('/admin/member_management', $RegistrationSuccess, 5);
					}
					return 0;
				}
			}
			else
			{
				header('Location:'.base_url().'index/login');
			}
		}
		else
		{
			header('Location:'.base_url().'index/login');
		}
	}

	// 帳號重複驗證
	public function revartify()
	{
		$data = $this -> data;
		if($this->input->post('u'))
		{
			$member=$this->mod_index->select_from('member', array('account'=>$this->input->post('u')));
			if(empty($member))
			{
				$result['mbr_account_error']  = true;
				$result['mbr_account_result'] = '';
			}
			else
			{
				$result['mbr_account_error']  = false;
				$result['mbr_account_result'] = $data['AccountRepeatedEmail'];
			}
		}
		else
		{
			$result['mbr_account_error']  = false;
			$result['mbr_account_result'] = $data['NotIllegalOperations'];
		}
		//結果回傳
 		$ajax_data = json_encode($result);
		echo $ajax_data;
	}

	/**
	 * admin console login execute
	 *
	 * @return void
	 */
	public function login()
	{
		//data
		$data=$this->data;
		$lang = $this -> mod_language -> converter('15', $this -> session -> userdata('lang'));
		$data = array_merge($data, $lang);
		//檢查是否記住我
		$this->start_session(3600);
		if($_SESSION['member_id'] != '' && $_SESSION['member_id'] != 0)
		{
			$this->session->set_userdata('member_id', $_SESSION['member_id']);
			$this->session->set_userdata('auth', $_SESSION['auth']);
			$this->session->set_userdata('domain_id', $_SESSION['domain_id']);
			if($this->session->userdata('auth') == '00' && $data['domain_id'] == 0)
				// header('Location: '.base_url().'admin/panel');
				$this->useful->AlertPage('/index/logout');
			else
				// header('Location: '.base_url().'business/edit');
				$this->useful->AlertPage('/index/logout');
		}
		else
		{

			if(!$this->input->post('account'))
			{
				//驗證碼設定
				$len=5;
				$num=$this->random_vcode($len);
				$this->session->unset_userdata('VCODE');
				for($i = 0; $i < $len; $i++)
				{
					$this->session->set_userdata('VCODE', $this->session->userdata('VCODE').$num[$i]);
				}
				$s_vcode=$this->my_encrypt_encode($this->session->userdata('VCODE'));
				$vode_link=base_url().'index/vcode/'.$len.'/?s='.$s_vcode;
				$data['img']='<img id="vcode_img" src="'.$vode_link.'">';
				$data['hiddenvcode']=$s_vcode;

				//base_url
				$data['base_url']=base_url();

				//register code
				$data['register_code']=$this->encrypt->decode($data['web_config']['register_code']);
				//view
				$this->load->view('login', $data);
			}
			else
			{
				$this -> load -> library('session');

				//check
				$this -> chk_login_error();
				$account  = $this->input->post('account');	//帳號
				$password = $this->input->post('password');	//未加密密碼
				try {
					$data['host']['domain_id'] = 0;
					$this->mod_index->login_check_v1($account, $password, $data['host']['domain_id']);
				} catch (Exception  $e) {
					if($e -> getCode() > 0)
					{
						// print_r($e->getCode());break;
						@session_start();
						$this->session->unset_userdata('login_error');
						$this->session->unset_userdata('wip');
						//member
						$m=$this->mod_index->select_from('member', array('account'=>$account));

						//國鼎
						if($m['d_is_open']=='N' and $m['auth'] == '00'){
							$this -> script_message('此帳號停權中', '/index/login');
							return '';
						}

						//檢查使用時間, 使用期滿，無法登入, 名片頁無法使用
						$now_time=time();
						$time_out=false;
						if($m['auth'] != '00')
						{
							if($data['web_config']['g_deadline_status'] == 0)//設定個別期限
							{
								if($now_time > $m['deadline'])
									$time_out=true;
							}
							else if($data['web_config']['g_deadline_status'] == 1 && $data['web_config']['global_deadline'] != '')//設定全局期限
							{
								if($now_time > $data['web_config']['global_deadline'])
									$time_out=true;
								echo '1';
							}
							if($time_out)
							{
								$this->session->unset_userdata('member_id');
								$this->session->unset_userdata('domain_id');
								$this -> script_message($data['AccountDeadline'], '/index/login');
								// $this->myredirect('/index/login', '您的帳戶使用期限已到期，請聯絡您的網站管理員', 5);
								return 0;
							}
						}

						//img_url修正
						if($m['img_url'] == '0')
						{
							$member_dir=$this->get_member_dir($m['member_id']);

							//修正會員狀態
							$member_update=$this->mod_index->update_set('member', 'member_id', $m['member_id'], array('img_url'=>$member_dir));
						}

						//ckfinder
						$_SESSION['IsAuthorized']=true;
						$_SESSION['img_url']=$m['img_url'].'ckfinder_image/';

						//登入成功
						if($this->input->post('remember_me'))//勾選記住我
						{
							$_SESSION['member_id']=$m['member_id'];
							$_SESSION['auth']=$m['auth'];
							$_SESSION['domain_id']=$data['domain_id'];
						}

						//session
						$this->session->set_userdata('auth', $m['auth']);
						$d_action=$this->mod_index->select_from('jurisdicer', array('d_id'=>$m['d_action']));
						$_SESSION['AT']['action_list']=$d_action['d_action_list'];
						$_SESSION['AT']['account_name']=$m['account'];
						$_SESSION['AT']['account_id']=$m['member_id'];

						if($m['auth'] == '00' && $data['host']['domain_id'] == 0)
							$this->myredirect('/admin/panel', $data['SuperAdminLogin'], 5);
						else
							$this->myredirect('/business/edit', $data['LoginSuccessful'], 5);
						return 0;
					}
					else
					{
						//ck finder 資料夾關閉
						$_SESSION['IsAuthorized']=false;

						//記錄登入失敗次數
						if(!$this->session->userdata('login_error'))
							$this->session->set_userdata('login_error', 1);
						else
						{
							$this->session->set_userdata('login_error', $this->session->userdata('login_error')+1);

							//紀錄ip
							if($this->session->userdata('login_error') == 5)
							{
								$info=array(
									'ip'=>$this->get_realip(),
									'time'=>$this->session->userdata('login_error'),
									'date'=>time(),
									'account'=>$account
								);
								$login_error_log_data=$this->mod_index->select_from('login_error_log', array('ip'=>$this->get_realip()));
								if(empty($login_error_log_data))
								{
									$this->session->set_userdata('wip', $this->get_realip());
									$this->mod_index->insert_into('login_error_log', $info);
								}
							}
						}
						$this -> script_message($e -> getMessage(), '/index/login');
					}
				}
			}
		}
	}

	private function chk_login_error()
	{
		//檢查
		$chk_try_login_error=$this->mod_index->select_from('login_error_log', array('ip'=>$this->get_realip()));
		if(!empty($chk_try_login_error))
		{
			//確認重試時間
			if(time() > ($chk_try_login_error['date']+600))//time()+600s
			{
				$this->session->unset_userdata('login_error');
				//delete
				$this->mod_index->delete_where('login_error_log', array('ip'=>$this->session->userdata('wip')));
				$this->session->unset_userdata('wip');
			}
		}
	}

	// ajax 語系切換
	public function lang()
	{
		$lang = $this -> input -> post('lang');
		switch ($lang) {
			case 'zh-tw':
				$this -> session -> set_userdata('lang', 'TW');
				break;
			case 'zh-cn':
				$this -> session -> set_userdata('lang', 'zh-cn');
				break;
			case 'english':
				$this -> session -> set_userdata('lang', 'ENG');
				break;
			case 'japanese':
				$this -> session -> set_userdata('lang', 'JAP');
				break;
			case 'indonesia':
				$this->session->set_userdata('lang', 'IND');
				break;
		}
		echo $lang . ' selected';
	}

	//登出
	public function logout()
	{
		$data=$this->data;
		$language = $this -> language;
		if($this->session->userdata('member_id') > 0)
		{
			$this->session->sess_destroy();
	        @session_start();
			@session_destroy();
			$this->myredirect('/index/login', $language['LogoutSuccessful'], 5);
			return 0;
		}
		else
		{
			$this->myredirect('/index/login', $language['NotLoggedIn'], 5);
			return 0;
		}
	}

	//忘記密碼
	public function request()
	{
		//data
		$data=$this->data;
		$lang = $this -> mod_language -> converter('16', $this -> session -> userdata('lang'));
		$data = array_merge($data, $lang);

		if(!$this->input->post('account'))
		{
			//驗證碼設定
			$len=5;
			$num=$this->random_vcode($len);
			$this->session->unset_userdata('VCODE');
			for($i = 0; $i < $len; $i++)
			{
				$this->session->set_userdata('VCODE', $this->session->userdata('VCODE').$num[$i]);
			}
			$s_vcode=$this->my_encrypt_encode($this->session->userdata('VCODE'));
			$vode_link=base_url().'index/vcode/'.$len.'/?s='.$s_vcode;
			$data['img']='<img id="vcode_img" src="'.$vode_link.'">';
			$data['hiddenvcode']=$s_vcode;

			//base_url
			$data['base_url']=base_url();

			//view
			$this->load->view('request', $data);
		}
		else
		{
			//member
			$m=$this->mod_index->select_from('member', array('account'=>$this->input->post('account'), 'email'=>$this->input->post('email')));

			if(!empty($m))
			{
				//library
				$this->load->library('encrypt');

				//寄送密碼信
				//主旨
				$subject=$data['host']['company'].' '.$data['ActionBusinessLetter'];

				//內容
				$message=''.
					"<p>".$data['MemberHello']."</p>".
					"<p>".$data['YouInTime']."".date('Y-m-d H:i:s', time()).$data['ForgottenPassword']."</p>".
					"<p>".$data['AccountIs']."：".$this->input->post('account')."</p>".
					"<p>".$data['PasswordIs']."：".$this->encrypt->decode($m['password'])."</p>".
					"<p>{unwrap}<a href='http://".$data['host']['domain']."/'>".$data['LogInTo']."</a>{/unwrap}</p>".
					"<hr>".
					"<p>".$data['DoNotDirectlyReply']."</p>";
				//寄信
				$this->mod_index->send_mail($data['host']['domain'], $data['web_config']['title'], $this->input->post('email'), $subject, $message);

				$this->myredirect('/index/login', $data['PasswordSentToMailbox'], 5);
				return 0;
			}
			else
			{
				$this->myredirect('/index/request', $data['InformationErrorRescan'], 5);
				return 0;
			}
		}
	}

	//驗證碼使用的隨機數字
	public function vcode($len)
	{
		if($this->input->get('s'))
		{
			$num=$this->encrypt->decode($this->input->get('s'));
			for($i = 0; $i < $len; $i++)
			{
				$array_num[$i] = substr ($num, $i, 1);
			}
			$this->make_vcode_img($array_num, $len);
		}
	}

	//驗證碼解密
	public function s_decode()
	{
		if($this->input->post('vcode') && $this->input->post('hide_vcode'))
		{
			if(strnatcmp($this->input->post('vcode'), $this->encrypt->decode($this->input->post('hide_vcode'))) == 0)
			{
				echo '1';
			}
			else
			{
				echo '0';
			}
		}
	}

	function get_member_dir($mid)
	{
		//full relative path
		$path='/uploads/';

		$user=str_pad($mid, 10, '0', STR_PAD_LEFT);
		$one=substr($user, 7, 3);
		$two=substr($user, 0, 3);
		$three=substr($user, 3, 4);
		$dir='.'.$path.$one.'/'.$two.'/'.$three.'/'.$user;

		$temp = explode('/', $dir);
		$cur_dir = '';
		for($i = 0; $i < count($temp); $i++)
		{
			$cur_dir .= $temp[$i].'/';
		}
		return substr($cur_dir, 1, (strlen($cur_dir) - 1));
	}

	//session
	function start_session($expire = 0)
	{
	    if ($expire == 0) {
	        $expire = ini_get('session.gc_maxlifetime');
	    } else {
	        ini_set('session.gc_maxlifetime', $expire);
	     }

	    if (empty($_COOKIE['PHPSESSID'])) {
	        session_set_cookie_params($expire);
	        session_start();
	    } else {
	        session_start();
	        setcookie('PHPSESSID', session_id(), time() + $expire);
	     }
	}

	//產生無+號的加密碼
	function my_encrypt_encode($vcode)
	{
		do
		{
			$str=$this->encrypt->encode($vcode);
		}
		while(strpos($str, '+') !== false);
		return $str;
	}
}
