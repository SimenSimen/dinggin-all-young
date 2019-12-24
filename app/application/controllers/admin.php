<?php
//超管介面
class Admin extends MY_Controller
{
	public $data='';

	public function __construct()//初始化
	{
		parent::__construct();

		if(!$this -> session -> userdata('lang'))
		{
			$this -> session -> set_userdata('lang', 'TW');
			$this -> data['lang'] = $this -> session -> userdata('lang');
		}
		else
			$this -> data['lang'] = $this -> session -> userdata('lang');
		//model
		$this->load->model('admin_model', 'mod_admin');

		//helper
		$this->load->helper('url');

		//domain
		if($this->session->userdata('session_domain') != '')
		{
			$this->data['session_domain']=$this->session->userdata('session_domain');
		}
		else
		{
			$this->data['session_domain']=$this->session->set_userdata('session_domain', 1);
			$this->session->set_userdata('session_domain', 1);
		}
		$domain=$this->mod_admin->select_from('domain', array('domain_id'=>$this->data['session_domain']));
		$this->session->set_userdata('session_domain_name', $domain['domain']);
		$this->data['session_domain_name']=$this->session->userdata('session_domain_name');
		 
		 //權限撈取
		$this->load->library('/mylib/useful');
		@session_start();

		$this->setlang=(!empty($_SESSION['lang']))?$_SESSION['lang']:'TW';
		
		$this -> data['menu_title'] = $this -> useful -> set_jur();
		//web config
		$this->data['web_config']=$this->get_web_config($this->session->userdata('session_domain'));
		//style config
		$this->data['style_config']=$this->get_style_config($this->session->userdata('session_domain'));

		@session_start();
        $_SESSION['lang']=(!empty($_SESSION['lang']))?$_SESSION['lang']:'TW';
	}

	// 框架頁
	// menu 左側
	// main 右側
	public function index()
	{

		if($this->session->userdata('auth') != '00')
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
		else
		{
			//data
			$data=$this->data;
			$this->load->view('admin/manager_panel', $data);
		}
	}

	// 框架頁
	// menu 左側
	// main 右側
	public function panel()
	{

		if($this->session->userdata('auth') != '00')
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
		else
		{
			//data
			$data=$this->data;
			$this->load->view('admin/manager_panel', $data);
		}
	}

	//菜單欄
	public function menu()
	{
		if($this->session->userdata('auth') != '00')
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
		else
		{
			//data
			$data=$this->data;

			//domain
			$data['domain']=$this->mod_admin->select_from_order('domain', 'domain', 'asc');

			//domain checked
			$data['domain_selected'][$data['session_domain']]='selected';

			$this->load->view('admin/menu', $data);
		}
	}

	//內容欄
	public function main()
	{
		if($this->session->userdata('auth') != '00')
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
		else
		{
			// data
			$data=$this->data;
			$this->load->model('/MyModel/mymodel');
			$data['dbdata']=$this->mymodel->OneSearchSql('config','d_val',array('d_type'=>'adminmain'));
			$this->load->view('admin/main', $data);
		}
	}

	//網域列表
	public function domain_management($function_name='')
	{
		if($this->session->userdata('auth') != '00')
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
		else
		{
			//data
			$data=$this->data;

			if(!$this->input->post('domain_add'))
			{
				//domain
				$domain=$this->mod_admin->select_from_order('domain', 'domain', 'asc');
				foreach($domain as $key => $value)
				{
					$control_setting = $this -> mod_admin -> select_from('control_setting', array('domain_id' => $value['domain_id']));
					$value['status'] = $control_setting['cart_status'];
					$index=substr($value['domain'], 0, 1);
					$data['domain'][$index][]=$value;
				}

				//domain checked
				$data['domain_radio_checked'][$data['session_domain']]='checked';
				$data['domain_radio_tr'][$data['session_domain']]='warning';

				//view
				$this->load->view('admin/domain_list', $data);
			}
			else
			{
				if($this->input->post('domain_name') != '')
				{
					$domain_name=$this->input->post('domain_name');

					if(($pos = strpos($domain_name, 'http://')) !== false)
					{//檢查是否有http
						echo '<script>alert("不可包含http://");</script>';
					}
					else
					{
						//檢查domain是否重複
						$check_empty=$this->mod_admin->select_from('domain', array('domain'=>$domain_name));
						if(empty($check_empty))
						{
							//now time
							$now_time=time();

							//寫入domain
							$domain_data=array(
								'domain' 	=> $domain_name,
								'company' 	=> $this->input->post('company_name'),
								'add_time' 	=> $now_time,
							);
							$domain_id=$this->mod_admin->insert_into('domain', $domain_data);

							//複製系統設定
							$control_setting_data=array(
								'domain_id'			=> $domain_id, 
								'logo'				=> '/images/logo.gif',
								'title'				=> '行動商務系統', 
								'register_code'		=> $this->make_register_code(1), 
								'auth_level_num'	=> 2, 
								'video_num'			=> '99', 
								'website_num'		=> '99', 
								'address_num'		=> '99', 
								'titlename_num'		=> '99', 
								'iqr_link_type'		=> 1, 
								'global_deadline'	=> '', //($now_time+31536000)
								'g_deadline_status'	=> 0, 
								'quoted_default'	=> 1, 
								'free_link_name'	=> '', 
								'g_free_link_status'=> 1,
								'cart_status'		=> 0,
								'prd_class_num'		=> 8,
								'register_status'	=> 1,
								'group_push'		=> 0,
								'web_banner'		=> 1,
								'web_banner_color'	=> '#000000',
								'web_footer_text'	=> '行動商務系統, 版權所有 © '.date('Y', time()).' 保留所有權利',
								'iqr_footer_text'	=> '行動商務系統 ©'
							);
							$setting_id=$this->mod_admin->insert_into('control_setting', $control_setting_data);

							//複製系統風格資料夾
							$this->mod_admin->make_domain_img_dir($domain_name);
							$this->mod_admin->make_domain_img_dir($domain_name, 'app_welcome_page/');
						}
						else
						{
							echo '<script>alert("此domain重複");</script>';
						}
					}
					echo '<script>window.location.href="/admin/domain_management"</script>';
				}
			}
		}
	}

	//切換操作網域
	public function domain_switch($session_domain='')
	{
		if($this->session->userdata('auth') != '00')
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
		else
		{
			if($session_domain != '')
			{
				$this->session->set_userdata('session_domain', $session_domain);
				$domain=$this->mod_admin->select_from('domain', array('domain_id'=>$this->session->userdata('session_domain')));

				echo '<script>';
				// echo 'alert("切換成功，您目前網域：'.$domain['domain'].'");';
				echo 'top.frames["menu-frame"].location="/admin/menu";';
				echo 'top.frames["content-frame"].location="/admin/domain_management";';
				echo '</script>';
			}
		}
	}

