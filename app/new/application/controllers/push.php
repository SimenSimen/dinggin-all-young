<?php
// Push Notification
class push extends MY_Controller
{
	public $pem_path = '/var/www/vhosts/appplus.com.tw/httpdocs/sandbox', $data = '', $web_title;
    protected $domain_id, $member_id = '';

    public function __construct()//初始化
    {
        parent::__construct();
        
        // helper
        $this->load->helper('url');
        
        // base_url
        $this->data['base_url'] = base_url();

        // model
        $this->load->model('push_model', 'mod_push');

        // 使用者auth功能設定
        // if($this->session->userdata('user_auth') != '')
        //     $auth = $this->session->userdata('user_auth');
        // else
        //     $auth = $this->session->userdata('auth');
        // $this->data['user_auth'] = $auth;
        // 
        $this -> domain_id = $this -> member_id = 1;

        $this -> pem_path = dirname(dirname(dirname(__FILE__)));
    }

    // API : Add or Update Registration Token
    public function registration()
    {
        // Truly Value
        $uniqued      = $this -> input -> post('only_value');
        $device_token = $this -> input -> post('devicetoken');
        $member_id    = $this -> input -> post('member_id');
        $device_data  = $this -> mod_push -> select_from('push_device', array('uniqued' => $uniqued, 'member_id' => $member_id)); // 判斷資料是否存在
        // $logintime = time();
        // 唯一值不為空
        if($uniqued != '')
        {
            // 資料存在 : update
            if(!empty($device_data))
            {
                if($device_data['device_token'] != $device_token) // 修改
                {
                    $update_data = array(
                        'app_version'   => $this -> input -> post('appversion'),
                        'device_token'  => $device_token,
                        'model'         => $this -> input -> post('devicemodel'),
                        'version'       => $this -> input -> post('deviceversion'),
                        // 'logintime'     => $logintime,
                        'modified'      => date('Y-m-d H:i:s',time())
                    );
                    $this -> mod_push -> update_set('push_device', 'id', $device_data['id'], $update_data);
                    $result = array('result'=> 1, 'note'=> 'update success');
                }
                else
                {
                    $result = array('result'=> 1, 'note'=> 'It doesn\'t need to update the device token');
                }
            }
            else
            { // 資料不存在 : 註冊 device token 寫入
                switch ($this -> input -> post('devicesys'))
                {
                    case 'ios':
                        $device_data = array(
                            'app_version'   => $this -> input -> post('appversion'),
                            'device_token'  => $this -> input -> post('devicetoken'),
                            'model'         => $this -> input -> post('devicemodel'),
                            'version'       => $this -> input -> post('deviceversion'),
                            'sys'           => $this -> input -> post('devicesys'),
                            'uniqued'       => $this -> input -> post('only_value'),
                            'date'          => date('Y-m-d H:i:s',time()),
                            // 'logintime'     => $logintime,
                            'domain_id'		=> 1,
                            'member_id'     => $this -> input -> post('member_id'),
                            'badge'         => $this -> input -> post('badge'),
                            'alert'         => $this -> input -> post('alert'),
                            'sound'         => $this -> input -> post('sound')
                        );        
                        break;
                    
                    case 'android':
                        $device_data = array(
                            'app_version'   => $this -> input -> post('appversion'),
                            'device_token'  => $this -> input -> post('devicetoken'),
                            'model'         => $this -> input -> post('devicemodel'),
                            'version'       => $this -> input -> post('deviceversion'),
                            'sys'           => $this -> input -> post('devicesys'),
                            'uniqued'       => $this -> input -> post('only_value'),
                            'date'          => date('Y-m-d H:i:s',time()),
                            // 'logintime'     => $logintime,
                            'domain_id'		=> 1,
                            'member_id'     => $this -> input -> post('member_id'),
                        );
                        break;
                }
                $id = $this -> mod_push -> insert_into('push_device', $device_data);
                $result = array('result' => 1, 'note' => 'insert success');
            }
        }
        else
        {
            $result = array('result' => 0, 'note' => 'error, you should post an only_value');
        }
        echo json_encode($result);
    }

