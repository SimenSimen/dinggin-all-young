<?php
//會員
class User extends MY_Controller
{
	public $data='';
	public $language='';

	public function __construct()//初始化
	{
		parent::__construct();

		// language
		$this -> load -> helper('language');
		if(!$this -> session -> userdata('lang'))
		{
			$this -> session -> set_userdata('lang', 'TW');
			$this -> data['lang'] = $this -> session -> userdata('lang');
		}
		else
			$this -> data['lang'] = $this -> session -> userdata('lang');

		// language_top
		$this -> load -> model('language_model', 'mod_language');
		$lang = $this -> mod_language -> converter('999', $this -> session -> userdata('lang'));
		$this -> data = array_merge($this -> data, $lang);

		// language
		$lang = $this -> mod_language -> converter('6', $this -> session -> userdata('lang'));
		$this -> data = array_merge($this -> data, $lang);
        
        // helper
        $this->load->helper('url');
        
        // base_url
        $this->data['base_url'] = base_url();

        // model
		$this->load->model('user_model', 'mod_user');

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
        $m = $this->mod_user->select_from('member', array('member_id'=>$this->session->userdata('member_id')));

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

	//名片分析報表
	public function iqr_views($type='') // $type : 圖表類型
	{
		//data
		$data=$this->data;
		$lang = $this -> mod_language -> converter('7', $this -> session -> userdata('lang'));
		$data = array_merge($data, $lang);

		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{	
			//未登入
			$this->myredirect('/index/login', $data['PleaseLogin'], 5);
			return 0;
		}
		else
		{
			//行動名片連結
			$member=$this->mod_user->select_from('member', array('member_id'=>$this->session->userdata('member_id')));
			if($data['web_config']['iqr_link_type'] == 1)//短網址
			{
				$base_url=substr(base_url(), 7);
				$base_url=substr($base_url, 0, -1);
				$data['iqr_url']='http://'.$member['account'].'.'.$base_url;
			}
			else
			{
				$data['iqr_url']=base_url().'business/iqr/'.$member['account'];
			}

			//圖表數值設定
			if($type == '')$type = 'pm';
			$y = ($this->input->get('y') == '') ? (date('Y', time())) : $this->input->get('y');
			switch ($type) {
				case 'pm': // per month 
					
					//計算年度每月瀏覽次數
					$views_pmay = $this->mod_user->pmay_get($member['member_id'], $y); // pmay, per month a year
					foreach($views_pmay as $key => $value)
					{
						if($key != 0)
							$data['line']['data'] .= ',';
						$data['line']['data'] .= '['.($key + 1).', '.$value.']'; // 折線圖瀏覽次數資料
					}
					$data['line']['max'] = $this->rounding_up(round(max($views_pmay)));
					break;
				
				default:
					# code...
					break;
			}

			// element
			$data['title'] = $y . '年';
			//view
			$this->load->view('user/iqr_views', $data);
		}
	}

	//會員管理 - 網管權限
	public function member_list()
	{
		$language = $this -> language;
		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{	
			//未登入
			$this->myredirect('/index/login', $language['PleaseLogin'], 5);
			return 0;
		}
		else
		{
			//data
			$data=$this->data;
			// language
			$this -> lang -> load('views/user/member_list', $data['lang']);
			$data['_MemberAccount'] = lang('_MemberAccount');
			$data['MemberList'] = lang('MemberList');
			$data['Click'] = lang('Click');
			$data['Password'] = lang('Password');
			$data['AccountNumber'] = lang('AccountNumber');
			$data['Mailbox'] = lang('Mailbox');
			$data['Display'] = lang('Display');

			//權限檢查
			if($data['user_auth'] != '01')
			{
				//您的權限不足
				$this->myredirect('/business/edit', $language['LackOfCompetence'], 5);
				return 0;
			}
			else
			{
				//行動名片連結
				$member=$this->mod_user->select_from('member', array('member_id'=>$this->session->userdata('member_id'), 'domain_id'=>$data['domain_id']));
				if($data['web_config']['iqr_link_type'] == 1)//短網址
				{
					$base_url=substr(base_url(), 7);
					$base_url=substr($base_url, 0, -1);
					$data['iqr_url']='http://'.$member['account'].'.'.$base_url;
				}
				else
				{
					$data['iqr_url']=base_url().'business/iqr/'.$member['account'];
				}

				//library
				$this->load->library('encrypt');

				//member_list user
				$data['user']=$this->mod_user->list_user($data['domain_id']);
				foreach ($data['user'] as $key => $value)
				{
					//會員名片預覽
					$data['member_iqr_link'][$key]=base_url().'business/iqr_html/'.$value['account'];

					//密碼
					$data['password'][$key]=$this->encrypt->decode($value['password']);
				}			

				//view
				$this->load->view('user/member_list', $data);
			}
		}
	}

	//金鑰列表 - 直接顯示給網站管理者運用
	public function key_list()
	{
		$language = $this -> language;
		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{	
			//未登入
			$this->myredirect('/index/login', $language['PleaseLogin'], 5);
			return 0;
		}
		else
		{
			//data
			$data = $this -> data;
			// language
			$this -> lang -> load('views/user/key_list', $data['lang']);
			$data['_MemberAccount'] = lang('_MemberAccount');
			$data['CardNumber'] = lang('CardNumber');
			$data['NoAnyKey'] = lang('NoAnyKey');
			$data['Status'] = lang('Status');
			$data['Key'] = lang('Key');
			$data['KeyList'] = lang('KeyList');
			$data['_KeyState'] = lang('_KeyState');
			$data['ExpandHighlighted'] = lang('ExpandHighlighted');
			$data['OpenCardPeople'] = lang('OpenCardPeople');
			$data['Click'] = lang('Click');

			//權限檢查
			if($data['user_auth'] != '01')
			{
				//您的權限不足
				$this->myredirect('/business/edit', $language['LackOfCompetence'], 5);
				return 0;
			}
			else
			{
				//行動名片連結
				$member=$this->mod_user->select_from('keys', array('domain_id'=>$this->session->userdata('member_id'), 'domain_id'=>$data['domain_id']));
				if($data['web_config']['iqr_link_type'] == 1)//短網址
				{
					$base_url=substr(base_url(), 7);
					$base_url=substr($base_url, 0, -1);
					$data['iqr_url']='http://'.$member['account'].'.'.$base_url;
				}
				else
				{
					$data['iqr_url']=base_url().'business/iqr/'.$member['account'];
				}

				//keys
				$data['keys']=$this->mod_user->select_from_order('keys', 'key_id', 'asc', array('domain_id'=>$data['domain_id']));
				foreach ($data['keys'] as $key => $value)
				{
					//使用狀態
					$data['key_use'][$key]=($value['key_use'] == 0) ? $Unused : '○';

					if($value['key_use'] == 1)
					{
						//member
						$m=$this->mod_user->select_from('member', array('member_id'=>$value['member_id']));
					
						//會員名片預覽
						$data['member_iqr_link'][$key]='<a href="'.base_url().'business/iqr_html/'.$m['account'].'"" onclick="window.open(this.href, \'\', config=\'scrollbars=1,outerWidth=300,innerWidth=300,height=640,width=300,left=900,scrollbar=yes\'); return false;">'.$m['account'].'</a>';
					}
					else
					{
						$data['member_iqr_link'][$key]='';
					}
				}
				
				//view
				$this->load->view('user/key_list', $data);
			}
		}
	}
	
	//更新資料
	public function update($action='')
	{
		//data
		$data=$this->data;
		$lang = $this -> mod_language -> converter('8', $this -> session -> userdata('lang'));
		$data = array_merge($data, $lang);

		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{	
			//未登入
			$this->myredirect('/index/login', $language['PleaseLogin'], 5);
			return 0;
		}
		else
		{
			//行動名片連結
			$m=$this->mod_user->select_from('member', array('member_id'=>$this->session->userdata('member_id')));
			if($data['web_config']['iqr_link_type'] == 1)//短網址
			{
				$base_url=substr(base_url(), 7);
				$base_url=substr($base_url, 0, -1);
				$data['iqr_url']='http://'.$m['account'].'.'.$base_url;
			}
			else
			{
				$data['iqr_url']=base_url().'business/iqr/'.$m['account'];
			}

			//helper
			$this->load->helper('form');

			switch ($action)
			{
				case 'updp'://修改密碼
					//library
					$this->load->library('encrypt');
					if(!$this->input->post('form_submit'))
					{
						//view
						$this->load->view('user/updp', $data);
					}
					else
					{
						$temp_password=$this->input->post('password');

				    	//字符驗證
				    	$char=preg_match("/[\x{4e00}-\x{9fa5}]/u", $temp_password);     //判斷中文
				    	$phonetic=preg_match("/[\x{3105}-\x{312d}]/u", $temp_password); //判斷音標
				    	$number=preg_match('/[0-9]/u', $temp_password);
				    	$english=preg_match('/[a-zA-Z]/u', $temp_password);
						if($number && $english && !$phonetic && !$char)
						{
						}
			    		else
			    		{
			    			$this->script_message($data['Use6Char'], '/user/update/updp');
			    			return 0;
			    		}
			    		if(strlen($temp_password) < 6)
			    		{
			    			$this->script_message($data['Use6Char'], '/user/update/updp');
			    			return 0;
			    		}

						//原密碼
						$member=$this->mod_user->select_from('member', array('member_id'=>$this->session->userdata('member_id')));
						$decode=$this->encrypt->decode($member['password']);
						if($decode == $this->input->post('old_password'))
						{
							//新密碼加密
							$encode=$this->encrypt->encode($this->input->post('password'));
							$this->mod_user->update_set('member', 'member_id', $member['member_id'], array('password'=>$encode));
							$this->script_message('修改成功', '/user/update/updp');
							return 0;
						}
						else
						{
							$this->script_message($data['OriginalPasswordError'], '/user/update/updp');
							return 0;
						}
					}
					
					break;

				// case 'updmah'://修改子會員層級
					// 	if(!$this->input->post('form_submit'))
					// 	{
					// 		//member data
					// 		$member=$this->mod_user->select_from_order('member', 'member_id', 'asc');
					// 		$rowsapn=3;
					// 		if(!empty($member))
					// 		{
					// 			foreach($member as $key => $value)
					// 			{
					// 				if($value['auth'] != '00' && $value['member_id'] != $this->session->userdata('member_id'))
					// 				{
					// 					//列出會員
					// 					$data['member'][$key]=$value;

					// 					//iqr name
					// 					$iqr=$this->mod_user->select_from('iqr', array('member_id'=>$value['member_id']));
					// 					$data['user_name'][$key]=$iqr['l_name'].$iqr['f_name'];
					// 				}
					// 				$rowsapn++;
					// 			}
					// 			$data['rowspan']=$rowsapn;
					// 		}

					// 		//權限等級
					// 		$c_str=array(2=>'二', 3=>'三');
					// 		for($i = 2; $i <= $data['web_config']['auth_level_num']; $i++)
					// 		{
					// 			$data['auth_level'][$i]['value']=$i;
					// 			$data['auth_level'][$i]['name']='第'.$c_str[$i].'層級';
					// 		}

					// 		//view
					// 		$this->load->view('user/updmah', $data);
					// 	}
					// 	else
					// 	{
					// 		//post data
					// 		$update_webmin_id=$this->input->post('update_webmin');
					// 		foreach($update_webmin_id as $key => $value)
					// 		{
					// 			$this->mod_user->update_set('member', 'member_id', $value, array('auth'=>$this->input->post('auth_level')));
					// 		}

					// 		$this->myredirect('/user/update/updmah', '修改成功', 5);
					// 		return 0;
					// 	}

					// 	break;
				
				default:
					// redirect('/user/setting');
					break;
			}
		}
	}
}