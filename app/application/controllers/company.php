<?php
class Company extends MY_Controller
{
	public $data = '';
	public $language = '';

	public function __construct()
	{
		parent::__construct();

        // helper
        $this->load->helper('url');

        // language
		$this -> load -> helper('language');
		if(!$this -> session -> userdata('lang'))
		{
			$this -> session -> set_userdata('lang', 'zh-tw');
			$this -> data['lang'] = $this -> session -> userdata('lang');
		}
		else
			$this -> data['lang'] = $this -> session -> userdata('lang');

		$this -> lang -> load('controllers/company', $this -> data['lang']);
		$this -> language['SuccessMessage'] = lang('SuccessMessage');
		$this -> language['Photo_not_open'] = lang('Photo_not_open');

		$this -> lang -> load('views/template/integrate_footer/footer_basic', $this -> data['lang']);
		$this -> lang -> load('views/template/integrate_footer/footer_001', $this -> data['lang']);
		$this -> data['Library'] = lang('Library');
		$this -> data['Film'] = lang('Film');
		$this -> data['Photo'] = lang('Photo');
		$this -> data['AboutMe'] = lang('AboutMe');
		$this -> data['Information'] = lang('Information');
		$this -> data['Film'] = lang('Film');
		$this -> data['Activity'] = lang('Activity');

		$this -> lang -> load('views/company/left_1', $this -> data['lang']);
		$this -> lang -> load('views/company/left_2', $this -> data['lang']);
		$this -> data['Informationclassification'] = lang('Informationclassification');
		$this -> data['VideosCategory'] = lang('VideosCategory');
		$this -> data['Activityclassification'] = lang('Activityclassification');
		$this -> data['PhotoCategories'] = lang('PhotoCategories');
		$this -> data['DatabaseCategory'] = lang('DatabaseCategory');
		$this -> data['Database'] = lang('Database');
		$this -> data['Film'] = lang('Film');
		$this -> data['Albums'] = lang('Albums');
        
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
		$data = $this -> data;

		$this -> lang -> load('views/company/news_list_1', $data['lang']);
		$this -> lang -> load('views/company/news_list_2', $data['lang']);
		$data['CompanyArticles'] = lang('CompanyArticles');
		$data['ArticleClass'] = lang('ArticleClass');
		$data['ActionBusinessSystem'] = lang('ActionBusinessSystem');
		$data['Library'] = lang('Library');

		$member_id=$this->member_id;
		
		$iqr = $this -> mod_business -> select_from('iqr', array('member_id' => $this->son_member_id));

		if($type!='')
			$iqr_html = $this->mod_business->select_from_order('iqr_html', 'html_sort', 'asc', array('member_id'=>$member_id,'classify_id'=>$type));
		else
		{
			if(!empty($iqr['iqr_html']))
				$iqr_html = $this -> mod_business -> select_from_order('iqr_html', 'html_sort', asc, array('member_id' => $member_id));
				
		}
		
		$data['data']=$iqr_html;
		//base url
		$data['base_url'] = base_url();

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
		$data = $this -> data;

		$this -> lang -> load('views/company/news_info_1', $data['lang']);
		$this -> lang -> load('views/company/news_info_2', $data['lang']);
		$data['BusinessSystem'] = lang('BusinessSystem');
		$data['ArticleCategory'] = lang('ArticleCategory');
		$data['CompanyArticle'] = lang('CompanyArticle');
		$data['ShareContentTo'] = lang('ShareContentTo');
		$data['ShareFacebook'] = lang('ShareFacebook');
		$data['ShareWebio'] = lang('ShareWebio');
		$data['ShareGoogle'] = lang('ShareGoogle');
		$data['SharePlurk'] = lang('SharePlurk');
		$data['ShareTwitter'] = lang('ShareTwitter');
		$data['TheURL'] = lang('TheURL');

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
			$data['actual_link']="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			
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
	public function film_list($id='' , $type='')		
	{
		$data = $this -> data;
		
		$this -> lang -> load('views/company/film_list_1', $data['lang']);
		$this -> lang -> load('views/company/film_list_2', $data['lang']);
		$data['Views_Film'] = lang('Views_Film');
		$data['BusinessSystem'] = lang('BusinessSystem');
		$data['ArticleCategory'] = lang('ArticleCategory');
		$data['CompanyFilm'] = lang('CompanyFilm');
		$data['NoCategory'] = lang('NoCategory');

		$member_id=$this->member_id;
		//base url
		$data['base_url'] = base_url();
		$data['account'] = $id;
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

		$data['id'] = $id;
		$data['url']=$base_url.'/company/film_info/';
		
		//影像列表
		if($type != '')
		{
			$film = $this->mod_business->select_from_order('strings', 'str_id', 'desc', array('member_id'=>$member_id,'type'=>'0', 'cid' => $type));
		}
		else{
			$film = $this->mod_business->select_from_order('strings', 'str_id', 'desc', array('member_id'=>$member_id,'type'=>'0'));
		}

		$data['data']=$film;
		
		$data['store'] = $this -> mod_business -> select_from('iqr_cart', array('member_id' => $this->son_member_id));
		// $this->load->view('company/left_' .$theme['theme_id'], $data);
		$this->load->view('company/film_list_' .$theme['theme_id'], $data);
		$this->load->view('template/integrate_footer/' .$theme['footer_mode_name'], $data);
	}
	//影片簡介
	public function film_info($base='',$id='',$viewtype='')
	{
		$data = $this -> data;

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
			$this->publiccheck('',$base);
			$data=$this->data;
			
			if($viewtype == 'C')	$viewname='公司';
			else	$viewname='';

			//分享網址
			// $data['actual_link']="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
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
			$data['viewname'] = $viewname;
			

			$data['public_share_pict_Ppath'] = 'https://i.ytimg.com/vi/'.$film['str'].'/default.jpg';
			$data['public_share_title'] = $film['str_name'];
			if($this->get_device_type()>=1) {//手機>=1
				$data['public_share_url']   = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
				$data['public_share_buttom_url']   = 'jecp://path='.$data['public_share_pict_Ppath'].'&ecp_url='.$data['public_share_url'].'&ecp_title='.$data['public_share_title'];
			}else{
				$data['public_share_url']   = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			}
			$data['public_barcodeurl'] =base_url()."app/route/".$this->son_member_id;

			// $this->load->view('company/left_' .$theme['theme_id'], $data);
			if ($theme['theme_id']>=9){
				$this -> lang -> load('views/template/template4_seo', $data['lang']);
				$data['BusinessSystem'] = lang('BusinessSystem');
				$this -> lang -> load('views/template/template4_headmenu', $data['lang']);
				$data['AboutMe'] = lang('AboutMe');
				$data['TeamSituation'] = lang('TeamSituation');
				
				$this->load->view('template/temp'.$data['theme_id'].'/film_info', $data);
			}else{
				$this -> lang -> load('views/company/film_info_1', $data['lang']);
				$this -> lang -> load('views/company/film_info_2', $data['lang']);
				$this -> lang -> load('views/company/film_info_8', $data['lang']);
				$data['BusinessSystem'] = lang('BusinessSystem');
				$data['ArticleCategory'] = lang('ArticleCategory');
				$data['Film'] = lang('Film');
				$data['ShareTo'] = lang('ShareTo');
				$data['ShareFacebook'] = lang('ShareFacebook');
				$data['ShareWebio'] = lang('ShareWebio');
				$data['ShareGoogle'] = lang('ShareGoogle');
				$data['SharePlurk'] = lang('SharePlurk');
				$data['ShareTwitter'] = lang('ShareTwitter');
				$data['TheURL'] = lang('TheURL');
				$data['AboutMe'] = lang('AboutMe');
				$data['Film'] = lang('Film');
				$data['Collect'] = lang('Collect');

				$this->load->view('company/film_info_' .$theme['theme_id'], $data);
				$this->load->view('template/integrate_footer/' .$theme['footer_mode_name'], $data);
			}
		}
		else
		{
			redirect(base_url());
		}
	}