    // iOS Push
    public function apns($p_id)
    {
        if($this -> input -> post('message'))
        {
        	$type = $this -> input -> post('broadcasting');
        	if($type)
        	{
	            $domain_id = $this -> domain_id;
	            $member_id = $this -> member_id;
	            $devices = $this -> mod_push -> get_device_token($member_id, 'ios', $domain_id);
                $member = $this -> mod_push -> select_from('member', array('member_id' => $member_id));
	            $post_data = $this -> input -> post('title');
	        	$pem_file = $this->pem_path . $member['pem'];
	        	$push_result = $this -> apns_push($pem_file, $devices, $post_data);

	            // Push Log 
	            $log_data = array(
	                'user'          => $member_id,
	                'to'            => $member_id,
	                'multicast_id'  => $push_result['multicast_id'],
	                'success'       => $push_result['success'],
	                'failure'       => $push_result['failure'],
	                'canonical_ids' => $push_result['canonical_ids'],
	                'create_time'	=> time(),
	                'system'		=> 'ios'
	            );
	            $log_id = $this -> mod_push -> insert_into('push_request_log', $log_data);
	        }
        }
    }

    // Android Push
    public function gcm($p_id)
    {
        if($this->input->post('message'))
        {
            $type = $this -> input -> post('broadcasting');
            if($type)
        	{
	            $domain_id = $this -> domain_id;
	            $member_id = $this -> member_id;

	            $push_member = $this -> mod_push -> select_from('member', array('domain_id' => $domain_id, 'member_id' => $member_id));
	            $api_server_key = $push_member['gcm_key'];

	            // token 撈取
	            $devices = $this -> mod_push -> get_device_token($member_id, 'android', $domain_id);
	            
	            $member = $this -> mod_push -> select_from('member', array('member_id' => $member_id));
                $push_log = $this -> mod_push -> select_from('push_log', array('p_id' => $p_id));
                $image = (!empty($push_log['image'])) ? base_url() . $push_log['image'] : '';
	            $post_data = array(
	                'title'   => $this->input->post('title'),
	                'image'   => $image,
	                'message' => $this->input->post('message')
	            );
	            $push_result = $this->gcm_push($api_server_key, $devices, $post_data);
	            
	            // Push Log 
	            $log_data = array(
	                'user'          => $member_id,
	                'to'            => $member_id,
	                'multicast_id'  => $push_result['multicast_id'],
	                'success'       => $push_result['success'],
	                'failure'       => $push_result['failure'],
	                'canonical_ids' => $push_result['canonical_ids'],
	                'create_time'	=> time(),
	                'system'		=> 'android'
	            );
	            $log_id = $this->mod_push->insert_into('push_request_log', $log_data);
        	}
        }
    }
    
    // ==============================================================================================
    // GCM Initialization
    // ==============================================================================================
    
    private function gcm_push($api_server_key, $device_token_array, $message)
    {
        $this->load->library('gcm_push');

        $gcm_push = new Gcm_push($api_server_key);
        $gcm_push_result = $gcm_push->push_notification($device_token_array, $message);

        return $gcm_push_result;
    }

    // ==============================================================================================
    // APNS Initialization
    // ==============================================================================================
    
    private function apns_push($pem_file, $device_token_array, $message)
    {
        $this -> load -> library('apns_push');
    	$Apns_push = new Apns_push($pem_file);
        foreach ($device_token_array as $key => $value) {
            $Apns_push_result = $Apns_push->push_notification($value, $message);
            $success = $Apns_push_result['success'] + $success;
            $failure = $Apns_push_result['failure'] + $failure;
        }
        $Apns_push_result['success'] = $success;
        $Apns_push_result['failure'] = $failure;

        return $Apns_push_result;
    }