	//網域編輯
	public function domain_edit()
	{
		if($_SESSION['AT']['account_name']=='super')
		{
			//data
			$data=$this->data;
			
			if(!$this->input->post('domain_id'))
			{
				//domain
				$data['domain']=$domain=$this->mod_admin->select_from_order('domain', 'domain', 'asc');

				$this->load->view('admin/domain_edit', $data);
			}
			else
			{
				$domain_id  = $this->input->post('domain_id');
				$domain  	= $this->input->post('domain');
				$company 	= $this->input->post('company');
				$note 	 	= $this->input->post('note');
				foreach($domain_id as $key => $value)
				{
					$update=array(
						'domain'	=> $domain[$key],
						'company'	=> $company[$key],
						'note'		=> $note[$key]
					);
					$this->mod_admin->update_set('domain', 'domain_id', $value, $update);
				}
				redirect('/admin/domain_edit');
			}
		}
		else
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
	}

	//網域刪除
	public function domain_delete()
	{
		if($this->session->userdata('auth') != '00')
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
		else
		{
			//data
			$data=$this->data;

			if(!$this->input->post('domain_del'))
			{
				//data
				$data=$this->data;

				//domain
				$data['domain']=$this->mod_admin->select_from_order('domain', 'domain', 'asc');

				//view
				$this->load->view('admin/domain_delete', $data);
			}
			else
			{
				//post data
				$domain_del=$this->input->post('domain_del');
				foreach($domain_del as $key => $value)
				{
					$this->mod_admin->delete_where('domain', array('domain_id'=>$value));
				}
				redirect('/admin/domain_management');
			}
		}
	}

	//帳戶管理
	public function member_management()
	{
		if($this->session->userdata('auth') != '00')
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
		else
		{
			//data
			$data=$this->data;

			//base_url
			$data['base_url']=base_url();
		
			//library
			$this->load->library('encrypt');

			//member data
			$member=$this->mod_admin->select_from_order('member', 'member_id', 'DESC', array('domain_id'=>$data['session_domain']));
			foreach($member as $key => &$value)
			{				
				// name
				$iqr = $this->mod_admin->select_from('iqr', array('member_id'=>$value['member_id']));
				$value['member_name']=$data['member_name'][$key] = $iqr['l_name'].$iqr['f_name'];

				if($value['auth'] != '00')
				{
					//列出會員
					$data['member'][$key]=$value;

					//密碼加密
					$data['member_password'][$key]=$this->encrypt->decode($value['password']);

					//以 auth 分欄位顏色
					if($value['auth'] == '01')
						$data['member_auth_color'][$key]='#d9edf7';
					else if($value['auth'] == '02')
						$data['member_auth_color'][$key]='#FFFFFF';
					else if($value['auth'] == '03')
						$data['member_auth_color'][$key]='';
				}
				if($value['client_key'] && $value['gcm_key'])
					$data['android_key'][$key] = true;
				if($value['pem'] && $value['mobileprovision'])
				{
					$data['ios_key'][$key] = true;
					$data['ios_deadline'][$key] = $this -> get_deadtime($value['ios_createTime'], "+365 day");
				}
			}
			
			//權限等級
			$c_str=array(2=>'二', 3=>'三', 4=>'四');
			for($i = 2; $i <= $data['web_config']['auth_level_num']; $i++)
			{
				$data['auth_level'][$i]['value']=$i;
				$data['auth_level'][$i]['name']='第'.$c_str[$i].'層級';
			}

			//註冊入口
			$data['register_code']=$this->encrypt->decode($data['web_config']['register_code']);

			//new commer need domain id
			$data['session_domain']=$this->session->userdata('session_domain');
			
			foreach($data['member'] as $key =>  $value){// 有在db.iqr才出現
				if($value['member_name']==''){					
					unset($data['member'][$key]);
				}//end if
			}//end foreach

			if(count($data['member'])==1){//只有一筆,直接轉到詳細頁
				echo $data['member']['0']['account'];			
				foreach($data['member'] as $value){// 
					redirect("/admin/member_setting/".$value['account']);
				}
			}

			//view
			$this->load->view('admin/member_list', $data);
		}
	}

	//會員刪除
	public function member_delete()
	{
		if($this->session->userdata('auth') != '00')
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
		else
		{
			//data
			$data=$this->data;

			if(!$this->input->post('member_del'))
			{
				//member data
				$member=$this->mod_admin->select_from_order('member', 'auth', 'asc', array('domain_id'=>$data['session_domain']));
				foreach($member as $key => $value)
				{
					if($value['auth'] != '00')
					{
						//列出會員
						$data['member'][$key]=$value;

						//以 auth 分欄位顏色
						if($value['auth'] == '01')
							$data['member_auth_color'][$key]='#d9edf7';
						else if($value['auth'] == '02')
							$data['member_auth_color'][$key]='#FFFFFF';
						else if($value['auth'] == '03')
							$data['member_auth_color'][$key]='';
					}
				}
				
				//view
				$this->load->view('admin/member_delete', $data);
			}
			else
			{
				//post data
				$member_del=$this->input->post('member_del');
				foreach($member_del as $key => $value)
				{
					$this->mod_admin->unset_member($value);
				}
				redirect('/admin/member_management');
			}
		}
	}

