<?php
class Coupon extends MY_Controller
{
	public $language = '', $data = '';
	function __construct()
	{
		parent::__construct();
		$this -> load -> model('coupon_model', 'mod_coupon');

		$this -> load -> helper('url');
		$this -> load -> helper('language');
		if(!$this -> session -> userdata('lang') || $this -> session -> userdata('lang') == 'zh-tw')
		{
			$this -> session -> set_userdata('lang', 'TW');
			$this -> data['lang'] = $this -> session -> userdata('lang');
		}
		else
			$this -> data['lang'] = $this -> session -> userdata('lang');
		$this -> data['lang'] = $this -> session -> userdata('lang');

		$this -> load -> library('/mylib/useful');

		$this->useful->CheckComp('j_friend');
	}

	public function main()
	{
		$data['type'] = $type = '9';
		$data['group'] = $this -> mod_coupon -> select_from_order_limit('auth_category', array('c_name', 'category_id'), array('type' => $type, 'lang_type' => $this->session->userdata('lang')), 'sort', 'asc');
		if(!empty($data['group']))
			$data['coupon_btn'] = true;

		$data['coupon'] = $this -> mod_coupon -> inner_join_order_by('ecoupon', 'auth_category', array('ecoupon.*', 'auth_category.c_name'), array('auth_category.lang_type' => $this->session->userdata('lang'), 'ecoupon.lang_type' => $this -> session -> userdata('lang')), 'category_id', 'ecoupon.sort', 'asc');
		$this -> load -> view('admin/system_center/coupon/list', $data);
	}

	public function group_add()
	{
		$response = array('recode', 'result', 'retext');
		$group_name = $this -> input -> post('group_name');
		$type = $this -> input -> post('type');
		
		if(!empty($group_name))
		{
			$category = $this -> mod_coupon -> select_from('auth_category', array('c_name'), array('c_name' => $group_name, 'lang_type' => $this -> session -> userdata('lang'), 'type' => $type));
			
			if(in_array($group_name, $category))
			{
				$response = array(
					'recode' => '0001',
					'result' => false,
					'retext' => '群組名稱已存在'
				);
			}
			else
			{
				$this -> mod_coupon -> insert_into('auth_category', array('c_name' => $group_name, 'type' => $type, 'lang_type' => $this->session->userdata('lang'), 'update_time' => date('Y-m-d H:i:s', time())));
				$response = array(
					'recode' => '200',
					'result' => true,
					'retext' => '',
				);
			}
		}
		else
		{
			$response = array(
				'recode' => '0002',
				'result' => false,
				'retext' => '群組名不可為空白'
			);
		}
		echo json_encode($response);
	}

	public function del_group()
	{
		$response_array = array('result', 'message');
		$category_id = ($this -> input -> post('id')) ? $this -> input -> post('id') : '';
		$category = $this -> mod_coupon -> select_from('auth_category', array('category_id'), array('category_id' => $category_id));
		
		if(!empty($category))
		{
			$uform = $this -> mod_coupon -> select_from('ecoupon', array('ecp_id'), array('category_id' => $category['category_id']));
			if(!empty($uform))
			{
				$response_array['result'] = false;
				$response_array['message'] = 'To use';
			}
			else
			{
				$this -> mod_coupon -> delete_where('auth_category', array('category_id' => $category_id));
				$response_array['result'] = true;
				$response_array['message'] = 'Success';
			}
		}
		else
		{
			$response_array['result'] = false;
			$response_array['message'] = 'Error';
		}

		echo json_encode($response_array);
	}

	public function edit($type, $id)
	{
		$data['type'] = $type;
		if ($data['edit'] = $this -> mod_coupon -> stretch($type, $id))
		{
		}
		else
			show_error('錯誤連結', '404', 'Error');

		$this -> load -> view('admin/system_center/coupon/edit', $data);
	}

	public function con_edit()
	{
		$edit_name = $this -> input -> post('edit_name');
		$id = $this -> input -> post('edit_id');
		$type = $this -> input -> post('type');

		switch ($type) {
			case 'g':
				$table = 'auth_category';
				$target = array('category_id' => $id);
				$update_data = array('c_name' => $edit_name, 'update_time' => date('Y-m-d H:i:s', time()), 'lang_type' => $this->session->userdata('lang'));
				break;
		}

		if (isset($edit_name) && !empty($edit_name))
		{
			$this -> mod_coupon -> update_set($table, $target, $update_data);
			$this -> main();
		}
		else
			$this -> edit($type, $id);
	}

