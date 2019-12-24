<?php
class Appui_model extends MY_Model {

	public function __construct()
	{
		$this->load->database();
	}
	//----------------------------------------------------------------------------------- 
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
		$allowedExts = array("jpg", "png", "jpeg");
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
	// 函數名：send_mail($sender_domain, $sender, $addressee, $subject, $message)
	// 作 用 ：寄信
	// 參 數 ：$sender_domain 寄件人信箱網域名
	// $sender 寄件人
	// $addressee 收件人
	// $subject 主旨
	// $message 內容
	// 返回值：無
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	public function send_mail($sender_domain, $sender, $addressee='', $subject, $message)
	{
		//沒有收件者email不寄信
		if($addressee != '')
		{
			$config = Array(
				'protocol' 	=> 'smtp',
				'smtp_host' => 'ssl://smtp.gmail.com',
				'smtp_port' => 465,
				'smtp_user' => 'service@i-qrcode.com', 	// change it to yours
				'smtp_pass' => 'i-qrcode24260883-mail', // change it to yours
				'mailtype' 	=> 'html',
				'charset' 	=> 'utf-8',
				'wordwrap' 	=> TRUE
			);

			//email lib
			$this->load->library('email', $config);
			//enter method
			$this->email->set_newline("\r\n");
			//寄件人
			$this->email->from('server@'.$sender_domain, $sender);
			//收件人
			$this->email->to($addressee);
			//主旨
			$this->email->subject($subject);
			//內容
			$this->email->message($message);
			//寄送
			$this->email->send();
		}
	}
}