    // Push 紀錄列表
    public function index($page = 1)
    {
        if(!$this->session->userdata('member_id'))
        {   
            //未登入
            $this->myredirect('/index/login', '請先登入', 5);
            return 0;
        }
        else
        {
            $data = $this -> data;
            $data['push_log'] = $push_log = $this -> mod_push -> select_from_order('push_log', 'p_id', 'desc', array('member_id' => $this -> member_id, 'disable' => 'N'));

            // 換頁設定
            $page_uri   = 'push/index';
            $total_rows = count($data['push_log']);
            $per_page   = 10;
            $config     = $this -> init_pagination($page_uri, $total_rows, $per_page);

            // 排序條件
            if($this -> input -> get('ob') && $this -> input -> get('ot'))
            {
                $order_by   = $this->input->get('ob');
                $order_type = $this->input->get('ot');
            }
            else
            {
                $order_by   = 'p_id';
                $order_type = 'desc';
            }

            // 每頁資料設定
            $start_id             = (($page-1) * $per_page);
            $real_page_num        = $per_page;
            $data['page_data']    = $this -> mod_push -> get_range_data('push_log', $order_by, $order_type, $start_id, $real_page_num, array('member_id' => $this -> member_id, 'disable' => 'N'));
            $data['page_config']  = $config;
            $data['page']         = $page;
            foreach ($data['page_data'] as $key => $value)
            {
                $data['page_data'][$key]['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
                
                switch ($value['status']) {
                    case '1':
                        $data['page_data'][$key]['status'] = '已推送';
                        break;
                    
                    case '2':
                        $data['page_data'][$key]['status'] = '草稿';
                        $data['page_data'][$key]['edit'] = true;
                        break;
                    case '3':
                        $data['page_data'][$key]['status'] = '預約中';
                        break;                        
                }

                switch ($value['type']) {
                    case '0':
                        $data['page_data'][$key]['type'] = '全體';
                        break;
                    
                    default:
                        $data['page_data'][$key]['type'] = '個人';
                        break;
                }
            }

            // string replace
            $create_links=str_replace('&lsaquo;', '第一頁', $this->pagination->create_links());
            $create_links=str_replace('&rsaquo;', '最末頁', $create_links);
            $data['create_links']=$create_links;

            // push 按鈕
            // 判斷是否有接收到 token
            $data['add_push'] = false;
            $phones = $this -> mod_push -> select_from_order('push_device', 'id', 'desc');
            if(count($phones) > 0)
                $data['add_push'] = true;

            $this -> load -> view('push/push_index', $data);
        }
    }

    // 新增推播
    public function add()
    {
        if(!$this->session->userdata('member_id'))
        {   
            //未登入
            $this->myredirect('/index/login', '請先登入', 5);
            return 0;
        }
        else
        {
            $data = $this -> data;
            $member = $this -> mod_push -> select_from('member', array('member_id' => $this -> member_id));

            if(!$this -> input -> post('add'))
            {
                $data['member_id'] = $this -> member_id;
                $data['success'] = 0;
                $data['group_push'] = 1;

                // 撈取 domain 底下會員
                if($data['group_push'])
                {
                    $members = $this -> mod_push -> select_from_order('member', 'member_id', 'asc', array('domain_id' => $this -> domain_id));

                    if(!empty($members))
                    {
                        $data['show_device'] = true;

                        //延長ckeditor上傳時間
						$this->extend_ckupload_time(3600, 1, '/uploads/000/000/0000/0000000000/ckfinder_image', 00, 0);

                        foreach ($members as $key => $value)
                        {
                            $iqr = $this -> mod_push -> select_from('iqr', array('member_id' => $value['member_id']));
                            $data['device_users'][$key]['member_id'] = $value['member_id'];
                            $data['device_users'][$key]['account'] = $value['account'];
                            $data['device_users'][$key]['name'] = $iqr['l_name'] . $iqr['f_name'];
                        }
                    }
                    else
                        $data['show_device'] = false;
                }
                else
                    $data['show_device'] = false;
            }
            else
            {
                $title   = $this -> input -> post('title');
                $message = $this -> input -> post('message');
                
                // broadcasting 為 0, subordination 才有值
                $type    = $this -> input -> post('broadcasting');
                $subordination = $this -> input -> post('subordination');
                if(!empty($subordination))
                {
                    foreach ($subordination as $key => $value)
                    {
                        $to_member_id .= '*#' . $value;
                    }
                }

                $status = $this -> input -> post('status');
                $Create_time = time();

                // 會員圖檔目錄
                $img_url = '.' . $member['img_url'] . 'push/';
                if (!file_exists($img_url)) {
                    @mkdir($img_url, 0777);
                }
                if($_FILES['image']['error'] != 4)
                {
                    $this -> load -> model('upload_model', 'mod_upload');
                    $img = $this -> mod_upload -> upload_single_image($img_url, $_FILES['image']);
                    $image_path = base_url() . substr($member['img_url'], 1) . 'push/' . $img['path'];
                }

                $insert_data = array(
                	'domain_id'		=> 1,
                    'member_id'     => $this -> member_id,
                    'title'         => $title,
                    'image'         => $image_path,
                    'message'       => $message,
                    'messagebox'	=> $this -> input -> post('messagebox'),
                    'ip'            => $this -> get_realip(),
                    'create_time'   => $Create_time,
                    'type'          => $type,
                    'to_member_id'  => $to_member_id,
                    'status'        => $status,
                    'disable'       => 'N'
                );
                $p_id = $this -> mod_push -> insert_into('push_log', $insert_data);
                
                // status 1: 推送, 2: 草稿
                // type   0: 群體; 1: 個人
                switch ($type) {
                	case '0':
						// 禮拜一刪除此段，以send_time (edit_time) 為基準判斷
                		if($status == 1)
	                    	$this -> group_push($p_id);
                		break;
                	
                	case '1':
                		if($status == 1)
                		{
                			// 回傳時修改 send_time
		                	$this -> gcm($p_id);
		                    $this -> apns($p_id);
                            $this -> mod_push -> update_set('push_log', 'p_id', $p_id, array('send_time' => $Create_time));
                		}
                		break;
                }
                $data['success'] = 1;
                $this -> script_message_close('推送成功');
            }
            $this -> load -> view('push/push_add', $data);
        }
    }

    // 推播修改 未完成
    public function edit($p_id, $suc = "")
    {
        if(!$this->session->userdata('member_id'))
        {   
            //未登入
            $this->myredirect('/index/login', '請先登入', 5);
            return 0;
        }
        else
        {
            $data = $this -> data;
            $data['push'] = $this -> mod_push -> select_from('push_log', array('p_id' => $p_id));
            if(empty($data['push']))
            	$this -> script_message_close('非法連結');

            if(!$this -> input -> post('add'))
            {
                $data['member_id'] = $this -> member_id;
                $data['success'] = 0;
                $data['group_push'] = $this -> data['web_config']['group_push'];

                // 撈取 domain 底下會員
                if($this->data['user_auth'] == '01' && $data['group_push'])
                {
                    $members = $this -> mod_push -> select_from_order('member', 'member_id', 'asc', array('domain_id' => $this -> domain_id));
                    if(!empty($members))
                    {
                        $data['show_device'] = true;
                        
                        $to_member_array = $this -> get_serialstr($data['push']['to_member_id'], '*#');
                        foreach ($members as $key => $value)
                        {
                            if($value['push'])
                            {
                                $iqr = $this -> mod_push -> select_from('iqr', array('member_id' => $value['member_id']));
                                $data['device_users'][$key] = $value;
                                $data['device_users'][$key]['name'] = $iqr['l_name'] . $iqr['f_name'];
                    			$data['device_users'][$key]['selected'] = in_array($value['member_id'], $to_member_array) ? 'selected' : '';
                            }
                        }
                    }
                    else
                        $data['show_device'] = false;
                }
                else
                    $data['show_device'] = false;
            }
            else
            {
                $title   = $this -> input -> post('title');
                $message = $this -> input -> post('message');
                
                // broadcasting 為 0, subordination 才有值
                $type    = $this -> input -> post('broadcasting');
                $subordination = $this -> input -> post('subordination');
                if(!empty($subordination))
                {
                    foreach ($subordination as $key => $value)
                    {
                        $to_member_id .= '*#' . $value;
                    }
                }

                $status = $this -> input -> post('status');
                $Edit_time = time();

                // 會員圖檔目錄
                $member = $this -> mod_push -> select_from('member', array('member_id' => $this -> member_id));
                $img_url = '.' . $member['img_url'] . 'push/';
                if (!file_exists($img_url))
                {
                    @mkdir($img_url, 0777);
                }
                if($_FILES['new_image']['error'] != 4 && !empty($_FILES['new_image']))
                {
                    $this -> load -> model('upload_model', 'mod_upload');
                    $img = $this -> mod_upload -> upload_single_image($img_url, $_FILES['new_image']);
                    $image_path = base_url() . substr($member['img_url'], 1) . 'push/' . $img['path'];
                    
                    if($this-> input -> post('image'))
                    {
                    	$old_img = explode(base_url(), $data['push']['image']);
                    	unlink($old_img[1]);
                    }
                }
                else
                {
                	$image_path = $this -> input -> post('image');
                }

                $update_data = array(
                    'domain_id'     => $this -> domain_id,
                    'member_id'     => $this -> member_id,
                    'title'         => $title,
                    'image'         => $image_path,
                    'message'       => $message,
                    'messagebox'    => $this -> input -> post('messagebox'),
                    'ip'            => $this -> get_realip(),
                    'create_time'   => $Edit_time,
                    'type'          => $type,
                    'to_member_id'  => $to_member_id,
                    'status'        => $status,
                    'disable'       => 'N'
                );
                $id = $this -> mod_push -> update_set('push_log', 'p_id', $p_id, $update_data);

                // status 1: 推送, 2: 草稿
                // type   0: 群體; 1: 個人
                switch ($type) {
                    case '0':
                        if($status == 1)
                            $this -> group_push($p_id);
                        break;
                    
                    case '1':
                        if($status == 1)
                        {
                            // 回傳時修改 send_time
                            $this -> gcm($p_id);
                            $this -> apns($p_id);
                        }
                        break;
                }
                $data['success'] = 1;
            }
            $this -> load -> view('push/push_edit', $data);
        }
    }

    // 背景推播
    private function group_push($p_id)
    {
    	if($p_id != "")
    	{
	    	$push_log = $this -> mod_push -> select_from('push_log', array('p_id' => $p_id, 'type' => '0'));
			$writer = $push_log['member_id'];

	        $to_member_array = $this -> get_serialstr($push_log['to_member_id'], '*#');
	    	if(!empty($to_member_array))
	    	{
		    	$num = count($to_member_array);
		    	foreach ($to_member_array as $key => $value)
		    	{
		    		$to_member = $this -> mod_push -> select_from('member', array('member_id' => $value));
		    		$gcm_key = $to_member['gcm_key'];
		    		$pem_key = $this -> pem_path . $to_member['pem'];
		    		$member_id = $to_member['member_id'];
	    			$fp = popen("php ".dirname(__FILE__)."/robot.php $gcm_key $member_id $pem_key $writer $p_id > /dev/null &",'r');
	                // read popen
	                // $read = fread($fp, 2096);
	                // print_r($read);
	                pclose($fp);
		    	}
		    	$this -> mod_push -> update_set('push_log', 'p_id', $p_id, array('send_time' => $push_log['create_time']));
	    	}
	    }
    }

    public function group($p_id)
    {
        if($p_id != "")
        {
            $push_log = $this -> mod_push -> select_from('push_log', array('p_id' => $p_id, 'type' => '0'));
            $writer = $push_log['member_id'];

            $to_member_array = $this -> get_serialstr($push_log['to_member_id'], '*#');
            if(!empty($to_member_array))
            {
                $num = count($to_member_array);
                foreach ($to_member_array as $key => $value)
                {
                    $to_member = $this -> mod_push -> select_from('member', array('member_id' => $value));
                    $gcm_key = $to_member['gcm_key'];
                    $pem_key = $this -> pem_path . $to_member['pem'];
                    $member_id = $to_member['member_id'];
                    $fp = popen("php ".dirname(__FILE__)."/robot.php $gcm_key $member_id $pem_key $writer $p_id > /dev/null &",'r');
                    // read popen
                    // $read = fread($fp, 2096);
                    // print_r($read);
                    pclose($fp);
                }
                $this -> mod_push -> update_set('push_log', 'p_id', $p_id, array('send_time' => $push_log['create_time']));
            }
        }
    }

    // 推播匣列表
    public function push_list()
    {
        $member_id = $this -> input -> get('member_id');
        // App_Timer 當前開啟時間
        $App_Timer = $this -> input -> get('time_stamp');
        $App_token = $this -> input -> get('token');

        $member = $this -> mod_push -> select_from('member', array('member_id' => $member_id));
        $device = $this -> mod_push -> select_from('push_device', array('device_token' => $App_token, 'member_id' => $member_id));
        if(!empty($device['logintime']) && !empty($App_Timer) && $App_token)
        {
            $Sever_Timer = $device['logintime'];
            $push_lists  = $this -> mod_push -> select_timer_between('push_log', $member_id, $Sever_Timer, $App_Timer);
            
            if(!empty($push_lists))
            {
                foreach ($push_lists as $key => $value)
                {
                    $encoder_messagebox = $this -> mod_push -> encoder($value['messagebox']);
                    $_return[$key] = array(
                        'p_id'       => $value['p_id'],
                        'title'      => $value['title'],
                        'messagebox' => $encoder_messagebox,
                        'disable'    => $value['disable']
                    );
                }
            }
            else
                $_return = array('empty Info');

            $this -> mod_push -> update_set('push_device', 'device_token', $App_token, array('logintime' => $App_Timer));
        }
        else if(!empty($device))
        {
            $this -> mod_push -> update_set('push_device', 'device_token', $App_token, array('logintime' => $App_Timer));
            $_return = array('empty Info');
        }
        else
        	$_return = array('format error');

        echo json_encode($_return);
    }

    // Ajax 回傳，刪除 Push 紀錄
    public function del_push_log()
    {
        $del_id = $this -> input -> post('p_id');
        $mode   = $this -> input -> post('mode');
        $timer  = time();
        $once_push_log = $this -> mod_push -> select_from('push_log', array('p_id' => $del_id));
        if($mode == "0" && !empty($once_push_log))
        {
            $update_data = array(
                'delete_time' => $timer,
                'disable'     => 'Y',
            );
            $update_id = $this -> mod_push -> update_set('push_log', 'p_id', $del_id, $update_data);
            
            if(!empty($once_push_log['image']))
            {
	            $del_image = explode(base_url(), $once_push_log['image']);
	            unlink($del_image[1]);
	        }
            
            echo $update_id;
        }
        else
            echo false;
    }

    // 點閱率(click through rate) API
    public function CTR($p_id, $type = '', $num = '')
    {
        if($type == '')
            $log_id = $this -> mod_push -> push_log_views('add', array('p_id' => $p_id));
        else
            $log_id = $this -> mod_push -> push_log_views('update', array('p_id' => $p_id), $num);
        if(empty($log_id))
            $result = array('Add Views Success');
        else
            $result = array('Add Views Fail');
        
        echo json_encode($result);
    }

    public function R($p_id, $back_page)
    {
        if (isset($p_id))
        {
            $push_log = $this -> mod_push -> select_from('push_log', array('p_id' => $p_id));
            
            if ($push_log['type'] == '0') {
               $to_member = $this -> get_serialstr($push_log['to_member_id'], '*#');
               $push_log['member_name'] = $this -> mod_push -> get_member_name($to_member);
            } else {
                $iqr = $this -> mod_push -> select_from('iqr', array('member_id' => $push_log['type']));
                $push_log['member_name'] = $iqr['l_name'] . $iqr['f_name'];
            }
            $data['page'] = $back_page;
            $data['push_log'] = $push_log;
            $this -> load -> view('push' .DIRECTORY_SEPARATOR. 'push_R', $data);
        }
        else {
            $this -> script_message('Error Format', '/push/index');
        }
    }
}