	public function form_del()
	{
		$ck_array = $this -> input -> post('ck_id');
		$del_array = $this -> input -> post('check_id');
		$type = $this -> input -> post('type');

		if(is_array($ck_array) && is_array($del_array))
		{
			$del_data = array_intersect($del_array, $ck_array);
			$update_id = array();
			foreach ($del_data as $key => $value)
			{
				$ecoupon = $this -> mod_coupon -> inner_join('ecoupon', 'member', array('ecoupon.filename', 'member.img_url'), array('ecp_id' => $value), 'member_id', 'row');
				unlink('.' . $ecoupon['img_url'] .DIRECTORY_SEPARATOR. 'coupon' .DIRECTORY_SEPARATOR. $ecoupon['filename']);
				$this -> mod_coupon -> delete_where('ecoupon', array('ecp_id' => $value));
			}
			$this -> script_message('刪除成功', '/coupon/main/' . $type);
		}
		else
			$this -> script_message('請勾選您要刪除的筆數', '/coupon/main/' . $type);
	}

	public function ecoupon($opr = '', $success = '', $id = '')
	{
		$this -> load -> model('business_model', 'mod_business');
		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{	
			//未登入
			$this->myredirect('/index/login', '請先登入', 5);
			return 0;
		}
		else
		{
			$data = $this -> data;
			$language = $this -> language;
			//member
			// $member = $this->mod_business->select_from('member', array('member_id'=>$this->session->userdata('member_id')));

			//延長ckeditor上傳時間
			$this->extend_ckupload_time(3600, 1, '/uploads/000/000/0000/0000000000/ckfinder_image', 00, 0);

            //member
            $iqr = $this->mod_business->select_from('iqr', array('member_id'=>1));

			//helper
			$this->load->helper('form');

			//account
			$data['account'] = $member['account'];
			$data['mid'] 	 = 1;

			//行動名片資料
			$ecoupon = $this->mod_business->select_from_order('ecoupon', 'ecp_id', 'desc', array('member_id'=>1));
			foreach ($ecoupon as $key => $value) {
				switch ($value['mode']) {
                    case 1: $ecoupon[$key]['mode_txt'] = 'APP 載點';     break;
                    case 2: $ecoupon[$key]['mode_txt'] = '自訂分享網址'; break;
                    case 3: $ecoupon[$key]['mode_txt'] = '自訂分享內容'; break;
				}
			}
			$data['ecoupon'] = $ecoupon;

			$data['category'] = $this -> mod_coupon -> select_from('auth_category', array('category_id', 'c_name'), array('type' => '9', 'lang_type' => $this -> session -> userdata('lang')), 'array');
			
			//folder
			$data['img_url'] = $img_url = './uploads/000/000/0000/0000000000/coupon/';

			// exchange update
			// auth
	        $auth = intval($member['auth']);
            // web config
            $auth_level_num = intval($data['web_config']['auth_level_num']);

			switch ($opr) {

				case 'add':
					if(!$this->input->post('add'))
					{
						if($success == 1)
						{
							$data['success'] = $success;
						}

						$this -> lang -> load('views/ecoupon/add', $data['lang']);
						$data['ShareCertificatesName'] = lang('ShareCertificatesName');
						$data['ShareCertificatesPicture'] = lang('ShareCertificatesPicture');
						$data['TellFriendVoucher'] = lang('TellFriendVoucher');
						$data['Cancel'] = lang('Cancel');
						$data['Message'] = lang('Message');
						$data['Must32Char'] = lang('Must32Char');
						$data['Just3MB'] = lang('Just3MB');
						$data['Added'] = lang('Added');
						$data['_AddfriendCoupons'] = lang('_AddfriendCoupons');
						$data['ShareSetting'] = lang('ShareSetting');
						$data['APPDownload'] = lang('APPDownload');
						$data['CustomerURL'] = lang('CustomerURL');
						$data['CustomerContent'] = lang('CustomerContent');
						$data['ShareURL'] = lang('ShareURL');
						$data['ShareURLValue'] = lang('ShareURLValue');
						$data['ShareContent'] = lang('ShareContent');
						$data['Must8Char'] = lang('Must8Char');
						$data['ButtonName'] = lang('ButtonName');

						//view
						$this->load->view('admin/system_center/coupon/coupon_add', $data);
					}
					else
					{
						//創建資料夾放分享券
						if(!is_dir($img_url))
							@mkdir($img_url, 0777);

						//圖檔上傳
						if(!empty($_FILES))
						{
							//model
							$this->load->model('upload_model', 'mod_upload');

							//image file
							if($_FILES['coupon']['error'] != 4)
								$coupon = $this->mod_upload->upload_single_image($img_url, $_FILES['coupon']);
						}
						$share_mode = $this -> input -> post('share_mode');
						switch ($share_mode) {
							case 1:
								// App 載點
								$share = base_url() . 'app/route/';
								$insert_data = array(
									'member_id' => 1,
									'category_id' => $this->input->post('category_id'),
									'name' 		=> $this->input->post('name'),
									'filename' 	=> $coupon['path'],
									'content' 	=> $this->input->post('content'),
									'btn_name'	=> $this->input->post('btn_name'),
									'mode'		=> $share_mode,
									'mode_1'	=> $share,
									'lang_type' => $this -> session -> userdata('lang')
								);
								$ecp_id = $this->mod_business->insert_into('ecoupon', $insert_data);
								break;
							case 2:
								// 自訂分享網址
								$share_url = $this -> input -> post('share_url');
								$insert_data = array(
									'member_id' => 1,
									'category_id' => $this->input->post('category_id'),
									'name' 		=> $this->input->post('name'),
									'filename' 	=> $coupon['path'],
									'content' 	=> $this->input->post('content'),
									'btn_name'	=> $this->input->post('btn_name'),
									'mode'		=> $share_mode,
									'mode_2'	=> $share_url,
									'lang_type' => $this -> session -> userdata('lang')
								);
								$ecp_id = $this->mod_business->insert_into('ecoupon', $insert_data);
								break;
							case 3:
								$share_txt = $this -> input -> post('share_txt');
								$insert_data = array(
									'member_id' => 1,
									'category_id' => $this->input->post('category_id'),
									'name' 		=> $this->input->post('name'),
									'filename' 	=> $coupon['path'],
									'content' 	=> $this->input->post('content'),
									'btn_name'	=> $this->input->post('btn_name'),
									'mode'		=> $share_mode,
									'mode_3'	=> $share_txt,
									'lang_type' => $this -> session -> userdata('lang')
								);
								$ecp_id = $this->mod_business->insert_into('ecoupon', $insert_data);
								break;
						}

						//返回
						redirect('/coupon/ecoupon/add/1');
					}
					break;

				case 'edit':

					$data['edit_ecp'] = $this->mod_business->select_from('ecoupon', array('ecp_id'=>$id, 'member_id'=>1));
			
					if(!$this->input->post('edit'))
					{
						if($success == 1)
						{
							$data['success'] = $success;
						}
						
						$this -> lang -> load('views/ecoupon/edit', $data['lang']);
						$data['ShareCertificatesName'] = lang('ShareCertificatesName');
						$data['ShareCertificatesPicture'] = lang('ShareCertificatesPicture');
						$data['TellFriendVoucher'] = lang('TellFriendVoucher');
						$data['Cancel'] = lang('Cancel');
						$data['Message'] = lang('Message');
						$data['Just3MB'] = lang('Just3MB');
						$data['EditShare'] = lang('EditShare');
						$data['SaveEdit'] = lang('SaveEdit');
						$data['Must32Char'] = lang('Must32Char');
						$data['ButtonName'] = lang('ButtonName');
						$data['ShareSetting'] = lang('ShareSetting');
						$data['Must8Char'] = lang('Must8Char');
						$data['APPDownload'] = lang('APPDownload');
						$data['CustomerURL'] = lang('CustomerURL');
						$data['CustomerContent'] = lang('CustomerContent');
						$data['ShareURL'] = lang('ShareURL');
						$data['ShareURLValue'] = lang('ShareURLValue');
						$data['ShareContent'] = lang('ShareContent');

						//view
						$this->load->view('admin/system_center/coupon/coupon_edit', $data);
					}
					else
					{
						$share_mode = $this -> input -> post('share_mode');
						switch ($share_mode) {
							case 1:
								// App 載點
								$share = base_url() . 'app/route/';
								$update_data = array(
									'member_id' => 1,
									'category_id' => $this->input->post('category_id'),
									'name' 		=> $this->input->post('name'),
									'content' 	=> $this->input->post('content'),
									'btn_name'	=> $this->input->post('btn_name'),
									'mode'		=> $share_mode,
									'mode_1'	=> $share,
									'mode_2'	=> NULL,
									'mode_3'	=> NULL,
								);
								break;
							case 2:
								// 自訂分享網址
								$share_url = $this -> input -> post('share_url');
								$update_data = array(
									'member_id' => 1,
									'category_id' => $this->input->post('category_id'),
									'name' 		=> $this->input->post('name'),
									'content' 	=> $this->input->post('content'),
									'btn_name'	=> $this->input->post('btn_name'),
									'mode'		=> $share_mode,
									'mode_1'	=> NULL,
									'mode_2'	=> $share_url,
									'mode_3'	=> NULL
								);
								break;
							case 3:
								$share_txt = $this -> input -> post('share_txt');
								$update_data = array(
									'member_id' => 1,
									'category_id' => $this->input->post('category_id'),
									'name' 		=> $this->input->post('name'),
									'content' 	=> $this->input->post('content'),
									'btn_name'	=> $this->input->post('btn_name'),
									'mode'		=> $share_mode,
									'mode_1'	=> NULL,
									'mode_2'	=> NULL,
									'mode_3'	=> $share_txt
								);
								break;
						}

						//圖檔上傳
						if(!empty($_FILES))
						{
							//model
							$this->load->model('upload_model', 'mod_upload');

							//image file
							if($_FILES['coupon']['error'] != 4)
							{
								unlink($img_url.$data['edit_ecp']['filename']);
								$coupon = $this->mod_upload->upload_single_image($img_url, $_FILES['coupon']);
								$update_data['filename'] = $coupon['path'];
							}
						}

						$ecp_id = $this->mod_business->update_set('ecoupon', 'ecp_id', $id, $update_data);

						//返回
						redirect('/coupon/ecoupon/edit/1');
					}

					break;

				case 'delete':

                    //iqr
                    $ecp_id_array = $this->get_serialstr($iqr['ecoupon'], '*#');
                    foreach ($ecp_id_array as $key => $value)
                    {
                        if($value == $id)
                            unset($ecp_id_array[$key]);
                    }
                    $ecp_id_string = $this->set_serialstr($ecp_id_array, '*#');
                    $this->mod_business->update_set('iqr', 'member_id', 1, array('ecoupon'=>$ecp_id_string));

                    //ecoupon
					$delete_ecp = $this->mod_business->select_from('ecoupon', array('ecp_id'=>$id, 'member_id'=>1));
					unlink($img_url.$delete_ecp['filename']);
					$this->mod_business->delete_where('ecoupon', array('ecp_id'=>$id, 'member_id'=>1));
			
					//返回
					redirect('/coupon/main');

					break;

				default:
					$this -> lang -> load('views/business/ecoupon', $data['lang']);
					$data['ShareTicket'] = lang('ShareTicket');
					$data['ShareSet'] = lang('ShareSet');
					$data['NameMassage'] = lang('NameMassage');
					$data['FriendTicket'] = lang('FriendTicket');
					$data['_FriendTicket'] = lang('_FriendTicket');
					$data['FriendTicketLink'] = lang('FriendTicketLink');
					$data['Delete'] = lang('Delete');
					$data['QuickLink'] = lang('QuickLink');
					$data['Modify'] = lang('Modify');
					$data['SureDelet'] = lang('SureDelet');
					$data['Add'] = lang('Add');
					$data['NewShare'] = lang('NewShare');
					$data['Number'] = lang('Number');
					$data['EditSignUpForm'] = lang('EditSignUpForm');
					$data['Operating'] = lang('Operating');

					//view
					$this->load->view('coupon/main', $data);
					break;
			}
		}
	}

