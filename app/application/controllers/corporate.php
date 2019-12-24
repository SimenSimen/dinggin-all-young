<?php
class Corporate extends MY_Controller
{
	public $message = '';
	public $data = '';
	private $ck_path = '/uploads/000/000/0000/0000000000/ckfinder_image';
	public $lang = '';
	public function __construct()
	{
		parent::__construct();

		if(!$this -> session -> userdata('lang'))
		{
			$this -> session -> set_userdata('lang', 'TW');
		}

		// helper
        $this->load->helper('url');

        //model
		$this->load->model('admin_model', 'mod_admin');
		$this->load-> model('corporate_model', 'mod_cpr');
		$this -> load -> model('eform_model', 'mod_eform');

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

		// ckeditor
		$this -> member_id = $this -> session -> userdata('member_id');
		$member = $this -> mod_cpr -> select_from('member', array('img_url', 'auth', 'domain_id'), array('member_id' => $this -> member_id));
		$this -> extend_ckupload_time(3600, $this -> member_id, $this -> ck_path, $member['auth'], $member['domain_id']);

		//web config
		// $this->data['web_config']=$this->get_web_config($this->session->userdata('session_domain'));

		$this->load->library('/mylib/useful');
	}

	public function main($type = '')
	{
		// 權限判斷
		switch ($type) {
			case '2':
				$type = '2';
				$this->useful->CheckComp('j_news');
				$data['btn_name'] = '新增文章';
				break;
			case '3':
				$type = '3';
				$this->useful->CheckComp('j_service');
				$data['btn_name'] = '新增文章';
				break;
			case '4':
				$type = '4';
				$this->useful->CheckComp('j_video');
				$data['btn_name'] = '新增影音';
				break;
			case '5':
				$type = '5';
				$this->useful->CheckComp('j_net');
				$data['btn_name'] = '新增網址';
				break;
			case '6':
				$type = '6';
				$this->useful->CheckComp('j_annou');
				$data['btn_name'] = '新增公告';
				break;
			default:
				$type = '1';
				$this->useful->CheckComp('j_company');
				$data['btn_name'] = '新增文章';
				break;
		}
		$data['type'] = $type;
		if($type == '4' || $type == '5')
			$data['group'] = $this -> mod_eform -> select_from_order_limit('auth_category', array('c_name', 'category_id'), array('type' => $type, 'lang_type' => $this -> session -> userdata('lang')), 'sort', 'asc');

		if($type == '1' || $type == '2' || $type == '3'|| $type == '6')
			$data['texts'] = $texts = $this -> mod_cpr -> select_from_order_limit('ckeditor', array('ck_id', 'name', 'content','enable'), array('type' => $type,  'lang_type' => $this -> session -> userdata('lang')), 'sort', 'asc');
		else
			$data['texts'] = $texts = $this -> mod_cpr -> inner_join_order_by('ckeditor', 'auth_category',array('ckeditor.*', 'auth_category.c_name'), array('ckeditor.type' => $type,  'ckeditor.lang_type' =>  $this -> session -> userdata('lang'), 'auth_category.lang_type' => $this -> session -> userdata('lang')), 'category_id', 'ckeditor.sort', 'asc', 'array');
		
		foreach($data['texts'] as $key => $val){
			$data['texts'][$key]['enable'] = ($val['enable'] == 0)?'隱藏中':'公開中';
		}
		
		
		$this -> load -> view('/admin/system_center/list', $data);
	}

	// --------------------------------
	// 公司介紹(1), 最新消息(2), 服務專區(3)
	// --------------------------------

	// 最新消息檔案新增
	public function news($opr = '', $success = '', $id = '')
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

			$data['category'] = $this -> mod_coupon -> select_from('auth_category', array('category_id', 'c_name'), array('type' => '2', 'lang_type' => $this -> session -> userdata('lang')), 'array');
			
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

	// 新增
	public function ckeditor_add($type)
	{
		if (!$this -> input -> post('form_submit'))
		{
			$data = $this -> mod_cpr -> category_chk($type);
			$data['back_url'] =  base_url() . 'corporate/main/' . $type;
			$data['type'] = $type;
			$this -> load -> view('/admin/system_center/ckeditor_add', $data);
		}
		else
		{
			if($this -> mod_cpr -> add_action($this -> input -> post()))
				$this -> script_message('新增成功', '/corporate/main/' . $type, 'top');
			else
				$this -> script_message('新增失敗', '/corporate/ckeditor_add/' . $type, 'top');
		}
	}

