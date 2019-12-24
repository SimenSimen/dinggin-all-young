<?php
class App extends MY_Controller
{
	public $data     = '';
	public $gz_name  = ''; 								// 產生亂數複製專案檔名
	public $a_server = 'http://59.125.75.217';    		// server 網址
	public $a_build  = '/android/apk_build.php';  		// 打包程式
	public $a_delete = '/android/apk_delete.php'; 		// 刪除程式
	public $i_server = 'http://59.125.75.220:8888';     // server 網址
	public $i_build  = '/ipabuild.php';  		  		// 打包程式
	public $i_appID  = 'com.appplus.KuoTing.';
	public $s_appID  = 'store.appplus.KuoTing.';
	public $i_download_path = 'kuo_ting';        // iOS 發佈資料夾名稱
	public $newsletter = 'kuoting';       	 // 通訊名以專案名為準
	
	public function __construct()//初始化
	{
		parent::__construct();

		//mac
		header('Access-Control-Allow-Origin: *');

		// language
		$this -> load -> helper('language');
		if(!$this -> session -> userdata('lang'))
		{
			$this -> session -> set_userdata('lang', 'zh-tw');
			$this -> data['lang'] = $this -> session -> userdata('lang');
		}
		else
			$this -> data['lang'] = $this -> session -> userdata('lang');

		@session_start();
        $this->setlang = (!empty($_SESSION['LA'])) ? $_SESSION['LA']['lang'] : 'TW';
        //語言包設置
        $this->load->model('lang_model',lmodel);
        //語言包
        $lang=$this->lmodel->config('27',$this->setlang);

		// language
		// $this -> lang -> load('controllers/app', $this -> data['lang']);
		$data['APPUpdateFailed'] = $lang['APPUpdateFailed'];
		$data['IOSUpdateFailed'] = $lang['IOSUpdateFailed'];

		//亂碼
		header("Content-Type:text/html; charset=utf-8");

		//helper
		$this->load->helper('url');

		//base_url
		$this->data['base_url']=base_url();

		//model
		$this->load->model('business_model', 'mod_business');

		//host
		$this->data['host']=$this->get_host_config();

		//domain id
		if($this->session->userdata('session_domain'))
			$this->data['domain_id']=$this->session->userdata('session_domain');
		else
			$this->data['domain_id']=$this->data['host']['domain_id'];

		//web config
		$this->data['web_config']=$this->get_web_config($this->data['domain_id']);
	}

	//----------------------------------------------------------------------------------- 
	// 網站端自動打包前置作業流程
	//----------------------------------------------------------------------------------- 
	// Android
	// 0. 產生亂數檔名
	// 1. 複製專案檔
	// 2. 替換strings.xml
	// 3. 替換icon
	// *. 替換其他
	// 4. 壓縮專案檔
	// 5. 刪除原始專案資料夾
	// 6. 傳送.gz網址給打包端
	// 7. json_decode 打包端給的apk連結
	// end
	//----------------------------------------------------------------------------------- 
	// iOS
	// 0. 產生亂數檔名
	// 1. 複製專案檔
	// 2. 替換 icon
	// 3. 替換BusinessCard-Info.plist
	// 4. 替換 web view url
	// *. 替換其他
	// 5. 壓縮專案檔
	// 6. 移動壓縮檔, 刪除原始專案資料夾
	// 7. 傳送.zip網址給打包端
	// 8. json_decode 打包端給的apk連結
	// end
	//----------------------------------------------------------------------------------- 
	// 函數名：ajax() -> android, ios
	// 作 用 ：網站端非同步處理、傳值主要入口
	// 參 數 ：$this->input->post()
	// 返回值：無
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	public function postajax($device = ''){
		echo "<form action='http://www.gbshop.com.tw/app/ajax/ios' method='POST'>
				<input name='project' value='ios'><br>
				<input name='name' value='AppPlusNetnewsWeb'><br>
				<input name='id' value='36'><br>
				<input name='app_name' value='紀盈溢'><br>
				<input name='app_icon' value='/images/web_style_images/gbshop.com.tw/app_welcome_page/icon.png'><br>
				<!--<input name='app_a_wp' value='/images/web_style_images/gbshop.com.tw/app_welcome_page/a_wp.png'><br>-->
				<input name='app_i_wp_0' value='/images/web_style_images/gbshop.com.tw/app_welcome_page/i_wp_0.png'><br>
				<input name='app_i_wp_1' value='/images/web_style_images/gbshop.com.tw/app_welcome_page/i_wp_1.png'><br>

				<input type='submit'>
				</form>
	
		";

	}

