<?php
//行動商務系統後台
class Business extends MY_Controller
{
	public $data = '', $web_title = '', $set_language = '';

	public function __construct()//初始化
	{
		parent::__construct();
		@session_start();
		// if($this -> session -> userdata('lang')=='zh-tw')
		// 	$this -> session -> userdata('lang')='TW';
		if(!$this -> session -> userdata('lang'))
		{
			if (isset($_SESSION['LA']['lang']))
				$this -> session -> set_userdata('lang', $_SESSION['LA']['lang']);
			else
				$this -> session -> set_userdata('lang', "TW");

			$this -> set_language = $this -> data['lang'] = $this -> session -> userdata('lang');
			$this -> set_language = $this -> data['lang'] = $this -> session -> userdata('lang');
		}
		else {
			$this -> set_language = $this -> data['lang'] = $this -> session -> userdata('lang');
		}

		@session_write_close();
		
		
		$this -> load -> model('webconfig_model', 'mod_webconfig');
        $this -> web_title = $this -> mod_webconfig -> config($_SERVER['REQUEST_URI']);
		// language_header
		$this -> load -> model('language_model', 'mod_language');
		$lang = $this -> mod_language -> converter('999', $this -> session -> userdata('lang'));
		$this -> data = array_merge($this -> data, $lang);

		// language
		$lang = $this -> mod_language -> converter('3', $this -> session -> userdata('lang'));
		$this -> data = array_merge($this -> data, $lang);

		$lang = $this -> mod_language -> converter('998', $this -> session -> userdata('lang'));
		$this -> data = array_merge($this -> data, $lang);

		$lang = $this -> mod_language -> converter('997', $this -> session -> userdata('lang'));
		$this -> data = array_merge($this -> data, $lang);

        // helper
        $this->load->helper('url');

        // base_url
        $this->data['base_url'] = base_url();

        // model
		$this->load->model('business_model', 'mod_business');

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
        $m = $this->mod_business->select_from('member', array('member_id'=>$this->session->userdata('member_id')));

		//id on 菜單高亮處理
		$id_on_index = substr($_SERVER['REQUEST_URI'], 10);
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

                    $auth_cols  = '<a href="/share/setting/'.$auth.'" title="'.$this -> data['SharingSet'].'" alt="'.$this -> data['SharingSet'].'" style="width: '.$this->data['menu_width'].'; font-size:16px;">'.$this -> data['SharingSet'].'</a>';
                    $auth_title = $this -> data['SharingSet'];

                    break;

                case '02': // 第二層

                    $auth_cols  = '<a href="/quote/setting/'.$auth.'" title="'.$this -> data['ReferenceSet'].'" alt="'.$this -> data['ReferenceSet'].'" style="width: '.$this->data['menu_width'].'; font-size:16px;">'. $this -> data['ReferenceSet'] .'</a>';
                    $auth_title = $this -> data['ReferenceSet'];

                    break;
            }
        }
        else
        {
            switch ($auth)
            {
                case '01': // 第一層

                    $auth_cols  = '<a href="/share/setting/'.$auth.'" title="'.$this -> data['SharingSet'].'" alt="'.$this -> data['SharingSet'].'" style="width: '.$this->data['menu_width'].'; font-size:16px;">'.$this -> data['SharingSet'].'</a>';
                    $auth_title = $this -> data['SharingSet'];

                    break;

                case '02': // 第二層

                    $auth_cols_1  = '<a href="/middle/setting/'.$auth.'/share" title="'.$this -> data['SharingSet'].'" alt="'.$this -> data['SharingSet'].'" style="width: '.$this->data['menu_width'].'; font-size:16px;">'.$this -> data['SharingSet'].'</a>';
                    $auth_title_1 = $this -> data['SharingSet'];
                    $auth_cols_2  = '<a href="/middle/setting/'.$auth.'/quote" title="'.$this -> data['ReferenceSet'].'" alt="'.$this -> data['ReferenceSet'].'" style="width: '.$this->data['menu_width'].'; font-size:16px;">'.$this -> data['ReferenceSet'].'</a>';
                    $auth_title_2 = $this -> data['ReferenceSet'];

                    break;

                case '03': // 第三層

                    $auth_cols  = '<a href="/quote/setting/'.$auth.'" title="'.$this -> data['ReferenceSet'].'" alt="'.$this -> data['ReferenceSet'].'" style="width: '.$this->data['menu_width'].'; font-size:16px;">'.$this -> data['ReferenceSet'].'</a>';
                    $auth_title = $this -> data['ReferenceSet'];

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

        // 設定 web banner
        $this->data['web_banner_dir'] = $this->set_web_banner_dir($this->data['domain_id'], $this->data['web_config']['web_banner'], $this->data['host']['domain']);

		$this->data['real_ip'] = $this->get_realip();

		// 設定上架資料
		$this->data['release_setting'] = $m['instore'];

		$this -> load -> library('Common');


		//account
		$REQUEST_URI=$this->input->server('REQUEST_URI',true);
		$REQUEST_URI=explode('/',$REQUEST_URI);
		$REQUEST=$REQUEST_URI[3];
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

	//限制檔案只能下載，不在線上顯示
	private function SetDownload($member_id, $doc_id)
	{
		$language = $this -> language;
		$member = $this -> mod_business -> select_from('member', array('member_id' => $member_id));
		$file = $this -> mod_business -> select_from('documents', array('doc_id' => $doc_id));
        $string="";
		if(file_exists($file['doc_path']) and is_file($file['doc_path']))
		{
		    header("Content-type: ".filetype($file['doc_path']));//指定類型
		    header("Content-Disposition: attachment; filename=".$file['doc_name']."");//指定下載時的檔名
            header('Content-Type: application/octet-stream');
		    readfile($file['doc_path']);//輸出下載的內容。
        }
		else
			$string = $language['NoFileSearch'];

		echo $string;
	}

	public function publicpage($tempname='website_list',$id = '')
	{
		if($this->publiccheck($tempname,$id))
		{
			$data=$this->data;

			$this -> lang -> load('views/template/integrate/'. $tempname, $data['lang']);
			$data['AboutMeURL'] = lang('AboutMeURL');

			$this->load->view('template/integrate/'.$tempname, $data);
			$this->load->view('template/integrate_footer/' .$data['footer_mode_name'], $data);
		}
		else
		{
			redirect(base_url());
		}
	}

	public function team($id = '')
	{
		if($this->publiccheck('',$id))
		{
			$data=$this->data;

			$this -> lang -> load('views/template/temp'.$data['theme_id'].'/team', $data['lang']);
			$data['TeamData'] = lang('TeamData');
			$data['CompanyPage'] = lang('CompanyPage');
			$data['CompanyVideo'] = lang('CompanyVideo');
			$data['CompanyGallery'] = lang('CompanyGallery');
			$data['CompanyForm'] = lang('CompanyForm');
			$data['CompanyExfile'] = lang('CompanyExfile');
			$data['WebLink'] = lang('WebLink');
			$data['FriendTicket'] = lang('FriendTicket');
			$data['ShoppingCart'] = lang('ShoppingCart');

			$this -> lang -> load('views/template/template4_seo', $data['lang']);
			$data['BusinessSystem'] = lang('BusinessSystem');

			$this -> lang -> load('views/template/template4_headmenu', $data['lang']);
			$data['AboutMe'] = lang('AboutMe');
			$data['TeamSituation'] = lang('TeamSituation');


			$data['viewtype']='C';
			$this->load->view('template/temp'.$data['theme_id'].'/team' , $data);
		}
		else
		{
			redirect(base_url());
		}
	}

	public function film_cate($id,$cid,$viewtype)
	{
		$language = $this -> language;
		if($this->publiccheck('',$id))
		{
			$data=$this->data;
			$data['htmltitle']=$language['VideoList'];
			$this -> lang -> load('views/template/template4_seo', $data['lang']);
			$data['BusinessSystem'] = lang('BusinessSystem');

			if($viewtype == 'C')
			{
				$data['chkmemberid']=$this->member_id;
				$viewname=$language['Company'];
			}
			else{
				$data['chkmemberid']=$this->son_member_id;
				$viewname='';
			}
			$data['viewtype']=$viewtype;

			$data['film'] = $this->mod_business->select_from_order('strings', 'str_id', 'asc', array('member_id'=>$data['chkmemberid'],'type'=>'0','cid'=>$cid));
			$this->load->view('template/temp'.$data['theme_id'].'/film_cate', $data);
		}
		else
		{
			redirect(base_url());
		}
	}

	public function article_list2($id,$cid,$viewtype)
	{
		$language = $this -> language;
		if($this->publiccheck('',$id))
		{
			$data=$this->data;
			$data['htmltitle'] = $language['HtmlList'];

			$this -> lang -> load('views/template/template4_seo', $data['lang']);
			$data['BusinessSystem'] = lang('BusinessSystem');

			if($viewtype == 'C')
			{
				$data['chkmemberid']=$this->member_id;
				$viewname=$language['Company'];
			}
			else{
				$data['chkmemberid']=$this->son_member_id;
				$viewname='';
			}
			$data['viewtype']=$viewtype;

			$data['iqr_html']=$this->mod_business->select_from_order('iqr_html', 'html_sort', 'asc', array('member_id'=>$data['chkmemberid'],'classify_id'=>$cid));
			$this->load->view('template/temp'.$data['theme_id'].'/article_list2', $data);
		}
		else
		{
			redirect(base_url());
		}
	}

	public function enroll_list2($id,$cid,$viewtype)
	{
		$language = $this -> language;
		if($this->publiccheck('',$id))
		{
			$data=$this->data;
			$data['htmltitle']=$language['FormList'];

			$this -> lang -> load('views/template/template4_seo', $data['lang']);
			$data['BusinessSystem'] = lang('BusinessSystem');

			if($viewtype == 'C')
			{
				$data['chkmemberid']=$this->member_id;
				$viewname=$language['Company'];
			}
			else{
				$data['chkmemberid']=$this->son_member_id;
				$viewname='';
			}
			$data['viewtype']=$viewtype;

			$data['uform']=$this->mod_business->select_from_order('uform', 'ufm_cid', 'desc', array('member_id' => $data['chkmemberid'],'ufm_cid'=>$cid));
			$this->load->view('template/temp'.$data['theme_id'].'/enroll_list2', $data);
		}
		else
		{

			redirect(base_url());
		}
	}

	public function coupon_detail($id = '')
	{
		$language = $this -> language;
		if($this->publiccheck('',$id))
		{
			$data=$this->data;

			$this -> lang -> load('views/template/template3_seo', $data['lang']);
			$data['BusinessSystem'] = lang('BusinessSystem');

			$this -> lang -> load('views/ecoupon/ecoupon_detail', $data['lang']);
			$data['AboutMeEcoupon'] = lang('AboutMeEcoupon');

			$this->load->view('ecoupon/ecoupon_detail', $data);
		}
		else
		{

			redirect(base_url());
		}
	}

	public function gohomeurl($account)
	{
		redirect(base_url().'business/iqr/'.$account);
	}
	public function two_temp_list($id='' , $viewtype='',$templatename='')
	{
		$language = $this -> language;
		$this->publiccheck('',$id);
		$data=$this->data;
		if ($data['theme_id']<8){//版型不符
			$this->gohomeurl($id);
			exit;
		}

		$this -> lang -> load('views/template/template3_seo', $data['lang']);
		$data['BusinessSystem'] = lang('BusinessSystem');

		$this -> lang -> load('views/business/two_temp_list_view', $data['lang']);
		$data['AboutMe'] = lang('AboutMe');
		$data['Photo'] = lang('Photo');
		$data['Annex'] = lang('Annex');
		$data['Website'] = lang('Website');
		$data['Article'] = lang('Article');
		$data['Coupon'] = lang('Coupon');
		$data['Form'] = lang('Form');

		if($viewtype == 'C')
		{
			$data['chkmemberid']=$this->member_id;
			$viewname=$language['Company'];
		}
		else{
			$data['chkmemberid']=$this->son_member_id;
			$viewname='';
		}
		$film = '';
		if($templatename=='photo_list'){
			$picture= $this->mod_business->select_from_order('photo_category', 'd_sort', 'asc', array('d_member_id'=>$data['chkmemberid']));
			foreach ($picture as $key => $value) {
				$photo_array = $this -> get_serialstr($value['d_photo'], '*#');
				$img = $this -> mod_business -> select_from('images', array('img_id' => $photo_array[0]));
				$picture[$key]['first_img'] = substr($img['img_path'],1);
			}
			$data['data']=$picture;
		}elseif($templatename=='article_list'){

			$cate_sort = $this->mod_business->select_query('SELECT iqr_classify FROM iqr where member_id='.$data['chkmemberid']);
			//新自訂網頁
			if(!empty($cate_sort[0]['iqr_classify']))
			{
				$iqr_classify = $this -> get_serialstr($cate_sort[0]['iqr_classify'], '*#');
				foreach ($iqr_classify as $key => $value)
				{
					$temparray = $this->mod_business->select_query('SELECT a.classify_id,a.classify_name FROM iqr_classify as a ','where classify_id='.$value);
					$data_cate[]=$temparray[0];
				}
			}
			$iqr_html = $this->mod_business->select_from_order('iqr_html', 'html_sort', 'asc', array('member_id'=>$data['chkmemberid']));

			$data['data']=$iqr_html;
			$data['data_cate'] = $data_cate;
		}elseif($templatename=='enroll_list'){
			$data['data_cate'] = $this -> mod_business -> select_from_order('strings_category', 'cid', 'desc', array('member_id' => $data['chkmemberid'], 'type' => 'uform'));
			$data['uform']=$this->mod_business->select_from_order('uform', 'ufm_cid', 'desc', array('member_id' => $data['chkmemberid']));
		}elseif($templatename=='annex_list'){
			if($viewtype == 'C') {
				$this->set_mother_exfile();
				$data=$this->data;
			}
		}elseif($templatename=='website_list'){
			if($viewtype == 'C') {
				$this->set_website_list();
				$data=$this->data;
			}
		}elseif($templatename=='coupon_list'){
			if($viewtype == 'C') {
				$this->set_mother_ecoupon($viewtype,$id);
				$data=$this->data;
			}
		}else{ // film
			$film = $this->mod_business->select_from_order('strings', 'str_id', 'asc', array('member_id'=>$data['chkmemberid'],'type'=>'0'));
			//行動名片資料
			$data['iqr']=$this->mod_business->select_from('iqr', array('member_id'=>$data['chkmemberid']));

			if(!empty($data['iqr']['ytb_category']))
			{
				$data['film_cate'] = '';
				$Array_ytb_category = $this -> get_serialstr($data['iqr']['ytb_category'], '*#');
				foreach ($Array_ytb_category as $key => $value)
				{
					$data['film_cate'][] = $this -> mod_business -> select_from('strings_category', array('cid' => $value));
				}
			}
		}

		$data['film']=$film;
		$data['viewname'] = $viewname;
		$data['viewtype'] = $viewtype;

		if ($templatename=='')
			$templatename='film_list_'.$data['theme_id'];

		if ($data['theme_id']>=9){
			$this->load->view('template/temp'.$data['theme_id'].'/'.$templatename , $data);
		}else{
			$this->load->view('business/'.$templatename , $data);
			$this->load->view('template/integrate_footer/' .$data['footer_mode_name'], $data);
		}
	}

	public function set_mother_enroll()
	{
		$data=$this->data;
		$data['iqr']=$iqr=$this->mod_business->select_from('iqr', array('member_id'=>$this->member_id));
		$ufm_id_array=$this->get_serialstr($iqr['uform'], '*#');
		foreach($ufm_id_array as $key => $value)
		{
			$uform=$this->mod_business->select_from('uform', array('ufm_id'=>$value));
			if(!empty($uform) && $uform['ufm_status'] != 0)
			{
				//按鈕名稱
				if($uform['ufm_btn_name'] != '')
					$data['ufm_btn_name'][$key]=$uform['ufm_btn_name'];
				else
					$data['ufm_btn_name'][$key]=$uform['ufm_name'];
				//id
				$data['ufm_id'][$key]=$uform['ufm_id'];
			}
		}
		$data['uform_show']=true;
		$this->data=$data;
	}

	public function set_mother_ecoupon($viewtype,$appacount)
	{
		$data=$this->data;
		$member=$this->mod_business->select_from('member', array('member_id'=>$this->member_id));
		//iqr
		$data['iqr']=$iqr=$this->mod_business->select_from('iqr', array('member_id'=>$this->member_id));
		$data['ecp_show']=true;
		$ecp_id=$this->get_serialstr($iqr['ecoupon'], '*#');
		if (!empty($ecp_id)){
			foreach($ecp_id as $key => $value)
			{
				$ecp=$this->mod_business->select_from('ecoupon', array('ecp_id'=>$value));
				$data['ecp_url_name'][$key] = $ecp['name'];
				$data['ecp_content'][$key]  = $ecp['content'];
				$data['ecp_btn_name'][$key] = $ecp['btn_name'];
				// image data uri
				$ecp_img_path = $member['img_url'] .'coupon/'. $ecp['filename'];
				$data['ecp_img'][$key] = Common::get_data_uri(substr($ecp_img_path, 1));

				// share mode
				switch ($ecp['mode']) {
					case 1:
						$data['ecp_Ppath'][$key] = base_url() . substr($member['img_url'], 1) . 'coupon/' .$ecp['filename'];
						$data['ecp_url'][$key]   = $ecp['mode_1'];
						$data['ecp_title'][$key] = $ecp['name'];
						break;
					case 2:
						$data['ecp_Ppath'][$key] = base_url() . substr($member['img_url'], 1) . 'coupon/' .$ecp['filename'];
						$data['ecp_url'][$key]   = $ecp['mode_2'];
						$data['ecp_title'][$key] = $ecp['name'];
						break;
					case 3:
						$data['ecp_Ppath'][$key] = base_url() . substr($member['img_url'], 1) . 'coupon/' .$ecp['filename'];
						$data['ecp_url'][$key]   = base_url() ."business/ecoupon_editor/" .$ecp['member_id'] . "/" . $ecp['ecp_id'];
						$data['ecp_title'][$key] = $ecp['name'];
						break;
				}
				$ecp[$key] = array(
					"path" 		=> $data['ecp_Ppath'][$key],
					"ecp_url" 	=> $data['ecp_url'][$key],
					"ecp_title" => $data['ecp_title'][$key]
				);
				$data['jecp'][$key] = "path=" . $data['ecp_Ppath'][$key] . "&ecp_url=" . $data['ecp_url'][$key] . "&ecp_title=" . $data['ecp_title'][$key];
				$data['ecp_url_detail'][$key] = base_url() ."business/ecoupon_editor/" .$ecp['member_id'] . "/" . $ecp['ecp_id'].'/ecoupon_detail/'.$appacount;

			}
		}else{
			$data['ecp_show']=false;
		}
		$this->data=$data;
	}

	public function set_mother_exfile()
	{
		$language = $this -> language;
		$data=$this->data;
		$data['iqr']=$iqr=$this->mod_business->select_from('iqr', array('member_id'=>$this->member_id));
		$temp_exfile=$this->get_serialstr($data['iqr']['exfile'], '*#');
		$data['doc_path']='';
		$data['doc_name']='';
		foreach($temp_exfile as $key => $value)
		{
			$doc=$this->mod_business->select_from('documents', array('doc_id'=>$value));
			if(!empty($doc))
			{
				$data['doc_path'][]=$this->mod_business->get_doc_path($value);
				if($doc['doc_name'] != '')
					$data['doc_name'][]=$doc['doc_name'];
				else
					$data['doc_name'][]=$Annex.($key+1);
			}
		}
		$this->data=$data;
	}

	public function chkphoto_detail_data($detail_id)
	{
		$data=$this->data;
		if($detail_id != '')
		{
			$photo_category=$this->mod_business->select_from('photo_category', array('d_id'=>$detail_id));
			$data['photo_category_name']=$photo_category['d_name'];
		}
		else
		{
			redirect(base_url());
		}
		if(!empty($photo_category))
		{
			if(!empty($photo_category['d_photo']))
			{
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
					if(!empty($img))
					{
						$data['public_share_pict_Ppath'] = base_url() .$data['myphoto'][0];
						$data['public_share_title'] = $data['myphoto_name'][0].' photo';
					}
				}
				$data['share_link'] = base_url() . 'company/film_share/' . $base .'/'. $id;
				if($this->get_device_type()>=1) {//手機>=1
					$data['public_share_url']   = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

				}else{
					$data['public_share_url']   = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
				}
				$data['public_share_buttom_url']   = 'jecp://path='.$data['public_share_pict_Ppath'].'&ecp_url='.$data['public_share_url'].'&ecp_title='.$data['public_share_title'];

			};
			$this->data=$data;
		}
		else
		{
			redirect(base_url());
		}
	}

	public function data_detail($base='',$detail_id , $viewtype='',$templatename='')
	{

		$language = $this -> language;
		$this->publiccheck('',$base);
		$data=$this->data;
		if ($data['theme_id']<8){//版型不符
			$this->gohomeurl($base);
			exit;
		}

		$this -> lang -> load('views/template/template4_seo', $data['lang']);
		$data['BusinessSystem'] = lang('BusinessSystem');

		$this -> lang -> load('views/business/edit_integrate', $data['lang']);
		if($viewtype == 'C')
		{
			$data['chkmemberid']=$this->member_id;
			$viewname=$language['Company'];
		}
		else{
			$data['chkmemberid']=$this->son_member_id;
			$viewname='';
		}

		$film = '';
		if($templatename=='photo_detail'){
			$this->chkphoto_detail_data($detail_id);
			$data=$this->data;
		}elseif($templatename=='article_detail'){
			$iqr_html = $this->mod_business->select_from_order('iqr_html', 'member_id', 'desc', array('html_id'=>$detail_id));
			$data['data']=$iqr_html;
			$data['public_share_pict_Ppath'] = $this->chksharepict($data['logo_path_url']);
			$data['public_share_title'] = $iqr_html[0]['html_name'];
			if($this->get_device_type()>=1) {//手機>=1
				$data['public_share_url']   = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
				$data['public_share_buttom_url']   = 'jecp://path='.$data['public_share_pict_Ppath'].'&ecp_url='.$data['public_share_url'].'&ecp_title='.$data['public_share_title'];
			}else{
				$data['public_share_url']   = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			};
			$data['public_barcodeurl'] =base_url()."app/route/".$this->son_member_id;
		}elseif($templatename=='enroll_detail'){
			$film = $this->mod_business->select_from_order('strings', 'str_id', 'desc', array('member_id'=>$data['chkmemberid'],'type'=>'3'));
		}elseif($templatename=='website_detail'){
			$film = '';
		}else{ // film
			$film = $this->mod_business->select_from_order('strings', 'str_id', 'desc', array('member_id'=>$data['chkmemberid'],'type'=>'0'));
		}

		$data['film']=$film;
		$data['viewname'] = $viewname;
		$data['viewtype'] = $viewtype;

		if ($templatename=='') $templatename='film_list_'.$data['theme_id'];

		if ($data['theme_id']>=9){
			$this -> lang -> load('views/template/template4_seo', $data['lang']);
			$data['BusinessSystem'] = lang('BusinessSystem');

			$this -> lang -> load('views/template/template4_headmenu', $data['lang']);
			$data['AboutMe'] = lang('AboutMe');
			$data['TeamSituation'] = lang('TeamSituation');

			$this->load->view('template/temp'.$data['theme_id'].'/'.$templatename , $data);
		}else{
			$this -> lang -> load('views/template/template3_seo', $data['lang']);
			$data['BusinessSystem'] = lang('BusinessSystem');

			$this -> lang -> load('views/business/two_temp_list_view', $data['lang']);
			$data['AboutMe'] = lang('AboutMe');
			$data['Photo'] = lang('Photo');
			$data['Annex'] = lang('Annex');
			$data['Website'] = lang('Website');
			$data['Article'] = lang('Article');
			$data['Coupon'] = lang('Coupon');
			$data['Form'] = lang('Form');

			$this->load->view('business/'.$templatename , $data);
			$this->load->view('template/integrate_footer/' .$data['footer_mode_name'], $data);
		}
	}

	//set_website_list data
	public function set_website_list()
	{
		$language = $this -> language;
		$data=$this->data;
		$data['iqr']=$iqr=$this->mod_business->select_from('iqr', array('member_id'=>$this->member_id));

		//strings items
			$strings_items = array(
				0 => 'ytb_link',
				1 => 'website',
				2 => 'address',
				3 => 'titlename',
				4 => 'mobile_phones'
			);
			$data['website']='';

			foreach($strings_items as $s_i_key => $s_i_value)
			{
				${$s_i_value.'_id'} = $this->get_serialstr($iqr[$s_i_value], '*#');
				if(!empty(${$s_i_value.'_id'}))
				{
					$data[$s_i_value.'_name']='';
					${$s_i_value.'_num'}=0;
					$sortnum = 0;
					foreach(${$s_i_value.'_id'} as $key => $value)
					{
						$str = $this->mod_business->select_from('strings', array('str_id'=>$value));

						${$s_i_value.'_num'}++;
						if($s_i_value == 'ytb_link'){
							$data[$s_i_value][] = $this->get_ytb_id($str['str']);
						}else
							$data[$s_i_value][] = $str['str'];
						$data[$s_i_value.'_id'][] = $str['str_id'];
						if($s_i_value != 'titlename')
						{
							switch ($s_i_key) {
								case 0:
									$data[$s_i_value.'_name'][]	= ($str['str_name'] != '') ? $str['str_name'] : $language['Movie'].$sortnum ;
									break;
								case 1:
									$data[$s_i_value.'_name'][]	= ($str['str_name'] != '') ? $str['str_name'] : $language['Web'].$sortnum ;
									break;
								case 2:
									$data[$s_i_value.'_name'][]	= ($str['str_name'] != '') ? $str['str_name'] : $language['Map'].$sortnum ;
									break;
								case 4:
									$data[$s_i_value.'_name'][]	= ($str['str_name'] != '') ? $str['str_name'] : $language['CallMyMobilePhone']. ' ' .$sortnum ;
									break;
							}
							$sortnum++;
						}
					}
					$data[$s_i_value.'_num'] = ${$s_i_value.'_num'};
				}
			}
			$this->data=$data;
	}

	//名片頁顯示頁面
	public function iqr($id='')
	{
		// if ($this -> get_realip() == '111.246.97.78'){
		// 	print_r($this->session->userdata('lang'));
		// 	print_r($_SESSION);
		// }

		$data=$this->data;
		$lang = $this -> mod_language -> converter('13', $this -> session -> userdata('lang'));
		$data = array_merge($data, $lang);
		if($id != '')
		{
			$member=$this->mod_business->select_from('member', array('account'=>$id));
			$data['aid'] = $member['account'];
		}
		else
		{
            if (!empty($_SESSION['MT']['member_id'])) {
			    $member=$this->mod_business->select_from('member', array('member_id'=>$_SESSION['MT']['member_id']));
			    $data['aid'] = $member['account'];
            } else {
    			redirect('/gold/login');
            }
		}

		if(!empty($member))
		{
			//判斷使用期限
			if(!$this->check_deadline($data['web_config'], $member['member_id']))
			{
				redirect('/index/error');
			}

			//iqr
			$data['iqr']=$iqr=$this->mod_business->select_from('iqr', array('member_id'=>$member['member_id']));
			//名片流量計數器
			$this->mod_business->iqr_views_add($iqr['iqr_id'], $this->get_realip());

			// logo
			$data['logo_path'] = Common::get_data_uri($iqr['logo_path']);

			//web return
			$this->session->set_userdata('web_return', $id);

			//helper
			$this->load->helper('form');

			//base url
			$data['base_url']=base_url();

			//account
			$data['account']=$id;
			$data['mid']=$member['member_id'];

			//name
			if($iqr['f_name'] != '')
				$data['iqr_name']=$iqr['l_name'].$iqr['f_name'];
			else
				$data['iqr_name']=$data['account'] ;
			$data['iqr_name'] .= $data['AboutKT'];

			//en_name
			if($iqr['f_en_name'] != '')
				$data['iqr_en_name']=$iqr['l_en_name'].' '.$iqr['f_en_name'] ;
			else
				$data['iqr_en_name']=$data['account'];

			// qrcode btn show/hide
			$data['web_btn']     = $this -> mod_business -> select_from('qrc_style', array('member_id' => $member['member_id'], 'type' => 0));
			$data['contact_btn'] = $this -> mod_business -> select_from('qrc_style', array('member_id' => $member['member_id'], 'type' => 1));
			$data['app_btn']     = $this -> mod_business -> select_from('qrc_style', array('member_id' => $member['member_id'], 'type' => 2));

			//qrcode btn name
			$data['web_btn_name'] 	  = ($iqr['iqr_qrcode_web'] != '') 		? $iqr['iqr_qrcode_web'] 	 : $data['SystemWeb'];
			$data['app_btn_name'] 	  = ($iqr['iqr_qrcode_app'] != '') 		? $iqr['iqr_qrcode_app'] 	 : $data['SystemApp'];
			$data['contact_btn_name'] = ($iqr['iqr_qrcode_contact'] != '') 	? $iqr['iqr_qrcode_contact'] : $data['Contacts'];

			//行動名片連結
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

			//header title
				$default_title = $this -> mod_business -> select_from('system_header', array('theme_id' => $iqr['theme_id']));
				$default_title = $this -> get_serialstr($default_title['header_default'], '*#');
				$header_array = $this -> get_serialstr($iqr['str_header'], '*#');

				if(count($header_array) != count($default_title))
				{
					if(!empty($default_title))
					{
						foreach ($default_title as $key => $value)
						{
							$data['title_text'][$key] = $value;
						}
					}
				}
				else
				{
					if($iqr['theme_id']==2){
						foreach ($header_array as $key => $value)
						{
							$data['title_text'][$key] = $value;
						}
					}
				}
			//photo
				$data['photo_show'] = false;
				$photo_category = $this -> mod_business -> select_from_order('photo_category', 'd_sort', 'asc', array('d_member_id' => $member['member_id'], 'd_enable' => 'Y'));
				if(!empty($photo_category))
				{
					foreach ($photo_category as $key => $value)
					{
						if(!empty($value['d_photo']))
						{
							$photo_array = $this -> get_serialstr($value['d_photo'], '*#');

							$image = $this -> mod_business -> select_from('images', array('img_id' => $photo_array[0]));
							$data['photo_category'][$key]['L_image'] = base_url() . substr($image['img_path'], 1);
							$data['photo_category'][$key]['show'] = true;
						}
						else
						{
							$photo_array = '';
							$data['photo_category'][$key]['L_image'] = '';
							$data['photo_category'][$key]['show'] = false;
						}
						$data['photo_category'][$key]['d_id'] = $value['d_id'];
					}
					$data['photo_show'] = true;
				}
			//strings items
				$strings_items = array(
					0 => 'ytb_link',
					1 => 'website',
					2 => 'address',
					3 => 'titlename',
					4 => 'mobile_phones'
				);
				foreach($strings_items as $s_i_key => $s_i_value)
				{
					${$s_i_value.'_id'} = $this->get_serialstr($iqr[$s_i_value], '*#');
					if(!empty(${$s_i_value.'_id'}))
					{
						$sortnum = 0;
						foreach(${$s_i_value.'_id'} as $key => $value)
						{
							$str = $this->mod_business->select_from('strings', array('str_id'=>$value));

							${$s_i_value.'_num'}++;

							if($s_i_value == 'ytb_link')
								$data[$s_i_value][] = $this->get_ytb_id($str['str']);
							else
								$data[$s_i_value][] = $str['str'];
							$data[$s_i_value.'_id'][] = $str['str_id'];
							if($s_i_value != 'titlename')
							{
								switch ($s_i_key) {
									case 0:
										$data[$s_i_value.'_name'][]	= ($str['str_name'] != '') ? $str['str_name'] : $data['Movie'].$sortnum ;
										break;
									case 1:
										$data[$s_i_value.'_name'][]	= ($str['str_name'] != '') ? $str['str_name'] : $data['Web'].$sortnum ;
										break;
									case 2:
										$data[$s_i_value.'_name'][]	= ($str['str_name'] != '') ? $str['str_name'] : $data['Map'].$sortnum ;
										break;
									case 4:
										$data[$s_i_value.'_name'][]	= ($str['str_name'] != '') ? $str['str_name'] : $data['CallMyMobilePhone']. ' ' .$sortnum ;
										break;
								}
								$sortnum++;
							}
						}
						$data[$s_i_value.'_num'] = ${$s_i_value.'_num'};
					}
				}
			//mobile
				if($iqr['mobile'] != '')
				{
					$data['mobile_show']=true;
					$data['mobile']=$iqr['mobile'];
					if($iqr['mobile_name'] != '')
						$data['mobile_name']=$iqr['mobile_name'];
					else
						$data['mobile_name']=$data['CallMyMobilePhone'];
				}
				else
				{
					$data['mobile_show']=false;
				}
			//email
				if($iqr['email'] != '')
				{
					$data['email_show']=true;
					$data['email']=$iqr['email'];
					if($iqr['email_name'] != '')
						$data['email_name']=$iqr['email_name'];
					else
						$data['email_name']=$data['YourMail'];
				}
				else
				{
					$data['email_show']=false;
				}
			//skype
				if($iqr['skype'] != '')
				{
					$data['skype_show']=true;
					$data['skype']=$iqr['skype'];
					if($iqr['skype_name'] != '')
						$data['skype_name']=$iqr['skype_name'];
					else
						$data['skype_name']=$data['SkypeCall'];
				}
				else
				{
					$data['skype_show']=false;
				}
			//facebook
				if($iqr['facebook'] != '')
				{
					$data['facebook_show']=true;
					$data['facebook']=$iqr['facebook'];
					if($iqr['facebook_name'] != '')
						$data['facebook_name']=$iqr['facebook_name'];
					else
						$data['facebook_name']=$data['MyFacebook'];
				}
				else
				{
					$data['facebook_show']=false;
				}
			//line
				if($iqr['line'] != '')
				{
					$data['line_show']=true;
					$data['line']=$iqr['line'];
					if($iqr['line_name'] != '')
						$data['line_name']=$iqr['line_name'];
					else
						$data['line_name']=$data['AddLineFriend'];
				}
				else
				{
					$data['line_show']=false;
				}
			//mecard
				if(($iqr['firstname'] != '' || $iqr['lastname'] != '') && ($iqr['mphone'] != '' || $iqr['cpn_tel'] != ''))
				{
					$data['mecard_show']=true;
				}
				else
				{
					$data['mecard_show']=false;
				}
			//cpn_phone
				if($iqr['cpn_phone'] != '')
				{
					$data['cpn_phone_show']=true;
					$data['cpn_phone']=$iqr['cpn_phone'];
					if($iqr['cpn_phone_name'] != '')
						$data['cpn_phone_name']=$iqr['cpn_phone_name'];
					else
						$data['cpn_phone_name']=$data['CompanyPhone'];
					if($iqr['cpn_extension'] != '')
						$data['cpn_extension']=','.$iqr['cpn_extension'];
					else
						$data['cpn_extension']='';
				}
				else
				{
					$data['cpn_phone_show']=false;
				}
			//cpn_cfax
				if($iqr['cpn_cfax'] != '')
				{
					$data['cpn_cfax_show'] = true;
					$data['cpn_cfax'] = $iqr['cpn_cfax'];
					if($iqr['cpn_fax_name'] != '')
						$data['cpn_fax_name'] = $iqr['cpn_fax_name'];
					else
						$data['cpn_fax_name'] = $data['Fax'];
				}
				else
				{
					$data['cpn_cfax_show'] = false;
				}
			//cpn_number
				if($iqr['cpn_number'] != '')
				{
					$data['cpn_number_show']=true;
					$data['cpn_number']=$iqr['cpn_number'];
					if($iqr['cpn_number_name'] != '')
						$data['cpn_number_name']=$iqr['cpn_number_name'];
					else
						$data['cpn_number_name']=$data['ShowUniform'];
				}
				else
				{
					$data['cpn_number_show']=false;
				}
			//exfile
				if($iqr['exfile'] != '')
				{
					$temp_exfile=$this->get_serialstr($data['iqr']['exfile'], '*#');
					foreach($temp_exfile as $key => $value)
					{
						$doc=$this->mod_business->select_from('documents', array('doc_id'=>$value));
						if(!empty($doc))
						{
							$data['doc_path'][]=$this->mod_business->get_doc_path($value);
							if($doc['doc_name'] != '')
								$data['doc_name'][]=$doc['doc_name'];
							else
								$data['doc_name'][]=$data['Annex'].($key+1);
						}
					}
					$data['exfile_show']=true;
				}
				else
				{
					$data['exfile_show']=false;
				}
			//cpn_photo
				$data['cpn_photo_show']   = false;
				$data['cpn_photo_note']   = '';
				$data['cpn_photo_amount'] = 0;
				if($iqr['cpn_photo'] != '')
				{
					$temp_cpn_photo = $this->get_serialstr($iqr['cpn_photo'], '*#');
					foreach($temp_cpn_photo as $key => $value)
					{
						$img 		   = $this->mod_business->select_from('images', array('img_id'=>$value));
						$cpn_photo_src = $this->mod_business->get_img_path($value);
						if($cpn_photo_src != '')
						{
							$data['cpn_photo_src']  .= '<img src=\''.base_url().substr($cpn_photo_src, 1).'\'>';
							$data['cpn_photo_note'] .= ',';
							$data['cpn_photo_note'] .= '"'.trim($img['img_note']).'"';
						}
					}
					$data['cpn_photo_amount'] = count($temp_cpn_photo);
					$data['cpn_photo_show']   = true;
				}
			//cart
				if($data['web_config']['cart_status'] == 1)
				{
					$cart = $this->mod_business->select_from('iqr_cart', array('member_id'=>$member['member_id']));
					$data['cart_link']   = base_url().'cart/store/'.$cart['cset_code'];
					$data['cset_name']   = ($cart['cset_name'] != '') ? $cart['cset_name'] : $data['StorePage'];
					$data['cset_active'] = $cart['cset_active'];
				}
			//icon
				$dirname = '.'.$member['img_url'].'icon/';
				$icon = glob($dirname."icon.png", GLOB_BRACE);//{*.gif,*.jpg,*.jpeg,*.png,*.GIF,*.JPG,*.PNG}
				if(!is_file($icon[0]) || $iqr['icon_status'] == 0)
					$data['icon'] = '/images/web_style_images/'.$data['web_banner_dir'].'/app_welcome_page/icon100x100.png';
				else
				{
					$icon = glob($dirname."icon100x100.png", GLOB_BRACE);
					$data['icon'] = substr($icon[0], 1);
				}
            //coupon
                if($iqr['ecoupon'] != '')
                {
                    $data['ecp_show']=true;
                    $ecp_id=$this->get_serialstr($iqr['ecoupon'], '*#');
                    foreach($ecp_id as $key => $value)
                    {
                        $ecp=$this->mod_business->select_from('ecoupon', array('ecp_id'=>$value));
                        $data['ecp_url_name'][$key] = $ecp['name'];
                        $data['ecp_content'][$key]  = $ecp['content'];
                        $data['ecp_btn_name'][$key] = $ecp['btn_name'];
                        // image data uri
                        $ecp_img_path = $member['img_url'] .'coupon/'. $ecp['filename'];
                        $data['ecp_img'][$key] = Common::get_data_uri(substr($ecp_img_path, 1));

                        // share mode
                        switch ($ecp['mode']) {
                        	case 1:
		                        $data['ecp_Ppath'][$key] = base_url() . substr($member['img_url'], 1) . 'coupon/' .$ecp['filename'];
								$data['ecp_url'][$key]   = $ecp['mode_1'];
								$data['ecp_title'][$key] = $ecp['name'];
                        		break;
                        	case 2:
		                        $data['ecp_Ppath'][$key] = base_url() . substr($member['img_url'], 1) . 'coupon/' .$ecp['filename'];
								$data['ecp_url'][$key]   = $ecp['mode_2'];
								$data['ecp_title'][$key] = $ecp['name'];
                        		break;
                        	case 3:
		                        $data['ecp_Ppath'][$key] = base_url() . substr($member['img_url'], 1) . 'coupon/' .$ecp['filename'];
		                        // $data['ecp_Ppath'][$key] = substr($member['img_url'], 1) . 'coupon/' .$ecp['filename'];
								$data['ecp_url'][$key]   = base_url() ."business/ecoupon_editor/" .$ecp['member_id'] . "/" . $ecp['ecp_id'];
								$data['ecp_title'][$key] = $ecp['name'];
                        		break;
                        }
                        $ecp[$key] = array(
                        	"path" 		=> $data['ecp_Ppath'][$key],
                        	"ecp_url" 	=> $data['ecp_url'][$key],
                        	"ecp_title" => $data['ecp_title'][$key]
                        );

                        // $data['jecp'][$key] = json_encode($ecp[$key]);
                        $data['jecp'][$key] = "path=" . $data['ecp_Ppath'][$key] . "&ecp_url=" . $data['ecp_url'][$key] . "&ecp_title=" . $data['ecp_title'][$key];
                    }
                }
                else
                {
                    $data['ecp_show']=false;
                }
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
				$data['bg_image_path'] = ($iqr['theme_bg_image_path'] != '') ? $iqr['theme_bg_image_path'] : $theme['dfu_bg_image_path'];
				// $data['bg_image_path'] = Common::get_data_uri(substr($bg_image_path, 1));
			//banner
				if($data['web_config']['g_free_link_status'] == 1)//開啟全局免費體驗設定
				{
					$data['banner_show']=true;
					if($data['web_config']['free_link_name'] != '')
						$data['banner_name']=$data['web_config']['free_link_name'];
					else
						$data['banner_show']=false;
				}
				else//使用個別免費體驗設定
				{
					//預設開啟給會員設定免費體驗連結是否顯示
					if($iqr['banner_status'] == 1)
					{
						$data['banner_show']=true;
						if($iqr['banner_status_name'] != '')
							$data['banner_name']=$iqr['banner_status_name'];
						else
							$data['banner_name']=$data['FreeActionCards'];
					}
					else
					{
						$data['banner_show']=false;
					}
				}
			//form
				if($iqr['uform'] != '')
				{
					$ufm_id_array=$this->get_serialstr($iqr['uform'], '*#');
					foreach($ufm_id_array as $key => $value)
					{
						$uform=$this->mod_business->select_from('uform', array('ufm_id'=>$value));
						if(!empty($uform) && $uform['ufm_status'] != 0)
						{
							//按鈕名稱
							if($uform['ufm_btn_name'] != '')
								$data['ufm_btn_name'][$key]=$uform['ufm_btn_name'];
							else
								$data['ufm_btn_name'][$key]=$uform['ufm_name'];
							//id
							$data['ufm_id'][$key]=$uform['ufm_id'];
						}
					}
					if(count($data['ufm_id']) != '')
						$data['uform_show']=true;
					else
						$data['uform_show']=false;
				}
				else
				{
					$data['uform_show']=false;
				}
			//iqr_html_page
				if(!empty($iqr['iqr_html']))
				{
					$data['iqr_html_page'] = $this -> mod_business -> select_from_order('iqr_html', 'html_sort', 'asc', array('member_id' => $member['member_id']));
				}

			$data['iqr_html']=0;
			if($this->check_ipad() == 0)
			{
				$data['iqr_img_double']=1;
				$data['iqr_img_ipad']=0;
			}
			else
			{
				$data['iqr_img_double']=0;
				$data['iqr_img_ipad']=1;
			}

			// 圖檔字首檢查
			if($data['cpn_photo_show'] && substr($data['cpn_photo_note'], 0, 1) == ',')
				$data['cpn_photo_note'] = substr($data['cpn_photo_note'], 1);

			$data['id']    = $member['account'];
			$data['store'] = $this -> mod_business -> select_from('iqr_cart', array('member_id' => $member['member_id']));

			if ($theme['theme_id']==8){
				$this->publiccheck('',$id);
				$data=$this->data;
			}
			$mother_store=$this -> mod_business -> select_from('iqr_cart', array('member_id' => $this->member_id));
			$data['mother_cset_code'] = $mother_store['cset_code'];

			//view
			$this->load->view('template/integrate/'.$view_name, $data);
			$this->load->view('template/integrate_footer/' .$theme['footer_mode_name'], $data);
		}
		else
		{
			redirect(base_url());
		}
	}

	public function about($id = '')
	{
		$language = $this -> language;
		$data=$this->data;

		if($id != '')
		{
			$member=$this->mod_business->select_from('member', array('account'=>$id));
			$data['account'] = $member['account'];
		}
		else
		{
			redirect(base_url());
		}

		if(!empty($member))
		{
			//判斷使用期限
			if(!$this->check_deadline($data['web_config'], $member['member_id']))
			{
				redirect('/index/error');
			}

			//iqr
			$data['iqr']=$iqr=$this->mod_business->select_from('iqr', array('member_id'=>$member['member_id']));

			//名片流量計數器
			$this->mod_business->iqr_views_add($iqr['iqr_id'], $this->get_realip());

			//helper
			$this->load->helper('form');

			// logo
			$data['logo_path'] = Common::get_data_uri($iqr['logo_path']);


			//base url
			$data['base_url']=base_url();

			//account
			$data['account']=$id;
			$data['mid']=$member['member_id'];

			//name
			if($iqr['f_name'] != '')
				$data['iqr_name']=$iqr['l_name'].$iqr['f_name'];
			else
				$data['iqr_name']=$data['account'];

			//en_name
			if($iqr['f_en_name'] != '')
				$data['iqr_en_name']=$iqr['l_en_name'].$iqr['f_en_name'];
			else
				$data['iqr_en_name']=$data['account'];


			// qrcode btn show/hide
			$data['web_btn']     = $this -> mod_business -> select_from('qrc_style', array('member_id' => $member['member_id'], 'type' => 0));
			$data['contact_btn'] = $this -> mod_business -> select_from('qrc_style', array('member_id' => $member['member_id'], 'type' => 1));
			$data['app_btn']     = $this -> mod_business -> select_from('qrc_style', array('member_id' => $member['member_id'], 'type' => 2));

			//qrcode btn name
			$data['web_btn_name'] 	  = ($iqr['iqr_qrcode_web'] != '') 		? $iqr['iqr_qrcode_web'] 	 : $language['SystemWeb'];
			$data['app_btn_name'] 	  = ($iqr['iqr_qrcode_app'] != '') 		? $iqr['iqr_qrcode_app'] 	 : $language['SystemApp'];
			$data['contact_btn_name'] = ($iqr['iqr_qrcode_contact'] != '') 	? $iqr['iqr_qrcode_contact'] : $language['Contacts'];

			//行動名片連結
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

			//mobile
				if($iqr['mobile'] != '')
				{
					$data['mobile_show']=true;
					$data['mobile']=$iqr['mobile'];
					if($iqr['mobile_name'] != '')
						$data['mobile_name']=$iqr['mobile_name'];
					else
						$data['mobile_name']=$language['CallMyMobilePhone'];
				}
				else
				{
					$data['mobile_show']=false;
				}
				if($iqr['mobile_phones'] != "")
				{
					$mobile_phones = $this -> get_serialstr($iqr['mobile_phones'], "*#");
					if(!empty($mobile_phones))
					{
						foreach ($mobile_phones as $key => $value)
						{
							$mobile_phones_num++;
							$str_mobile = $this -> mod_business -> select_from('strings', array('str_id' => $value, 'type' => 4));
							$data['mobile_phones'][] = $str_mobile['str'];
							$data['mobile_phones_name'][] = ($str_mobile['str_name'] != '') ? $str_mobile['str_name'] : $language['CallMyMobilePhone'] .' '. $mobile_phones_num;
						}
						$data['mobile_phones_num'] = $mobile_phones_num;
					}
				}
			//email
				if($iqr['email'] != '')
				{
					$data['email_show']=true;
					$data['email']=$iqr['email'];
					if($iqr['email_name'] != '')
						$data['email_name']=$iqr['email_name'];
					else
						$data['email_name']=$language['WriteToEmail'];
				}
				else
				{
					$data['email_show']=false;
				}
			//skype
				if($iqr['skype'] != '')
				{
					$data['skype_show']=true;
					$data['skype']=$iqr['skype'];
					if($iqr['skype_name'] != '')
						$data['skype_name']=$iqr['skype_name'];
					else
						$data['skype_name']=$language['SkypeCall'];
				}
				else
				{
					$data['skype_show']=false;
				}
			//facebook
				if($iqr['facebook'] != '')
				{
					$data['facebook_show']=true;
					$data['facebook']=$iqr['facebook'];
					if($iqr['facebook_name'] != '')
						$data['facebook_name']=$iqr['facebook_name'];
					else
						$data['facebook_name']=$language['MyFacebook'];
				}
				else
				{
					$data['facebook_show']=false;
				}
			//line
				if($iqr['line'] != '')
				{
					$data['line_show']=true;
					$data['line']=$iqr['line'];
					if($iqr['line_name'] != '')
						$data['line_name']=$iqr['line_name'];
					else
						$data['line_name']=$language['AddLineFriend'];
				}
				else
				{
					$data['line_show']=false;
				}
			//mecard
				if(($iqr['firstname'] != '' || $iqr['lastname'] != '') && ($iqr['mphone'] != '' || $iqr['cpn_tel'] != ''))
				{
					$data['mecard_show']=true;
				}
				else
				{
					$data['mecard_show']=false;
				}
			//cpn_phone
				if($iqr['cpn_phone'] != '')
				{
					$data['cpn_phone_show']=true;
					$data['cpn_phone']=$iqr['cpn_phone'];
					if($iqr['cpn_phone_name'] != '')
						$data['cpn_phone_name']=$iqr['cpn_phone_name'];
					else
						$data['cpn_phone_name']=$language['CompanyPhone'];
					if($iqr['cpn_extension'] != '')
						$data['cpn_extension']=','.$iqr['cpn_extension'];
					else
						$data['cpn_extension']='';
				}
				else
				{
					$data['cpn_phone_show']=false;
				}
			//cpn_cfax
				if($iqr['cpn_cfax'] != '')
				{
					$data['cpn_cfax_show'] = true;
					$data['cpn_cfax'] = $iqr['cpn_cfax'];
					if($iqr['cpn_fax_name'] != '')
						$data['cpn_fax_name'] = $iqr['cpn_fax_name'];
					else
						$data['cpn_fax_name'] = $language['Fax'];
				}
				else
				{
					$data['cpn_cfax_show'] = false;
				}
			//cpn_number
				if($iqr['cpn_number'] != '')
				{
					$data['cpn_number_show']=true;
					$data['cpn_number']=$iqr['cpn_number'];
					if($iqr['cpn_number_name'] != '')
						$data['cpn_number_name']=$iqr['cpn_number_name'];
					else
						$data['cpn_number_name']=$language['ShowUniform'];
				}
				else
				{
					$data['cpn_number_show']=false;
				}
			//exfile
				if($iqr['exfile'] != '')
				{
					$temp_exfile=$this->get_serialstr($data['iqr']['exfile'], '*#');
					foreach($temp_exfile as $key => $value)
					{
						$doc=$this->mod_business->select_from('documents', array('doc_id'=>$value));
						if(!empty($doc))
						{
							$data['doc_path'][]=$this->mod_business->get_doc_path($value);
							if($doc['doc_name'] != '')
								$data['doc_name'][]=$doc['doc_name'];
							else
								$data['doc_name'][]=$language['Annex'].($key+1);
						}
					}
					$data['exfile_show']=true;
				}
				else
				{
					$data['exfile_show']=false;
				}
			//icon
				$dirname = '.'.$member['img_url'].'icon/';
				$icon = glob($dirname."icon.png", GLOB_BRACE);//{*.gif,*.jpg,*.jpeg,*.png,*.GIF,*.JPG,*.PNG}
				if(!is_file($icon[0]) || $iqr['icon_status'] == 0)
					$data['icon'] = '/images/web_style_images/'.$data['web_banner_dir'].'/app_welcome_page/icon100x100.png';
				else
				{
					$icon = glob($dirname."icon100x100.png", GLOB_BRACE);
					$data['icon'] = substr($icon[0], 1);
				}
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
				$data['bg_image_path'] = ($iqr['theme_bg_image_path'] != '') ? $iqr['theme_bg_image_path'] : $theme['dfu_bg_image_path'];
			//titlename
			if(!empty($iqr['titlename']))
			{
				$titlename = $this -> get_serialstr($iqr['titlename'], '*#');
				foreach ($titlename as $key => $value)
				{
					$title_name = $this -> mod_business -> select_from('strings', array('type' => 3, 'str_id' => $value));
					$data['title'][$key] = $title_name['str'];
				}

			}
			// * Damn
			$data['id']    = $member['account'];
			$data['store'] = $a = $this -> mod_business -> select_from('iqr_cart', array('member_id' => $member['member_id']));

			//分享鈕
			if ($theme['theme_id']==8){

				$this->publiccheck('',$id);
				$data=$this->data;
			}
			$data['public_share_pict_Ppath'] = $this->chksharepict($data['logo_path_url']);
			$data['public_share_title'] = $data['iqr_name'] .' '. $language['ActionBusinessSystem'];
			if ($this->get_device_os()=='ios')
				$data['public_share_title'] = urlencode($data['public_share_title']);
			$data['public_share_url']   = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$data['public_share_buttom_url']   = 'jecp://path='.$data['public_share_pict_Ppath'].'&ecp_url='.$data['public_share_url'].'&ecp_title='.$data['public_share_title'];


			if ($theme['theme_id']>=9){
				$this->load->view('template/temp'.$theme['theme_id'].'/about' , $data);
			}else{
				//view
				$this->load->view('template/about' . $theme['theme_id'], $data);
				$this->load->view('template/integrate_footer/' .$theme['footer_mode_name'], $data);
			}
		}
		else
		{
			redirect(base_url());
		}
	}

	public function photo($id, $type = '')
	{
		$language = $this -> language;
		$data=$this->data;

		if($id != '' && $type != '')
		{
			$member=$this->mod_business->select_from('member', array('account'=>$id));
			$data['account'] = $member['account'];
		}
		else
		{
			redirect(base_url());
		}

		if(!empty($member))
		{
			//判斷使用期限
			if(!$this->check_deadline($data['web_config'], $member['member_id']))
			{
				redirect('/index/error');
			}

			//iqr
			$data['iqr']=$iqr=$this->mod_business->select_from('iqr', array('member_id'=>$member['member_id']));
			//名片流量計數器
			$this->mod_business->iqr_views_add($iqr['iqr_id'], $this->get_realip());

			//web return
			$this->session->set_userdata('web_return', $id);

			//helper
			$this->load->helper('form');

			//base url
			$data['base_url']=base_url();

			//account
			$data['account']=$id;
			$data['mid']=$member['member_id'];

			//name
			if($iqr['f_name'] != '')
				$data['iqr_name']=$iqr['l_name'].$iqr['f_name'];
			else
				$data['iqr_name']=$data['account'];

			//en_name
			if($iqr['f_en_name'] != '')
				$data['iqr_en_name']=$iqr['l_en_name'].$iqr['f_en_name'];
			else
				$data['iqr_en_name']=$data['account'];


			//行動名片連結
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

			//icon
				$dirname = '.'.$member['img_url'].'icon/';
				$icon = glob($dirname."icon.png", GLOB_BRACE);//{*.gif,*.jpg,*.jpeg,*.png,*.GIF,*.JPG,*.PNG}
				if(!is_file($icon[0]) || $iqr['icon_status'] == 0)
					$data['icon'] = '/images/web_style_images/'.$data['web_banner_dir'].'/app_welcome_page/icon100x100.png';
				else
				{
					$icon = glob($dirname."icon100x100.png", GLOB_BRACE);
					$data['icon'] = substr($icon[0], 1);
				}
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
				$data['bg_image_path'] = ($iqr['theme_bg_image_path'] != '') ? $iqr['theme_bg_image_path'] : $theme['dfu_bg_image_path'];
				// $data['bg_image_path'] = Common::get_data_uri(substr($bg_image_path, 1));
			// 引用資料設定開始
            $temp_quote_data = $this->mod_business->select_from_order('quote_data', 'parent', 'asc', array('member_id'=>$member['member_id'], 'status'=>1)); // quote 引用資料
            if(!empty($temp_quote_data))
            {
            	// quote data index number
            	$index = 0;

	            // 當 column 提供 id 資料，需要 table name 來撈值，且需要 id 名稱與 主要值 名稱
	            $db_table_name  = array(
	                'd_photo'     	=> 'images',
	                'cpn_photo' 	=> 'images',
	                'ytb_link'  	=> 'strings',
	                'website'   	=> 'strings',
	                'address'   	=> 'strings',
	                'mobile_phones' => 'strings',
	                'exfile'    	=> 'documents',
	                'uform'     	=> 'uform',
	                'ecoupon'   	=> 'ecoupon',
	                'iqr_html'  	=> 'iqr_html'
	            );
	            $db_id_col_name = array(
	                'd_photo'     	=> 'img_id',
	                'cpn_photo' 	=> 'img_id',
	                'ytb_link'  	=> 'str_id',
	                'website'   	=> 'str_id',
	                'mobile_phones' => 'str_id',
	                'address'   	=> 'str_id',
	                'exfile'    	=> 'doc_id',
	                'uform'     	=> 'ufm_id',
	                'ecoupon'   	=> 'ecp_id',
	                'iqr_html'  	=> 'html_id'
	            );
	            foreach($temp_quote_data as $key => $value)
	            {
	            	// root data
	            	$root_iqr = $this->mod_business->select_from('iqr', array('member_id'=>$value['parent']));

	                // 值
	                if($value['id'] == 0) // iqr data
	                {
	                	$quote_data[$value['iqr_column']]['value'][$index]   = $root_iqr[$value['iqr_column']];
	                    $quote_data[$value['iqr_column']]['btnname'][$index] = $root_iqr[$value['iqr_column'].'_name'];

	                	if($value['iqr_column'] == 'cpn_phone' && $root_iqr['cpn_extension'] != '')
	                		$quote_data[$value['iqr_column']]['value'][$index] .= '#'.$root_iqr['cpn_extension'];
	                }
	                else // id data
	                {
	                    // 撈出特定 id data
	                    $id_data = $this->mod_business->select_from($db_table_name[$value['iqr_column']], array($db_id_col_name[$value['iqr_column']] => $value['id']));
	                    // special value setting
	                    switch ($value['iqr_column']) {
	                        case 'd_photo':
	                        case 'cpn_photo':
	                            $quote_data[$value['iqr_column']]['value'][$index]   = base_url().substr($id_data['img_path'], 2);
	                            $quote_data[$value['iqr_column']]['btnname'][$index] = $id_data['img_note'];
	                            break;
	                        case 'ytb_link':
	                            $quote_data[$value['iqr_column']]['value'][$index]   = $this->get_ytb_id($id_data['str']);
	                            $quote_data[$value['iqr_column']]['btnname'][$index] = ($id_data['str_name'] != '') ? $id_data['str_name'] : 'Youtube';
	                            break;
	                        case 'website':
	                        case 'address':
	                        case 'mobile_phones':
	                            $quote_data[$value['iqr_column']]['value'][$index]   = $id_data['str'];
	                            $quote_data[$value['iqr_column']]['btnname'][$index] = ($id_data['str_name'] != '') ? $id_data['str_name'] : $language['Link'];
	                            break;
	                        case 'exfile':
	                            $quote_data[$value['iqr_column']]['value'][$index]   = base_url().substr($id_data['doc_path'], 2);
	                            $quote_data[$value['iqr_column']]['btnname'][$index] = ($id_data['doc_name'] != '') ? $id_data['doc_name'] : $id_data['doc_ori_name'];
	                            break;
	                        case 'uform':
	                        	$quote_data[$value['iqr_column']]['value'][$index]   = base_url().'form/index/'.$id_data['ufm_id'].'/'.$id_data['member_id'];
	                            $quote_data[$value['iqr_column']]['btnname'][$index] = ($id_data['ufm_btn_name'] != '') ? $id_data['ufm_btn_name'] : $id_data['ufm_name'];
	                            break;
                            case 'ecoupon':
                                $quote_data[$value['iqr_column']]['value'][$index]   = base_url().'business/my_ecoupon/'.$id_data['member_id'].'/'.$id_data['ecp_id'];
                                $quote_data[$value['iqr_column']]['btnname'][$index] = $id_data['name'];
                                break;
	                        case 'iqr_html':
	                            $quote_data[$value['iqr_column']]['value'][$index]   = base_url().'business/html_web/'.$id_data['html_id'];
	                            $quote_data[$value['iqr_column']]['btnname'][$index] = $id_data['html_name'];
	                            break;
	                    }
	                }
	                $index++;
	            }
	            $data['quote_data'] = $quote_data;
	        }
	        // 引用圖檔設定
	        if(!empty($quote_data['d_photo']) != '' || !empty($quote_data['cpn_photo']))
			{
				if(!empty($quote_data['d_photo']) != '')
				{
					foreach($quote_data['d_photo']['value'] as $key => $value)
					{
						$data['cpn_photo_src']  .= '<img src=\''.$value.'\'>';
						$data['cpn_photo_note'] .= ',';
						$data['cpn_photo_note'] .= '"'.trim($quote_data['d_photo']['btnname'][$key]).'"';
					}
					$data['cpn_photo_amount'] += count($quote_data['d_photo']['value']);
				}
				if(!empty($quote_data['cpn_photo']) != '')
				{
					foreach($quote_data['cpn_photo']['value'] as $key => $value)
					{
						$data['cpn_photo_src']  .= '<img src=\''.$value.'\'>';
						$data['cpn_photo_note'] .= ',';
						$data['cpn_photo_note'] .= '"'.trim($quote_data['cpn_photo']['btnname'][$key]).'"';
					}
					$data['cpn_photo_amount'] += count($quote_data['cpn_photo']['value']);
				}
				$data['cpn_photo_show']    = true;
			}
			// 引用資料設定結束

			// 圖檔字首檢查
			if($data['cpn_photo_show'] && substr($data['cpn_photo_note'], 0, 1) == ',')
				$data['cpn_photo_note'] = substr($data['cpn_photo_note'], 1);

			// * Damn
			$data['id']    = $member['account'];
			$data['store'] = $a = $this -> mod_business -> select_from('iqr_cart', array('member_id' => $member['member_id']));

			//photo
			$data['photo_category'] = $photo_category = $this -> mod_business -> select_from('photo_category', array('d_id' => $type));

			if(!empty($photo_category['d_photo']))
			{
				$img_array = $this -> get_serialstr($photo_category['d_photo'], '*#');
				if(!empty($img_array))
				{
					foreach ($img_array as $key => $value) {
						$data['photos'][] = $image = $this -> mod_business -> select_from('images', array('img_id' => $value));
						$data['photos'][$key]['img_path'] = base_url() . substr($image['img_path'], 1);
					}
				}
			}
			else
			{
				$this -> script_message($language['ErrorLink'], '/business/iqr/'. $member['account']);
			}

			//view
			$this -> load -> view('template/photo', $data);
			$this->load->view('template/integrate_footer/' .$theme['footer_mode_name'], $data);
		}
		else
		{
			redirect(base_url());
		}
	}

	//名片頁電腦端彈出對話框顯示頁面
	public function iqr_html($id='')
	{
		$language = $this -> language;
		$data=$this->data;
		if($id != '')
		{
			$member=$this->mod_business->select_from('member', array('account'=>$id));
			$data['aid'] = $member['account'];
		}
		else
		{
			redirect(base_url());
		}

		if(!empty($member))
		{
			//判斷使用期限
			if(!$this->check_deadline($data['web_config'], $member['member_id']))
			{
				redirect('/index/error');
			}

			//iqr
			$data['iqr']=$iqr=$this->mod_business->select_from('iqr', array('member_id'=>$member['member_id']));
			//名片流量計數器
			$this->mod_business->iqr_views_add($iqr['iqr_id'], $this->get_realip());

			// logo
			$data['logo_path'] = Common::get_data_uri($iqr['logo_path']);

			//web return
			$this->session->set_userdata('web_return', $id);

			//helper
			$this->load->helper('form');

			//base url
			$data['base_url']=base_url();

			//account
			$data['account']=$id;
			$data['mid']=$member['member_id'];

			//name
			if($iqr['f_name'] != '')
				$data['iqr_name']=$iqr['l_name'].$iqr['f_name'];
			else
				$data['iqr_name']=$data['account'] ;
			$data['iqr_name'] .= ' - 關於eoneda - ';

			//en_name
			if($iqr['f_en_name'] != '')
				$data['iqr_en_name']=$iqr['l_en_name'].' '.$iqr['f_en_name'] ;
			else
				$data['iqr_en_name']=$data['account'];

			// qrcode btn show/hide
			$data['web_btn']     = $this -> mod_business -> select_from('qrc_style', array('member_id' => $member['member_id'], 'type' => 0));
			$data['contact_btn'] = $this -> mod_business -> select_from('qrc_style', array('member_id' => $member['member_id'], 'type' => 1));
			$data['app_btn']     = $this -> mod_business -> select_from('qrc_style', array('member_id' => $member['member_id'], 'type' => 2));

			//qrcode btn name
			$data['web_btn_name'] 	  = ($iqr['iqr_qrcode_web'] != '') 		? $iqr['iqr_qrcode_web'] 	 : $language['SystemWeb'];
			$data['app_btn_name'] 	  = ($iqr['iqr_qrcode_app'] != '') 		? $iqr['iqr_qrcode_app'] 	 : $language['SystemApp'];
			$data['contact_btn_name'] = ($iqr['iqr_qrcode_contact'] != '') 	? $iqr['iqr_qrcode_contact'] : $language['Contacts'];

			//行動名片連結
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

			//header title
				$default_title = $this -> mod_business -> select_from('system_header', array('theme_id' => $iqr['theme_id']));
				$default_title = $this -> get_serialstr($default_title['header_default'], '*#');
				$header_array = $this -> get_serialstr($iqr['str_header'], '*#');

				if(count($header_array) != count($default_title))
				{
					if(!empty($default_title))
					{
						foreach ($default_title as $key => $value)
						{
							$data['title_text'][$key] = $value;
						}
					}
				}
				else
				{
					if($iqr['theme_id']==2){
						foreach ($header_array as $key => $value)
						{
							$data['title_text'][$key] = $value;
						}
					}
				}
			//photo
				$data['photo_show'] = false;
				$photo_category = $this -> mod_business -> select_from_order('photo_category', 'd_sort', 'asc', array('d_member_id' => $member['member_id'], 'd_enable' => 'Y'));
				if(!empty($photo_category))
				{
					foreach ($photo_category as $key => $value)
					{
						if(!empty($value['d_photo']))
						{
							$photo_array = $this -> get_serialstr($value['d_photo'], '*#');

							$image = $this -> mod_business -> select_from('images', array('img_id' => $photo_array[0]));
							$data['photo_category'][$key]['L_image'] = base_url() . substr($image['img_path'], 1);
							$data['photo_category'][$key]['show'] = true;
						}
						else
						{
							$photo_array = '';
							$data['photo_category'][$key]['L_image'] = '';
							$data['photo_category'][$key]['show'] = false;
						}
						$data['photo_category'][$key]['d_id'] = $value['d_id'];
					}
					$data['photo_show'] = true;
				}
			//strings items
				$strings_items = array(
					0 => 'ytb_link',
					1 => 'website',
					2 => 'address',
					3 => 'titlename',
					4 => 'mobile_phones'
				);
				foreach($strings_items as $s_i_key => $s_i_value)
				{
					${$s_i_value.'_id'} = $this->get_serialstr($iqr[$s_i_value], '*#');
					if(!empty(${$s_i_value.'_id'}))
					{
						$sortnum = 0;
						foreach(${$s_i_value.'_id'} as $key => $value)
						{
							$str = $this->mod_business->select_from('strings', array('str_id'=>$value));

							${$s_i_value.'_num'}++;

							if($s_i_value == 'ytb_link')
								$data[$s_i_value][] = $this->get_ytb_id($str['str']);
							else
								$data[$s_i_value][] = $str['str'];
							$data[$s_i_value.'_id'][] = $str['str_id'];
							if($s_i_value != 'titlename')
							{
								switch ($s_i_key) {
									case 0:
										$data[$s_i_value.'_name'][]	= ($str['str_name'] != '') ? $str['str_name'] : $language['Movie'].$sortnum ;
										break;
									case 1:
										$data[$s_i_value.'_name'][]	= ($str['str_name'] != '') ? $str['str_name'] : $language['Web'].$sortnum ;
										break;
									case 2:
										$data[$s_i_value.'_name'][]	= ($str['str_name'] != '') ? $str['str_name'] : $language['Map'].$sortnum ;
										break;
									case 4:
										$data[$s_i_value.'_name'][]	= ($str['str_name'] != '') ? $str['str_name'] : $language['CallMyMobilePhone']. ' ' .$sortnum ;
										break;
								}
								$sortnum++;
							}
						}
						$data[$s_i_value.'_num'] = ${$s_i_value.'_num'};
					}
				}
			//mobile
				if($iqr['mobile'] != '')
				{
					$data['mobile_show']=true;
					$data['mobile']=$iqr['mobile'];
					if($iqr['mobile_name'] != '')
						$data['mobile_name']=$iqr['mobile_name'];
					else
						$data['mobile_name']=$language['CallMyMobilePhone'];
				}
				else
				{
					$data['mobile_show']=false;
				}
			//email
				if($iqr['email'] != '')
				{
					$data['email_show']=true;
					$data['email']=$iqr['email'];
					if($iqr['email_name'] != '')
						$data['email_name']=$iqr['email_name'];
					else
						$data['email_name']='電子信箱';
				}
				else
				{
					$data['email_show']=false;
				}
			//skype
				if($iqr['skype'] != '')
				{
					$data['skype_show']=true;
					$data['skype']=$iqr['skype'];
					if($iqr['skype_name'] != '')
						$data['skype_name']=$iqr['skype_name'];
					else
						$data['skype_name']=$language['SkypeCall'];
				}
				else
				{
					$data['skype_show']=false;
				}
			//facebook
				if($iqr['facebook'] != '')
				{
					$data['facebook_show']=true;
					$data['facebook']=$iqr['facebook'];
					if($iqr['facebook_name'] != '')
						$data['facebook_name']=$iqr['facebook_name'];
					else
						$data['facebook_name']=$language['MyFacebook'];
				}
				else
				{
					$data['facebook_show']=false;
				}
			//line
				if($iqr['line'] != '')
				{
					$data['line_show']=true;
					$data['line']=$iqr['line'];
					if($iqr['line_name'] != '')
						$data['line_name']=$iqr['line_name'];
					else
						$data['line_name']=$language['AddLineFriend'];
				}
				else
				{
					$data['line_show']=false;
				}
			//mecard
				if(($iqr['firstname'] != '' || $iqr['lastname'] != '') && ($iqr['mphone'] != '' || $iqr['cpn_tel'] != ''))
				{
					$data['mecard_show']=true;
				}
				else
				{
					$data['mecard_show']=false;
				}
			//cpn_phone
				if($iqr['cpn_phone'] != '')
				{
					$data['cpn_phone_show']=true;
					$data['cpn_phone']=$iqr['cpn_phone'];
					if($iqr['cpn_phone_name'] != '')
						$data['cpn_phone_name']=$iqr['cpn_phone_name'];
					else
						$data['cpn_phone_name']=$language['CompanyPhone'];
					if($iqr['cpn_extension'] != '')
						$data['cpn_extension']=','.$iqr['cpn_extension'];
					else
						$data['cpn_extension']='';
				}
				else
				{
					$data['cpn_phone_show']=false;
				}
			//cpn_cfax
				if($iqr['cpn_cfax'] != '')
				{
					$data['cpn_cfax_show'] = true;
					$data['cpn_cfax'] = $iqr['cpn_cfax'];
					if($iqr['cpn_fax_name'] != '')
						$data['cpn_fax_name'] = $iqr['cpn_fax_name'];
					else
						$data['cpn_fax_name'] = $language['Fax'];
				}
				else
				{
					$data['cpn_cfax_show'] = false;
				}
			//cpn_number
				if($iqr['cpn_number'] != '')
				{
					$data['cpn_number_show']=true;
					$data['cpn_number']=$iqr['cpn_number'];
					if($iqr['cpn_number_name'] != '')
						$data['cpn_number_name']=$iqr['cpn_number_name'];
					else
						$data['cpn_number_name']=$language['ShowUniform'];
				}
				else
				{
					$data['cpn_number_show']=false;
				}
			//exfile
				if($iqr['exfile'] != '')
				{
					$temp_exfile=$this->get_serialstr($data['iqr']['exfile'], '*#');
					foreach($temp_exfile as $key => $value)
					{
						$doc=$this->mod_business->select_from('documents', array('doc_id'=>$value));
						if(!empty($doc))
						{
							$data['doc_path'][]=$this->mod_business->get_doc_path($value);
							if($doc['doc_name'] != '')
								$data['doc_name'][]=$doc['doc_name'];
							else
								$data['doc_name'][]=$language['Annex'].($key+1);
						}
					}
					$data['exfile_show']=true;
				}
				else
				{
					$data['exfile_show']=false;
				}
			//cpn_photo
				$data['cpn_photo_show']   = false;
				$data['cpn_photo_note']   = '';
				$data['cpn_photo_amount'] = 0;
				if($iqr['cpn_photo'] != '')
				{
					$temp_cpn_photo = $this->get_serialstr($iqr['cpn_photo'], '*#');
					foreach($temp_cpn_photo as $key => $value)
					{
						$img 		   = $this->mod_business->select_from('images', array('img_id'=>$value));
						$cpn_photo_src = $this->mod_business->get_img_path($value);
						if($cpn_photo_src != '')
						{
							$data['cpn_photo_src']  .= '<img src=\''.base_url().substr($cpn_photo_src, 1).'\'>';
							$data['cpn_photo_note'] .= ',';
							$data['cpn_photo_note'] .= '"'.trim($img['img_note']).'"';
						}
					}
					$data['cpn_photo_amount'] = count($temp_cpn_photo);
					$data['cpn_photo_show']   = true;
				}
			//cart
				if($data['web_config']['cart_status'] == 1)
				{
					$cart = $this->mod_business->select_from('iqr_cart', array('member_id'=>$member['member_id']));
					$data['cart_link']   = base_url().'cart/store/'.$cart['cset_code'];
					$data['cset_name']   = ($cart['cset_name'] != '') ? $cart['cset_name'] : $language['StorePage'];
					$data['cset_active'] = $cart['cset_active'];
				}
			//icon
				$dirname = '.'.$member['img_url'].'icon/';
				$icon = glob($dirname."icon.png", GLOB_BRACE);//{*.gif,*.jpg,*.jpeg,*.png,*.GIF,*.JPG,*.PNG}
				if(!is_file($icon[0]) || $iqr['icon_status'] == 0)
					$data['icon'] = '/images/web_style_images/'.$data['web_banner_dir'].'/app_welcome_page/icon100x100.png';
				else
				{
					$icon = glob($dirname."icon100x100.png", GLOB_BRACE);
					$data['icon'] = substr($icon[0], 1);
				}
            //coupon
                if($iqr['ecoupon'] != '')
                {
                    $data['ecp_show']=true;
                    $ecp_id=$this->get_serialstr($iqr['ecoupon'], '*#');
                    foreach($ecp_id as $key => $value)
                    {
                        $ecp=$this->mod_business->select_from('ecoupon', array('ecp_id'=>$value));
                        $data['ecp_url_name'][$key] = $ecp['name'];
                        $data['ecp_content'][$key]  = $ecp['content'];
                        $data['ecp_btn_name'][$key] = $ecp['btn_name'];
                        // image data uri
                        $ecp_img_path = $member['img_url'] .'coupon/'. $ecp['filename'];
                        $data['ecp_img'][$key] = Common::get_data_uri(substr($ecp_img_path, 1));

                        // share mode
                        switch ($ecp['mode']) {
                        	case 1:
		                        $data['ecp_Ppath'][$key] = base_url() . substr($member['img_url'], 1) . 'coupon/' .$ecp['filename'];
								$data['ecp_url'][$key]   = $ecp['mode_1'];
								$data['ecp_title'][$key] = $ecp['name'];
                        		break;
                        	case 2:
		                        $data['ecp_Ppath'][$key] = base_url() . substr($member['img_url'], 1) . 'coupon/' .$ecp['filename'];
								$data['ecp_url'][$key]   = $ecp['mode_2'];
								$data['ecp_title'][$key] = $ecp['name'];
                        		break;
                        	case 3:
		                        $data['ecp_Ppath'][$key] = base_url() . substr($member['img_url'], 1) . 'coupon/' .$ecp['filename'];
		                        // $data['ecp_Ppath'][$key] = substr($member['img_url'], 1) . 'coupon/' .$ecp['filename'];
								$data['ecp_url'][$key]   = base_url() ."business/ecoupon_editor/" .$ecp['member_id'] . "/" . $ecp['ecp_id'];
								$data['ecp_title'][$key] = $ecp['name'];
                        		break;
                        }
                        $ecp[$key] = array(
                        	"path" 		=> $data['ecp_Ppath'][$key],
                        	"ecp_url" 	=> $data['ecp_url'][$key],
                        	"ecp_title" => $data['ecp_title'][$key]
                        );

                        // $data['jecp'][$key] = json_encode($ecp[$key]);
                        $data['jecp'][$key] = "path=" . $data['ecp_Ppath'][$key] . "&ecp_url=" . $data['ecp_url'][$key] . "&ecp_title=" . $data['ecp_title'][$key];
                    }
                }
                else
                {
                    $data['ecp_show']=false;
                }
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
				$data['bg_image_path'] = ($iqr['theme_bg_image_path'] != '') ? $iqr['theme_bg_image_path'] : $theme['dfu_bg_image_path'];
				// $data['bg_image_path'] = Common::get_data_uri(substr($bg_image_path, 1));
			//banner
				if($data['web_config']['g_free_link_status'] == 1)//開啟全局免費體驗設定
				{
					$data['banner_show']=true;
					if($data['web_config']['free_link_name'] != '')
						$data['banner_name']=$data['web_config']['free_link_name'];
					else
						$data['banner_show']=false;
				}
				else//使用個別免費體驗設定
				{
					//預設開啟給會員設定免費體驗連結是否顯示
					if($iqr['banner_status'] == 1)
					{
						$data['banner_show']=true;
						if($iqr['banner_status_name'] != '')
							$data['banner_name']=$iqr['banner_status_name'];
						else
							$data['banner_name']=$language['FreeActionCards'];
					}
					else
					{
						$data['banner_show']=false;
					}
				}
			//form
				if($iqr['uform'] != '')
				{
					$ufm_id_array=$this->get_serialstr($iqr['uform'], '*#');
					foreach($ufm_id_array as $key => $value)
					{
						$uform=$this->mod_business->select_from('uform', array('ufm_id'=>$value));
						if(!empty($uform) && $uform['ufm_status'] != 0)
						{
							//按鈕名稱
							if($uform['ufm_btn_name'] != '')
								$data['ufm_btn_name'][$key]=$uform['ufm_btn_name'];
							else
								$data['ufm_btn_name'][$key]=$uform['ufm_name'];
							//id
							$data['ufm_id'][$key]=$uform['ufm_id'];
						}
					}
					if(count($data['ufm_id']) != '')
						$data['uform_show']=true;
					else
						$data['uform_show']=false;
				}
				else
				{
					$data['uform_show']=false;
				}
			//iqr_html_page
				if(!empty($iqr['iqr_html']))
				{
					$data['iqr_html_page'] = $this -> mod_business -> select_from_order('iqr_html', 'html_sort', 'asc', array('member_id' => $member['member_id']));
				}

			$data['iqr_html']=0;
			if($this->check_ipad() == 0)
			{
				$data['iqr_img_double']=1;
				$data['iqr_img_ipad']=0;
			}
			else
			{
				$data['iqr_img_double']=0;
				$data['iqr_img_ipad']=1;
			}

			// 圖檔字首檢查
			if($data['cpn_photo_show'] && substr($data['cpn_photo_note'], 0, 1) == ',')
				$data['cpn_photo_note'] = substr($data['cpn_photo_note'], 1);

			$data['id']    = $member['account'];
			$data['store'] = $this -> mod_business -> select_from('iqr_cart', array('member_id' => $member['member_id']));

			if ($theme['theme_id']==8){
				$this->publiccheck('',$id);
				$data=$this->data;
			}
			$mother_store=$this -> mod_business -> select_from('iqr_cart', array('member_id' => $this->member_id));
			$data['mother_cset_code'] = $mother_store['cset_code'];

			//view
			$this->load->view('template/integrate/'.$view_name, $data);
			$this->load->view('template/integrate_footer/' .$theme['footer_mode_name'], $data);
		}
		else
		{
			redirect(base_url());
		}
	}

	//名片頁電腦端預覽區頁面
	public function iqr_preview($id='')
	{
		$language = $this -> language;
		$data=$this->data;

		if($id != '')
		{
			$member=$this->mod_business->select_from('member', array('account'=>$id));
			$data['account'] = $member['account'];
		}
		else
		{
			redirect(base_url());
		}

		if(!empty($member))
		{
			//判斷使用期限
			if(!$this->check_deadline($data['web_config'], $member['member_id']))
			{
				redirect('/index/error');
			}

			//iqr
			$data['iqr']=$iqr=$this->mod_business->select_from('iqr', array('member_id'=>$member['member_id']));
			//名片流量計數器
			$this->mod_business->iqr_views_add($iqr['iqr_id'], $this->get_realip());

			// logo
			$data['logo_path'] = Common::get_data_uri($iqr['logo_path']);

			//web return
			$this->session->set_userdata('web_return', $id);

			//helper
			$this->load->helper('form');

			//base url
			$data['base_url']=base_url();

			//account
			$data['account']=$id;
			$data['mid']=$member['member_id'];

			//name
			if($iqr['f_name'] != '')
				$data['iqr_name']=$iqr['l_name'].$iqr['f_name'];
			else
				$data['iqr_name']=$data['account'];

			//en_name
			if($iqr['f_en_name'] != '')
				$data['iqr_en_name']=$iqr['l_en_name'].$iqr['f_en_name'];
			else
				$data['iqr_en_name']=$data['account'];


			// qrcode btn show/hide
			$data['web_btn']     = $this -> mod_business -> select_from('qrc_style', array('member_id' => $member['member_id'], 'type' => 0));
			$data['contact_btn'] = $this -> mod_business -> select_from('qrc_style', array('member_id' => $member['member_id'], 'type' => 1));
			$data['app_btn']     = $this -> mod_business -> select_from('qrc_style', array('member_id' => $member['member_id'], 'type' => 2));

			//qrcode btn name
			$data['web_btn_name'] 	  = ($iqr['iqr_qrcode_web'] != '') 		? $iqr['iqr_qrcode_web'] 	 : $language['SystemWeb'];
			$data['app_btn_name'] 	  = ($iqr['iqr_qrcode_app'] != '') 		? $iqr['iqr_qrcode_app'] 	 : $language['SystemApp'];
			$data['contact_btn_name'] = ($iqr['iqr_qrcode_contact'] != '') 	? $iqr['iqr_qrcode_contact'] : $language['Contacts'];

			//行動名片連結
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

			//header title
				$default_title = $this -> mod_business -> select_from('system_header', array('theme_id' => $iqr['theme_id']));
				$default_title = $this -> get_serialstr($default_title['header_default'], '*#');
				$header_array = $this -> get_serialstr($iqr['str_header'], '*#');

				if(count($header_array) != count($default_title))
				{
					if(!empty($default_title))
					{
						foreach ($default_title as $key => $value)
						{
							$data['title_text'][$key] = $value;
						}
					}
				}
				else
				{
					// if(($iqr['theme_id'] != 1) && ($iqr['theme_id'] != 8)) 					{
					if($iqr['theme_id']==2){
						foreach ($header_array as $key => $value)
						{
							$data['title_text'][$key] = $value;
						}
					}
				}
			//photo
				$data['photo_show'] = false;
				$photo_category = $this -> mod_business -> select_from_order('photo_category', 'd_updateTime', 'desc', array('d_member_id' => $member['member_id'], 'd_enable' => 'Y'));
				if(!empty($photo_category))
				{
					foreach ($photo_category as $key => $value)
					{
						if(!empty($value['d_photo']))
						{
							$photo_array = $this -> get_serialstr($value['d_photo'], '*#');

							$image = $this -> mod_business -> select_from('images', array('img_id' => $photo_array[0]));
							$data['photo_category'][$key]['L_image'] = base_url() . substr($image['img_path'], 1);
							$data['photo_category'][$key]['show'] = true;
						}
						else
						{
							$photo_array = '';
							$data['photo_category'][$key]['L_image'] = '';
							$data['photo_category'][$key]['show'] = false;
						}
						$data['photo_category'][$key]['d_id'] = $value['d_id'];
					}
					$data['photo_show'] = true;
				}
			//strings items
				$strings_items = array(
					0 => 'ytb_link',
					1 => 'website',
					2 => 'address',
					3 => 'titlename',
					4 => 'mobile_phones'
				);
				foreach($strings_items as $s_i_key => $s_i_value)
				{
					${$s_i_value.'_id'} = $this->get_serialstr($iqr[$s_i_value], '*#');
					if(!empty(${$s_i_value.'_id'}))
					{
						$sortnum = 0;
						foreach(${$s_i_value.'_id'} as $key => $value)
						{
							$str = $this->mod_business->select_from('strings', array('str_id'=>$value));

							${$s_i_value.'_num'}++;

							if($s_i_value == 'ytb_link')
								$data[$s_i_value][] = $this->get_ytb_id($str['str']);
							else
								$data[$s_i_value][] = $str['str'];
							$data[$s_i_value.'_id'][] = $str['str_id'];
							if($s_i_value != 'titlename')
							{
								switch ($s_i_key) {
									case 0:
										$data[$s_i_value.'_name'][]	= ($str['str_name'] != '') ? $str['str_name'] : $language['Movie'].$sortnum ;
										break;
									case 1:
										$data[$s_i_value.'_name'][]	= ($str['str_name'] != '') ? $str['str_name'] : $language['Web'].$sortnum ;
										break;
									case 2:
										$data[$s_i_value.'_name'][]	= ($str['str_name'] != '') ? $str['str_name'] : $language['Map'].$sortnum ;
										break;
									case 4:
										$data[$s_i_value.'_name'][]	= ($str['str_name'] != '') ? $str['str_name'] : $language['CallMyMobilePhone']. ' ' .$sortnum ;
										break;
								}
								$sortnum++;
							}
						}
						$data[$s_i_value.'_num'] = ${$s_i_value.'_num'};
					}
				}
			//mobile
				if($iqr['mobile'] != '')
				{
					$data['mobile_show']=true;
					$data['mobile']=$iqr['mobile'];
					if($iqr['mobile_name'] != '')
						$data['mobile_name']=$iqr['mobile_name'];
					else
						$data['mobile_name']=$language['CallMyMobilePhone'];
				}
				else
				{
					$data['email_show']=false;
				}
			//email
				if($iqr['email'] != '')
				{
					$data['email_show']=true;
					$data['email']=$iqr['email'];
					if($iqr['email_name'] != '')
						$data['email_name']=$iqr['email_name'];
					else
						$data['email_name']=$language['WriteToEmail'];
				}
				else
				{
					$data['email_show']=false;
				}
			//skype
				if($iqr['skype'] != '')
				{
					$data['skype_show']=true;
					$data['skype']=$iqr['skype'];
					if($iqr['skype_name'] != '')
						$data['skype_name']=$iqr['skype_name'];
					else
						$data['skype_name']=$language['SkypeCall'];
				}
				else
				{
					$data['skype_show']=false;
				}
			//facebook
				if($iqr['facebook'] != '')
				{
					$data['facebook_show']=true;
					$data['facebook']=$iqr['facebook'];
					if($iqr['facebook_name'] != '')
						$data['facebook_name']=$iqr['facebook_name'];
					else
						$data['facebook_name']=$language['MyFacebook'];
				}
				else
				{
					$data['facebook_show']=false;
				}
			//line
				if($iqr['line'] != '')
				{
					$data['line_show']=true;
					$data['line']=$iqr['line'];
					if($iqr['line_name'] != '')
						$data['line_name']=$iqr['line_name'];
					else
						$data['line_name']=$language['AddLineFriend'];
				}
				else
				{
					$data['line_show']=false;
				}
			//mecard
				if(($iqr['firstname'] != '' || $iqr['lastname'] != '') && ($iqr['mphone'] != '' || $iqr['cpn_tel'] != ''))
				{
					$data['mecard_show']=true;
				}
				else
				{
					$data['mecard_show']=false;
				}
			//cpn_phone
				if($iqr['cpn_phone'] != '')
				{
					$data['cpn_phone_show']=true;
					$data['cpn_phone']=$iqr['cpn_phone'];
					if($iqr['cpn_phone_name'] != '')
						$data['cpn_phone_name']=$iqr['cpn_phone_name'];
					else
						$data['cpn_phone_name']=$language['CompanyPhone'];
					if($iqr['cpn_extension'] != '')
						$data['cpn_extension']=','.$iqr['cpn_extension'];
					else
						$data['cpn_extension']='';
				}
				else
				{
					$data['cpn_phone_show']=false;
				}
			//cpn_cfax
				if($iqr['cpn_cfax'] != '')
				{
					$data['cpn_cfax_show'] = true;
					$data['cpn_cfax'] = $iqr['cpn_cfax'];
					if($iqr['cpn_fax_name'] != '')
						$data['cpn_fax_name'] = $iqr['cpn_fax_name'];
					else
						$data['cpn_fax_name'] = $language['Fax'];
				}
				else
				{
					$data['cpn_cfax_show'] = false;
				}
			//cpn_number
				if($iqr['cpn_number'] != '')
				{
					$data['cpn_number_show']=true;
					$data['cpn_number']=$iqr['cpn_number'];
					if($iqr['cpn_number_name'] != '')
						$data['cpn_number_name']=$iqr['cpn_number_name'];
					else
						$data['cpn_number_name']=$language['ShowUniform'];
				}
				else
				{
					$data['cpn_number_show']=false;
				}
			//exfile
				if($iqr['exfile'] != '')
				{
					$temp_exfile=$this->get_serialstr($data['iqr']['exfile'], '*#');
					foreach($temp_exfile as $key => $value)
					{
						$doc=$this->mod_business->select_from('documents', array('doc_id'=>$value));
						if(!empty($doc))
						{
							$data['doc_path'][]=$this->mod_business->get_doc_path($value);
							// $data['doc_path'][] = 'business/SetDownload/' . $member['member_id']. '/' .$value;
							if($doc['doc_name'] != '')
								$data['doc_name'][]=$doc['doc_name'];
							else
								$data['doc_name'][]=$language['Annex'].($key+1);
						}
					}
					$data['exfile_show']=true;
				}
				else
				{
					$data['exfile_show']=false;
				}
			//cpn_photo
				$data['cpn_photo_show']   = false;
				$data['cpn_photo_note']   = '';
				$data['cpn_photo_amount'] = 0;
				if($iqr['cpn_photo'] != '')
				{
					$temp_cpn_photo = $this->get_serialstr($iqr['cpn_photo'], '*#');
					foreach($temp_cpn_photo as $key => $value)
					{
						$img 		   = $this->mod_business->select_from('images', array('img_id'=>$value));
						$cpn_photo_src = $this->mod_business->get_img_path($value);
						if($cpn_photo_src != '')
						{
							$data['cpn_photo_src']  .= '<img src=\''.base_url().substr($cpn_photo_src, 1).'\'>';
							$data['cpn_photo_note'] .= ',';
							$data['cpn_photo_note'] .= '"'.trim($img['img_note']).'"';
						}
					}
					$data['cpn_photo_amount'] = count($temp_cpn_photo);
					$data['cpn_photo_show']   = true;
				}
			//cart
				if($data['web_config']['cart_status'] == 1)
				{
					$cart = $this->mod_business->select_from('iqr_cart', array('member_id'=>$member['member_id']));
					$data['cart_link']   = base_url().'cart/store/'.$cart['cset_code'];
					$data['cset_name']   = ($cart['cset_name'] != '') ? $cart['cset_name'] : $language['StorePage'];
					$data['cset_active'] = $cart['cset_active'];
				}
			//icon
				$dirname = '.'.$member['img_url'].'icon/';
				$icon = glob($dirname."icon.png", GLOB_BRACE);//{*.gif,*.jpg,*.jpeg,*.png,*.GIF,*.JPG,*.PNG}
				if(!is_file($icon[0]) || $iqr['icon_status'] == 0)
					$data['icon'] = '/images/web_style_images/'.$data['web_banner_dir'].'/app_welcome_page/icon100x100.png';
				else
				{
					$icon = glob($dirname."icon100x100.png", GLOB_BRACE);
					$data['icon'] = substr($icon[0], 1);
				}
            //coupon
                if($iqr['ecoupon'] != '')
                {
                    $data['ecp_show']=true;
                    $ecp_id=$this->get_serialstr($iqr['ecoupon'], '*#');
                    foreach($ecp_id as $key => $value)
                    {
                        $ecp=$this->mod_business->select_from('ecoupon', array('ecp_id'=>$value));
                        $data['ecp_url_name'][$key] = $ecp['name'];
                        $data['ecp_content'][$key]  = $ecp['content'];
                        $data['ecp_btn_name'][$key] = $ecp['btn_name'];
                        // image data uri
                        $ecp_img_path = $member['img_url'] .'coupon/'. $ecp['filename'];
                        $data['ecp_img'][$key] = Common::get_data_uri(substr($ecp_img_path, 1));

                        // share mode
                        switch ($ecp['mode']) {
                        	case 1:
		                        $data['ecp_url'][$key] = $ecp['mode_1'];
                        		break;
                        	case 2:
		                        $data['ecp_url'][$key] = $ecp['mode_2'];
                        		break;
                        	case 3:
		                        $data['ecp_url'][$key] = base_url().'business/ecoupon_editor/'.$member['member_id'].'/'.$ecp['ecp_id'];
                        		break;
                        }
                    }
                }
                else
                {
                    $data['ecp_show']=false;
                }
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
				$data['bg_image_path'] = ($iqr['theme_bg_image_path'] != '') ? $iqr['theme_bg_image_path'] : $theme['dfu_bg_image_path'];
			//banner
				if($data['web_config']['g_free_link_status'] == 1)//開啟全局免費體驗設定
				{
					$data['banner_show']=true;
					if($data['web_config']['free_link_name'] != '')
						$data['banner_name']=$data['web_config']['free_link_name'];
					else
						$data['banner_show']=false;
				}
				else//使用個別免費體驗設定
				{
					//預設開啟給會員設定免費體驗連結是否顯示
					if($iqr['banner_status'] == 1)
					{
						$data['banner_show']=true;
						if($iqr['banner_status_name'] != '')
							$data['banner_name']=$iqr['banner_status_name'];
						else
							$data['banner_name']=$language['FreeActionCards'];
					}
					else
					{
						$data['banner_show']=false;
					}
				}
			//form
				if($iqr['uform'] != '')
				{
					$ufm_id_array=$this->get_serialstr($iqr['uform'], '*#');
					foreach($ufm_id_array as $key => $value)
					{
						$uform=$this->mod_business->select_from('uform', array('ufm_id'=>$value));
						if(!empty($uform) && $uform['ufm_status'] != 0)
						{
							//按鈕名稱
							if($uform['ufm_btn_name'] != '')
								$data['ufm_btn_name'][$key]=$uform['ufm_btn_name'];
							else
								$data['ufm_btn_name'][$key]=$uform['ufm_name'];
							//id
							$data['ufm_id'][$key]=$uform['ufm_id'];
						}
					}
					if(count($data['ufm_id']) != '')
						$data['uform_show']=true;
					else
						$data['uform_show']=false;
				}
				else
				{
					$data['uform_show']=false;
				}
			//iqr_html_page
				$data['iqr_html_page'] = $this->mod_business->select_from_order('iqr_html', 'html_id', 'desc', array('member_id'=>$member['member_id']));

			$data['iqr_html']=0;
			if($this->check_ipad() == 0)
			{
				$data['iqr_img_double']=1;
				$data['iqr_img_ipad']=0;
			}
			else
			{
				$data['iqr_img_double']=0;
				$data['iqr_img_ipad']=1;
			}

			// 引用資料設定開始
            $temp_quote_data = $this->mod_business->select_from_order('quote_data', 'parent', 'asc', array('member_id'=>$member['member_id'], 'status'=>1)); // quote 引用資料
            if(!empty($temp_quote_data))
            {
            	// quote data index number
            	$index = 0;

	            // 當 column 提供 id 資料，需要 table name 來撈值，且需要 id 名稱與 主要值 名稱
	            $db_table_name  = array(
	                'd_photo'     	=> 'images',
	                'cpn_photo' 	=> 'images',
	                'ytb_link'  	=> 'strings',
	                'website'   	=> 'strings',
	                'address'   	=> 'strings',
	                'mobile_phones' => 'strings',
	                'exfile'    	=> 'documents',
	                'uform'     	=> 'uform',
	                'ecoupon'   	=> 'ecoupon',
	                'iqr_html'  	=> 'iqr_html'
	            );
	            $db_id_col_name = array(
	                'd_photo'     	=> 'img_id',
	                'cpn_photo' 	=> 'img_id',
	                'ytb_link'  	=> 'str_id',
	                'website'   	=> 'str_id',
	                'mobile_phones' => 'str_id',
	                'address'   	=> 'str_id',
	                'exfile'    	=> 'doc_id',
	                'uform'     	=> 'ufm_id',
	                'ecoupon'   	=> 'ecp_id',
	                'iqr_html'  	=> 'html_id'
	            );
	            foreach($temp_quote_data as $key => $value)
	            {
	            	// root data
	            	$root_iqr = $this->mod_business->select_from('iqr', array('member_id'=>$value['parent']));

	                // 值
	                if($value['id'] == 0) // iqr data
	                {
	                	$quote_data[$value['iqr_column']]['value'][$index]   = $root_iqr[$value['iqr_column']];
	                    $quote_data[$value['iqr_column']]['btnname'][$index] = $root_iqr[$value['iqr_column'].'_name'];

	                	if($value['iqr_column'] == 'cpn_phone' && $root_iqr['cpn_extension'] != '')
	                		$quote_data[$value['iqr_column']]['value'][$index] .= '#'.$root_iqr['cpn_extension'];
	                }
	                else // id data
	                {
	                    // 撈出特定 id data
	                    $id_data = $this->mod_business->select_from($db_table_name[$value['iqr_column']], array($db_id_col_name[$value['iqr_column']] => $value['id']));

	                    // special value setting
                    	$quote_data['member_id'][$index] = $value['parent'];
	                    switch ($value['iqr_column']) {
	                        case 'd_photo':
	                        case 'cpn_photo':
	                            $quote_data[$value['iqr_column']]['value'][$index]   = base_url().substr($id_data['img_path'], 2);
	                            $quote_data[$value['iqr_column']]['btnname'][$index] = $id_data['img_note'];
	                            break;
	                        case 'ytb_link':
	                            $quote_data[$value['iqr_column']]['value'][$index]   = $this->get_ytb_id($id_data['str']);
	                            $quote_data[$value['iqr_column']]['btnname'][$index] = ($id_data['str_name'] != '') ? $id_data['str_name'] : 'Youtube';
	                            break;
	                        case 'website':
	                        case 'address':
	                        case 'mobile_phones':
	                            $quote_data[$value['iqr_column']]['value'][$index]   = $id_data['str'];
	                            $quote_data[$value['iqr_column']]['btnname'][$index] = ($id_data['str_name'] != '') ? $id_data['str_name'] : $language['Link'];
	                            break;
	                        case 'exfile':
	                            $quote_data[$value['iqr_column']]['value'][$index]   = base_url().substr($id_data['doc_path'], 2);
	                            $quote_data[$value['iqr_column']]['btnname'][$index] = ($id_data['doc_name'] != '') ? $id_data['doc_name'] : $id_data['doc_ori_name'];
	                            break;
	                        case 'uform':
	                        	$quote_data[$value['iqr_column']]['value'][$index]   = base_url().'form/index/'.$id_data['ufm_id'].'/'.$member['member_id'];
	                            $quote_data[$value['iqr_column']]['btnname'][$index] = ($id_data['ufm_btn_name'] != '') ? $id_data['ufm_btn_name'] : $id_data['ufm_name'];
	                            break;
                            case 'ecoupon':
                                $quote_data[$value['iqr_column']]['value'][$index]   = base_url().'business/my_ecoupon/'.$id_data['member_id'].'/'.$id_data['ecp_id'];
                                $quote_data[$value['iqr_column']]['btnname'][$index] = $id_data['name'];
                                break;
	                        case 'iqr_html':
	                            $quote_data[$value['iqr_column']]['value'][$index]   = base_url().'business/html_web/'.$id_data['html_id'];
	                            $quote_data[$value['iqr_column']]['btnname'][$index] = $id_data['html_name'];
	                            break;
	                    }
	                }
	                $index++;
	            }
	            $data['quote_data'] = $quote_data;
	        }
	        // 引用圖檔設定
	        if(!empty($quote_data['d_photo']) != '' || !empty($quote_data['cpn_photo']))
			{
				if(!empty($quote_data['d_photo']) != '')
				{
					foreach($quote_data['d_photo']['value'] as $key => $value)
					{
						$data['cpn_photo_src']  .= '<img src=\''.$value.'\'>';
						$data['cpn_photo_note'] .= ',';
						$data['cpn_photo_note'] .= '"'.trim($quote_data['d_photo']['btnname'][$key]).'"';
					}
					$data['cpn_photo_amount'] += count($quote_data['d_photo']['value']);
				}
				if(!empty($quote_data['cpn_photo']) != '')
				{
					foreach($quote_data['cpn_photo']['value'] as $key => $value)
					{
						$data['cpn_photo_src']  .= '<img src=\''.$value.'\'>';
						$data['cpn_photo_note'] .= ',';
						$data['cpn_photo_note'] .= '"'.trim($quote_data['cpn_photo']['btnname'][$key]).'"';
					}
					$data['cpn_photo_amount'] += count($quote_data['cpn_photo']['value']);
				}
				$data['cpn_photo_show']    = true;
			}
			// 引用資料設定結束

			// // 圖檔字首檢查
			if($data['cpn_photo_show'] && substr($data['cpn_photo_note'], 0, 1) == ',')
				$data['cpn_photo_note'] = substr($data['cpn_photo_note'], 1);

			// * Damn
			$data['id']    = $member['account'];
			$data['store'] = $this -> mod_business -> select_from('iqr_cart', array('member_id' => $member['member_id']));
			//view
			$this->load->view('template/integrate/'.$view_name, $data);
			$this->load->view('template/integrate_footer/' .$theme['footer_mode_name'], $data);
		}
		else
		{
			redirect(base_url());
		}
	}

	//名片風格預覽
	public function style_view($theme_id='')
	{
		$data=$this->data;

		//theme
		$data['theme']=$theme=$this->mod_business->select_from('iqr_theme', array('theme_id'=>$theme_id));
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

		$data['iqr_html']=1;
		$data['iqr_img_double']=1;

		//view
		$this->load->view('business/style_view/'.$view_name, $data);
	}

	//名片風格預覽
	public function cart_view($cart_id='')
	{
		$data=$this->data;

		//theme
		$data['theme']=$theme=$this->mod_business->select_from('cart_theme', array('cart_id'=>$cart_id));
		//view
		$view_name=$theme['cart_mod_name'];
		//css
		$data['theme_css']=$theme['theme_css_name'];

		//view
		$this->load->view('cart/style_view/'.$view_name, $data);
	}

	//資訊編輯頁面
	public function edit()
	{
		//data
		$data = $this -> data;
		$lang = $this -> mod_language -> converter('2', $this -> session -> userdata('lang'));
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
			//行動名片資料
			$data['iqr']=$iqr=$this->mod_business->select_from('iqr', array('member_id'=>$this->session->userdata('member_id')));

			//沒收到post顯示編輯頁面
			if(!$this->input->post('form_submit'))
			{
				//helper
				$this->load->helper('form');

				//member
				$member = $this->mod_business->select_from('member', array('member_id'=>$this->session->userdata('member_id')));

				//延長ckeditor上傳時間
				$this->extend_ckupload_time(3600, $member['member_id'], $member['img_url'].'ckfinder_image/', $member['auth'], $member['domain_id']);

				//account
				$data['account']=$member['account'];
				$data['mid']=$member['member_id'];

				//相簿內容
				$data['show_photo_checkbox']=($iqr['photo'] != '') ? true : false;

				//公司相簿內容
				$data['show_cpn_photo_checkbox']=($iqr['cpn_photo'] != '') ? true : false;

				//上傳附件內容
				$data['show_exfile_checkbox']=($iqr['exfile'] != '') ? true : false;

				//mecard
				$data['mecard_show']=(($iqr['firstname'] != '' || $iqr['lastname'] != '') && ($iqr['mphone'] != '' || $iqr['cpn_tel'] != '')) ? true : false;

				//strings items
				$strings_items = array(
					'ytb_link',
					'website',
					'address',
					'titlename',
					'mobile_phones'
				);
				foreach($strings_items as $s_i_key => $s_i_value)
				{
					${$s_i_value.'_id'} = $this->get_serialstr($iqr[$s_i_value], '*#');
					if(!empty(${$s_i_value.'_id'}))
					{
						foreach(${$s_i_value.'_id'} as $key => $value)
						{
							$str = $this->mod_business->select_from('strings', array('str_id'=>$value));

							${$s_i_value.'_num'}++;

							$data[$s_i_value][] = $str['str'];
							$data[$s_i_value.'_id'][] = $str['str_id'];
							$data[$s_i_value.'_cid'][] = $str['cid'];
							if($s_i_value != 'titlename')
								$data[$s_i_value.'_name'][]	= $str['str_name'];
						}
						$data[$s_i_value.'_num'] = ${$s_i_value.'_num'};
					}
				}

				//數量上限
				$data['video_num']			   = $data['web_config']['video_num']; 	     // 影片
				$data['sys_website_num']	   = $data['web_config']['website_num']; 	 // 網址
				$data['sys_address_num']	   = $data['web_config']['address_num'];	 // 地址
				$data['sys_titlename_num']	   = $data['web_config']['titlename_num'];   // 頭銜
				$data['sys_mobile_phones_num'] = $data['web_config']['titlename_num'];
				//開啟全局時不顯示此編輯欄位
				$data['member_type_show']=false;
					// if($data['web_config']['g_free_link_status'] != 1)
					// {
					// 	//顯示
					// 	$data['member_type_show']=true;

					// 	//banner_status_name
					// 	if($iqr['banner_status_name'] == '')
					// 		$data['banner_status_name']='立即免費體驗行動名片';
					// 	else
					// 		$data['banner_status_name']=$iqr['banner_status_name'];
					// 	$data['banner_status_checked'] = ($iqr['banner_status'] == 1) ? 'checked' : '';
					// }
					// else
					// {
					// 	//不顯示
					// 	$data['member_type_show']=false;
					// }

				if($this->get_device_type() >= 1)//mobile
					$data['pageguide_tag_arrow']='tlypageguide_top';
				else
					$data['pageguide_tag_arrow']='tlypageguide_left';

				//新自訂網頁
				if(!empty($iqr['iqr_classify']))
				{
					$iqr_classify = $this -> get_serialstr($iqr['iqr_classify'], '*#');
					foreach ($iqr_classify as $key => $value)
					{
						$html_classify[] = $this -> mod_business -> select_from('iqr_classify', array('classify_id' => $value));
						$html_classify[$key]['iqr_html'] = $this -> mod_business -> select_from_order('iqr_html', 'html_sort', 'asc', array('member_id' => $this->session->userdata('member_id'), 'classify_id' => $value));
					}
					$data['iqr_classify'] = $html_classify;
				}
				$data['count_classify'] = count($data['iqr_classify']);
				if(!empty($iqr['ytb_category']))
				{
					$Array_ytb_category = $this -> get_serialstr($iqr['ytb_category'], '*#');
					foreach ($Array_ytb_category as $key => $value)
					{
						$data['ytb_category'][] = $this -> mod_business -> select_from('strings_category', array('cid' => $value));
					}
				}
				$data['ytb_category_count'] = count($data['ytb_category']);

				//view
				$this->load->view('business/edit_integrate', $data);
			}
			else
			{//寫入編輯資料

				//會員
				$member_info=$this->mod_business->select_from('member', array('member_id'=>$this->session->userdata('member_id')));
				$member_id=$this->session->userdata('member_id');

				//iqr data
				$iqr=$this->mod_business->select_from('iqr', array('member_id'=>$member_id));

				// str set_serialstr
				// type : item
				$post_items = array(
					0 => 'ytb_link',
					1 => 'website',
					2 => 'address',
					3 => 'titlename',
					4 => 'mobile_phones'
				);
				foreach($post_items as $item_key => $item_value)
				{
					//input post
					$post_data		= $this->input->post($item_value);
					$post_name_data = $this->input->post($item_value.'_name');
					$post_name_cid  = $this->input->post($item_value.'_cid');

					if(!empty($post_data))
					{
						foreach($post_data as $key => $value)
						{
							if($value != '')
							{
								if($item_value == 'ytb_link')
								{
									${$item_value.'_array'}[$key]      = $this->http_check($value);
									${$item_value.'_name_array'}[$key] = $post_name_data[$key];
									${$item_value.'_cid'}[$key]        = $post_name_cid[$key];
								}
								else if($item_value == 'website')
								{
									${$item_value.'_array'}[$key]      = $this->http_check($value);
									${$item_value.'_name_array'}[$key] = $post_name_data[$key];
								}
								else if($item_value == 'address') // 2 地址
								{
									${$item_value.'_array'}[$key]	   = $value;
								}
								else if($item_value == 'titlename') // 3 頭銜
								{
									${$item_value.'_array'}[$key]	   = $value;
									${$item_value.'_name_array'}[$key] = $post_name_data[$key];
								}
								else if($item_value == 'mobile_phones') // 4 手機
								{
									${$item_value.'_array'}[$key]	   = $value;
									${$item_value.'_name_array'}[$key] = $post_name_data[$key];
								}
							}
							else
							{
								// delete
						        $delete_where = array(
						            'str_id'    => $key,
						            'member_id' => $this->session->userdata('member_id'),
						            'type'      => $item_key
						        );
						        $this->mod_business->delete_where('strings', $delete_where);
							}
						}
					}
				}
				// update strings
				$type = 0;
				foreach($post_items as $item_key => $item_value)
				{
					// strings array
					$update_data = '';
					if(!empty(${$item_value.'_array'}))
					{
						foreach(${$item_value.'_array'} as $key => $value)
						{
							// 寫入iqr的id字串資料
							$iqr_item_id[$item_value] .= '*#'.$key;

							// update
							$update_data['str'] = $value;
							if($item_value != 'titlename') // 頭銜
							{
								$update_data['str_name'] = ${$item_value.'_name_array'}[$key];
								$update_data['cid'] = ${$item_value.'_cid'}[$key];
							}
							else
								$update_data['str_name'] = '';
							$update_where = array(
								'str_id'    => $key,
								'member_id' => $this->session->userdata('member_id'),
								'type'		=> $type,
							);
							$this->mod_business->update_where_array_set('strings', $update_where, $update_data);
						}
					}
					$type++;
				}

				// iqr html classify sort
				$Array_classify = $this -> input -> post('iqr_classify');
				if(!empty($Array_classify))
				{
					foreach ($Array_classify as $key => $value) {
						$iqr_classify .= "*#" . $value;
					}
				}
				// iqr html sort
				$html_sort = $this -> input -> post('html_sort');
				foreach ($html_sort as $key => $value)
				{
					$result_updata = $this -> mod_business -> update_set('iqr_html', 'html_id', $value, array('html_sort' => $key + 1));
				}

				$Array_ytb_category = $this -> input -> post('ytb_category');
				if(!empty($Array_ytb_category))
				{
					foreach ($Array_ytb_category as $key => $value) {
						$ytb_category .= "*#" . $value;
					}
				}
				//http check
				$facebook 	  = ($this->input->post('facebook') != '') ? $this->http_check($this->input->post('facebook')) : '';
				$line 	 	  = ($this->input->post('line') != '') ? $this->http_check($this->input->post('line')) : '';

				// 企業版未使用參數
				$banner_status=($this->input->post('banner_status')) ? 0 : 0; // 免費體驗連結
				$case_show=($this->input->post('case_show')) ? 0 : 0; // 案例牆
				$iqr_edit = array(
					'l_name'			=> trim($this->input->post('l_name')),
					'f_name'			=> trim($this->input->post('f_name')),
					'l_en_name'			=> $this->input->post('l_en_name'),
					'f_en_name'			=> $this->input->post('f_en_name'),
					'introduce' 		=> $this->input->post('introduce'),
					'mobile' 			=> $this->input->post('mobile'),
					'mobile_name'		=> $this->input->post('mobile_name'),
					'cpn_phone' 		=> $this->input->post('cpn_phone'),
					'cpn_phone_name'	=> $this->input->post('cpn_phone_name'),
					'cpn_cfax'			=> $this->input->post('cpn_cfax'),
					'cpn_fax_name'      => $this->input->post('cpn_fax_name'),
					'cpn_extension'		=> $this->input->post('cpn_extension'),
					'cpn_number' 		=> $this->input->post('cpn_number'),
					'cpn_number_name'	=> $this->input->post('cpn_number_name'),
					'email' 			=> $this->input->post('email'),
					'email_name' 		=> $this->input->post('email_name'),
					'skype' 			=> $this->input->post('skype'),
					'skype_name'		=> $this->input->post('skype_name'),
					'facebook' 			=> $facebook,
					'facebook_name' 	=> $this->input->post('facebook_name'),
					'line' 				=> $line,
					'line_name' 		=> $this->input->post('line_name'),
					'lastname'			=> $this->input->post('iqr_lastname'),
					'firstname'			=> $this->input->post('iqr_firstname'),
					'mphone'			=> $this->input->post('iqr_mphone'),
					'cpn_name'			=> $this->input->post('iqr_cpn_name'),
					'cpn_tel'			=> $this->input->post('iqr_cpn_tel'),
					'cpn_tel_ext'		=> $this->input->post('iqr_cpn_tel_ext'),
					'cpn_fax'			=> $this->input->post('iqr_cpn_fax'),
					'cpn_addr'			=> $this->input->post('iqr_cpn_addr'),
					'ecard_mail'		=> $this->input->post('iqr_ecard_mail'),
					'text_edit01' 		=> $this->input->post('text_edit01'),
					'text_edit01_name'	=> $this->input->post('text_edit01_name'),
					'text_edit02' 		=> $this->input->post('text_edit02'),
					'text_edit02_name'	=> $this->input->post('text_edit02_name'),
					'text_edit03' 		=> $this->input->post('text_edit03'),
					'text_edit03_name'	=> $this->input->post('text_edit03_name'),
					'banner_status'		=> $banner_status,
					'banner_status_name'=> $this->input->post('banner_status_name'),
					'case_show'			=> $case_show,
					'case_show_text'	=> $this->input->post('case_show_text'),
					'ytb_category'		=> $ytb_category,
					'ytb_link' 			=> $iqr_item_id['ytb_link'],
					'website' 			=> $iqr_item_id['website'],
					'address' 			=> $this -> input -> post('addr'),
					'titlename'			=> $iqr_item_id['titlename'],
					'mobile_phones'		=> $iqr_item_id['mobile_phones'],
					'iqr_classify'		=> $iqr_classify,
					'member_id' 		=> $member_id
				);
				$iqr_edit_result=$this->mod_business->update_set('iqr', 'member_id', $member_id, $iqr_edit);

				//導向
				$this->myredirect('/business/edit', $data['EditSuccess'], 5);
				return 0;
			}
		}
	}

	public function ytb_category_add($success='')
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
			$data = $this->data;

			// language
			$this -> lang -> load('views/business/iqr_classify_add', $data['lang']);
			$data['ClassName'] = lang('ClassName');
			$data['Cancle'] = lang('Cancle');
			$data['Add'] = lang('Add');
			$data['NewClass'] = lang('NewClass');
			$data['AddProductClass'] = lang('AddProductClass');
			$data['Max32fonts'] = lang('Max32fonts');

			//member
			$member = $this -> mod_business -> select_from('member', array('member_id'=>$this->session->userdata('member_id')));
			$iqr    = $this -> mod_business -> select_from('iqr', array('member_id' => $this -> session -> userdata('member_id')));
			if(!$this->input->post('form_submit'))
			{
				//新增完成
				$data['success'] = $success;
				if($success == 1)
				{
					$company_classify = $this->mod_business->select_from_order('strings_category', 'cid', 'desc', array('member_id'=>$this->session->userdata('member_id')));
					$data['html_name'] = $company_classify[0]['name'];
					$data['html_id'] = $company_classify[0]['id'];
				}

				//延長ckeditor上傳時間
				$this->extend_ckupload_time(3600, $member['member_id'], $member['img_url'].'ckfinder_image/', $member['auth'], $member['domain_id']);

				$data['gateway_url'] = '/business/ytb_category_add';
				//view
				$this->load->view('business/iqr_classify_add', $data);
			}
			else
			{
				$insert_data = array(
					'member_id'		=> $this -> session -> userdata('member_id'),
					'name' 			=> $this -> input -> post('company_classify_name')
				);
				$id = $this -> mod_business -> insert_into('strings_category', $insert_data);

				if(!empty($iqr['ytb_category']))
				{
					$this -> mod_business -> update_set('iqr', 'member_id', $this -> session -> userdata('member_id'), array('ytb_category' => $iqr['ytb_category'].'*#'.$id));
				}
				else
					$this -> mod_business -> update_set('iqr', 'member_id', $this -> session -> userdata('member_id'), array('ytb_category' => '*#'.$id));

				header('Location: /business/ytb_category_add/1');
			}
		}
	}
	// edit prd_classify
	public function ytb_category_edit($classify_id, $success = '')
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
			$data = $this->data;

			// language
			$this -> lang -> load('views/business/iqr_classify_edit', $data['lang']);
			$data['ClassName'] = lang('ClassName');
			$data['Cancle'] = lang('Cancle');
			$data['Must32Bit'] = lang('Must32Bit');
			$data['EditProductClass'] = lang('EditProductClass');
			$data['_EditProductClass'] = lang('_EditProductClass');
			$data['Save'] = lang('Save');

			if(!$this->input->post('form_submit'))
			{
				//iqr_html
				$data['company_classify'] = $this -> mod_business -> select_from('strings_category', array('member_id' => $this->session->userdata('member_id'), 'cid' => $classify_id));
				$data['classify_name'] = $data['company_classify']['name'];

				//新增完成
				$data['success'] = $success;
				$data['classify_id'] = $classify_id;

				//member
				$member = $this -> mod_business -> select_from('member', array('member_id'=>$this->session->userdata('member_id')));

				//延長ckeditor上傳時間
				$this->extend_ckupload_time(3600, $member['member_id'], $member['img_url'].'ckfinder_image/', $member['auth'], $member['domain_id']);

				$data['gateway_url'] = '/business/ytb_category_edit';

				//view
				$this->load->view('business/iqr_classify_edit', $data);
			}
			else
			{
				$update_data = array(
					'name'	=> $this->input->post('company_classify_name'),
				);
				$this->mod_business->update_set('strings_category', 'cid', $this->input->post('classify_id'), $update_data);

				header('Location: /business/ytb_category_edit/'.$this->input->post('classify_id').'/1');
			}
		}
	}
	// del prd_classify
	public function ytb_category_del($classify_id)
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
			$data = $this->data;
			$iqr      = $this -> mod_business -> select_from('iqr', array('member_id' => $this -> session -> userdata('member_id')));
			$str = $this -> mod_business -> select_from('strings', array('cid' => $classify_id));
			if(empty($str))
			{
				$classify_array = $this -> get_serialstr($iqr['ytb_category'], '*#');
				foreach ($classify_array as $key => $value) {
					if($value != $classify_id)
						$ytb_category .= '*#' . $value;
				}

				$this -> mod_business -> update_set('iqr', 'member_id', $this -> session -> userdata('member_id'), array('ytb_category' => $ytb_category));

				$this -> mod_business -> delete_where('strings_category', array('cid' => $classify_id));
				$this -> script_message($language['DeleteSuccess'], '/business/edit');
			}
			else
			{
				echo '<script>alert("'.$language['ClassUsing'].'")</script>';
				return false;
			}
		}
	}
	public function ajax_chk_category()
	{
		$classifyID = $this -> input -> post('classifyID');

		$count_classify = $this -> mod_business -> select_from('strings', array('cid' => $classifyID));

		if(empty($count_classify))
		{
			echo true;
		}
		else
			echo false;
	}

	//新增自訂網頁
	public function iqr_html_add($success='')
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
			$data = $this->data;

			// language
			$this -> lang -> load('views/business/iqr_html_add', $data['lang']);
			$data['Cancle'] = lang('Cancle');
			$data['ButtonName'] = lang('ButtonName');
			$data['Add'] = lang('Add');
			$data['NewCustomPages'] = lang('NewCustomPages');
			$data['_NewCustomPages'] = lang('_NewCustomPages');
			$data['WebContent'] = lang('WebContent');
			$data['Select'] = lang('Select');
			$data['Class'] = lang('Class');
			$data['Max64fonts'] = lang('Max64fonts');

			//member
			$member = $this->mod_business->select_from('member', array('member_id'=>$this->session->userdata('member_id')));
			$data['classify'] = $classify = $this -> mod_business -> select_from_order('iqr_classify', 'classify_id', 'asc', array('member_id' => $this -> session -> userdata('member_id')));

			//延長ckeditor上傳時間
			$this->extend_ckupload_time(3600, $member['member_id'], $member['img_url'].'ckfinder_image/', $member['auth'], $member['domain_id']);

			if(!$this->input->post('form_submit'))
			{
				//新增完成
				$data['success'] = $success;
				if($success == 1)
				{
					$iqr_html = $this->mod_business->select_from_order('iqr_html', 'html_id', 'desc', array('member_id'=>$this->session->userdata('member_id')));
					$class = $this -> mod_business -> select_from('iqr_classify', array('classify_id' => $iqr_html[0]['classify_id']));
					$data['classify_name'] = $class['classify_name'];
					$data['html_name'] = $iqr_html[0]['html_name'];
					$data['html_id'] = $iqr_html[0]['html_id'];
				}

				//延長ckeditor上傳時間
				$this->extend_ckupload_time(3600, $member['member_id'], $member['img_url'].'ckfinder_image/', $member['auth'], $member['domain_id']);

				//view
				$this->load->view('business/iqr_html_add', $data);
			}
			else
			{
				$insert_data = array(
					'member_id'		=> $this->session->userdata('member_id'),
					'classify_id'	=> $this->input->post('iqr_classify_select'),
					'html_name' 	=> $this->input->post('iqr_html_name'),
					'html_content' 	=> $this->input->post('iqr_html_content')
				);
				$html_id = $this->mod_business->insert_into('iqr_html', $insert_data);

				//更新iqr
				$iqr = $this->mod_business->select_from('iqr', array('member_id' => $this->session->userdata('member_id')));
				$iqr['iqr_html'] .= '*#'.$html_id;
				$this->mod_business->update_set('iqr', 'member_id', $this->session->userdata('member_id'), array('iqr_html' => $iqr['iqr_html']));

				// exchange update
				// auth
		        $auth = intval($member['auth']);
	            // web config
	            $auth_level_num = intval($data['web_config']['auth_level_num']);
	            if($auth_level_num > $auth) // 擁有共享層級的使用者
	            {
	                // share update
	                $add_share_data  = array(
	                    'member_id'  => $this->session->userdata('member_id'),
	                    'iqr_column' => 'iqr_html',
	                    'id'         => $html_id,
	                    'status'     => 1
	                );
	                $add_share_data_where = array(
	                    'member_id'  => $this->session->userdata('member_id'),
	                    'iqr_column' => 'iqr_html',
	                    'id'         => $html_id
	                );
	                $this->mod_business->insert_into('share_data', $add_share_data, $add_share_data_where);

	                // quote update
	                $this->load->model('exchange_model', 'mod_exchange');
	                $member_array = $this->mod_exchange->get_all_member_in_domain($member['domain_id']);
	                foreach($member_array as $key => $value)
	                {
	                    $add_quote_data = array(
	                        'member_id'  => $value,
	                        'parent'     => $this->session->userdata('member_id'),
		                    'iqr_column' => 'iqr_html',
		                    'id'         => $html_id,
	                        'status'     => 0
	                    );
	                    $add_quote_data_where = array(
	                        'member_id'  => $value,
	                        'parent'     => $this->session->userdata('member_id'),
		                    'iqr_column' => 'iqr_html',
		                    'id'         => $html_id
	                    );
	                    $this->mod_business->insert_into('quote_data', $add_quote_data, $add_quote_data_where);
	                }
	            }
	            else
	            {
	                // 會員層級屬於最低層, 無須update
	            }

				header('Location: /business/iqr_html_add/1');
			}
		}
	}

	//編輯自訂網頁
	public function iqr_html_edit($html_id, $success='')
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
			$data = $this->data;

			$this -> lang -> load('views/business/iqr_html_edit', $data['lang']);
			$data['Cancle'] = lang('Cancle');
			$data['ButtonName'] = lang('ButtonName');
			$data['WebContent'] = lang('WebContent');
			$data['EditCustomPages'] = lang('EditCustomPages');
			$data['_EditCustomPages'] = lang('_EditCustomPages');
			$data['Save'] = lang('Save');
			$data['Class'] = lang('Class');
			$data['Max64fonts'] = lang('Max64fonts');

			if(!$this->input->post('form_submit'))
			{
				//iqr_html
				$data['iqr_html'] = $this->mod_business->select_from('iqr_html', array('member_id'=>$this->session->userdata('member_id'), 'html_id'=>$html_id));
				$data['html_name'] = $data['iqr_html']['html_name'];
				$data['classify'] = $this -> mod_business -> select_from_order('iqr_classify', 'classify_id', 'asc', array('member_id' => $this -> session -> userdata('member_id')));
				$classify = $this -> mod_business -> select_from('iqr_classify', array('classify_id' => $data['iqr_html']['classify_id']));

				//新增完成
				$data['success'] = $success;
				$data['html_id'] = $html_id;
				$data['classify_name'] = $classify['classify_name'];

				//member
				$member = $this->mod_business->select_from('member', array('member_id'=>$this->session->userdata('member_id')));

				//延長ckeditor上傳時間
				$this->extend_ckupload_time(3600, $member['member_id'], $member['img_url'].'ckfinder_image/', $member['auth'], $member['domain_id']);

				//view
				$this->load->view('business/iqr_html_edit', $data);
			}
			else
			{
				$update_data = array(
					'html_name' 	=> $this->input->post('iqr_html_name'),
					'html_content' 	=> $this->input->post('iqr_html_content'),
					'classify_id'   => $this->input->post('iqr_classify_select'),
				);
				$this->mod_business->update_set('iqr_html', 'html_id', $this->input->post('html_id'), $update_data);

				header('Location: /business/iqr_html_edit/'.$this->input->post('html_id').'/1');
			}
		}
	}

	//編輯自訂網頁
	public function iqr_html_del($html_id)
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
			$data = $this->data;

			$this->mod_business->delete_where('iqr_html', array('html_id'=>$html_id));

			//更新iqr
			$iqr 	  = $this->mod_business->select_from('iqr', array('member_id'=>$this->session->userdata('member_id')));
			$iqr_html = $this->get_serialstr($iqr['iqr_html'], '*#');
			foreach($iqr_html as $key => $value)
			{
				if($value == $html_id)
				{
					unset($iqr_html[$key]);
					break;
				}
			}
			$result = $this->set_serialstr($iqr_html, '*#');
			$this->mod_business->update_set('iqr', 'member_id', $this->session->userdata('member_id'), array('iqr_html'=>$result));

			// exchange update
			// auth
	        $member = $this->mod_business->select_from('member', array('member_id' => $this->session->userdata('member_id')));
            $auth   = intval($member['auth']);
            // web config
            $auth_level_num = intval($data['web_config']['auth_level_num']);
			if($auth_level_num > $auth) // 擁有共享層級的使用者
            {
                $del_share_data = array(
                    'member_id'  => $this->session->userdata('member_id'),
                    'iqr_column' => 'iqr_html',
                    'id'         => $html_id
                );
                $del_quote_data = array(
                    'parent'     => $this->session->userdata('member_id'),
                    'iqr_column' => 'iqr_html',
                    'id'         => $html_id
                );
                $this->mod_business->delete_where('share_data', $del_share_data);
                $this->mod_business->delete_where('quote_data', $del_quote_data);
            }
            else
            {
                // 會員層級屬於最低層, 無須update
            }

			$this->script_message($language['DeleteSuccess'], '/business/edit');
		}
	}

	// add prd_classify
	public function iqr_classify_add($success='')
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
			$data = $this->data;

			$this -> lang -> load('views/business/iqr_classify_add', $data['lang']);
			$data['ClassName'] = lang('ClassName');
			$data['Cancle'] = lang('Cancle');
			$data['Add'] = lang('Add');
			$data['NewClass'] = lang('NewClass');
			$data['AddProductClass'] = lang('AddProductClass');
			$data['Max32fonts'] = lang('Max32fonts');

			//member
			$member = $this -> mod_business -> select_from('member', array('member_id'=>$this->session->userdata('member_id')));
			$iqr    = $this -> mod_business -> select_from('iqr', array('member_id' => $this -> session -> userdata('member_id')));
			if(!$this->input->post('form_submit'))
			{
				//新增完成
				$data['success'] = $success;
				if($success == 1)
				{
					$company_classify = $this->mod_business->select_from_order('iqr_classify', 'classify_id', 'desc', array('member_id'=>$this->session->userdata('member_id')));
					$data['html_name'] = $company_classify[0]['classify_name'];
					$data['html_id'] = $company_classify[0]['classify_id'];
				}

				//延長ckeditor上傳時間
				$this->extend_ckupload_time(3600, $member['member_id'], $member['img_url'].'ckfinder_image/', $member['auth'], $member['domain_id']);

				$data['gateway_url'] = '/business/iqr_classify_add';

				//view
				$this->load->view('business/iqr_classify_add', $data);
			}
			else
			{
				$insert_data = array(
					'member_id'		=> $this->session->userdata('member_id'),
					'classify_name' => $this->input->post('company_classify_name')
				);
				$html_id = $this -> mod_business -> insert_into('iqr_classify', $insert_data);

				if(!empty($iqr['iqr_classify']))
				{
					$this -> mod_business -> update_set('iqr', 'member_id', $this -> session -> userdata('member_id'), array('iqr_classify' => $iqr['iqr_classify'].'*#'.$html_id));
				}
				else
					$this -> mod_business -> update_set('iqr', 'member_id', $this -> session -> userdata('member_id'), array('iqr_classify' => '*#'.$html_id));

				header('Location: /business/iqr_classify_add/1');
			}
		}
	}
	// edit prd_classify
	public function iqr_classify_edit($classify_id, $success = '')
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
			$data = $this->data;

			$this -> lang -> load('views/business/iqr_classify_edit', $data['lang']);
			$data['ClassName'] = lang('ClassName');
			$data['Cancle'] = lang('Cancle');
			$data['Must32Bit'] = lang('Must32Bit');
			$data['EditProductClass'] = lang('EditProductClass');
			$data['_EditProductClass'] = lang('_EditProductClass');
			$data['Save'] = lang('Save');

			if(!$this->input->post('form_submit'))
			{
				//iqr_html
				$data['company_classify'] = $this -> mod_business -> select_from('iqr_classify', array('member_id' => $this->session->userdata('member_id'), 'classify_id'=> $classify_id));
				$data['classify_name'] = $data['company_classify']['classify_name'];

				//新增完成
				$data['success'] = $success;
				$data['classify_id'] = $classify_id;

				//member
				$member = $this -> mod_business -> select_from('member', array('member_id'=>$this->session->userdata('member_id')));

				//延長ckeditor上傳時間
				$this->extend_ckupload_time(3600, $member['member_id'], $member['img_url'].'ckfinder_image/', $member['auth'], $member['domain_id']);

				$data['gateway_url'] = '/business/iqr_classify_edit';

				//view
				$this->load->view('business/iqr_classify_edit', $data);
			}
			else
			{
				$update_data = array(
					'classify_name'	=> $this->input->post('company_classify_name'),
				);
				$this->mod_business->update_set('iqr_classify', 'classify_id', $this->input->post('classify_id'), $update_data);

				header('Location: /business/iqr_classify_edit/'.$this->input->post('classify_id').'/1');
			}
		}
	}
	// del prd_classify
	public function iqr_classify_del($classify_id)
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
			$data = $this->data;
			$iqr      = $this -> mod_business -> select_from('iqr', array('member_id' => $this -> session -> userdata('member_id')));
			$iqr_html = $this -> mod_business -> select_from('iqr_html', array('classify_id' => $classify_id));
			if(empty($iqr_html))
			{
				$classify_array = $this -> get_serialstr($iqr['iqr_classify'], '*#');
				foreach ($classify_array as $key => $value) {
					if($value != $classify_id)
						$iqr_classify .= '*#' . $value;
				}

				$this -> mod_business -> update_set('iqr', 'member_id', $this -> session -> userdata('member_id'), array('iqr_classify' => $iqr_classify));

				$this -> mod_business -> delete_where('iqr_classify', array('classify_id' => $classify_id));
				$this -> script_message($language['DeleteSuccess'], '/business/edit');
			}
			else
			{
				echo '<script>alert("'. $language['ClassUsing'] .'")</script>';
				return false;
			}
		}
	}

	public function ajax_chk_classify()
	{
		$classifyID = $this -> input -> post('classifyID');

		$count_classify = $this -> mod_business -> select_from('iqr_html', array('classify_id' => $classifyID));

		if(empty($count_classify))
		{
			echo true;
		}
		else
			echo false;
	}

	// No
	//網頁編輯器的顯示頁面
	public function html_web($html_id='')
	{
		$data = $this->data;

		$iqr_html = $this->mod_business->select_from('iqr_html', array('html_id'=>$html_id));
		if($html_id != '')
		{
			$member = $this->mod_business->select_from('member', array('member_id'=>$iqr_html['member_id']));
		}
		else
		{
			redirect(base_url());
		}

		if(!empty($iqr_html) && !empty($member))
		{
			//判斷使用期限
			if(!$this->check_deadline($data['web_config'], $member['member_id']))
			{
				redirect('/index/error');
			}

			//iqr
			$data['id'] = $id;
			$iqr = $this->mod_business->select_from('iqr', array('member_id'=>$member['member_id']));

			//full url
			$data['actual_link'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

			//行動名片連結
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
				$data['bg_image_path'] = ($iqr['theme_bg_image_path'] != '') ? $iqr['theme_bg_image_path'] : $theme['dfu_bg_image_path'];

			//網頁內容
			$data['content'] 	  = $iqr_html['html_content'];
			$data['header_title'] = $iqr_html['html_name'];
			$data['share_link']   = base_url() . 'company/html_share/' . $member['account'] . "/" . $html_id;
			if($this->session->userdata('web_return'))
				$data['web_return'] = base_url().'business/iqr/'.$this->session->userdata('web_return'); //web return
			else
				$data['web_return'] = $data['iqr_url'];

			//搜尋網頁內容是否含圖片
			$data['first_img'] = $this->get_first_img($iqr_html['html_content']);

			//裝置判斷分享bar hideen
			if($this->input->get('d') == 1 && $this->get_device_os() == 'android')
				$data['share_bar_hidden'] = 0;
			$data['android_d'] = $this->input->get('d');

			$data['base_url'] = base_url();
			$data['id']       = $member['account'];
			$data['store']    = $this -> mod_business -> select_from('iqr_cart', array('member_id' => $member['member_id']));
			if ($theme['theme_id']==8){
				$iqr_html = $this->mod_business->select_from_order('iqr_html', 'member_id', 'desc', array('html_id'=>$html_id));
				$data['data']=$iqr_html;
				$this->load->view('business/article_detail' , $data);
			}else {
				$this -> load -> view('template/integrate_web_' . $theme['theme_id'], $data);
				$this -> load -> view('template/integrate_footer/' .$theme['footer_mode_name'], $data);
			}
		}
		else
		{
			redirect(base_url());
		}
	}

	// 封面照上傳
	public function logo()
	{
		$member_id = $this -> session -> userdata('member_id');
		$m = $this -> mod_business -> select_from('member', array('member_id' => $member_id));
		if(!empty($m))
		{
			if($_FILES['t'])
			{
				if($_FILES['t']['error'] != 4)
				{
					$path = $m['img_url'].'logo';
					if (!file_exists('.'.$path))
						@mkdir('.'.$path, 0777);
					$file_data = $this -> upload_pic($_FILES['t'], '.'. $path . '/','logo');
	                $file_data = str_ireplace("./", "", $file_data['path']);
	                $logo = $file_data;
				}
			}
			$this -> mod_business ->update_set('iqr', 'member_id', $this->session->userdata('member_id'), array('logo_path' => $logo));
			if(!empty($logo))
				$this -> script_message('Success', '/business/edit_logo_style');
			else
				$this -> script_message('Fail', '/business/edit_logo_style');
		}
	}
	// 封面照刪除
	public function del_logo()
	{
		$language = $this -> language;
		$path = $this -> input -> post('image_path');
		$member_id = $this -> session -> userdata('member_id');

		$iqr = $this -> mod_business ->select_from('iqr', array('member_id' => $member_id));

		if(!empty($iqr['logo_path']) && $iqr['logo_path'] == $path) {
			if(file_exists($path))
			{
				unlink($path);
				$this -> mod_business -> update_set('iqr', 'member_id', $member_id, array('logo_path' => NULL));

				echo $language['DeleteSuccess'];
			}
			else
			{
				$this -> mod_business -> update_set('iqr', 'member_id', $member_id, array('logo_path' => NULL));
				echo $language['DeleteSuccess'];
			}
		}
		else {
			echo 'fail';
		}
	}
	// 封面照設定
	public function edit_logo_style()
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

			//行動名片資料
			$data['iqr']= $iqr=$this->mod_business->select_from('iqr', array('member_id'=>$this->session->userdata('member_id')));

			//helper
			$this->load->helper('form');

			//會員
			$member=$this->mod_business->select_from('member', array('member_id'=>$this->session->userdata('member_id')));

			//account
			$data['account']=$member['account'];
			$data['mid']=$member['member_id'];

			//view
			$this->load->view('business/edit_logo_style', $data);
		}
	}

	//風格設定頁面
	public function edit_iqr_style()
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
			$this -> lang -> load('views/business/edit_iqr_style', $data['lang']);
				$data['Show'] = lang('Show');
				$data['ClickShow'] = lang('ClickShow');
				$data['CategoryTitle'] = lang('CategoryTitle');
				$data['Radios'] = lang('Radios');
				$data['_StytleSet'] = lang('_StytleSet');
				$data['NotFirefoxChromIE'] = lang('NotFirefoxChromIE');
				$data['SelectStoreSystem'] = lang('SelectStoreSystem');
				$data['ButtonColor'] = lang('ButtonColor');
				$data['Black'] = lang('Black');
				$data['Blue'] = lang('Blue');
				$data['Gray'] = lang('Gray');
				$data['White'] = lang('White');
				$data['Yellow'] = lang('Yellow');
				$data['FontSet'] = lang('FontSet');
				$data['Color'] = lang('Color');
				$data['Size'] = lang('Size');
				$data['Font'] = lang('Font');
				$data['BackSet'] = lang('BackSet');
				$data['UseMaterial'] = lang('UseMaterial');
				$data['UseColor'] = lang('UseColor');
				$data['BackColor'] = lang('BackColor');
				$data['BackMaterial'] = lang('BackMaterial');
				$data['UseDefultBack'] = lang('UseDefultBack');
				$data['DefaulBack'] = lang('DefaulBack');
				$data['Restore'] = lang('Restore');
				$data['Reset'] = lang('Reset');
				$data['Save'] = lang('Save');
				$data['Show'] = lang('Show');
				$data['ClickShow'] = lang('ClickShow');
				$data['CategoryTitle'] = lang('CategoryTitle');
				$data['Radios'] = lang('Radios');

			//行動名片資料
			$iqr=$this->mod_business->select_from('iqr', array('member_id'=>$this->session->userdata('member_id')));
			$data['theme']=$theme=$this->mod_business->select_from_order('iqr_theme', 'order', 'asc');//系統提供版型主題

			//沒收到post顯示編輯頁面
			if(!$this->input->post('form_submit'))
			{
				//helper
				$this->load->helper('form');

				//會員
				$member=$this->mod_business->select_from('member', array('member_id'=>$this->session->userdata('member_id')));

				//account
				$data['account']=$member['account'];
				$data['mid']=$member['member_id'];

				//系統提供版型主題 縮圖路徑 thumb path
				$thumb_dir='/images/integrate/thumb/';
				foreach($theme as $key => $value)
				{
					$data['thumb_path'][$key]=$thumb_dir.$value['theme_thumb_name'];
				}

				//系統背景素材 theme_background
				$dirname = './images/integrate/theme_background/';
				$theme_background = glob($dirname."{*.gif,*.jpg,*.jpeg,*.png,*.GIF,*.JPG,*.PNG}", GLOB_BRACE);
				foreach($theme_background as $key => $value)
				{
					$data['theme_background'][]=substr($value, 1);
				}

				//使用者資料預設值
				//系統版型預設值
				$data['dfu_theme']=$dfu_theme=$this->mod_business->select_from('iqr_theme', array('theme_id'=>$iqr['theme_id']));
				$data['user_theme_id']=($iqr['theme_id'] != '') ? $iqr['theme_id'] : 1;															//系統版型相關預設值
				$data['jqm_button']=$data['user_jqm_button_color']=($iqr['theme_jqm_button'] != '') ? $iqr['theme_jqm_button'] : 'e'; 			//會員使用按鈕顏色值

				for($i=0;$i<4;$i++){
					if ($i>0) $outinum=$i;
					else $outinum='';
					$data['user_theme_font_color'.$outinum]=($iqr['theme_font_color'.$outinum] != '') ? $iqr['theme_font_color'.$outinum] : $dfu_theme['dfu_font_color'];  	//字顏色
					$data['user_theme_font_size'.$outinum]=($iqr['theme_font_size'.$outinum] != '') ? $iqr['theme_font_size'.$outinum] : $dfu_theme['dfu_font_size']; 	    	//字尺寸
					$data['user_theme_font_family'.$outinum]=($iqr['theme_font_family'.$outinum] != '') ? $iqr['theme_font_family'.$outinum] : $dfu_theme['dfu_font_family']; 	//字型
				}
				$data['set_header']=$iqr['set_header'];
				$data['set_03list']=$iqr['set_03list'];


				$data['bg_type']=$iqr['theme_bg_type'];
				$data['user_theme_bg_color']=($iqr['theme_bg_color'] != '') ? $iqr['theme_bg_color'] : $dfu_theme['dfu_bg_color']; 				//背景顏色
				$data['user_theme_bg_image_path']=($iqr['theme_bg_image_path'] != '') ? $iqr['theme_bg_image_path'] : $dfu_theme['dfu_bg_image_path'];//背景圖片
				if($iqr['theme_bg_image_path'] != '')
				{
					$data['user_theme_bg_image_path_id']=intval($this->cut_mystring($iqr['theme_bg_image_path'], 'g_', '.'));
				}
				else
				{
					$data['user_theme_bg_image_path_id']='';
				}
				if($dfu_theme['dfu_bg_image_path'] != '')
				{
					$data['dfu_bg_image_path_id']=intval($this->cut_mystring($dfu_theme['dfu_bg_image_path'], 'g_', '.'));
				}
				else
				{
					$data['dfu_bg_image_path_id']='';
				}
				// font, size, color
				$data['setting_array'] = $settingArray = array('2', '3', '4', '5');
				//selected
				foreach ($settingArray as $key => $value)
				{
					$data['user_font_color_'. $value] = ($iqr['theme_font_color_'. $value] != '') ? $iqr['theme_font_color_'. $value] : $dfu_theme['dfu_font_color_'. $value];  	    // 字顏色
					$data['user_font_size_'. $value] = ($iqr['theme_font_size_'. $value] != '') ? $iqr['theme_font_size_'. $value] : $dfu_theme['dfu_font_size_'. $value]; 	    	// 字尺寸
					$data['user_font_family_'. $value] = ($iqr['theme_font_family_'. $value] != '') ? $iqr['theme_font_family_'. $value] : $dfu_theme['dfu_font_family_'. $value]; 	// 字型
					$data['font_size_selected_'. $value][$data['user_font_size_'. $value]] = 'selected';	//尺寸
					$data['font_family_selected_'. $value][$data['user_font_family_'. $value]] = 'selected';	//字型
				}
				$data['bg_type_checked'][$data['bg_type']] = 'checked';//背景模式:color, or image
				$data['jqm_button_selected'][$data['user_jqm_button_color']] = 'selected';//按鈕樣式預設

				for($i=0;$i<4;$i++){
					if ($i>0) $outinum=$i;
					else $outinum='';
					$data['font_size_selected'.$outinum] = $data['user_theme_font_size'.$outinum];	//尺寸
					$data['font_family_selected'.$outinum]= $data['user_theme_font_family'.$outinum];	//字型
				}
				//arrow方向
				if($this->get_device_type() >= 1)//mobile
					$data['pageguide_tag_arrow']='tlypageguide_top';
				else
					$data['pageguide_tag_arrow']='tlypageguide_left';

				//view
				$this->load->view('business/edit_iqr_style', $data);
			}
			else
			{//寫入編輯資料

				//背景圖
				if($this->input->post('background_type') == 1)
				{
					if(strnatcmp($this->input->post('theme_background_radio'), 0) == 0)//使用系統版型預設背景
					{
						$theme=$this->mod_business->select_from('iqr_theme', array('theme_id'=>$this->input->post('theme_radio')));
						$bg_path=$theme['dfu_bg_image_path'];//使用背景-素材模式-預設圖片
					}
					else $bg_path=$this->input->post('theme_background_radio');//使用背景-素材模式-自訂系統素材
				}
				else $bg_path='';//使用背景-顏色模式

				// 更新陣列
				$update_theme=array(
					'theme_id'=>$this->input->post('theme_radio'),
					'theme_jqm_button'=>$this->input->post('jqm_button_color'),
					'theme_bg_type'=>$this->input->post('background_type'),
					'theme_bg_color'=>$this->input->post('background_color'),
					'set_03list'=>$this->input->post('set_03list'),
					'set_header'=>$this->input->post('set_header'),
					'theme_bg_image_path'=>$bg_path
				);

				for($i=0;$i<4;$i++){
					if ($i>0) $outinum=$i;
					else $outinum='';
					$update_theme['theme_font_color'.$outinum]=$this->input->post('fonts_color'.$outinum);
					$update_theme['theme_font_size'.$outinum]=$this->input->post('fonts_size'.$outinum);
					$update_theme['theme_font_family'.$outinum]=$this->input->post('fonts_family'.$outinum);
				}

				if($this -> input -> post('theme_radio') == '8')
				{
					for ($i = 2; $i < 6; $i++)
					{
						$update_theme['theme_font_color_'.$i]  = $this -> input -> post('fonts_color_'. $i);
						$update_theme['theme_font_size_'. $i]  = $this -> input -> post('fonts_size_'. $i);
						$update_theme['theme_font_family_'. $i]  = $this -> input -> post('fonts_family_'. $i);
					}
				}

				$this->mod_business->update_set('iqr', 'member_id', $this->session->userdata('member_id'), $update_theme);

				//導向
				$this->myredirect('/business/edit_iqr_style', $language['EditSuccess'], 5);
				return 0;
			}
		}
	}

	// 購物車設定頁面
	public function edit_cart_style()
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
			$this -> lang -> load('views/business/edit_cart_style', $data['lang']);
			$data['MenuColor'] = lang('MenuColor');
			$data['Gray'] = lang('Gray');
			$data['_ActionStoreSet'] = lang('_ActionStoreSet');
			$data['Restore'] = lang('Restore');
			$data['Reset'] = lang('Reset');
			$data['Pink'] = lang('Pink');
			$data['Purple'] = lang('Purple');
			$data['Black'] = lang('Black');
			$data['View'] = lang('View');
			$data['Green'] = lang('Green');
			$data['SelectStore'] = lang('SelectStore');
			$data['Orange'] = lang('Orange');
			$data['Save'] = lang('Save');
			$data['ClickView'] = lang('ClickView');

			// iframe data
			$cart = $this -> mod_business -> select_from('iqr_cart', array('member_id' => $this -> session -> userdata('member_id')));
			$data['cset_code'] = $cart['cset_code'];

			//行動名片資料
			$iqr=$this->mod_business->select_from('iqr', array('member_id'=>$this->session->userdata('member_id')));
			$data['theme']=$theme=$this->mod_business->select_from_order('cart_theme', 'cart_id', 'asc');//系統提供版型主題

			//沒收到post顯示編輯頁面
			if(!$this->input->post('form_submit'))
			{
				//helper
				$this->load->helper('form');

				//會員
				$member=$this->mod_business->select_from('member', array('member_id'=>$this->session->userdata('member_id')));

				//account
				$data['account']=$member['account'];
				$data['mid']=$member['member_id'];

				//系統提供版型主題 縮圖路徑 thumb path
				$thumb_dir='/images/integrate/cart_thumb/';
				foreach($theme as $key => $value)
				{
					$data['thumb_path'][$key]=$thumb_dir.$value['cart_thumb_name'];
				}

				$menu_dir = '/images/integrate/cart_thumb/';
				foreach ($theme as $key => $value)
				{
					$data['menu_path'][$key] = $menu_dir.$value['cart_menu_type'].'.jpg';
				}


				//使用者資料預設值
				//系統版型預設值
				$data['user_cart_id']=($iqr['cart_id'] != '') ? $iqr['cart_id'] : 1;	//系統版型相關預設值
				$data['user_menu_id']=($iqr['cart_menu_button'] != '') ? $iqr['cart_menu_button'] : 'demo-1'; //會員使用按鈕顏色值

				//selected
				$data['jqm_button_selected'][$data['user_jqm_button_color']] = 'selected';//按鈕樣式預設

				//arrow方向
				if($this->get_device_type() >= 1)//mobile
					$data['pageguide_tag_arrow']='tlypageguide_top';
				else
					$data['pageguide_tag_arrow']='tlypageguide_left';

				//view
				$this->load->view('business/edit_cart_style', $data);
			}
			else
			{//寫入編輯資料

				//更新陣列
				$update_theme=array(
					'cart_id'=>$this->input->post('theme_radio'),
					'cart_menu_button'=>$this->input->post('jqm_button_color')
				);
				$this->mod_business->update_set('iqr', 'member_id', $this->session->userdata('member_id'), $update_theme);

				//導向
				$this->myredirect('/business/edit_cart_style', $language['EditSuccess'], 5);
				return 0;
			}
		}
	}

	// 風格標題設定
	public function edit_header_str()
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

			$this -> lang -> load('views/business/style_header_setting', $data['lang']);
			$data['ClassTitleName'] = lang('ClassTitleName');
			$data['_ClassTitleName'] = lang('_ClassTitleName');
			$data['ShowDataEx'] = lang('ShowDataEx');
			$data['NotFirefoxChromIE'] = lang('NotFirefoxChromIE');
			$data['RequiredField'] = lang('RequiredField');
			$data['MoveMouse'] = lang('MoveMouse');
			$data['SaveEdit'] = lang('SaveEdit');

			//行動名片資料
			$data['iqr']       = $iqr = $this -> mod_business -> select_from('iqr', array('member_id' => $this -> session -> userdata('member_id')));
			$data['member_id'] = $iqr['member_id'];

			$default_header = $this -> mod_business -> select_from('system_header', array('theme_id' => $iqr['theme_id']));
			$default_header_array = $this -> get_serialstr($default_header['header_default'], '*#');

		    $header_array = $this -> get_serialstr($iqr['str_header'], '*#');

		    if(count($default_header_array) != count($header_array))
		    {
		    	foreach ($default_header_array as $key => $value)
		    	{
		    		$data['header_text'][$key] = $value;
		    	}
		    }
		    else
		    {
		    	foreach ($header_array as $key => $value)
		    	{
		    		$data['header_text'][$key] = $value;
		    	}
		    }

			if($this -> input -> post('form_submit'))
			{
				$str = $this -> input -> post('strings_array');
				foreach ($str as $key => $value)
				{
					$db_str .= '*#'.$value;
				}
				$this -> mod_business -> update_set('iqr', 'member_id', $this -> session -> userdata('member_id'), array('str_header' => $db_str));
			}

			$this -> load -> view('business/style_header_setting', $data);
		}
	}

	//Ajax 取得系統版型預設值
	public function iqr_default_style()
	{
		if($this->input->post('theme_id'))
		{
			//系統版型預設值
			$data['dfu_theme']=$dfu_theme=$this->mod_business->select_from('iqr_theme', array('theme_id'=>$this->input->post('theme_id')));
			if($dfu_theme['dfu_bg_image_path'] != '')
			{
				$pos=strpos($dfu_theme['dfu_bg_image_path'], '.jpg');
				$data['dfu_theme']['bg_image_path_id']=intval(substr($dfu_theme['dfu_bg_image_path'], $pos-2, 2));
			}
			else
			{
				$data['dfu_theme']['bg_image_path_id']='';
			}
			$result=$data['dfu_theme'];

			//結果回傳
	 		$ajax_data = json_encode($result);
			echo $ajax_data;
		}
	}

	//Ajax 取得購物車版型預設值
	public function cart_default_style()
	{
		if($this->input->post('cart_id'))
		{
			//系統版型預設值
			$data['dfu_theme']=$dfu_theme=$this->mod_business->select_from('cart_theme', array('cart_id'=>$this->input->post('cart_id')));
		}
		$result = $data['dfu_theme'];
		//結果回傳
 		$ajax_data = json_encode($result);
		echo $ajax_data;
	}

	public function cart_menu_style()
	{
		if($this -> input -> post('menu_id'));
		{
			$data['dfu_theme']=$dfu_theme=$this->mod_business->select_from('cart_theme', array('cart_menu_type'=>$this->input->post('menu_id')));
		}
		$result = $data['dfu_theme'];
		$ajax_data = json_encode($result);
		echo $ajax_data;
	}


	//QRcode顯示頁面
	public function view_qrcode($id='', $type='')
	{
		$data = $this -> data;

		$lang = $this -> mod_language -> converter('12', $this -> session -> userdata('lang'));
		$data = array_merge($data, $lang);

		if($id != '')
		{
			$member=$this->mod_business->select_from('member', array('member_id'=>$id));
		}
		else
		{
			redirect(base_url());
		}

		if(!empty($member))
		{
			//判斷使用期限
			if(!$this->check_deadline($data['web_config'], $member['member_id']))
			{
				redirect('/index/error');
			}

			//helper
			$this->load->helper('form');

			//full url
			$data['actual_link'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

			//account
			$data['account']=$member['account'];
			$data['mid']=$id;

			//行動名片連結
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

			//行動名片資料
			$data['iqr']=$iqr=$this->mod_business->select_from('iqr', array('member_id'=>$member['member_id']));

			//0
			$data['mphone']  = ( $iqr['mphone'] ==0 ) ? '' : $iqr['mphone'];
			$data['cpn_tel'] = ( $iqr['cpn_tel']==0 ) ? '' : $iqr['cpn_tel'];
			$data['cpn_fax'] = ( $iqr['cpn_fax']==0 ) ? '' : $iqr['cpn_fax'];

			//edit_target
			$data['edit_target'] = $type;

			//qrcode style
			$data['style'] = $iqr_style=$this->mod_business->select_from('qrc_style', array('member_id'=>$member['member_id'], 'type'=>$type));

			//mode預設
			$data['eclevel_selected'][$data['style']['eclevel']] = 'selected';
			$data['mode_selected'][$data['style']['mode']] 		 = 'selected';
			$data['font_selected'][$data['style']['font']] 		 = 'selected';
			$data['mode_value']=$data['style']['mode'];

			//內嵌圖片模式
			if($data['style']['mode'] == 3 || $data['style']['mode'] == 4)
			{
				$img_src=$this->mod_business->select_from('qrc_image', array('qimg_id'=>$data['style']['qimg_id']));
				$data['img_content']=$img_src['qimg_content'];
			}
			else
			{
				$data['img_content']='';
			}

			//0
			$data['mphone']  = ( $iqr['mphone'] ==0 ) ? '' : $iqr['mphone'];
			$data['cpn_tel'] = ( $iqr['cpn_tel']==0 ) ? '' : $iqr['cpn_tel'];
			$data['cpn_fax'] = ( $iqr['cpn_fax']==0 ) ? '' : $iqr['cpn_fax'];

			$data['button'] = true;
			//share title
			switch ($type) {
				case 0:
					$data['share_title'] = $iqr['l_name'].$iqr['f_name'].$data['_SystemWeb'];
					$data['share_link']  = $data['iqr_url'];
					$data['ClickDownload'] = $data['OpenThisPage'];
					break;
				case 1:
					$data['share_title'] = $Joinin.$iqr['l_name'].$iqr['f_name'].$data['ToPhoneContacts'];
					$data['share_link']  = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
					$data['ClickDownload'] = $data['ClickQrcodeToJoinPhoneContacts'];
					$data['button'] = false;
					break;
				case 2:
					$data['share_title'] = $iqr['l_name'].$iqr['f_name'].$data['_SystemApp'];
					$data['share_link']  = base_url().'app/route/'.$id;
					$data['ClickDownload'] = $data['ClickToDownloadAPP'];
					break;
			}

			//icon
			$dirname = '.'.$member['img_url'].'icon/';
			$icon = glob($dirname.'{icon.png}', GLOB_BRACE);//"{*.gif,*.jpg,*.jpeg,*.png,*.GIF,*.JPG,*.PNG}"
			// 預設狀態變更
			if(!is_file($icon[0]) || $iqr['icon_status'] == 0)
				$data['icon'] = '/images/web_style_images/'.$data['web_banner_dir'].'/app_welcome_page/icon100x100.png';
			else
			{
				$icon = glob($dirname."icon100x100.png", GLOB_BRACE);
				$data['icon'] = substr($icon[0], 1);
			}

			//裝置判斷分享bar hideen
			if($this->input->get('d') == 1 && $this->get_device_os() == 'android')
				$data['share_bar_hidden'] = 0;
			$data['android_d'] = $this->input->get('d');

			$this->load->view('business/view_qrcode', $data);
		}
		else
		{
			redirect(base_url());
		}
	}

	// Qrcode type: 1, click ajax echo json
	public function ajax_qrcode_content()
	{
		$member_id = $this -> input -> get('mid');
		$iqr_url = $this -> input -> get('iqr_url');

		if($member_id)
		{
			$member = $this -> mod_business -> select_from('member', array('member_id' => $member_id));

			if(!empty($member))
			{
				$select_columns = array(
					'lastname',
					'firstname',
					'mphone',
					'cpn_name',
					'cpn_tel',
					'cpn_fax',
					'cpn_addr',
					'ecard_mail'
				);
				$iqr = $this -> mod_business -> select_from_where('iqr', $select_columns, array('member_id' => $member_id));

				$json_text = array(
					'N' 			=> $iqr['lastname'] . $iqr['firstname'],
					'TEL;CELL' 		=> $iqr['mphone'],
					'NOTE'			=> $iqr['cpn_name'],
					'TEL;WORK'		=> $iqr['cpn_tel'],
					'TEL;WORK;FAX'	=> $iqr['cpn_fax'],
					'ADR;WORK'		=> $iqr['cpn_addr'],
					'EMAIL'			=> $iqr['ecard_mail'],
					'URL'			=> $iqr_url,
				);
			}
			else
			$json_text = 'Fail';
		}
		else
			$json_text = 'Fail';

		echo json_encode($json_text);
	}

	//QRcode顯示頁面
	public function iqrc($id='', $type=0)
	{
		$data = $this -> data;

		$lang = $this -> mod_language -> converter('999', $this -> session -> userdata('lang'));
		$data = array_merge($data, $lang);
		$lang = $this -> mod_language -> converter('19', $this -> session -> userdata('lang'));
		$data = array_merge($data, $lang);

		if($id != '')
		{
			$member=$this->mod_business->select_from('member', array('member_id'=>$id));
		}
		else
		{
			redirect(base_url());
		}

		if(!empty($member))
		{
			//判斷使用期限
			if(!$this->check_deadline($data['web_config'], $member['member_id']))
			{
				redirect('/index/error');
			}

			//helper
			$this->load->helper('form');

			//account
			$data['account']=$member['account'];
			$data['mid']=$id;

			//行動名片連結
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

			//base_url
			$data['base_url']=base_url();

			//行動名片資料
			$data['iqr']=$iqr=$this->mod_business->select_from('iqr', array('member_id'=>$member['member_id']));

			if ($type == '2' && $iqr['apk'] != '1' || $iqr['ipa'] != '1')
			{
				$this -> script_message_location_where($data['SettingYourAPP'], '/appui/build', true, false);
			}

			//0
			$data['mphone']  = ( $iqr['mphone'] ==0 ) ? '' : $iqr['mphone'];
			$data['cpn_tel'] = ( $iqr['cpn_tel']==0 ) ? '' : $iqr['cpn_tel'];
			$data['cpn_fax'] = ( $iqr['cpn_fax']==0 ) ? '' : $iqr['cpn_fax'];

			//edit_target
			$data['edit_target']=$type;
			switch ($type) {
				case 0:
					$data['qrcode_box_text'] = $data['QuickOpenSystemWeb'];
					break;
				case 2:
					$data['qrcode_box_text'] = $data['QuickOpenSystemApp'];
					break;
			}

			//qrcode style
			$data['style']=$iqr_style=$this->mod_business->select_from('qrc_style', array('member_id'=>$member['member_id'], 'type'=>$type));

			//mode預設
			$data['eclevel_selected'][$data['style']['eclevel']] = 'selected';
			$data['mode_selected'][$data['style']['mode']] 		 = 'selected';
			$data['font_selected'][$data['style']['font']] 		 = 'selected';
			$data['mode_value']=$data['style']['mode'];

			//內嵌圖片模式
			if($data['style']['mode'] == 3 || $data['style']['mode'] == 4)
			{
				$img_src=$this->mod_business->select_from('qrc_image', array('qimg_id'=>$data['style']['qimg_id']));
				$data['img_content']=$img_src['qimg_content'];
			}
			else
			{
				$data['img_content']='';
			}
			//0
			$data['mphone']  = ( $iqr['mphone'] ==0 ) ? '' : $iqr['mphone'];
			$data['cpn_tel'] = ( $iqr['cpn_tel']==0 ) ? '' : $iqr['cpn_tel'];
			$data['cpn_fax'] = ( $iqr['cpn_fax']==0 ) ? '' : $iqr['cpn_fax'];

			$data['l_name']=$iqr['l_name'];
			$data['f_name']=$iqr['f_name'];

			if($this->get_device_type() > 0)
				$data['device_check'] = 1;
			else
				$data['device_check'] = 0;

			$this->load->view('business/view_qrcode_box', $data);
		}
		else
		{
			redirect(base_url());
		}
	}

	//QRcode編輯頁面
	public function edit_qrcode($edit_target='')
	{
		$data = $this -> data;
		$lang = $this -> mod_language -> converter('4', $this -> session -> userdata('lang'));
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
			//data

			$iqr = $this -> mod_business -> select_from('iqr', array('member_id' => $this -> session -> userdata('member_id')));

			if (empty($iqr['firstname']) && $edit_target == 1) {
				$this -> script_message($data['ValidateContentsQrcode'], '/business/edit');
			} elseif ($iqr['apk'] != '1' && $iqr['ipa'] != '1' && $edit_target) {
				$this -> script_message($data['ValidateAPPQrcode'], '/appui/build');
			}

			$data['id']=$this->session->userdata('member_id');

			//edit_target
			$data['edit_target']=$edit_target;

			switch ($edit_target) {
				case 0:
					$data['qrcode_file_name']=$data['SystemWebQRcode'];
					break;
				case 1:
					$data['qrcode_file_name']=$data['ContactsQRcode'];
					break;
				case 2:
					$data['qrcode_file_name']=$data['SystemAppQRcode'];
					break;
			}

			$this->load->view('business/edit_qrcode', $data);
		}
	}

	//QRcode編輯頁面 - iframe
	public function editer_iframe($edit_target='')
	{
		$data=$this->data;
		$lang = $this -> mod_language -> converter('5', $this -> session -> userdata('lang'));
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
			switch ($edit_target) {
				case 0:
					$data['qrcode_file_name']=$data['SystemWebQRcode'];
					$iqr_qrcode = 'iqr_qrcode_web';
					break;
				case 1:
					$data['qrcode_file_name']=$data['ContactsQRcode'];
					$iqr_qrcode = 'iqr_qrcode_contact';
					break;
				case 2:
					$data['qrcode_file_name']=$data['SystemAppQRcode'];
					$iqr_qrcode = 'iqr_qrcode_app';
					break;
			}

			//行動名片資料
			$data['iqr'] = $iqr = $this->mod_business->select_from('iqr', array('member_id'=>$this->session->userdata('member_id')));
			$data['btn_name'] = $iqr[$iqr_qrcode];

			$data['edit_target']=$edit_target;

			//沒收到post顯示編輯頁面
			if(!$this->input->post('form_submit'))
			{
				//helper
				$this->load->helper('form');

				//member
				$member=$this->mod_business->select_from('member', array('member_id'=>$this->session->userdata('member_id')));

				//account
				$data['account']=$member['account'];
				$data['mid']=$member['member_id'];

				//行動名片連結
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
			
				//qrcode style
				$data['style']=$iqr_style=$this->mod_business->select_from('qrc_style', array('member_id'=>$this->session->userdata('member_id'), 'type'=>$edit_target));

				if($iqr_style['qrcode_btn'])
				{
					$open_btn_css  = '';
					$close_btn_css = 'display: none;';
				}
				else
				{
					$open_btn_css  = 'display: none;';
					$close_btn_css = '';
				}

				//mode預設
				$data['eclevel_selected'][$data['style']['eclevel']] = 'selected';
				$data['mode_selected'][$data['style']['mode']] 		 = 'selected';
				$data['font_selected'][$data['style']['font']] 		 = 'selected';
				$data['mode_value'] 								 = $data['style']['mode'];
				$data['open_btn_css'] 							     = $open_btn_css;
				$data['close_btn_css']								 = $close_btn_css;
				//內嵌圖片模式
				if($data['style']['mode'] == 3 || $data['style']['mode'] == 4)
				{
					$img_src=$this->mod_business->select_from('qrc_image', array('qimg_id'=>$data['style']['qimg_id']));
					$data['img_content']=$img_src['qimg_content'];
				}
				else
				{
					$data['img_content']='';
				}

				//0
				$data['mphone']  = ( $iqr['mphone'] ==0 ) ? '' : $iqr['mphone'];
				$data['cpn_tel'] = ( $iqr['cpn_tel']==0 ) ? '' : $iqr['cpn_tel'];
				$data['cpn_fax'] = ( $iqr['cpn_fax']==0 ) ? '' : $iqr['cpn_fax'];

				//view
				$this->load->view('business/edit_qrcode_iframe', $data);
			}
			else
			{//寫入編輯資料

				//member
				$member=$this->mod_business->select_from('member', array('account'=>$this->input->post('id')));

				$style_data=array(
			        'mode'      	=>$this->input->post('mode'),       // QR Code模式
			        'size'      	=>$this->input->post('size'),       // QR Code尺寸
			        'fill'      	=>$this->input->post('fill'),       // 前景顏色
			        'background'  	=>$this->input->post('background'), // 背景顏色
			        'minversion'  	=>$this->input->post('minversion'), // 複雜程度
			        'eclevel'   	=>$this->input->post('eclevel'),    // 顆粒細緻程度
			        'quiet'     	=>$this->input->post('quiet'),      // 留邊尺寸
			        'radius'    	=>$this->input->post('radius'),     // 容錯程度
			        'msize'     	=>$this->input->post('msize'),      // 嵌入字樣或圖形尺寸
			        'mposx'     	=>$this->input->post('mposx'),      // 嵌入字樣或圖形位置X
			        'mposy'     	=>$this->input->post('mposy'),      // 嵌入字樣或圖形位置Y
			        'label'     	=>$this->input->post('label'),      // 嵌入字樣內容
			        'font'     		=>$this->input->post('font'),      	// 嵌入字樣字型
			        'fontcolor'  	=>$this->input->post('fontcolor')   // 嵌入字樣顏色
				);
				$style=$this->mod_business->update_where_array_set('qrc_style', array('member_id'=>$member['member_id'], 'type'=>$this->input->post('edit_target')), $style_data);

				// 按鈕名稱
				switch ($this->input->post('edit_target')) {
					case 0:
						$edit_iqr_qrcode = 'iqr_qrcode_web';
						break;
					case 1:
						$edit_iqr_qrcode = 'iqr_qrcode_contact';
						break;
					case 2:
						$edit_iqr_qrcode = 'iqr_qrcode_app';
						break;
				}
				$this->mod_business->update_set('iqr', 'member_id', $member['member_id'], array($edit_iqr_qrcode=>$this->input->post('btn_name')));

				//$this->arr_print('data', $style_data);
				//內嵌圖檔
				if($this->input->post('image') && $this->input->post('mode') > 2)
				{
					$image=array(
				        'qimg_content'=>$this->input->post('image')
					);
					$this->mod_business->update_where_array_set('qrc_image', array('member_id'=>$member['member_id'], 'type'=>$this->input->post('edit_target')), $image);
				}
			}
		}
	}
	// QRcode show/hide
	public function ajax_editer_qrcode_btn()
	{
		$language = $this -> language;
		if(!$this->session->userdata('member_id'))
		{
			//未登入
			$this->myredirect('/index/login', $language['PleaseLogin'], 5);
			return 0;
		}
		else
		{
			$your_qrcode_style = $this -> mod_business -> select_from('qrc_style', array('member_id' => $this -> input -> post('member_id'), 'type' => $this -> input -> post('type')));
			if($your_qrcode_style)
			{
			 	$this -> mod_business -> update_where_array_set('qrc_style', array('member_id' => $this -> input -> post('member_id'),'type' => $this -> input -> post('type')), array('qrcode_btn' => $this -> input -> post('qrcode_btn')));
				$requset = true;
			}
			else
				$requset = false;
			echo $requset;
		}
	}

	//相簿與附件
	public function photo_management()
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

			$this -> lang -> load('views/business/photo_management', $data['lang']);
			$data['NowNoPhoto'] = lang('NowNoPhoto');
			$data['SelectAll'] = lang('SelectAll');
			$data['All'] = lang('All');
			$data['Cancle'] = lang('Cancle');
			$data['NotFirefoxChromIE'] = lang('NotFirefoxChromIE');
			$data['_AlbumManagement'] = lang('_AlbumManagement');
			$data['Zhang'] = lang('Zhang');
			$data['SequencePhoto'] = lang('SequencePhoto');
			$data['RemoveSelectePhoto'] = lang('RemoveSelectePhoto');
			$data['RemovPhoto'] = lang('RemovPhoto');
			$data['AddPhoto'] = lang('AddPhoto');
			$data['FromLeftToRight'] = lang('FromLeftToRight');
			$data['EditAnnotation'] = lang('EditAnnotation');
			$data['CheckRemovePhoto'] = lang('CheckRemovePhoto');
			$data['SaveSequence'] = lang('SaveSequence');
			$data['SavePhotoAnnotation'] = lang('SavePhotoAnnotation');
			$data['PhotoCaption64words'] = lang('PhotoCaption64words');

			//member
			$member=$iqr=$this->mod_business->select_from('member', array('member_id'=>$this->session->userdata('member_id')));

			//行動名片資料
			$data['iqr']=$iqr=$this->mod_business->select_from('iqr', array('member_id'=>$this->session->userdata('member_id')));

			//helper
			$this->load->helper('form');

			//account
			$data['account']=$member['account'];
			$data['mid']=$this->session->userdata('member_id');

			//行動名片連結
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

			//形象圖設定
			$myphoto=$this->get_serialstr($iqr['photo'], '*#');
			$data['myphoto_num']=0;
			if(!empty($myphoto))
			{
				$fix_status=false;
				foreach($myphoto as $key => $value)
				{
					// $data['myphoto'][$key]=$this->mod_business->get_img_path($value);
					$img=$this->mod_business->select_from('images', array('img_id'=>$value));
					if(!empty($img))
					{
						if(empty($data['myphoto_id']))
						{
							$data['myphoto_num']++;
							$data['myphoto'][$key]=substr($img['img_path'], 1);
							$data['myphoto_name'][$key]=$img['img_note'];
							$data['myphoto_id'][$key]=$value;
						}
						else if(!in_array($value, $data['myphoto_id']))
						{
							$data['myphoto_num']++;
							$data['myphoto'][$key]=substr($img['img_path'], 1);
							$data['myphoto_name'][$key]=$img['img_note'];
							$data['myphoto_id'][$key]=$value;
						}
						else
						{
							$fix_status=true;
						}
					}
				}
				//順便修正DB資料
				if($fix_status && !empty($data['myphoto_id']))
				{
					$myphoto_id_str=$this->set_serialstr($data['myphoto_id'], '*#');
					$this->mod_business->update_set('iqr', 'member_id', $this->session->userdata('member_id'), array('photo'=>$myphoto_id_str));
				}
			}

			//公司照片設定
			$cpnphoto=$this->get_serialstr($iqr['cpn_photo'], '*#');
			$data['cpnphoto_num']=0;
			if(!empty($cpnphoto))
			{
				$fix_status=false;
				foreach($cpnphoto as $key => $value)
				{
					$img=$this->mod_business->select_from('images', array('img_id'=>$value));
					if(!empty($img))
					{
						if(empty($data['cpnphoto_id']))
						{
							$data['cpnphoto_num']++;
							$data['cpnphoto'][$key]=substr($img['img_path'], 1);
							$data['cpnphoto_name'][$key]=$img['img_note'];
							$data['cpnphoto_id'][$key]=$value;
						}
						else if(!in_array($value, $data['cpnphoto_id']))
						{
							$data['cpnphoto_num']++;
							$data['cpnphoto'][$key]=substr($img['img_path'], 1);
							$data['cpnphoto_name'][$key]=$img['img_note'];
							$data['cpnphoto_id'][$key]=$value;
						}
						else
						{
							$fix_status=true;
						}
					}
				}
				//順便修正DB資料
				if($fix_status && !empty($data['cpnphoto_id']))
				{
					$cpnphoto_id_str=$this->set_serialstr($data['cpnphoto_id'], '*#');
					$this->mod_business->update_set('iqr', 'member_id', $this->session->userdata('member_id'), array('cpn_photo'=>$cpnphoto_id_str));
				}
			}
			//********************改成自由新增
			$this->load->model("photo_category_model");
			$data["photo_list"]=$this->photo_category_model->get_photo_category();
			foreach($data["photo_list"] as $d_id=>$val){
				$photo_column=$this->get_serialstr($val['d_photo'], '*#');
				$data['photo_num'][$d_id]=0;
				if(!empty($photo_column)){
					$fix_status=false;
					foreach($photo_column as $key => $value){
						$img=$this->mod_business->select_from('images', array('img_id'=>$value));
						if(!empty($img)){
							if(empty($data['photo_id'])){
								$data['photo_num'][$d_id]++;
								$data['photo'][$d_id][$key]=substr($img['img_path'], 1);
								$data['photo_name'][$d_id][$key]=$img['img_note'];
								$data['photo_id'][$d_id][$key]=$value;
							}
							else if(!in_array($value, $data['photo_id']))
							{
								$data['photo_num'][$d_id]++;
								$data['photo'][$d_id][$key]=substr($img['img_path'], 1);
								$data['photo_name'][$d_id][$key]=$img['img_note'];
								$data['photo_id'][$d_id][$key]=$value;
							}
							else
							{
								$fix_status=true;
							}
						}
					}
					//順便修正DB資料
					if($fix_status && !empty($data['photo_id'][$d_id]))
					{
						$myphoto_id_str=$this->set_serialstr($data['myphoto_id'], '*#');
						$this->mod_business->update_set('photo_category', 'd_id', $d_id, array('photo'=>$myphoto_id_str));
					}
				}
			}
			//*******************


			//附件設定
			$exfile=$this->get_serialstr($iqr['exfile'], '*#');
			$data['exfile_num']=0;
			if(!empty($exfile))
			{
				$fix_status=false;
				foreach($exfile as $key => $value)
				{
					$doc=$this->mod_business->select_from('documents', array('doc_id'=>$value));
					if(!empty($doc))
					{
						if(empty($data['exfile_id']))
						{
							$data['exfile_num']++;
							$data['exfile'][$key]=substr($doc['doc_path'], 1);
							$pos=strrpos($doc['doc_path'], '.');
							$data['exfile_extname'][$key]=substr($doc['doc_path'], $pos+1);
							$data['exfile_name'][$key]=$doc['doc_name'];
							$pos=strrpos($doc['doc_ori_name'], '.');
							$data['exfile_ori_name'][$key]=$doc['doc_ori_name'];
							$data['doc_ori_name'][$key]=$doc['doc_ori_name'];
							$data['exfile_id'][$key]=$value;
						}
						else if(!in_array($value, $data['exfile_id']))
						{
							$data['exfile_num']++;
							$data['exfile'][$key]=substr($doc['doc_path'], 1);
							$pos=strrpos($doc['doc_path'], '.');
							$data['exfile_extname'][$key]=substr($doc['doc_path'], $pos+1);
							$data['exfile_name'][$key]=$doc['doc_name'];
							$pos=strrpos($doc['doc_ori_name'], '.');
							$data['exfile_ori_name'][$key]=$doc['doc_ori_name'];
							$data['doc_ori_name'][$key]=$doc['doc_ori_name'];
							$data['exfile_id'][$key]=$value;
						}
						else
						{
							$fix_status=true;
						}
					}
				}
				//順便修正DB資料
				if($fix_status && !empty($data['exfile_id']))
				{
					$exfile_id_str=$this->set_serialstr($data['exfile_id'], '*#');
					$this->mod_business->update_set('iqr', 'member_id', $this->session->userdata('member_id'), array('exfile'=>$exfile_id_str));
				}
			}

			//顯示作業完成提示 msg
			if($this->session->userdata('msg') != '')
				$data['msg']=$this->session->userdata('msg');
			else
				$data['msg']='';
			$this->session->set_userdata('msg', '');

			//view
			$this->load->view('business/photo_management', $data);
		}
	}

	//相簿管理彈出Tab頁面
	public function photo_tab($type='', $success='')
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
			//helper
			$this->load->helper('form');

			if($success == 1)
			{
				$data['success']=$success;
			}
			else
			{
				//data
				$data=$this->data;

				$this -> lang -> load('views/business/photo_tab', $data['lang']);
				$data['MachineUploads'] = lang('MachineUploads');
				$data['SelectAll'] = lang('SelectAll');
				$data['_AlbumManagement'] = lang('_AlbumManagement');
				$data['RemoveCyberspace'] = lang('RemoveCyberspace');
				$data['ArrangeAlbum'] = lang('ArrangeAlbum');
				$data['AllPhotoAdd'] = lang('AllPhotoAdd');
				$data['_NoAnyPhoto'] = lang('_NoAnyPhoto');
				$data['BrowserNotSuppor'] = lang('BrowserNotSuppor');
				$data['TypeOfPicture'] = lang('TypeOfPicture');
				$data['StareUpLoad'] = lang('StareUpLoad');
				$data['NewSuccess'] = lang('NewSuccess');
				$data['NewSuccessPhoto'] = lang('NewSuccessPhoto');
				$data['AddToAlbum'] = lang('AddToAlbum');
				$data['Cyberspace'] = lang('Cyberspace');
				$data['CheckPhotoNew'] = lang('CheckPhotoNew');
				$data['NoteAllowingOnly'] = lang('NoteAllowingOnly');
				$data['HideRepeatPhoto'] = lang('HideRepeatPhoto');
				$data['ShowAllPhoto'] = lang('ShowAllPhoto');
				$data['Cancel'] = lang('Cancel');
				$data['RequiredFile'] = lang('RequiredFile');

				//資料夾讀取
				$data['typ_n']=$type;
				$data['photo']=$photo=$this->mod_business->select_from_order('images', 'img_id', 'asc', array('member_id'=>$this->session->userdata('member_id')));//, 'type'=>$typ_n
				//使用者已有圖
				$col_name=($type == 0) ? 'photo' : 'cpn_photo';
				$iqr=$this->mod_business->select_from('iqr', array('member_id'=>$this->session->userdata('member_id')));
				$temp_photo=$this->get_serialstr($iqr[$col_name], '*#');
				if(!empty($photo))
				{
					$photo_num=0;
					foreach($photo as $key => $value)
					{
						if($value['img_path'] != '')
						{
							$photo_num++;
							$data['img_path'][$key]=substr($value['img_path'], 1);
							$data['img_id'][$key]=$value['img_id'];
						}
					}
					$no_repeat_photo_num=0;
					if(!empty($temp_photo))
					{
						$no_repeat_photo=array_diff($data['img_id'], $temp_photo);
						foreach($no_repeat_photo as $key => $value)
						{
							$no_repeat_photo_num++;
							$img=$this->mod_business->select_from('images', array('img_id'=>$value));
							$data['no_repeat_photo'][$key]=substr($img['img_path'], 1);
							$data['no_repeat_photo_id'][$key]=$value['img_id'];
						}
					}
					else
					{
						$data['no_repeat_photo']=$data['img_path'];
						$data['no_repeat_photo_id']=$data['img_id'];
					}
					$data['no_repeat_photo_num']=$no_repeat_photo_num;
				}
				$data['photo_num']=$photo_num;
			}
			$data['member_id']=$this->session->userdata('member_id');
			//view
			$this->load->view('business/photo_tab', $data);
		}
	}
	//相簿管理彈出Tab頁面
	public function photo_tab_new($type='', $success='')
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
			//helper
			$this->load->helper('form');

			if($success == 1)
			{
				$data['success']=$success;
			}
			else
			{
				//data
				$data=$this->data;

				$this -> lang -> load('views/business/photo_tab', $data['lang']);
				$data['MachineUploads'] = lang('MachineUploads');
				$data['SelectAll'] = lang('SelectAll');
				$data['_AlbumManagement'] = lang('_AlbumManagement');
				$data['RemoveCyberspace'] = lang('RemoveCyberspace');
				$data['ArrangeAlbum'] = lang('ArrangeAlbum');
				$data['AllPhotoAdd'] = lang('AllPhotoAdd');
				$data['_NoAnyPhoto'] = lang('_NoAnyPhoto');
				$data['BrowserNotSuppor'] = lang('BrowserNotSuppor');
				$data['TypeOfPicture'] = lang('TypeOfPicture');
				$data['StareUpLoad'] = lang('StareUpLoad');
				$data['NewSuccess'] = lang('NewSuccess');
				$data['NewSuccessPhoto'] = lang('NewSuccessPhoto');
				$data['AddToAlbum'] = lang('AddToAlbum');
				$data['Cyberspace'] = lang('Cyberspace');
				$data['CheckPhotoNew'] = lang('CheckPhotoNew');
				$data['NoteAllowingOnly'] = lang('NoteAllowingOnly');
				$data['HideRepeatPhoto'] = lang('HideRepeatPhoto');
				$data['ShowAllPhoto'] = lang('ShowAllPhoto');
				$data['Cancel'] = lang('Cancel');
				$data['RequiredFile'] = lang('RequiredFile');

				//資料夾讀取
				$data['typ_n']=$type;
				$data['photo']=$photo=$this->mod_business->select_from_order('images', 'img_id', 'asc', array('member_id'=>$this->session->userdata('member_id')));//, 'type'=>$typ_n
				//使用者已有圖
				$this->load->model("photo_category_model");
				$iqr=$this->photo_category_model->get_photo_category_id($type);
				$temp_photo=$this->get_serialstr($iqr['d_photo'], '*#');
				if(!empty($photo))
				{
					$photo_num=0;
					foreach($photo as $key => $value)
					{
						if($value['img_path'] != '')
						{
							$photo_num++;
							$data['img_path'][$key]=substr($value['img_path'], 1);
							$data['img_id'][$key]=$value['img_id'];
						}
					}
					$no_repeat_photo_num=0;
					if(!empty($temp_photo))
					{
						$no_repeat_photo=array_diff($data['img_id'], $temp_photo);
						foreach($no_repeat_photo as $key => $value)
						{
							$no_repeat_photo_num++;
							$img=$this->mod_business->select_from('images', array('img_id'=>$value));
							$data['no_repeat_photo'][$key]=substr($img['img_path'], 1);
							$data['no_repeat_photo_id'][$key]=$value['img_id'];
						}
					}
					else
					{
						$data['no_repeat_photo']=$data['img_path'];
						$data['no_repeat_photo_id']=$data['img_id'];
					}
					$data['no_repeat_photo_num']=$no_repeat_photo_num;
				}
				$data['photo_num']=$photo_num;
			}
			$data['member_id']=$this->session->userdata('member_id');
			//view
			$this->load->view('business/photo_tab', $data);
		}
	}
	//由Server端選取照片寫入DB資料
	public function photo_add()
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
			//收到新增
			if($this->input->post('form_server_submit'))
			{
				//data
				$data=$this->data;

				$this -> lang -> load('views/business/photo_tab', $data['lang']);
				$data['MachineUploads'] = lang('MachineUploads');
				$data['SelectAll'] = lang('SelectAll');
				$data['_AlbumManagement'] = lang('_AlbumManagement');
				$data['RemoveCyberspace'] = lang('RemoveCyberspace');
				$data['ArrangeAlbum'] = lang('ArrangeAlbum');
				$data['AllPhotoAdd'] = lang('AllPhotoAdd');
				$data['_NoAnyPhoto'] = lang('_NoAnyPhoto');
				$data['BrowserNotSuppor'] = lang('BrowserNotSuppor');
				$data['TypeOfPicture'] = lang('TypeOfPicture');
				$data['StareUpLoad'] = lang('StareUpLoad');
				$data['NewSuccess'] = lang('NewSuccess');
				$data['NewSuccessPhoto'] = lang('NewSuccessPhoto');
				$data['AddToAlbum'] = lang('AddToAlbum');
				$data['Cyberspace'] = lang('Cyberspace');
				$data['CheckPhotoNew'] = lang('CheckPhotoNew');
				$data['NoteAllowingOnly'] = lang('NoteAllowingOnly');
				$data['HideRepeatPhoto'] = lang('HideRepeatPhoto');
				$data['ShowAllPhoto'] = lang('ShowAllPhoto');
				$data['Cancel'] = lang('Cancel');
				$data['RequiredFile'] = lang('RequiredFile');

				//設定字串列
				$photo=$this->set_serialstr($this->input->post('photoadd'), '*#');

				//edit
				$this->load->model("photo_category_model");
				$iqr=$this->photo_category_model->get_photo_category_id($this->input->post('typ_n'));

				$col_name = 'd_photo';
				$shr_col_name = 'd_photo';

				//full images id
				$temp_full_id=$this->get_serialstr($iqr[$col_name].$photo, '*#');
				$full_id=array();
				foreach($temp_full_id as $key => $value)
				{
					if(!in_array($value, $full_id))
					{
						array_push($full_id, $value);
					}
				}
				$images_id_array = $full_id;
				$full_id_str=$this->set_serialstr($full_id, '*#');

				//update iqr
				$this->photo_category_model->edit_photo_category_d_photo(array($col_name=>$full_id_str),$this->input->post('typ_n'));
				// exchange update
				// auth
				$member = $this->mod_business->select_from('member', array('member_id' =>$this->session->userdata('member_id')));
		        $auth   = intval($member['auth']);
	            // web config
	            $auth_level_num = intval($data['web_config']['auth_level_num']);
	            if($auth_level_num > $auth) // 擁有共享層級的使用者
	            {
	            	// images id array
					foreach($images_id_array as $key => $value)
					{
		                // share update
		                $add_share_data  = array(
		                    'member_id'  		=> $this->session->userdata('member_id'),
		                    'iqr_column' 		=> $col_name,
		                    'id'         		=> $value,
		                    'status'     		=> 1,
		                    'photo_category_id' => $this->input->post('typ_n')
		                );
		                $add_share_data_where  = array(
		                    'member_id'  		=> $this->session->userdata('member_id'),
		                    'iqr_column' 		=> $col_name,
		                    'id'         		=> $value,
		                    //'photo_category_id' => $this->input->post('typ_n')
		                );
		                $this->mod_business->insert_into('share_data', $add_share_data, $add_share_data_where);

		                // quote update
		                $this->load->model('exchange_model', 'mod_exchange');
		                $member_array = $this->mod_exchange->get_all_member_in_domain($member['domain_id']);
		                if(!empty($member_array))
		                {
			                foreach($member_array as $ma_key => $ma_value)
			                {
			                    $add_quote_data = array(
			                        'member_id'  => $ma_value,
			                        'parent'     => $this->session->userdata('member_id'),
				                    'iqr_column' => $col_name,
				                    'id'         => $value,
			                        'status'     => 0,
			                    	'photo_category_id' => (int)$this->input->post('typ_n')
			                    );
			                    $add_quote_data_where = array(
			                        'member_id'  => $ma_value,
			                        'parent'     => $this->session->userdata('member_id'),
				                    'iqr_column' => $col_name,
				                    'id'         => $value
			                    );
			                    $this->mod_business->insert_into('quote_data', $add_quote_data, $add_quote_data_where);
			                }
			            }
					}
	            }
	            else
	            {
	                // 會員層級屬於最低層, 無須update
	            }

				//返回
				redirect('/business/photo_tab/'.$this->input->post('typ_n').'/1');
			}
		}
	}

	//排序照片
	public function photo_sort()
	{
		$language = $this -> language;
		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{
			//未登入
			$this->myredirect('/index/login', '請先登入', 5);
			return 0;
		}
		else
		{
			//收到新增
			if($this->input->post('photo_sort'))
			{
				//data
				$data=$this->data;

				$this -> lang -> load('views/business/photo_management', $data['lang']);
				$data['NowNoPhoto'] = lang('NowNoPhoto');
				$data['SelectAll'] = lang('SelectAll');
				$data['All'] = lang('All');
				$data['Cancle'] = lang('Cancle');
				$data['NotFirefoxChromIE'] = lang('NotFirefoxChromIE');
				$data['_AlbumManagement'] = lang('_AlbumManagement');
				$data['Zhang'] = lang('Zhang');
				$data['SequencePhoto'] = lang('SequencePhoto');
				$data['RemoveSelectePhoto'] = lang('RemoveSelectePhoto');
				$data['RemovPhoto'] = lang('RemovPhoto');
				$data['AddPhoto'] = lang('AddPhoto');
				$data['FromLeftToRight'] = lang('FromLeftToRight');
				$data['EditAnnotation'] = lang('EditAnnotation');
				$data['CheckRemovePhoto'] = lang('CheckRemovePhoto');
				$data['SaveSequence'] = lang('SaveSequence');
				$data['SavePhotoAnnotation'] = lang('SavePhotoAnnotation');

				//設定字串列
				$photo_sort=$this->set_serialstr($this->input->post('photo_sort'), '*#');

				//update_set
				$this->load->model("photo_category_model");
				$this->photo_category_model->edit_photo_category_d_photo(array("d_photo"=>$photo_sort),$this->input->post('typ_n'));
				//返回
				$type_name=$this->photo_category_model->get_photo_category_id($this->input->post('typ_n'));
				$this->session->set_userdata('msg', $language['Sort'].$type_name["d_name"].$language['Done']);

				header('Location:/business/photo_management');
			}
		}
	}

	//編輯照片註解
	public function photo_edit_note()
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
			//收到新增
			if($this->input->post('photo_name'))
			{
				//data
				$data=$this->data;

				$this -> lang -> load('views/business/photo_management', $data['lang']);
				$data['NowNoPhoto'] = lang('NowNoPhoto');
				$data['SelectAll'] = lang('SelectAll');
				$data['All'] = lang('All');
				$data['Cancle'] = lang('Cancle');
				$data['NotFirefoxChromIE'] = lang('NotFirefoxChromIE');
				$data['_AlbumManagement'] = lang('_AlbumManagement');
				$data['Zhang'] = lang('Zhang');
				$data['SequencePhoto'] = lang('SequencePhoto');
				$data['RemoveSelectePhoto'] = lang('RemoveSelectePhoto');
				$data['RemovPhoto'] = lang('RemovPhoto');
				$data['AddPhoto'] = lang('AddPhoto');
				$data['FromLeftToRight'] = lang('FromLeftToRight');
				$data['EditAnnotation'] = lang('EditAnnotation');
				$data['CheckRemovePhoto'] = lang('CheckRemovePhoto');
				$data['SaveSequence'] = lang('SaveSequence');
				$data['SavePhotoAnnotation'] = lang('SavePhotoAnnotation');

				//col_name
				$col_name=($this->input->post('typ_n') == 0) ? 'photo_name' : 'cpn_photo_name';
				$type_name=($this->input->post('typ_n') == 0) ? $language['ImageFigure'] : $language['CompanyPhoto'];

				//update_set
				$photo_note='';
				$post_photo_name=$this->input->post('photo_name');
				foreach($post_photo_name as $key => $value)
				{
					$this->mod_business->update_set('images', 'img_id', $key, array('img_note'=>$value));
					$photo_note.='*#'.$value;
				}

				//返回
				$this->session->set_userdata('msg', $language['Save'].$type_name.$language['AnnotationFinish']);
				header('Location:/business/photo_management');
			}
		}
	}

	//移除相簿照片
	public function photo_remove()
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
			if($this->input->post('photo_remove'))
			{
				//data
				$data=$this->data;

				$this -> lang -> load('views/business/photo_management', $data['lang']);
				$data['NowNoPhoto'] = lang('NowNoPhoto');
				$data['SelectAll'] = lang('SelectAll');
				$data['All'] = lang('All');
				$data['Cancle'] = lang('Cancle');
				$data['NotFirefoxChromIE'] = lang('NotFirefoxChromIE');
				$data['_AlbumManagement'] = lang('_AlbumManagement');
				$data['Zhang'] = lang('Zhang');
				$data['SequencePhoto'] = lang('SequencePhoto');
				$data['RemoveSelectePhoto'] = lang('RemoveSelectePhoto');
				$data['RemovPhoto'] = lang('RemovPhoto');
				$data['AddPhoto'] = lang('AddPhoto');
				$data['FromLeftToRight'] = lang('FromLeftToRight');
				$data['EditAnnotation'] = lang('EditAnnotation');
				$data['CheckRemovePhoto'] = lang('CheckRemovePhoto');
				$data['SaveSequence'] = lang('SaveSequence');
				$data['SavePhotoAnnotation'] = lang('SavePhotoAnnotation');

				//col_name
				$col_name="d_photo";
				$shr_col_name=($this->input->post('typ_n') == 0) ? 'myphoto' : 'cpn_photo';

				$photo_remove=$this->input->post('photo_remove');

				//原始資料
				$this->load->model("photo_category_model");
				$iqr=$this->photo_category_model->get_photo_category_id($this->input->post('typ_n'));

				$ori_photo=$iqr[$col_name];

				//刪除
				$temp_photo_id=$this->get_serialstr($ori_photo, '*#');
				$result=array_diff($temp_photo_id, $photo_remove);
				$photo_id=$this->set_serialstr($result, '*#');

				//update_set
				$this->photo_category_model->edit_photo_category_d_photo(array("d_photo"=>$photo_id),$this->input->post('typ_n'));

				// exchange update
				// auth
		        $member = $this->mod_business->select_from('member', array('member_id' => $this->session->userdata('member_id')));
	            $auth   = intval($member['auth']);
	            // web config
	            $auth_level_num = intval($data['web_config']['auth_level_num']);
				if($auth_level_num > $auth) // 擁有共享層級的使用者
	            {
	            	foreach($photo_remove as $key => $value)
					{
		                $del_share_data = array(
		                    'member_id'  => $this->session->userdata('member_id'),
		                    'iqr_column' => $col_name,
		                    'id'         => $value
		                );
		                $del_quote_data = array(
		                    'parent'     => $this->session->userdata('member_id'),
		                    'iqr_column' => $col_name,
		                    'id'         => $value
		                );
		                $this->mod_business->delete_where('share_data', $del_share_data);
		                $this->mod_business->delete_where('quote_data', $del_quote_data);
					}
	            }
	            else
	            {
	                // 會員層級屬於最低層, 無須update
	            }

				//返回
				$this->session->set_userdata('msg', $iqr["d_name"].$language['RemoveFinish']);
			}
			header('Location:/business/photo_management');
		}
	}

	//移除網路空間照片
	public function photo_delete()
	{
		if($this->input->post('img_id') && $this->input->post('member_id'))
		{
			//data
			$data=$this->data;

			$this -> lang -> load('views/business/photo_tab', $data['lang']);
			$data['MachineUploads'] = lang('MachineUploads');
			$data['SelectAll'] = lang('SelectAll');
			$data['_AlbumManagement'] = lang('_AlbumManagement');
			$data['RemoveCyberspace'] = lang('RemoveCyberspace');
			$data['ArrangeAlbum'] = lang('ArrangeAlbum');
			$data['AllPhotoAdd'] = lang('AllPhotoAdd');
			$data['_NoAnyPhoto'] = lang('_NoAnyPhoto');
			$data['BrowserNotSuppor'] = lang('BrowserNotSuppor');
			$data['TypeOfPicture'] = lang('TypeOfPicture');
			$data['StareUpLoad'] = lang('StareUpLoad');
			$data['NewSuccess'] = lang('NewSuccess');
			$data['NewSuccessPhoto'] = lang('NewSuccessPhoto');
			$data['AddToAlbum'] = lang('AddToAlbum');
			$data['Cyberspace'] = lang('Cyberspace');
			$data['CheckPhotoNew'] = lang('CheckPhotoNew');
			$data['NoteAllowingOnly'] = lang('NoteAllowingOnly');
			$data['HideRepeatPhoto'] = lang('HideRepeatPhoto');
			$data['ShowAllPhoto'] = lang('ShowAllPhoto');
			$data['Cancel'] = lang('Cancel');
			$data['RequiredFile'] = lang('RequiredFile');

			//img_id
			$img_id=$this->input->post('img_id');

			//原始資料
			$img=$this->mod_business->select_from('images', array('img_id'=>$this->input->post('img_id')));

			//刪除SERVER端圖檔
			unlink($img['img_path']);

			//iqr
			$col_name="d_photo";


			$this->load->model("photo_category_model");
			$photo_category=$this->photo_category_model->get_photo_category($this->input->post('typ_n'));
			foreach($photo_category as $key=>$iqr)
			{
				$temp_photo_array=$this->get_serialstr($iqr[$col_name], '*#');
				$temp_img_id=array(0=>$img_id);
				if(!empty($temp_photo_array) && !empty($temp_img_id))
				{
					$photo_array=array_diff($temp_photo_array, $temp_img_id);
					$photo_result=$this->set_serialstr($photo_array, '*#');
				}
			}
			//刪除IMAGE TABLE 資料
			$this->mod_business->delete_where('images', array('img_id'=>$this->input->post('img_id')));

			// exchange update
			// auth
	        $member = $this->mod_business->select_from('member', array('member_id' => $this->session->userdata('member_id')));
            $auth   = intval($member['auth']);
            // web config
            $auth_level_num = intval($data['web_config']['auth_level_num']);
			if($auth_level_num > $auth) // 擁有共享層級的使用者
            {
                $del_share_data = array(
                    'member_id'  => $this->session->userdata('member_id'),
                    'iqr_column' => $col_name,
                    'id'         => $this->input->post('img_id')
                );
                $del_quote_data = array(
                    'parent'     => $this->session->userdata('member_id'),
                    'iqr_column' => $col_name,
                    'id'         => $this->input->post('img_id')
                );
                $this->mod_business->delete_where('share_data', $del_share_data);
                $this->mod_business->delete_where('quote_data', $del_quote_data);
            }
            else
            {
                // 會員層級屬於最低層, 無須update
            }
		}
	}

	//plupload上傳 - photo
	public function upload($dir='', $typ_n='')
	{
		$language = $this -> language;
		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{
			//未登入
			$this->myredirect('/index/login', $language['PleaseLogin'], 5);
			return 0;
		}
		else if($dir != '' && $typ_n != '' )
		{
			/**
			 * upload.php
			 *
			 * Copyright 2013, Moxiecode Systems AB
			 * Released under GPL License.
			 *
			 * License: http://www.plupload.com/license
			 * Contributing: http://www.plupload.com/contributing
			 */

			#!! IMPORTANT:
			#!! this file is just an example, it doesn't incorporate any security checks and
			#!! is not recommended to be used in production environment as it is. Be sure to
			#!! revise it and customize to your needs.

			// Make sure file is not cached (as it happens for example on iOS devices)
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");

			// 5 minutes execution time
			@set_time_limit(5 * 60);

			// Uncomment this one to fake upload time
			// usleep(5000);

			// Settings
			$member=$this->mod_business->select_from('member', array('member_id'=>$this->session->userdata('member_id')));
			$member_dir=$this->mod_business->member_img_dir_check($member);
			$targetDir = '.'.$member_dir . $dir;

			//$targetDir = 'uploads';
			$cleanupTargetDir = true; // Remove old files
			$maxFileAge = 5 * 3600; // Temp file age in seconds


			// Create target dir
			if (!file_exists($targetDir)) {
				@mkdir($targetDir);
			}

			// Get a file name
			if (isset($_REQUEST["name"])) {
				$fileName = $_REQUEST["name"];
			} elseif (!empty($_FILES)) {
				$fileName = $_FILES["file"]["name"];
			} else {
				$fileName = uniqid("file_");
			}

			$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

			// Chunking might be enabled
			$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
			$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;


			// Remove old temp files
			if ($cleanupTargetDir) {
				if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
					die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
				}

				while (($file = readdir($dir)) !== false) {
					$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

					// If temp file is current file proceed to the next
					if ($tmpfilePath == "{$filePath}.part") {
						continue;
					}

					// Remove temp file if it is older than the max age and is not the current file
					if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
						@unlink($tmpfilePath);
					}
				}
				closedir($dir);
			}


			// Open temp file
			if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
			}

			if (!empty($_FILES)) {
				if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
					die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
				}

				// Read binary input stream and append it to temp file
				if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
					die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
				}
			} else {
				if (!$in = @fopen("php://input", "rb")) {
					die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
				}
			}

			while ($buff = fread($in, 4096)) {
				fwrite($out, $buff);
			}

			@fclose($out);
			@fclose($in);

			// Check if file has been uploaded
			if (!$chunks || $chunk == $chunks - 1) {
				// Strip the temp .part suffix off
				rename("{$filePath}.part", $filePath);

				//寫入資料庫
				$img_info=array(
					'img_path'	=>$filePath,
					'member_id' =>$this->session->userdata('member_id'),
					'type' 		=>$typ_n
				);
				$img_id=$this->mod_business->insert_into('images', $img_info);
				$id_str='*#'.$img_id;

				//檢查原有資料
				//$col_name=($typ_n == 0) ? 'photo' : 'cpn_photo';
				$col_name="d_photo";
				//$shr_col_name=($typ_n == 0) ? 'myphoto' : 'cpn_photo';
				//$iqr=$this->mod_business->select_from('iqr', array('member_id' =>$this->session->userdata('member_id')));
				$this->load->model("photo_category_model");
				$iqr=$this->photo_category_model->get_photo_category_id($typ_n);
				//$this->mod_business->update_set('iqr', 'member_id', $this->session->userdata('member_id'), array($col_name=>$iqr[$col_name].$id_str));
				//改寫到自由定義
				$this->photo_category_model->edit_photo_category_d_photo(array($col_name=>$iqr[$col_name].$id_str),$typ_n);
				//data
				$data=$this->data;

				// exchange update
				// auth
				$auth = intval($member['auth']);
	            // web config
	            $auth_level_num = intval($data['web_config']['auth_level_num']);
	            if($auth_level_num > $auth) // 擁有共享層級的使用者
	            {
	                // share update
	                $add_share_data  = array(
	                    'member_id'  => $this->session->userdata('member_id'),
	                    'iqr_column' => $col_name,
	                    'id'         => $img_id,
	                    'status'     => 1,
	                	'photo_category_id'=>$typ_n
	                );
	                $add_share_data_where = array(
	                    'member_id'  => $this->session->userdata('member_id'),
	                    'iqr_column' => $col_name,
	                    'id'         => $img_id,
	                	//'photo_category_id'=>$typ_n
	                );
	                $this->mod_business->insert_into('share_data', $add_share_data, $add_share_data_where);

	                // quote update
	                $this->load->model('exchange_model', 'mod_exchange');
	                $member_array = $this->mod_exchange->get_all_member_in_domain($member['domain_id']);
	                foreach($member_array as $key => $value)
	                {
	                    $add_quote_data = array(
	                        'member_id'  => $value,
	                        'parent'     => $this->session->userdata('member_id'),
		                    'iqr_column' => $col_name,
		                    'id'         => $img_id,
	                        'status'     => 0,
	                    	'photo_category_id'=>$typ_n
	                    );
	                    $add_quote_data_where = array(
	                        'member_id'  => $value,
	                        'parent'     => $this->session->userdata('member_id'),
		                    'iqr_column' => $col_name,
		                    'id'         => $img_id,
	                    	//'photo_category_id'=>$typ_n
	                    );
	                    $this->mod_business->insert_into('quote_data', $add_quote_data, $add_quote_data_where);
	                }
	            }
	            else
	            {
	                // 會員層級屬於最低層, 無須update
	            }
			}

			// Return Success JSON-RPC response
			die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
		}
	}

	//附件管理
	public function exfile_management()
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

			$this -> lang -> load('views/business/exfile_management', $data['lang']);
			$data['Download'] = lang('Download');
			$data['NoAnyAnnex'] = lang('NoAnyAnnex');
			$data['SelectAll'] = lang('SelectAll');
			$data['Cancle'] = lang('Cancle');
			$data['_AnnexManagement'] = lang('_AnnexManagement');
			$data['ButtonName'] = lang('ButtonName');
			$data['LimitButtonName'] = lang('LimitButtonName');
			$data['_Annex'] = lang('_Annex');
			$data['OriginalFilename'] = lang('OriginalFilename');
			$data['NowHave'] = lang('NowHave');
			$data['SequenceAnnex'] = lang('SequenceAnnex');
			$data['RemoveSelecteAnnex'] = lang('RemoveSelecteAnnex');
			$data['RemoveAnnex'] = lang('RemoveAnnex');
			$data['StrNum15'] = lang('StrNum15');
			$data['Number'] = lang('Number');
			$data['EditButtonName'] = lang('EditButtonName');
			$data['NotShowAllName'] = lang('NotShowAllName');
			$data['SaveAnnexName'] = lang('SaveAnnexName');
			$data['SaveAnnexSequence'] = lang('SaveAnnexSequence');
			$data['AddAnnex'] = lang('AddAnnex');

			//member
			$member=$iqr=$this->mod_business->select_from('member', array('member_id'=>$this->session->userdata('member_id')));

			//行動名片資料
			$data['iqr']=$iqr=$this->mod_business->select_from('iqr', array('member_id'=>$this->session->userdata('member_id')));

			//helper
			$this->load->helper('form');

			//account
			$data['account']=$member['account'];
			$data['mid']=$this->session->userdata('member_id');

			//行動名片連結
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

			//附件設定
			$exfile=$this->get_serialstr($iqr['exfile'], '*#');
			$data['exfile_num']=0;
			if(!empty($exfile))
			{
				$fix_status=false;
				foreach($exfile as $key => $value)
				{
					$doc=$this->mod_business->select_from('documents', array('doc_id'=>$value));
					if(!empty($doc))
					{
						if(empty($data['exfile_id']))
						{
							$data['exfile_num']++;
							$data['exfile'][$key]=substr($doc['doc_path'], 1);
							$pos=strrpos($doc['doc_path'], '.');
							$data['exfile_extname'][$key]=substr($doc['doc_path'], $pos+1);
							$data['exfile_name'][$key]=$doc['doc_name'];
							$pos=strrpos($doc['doc_ori_name'], '.');
							$data['exfile_ori_name'][$key]=$doc['doc_ori_name'];
							$data['doc_ori_name'][$key]=$doc['doc_ori_name'];
							$data['exfile_id'][$key]=$value;
						}
						else if(!in_array($value, $data['exfile_id']))
						{
							$data['exfile_num']++;
							$data['exfile'][$key]=substr($doc['doc_path'], 1);
							$pos=strrpos($doc['doc_path'], '.');
							$data['exfile_extname'][$key]=substr($doc['doc_path'], $pos+1);
							$data['exfile_name'][$key]=$doc['doc_name'];
							$pos=strrpos($doc['doc_ori_name'], '.');
							$data['exfile_ori_name'][$key]=$doc['doc_ori_name'];
							$data['doc_ori_name'][$key]=$doc['doc_ori_name'];
							$data['exfile_id'][$key]=$value;
						}
						else
						{
							$fix_status=true;
						}
					}
				}
				//順便修正DB資料
				if($fix_status && !empty($data['exfile_id']))
				{
					$exfile_id_str=$this->set_serialstr($data['exfile_id'], '*#');
					$this->mod_business->update_set('iqr', 'member_id', $this->session->userdata('member_id'), array('exfile'=>$exfile_id_str));
				}
			}

			//顯示作業完成提示 msg
			if($this->session->userdata('msg') != '')
				$data['msg']=$this->session->userdata('msg');
			else
				$data['msg']='';
			$this->session->set_userdata('msg', '');

			//view
			$this->load->view('business/exfile_management', $data);
		}
	}

	//附件管理彈出Tab頁面
	public function exfile_tab($success='')
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
			//helper
			$this->load->helper('form');

			if($success == 1)
			{
				$data['success']=$success;
			}
			else
			{
				//data
				$data = $this -> data;
				$this -> lang -> load('views/business/exfile_tab', $data['lang']);
				$data['MachineUploads'] = lang('MachineUploads');
				$data['SelectAll'] = lang('SelectAll');
				$data['Cancle'] = lang('Cancle');
				$data['ButtonName'] = lang('ButtonName');
				$data['OriginalFilename'] = lang('OriginalFilename');
				$data['RemoveCyberspace'] = lang('RemoveCyberspace');
				$data['ComputerSelectAnnex'] = lang('ComputerSelectAnnex');
				$data['AtLeastFile'] = lang('AtLeastFile');
				$data['AllAnnexAdd'] = lang('AllAnnexAdd');
				$data['_NoAnyAnnex'] = lang('_NoAnyAnnex');
				$data['BrowserNotSuppor'] = lang('BrowserNotSuppor');
				$data['TypeOfFile'] = lang('TypeOfFile');
				$data['StareUpLoad'] = lang('StareUpLoad');
				$data['AllowingOnly'] = lang('AllowingOnly');
				$data['Add'] = lang('Add');
				$data['NewSuccess'] = lang('NewSuccess');
				$data['NewSuccessAnnex'] = lang('NewSuccessAnnex');
				$data['AddAnnex'] = lang('AddAnnex');
				$data['Cyberspace'] = lang('Cyberspace');
				$data['CheckAnnexNew'] = lang('CheckAnnexNew');
				$data['HideRepeatAnnex'] = lang('HideRepeatAnnex');
				$data['RemoveCyberspace'] = lang('RemoveCyberspace');
				$data['ShowAttachments'] = lang('ShowAttachments');

				//資料夾讀取
				$doc=$this->mod_business->select_from_order('documents', 'doc_id', 'asc', array('member_id'=>$this->session->userdata('member_id')));
				//使用者附件
				$iqr=$this->mod_business->select_from('iqr', array('member_id'=>$this->session->userdata('member_id')));
				$temp_exfile=$this->get_serialstr($iqr['exfile'], '*#');
				if(!empty($doc))
				{
					$exfile_num=0;
					foreach($doc as $key => $value)
					{
						if($value['doc_path'] != '')
						{
							$exfile_num++;
							$data['exfile'][$key]=substr($value['doc_path'], 1);
							$pos=strrpos($value['doc_path'], '.');
							$data['exfile_extname'][$key]=substr($value['doc_path'], $pos+1);
							$data['exfile_name'][$key]=$value['doc_name'];
							$pos=strrpos($value['doc_ori_name'], '.');
							$data['exfile_ori_name'][$key]=substr($value['doc_ori_name'],0 , $pos);
							$data['exfile_id'][$key]=$value['doc_id'];
						}
					}
					$no_repeat_exfile_num=0;
					if(!empty($temp_exfile))
					{
						$no_repeat_exfile=array_diff($data['exfile_id'], $temp_exfile);
						foreach($no_repeat_exfile as $key => $value)
						{
							$no_repeat_exfile_num++;
							$doc=$this->mod_business->select_from('documents', array('doc_id'=>$value));
							$data['no_repeat_exfile'][$key]=substr($doc['doc_path'], 1);
							$data['no_repeat_exfile_id'][$key]=$value;
						}
					}
					else
					{
						$data['no_repeat_exfile']=$data['exfile'];
						$data['no_repeat_exfile_id']=$data['exfile_id'];
					}
					$data['no_repeat_exfile_num']=$no_repeat_exfile_num;
				}
				$data['exfile_num']=$exfile_num;
				$data['member_id']=$this->session->userdata('member_id');
			}
			//view
			$this->load->view('business/exfile_tab', $data);
		}
	}

	//由Server端選取附件寫入DB資料
	public function exfile_add()
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
			//收到新增
			if($this->input->post('form_server_submit'))
			{
				//data
				$data = $this->data;

				//設定字串列
				$exfile = $this->set_serialstr($this->input->post('exfile_add'), '*#');

				//edit
				$iqr = $this->mod_business->select_from('iqr', array('member_id' =>$this->session->userdata('member_id')));
				$this->mod_business->update_set('iqr', 'member_id', $this->session->userdata('member_id'), array('exfile'=>$iqr['exfile'].$exfile));

				// exchange update
				// auth
				$member = $this->mod_business->select_from('member', array('member_id' =>$this->session->userdata('member_id')));
		        $auth   = intval($member['auth']);
	            // web config
	            $auth_level_num = intval($data['web_config']['auth_level_num']);
	            if($auth_level_num > $auth) // 擁有共享層級的使用者
	            {
	            	// exfile id array
	            	$exfile_id_array = $this->input->post('exfile_add');
					foreach($exfile_id_array as $key => $value)
					{
		                // share update
		                $add_share_data  = array(
		                    'member_id'  => $this->session->userdata('member_id'),
		                    'iqr_column' => 'exfile',
		                    'id'         => $value,
		                    'status'     => 1
		                );
		                $add_share_data_where  = array(
		                    'member_id'  => $this->session->userdata('member_id'),
		                    'iqr_column' => 'exfile',
		                    'id'         => $value
		                );
		                $this->mod_business->insert_into('share_data', $add_share_data, $add_share_data_where);

		                // quote update
		                $this->load->model('exchange_model', 'mod_exchange');
		                $member_array = $this->mod_exchange->get_all_member_in_domain($member['domain_id']);
		                foreach($member_array as $ma_key => $ma_value)
		                {
		                    $add_quote_data = array(
		                        'member_id'  => $ma_value,
		                        'parent'     => $this->session->userdata('member_id'),
			                    'iqr_column' => 'exfile',
			                    'id'         => $value,
		                        'status'     => 0
		                    );
		                    $add_quote_data_where = array(
		                        'member_id'  => $ma_value,
		                        'parent'     => $this->session->userdata('member_id'),
			                    'iqr_column' => 'exfile',
			                    'id'         => $value
		                    );
		                    $this->mod_business->insert_into('quote_data', $add_quote_data, $add_quote_data_where);
		                }
					}
	            }
	            else
	            {
	                // 會員層級屬於最低層, 無須update
	            }

				//返回
				redirect('/business/exfile_tab/1');
			}
		}
	}

	//排序附件
	public function exfile_sort()
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
			//收到新增
			if($this->input->post('exfile_sort_id'))
			{
				//data
				$data=$this->data;

				//設定字串列
				$exfile_sort=$this->set_serialstr($this->input->post('exfile_sort_id'), '*#');

				//update_set
				$this->mod_business->update_set('iqr', 'member_id', $this->session->userdata('member_id'), array('exfile'=>$exfile_sort));

				//返回
				$this->session->set_userdata('msg', $language['SequenceFinish']);
				header('Location:/business/exfile_management');
			}
		}
	}

	//編輯附件按鈕名稱
	public function exfile_edit_btn_name()
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
			//收到新增
			if($this->input->post('exfile_name'))
			{
				//data
				$data=$this->data;

				//update_set
				foreach($this->input->post('exfile_name') as $key => $value)
				{
					$this->mod_business->update_set('documents', 'doc_id', $key, array('doc_name'=>$value));
					$exfile_btn_name.='*#'.$value;
				}

				//返回
				$this->session->set_userdata('msg', $language['ButtonSaveSuccess']);
				header('Location:/business/exfile_management');
			}
		}
	}

	//移除附件
	public function exfile_remove()
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
			//收到新增
			if($this->input->post('exfile_remove'))
			{
				//data
				$data=$this->data;

				$exfile_remove=$this->input->post('exfile_remove');

				//原始資料
				$iqr=$this->mod_business->select_from('iqr', array('member_id'=>$this->session->userdata('member_id')));
				$ori_exfile=$iqr['exfile'];

				//刪除
				$temp_exfile_id=$this->get_serialstr($ori_exfile, '*#');
				$result=array_diff($temp_exfile_id, $exfile_remove);
				$exfile_id=$this->set_serialstr($result, '*#');
				$exfile_id_array=array_diff($temp_exfile_id, $result);

				//update_set
				$this->mod_business->update_set('iqr', 'member_id', $this->session->userdata('member_id'), array('exfile'=>$exfile_id));

				// exchange update
				// auth
		        $member = $this->mod_business->select_from('member', array('member_id' => $this->session->userdata('member_id')));
	            $auth   = intval($member['auth']);
	            // web config
	            $auth_level_num = intval($data['web_config']['auth_level_num']);
				if($auth_level_num > $auth) // 擁有共享層級的使用者
	            {
	            	foreach($exfile_id_array as $key => $value)
					{
		                $del_share_data = array(
		                    'member_id'  => $this->session->userdata('member_id'),
		                    'iqr_column' => 'exfile',
		                    'id'         => $value
		                );
		                $del_quote_data = array(
		                    'parent'     => $this->session->userdata('member_id'),
		                    'iqr_column' => 'exfile',
		                    'id'         => $value
		                );
		                $this->mod_business->delete_where('share_data', $del_share_data);
		                $this->mod_business->delete_where('quote_data', $del_quote_data);
					}
	            }
	            else
	            {
	                // 會員層級屬於最低層, 無須update
	            }

				//返回
				$this->session->set_userdata('msg', $language['AnnexDelSuccess']);
				header('Location:/business/exfile_management');
			}
		}
	}

	//移除網路空間附件
	public function exfile_delete()
	{
		//收到新增
		if($this->input->post('doc_id') && $this->input->post('member_id') != '')
		{
			//doc_id
			$doc_id=$this->input->post('doc_id');

			//原始資料
			$doc=$this->mod_business->select_from('documents', array('doc_id'=>$this->input->post('doc_id')));

			// //刪除SERVER端圖檔
			unlink($doc['doc_path']);

			//iqr
			$iqr=$this->mod_business->select_from('iqr', array('member_id'=>$this->session->userdata('member_id')));
			$temp_exfile_array=$this->get_serialstr($iqr['exfile'], '*#');
			$temp_doc_id=array(0=>$doc_id);
			if(!empty($temp_exfile_array) && !empty($temp_doc_id))
			{
				$exfile_array=array_diff($temp_exfile_array, $temp_doc_id);
				$exfile_array=array_diff($temp_exfile_array, $temp_doc_id);
				$exfile_result=$this->set_serialstr($exfile_array, '*#');
				$edit=$this->mod_business->update_set('iqr', 'member_id', $this->session->userdata('member_id'), array('exfile'=>$exfile_result));
			}

			//刪除IMAGE TABLE 資料
			$this->mod_business->delete_where('documents', array('doc_id'=>$this->input->post('doc_id')));

			//data
			$data=$this->data;

			// exchange update
			// auth
	        $member = $this->mod_business->select_from('member', array('member_id' => $this->session->userdata('member_id')));
            $auth   = intval($member['auth']);
            // web config
            $auth_level_num = intval($data['web_config']['auth_level_num']);
			if($auth_level_num > $auth && $doc_id != '') // 擁有共享層級的使用者
            {
                $del_share_data = array(
                    'member_id'  => $this->session->userdata('member_id'),
                    'iqr_column' => 'exfile',
                    'id'         => $doc_id
                );
                $del_quote_data = array(
                    'parent'     => $this->session->userdata('member_id'),
                    'iqr_column' => 'exfile',
                    'id'         => $doc_id
                );
                $this->mod_business->delete_where('share_data', $del_share_data);
                $this->mod_business->delete_where('quote_data', $del_quote_data);
            }
            else
            {
                // 會員層級屬於最低層, 無須update
            }
		}
	}

	//plupload上傳 - documents
	public function upload_doc($dir='')
	{
		$language = $this -> language;
		//判斷帳號是否session
		if(!$this->session->userdata('member_id'))
		{
			//未登入
			$this->myredirect('/index/login', $language['PleaseLogin'], 5);
			return 0;
		}
		else if($dir != '')
		{
			/**
			 * upload.php
			 *
			 * Copyright 2013, Moxiecode Systems AB
			 * Released under GPL License.
			 *
			 * License: http://www.plupload.com/license
			 * Contributing: http://www.plupload.com/contributing
			 */

			#!! IMPORTANT:
			#!! this file is just an example, it doesn't incorporate any security checks and
			#!! is not recommended to be used in production environment as it is. Be sure to
			#!! revise it and customize to your needs.

			// Make sure file is not cached (as it happens for example on iOS devices)
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");

			// 5 minutes execution time
			@set_time_limit(5 * 60);

			// Uncomment this one to fake upload time
			// usleep(5000);

			// Settings
			$member=$this->mod_business->select_from('member', array('member_id'=>$this->session->userdata('member_id')));
			$member_dir=$this->mod_business->member_img_dir_check($member);
			$targetDir = '.'.$member_dir . $dir;

			//$targetDir = 'uploads';
			$cleanupTargetDir = true; // Remove old files
			$maxFileAge = 5 * 3600; // Temp file age in seconds

			// Create target dir
			if (!file_exists($targetDir)) {
				@mkdir($targetDir);
			}

			// Get a file name
			if (isset($_REQUEST["name"])) {
				$fileName = $_REQUEST["name"];
			} elseif (!empty($_FILES)) {
				$fileName = $_FILES["file"]["name"];
			} else {
				$fileName = uniqid("file_");
			}

			//ori name
			$ori_name=$_FILES["file"]["name"];

			$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

			// Chunking might be enabled
			$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
			$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;


			// Remove old temp files
			if ($cleanupTargetDir) {
				if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
					die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
				}

				while (($file = readdir($dir)) !== false) {
					$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

					// If temp file is current file proceed to the next
					if ($tmpfilePath == "{$filePath}.part") {
						continue;
					}

					// Remove temp file if it is older than the max age and is not the current file
					if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
						@unlink($tmpfilePath);
					}
				}
				closedir($dir);
			}


			// Open temp file
			if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
			}

			if (!empty($_FILES)) {
				if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
					die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
				}

				// Read binary input stream and append it to temp file
				if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
					die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
				}
			} else {
				if (!$in = @fopen("php://input", "rb")) {
					die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
				}
			}

			while ($buff = fread($in, 4096)) {
				fwrite($out, $buff);
			}

			@fclose($out);
			@fclose($in);

			// Check if file has been uploaded
			if (!$chunks || $chunk == $chunks - 1) {
				// Strip the temp .part suffix off
				rename("{$filePath}.part", $filePath);

				//寫入資料庫
				$doc_info=array(
					'doc_name'	  =>$ori_name,
					'doc_ori_name'=>$ori_name,
					'doc_path'	  =>$filePath,
					'member_id'   =>$this->session->userdata('member_id')
				);
				$doc_id=$this->mod_business->insert_into('documents', $doc_info);
				$id_str='*#'.$doc_id;

				//檢查原有資料
				$iqr=$this->mod_business->select_from('iqr', array('member_id' =>$this->session->userdata('member_id')));
				$this->mod_business->update_set('iqr', 'member_id', $this->session->userdata('member_id'), array('exfile'=>$iqr['exfile'].$id_str));

				//data
				$data=$this->data;

				// exchange update
				// auth
				$auth = intval($member['auth']);
	            // web config
	            $auth_level_num = intval($data['web_config']['auth_level_num']);
	            if($auth_level_num > $auth && $doc_id != '') // 擁有共享層級的使用者
	            {
	                // share update
	                $add_share_data  = array(
	                    'member_id'  => $this->session->userdata('member_id'),
	                    'iqr_column' => 'exfile',
	                    'id'         => $doc_id,
	                    'status'     => 1
	                );
	                $add_share_data_where  = array(
	                    'member_id'  => $this->session->userdata('member_id'),
	                    'iqr_column' => 'exfile',
	                    'id'         => $doc_id
	                );
	                $this->mod_business->insert_into('share_data', $add_share_data, $add_share_data_where);

	                // quote update
	                $this->load->model('exchange_model', 'mod_exchange');
	                $member_array = $this->mod_exchange->get_all_member_in_domain($member['domain_id']);
	                foreach($member_array as $key => $value)
	                {
	                    $add_quote_data = array(
	                        'member_id'  => $value,
	                        'parent'     => $this->session->userdata('member_id'),
		                    'iqr_column' => 'exfile',
		                    'id'         => $doc_id,
	                        'status'     => 0
	                    );
	                    $add_quote_data_where = array(
	                        'member_id'  => $value,
	                        'parent'     => $this->session->userdata('member_id'),
		                    'iqr_column' => 'exfile',
		                    'id'         => $doc_id
	                    );
	                    $this->mod_business->insert_into('quote_data', $add_quote_data, $add_quote_data_where);
	                }
	            }
	            else
	            {
	                // 會員層級屬於最低層, 無須update
	            }
			}

			// Return Success JSON-RPC response
			die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
		}
	}

	//表單管理
	public function eform()
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
			$data = $this->data;

			$this -> lang -> load('views/business/eform', $data['lang']);
			$data['PeopleNum'] = lang('PeopleNum');
			$data['ClassType'] = lang('ClassType');
			$data['RegistrationFormNum'] = lang('RegistrationFormNum');
			$data['NoQuoteAnyFrom'] = lang('NoQuoteAnyFrom');
			$data['NoAnyClassType'] = lang('NoAnyClassType');
			$data['NoAnyFrom'] = lang('NoAnyFrom');
			$data['SelectAll'] = lang('SelectAll');
			$data['Name_2'] = lang('Name_2');
			$data['_CustomForms'] = lang('_CustomForms');
			$data['CustomButtonsName'] = lang('CustomButtonsName');
			$data['Delete'] = lang('Delete');
			$data['DeleteClass'] = lang('DeleteClass');
			$data['QuickLink'] = lang('QuickLink');
			$data['Cancle'] = lang('Cancle');
			$data['StatusEditDel'] = lang('StatusEditDel');
			$data['NotFirefoxChromIE'] = lang('NotFirefoxChromIE');
			$data['ButtonStatus'] = lang('ButtonStatus');
			$data['LimitButtonName'] = lang('LimitButtonName');
			$data['ModifyFormContent'] = lang('ModifyFormContent');
			$data['ModifyClassName'] = lang('ModifyClassName');
			$data['_ClassType'] = lang('_ClassType');
			$data['_RegistrationForm'] = lang('_RegistrationForm');
			$data['NowHave'] = lang('NowHave');
			$data['SequenceFrom'] = lang('SequenceFrom');
			$data['SignUpName'] = lang('SignUpName');
			$data['SignUpEnrollment'] = lang('SignUpEnrollment');
			$data['StrNum15'] = lang('StrNum15');
			$data['No'] = lang('No');
			$data['Open'] = lang('Open');
			$data['NewClassType'] = lang('NewClassType');
			$data['AddSignUpForm'] = lang('AddSignUpForm');
			$data['NoInformation'] = lang('NoInformation');
			$data['Number'] = lang('Number');
			$data['EditButtonName'] = lang('EditButtonName');
			$data['CopyForm'] = lang('CopyForm');
			$data['NotShowAllName'] = lang('NotShowAllName');
			$data['Operating'] = lang('Operating');
			$data['SaveSingUpName'] = lang('SaveSingUpName');
			$data['SaveSingUpSequence'] = lang('SaveSingUpSequence');
			$data['DownloadExcel'] = lang('DownloadExcel');
			$data['Close'] = lang('Close');

			//member
			$member = $iqr = $this->mod_business->select_from('member', array('member_id'=>$this->session->userdata('member_id')));

			//行動名片資料
			$data['iqr'] = $iqr = $this->mod_business->select_from('iqr', array('member_id'=>$this->session->userdata('member_id')));

			//helper
			$this->load->helper('form');

			//account
			$data['account'] = $member['account'];
			$data['mid'] 	 = $this->session->userdata('member_id');

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

			//分類類別
			$data['uform_category'] = $this -> mod_business -> select_from_order('strings_category', 'cid', 'desc', array('member_id' => $member['member_id'], 'type' => 'uform'));
			$data['uform_category_num'] = count($data['uform_category']);
			//報名表單資料
			$uform = $this->get_serialstr($iqr['uform'], '*#');
			$data['uform_num'] = 0;
			if(!empty($uform) && $uform[0] != '*#')
			{
				foreach($uform as $key => $value)
				{
					$data['uform'][] 			 	= $ufm = $this->mod_business->select_from('uform', array('ufm_id'=>$value));
					$category 						= $this -> mod_business -> select_from('strings_category', array('cid' => $ufm['ufm_cid']));
					$data['uform'][$key]['category_name'] = (!empty($category['name'])) ? $category['name'] : $language['NoCategory'];
					$temp_sudata 	 			 	= $this->mod_business->select_from_order('uform_signup', 'ufms_id', 'asc', array('ufm_id'=>$value));
					$data['ufm_sudata'][] 		 	= (!empty($temp_sudata)) ? 1 : 0 ;
					$data['ufm_su_number'][$key] 	= (!empty($temp_sudata)) ? count($temp_sudata) : '' ;
					$data['ufm_status'][$key] 	    = ($ufm['ufm_status'] == 0) ? $language['NotShow'] : $language['Show'];
					$data['ufm_status_color'][$key] = ($ufm['ufm_status'] == 0) ? 'active' : '';

					$data['uform_num']++;
				}
			}
			//引用表單列表，供顯示表單QRCODE與報名情形預覽
			$temp_quote_uform = $this->mod_business->select_from_order('quote_data', 'id', 'asc', array('member_id'=>$this->session->userdata('member_id'), 'iqr_column'=>'uform', 'status'=>1));
			if(!empty($temp_quote_uform))
			{
				foreach($temp_quote_uform as $key => $value)
				{
					$data['quote_uform'][] = $this->mod_business->select_from('uform', array('ufm_id'=>$value['id']));
					$temp_sudata 	 	   = $this->mod_business->select_from_order('uform_signup', 'ufms_id', 'asc', array('ufm_id'=>$value['id'], 'card_owner'=>$this->session->userdata('member_id')));
					$data['quote_uform_sudata'][] = (!empty($temp_sudata)) ? 1 : 0 ;
					$data['quote_uform_sunumber'][$key] = (!empty($temp_sudata)) ? count($temp_sudata) : '' ;
				}
			}

			//顯示作業完成提示 msg
			if($this->session->userdata('msg') != '')
				$data['msg']=$this->session->userdata('msg');
			else
				$data['msg']='';
			$this->session->set_userdata('msg', '');

			//view
			$this->load->view('business/eform', $data);
		}
	}

	//好友分享券 show
	public function my_ecoupon($mid, $eid)
	{
		//member
		$member = $this->mod_business->select_from('member', array('member_id'=>$mid));
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
			$data['img_url'] 	 = $img_url = '.'.$member['img_url'].'coupon/';
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

	public function ecoupon_editor($mid, $eid, $templatename='', $appacount='', $viewtype='')
	{
		//member
		$member = $this->mod_business->select_from('member', array('member_id'=>$mid));
		if(!empty($member))
		{
			// data
			$data = $this -> data;
			$lang = $this -> mod_language -> converter('18', $this -> set_language);
			$data = array_merge($data, $lang);

			$data['viewtype']=$viewtype;
			$data['public_barcodeurl'] = base_url()."app/route/".$member['member_id'];

            //member_id
            $data['mid'] = $member['member_id'];
            //full url
            $data['actual_link'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

			//folder
			$data['img_url'] 	 = $img_url = './uploads/000/000/0000/0000000000/coupon/';
			$data['my_e_coupon'] = $this->mod_business->select_from('ecoupon', array('ecp_id'=>$eid));
			$data['download_href'] = base_url() . 'app/route/' . $member['member_id'];
			$data['ecp_Ppath'] = base_url() .substr($img_url, 2). $data['my_e_coupon']['filename'];

			//裝置判斷分享bar hideen
			if($this->input->get('d') == 1 && $this->get_device_os() == 'android')
				$data['share_bar_hidden'] = 0;
			$data['android_d'] = $this->input->get('d');

			//view
			if (empty($templatename))
				$this->load->view('ecoupon/show_editor', $data);
			else  {
				$data['get_device_type']=$this->get_device_type();
				$data['public_share_pict_Ppath'] = $data['ecp_Ppath'];
				$data['public_share_title'] = $data['my_e_coupon']['name'];
				$data['public_share_url']   = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

				if($data['get_device_type']>=1) {//手機>=1
					$data['public_share_buttom_url']   = 'jecp://path='.$data['public_share_pict_Ppath'].'&ecp_url='.$data['public_share_url'].'&ecp_title='.$data['public_share_title'];
				}else{
				}

				$sql = "SELECT i.theme_id,i.set_header,i.set_03list FROM iqr i inner join member m on m.member_id=i.member_id WHERE m.account = ?";
				$theme = $this->db->query($sql, array($appacount))->result_array(); //樣板以子帳號為主
				$data['theme_id']=$theme[0]['theme_id'];
				$data['set_header']=$theme[0]['set_header'];
				$data['set_03list']=$theme[0]['set_03list'];
				$data['account']=$appacount; //account  以APP帳號為主

				if ($data['theme_id']>=9){
					$this->load->view('template/temp'.$data['theme_id'].'/ecoupon_detail' , $data);
				}else{
					$this->load->view('ecoupon/'.$templatename, $data);
				}
			}
		}
	}

    //好友分享券
	public function ecoupon($opr = '', $success = '', $id = '')
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
			$data = $this->data;

			//member
			$member = $this->mod_business->select_from('member', array('member_id'=>$this->session->userdata('member_id')));

			//延長ckeditor上傳時間
			$this->extend_ckupload_time(3600, $member['member_id'], $member['img_url'].'ckfinder_image/', $member['auth'], $member['domain_id']);

            //member
            $iqr = $this->mod_business->select_from('iqr', array('member_id'=>$this->session->userdata('member_id')));

			//helper
			$this->load->helper('form');

			//account
			$data['account'] = $member['account'];
			$data['mid'] 	 = $this->session->userdata('member_id');

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

			//行動名片資料
			$ecoupon = $this->mod_business->select_from_order('ecoupon', 'ecp_id', 'desc', array('member_id'=>$this->session->userdata('member_id')));
			foreach ($ecoupon as $key => $value) {
				switch ($value['mode']) {
                    case 1: $ecoupon[$key]['mode_txt'] = $language['AppPoint'];     		break;
                    case 2: $ecoupon[$key]['mode_txt'] = $language['CustomShareURL']; 		break;
                    case 3: $ecoupon[$key]['mode_txt'] = $language['CustomShareContent'];	break;
				}
			}
			$data['ecoupon'] = $ecoupon;

			//folder
			$data['img_url'] = $img_url = '.'.$member['img_url'].'coupon/';

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
						$this->load->view('ecoupon/add', $data);
					}
					else
					{
						//創建資料夾放分享券
						if(!is_dir($img_url))
							@mkdir($img_url);

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
								$share = base_url() . 'app/route/' . $member['member_id'];
								$insert_data = array(
									'member_id' => $this->session->userdata('member_id'),
									'name' 		=> $this->input->post('name'),
									'filename' 	=> $coupon['path'],
									'content' 	=> $this->input->post('content'),
									'btn_name'	=> $this->input->post('btn_name'),
									'mode'		=> $share_mode,
									'mode_1'	=> $share
								);
								$ecp_id = $this->mod_business->insert_into('ecoupon', $insert_data);
								break;
							case 2:
								// 自訂分享網址
								$share_url = $this -> input -> post('share_url');
								$insert_data = array(
									'member_id' => $this->session->userdata('member_id'),
									'name' 		=> $this->input->post('name'),
									'filename' 	=> $coupon['path'],
									'content' 	=> $this->input->post('content'),
									'btn_name'	=> $this->input->post('btn_name'),
									'mode'		=> $share_mode,
									'mode_2'	=> $share_url
								);
								$ecp_id = $this->mod_business->insert_into('ecoupon', $insert_data);
								break;
							case 3:
								$share_txt = $this -> input -> post('share_txt');
								$insert_data = array(
									'member_id' => $this->session->userdata('member_id'),
									'name' 		=> $this->input->post('name'),
									'filename' 	=> $coupon['path'],
									'content' 	=> $this->input->post('content'),
									'btn_name'	=> $this->input->post('btn_name'),
									'mode'		=> $share_mode,
									'mode_3'	=> $share_txt
								);
								$ecp_id = $this->mod_business->insert_into('ecoupon', $insert_data);
								break;
						}

                        //iqr
                        $ecp_id_string = $iqr['ecoupon'].'*#'.$ecp_id;
                        $this->mod_business->update_set('iqr', 'member_id', $this->session->userdata('member_id'), array('ecoupon'=>$ecp_id_string));

						// exchange update
                        if($auth_level_num > $auth) // 擁有共享層級的使用者
			            {
			                // share update
			                $add_share_data  = array(
			                    'member_id'  => $this->session->userdata('member_id'),
			                    'iqr_column' => 'ecoupon',
			                    'id'         => $ecp_id,
			                    'status'     => 1
			                );
			                $add_share_data_where  = array(
			                    'member_id'  => $this->session->userdata('member_id'),
			                    'iqr_column' => 'ecoupon',
			                    'id'         => $ecp_id
			                );
			                $this->mod_business->insert_into('share_data', $add_share_data, $add_share_data_where);

			                // quote update
			                $this->load->model('exchange_model', 'mod_exchange');
			                $member_array = $this->mod_exchange->get_all_member_in_domain($member['domain_id']);
			                foreach($member_array as $key => $value)
			                {
			                    $add_quote_data = array(
			                        'member_id'  => $value,
			                        'parent'     => $this->session->userdata('member_id'),
				                    'iqr_column' => 'ecoupon',
			                    	'id'         => $ecp_id,
			                        'status'     => 0
			                    );
			                    $add_quote_data_where = array(
			                        'member_id'  => $value,
			                        'parent'     => $this->session->userdata('member_id'),
				                    'iqr_column' => 'ecoupon',
			                    	'id'         => $ecp_id
			                    );
			                    $this->mod_business->insert_into('quote_data', $add_quote_data, $add_quote_data_where);
			                }
			            }
			            else
			            {
			                // 會員層級屬於最低層, 無須update
			            }

						//返回
						redirect('/business/ecoupon/add/1');
					}
					break;

				case 'edit':

					$data['edit_ecp'] = $this->mod_business->select_from('ecoupon', array('ecp_id'=>$id, 'member_id'=>$this->session->userdata('member_id')));

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
						$this->load->view('ecoupon/edit', $data);
					}
					else
					{
						$share_mode = $this -> input -> post('share_mode');
						switch ($share_mode) {
							case 1:
								// App 載點
								$share = base_url() . 'app/route/' . $member['member_id'];
								$update_data = array(
									'member_id' => $this->session->userdata('member_id'),
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
									'member_id' => $this->session->userdata('member_id'),
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
									'member_id' => $this->session->userdata('member_id'),
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
						redirect('/business/ecoupon/edit/1');
					}

					break;

				case 'delete':

                    //iqr
                    $ecp_id_array = $this->get_serialstr($iqr['ecoupon'], '*#');
                    foreach($ecp_id_array as $key => $value)
                    {
                        if($value == $id)
                            unset($ecp_id_array[$key]);
                    }
                    $ecp_id_string = $this->set_serialstr($ecp_id_array, '*#');
                    $this->mod_business->update_set('iqr', 'member_id', $this->session->userdata('member_id'), array('ecoupon'=>$ecp_id_string));

                    //ecoupon
					$delete_ecp = $this->mod_business->select_from('ecoupon', array('ecp_id'=>$id, 'member_id'=>$this->session->userdata('member_id')));
					unlink($img_url.$delete_ecp['filename']);
					$this->mod_business->delete_where('ecoupon', array('ecp_id'=>$id, 'member_id'=>$this->session->userdata('member_id')));

					// exchange update
					if($auth_level_num > $auth) // 擁有共享層級的使用者
		            {
		                $del_share_data = array(
		                    'member_id'  => $this->session->userdata('member_id'),
		                    'iqr_column' => 'ecoupon',
	                    	'id'         => $id
		                );
		                $del_quote_data = array(
		                    'parent'     => $this->session->userdata('member_id'),
		                    'iqr_column' => 'ecoupon',
	                    	'id'         => $id
		                );
		                $this->mod_business->delete_where('share_data', $del_share_data);
		                $this->mod_business->delete_where('quote_data', $del_quote_data);
		            }
		            else
		            {
		                // 會員層級屬於最低層, 無須update
		            }

					//返回
					redirect('/business/ecoupon');

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
					$this->load->view('business/ecoupon', $data);
					break;
			}
		}
	}

	public function ecoupon_qrcode($ecp_id='')
	{
		$language = $this -> language;
		//data
		$data=$this->data;
		$this->publiccheck('',$data['account']);
		$data=$this->data;
		$auth=$data['user_auth'];
		if($auth=='02'){
			$data['chkmemberid']=$this->son_member_id;
			$viewname='';
			$viewtype='P';
		}
		else{
			$data['chkmemberid']=$this->member_id;
			$viewname=$language['Company'];
			$viewtype='C';
		}
		$data['viewname'] = $viewname;
		$data['viewtype'] = $viewtype;

		//helper
		$this->load->helper('url');

		if($ecp_id != '')
		{
			$data['ecoupon'] = $ecoupon = $this->mod_index->select_from('ecoupon', array('ecp_id'=>$ecp_id));
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

	//新增報名表單填寫視窗
	public function uform_add($success='')
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
				$data['member_id']=$this->session->userdata('member_id');

				//延長ckeditor上傳時間
				$this->extend_ckupload_time(3600, $member['member_id'], $member['img_url'].'ckfinder_image/', $member['auth'], $member['domain_id']);

				//form item
				$data['form_item']=$this->mod_business->select_from_order('form_item', 'item_id', 'asc');

				// uform category
					$data['uform_category'] = $category = $this -> mod_business -> select_from_order('strings_category', 'cid', asc, array('type' => 'uform', 'member_id' => $member['member_id']));

				//view
				$this->load->view('business/uform_add', $data);
			}
			else
			{
				//固定欄位設定
				$temp_ufm_col_name[] = ($this->input->post('ufm_col_0') != '') ? $this->input->post('ufm_col_0') : $language['Name'];
				$temp_ufm_col_name[] = ($this->input->post('ufm_col_1') != '') ? $this->input->post('ufm_col_1') : $language['Phone'];
				$temp_ufm_col_name[] = ($this->input->post('ufm_col_2') != '') ? $this->input->post('ufm_col_2') : $language['Mail'];

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
					'ufm_aim'  			=> $this->input->post('ufm_aim'),
					'ufm_col_name' 		=> $ufm_col_name,
					'ufm_col_content' 	=> $ufm_col_content,
					'ufm_col_required' 	=> $ufm_col_required,
					'ufm_mode'			=> $this->input->post('ufm_mode'),
					'ufm_status' 		=> 1,
					'ufm_msg' 			=> $this->input->post('ufm_msg'),
					'ufm_col_num'		=> count($temp_ufm_col_name),
					'member_id' 		=> $this->input->post('member_id')
				);
				$ufm_id=$this->mod_business->insert_into('uform', $uform_data);

				//更新iqr
				$iqr=$this->mod_business->select_from('iqr', array('member_id'=>$this->input->post('member_id')));
				$iqr['uform'].='*#'.$ufm_id;
				$this->mod_business->update_set('iqr', 'member_id', $this->input->post('member_id'), array('uform'=>$iqr['uform']));

				// exchange update
				// auth
		        $auth = intval($member['auth']);
	            // web config
	            $auth_level_num = intval($data['web_config']['auth_level_num']);
	            if($auth_level_num > $auth) // 擁有共享層級的使用者
	            {
	                // share update
	                $add_share_data  = array(
	                    'member_id'  => $this->session->userdata('member_id'),
	                    'iqr_column' => 'uform',
	                    'id'         => $ufm_id,
	                    'status'     => 1
	                );
	                $add_share_data_where = array(
	                    'member_id'  => $this->session->userdata('member_id'),
	                    'iqr_column' => 'uform',
	                    'id'         => $ufm_id
	                );
	                $this->mod_business->insert_into('share_data', $add_share_data, $add_share_data_where);

	                // quote update
	                $this->load->model('exchange_model', 'mod_exchange');
	                $member_array = $this->mod_exchange->get_all_member_in_domain($member['domain_id']);
	                foreach($member_array as $key => $value)
	                {
	                    $add_quote_data = array(
	                        'member_id'  => $value,
	                        'parent'     => $this->session->userdata('member_id'),
		                    'iqr_column' => 'uform',
		                    'id'         => $ufm_id,
	                        'status'     => 0
	                    );
	                    $add_quote_data_where = array(
	                        'member_id'  => $value,
	                        'parent'     => $this->session->userdata('member_id'),
		                    'iqr_column' => 'uform',
		                    'id'         => $ufm_id
	                    );
	                    $this->mod_business->insert_into('quote_data', $add_quote_data, $add_quote_data_where);
	                }
	            }
	            else
	            {
	                // 會員層級屬於最低層, 無須update
	            }

				redirect('/business/uform_add/1');
			}
		}
	}

	//編輯報名表單填寫視窗
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
					//member
					$member = $this->mod_business->select_from('member', array('member_id'=>$this->session->userdata('member_id')));

					//延長ckeditor上傳時間
					$this->extend_ckupload_time(3600, $member['member_id'], $member['img_url'].'ckfinder_image/', $member['auth'], $member['domain_id']);

					//form item
					$data['form_item']=$this->mod_business->select_from_order('form_item', 'item_id', 'asc');

					//uform
					$data['uform']=$uform=$this->mod_business->select_from('uform', array('ufm_id'=>$ufm_id));
					// uform category
					$data['uform_category'] = $category = $this -> mod_business -> select_from_order('strings_category', 'cid', asc, array('type' => 'uform', 'member_id' => $member['member_id']));
					foreach ($category as $key => $value)
					{
						$data['uform_category'][$key]['selection'] = ($uform['ufm_cid'] == $value['cid']) ? 'selected' : '' ;
					}
					//欄位名稱
					$data['ufm_col_name_1']=$this->get_serialstr($uform['ufm_col_name'], '*#');
					$ufm_col_name_number=count($this->get_serialstr($uform['ufm_col_name'], '*#')) - 3;
					if($ufm_col_name_number > 0)
					{
						foreach($data['ufm_col_name_1'] as $key => $value)
						{
							if($key >= 3)
								$data['ufm_col_name_2'][]=$value;
						}
						$data['ufm_col_name_number']=$ufm_col_name_number;
					}
					else $data['ufm_col_name_number']=0;

					//欄位內容
					$space_content=$ufm_col_content=$this->get_serialstr($uform['ufm_col_content'], '*#');
					if(!empty($space_content))
					{
						foreach($space_content as $key => $value)
						{
							$data['space_content'][]=substr($value, 2);
						}
					}
					if(!empty($ufm_col_content))
					{
						foreach($ufm_col_content as $key => $value)
						{
							$str=explode(';', $value);
							$data['ufm_col_content'][]=$str;
						}
					}

					//欄位必填
					$ufm_col_required=$this->get_serialstr($uform['ufm_col_required'], '*#');
					if(!empty($ufm_col_required))
					{
						foreach($ufm_col_required as $key => $value)
						{
							$data['ufm_col_required'][]=($value == 1) ? 'checked' : '';
						}
					}

					//view
					$this->load->view('business/uform_edit', $data);
				}
				else
				{
					//ufm_id
					$ufm_id=$this->input->post('ufm_id');

					//固定欄位設定
					$temp_ufm_col_name[] = ($this->input->post('ufm_col_0') != '') ? $this->input->post('ufm_col_0') : $language['Name'];
					$temp_ufm_col_name[] = ($this->input->post('ufm_col_1') != '') ? $this->input->post('ufm_col_1') : $language['Phone'];
					$temp_ufm_col_name[] = ($this->input->post('ufm_col_2') != '') ? $this->input->post('ufm_col_2') : $language['Mail'];

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
						'ufm_cid'			=> $this->input->post('ufm_cid'),
						'ufm_aim'  			=> $this->input->post('ufm_aim'),
						'ufm_col_name' 		=> $ufm_col_name,
						'ufm_col_content' 	=> $ufm_col_content,
						'ufm_col_required' 	=> $ufm_col_required,
						'ufm_mode'			=> $this->input->post('ufm_mode'),
						'ufm_msg' 			=> $this->input->post('ufm_msg'),
						'ufm_col_num'		=> count($temp_ufm_col_name)
					);
					$ufm_id=$this->mod_business->update_set('uform', 'ufm_id', $ufm_id, $uform_data);

					echo '<script>';
					echo 'alert("'.$language['EditSuccess'].'");';
					echo 'window.close();';
					echo '</script>';
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

	//複製報名表單填寫視窗
	public function uform_copy($ufm_id='', $success='')
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

			$this -> lang -> load('views/business/uform_copy', $data['lang']);
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
			$data['Remove'] = lang('Remove');
			$data['PromptStr'] = lang('PromptStr');
			$data['FillActivityEx'] = lang('FillActivityEx');
			$data['Add'] = lang('Add');
			$data['SetPromptStr'] = lang('SetPromptStr');
			$data['SaveEdit'] = lang('SaveEdit');
			$data['ColumnPosition'] = lang('ColumnPosition');
			$data['CheckWebUI'] = lang('CheckWebUI');
			$data['AddBlank'] = lang('AddBlank');
			$data['NoSpaceAdd'] = lang('NoSpaceAdd');
			$data['RadioMotorcycleTaxiCar'] = lang('RadioMotorcycleTaxiCar');
			$data['DropMotorcycleTaxiCar'] = lang('DropMotorcycleTaxiCar');
			$data['WebUIValue'] = lang('WebUIValue');
			$data['VehicleValue'] = lang('VehicleValue');
			$data['SureCancleCopy'] = lang('SureCancleCopy');
			$data['Copy'] = lang('Copy');
			$data['CopySuccess'] = lang('CopySuccess');
			$data['CopyUpForm'] = lang('CopyUpForm');
			$data['_CopyUpForm'] = lang('_CopyUpForm');

			if(!$this->input->post('form_submit'))
			{
				if($ufm_id != '')
				{
					//member
					$member = $this->mod_business->select_from('member', array('member_id'=>$this->session->userdata('member_id')));

					//延長ckeditor上傳時間
					$this->extend_ckupload_time(3600, $member['member_id'], $member['img_url'].'ckfinder_image/', $member['auth'], $member['domain_id']);

					//複製完成
					$data['success']=$success;

					//form item
					$data['form_item']=$this->mod_business->select_from_order('form_item', 'item_id', 'asc');

					//uform
					$data['uform']=$uform=$this->mod_business->select_from('uform', array('ufm_id'=>$ufm_id));

					// uform category
					$data['uform_category'] = $category = $this -> mod_business -> select_from_order('strings_category', 'cid', asc, array('type' => 'uform', 'member_id' => $member['member_id']));
					foreach ($category as $key => $value)
					{
						$data['uform_category'][$key]['selection'] = ($uform['ufm_cid'] == $value['cid']) ? 'selected' : '' ;
					}

					//欄位名稱
					$data['ufm_col_name_1']=$this->get_serialstr($uform['ufm_col_name'], '*#');
					$ufm_col_name_number=count($this->get_serialstr($uform['ufm_col_name'], '*#')) - 3;
					if($ufm_col_name_number > 0)
					{
						foreach($data['ufm_col_name_1'] as $key => $value)
						{
							if($key >= 3)
								$data['ufm_col_name_2'][]=$value;
						}
						$data['ufm_col_name_number']=$ufm_col_name_number;
					}
					else $data['ufm_col_name_number']=0;

					//欄位內容
					$space_content=$ufm_col_content=$this->get_serialstr($uform['ufm_col_content'], '*#');
					if(!empty($space_content))
					{
						foreach($space_content as $key => $value)
						{
							$data['space_content'][]=substr($value, 2);
						}
					}
					if(!empty($ufm_col_content))
					{
						foreach($ufm_col_content as $key => $value)
						{
							$str=explode(';', $value);
							$data['ufm_col_content'][]=$str;
						}
					}

					//欄位必填
					$ufm_col_required=$this->get_serialstr($uform['ufm_col_required'], '*#');
					if(!empty($ufm_col_required))
					{
						foreach($ufm_col_required as $key => $value)
						{
							$data['ufm_col_required'][]=($value == 1) ? 'checked' : '';
						}
					}

					//view
					$this->load->view('business/uform_copy', $data);
				}
				else
				{
					echo '<script>';
					echo 'alert("'.$language['DataLost'].'");';
					echo 'window.close();';
					echo '</script>';
				}
			}
			else
			{
				//固定欄位設定
				$temp_ufm_col_name[] = ($this->input->post('ufm_col_0') != '') ? $this->input->post('ufm_col_0') : $language['Name'];
				$temp_ufm_col_name[] = ($this->input->post('ufm_col_1') != '') ? $this->input->post('ufm_col_1') : $language['Phone'];
				$temp_ufm_col_name[] = ($this->input->post('ufm_col_2') != '') ? $this->input->post('ufm_col_2') : $language['Mail'];

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
					'ufm_aim'  			=> $this->input->post('ufm_aim'),
					'ufm_col_name' 		=> $ufm_col_name,
					'ufm_col_content' 	=> $ufm_col_content,
					'ufm_col_required' 	=> $ufm_col_required,
					'ufm_status' 		=> 1,
					'ufm_msg' 			=> $this->input->post('ufm_msg'),
					'ufm_col_num'		=> count($temp_ufm_col_name),
					'member_id' 		=> $this->session->userdata('member_id')
				);
				$copy_ufm_id=$this->mod_business->insert_into('uform', $uform_data);

				//更新iqr
				$iqr=$this->mod_business->select_from('iqr', array('member_id'=>$this->session->userdata('member_id')));
				$iqr['uform'].='*#'.$copy_ufm_id;
				$this->mod_business->update_set('iqr', 'member_id', $this->session->userdata('member_id'), array('uform'=>$iqr['uform']));

				redirect('/business/uform_copy/'.$copy_ufm_id.'/1');
			}
		}
	}

	//排序報名表單
	public function uform_sort()
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
			//收到新增
			if($this->input->post('uform_sort_id'))
			{
				//data
				$data=$this->data;

				//設定字串列
				$uform_sort=$this->set_serialstr($this->input->post('uform_sort_id'), '*#');

				//update_set
				$this->mod_business->update_set('iqr', 'member_id', $this->session->userdata('member_id'), array('uform'=>$uform_sort));

				//返回
				$this->session->set_userdata('msg', $language['SequenceFinish']);
				header('Location:/business/eform');
			}
		}
	}

	// 新增報名表單分類
	public function uform_category_add($success = '')
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

			$this -> lang -> load('views/business/uform_category_add', $data['lang']);
			$data['ClassTypeName'] = lang('ClassTypeName');
			$data['Cancle'] = lang('Cancle');
			$data['SureCancleAdd'] = lang('SureCancleAdd');
			$data['Add'] = lang('Add');
			$data['NewClassType'] = lang('NewClassType');
			$data['_NewClassType'] = lang('_NewClassType');
			$data['NewSuccess'] = lang('NewSuccess');

			//member
			$member = $this->mod_business->select_from('member', array('member_id'=>$this->session->userdata('member_id')));

			if(!$this->input->post('form_submit'))
			{
				//新增完成
				$data['success']=$success;

				//member_id
				$data['member_id']=$this->session->userdata('member_id');

				//延長ckeditor上傳時間
				$this->extend_ckupload_time(3600, $member['member_id'], $member['img_url'].'ckfinder_image/', $member['auth'], $member['domain_id']);

				//view
				$this->load->view('business/uform_category_add', $data);
			}
			else
			{
			 	$insert_data = array(
			 			'name'		=>	$this -> input -> post('ufm_category'),
			 			'type'		=>	'uform',
			 			'member_id'	=>	$this -> input -> post('member_id')
		 		);
			 	$this -> mod_business -> insert_into('strings_category', $insert_data);
				redirect('/business/uform_category_add/1');
			}
		}
	}

	// 編輯報名表單分類
	public function uform_category_edit($cid = '')
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

			$this -> lang -> load('views/business/uform_category_edit', $data['lang']);
			$data['ClassTypeName'] = lang('ClassTypeName');
			$data['Cancle'] = lang('Cancle');
			$data['Modify'] = lang('Modify');
			$data['ModifyClassType'] = lang('ModifyClassType');
			$data['_ModifyClassType'] = lang('_ModifyClassType');
			$data['ModifySuccess'] = lang('ModifySuccess');
			$data['SureCancleAdd'] = lang('SureCancleAdd');

			if($cid != '')
			{
				if(!$this->input->post('form_submit'))
				{
					//member
					$member = $this->mod_business->select_from('member', array('member_id'=>$this->session->userdata('member_id')));


					//延長ckeditor上傳時間
					$this->extend_ckupload_time(3600, $member['member_id'], $member['img_url'].'ckfinder_image/', $member['auth'], $member['domain_id']);
					$data['cid'] = $cid;
					$data['member_id'] = $member['member_id'];
					$data['category'] = $this -> mod_business -> select_from('strings_category', array('member_id' => $member['member_id'], 'cid' => $cid));

					//view
					$this->load->view('business/uform_category_edit', $data);
				}
				else
				{
					$update_data = array(
							'name'		=> $this -> input -> post('ufm_category'),
							'type'		=> 'uform',
							'member_id' => $this -> input -> post('member_id')
					);
					$this -> mod_business -> update_set('strings_category', 'cid', $this -> input -> post('cid'), $update_data);

					echo '<script>';
					echo 'alert("修改成功");';
					echo 'opener.window.parent.location.reload();';
					echo 'window.close();';
					echo '</script>';
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

	public function uform_category_del()
	{
		if($this -> input -> post('member_id') && $this -> input -> post('cid'))
		{
			$uform = $this -> mod_business -> select_from_order('uform', 'ufm_id', 'asc', array('member_id' => $this -> input -> post('member_id')));
			foreach ($uform as $key => $value)
			{
				$return = ($value['ufm_cid'] == $this -> input -> post('cid')) ? true : false;
				if($return)
				{
					$this -> mod_business -> update_set('uform', 'ufm_id', $value['ufm_id'], array('ufm_cid' => '0'));
				}
			}
			$this -> mod_business -> delete_where('strings_category', array('cid' => $this -> input -> post('cid'), 'member_id' => $this -> input -> post('member_id')));
			echo true;
		}
		else
			echo false;
	}

	//編輯報名表單按鈕名稱
	public function uform_edit_btn_name()
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
			//收到新增
			if($this->input->post('uform_name'))
			{
				//data
				$data=$this->data;

				//update_set
				$uform_btn_name='';
				foreach($this->input->post('uform_name') as $key => $value)
				{
					$this->mod_business->update_set('uform', 'ufm_id', $key, array('ufm_btn_name'=>$value));
					$uform_btn_name.='*#'.$value;
				}

				//返回
				$this->session->set_userdata('msg', $language['ButtonSaveSuccess']);
				header('Location:/business/eform');
			}
		}
	}

	//開啟或關閉報名表單
	public function uform_switch()
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
			if($this->input->post('uform_ctrl_type') != '')
			{
				//data
				$data=$this->data;

				$uform_id=$this->input->post('uform_switch_id');
				if(!empty($uform_id))
				{
					// exchange update
					// auth
					$member = $this->mod_business->select_from('member', array('member_id'=>$this->session->userdata('member_id')));
			        $auth   = intval($member['auth']);

		            // web config
		            $auth_level_num = intval($data['web_config']['auth_level_num']);

					foreach($uform_id as $key => $value)
					{
						//0 開啟, 1 關閉, 2 刪除
						switch ($this->input->post('uform_ctrl_type')) {
							case 0:
								$this->mod_business->update_set('uform', 'ufm_id', $value, array('ufm_status'=>1));
								$exchange_update_type = 'add';
								break;
							case 1:
								$this->mod_business->update_set('uform', 'ufm_id', $value, array('ufm_status'=>0));
								$exchange_update_type = 'delete';
								break;
							case 2:
								$this->mod_business->delete_where('uform', array('ufm_id'=>$value));
								$this->mod_business->delete_where('uform_signup', array('ufm_id'=>$value));
								$exchange_update_type = 'delete';
								break;
						}

						// exchange update
						if($auth_level_num > $auth) // 擁有共享層級的使用者
			            {
							switch ($exchange_update_type)
							{
								case 'add':

					                // share update
					                $add_share_data  = array(
					                    'member_id'  => $this->session->userdata('member_id'),
					                    'iqr_column' => 'uform',
					                    'id'         => $value,
					                    'status'     => 1
					                );
					                $add_share_data_where = array(
					                    'member_id'  => $this->session->userdata('member_id'),
					                    'iqr_column' => 'uform',
					                    'id'         => $value
					                );
					                $this->mod_business->insert_into('share_data', $add_share_data, $add_share_data_where);

					                // quote update
					                $this->load->model('exchange_model', 'mod_exchange');
					                $member_array = $this->mod_exchange->get_all_member_in_domain($member['domain_id']);
					                foreach($member_array as $ma_key => $ma_value)
					                {
					                    $add_quote_data = array(
					                        'member_id'  => $ma_value,
					                        'parent'     => $this->session->userdata('member_id'),
						                    'iqr_column' => 'uform',
						                    'id'         => $value,
					                        'status'     => 0
					                    );
					                    $add_quote_data_where = array(
					                        'member_id'  => $ma_value,
					                        'parent'     => $this->session->userdata('member_id'),
						                    'iqr_column' => 'uform',
						                    'id'         => $value
					                    );
					                    $this->mod_business->insert_into('quote_data', $add_quote_data, $add_quote_data_where);
					                }

									break;

								case 'delete':

									$del_share_data = array(
					                    'member_id'  => $this->session->userdata('member_id'),
					                    'iqr_column' => 'uform',
					                    'id'         => $value
					                );
					                $del_quote_data = array(
					                    'parent'     => $this->session->userdata('member_id'),
					                    'iqr_column' => 'uform',
					                    'id'         => $value
					                );
					                $this->mod_business->delete_where('share_data', $del_share_data);
					                $this->mod_business->delete_where('quote_data', $del_quote_data);

									break;
							}
						}
			            else
			            {
			                // 會員層級屬於最低層, 無須update
			            }
					}

					//刪除的話修改顯示id
					if($this->input->post('uform_ctrl_type') == 2)
					{
						$iqr=$this->mod_business->select_from('iqr', array('member_id'=>$this->session->userdata('member_id')));
						$iqr_uform=$this->get_serialstr($iqr['uform'], '*#');
						$temp=array_diff($iqr_uform, $uform_id);
						$result=$this->set_serialstr($temp, '*#');
						$this->mod_business->update_set('iqr', 'member_id', $this->session->userdata('member_id'), array('uform'=>$result));
					}
				}

				//返回
				$this->session->set_userdata('msg', $language['EditSuccess']);
				header('Location:/business/eform');
			}
		}
	}

	//顯示報名情形
	public function uform_sign_up_show($ufm_id='', $mail_mid='')
	{
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
			$this->load->view('business/uform_sign_up_show', $data);
		}
		else
		{
			header('Location:'.base_url());
		}
	}

	//匯出報名xls
	public function export($ufm_id='', $mail_mid='')
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
					array_push($data['title_array'], $language['SignUpSource']);
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
				header('Location:/business/eform');
			}
		}
	}

	//網頁編輯器的顯示頁面
	public function web($id='', $page='')
	{
		$data=$this->data;

		$this -> lang -> load('views/business/integrate_text', $data['lang']);
		$data['ShareGoogle'] = lang('ShareGoogle');
		$data['SharePlurk'] = lang('SharePlurk');
		$data['ShareTwitter'] = lang('ShareTwitter');
		$data['ShareWeibo'] = lang('ShareWeibo');
		$data['ShareFacebook'] = lang('ShareFacebook');
		$data['UseEmail'] = lang('UseEmail');
		$data['Site'] = lang('Site');

		if($id != '')
		{
			$member=$this->mod_business->select_from('member', array('member_id'=>$id));
		}
		else
		{
			redirect(base_url());
		}

		if(!empty($member))
		{
			//判斷使用期限
			if(!$this->check_deadline($data['web_config'], $member['member_id']))
			{
				redirect('/index/error');
			}

			//iqr
			$data['id']=$id;
			$iqr=$this->mod_business->select_from('iqr', array('member_id'=>$member['member_id']));

			//full url
			$data['actual_link'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

			//行動名片連結
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

			//網頁內容
			$data['content']=$iqr['text_edit0'.$page];
			$data['header_title']=($iqr['text_edit0'.$page.'_name'] != '') ? $iqr['text_edit0'.$page.'_name'] : '自訂網頁0'.$page;

			if($this->session->userdata('web_return'))
				$data['web_return'] = base_url().'business/iqr/'.$this->session->userdata('web_return'); //web return
			else
				$data['web_return'] = $data['iqr_url'] ;

			//搜尋網頁內容是否含圖片
			$data['first_img'] = $this->get_first_img($data['content']);

			//裝置判斷分享bar hideen
			if($this->input->get('d') == 1 && $this->get_device_os() == 'android')
				$data['share_bar_hidden'] = 0;
			$data['android_d'] = $this->input->get('d');

			$this->load->view('business/integrate_text', $data);
		}
		else
		{
			redirect(base_url());
		}
	}

	//Line加入好友連結取得教學
	public function line_teach()
	{
		$data=$this->data;

		$this -> lang -> load('views/business/line_teach', $data['lang']);
		$data['ChooseAther'] = lang('ChooseAther');
		$data['ChooseSet_2'] = lang('ChooseSet_2');
		$data['LineTeaching'] = lang('LineTeaching');
		$data['LineFieldFinish'] = lang('LineFieldFinish');
		$data['UseEmailSend'] = lang('UseEmailSend');
		$data['ScrollBottom'] = lang('ScrollBottom');
		$data['_PersonalInformation'] = lang('_PersonalInformation');
		$data['Step_1'] = lang('Step_1');
		$data['Step_7'] = lang('Step_7');
		$data['Step_2'] = lang('Step_2');
		$data['Step_3'] = lang('Step_3');
		$data['Step_5'] = lang('Step_5');
		$data['Step_6'] = lang('Step_6');
		$data['Step_4'] = lang('Step_4');
		$data['OpenLineApp'] = lang('OpenLineApp');
		$data['LineUiIos'] = lang('LineUiIos');
		$data['SelectSelfData'] = lang('SelectSelfData');
		$data['SelectShowBarcode'] = lang('SelectShowBarcode');
		$data['CloseWondows'] = lang('CloseWondows');

		$data['id']=$this->session->userdata('member_id');
		$this->load->view('business/line_teach', $data);
	}

	//QRcode風格編輯教學
	public function edit_qrc_style_teach()
	{
		$data=$this->data;
		$this -> lang -> load('views/business/edit_qrc_style_teach', $data['lang']);
		$data['QrcodeTitle'] = lang('QrcodeTitle');
		$data['Project'] = lang('Project');
		$data['Explanation'] = lang('Explanation');
		$data['Exp_1'] = lang('Exp_1');
		$data['Exp_2'] = lang('Exp_2');
		$data['Exp_3'] = lang('Exp_3');
		$data['Exp_4'] = lang('Exp_4');
		$data['Exp_5'] = lang('Exp_5');
		$data['Exp_6'] = lang('Exp_6');
		$data['Exp_7'] = lang('Exp_7');
		$data['Exp_8'] = lang('Exp_8');
		$data['Exp_9'] = lang('Exp_9');
		$data['Exp_10'] = lang('Exp_10');
		$data['Exp_11'] = lang('Exp_11');
		$data['Exp_12'] = lang('Exp_12');
		$data['Exp_13'] = lang('Exp_13');
		$data['Exp_14'] = lang('Exp_14');
		$data['Exp_15'] = lang('Exp_15');
		$data['Exp_16'] = lang('Exp_16');
		$data['Exp_17'] = lang('Exp_17');
		$data['Exp_18'] = lang('Exp_18');

		$data['id']=$this->session->userdata('member_id');
		$this->load->view('business/edit_qrc_style_teach', $data);
	}

	//修改密碼
	// public function update_password()
	// {
	// 	$this->load->view('business/update_password');
	// }

	//擷取部分字串，請傳入前後關鍵字符
	private function cut_mystring($str, $symbol_1, $symbol_2)
	{
		//前後位置
		$pos_1=strpos($str, $symbol_1);
		$pos_2=strpos($str, $symbol_2);

		return substr($str, $pos_1+strlen($pos_1), ($pos_2-$pos_1));
	}

	//搜尋網頁內容是否含圖片
	private function get_first_img($content)
	{
		//前後位置
		if(($img_tag_pos = strpos($content, '<img')) !== false)
		{
			$img_status 	 = true;
			$temp_content_1  = substr($content, $img_tag_pos);
			$img_tag_end_pos = strpos($temp_content_1, '>'); // 從新位置開始找第一個>
			$img_tag 	  	 = substr($temp_content_1, 0, $img_tag_end_pos + 1);
			$src_pos	 	 = strpos($img_tag, 'src');
			$temp_img_link 	 = substr($img_tag, $src_pos);
			$quotation_marks = substr($temp_img_link, 4, 1);
			$temp_img_link   = substr($temp_img_link, 5);
			$q_marks_pos     = strpos($temp_img_link, $quotation_marks);
			$first_img 		 = substr($temp_img_link, 0, $q_marks_pos);
		}
		else
		{
			$img_status = false;
		}
		return array('img_status'=>$img_status, 'first_img'=>$first_img);
	}
}