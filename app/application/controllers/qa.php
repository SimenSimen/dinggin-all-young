<?php
class Qa extends MY_Controller
{
	public $language = '', $data = '';
	function __construct()
	{
		parent::__construct();
		$this -> load -> model('qa_model', 'mod_news');

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

		$this->useful->CheckComp('j_news');

		$this->mode_function='qa';
	}

	public function main()
	{
		$data['type'] = $type = '2';
		$data['group'] = $this -> mod_news -> select_from_order_limit('q_and_a_group', array('qaag_id', 'qaag_name'), array('type' => $type, 'lang_type' => $this->session->userdata('lang')), 'sort', 'asc');
		if(!empty($data['group']))
			$data['news_btn'] = true;

		$data['news'] = $this -> mod_news -> inner_join_order_by('q_and_a', 'q_and_a_group', array('q_and_a.*', 'q_and_a_group.qaag_name'), array('q_and_a_group.type' =>$type, 'q_and_a_group.lang_type' => $this->session->userdata('lang'), 'q_and_a.lang_type' => $this -> session -> userdata('lang')), 'qaag_id', 'q_and_a.sort', 'asc');
		
		foreach($data['news'] as $key => $val){
			$data['news'][$key]['enable'] = ($val['enable'] == 0)?'隱藏中':'公開中';
		}
		
		$this -> load -> view('admin/system_center/qa/list', $data);
	}