	public function ajax($device = '')
	{
		// 執行時間起點
		// $time_start = microtime(true);

		// 設定檔
		$data = $this->data;

		// Web View Link
		$member = $this->mod_business->select_from('member', array('member_id'=>$this->input->post('id')));
		$iqr_cart = $this -> mod_business -> select_from('iqr_cart', array('member_id' => $this->input->post('id')));
		$iqr = $this -> mod_business -> select_from('iqr', array('member_id' => $this -> input -> post('id')));
		if($member['app_index'] == 0)
		{
			if($data['web_config']['iqr_link_type'] == 1)//短網址
			{
				$base_url=substr(base_url(), 7);
				$base_url=substr($base_url, 0, -1);
				$iqr_url='http://'.$member['account'].'.'.$base_url;
			}
			else
			{
				$iqr_url=base_url().'business/iqr/'.$member['account'];
			}
		}
		else
		{
			$iqr_url = base_url().'cart/store/'.$iqr_cart['cset_code'];
		}
		// project  : 專案資料夾名稱
		// main     : 專案主程式
		// id 		: 會員id
		// app_name : 會員名片姓名
		// app_icon : 會員用icon
		if( $this->input->post('project') && 
			$this->input->post('name') && 
			$this->input->post('id') && 
			$this->input->post('app_name') && 
			$this->input->post('app_icon')
		){
			// $file = fopen('template/log-r.php', 'a+');
			// fwrite($file, 'project：'.$this->input->post('project'));
			// fwrite($file, PHP_EOL);
			// fwrite($file, 'name：'.$this->input->post('name'));
			// fwrite($file, PHP_EOL);
			// fwrite($file, 'id：'.$this->input->post('id'));
			// fwrite($file, PHP_EOL);
			// fwrite($file, 'app_name：'.$this->input->post('app_name'));
			// fwrite($file, PHP_EOL);
			// fwrite($file, 'app_icon：'.$this->input->post('app_icon'));
			// fwrite($file, PHP_EOL);
			// fwrite($file, 'app_a_wp：'.$this->input->post('app_a_wp'));
			// exit();
			// fclose($fh);
			
			if($device == 'android')
			{
				// 0. 產生亂數檔名
				$this->gz_name = md5(uniqid(rand()));
				// $this->gz_name = 'test';

				// 1. 複製專案檔
				// shell_exec('rm -r -f ./project/temp/'.$this->gz_name);
				shell_exec('cp -a ./project/'.$this->input->post('project').' ./project/temp/'.$this->gz_name);

				// 1-1. client key & member_id & domain 寫入
				$strings_xml = file_get_contents('./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/src/com/appplus/HiStoreNetNews/utils/Config.java');
				// if(!empty($member['gcm_key']) && !empty($member['client_key']))
				// {
				// 	$temp_strings_xml_0 = str_replace('***client_key', $member['client_key'], $strings_xml);
				// 	$temp_strings_xml_1 = str_replace('***domain', base_url(), $temp_strings_xml_0);
				// 	$temp_strings_xml_2 = str_replace('****', $member['domain_id'], $temp_strings_xml_1);
				// 	$new_strings_xml_3  = str_replace('***member_id', $member['member_id'], $temp_strings_xml_2);
				// }
				// else
				// {
				// 	$temp_strings_xml_1 = str_replace('***domain', base_url(), $strings_xml);
				// 	$temp_strings_xml_2 = str_replace('****', $member['domain_id'], $temp_strings_xml_1);
				// 	$new_strings_xml_3  = str_replace('***member_id', $member['member_id'], $temp_strings_xml_2);
				// }
				$new_strings_xml_3 = $strings_xml;

				$new_strings_xml_3 = str_replace('C2DM_SENDER  = "***"',' C2DM_SENDER  = "'.$member['client_key'].'"', $new_strings_xml_3);					
				$new_strings_xml_3 = str_replace('Baidu_Push = "0"','Baidu_Push = "0"', $new_strings_xml_3);

				$new_strings_xml_3 = str_replace('Domain_Url  = "***"','Domain_Url  = "'.base_url().'"',  $new_strings_xml_3);
				$new_strings_xml_3 = str_replace('Domain_id  = "***"','Domain_id  = "'.$member['domain_id'].'"' , $new_strings_xml_3);
				$new_strings_xml_3 = str_replace('Start_Page_Url  = "***"','Start_Page_Url  = "'.$iqr_url.'"', $new_strings_xml_3);
				$new_strings_xml_3  = str_replace('member_id  = "***"','member_id  = "'.$member['member_id'].'"' , $new_strings_xml_3);
				$new_strings_xml_3  = str_replace('TitleBar = "0"', 'TitleBar = "2"', $new_strings_xml_3);
				
				$new_strings_xml_3  = str_replace('TitleBarText = "***"', 'TitleBarText = "'.$this->input->post('app_name').'"', $new_strings_xml_3);
				$new_strings_xml_3 = str_replace('Netnews = "0"','Netnews = "1"', $new_strings_xml_3);

				$new_strings_xml = str_replace('*share_APK_Name*', $this->input->post('name'), $new_strings_xml_3);
				shell_exec('rm ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/src/com/appplus/HiStoreNetNews/utils/Config.java');
				shell_exec('echo \''.$new_strings_xml.'\' >> ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/src/com/appplus/HiStoreNetNews/utils/Config.java');
				
				// 2. 替換strings.xml
				// a. app name
				$strings_xml = file_get_contents('./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/res/values/strings.xml');
				$temp_strings_xml = str_replace('<string name="app_name">***</string>', '<string name="app_name">'.$this->input->post('app_name').'</string>', $strings_xml);
				// b. web viwe url
				// $temp_strings_xml_0 = str_replace('<string name="webviewurl">***</string>', '<string name="webviewurl">'.$iqr_url.'</string>', $temp_strings_xml);
				// c. title_activity_home
				$new_strings_xml = str_replace('<string name="title_activity_home">***</string>', '<string name="title_activity_home">'.$this->input->post('app_name').'</string>', $temp_strings_xml);
				shell_exec('rm ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/res/values/strings.xml');
				shell_exec('echo \''.$new_strings_xml.'\' >> ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/res/values/strings.xml');
				// d. AndroidManifest.xml
				$android_code = $iqr['android_versioncode'] + 1;
				$android_name = $iqr['android_versionname'] + 0.01;
				$version_path = './project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/AndroidManifest.xml';
				#-- Plan A (因為無法 echo 檔案) 故不用
				// $android_path     = file_get_contents('./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/AndroidManifest.xml');
				// $android_path0 = str_replace('package="com.appplus.***"', 'package="com.appplus.'.$member['account'].'"', $android_path);
				// $new_android_code = str_replace('android:versionCode="***"', 'android:versionCode="'.$android_code.'"', $android_path0);
				// $new_android_code = str_replace('android:versionName="****"', 'android:versionName="'.$android_name.'"', $new_android_code);
				// shell_exec('rm ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/AndroidManifest.xml');
				// shell_exec('echo \''.$new_android_code.'\' >> ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/AndroidManifest.xml');
				// $this -> utils($version_path, 'android:scheme="netnewsweb"', 'android:scheme="'.$this->newsletter.$member['member_id'].'"');
				// $this->i_download_path.$member['member_num']
				#-- Plan B
				$this -> utils($version_path, 'android:versionCode="***"', 'android:versionCode="'.$android_code.'"');
				$this -> utils($version_path, 'android:versionName="****"', 'android:versionName="'.$android_name.'"');
				// e. rename package name
				// $this -> Auto_matching('./project/temp/'.$this->gz_name.'/'.$this->input->post('name'), 'netnewsweb2', 'A'. $member['account'] .'C'. $member['member_id']);
				$this -> Auto_matching('./project/temp/'.$this->gz_name.'/'.$this->input->post('name'), 'HiStoreNetNews',$this->packagename($member['member_id'],$member['account']));	
				// 3. 替換icon
				shell_exec('rm ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/res/drawable/ic_launcher.png');
				shell_exec('cp .'.$this->input->post('app_icon').' ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/res/drawable/ic_launcher.png');
				// >> 96 x 96
				$icon_96 = $this->resize_image('.'.$this->input->post('app_icon'), 96, 96); // copy
				shell_exec('rm ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/res/drawable-xhdpi/ic_launcher.png');
				shell_exec('cp '.$icon_96.' ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/res/drawable-xhdpi/ic_launcher.png');
				shell_exec('rm '.$icon_96);
				// >> 72 x 72
				$icon_72 = $this->resize_image('.'.$this->input->post('app_icon'), 72, 72); // copy
				shell_exec('rm ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/res/drawable-hdpi/ic_launcher.png');
				shell_exec('cp '.$icon_72.' ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/res/drawable-hdpi/ic_launcher.png');
				shell_exec('rm '.$icon_72);
				// >> 48 x 48
				$icon_48 = $this->resize_image('.'.$this->input->post('app_icon'), 48, 48); // copy
				shell_exec('rm ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/res/drawable-mdpi/ic_launcher.png');
				shell_exec('cp '.$icon_48.' ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/res/drawable-mdpi/ic_launcher.png');
				shell_exec('rm '.$icon_48);
				// >> 36 x 36
				$icon_36 = $this->resize_image('.'.$this->input->post('app_icon'), 36, 36); // copy
				shell_exec('rm ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/res/drawable-ldpi/ic_launcher.png');
				shell_exec('cp '.$icon_36.' ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/res/drawable-ldpi/ic_launcher.png');
				shell_exec('rm '.$icon_36);

				// *. 替換其他
				// a. welcome page
				$wp = $this->resize_image('.'.$this->input->post('app_a_wp'), 480, 760); // copy
				shell_exec('rm ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/res/drawable/splash.png');
				shell_exec('cp '.$wp.' ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/res/drawable/splash.png');
				shell_exec('rm '.$wp);

				// 4. 壓縮專案檔, 專案壓縮檔建立 -p:保留原檔案權限 -v:列出所有壓縮內容
				// shell_exec('tar -zc -p -f ./project/'.$this->gz_name.'.tar.gz ./project/temp/'.$this->gz_name.'/');
				// $tar_url = $data['base_url'].'project/'.$this->gz_name.'.tar.gz';
				chdir('./project/temp/'.$this->gz_name.'/'); // 變更系統路徑
				shell_exec('zip -r '.$this->gz_name.'.zip *');
				$tar_url = $data['base_url'].'project/'.$this->gz_name.'.zip';
				chdir('../../../'); // 復原路徑
				// 5. 刪除原始專案資料夾
				shell_exec('mv ./project/temp/'.$this->gz_name.'/'.$this->gz_name.'.zip ./project');
				shell_exec('rm -r -f ./project/temp/'.$this->gz_name);
				
				// 6. 傳送.gz網址給打包端
				$file_get_link  = $this->a_server.$this->a_build;				// 打包主程式
				$file_get_link .= '?url='.$tar_url;								// 專案壓縮檔路徑
				$file_get_link .= '&name='.$this->input->post('name');			// 專案主程式名稱
				$file_get_link .= '&p=com.appplus';								// package 
				$file_get_link .= '&n=iqr'.$member['account'];					// name
				$file_get_link .= '&return_url='.base_url().'app/refresh_app/'.$member['member_id'].'/apk'; // return url
				$result = $this->curl_request($file_get_link);
				// $this -> mod_business -> insert_into('a1_test', array('str' => $file_get_link));
			}
			else if($device == 'ios')
			{
				if(!empty($member['pem']) && !empty($member['mobileprovision']))
				{
					// 0. 產生亂數檔名
					$this->gz_name = md5(uniqid(rand()));
					// $this->gz_name = 'test';

					// 1. 複製專案檔
					shell_exec('rm -r -f ./project/temp/'.$this->gz_name);
					shell_exec('cp -a ./project/'.$this->input->post('project').' ./project/temp/'.$this->gz_name);

					// 1-1. mobileprovision 塞入憑證
					shell_exec('cp .'.$member['img_url'].'app/'.$member['account'].'.mobileprovision ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$member['account'].'.mobileprovision');
					
					// 2. 替換 icon
					$this -> change_icon();
					
					// 3. 替換Info.plist
					// a. app name
					$ios_vstring = $iqr['ios_versionstring'] + 0.1;
					$ios_version = $iqr['ios_version'] + 0.1;
					$strings_xml = file_get_contents('./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/Info.plist');
					$temp_strings_xml = str_replace('<string>***</string>', '<string>'.$this->input->post('app_name').'</string>', $strings_xml);
					$temp_strings_xml = str_replace('<string>*****</string>', '<string>'.$ios_vstring.'</string>', $temp_strings_xml);
					$temp_strings_xml = str_replace('<string>****</string>', '<string>'.$ios_version.'</string>', $temp_strings_xml);
 
					//20160921更換IOS通訊協定-用於呼叫APP
					$temp_strings_xml = str_replace('<string>callMe</string>', '<string>'.$this->newsletter.$member['member_id'].'</string>', $temp_strings_xml);


					// b. app id
					$sysText = ($member['app_id'] == 'default') ? $this->i_appID : $this->s_appID;
					//20160718-特殊處理
					$this->load->library('../controllers/IosAccount');
					$acc=new IosAccount();
					$member['account']=$acc->checkacc($member['account']);
					
					$new_strings_xml = str_replace('<string>com.iqr.user</string>', '<string>'.$sysText.$member['account'].'</string>', $temp_strings_xml);
					shell_exec('rm ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/Info.plist');
					shell_exec('echo \''.$new_strings_xml.'\' >> ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/Info.plist');

					// 4. 替換 web view url
					$strings_xml = file_get_contents('./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/ModerCode/AppMetaData.plist');
					$new_strings_xml = str_replace('<string>http://server_name/s/r/user_account</string>', '<string>'.$iqr_url.'</string>', $strings_xml);
					// a. member_id, domain_id 寫入
					$new0_strings_xml = str_replace('<string>domain_id</string>', '<string>'.$member['domain_id'].'</string>', $new_strings_xml);
					$new1_strings_xml = str_replace('<string>member_id</string>', '<string>'.$member['member_id'].'</string>', $new0_strings_xml);
					$new2_strings_xml = str_replace('<string>http://server_name/</string>', '<string>'.base_url().'</string>', $new1_strings_xml);
					//20160921更換IOS通訊協定-用於呼叫APP
					$new3_strings_xml = str_replace('<string>callMe</string>', '<string>'.$this->i_download_path.$member['member_num'].'</string>', $new2_strings_xml);
					// 20170424 TitleBar (0.不顯示、1.滑動顯隱、2.固定顯示)
					$new3_strings_xml = str_replace('<string>TitleBar</string>', '<string>2</string>', $new3_strings_xml);
					// 20170424 版本更新 API  設定 （ 版本更新 0關閉 1 開啟）
					$new3_strings_xml = str_replace('<string>AppAppversion</string>', '<string>1</string>', $new3_strings_xml);

					shell_exec('rm ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/ModerCode/AppMetaData.plist');
					shell_exec('echo \''.$new3_strings_xml.'\' >> ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/ModerCode/AppMetaData.plist');

					// *. 替換其他
					// a. welcome page 0
					$i_wp_0_0 = $this->resize_image('.'.$this->input->post('app_i_wp_0'), 640, 960); // copy
					shell_exec('rm ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/AppImages/Default@2x.png');
					shell_exec('cp '.$i_wp_0_0.' ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/AppImages/Default@2x.png');
					shell_exec('rm '.$i_wp_0_0);
					// b. welcome page 0 -> 0.5 x
					$i_wp_0_1 = $this->resize_image('.'.$this->input->post('app_i_wp_0'), 320, 480); // copy
					shell_exec('rm ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/AppImages/Default.png');
					shell_exec('cp '.$i_wp_0_1.' ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/AppImages/Default.png');
					shell_exec('rm '.$i_wp_0_1);
					// c. welcome page 1
					$i_wp_1 = $this->resize_image('.'.$this->input->post('app_i_wp_1'), 640, 1136); // copy
					shell_exec('rm ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/AppImages/Default-568h@2x.png');
					shell_exec('cp '.$i_wp_1.' ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/AppImages/Default-568h@2x.png');
					shell_exec('rm '.$i_wp_1);
					
					// 5. 壓縮專案檔, 專案壓縮檔建立 -p:保留原檔案權限 -v:列出所有壓縮內容
					chdir('./project/temp/'.$this->gz_name.'/'); // 變更系統路徑
					shell_exec('zip -r '.$this->gz_name.'.zip '.$this->input->post('name'));
					$tar_url = $data['base_url'].'project/'.$this->gz_name.'.zip';
					chdir('../../../'); // 復原路徑
					// echo $tar_url;

					// 6. 複製壓縮檔(iOS 擷圖用), 移動壓縮檔, 刪除原始專案資料夾
					shell_exec('cp ./project/temp/'.$this->gz_name.'/'.$this->gz_name.'.zip .'.$member['img_url'].'app/'.$member['account'].'.zip');
					shell_exec('mv ./project/temp/'.$this->gz_name.'/'.$this->gz_name.'.zip ./project');
					shell_exec('rm -r -f ./project/temp/'.$this->gz_name);
					
					// 7. 傳送.zip網址給打包端
					$file_get_link  = $this->i_server.$this->i_build;				// 打包主程式
					$file_get_link .= '?url='.$tar_url;								// 專案壓縮檔路徑
					$file_get_link .= '&name='.$this->input->post('name');			// 專案主程式名稱
					$file_get_link .= '&returnUrl='.base_url().'app/refresh_app/'.$member['member_id'].'/ipa';// return url
					$file_get_link .= '&deploy=http://apps.appmall.com.tw/app/'.$this->i_download_path.'/'.$member['account'];// 發布網址
					if(!empty($member['mobileprovision']))
					{
						$file_get_link .= '&push=' . $member['account']; // 憑證名稱
					}
					$result = $this->curl_request($file_get_link);
				}
				else
					echo $data['IOSUpdateFailed'];
			}

			// echo '<pre>';
			// print_r($result);
			// echo '</pre>';

		}
		else
		{
			echo $data['APPUpdateFailed'];
		}

		// 計算執行時間
		// $time_end = microtime(true);
		// $time = $time_end - $time_start;
		// echo "All : $time s\n";
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：change_icon()
	// 作 用 ：變更AppIcon
	// 參 數 ：無
	// 返回值：無
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	private function change_icon()
	{
		// >> 29 x 29
		$icon_29 = $this->resize_image('.'.$this->input->post('app_icon'), 29, 29); // copy
		shell_exec('rm ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/Assets.xcassets/AppIcon.appiconset/Icon-Small.png');
		shell_exec('cp '.$icon_29.' ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/Assets.xcassets/AppIcon.appiconset/Icon-Small.png');
		shell_exec('rm '.$icon_29);

		// >> 40 x 40
		$icon_40 = $this->resize_image('.'.$this->input->post('app_icon'), 40, 40); // copy
		shell_exec('rm ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/Assets.xcassets/AppIcon.appiconset/Icon-40.png');
		shell_exec('cp '.$icon_40.' ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/Assets.xcassets/AppIcon.appiconset/Icon-40.png');
		shell_exec('rm '.$icon_40);

		// >> 58 x 58
		$icon_58 = $this->resize_image('.'.$this->input->post('app_icon'), 58, 58); // copy
		shell_exec('rm ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/Assets.xcassets/AppIcon.appiconset/Icon-Small@2x.png');
		shell_exec('cp '.$icon_58.' ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/Assets.xcassets/AppIcon.appiconset/Icon-Small@2x.png');
		shell_exec('rm '.$icon_58);
		
		// >> 76 x 76
		$icon_76 = $this->resize_image('.'.$this->input->post('app_icon'), 76, 76); // copy
		shell_exec('rm ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/Assets.xcassets/AppIcon.appiconset/Icon-76.png');
		shell_exec('cp '.$icon_76.' ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/Assets.xcassets/AppIcon.appiconset/Icon-76.png');
		shell_exec('rm '.$icon_76);
		
		// >> 80 x 80
		$icon_80 = $this->resize_image('.'.$this->input->post('app_icon'), 80, 80); // copy
		shell_exec('rm ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/Assets.xcassets/AppIcon.appiconset/Icon-40@2x.png');
		shell_exec('cp '.$icon_80.' ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/Assets.xcassets/AppIcon.appiconset/Icon-40@2x.png');
		shell_exec('rm '.$icon_80);
		
		// >> 87 x 87
		$icon_87 = $this->resize_image('.'.$this->input->post('app_icon'), 87, 87); // copy
		shell_exec('rm ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/Assets.xcassets/AppIcon.appiconset/Icon-Small@3x.png');
		shell_exec('cp '.$icon_87.' ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/Assets.xcassets/AppIcon.appiconset/Icon-Small@3x.png');
		shell_exec('rm '.$icon_87);
		
		// >> 120 x 120 (2)
		$icon_120 = $this->resize_image('.'.$this->input->post('app_icon'), 120, 120);
		shell_exec('rm ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/Assets.xcassets/AppIcon.appiconset/Icon-40@3x.png');
		shell_exec('rm ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/Assets.xcassets/AppIcon.appiconset/Icon-60@2x.png');
		shell_exec('cp '.$icon_120.' ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/Assets.xcassets/AppIcon.appiconset/Icon-40@3x.png');
		shell_exec('cp '.$icon_120.' ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/Assets.xcassets/AppIcon.appiconset/Icon-60@2x.png');
		shell_exec('rm '.$icon_120);

		// >> 152 x 152
		$icon_152 = $this->resize_image('.'.$this->input->post('app_icon'), 152, 152); // copy
		shell_exec('rm ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/Assets.xcassets/AppIcon.appiconset/Icon-76@2x.png');
		shell_exec('cp '.$icon_152.' ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/Assets.xcassets/AppIcon.appiconset/Icon-76@2x.png');
		shell_exec('rm '.$icon_152);
		
		// >> 180 x 180
		$icon_180 = $this->resize_image('.'.$this->input->post('app_icon'), 180, 180); // copy
		shell_exec('rm ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/Assets.xcassets/AppIcon.appiconset/Icon-60@3x.png');
		shell_exec('cp '.$icon_180.' ./project/temp/'.$this->gz_name.'/'.$this->input->post('name').'/'.$this->input->post('name').'/Assets.xcassets/AppIcon.appiconset/Icon-60@3x.png');
		shell_exec('rm '.$icon_180);
	}
	//----------------------------------------------------------------------------------- 
	// 函數名：refresh_app()
	// 作 用 ：變更App狀態更新
	// 參 數 ：$member_id 會員id
	// $build 安裝檔類型
	// 返回值：無
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	public function refresh_app($member_id, $build)
	{
		if($member_id != '')
		{
			$member = $this->mod_business->select_from('member', array('member_id'=>$member_id));
			if(!empty($member) && $this->input->get('data'))
			{
				if(time() > $member['deadline']) // 使用期限已過
					redirect(base_url());

				// data
				$result = json_decode($this->input->get('data'), true);
				
				
				// 打包成功
				if($result['status'] == 'ok')
				{
					// 設定檔
					$data = $this->data;

					// 變更App更新狀態
					$iqr = $this->mod_business->select_from('iqr', array('member_id'=>$member_id));
					if($iqr[$build] == 2 || $iqr[$build] == 0)
						$this->mod_business->update_set('iqr', 'member_id', $member_id, array($build=>1));

					// check app folder
					if(!is_dir('.'.$member['img_url'].'/app/'))
						@mkdir('.'.$member['img_url'].'/app/', 0777);

					if($build == 'apk')
					{
						// 複製package
						$apk_name = substr($result['package'], strrpos($result['package'], '-')+1);
						shell_exec('rm .'.$member['img_url'].'/app/'.$member['account'].'-'.$apk_name); 
						copy($result['package'], '.'.$member['img_url'].'/app/'.$member['account'].'-'.$apk_name);

						// 刪除server端檔案
						$delete = file_get_contents($this->a_server.$this->a_delete.'?u='.$result['package']); 
						
						// 刪除專案壓縮檔
						shell_exec('rm ./project/'.$result['zip_name'].'.zip');

						$androidCode = $iqr['android_versioncode'] + 1;
						$androidName = $iqr['android_versionname'] + 0.01;
						$this -> mod_business -> update_set('iqr', 'member_id', $member_id, array('android_versioncode' => $androidCode, 'android_versionname' => $androidName));

						//--2015.03.10.---新增功能-抓取成功後刪除打包機的APK檔---START----------
						$link = explode('/', $result['package']);
						$apk_name=$link[5];

						$url  = 'http://59.125.75.219/android/apk_remove.php?';
						$url .= 'name=' . $apk_name;

						$curl = curl_init($url);
						curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($curl, CURLOPT_TIMEOUT ,  '30');
						$updateUrlContent = curl_exec($curl);
						curl_close($curl);
						//--2015.03.10.---新增功能-抓取成功後刪除打包機的APK檔-----END----------
					}
					else if($build == 'ipa')
					{
						//20160718-特殊處理
						$this->load->library('../controllers/IosAccount');
						$acc=new IosAccount();
						$member['account']=$acc->checkacc($member['account']);
						
						
						// ipa
						$ipa_name = substr($result['package']['ipa'], strrpos($result['package']['ipa'], '/')+1);
						shell_exec('rm .'.$member['img_url'].'/app/'.$member['account'].'-'.$ipa_name); 
						copy($result['package']['ipa'], '.'.$member['img_url'].'/app/'.$member['account'].'-'.$ipa_name);
						
						// plist
						$plist_name = substr($result['package']['plist'], strrpos($result['package']['plist'], '/')+1);
						shell_exec('rm .'.$member['img_url'].'/app/'.$member['account'].'-'.$plist_name); 
						copy($result['package']['plist'], '.'.$member['img_url'].'/app/'.$member['account'].'-'.$plist_name);

						// 刪除專案壓縮檔
						shell_exec('rm ./project/'.$result['zip_name']);

						$iOS_VersionString = $iqr['ios_versionstring'] + 0.1;
						$iOS_Version = $iqr['ios_version'] + 0.1;
						$this -> mod_business -> update_set('iqr', 'member_id', $member_id, array('ios_versionstring' => $iOS_VersionString, 'ios_version' => $iOS_Version));

						// 發佈
						$release_data = array(
							'img_url'	=> $member['img_url'],
							'folder'	=> $member['account'],
							'server'	=> base_url(),
							'ipa'		=> $ipa_name,
							'plist'		=> $plist_name,
							'status'	=> $result['status'],
							'icon_s'	=> $iqr['icon_status'],
							'domain'	=> $data['host']['domain']
						);

					
						$file_get_link  = 'http://apps.appmall.com.tw/app/'.$this->i_download_path.'/bf89b7706d1d45e1f81e9edcd41800fb/build.php'; // 發佈主程式
						$file_get_link .= '?data='.json_encode($release_data); // package content
						$release = $this->curl_request($file_get_link);
					}
				}
				else
				{
					// error log
                    if($build == 'apk')
                    {
                        $to ='vince@netnews.com.tw'; 
                        $subject = $build.'_build';
                        $msg = $this->input->get('data');
                        $headers = 'From: vince@netnews.com.tw';
                        // $this->my_mail_to($to, $subject, $msg, $headers);
                    }
                    else
                    {
                        $to ='vince@netnews.com.tw'; 
                        $subject = $build.'_build';
                        $msg = $this->input->get('data');
                        $headers = 'From: vince@netnews.com.tw';
                        // $this->my_mail_to($to, $subject, $msg, $headers);
                    }
				}
			}
		}
	}
	//----------------------------------------------------------------------------------- 
	// 函數名：curl_request()
	// 作 用 ：發送 curl 請求
	// 參 數 ：$url 請求網址
	// 返回值：返回 json 結果
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	private function curl_request($url)
	{
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$result = json_decode(curl_exec($curl), true);
		curl_close($curl);
		return $result;
	}
	//----------------------------------------------------------------------------------- 
	// 函數名：resize_image()
	// 作 用 ：變更圖形尺寸
	// 參 數 ：$filename 檔案路徑
	// $max_width  變更寬度
	// $max_height 變更高度
	// 返回值：返回新檔案路徑
	// 備 注 ：null
	//----------------------------------------------------------------------------------- 
	private function resize_image($filename, $max_width, $max_height)
	{
	    list($orig_width, $orig_height) = getimagesize($filename);

	    $width = $orig_width;
	    $height = $orig_height;

	    # taller
	    if ($height > $max_height) {
	        $width = ($max_height / $height) * $width;
	        $height = $max_height;
	    }

	    # wider
	    if ($width > $max_width) {
	        $height = ($max_width / $width) * $height;
	        $width = $max_width;
	    }

	    $image_p = imagecreatetruecolor($width, $height);
		imagealphablending( $image_p, false );
		imagesavealpha( $image_p, true );

	    $image = imagecreatefrompng($filename);
		imagealphablending( $image, false );
		imagesavealpha( $image, true );

	    imagecopyresampled($image_p, $image, 0, 0, 0, 0, 
	                                     $width, $height, $orig_width, $orig_height);

	    $path = substr($filename, 0, (strrpos($filename, '/') + 1));
	    $ext = substr($filename, strrpos($filename, '.'));
	    imagepng($image_p, $path.'icon_'.$max_width.'x'.$max_height.$ext);

	    return $path.'icon_'.$max_width.'x'.$max_height.$ext;
	}
	//----------------------------------------------------------------------------------- 
	// End of 網站端自動打包前置作業
	//----------------------------------------------------------------------------------- 


	//----------------------------------------------------------------------------------- 
	// 函數名：qrcode($member_id='')
	// 作 用 ：qrcode圖形視窗
	// 參 數 ：$member_id 會員id
	// 返回值：無
	// 備 注 ：顯示QRcode為裝置判斷連結 -> /app/route
	//----------------------------------------------------------------------------------- 
	// public function qrcode($member_id='')
	// {
	// 	// 設定檔
	// 	$data = $this->data;

	// 	// 驗證會員是否存在
	// 	if($member_id != '')
	// 	{
	// 		$member=$this->mod_business->select_from('member', array('member_id'=>$member_id));
	// 	}
	// 	else
	// 	{
	// 		redirect(base_url());
	// 	}

	// 	// 驗證會員使用期限是否過期
	// 	if(!empty($member))
	// 	{
	// 		if(!$this->check_deadline($data['web_config'], $member['member_id']))
	// 		{
	// 			redirect('/index/error');
	// 		}

	// 		// qrcode 視窗設定
	// 		$iqr = $this->mod_business->select_from('iqr', array('member_id'=>$member_id));
	// 		$data['content'] = base_url().'app/route/'.$member_id;

	// 		// update status
	// 		// 2 : after business edit -> so need to update
	// 		// 1 : recive a response from auto build server -> tip : please re-install apk or ipa ?
	// 		// 0 : 確認更新之後回歸0
	// 		if($iqr['apk'] == 2 || $iqr['ipa'] == 2)
	// 		{
	// 			$data['update_prompt'] = '<span id="update_span">您進行了幾項資料更新<br>請立即更新您的 APP</span>';
	// 		}
	// 		else
	// 		{
	// 			$data['update_prompt'] = '<span id="update_span">掃描此 QRcode 下載您的名片 APP</span>';
	// 		}

	// 		// view
	// 		$this->load->view('app_qrcode', $data);
	// 	}
	// 	else
	// 	{
	// 		redirect(base_url());
	// 	}
	// }

	//----------------------------------------------------------------------------------- 
	// 函數名：qrcode($member_id='')
	// 作 用 ：裝置判斷並轉只到對應APP下載頁面
	// 參 數 ：$member_id 會員id
	// 返回值：無
	// 備 注 ：轉址
	//----------------------------------------------------------------------------------- 
	public function route($member_id)
	{
		// member data
		$member = $this->mod_business->select_from('member', array('member_id'=>$member_id));
		$iqr    = $this->mod_business->select_from('iqr', array('member_id'=>$member_id));

		// 對應裝置判斷 && 下載頁面判斷
		if($this->get_device_os() == 'ios')
		{
			if($member['instore'] && $iqr['ipa_release'] != '')
				$app_link = $iqr['ipa_release'];
			else
				$app_link = 'http://apps.appmall.com.tw/app/'.$this->i_download_path.'/'.$member['account'].'/download.html';
		}
		else
		{
			if($member['instore'] && $iqr['apk_release'] != '')
				$app_link = $iqr['apk_release'];
			else
				$app_link = '/appui/download/'.$member_id;
		}

		// 轉址
		redirect($app_link);
	}

	//utils.jave 替換
	private function utils($path_file,$replace,$replace_val)
	{
		$strings =$path_file;
		$solrXml = file_get_contents($strings);
		$solrXml=str_replace ($replace,$replace_val,$solrXml);
		$fp = fopen($strings,"w+");
		var_dump(fwrite($fp,$solrXml));
	}

	// 自動比對
	private function Auto_matching($file_path, $match_string, $sub_string)
	{
		// Linux grep and sed 
		// 搜尋內文裡的 package name 並修改
		shell_exec("grep -rl '". $match_string ."' ". $file_path ." | xargs sed -i 's/".$match_string."/".$sub_string."/g'");
		
		// rename folder name
		shell_exec("mv ".$file_path."/src/com/appplus/".$match_string."  ".$file_path."/src/com/appplus/".$sub_string."");
	}

	// 版本檢查
	public function appversion(){
		$md5=md5("*%&24260883#");
		$this->POST['key']=md5("*%&24260883#");
		// $POST=array(
		// 	'appid'=>'36',
		// 	'deviceuid'=>'36a0152f7ea8e39c',
		// 	'devicemodel'=>'Ios',
		// 	'appversion'=>'2.4',
		// );
		$POST=$_POST;
		if($md5==$this->POST['key']){
			$this->load->model('/MyModel/mymodel');	
			$dbdata=$this->mymodel->OneSearchSQL('iqr','android_versionname,ios_versionstring',array('member_id'=>$POST['appid']));
			// print_r($dbdata);
			$version=($POST['devicemodel']=='Android')?'android_versionname':'ios_versionstring';
			if(empty($dbdata[$version])){
				$this->pdata['error_code']='1';
				$this->pdata['error_message']='查不到版本資訊';
			}elseif($dbdata[$version]==$POST['appversion']){
				$this->pdata['error_code']='2';
				$this->pdata['error_message']='版本相同';
			}else{
				$this->pdata["data"][]=array(
					"appversion"=>$dbdata[$version],
					"d_url"=>'http://'.$_SERVER['HTTP_HOST'].'/app/route/'.$POST['appid'],
				);
				if($POST['devicemodel']=='Android'){
					$this->pdata["data"][0]+=array('d_url_china'=>'');
				}
				$this->pdata["error_message"]="已有新版本，是否更新?";
				$this->pdata["error_code"]="0";
			}
			// print_r($this->pdata);
			echo json_encode($this->pdata);
		}else{
			$this->pdata['error_code']='1';
			$this->pdata['error_message']='Key比對錯誤';
			echo json_encode($this->pdata);
		}
	}
	// 改名
	public function packagename($member_id,$account,$sys_push='')
    {
        if (is_numeric(substr($account,0,1)))
            $tempstr='A';
        else
            $tempstr='';

        if($sys_push=='1'){
            $ptype="baidu";
        }else
            $ptype="";

        return $tempstr.$account .'C'. $member_id.$ptype;
    }
}