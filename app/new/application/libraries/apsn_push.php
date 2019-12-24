<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/*
    -----------------------
    Sample data
    -----------------------
    $device_token = '2df4a271892cf4acf594e7064ee33558372ebd14b1e1260e069db66e462f540f';
    $pem          = '/var/www/vhosts/topapp.com.tw/httpdocs/AppPlus/attachments/date_201302/6a38af4eb5192f66fbfa084c3698d7f7.pem'; 
    $message      = 'Hello World';
    $pem          = new Apsn_push($pem);
    echo $pem->push_notification($device_token, $meg);

    -----------------------
    $message     = $msg;        // 訊息
    $pass        = $this->pass; // pem檔案位置
    $device_token = $devices;    // 傳送裝置編號
    -----------------------
            
*/
class Apsn_push
{
	var $pass         = ''; // 絕對路徑
	var $device_token = '';
	var $message      = '';
	
	public function __construct ($pem = '')
	{
		$this->pass = $pem;
	}

	public function push_notification($device_token = '', $message = '' , $sound = '')
	{
		if($device_token == '' || $message == '')
		{
			return '01';
		}
		
		// Get the parameters from HTTP get or from command line
		// echo $message = $_GET['message'] or $message = $argv[1] or $message ;
		$badge = (int)$_GET['badge'] or $badge = (int)$argv[2];

		// $sound = $_GET['sound'] or $sound = $argv[3];
		// Construct the notification payload
		$body = array();
		$body['aps'] = array('alert' => $message);

		// if ($badge)	$body['aps']['badge'] = '1';

		$body['aps']['badge'] = '1';
		if ($sound)	$body['aps']['sound'] = $sound;

		// $body['aps']['sound'] = $sound;
		
        // End of Configurable Items
		$ctx = stream_context_create();
		$stream_context_set_option = stream_context_set_option($ctx, 'ssl', 'local_cert',  $pass);

		$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);

		// connect to apns
		if (!$fp)
		  return '02';

		// send message
		$payload = json_encode($body);
		@$msg    = chr(0) . pack("n",32) . pack('H*', str_replace(' ', '', $device_token)) . pack("n",strlen($payload)) . $payload;

		fwrite($fp, $msg);
		fclose($fp);

		return 1; // success
	}
}