	//公司活動
	public function activity_list($id='', $type='')	
	{
		$data = $this -> data;
		
		$this -> lang -> load('views/company/activity_list', $data['lang']);
		$data['BusinessSystem'] = lang('BusinessSystem');
		$data['FormCategory'] = lang('FormCategory');
		$data['CompanyForm'] = lang('CompanyForm');
		
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
	public function activity_info($base='',$id='')
	{
		$data = $this -> data;
		
		$this -> lang -> load('views/company/activity_info', $data['lang']);
		$data['BusinessSystem'] = lang('BusinessSystem');
		$data['FilmCategory'] = lang('FilmCategory');
		$data['ShareTo'] = lang('ShareTo');
		$data['ShareFacebook'] = lang('ShareFacebook');
		$data['ShareWebio'] = lang('ShareWebio');
		$data['ShareGoogle'] = lang('ShareGoogle');
		$data['SharePlurk'] = lang('SharePlurk');
		$data['ShareTwitter'] = lang('ShareTwitter');
		$data['TheURL'] = lang('TheURL');
		$data['TheRadio'] = lang('TheRadio');
		$data['TheSelect'] = lang('TheSelect');
		$data['PleaseSelect'] = lang('PleaseSelect');
		$data['Radios'] = lang('Radios');
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
			$data['actual_link']="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			
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
						$str=explode(';', $value);
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
		$language = $this -> language;
	
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
				//手機版報名
				$ufm_msg = ($uform['ufm_msg'] != '') ? $uform['ufm_msg'] : $language['SuccessMessage'];
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
		$data = $this -> data;
		$this -> lang -> load('views/company/picture_list_1', $data['lang']);
		$this -> lang -> load('views/company/picture_list_2', $data['lang']);
		$data['BusinessSystem'] = lang('BusinessSystem');
		$data['ArticleCategory'] = lang('ArticleCategory');
		$data['CompanyGallery'] = lang('CompanyGallery');
		$data['Gallery'] = lang('Gallery');

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
		$picture= $this->mod_business->select_from_order('photo_category', 'd_sort', 'asc', array('d_member_id'=>$member_id));
		foreach ($picture as $key => $value) {
			$photo_array = $this -> get_serialstr($value['d_photo'], '*#');
			$img = $this -> mod_business -> select_from('images', array('img_id' => $photo_array[0]));

			$picture[$key]['first_img'] = substr($img['img_path'],1);

		}
		$data['data']=$picture;

		$this->load->view('company/picture_list_' .$theme['theme_id'], $data);
		$this->load->view('template/integrate_footer/' .$theme['footer_mode_name'], $data);
	}


	//公司照片內文
	public function picture_info($base='',$id='')		
	{    
		$data = $this -> data;
	    $language = $this -> language;
		$member_id=$this->member_id;
        
        $this -> lang -> load('views/company/picture_info_1', $data['lang']);
        $this -> lang -> load('views/company/picture_info_2', $data['lang']);
        
        $data['title'] = lang('title');
		$data['ShareGoogle'] = lang('ShareGoogle');
	    $data['SharePlurk'] = lang('SharePlurk');
	    $data['ShareTwitter'] = lang('ShareTwitter');
	    $data['ShareWeibo'] = lang('ShareWeibo');
	    $data['ShareFacebook'] = lang('ShareFacebook');
	    $data['MySystemUrl'] = lang('MySystemUrl');
	    $data['UseEmail'] = lang('UseEmail');
	    $data['ClickCollectApp'] = lang('ClickCollectApp');
	    $data['Return_page'] = lang('Return_page');
		if($id != '')
		{
			$photo_category=$this->mod_business->select_from('photo_category', array('d_id'=>$id));
		}
		else
		{
			redirect(base_url());
		}
		if(!empty($photo_category))		{
			if(!empty($photo_category['d_photo']))
			{
				//分享網址
				// $data['actual_link']="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				
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
				$this -> script_message($language['Photo_not_open'], '/company/picture_list/'.$base);
		}
		else
		{
			redirect(base_url());
		}
	}

	// 分享頁 (資料庫, 影片, 相簿)
	public function news_share($account, $id)
	{
		$data = $this -> data;
        
        $this -> lang -> load('views/company/news_share_editor', $data['lang']);
        $data['title'] = lang('title');
	    $data['ShareGoogle'] = lang('ShareGoogle');
	    $data['SharePlurk'] = lang('SharePlurk');
	    $data['ShareTwitter'] = lang('ShareTwitter');
	    $data['ShareWeibo'] = lang('ShareWeibo');
	    $data['ShareFacebook'] = lang('ShareFacebook');
	    $data['MySystemUrl'] = lang('MySystemUrl');
	    $data['UseEmail'] = lang('UseEmail');
	    $data['ClickCollectApp'] = lang('ClickCollectApp');

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
		$data = $this -> data;
        
        $this -> lang -> load('views/company/film_share_editor' , $data['lang']);

        $data['title'] = lang('title');
		$data['ShareGoogle'] = lang('ShareGoogle');
	    $data['SharePlurk'] = lang('SharePlurk');
	    $data['ShareTwitter'] = lang('ShareTwitter');
	    $data['ShareWeibo'] = lang('ShareWeibo');
	    $data['ShareFacebook'] = lang('ShareFacebook');
	    $data['MySystemUrl'] = lang('MySystemUrl');
	    $data['UseEmail'] = lang('UseEmail');
	    $data['ClickCollectApp'] = lang('ClickCollectApp');

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
	    $data = $this -> data;

		$language = $this -> language;

		$member_id = $this -> member_id;
          
        $this -> lang -> load('views/company/picture_share_editor' , $data['lang']);
        $data['title'] = lang('title');
		$data['ShareGoogle'] = lang('ShareGoogle');
	    $data['SharePlurk'] = lang('SharePlurk');
	    $data['ShareTwitter'] = lang('ShareTwitter');
	    $data['ShareWeibo'] = lang('ShareWeibo');
	    $data['ShareFacebook'] = lang('ShareFacebook'); 
	    $data['MySystemUrl'] = lang('MySystemUrl');
	    $data['UseEmail'] = lang('UseEmail');
	    $data['ClickCollectApp'] = lang('ClickCollectApp');
		
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
					$this -> script_message($language['Photo_not_open'], '/company/picture_list/'.$account);
				$data['iqr_url'] = base_url() . "company/picture_share/" . $account ."/". $id;
				$data["download_href"] = base_url() ."app/route/" .$iqr["member_id"] ;
				$this -> load -> view('company/picture_share_editor', $data);
			}
			else
				$this -> script_message($language['Photo_not_open'], '/company/picture_list/'.$account);
		}
		else
		{
			redirect(base_url());
		}
	}
	
	public function html_share($account, $id)
	{   
		$dtat =  $this -> data ;

		$this -> lang -> load('veiws/company/html_share_editor' , $data['lang']);
        
        $data['title'] = lang('title');
        $data['ShareGoogle'] = lang('ShareGoogle');
	    $data['SharePlurk'] = lang('SharePlurk');
	    $data['ShareTwitter'] = lang('ShareTwitter');
	    $data['ShareWeibo'] = lang('ShareWeibo');
	    $data['ShareFacebook'] = lang('ShareFacebook');
	    $data['MySystemUrl'] = lang('MySystemUrl');
	    $data['UseEmail'] = lang('UseEmail');
	    $data['ClickCollectApp'] = lang('ClickCollectApp');

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