	// 會員設定
	public function member_setting($account = '', $action = '')
	{
		if($this->session->userdata('auth') != '00')
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
		else
		{
			//data
			$data = $this -> data;

			$data['member'] = $member = $this -> mod_admin -> select_from('member', array('account' => $account));
			$data['packname']=$this->allpackagename($member['member_id'],$member['account'],$member['sys_push']);

			// 判斷 ios(zip)
			$data['zipBtn'] = (file_exists(substr($member['img_url'], 1) . 'app/' . $member['account'] . '.zip')) ? true : false;
			if($member['sys_push']=="1"){
				$data['selected1']="checked";
				$data['selected2']="";
			}else if($member['sys_push']=="2"){
				$data['selected1']="";
				$data['selected2']="checked";
			}else{
				$data['selected1']="";
				$data['selected2']="";
			}
			// pem, mobileprovision 名稱切割處理
			if(!empty($member['pem']))
			{
				$str = explode($member['img_url'].'app/', $member['pem']);
				$data['pem_name'] = $str["1"];
			}
			if(!empty($member['mobileprovision']))
			{
				$str = explode($member['img_url'].'app/', $member['mobileprovision']);
				$data['mobileprovision_name'] = $str["1"];
			}

			// input
			$date = $this -> input -> post('add_date');
			$apk_server_key = $this -> input -> post('apk_server_key');
			$apk_client_key = $this -> input -> post('apk_client_key');
			$apikey 		= $this -> input -> post('apikey');
			$secretkey 		= $this -> input -> post('secretkey');
			$sys_push 		= $this -> input -> post('sys_push');

			$ios_pem = $_FILES['ios_pem'];
			$ios_mobileprovision = $_FILES['ios_mobileprovision'];
			$writen_sname_pem = $member['sname_pem'];
			$writen_sname_mobileprovision = $member['sname_mobileprovision'];
			
			// ios 憑證到期日
			if(!empty($member['ios_createTime']))
			{
				$data['ios_deadline'] = $this -> get_deadtime($member['ios_createTime'], "+365 day");
			}

			if(!$date && !$apk_server_key && !$apk_client_key && empty($ios_pem_key['error'])  && empty($ios_mobileprovision['error']) && $action == 0)
			{
				$data['suc'] = 0;
			}
			else
			{
				$data['suc'] = 1;
				$date = ((int) $date);
				$timer = time();
				// Pem, mobileprovision 上傳至 app 資料夾
				$path = $member['img_url'] . "app/";
				if (!file_exists('.'.$path)) {
					@mkdir('.'.$path, 0777);
				}
				$this -> load -> model('upload_model', 'mod_upload');
				// Pem 上傳
				if($ios_pem["error"] != 4)
				{
					$_pem = $this -> mod_upload -> upload_ios_element($ios_pem, '.'.$path, 'pem', $member['account']);
					if($_pem['error'] == "檔案類型錯誤")
					{
						$this -> script_message('iOS Pem 檔案類型錯誤, 將不寫入此次新增資料', '/admin/member_setting/' .$account);
						$writen_pem = ($this -> input -> post('pem_name')) ? $path . $this -> input -> post('pem_name') : "";
					}
					else
					{
						$ios_create_time = date('Y-m-d', $timer);
						$writen_pem = substr($_pem['path'], 1);
					}
				}
				else
				{
					if(!empty($member['pem']))
						$writen_pem = $member['pem'];
				}
				// mobileprovision 上傳
				if($ios_mobileprovision["error"] != 4)
				{
					$_mobileprovision = $this -> mod_upload -> upload_ios_element($ios_mobileprovision, '.'.$path, 'mobileprovision', $member['account']);
					if($_mobileprovision['error'] == "檔案類型錯誤")
					{
						$this -> script_message('iOS UniversalDistribution 檔案類型錯誤, 將不寫入此次新增資料', '/admin/member_setting/' .$account);
						$writen_mobileprovision = ($this -> input -> post('mobileprovision_name')) ? $path . $this -> input -> post('mobileprovision_name') : "";
					}
					else
					{
						$ios_create_time = date('Y-m-d', $timer);
						$writen_mobileprovision = substr($_mobileprovision['path'], 1);
					}
				}
				else
				{
					if(!empty($member['mobileprovision']))
						$writen_mobileprovision = $member['mobileprovision'];

				}

				// 修改期限, 推播 key 寫入
				$add_date = $date * 86400;
				$new_date = $member['deadline'] + $add_date;
				$update_data = array(
						'push'					=> $this -> input -> post('push'),
//						'ShowExitMessage'	=> $this -> input -> post('ShowExitMessage'),
						'deadline'				=> $new_date,
						'gcm_key'				=> $apk_server_key,
						'client_key'			=> $apk_client_key,
						'apikey'				=> $apikey,
						'secretkey'				=> $secretkey,
						'sys_push'				=> $sys_push,
						'app_id'				=> (string)$this -> input -> post('app_id'),
						'pem'					=> $writen_pem,
						'mobileprovision'		=> $writen_mobileprovision,
						'sname_pem'				=> $writen_sname_pem,
						'sname_mobileprovision'	=> $writen_sname_mobileprovision,
						'ios_createTime'		=> (!empty($ios_create_time)) ? $ios_create_time : $member['ios_createTime'],
				);
			
				$this -> mod_admin -> update_where_array_set('member', array('member_id' => $member["member_id"]), $update_data);

				$this -> script_message('修改成功', '/admin/member_management', 'top');
			}
			
			$this -> load -> view('admin/member_setting', $data);
		}
	}

	//網站管理員更新
	public function webmin_update()
	{
		if($this->session->userdata('auth') != '00')
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
		else
		{
			// data
			$data = $this->data;

			// defined share iqr_colunm
			$share_iqr_colunm = array(
				'cpn_phone',	// 電話
				'cpn_number',	// 統編
				'email',		// 信箱
				'skype',		// skype
				'facebook',		// facebook
				'line'			// line
			);
			$share_iqr_colunm_id = array(
				'photo',		// id:相簿1：形象圖
				'cpn_photo',	// id:相簿2：企業形象
				'ytb_link',		// id:youtube 影片網址
				'website',		// id:網站網址
				'address',		// id:自訂地址
				'exfile',		// id:附件
				'uform',		// id:自訂表單
				'ecoupon',		// id:好友分享券
				'iqr_html'		// id:自訂表單
			);
			$share_cart_colunm = 'prd_id'; // id:商品

			// post data : member_id
			$update_webmin_id = $this->input->post('update_webmin');

			// update_type : auth
			if($this->input->post('update_type') == 0)
			{
				// 設為網管 : 新增共享資訊
				foreach($update_webmin_id as $key => $value) // value is member_id 
				{
					// Step 1. auth 變更
					$this->mod_admin->update_set('member', 'member_id', $value, array('auth'=>'01'));

					// iqr
					$iqr = $this->mod_admin->select_from('iqr', array('member_id' => $value));

					// Step 2. 刪除
					$this->mod_admin->delete_where('share_data', array('member_id' => $value));
                    $this->mod_admin->delete_where('quote_data', array('parent'    => $value));

					// Step 3. 寫入 colunm_name
					foreach($share_iqr_colunm as $c_key => $c_value)
					{
						$this->mod_admin->insert_into('share_data', array('member_id' => $value, 'iqr_column' => $c_value, 'status' => 0));
					}

					// Step 4. 寫入 colunm_name and id
					foreach($share_iqr_colunm_id as $c_key => $c_value)
					{
						$id_array = $this->get_serialstr($iqr[$c_value], '*#');

						foreach($id_array as $id_key => $id_value)
						{
							$this->mod_admin->insert_into('share_data', array('member_id' => $value, 'iqr_column' => $c_value, 'id' => $id_value, 'status' => 0));
						}
					}
				}
			}
			else
			{
				$lowest_auth = $data['web_config']['auth_level_num']; 		// 系統最低層級
				$set_auth    = intval($this->input->post('update_type')); 	// 設定層級

				// 最底層級
				if($lowest_auth == $set_auth)
				{
					// 刪除共享資料
					foreach($update_webmin_id as $key => $value) // value is member_id 
					{
						// Step 1. auth 變更
						$this->mod_admin->update_set('member', 'member_id', $value, array('auth'=>$this->input->post('update_type')));

						// Step 2. 刪除
						$this->mod_admin->delete_where('share_data', array('member_id' => $value));
                        $this->mod_admin->delete_where('quote_data', array('parent'    => $value));
					}
				}
				else // 其他層級，但不是管理者層級 - 同時有共享與引用功能
				{
					// 設為其他層級(非最底層) : 新增共享資訊
					foreach($update_webmin_id as $key => $value) // value is member_id 
					{
						// Step 1. auth 變更
						$this->mod_admin->update_set('member', 'member_id', $value, array('auth'=>$this->input->post('update_type')));
						
						// Step 2. 刪除
						$this->mod_admin->delete_where('share_data', array('member_id' => $value));
                        $this->mod_admin->delete_where('quote_data', array('parent'    => $value));

						// iqr
						$iqr = $this->mod_admin->select_from('iqr', array('member_id' => $value));

						// Step 3. 寫入 colunm_name
						foreach($share_iqr_colunm as $c_key => $c_value)
						{
							$this->mod_admin->insert_into('share_data', array('member_id' => $value, 'iqr_column' => $c_value, 'status' => 0));
						}

						// Step 4. 寫入 colunm_name and id
						foreach($share_iqr_colunm_id as $c_key => $c_value)
						{
							$id_array = $this->get_serialstr($iqr[$c_value], '*#');
							foreach($id_array as $id_key => $id_value)
							{
								$this->mod_admin->insert_into('share_data', array('member_id' => $value, 'iqr_column' => $c_value, 'id' => $id_value, 'status' => 0));
							}
						}
					}
				}
			}
			redirect('/admin/member_management');
		}
	}

