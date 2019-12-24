<?
abstract class DataCheckBase { // 抽象檢查
	abstract public function _DataCheck($class, $value, $fname);
}
class chk_null extends DataCheckBase { // 檢查空白
	 function _DataCheck($class, $value, $fname){
		$data = "";
		if ($value == "") {
			$data = "請輸入" . $fname . "，不可留空白";
		}
		return $data;
	}

}
class CCheckData extends DataCheckBase{
	function _DataCheck($class, $value, $fname) {
		$error="";
		if (class_exists ( $class )) {
			$DataCheckClass = new $class ();
			$error = $DataCheckClass->_DataCheck ( $class, $value, $fname );
			$this->ViewData ( $error );
		}
		return $error;
	}
	function ViewData($error){//顯示錯誤訊息//停止執行
		if (! empty ( $error )) {
			if ($this->ajax == 'ajax') { //ajax顯示方式
				echo "alert('" . $error . "');history.go(-1);";
				exit ();
			}
			elseif ($this->ajax == 'txt') { //常駐程式顯示方式
				//不停止只傳回錯誤訊息資料//可直接取 $this->error 的最後一次錯誤訊息
				echo $error."<BR>";
				return $error;
			}
			elseif ($this->ajax == 'NotShow') { //常駐程式顯示方式
				//不停止只傳回錯誤訊息資料//可直接取 $this->error 的最後一次錯誤訊息
				return $error;
			}
			else { // 網頁方式
				echo "<script>alert('" . $error . "');history.go(-1);</script>";
				exit ();
			}
		}
	}
}
class Check extends CCheckData{ // 處理回傳資料
	public $rq = array (); // 回傳變數
	public $error = ""; // 回傳錯誤訊息
	public $fname = array (); // 傳入檢查的資料
	public $ajax = ""; // 顯示的方式
	public function main() {
		if (! empty ( $this->fname )) {
			foreach ( $this->fname as $key => $val ) { // 0檢查類別1名稱2值3說明
				if (count ( $val ) == "4") {
					$class=(substr ( $val [0], 0, 2 ) == "__")?substr ( $val [0], 1 ):$val [0];
					if (class_exists ( $class )) { // 要檢查
						$value_array = array ($val [2]);
						if (is_array ( $val [2] )) { // 陣列處理轉換
							$value_array = $val [2];
						}
						foreach ( $value_array as $array_number => $value ) {
							if (empty ( $this->error )) {
								if (!(substr ( $val [0], 0, 2 ) == "__" && trim ( $value ) == "")) {// 可以是空白,但如果有值就要檢查
									$this->error = $this->_DataCheck ( $class, trim ( $value ), $val [3] );
								}
							}
							if (is_array ( $val [2] )) {
								$this->rq [$val [1]] [$array_number] = $value; // 增加回傳值
							} else {
								$this->rq [$val [1]] = $value; // 增加回傳值
							}
						}
					} else { // 不用檢查
						$this->rq [$val [1]] = $val [2];
					}
				} else {
					$this->error = $this->ViewData ( "傳入檢查參數錯誤" );
				}
			}
		}
	}
}