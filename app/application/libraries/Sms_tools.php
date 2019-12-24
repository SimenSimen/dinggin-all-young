<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms_tools{
	private $_ci, $_sms, $_account, $_passwd, $_subject, $_content, $_mobile, $_error_code;

	public function __construct(){
		$this->_ci =& get_instance();
		require('SMSHttp.php');
		$this->_account = '28778071';
		$this->_passwd = '8071';
		/*
		 * $this->load->library('sms_tools');
			$this->sms_tools->subject = 'aaa from test sms';
			$this->sms_tools->content = 'test test test as test';
			$this->sms_tools->mobile = '0912632338';
			echo 'SMS: ' . $this->sms_tools->sendSms();echo ' error code: ' . $this->sms_tools->getErrorCode();
		 */
	}

	public function __set($name, $val){
		if (property_exists(__CLASS__, '_' . $name)){
			$this->{'_' . $name} = $val;
		}
	}

	/**
	 * 寄送簡訊 1:台灣 2:印尼
	 * @param number $flag
	 * @return boolean
	 */
	public function sendSms($flag=1){
		if ($flag == 1){
			if ($this->check()){
				$this->_sms = new SMSHttp();
				if ($this->_sms->getCredit($this->_account, $this->_passwd)){
					if ($this->_sms->sendSMS($this->_account, $this->_passwd, $this->_subject, $this->_content, $this->_mobile, '')){
						$this->_error_code = '00';//發送成功
						return true;
					}else{
						$this->_error_code = '01';//發送失敗
					}
				}else{
					$this->_error_code = '03';//餘額不足
				}
			}else{
				$this->_error_code = '05';//資料輸入不全
			}
			return false;
		}else if ($flag == 2){
			$this->id_sms();
		}
	}

	public function getErrorCode(){
		return $this->_error_code;
	}

	private function check(){
		if (empty($this->_account) || empty($this->_passwd) || empty($this->_subject) || empty($this->_content) || empty($this->_mobile)){
			return false;
		}else if (!preg_match('/^\d+$/', $this->_mobile)){
			return false;
		}
		return true;
	}

	private function id_sms(){
		$pecah					= explode(",",$this->_mobile);
		$jumlah					= count($pecah);
		$from						= "268F5EDB771028B0228C745E12BF89A1"; //Sender ID or SMS Masking Name, if leave blank, it will use default from telco
		$username			= "dorisallyoungtw"; //your smsviro username
		$password				= "28778071AYidapp"; //your smsviro password
		$postUrl					= "http://107.20.199.106/restapi/sms/1/text/advanced"; # DO NOT CHANGE THIS

		for($i=0; $i<$jumlah; $i++){
			if(substr($pecah[$i],0,2) == "62" || substr($pecah[$i],0,3) == "+62"){
				$pecah = $pecah;
			}elseif(substr($pecah[$i],0,1) == "0"){
				$pecah[$i][0] = "X";
				$pecah = str_replace("X", "62", $pecah);
			}else{
				echo "Invalid mobile number format";
			}
			$destination = array("to" => $pecah[$i]);
			$message     = array("from" => $from,
					"destinations" => $destination,
					"text" => $this->_content,
					"smsCount" => 2);
			$postData           = array("messages" => array($message));
			$postDataJson       = json_encode($postData);
			$ch                 = curl_init();
			$header             = array("Content-Type:application/json", "Accept:application/json");

			curl_setopt($ch, CURLOPT_URL, $postUrl);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
			curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataJson);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$response = curl_exec($ch);
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$responseBody = json_decode($response);
			curl_close($ch);
		}
	}

	/**
	 * 20180524 亂數產生一組指定位數的碼
	 * @param number $num
	 * @return string
	 */
	public function getCode($num=16, $mykey=0){
		$strNum = "";
		$en1 = array();
		$en2 = array();
		$en3 = array();
		for ($x =0;$x < 26;$x++){
			if ($x < 10) $en3[$x] = $x+48;
			$en1[$x] = $x+97;
			$en2[$x] = $x+65;
		}
		$en4 = array(35,36,40,41,45,60,62,64,91,93,94,95,123,125);

		for ($i = 0;$i < $num;$i++){
			$succ = '';
			$key = ((int)rand(0, 100)%4)+1;
			//2019-02-21 若有指定值，則使用指定的值來產生亂數
			if ($mykey > 0 && $mykey < 5){
				$succ = ${'en' . $mykey};
			}else if ($mykey == '-4' && $key == 4){
				$key = ((int)rand(0, 100)%3)+1;
				$succ = ${'en' . $key};
			}else{
				$succ = ${'en' . $key};
			}
			$skey = ((int)rand(0, 100)%count($succ))+1;
			$strNum .= chr($succ[$skey-1]);
		}

		return $strNum;
	}
}