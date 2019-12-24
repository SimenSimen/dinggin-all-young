<?	
include_once dirname(dirname(dirname(__FILE__))).'/Payment/Bank/Ctbc/POSAPI.php';
include_once dirname(dirname(dirname(dirname(__FILE__)))).'/libraries/mylib/CheckInput.php';

// 中信金流
class Ctbc_model{
	public 	$MERID='',		//商店編號
			$LIDM='',		//訂單編號 最長19個字元 僅接受一般英文字母、數字及底線’_’的組合，不可出現其餘符號字元
			$PAN='',		//信用卡號及卡片背面末三碼值(CVV2/CVC2)，最大長度19位數字
			$ExpDate='',	//為信用卡之有效期限，格式固定為六碼 YYYYMM。
		   	$currency='901',//交易幣值代號。長度為3個字元的字串。(如台幣”901”)
		   	$purchAmt='',	//消費者此筆交易所購買商品欲授權總金額，正整數型態
			$exponent='0',	//為幣值指數，新台幣為0。（如美金1.23元，purchAmt給123而amtExp 則給-2）
			$ECI='',		//為電子商務交易安全等級。一般VISA卡與JCB卡SSL交易eci值須設定為7，MasterCard卡SSL交易eci值須設定為0
			$SubMerchantId='0',	//次特店商店編號(此欄位僅供代收代付平台使用)
			$ProductName='0',   //品項。注意﹕此欄位所放入的字串必需為Big5碼全形字串，最長為20個Big5碼(使用UTF8碼需轉為Big5碼)全形字。(此欄位僅供代收代付平台使用)
			$Mode='0';			//0 測試 1正式
	public function __construct (){
		$cafile=dirname(dirname(dirname(__FILE__))).'/Payment/Bank/Ctbc/server.cer';
		$this->Server=array(
			'HOST' => $this->PayUrl(),
			'PORT' => '2011',
			'CAFile' => $cafile,
			'Timeout' => 30
		);
	}
	
	// 付款入口
	public function Pay(){
		
		// DATA 交易參數
		$this->Chkarray=array('MERID','LIDM','PAN','ExpDate','purchAmt');
		// 檢查欄位
		$ChkData=array(
			'MERID'=>array(
				'ChkValue'=>$this->MERID,
				'ChkMsg'=>'商店編號'
			),
			'LIDM'=>array(
				'ChkValue'=>$this->LIDM,
				'ChkMsg'=>'訂單編號'
			),
			'PAN'=>array(
				'ChkValue'=>$this->PAN,
				'ChkMsg'=>'信用卡號及卡片背面末三碼'
			),
			'ExpDate'=>array(
				'ChkValue'=>$this->ExpDate,
				'ChkMsg'=>'有效期限'
			),
			'purchAmt'=>array(
				'ChkValue'=>$this->purchAmt,
				'ChkMsg'=>'總金額'
			),
		);

		$this->Rdata=$this->CheckInput($ChkData);
        if(empty($this->error)){
        	$Auth=$this->Auth();
        	print_r($Auth);

        	if($Auth['RespCode']==0 && $Auth['ErrCode']=="00"){
				$Cap=$this->Cap($Auth);
			}else{
				$this->AuthRev($Auth);
			}
            exit();
        }
	}
	// 取消 信用卡請款作業
	public function CancelPay(){
		// DATA 交易參數
		$this->Chkarray=array('MERID','LIDM','PAN','ExpDate','purchAmt');
		// 檢查欄位
		$ChkData=array(
			'MERID'=>array(
				'ChkValue'=>$this->MERID,
				'ChkMsg'=>'商店編號'
			),
			'LIDM'=>array(
				'ChkValue'=>$this->LIDM,
				'ChkMsg'=>'訂單編號'
			),
			'PAN'=>array(
				'ChkValue'=>$this->PAN,
				'ChkMsg'=>'信用卡號及卡片背面末三碼'
			),
			'ExpDate'=>array(
				'ChkValue'=>$this->ExpDate,
				'ChkMsg'=>'有效期限'
			),
			'purchAmt'=>array(
				'ChkValue'=>$this->purchAmt,
				'ChkMsg'=>'總金額'
			),
		);
		$this->Rdata=$this->CheckInput($ChkData);
        if(empty($this->error)){
   			$Auth=$this->Auth();

        	if($Auth['RespCode']==0 && $Auth['ErrCode']=="00"){
				$Cap=$this->Cap($Auth);
			}else{
				$this->AuthRev($Auth);
			}
            exit();
        }
	}
	// 查詢
	public function Search(){
		// DATA 交易參數
		$this->Chkarray=array('MID','ONO');
		// 檢查欄位
		$ChkData=array(
			'MID'=>array(
				'ChkValue'=>$this->MID,
				'ChkMsg'=>'特店代號'
			),
			'ONO'=>array(
				'ChkValue'=>$this->ONO,
				'ChkMsg'=>'訂單編號'
			),
			'M'=>array(
				'ChkValue'=>$this->M,
				'ChkMsg'=>'押碼KEY'
			),
		);
		$this->Rdata=$this->CheckInput($ChkData);
        if(empty($this->error)){
        	$this->GetData();
            $this->GetForm();
            $this->SendForm();
            exit();
        }
	}

