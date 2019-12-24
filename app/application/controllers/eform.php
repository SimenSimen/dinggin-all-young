<?php
class Eform extends MY_Controller
{
	public $message, $data, $language = '';
	function __construct()
	{
		parent::__construct();
		$this -> load -> model('eform_model', 'mod_eform');

		$this -> load -> helper('language');
		if(!$this -> session -> userdata('lang'))
		{
			$this -> session -> set_userdata('lang', 'TW');
			$this -> data['lang'] = $this -> session -> userdata('lang');
		}
		else
			$this -> data['lang'] = $this -> session -> userdata('lang');

		$this -> load -> library('/mylib/useful');
	}

	public function main($type = '')
	{
		switch ($type) {
			default:
				$this->useful->CheckComp('j_action');
				$data['type'] = $type = '7';
				break;
		}

		$data['group'] = $this -> mod_eform -> select_from_order_limit('auth_category', array('c_name', 'category_id'), array('type' => $type, 'lang_type' => $this -> session -> userdata('lang')), 'sort', 'asc');
		$data['form'] = $this -> mod_eform -> inner_join_order_by('uform', 'auth_category', array('uform.*', 'auth_category.c_name'), array('uform.lang_type' => $this -> session -> userdata('lang'), 'auth_category.lang_type' => $this -> session -> userdata('lang')), 'category_id', 'uform.sort', 'asc');
		if(empty($data['group']))
			$data['form_btn'] = false;
		else
			$data['form_btn'] = true;
		
		foreach($data['form'] as $key => $val){
			$data['form'][$key]['enable'] = ($val['enable'] == 0)?'隱藏中':'公開中';
		}
	
		$this -> load -> view('admin/system_center/form/list', $data);
	}