	public function ecoupon_qrcode($ecp_id='')
	{
		$this -> load -> model('business_model', 'mod_business');
		$language = $this -> language;
		//data
		$data=$this->data;
		// $auth=$data['user_auth'];
		// if($auth=='02'){
		// 	$data['chkmemberid']=$this->son_member_id;
		// 	$viewname='';
		// 	$viewtype='P';
		// }
		// else{
		// 	$data['chkmemberid']=$this->member_id;
		// 	$viewname=$language['Company'];
		// 	$viewtype='C';
		// }
		// $data['viewname'] = $viewname;
		// $data['viewtype'] = $viewtype;
		
		//helper
		$this->load->helper('url');

		if($ecp_id != '')
		{
			$data['ecoupon'] = $ecoupon = $this->mod_business->select_from('ecoupon', array('ecp_id'=>$ecp_id));
		}
		else
		{
			redirect(base_url());
		}

		if(!empty($ecoupon))
		{
			$data['base_url']=base_url();
			$data['ecp_id']=$ecp_id;

			//account
			$data['mid']=$this->session->userdata('member_id');

			//判斷使用期限
			if(!$this->check_deadline($data['web_config'], $this->session->userdata('member_id')))
			{
				redirect('/index/error');
			}
			
			//qrcode style
			$data['style']=array(
				'mode'=>0,
				'size'=>400,
				'fill'=>'#000000',
				'background'=>'#FFFFFF',
				'minversion'=>2,
				'eclevel'=>'H',
				'quiet'=>1,
				'radius'=>20,
				'msize'=>1,
				'mposx'=>50,
				'mposy'=>50,
				'font'=>4
			);

			$this -> lang -> load('views/business/view_ecp_qrcode_box', $data['lang']);
			$data['ClickOpen'] = lang('ClickOpen');
			$data['FriendTicket'] = lang('FriendTicket');
			$data['FriendTicketQRcode'] = lang('FriendTicketQRcode');
			$data['FriendTicketQuickLink'] = lang('FriendTicketQuickLink');
			$data['QuickFriendTicket'] = lang('QuickFriendTicket');
			$data['UsePhoneScan'] = lang('UsePhoneScan');
			$data['ClickPictureDownload'] = lang('ClickPictureDownload');
			$data['_ClickDownload'] = lang('_ClickDownload');
			$data['CloseWondows'] = lang('CloseWondows');
			$this->load->view('business/view_ecp_qrcode_box', $data);
		}
		else
		{
			redirect(base_url());
		}
	}

