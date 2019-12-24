<?php
class Menu extends MY_Controller
{
	public $message = '';
	function __construct()
	{
		parent::__construct();

		// helper
        $this -> load -> helper('url');

        $this -> load -> library('/mylib/useful');

        $this -> load -> model('menu_model', 'mod_menu');

        if(!$this -> session -> userdata('lang'))
		{
			$this -> session -> set_userdata('lang', 'TW');
		}
	}

	public function menu_setting()
	{

		$this -> useful -> CheckComp('j_menu');
		if($this -> input -> post('form_submit'))
		{
			$this -> event_setting($this -> input -> post());
			$this -> script_message($this -> message);
		}

		$data['icon_link_type'] = $this -> mod_menu -> select_from_order_limit('icon_link_type', array('d_id', 'd_title', 'd_link', 'd_enable'), array('default_active' => 1),'d_sort','','');
		foreach ($data['icon_link_type'] as $key => $value) {
			$data['icon_link_type'][$key]['selected_open'] = ($value['d_enable'] == 'Y') ? 'checked' : '';
			$data['icon_link_type'][$key]['selected_close'] = ($value['d_enable'] == 'N') ? 'checked' : '';
		}
		

		$data['menu_link_type'] = $this -> mod_menu -> select_from_order_limit('menu_link_type', array('d_id', 'd_title', 'd_link', 'd_enable'), array('default_active' => 1),'d_sort','','');
		foreach ($data['menu_link_type'] as $key => $value) {
			$data['menu_link_type'][$key]['selected_open'] = ($value['d_enable'] == 'Y') ? 'checked' : '';
			$data['menu_link_type'][$key]['selected_close'] = ($value['d_enable'] == 'N') ? 'checked' : '';
		}
		
		$data['bottom_link_type'] = $this -> mod_menu -> select_from_order_limit('bottom_link_type', array('d_id', 'd_title', 'd_link', 'd_enable'), array('default_active' => 1),'d_sort','','');
		foreach ($data['bottom_link_type'] as $key => $value) {
			$data['bottom_link_type'][$key]['selected_open'] = ($value['d_enable'] == 'Y') ? 'checked' : '';
			$data['bottom_link_type'][$key]['selected_close'] = ($value['d_enable'] == 'N') ? 'checked' : '';
		}
		
		$data['mobile_link_type'] = $this -> mod_menu -> select_from_order_limit('mobile_link_type', array('d_id', 'd_title', 'd_link', 'd_enable'), array('default_active' => 1),'d_sort','','');
		foreach ($data['mobile_link_type'] as $key => $value) {
			$data['mobile_link_type'][$key]['selected_open'] = ($value['d_enable'] == 'Y') ? 'checked' : '';
			$data['mobile_link_type'][$key]['selected_close'] = ($value['d_enable'] == 'N') ? 'checked' : '';
		}
		
		$this -> load -> view('admin' .DIRECTORY_SEPARATOR. 'system_center' .DIRECTORY_SEPARATOR. 'menu' .DIRECTORY_SEPARATOR. 'menu_setting', $data);
	}

	private function event_setting($post)
	{
		// menu_type update
		if(!empty($post['icon_link'])){
			foreach ($post['icon_link'] as $key => $value) {
				$update_id=$this -> mod_menu -> update_set('icon_link_type', array('d_id' => $key), array('d_enable' => $value));
			}
		}

		if(!empty($post['menu_link'])){
			foreach ($post['menu_link'] as $key => $value) {
				$update_id=$this -> mod_menu -> update_set('menu_link_type', array('d_id' => $key), array('d_enable' => $value));
			}
		}

		if(!empty($post['bottom_link'])){
			foreach ($post['bottom_link'] as $key => $value) {
				$update_id=$this -> mod_menu -> update_set('bottom_link_type', array('d_id' => $key), array('d_enable' => $value));
			}
		}

		if(!empty($post['mobile_link'])){
			foreach ($post['mobile_link'] as $key => $value) {
				$update_id=$this -> mod_menu -> update_set('mobile_link_type', array('d_id' => $key), array('d_enable' => $value));
			}
		}
		

		if($update_id)
			$this -> message = '編輯成功';
		else
			$this -> message = '編輯失敗';
	}
	