	// 修改
	public function ckeditor_edit($type, $ck_id)
	{
		if (!$this -> input -> post('form_submit'))
		{
			$data = $this -> mod_cpr -> category_chk($type);
			$data['type'] = $type;
			switch ($type) {
				case '1':
					$data['text'] = $text = $this -> mod_cpr -> select_from('ckeditor', array('*'), array('ck_id' => $ck_id));
					break;
				case '2':
					$data['text'] = $text = $this -> mod_cpr -> inner_join('ckeditor', 'auth_category', array('ckeditor.*', 'auth_category.c_name'), array('ckeditor.ck_id' => $ck_id, 'ckeditor.type' => $type, 'auth_category.lang_type' => $this -> session -> userdata('lang')), 'category_id', 'row');
					break;
				case '3':
					$data['text'] = $text = $this -> mod_cpr -> select_from('ckeditor', array('*'), array('ck_id' => $ck_id));
					break;
				case '6':
					$data['text'] = $text = $this -> mod_cpr -> select_from('ckeditor', array('*'), array('ck_id' => $ck_id));
					break;
				case '4':
					$data['text'] = $text = $this -> mod_cpr -> inner_join('ckeditor', 'auth_category', array('ckeditor.*', 'auth_category.c_name'), array('ckeditor.ck_id' => $ck_id, 'ckeditor.type' => $type, 'auth_category.lang_type' => $this -> session -> userdata('lang')), 'category_id', 'row');
					$data['text']['content'] = 'https://www.youtube.com/embed/' . $data['text']['content'];
					break;
				default:
					$data['text'] = $text = $this -> mod_cpr -> inner_join('ckeditor', 'auth_category', array('ckeditor.*', 'auth_category.c_name'), array('ckeditor.ck_id' => $ck_id, 'ckeditor.type' => $type, 'auth_category.lang_type' => $this -> session -> userdata('lang')), 'category_id', 'row');
					break;
			}
			$data['back_url'] =  base_url() . 'corporate/main/' . $text['type'];
			$this -> load -> view('/admin/system_center/ckeditor_add', $data);
		}
		else
		{
			if($this -> mod_cpr -> update_action($this -> input -> post(), $ck_id))
				$this -> script_message('修改成功', '/corporate/main/' . $type, 'top');
			else
				$this -> script_message('修改失敗', '/corporate/ckeditor_edit/' . $type, 'top');
		}
	}

	// 刪除
	public function ckeditor_del()
	{
		$ck_array = $this -> input -> post('ck_id');
		$del_array = $this -> input -> post('check_id');
		$type = $this -> input -> post('type');

		if(is_array($ck_array) && is_array($del_array))
		{
			$del_data = array_intersect($del_array, $ck_array);
			
			foreach($del_data as $val){
				$this -> mod_cpr -> delete_where('ckeditor',array('ck_id' => $val));
			}
			$this -> script_message('刪除成功', '/corporate/main/' . $type);
		}
		else
			$this -> script_message('請勾選您要刪除的筆數', '/corporate/main/' . $type);
	}

	// 排序
	public function sort_save()
	{
		$ck_array = $this -> input -> post('ck_id');
		$type = $this -> input -> post('type');
		if ($this -> mod_cpr -> sort_action($ck_array))
		{
			$this -> message = '排序修改成功';
			$this -> main($type);
		}
		else
		{
			$this -> message = '';
			$this -> main($type);
		}
	}

	public function group_del()
	{
		$d_category_id = $this -> input -> post('del_id');
		$search_data = $this -> mod_cpr -> select_from('ckeditor', array('*'), array('category_id' => $d_category_id, 'enable' => '1'));
		
		if (!empty($search_data))
			$return = array('re_code' => '000', 're_msg' => '刪除失敗, 目前有資料正在使用此群組');
		else
		{
			$this -> mod_cpr -> delete_where('auth_category', array('category_id' => $d_category_id));
			$return = array('re_code' => '001', 're_msg' => '刪除成功');
		}

		echo json_encode($return);
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
				$update_id[] = $this -> mod_cpr -> update_set('ckeditor', array('ck_id' => $value), array('enable' => $Art_status ));
			}
			$this -> script_message('更改成功', '/corporate/main/' . $type);
		}
		else
			$this -> script_message('請選擇筆數或狀態', '/corporate/main/' . $type);
		
	}
	
}