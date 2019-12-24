<?php
// 共享設定
class Share extends MY_Controller
{
    public $data='';
    public $Clanguage = '';

    public function __construct()//初始化
    {
        parent::__construct();

        // language
        $this -> load -> helper('language');
        if(!$this -> session -> userdata('lang'))
        {
            $this -> session -> set_userdata('lang', 'zh-tw');
            $this -> data['lang'] = $this -> session -> userdata('lang');
        }
        else
            $this -> data['lang'] = $this -> session -> userdata('lang');
        
        $this -> lang -> load('views/business/edit', $this -> data['lang']);
        // language_top
        $this -> data['Edit_Web_version'] = lang('Edit_Web_version');
        $this -> data['Edit_APP_version'] = lang('Edit_APP_version');
        $this -> data['Edit_Sign_out'] = lang('Edit_Sign_out');
        $this -> data['Edit_Signed_in'] = lang('Edit_Signed_in'); 
        $this -> data['Edit_Maturity'] = lang('Edit_Maturity');
        $this -> data['Edit_Day'] = lang('Edit_Day');
        // language_business_header
        $this -> data['Edit_Personal_information'] = lang('Edit_Personal_information');
        $this -> data['Edit_Style_Settings'] = lang('Edit_Style_Settings');
        $this -> data['Edit_Cover_photo_set'] = lang('Edit_Cover_photo_set');
        $this -> data['Edit_Style_setting'] = lang('Edit_Style_setting');
        $this -> data['Edit_settings_action_Stores'] = lang('Edit_settings_action_Stores');
        $this -> data['Edit_Text_classification_set'] = lang('Edit_Text_classification_set');
        $this -> data['Edit_Albums_and_Accessories'] = lang('Edit_Albums_and_Accessories');
        $this -> data['Edit_New_Album'] = lang('Edit_New_Album');
        $this -> data['Edit_Album_Management'] = lang('Edit_Album_Management');
        $this -> data['Edit_Attachment_Manager'] = lang('Edit_Attachment_Manager');
        $this -> data['Edit_QR_code_style'] = lang('Edit_QR_code_style');
        $this -> data['Edit_APP_Edition'] = lang('Edit_APP_Edition');
        $this -> data['Edit_Web_version'] = lang('Edit_Web_version');
        $this -> data['Edit_Contacts'] = lang('Edit_Contacts');
        $this -> data['Edit_Form_Tools'] = lang('Edit_Form_Tools');
        $this -> data['Edit_Custom_Forms'] = lang('Edit_Custom_Forms');
        $this -> data['Edit_Tell_a_friend_Voucher'] = lang('Edit_Tell_a_friend_Voucher');
        $this -> data['Edit_Action_Shop'] = lang('Edit_Action_Shop');
        $this -> data['Edit_Basic_settings'] = lang('Edit_Basic_settings');
        $this -> data['Edit_Commodity_Management'] = lang('Edit_Commodity_Management');
        $this -> data['Edit_Order_Management'] = lang('Edit_Order_Management');
        $this -> data['Edit_Orders_Search'] = lang('Edit_Orders_Search');
        $this -> data['Edit_control_center'] = lang('Edit_control_center');
        $this -> data['Edit_change_Password'] = lang('Edit_change_Password');
        $this -> data['Edit_System_flow'] = lang('Edit_System_flow');
        $this -> data['Edit_Member_Management'] = lang('Edit_Member_Management');
        $this -> data['Edit_Key_state'] = lang('Edit_Key_state');
        $this -> data['Edit_APP_setting'] = lang('Edit_APP_setting');
        $this -> data['Edit_Automatic_packing'] = lang('Edit_Automatic_packing');
        $this -> data['Edit_Application_shelves'] = lang('Edit_Application_shelves');
        $this -> data['Edit_Push_application'] = lang('Edit_Push_application');
        $this -> data['Edit_Added_Management'] = lang('Edit_Added_Management');
        // language_business_header_title
        $this -> data['Edit_Business_Information_Systemsnt'] = lang('Edit_Business_Information_Systemsnt');
        $this -> data['Edit_still_cover_formula'] = lang('Edit_still_cover_formula');
        $this -> data['Edit_commerce_system_styles'] = lang('Edit_commerce_system_styles');
        $this -> data['Edit_store_style_action'] = lang('Edit_store_style_action');
        $this -> data['Edit_title_text_style'] = lang('Edit_title_text_style');
        $this -> data['Edit_systems_albums_Category'] = lang('Edit_systems_albums_Category');
        $this -> data['Edit_commerce_system_Album'] = lang('Edit_commerce_system_Album');
        $this -> data['Edit_business_systems_Accessories'] = lang('Edit_business_systems_Accessories');
        $this -> data['Edit_APP_version_QRcode'] = lang('Edit_APP_version_QRcode');
        $this -> data['Edit_web_version_QRcode'] = lang('Edit_web_version_QRcode');
        $this -> data['Edit_contacts_QRcode_styles'] = lang('Edit_contacts_QRcode_styles');
        $this -> data['Edit_system_custom_form'] = lang('Edit_system_custom_form');
        $this -> data['Edit_commerce_system'] = lang('Edit_commerce_system');
        $this -> data['Edit_APP_installer'] = lang('Edit_APP_installer');
        $this -> data['Edit_apply_through'] = lang('Edit_apply_through');
        $this -> data['Edit_application_APP'] = lang('Edit_application_APP');
        $this -> data['Edit_URL_shelves'] = lang('Edit_URL_shelves');
        
        // language
        $this -> lang -> load('controllers/share', $this -> data['lang']);
        $ReferenceSet = lang('ReferenceSet');
        $SharingPreferences = lang('SharingPreferences');
        $this -> Clanguage['YoutubeSite'] = lang('YoutubeSite');
        $this -> Clanguage['SetUpNotShow'] = lang('SetUpNotShow');
        $this -> Clanguage['CompanyCompiled'] = lang('CompanyCompiled');
        $this -> Clanguage['CompanyPhone'] = lang('CompanyPhone');
        $this -> Clanguage['CorporateImageFigure'] = lang('CorporateImageFigure');
        $this -> Clanguage['SharingPreferencesSuccess'] = lang('SharingPreferencesSuccess');
        $this -> Clanguage['MapAddress'] = lang('MapAddress');
        $this -> Clanguage['Multimedia'] = lang('Multimedia');
        $this -> Clanguage['FriendVoucher'] = lang('FriendVoucher');
        $this -> Clanguage['CommunityNews'] = lang('CommunityNews');
        $this -> Clanguage['FileAttachments'] = lang('FileAttachments');
        $this -> Clanguage['PersonalImageFigure'] = lang('PersonalImageFigure');
        $this -> Clanguage['LinkInformation'] = lang('LinkInformation');
        $this -> Clanguage['OpenSignSituation'] = lang('OpenSignSituation');
        $this -> Clanguage['Email'] = lang('Email');
        $this -> Clanguage['GraphicsPhoto'] = lang('GraphicsPhoto');
        $this -> Clanguage['WebsiteURL'] = lang('WebsiteURL');
        $this -> Clanguage['PleaseLogin'] = lang('PleaseLogin');
        $this -> Clanguage['ContactInformation'] = lang('ContactInformation');
        $this -> Clanguage['InsufficientPermissions'] = lang('InsufficientPermissions');


        // helper
        $this->load->helper('url');
        
        // base_url
        $this->data['base_url'] = base_url();

        // model
        $this->load->model('exchange_model', 'mod_exchange');

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
        $m = $this->mod_exchange->select_from('member', array('member_id'=>$this->session->userdata('member_id')));

        // id on 菜單高亮處理
        $id_on_index = substr($_SERVER['REQUEST_URI'], 7);
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

    // 資料列表
    public function setting($auth_type = '')
    {
        $Clanguage = $this -> Clanguage;
        
        // 判斷帳號是否session
        if(!$this->session->userdata('member_id'))
        {   
            // 未登入
            $this->myredirect('/index/login', $Clanguage['PleaseLogin'], 5);
            return 0;
        }
        else
        {
            header('Content-Type: text/html; charset=utf-8');

            // data
            $data = $this->data;

            // language
            $this -> lang -> load('views/exchange/share', $data['lang']);
            $data['QuestionRightDescription'] = lang('QuestionRightDescription');
            $data['UseFormTopRight_1'] = lang('UseFormTopRight_1');
            $data['StoreOnly_1'] = lang('StoreOnly_1');
            $data['ChangeAllPagingCheck_2'] = lang('ChangeAllPagingCheck_2');
            $data['ApplySubAccount_2'] = lang('ApplySubAccount_2');
            $data['SettingShare_3'] = lang('SettingShare_3');
            $data['ApplySubAccount_3'] = lang('ApplySubAccount_3');
            $data['SelectCancel_4'] = lang('SelectCancel_4');
            $data['ContinueSetting_5'] = lang('ContinueSetting_5');
            $data['ShareRegistrationForm'] = lang('ShareRegistrationForm');
            $data['ShareProject'] = lang('ShareProject');
            $data['ShareImage'] = lang('ShareImage');
            $data['ShareFile'] = lang('ShareFile');
            $data['SelectAll'] = lang('SelectAll');
            $data['SelectAllPagingItems'] = lang('SelectAllPagingItems');
            $data['SharingPreferences'] = lang('SharingPreferences');
            $data['SharedProject'] = lang('SharedProject');
            $data['ShareProjectContent'] = lang('ShareProjectContent');
            $data['SwitchTabA'] = lang('SwitchTabA');
            $data['ButtonName'] = lang('ButtonName');
            $data['OriginalName'] = lang('OriginalName');
            $data['NoInformationShared'] = lang('NoInformationShared');
            $data['SetShare'] = lang('SetShare');
            $data['SetDescription'] = lang('SetDescription');
            $data['Link'] = lang('Link');
            $data['Enrollment'] = lang('Enrollment');
            $data['RemindYou'] = lang('RemindYou');
            $data['WhenSelectSave'] = lang('WhenSelectSave');
            $data['SelectSuggest'] = lang('SelectSuggest');
            $data['FileLink'] = lang('FileLink');
            $data['ClickAll'] = lang('ClickAll');
            $data['SpecialTips'] = lang('SpecialTips');

            // 檢查auth是否正確
            if($data['user_auth'] != $auth_type)
                $this->script_message($Clanguage['InsufficientPermissions'], '/business/edit');
            else
                $data['auth_type'] = $auth_type;

            if(!$this->input->post('form_submit'))
            {
				
            	$this->load->model("photo_category_model");//d_photo重取資料****************
            	$photo_list=$this->photo_category_model->get_photo_category();//******************
                // iqr
                $data['iqr'] = $iqr = $this->mod_exchange->select_from('iqr', array('member_id'=>$this->session->userdata('member_id')));

                // 自訂 tabs 分群 iqr column names are in subarray
                $data['share_groups'] = array(
                    'contact' => array(
                                    'email',
                                    'cpn_phone',
                                    'cpn_number'
                                ),
                    'social' => array(
                                    'facebook',
                                    'line',
                                    'skype'
                                ),
                    'address' => array(
                                    'address'
                                ),
                    'pages' => array(
                                    'website',
                                    'iqr_html'
                                ),
                    'uform' => array(
                                    'uform'
                                ),
                    'ecoupon' => array(
                                    'ecoupon'
                                ),
                    'media' => array(
                                    'ytb_link'
                                ),
                    'images' => array(
                    				//'d_photo',
                                    //'photo',
                                    //'cpn_photo'
                                ),
                    'files' => array(
                                    'exfile'
                                )
                );
               
                // 當 column 提供 id 資料，需要 table name 來撈值，且需要 id 名稱與 主要值 名稱
                $db_table_name  = array(
                	//'d_photo'     => 'images',
                	//'photo'     => 'images',
                    'cpn_photo' => 'images',
                    'ytb_link'  => 'strings',
                    'website'   => 'strings',
                    'address'   => 'strings',
                    'exfile'    => 'documents',
                    'uform'     => 'uform',
                    'ecoupon'   => 'ecoupon',
                    'iqr_html'  => 'iqr_html'
                );
                $db_id_col_name = array(
                	//'d_photo'     => 'img_id',
                    //'photo'     => 'img_id',
                    'cpn_photo' => 'img_id',
                    'ytb_link'  => 'str_id',
                    'website'   => 'str_id',
                    'address'   => 'str_id',
                    'exfile'    => 'doc_id',
                    'uform'     => 'ufm_id',
                    'ecoupon'   => 'ecp_id',
                    'iqr_html'  => 'html_id'
                );
                //加入tabs 分群 資料*******************
                foreach($photo_list as $key=>$val){
                	$data['share_groups']["images"][]="d_photo_".$key;
                	$db_table_name["d_photo_".$key]='images';
                	$db_id_col_name["d_photo_".$key]='img_id';
                }
                //************************************
                // share_data
                $temp_share_data = $this->mod_exchange->select_from_order('share_data', 'id', 'asc', array('member_id'=>$this->session->userdata('member_id')));
                $index = 0;
                foreach($temp_share_data as $key => $value)
                {
                	if($value['iqr_column']=="photo" || $value['iqr_column']=="cpn_photo"){//舊方式不使用了,改成自定義
                		continue;
                	}
                    // 群組 : $value['iqr_column']
                    if($value['iqr_column']=="d_photo"){//相簿拆成自定義的想簿*****************
                    	$share_data[$value['iqr_column']."_".$value['photo_category_id']]['id'][$index] = $value['id']; // 項目id, if empty then 給iqr欄位值
                    }
                    else{
                		$share_data[$value['iqr_column']]['id'][$index] = $value['id']; // 項目id, if empty then 給iqr欄位值
                    }
                    // 值
                    if($value['id'] == 0) // iqr data
                    {
                        switch ($value['iqr_column']) {
                            default:
                                $share_data[$value['iqr_column']]['value'][$index]   = $iqr[$value['iqr_column']];
                                break;
                            case 'facebook':
                                $share_data[$value['iqr_column']]['value'][$index]   = '<a class=\'aa8\' href=\''.$iqr[$value['iqr_column']].'\' target=\'_blank\'>'.$iqr[$value['iqr_column']].'</a>';
                                break;
                        }
                        $share_data[$value['iqr_column']]['btnname'][$index] = ($iqr[$value['iqr_column'].'_name'] != '') ? $iqr[$value['iqr_column'].'_name'] : $value['iqr_column'];
                        
                        if($value['iqr_column'] == 'cpn_phone' && $iqr['cpn_extension'] != '')
                            $share_data[$value['iqr_column']]['value'][$index] .= '#'.$iqr['cpn_extension'];
                        
                        // 可勾選狀態設定
                        $share_data[$value['iqr_column']]['disabled'][$index] = '';
                        if($iqr[$value['iqr_column']] == '')
                            $share_data[$value['iqr_column']]['disabled'][$index] = 'true'; // 不可勾選
                    }
                    else // id data
                    {
						// 撈出特定 id data
                    	if($value['iqr_column']=="d_photo")
                        {
                            //相簿拆成自定義的想簿*****************
                    		$id_data = $this->mod_exchange->select_from($db_table_name[$value['iqr_column']."_".$value['photo_category_id']], array($db_id_col_name[$value['iqr_column']."_".$value['photo_category_id']] => $value['id']));
                        }
                    	else
                        {
                    		$id_data = $this->mod_exchange->select_from($db_table_name[$value['iqr_column']], array($db_id_col_name[$value['iqr_column']] => $value['id']));
                    	}
						if($value['iqr_column']=="d_photo")
                        {
                            //自定義相簿
                        	$share_data[$value['iqr_column']."_".$value['photo_category_id']]['value'][$index]   = base_url().substr($id_data['img_path'], 2);
                            $share_data[$value['iqr_column']."_".$value['photo_category_id']]['btnname'][$index] = $id_data['img_note'];
						}
                        
                        
                        // special value setting
                        switch ($value['iqr_column']) {
                           /* case 'photo':
                            case 'cpn_photo':
                                $share_data[$value['iqr_column']]['value'][$index]   = base_url().substr($id_data['img_path'], 2);
                                $share_data[$value['iqr_column']]['btnname'][$index] = $id_data['img_note'];
                                break;*/
                            case 'ytb_link':
                            case 'website':
                                $share_data[$value['iqr_column']]['link'][$index]    = $id_data['str'];
                                $share_data[$value['iqr_column']]['value'][$index]   = '<a class=\'aa8\' href=\''.$id_data['str'].'\' target=\'_blank\'>'.$id_data['str'].'</a>';
                                $share_data[$value['iqr_column']]['btnname'][$index] = $id_data['str_name'];
                                break;
                            case 'address': // https://maps.google.com.tw/maps?q=
                                $share_data[$value['iqr_column']]['value'][$index]   = '<a class=\'aa8\' href=\'https://maps.google.com.tw/maps?q='.$id_data['str'].'\' target=\'_blank\'>'.$id_data['str'].'</a>';
                                $share_data[$value['iqr_column']]['btnname'][$index] = $id_data['str_name'];
                                break;
                            case 'exfile':
                                $share_data[$value['iqr_column']]['value'][$index]   = base_url().substr($id_data['doc_path'], 2);
                                $share_data[$value['iqr_column']]['btnname'][$index] = ($id_data['doc_name'] != '') ? $id_data['doc_name'] : $id_data['doc_ori_name'];
                                $share_data[$value['iqr_column']]['oriname'][$index] = $id_data['doc_ori_name'];
                                break;
                            case 'uform':
                                $share_data[$value['iqr_column']]['signup'][$index]  = '<a class=\'aa8\' href=\''.base_url().'business/uform_sign_up_show/sign_up_'.$id_data['ufm_id'].'/'.$id_data['member_id'].'\' target=\'_blank\'>'.$Clanguage['OpenSignSituation'].'</a>';;
                                $share_data[$value['iqr_column']]['btnname'][$index] = ($id_data['ufm_btn_name'] != '') ? $id_data['ufm_btn_name'] : $id_data['ufm_name'];
                                if($id_data['ufm_status'])
                                {
                                    $share_data[$value['iqr_column']]['value'][$index]    = '<a class=\'aa8\' href=\''.base_url().'form/index/'.$id_data['ufm_id'].'/'.$id_data['member_id'].'\' target=\'_blank\'>'.base_url().'form/index/'.$id_data['ufm_id'].'/'.$id_data['member_id'].'</a>';
                                    $share_data[$value['iqr_column']]['disabled'][$index] = '';
                                }
                                else // 設為不顯示
                                {
                                    $share_data[$value['iqr_column']]['value'][$index]    = '<a class=\'aa8\' href=\''.base_url().'business/eform\' target=\'_blank\'>'.$Clanguage['SetUpNotShow'].'</a>';
                                    $share_data[$value['iqr_column']]['disabled'][$index] = 'true';
                                }
                                break;
                            case 'ecoupon':
                                $share_data[$value['iqr_column']]['link'][$index]    = base_url().'business/my_ecoupon/'.$id_data['ecp_id'].'/'.$id_data['member_id'];
                                $share_data[$value['iqr_column']]['value'][$index]   = '<a class=\'aa8\' href=\''.base_url().'business/my_ecoupon/'.$id_data['ecp_id'].'/'.$id_data['member_id'].'\' target=\'_blank\'>'.$id_data['name'].'</a>';
                                $share_data[$value['iqr_column']]['btnname'][$index] = $id_data['name'];
                                break;
                            case 'iqr_html':
                                $share_data[$value['iqr_column']]['link'][$index]    = base_url().'business/html_web/'.$id_data['html_id'];
                                $share_data[$value['iqr_column']]['value'][$index]   = '<a class=\'aa8\' href=\''.base_url().'business/html_web/'.$id_data['html_id'].'\' target=\'_blank\'>'.$share_data[$value['iqr_column']]['link'][$index].'</a>';
                                $share_data[$value['iqr_column']]['btnname'][$index] = $id_data['html_name'];
                                break;
                        }
                    }
                   
                    // share checked
                    // ? unchecked : checked
                    if($value['iqr_column']=="d_photo"){//相簿拆成自定義的想簿*****************
                    	$share_data[$value['iqr_column']."_".$value['photo_category_id']]['checked'][$index] = ($value['status'] == 0) ? '' : 'checked';
                    }
                    else{
                    	$share_data[$value['iqr_column']]['checked'][$index] = ($value['status'] == 0) ? '' : 'checked';
                    }
                    $index++;
                }
                $data['share_data'] = $share_data;
                // 連結資訊 空資料判斷
                if(empty($share_data['website']) && empty($share_data['iqr_html']))
                    $data['pages_all_empty'] = true;

                // 共享項目字眼轉置
                $data['share_item_string'] = array(
                    // tabs
                    'social'        => $Clanguage['CommunityNews'],
                    'contact'       => $Clanguage['ContactInformation'],
                    'address'       => $Clanguage['MapAddress'],
                    'pages'         => $Clanguage['LinkInformation'],
                    'uform'         => '報名表單',
                    'media'         => $Clanguage['Multimedia'],
                    'images'        => $Clanguage['GraphicsPhoto'],
                    'files'         => $Clanguage['FileAttachments'],
                    'ecoupon'       => $Clanguage['FriendVoucher'],
                    // items
                    'facebook'      => 'Facebook',
                    'line'          => 'Line',
                    'skype'         => 'Skype',
                    'email'         => $Clanguage['Email'],
                    'cpn_phone'     => $Clanguage['CompanyPhone'],
                    'cpn_number'    => $Clanguage['CompanyCompiled'],
                	//'d_photo'       => '相簿',
                    //'photo'         => $PersonalImageFigure,
                    //'cpn_photo'     => $CorporateImageFigure,
                    'address'       => $Clanguage['MapAddress'],
                    'ytb_link'      => $Clanguage['YoutubeSite'],
                    'exfile'        => $Clanguage['Exfile'],
                    'website'       => $Clanguage['WebsiteURL'],
                    'iqr_html'      => $Clanguage['CustomPage']
                );
                //加入tabs 分群 資料*******************
                foreach($photo_list as $key=>$val){
                	$data['share_item_string']['d_photo_'.$key]=$val["d_name"];
                }
                //************************************

                //view
                $this->load->view('exchange/share', $data);
            }
            else
            {
                //post data
                $check_share = $this->input->post('check_share');   // 共享的資料標籤 (and id)
                foreach ($check_share as $key => $value)
                {
                    if(preg_match('/d_photo/i', $value))
                    {
                        $str = $this -> get_serialstr($value, '^#');
                        $check_share[$key] = '^#d_photo^#' . $str[1]; 
                    }
                }
                // 將全部 share data 讀出 有 post 到的 status 改 1:共享 沒的改 0:不共享
                $temp_share_data = $this->mod_exchange->select_from_order('share_data', 'id', 'asc', array('member_id'=>$this->session->userdata('member_id')));
                foreach($temp_share_data as $key => $value)
                {
                   // $share_data[] = '^#'.$value['iqr_column'].'^#'.$value['id'].'^#'.$value['photo_category_id'];
                    $share_data[] = '^#'.$value['iqr_column'].'^#'.$value['id'];
                }

                // 若有 post 到任何設為共享項目
                if(!empty($check_share))
                {
                    // tag divide
                    foreach($check_share as $key => $value)
                    {
                        $post_check_share = $this->get_serialstr($value, '^#');
                        if($post_check_share[1] != '')
                        {
                            $update_data     = array(
                                'member_id'  => $this->session->userdata('member_id'),
                                'iqr_column' => $post_check_share[0], 
                                'id'         => $post_check_share[1]
                            );
                        }
                        else
                        {
                            $update_data = array(
                                'member_id'  => $this->session->userdata('member_id'),
                                'iqr_column' => $post_check_share[0]
                            );
                        }

                        // post 到的共享項目設為 1:共享
                        $this->mod_exchange->update_where_array_set('share_data', $update_data, array('status' => 1));
                    }
                }
                else
                { // 若沒有 post 到任何共享項目，共享狀態清除為 0:不共享
                    $this->mod_exchange->update_set('share_data', 'member_id', $this->session->userdata('member_id'), array('status' => 0));
                }

                // check_share(post) 與 share_data(all) 資料差異 foreach, status 改 0:不共享
                if(empty($check_share))
                    $check_share = array();
                $diff_array = array_diff($share_data, $check_share);
                foreach($diff_array as $key => $value)
                {
                    $share_close = $this->get_serialstr($value, '^#');
                    if($share_close[1] != '')
                    {
                        $update_data     = array(
                            'member_id'  => $this->session->userdata('member_id'),
                            'iqr_column' => $share_close[0], 
                            'id'         => $share_close[1]
                        );
                    }
                    else
                    {
                        $update_data = array(
                            'member_id'  => $this->session->userdata('member_id'),
                            'iqr_column' => $share_close[0]
                        );
                    }

                    // post 到的共享項目設為 1:共享
                    $this->mod_exchange->update_where_array_set('share_data', $update_data, array('status' => 0));
                }

                // 是否預設引用 : 1 預設引用
                $default_quote = $this->input->post('default_quote');

                // member array : 取得網域中所有使用者 member_id
                $member_array = $this->mod_exchange->get_all_member_in_domain($data['domain_id']);

                // 套用到子帳戶
                if($default_quote)
                {
                    // 將 post 資料加上 member_id
                    if(!empty($check_share))
                    {
                        foreach($check_share as $key => $value)
                        {
                            $default_check_share[] .= $value.'^#'.$this->session->userdata('member_id');
                        }
                    }
                    else
                    {
                        foreach($share_data as $key => $value)
                        {
                            $default_check_share[] .= $value.'^#'.$this->session->userdata('member_id');
                        }
                    }

                    if(!empty($member_array))
                    {
                        // member id array
                        foreach($member_array  as $ma_key => $ma_value)
                        {
                            // 資料建立判斷, 當使用者未有任何引用資料時, 建立(insert)新資料, 這邊使用陣列差異(array_diff)判斷缺了哪些資料
                            $temp_quote_data = $this->mod_exchange->select_from_order('quote_data', 'id', 'asc', array('member_id'=>$ma_value));
                            if(!empty($temp_quote_data))
                            {
                                foreach($temp_quote_data as $key => $value) // quote 陣列設定
                                {
                                    $quote_data[] = '^#'.$value['iqr_column'].'^#'.$value['id'].'^#'.$this->session->userdata('member_id');
                                }
                            }
                            else
                                $quote_data = array();
                            // 差異陣列
                            $diff_array = array_diff($default_check_share, $quote_data);
                            if(!empty($diff_array)) // 有差異再新增
                            {
                                foreach($diff_array as $key => $value)
                                {
                                    $diff_array_data = $this->get_serialstr($value, '^#');

                                    if($diff_array_data[1] != '')
                                    {
                                        $inset_data      = array(
                                            'member_id'  => $ma_value,
                                            'parent'     => $this->session->userdata('member_id'), 
                                            'iqr_column' => $diff_array_data[0], 
                                            'id'         => $diff_array_data[1],
                                            'status'     => 1
                                        );
                                    }
                                    else
                                    {
                                        $inset_data      = array(
                                            'member_id'  => $ma_value,
                                            'parent'     => $this->session->userdata('member_id'), 
                                            'iqr_column' => $diff_array_data[0],
                                            'status'     => 1
                                        );
                                    }
                                    $this->mod_exchange->insert_into('quote_data', $inset_data);
                                }
                            } // 差異新增結束

                            // 非差異修改狀態
                            if(!empty($check_share))
                            {
                                // tag divide
                                foreach($check_share as $key => $value)
                                {
                                    $post_check_share = $this->get_serialstr($value, '^#');
                                    if($post_check_share[1] != '')
                                    {
                                        $update_data     = array(
                                            'member_id'  => $ma_value,
                                            'parent'     => $this->session->userdata('member_id'), 
                                            'iqr_column' => $post_check_share[0], 
                                            'id'         => $post_check_share[1]
                                        );
                                    }
                                    else
                                    {
                                        $update_data = array(
                                            'member_id'  => $ma_value,
                                            'parent'     => $this->session->userdata('member_id'), 
                                            'iqr_column' => $post_check_share[0]
                                        );
                                    }

                                    // post 到的共享項目設為 1:共享
                                    $this->mod_exchange->update_where_array_set('quote_data', $update_data, array('status' => 1));
                                }
                            }
                        }
                    }

                    // 套用不共享資料, 將被引用資料刪除
                    $diff_array = array_diff($share_data, $check_share);
                    foreach($diff_array as $key => $value)
                    {
                        $share_delete = $this->get_serialstr($value, '^#');
                        if($share_close[1] != '')
                        {
                            $delete_data     = array(
                                'parent'     => $this->session->userdata('member_id'),
                                'iqr_column' => $share_delete[0], 
                                'id'         => $share_delete[1]
                            );
                        }
                        else
                        {
                            $delete_data = array(
                                'member_id'  => $this->session->userdata('member_id'),
                                'iqr_column' => $share_delete[0]
                            );
                        }
                        $this->mod_exchange->delete_where('quote_data', $delete_data);
                    }
                }

                $this->myredirect('/share/setting/'.$auth_type, $Clanguage['SharingPreferencesSuccess'], 5);
                return 0;
            }
        }
    }
}