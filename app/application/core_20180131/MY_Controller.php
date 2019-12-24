<?
//-----------------------------------------------------------------------------------
// 1. get_host_config 		取得網域配置資訊
// 2. get_web_config 		取得網站公共變數
// 3. check_deadline		判斷使用期限
// 4. set_web_banner_dir	設定banner使用的資料夾
// 5. deal_with_index_page	判斷原始網址不包含index.php的話就導向錯誤頁面
// 6. myredirect			倒數轉址頁面
// 7. db_lang				讀取資料庫語系
//    import_xls 			匯入excel
// 8. export_xls			產生excel
// 9. get_device_type		檢查開啟網頁裝置
// 10.get_device_os 		檢查開啟網頁作業系統
// 11.get_realip			取得真實ip
// 12.remove_html_tag		移除文字內容最外層tag
// 13.arr_print				顯示陣列值
// 14.http_check			檢查url是否包含http://
// 15.set_serialstr			字元陣列串接
// 16.get_serialstr			字串還原陣列
// 17.random_vcode			產生隨機n碼作為驗證碼
// 18.random_num_code		產生隨機n碼作為卡號
// 19.random_key			產生隨機金鑰
// 20.make_vcode_img		產生驗證碼圖形
// 21.get_direct_file 		取得資料夾底下所有檔案
// 22.random_num 			產生隨機數字碼
// 23.calc_directory_size 	計算資料夾容量大小
// 24.rounding_up 			無條件進值某整數到整值
// 25.my_mail_to 			寄信
// 26.init_facebook_sdk 	初始化facebook函式庫
// 27.icurl 				發送 curl 請求
// 28.script_message 		跳出提示訊息, (及)轉跳
// 29.init_pagination 		分頁設定值初始化
// 30.extend_ckupload_time	延長ckeditor上傳時間
// 31.curlpost 				發送 curl post 請求
// 33.check_extend_name		上傳文件的副檔名判斷 
// 34.script_message_close  跳出提示訊息, (及)關閉視窗
//----------------------------------------------------------------------------------- 
class MY_Controller extends CI_Controller {
	public function __construct()
	{
		parent::__construct();

		$this->load->library('session'); //library
		$this->load->model('index_model', 'mod_index'); //model
		$this->load->model('business_model', 'mod_business');
		
	    $this->deal_with_index_page(); //判斷原始網址不包含index.php的話就導向錯誤頁面
	    
		date_default_timezone_set('Asia/Taipei'); 		 //timezone
        header('Access-Control-Allow-Origin: *'); 		 // mac
		header("Content-Type:text/html; charset=utf-8"); //亂碼

		$this->load->model('/MyModel/mymodel');	
		$this -> load -> model('views_model', 'mod_views');
        $this->load->model('lang_model',lmodel);

		//語言包設置
        @session_start();
		$this->setlang=(!empty($_SESSION['lang']))?$_SESSION['lang']:'ENG';
        $this -> set_language = $this->setlang = (!empty($_SESSION['LA'])) ? $_SESSION['LA']['lang'] : 'ENG';

		//語言包
		$this->lang_menu=$this->lmodel->config('1',$this->setlang);

		//語言抓取
		$this->lang_list=$this->mymodel->select_page_form('language_type','','d_title,d_code',array('d_enable'=>'Y'));

		$this->product_type=$this->mymodel->productsType();
		
		// session_start();
		// if($_SESSION['bulletin']==''){
		// 	$_SESSION['bulletin']=1;
		// 	echo "<script>alert('2016年8月18日台北時間下午2:00 - 17:00將進行系統升級作業，升級期間系統將暫停服務，造成不便懇請見諒！');</script>";
		// }
	}

	//----------------------------------------------------------------------------------- 
	// 編號	 ：1
	// 函數名：get_host_config()
	// 作 用 ：取得網域配置資訊
	// 參 數 ：無
	// 返回值：網域配置資訊
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
    protected function get_host_config()
    {
		//www檢查
		if(($pos = strpos($_SERVER['SERVER_NAME'], 'www')) !== false)
		{
			$SERVER_NAME = substr($_SERVER['SERVER_NAME'], 4);
		}
		else
		{
			$SERVER_NAME = $_SERVER['SERVER_NAME'];

			// 59.125.75.222:8023
			// $SERVER_NAME = $_SERVER['HTTP_HOST'];
		}

    	//database doamin資訊
		$host_data=$this->mod_index->select_from('domain', array('domain'=>$SERVER_NAME));
		if(empty($host_data) && $SERVER_NAME == 'eoneda.appplus.com.tw')
		{//由母網域登入
			$host_data=array(
				'domain_id' => 0,
				'domain'	=> $SERVER_NAME
			);
		}
		else if(empty($host_data))
		{//不是由母網登入，database卻找不到doamin資訊
			$host_data=array(
				'domain_id' => -1,
				'domain'	=> null
			);
		}

		return $host_data;
    }

	//----------------------------------------------------------------------------------- 
	// 編號	 ：2
	// 函數名：get_web_config()
	// 作 用 ：取得網站公共變數
	// 參 數 ：$domain_id 目前操作的domain_id
	// 返回值：公共變數陣列web_config
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
    protected function get_web_config($domain_id)
    {
    	$web_config = $this->mod_index->select_from('control_setting', array('domain_id'=>$domain_id));
    	
    	if($domain_id == 0)
	    {//母網設定檔
	    	$web_config['logo']  = '/images/logo.gif';
			$web_config['title'] = '管理系統';
	    }

        return $web_config;
    }

	//----------------------------------------------------------------------------------- 
	// 編號	 ：3
	// 函數名：check_deadline($web_config, $mid)
	// 作 用 ：判斷使用期限
	// 參 數 ：$web_config 網站配置檔
	// mid 會員id
	// 返回值：布林值 0 到期
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
    public function check_deadline($web_config, $mid)
    {
    	//member
    	$m = $this->mod_index->select_from('member', array('member_id'=>$mid));

    	//期限
    	$deadline=($web_config['g_deadline_status'] == 0) ? $m['deadline'] : $web_config['global_deadline'] ; //期限
		$minutes=round(($deadline - time()) / 60); //期限分數

		if($minutes > 0)
			return 1;
		else
			return 0;
    }	