	private function CheckInput($data=array()){
        
        $check=new CheckInput;
        foreach ($data as $key => $value) {
        	$check->fname[]=array('_String',$value['ChkValue'],$value['ChkMsg']);
        }        
        $this->error=$check->main();
        if(!empty($check->main())){
            echo $check->main();
            return '';
        }
        // return ;
    }
	// --Auth-- 信用卡授權作業
	private function Auth(){
		$Auth = array(
			'MERID' => $this->MERID,
			'LID-M' => $this->LIDM,
			'PAN' => $this->PAN,
			'ExpDate' => $this->ExpDate,
			'currency' => $this->currency,
			'purchAmt' => $this->purchAmt,
			'exponent' => $this->exponent,
			'ECI' => $this->ECI(),
			'BIRTHDAY' => '',
			'CAVV' => '',
			'ORDER_DESC'=> '',
			'PID' => '',
			'SubMerchantId' => '', //次特店商店編號
			'ProductName' => '', //品項
			//Travel
			'TRV_DepartDay' => '',
			'TRV_MerchantID' => '',
			'TRV_Commission' => ''
		);
		//此陣列內之值請帶入接收到的參數
		$Result = AuthTransac($this->Server,$Auth);

		return $Result;
	}
	// --AuthRevTransac--取消授權交易
	private function AuthRev($Auth){
		$AuthRev = array(
			'MERID' => $this->MERID,
			'XID' => $Auth['XID'],
			'AuthRRPID' => $Auth['AuthRRPID'],
			'currency' => $Auth['currency'],
			'orgAmt' => $Auth['amount'],
			'authnewAmt'=>'0',
			'exponent' => $Auth['exponent'],
			'AuthCode' => $Auth['AuthCode'],
			'TermSeq' => $Auth['TermSeq'],
		);
		//此陣列內之值請帶入接收到的參數
		$Result = AuthRevTransac($this->Server,$AuthRev);

		return $Result;
	}
	// Cap 信用卡請款作業
	private function Cap($Auth){
		$Cap = array(
			'MERID' => $this->MERID,
			'XID' => $Auth['XID'],
			'AuthRRPID' => $Auth['AuthRRPID'],
			'currency' => $Auth['currency'],
			'orgAmt' => $Auth['amount'],
			'capAmt' => $Auth['amount'],
			'exponent' => $Auth['exponent'],
			'AuthCode' => $Auth['AuthCode'],
			'TermSeq' => $Auth['TermSeq'],
			//Travel
			'TRV_DepartDay' => '',
			'TRV_MerchantID' => '',
			'TRV_Commission' => ''
		);
		$Result = CapTransac($this->Server,$Cap);

		return $Result;
	}
	// CapRev 
	private function CapRev($Auth){

	}
	//連接主機網址
	public function PayUrl(){
		$data="";
		switch ($this->Mode) {
			case "0"://測試環境網址
				$data="testepos.chinatrust.com.tw";
				break;
			case "1"://正式網址
				$data="epos.chinatrust.com.tw";
				break;
		}
		$this->error=empty($data)?"未取得連接主機網址":"";
		return $data;
	}

	// ECI判定
	private function ECI(){
		if(strlen($this->PAN)>=16){
			$Card=substr($this->PAN,0,1);
			if($Card==3 or $Card==4)
				$ECI='7';
			elseif($Card==5)
				$ECI='0';
			else{
				echo "<script>alert('請輸入正確的信用卡卡號');history.go(-1);</script>";
				return '';
			}

			return $ECI;
		}else
			echo "<script>alert('信用卡及後三碼加起來至少16碼');history.go(-1);</script>";
	}
}
?>