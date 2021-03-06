<?php
class Banner extends MY_Controller
{
	public $language = '', $data = '';
	function __construct()
	{
		parent::__construct();
		$this -> load -> model('ban_model', 'mod_banner');

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

		$this->useful->CheckComp('j_banner');
	}

	public function main()
	{
		$data['type'] = $type = '10';
		$data['group'] = $this -> mod_banner -> select_from_order_limit('auth_category', array('c_name', 'category_id'), array('type' => $type, 'lang_type' => $this->session->userdata('lang')), 'sort', 'asc');
		if(!empty($data['group']))
			$data['banner_btn'] = true;

		$data['banner'] = $this -> mod_banner -> inner_join_order_by('ebanner', 'auth_category', array('ebanner.*', 'auth_category.c_name'), array('auth_category.lang_type' => $this->session->userdata('lang'), 'ebanner.lang_type' => $this -> session -> userdata('lang')), 'category_id', 'ebanner.sort', 'asc');
		$data['path'] = '/uploads/000/000/0000/0000000000/banner/';
		$this -> load -> view('admin/system_center/banner/list', $data);
	}

	public function group_add()
	{
		$response = array('recode', 'result', 'retext');
		$group_name = $this -> input -> post('group_name');
		$type = $this -> input -> post('type');
		
		if(!empty($group_name))
		{
			$category = $this -> mod_banner -> select_from('auth_category', array('c_name'), array('c_name' => $group_name, 'lang_type' => $this -> session -> userdata('lang'), 'type' => $type));
			
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
				$this -> mod_banner -> insert_into('auth_category', array('c_name' => $group_name, 'type' => $type, 'lang_type' => $this->session->userdata('lang'), 'update_time' => date('Y-m-d H:i:s', time())));
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
		$category = $this -> mod_banner -> select_from('auth_category', array('category_id'), array('category_id' => $category_id));
		
		if(!empty($category))
		{
			$uform = $this -> mod_banner -> select_from('ebanner', array('ebanner_id'), array('category_id' => $category['category_id']));
			if(!empty($uform))
			{
				$response_array['result'] = false;
				$response_array['message'] = 'To use';
			}
			else
			{
				$this -> mod_banner -> delete_where('auth_category', array('category_id' => $category_id));
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
		if ($data['edit'] = $this -> mod_banner -> stretch($type, $id))
		{
		}
		else
			show_error('錯誤連結', '404', 'Error');

		$this -> load -> view('admin/system_center/banner/edit', $data);
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
			$this -> mod_banner -> update_set($table, $target, $update_data);
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
		$img_url = './uploads/000/000/0000/0000000000/banner/';
		
		if(is_array($ck_array) && is_array($del_array))
		{
			$del_data = array_intersect($del_array, $ck_array);
			$update_id = array();
			foreach ($del_data as $key => $value)
			{	
				$banner = $this -> mod_banner -> select_from('ebanner', array('filename'), array('ebanner_id' => $value));
				unlink($img_url.$banner['filename']);
				$this -> mod_banner -> delete_where('ebanner', array('ebanner_id' => $value));
			}
			$this -> script_message('刪除成功', '/banner/main/' . $type);
		}
		else
			$this -> script_message('請勾選您要刪除的筆數', '/banner/main/' . $type);
	}

	public function ebanner($opr = '', $success = '', $id = '')
	{
		$this -> load -> model('business_model', 'mod_business');
		//判斷帳號是否session
		/*if(!$this->session->userdata('member_id'))
		{	
			//未登入
			$this->myredirect('/index/login', '請先登入', 5);
			return 0;
		}
		else
		{*/
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

			$data['category'] = $this -> mod_banner -> select_from('auth_category', array('category_id', 'c_name'), array('type' => '10', 'lang_type' => $this -> session -> userdata('lang')), 'array');
			
			//folder
			$data['img_url'] = $img_url = './uploads/000/000/0000/0000000000/banner/';

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
						$this -> lang -> load('views/ebanner/add', $data['lang']);
						$data['ShareCertificatesName'] = lang('ShareCertificatesName');
						$data['ShareCertificatesPicture'] = lang('ShareCertificatesPicture');
						$data['TellFriendVoucher'] = lang('TellFriendVoucher');
						$data['Cancel'] = lang('Cancel');
						$data['Message'] = lang('Message');
						$data['Must32Char'] = lang('Must32Char');
						$data['Just3MB'] = lang('Just3MB');
						$data['Added'] = lang('Added');
						$data['_Addbanner'] = lang('_Addbanner');
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
						$this->load->view('admin/system_center/banner/banner_add', $data);
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
							if($_FILES['banner']['error'] != 4)
								$banner = $this->mod_upload->upload_single_image($img_url, $_FILES['banner']);
						}
						$insert_data = array(
							'category_id' => $this->input->post('category_id'),
							'name' 		=> $this->input->post('name'),
							'filename' 	=> $banner['path'],
							'content' 	=> $this->input->post('content'),
							'lang_type' => $this -> session -> userdata('lang'),
							'jump_page' => $this->input->post('jump_page')
						);
						$ebanner_id = $this->mod_business->insert_into('ebanner', $insert_data);

						//返回
						redirect('/banner/ebanner/add/1');
					}
					break;

				case 'edit':
					$data['edit_ebanner'] = $this->mod_business->select_from('ebanner', array('ebanner_id'=>$id));
			
					if(!$this->input->post('edit'))
					{
						if($success == 1)
						{
							$data['success'] = $success;
						}
						
						$this -> lang -> load('views/ebanner/edit', $data['lang']);
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
						$this->load->view('admin/system_center/banner/banner_edit', $data);
					}
					else
					{
						$update_data = array(
							'category_id' => $this->input->post('category_id'),
							'name' 		=> $this->input->post('name'),
							'content' 	=> $this->input->post('content'),
							'jump_page' => $this->input->post('jump_page')
						);

						//圖檔上傳
						if(!empty($_FILES))
						{
							//model
							$this->load->model('upload_model', 'mod_upload');

							//image file
							if($_FILES['banner']['error'] != 4)
							{
								unlink($img_url.$data['edit_ebanner']['filename']);
								$banner = $this->mod_upload->upload_single_image($img_url, $_FILES['banner']);
								$update_data['filename'] = $banner['path'];
							}
						}

						$ebanner_id = $this->mod_business->update_set('ebanner', 'ebanner_id', $id, $update_data);

						//返回
						redirect('/banner/ebanner/edit/1');
					}

					break;

				case 'delete':

                    //banner
					$delete_banner = $this->mod_business->select_from('ebanner', array('ebanner_id'=>$id));
					unlink($img_url.$delete_banner['filename']);
					$this->mod_business->delete_where('ebanner', array('ebanner_id'=>$id));
			
					//返回
					redirect('/banner/main');

					break;


				case 'hidden':

                    //banner
					$delete_banner = $this->mod_business->select_from('ebanner', array('ebanner_id'=>$id));
					$this->mod_business->update_set('ebanner', 'ebanner_id', $id, array('hidden' => 'Y'));

					//返回
					redirect('/banner/main');

					break;

				case 'show':

                    //banner
					$delete_banner = $this->mod_business->select_from('ebanner', array('ebanner_id'=>$id));
					$this->mod_business->update_set('ebanner', 'ebanner_id', $id, array('hidden' => 'N'));

					//返回
					redirect('/banner/main');

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
					$data['bannerhare'] = lang('bannerhare');
					$data['Number'] = lang('Number');
					$data['EditSignUpForm'] = lang('EditSignUpForm');
					$data['Operating'] = lang('Operating');

					//view
					$this->load->view('banner/main', $data);
					break;
			}
		//}
	}