	//----------------------------------------------------------------------------------- 
	// 編號	 ：4
	// 函數名：set_web_banner_dir()
	// 作 用 ：設定banner使用的資料夾
	// 參 數 ：$domain_id 網域設定檔
	// $web_banner 資料夾狀態：0 => 預設, 1 => 域名
	// $domain 偵測網域
	// 返回值：網域配置資訊
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
    protected function set_web_banner_dir($domain_id, $web_banner, $domain)
    {
		//www檢查
		if(($pos = strpos($_SERVER['SERVER_NAME'], 'www')) !== false)
		{
			$SERVER_NAME = substr($_SERVER['SERVER_NAME'], 4);
		}
		else
		{
			$SERVER_NAME = $_SERVER['SERVER_NAME'];
		}
		
		//狀態判斷
		if($web_banner == 0 || $domain == 'eoneda.appplus.com.tw')
		{//使用預設背景
			return 'default';
		}
		else
		{
			if($SERVER_NAME == 'eoneda.appplus.com.tw')
			{//由母網域登入
				$host_data=$this->mod_index->select_from('domain', array('domain_id'=>$domain_id));
				return $host_data['domain'];
			}
			else
			{//不是由母網登入
				return $SERVER_NAME;
			}
		}
    }

	//----------------------------------------------------------------------------------- 
	// 編號	 ：5
	// 函數名：deal_with_index_page()
	// 作 用 ：判斷原始網址不包含index.php的話就導向錯誤頁面
	// 參 數 ：無
	// 返回值：無
	// 備 注 ：條件成立將導向
	//----------------------------------------------------------------------------------- 
    protected function deal_with_index_page()
    {
        $uri = $this->input->server('REQUEST_URI',true);
        //deal with index.php
        if(strpos($uri, 'index.php')!==false)
        {
            $this->load->helper('url');
            redirect('/error/');
        }
    }

	//----------------------------------------------------------------------------------- 
	// 編號	 ：6
	// 函數名：myredirect($url, $info, $_second)
	// 作 用 ：倒數轉址頁面
	// 參 數 ：$url 導向網址
	// $info 顯示文字
	// $second 倒數秒數
	// 返回值：無
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	public function myredirect($url, $info, $_second)
	{
		$data=$this->data;

		//helper
		$this->load->helper('url');

		$data['base_url'] = base_url();	//設定本站網址
		$data['url']      = $url;		//轉向網址
		$data['info']     = $info;		//顯示文字
		$data['second']   = $_second;	//讀秒秒數

		$this->load->view('myredirect', $data);
	}

	//----------------------------------------------------------------------------------- 
	// 編號	 ：7
	// 函數名：db_lang()
	// 作 用 ：讀取資料庫語系
	// 參 數 ：無
	// 返回值：無
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	public function db_lang()
	{
		$this->load->database();
		$query = $this->db->get('lang_list');
		return $query->result_array();
	}

	//----------------------------------------------------------------------------------- 
	// 編號	 ：
	// 函數名：import_xls($path)
	// 作 用 ：匯入excel
	// 參 數 ：$path excel路徑
	// 返回值：excel中內容
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	public function import_xls($path)
	{
	    // 載入PHPExcel外掛
		$this->load->library('PHPExcel/oleread');
		$this->load->library('PHPExcel/Spreadsheet_Excel_Reader');

	    // 創建Spreadsheet_Excel_Reader對象
		$excel_obj = new Spreadsheet_Excel_Reader();

	    // 設定編碼
		$excel_obj->setOutputEncoding('UTF-8');

	    // 檔案路徑
		$excel_obj->read($path);

		return $excel_obj->sheets[0];
	}

	//----------------------------------------------------------------------------------- 
	// 編號	 ：8
	// 函數名：export_xls($title_array='', $data_array='', $filename)
	// 作 用 ：產生excel
	// 參 數 ：無
	// 返回值：無
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	public function export_xls($title_array='', $data_array='', $filename)
	{
	    // 清空輸出緩沖區
	    ob_clean();

	    //欄位矩陣
	    $row_n=array(
	    	'0'=>'A', '1'=>'B', '2'=>'C', '3'=>'D', '4'=>'E',
	    	'5'=>'F', '6'=>'G', '7'=>'H', '8'=>'I', '9'=>'J',
	    	'10'=>'K', '11'=>'L', '12'=>'M', '13'=>'N', '14'=>'O',
	    	'15'=>'P', '16'=>'Q', '17'=>'R', '18'=>'S', '19'=>'T',
	    	'20'=>'U', '21'=>'V', '22'=>'W', '23'=>'X', '24'=>'Y', '25'=>'Z'
	    );
	    
	    // 載入PHPExcel類庫
	    $this->load->library('PHPExcel');
	    $this->load->library('PHPExcel/IOFactory');
	    
	    // 創建PHPExcel對象
	    $objPHPExcel = new PHPExcel();
	    
	    // 設置excel文件屬性描述
	    $objPHPExcel->getProperties()
	                ->setTitle("reports")
	                ->setDescription("")
	                ->setCreator("wepower");
	    
	    // 設置當前工作表
	    $objPHPExcel->setActiveSheetIndex(0);
	   
	    // 設置表頭
	    foreach($title_array as $key => $value)
		{
			$fields[] = $value;
		}
	    
	    // 列編號從0開始，行編號從1開始
	    $col = 0;
	    $row = 1;
	    foreach($fields as $key => $field)
	    {
	    	//$objPHPExcel->getActiveSheet()->getColumnDimension($key)->setAutoSize(true);
	        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $field);
	        $col++;
	    }
	    
