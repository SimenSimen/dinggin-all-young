<?php
/**
* Specific API
*/
class Specific
{
	// Agreement
	public $IOS_SCHEMES = 'callmelaleuca888://';
	public $ANDROID_SCHEMES = 'businesscard://';

	// User's Elements
	public $ANDROID_HOST = 'com.appplus.businesscard/';
	public $ANDROID_PATHPREFIX = 'IntentDataActivity/';
	public $ELEMENTS = array('');
	public $I_ELEMENTS = array('');
	// ELEMENTS -> key[0] = GoToURL
	// 			-> key[1] = APP Download URL
	public $GOOGLE_STORE = '#';
	public $ITUNES_STORE = '#';

	public $WEB_SESSION = 'website_name';

	// Box Module
	public function index()
	{
		$data = $this -> get_url();
		if ($data["OS"] == 'windows')
		{
			// Windows Events
			// Building The Qrcode
			echo '<a href="'.$data["url"].'">前往官網</a>';
		}
		else
		{
			// Android, iOS View
			// Android Should Click "a" Button
			echo '<a href="' .$data["start_url"]. '">啟動應用程式</a>';

			// Using to Testing
			echo "<h2>" .$data["start_url"] ."</h2>";
			echo '<br><br><br>';
			echo '<a href="' .$data["store_url"]. '">下載應用程式</a>';
			echo "<h2>" .$data["store_url"] ."</h2>";
		}
	}

	public function get_url()
	{
		$app_elements = '';

		$data = array(
			"OS" 			=> "",
			"script_url" 	=> "",
			"start_url" 	=> "",
			"store_url" 	=> ""
		);

		$device_os = $this -> get_device_os();

		if ($device_os == 'windows')
		{
			// Windows Events
			$data["OS"] = "windows";
			$data["url"] = $this -> ELEMENTS[1];
		}
		else
		{

			if ($device_os == 'android')
			{
				$app_elements = $this -> app_converter($this -> ELEMENTS);
				$data["start_url"] = $this->ANDROID_SCHEMES . $this->ANDROID_HOST . $this->ANDROID_PATHPREFIX . $app_elements;
				$data["script_url"] = $this->ANDROID_SCHEMES . $this->ANDROID_HOST . $this->ANDROID_PATHPREFIX . $app_elements;
				$data["store_url"] = $this->GOOGLE_STORE;
			}
			else if ($device_os == 'ios')
			{
				$app_elements = $this -> app_converter($this -> I_ELEMENTS);
				$data["start_url"] = $this->IOS_SCHEMES . $app_elements;
				$data["script_url"] = $this->IOS_SCHEMES . $app_elements;
				$data["store_url"] = $this->ITUNES_STORE;

				// iOS Daemon Open APP, Android Could not
				// echo '<script type="text/javascript">';
				// echo 'location.href="' .$data["script_url"] . '";';
				// echo '</script>';
			}
		}
		return $data;
	}

	private function app_converter($elements_array)
	{
		$elements = '';
		if (!empty($elements_array)) {
			foreach ($elements_array as $key => $value)
			{
				if ($key > 0)
					$elements .= '/';
				$elements .= rawurlencode($value);
			}
		}
		return $elements;
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：save_data()
	// 作 用 ：儲存 REQUEST_URI 資料
	// 參 數 ：無
	// 返回值：無
	// 備 注 ：檢查是否登入時呼叫
	//----------------------------------------------------------------------------------- 
	function save_data()
	{
		$_SESSION["login_after"][$this->WEB_SESSION]["REQUEST_URI"] =$_SERVER["REQUEST_URI"];
		$_SESSION["login_after"][$this->WEB_SESSION]["_POST"]=$_POST;
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：gotourl()
	// 作 用 ：轉跳至登入前要去的網頁
	// 參 數 ：無
	// 返回值：無
	// 備 注 ：登入檢查成功後呼叫
	//----------------------------------------------------------------------------------- 
	function gotourl()
	{
		if (!empty($_SESSION["login_after"][$this->WEB_SESSION]["REQUEST_URI"])) {
			echo '<form id="login_after_go" action="' .$_SESSION["login_after"][$this->WEB_SESSION]["REQUEST_URI"]. '" method="post">';
			if (!empty($_SESSION["login_after"][$this->WEB_SESSION]["_POST"])) {
				foreach($_SESSION["login_after"][$this->WEB_SESSION]["_POST"] as $key=>$val){
					echo '<input type="hidden" name="' .$key. '" value="' .$val. '">';
				}
			}
			echo '</form>';
			echo '<script>document.getElementById("login_after_go").submit()</script>';
			unset($_SESSION["login_after"]);
			exit();
		}
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：get_device_os()
	// 作 用 ：檢查開啟網頁作業系統
	// 參 數 ：無
	// 返回值：裝置系統名稱
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	private function get_device_os()
	{
		$device = '';

		if(preg_match('/(Android)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
		    $device = 'android';
		else if(preg_match('/(iPhone|iPad|iPod)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
		    $device = 'ios';
		else if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') > 0)
		    $device = 'windows';

		return $device;
	}
}