	public function group_add()
	{
		$response = array('recode', 'result', 'retext');
		$group_name = $this -> input -> post('group_name');
		$type = $this -> input -> post('type');
		
		if(!empty($group_name))
		{
			$category = $this -> mod_eform -> select_from('auth_category', array('c_name'), array('c_name' => $group_name, 'type' => $type, 'lang_type' => $this -> session -> userdata('lang')));
			
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
				$this -> mod_eform -> insert_into('auth_category', array('c_name' => $group_name, 'type' => $type, 'update_time' => date('Y-m-d H:i:s', time()), 'lang_type' => $this -> session -> userdata('lang')));
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
		$category = $this -> mod_eform -> select_from('auth_category', array('category_id'), array('category_id' => $category_id));
		
		if(!empty($category))
		{
			$uform = $this -> mod_eform -> select_from('uform', array('ufm_id'), array('category_id' => $category['category_id']));
			if(!empty($uform))
			{
				$response_array['result'] = false;
				$response_array['message'] = 'To use';
			}
			else
			{
				$this -> mod_eform -> delete_where('auth_category', array('category_id' => $category_id));
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

	public function del_video_group()
	{
		$response_array = array('result', 'message');
		$category_id = ($this -> input -> post('id')) ? $this -> input -> post('id') : '';
		$category = $this -> mod_eform -> select_from('auth_category', array('category_id'), array('category_id' => $category_id));
		
		if(!empty($category))
		{
			$uform = $this -> mod_eform -> select_from('ckeditor', array('ck_id'), array('category_id' => $category['category_id']));
			if(!empty($uform))
			{
				$response_array['result'] = false;
				$response_array['message'] = 'To use';
			}
			else
			{
				$this -> mod_eform -> delete_where('auth_category', array('category_id' => $category_id));
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

	public function sort_save()
	{
		// 權限判斷
		$this->useful->CheckComp('j_member');

		$ck_array = $this -> input -> post('ck_id');
		$type = $this -> input -> post('type');
		if ($this -> mod_eform -> sort_action($ck_array))
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

	public function edit($type, $id)
	{
		$data['type'] = $type;
		if ($data['edit'] = $this -> mod_eform -> stretch($type, $id))
		{
		}
		else
			show_error('錯誤連結', '404', 'Error');

		$this -> load -> view('admin/system_center/form/edit', $data);
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
				$update_data = array('c_name' => $edit_name, 'update_time' => date('Y-m-d H:i:s', time()));
				break;
			case 'd':
				$table = 'auth_category';
				$target = array('category_id' => $id);
				$update_data = array('c_name' => $edit_name, 'update_time' => date('Y-m-d H:i:s', time()));
				break;
			case 'e':
				$table = 'auth_category';
				$target = array('category_id' => $id);
				$update_data = array('c_name' => $edit_name, 'update_time' => date('Y-m-d H:i:s', time()));
				break;
		}

		if (isset($edit_name) && !empty($edit_name))
		{
			$this -> mod_eform -> update_set($table, $target, $update_data);
			// $this -> main();
			switch ($type) {
				case 'g':
					echo '<script>window.location.href="/eform/main"</script>';
				case 'd':
					echo '<script>window.location.href="/corporate/main/4"</script>';
				case 'e':
					echo '<script>window.location.href="/corporate/main/5"</script>';
			}
		}
		else
			$this -> edit($type, $id);
	}

	// 刪除
	public function form_del()
	{
		$ck_array = $this -> input -> post('ck_id');
		$del_array = $this -> input -> post('check_id');
		$type = $this -> input -> post('type');

		if(is_array($ck_array) && is_array($del_array))
		{
			$del_data = array_intersect($del_array, $ck_array);
			$update_id = array();
			foreach ($del_data as $key => $value) {
				$this -> mod_eform -> delete_where('uform', array('ufm_id' => $value));
			}
			$this -> script_message('刪除成功', '/eform/main/' . $type);
		}
		else
			$this -> script_message('請勾選您要刪除的筆數', '/eform/main/' . $type);
	}

	public function uform_add($success='')
	{
		$this -> load -> model('business_model', 'mod_business');
		$language = $this -> language;
		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{	
			//未登入
			$this->myredirect('/index/login', '請重新登入', 5);
			return 0;
		}
		else
		{
			//data
			$data=$this->data;

			$this -> lang -> load('views/business/uform_add', $data['lang']);
			$data['CheckLeft'] = lang('CheckLeft');
			$data['DownloadApp'] = lang('DownloadApp');
			$data['ClassType'] = lang('ClassType');
			$data['CanDragSequence'] = lang('CanDragSequence');
			$data['RequiredPhone'] = lang('RequiredPhone');
			$data['RequiredName'] = lang('RequiredName');
			$data['RequiredEmail'] = lang('RequiredEmail');
			$data['NoClass'] = lang('NoClass');
			$data['FinishAction'] = lang('FinishAction');
			$data['SignUpFinish'] = lang('SignUpFinish');
			$data['FixedFieldName'] = lang('FixedFieldName');
			$data['ActivityName'] = lang('ActivityName');
			$data['ActivityEx'] = lang('ActivityEx');
			$data['NotFilledField'] = lang('NotFilledField');
			$data['PromptStr'] = lang('PromptStr');
			$data['FillActivityEx'] = lang('FillActivityEx');
			$data['Add'] = lang('Add');
			$data['AddSignUpForm'] = lang('AddSignUpForm');
			$data['_AddSignUpForm'] = lang('_AddSignUpForm');
			$data['SetPromptStr'] = lang('SetPromptStr');
			$data['ColumnPosition'] = lang('ColumnPosition');
			$data['AddSuccess'] = lang('AddSuccess');
			$data['Cancel'] = lang('Cancel');

			//member
			$member = $this->mod_business->select_from('member', array('member_id'=>$this->session->userdata('member_id')));

			if(!$this->input->post('form_submit'))
			{
				//新增完成
				$data['success']=$success;

				//member_id
				$data['member_id'] = 0;

				//延長ckeditor上傳時間
				$this->extend_ckupload_time(3600, 0, '/uploads/000/000/0000/0000000000/ckfinder_image', 00, 0);

				//form item
				$data['form_item']=$this->mod_business->select_from_order('form_item', 'item_id', 'asc');

				// uform category
				$data['uform_category'] = $category = $this -> mod_eform -> select_from('auth_category', array('category_id as cid', 'c_name as name'), array('type' => '7', 'lang_type' => $this -> session -> userdata('lang')), 'array');

				//view
				$this->load->view('admin/system_center/form/form_add', $data);
			}
			else
			{
				//固定欄位設定
				$temp_ufm_col_name[] = ($this->input->post('ufm_col_0') != '') ? $this->input->post('ufm_col_0') : '姓名';
				$temp_ufm_col_name[] = ($this->input->post('ufm_col_1') != '') ? $this->input->post('ufm_col_1') : '電話';
				$temp_ufm_col_name[] = ($this->input->post('ufm_col_2') != '') ? $this->input->post('ufm_col_2') : '信箱';

				$item=$this->input->post('item');

				if(!empty($item['type']))
				{
					$content_num=0;
					foreach($item['type'] as $key => $value)
					{
						if($value == 3 || $value == 4 || $value == 5)
						{//多值項目
							if(trim($item['content'][$content_num]) != '')
							{
								if($item['name'][$key] != '')
								{
									$temp_ufm_col_key[]=$key;
									$temp_ufm_col_name[]=$item['name'][$key];
									$temp_ufm_col_content[]=$value.';'.trim($item['content'][$content_num]);
									if(!empty($item['required']))
										$temp_ufm_col_required[]=(in_array($key, $item['required'])) ? 1 : 0;
								}
							}
							$content_num++;
						}
						else
						{//單值項目
							if($item['name'][$key] != '')
							{
								$temp_ufm_col_key[]=$key;
								$temp_ufm_col_name[]=$item['name'][$key];
								$temp_ufm_col_content[]=$value.';n';
								if(!empty($item['required']))
									$temp_ufm_col_required[]=(in_array($key, $item['required'])) ? 1 : 0;
							}
						}
					}
				}

				//寫入DB
				$ufm_col_name 	 = $this->set_serialstr($temp_ufm_col_name, '*#');
				$ufm_col_content = $this->set_serialstr($temp_ufm_col_content, '*#');
				if(!empty($item['required']))
					$ufm_col_required = $this->set_serialstr($temp_ufm_col_required, '*#');
				else
					$ufm_col_required = '';
				$uform_data=array(
					'ufm_name' 			=> $this->input->post('ufm_name'),
					'category_id'       => $this->input->post('ufm_cid'),
					'ufm_aim'  			=> $this->input->post('ufm_aim'),
					'ufm_col_name' 		=> $ufm_col_name,
					'ufm_col_content' 	=> $ufm_col_content,
					'ufm_col_required' 	=> $ufm_col_required,
					'ufm_mode'			=> $this->input->post('ufm_mode'),
					'ufm_status' 		=> 1,
					'ufm_msg' 			=> $this->input->post('ufm_msg'),
					'ufm_col_num'		=> count($temp_ufm_col_name),
					'member_id' 		=> 0,
					'lang_type'			=> $this->session->userdata('lang'),
					'enable'			=> $this->input->post('ufm_enable')
				);
				$ufm_id=$this->mod_business->insert_into('uform', $uform_data);

	            $this -> script_message('新增成功', '/eform/main', 'top');
			}
		}
	}

	public function uform_sign_up_show($ufm_id='', $mail_mid='')
	{
		$this -> load -> model('business_model', 'mod_business');
		if($ufm_id != '')
		{
			//data
			$data=$this->data;

			$this -> lang -> load('views/business/uform_sign_up_show', $data['lang']);
			$data['PhoneQuickView'] = lang('PhoneQuickView');
			$data['NoAnyPeople'] = lang('NoAnyPeople');
			$data['FromSituation'] = lang('FromSituation');
			$data['HoldDataBox'] = lang('HoldDataBox');
			$data['SignUpSource'] = lang('SignUpSource');
			$data['_SignUpEnrollment'] = lang('_SignUpEnrollment');
			$data['ExportReport'] = lang('ExportReport');

			//裝置
			$data['device']=$this->get_device_type();

			//id
			$pos=strpos($ufm_id, 'p_');
			$data['ufm_id']=$ufm_id=substr($ufm_id, $pos+2);

			//uform資料
			$data['ufm']=$ufm=$this->mod_business->select_from('uform', array('ufm_id'=>$ufm_id));

			//確認表單擁有者與名片擁有者在同網域中
			$ufm_domain=$this->mod_index->select_from('member', array('member_id'=>$ufm['member_id']));
			$mail_domain=$this->mod_index->select_from('member', array('member_id'=>$mail_mid));
			if($mail_domain['domain_id'] != $ufm_domain['domain_id'])
			{
				redirect('/index/error');
			}
			
			//判斷表單擁有者與引用關係
			if($mail_mid != '')
			{
				$card_owner = $mail_mid;
				//mid
				$data['mid']= $mail_mid;
			}
			else
			{
				$card_owner = $this->session->userdata('member_id');
				//mid
				$data['mid']= $this->session->userdata('member_id');
			}
			if($card_owner != $ufm['member_id'])
			{//引用表單，僅show屬於自己的名單
				$ufm_data=$this->mod_business->select_from_order('uform_signup', 'ufms_id', 'desc', array('ufm_id'=>$ufm_id, 'card_owner'=>$card_owner));
			}
			else
			{
				$ufm_data=$this->mod_business->select_from_order('uform_signup', 'ufms_id', 'desc', array('ufm_id'=>$ufm_id));
			}

			//title
			$data['title_array']=$this->get_serialstr($ufm['ufm_col_name'], '*#');

			//顯示報名來源
			if($data['user_auth'] == '01')
			{
				$data['card_owner_show']=true;
			}
			else
			{
				$data['card_owner_show']=false;
			}
			
			//data
			$temp_ufm_col_content=$this->get_serialstr($ufm['ufm_col_content'], '*#');
			if(!empty($temp_ufm_col_content))
			{
				foreach($temp_ufm_col_content as $key => $value)
				{
					$ufm_content[$key]=explode(';', $value);
				}
			}
			if(!empty($ufm_data))
			{
				foreach($ufm_data as $key => $value)
				{
					$data['data_array'][$key]=$this->get_serialstr($value['ufms_result'], '*#');

					foreach($data['data_array'][$key] as $d_key => $d_value)
					{
						if($d_key > 2)
						{
							if($ufm_content[($d_key-3)][0] == 5)
							{
								$new_data=$this->get_serialstr($d_value, '*#');
								$data['data_array'][$key][$d_key]='';
								if(!empty($new_data))
								{
									foreach($new_data as $nd_key => $nd_value)
									{
										$data['data_array'][$key][$d_key].=$nd_value.'. '.$ufm_content[($d_key-3)][$nd_value].'<br>';
									}
								}
							}
							if($ufm_content[($d_key-3)][0] == 3 || $ufm_content[($d_key-3)][0] == 4)
							{
								$data['data_array'][$key][$d_key]=$ufm_content[($d_key-3)][$d_value];
							}
						}
					}

					//報名來源
					if($data['card_owner_show'])
					{
						$iqr=$this->mod_business->select_from('iqr', array('member_id'=>$value['card_owner']));
						$m=$this->mod_business->select_from('member', array('member_id'=>$value['card_owner']));
						$owner=($iqr['f_name'] != '') ? $iqr['l_name'].$iqr['f_name'] : $m['account'];
						array_push($data['data_array'][$key], $owner);
					}
				}
			}

			//view
			$this->load->view('admin/system_center/form/uform_sign_up_show', $data);
		}
		else
		{
			header('Location:'.base_url());
		}
	}

	public function export($ufm_id='', $mail_mid='')
	{
		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{	
			//未登入
			$this->myredirect('/index/login', 'Please Login', 5);
			return 0;
		}
		else
		{
			if($ufm_id != '')
			{
				//data
				$data=$this->data;

				//id
				$pos=strpos($ufm_id, 'p_');
				$data['ufm_id']=$ufm_id=substr($ufm_id, $pos+2);

				//uform資料
				$data['ufm']=$ufm=$this->mod_business->select_from('uform', array('ufm_id'=>$ufm_id));

				//確認表單擁有者與名片擁有者在同網域中
				$ufm_domain=$this->mod_index->select_from('member', array('member_id'=>$ufm['member_id']));
				$mail_domain=$this->mod_index->select_from('member', array('member_id'=>$mail_mid));
				if($mail_domain['domain_id'] != $ufm_domain['domain_id'])
				{
					redirect('/index/error');
				}
				
				//判斷表單擁有者與引用關係
				if($mail_mid != '')
					$card_owner = $mail_mid;
				else
					$card_owner = $this->session->userdata('member_id');
				if($card_owner != $ufm['member_id'])
				{//引用表單，僅show屬於自己的名單
					$ufm_data=$this->mod_business->select_from_order('uform_signup', 'ufms_id', 'desc', array('ufm_id'=>$ufm_id, 'card_owner'=>$card_owner));
				}
				else
				{
					$ufm_data=$this->mod_business->select_from_order('uform_signup', 'ufms_id', 'desc', array('ufm_id'=>$ufm_id));
				}

				//title
				$data['title_array']=$this->get_serialstr($ufm['ufm_col_name'], '*#');
				
				//顯示報名來源
				if($data['user_auth'] == '01')
				{
					$data['card_owner_show']=true;
					array_push($data['title_array'], '報名來源');
				}
				else
				{
					$data['card_owner_show']=false;
				}
				
				//data
				foreach($ufm_data as $key => $value)
				{
					$data['data_array'][]=$this->get_serialstr($value['ufms_result'], '*#');

					//報名來源
					if($data['card_owner_show'])
					{
						$iqr=$this->mod_business->select_from('iqr', array('member_id'=>$value['card_owner']));
						$m=$this->mod_business->select_from('member', array('member_id'=>$value['card_owner']));
						$owner=($iqr['f_name'] != '') ? $iqr['l_name'].$iqr['f_name'] : $m['account'];
						array_push($data['data_array'][$key], $owner);
					}
				}

				$this->export_xls($data['title_array'], $data['data_array'], $ufm['ufm_name']);
			}
			else
			{
				$this -> script_message('Error');
			}
		}
	}

	public function uform_edit($ufm_id='')
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

			$this -> lang -> load('views/business/uform_edit', $data['lang']);
			$data['DropVehicle'] = lang('DropVehicle');
			$data['DropScan'] = lang('DropScan');
			$data['StrCampanyPhone'] = lang('StrCampanyPhone');
			$data['DateBirthday'] = lang('DateBirthday');
			$data['RadioVehicle'] = lang('RadioVehicle');
			$data['RadioScan'] = lang('RadioScan');
			$data['NumberPeopleNum'] = lang('NumberPeopleNum');
			$data['CheckSpecialty'] = lang('CheckSpecialty');
			$data['CheckScan'] = lang('CheckScan');
			$data['CheckLeft'] = lang('CheckLeft');
			$data['DownloadApp'] = lang('DownloadApp');
			$data['ClassType'] = lang('ClassType');
			$data['NotAddField'] = lang('NotAddField');
			$data['CanDragSequence'] = lang('CanDragSequence');
			$data['RequiredPhone'] = lang('RequiredPhone');
			$data['RequiredName'] = lang('RequiredName');
			$data['RequiredEmail'] = lang('RequiredEmail');
			$data['NoClass'] = lang('NoClass');
			$data['FinishAction'] = lang('FinishAction');
			$data['SignUpFinish'] = lang('SignUpFinish');
			$data['Cancle'] = lang('Cancle');
			$data['FixedFieldName'] = lang('FixedFieldName');
			$data['ActivityName'] = lang('ActivityName');
			$data['ActivityEx'] = lang('ActivityEx');
			$data['NotFilledField'] = lang('NotFilledField');
			$data['Vehicle'] = lang('Vehicle');
			$data['Specialty'] = lang('Specialty');
			$data['SureCancleEdit'] = lang('SureCancleEdit');
			$data['Remove'] = lang('Remove');
			$data['PromptStr'] = lang('PromptStr');
			$data['FillActivityEx'] = lang('FillActivityEx');
			$data['Add'] = lang('Add');
			$data['SetPromptStr'] = lang('SetPromptStr');
			$data['EditFinal'] = lang('EditFinal');
			$data['EditSignUpForm'] = lang('EditSignUpForm');
			$data['_EditSignUpForm'] = lang('_EditSignUpForm');
			$data['SaveEdit'] = lang('SaveEdit');
			$data['ColumnPosition'] = lang('ColumnPosition');
			$data['CheckWebUI'] = lang('CheckWebUI');
			$data['AddBlank'] = lang('AddBlank');
			$data['NoSpaceAdd'] = lang('NoSpaceAdd');
			$data['RadioMotorcycleTaxiCar'] = lang('RadioMotorcycleTaxiCar');
			$data['DropMotorcycleTaxiCar'] = lang('DropMotorcycleTaxiCar');
			$data['WebUIValue'] = lang('WebUIValue');
			$data['VehicleValue'] = lang('VehicleValue');

			if($ufm_id != '')
			{
				if(!$this->input->post('form_submit'))
				{
					//延長ckeditor上傳時間
					$this->extend_ckupload_time(3600, 0, '/uploads/000/000/0000/0000000000/ckfinder_image', 00, 0);

					//form item
					$data['form_item']=$this->mod_business->select_from_order('form_item', 'item_id', 'asc');

					//uform
					$data['uform']=$uform=$this->mod_business->select_from('uform', array('ufm_id'=>$ufm_id));
					// uform category
					// $data['uform_category'] = $category = $this -> mod_business -> select_from_order('auth_category', 'update_time', asc, array('type' => 7));
					$data['uform_category'] = $category = $this -> mod_eform -> select_from('auth_category', array('category_id as cid', 'c_name as name'), array('type' => '7', 'lang_type' => $this -> session -> userdata('lang')), 'array');
					foreach ($category as $key => $value)
					{
						$data['uform_category'][$key]['selection'] = ($uform['ufm_cid'] == $value['cid']) ? 'selected' : '' ; 
					}

					//view
					$this->load->view('admin/system_center/form/form_edit', $data);
				}
				else
				{
					foreach ($this->input->post('ufm_col_name') as $key => $value) {
						$ufm_col_name=$ufm_col_name."*#".$value;
					}
					//ufm_id
					$ufm_id = $this -> input -> post('ufm_id');
					$ufm = $this -> mod_eform -> select_from('uform', array('*'), array('ufm_id' => $ufm_id));
					$uform_data=array(
						'ufm_name' 			=> $this->input->post('ufm_name'),
						'category_id'		=> $this->input->post('ufm_cid'),
						'ufm_aim'  			=> $this->input->post('ufm_aim'),
						'ufm_col_name'  	=> $ufm_col_name,
						'ufm_mode'			=> $this->input->post('ufm_mode'),
						'ufm_msg' 			=> $this->input->post('ufm_msg'),
						'lang_type'			=> $this->session->userdata('lang'),
						'enable'			=> $this->input->post('ufm_enable'),
					);
					$ufm_id = $this -> mod_eform -> update_set('uform', array('ufm_id' => $ufm_id), $uform_data);
					if ($ufm_id)
						$this -> script_message('修改成功', '/eform/main', 'top');
					else
						$this -> script_message('修改失敗', '/eform/main', 'top');
				}
			}
			else
			{
				echo '<script>';
				echo 'alert("'.$language['DataLost'].'");';
				echo 'window.close();';
				echo '</script>';
			}
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
				$update_id[] = $this -> mod_eform -> update_set('uform', array('ufm_id' => $value), array('enable' => $Art_status ));
			}
			$this -> script_message('更改成功', '/eform/main/' . $type);
		}
		else
			$this -> script_message('請選擇筆數或狀態', '/eform/main/' . $type);
		
	}
	
	
}