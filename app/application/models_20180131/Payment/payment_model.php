<?	
include_once dirname(dirname(dirname(__FILE__))).'/libraries/mylib/useful.php';

// 中信
include_once dirname(dirname(dirname(__FILE__))).'/models/Payment/Bank/Ctbc_model.php';

// 金流入口
class Payment_model {
	// 入口
	public function index($BankArray,$PayArray){
		$Useful=new useful();
		if (class_exists($BankArray['Bank'].'_model')) {
			$Model=$BankArray['Bank'].'_model';
		    $payment=new $Model();

		    $this->GetValue($payment,$PayArray);
		    
		    $BankFunc=$BankArray['BankFunc'];
			$payment->$BankFunc();
		}else
		    $Useful->AlertPage('','無此函式');
	}
	// 參數處理
	private function GetValue($payment,$PayArray){
		if(!empty($PayArray)){
	    	foreach ($PayArray as $key => $value) {
				$payment->$key=$value;
			}
	    }else
	    	$this->useful->AlertPage('','資料錯誤');
	}
}
?>