	//會員登入窗口
		// public function iqr_edit($account, $auth)
		// {
		// 	if($this->session->userdata('auth') != '00')
		// 	{
		// 		echo '<script>top.window.location.href="/index/login"</script>';
		// 	}
		// 	else
		// 	{
		// 		$m=$this->mod_admin->select_from('member', array('account'=>$account));

		// 		//img_url修正
		// 		if($m['img_url'] == '0')
		// 		{
		// 			$member_dir=$this->get_member_dir($m['member_id']);

		// 			//修正會員狀態
		// 			$member_update=$this->mod_index->update_set('member', 'member_id', $m['member_id'], array('img_url'=>$member_dir));
		// 		}

		// 		$this->session->set_userdata('member_id', $m['member_id']);
		// 		$this->session->set_userdata('user_auth', $auth);
		// 		echo '<script type="text/javascript">window.open("'.base_url().'business/edit", "編輯會員資訊", config="height=630,width=1124,left=100,top=0,resizable=yes,scrollbar=yes")</script>';
		// 		echo '<script type="text/javascript">window.location.href="/admin/member_management"</script>';
		// 	}
		// }

	//金鑰管理
	public function key_management()
	{
		// kevin2pig's note:
		// 其實可以加入換頁功能

		if($this->session->userdata('auth') != '00')
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
		else
		{
			//data
			$data=$this->data;
		
			//keys data
			$data['keys']=$keys=$this->mod_admin->select_from_order('keys', 'key_id', 'asc');
			foreach($keys as $key => $value)
			{
				//使用狀態
				$data['key_use'][$key]=($value['key_use'] == 0) ? '未使用' : '○';

				//流水號
				$no=($key+1);
				$data['key_no'][$key]=($no < 10) ? '00'.$no : (($no < 100) ? '0'.$no : $no);

				//domain name
				$domain_data=$this->mod_admin->select_from('domain', array('domain_id'=>$value['domain_id']));
				if(!empty($domain_data))
				{
					$data['domain_name'][$key]=$domain_data['domain'];
					$data['domain_name_tr'][$key]='active';
				}
				else
				{
					$data['domain_name'][$key]='未分配';
					$data['domain_name_tr'][$key]='';
				}

				//開卡人
				if($value['member_id'] != '')
				{
					$m=$this->mod_admin->select_from('member', array('member_id'=>$value['member_id']));
					$data['member_account'][$key]=$m['account'];
					$iqr=$this->mod_admin->select_from('iqr', array('member_id'=>$value['member_id']));
					$data['member_name'][$key]=$iqr['l_name'].$iqr['f_name'];
				}
				else
				{
					$data['member_account'][$key]='';
				}
			}

			$this->load->view('admin/key_list', $data);
		}
	}

	//金鑰編輯
	public function key_edit()
	{
		if($this->session->userdata('auth') != '00')
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
		else
		{
			//data
			$data=$this->data;
			
			if(!$this->input->post('domain_id'))
			{
				//domain
				$data['domain']=$this->mod_admin->select_from_order('domain', 'domain', 'asc');

				//keys data
				$data['keys']=$keys=$this->mod_admin->select_from_order('keys', 'key_id', 'asc');
				foreach($keys as $key => $value)
				{
					//使用狀態
					$data['key_use_color'][$key]=($value['key_use'] == 1) ? '#FDFFE2' : '#fff';
					$data['key_use_status'][$key]=($value['key_use'] == 0) ? '未使用' : '已用';
					// $data['key_use_select'][$key][$value['key_use']]='selected';

					//流水號
					$no=($key+1);
					$data['key_no'][$key]=($no < 10) ? '00'.$no : (($no < 100) ? '0'.$no : $no);
					
					//domain name
					$domain_data=$this->mod_admin->select_from('domain', array('domain_id'=>$value['domain_id']));
					if(!empty($domain_data))
						$data['domain_name'][$key]=$domain_data['domain'];
					else
						$data['domain_name'][$key]='未分配';

					//開卡人
					if($value['member_id'] != '')
					{
						$m=$this->mod_admin->select_from('member', array('member_id'=>$value['member_id']));
						$data['member_account'][$key]=$m['account'];
						$iqr=$this->mod_admin->select_from('iqr', array('member_id'=>$value['member_id']));
						$data['member_name'][$key]=$iqr['l_name'].$iqr['f_name'];
					}
					else
					{
						$data['member_account'][$key]='';
					}
				}

				$this->load->view('admin/key_edit', $data);
			}
			else
			{
				// post data
				$check_domain=$this->input->post('check_domain');
				$domain_id=($this->input->post('domain_id') == 'unset') ? 0 : $this->input->post('domain_id');
				foreach($check_domain as $key => $value)
				{
					$updata_array=array(
						'domain_id'	=> $domain_id
					);
					$this->mod_admin->update_set('keys', 'key_id', $value, $updata_array);
				}
				redirect('/admin/key_management');
			}
		}
	}