	public function sort_save()
	{
		$ck_array = $this -> input -> post('ck_id');
		$type = $this -> input -> post('type');
		if ($this -> mod_banner -> sort_action($ck_array))
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
	public function my_ebanner($mid, $eid)
	{
		//member
		$member = $this->mod_business->select_from('member', array('member_id'=>$mid));
		$member['img_url'] = '.uploads/000/000/0000/0000000000/';
		if(!empty($member))
		{
			//data
			$data = $this -> data;
			$this -> lang -> load('views/ebanner/show', $data['lang']); 
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
			$data['img_url'] = $img_url = '.'.$member['img_url'].'banner/';
			$data['my_e_banner'] = $this->mod_business->select_from('ebanner', array('ebanner_id'=>$eid));

			// mode 資料庫修正
			if($data['my_e_banner']['mode'] == 1)
			{
				if(empty($data['my_e_banner']['mode_1']))
				{
					$data['my_e_banner']['mode_1'] = base_url() . 'app/route/' .$member['member_id'];
					$this->mod_business->update_set('ebanner', 'ebanner_id', $eid, array('mode_1' => $data['my_e_banner']['mode_1']));
				}
			}

			if($this->session->userdata('web_return'))
				$data['web_return'] = base_url().'business/iqr/'.$this->session->userdata('web_return'); //web return
			else
				$data['web_return'] = $data['iqr_url'] ;
			
			//view
			$this->load->view('ebanner/show', $data);
		}
	}
}
