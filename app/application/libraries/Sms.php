<?
//簡訊發送服務
class Sms
{
	
	public function __construct ($custID = '', $userID = '',$password='')
	{
		$this->custID = $custID;
		$this->userID = $userID;
		$this->password = $password;
	}

	public function Send_sms($subject,$content,$mobile,$email,$sendTime)
	{
		$login_wsdl = "http://tw.every8d.com/API20/Security.asmx?wsdl";
	    $sms_wsdl = "http://tw.every8d.com/API20/Message.asmx?wsdl";
	    
	    $custID =$this->custID;
	    $userID=$this->userID;  
	    $password=$this->password; 
	    $client = new SoapClient($login_wsdl);
	    // login
	    $params = array("custID"=>$custID,"userID"=>$userID,"password"=>$password,"APIType"=>"","version"=>""); 
	    $objResult =$client->Login($params);
	    $xmlstr= $objResult->LoginResult;
	    
	    $xml = new SimpleXMLElement($xmlstr);
	    
	    if($xml->ERROR_CODE =="0000"){
	    	
	    	$str= "Login successfully<br/>";
	    }else{
	    	$str= "Login Failure!<br/>";
	    	exit;
	    }
	    
	    // // send sms
	    
	    $UserNo = $xml->USER_NO;      //±qµn¤Jµ²ªG¨ú±oUserNo
	    $CompanyNo = $xml->COMPANY_NO; //±qµn¤Jµ²ªG¨ú±oCompany_No
	    $Credit = $xml->CREDIT;        //±qµn¤Jµ²ªG¨ú±o¥Ø«e³Ñ¾lÃB«×
	    // $subject = "test";   //µo°e¥D¦®
	    // $content = "hello";  //µo°e¤º®e
	    
	    // $mobile = "0922056303"; //µo°e¸¹½X
	    // $email = "roger@every8d.com.tw";  //µo°eemail¦ì¸m
	    // $sendTime= "";  //µo°e®É¶¡
	    
	    $sms_xml =	'<REPS>';
	    $sms_xml .=		'<IP></IP>';
	    $sms_xml .=		'<CARD_NO/>';
	    $sms_xml .=		'<USER NAME="" MOBILE="'.$mobile.'" EMAIL="'.$email.'" SENDTIME="'.$sendTime.'" PARAM=""/>';
	    $sms_xml .=	'</REPS>';


	    
	    $params_sms = array("custID"=>$custID,
	    			"CompanyNo"=>$CompanyNo,
	    			"userNo"=>$UserNo,
	    			"sendtype"=>"110",
	    			"msgCategory"=>"10",
	    			"subject"=>$subject,
	    			"content"=>$content,
	    			"image"=>"",
	    			"Audio"=>"",
	    			"xml"=>$sms_xml,
	    			"batchID"=>"",
	    			"certified"=>"");
	    
	    $sms_Service = new SoapClient($sms_wsdl);		
	    $sendResult = $sms_Service->QueueIn($params_sms);
	    $sendResultStr = $sendResult->QueueInResult;
	    if( substr($sendResultStr,0,1) =="-"){
	        $str.= "Send SMS Failure!<br/>";	
	    }else{
	    	$str.= "Send SMS Successfully<br/>";
	    }
	    return $str;
	}
}
?>