	//金鑰刪除
	public function key_delete()
	{
		if($this->session->userdata('auth') != '00')
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
		else
		{
			//data
			$data=$this->data;

			if(!$this->input->post('key_del'))
			{
				//keys data
				$data['keys']=$keys=$this->mod_admin->select_from_order('keys', 'key_id', 'asc');
				foreach($keys as $key => $value)
				{
					//使用狀態
					$data['key_use'][$key]=($value['key_use'] == 0) ? '未使用' : '○';

					//流水號
					$no=($key+1);
					$data['key_no'][$key]=($no < 10) ? '00'.$no : (($no < 100) ? '0'.$no : $no);
					
					//domain name
					$domain_data=$this->mod_admin->select_from('domain', array('domain_id'=>$value['domain_id']));
					if(!empty($domain_data))
						$data['domain_name'][$key]=$domain_data['domain'];
					else
						$data['domain_name'][$key]='未分配';

					//開卡人
					if($value['member_id'] != '')
					{
						$m=$this->mod_admin->select_from('member', array('member_id'=>$value['member_id']));
						$data['member_account'][$key]=$m['account'];
					}
					else
					{
						$data['member_account'][$key]='';
					}
				}

				$this->load->view('admin/key_delete', $data);
			}
			else
			{
				//post data
				$key_del=$this->input->post('key_del');
				foreach($key_del as $key => $value)
				{
					$this->mod_admin->delete_where('keys', array('key_id'=>$value));
				}
				redirect('/admin/key_management');
			}
		}
	}

	//金鑰匯入
	public function key_import()
	{
		if($this->session->userdata('auth') != '00')
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
		else
		{
			if($_FILES['key_file'])
			{
				//上傳文件 : upload and get file path => $file['path']
				$file=$this->mod_admin->upload_doc($_FILES['key_file'], './uploads/key/');

				//解xls檔 : echo data
				$import_content=$this->import_xls($file['path']);
				
				//寫入資料庫
				foreach($import_content['cells'] as $key => $value)
				{
					if($key > 1)
					{
						$insert_data=array(
							'domain_id'		=> 0,
							'key_number'	=> $value[1],
							'key_value'		=> $value[2],
							'key_power'		=> '12',
							'key_use'		=> 0//,
							//'ip'			=> $this->get_realip()
						);
						$key_id=$this->mod_admin->insert_into('keys', $insert_data);
					}
				}

				if($key_id)
				{
					unlink($file['path']);
					redirect('/admin/key_management');
				}
			}
		}
	}

	// 上架設定
	public function qrcode_direct()
	{
		if($this->session->userdata('auth') != '00')
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
		else
		{
			//data
			$data=$this->data;
			$data['TD']   = array(
				'td_field'		=> '<td style="width: 10%;">編號</td>',
				'td_field00'	=> '<td style="width: 15%;">帳號</td>',
				'td_field01'	=> '<td style="width: 26%;">Android</td>',
				'td_field02'	=> '<td style="width: 26%;">iOS</td>',
				'td_field03'	=> '<td style="width: 10%;">上架申請</td>',
				'td_edit'		=> '<td style="width: 10%;">編輯</td>'
			);
 
			$domains = $this -> mod_admin -> select_from('domain', array('domain_id' => $data['session_domain']));
		 	$members = $this -> mod_admin -> select_from_order('member', 'member_id', 'asc', array('domain_id' => $domains['domain_id']));
			foreach ($members as $key => $value)
			{
			 	$iqr = $this -> mod_admin -> select_from('iqr', array('member_id' => $value['member_id']));
			 	if(!empty($members) && !empty($iqr))
			 	{
			 		$data['list'][$key]['no'] 		   = $key + 1;
			 		$data['list'][$key]['val_field00'] = $value['account'];
			 		$data['list'][$key]['field01_btn'] = true;
			 		$data['list'][$key]['val_field01'] = ($iqr['apk_release'] == '' || $iqr['apk_release'] == NULL) ? '' : $iqr['apk_release'];
			 		$data['list'][$key]['field02_btn'] = true;
			 		$data['list'][$key]['val_field02'] = ($iqr['ipa_release'] == '' || $iqr['ipa_release'] == NULL) ? '' : $iqr['ipa_release'];
			 		$data['list'][$key]['field03_btn'] = true;
			 		$data['list'][$key]['val_field03'] = ($value['instore'] == 0) ? '' : '已申請';
			 		$data['list'][$key]['gateway_url'] = '/admin/qrcode_edit/'.$value['member_id'].'/0';
			 	}
			}
			$this->load->view('admin/list', $data);
		}
	}
	// Qrcode 轉址編輯
	public function qrcode_edit($member_id='',$action = '')
	{
		$data = $this -> data;

		if($this->session->userdata('auth') != '00')
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
		else
		{
			$post_apk    = $this -> input -> post('apk_release');
			$post_ipa    = $this -> input -> post('ipa_release');
			$selection   = $this -> input -> post('select_status');

			if($action == 0)
				$data['suc']    = 0;

			else if($post_apk && $post_ipa && $action == 1 || ($post_apk == '' || $post_ipa) && $action == 1 || ($post_apk  || $post_ipa == '') && $action == 1)
			{
				$data['suc'] = 1;
				if($this -> input -> post('apk_release'))
					$apk_release = $post_apk;
				else
					$apk_release = NULL;
				if($this -> input -> post('ipa_release'))
					$ipa_release = $post_ipa;
				else
					$ipa_release = NULL;
				$update_data = array(
						'apk_release'	=> $apk_release,
						'ipa_release'	=> $ipa_release
				);
				$this -> mod_admin -> update_set('iqr', 'member_id', $member_id, $update_data);
				$this -> mod_admin -> update_set('member', 'member_id', $member_id, array('instore' => $selection));
			}
			else
			{
				echo '<script>
					  alert("錯誤連結");
					  window.close();
					  </script>'
					  ;
			}
			$data['member'] = $member = $this -> mod_admin -> select_from('member', array('member_id' => $member_id));
			$data['iqr']    = $iqr    = $this -> mod_admin -> select_from('iqr', array('member_id' => $member_id));
			// selection
			$data['instore'][] = '未申請';
			$data['instore'][] = '已申請';
			$data['instore_selected'][$member['instore']] = 'selected';
			
			$this -> load -> view('admin/qrcode_edit', $data);
		}
	}

