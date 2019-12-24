<?php
	class Gcm_push
	{
	    /*
	    Set the api key for using push service.
	    Note that if you send by "cUrl" , you should ask a "Browser Key"!
	    $api_server_key = "";
	    */
	    var $GOOGLE_API_KEY         = '';
	    //var $GOOGLE_CLOUD_MESSAGING = 'https://android.googleapis.com/gcm/send'; // Google Cloud Messaging Service path for push notification 
	    var $GOOGLE_CLOUD_MESSAGING = 'https://fcm.googleapis.com/fcm/send';
	    var $contentType            = 'application/json'; // content type for your data format
	    
	    public function __construct ($api_server_key = '')
	    {
	        $this->GOOGLE_API_KEY = $api_server_key;
	    }
	    
	    /* the main function to send message */
	    public function push_notification($device_token_array = '', $message = '', $notifyType = '')
	    {
	        /* 
	            there are example data.
	            if un note this section , you can use some fake data for testign 
	            $device_token_array  = array("50");
	            $notifyType = "packages";
	        */
	        if(!is_array($device_token_array))
	        	$device_token_array = array($device_token_array);
	        
	        //if data is null , then return false 
	        if( count($device_token_array) <= 0 /*or trim($message) == ""*/) 
	            return false; 
	        
	        $push_messagess = $message['title']."@@".$message['image']."@@".$message['message'];

	        $post_fields = array(
	            'data' => array(
	                'action'   => $push_messagess,
	                "dataType" => $notifyType
	            ),
	            'registration_ids' => $device_token_array
	        );
	        $post_fields = json_encode($post_fields);
	        
	        $headers = array( 
	            "Authorization: key=".$this->GOOGLE_API_KEY,
	            "Content-Type: ".$this->contentType
	        );

	        /* initial the curl object */
	        $curl = curl_init();
	        curl_setopt($curl, CURLOPT_URL, $this->GOOGLE_CLOUD_MESSAGING);
	        curl_setopt($curl, CURLOPT_POST, true );             //啟用POST
	        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true );   //將curl_exec()獲取的訊息以文件流的形式返回，而不是直接輸出。
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false );  //不驗證SSL憑證
	        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers );   //加入header
	        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_fields); //傳入POST內容
	        $curl_result = curl_exec($curl);

	        if($curl_result)
	        {
	            return json_decode($curl_result, true);
	        }
	        else
	        {
	            return false;
	        }
	    }
	}

	class Apns_push
	{
		var $pass         = ''; // 絕對路徑
		var $device_token = '';
		var $message      = '';

		public function __construct ($pem = '')
		{
			// pem file
			$this->pass = $pem;
		}

		public function push_notification($device_token = '', $message = '' , $sound = '')
		{
			if($device_token == '' || $message == '')
			{
				$return['success'] = 0;
				$return['failure'] = 1;
				$return['canonical_ids'] = 'error';		
				$return['result_error'] = 'token and message error';
				// return '01';
			}
			// Get the parameters from HTTP get or from command line
			// echo $message = $_GET['message'] or $message = $argv[1] or $message ;
			$badge = (int)$_GET['badge'] or $badge = (int)$argv[2];

			// Construct the notification payload
			$body['aps'] = array(
				'alert' => $message,
				'sound' => 'default',
				'badge' => 1,
			);
	        // End of Configurable Items
			$ctx = stream_context_create();
			$stream_context_set_option = stream_context_set_option($ctx, 'ssl', 'local_cert',  $this->pass);

			$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

			// connect to apns
			if (!$fp)
			{
				// 自定義，連線錯誤訊息
				$return['success'] = 0;
				$return['failure'] = 1;
				$return['canonical_ids'] = 'error';		
				$return['result_error'] = 'content error';		
			  	// return '02';
			}

			// send message
			$payload = json_encode($body);
			$msg    = chr(0) . pack("n",32) . pack('H*', $device_token) . pack("n",strlen($payload)) . $payload;

			fwrite($fp, $msg);
			fclose($fp);

			if(!$return['failure'])
			{
				// 自定義成功訊息
				$return['success'] = 1; // success
				$return['failure'] = 0; // success
				$return['canonical_ids'] = 'success';		
				$return['result_error'] = '';		
			}
			return $return;
		}
	}

	// user , pwd
