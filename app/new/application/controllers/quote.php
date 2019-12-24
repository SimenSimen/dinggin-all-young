<?php
// 引用設定
class Quote extends MY_Controller
{
    public $data='';
    public $language='';

    public function __construct()//初始化
    {
        parent::__construct();

        // helper
        $this->load->helper('url');
    

        // language
        $this -> load -> helper('language');
        if(!$this -> session -> userdata('lang'))
            $this -> data['lang'] = $this -> session -> set_userdata('lang', 'zh-tw');
        else
            $this -> data['lang'] = $this -> session -> userdata('lang');
        $this -> lang -> load('controllers/quote', $this -> data['lang']);
        $ReferenceSet = lang('ReferenceSet');
        $SharingPreferences = lang('SharingPreferences');
        $this -> language['YoutubeSite'] = lang('YoutubeSite');
        $this -> language['SetUpNotShow'] = lang('SetUpNotShow');
        $this -> language['CompanyCompiled'] = lang('CompanyCompiled');
        $this -> language['CompanyPhone'] = lang('CompanyPhone');
        $this -> language['ReferenceSetSuccess'] = lang('ReferenceSetSuccess');
        $this -> language['CorporateImageFigure'] = lang('CorporateImageFigure');
        $this -> language['MapAddress'] = lang('MapAddress');
        $this -> language['Multimedia'] = lang('Multimedia');
        $this -> language['FriendVoucher'] = lang('FriendVoucher');
        $this -> language['CustomPages'] = lang('CustomPages');
        $this -> language['CommunityNews'] = lang('CommunityNews');
        $this -> language['FileAttachments'] = lang('FileAttachments');
        $this -> language['PersonalImageFigure'] = lang('PersonalImageFigure');
        $this -> language['LinkInformation'] = lang('LinkInformation');
        $this -> language['OpenSignSituation'] = lang('OpenSignSituation');
        $this -> language['Email'] = lang('Email');
        $this -> language['ElectronicElegiac'] = lang('ElectronicElegiac');
        $this -> language['GraphicsPhoto'] = lang('GraphicsPhoto');
        $this -> language['WebsiteURL'] = lang('WebsiteURL');
        $this -> language['PleaseLogin'] = lang('PleaseLogin');
        $this -> language['ContactInformation'] = lang('ContactInformation');
        $this -> language['InsufficientPermissions'] = lang('InsufficientPermissions');
        // language_business_header
        $this -> lang -> load('views/business/edit', $this -> data['lang']);

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
        // base_url
        $this->data['base_url'] = base_url();

        // model
        $this->load->model('exchange_model', 'mod_exchange');
        $this->load->model("photo_category_model");//d_photo重取資料****************
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
                    $auth_title = $SharingPreference;

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
                    $auth_title = $SharingPreference;

                    break;

                case '02': // 第二層

                    $auth_cols_1  = '<a href="/middle/setting/'.$auth.'/share" title="'.$SharingPreferences.'" alt="'.$SharingPreferences.'" style="width: '.$this->data['menu_width'].'; font-size:16px;">'.$SharingPreferences.'</a>';
                    $auth_title_1 = $SharingPreference;
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
        $language = $this -> language;
        // 判斷帳號是否session
        if(!$this->session->userdata('member_id'))
        {   
            // 未登入
            $this->myredirect('/index/login', $language['PleaseLogin'], 5);
            return 0;
        }
        else
        {
            header('Content-Type: text/html; charset=utf-8');

            // data
            $data = $this->data;

            $this -> lang -> load('views/exchange/quote', $data['lang']);
            $data['UseFormTopRight_1'] = lang('UseFormTopRight_1');
            $data['ChangeAllPagingCheck_2'] = lang('ChangeAllPagingCheck_2');
            $data['SettingReferences_3'] = lang('SettingReferences_3');
            $data['CheckRegistrationForm'] = lang('CheckRegistrationForm');
            $data['CheckProject'] = lang('CheckProject');
            $data['CheckImage'] = lang('CheckImage');
            $data['CheckFile'] = lang('CheckFile');
            $data['ReferenceSet'] = lang('ReferenceSet');
            $data['ReferenceProjects'] = lang('ReferenceProjects');
            $data['ReferenceProjectsContent'] = lang('ReferenceProjectsContent');
            $data['SelectAll'] = lang('SelectAll');
            $data['NoAnyLibrary'] = lang('NoAnyLibrary');
            $data['SwitchTabB'] = lang('SwitchTabB');
            $data['NoInformationQuote'] = lang('NoInformationQuote');
            $data['ButtonName'] = lang('ButtonName');
            $data['OriginalName'] = lang('OriginalName');
            $data['SetQuote'] = lang('SetQuote');
            $data['Link'] = lang('Link');
            $data['RemindYou'] = lang('RemindYou');
            $data['FileLink'] = lang('FileLink');
            $data['ClickAll'] = lang('ClickAll');
            $data['SelectAllItems'] = lang('SelectAllItems');
            
            // 檢查auth是否正確
            if($data['user_auth'] != $auth_type)
                $this->script_message($language['InsufficientPermissions'], '/business/edit');
            else
                $data['auth_type'] = $auth_type;

            if(!$this->input->post('form_submit'))
            {
                // root array : 取得網域中所有管理者 member_id
                $root_array = $this->mod_exchange->get_all_root_in_domain($data['domain_id']);

                $photo_list=$this->photo_category_model->get_auth_photo_category($root_array[0]);//******************

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
                                    // 'photo',
                                    // 'cpn_photo'
                                ),
                    'files' => array(
                                    'exfile'
                                )
                );

                // 當 column 提供 id 資料，需要 table name 來撈值，且需要 id 名稱與 主要值 名稱
                $db_table_name  = array(
                    // 'photo'     => 'images',
                    // 'cpn_photo' => 'images',
                    'ytb_link'  => 'strings',
                    'website'   => 'strings',
                    'address'   => 'strings',
                    'exfile'    => 'documents',
                    'uform'     => 'uform',
                    'ecoupon'   => 'ecoupon',
                    'iqr_html'  => 'iqr_html'
                );
                $db_id_col_name = array(
                    // 'photo'     => 'img_id',
                    // 'cpn_photo' => 'img_id',
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
                
                // root array
                $index = 0;
                foreach($root_array  as $ra_key => $ra_value)
                {
                    // iqr
                    $data['iqr'] = $iqr = $this->mod_exchange->select_from('iqr', array('member_id'=>$ra_value));

                    // exchange data setting
                    $temp_share_data = $this->mod_exchange->select_from_order('share_data', 'id', 'asc', array('member_id'=>$ra_value, 'status'=>1));
                    if(!empty($temp_share_data))
                    {
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
                                // 撈出引用預設狀態
                                $default_quote = array(
                                    'member_id'  => $this->session->userdata('member_id'), 
                                    'parent'     => $ra_value, 
                                    'iqr_column' => $value['iqr_column']
                                );
                                $quote_data = $this->mod_exchange->select_from('quote_data', $default_quote);

                                switch ($value['iqr_column']) {
                                    default:
                                        $share_data[$value['iqr_column']]['value'][$index] = $iqr[$value['iqr_column']];
                                        break;
                                    case 'facebook':
                                        $share_data[$value['iqr_column']]['link'][$index]  = $iqr[$value['iqr_column']];
                                        $share_data[$value['iqr_column']]['value'][$index] = '<a class=\'aa8\' href=\''.$iqr[$value['iqr_column']].'\' target=\'_blank\'>'.$iqr[$value['iqr_column']].'</a>';
                                        break;
                                }
                                $share_data[$value['iqr_column']]['btnname'][$index] = ($iqr[$value['iqr_column'].'_name'] != '') ? $iqr[$value['iqr_column'].'_name'] : $value['iqr_column'];
                                        
                                if($value['iqr_column'] == 'cpn_phone' && $iqr['cpn_extension'] != '')
                                    $share_data[$value['iqr_column']]['value'][$index] .= '#'.$iqr['cpn_extension'];
                        
                            }
                            else // id data
                            {
                                // 撈出引用預設狀態
                                $default_quote = array(
                                    'member_id'  => $this->session->userdata('member_id'), 
                                    'parent'     => $ra_value, 
                                    'iqr_column' => $value['iqr_column'], 
                                    'id'         => $value['id']
                                );
                                $quote_data = $this->mod_exchange->select_from('quote_data', $default_quote);

                                // 撈出特定 id data
                                // $id_data = $this->mod_exchange->select_from($db_table_name[$value['iqr_column']], array($db_id_col_name[$value['iqr_column']] => $value['id']));

                                // 撈出特定 id data
                                if($value['iqr_column']=="d_photo"){//相簿拆成自定義的想簿*****************
                                //echo $value["photo_category_id"].$db_table_name[$value['iqr_column']."_".$value['photo_category_id']]."1<BR>";
                                    $id_data = $this->mod_exchange->select_from($db_table_name[$value['iqr_column']."_".$value['photo_category_id']], array($db_id_col_name[$value['iqr_column']."_".$value['photo_category_id']] => $value['id']));
                                }
                                else{//echo $db_table_name[$value['iqr_column']]."2<BR>";
                                    $id_data = $this->mod_exchange->select_from($db_table_name[$value['iqr_column']], array($db_id_col_name[$value['iqr_column']] => $value['id']));
                                }
                                

                                // special value setting
                                switch ($value['iqr_column']) {
                                    // case 'photo':
                                    // case 'cpn_photo':
                                    //     $share_data[$value['iqr_column']]['value'][$index]   = base_url().substr($id_data['img_path'], 2);
                                    //     $share_data[$value['iqr_column']]['btnname'][$index] = $id_data['img_note'];
                                    //     break;
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
                                        $share_data[$value['iqr_column']]['signup'][$index]  = '<a class=\'aa8\' href=\''.base_url().'business/uform_sign_up_show/sign_up_'.$id_data['ufm_id'].'/'.$id_data['member_id'].'\' target=\'_blank\'>'.$OpenSignSituation.'</a>';
                                        $share_data[$value['iqr_column']]['btnname'][$index] = ($id_data['ufm_btn_name'] != '') ? $id_data['ufm_btn_name'] : $id_data['ufm_name'];
                                        if($id_data['ufm_status'])
                                        {
                                            $share_data[$value['iqr_column']]['value'][$index]    = '<a class=\'aa8\' href=\''.base_url().'form/index/'.$id_data['ufm_id'].'/'.$id_data['member_id'].'\' target=\'_blank\'>'.base_url().'form/index/'.$id_data['ufm_id'].'/'.$id_data['member_id'].'</a>';
                                            $share_data[$value['iqr_column']]['disabled'][$index] = '';
                                        }
                                        else // 設為不顯示
                                        {
                                            $share_data[$value['iqr_column']]['value'][$index]    = '<a class=\'aa8\' href=\''.base_url().'business/eform\' target=\'_blank\'>'.$language['SetUpNotShow'].'</a>';
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

                            // 父 member_id
                            if($value['iqr_column']=="d_photo"){//自定義相簿
                                $share_data[$value['iqr_column']."_".$value['photo_category_id']]['value'][$index]   = base_url().substr($id_data['img_path'], 2);
                                $share_data[$value['iqr_column']."_".$value['photo_category_id']]['btnname'][$index] = $id_data['img_note'];
                                $share_data[$value['iqr_column']."_".$value['photo_category_id']]['parent'][$index]  = $ra_value;
                            }
                            else
                                $share_data[$value['iqr_column']]['parent'][$index]  = $ra_value;

                            // share checked
                            // ? unchecked : checked
                            // $share_data[$value['iqr_column']]['checked'][$index] = ($quote_data['status'] == 0) ? '' : 'checked';
                            if($value['iqr_column']=="d_photo"){//相簿拆成自定義的想簿*****************
                                $share_data[$value['iqr_column']."_".$value['photo_category_id']]['checked'][$index] = ($quote_data['status'] == 0) ? '' : 'checked';
                            }
                            else{
                                $share_data[$value['iqr_column']]['checked'][$index] = ($quote_data['status'] == 0) ? '' : 'checked';
                            }
                            $index++;
                        }
                    }
                }
                $data['share_data'] = $share_data;
                // 聯絡資訊 空資料判斷
                if(empty($share_data['email']) && empty($share_data['cpn_phone']) && empty($share_data['cpn_number']))
                    $data['contact_all_empty'] = true;

                // 社群資訊 空資料判斷
                if(empty($share_data['facebook']) && empty($share_data['line']) && empty($share_data['skype']))
                    $data['social_all_empty'] = true;

                // 連結資訊 空資料判斷
                if(empty($share_data['website']) && empty($share_data['iqr_html']))
                    $data['pages_all_empty'] = true;

                // 共享項目字眼轉置
                $data['share_item_string'] = array(
                    // tabs
                    'social'        => $language['CommunityNews'],
                    'contact'       => $language['ContactInformation'],
                    'address'       => $language['MapAddress'],
                    'pages'         => $language['LinkInformation'],
                    'uform'         => $language['ElectronicElegiac'],
                    'media'         => $language['Multimedia'],
                    'images'        => $language['GraphicsPhoto'],
                    'files'         => $language['FileAttachments'],
                    'ecoupon'       => $language['FriendVoucher'],
                    // items
                    'facebook'      => 'Facebook',
                    'line'          => 'Line',
                    'skype'         => 'Skype',
                    'email'         => $language['Email'],
                    'cpn_phone'     => $language['CompanyPhone'],
                    'cpn_number'    => $language['CompanyCompiled'],
                    // 'photo'         => '個人形象圖',
                    // 'cpn_photo'     => '企業形象圖',
                    'address'       => $language['MapAddress'],
                    'ytb_link'      => $language['YoutubeSite'],
                    'exfile'        => $language['FileAttachments'],
                    'website'       => $language['WebsiteURL'],
                    'iqr_html'      => $language['CustomPages']
                );
                 //加入tabs 分群 資料*******************
                foreach($photo_list as $key=>$val){
                    $data['share_item_string']['d_photo_'.$key]=$val["d_name"];
                }
                //************************************
                //view
                $this->load->view('exchange/quote', $data);
            }
            else
            {
                //post data
                $check_quote = $this->input->post('check_quote'); // 共享的資料標籤 (and id)
                foreach ($check_quote as $key => $value)
                {
                    if(preg_match('/d_photo/i', $value))
                    {
                        $str = $this -> get_serialstr($value, '^#');
                        $check_quote[$key] = '^#d_photo^#' . $str[1] . '^#' . $str[2]; 
                    }
                }
                // 資料建立判斷, 當使用者未有任何引用資料時, 建立(insert)新資料, 這邊使用陣列差異(array_diff)判斷缺了哪些資料
                $temp_quote_data = $this->mod_exchange->select_from_order('quote_data', 'id', 'asc', array('member_id'=>$this->session->userdata('member_id')));
                if(!empty($temp_quote_data))
                {
                    foreach($temp_quote_data as $key => $value) // quote 陣列設定
                    {
                        $quote_data[] = '^#'.$value['iqr_column'].'^#'.$value['id'].'^#'.$value['parent'];
                    }
                }
                else
                    $quote_data = array();
                $diff_array = array_diff($check_quote, $quote_data); // 差異
                if(!empty($diff_array)) // 有差異再新增
                {
                    foreach($diff_array as $key => $value)
                    {
                        $diff_array_data = $this->get_serialstr($value, '^#');

                        if($diff_array_data[1] != '')
                        {
                            $inset_data      = array(
                                'member_id'  => $this->session->userdata('member_id'),
                                'parent'     => $diff_array_data[2],
                                'iqr_column' => $diff_array_data[0], 
                                'id'         => $diff_array_data[1],
                                'status'     => 0
                            );
                        }
                        else
                        {
                            $inset_data      = array(
                                'member_id'  => $this->session->userdata('member_id'),
                                'parent'     => $diff_array_data[2],
                                'iqr_column' => $diff_array_data[0],
                                'status'     => 0
                            );
                        }
                        $this->mod_exchange->insert_into('quote_data', $inset_data);
                    }
                } // 差異新增結束

                // 將全部 quote data 讀出 有 post 到的 status 改 1:共享 沒的改 0:不共享
                if(!empty($check_quote)) // 若有 post 到任何設為共享項目
                {
                    // tag divide
                    foreach($check_quote as $key => $value)
                    {
                        $post_check_quote = $this->get_serialstr($value, '^#');
                        if($post_check_quote[1] != '')
                        {
                            $update_data     = array(
                                'member_id'  => $this->session->userdata('member_id'),
                                'parent'     => $post_check_quote[2],
                                'iqr_column' => $post_check_quote[0], 
                                'id'         => $post_check_quote[1]
                            );
                        }
                        else
                        {
                            $update_data = array(
                                'member_id'  => $this->session->userdata('member_id'),
                                'parent'     => $post_check_quote[2],
                                'iqr_column' => $post_check_quote[0]
                            );
                        }

                        // post 到的共享項目設為 1:共享
                        $this->mod_exchange->update_where_array_set('quote_data', $update_data, array('status' => 1));
                    }
                }
                else
                { // 若沒有 post 到任何共享項目，共享狀態清除為 0:不共享
                    $this->mod_exchange->update_set('quote_data', 'member_id', $this->session->userdata('member_id'), array('status' => 0));
                }

                // check_share(post) 與 share_data(all) 資料差異 foreach, status 改 0:不共享
                $diff_array = array_diff($quote_data, $check_quote);
                foreach($diff_array as $key => $value)
                {
                    $quote_close = $this->get_serialstr($value, '^#');
                    if($quote_close[1] != '')
                    {
                        $update_data     = array(
                            'member_id'  => $this->session->userdata('member_id'),
                            'iqr_column' => $quote_close[0], 
                            'id'         => $quote_close[1]
                        );
                    }
                    else
                    {
                        $update_data = array(
                            'member_id'  => $this->session->userdata('member_id'),
                            'iqr_column' => $quote_close[0]
                        );
                    }

                    // post 到的共享項目設為 1:共享
                    $this->mod_exchange->update_where_array_set('quote_data', $update_data, array('status' => 0));
                }

                $this->myredirect('/quote/setting/'.$auth_type, $language['ReferenceSetSuccess'], 5);
                return 0;
            }
        }
    }
}