	public function sort_save()
	{
		$ck_array = $this -> input -> post('ck_id');
		$type = $this -> input -> post('type');
		if ($this -> mod_coupon -> sort_action($ck_array))
		{
			$this -> message = '排序修改成功';
			$this -> main();
		}
		else
		{
			$this -> message = '';
			$this -> main();
		}
	}

	public function my_ecoupon($mid, $eid)
	{
		//member
		$member = $this->mod_business->select_from('member', array('member_id'=>$mid));
		$member['img_url'] = '.uploads/000/000/0000/0000000000/';
		if(!empty($member))
		{
			//data
			$data = $this -> data;

			$this -> lang -> load('views/ecoupon/show', $data['lang']); 
			$data['ShareOnGoogle'] = lang('ShareOnGoogle');
			$data['ShareOnPlurk'] = lang('ShareOnPlurk');
			$data['ShareOnTwitter'] = lang('ShareOnTwitter');
			$data['ShareOnWeibo'] = lang('ShareOnWeibo');
			$data['ShareOnFacebook'] = lang('ShareOnFacebook');
			$data['TellFriendVoucher'] = lang('TellFriendVoucher');
			$data['EmailTellFriend'] = lang('EmailTellFriend');

			//判斷使用期限
			if(!$this->check_deadline($data['web_config'], $member['member_id']))
			{
				redirect('/index/error');
			}
            
            //member_id
            $data['mid'] = $member['member_id'];

            //行動名片連結
            if($data['web_config']['iqr_link_type'] == 1)//短網址
            {
                $base_url = substr(base_url(), 7);
                $base_url = substr($base_url, 0, -1);
                $data['iqr_url'] = 'http://'.$member['account'].'.'.$base_url;
            }
            else
            {
                $data['iqr_url'] = base_url().'business/iqr/'.$member['account'];
            }

            //full url
            $data['actual_link'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            
			//folder
			$data['base_url'] = base_url();
			$data['img_url'] = $img_url = '.'.$member['img_url'].'coupon/';
			$data['my_e_coupon'] = $this->mod_business->select_from('ecoupon', array('ecp_id'=>$eid));

			// mode 資料庫修正
			if($data['my_e_coupon']['mode'] == 1)
			{
				if(empty($data['my_e_coupon']['mode_1']))
				{
					$data['my_e_coupon']['mode_1'] = base_url() . 'app/route/' .$member['member_id'];
					$this->mod_business->update_set('ecoupon', 'ecp_id', $eid, array('mode_1' => $data['my_e_coupon']['mode_1']));
				}
			}

			if($this->session->userdata('web_return'))
				$data['web_return'] = base_url().'business/iqr/'.$this->session->userdata('web_return'); //web return
			else
				$data['web_return'] = $data['iqr_url'] ;
			
			$data['mode_1_btn'] = false;
			$data['mode_2_btn'] = false;
			$data['mode_3_btn'] = false;
			$mode = $data['my_e_coupon']['mode'];
			switch ($mode) {
				case 1:
					$data['mode_1_btn'] = true;
					$data['mode_1'] = $data['my_e_coupon']['mode_1'];
					break;
				case 2:
					$data['mode_2_btn'] = true;
					$data['mode_2'] = $data['my_e_coupon']['mode_2'];
					break;
				case 3:
					$data['mode_3_btn'] = true;
					$data['mode_3'] = '/business/ecoupon_editor/' . $member['member_id'] . '/' . $eid;
					break;
			}
				
			//裝置判斷分享bar hideen
			if($this->input->get('d') == 1 && $this->get_device_os() == 'android')
				$data['share_bar_hidden'] = 0;
			$data['android_d'] = $this->input->get('d');
			
			//view
			$this->load->view('ecoupon/show', $data);
		}
	}
}