/*	$conn = mysql_connect("192.168.1.200", "jcymall", "B6niUc2xPLka369J");
	mysql_query("SET NAMES utf8");
	// db name
	mysql_select_db("jcymall");
*/
	define('BASEPATH','');//database.php使用,不然會有錯誤
	if(ini_get('date.timezone') == '')
	{
		date_default_timezone_set('Asia/Taipei');
	}
	include_once dirname(dirname(__FILE__)).'/config/database.php';
	// user , pwd
	$conn = mysql_connect($db['default']["hostname"], $db['default']["username"], $db['default']["password"]);
	mysql_query("SET NAMES utf8");
	// db name
	mysql_select_db($db['default']["database"]);
	$api_server_key = $_SERVER['argv'][1];
	$member_id = $_SERVER['argv'][2];

	// 訊息撈取
		$sql  = "SELECT * FROM `push_log`";
		$sql .= " WHERE p_id = '".$_SERVER['argv'][5]."'";
		$result = mysql_query($sql);
		$push_log = mysql_fetch_assoc($result);
	$message = array(
		'title' 	=> $push_log['title'],
		'image' 	=> $push_log['image'],
		'message'   => $push_log['message'],
	);

	// Android token 撈取
		$sql  = "SELECT * FROM `push_device`";
		$sql .= " WHERE member_id ='".$member_id."'";
		$sql .= " AND sys = 'android'";
		$sql .= " AND domain_id = '".$push_log['domain_id']."'";
		$sql .= " ORDER BY id ASC";
		$result = mysql_query($sql);
		while ($row = mysql_fetch_array($result))
		{
			$push_Android_device[] = $row;
		}

		if(!empty($push_Android_device))
		{
			foreach ($push_Android_device as $key => $value)
			{
				$device_token_array[] = $value['device_token'];
			}
		}

	// iOS token 撈取
		$sql  = "SELECT * FROM `push_device`";
		$sql .= " WHERE member_id ='".$member_id."'";
		$sql .= " AND sys = 'ios'";
		$sql .= " AND domain_id = '".$push_log['domain_id']."'";
		$sql .= " ORDER BY id ASC";
		$result = mysql_query($sql);
		while ($row = mysql_fetch_array($result))
		{
			$push_iOS_device[] = $row;
		}
		if(!empty($push_iOS_device))
		{
			foreach ($push_iOS_device as $key => $value)
			{
				$iOS_device_token_array[] = $value['device_token'];
			}
		}

	// Android Push
		if(!empty($api_server_key) && !empty($device_token_array))
		{
			$gcm_push = new Gcm_push($api_server_key);
			$push_result = $gcm_push->push_notification($device_token_array, $message);

			$sql  = "INSERT INTO push_request_log(`user`, `to`, `multicast_id`, `success`, `failure`, `canonical_ids`, `create_time`, `system`)";
			$sql .= "VALUE ('".$_SERVER['argv'][4]."', '".$member_id."', '".$push_result['multicast_id']."', '".$push_result['success']."', '".$push_result['failure']."', '".$push_result['canonical_ids']."', '".date('Y-m-d H:i:s', $push_log['create_time'])."', 'android')";
		    mysql_query($sql);
		}
	
	// iOS Push
		$pem_file = $_SERVER['argv'][3];
		$Apns_push = new Apns_push($pem_file);
		if(!empty($iOS_device_token_array) && !empty($pem_file))
		{
		    foreach ($iOS_device_token_array as $key => $value) {
		        $Apns_push_result = $Apns_push->push_notification($value, $push_log['title']);
		        $success = $Apns_push_result['success'] + $success;
		        $failure = $Apns_push_result['failure'] + $failure;
		    }
		    $Apns_push_result['success'] = $success;
		    $Apns_push_result['failure'] = $failure;
		    $sql  = "INSERT INTO push_request_log(`user`, `to`, `multicast_id`, `success`, `failure`, `canonical_ids`, `result_error`, `create_time`, `system`)";
		    $sql .= "VALUE ('".$_SERVER['argv'][4]."', '".$member_id."', '".$Apns_push_result['multicast_id']."', '".$Apns_push_result['success']."', '".$Apns_push_result['failure']."', '".$Apns_push_result['canonical_ids']."', '".$Apns_push_result['result_error']."', '".date('Y-m-d H:i:s', $push_log['create_time'])."', 'ios')";
		    mysql_query($sql);
		}

?>