	public function emenu($opr = '', $success = '', $id = '')
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

			$data['category'] = $this -> mod_news -> select_from('auth_category', array('category_id', 'c_name'), array('type' => '2', 'lang_type' => $this -> session -> userdata('lang')), 'array');
			
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
						$this->load->view('admin/system_center/news/news_add', $data);
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
						$insert_data = array(
							'category_id' => $this->input->post('category_id'),
							'name' 		=> $this->input->post('name'),
							'filename' 	=> $news['path'],
							'content' 	=> $this->input->post('content'),
							'lang_type' => $this -> session -> userdata('lang')
						);
						$enews_id = $this->mod_business->insert_into('enews', $insert_data);

						//返回
						redirect('/news/enews/add/1');
					}
					break;

				case 'edit':
					$data['edit_enews'] = $this->mod_business->select_from('enews', array('enews_id'=>$id));
			
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
						$this->load->view('admin/system_center/news/news_edit', $data);
					}
					else
					{
						$update_data = array(
							'category_id' => $this->input->post('category_id'),
							'name' 		=> $this->input->post('name'),
							'content' 	=> $this->input->post('content'),
						);

						//圖檔上傳
						if(!empty($_FILES))
						{
							//model
							$this->load->model('upload_model', 'mod_upload');

							//image file
							if($_FILES['news']['error'] != 4)
							{
								unlink($img_url.$data['edit_enews']['filename']);
								$news = $this->mod_upload->upload_single_image($img_url, $_FILES['news']);
								$update_data['filename'] = $news['path'];
							}
						}

						$enews_id = $this->mod_business->update_set('enews', 'enews_id', $id, $update_data);

						//返回
						redirect('/news/enews/edit/1');
					}

					break;

				case 'delete':

                    //news
					$delete_news = $this->mod_business->select_from('enews', array('enews_id'=>$id));
					unlink($img_url.$delete_news['filename']);
					$this->mod_business->delete_where('enews', array('enews_id'=>$id));
			
					//返回
					redirect('/news/main');

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
					$this->load->view('news/main', $data);
					break;
			}
		}
	}
	
	public function sort1_save()
	{
		$ck_array = $this -> input -> post('ck_id1');
		if ($this -> mod_menu -> sort1_action($ck_array))
		{
			$this -> message = '排序修改成功';
			$this -> menu_setting();
		}
		else
		{
			$this -> message = '';
			$this -> menu_setting();
		}
	}
	
	public function sort2_save()
	{
		$ck_array = $this -> input -> post('ck_id2');
		if ($this -> mod_menu -> sort2_action($ck_array))
		{
			$this -> message = '排序修改成功';
			$this -> menu_setting();
		}
		else
		{
			$this -> message = '';
			$this -> menu_setting();
		}
	}
	
	public function sort3_save()
	{
		$ck_array = $this -> input -> post('ck_id3');
		if ($this -> mod_menu -> sort3_action($ck_array))
		{
			$this -> message = '排序修改成功';
			$this -> menu_setting();
		}
		else
		{
			$this -> message = '';
			$this -> menu_setting();
		}
	}
	
	public function sort4_save()
	{
		$ck_array = $this -> input -> post('ck_id4');
		if ($this -> mod_menu -> sort4_action($ck_array))
		{
			$this -> message = '排序修改成功';
			$this -> menu_setting();
		}
		else
		{
			$this -> message = '';
			$this -> menu_setting();
		}
	}

	public function sort5_save()
	{
		$ck_array = $this -> input -> post('ck_id5');
		if ($this -> mod_menu -> sort5_action($ck_array))
		{
			$this -> message = '排序修改成功';
			$this -> menu_setting();
		}
		else
		{
			$this -> message = '';
			$this -> menu_setting();
		}
	}
}