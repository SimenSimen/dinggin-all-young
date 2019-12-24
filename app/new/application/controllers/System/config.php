<?php
class Config
{
	public $setIP_array = array('36.234.169.199', '36.234.172.244','59.126.65.89');
	protected $ip_addr = '';
	
	public function index()
	{
		if (!in_array($this -> get_realip(), $this -> setIP_array))
		{
			die('2016年8月18日台北時間下午2:00 -2016年8月19日 17:00將進行系統升級作業，升級期間系統將暫停服務，造成不便懇請見諒！');
			break;
		}
	}

	private function get_realip()
	{
		if(isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
		{
			$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		elseif(isset($_SERVER["HTTP_CLIENT_IP"]))
		{
			$ip = $_SERVER["HTTP_CLIENT_IP"];
		}
		elseif (isset($_SERVER["REMOTE_ADDR"]))
		{
			$ip = $_SERVER["REMOTE_ADDR"];
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
}
$config = new Config();
$config->index();