	// Allpay 加值服務
	public function addon()
	{
		if($this->session->userdata('auth') != '00')
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
		else
		{
			//data
			$data = $this -> data;
			$iqrt_all = $this -> mod_admin -> select_from_order('iqr_trans', 'pway_id', 'asc', array('pway_id' => 5));
			if(!empty($iqrt_all))
			{
				$data['TD']   = array(
					'td_field'		=> '<td style="width: 10%;">編號</td>',
					'td_field00'	=> '<td style="width: 15%;">帳號</td>',
					'td_field01'	=> '<td style="width: 20%;">商店代號</td>',
					'td_field02'	=> '<td style="width: 22%;">HashKey</td>',
					'td_field03'	=> '<td style="width: 22%;">HashIV</td>',
					'td_edit'		=> '<td style="width: 10%;">編輯</td>'
				);

				$members = $this -> mod_admin -> select_from_order('member', 'member_id', 'asc', array('domain_id' => $data['session_domain']));
				foreach ($members as $key => $value)
				{
					$cart = $this -> mod_admin -> select_from('iqr_cart', array('member_id' => $value['member_id']));
					$iqrt = $this -> mod_admin -> select_from('iqr_trans', array('pway_id' => 5, 'cset_id' => $cart['cset_id']));
					if(!empty($iqrt) && !empty($cart))
					{
						$data['list'][$key]['no'] = $key + 1;
						$data['list'][$key]['val_field00'] = $value['account'];
						$data['list'][$key]['field01_btn'] = true;
						$data['list'][$key]['val_field01'] = $iqrt['business_account'];
						$data['list'][$key]['field02_btn'] = true;
						$data['list'][$key]['val_field02'] = $iqrt['business_hashkey'];
						$data['list'][$key]['field03_btn'] = true;
						$data['list'][$key]['val_field03'] = $iqrt['business_hashiv'];
						$data['list'][$key]['gateway_url'] = '/admin/allpay_edit/'.$value['member_id'].'/0';
					}
				}
				$this -> load -> view('admin/list', $data);
			}
			else
				echo '載入資料失敗 ...';
		}
	}
	// Allpay 金流編輯
	public function allpay_edit($member_id='',$action = '')
	{
		$data = $this -> data;

		if($this->session->userdata('auth') != '00')
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
		else
		{
			if($action == 0)
			{
				$data['suc'] = 0;
			}
			else if($this -> input -> post('business_account') && $this -> input -> post('business_hashkey') && $this -> input -> post('business_hashiv') || $action == 1)
			{
				$data['suc'] = 1;
				$store = $this -> mod_admin -> select_from('iqr_cart', array('member_id' => $member_id));
				$iqrt  = $this -> mod_admin -> select_from('iqr_trans', array('pway_id' => 5,'cset_id' => $store['cset_id']));

				$business_account = $this -> input -> post('business_account');
				$business_hashkey = $this -> input -> post('business_hashkey');
				$business_hashiv  = $this -> input -> post('business_hashiv');

				$update_data = array(
						'business_account'	=> $business_account,
						'business_hashkey'	=> $business_hashkey,
						'business_hashiv'	=> $business_hashiv
				);
				$this -> mod_admin -> update_where_array_set('iqr_trans', array('cset_id' => $iqrt['cset_id'], 'pway_id' => 5), $update_data);
			}
			else
			{
				echo '<script>
					  alert("錯誤連結");
					  window.close();
					  </script>'
					  ;

			}
			$data['member'] = $member = $this -> mod_admin -> select_from('member', array('member_id' => $member_id));
			$store  = $this -> mod_admin -> select_from('iqr_cart', array('member_id' => $member_id));
			$data['iqrt'] = $this -> mod_admin -> select_from('iqr_trans', array('pway_id' => 5,'cset_id' => $store['cset_id']));
			$this -> load -> view('admin/allpay_edit', $data);
		}
	}

	// Gomypay-線上刷卡 商店代號、驗證密碼設定
	public function addon_gomypay()
	{
		if($this->session->userdata('auth') != '00')
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
		else
		{
			//data
			$data = $this -> data;
			$iqrt_all = $this -> mod_admin -> select_from_order('iqr_trans', 'pway_id', 'asc', array('pway_id' => 6));
			if(!empty($iqrt_all))
			{
				$data['TD']   = array(
					'td_field'		=> '<td style="width: 10%;">編號</td>',
					'td_field00'	=> '<td style="width: 15%;">帳號</td>',
					'td_field01'	=> '<td style="width: 20%;">商店代號</td>',
					'td_field03'	=> '<td style="width: 30%;">交易驗證密碼</td>',
					'td_edit'		=> '<td style="width: 10%;">編輯</td>'
				);

				$members = $this -> mod_admin -> select_from_order('member', 'member_id', 'asc', array('domain_id' => $data['session_domain']));
				foreach ($members as $key => $value)
				{
					$cart = $this -> mod_admin -> select_from('iqr_cart', array('member_id' => $value['member_id']));
					$iqrt = $this -> mod_admin -> select_from('iqr_trans', array('pway_id' => 6, 'cset_id' => $cart['cset_id']));
					
					if(!empty($iqrt) && !empty($cart))
					{
						$data['list'][$key]['no'] = $key + 1;
						$data['list'][$key]['val_field00'] = $value['account'];

						$data['list'][$key]['field01_btn'] = true;
						$data['list'][$key]['val_field01'] = $iqrt['business_account'];
						
						$data['list'][$key]['field02_btn'] = true;
						$data['list'][$key]['val_field02'] = $iqrt['business_hashiv'];
						
						$data['list'][$key]['gateway_url'] = '/admin/gomypay_credit_edit/'.$value['member_id'].'/0';
					}
				}

				$this -> load -> view('admin/list', $data);
			}
			else
				echo '載入資料失敗 ...';
		}
	}
	// Gomypay-線上刷卡 編輯
	public function gomypay_credit_edit($member_id = '', $action = '')
	{
		$data = $this -> data;

		if($this->session->userdata('auth') != '00')
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
		else
		{
			if($action == 0)
			{
				$data['suc'] = 0;
			}
			else if($this -> input -> post('business_account') && $this -> input -> post('business_hashiv') || $action == 1)
			{
				$data['suc'] = 1;
				$store = $this -> mod_admin -> select_from('iqr_cart', array('member_id' => $member_id));
				$iqrt  = $this -> mod_admin -> select_from('iqr_trans', array('pway_id' => 6,'cset_id' => $store['cset_id']));

				$business_account = $this -> input -> post('business_account');
				$business_hashiv  = $this -> input -> post('business_hashiv');

				$update_data = array(
						'business_account'	=> $business_account,
						'business_hashiv'	=> $business_hashiv
				);
				$this -> mod_admin -> update_where_array_set('iqr_trans', array('cset_id' => $iqrt['cset_id'], 'pway_id' => 6), $update_data);
			}
			else
			{
				echo '<script>
					  alert("錯誤連結");
					  window.close();
					  </script>'
					  ;

			}
			$data['member'] = $member = $this -> mod_admin -> select_from('member', array('member_id' => $member_id));
			$store  = $this -> mod_admin -> select_from('iqr_cart', array('member_id' => $member_id));
			$data['iqrt'] = $this -> mod_admin -> select_from('iqr_trans', array('pway_id' => 6,'cset_id' => $store['cset_id']));
			$this -> load -> view('admin/gomypay_credit_edit', $data);
		}
	}

