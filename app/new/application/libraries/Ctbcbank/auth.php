<?php
class Auth
{
	public $Server=array();
	public 	$MERID='',	//特店編號
			$LIDM='',	//訂單編號
			$PAN='',	//信用卡號及卡片背面末三碼
			$ExpDate='',	//信用卡之有效期限，格式固定為六碼 YYYYMM。
			$currency='',	//交易幣值代號。長度為3個字元的字串。(如台幣”901”)
			$purchAmt='',	//消費者此筆交易所購買商品欲授權總金額，正整數型態。
			$exponent='',	//為幣值指數，新台幣為0。（如美金1.23元，purchAmt給123而amtExp 則給-2）
			$ECI='';	//電子商務交易安全等級。一般VISA卡與JCB卡SSL交易eci值須設定為7，MasterCard卡SSL交易eci值須設定為0



	public function __construct()//初始化
    {
		
		$cafile = dirname(__FILE__)."/server.cer";
		$this->Server = array(
			'HOST' => 'testepos.chinatrust.com.tw',
			'PORT' => '2011',
			'CAFile' => $cafile,
			'Timeout' => 30
		);

		$this->MERID='10533';	//特店編號
		$this->currency='901';	//交易幣值代號。長度為3個字元的字串。(如台幣”901”)
		$this->exponent='0';	//為幣值指數，新台幣為0。（如美金1.23元，purchAmt給123而amtExp 則給-2）
		$this->ECI='7';	//電子商務交易安全等級。一般VISA卡與JCB卡SSL交易eci值須設定為7，MasterCard卡SSL交易eci值須設定為0
	}
	
	/* --Auth-- */
	public function creditcard($order_id=''){
		include 'POSAPI.php';
		$Auth = array(
			'MERID' => $this->MERID,
			'LID-M' => 'NPGtestlidm',
			'PAN' => '4560511000001211796',
			'ExpDate' => '201901',
			'currency' => $this->currency,
			'purchAmt' => '168',
			'exponent' => $this->exponent,
			'ECI' => $this->ECI,
		);

		$Result = AuthTransac($this->Server,$Auth);
		print("Auth Result");
		print_r($Result); 
		if($Result['RespCode']==0 && $Result['ErrCode']=="00")
		{
			$MERID="3";
			$XID=$Result['XID'];

			$AuthRRPID=$Result['AuthRRPID'];
			$currency=$Result['currency'];
			$orgAmt=$Result['amount'];
			$exponent=$Result['exponent'];
			$authnewAmt=0;
			$AuthCode=$Result['AuthCode'];
			$TermSeq=$Result['TermSeq'];
			$AuthRev = array(
				'MERID' => $MERID,
				'XID' => $XID,
				'AuthRRPID' => $AuthRRPID,
				'currency' => $currency,
				'orgAmt' => $orgAmt,
				'authnewAmt'=> $authnewAmt,
				'exponent' => $exponent,
				'AuthCode' => $AuthCode,
				'TermSeq' => $TermSeq
			);
			$Result = AuthRevTransac($Server,$AuthRev );
			print("AuthRev Result");
			print_r($Result);
		}
	}
}