	    // 從第二行開始輸出數據內容
	    $row = 2;
	    foreach ($data_array as $key => $value)
		{
			foreach ($value as $pdkey => $pdvalue)
			{
				$objPHPExcel->getActiveSheet()->getColumnDimension($row_n[$pdkey])->setWidth(20);//->setAutoSize(true);
				//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($pdkey, $row, $row_n[$pdkey]);
				$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($pdkey, $row)->setValueExplicit($pdvalue, PHPExcel_Cell_DataType::TYPE_STRING);
			}
	        $row++;
		}
	    
	    //輸出excel文件
	    $objPHPExcel->setActiveSheetIndex(0);
	    
	    // 設置HTTP頭
	    header('Content-Type: application/vnd.ms-excel; charset=utf-8');
	    header('Content-Disposition: attachment;filename="'.mb_convert_encoding($filename, "Big-5", "UTF-8").'.xls"');
	    header('Cache-Control: max-age=0');
	    
	    // 第二個參數可取值：CSV、Excel5(生成97-2003版的excel)、Excel2007(生成2007版excel)
	    $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
	    $objWriter->save('php://output');
	}

	//----------------------------------------------------------------------------------- 
	// 編號	 ：9
	// 函數名：get_device_type()
	// 作 用 ：檢查開啟網頁裝置
	// 參 數 ：無
	// 返回值：若>=1則為行動裝置
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	public function get_device_type()
	{
		$mobile_browser = '0';

		if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|Android|iPhone|iPad|iPod)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
		{
		    $mobile_browser++;
		}
		 
		if((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml')>0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE']))))
		{
		    $mobile_browser++;
		}    
		 
		$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));
		$mobile_agents = array(
		    'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
		    'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
		    'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
		    'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
		    'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
		    'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
		    'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
		    'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
		    'wapr','webc','winw','winw','xda','xda-','Googlebot-Mobile');
		 
		if(in_array($mobile_ua,$mobile_agents))
		{
		    $mobile_browser++;
		}
		 
		if (strpos(strtolower($_SERVER['ALL_HTTP']),'OperaMini')>0)
		{
		    $mobile_browser++;
		}
		 
		if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows')>0)
		{
			$mobile_browser=0;
		}

		return $mobile_browser;
	}

	//----------------------------------------------------------------------------------- 
	// 編號	 ：10
	// 函數名：get_device_os()
	// 作 用 ：檢查開啟網頁作業系統
	// 參 數 ：無
	// 返回值：裝置系統名稱
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	public function get_device_os()
	{
		$device = '';

		if(preg_match('/(Android)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
		    $device = 'android';
		}
		else if(preg_match('/(iPhone|iPad|iPod)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
		    $device = 'ios';
		}
		else if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows')>0) {
		    $device = 'windows';
		}

		return $device;
	}
	//確認是否為ipad
	public function check_ipad()
	{
		$device = '';

		if(preg_match('/(iPad)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
		    return 1;
		}
		else
		{
		    return 0;
		}
	}

	//----------------------------------------------------------------------------------- 
	// 編號	 ：11
	// 函數名：get_realip()
	// 作 用 ：取得真實ip
	// 參 數 ：無
	// 返回值：Client端真實ip
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	public function get_realip()
	{
		if($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"])
		{
			$ip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
		}
		elseif($HTTP_SERVER_VARS["HTTP_CLIENT_IP"])
		{
			$ip = $HTTP_SERVER_VARS["HTTP_CLIENT_IP"];
		}
		elseif ($HTTP_SERVER_VARS["REMOTE_ADDR"])
		{
			$ip = $HTTP_SERVER_VARS["REMOTE_ADDR"];
		}
		elseif (getenv("HTTP_X_FORWARDED_FOR"))
		{
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		}
		elseif (getenv("HTTP_CLIENT_IP"))
		{
			$ip = getenv("HTTP_CLIENT_IP");
		}
		elseif (getenv("REMOTE_ADDR"))
		{
			$ip = getenv("REMOTE_ADDR");
		}
		else
		{
			$ip = "Unknown";
		}
		return $ip;
	}

	//----------------------------------------------------------------------------------- 
	// 編號	 ：12
	// 函數名：remove_html_tag()
	// 作 用 ：移除文字內容最外層tag
	// 參 數 ：無
	// 返回值：去除外層tag後的文字內容
	// 備 注 ：常用於CKEditor送出的內容自動加在外層的<p></p>
	//----------------------------------------------------------------------------------- 
	public function remove_html_tag($str)
	{
		if($str != '')
		{
			$temp_content = $str;
			$pos_p1 = strpos($temp_content, '>');
			$temp   = substr ($temp_content, $pos_p1+1);
			$pos_p2 = strrpos($temp, '<');
			$rest   = substr ($temp, 0, $pos_p2);
			return $rest;
		}
		else
		{
			return '';
		}
	}
	
	//----------------------------------------------------------------------------------- 
	// 編號	 ：13
	// 函數名：arr_print($name, $data, $ip)
	// 作 用 ：顯示陣列值
	// 參 數 ：$name 變數名稱
	// $data 變數陣列內容
	// $ip 用ip限制列印只給我看
	// 返回值：無
	// 備 注 ：無 
	//----------------------------------------------------------------------------------- 
	public function arr_print($name, $data, $ip)
	{
		if($ip == $this->get_realip())
		{
			echo "<h3>".$name."</h3>";
			echo "<PRE>";
			print_r($data);
			echo "</PRE>";
		}
	}
	
	//----------------------------------------------------------------------------------- 
	// 編號	 ：14
	// 函數名：http_check($temp_url)
	// 作 用 ：檢查url是否包含http://
	// 參 數 ：$temp_url 原始網址
	// 返回值：修正後的網址
	// 備 注 ：無 
	//----------------------------------------------------------------------------------- 
	public function http_check($temp_url)
	{
		if (false !== ($pos = strpos($temp_url, "https://")))
		{//find https
		    $url=$temp_url;
		}
		else
		{
			if (false !== ($pos = strpos($temp_url, "http://")))
			{//find
			    if($pos!=0)
			    	$url="http://".$temp_url;
			    else
			    	$url=$temp_url;
			}
			else
			{//not find
			    $url="http://".$temp_url;
			}
		}
		return $url;
	}

	//----------------------------------------------------------------------------------- 
	// 編號	 ：15
	// 函數名：set_serialstr($str_array, $target)
	// 作 用 ：字串陣列串接
	// 參 數 ：$str_array 原始字元陣列
	// $target 分隔符號
	// 返回值：串接字串
	// 備 注 ：無 
	//----------------------------------------------------------------------------------- 
	public function set_serialstr($str_array, $target)
	{
		if(!empty($str_array))
		{
			foreach((array)$str_array as $key => $value)
			{
				$pos1=strpos($value, $target);
				if($pos1 >= 0)
				{
					$temp_str = str_replace($target, '+-', $value);
				}
				else
				{
					$temp_str = $value;
				}

				$result.=$target.$temp_str;
			}
		}
		return $result;
	}

	//----------------------------------------------------------------------------------- 
	// 編號	 ：16
	// 函數名：get_serialstr($str, $target)
	// 作 用 ：還原字串陣列
	// 參 數 ：$str 原始字串
	// $target 分隔符號
	// 返回值：字元陣列
	// 備 注 ：無 
	//----------------------------------------------------------------------------------- 
	public function get_serialstr($str, $target)
	{
		$ori_str=$str;

		$pos_s=strpos($str, $target);
		$amount=0;
		$odd=1;
		while(!($pos_s===False))
		{
			$pos_s=strpos($str, $target);
			$temp_str=substr($str, $pos_s+2, strlen($str));
			$pos_e=strpos($temp_str, $target);
			if(!($pos_e===False))
			{
				$print_str=substr($str, $pos_s+2, $pos_s+$pos_e);
				$result_array[]=substr($str, $pos_s+2, $pos_s+$pos_e);
				$amount=$amount+$pos_e+($odd*2);
			}
			else
			{
				$result_array[]=$temp_str;
				break;
			}
			$str=substr($ori_str, $amount, strlen($ori_str));
		};
		if(!empty($result_array))
		{
			foreach($result_array as $key => $value)
			{
				$result_array[$key] = str_replace('+-', $target, $value);
			}
		}
		return $result_array;
	}

	//----------------------------------------------------------------------------------- 
	// 編號	 ：17
	// 函數名：random_vcode($len)
	// 作 用 ：產生隨機n碼作為驗證碼
	// 參 數 ：$len 驗證碼長度
	// 返回值：隨機n碼陣列
	// 備 注 ：session_vcode清空 
	//----------------------------------------------------------------------------------- 
	public function random_vcode($len)
	{
		$this->session->set_userdata('session_vcode','');
		srand((double)microtime()*1000000);
		for($i = 0; $i < $len; $i++)
		{
			$authnum=rand(1,9);
			$vcodes[$i]=$authnum;
		}
		return $vcodes;
	}

	//----------------------------------------------------------------------------------- 
	// 編號	 ：18
	// 函數名：random_num_code($len)
	// 作 用 ：產生隨機n碼作為卡號
	// 參 數 ：$len 驗證碼長度
	// 返回值：隨機n碼字串
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	public function random_num_code($len)
	{
		for($i = 0; $i < $len; $i++)
		{
			$authnum=mt_rand(0,9);
			$ncodes.=$authnum;
		}
		return $ncodes;
	}

	//----------------------------------------------------------------------------------- 
	// 編號	 ：19
	// 函數名：random_key($len)
	// 作 用 ：產生隨機金鑰
	// 參 數 ：$len 隨機長度
	// 返回值：隨機金鑰
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	public function random_key($len)
	{
		$string = "ab0123456789cdefghijklmn0123456789opqrstuvwxyzABCD0123456789EFGHIJKLMNO0123456789PQRSTUVWKYZ0123456789"; 
		do
		{
			for($i = 0; $i < $len; $i++)
			{
			    $pos  = mt_rand(0,strlen($string)-1);
			    $str .= $string{$pos}; 
			}
		}while(strlen($str) != $len);

		return $str;
	}

	//----------------------------------------------------------------------------------- 
	// 編號	 ：20
	// 函數名：make_vcode_img($vcode, $len)
	// 作 用 ：產生驗證碼圖形
	// 參 數 ：$vcode 驗證碼
	// $len 數字長度
	// 返回值：無
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	public function make_vcode_img($vcode, $len)
	{
		Header("Content-type: image/PNG");
		$im = imagecreate($len*11,18);
		$back = ImageColorAllocate($im, 245,245,245);
		imagefill($im,0,0,$back); //背景

		//生成4位数字
		for($i=0;$i<$len;$i++)
		{
			$font = ImageColorAllocate($im, rand(100,255),rand(0,100),rand(100,255));
			imagestring($im, 5, 2+$i*10, 1, $vcode[$i], $font);
		}

		for($i=0;$i<100;$i++) //加入干扰象素
		{ 
		$randcolor = ImageColorallocate($im,rand(0,255),rand(0,255),rand(0,255));
		imagesetpixel($im, rand()%70 , rand()%30 , $randcolor);
		} 
		ImagePNG($im);
		ImageDestroy($im);
	}

	//----------------------------------------------------------------------------------- 
	// 編號	 ：21
	// 函數名：get_direct_file($path, $type)
	// 作 用 ：取得資料夾底下所有檔案
	// 參 數 ：$path 檔案路徑
	// $type 附檔類型, photo => 圖片副檔名, exfile => 文件副檔名
	// 返回值：檔案名路徑陣列
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	public function get_direct_file($path, $type)
	{
		$dirname = $path;
		if($type == 'photo')
			$ext="{*.gif,*.GIF,*.jpg,*.JPG,*.png,*.PNG}";
		else if($type == 'exfile')
			$ext="{*.doc,*.docx,*.DOC,*.DOCX,*.xls,*.xlsx,*.XLS,*.XLSX,*.ppt,*.PPT,*.pptx,*.PPTX,*.pdf,*.PDF}";

		$dir_array=glob($dirname.$ext, GLOB_BRACE);
		if(!empty($dir_array))
		{
			$images = array_filter($dir_array, 'is_file');
			if(!empty($images))
			{
				$data['photo_show']=true;
				foreach($images as $image)
				{
					$result[]=substr($image, 1);
				}
			}
		}
		return $result;
	}

	//----------------------------------------------------------------------------------- 
	// 編號	 ：22
	// 函數名：random_num($len)
	// 作 用 ：產生隨機數字碼
	// 參 數 ：$len 隨機長度
	// 返回值：隨機數字碼
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	public function random_num($len)
	{
		$string = "ab0123456789cdefghijklmn0123456789opqrstuvwxyzABCD0123456789EFGHIJKLMNO0123456789PQRSTUVWKYZ0123456789"; 
		for($i = 0; $i < $len; $i++)
		{ 
		    $pos  = rand(0,(strlen($string)-1)); 
		    $str .= $string{$pos}; 
		}
		return $str;
	}

	//----------------------------------------------------------------------------------- 
	// 編號	 ：23
	// 函數名：calc_directory_size($directory_path)
	// 作 用 ：計算資料夾容量大小
	// 參 數 ：$directory_path 資料夾路徑
	// 返回值：MB
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	public function calc_directory_size($directory_path)
	{
	    // I reccomend using a normalize_path function here
	    // to make sure $directory_path contains an ending slash
	    // (-> http://www.jonasjohn.de/snippets/php/normalize-path.htm)
	  
	    // To display a good looking size you can use a readable_filesize
	    // function.
	    // (-> http://www.jonasjohn.de/snippets/php/readable-filesize.htm)
	  
	    $size = 0;
	  
	    $dir = opendir($directory_path);

	    if (!$dir)
	        return -1;
	  
	    while (($file = readdir($dir)) !== false) {
	  
	        // Skip file pointers
	        if ($file[0] == '.') continue; 
	  
	        // Go recursive down, or add the file size
	        if (is_dir($directory_path . $file))            
	            $size += CalcDirectorySize($directory_path . $file . DIRECTORY_SEPARATOR);
	        else
	            $size += filesize($directory_path . $file); 
	    }
	  
	    closedir($dir);

	    $temp_size = $size / 1024;//位元組轉KB
	    if ($temp_size / 1024 > 1) 
		{ 
			if ((($temp_size / 1024) / 1024) > 1) 
			{ 
			    $temp_size = (round((($temp_size / 1024) / 1024) * 100) / 100);
			    $sizeType = "GB";
			}
			else
			{ 
			    $temp_size = (round(($temp_size / 1024) * 100) / 100);
			    $sizeType = "MB";
			} 
		} 
		else 
		{
			$temp_size = (round($temp_size * 100) / 100);
			$sizeType = "KB";
		}

	    return $temp_size.$sizeType;
	}

	//----------------------------------------------------------------------------------- 
	// 編號	 ：24
	// 函數名：rounding_up($number)
	// 作 用 ：無條件進值某整數到整值
	// 參 數 ：目標數值
	// 返回值：進值數值
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	public function rounding_up($number)
	{
	    $len    = strlen($number); // 數值長度, 100 : 3
	    $ru_num = intval(substr($number, 0, 1));
	    $ru_num += 2;
	    for($i = 1; $i < $len; $i++)
		{
			$ru_num .= '0';
		}
	    return intval($ru_num);
	}
	
	//----------------------------------------------------------------------------------- 
	// 編號	 ：25
	// 函數名：my_mail_to($to, $subject, $msg, $headers)
	// 作 用 ：寄信
	// 參 數 ：$to 收件人 email
	// $subject 主旨
	// $msg 內容
	// $headers 寄件者
	// 返回值：無
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	public function my_mail_to($to, $subject, $msg, $headers)
	{
		// $to ='someone@com.tw'; 
		// $subject = 'subject';
		// $msg = 'msg';
		// $headers = 'From: someotherguy@com.tw';
		mail($to, $subject, $msg, $headers);
	}

	//----------------------------------------------------------------------------------- 
	// 編號	 ：26
	// 函數名：init_facebook_sdk
	// 作 用 ：初始化facebook函式庫
	// 參 數 ：無
	// 返回值：MB
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	public function init_facebook_sdk()
	{
        // Your own constructor code
        $CI = & get_instance();
        $CI->config->load("facebook",TRUE);
        $config = $CI->config->item('facebook');
        $this->load->library('facebook', $config);
        return $config;
	}

	//----------------------------------------------------------------------------------- 
	// 編號	 ：27
	// 函數名：icurl()
	// 作 用 ：發送 curl 請求
	// 參 數 ：$url 請求網址
	// 返回值：返回 json 結果
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	public function icurl($url)
	{
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$result = json_decode(curl_exec($curl), true);
		curl_close($curl);
		return $result;
	}

	//----------------------------------------------------------------------------------- 
	// 編號	 ：28
	// 函數名：script_message($str, $url='')
	// 作 用 ：跳出提示訊息
	// 參 數 ：$str 訊息
	// $url 是否跳轉頁面
	// 返回值：無
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	public function script_message($str, $url='', $type='')
	{
		echo '<script>';
		echo 'alert("'.$str.'");';
		if($url != '' && $type == '')
			echo 'window.location.href="'.$url.'";';
		else if($url != '' && $type == 'top')
			echo 'top.frames["content-frame"].location.href="'.$url.'";';
		echo '</script>';
	}

	//----------------------------------------------------------------------------------- 
	// 編號	 ：29
	// 函數名：init_pagination($uri, $total_rows, $per_page = 10, $uri_segment = 3)
	// 作 用 ：分頁設定值初始化
	// 參 數 ：
	// $uri 		分頁主網址
	// $total_rows 	總列數
	// $per_page 	每頁筆數
	// $uri_segment 頁數參數順序
	// 返回值：無
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	public function init_pagination($uri, $total_rows, $per_page = 10, $uri_segment = 3)
	{
		$this->load->library('pagination');
		$this->load->helper('url');

		$config['per_page']          = $per_page;
	    $config['uri_segment']       = $uri_segment;
	    $config['base_url']          = base_url().$uri;
	    $config['total_rows']        = $total_rows;
	    $config['use_page_numbers']  = TRUE;
	    $config['total_page']		 = ( $config['total_rows'] % $config['per_page'] == 0 ) ? $config['total_rows'] / $config['per_page'] : intval( $config['total_rows'] / $config['per_page'] ) + 1;
			
	    $config['first_tag_open'] 	 = $config['last_tag_open'] = $config['next_tag_open'] = $config['prev_tag_open']  = $config['num_tag_open']  = '<li>';
	    $config['first_tag_close'] 	 = $config['last_tag_close']= $config['next_tag_close']= $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';        
	    $config['cur_tag_open'] 	 = "<li><span><b>";
	    $config['cur_tag_close'] 	 = "</b></span></li>";

		$this->pagination->initialize($config);

		return $config;    
	}

	//----------------------------------------------------------------------------------- 
	// 編號	 ：30
	// 函數名：extend_ckupload_time($expire, $member_id, $img_url)
	// 作 用 ：延長ckeditor上傳時間
	// 參 數 ： 
	// $expire 		延長秒數
	// $member_id 	會員id
	// $img_url 	圖檔資料夾
	// $auth 		權限
	// $domain_id 	位址
	// 返回值：無
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	public function extend_ckupload_time($expire, $member_id, $img_url, $auth, $domain_id)
	{
		if ($expire == 0) {
			$expire = ini_get('session.gc_maxlifetime');
		} else {
			ini_set('session.gc_maxlifetime', $expire);
		}

		if (empty($_COOKIE['PHPSESSID'])) {
			session_set_cookie_params($expire);
			session_start();
		} else {
			session_start();
			setcookie('PHPSESSID', session_id(), time() + $expire);
		}

		$_SESSION['member_id'] 	  = $member_id;
		$_SESSION['IsAuthorized'] = true;
		$_SESSION['img_url'] 	  = $img_url;
		$this->session->set_userdata('auth', $auth);
		$this->session->set_userdata('domain_id', $domain_id);
	}
	
	//----------------------------------------------------------------------------------- 
	// 編號	 ：31
	// 函數名：curlpost($url, $post='')
	// 作 用 ：發送 curl post 請求
	// 參 數 ：$url 請求網址
	// $post 請求網址
	// 返回值：返回 json 結果
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	public function curlpost($url, $post = '')
	{
		$ch = curl_init();
		$options = array(
		  CURLOPT_URL		 => $url,
		  CURLOPT_POST 		 => true,
		  CURLOPT_POSTFIELDS => $post
		);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt_array($ch, $options);
		$result = json_decode(curl_exec($ch), true);
		curl_close($ch);
		return $result;
	}

	//----------------------------------------------------------------------------------- 
	// 編號：32
	// 函數名：upload_pic($pic_file) 
	// 作 用：上傳圖片
	// 參 數：$pic_file = $_FILES['xxx'] => input 傳入檔案
	// $path 存檔dir路徑
	// 返回值：檔案路徑
	// 備 注：無 
	//----------------------------------------------------------------------------------- 
	public function upload_pic($pic_file, $path, $name = '')
	{
		//允許的副檔名
		$allowedExts = array("jpg", "png", "jpeg", "gif", "bmp");
		//檢查檔名合法
		$chk_file_ext= $this->check_extend_name($pic_file['name'], $allowedExts);

		if($chk_file_ext == 1)
		{
			$lastdot = strrpos($pic_file['name'], "."); //取出.最後出現的位置 
			$extended = substr($pic_file['name'], $lastdot); //取出副檔名
			if($name == '')
			{
				$doc_name = md5(uniqid(rand())) . $extended;  /*產生唯一的檔案名稱*/
			}
			else
			{
				$doc_name = $name . $extended;  /*產生唯一的檔案名稱*/
			}			
			move_uploaded_file($pic_file["tmp_name"], $path.$doc_name);
			// chmod($path.$doc_name, 0755);

			$data=array(
				"name"	=>  $doc_name,
				"path"	=>  $path.$doc_name,
				"error" => 	''
			);

			return $data;
		}
		else
		{
			$data=array(
				"error" => '檔案類型錯誤'
			);
			return $data;
		}
	}
	//----------------------------------------------------------------------------------- 
	// 編號：33
	// 函數名：check_extend_name($c_filename,$a_extend) 
	// 作 用：上傳文件的副檔名判斷 
	// 參 數：$c_filename 上傳的檔案名 
	// $a_extend 要求的副檔名 
	// 返回值：布林值 
	// 備 注：無 
	//----------------------------------------------------------------------------------- 
	function check_extend_name($c_filename, $a_extend) 
	{ 
		if(strlen(trim($c_filename)) < 5) 
		{ 
			return 0; //返回0表示沒上傳圖片 
		} 
		
		$lastdot = strrpos($c_filename, "."); //取出.最後出現的位置 
		$extended = substr($c_filename, $lastdot+1); //取出副檔名 

		for($i=0;$i<count($a_extend);$i++) //進行檢測 
		{ 
			if (trim(strtolower($extended)) == trim(strtolower($a_extend[$i]))) //轉換大小寫並檢測 
			{ 
				$flag=1; //加成功標誌 
				$i=count($a_extend); //檢測到了便停止檢測 
			} 
		} 

		if($flag<>1) 
		{ 
			for($j=0;$j<count($a_extend);$j++) //列出允許上傳的副檔名種類 
			{ 
				$alarm .= $a_extend[$j]." "; 
			}
			return -1; //返回-1表示上傳圖片的類型不符 
		} 

		return 1; //返回1表示圖片的類型符合要求 
	}

	//----------------------------------------------------------------------------------- 
	// 編號	 ：34
	// 函數名：script_message_close($message = '', $btn = true)
	// 作 用 ：跳出提示訊息, 並關閉視窗
	// 參 數 ：$str 訊息
	// $btn 是否關閉視窗(預設 true)
	// 返回值：無
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	public function script_message_close($str = '', $btn = true)
	{
		echo '<script>';
		if($str != '')
			echo 'alert("'.$str.'");';
		echo ($btn) ? 'window.close();' : '';
		echo '</script>';
	}

	//----------------------------------------------------------------------------------- 
	// 編號	 ：34
	// 函數名：script_message_close($message = '', $btn = true)
	// 作 用 ：跳出提示訊息, 並關閉視窗
	// 參 數 ：$str 訊息
	// $url 是否跳轉頁面
	// $closeBtn 是否關閉視窗(預設 true)
	// $location location/parent (預設 location)
	// 返回值：無
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	public function script_message_location_where($str = '', $url = '', $closeBtn = true, $location = true)
	{
		echo '<script>';
		if($str != '')
			echo 'alert("'.$str.'");';
		echo ($closeBtn) ? 'window.close();' : '';
		if ($url != '')
		{
			echo ($location_type) ? 'window.location.href=' : 'opener.window.location.href=';
			echo '"'. $url .'";';
		}
		echo '</script>';
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：publiccheck($tempname,$id) 
	// 作 用：每一頁必須檢查的動作.
	// 參 數：$pagename 的檔案名 ,id 用戶ID
	// 返回值：布林值 
	// 備 注：無 
	//----------------------------------------------------------------------------------- 
	function publiccheck($tempname,$id,$seektype='')
	{	
		$data=$this->data;
		if($id != '')
		{
			if ($seektype==2) $member=$this->mod_business->select_from('member', array('member_id'=>$id));
			else $member=$this->mod_business->select_from('member', array('account'=>$id));
			$data['account'] = $member['account'];
			$data['public_barcodeurl'] = base_url()."app/route/".$member['member_id'];

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
			//mother_iqr
			$data['mother_iqr']=$mother_iqr=$this->mod_business->select_from('iqr', array('member_id'=>$this->member_id));

			//名片流量計數器
			$this->mod_business->iqr_views_add($iqr['iqr_id'], $this->get_realip());

			$this -> load -> library('Common');

			// logo
			$data['logo_path'] = Common::get_data_uri($iqr['logo_path']);
			$data['logo_path_url'] = $iqr['logo_path'];

			//web return
			$this->session->set_userdata('web_return', $id);

			//helper
			$this->load->helper('form');

			//base url
			$data['base_url']=base_url();

			//account
			$data['mid']=$member['member_id'];

			//name
			if($iqr['f_name'] != '')
				$data['iqr_name']=$iqr['l_name'].$iqr['f_name'];
			else
				$data['iqr_name']=$data['account'];
			
			//en_name
			if($iqr['f_en_name'] != '')
				$data['iqr_en_name']=$iqr['l_en_name'].' '.$iqr['f_en_name'];
			else
				$data['iqr_en_name']=$data['account'];
			
			// qrcode btn show/hide
			$data['web_btn']     = $this -> mod_business -> select_from('qrc_style', array('member_id' => $member['member_id'], 'type' => 0));
			$data['contact_btn'] = $this -> mod_business -> select_from('qrc_style', array('member_id' => $member['member_id'], 'type' => 1));
			$data['app_btn']     = $this -> mod_business -> select_from('qrc_style', array('member_id' => $member['member_id'], 'type' => 2));
			
			//qrcode btn name
			$data['address'] 	  = $iqr['address'];
			$data['web_btn_name'] 	  = ($iqr['iqr_qrcode_web'] != '') 		? $iqr['iqr_qrcode_web'] 	 : '行動商務系統 網頁';
			$data['app_btn_name'] 	  = ($iqr['iqr_qrcode_app'] != '') 		? $iqr['iqr_qrcode_app'] 	 : '行動商務系統 APP';
			$data['contact_btn_name'] = ($iqr['iqr_qrcode_contact'] != '') 	? $iqr['iqr_qrcode_contact'] : '通訊錄';
					
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
					if($iqr['theme_id'] == 2)
					{
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
			//mother_photo
				$mother_photo_category = $this -> mod_business -> select_from_order('photo_category', 'd_updateTime', 'desc', array('d_member_id' => $this->member_id, 'd_enable' => 'Y'));
				$data['mother_photo_show']=!empty($photo_category);
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
							if($s_i_value == 'ytb_link'){
								$data[$s_i_value][] = $this->get_ytb_id($str['str']);
							}else
								$data[$s_i_value][] = $str['str'];
							$data[$s_i_value.'_id'][] = $str['str_id'];
							if($s_i_value != 'titlename')
							{
								switch ($s_i_key) {
									case 0:
										$data[$s_i_value.'_name'][]	= ($str['str_name'] != '') ? $str['str_name'] : '影片'.$sortnum ;
										break;
									case 1:
										$data[$s_i_value.'_name'][]	= ($str['str_name'] != '') ? $str['str_name'] : '網站'.$sortnum ;
										break;
									case 2:
										$data[$s_i_value.'_name'][]	= ($str['str_name'] != '') ? $str['str_name'] : '地圖'.$sortnum ;
										break;
									case 4:
										$data[$s_i_value.'_name'][]	= ($str['str_name'] != '') ? $str['str_name'] : '撥打我的行動電話 ' .$sortnum ;
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
						$data['mobile_name']='撥打我的行動電話';
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
						$data['email_name']='寫信寄到我的電子信箱';
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
						$data['skype_name']='Skype通話';
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
						$data['facebook_name']='我的Facebook';
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
						$data['line_name']='加入我的Line為好友';
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
						$data['cpn_phone_name']='公司電話';
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
						$data['cpn_fax_name'] = '傳真電話';
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
						$data['cpn_number_name']='顯示我的統編';
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
								$data['doc_name'][]='附件'.($key+1);
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
					$data['cset_name']   = ($cart['cset_name'] != '') ? $cart['cset_name'] : '商店頁';
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
                        $data['ecp_url_detail'][$key] = base_url() ."business/ecoupon_editor/" .$ecp['member_id'] . "/" . $ecp['ecp_id'].'/ecoupon_detail/'.$member['account'];
						
                    }
                }
                else
                {
                    $data['ecp_show']=false;
                }
            //mother_coupon
				$data['mother_ecp_show']=($mother_iqr['ecoupon'] != '');
			//theme
				//DB data
				$theme=$this->mod_business->select_from('iqr_theme', array('theme_id'=>$iqr['theme_id']));
				$data['theme_id']=$iqr['theme_id'];
				//view
				$view_name=$theme['theme_mod_name'];
				//css
				$data['theme_id']=$theme['theme_id'];
				$data['footer_mode_name']=$theme['footer_mode_name'];				
				$data['theme_css']=$theme['theme_css_name'];
				$data['slider_css']=$theme['theme_slider_css_name'];
				$data['set_header']=$iqr['set_header'];
				$data['set_03list']=$iqr['set_03list'];				
				
				//jquery mobile button
				$data['jqm_button']=($iqr['theme_jqm_button'] != '') ? $iqr['theme_jqm_button'] : 'e'; 	
				//font-color
				$data['font_color']=($iqr['theme_font_color'] != '') ? $iqr['theme_font_color'] : $theme['dfu_font_color'];
				$data['font_color_2']=($iqr['theme_font_color_2'] != '') ? $iqr['theme_font_color_2'] : $theme['dfu_font_color_2'];
				$data['font_color_3']=($iqr['theme_font_color_3'] != '') ? $iqr['theme_font_color_3'] : $theme['dfu_font_color_3'];
				$data['font_color_4']=($iqr['theme_font_color_4'] != '') ? $iqr['theme_font_color_4'] : $theme['dfu_font_color_4'];
				$data['font_color_5']=($iqr['theme_font_color_5'] != '') ? $iqr['theme_font_color_5'] : $theme['dfu_font_color_5'];

				//font-size
				$data['font_size']=($iqr['theme_font_size'] != '') ? $iqr['theme_font_size'] : $theme['dfu_font_size'];
				$data['font_size_2']=($iqr['theme_font_size_2'] != '') ? $iqr['theme_font_size_2'] : $theme['dfu_font_size_2'];
				$data['font_size_3']=($iqr['theme_font_size_3'] != '') ? $iqr['theme_font_size_3'] : $theme['dfu_font_size_3'];
				$data['font_size_4']=($iqr['theme_font_size_4'] != '') ? $iqr['theme_font_size_4'] : $theme['dfu_font_size_4'];
				$data['font_size_5']=($iqr['theme_font_size_5'] != '') ? $iqr['theme_font_size_5'] : $theme['dfu_font_size_5'];

				//font-family
				$data['font_family']=($iqr['theme_font_family'] != '') ? $iqr['theme_font_family'] : $theme['dfu_font_family'];
				$data['font_family_2']=($iqr['theme_font_family_2'] != '') ? $iqr['theme_font_family_2'] : $theme['dfu_font_family_2'];
				$data['font_family_3']=($iqr['theme_font_family_3'] != '') ? $iqr['theme_font_family_3'] : $theme['dfu_font_family_3'];
				$data['font_family_4']=($iqr['theme_font_family_4'] != '') ? $iqr['theme_font_family_4'] : $theme['dfu_font_family_4'];
				$data['font_family_5']=($iqr['theme_font_family_5'] != '') ? $iqr['theme_font_family_5'] : $theme['dfu_font_family_5'];

				//background type
				$data['bg_type']=$iqr['theme_bg_type'];
				//background color
				$data['bg_color']=($iqr['theme_bg_color'] != '') ? $iqr['theme_bg_color'] : $theme['dfu_bg_color'];
				//background image path
				$data['bg_image_path'] = ($iqr['theme_bg_image_path'] != '') ? $iqr['theme_bg_image_path'] : $theme['dfu_bg_image_path'];
				// $data['bg_image_path'] = Common::get_data_uri(substr($bg_image_path, 1));
				$data['footer_mode_name']=$theme['footer_mode_name'];

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
							$data['banner_name']='立即免費體驗行動名片';
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
			//mother_form
				$ufm_id_array=$this->get_serialstr($mother_iqr['uform'], '*#');
				if (!empty($ufm_id_array)){
				foreach($ufm_id_array as $key => $value)
				{
					$uform=$this->mod_business->select_from('uform', array('ufm_id'=>$value));
					if(!empty($uform) && $uform['ufm_status'] != 0)
					{
						//按鈕名稱
						if($uform['ufm_btn_name'] != '')
							$data['mother_ufm_btn_name'][$key]=$uform['ufm_btn_name'];
						else
							$data['mother_ufm_btn_name'][$key]=$uform['ufm_name'];
						//id
						$data['mother_ufm_id'][$key]=$uform['ufm_id'];
					}
				}}
				if(count($data['mother_ufm_id']) != '')
					$data['mother_uform_show']=true;
				else
					$data['mother_uform_show']=false;
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
	                            $quote_data[$value['iqr_column']]['btnname'][$index] = ($id_data['str_name'] != '') ? $id_data['str_name'] : '連結';
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
			$mother_store=$this -> mod_business -> select_from('iqr_cart', array('member_id' => $this->member_id));
			$data['mother_cset_code'] = $mother_store['cset_code'];
			$data['get_device_type'] = $this->get_device_type();


			$auth=$this->session->userdata['auth'];
			if($auth=='01'){
				$data['chkmemberid']=$this->member_id;
				$viewname='公司';
				$viewtype='C';
			}
			else{
				$data['chkmemberid']=$this->son_member_id;
				$viewname='';
				$viewtype='P';
			}
			$data['viewname'] = $viewname;
			$data['viewtype'] = $viewtype;
		}
		$this->data=$data;
		return true;
	}
	public function chksharepict($url) 
	{
		if (empty($url)) return base_url().$this->data['icon'];
		else return base_url().$url;
	}

	public function get_ytb_id($url) 
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

	public function istestmachine() 
	{
		return $_SERVER["REMOTE_ADDR"]=='114.46.112.23';
	}

}
