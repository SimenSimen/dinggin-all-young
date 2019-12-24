<?php
class Appui extends MY_Controller
{
    public $data     = '';
    public $language = '';
    public function __construct()//初始化
    {
        parent::__construct();

        // helper
        $this->load->helper('url');

        // language
        // $this -> load -> helper('language');
        if(!$this -> session -> userdata('lang'))
        {
            $this -> session -> set_userdata('lang', 'TW');
            $this -> data['lang'] = $this -> session -> userdata('lang');
        }
        else
            $this -> data['lang'] = $this -> session -> userdata('lang');

        if($this->session->userdata('lang')=='zh-tw')
            $this -> session -> set_userdata('lang', 'TW');

        // $this -> lang -> load('views/business/edit', $this -> data['lang']);
      
        // language_top
        $this -> load -> model('language_model', 'mod_language');
        $lang = $this -> mod_language -> converter('999', $this -> session -> userdata('lang'));
        $this -> data = array_merge($this -> data, $lang);

        $lang = $this -> mod_language -> converter('9', $this -> session -> userdata('lang'));
        $this -> data = array_merge($this -> data, $lang);

        // base_url
        $this->data['base_url'] = base_url();

        // model
        $this->load->model('appui_model', 'mod_appui');

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
        $m = $this->mod_appui->select_from('member', array('member_id'=>$this->session->userdata('member_id')));

        //id on 菜單高亮處理
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

    //-----------------------------------------------------------------------------------
    // 函數名：download()
    // 作 用 ：Android下載介面
    // 參 數 ：
    // 返回值：
    // 備 注 ：
    //-----------------------------------------------------------------------------------
    public function download($member_id)
    {

        // data
        $data = $this->data;

        @session_start();
        $this->setlang = (!empty($_SESSION['LA'])) ? $_SESSION['LA']['lang'] : 'TW';
        //語言包設置
        $this->load->model('lang_model',lmodel);
        //語言包
        $lang=$this->lmodel->config('27',$this->setlang);
        $data['ActionBusinessSystems_1'] = $lang['ActionBusinessSystems_1'];
        $data['AppDownload'] = $lang['AppDownload'];
        $data['RemindYouAndroid'] = $lang['RemindYouAndroid'];
        $data['ClickDownloadAndroid'] = $lang['ClickDownloadAndroid'];

        // member data
        $member = $this->mod_appui->select_from('member', array('member_id'=>$member_id));

        // iqr
        $iqr = $this->mod_appui->select_from('iqr', array('member_id'=>$member_id));

        //url
        $data['download_url'] = base_url().substr($member['img_url'], 1).'app/'.$member['account'].'-android.apk';
        $data['download_app_name'] = $member['account'].'-android.apk';

        //icon
        $dirname = '.'.$member['img_url'].'icon/';
        $icon = glob($dirname."icon.png", GLOB_BRACE);//{*.gif,*.jpg,*.jpeg,*.png,*.GIF,*.JPG,*.PNG}
        if(!is_file($icon[0]) || $iqr['icon_status'] == 0)
            $data['download_icon'] = '/images/web_style_images/'.$data['web_banner_dir'].'/app_welcome_page/icon.png';
        else
            $data['download_icon'] = substr($icon[0], 1);

        //view
        $this->load->view('appui/download', $data);
    }

    //-----------------------------------------------------------------------------------
    // 函數名：build()
    // 作 用 ：自動打包介面
    // 參 數 ：
    // 返回值：
    // 備 注 ：
    //-----------------------------------------------------------------------------------
    public function build()
    {

        $data=$this->data;
        $lang = $this -> mod_language -> converter('10', $this -> session -> userdata('lang'));
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
            $data['iqr']=$iqr=$this->mod_appui->select_from('iqr', array('member_id'=>$this->session->userdata('member_id')));

            //member
            $member=$this->mod_appui->select_from('member', array('member_id'=>$this->session->userdata('member_id')));

            $data['control_setting'] = $this -> mod_appui -> select_from('control_setting', array('domain_id' => $member['domain_id']));
            $data['index'][] = $data['IqrIndex'];
            $data['index'][] = $data['CartIndex'];
            $data['index_selected'][$member['app_index']] = 'selected';


            //沒收到post顯示編輯頁面
            if(!$this->input->post('form_submit'))
            {
                //helper
                $this->load->helper('form');

                $data['mid'] = $this->session->userdata('member_id');

                //update app
                if($iqr['apk'] == 2 || $iqr['apk'] == 0)
                {
                    $data['app_update_class']['apk'] = 'app_updating';
                    $data['apk_update_text'] = $data['AndroidUpdating'];
                }
                else
                {
                    $data['app_update_class']['apk'] = 'app_updated';
                    $data['apk_update_text'] = $data['AndroidUpdated'];
                }
                if($iqr['ipa'] == 2 || $iqr['ipa'] == 0)
                {
                    $data['app_update_class']['ios'] = 'app_updating';
                    $data['ios_update_text'] = $data['IosUpdating'];
                }
                else
                {
                    $data['app_update_class']['ios'] = 'app_updated';
                    $data['ios_update_text'] = $data['IosUpdated'];
                }

                //icon
                $dirname = '.'.$member['img_url'].'icon/';
                $img_s_array = array('icon', 'a_wp', 'i_wp_0', 'i_wp_1');
                foreach($img_s_array as $key => $value)
                {
                    ${$value} = glob($dirname.'{'.$value.'.png}', GLOB_BRACE);//"{*.gif,*.jpg,*.jpeg,*.png,*.GIF,*.JPG,*.PNG}"
                    // 預設狀態變更
                    if(!is_file(${$value}[0]) || $iqr[$value.'_status'] == 0)
                    {
                        $data[$value] = '/images/web_style_images/'.$data['web_banner_dir'].'/app_welcome_page/'.$value.'.png';
                        $data[$value.'_checked'] = 'checked';
                    }
                    else
                    {
                        $data[$value] = substr(${$value}[0], 1);
                        $data[$value.'_checked'] = '';
                    }
                }

                //view
                $this->load->view('appui/build', $data);
            }
            else
            {//寫入編輯資料
                //model
                $this->load->model('upload_model', 'mod_upload');

                //會員圖檔目錄
                $member_id=$this->session->userdata('member_id');
                $img_url='.'.$member['img_url'];

                //新增_FILES
                //圖檔上傳
                if(!empty($_FILES))
                {
                    $img_s_array = array(
                        'icon'   => array('w' => 512, 'h' => 512),
                        'a_wp'   => array('w' => 480, 'h' => 760),
                        'i_wp_0' => array('w' => 640, 'h' => 960),
                        'i_wp_1' => array('w' => 640, 'h' => 1136)
                    );
                    foreach($_FILES as $key => $value)
                    {
                        if($value['error'] != 4)
                        {
                            $image_info = $this->mod_upload->upload_png($value, $img_url, $key, $img_s_array[$key]['w'], $img_s_array[$key]['h']);
                            ${$key.'_status'} = 1;
                        }
                        else
                        { // 使用預設圖示
                            if($this->input->post($key.'_status') == 'on')
                                ${$key.'_status'} = 0;
                            else
                            {
                                $dirname = $img_url.'icon/';
                                ${$key} = glob($dirname.$key.'.png', GLOB_BRACE); //{*.png,*.PNG}
                                if(!is_file(${$key}[0]))
                                    ${$key.'_status'} = 0;
                                else
                                    ${$key.'_status'} = 1;
                            }
                        }
                    }
                }
                $iqr_edit = array(
                    'l_name'            => $this->input->post('l_name'),
                    'f_name'            => $this->input->post('f_name'),
                    'icon_status'       => $icon_status,
                    'a_wp_status'       => $a_wp_status,
                    'i_wp_0_status'     => $i_wp_0_status,
                    'i_wp_1_status'     => $i_wp_1_status
                );
                // $this->arr_print('iqr_edit', $iqr_edit);
                $iqr_edit_result=$this->mod_appui->update_set('iqr', 'member_id', $member_id, $iqr_edit);
                $member_result = $this -> mod_appui -> update_set('member', 'member_id', $member_id , array('app_index' => $this -> input -> post('app_index')));
                if($icon_status == 0)
                    $upset_data = $this -> mod_appui -> update_set('application_shelves', 'member_id', $member_id, array('shelf_HD_url' => 'images/web_style_images/default/app_welcome_page/icon.png'));
                else
                {
                    $member['img_url'] = str_ireplace('/uploads', 'uploads', $member['img_url']);
                    $icon_path = $member['img_url'].'icon/icon.png';
                    $upset_data = $this -> mod_appui -> update_set('application_shelves', 'member_id', $member_id, array('shelf_HD_url' => $icon_path));
                }

                // APP 更新狀態變更
                if($iqr['apk'] != 2 || $iqr['ipa'] != 2)
                {
                    $app_updata = 1;

                    if($this->input->post('l_name') != $iqr['l_name'])//姓
                        $app_updata = 2;
                    if($this->input->post('f_name') != $iqr['f_name'])//名
                        $app_updata = 2;
                    if($this->input->post('app_index') != $member['app_index'])
                        $app_updata = 2;
                    if(!empty($_FILES))
                    {
                        foreach($_FILES as $key => $value)
                        {
                            if($value['error'] != 4)
                                $app_updata = 2;
                        }
                    }
                    // images
                    $img_s_array = array('icon', 'a_wp', 'i_wp_0', 'i_wp_1');
                    foreach($img_s_array as $key => $value)
                    {
                        $status = ($this->input->post($value.'_status') == 'on') ? 0 : 1;
                        // 預設狀態變更
                        if($status != $iqr[$value.'_status'])
                            $app_updata = 2;
                    }

                    //update
                    $app_updata_result=$this->mod_appui->update_set('iqr', 'member_id', $member_id, array('apk'=>$app_updata, 'ipa'=>$app_updata));
                }

                //導向
                $this->myredirect('/appui/build', $data['EditSuccess'], 5);
                return 0;
            }
        }
    }