	public function group_add()
	{
		$response = array('recode', 'result', 'retext');
		$group_name = $this -> input -> post('group_name');
		$type = $this -> input -> post('type');
		
		if(!empty($group_name))
		{
			$category = $this -> mod_news -> select_from('q_and_a_group', array('qaag_name'), array('qaag_name' => $group_name, 'lang_type' => $this -> session -> userdata('lang'), 'type' => $type));
			
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
				$this -> mod_news -> insert_into('q_and_a_group', array('qaag_name' => $group_name, 'type' => $type, 'lang_type' => $this->session->userdata('lang'), 'update_time' => date('Y-m-d H:i:s', time())));
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
		$category = $this -> mod_news -> select_from('q_and_a_group', array('qaag_id'), array('qaag_id' => $category_id));
		
		if(!empty($category))
		{
			$uform = $this -> mod_news -> select_from('q_and_a', array('qaa_id'), array('qaag_id' => $category['qaag_id']));
			if(!empty($uform))
			{
				$response_array['result'] = false;
				$response_array['message'] = 'To use';
			}
			else
			{
				$this -> mod_news -> delete_where('q_and_a_group', array('qaag_id' => $category_id));
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
		if ($data['edit'] = $this -> mod_news -> stretch($type, $id))
		{
		}
		else
			show_error('錯誤連結', '404', 'Error');

		$this -> load -> view('admin/system_center/qa/edit', $data);
	}

	public function con_edit()
	{
		$edit_name = $this -> input -> post('edit_name');
		$id = $this -> input -> post('edit_id');
		$type = $this -> input -> post('type');

		switch ($type) {
			case 'g':
				$table = 'q_and_a_group';
				$target = array('qaag_id' => $id);
				$update_data = array('qaag_name' => $edit_name, 'update_time' => date('Y-m-d H:i:s', time()), 'lang_type' => $this->session->userdata('lang'));
				break;
		}

		if (isset($edit_name) && !empty($edit_name))
		{
			$this -> mod_news -> update_set($table, $target, $update_data);
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
				$this -> mod_news -> delete_where('q_and_a', array('qaa_id' => $value));
			}
			$this -> script_message('刪除成功', '/qa/main/' . $type);
		}
		else
			$this -> script_message('請勾選您要刪除的筆數', '/qa/main/' . $type);
	}

	public function enews($opr = '', $success = '', $id = '')
	{
		$this -> load -> model('business_model', 'mod_business');
		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{
			//未登入
			$this->myredirect('/index/login', '請先登入', 5);
			return 0;
		}
		
			$data = $this -> data;
			$language = $this -> language;
			//member
			// $member = $this->mod_business->select_from('member', array('member_id'=>$this->session->userdata('member_id')));

			//延長ckeditor上傳時間
			//$this->extend_ckupload_time(3600, 1, '/uploads/000/000/0000/0000000000/ckfinder_image', 00, 0);

            //member
            $iqr = $this->mod_business->select_from('iqr', array('member_id'=>1));

			//helper
			$this->load->helper('form');

			//account
			$data['account'] = $member['account'];
			$data['mid'] 	 = 1;

			$data['category'] = $this -> mod_news -> select_from('q_and_a_group', array('qaag_id', 'qaag_name'), array('type' => '2', 'lang_type' => $this -> session -> userdata('lang')), 'array');
			
			//folder
			$data['img_url'] = $img_url = './uploads/000/000/0000/0000000000/news/';

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
						$this -> lang -> load('views/enews/add', $data['lang']);
						$data['ShareCertificatesName'] = lang('ShareCertificatesName');
						$data['ShareCertificatesPicture'] = lang('ShareCertificatesPicture');
						$data['TellFriendVoucher'] = lang('TellFriendVoucher');
						$data['Cancel'] = lang('Cancel');
						$data['Message'] = lang('Message');
						$data['Must32Char'] = lang('Must32Char');
						$data['Just3MB'] = lang('Just3MB');
						$data['Added'] = lang('Added');
						$data['_AddNews'] = lang('_AddNews');
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
						$this->load->view('admin/system_center/qa/news_add', $data);
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
							if($_FILES['news']['error'] != 4)
								$news = $this->mod_upload->upload_single_image($img_url, $_FILES['news']);
						}
						$content=$this->input->post('content');
						$content=str_replace('youtube.com/watch?v=','youtube.com/embed/',$content);
						$insert_data = array(
							'qaag_id' => $this->input->post('category_id'),
							'qaa_title' 		=> $this->input->post('name'),
							'qaa_content' 	=> $content,
							'lang_type' => $this -> session -> userdata('lang'),
							'enable'	=> $this ->input->post('news_enable'),
							'create_time'    => $this->useful->get_now_time(),
							'update_time'    => $this->useful->get_now_time()
						);
						$enews_id = $this->mod_business->insert_into('q_and_a', $insert_data);

						//返回
						redirect('/qa/enews/add/1');
					}
					break;

				case 'edit':
					$data['edit_enews'] = $this->mod_business->select_from('q_and_a', array('qaa_id'=>$id));
			
					if(!$this->input->post('edit'))
					{
						if($success == 1)
						{
							$data['success'] = $success;
						}
						
						$this -> lang -> load('views/enews/edit', $data['lang']);
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
						$this->load->view('admin/system_center/qa/news_edit', $data);
					}
					else
					{
						$content=$this->input->post('content');
						$content=str_replace('youtube.com/watch?v=','youtube.com/embed/',$content);
						$update_data = array(
							'qaag_id' => $this->input->post('category_id'),
							'qaa_title' 		=> $this->input->post('name'),
							'qaa_content' 	=> $content,
							'enable'    => $this->input->post('news_enable'),
							'update_time'    => $this->useful->get_now_time()
						);

						$enews_id = $this->mod_business->update_set('q_and_a', 'qaa_id', $id, $update_data);

						//返回
						redirect('/qa/enews/edit/1');
					}

					break;

				case 'delete':				
					$delete_news = $this->mod_business->select_from('q_and_a', array('qaa_id'=> $id ));
					$this -> mod_news -> delete_where('q_and_a', array('qaa_id' => $id  ));
					$this -> script_message('刪除成功', '/qa/main/' . $this -> input -> post('type') );
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
					$this->load->view('qa/main', $data);
					break;
			}
		
	}

	public function sort_save()
	{
		$ck_array = $this -> input -> post('ck_id');
		$type = $this -> input -> post('type');
		if ($this -> mod_news -> sort_action($ck_array))
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
	
	//修改多筆狀態
	public function article_status()
	{
		$ck_array = $this -> input -> post('ck_id');
		$del_array = $this -> input -> post('check_id');
		$type = $this -> input -> post('type');
		$Art_status   = $this -> input -> post('article_status');
	
		if(is_array($ck_array) && is_array($del_array) && $Art_status != '#')
		{
			$del_data = array_intersect($del_array, $ck_array);
			$update_id = array();
			foreach ($del_data as $key => $value)
			{
				$update_id[] = $this -> mod_news -> update_set('q_and_a', array('qaa_id' => $value), array('enable' => $Art_status ));
			}
			$this -> script_message('更改成功', '/qa/main/' . $type);
		}
		else
			$this -> script_message('請選擇筆數或狀態', '/qa/main/' . $type);
		
	}
	
	
}