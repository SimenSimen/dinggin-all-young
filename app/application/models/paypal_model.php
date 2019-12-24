<?php
class Paypal_model extends MY_Model {

	public function __construct()
	{
		$this->load->database();
	}

	//posts transaction data using fsockopen.
	public function fsockPost($url,$data)
	{
		// echo "fsockPost<BR>";
		//Parse url
		$web=parse_url($url);

		//build post string
		foreach($data as $i=>$v)
		{
			$postdata.= $i . "=" . urlencode($v) . "&";
		}

		$postdata.="cmd=_notify-validate";

		//Set the port number
		if($web[scheme] == "https") { $web[port]="443";  $ssl="ssl://"; } else { $web[port]="80"; }

		//Create paypal connection
		$fp=@fsockopen($ssl . $web[host],$web[port],$errnum,$errstr,30);

		//Error checking
		if(!$fp)
		{
			// echo "$errnum: $errstr";
		}
		else //Post Data
		{
			fputs($fp, "POST $web[path] HTTP/1.1\r\n");
			fputs($fp, "Host: $web[host]\r\n");
			fputs($fp, "Content-Type: application/x-www-form-urlencoded\r\n");
			fputs($fp, "Content-length: ".strlen($postdata)."\r\n");
			fputs($fp, "Connection: close\r\n\r\n");
			fputs($fp, $postdata . "\r\n\r\n");

			//loop through the response from the server
			while(!feof($fp)) { $info[]=@fgets($fp, 1024); }

			//close fp - we are done with it
			fclose($fp);

			//break up results into a string
			$info=implode(",",$info);
		}

		return $info;
	}

	//檢查ipn收到的txn_id是否重複
	public function chk_txn_id($txn_id)
	{
		$sql 	= 'select * from `ipn` where `txn_id`=\''.$txn_id.'\';';	
		$query  = $this->db->query($sql);
		$data 	= $query->result_array();
		if(!empty($data))
			return false;
		else
			return true;
	}

}