	// 信件通知
	public function mail_config()
	{
		if($this->session->userdata('auth') != '00')
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
		else
		{
			$data = $this -> data;

			//domain
			if(!$this -> input -> post('sys_mail') && !$this -> input -> post('domain_id'))
			{
				$data['domain'] = $domain = $this -> mod_admin -> select_from_order('domain', 'domain', 'asc');
				$this -> load -> view('admin/mail_config', $data);
			}
			else
			{
				$sys_mail = $this -> input -> post('sys_mail');
				$domain_id = $this -> input -> post('domain_id');
				foreach ($domain_id as $key => $value)
				{
					$this -> mod_admin -> update_set('domain', 'domain_id', $value, array('sys_mail' => $sys_mail[$key]));
				}

				$this -> script_message('修改成功', '/admin/mail_config', 'top');
			}
		}
	}

	//系統設定
	public function system_config()
	{
		if($this->session->userdata('auth') != '00')
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
		else
		{
			//library
			$this->load->library('encrypt');
			
			//data
			$data=$this->data;

			if(!$this->input->post('form_submit'))
			{
				//register_code
				$data['register_code']=$this->encrypt->decode($data['web_config']['register_code']);

				$data['iqr_link_type_selected'][$data['web_config']['iqr_link_type']]='selected';
				$data['g_deadline_status_selected'][$data['web_config']['g_deadline_status']]='selected';
				$data['quoted_default_selected'][$data['web_config']['quoted_default']]='selected';
				$data['g_free_link_status_selected'][$data['web_config']['g_free_link_status']]='selected';
				$data['cart_status_selected'][$data['web_config']['cart_status']]='selected';
				$data['cart_spec_status_selected'][$data['web_config']['cart_spec_status']]='selected';
				$data['register_status_selected'][$data['web_config']['register_status']]='selected';
				$data['web_banner_selected'][$data['web_config']['web_banner']]='selected';
				$data['auth_level_num_selected'][$data['web_config']['auth_level_num']]='selected';
				$data['group_push_selected'][$data['web_config']['group_push']]='selected';
				$data['is_auto_upgrade_member'][$data['web_config']['is_auto_upgrade_member']]='selected';
				$data['is_auto_register_wowpay'][$data['web_config']['is_auto_register_wowpay']]='selected';
				$data['product_home'][$data['web_config']['product_home']]='selected';
				$data['prd_class_img'][$data['web_config']['prd_class_img']]='selected';
				$data['is_show_fb'][$data['web_config']['is_show_fb']]='selected';
				$data['is_show_pv'][$data['web_config']['is_show_pv']]='selected';
				$data['is_givebonus'][$data['web_config']['is_givebonus']]='selected';
				$data['is_notice_email'][$data['web_config']['is_notice_email']]='selected';

				$this->load->view('admin/system_config', $data);
			}
			else
			{
				$update_data=array(
					'logo'					=> $this->input->post('logo'),
					'title'					=> $this->input->post('title'),
					'register_code'			=> $this->encrypt->encode($this->input->post('register_code')),
					'auth_level_num'		=> $this->input->post('auth_level_num'),
					'titlename_num'			=> $this->input->post('titlename_num'),
					'video_num'				=> $this->input->post('video_num'),
					'website_num'			=> $this->input->post('website_num'),
					'address_num'			=> $this->input->post('address_num'),
					'iqr_link_type'			=> $this->input->post('iqr_link_type'),
					'g_deadline_status'		=> $this->input->post('global_deadline_status'),
					'global_deadline'		=> $this->input->post('global_deadline'),
					'quoted_default'		=> $this->input->post('quoted_default'),
					'g_free_link_status'	=> $this->input->post('g_free_link_status'),
					'free_link_name'		=> $this->input->post('free_link_name'),
					'cart_status'			=> $this->input->post('cart_status'),
					'cart_spec_status'		=> $this->input->post('cart_spec_status'),
					'prd_class_num'			=> $this->input->post('prd_class_num'),
					'register_status'		=> $this->input->post('register_status'),
					'group_push'			=> $this->input->post('group_push'),
					'web_banner'			=> $this->input->post('web_banner'),
					'web_banner_color'		=> $this->input->post('web_banner_color'),
					'web_footer_text'		=> $this->input->post('web_footer_text'),
					'iqr_footer_text'		=> $this->input->post('iqr_footer_text'),
					'currency'				=> $this->input->post('currency'),
					'is_transfer'			=> $this->input->post('is_transfer'),
					'transfer'				=> $this->input->post('transfer'),
					'is_auto_upgrade_member'=> $this->input->post('is_auto_upgrade_member'),
					'is_auto_register_wowpay'=> $this->input->post('is_auto_register_wowpay'),
					'product_home'			=> $this->input->post('product_home'),
					'prd_class_img'			=> $this->input->post('prd_class_img'),
					'is_show_fb'			=> $this->input->post('is_show_fb'),
					'is_show_pv'			=> $this->input->post('is_show_pv'),
					'is_givebonus'			=> $this->input->post('is_givebonus'),
					'is_notice_email'		=> $this->input->post('is_notice_email'),
					'notice_email'			=> $this->input->post('notice_email'),
					'is_PID'				=> $this->input->post('is_PID'),
					'is_alipay'				=> $this->input->post('is_alipay')
				);
				$this->mod_admin->update_set('control_setting', 'domain_id', $data['session_domain'], $update_data);
				redirect('/admin/system_config');
			}
		}
	}

	//版型設定
	public function style_config()
	{
		if($this->session->userdata('auth') != '00')
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
		else
		{
			//library
			$this->load->library('encrypt');
			
			//data
			$data=$this->data;

			if(!$this->input->post('form_submit'))
			{
				$this->load->view('admin/style_config', $data);
			}
			else
			{
				$update_data=array(
					'style_id'			=> $this->input->post('style_id')
				);
				$this->mod_admin->update_set('style_config', 'domain_id', $data['session_domain'], $update_data);
				redirect('/admin/style_config');
			}
		}
	}


	//常見問題管理
	public function qaa_management()
	{
		if($this->session->userdata('auth') != '00')
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
		else
		{
			//data
			$data=$this->data;
			
			//qanda data
			$data['qaa']=$q_and_a=$this->mod_admin->select_from_order('q_and_a', 'qaa_id', 'asc');

			//qaa group
			$data['qaag']=$this->mod_admin->select_from_order('q_and_a_group', 'qaag_id', 'asc');

			//view
			$this->load->view('admin/qaa_list', $data);
		}
	}

	//新增常見問題群組
	public function qaag_add()
	{
		if($this->session->userdata('auth') != '00')
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
		else
		{
			//data
			$data=$this->data;
		
			if($this->input->post('qaag_name'))
			{
				$this->mod_admin->insert_into('q_and_a_group', array('qaag_name'=>$this->input->post('qaag_name')));
				redirect('/admin/qaa_management');
			}
		}
	}

