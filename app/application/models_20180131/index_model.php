<?php
class index_model extends MY_Model {

	public function __construct()
	{
		$this->load->database();
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：login_check($account, $password, $domain_id)
	// 作 用 ：判斷登入帳密是否屬於某會員
	// 參 數 ：$account 帳號
	// $password 密碼
	// $domain_id 當前網域id
	// 返回值：true, false
	// 備 注 ：條件成立將導向
	//----------------------------------------------------------------------------------- 
	public function login_check($account, $password, $domain_id)
	{
		//db_data
		$sql="
			SELECT *
			FROM  `member` 
			WHERE `account`= '".$account."' 
			AND   `domain_id`= '".$domain_id."' 
		";
		$query=$this->db->query($sql);
		$member_data=$query->row_array();

		//帳號存在
		if(!empty($member_data))
		{
			//library
			$this->load->library('encrypt');

			//檢查密碼
			$db_password=$this->encrypt->decode($member_data['password']);//decode
			if(strnatcmp($db_password, $password) == 0)
			{
				//密碼正確
				$this->session->unset_userdata('member_id');
				$this->session->unset_userdata('domain_id');
		        session_start();
				session_unset();
				$this->session->set_userdata('domain_id', $domain_id);
				$this->session->set_userdata('member_id', $member_data['member_id']);
				return 1;
			}
			else
			{
				$this->session->unset_userdata('domain_id');
				$this->session->unset_userdata('member_id');
				return 0;
			}
		}
		else
		{
			$this->session->unset_userdata('member_id');
			$this->session->unset_userdata('domain_id');
			return 0;
		}
	}

	public function login_check_v1($account, $password, $domain_id)
	{
		// new Exception();
		//db_data
		$sql="
			SELECT *
			FROM  `member` 
			WHERE `account`= ? 
			AND   `domain_id`= ? 
		";

		$query = $this -> db -> query($sql, array($account, $domain_id));
		$member_data = $query -> row_array();

		// if ((5 - $this -> session -> userdata('login_error')) <= 0)
		// {
		// 	throw new Exception('@@您已登入失敗5次，請於10分鐘後再次嘗試');
		// 	exit();
		// }

		//帳號存在
		if (!empty($member_data))
		{
			//library
			$this -> load -> library('encrypt');

			//檢查密碼
			$db_password = $this -> encrypt -> decode($member_data['password']);//decode

			if (strnatcmp($db_password, $password) == 0)
			{
				// suc
				$this->session->unset_userdata('member_id');
				$this->session->unset_userdata('domain_id');
		        @session_start();
				@session_unset();
				$this -> session -> set_userdata('domain_id', $domain_id);
				$this -> session -> set_userdata('member_id', $member_data['member_id']);
				throw new Exception("登入成功", 1);
				// return 1;
			}
			else
			{
				// error pwd
				$this -> session -> unset_userdata('domain_id');
				$this -> session -> unset_userdata('member_id');
				throw new Exception('請輸入正確密碼 \n  登入失敗，您還可以嘗試' .(5 - $this -> session -> userdata('login_error')). '次', 0);
				// return 0;
			}
		}
		else
		{
			$buyer = $this -> select_from('buyer', array('d_account' => $account, 'd_is_member' => '2'));
			
			if (!empty($buyer))
			{
				throw new Exception("會員資格審查中，請與您的專屬業務聯繫", -1);
			}
			else
			{
				throw new Exception('無此帳號，請詢問系統管理員 \n 登入失敗，您還可以嘗試' .(5 - $this -> session -> userdata('login_error')). '次', -2);
			}
			$this->session->unset_userdata('member_id');
			$this->session->unset_userdata('domain_id');
			// return 0;
		}
	}
	
	//----------------------------------------------------------------------------------- 
	// 函數名：create_dir($mid)
	// 作 用 ：建立多層資料夾
	// 參 數 ：$mid 會員id
	// 返回值：資料夾路徑
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	public function create_dir($mid)
	{
		//full relative path
		$path='/uploads/';

		$user=str_pad($mid, 10, '0', STR_PAD_LEFT);

		if($mid < 1000)
			$one = substr($user, 7, 3);
		else
			$one = $mid;
		$two   = '000';
		$three = '0000';
		
		// $one=substr($user, 7, 3);
		// $two=substr($user, 0, 3);
		// $three=substr($user, 3, 4);
	
		$dir='.'.$path.$one.'/'.$two.'/'.$three.'/'.$user;

		$temp = explode('/', $dir);
		$cur_dir = '';
		if(!is_dir($dir))
		{
			for($i = 0; $i < count($temp); $i++)
			{
				$cur_dir .= $temp[$i].'/';
				if (!is_dir($cur_dir))
					@mkdir($cur_dir,0777);
			}
		}
		else
		{
			for($i = 0; $i < count($temp); $i++)
			{
				$cur_dir .= $temp[$i].'/';
			}
		}
		return substr($cur_dir, 1, (strlen($cur_dir) - 1));
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：create_qrcode_style($member_id, $type)
	// 作 用 ：建立QRcode預設樣式
	// 參 數 ：$member_id 會員id
	// $type 類型, 0->iqr, 1->mecard
	// 返回值：無
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	public function create_qrcode_style($member_id, $type)
	{
		switch ($type) {
			case 0:
				$label = '行動商務系統 網頁版';
				$color = '#0000FF';
				break;
			case 1:
				$label = '行動商務系統 通訊錄';
				$color = '#00FF00';
				break;
			case 2:
				$label = '行動商務系統 APP版';
				$color = '#FF0000';
				break;
		}

		//default style
		$image_data=array(
			'member_id'=>$member_id,
			'type'=>$type
		);
		$qimg_id=$this->insert_into('qrc_image', $image_data);

		//default style
		$style_data=array(
			'mode'=>2,
			'size'=>400,
			'fill'=>'#000000',
			'background'=>'#FFFFFF',
			'minversion'=>6,
			'eclevel'=>'H',
			'quiet'=>1,
			'radius'=>20,
			'msize'=>7,
			'mposx'=>50,
			'mposy'=>50,
			'label'=>$label,
			'font'=>4,
			'fontcolor'=>$color,
			'member_id'=>$member_id,
			'type'=>$type,
			'qimg_id'=>$qimg_id
		);
		$id=$this->insert_into('qrc_style', $style_data);
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

	//----------------------------------------------------------------------------------- 
	// 函數名：SendMail($to, $subject, $msg, $fromName = '', $headers = 'service@i-qrcode.com', $cc="", $bcc="")
	//----------------------------------------------------------------------------------- 
	public function SendMail($to, $subject, $msg, $fromName = '', $headers = 'service@i-qrcode.com', $cc="", $bcc=""){//寄信
		$data=false;
		require_once(dirname(__FILE__).'/mail_v1/class.phpmailer.php');
		$mail = new PHPMailer();
		$mail->IsSMTP();// send via SMTP
		$mail->SMTPAuth = true; // turn on SMTP authentication打開SMTP認證
        $mail->SMTPSecure = "ssl"; //SMTP驗證方式 SSL/TLS
        $mail->Host = "smtp.gmail.com"; //SMTP主機
        $mail->Port = 465;
		$mail->CharSet = "utf-8";

		$mail->Username = "service@i-qrcode.com";//寄信主機的登入帳號
		$mail->Password = "i-qrcode24260883-mail";//寄信主機的登入密碼
		$mail->From = $headers;//寄件者mail
        if (empty($fromName)) {
    		$mail->FromName = "易大線上商城";//寄件者名稱
        } else {
    		$mail->FromName = $fromName;//寄件者名稱
        }

		//$mail->WordWrap = 50; //設定幾個字後換行
		//$mail->AddAttachment("/var/tmp/file.tar.gz");//夾檔
		//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");//夾多檔
		$mail->IsHTML(true);//網頁格式
		$mail->Subject = $subject;//信件標題
		$mail->Body = $msg;//信件內容(網頁格式)
		$tos=explode(",",$to);
		foreach($tos as $val){
			$mail->AddAddress($val);//收件者mail及名稱
		}
		if(!empty($cc)){
			$ccs=explode(",",$cc);
			foreach($ccs as $val){
				//$mail->AddAddress($val,$title);//收件者mail及名稱
			}
		}
		if(!empty($bcc)){
			$bccs=explode(",",$bcc);
			foreach($bccs as $val){
				//$mail->AddAddress($val,$title);//收件者mail及名稱
			}
		}
		if($mail->Send()){
			$mail->ClearAddresses();//清除收件者mail
			$data=true;
		}
		return $data;
	}


	public function public_get_ytb_id($url)
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
	
	//----------------------------------------------------------------------------------- 
	// 函數名：mail_setter($mails)
	// 作 用 ：管理人信箱陣列
	// 參 數 ：$mail 管理人信箱 (陣列)
	// 返回值：陣列
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	public function mail_setter($mails)
	{
		if(stristr($mails, ','))
		{
			$array = explode(',', $mails);
		}
		else
			$array[] = $mails;

		return $array;
	}

	public function inner_join($Table1, $Table2, $selcet_characters = array(), $data_where = array(), $relation1, $relation2, $data_type = '')
	{
		if(!empty($selcet_characters))
			$this -> db -> select($selcet_characters);
		else
			$this->db->select('*');

		$this -> db -> from($Table1);
		$this -> db -> join($Table2, $Table1 .".". $relation1 ."=". $Table2 .".". $relation2, 'inner');
		$this -> db -> where($data_where); 
		$query = $this -> db -> get();

		if($data_type == 'row')
			return  $query -> row_array();
		else
			return $query -> result_array();
	}
}