    //-----------------------------------------------------------------------------------
    // 函數名：release()
    // 作 用 ：申請上架
    // 參 數 ：
    // 返回值：
    // 備 注 ：
    //-----------------------------------------------------------------------------------
    public function release()
    {
        $data = $this -> data;
        $lang = $this -> mod_language -> converter('11', $this -> session -> userdata('lang'));
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
            $user = $this->session->userdata('member_id');

            $member           = $this -> mod_appui -> select_from("member", array("member_id" => $user));
            $data['iqr']      = $this -> mod_appui -> select_from('iqr',array('member_id' => $user));
            $data['shelf']    = $this -> mod_appui -> select_from('application_shelves', array('member_id' => $user));
            // del submit
            $del_mobile1  = $this -> input -> post('del_mobile1');
            $del_mobile2  = $this -> input -> post('del_mobile2');
            $del_mobile3  = $this -> input -> post('del_mobile3');
            $del_mobile4  = $this -> input -> post('del_mobile4');
            $del_mobile5  = $this -> input -> post('del_mobile5');
            $del_topic    = $this -> input -> post('del_topic');

            $icon_size = getimagesize('./'.$data['shelf']['shelf_HD_url']);
            if($icon_size[0] != 512 || $icon_size[1] != 512)
                $data['icon_size'] = 1;
            else
                $data['icon_size'] = 0;

            $data['type'][] = $data['PleaseSelect'];
            $data['type'][] = $data['Tools'];
            $data['type'][] = $data['Weather'];
            $data['type'][] = $data['Life'];
            $data['type'][] = $data['Production'];
            $data['type'][] = $data['Transportation'];
            $data['type'][] = $data['Social'];
            $data['type'][] = $data['MusicSound'];
            $data['type'][] = $data['Personal'];
            $data['type'][] = $data['Entertainment'];
            $data['type'][] = $data['Travel'];
            $data['type'][] = $data['Finance'];
            $data['type'][] = $data['Fitness'];
            $data['type'][] = $data['Business'];
            $data['type'][] = $data['Education'];
            $data['type'][] = $data['Communication'];
            $data['type'][] = $data['MediaVideo'];
            $data['type'][] = $data['LibrariesProbationProgram'];
            $data['type'][] = $data['NewsMagazines'];
            $data['type'][] = $data['Movement'];
            $data['type'][] = $data['BooksResources'];
            $data['type'][] = $data['Cartoon'];
            $data['type'][] = $data['Shopping'];
            $data['type'][] = $data['Health'];
            $data['type'][] = $data['Photography'];

            $data['type_selected'][$data['shelf']['type']] = 'selected';


            if($this -> input -> post('save_data'))
            {
                //data

                $path   = "upload_android/".$user;

                // 路徑存在
                if(is_dir($path))
                {
                }
                else // 路徑不存在，新增
                {
                    mkdir($path);
                }
                if($_FILES['mobile1']['error']!= 4)
                {
                    if($_FILES['mobile1'])
                    {
                        $file1 = $this -> mod_appui -> upload_pic($_FILES['mobile1'], './'.$path.'/','capture1');
                        $file1['path'] = str_ireplace('./', '', $file1['path']);
                    }
                    else
                    {
                        $file1['path'] = $data['shelf']['shelf_capture_url1'];
                    }
                }

                if($_FILES['mobile2']['error']!= 4)
                {
                    if($_FILES['mobile2'])
                    {
                        $file2 = $this -> mod_appui -> upload_pic($_FILES['mobile2'], './'.$path.'/','capture2');
                        $file2['path'] = str_ireplace('./', '', $file2['path']);
                    }
                    else
                    {
                        $file2['path'] = $data['shelf']['shelf_capture_url2'];
                    }
                }
                if($_FILES['mobile3']['error']!= 4)
                {
                    if($_FILES['mobile3'])
                    {
                        $file3 = $this -> mod_appui -> upload_pic($_FILES['mobile3'], './'.$path.'/','capture3');
                        $file3['path'] = str_ireplace('./', '', $file3['path']);
                    }
                    else
                    {
                        $file3['path'] = $data['shelf']['shelf_capture_url3'];
                    }
                }
                if($_FILES['mobile4']['error']!= 4)
                {
                    if($_FILES['mobile4'])
                    {
                        $file4 = $this -> mod_appui -> upload_pic($_FILES['mobile4'], './'.$path.'/','capture4');
                        $file4['path'] = str_ireplace('./', '', $file4['path']);
                    }
                    else
                    {
                        $file4['path'] = $data['shelf']['shelf_capture_url4'];
                    }
                }
                if($_FILES['mobile5']['error']!= 4)
                {
                    if($_FILES['mobile5'])
                    {
                        $file5 = $this -> mod_appui -> upload_pic($_FILES['mobile5'], './'.$path.'/','capture5');
                        $file5['path'] = str_ireplace('./', '', $file5['path']);
                    }
                    else
                    {
                        $file5['path'] = $data['shelf']['shelf_capture_url5'];
                    }
                }
                if($data['iqr']['icon_status'] == 0 )
                {
                    $quantity['path'] = 'images/web_style_images/'.$data['web_banner_dir'].'/app_welcome_page/icon.png';
                }
                else
                {
                    $quantity['path'] = $member['img_url'].'icon/icon.png';
                }
                if($_FILES['topic']['error']!= 4)
                {
                    if($_FILES['topic'])
                    {
                        $topic = $this -> mod_appui -> upload_pic($_FILES['topic'], './'.$path.'/','topic');
                        $topic['path'] = str_ireplace('./', '', $topic['path']);
                    }
                    else
                    {
                        $topic['path'] = $data['shelf']['shelf_topic_url'];
                    }
                }

                $shelf_edit = array(
                        'shelf_name'            => $data['iqr']['l_name'].$data['iqr']['f_name'],
                        'shelf_brief'           => $this -> input -> post('brief_r'),
                        'shelf_description'     => $this -> input -> post('description_r'),
                        'shelf_capture_url1'    => $file1['path'],
                        'shelf_capture_url2'    => $file2['path'],
                        'shelf_capture_url3'    => $file3['path'],
                        'shelf_capture_url4'    => $file4['path'],
                        'shelf_capture_url5'    => $file5['path'],
                        'shelf_topic_url'       => $topic['path'],
                        'type'                  => $this -> input -> post('type')
                );
                $shelf_edit_result = $this -> mod_appui -> update_set('application_shelves', 'member_id', $user, $shelf_edit);
                $this -> script_message('儲存成功', '/appui/release');
            }

            if($del_mobile1 || $del_mobile2 || $del_mobile3 || $del_mobile4 || $del_mobile5 || $del_quantity || $del_topic)
            {

                if($del_mobile1)
                {
                    $file_path = $data['shelf']['shelf_capture_url1'];
                    $file_path = str_ireplace('upload_android', './upload_android', $file_path);
                    $db_shelf  = array('shelf_capture_url1' => NULL);
                    $this -> del_picture($file_path, $db_shelf);
                }
                elseif($del_mobile2)
                {
                    $file_path = $data['shelf']['shelf_capture_url2'];
                    $file_path = str_ireplace('upload_android', './upload_android', $file_path);
                    $db_shelf  = array('shelf_capture_url2' => NULL);
                    $this -> del_picture($file_path, $db_shelf);
                }
                elseif($del_mobile3)
                {
                    $file_path = $data['shelf']['shelf_capture_url3'];
                    $file_path = str_ireplace('upload_android', './upload_android', $file_path);
                    $db_shelf  = array('shelf_capture_url3' => NULL);
                    $this -> del_picture($file_path, $db_shelf);
                }
                elseif($del_mobile4)
                {
                    $file_path = $data['shelf']['shelf_capture_url4'];
                    $file_path = str_ireplace('upload_android', './upload_android', $file_path);
                    $db_shelf  = array('shelf_capture_url4' => NULL);
                    $this -> del_picture($file_path, $db_shelf);
                }
                elseif($del_mobile5)
                {
                    $file_path = $data['shelf']['shelf_capture_url5'];
                    $file_path = str_ireplace('upload_android', './upload_android', $file_path);
                    $db_shelf  = array('shelf_capture_url5' => NULL);
                    $this -> del_picture($file_path, $db_shelf);
                }
                // elseif($del_quantity)
                // {
                //     $file_path = $data['shelf']['shelf_HD_url'];
                //     $file_path = str_ireplace('upload_android', './upload_android', $file_path);
                //     $db_shelf  = array('shelf_HD_url' => NULL);
                //     $this -> del_picture($file_path, $db_shelf);
                // }
                elseif($del_topic)
                {
                    $file_path = $data['shelf']['shelf_topic_url'];
                    $file_path = str_ireplace('upload_android', './upload_android', $file_path);
                    $db_shelf = array('shelf_topic_url' => NULL);
                    $this -> del_picture($file_path, $db_shelf);
                }
            }

            if($this -> input -> post('upload'))
            {
                $apk         = base_url().$member['img_url'].'app/'.$member['account'].'-android.apk';
                $account     = $member['account'];
                $name        = $data['shelf']['shelf_name'];
                $brief       = $data['shelf']['shelf_brief'];
                $description = $data['shelf']['shelf_description'];
                $mobile1     = base_url().$data['shelf']['shelf_capture_url1'];
                $mobile2     = base_url().$data['shelf']['shelf_capture_url2'];
                $mobile3     = base_url().$data['shelf']['shelf_capture_url3'];
                $mobile4     = base_url().$data['shelf']['shelf_capture_url4'];
                $mobile5     = base_url().$data['shelf']['shelf_capture_url5'];
                $quantity    = base_url().$data['shelf']['shelf_HD_url'];
                $topic       = base_url().$data['shelf']['shelf_topic_url'];

                switch ($data['shelf']['type']) {
                    case 1:  $type = $data['Tools'];                        break;
                    case 2:  $type = $data['Weather'];                      break;
                    case 3:  $type = $data['Life'];                         break;
                    case 4:  $type = $data['Production'];                   break;
                    case 5:  $type = $data['Transportation'];               break;
                    case 6:  $type = $data['Social'];                       break;
                    case 7:  $type = $data['MusicSound'];                   break;
                    case 8:  $type = $data['Personal'];                     break;
                    case 9:  $type = $data['Entertainment'];                break;
                    case 10: $type = $data['Travel'];                       break;
                    case 11: $type = $data['Finance'];                      break;
                    case 12: $type = $data['Fitness'];                      break;
                    case 13: $type = $data['Business'];                     break;
                    case 14: $type = $data['Education'];                    break;
                    case 15: $type = $data['Communication'];                break;
                    case 16: $type = $data['MediaVideo'];                   break;
                    case 17: $type = $data['LibrariesProbationProgram'];    break;
                    case 18: $type = $data['NewsMagazines'];                break;
                    case 19: $type = $data['Movement'];                     break;
                    case 20: $type = $data['BooksResources'];               break;
                    case 21: $type = $data['Cartoon'];                      break;
                    case 22: $type = $data['Shopping'];                     break;
                    case 23: $type = $data['Health'];                       break;
                    case 24: $type = $data['Photography'];                  break;
                }

                $instore = $this -> mod_appui -> update_set('member', 'member_id', $user, array('instore' => 1));
                $this -> mail($apk, $account, $name, $brief, $description, $mobile1, $mobile2, $quantity, $topic, $mobile3, $mobile4, $mobile5, $type);
            }

            $this -> load -> view('appui/h_upload', $data);
        }
    }

    public function del_picture($path, $shelf)
    {
        $language = $this -> language;
        $update = $this -> mod_appui -> update_set('application_shelves', 'member_id', $this -> session -> userdata('member_id'), $shelf);
        unlink($path);

        $this -> script_message($language['DeleteSuc'],'/appui/release');
    }

    private function mail($apk, $account, $name, $brief, $description, $phone_pic1, $phone_pic2, $quantity_pic, $main_pic, $phone_pic3, $phone_pic4, $phone_pic5, $type)
    {
        $data = $this->data;


        // 寄信通知訂單紀錄
        // 主旨
        $subject = date('Y-m-d',time()).'-'.$account.'的上架申請';

        // 內容
        $message =  '<p>有一筆上架申請：</p>'.
                    '<p><hr></p>'.
                    '<p><h3>上架資訊</h3></p>'.
                    '<p>名稱(APP名稱)：'.$name.'</p>'.
                    '<p>簡短說明：'.$brief.'</p>'.
                    '<p>完整說明：'.$description.'</p>'.
                    '<p>APK 下載網址：'.$apk.'</p>'.
                    '<p>手機畫面圖片(一) 網址：'.$phone_pic1.'</p>'.
                    '<p>手機畫面圖片(二) 網址：'.$phone_pic2.'</p>'.
                    '<p>手機畫面圖片(三) 網址：'.$phone_pic3.'</p>'.
                    '<p>手機畫面圖片(四) 網址：'.$phone_pic4.'</p>'.
                    '<p>手機畫面圖片(五) 網址：'.$phone_pic5.'</p>'.
                    '<p>高解析圖示 網址：'.$quantity_pic.'</p>'.
                    '<p>主題圖片 網址：'.$main_pic.'</p>'.
                    '<p>應用程式類型：應用程式</p>'.
                    '<p>類別：'.$type.'</p>'.
                    '<p>內容分級：自行選擇</p>'
        ;

        $message .= '<p><hr></p>'.
                    "<p>注意：本郵件是由系統自動產生與發送，請勿直接回覆。</p>";

        // 寄信
        $this->mod_appui->send_mail($data['host']['domain'], $data['host']['company'], 'liang@netnews.com.tw', $subject, $message);
        $this->mod_appui->send_mail($data['host']['domain'], $data['host']['company'], 'manager@netnews.com.tw', $subject, $message);
        $this->mod_appui->send_mail($data['host']['domain'], $data['host']['company'], 'alice@netnews.com.tw', $subject, $message);

        $this -> script_message('送出成功','/appui/release');
    }

    //-----------------------------------------------------------------------------------
    // 函數名：release_setting()
    // 作 用 ：上架後網址設定
    // 參 數 ：
    // 返回值：
    // 備 注 ：
    //-----------------------------------------------------------------------------------
    public function release_setting($success = '')
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
            // data
            $data = $this->data;

            // member
            $member = $this->mod_appui->select_from('member', array('member_id'=>$this->session->userdata('member_id')));

            // 是否允許設定上架網址
            if($member['instore'])
            {
                //沒收到post顯示編輯頁面
                if(!$this->input->post('form_submit'))
                {
                    if($success)
                        $data['success'] = $success;

                    // 行動名片資料
                    $data['iqr'] = $iqr = $this->mod_appui->select_from('iqr', array('member_id'=>$this->session->userdata('member_id')));

                    //view
                    $this->load->view('appui/release_setting', $data);
                }
                else
                {
                    $update_data = array(
                        'apk_release' => $this->input->post('apk_release'),
                        'ipa_release' => $this->input->post('ipa_release')
                    );
                    $this->mod_appui->update_set('iqr', 'iqr_id', $this->input->post('iqr_id'), $update_data);

                    //導向
                    $this->myredirect('/appui/release_setting/1', $language['EditSuccess'], 5);
                    return 0;
                }
            }
            else
            {
                // 沒有權限
                $this->script_message($language['NotApplyAdded'], '/appui/release');
                return 0;
            }
        }
    }

    //-----------------------------------------------------------------------------------
    // 函數名：notification()
    // 作 用 ：申請推播
    // 參 數 ：
    // 返回值：
    // 備 注 ：
    //-----------------------------------------------------------------------------------
    public function notification()
    {
    }
}