	//新增常見問題
	public function qaa_add()
	{
		if($this->session->userdata('auth') != '00')
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
		else
		{
			//data
			$data=$this->data;
		
			if(!$this->input->post('qaag_id'))
			{
				//qaa group
				$data['qaag']=$this->mod_admin->select_from_order('q_and_a_group', 'qaag_id', 'asc');

				//view
				$this->load->view('admin/qaa_add', $data);
			}
			else
			{
				$insert_qaa=array(
					'qaa_group_id'	=> $this->input->post('qaag_id'),
					'qaa_title'		=> $this->input->post('qaa_title'),
					'qaa_content'	=> $this->input->post('qaa_content'),
					'qaa_answer'	=> $this->input->post('qaa_answer')
				);
				$this->mod_admin->insert_into('q_and_a', $insert_qaa);
				redirect('/admin/qaa_management');
			}
		}
	}

	//編輯常見問題
	public function qaa_edit()
	{
		if($this->session->userdata('auth') != '00')
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
		else
		{
			//data
			$data=$this->data;
			
			if(!$this->input->post('qaa_id'))
			{
				//qanda data
				$data['qaa']=$q_and_a=$this->mod_admin->select_from_order('q_and_a', 'qaa_id', 'asc');

				//view
				$this->load->view('admin/qaa_edit', $data);
			}
			else
			{
				$qaa_title=$this->input->post('qaa_title');
				$qaa_content=$this->input->post('qaa_content');
				$qaa_answer=$this->input->post('qaa_answer');

				foreach ($this->input->post('qaa_id') as $key => $value)
				{
					$update_data=array(
						'qaa_title'		=> $qaa_title[$key],
						'qaa_content'	=> $qaa_content[$key],
						'qaa_answer'	=> $qaa_answer[$key]
					);
					$this->mod_admin->update_set('q_and_a', 'qaa_id', $value, $update_data);
				}
				redirect('/admin/qaa_management');
			}
		}
	}

	//常見問題刪除
	public function qaa_delete()
	{
		if($this->session->userdata('auth') != '00')
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
		else
		{
			//data
			$data=$this->data;

			if(!$this->input->post('qaa_del'))
			{
				//qanda data
				$data['qaa']=$q_and_a=$this->mod_admin->select_from_order('q_and_a', 'qaa_id', 'asc');

				foreach($q_and_a as $key => $value)
				{
					
				}

				$this->load->view('admin/qaa_delete', $data);
			}
			else
			{
				//post data
				$qaa_del=$this->input->post('qaa_del');
				foreach($qaa_del as $key => $value)
				{
					$this->mod_admin->delete_where('q_and_a', array('qaa_id'=>$value));
				}
				redirect('/admin/qaa_management');
			}
		}
	}

	//產生加密碼
	public function make_code()
	{
		if($this->session->userdata('auth') != '00')
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
		else
		{
			//library
			$this->load->library('encrypt');
			echo $this->encrypt->encode($this->input->post('encrypt_code'));
			echo '<p><input type="button" value="返回" onclick="top.frames[\'content-frame\'].location=\'/admin/system_config\'"></p>';
		}
	}

	//產生註冊數字串
	public function make_register_code($need_return='')
	{
		if($this->session->userdata('auth') != '00')
		{
			echo '<script>top.window.location.href="/index/login"</script>';
		}
		else
		{
			$code='000000'.mt_rand(1000000000, 9999999999);
			
			if($need_return == 1)
			{
				//library
				$this->load->library('encrypt');

				return $this->encrypt->encode($code);
			}
			else
			{
				echo $code;
			}
		}
	}

	//驗證註冊表單
	public function register()
	{
		//資料設定
		$account=$this->input->post('account');

		//空白驗證
		if($account == '')
		{
			$result['empty_error'] = false;
			$result['empty_result']  = '您的註冊資訊不可空白';
		}
		else
		{
			$result['empty_error'] = true;
			$result['empty_result']  = '';

			//帳號驗證
			if($account != '')
			{
				$member=$this->mod_admin->select_from('member', array('account'=>$account));
				if(empty($member))
				{
					if($this->check_symbol($account))
					{
						$result['account_error']  = true;
						$result['account_result'] = '';
					}
					else
					{
						$result['account_error']  = false;
						$result['account_result'] = '請勿使用特殊符號作為帳號';
					}
				}
				else
				{//帳號已存在
					$result['account_error']  = false;
					$result['account_result'] = '帳號重覆，請使用其他帳號';
				}
			}
		}

		if($result['empty_error'] && $result['account_error'])
		{
			$result['result_error']=1;
		}
		else
		{
			$result['result_error']=0;
		}
		//結果回傳
 		$ajax_data = json_encode($result);
		echo $ajax_data;
	}

	// 到期日回傳
	function get_deadtime($time, $range)
	{
		$original = strtotime($time);
		$deadtime = date('Y-m-d', strtotime($range, $original));
		return $deadtime;
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

		// if(!is_dir($dir))
		// {
			$temp = explode('/', $dir);
			$cur_dir = '';
			for($i = 0; $i < count($temp); $i++)
			{
				$cur_dir .= $temp[$i].'/';
				// if (!is_dir($cur_dir))
					// @mkdir($cur_dir,0777);
			}
		// }
		return substr($cur_dir, 1, (strlen($cur_dir) - 1));
	}

	function check_symbol($account)
	{
		$symbol[]=strpos($account, '`');
		$symbol[]=strpos($account, '!');
		$symbol[]=strpos($account, '@');
		$symbol[]=strpos($account, '#');
		$symbol[]=strpos($account, '$');
		$symbol[]=strpos($account, '%');
		$symbol[]=strpos($account, '^');
		$symbol[]=strpos($account, '&');
		$symbol[]=strpos($account, '*');
		$symbol[]=strpos($account, '-');
		$symbol[]=strpos($account, '(');
		$symbol[]=strpos($account, ')');
		$symbol[]=strpos($account, '+');
		$symbol[]=strpos($account, '=');
		$symbol[]=strpos($account, '[');
		$symbol[]=strpos($account, ']');
		$symbol[]=strpos($account, '\\');
		$symbol[]=strpos($account, '/');
		$symbol[]=strpos($account, ',');
		$symbol[]=strpos($account, '.');
		$symbol[]=strpos($account, '?');
		$symbol[]=strpos($account, '"');
		$symbol[]=strpos($account, '\'');
		$symbol[]=strpos($account, '|');
		$symbol[]=strpos($account, '{');
		$symbol[]=strpos($account, '}');
		$result=true;
		foreach($symbol as $key => $value)
		{
			if($value == true)
			{
				$result=false;
				break;
			}
		}
		return $result;
	}
	public function writemain(){
		$this->load->model('/MyModel/mymodel');
		if(!empty($_POST)){
			$this->mymodel->update_set('config','d_type','adminmain',array('d_val'=>$_POST['d_content']));
		
			$this->useful->AlertPage('/admin/writemain','儲存成功');
		}else{
			$data['dbdata']=$this->mymodel->OneSearchSql('config','d_val',array('d_type'=>'adminmain'));
			$this->load->view('admin/writemain', $data);
		}	
	}
}
