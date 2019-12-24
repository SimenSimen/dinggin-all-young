<?php
class Company extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

        // helper
        $this->load->helper('url');
        
        // base_url
        $this->data['base_url'] = base_url();

        // model
		$this->load->model('business_model', 'mod_business');

        // host
        $this->data['host'] = $this->get_host_config();
        $this->data['web_config'] = $this->get_web_config($this->data['domain_id']);
		//account
		$REQUEST_URI=$this->input->server('REQUEST_URI',true);
		$REQUEST_URI=explode('/',$REQUEST_URI);
		$REQUEST=$REQUEST_URI[3];
		//echo $REQUEST;
		//member_id
		$member= $this->mod_business->select_from('member', array('account'=>$REQUEST));
		
		$auth=$member['auth'];
		if($auth=='02'){
			$son_member_id=$member['member_id'];
			$domain_id=$member['domain_id'];
			$member= $this->mod_business->select_from('member',array('domain_id'=>$domain_id,'auth'=>'01'));
			$member_id=$member['member_id'];
			
		}else{
			$member_id=$member['member_id'];
			$son_member_id=$member_id;
		}
	
		$this->member_id=$member_id;
		$this->son_member_id=$son_member_id;
	}
	//公司資訊
	public function news_list($id='',$type='')		
	{
		$member_id=$this->member_id;		
					
		if($type!='')
			$iqr_html = $this->mod_business->select_from_order('iqr_html', 'member_id', 'desc', array('member_id'=>$member_id,'classify_id'=>$type));
		else
			$iqr_html = $this->mod_business->select_from_order('iqr_html', 'member_id', 'desc', array('member_id'=>$member_id));
		
		$data['data']=$iqr_html;
		//base url
		$data['base_url'] = base_url();

		$iqr = $this -> mod_business -> select_from('iqr', array('member_id' => $this->son_member_id));
		//theme
			//DB data
			$theme=$this->mod_business->select_from('iqr_theme', array('theme_id'=>$iqr['theme_id']));
			//view
			$view_name=$theme['theme_mod_name'];
			//css
			$data['theme_css']=$theme['theme_css_name'];
			$data['slider_css']=$theme['theme_slider_css_name'];
			//jquery mobile button
			$data['jqm_button']=($iqr['theme_jqm_button'] != '') ? $iqr['theme_jqm_button'] : 'e'; 	
			//font-color
			$data['font_color']=($iqr['theme_font_color'] != '') ? $iqr['theme_font_color'] : $theme['dfu_font_color'];
			//font-size
			$data['font_size']=($iqr['theme_font_size'] != '') ? $iqr['theme_font_size'] : $theme['dfu_font_size'];
			//font-family
			$data['font_family']=($iqr['theme_font_family'] != '') ? $iqr['theme_font_family'] : $theme['dfu_font_family'];
			//background type
			$data['bg_type']=$iqr['theme_bg_type'];
			//background color
			$data['bg_color']=($iqr['theme_bg_color'] != '') ? $iqr['theme_bg_color'] : $theme['dfu_bg_color'];
			//background image path
			$data['bg_image_path']=($iqr['theme_bg_image_path'] != '') ? $iqr['theme_bg_image_path'] : $theme['dfu_bg_image_path'];

		$data['id']=$id;
		$data['url']=$base_url.'/company/news_info/';
	
		$data['store'] = $a = $this -> mod_business -> select_from('iqr_cart', array('member_id' => $this->son_member_id));

		// $this->load->view('company/left_' .$theme['theme_id'], $data);
		$this->load->view('company/news_list_' .$theme['theme_id'], $data);
		$this->load->view('template/integrate_footer/' .$theme['footer_mode_name'], $data);
	}
	//資訊簡介
	public function news_info($base='',$id='')
	{
		$member_id=$this->member_id;
		
		if($id != '')
		{
			$iqr_html=$this->mod_business->select_from('iqr_html', array('html_id'=>$id));
		}
		else
		{
			redirect(base_url());
		}
		if(!empty($iqr_html))
		{
			//分享網址
			$data['actual_link']="https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			
			//base url
			$data['base_url'] = base_url();
			$iqr = $this -> mod_business -> select_from('iqr', array('member_id' => $this->son_member_id));

			//theme
				//DB data
				$theme=$this->mod_business->select_from('iqr_theme', array('theme_id'=>$iqr['theme_id']));
				//view
				$view_name=$theme['theme_mod_name'];
				//css
				$data['theme_css']=$theme['theme_css_name'];
				$data['slider_css']=$theme['theme_slider_css_name'];
				//jquery mobile button
				$data['jqm_button']=($iqr['theme_jqm_button'] != '') ? $iqr['theme_jqm_button'] : 'e'; 	
				//font-color
				$data['font_color']=($iqr['theme_font_color'] != '') ? $iqr['theme_font_color'] : $theme['dfu_font_color'];
				//font-size
				$data['font_size']=($iqr['theme_font_size'] != '') ? $iqr['theme_font_size'] : $theme['dfu_font_size'];
				//font-family
				$data['font_family']=($iqr['theme_font_family'] != '') ? $iqr['theme_font_family'] : $theme['dfu_font_family'];
				//background type
				$data['bg_type']=$iqr['theme_bg_type'];
				//background color
				$data['bg_color']=($iqr['theme_bg_color'] != '') ? $iqr['theme_bg_color'] : $theme['dfu_bg_color'];
				//background image path
				$data['bg_image_path']=($iqr['theme_bg_image_path'] != '') ? $iqr['theme_bg_image_path'] : $theme['dfu_bg_image_path'];
			
			$data['store'] = $this -> mod_business -> select_from('iqr_cart', array('member_id' => $this->son_member_id));

			$data['news_left']=$this->mod_business->select_from_order('iqr_classify', 'member_id', 'desc', array('member_id'=>$member_id));
			$data['url_left']= base_url().'company/news_list/';
			
			$data['id']=$base;
			
			$data['info']=$iqr_html;
			$data['share_link'] = base_url() . 'company/news_share/' . $base .'/'. $id;
			// $this->load->view('company/left_' .$theme['theme_id'], $data);
			$this->load->view('company/news_info_' .$theme['theme_id'], $data);
			$this->load->view('template/integrate_footer/' .$theme['footer_mode_name'], $data);
		}
		else
		{
			redirect(base_url());
		}
	}
	//公司影片
	public function film_list($id='', $type='')		
	{
		$member_id=$this->member_id;
		//base url
		$data['base_url'] = base_url();
		$iqr = $this -> mod_business -> select_from('iqr', array('member_id' => $this->son_member_id));
		//theme
			//DB data
			$theme=$this->mod_business->select_from('iqr_theme', array('theme_id'=>$iqr['theme_id']));
			//view
			$view_name=$theme['theme_mod_name'];
			//css
			$data['theme_css']=$theme['theme_css_name'];
			$data['slider_css']=$theme['theme_slider_css_name'];
			//jquery mobile button
			$data['jqm_button']=($iqr['theme_jqm_button'] != '') ? $iqr['theme_jqm_button'] : 'e'; 	
			//font-color
			$data['font_color']=($iqr['theme_font_color'] != '') ? $iqr['theme_font_color'] : $theme['dfu_font_color'];
			//font-size
			$data['font_size']=($iqr['theme_font_size'] != '') ? $iqr['theme_font_size'] : $theme['dfu_font_size'];
			//font-family
			$data['font_family']=($iqr['theme_font_family'] != '') ? $iqr['theme_font_family'] : $theme['dfu_font_family'];
			//background type
			$data['bg_type']=$iqr['theme_bg_type'];
			//background color
			$data['bg_color']=($iqr['theme_bg_color'] != '') ? $iqr['theme_bg_color'] : $theme['dfu_bg_color'];
			//background image path
			$data['bg_image_path']=($iqr['theme_bg_image_path'] != '') ? $iqr['theme_bg_image_path'] : $theme['dfu_bg_image_path'];

		$data['id']=$id;
		$data['url']=$base_url.'/company/film_info/';
		
		//影像列表
		if($type != '')
		{
			$film = $this->mod_business->select_from_order('strings', 'str_id', 'desc', array('member_id'=>$member_id,'type'=>'0', 'cid' => $type));
		}
		else
			$film = $this->mod_business->select_from_order('strings', 'str_id', 'desc', array('member_id'=>$member_id,'type'=>'0'));
		$data['data']=$film;
		
		$data['store'] = $this -> mod_business -> select_from('iqr_cart', array('member_id' => $this->son_member_id));
		
		echo '=test=';
		exit;
		// $this->load->view('company/left_' .$theme['theme_id'], $data);
		$this->load->view('company/film_list_' .$theme['theme_id'], $data);
		echo '=test=';
		exit;
		
		$this->load->view('template/integrate_footer/' .$theme['footer_mode_name'], $data);
	}
	//影片簡介
	public function film_info($base='',$id='')
	{
		$member_id=$this->member_id;
		if($id != '')
		{
			$film=$this->mod_business->select_from('strings', array('str_id'=>$id));
		}
		else
		{
			redirect(base_url());
		}
		if(!empty($film))
		{
			//分享網址
			// $data['actual_link']="https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			//base url
			$data['base_url'] = base_url();
			$iqr = $this -> mod_business -> select_from('iqr', array('member_id' => $this->son_member_id));
			//theme
				//DB data
				$theme=$this->mod_business->select_from('iqr_theme', array('theme_id'=>$iqr['theme_id']));
				//view
				$view_name=$theme['theme_mod_name'];
				//css
				$data['theme_css']=$theme['theme_css_name'];
				$data['slider_css']=$theme['theme_slider_css_name'];
				//jquery mobile button
				$data['jqm_button']=($iqr['theme_jqm_button'] != '') ? $iqr['theme_jqm_button'] : 'e'; 	
				//font-color
				$data['font_color']=($iqr['theme_font_color'] != '') ? $iqr['theme_font_color'] : $theme['dfu_font_color'];
				//font-size
				$data['font_size']=($iqr['theme_font_size'] != '') ? $iqr['theme_font_size'] : $theme['dfu_font_size'];
				//font-family
				$data['font_family']=($iqr['theme_font_family'] != '') ? $iqr['theme_font_family'] : $theme['dfu_font_family'];
				//background type
				$data['bg_type']=$iqr['theme_bg_type'];
				//background color
				$data['bg_color']=($iqr['theme_bg_color'] != '') ? $iqr['theme_bg_color'] : $theme['dfu_bg_color'];
				//background image path
				$data['bg_image_path']=($iqr['theme_bg_image_path'] != '') ? $iqr['theme_bg_image_path'] : $theme['dfu_bg_image_path'];

			$data['id']=$base;
			$ytb_id = $this -> get_ytb_id($film['str']);
			$film['str']=$ytb_id;

			$data['film']=$film;
			
			$data['store'] = $this -> mod_business -> select_from('iqr_cart', array('member_id' => $this->son_member_id));
			$data['share_link'] = base_url() . 'company/film_share/' . $base .'/'. $id;

			// $this->load->view('company/left_' .$theme['theme_id'], $data);
			$this->load->view('company/film_info_' .$theme['theme_id'], $data);
			$this->load->view('template/integrate_footer/' .$theme['footer_mode_name'], $data);
		}
		else
		{
			redirect(base_url());
		}
	}
	//公司活動
	public function activity_list($id='', $type='')	
	{
		$member_id=$this->member_id;
		//base url
		$data['base_url'] = base_url();
		
		$data['id']=$id;
		$data['url']=$base_url.'/company/activity_info/';
		$iqr = $this -> mod_business -> select_from('iqr', array('member_id' => $this->son_member_id));
		//theme
			//DB data
			$theme=$this->mod_business->select_from('iqr_theme', array('theme_id'=>$iqr['theme_id']));
			//view
			$view_name=$theme['theme_mod_name'];
			//css
			$data['theme_css']=$theme['theme_css_name'];
			$data['slider_css']=$theme['theme_slider_css_name'];
			//jquery mobile button
			$data['jqm_button']=($iqr['theme_jqm_button'] != '') ? $iqr['theme_jqm_button'] : 'e'; 	
			//font-color
			$data['font_color']=($iqr['theme_font_color'] != '') ? $iqr['theme_font_color'] : $theme['dfu_font_color'];
			//font-size
			$data['font_size']=($iqr['theme_font_size'] != '') ? $iqr['theme_font_size'] : $theme['dfu_font_size'];
			//font-family
			$data['font_family']=($iqr['theme_font_family'] != '') ? $iqr['theme_font_family'] : $theme['dfu_font_family'];
			//background type
			$data['bg_type']=$iqr['theme_bg_type'];
			//background color
			$data['bg_color']=($iqr['theme_bg_color'] != '') ? $iqr['theme_bg_color'] : $theme['dfu_bg_color'];
			//background image path
			$data['bg_image_path']=($iqr['theme_bg_image_path'] != '') ? $iqr['theme_bg_image_path'] : $theme['dfu_bg_image_path'];
		
		//影像列表
		if($type !='')
			$uform = $this->mod_business->select_from_order('uform', 'ufm_id', 'desc', array('member_id'=>$member_id, 'ufm_cid' => $type));
		else
			$uform = $this->mod_business->select_from_order('uform', 'ufm_id', 'desc', array('member_id'=>$member_id));
		$data['data']=$uform;
		
		$data['store'] = $a = $this -> mod_business -> select_from('iqr_cart', array('member_id' => $this->son_member_id));
		
		$this->load->view('company/activity_list', $data);
		// $this->load->view('company/left_' .$theme['theme_id'], $data);
		$this->load->view('template/integrate_footer/' .$theme['footer_mode_name'], $data);
	}
	//活動簡介
	public function activity_info($base='',$id=''){		
		$member_id=$this->member_id;
		$data['member_id']=$member_id;
		if($id != '')
		{
			$uform=$this->mod_business->select_from('uform', array('ufm_id'=>$id));
		}
		else
		{
			redirect(base_url());
		}
		if(!empty($uform))
		{
			//base url
			$data['base_url'] = base_url();
			
			//$data['base']=$base;
			$data['id']=$base;
			
			$data['store'] = $a = $this -> mod_business -> select_from('iqr_cart', array('member_id' => $this->son_member_id));
			$iqr = $this -> mod_business -> select_from('iqr', array('member_id' => $this->son_member_id));
			//theme
				//DB data
				$theme=$this->mod_business->select_from('iqr_theme', array('theme_id'=>$iqr['theme_id']));
				//view
				$view_name=$theme['theme_mod_name'];
				//css
				$data['theme_css']=$theme['theme_css_name'];
				$data['slider_css']=$theme['theme_slider_css_name'];
				//jquery mobile button
				$data['jqm_button']=($iqr['theme_jqm_button'] != '') ? $iqr['theme_jqm_button'] : 'e'; 	
				//font-color
				$data['font_color']=($iqr['theme_font_color'] != '') ? $iqr['theme_font_color'] : $theme['dfu_font_color'];
				//font-size
				$data['font_size']=($iqr['theme_font_size'] != '') ? $iqr['theme_font_size'] : $theme['dfu_font_size'];
				//font-family
				$data['font_family']=($iqr['theme_font_family'] != '') ? $iqr['theme_font_family'] : $theme['dfu_font_family'];
				//background type
				$data['bg_type']=$iqr['theme_bg_type'];
				//background color
				$data['bg_color']=($iqr['theme_bg_color'] != '') ? $iqr['theme_bg_color'] : $theme['dfu_bg_color'];
				//background image path
				$data['bg_image_path']=($iqr['theme_bg_image_path'] != '') ? $iqr['theme_bg_image_path'] : $theme['dfu_bg_image_path'];
			//uform不存在
			if(empty($uform))
			{
				redirect(base_url());
			}

			//edm已關閉
			if(!empty($uform))
			{
				if($uform['ufm_status'] == 0)
				{
					redirect(base_url());
				}
			}
			
			//分享網址
			$data['actual_link']="https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			
			//title
			$data['ufm_title'] = $this->get_serialstr($uform['ufm_col_name'], "*#");

			//content
			if(count($data['ufm_title']) > 3)
			{
				$ufm_content = $this->get_serialstr($uform['ufm_col_content'], "*#");
				if(!empty($ufm_content))
				{
					foreach($ufm_content as $key => $value)
					{
						// $str[0] 		type, 1:日期, 2:文字, 3:單選, 4:下拉, 2:複選
						// $str[1]-[n] 	content if [1] != 'n'
						$str=explode(' ', $value);
						$data['ufm_content'][]=$str;
					}
				}
				$ufm_required = $this->get_serialstr($uform['ufm_col_required'], "*#");
				if(!empty($ufm_required))
				{
					foreach($ufm_required as $key => $value)
					{
						//必填
						$data['ufm_required'][] 	 = ($value == 1) ? 'required' : '';
						$data['ufm_required_star'][] = ($value == 1) ? '<span class="red_star">*</span>' : '';
					}
				}
			}
			
			
			$data['data']=$uform;
			// $this->load->view('company/left_' .$theme['theme_id'], $data);
			$this->load->view('company/activity_info', $data);
			$this->load->view('template/integrate_footer/' .$theme['footer_mode_name'], $data);
		}
		else
		{
			redirect(base_url());
		}
	}
	public function signup($type='')
	{
		//data
		$data=$this->data;
		
	
		$data['base_url'] = base_url();
		if($this->input->post('send'))
		{
			$data_array[0] = $this->input->post('name_r');
			$data_array[1] = $this->input->post('mphone_r');
			$data_array[2] = $this->input->post('email_r');
			$temp_customer_data = $this->input->post('customerInput');
			for($i = 3; $i < $this->input->post('ufm_col_num'); $i++)
			{
				if(is_array($temp_customer_data[$i]))
					$data_array[$i] = $this->set_serialstr($temp_customer_data[$i], '*#');
				else
					$data_array[$i] = $temp_customer_data[$i];
			}
			$ufms_result = $this->set_serialstr($data_array, '*#');
			$insert_data = array(
				'ufms_result'	=> $ufms_result,
				'ufm_id' 		=> $this->input->post('ufm_id'),
				'card_owner' 	=>  $this->input->post('member_id'),
				'addtime' 		=> time()
			);
			$ufms_id=$this->mod_index->insert_into('uform_signup', $insert_data);
	
			if($ufms_id)
			{
				/*$member 	   = $this->mod_index->select_from('member', array('member_id'=>$this->input->post('card_owner')));
				$member_domain = $this->mod_index->select_from('domain', array('domain_id'=>$member['domain_id']));
				$uform 		   = $this->mod_index->select_from('uform', array('ufm_id'=>$this->input->post('ufm_id')));
				$admin 		   = $this->mod_index->select_from('member', array('member_id'=>$uform['member_id'], 'auth'=>'01'));
				*/
				//寄送報名通知信給名片擁有者
				//主旨
				/*$subject = $data['host']['company'].' 行動商務系統信 - 報名通知';
				if($this->input->post('card_owner') != $admin['member_id'])
				{
					//內容
					$message = ''.
						"<p><h3>報名通知</h3></p>".
						"<p>您有一個報名表單活動有新報名者</p>".
						"<p>報名表單：".$uform['ufm_name']."</p>".
						"<p>詳細情況：{unwrap}<a href='https://".$member_domain['domain']."/business/uform_sign_up_show/sign_up_".$uform['ufm_id']."/".$this->input->post('card_owner')."'>報名情形總覽</a>{/unwrap}</p>".
						"<hr>".
						"<p>注意：本郵件是由系統自動產生與發送，請勿直接回覆。</p>";
					//寄信
					$this->mod_index->send_mail($data['host']['domain'], $data['host']['company'], $member['email'], $subject, $message);
				}
				//寄送報名通知信給母站帳戶
				//內容
				$message = ''.
					"<p><h3>報名通知</h3></p>".
					"<p>您或您的子帳戶報名表單有新報名者</p>".
					"<p>報名表單：".$uform['ufm_name']."</p>".
					"<p>詳細情況：{unwrap}<a href='https://".$member_domain['domain']."/business/uform_sign_up_show/sign_up_".$uform['ufm_id']."/".$admin['member_id']."'>報名情形總覽</a>{/unwrap}</p>".
					"<hr>".
					"<p>注意：本郵件是由系統自動產生與發送，請勿直接回覆。</p>";
				//寄信
				$this->mod_index->send_mail($data['host']['domain'], $data['host']['company'], $admin['email'], $subject, $message);
				*/
				//手機版報名
				$ufm_msg = ($uform['ufm_msg'] != '') ? $uform['ufm_msg'] : '恭喜您，報名資料已送出成功';
				if($type == 1)
				{
					echo $ufm_msg;
					
				}
				else//電腦版報名
				{
					$link = $base_url.'/company/activity_list/'.$this->input->post('base');
					echo '
					<script>
					setTimeout("alert(\''.$ufm_msg.'\')" , 500);
					setTimeout("window.location.href=\''.$link.'\'" , 500);
					</script>';
				}
			}
		}
	}
	//公司照片列表
	public function picture_list($id='')		
	{
		$member_id=$this->member_id;
		//base url
		$data['base_url'] = base_url();
		
		$data['id']=$id;
		$data['url']=$base_url.'/company/picture_info/';
		
		$data['store'] = $a = $this -> mod_business -> select_from('iqr_cart', array('member_id' => $this->son_member_id));
		$iqr = $this -> mod_business -> select_from('iqr', array('member_id' => $this->son_member_id));
		//theme
			//DB data
			$theme=$this->mod_business->select_from('iqr_theme', array('theme_id'=>$iqr['theme_id']));
			//view
			$view_name=$theme['theme_mod_name'];
			//css
			$data['theme_css']=$theme['theme_css_name'];
			$data['slider_css']=$theme['theme_slider_css_name'];
			//jquery mobile button
			$data['jqm_button']=($iqr['theme_jqm_button'] != '') ? $iqr['theme_jqm_button'] : 'e'; 	
			//font-color
			$data['font_color']=($iqr['theme_font_color'] != '') ? $iqr['theme_font_color'] : $theme['dfu_font_color'];
			//font-size
			$data['font_size']=($iqr['theme_font_size'] != '') ? $iqr['theme_font_size'] : $theme['dfu_font_size'];
			//font-family
			$data['font_family']=($iqr['theme_font_family'] != '') ? $iqr['theme_font_family'] : $theme['dfu_font_family'];
			//background type
			$data['bg_type']=$iqr['theme_bg_type'];
			//background color
			$data['bg_color']=($iqr['theme_bg_color'] != '') ? $iqr['theme_bg_color'] : $theme['dfu_bg_color'];
			//background image path
			$data['bg_image_path']=($iqr['theme_bg_image_path'] != '') ? $iqr['theme_bg_image_path'] : $theme['dfu_bg_image_path'];
		//影像列表
		$picture= $this->mod_business->select_from_order('photo_category', 'd_id', 'desc', array('d_member_id'=>$member_id));
		foreach ($picture as $key => $value) {
			$photo_array = $this -> get_serialstr($value['d_photo'], '*#');
			$img = $this -> mod_business -> select_from('images', array('img_id' => $photo_array[0]));

			$picture[$key]['first_img'] = substr($img['img_path'],1);

		}
		$data['data']=$picture;

		// $this->load->view('company/left_' .$theme['theme_id'], $data);
		$this->load->view('company/picture_list_' .$theme['theme_id'], $data);
		$this->load->view('template/integrate_footer/' .$theme['footer_mode_name'], $data);
		//$this -> script_message('暫不開放', '/business/iqr/'.$id);
	}
	//公司照片內文
	public function picture_info($base='',$id='')		
	{
		$data = $this -> data;
		$member_id=$this->member_id;
		
		if($id != '')
		{
			$photo_category=$this->mod_business->select_from('photo_category', array('d_id'=>$id));
		}
		else
		{
			redirect(base_url());
		}
		if(!empty($photo_category))
		{
			if(!empty($photo_category['d_photo']))
			{
				//分享網址
				// $data['actual_link']="https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				
				$data['store'] = $a = $this -> mod_business -> select_from('iqr_cart', array('member_id' => $this->son_member_id));
				//base url
				$data['base_url'] = base_url();
				$iqr = $this -> mod_business -> select_from('iqr', array('member_id' => $this->son_member_id));
				//theme
					//DB data
					$theme=$this->mod_business->select_from('iqr_theme', array('theme_id'=>$iqr['theme_id']));
					//view
					$view_name=$theme['theme_mod_name'];
					//css
					$data['theme_css']=$theme['theme_css_name'];
					$data['slider_css']=$theme['theme_slider_css_name'];
					//jquery mobile button
					$data['jqm_button']=($iqr['theme_jqm_button'] != '') ? $iqr['theme_jqm_button'] : 'e'; 	
					//font-color
					$data['font_color']=($iqr['theme_font_color'] != '') ? $iqr['theme_font_color'] : $theme['dfu_font_color'];
					//font-size
					$data['font_size']=($iqr['theme_font_size'] != '') ? $iqr['theme_font_size'] : $theme['dfu_font_size'];
					//font-family
					$data['font_family']=($iqr['theme_font_family'] != '') ? $iqr['theme_font_family'] : $theme['dfu_font_family'];
					//background type
					$data['bg_type']=$iqr['theme_bg_type'];
					//background color
					$data['bg_color']=($iqr['theme_bg_color'] != '') ? $iqr['theme_bg_color'] : $theme['dfu_bg_color'];
					//background image path
					$data['bg_image_path']=($iqr['theme_bg_image_path'] != '') ? $iqr['theme_bg_image_path'] : $theme['dfu_bg_image_path'];
				
				$data['id']=$base;
				
				$data['photo_category']=$photo_category;
				
				$myphoto=$this->get_serialstr($photo_category['d_photo'], '*#');
				
				
				if(!empty($myphoto))
				{
					foreach($myphoto as $key => $value)
					{
						$img=$this->mod_business->select_from('images', array('img_id'=>$value));
						
						if(!empty($img))
						{
								$data['myphoto'][$key]=substr($img['img_path'], 1);
								$data['myphoto_name'][$key]=$img['img_note'];
						}
					}
				}
				$data['share_link'] = base_url() . 'company/film_share/' . $base .'/'. $id;
				
				$this->load->view('company/picture_info_' .$theme['theme_id'], $data);
				$this->load->view('template/integrate_footer/' .$theme['footer_mode_name'], $data);
			}else
				$this -> script_message('相簿照片暫不開放', '/company/picture_list/'.$base);
		}
		else
		{
			redirect(base_url());
		}
	}

	private function get_ytb_id($url)
	{
		//去除首尾空白
		$url=trim($url);

		//擷取id
		if($pos = strpos($url, '?v=') !== false)
		{
			//後綴參數檢查
			$pos=strpos($url, '?v=');
			$and_mark=strpos($url, '&');
			if($and_mark != false)
			{
				$id=substr($url, $pos+3, ($and_mark-$pos-3));
			}
			else
			{
				$id=substr($url, $pos+3);
			}
		}
		else
		{
			//youtu.be檢查
			if($pos = strpos($url, 'youtu.be') !== false)
			{
				$pos=strrpos($url, '/');
				$and_mark=strpos($url, '&');
				if($and_mark != false)
				{
					$id=substr($url, $pos+1, ($and_mark-$pos-1));
				}
				else
				{
					$id=substr($url, $pos+1);
				}
			}
			else
			{
				$id='';
			}
		}
		return $id;
	}
	// 分享頁 (資料庫, 影片, 相簿)
	public function news_share($account, $id)
	{
		$member_id = $this -> member_id;
		
		if($id != '')
		{
			$iqr_html = $this -> mod_business -> select_from('iqr_html', array('html_id' => $id));
		}
		else
		{
			redirect(base_url());
		}
		if(!empty($iqr_html))
		{
			$iqr = $this -> mod_business -> select_from('iqr', array('member_id' => $this -> son_member_id));

			//theme
				//DB data
				$theme=$this->mod_business->select_from('iqr_theme', array('theme_id'=>$iqr['theme_id']));
				//view
				$view_name=$theme['theme_mod_name'];
				//css
				$data['theme_css']=$theme['theme_css_name'];
				$data['slider_css']=$theme['theme_slider_css_name'];
				//jquery mobile button
				$data['jqm_button']=($iqr['theme_jqm_button'] != '') ? $iqr['theme_jqm_button'] : 'e'; 	
				//font-color
				$data['font_color']=($iqr['theme_font_color'] != '') ? $iqr['theme_font_color'] : $theme['dfu_font_color'];
				//font-size
				$data['font_size']=($iqr['theme_font_size'] != '') ? $iqr['theme_font_size'] : $theme['dfu_font_size'];
				//font-family
				$data['font_family']=($iqr['theme_font_family'] != '') ? $iqr['theme_font_family'] : $theme['dfu_font_family'];
				//background type
				$data['bg_type']=$iqr['theme_bg_type'];
				//background color
				$data['bg_color']=($iqr['theme_bg_color'] != '') ? $iqr['theme_bg_color'] : $theme['dfu_bg_color'];
				//background image path
				$data['bg_image_path']=($iqr['theme_bg_image_path'] != '') ? $iqr['theme_bg_image_path'] : $theme['dfu_bg_image_path'];

			$data['id'] = $account;
			$data['iqr_url'] = base_url() . "company/news_share/" . $account ."/". $id;
			$data["title"]   = $iqr_html["html_name"];
			$data["content"] = $iqr_html["html_content"]; 
			$data["download_href"] = base_url() ."app/route/" .$iqr["member_id"] ;
			$this->load->view('company/news_share_editor', $data);
		}
		else
		{
			redirect(base_url());
		}
	}

	// 影片分享頁
	public function film_share($account, $id)
	{
		$member_id = $this -> member_id;
		if($id != '')
		{
			$data['film'] = $film = $this -> mod_business -> select_from('strings', array('str_id' => $id));
		print_r($film);
		}
		else
		{
			redirect(base_url());
		}
		if(!empty($film))
		{
			$iqr = $this -> mod_business -> select_from('iqr', array('member_id' => $this -> son_member_id));
			//theme
				//DB data
				$theme=$this->mod_business->select_from('iqr_theme', array('theme_id'=>$iqr['theme_id']));
				//view
				$view_name=$theme['theme_mod_name'];
				//css
				$data['theme_css']=$theme['theme_css_name'];
				$data['slider_css']=$theme['theme_slider_css_name'];
				//jquery mobile button
				$data['jqm_button']=($iqr['theme_jqm_button'] != '') ? $iqr['theme_jqm_button'] : 'e'; 	
				//font-color
				$data['font_color']=($iqr['theme_font_color'] != '') ? $iqr['theme_font_color'] : $theme['dfu_font_color'];
				//font-size
				$data['font_size']=($iqr['theme_font_size'] != '') ? $iqr['theme_font_size'] : $theme['dfu_font_size'];
				//font-family
				$data['font_family']=($iqr['theme_font_family'] != '') ? $iqr['theme_font_family'] : $theme['dfu_font_family'];
				//background type
				$data['bg_type']=$iqr['theme_bg_type'];
				//background color
				$data['bg_color']=($iqr['theme_bg_color'] != '') ? $iqr['theme_bg_color'] : $theme['dfu_bg_color'];
				//background image path
				$data['bg_image_path']=($iqr['theme_bg_image_path'] != '') ? $iqr['theme_bg_image_path'] : $theme['dfu_bg_image_path'];

			$ytb_id = $this -> get_ytb_id($film['str']);
			$data['ytb_str'] = $ytb_id;
			$data['title'] = $film['str_name'];
			$data['iqr_url'] = base_url() . "company/film_share/" . $account ."/". $id;
			
			$data["download_href"] = base_url() ."app/route/" .$iqr["member_id"] ;
			$this -> load -> view('company/film_share_editor', $data);
		}
		else
		{
			redirect(base_url());
		}
	}

	public function picture_share($account, $id)
	{
		$member_id = $this -> member_id;
		
		if($id != '')
		{
			$photo_category = $this -> mod_business -> select_from('photo_category', array('d_id' => $id));
			$data['title'] = $photo_category['d_name'];
		}
		else
		{
			redirect(base_url());
		}
		if(!empty($photo_category))
		{
			if(!empty($photo_category['d_photo']))
			{
				//base url
				$iqr = $this -> mod_business -> select_from('iqr', array('member_id' => $this -> son_member_id));
				//theme
					//DB data
					$theme=$this->mod_business->select_from('iqr_theme', array('theme_id'=>$iqr['theme_id']));
					//view
					$view_name=$theme['theme_mod_name'];
					//css
					$data['theme_css']=$theme['theme_css_name'];
					$data['slider_css']=$theme['theme_slider_css_name'];
					//jquery mobile button
					$data['jqm_button']=($iqr['theme_jqm_button'] != '') ? $iqr['theme_jqm_button'] : 'e'; 	
					//font-color
					$data['font_color']=($iqr['theme_font_color'] != '') ? $iqr['theme_font_color'] : $theme['dfu_font_color'];
					//font-size
					$data['font_size']=($iqr['theme_font_size'] != '') ? $iqr['theme_font_size'] : $theme['dfu_font_size'];
					//font-family
					$data['font_family']=($iqr['theme_font_family'] != '') ? $iqr['theme_font_family'] : $theme['dfu_font_family'];
					//background type
					$data['bg_type']=$iqr['theme_bg_type'];
					//background color
					$data['bg_color']=($iqr['theme_bg_color'] != '') ? $iqr['theme_bg_color'] : $theme['dfu_bg_color'];
					//background image path
					$data['bg_image_path']=($iqr['theme_bg_image_path'] != '') ? $iqr['theme_bg_image_path'] : $theme['dfu_bg_image_path'];
					$this -> load -> library('Common');
					$data['bg_image_path'] = Common::get_data_uri(substr($data['bg_image_path'], 1));
				
				$data['photo_category'] = $photo_category;
				$myphoto = $this->get_serialstr($photo_category['d_photo'], '*#');
				
				if(!empty($myphoto))
				{
					foreach($myphoto as $key => $value)
					{
						$img = $this -> mod_business -> select_from('images', array('img_id' => $value));
						
						if(!empty($img))
						{
								$data['myphoto'][$key] = substr($img['img_path'], 1);
								$data['myphoto_name'][$key] = $img['img_note'];
						}
					}
				}
				else
					$this -> script_message('相簿照片暫不開放', '/company/picture_list/'.$account);
				$data['iqr_url'] = base_url() . "company/picture_share/" . $account ."/". $id;
				$data["download_href"] = base_url() ."app/route/" .$iqr["member_id"] ;
				$this -> load -> view('company/picture_share_editor', $data);
			}
			else
				$this -> script_message('相簿照片暫不開放', '/company/picture_list/'.$account);
		}
		else
		{
			redirect(base_url());
		}
	}
	
	public function html_share($account, $id)
	{
		if($id != '')
		{
			$iqr_html = $this -> mod_business -> select_from('iqr_html', array('html_id' => $id));
			$member   = $this -> mod_business -> select_from('member', array('account' => $iqr_html['member_id']));
		}
		else
		{
			redirect(base_url());
		}
		if(!empty($iqr_html))
		{
			$iqr = $this -> mod_business -> select_from('iqr', array('member_id' => $iqr_html['member_id']));
			//theme
				//DB data
				$theme=$this->mod_business->select_from('iqr_theme', array('theme_id'=>$iqr['theme_id']));
				//view
				$view_name=$theme['theme_mod_name'];
				//css
				$data['theme_css']=$theme['theme_css_name'];
				$data['slider_css']=$theme['theme_slider_css_name'];
				//jquery mobile button
				$data['jqm_button']=($iqr['theme_jqm_button'] != '') ? $iqr['theme_jqm_button'] : 'e'; 	
				//font-color
				$data['font_color']=($iqr['theme_font_color'] != '') ? $iqr['theme_font_color'] : $theme['dfu_font_color'];
				//font-size
				$data['font_size']=($iqr['theme_font_size'] != '') ? $iqr['theme_font_size'] : $theme['dfu_font_size'];
				//font-family
				$data['font_family']=($iqr['theme_font_family'] != '') ? $iqr['theme_font_family'] : $theme['dfu_font_family'];
				//background type
				$data['bg_type']=$iqr['theme_bg_type'];
				//background color
				$data['bg_color']=($iqr['theme_bg_color'] != '') ? $iqr['theme_bg_color'] : $theme['dfu_bg_color'];
				//background image path
				$data['bg_image_path']=($iqr['theme_bg_image_path'] != '') ? $iqr['theme_bg_image_path'] : $theme['dfu_bg_image_path'];
			$data['id'] = $member['account'];
			$data['iqr_url'] = base_url() . "company/html_share/" . $member['account'] ."/". $id;
			$data["title"]   = $iqr_html["html_name"];
			$data["content"] = $iqr_html["html_content"]; 
			$data["download_href"] = base_url() ."app/route/" .$iqr["member_id"] ;
			$this->load->view('company/html_share_editor', $data);
		}
		else
		{
			redirect(base_url());
		}
	}
}
