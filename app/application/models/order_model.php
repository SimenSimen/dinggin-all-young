<?php
class Order_model extends MY_Model {

	public function __construct()
	{
		$this->load->database();
		$this->db_name = 'order';
		$this->db_namedetails = 'order_details';
		$this->db_nameproducts = 'products';
	}

	/**
	 * 取得訂單列表
	 * @return array stdClass db
	 */
	public function orderList($by_id,$page_limit,$Topage,$orderNumber,$date){
		$sql_where ="where o.`by_id`=$by_id";
		if(!empty($orderNumber)){
			$sql_where .=" and o.`order_id`='$orderNumber'";
		}
		if(!empty($date)){
			$date[0]=$date[0].' 00:00:00';
			$date[1]=$date[1].' 23:59:59';
			$sql_where .=" and (o.`create_time` BETWEEN '$date[0]' and '$date[1]' )";
		}
		$start_rec	=	($Topage-1) * $page_limit;	//	起始記錄編號
    	$sql="SELECT o.`id`, o.`order_id`, o.`create_time`, o.`status`,o.`product_flow`,o.`deadline`,o.`receipt_num`
    			FROM `$this->db_name` as o
    			$sql_where order by o.`id` DESC LIMIT $start_rec, $page_limit";
    	$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function orderDetail($id, $by_id){
		$sql_where ="where od.`oid`=$id and od.`by_id` = $by_id";
    	$sql="SELECT od.`prd_name`,od.`prd_spec`, od.`number`, od.`number`, od.`price`, od.`total_price`, od.`prd_id`, p.`prd_image`
    			FROM `$this->db_namedetails` as od
    			Inner JOIN `$this->db_nameproducts` as p ON p.`prd_id`=od.`prd_id` $sql_where order by od.`id` ASC";
    			//echo $sql;die;
    	$query = $this->db->query($sql);
    	$result['data']=$query->result_array();
    	$result['num']=$query->num_rows();
		return $result;
	}
	public function memberOrderList($member_id,$page_limit,$Topage,$orderNumber,$date){
		$sql_where ="where o.`member_id`=$member_id";
		if(!empty($orderNumber)){
			$sql_where .=" and o.`order_id`='$orderNumber'";
		}
		if(!empty($date)){
			$date[0]=$date[0].' 00:00:00';
			$date[1]=$date[1].' 23:59:59';
			$sql_where .=" and (o.`create_time` BETWEEN '$date[0]' and '$date[1]' )";
		}
		$start_rec	=	($Topage-1) * $page_limit;	//	起始記錄編號
    	$sql="SELECT o.`id`, o.`order_id`, o.`name`, o.`create_time`, o.`status`,o.`product_flow`
    			FROM `$this->db_name` as o
    			$sql_where order by o.`id` DESC LIMIT $start_rec, $page_limit";
    	$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function memberOrderDetail($id, $member_id){
		$sql_where ="where od.`oid`=$id and o.`member_id` = $member_id";
    	$sql="SELECT od.`prd_name`, od.`number`, od.`number`, od.`price`, od.`total_price`, od.`prd_id`, p.`prd_image`
    			FROM `$this->db_namedetails` as od
    			Inner JOIN `$this->db_nameproducts` as p ON p.`prd_id`=od.`prd_id`
    			Inner JOIN `$this->db_name` as o ON o.`id`=od.`oid`
    			$sql_where order by od.`id` ASC";
    			//echo $sql;die;
    	$query = $this->db->query($sql);
    	$result['data']=$query->result_array();
    	$result['num']=$query->num_rows();
		return $result;
	}

	public function orderdata($id){
		$sql_where ="where o.`id`=$id";
		// Nicky 新增發票號碼
    	$sql="SELECT o.`order_id`, o.`member_id`, o.`name`, o.`phone`, o.`address`, o.`pay_way_id`, o.`lway_price`, o.`lway_id`, o.`status`, o.`pay_price`, o.`total_price`, o.`price_money`, o.`use_dividend`, o.`use_dividend_cost`, o.`atmno`, o.`atmdate`, o.`trade_date`, o.`shop_id`, o.`total_lv`, o.`back_name`, o.`back_bank`, o.`back_account`, o.`back_note`, o.`apply_back_date`, o.`product_flow`,o.`bonus`,o.`create_time`,o.`country`,o.`county`,o.`area`,o.`deadline`,o.`atmpayment`,o.`alipay_id`,o.`alipay_status`,o.`alipay_trade_date`,o.`buyer_note`, o.`receipt_num`,o.`use_shopping_money`,o.`tracking_num`,o.`tracking_name`
    			FROM `$this->db_name` as o $sql_where ";
    	$query = $this->db->query($sql);
		return $query->row_array();
	}

	//會員匯款通知更改訂單及狀態
	public function orderRemit($id, $atmno, $atmdate){
		$sql="UPDATE `$this->db_name` SET atmno = '$atmno', atmdate = '$atmdate', status = 3 where `id`= $id";
		$query = $this->db->query($sql);
		return ;
	}

	public function search_session($search_default_array){//查詢整理
		$data=$this->check_session($search_default_array,"AT");
		if(!empty($_SESSION["AT"]["where"]["ToPage"])){//給跳頁使用
			$_POST["ToPage"]=$_SESSION["AT"]["where"]["ToPage"];
		}
		return $data;
	}
	public function check_session($search_default_array,$ST){//查詢整理
		@session_start();

		if(Comment::SetValue("del_search")=="Y" || Comment::Set_GET("del_search")=="Y"){//每個功能轉換時將查詢資料清空
			$_SESSION[$ST]["where"]=array();

		}
		if(!empty($search_default_array)){
			foreach($search_default_array as $val){
				if(!isset($_SESSION[$ST]["where"][$val])){
					$_SESSION[$ST]["where"][$val]="";
				}
				if(isset($_POST[$val])){
					$_SESSION[$ST]["where"][$val]=Comment::SetValue($val);
				}
			}
		}
		return $_SESSION[$ST]["where"];
	}
	public function get_order_sale_excel($where=""){//匯出出貨明細報表

		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel.php');
		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel/Writer/Excel2007.php');
		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel/Writer/Excel5.php');
		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel/IOFactory.php');

		$objPHPExcel = new PHPExcel();

		$this->set_attrib($objPHPExcel);//Set properties 設置文件屬性
		$objPHPExcel->setActiveSheetIndex(0);

		$word=$rword=array();
		for($i = 0 ; $i<26 ; $i++){
			$word[($i+1)] = chr(ord("A")+$i);
			$rword[$word[($i+1)]] = ($i+1);
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[($i+1)])->setAutoSize(true);//自動寬度
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[($i+1)])->setWidth(30);//設定寬度
		}
		for($i = 0 ; $i<26 ; $i++){
			$word[($i+1+26)] = "A".chr(ord("A")+$i);
			$rword[$word[($i+1+26)]] = ($i+1+26);
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[($i+1)])->setAutoSize(true);//自動寬度
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[($i+1)])->setWidth(30);//設定寬度
		}
		$title_array=array("prd_sn"=>"商品編號","prd_name"=>"產品項目","number"=>"銷量","price"=>"產品單價","total_price"=>"銷售額","total_count"=>"下單數");
		$i=1;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.($i), '出貨明細');
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':'.$word[(count($title_array))].$i);//合併
		$objPHPExcel->getActiveSheet()->getStyle('A'.($i))->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//置中
		$objPHPExcel->getActiveSheet()->getStyle('A'.($i))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);//置中
		$i+=1;
		//標題
		$k=0;
		$send_data["column"]=array();
		foreach($title_array as $key=>$val){
			$k+=1;
			$objPHPExcel->getActiveSheet()->setCellValue($word[$k].$i,$val);
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[$k])->setAutoSize(true);//自動寬度
			$objPHPExcel->getActiveSheet()->getColumnDimension($word[$k])->setWidth(10);//設定寬度
			$this->set_border($objPHPExcel,$word[$k].$i);
			$send_data["column"][$key]=$key;
		}
		$i+=1;
		$excel=$this->get_order_sale_data($where,'');
		foreach($excel as $key=>$val){
			$k=0;
			foreach($title_array as $key1=>$val1){
				$k+=1;
				$value=$val[$key1];
				if(substr($value,0,1)=="0"){
					$objPHPExcel->getActiveSheet()->setCellValueExplicit($word[$k].$i,(string)$value,PHPExcel_Cell_DataType::TYPE_STRING);//加空白可將數值轉出時轉成文字,數值欄位開頭0才不會不見//速度會變慢
				}else{
					$objPHPExcel->getActiveSheet()->setCellValue($word[$k].$i,(string)$value);//加空白可將數值轉出時轉成文字,數值欄位開頭0才不會不見//速度會變慢
				}
				//$this->set_border($objPHPExcel,$word[$k].$i);
			}
			$i+=1;
		}
		$this->set_save($objPHPExcel,'出貨明細');//excel儲存及匯出
	}

	public function get_order_supplier_excel($where=""){//匯出銷貨(供應商)明細報表20171228

		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel.php');
		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel/Writer/Excel2007.php');
		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel/Writer/Excel5.php');
		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel/IOFactory.php');

		$objPHPExcel = new PHPExcel();

		$this->set_attrib($objPHPExcel);//Set properties 設置文件屬性
		$objPHPExcel->setActiveSheetIndex(0);

		$word=$rword=array();
		for($i = 0 ; $i<26 ; $i++){
			$word[($i+1)] = chr(ord("A")+$i);
			$rword[$word[($i+1)]] = ($i+1);
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[($i+1)])->setAutoSize(true);//自動寬度
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[($i+1)])->setWidth(30);//設定寬度
		}
		for($i = 0 ; $i<26 ; $i++){
			$word[($i+1+26)] = "A".chr(ord("A")+$i);
			$rword[$word[($i+1+26)]] = ($i+1+26);
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[($i+1)])->setAutoSize(true);//自動寬度
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[($i+1)])->setWidth(30);//設定寬度
		}
		$title_array=array("d_name"=>"供應商姓名","prd_name"=>"產品項目","number"=>"銷量","price"=>"產品單價","total_price"=>"銷售額","total_count"=>"下單數");
		$i=1;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.($i), '出貨明細');
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':'.$word[(count($title_array))].$i);//合併
		$objPHPExcel->getActiveSheet()->getStyle('A'.($i))->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//置中
		$objPHPExcel->getActiveSheet()->getStyle('A'.($i))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);//置中
		$i+=1;
		//標題
		$k=0;
		$send_data["column"]=array();
		foreach($title_array as $key=>$val){
			$k+=1;
			$objPHPExcel->getActiveSheet()->setCellValue($word[$k].$i,$val);
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[$k])->setAutoSize(true);//自動寬度
			$objPHPExcel->getActiveSheet()->getColumnDimension($word[$k])->setWidth(10);//設定寬度
			$this->set_border($objPHPExcel,$word[$k].$i);
			$send_data["column"][$key]=$key;
		}
		$i+=1;

		$excel=$this->get_order_supplier_data($where,'');
		foreach($excel as $key=>$val){
			$k=0;
			foreach($title_array as $key1=>$val1){
				$k+=1;
				$value=$val[$key1];
				if(substr($value,0,1)=="0"){
					$objPHPExcel->getActiveSheet()->setCellValueExplicit($word[$k].$i,(string)$value,PHPExcel_Cell_DataType::TYPE_STRING);//加空白可將數值轉出時轉成文字,數值欄位開頭0才不會不見//速度會變慢
				}else{
					$objPHPExcel->getActiveSheet()->setCellValue($word[$k].$i,(string)$value);//加空白可將數值轉出時轉成文字,數值欄位開頭0才不會不見//速度會變慢
				}
				//$this->set_border($objPHPExcel,$word[$k].$i);
			}
			$i+=1;
		}
		$this->set_save($objPHPExcel,'銷貨(供應商)明細');//excel儲存及匯出
	}
	public function get_order_back_list_excel($where=""){//匯出退貨單明細20171226

		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel.php');
		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel/Writer/Excel2007.php');
		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel/Writer/Excel5.php');
		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel/IOFactory.php');

		$objPHPExcel = new PHPExcel();

		$this->set_attrib($objPHPExcel);//Set properties 設置文件屬性
		$objPHPExcel->setActiveSheetIndex(0);

		$word=$rword=array();
		for($i = 0 ; $i<26 ; $i++){
			$word[($i+1)] = chr(ord("A")+$i);
			$rword[$word[($i+1)]] = ($i+1);
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[($i+1)])->setAutoSize(true);//自動寬度
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[($i+1)])->setWidth(30);//設定寬度
		}
		for($i = 0 ; $i<26 ; $i++){
			$word[($i+1+26)] = "A".chr(ord("A")+$i);
			$rword[$word[($i+1+26)]] = ($i+1+26);
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[($i+1)])->setAutoSize(true);//自動寬度
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[($i+1)])->setWidth(30);//設定寬度
		}
		$title_array=array("order_id"=>"訂單編號","status_txt"=>"付款狀態","back_date"=>"退貨日期","name"=>"訂購人","back_name"=>"退款者姓名","back_bank"=>"退款銀行","back_account"=>"退款帳戶","back_note"=>"退款備註","apply_back_date"=>"申請退款日期");
		$i=1;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.($i), '退貨明細');
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':'.$word[(count($title_array))].$i);//合併
		$objPHPExcel->getActiveSheet()->getStyle('A'.($i))->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//置中
		$objPHPExcel->getActiveSheet()->getStyle('A'.($i))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);//置中
		$i+=1;
		//標題
		$k=0;
		$send_data["column"]=array();
		foreach($title_array as $key=>$val){
			$k+=1;
			$objPHPExcel->getActiveSheet()->setCellValue($word[$k].$i,"$val");
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[$k])->setAutoSize(true);//自動寬度
			$objPHPExcel->getActiveSheet()->getColumnDimension($word[$k])->setWidth(20);//設定寬度
			$this->set_border($objPHPExcel,$word[$k].$i);
			$send_data["column"][$key]=$key;
		}
		$i+=1;
		$excel=$this->get_order_back_list_data($where,'');
		foreach($excel as $key=>$val){
			$k=0;
			foreach($title_array as $key1=>$val1){
				$k+=1;
				$value=$val[$key1];
				//if(substr($value,0,1)=="0"){
					$objPHPExcel->getActiveSheet()->setCellValueExplicit($word[$k].$i,(string)$value,PHPExcel_Cell_DataType::TYPE_STRING);//加空白可將數值轉出時轉成文字,數值欄位開頭0才不會不見//速度會變慢
				/*
				}else{
					$objPHPExcel->getActiveSheet()->setCellValue($word[$k].$i,(string)$value);//加空白可將數值轉出時轉成文字,數值欄位開頭0才不會不見//速度會變慢
				}
				*/
				//$this->set_border($objPHPExcel,$word[$k].$i);
			}
			$i+=1;
		}
		$this->set_save($objPHPExcel,'退貨明細列表');//excel儲存及匯出
	}
	public function get_order_back_excel($where=""){//匯出退貨明細報表

		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel.php');
		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel/Writer/Excel2007.php');
		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel/Writer/Excel5.php');
		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel/IOFactory.php');

		$objPHPExcel = new PHPExcel();

		$this->set_attrib($objPHPExcel);//Set properties 設置文件屬性
		$objPHPExcel->setActiveSheetIndex(0);

		$word=$rword=array();
		for($i = 0 ; $i<26 ; $i++){
			$word[($i+1)] = chr(ord("A")+$i);
			$rword[$word[($i+1)]] = ($i+1);
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[($i+1)])->setAutoSize(true);//自動寬度
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[($i+1)])->setWidth(30);//設定寬度
		}
		for($i = 0 ; $i<26 ; $i++){
			$word[($i+1+26)] = "A".chr(ord("A")+$i);
			$rword[$word[($i+1+26)]] = ($i+1+26);
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[($i+1)])->setAutoSize(true);//自動寬度
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[($i+1)])->setWidth(30);//設定寬度
		}
		$title_array=array("d_name"=>"供應商姓名","prd_name"=>"產品項目","number"=>"數量","price"=>"產品單價","total_price"=>"退款金額","total_count"=>"下單數");
		$i=1;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.($i), '退貨明細');
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':'.$word[(count($title_array))].$i);//合併
		$objPHPExcel->getActiveSheet()->getStyle('A'.($i))->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//置中
		$objPHPExcel->getActiveSheet()->getStyle('A'.($i))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);//置中
		$i+=1;
		//標題
		$k=0;
		$send_data["column"]=array();
		foreach($title_array as $key=>$val){
			$k+=1;
			$objPHPExcel->getActiveSheet()->setCellValue($word[$k].$i,$val);
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[$k])->setAutoSize(true);//自動寬度
			$objPHPExcel->getActiveSheet()->getColumnDimension($word[$k])->setWidth(10);//設定寬度
			$this->set_border($objPHPExcel,$word[$k].$i);
			$send_data["column"][$key]=$key;
		}
		$i+=1;

		$excel=$this->get_order_back_data($where,'');

		foreach($excel as $key=>$val){
			$k=0;
			foreach($title_array as $key1=>$val1){
				$k+=1;
				$value=$val[$key1];
				if(substr($value,0,1)=="0"){
					$objPHPExcel->getActiveSheet()->setCellValueExplicit($word[$k].$i,(string)$value,PHPExcel_Cell_DataType::TYPE_STRING);//加空白可將數值轉出時轉成文字,數值欄位開頭0才不會不見//速度會變慢
				}else{
					$objPHPExcel->getActiveSheet()->setCellValue($word[$k].$i,(string)$value);//加空白可將數值轉出時轉成文字,數值欄位開頭0才不會不見//速度會變慢
				}
				//$this->set_border($objPHPExcel,$word[$k].$i);
			}
			$i+=1;
		}
		$this->set_save($objPHPExcel,'退貨明細');//excel儲存及匯出
	}
	public function get_order_excel($where=""){//匯出訂購單明細報表

		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel.php');
		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel/Writer/Excel2007.php');
		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel/Writer/Excel5.php');
		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel/IOFactory.php');

		$objPHPExcel = new PHPExcel();

		$this->set_attrib($objPHPExcel);//Set properties 設置文件屬性
		$objPHPExcel->setActiveSheetIndex(0);

		$word=$rword=array();
		for($i = 0 ; $i<26 ; $i++){
			$word[($i+1)] = chr(ord("A")+$i);
			$rword[$word[($i+1)]] = ($i+1);
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[($i+1)])->setAutoSize(true);//自動寬度
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[($i+1)])->setWidth(30);//設定寬度
		}
		for($i = 0 ; $i<26 ; $i++){
			$word[($i+1+26)] = "A".chr(ord("A")+$i);
			$rword[$word[($i+1+26)]] = ($i+1+26);
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[($i+1)])->setAutoSize(true);//自動寬度
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[($i+1)])->setWidth(30);//設定寬度
		}
		// $title_array=array("account" => "會員帳號", "order_id"=>"訂單編號","d_name"=>"出貨倉庫", "prd_no" => "商品編號","product_flow_txt"=>"訂單狀態","create_time"=>"訂單日期","name"=>"收件人姓名","phone"=>"收件電話","address"=>"收件地址","pay_way_txt"=>"付款方式","lway_txt"=>"寄送方式","status_txt"=>"付款狀態","atmno"=>"匯款後五碼","prd_sn"=>"商品條碼","prd_name"=>"商品名稱","number"=>"數量","price"=>"單價","total_price"=>"小計","ship_price"=>"運費","use_dividend"=>"使用紅利點數幾點","use_shopping_money"=>"使用購物金幾元","price_money"=>"實付金額","receipt_date"=>"發票日期","receipt_num"=>"發票號碼","note"=>"備註");//,"receipt_title"=>"發票抬頭","receipt_code"=>"統編","receipt_address"=>"發票地址","tracking_num"=>"物流編號","receipt_date"=>"發票日期","receipt_num"=>"發票號碼","sendapp"=>"接單APP"
		$title_array=array("account" => "會員帳號", "order_id"=>"訂單編號", "prd_no" => "商品編號","product_flow_txt"=>"訂單狀態","create_time"=>"訂單日期","name"=>"收件人姓名","phone"=>"收件電話","address"=>"收件地址","pay_way_txt"=>"付款方式","lway_txt"=>"寄送方式","status_txt"=>"付款狀態","prd_sn"=>"商品條碼","prd_name"=>"商品名稱","number"=>"數量","price"=>"單價","total_price"=>"小計","ship_price"=>"運費","use_dividend"=>"使用紅利點數幾點","use_shopping_money"=>"使用購物金幾元","price_money"=>"實付金額","cs_no"=>"超取店號","tracking_num"=>"物流編號","receipt_date"=>"發票日期","receipt_num"=>"發票號碼","receipt_code"=>"統編","note"=>"備註");//,"receipt_title"=>"發票抬頭","receipt_code"=>"統編","receipt_address"=>"發票地址","tracking_num"=>"物流編號","receipt_date"=>"發票日期","receipt_num"=>"發票號碼","sendapp"=>"接單APP"
		
		$i=1;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.($i), '訂購單明細');
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':'.$word[(count($title_array))].$i);//合併
		$objPHPExcel->getActiveSheet()->getStyle('A'.($i))->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//置中
		$objPHPExcel->getActiveSheet()->getStyle('A'.($i))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);//置中
		$i+=1;
		//標題
		$k=0;
		$send_data["column"]=array();
		foreach($title_array as $key=>$val){
			$k+=1;
			$objPHPExcel->getActiveSheet()->setCellValue($word[$k].$i,$val);
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[$k])->setAutoSize(true);//自動寬度
			$objPHPExcel->getActiveSheet()->getColumnDimension($word[$k])->setWidth(10);//設定寬度
			$this->set_border($objPHPExcel,$word[$k].$i);
			$send_data["column"][$key]=$key;
		}
		$i+=1;
		$detail=array();
		$excel=$this->get_order_data($where,'');
		$order_id_array=array();
		foreach($excel as $key=>$val){
			$order_id_array[$val["id"]]=$val["id"];
			$excel[$key]['ship_price']=$val["total_price"]-$val["pay_price"];
		}
		if(!empty($order_id_array)){
			$sql="select od.*,pd.prd_sn from order_details od left join products pd on od.prd_id=pd.prd_id where oid in(".implode(",",$order_id_array).")";
			$query = $this->db->query($sql);
			foreach($query->result_array() as $key=>$val){
				$detail[$val["oid"]][]=$val;
			}
		}
		foreach($excel as $key=>$val){
			if(isset($detail[$val["id"]])){
				$d=0;
				foreach($detail[$val["id"]] as $keyp=>$valp){
					$k=0;
					foreach($title_array as $key1=>$val1){
						$k+=1;
						if($key1=="address"){
							$value=$val['county'].$val['area'].$val['address'];
						}elseif($key1=="receipt_address"){
							$value=$val['receipt_zip']." ".$val['receipt_county'].$val['receipt_area'].$val['receipt_address'];
						}elseif($key1=="receipt_date"){
							$value=($val["receipt_date"]=="0000-00-00")?"":$val['receipt_date'];
						}elseif($key1=="prd_name" || $key1=="number" || $key1=="total_price" || $key1=="price" || $key1=="prd_sn"){
							$value=$valp[$key1];
						}else{
							$value=$val[$key1];
						}
						if($key1=='d_name'){//出貨倉庫
							$warehouse =$this->mymodel->OneSearchSql('`warehouse`','d_name',array('d_id'=>$val['warehouse_id']));
							$value     =$warehouse['d_name'];
						}
						/*if($key1<>'prd_name' and $key1<>'number' and $key1<>'total_price' and $key1<>'price' and $d>0){
							//同筆訂單第二項商品只需顯示商品資料即可
							$value='';
						}*/
						if(substr($value,0,1)=="0" || $key1=="order_id" || $key1=="tracking_num"){
							$objPHPExcel->getActiveSheet()->setCellValueExplicit($word[$k].$i,(string)$value,PHPExcel_Cell_DataType::TYPE_STRING);//加空白可將數值轉出時轉成文字,數值欄位開頭0才不會不見//速度會變慢
						}else{
							$objPHPExcel->getActiveSheet()->setCellValue($word[$k].$i,(string)$value);//加空白可將數值轉出時轉成文字,數值欄位開頭0才不會不見//速度會變慢
						}
						//$this->set_border($objPHPExcel,$word[$k].$i);
					}
					$i+=1;
					$d++;
				}
			}
		}
		$this->set_save($objPHPExcel,'訂購單明細');//excel儲存及匯出
	}

	public function get_order_supplier_list_excel($where=""){//匯出訂購單明細報表20180205

		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel.php');
		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel/Writer/Excel2007.php');
		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel/Writer/Excel5.php');
		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel/IOFactory.php');

		$objPHPExcel = new PHPExcel();

		$this->set_attrib($objPHPExcel);//Set properties 設置文件屬性
		$objPHPExcel->setActiveSheetIndex(0);

		$word=$rword=array();
		for($i = 0 ; $i<26 ; $i++){
			$word[($i+1)] = chr(ord("A")+$i);
			$rword[$word[($i+1)]] = ($i+1);
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[($i+1)])->setAutoSize(true);//自動寬度
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[($i+1)])->setWidth(30);//設定寬度
		}
		for($i = 0 ; $i<26 ; $i++){
			$word[($i+1+26)] = "A".chr(ord("A")+$i);
			$rword[$word[($i+1+26)]] = ($i+1+26);
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[($i+1)])->setAutoSize(true);//自動寬度
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[($i+1)])->setWidth(30);//設定寬度
		}
		$title_array=array("order_id"=>"訂單編號","d_name"=>"出貨倉庫","product_flow_txt"=>"訂單狀態","create_time"=>"訂單日期","name"=>"訂購人","phone"=>"訂購人電話","email"=>"訂購人信箱","address"=>"訂購人地址"
				,"pay_way_txt"=>"付款方式","lway_txt"=>"寄送方式","status_txt"=>"付款狀態","atmno"=>"匯款後五碼","prd_name"=>"商品名稱","number"=>"數量","total_price"=>"小計","note"=>"備註");//,"receipt_title"=>"發票抬頭","receipt_code"=>"統編","receipt_address"=>"發票地址","tracking_num"=>"物流編號","receipt_date"=>"發票日期","receipt_num"=>"發票號碼","sendapp"=>"接單APP"
		$i=1;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.($i), '訂購單明細');
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':'.$word[(count($title_array))].$i);//合併
		$objPHPExcel->getActiveSheet()->getStyle('A'.($i))->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//置中
		$objPHPExcel->getActiveSheet()->getStyle('A'.($i))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);//置中
		$i+=1;
		//標題
		$k=0;
		$send_data["column"]=array();
		foreach($title_array as $key=>$val){
			$k+=1;
			$objPHPExcel->getActiveSheet()->setCellValue($word[$k].$i,$val);
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[$k])->setAutoSize(true);//自動寬度
			$objPHPExcel->getActiveSheet()->getColumnDimension($word[$k])->setWidth(10);//設定寬度
			$this->set_border($objPHPExcel,$word[$k].$i);
			$send_data["column"][$key]=$key;
		}
		$i+=1;
		$detail=array();
		$excel=$this->get_order_supplier_list($where,'');
		$order_id_array=array();
		foreach($excel as $key=>$val){
			$order_id_array[$val["id"]]=$val["id"];
		}
		if(!empty($order_id_array)){
			$sql="select od.* from order_details od where od.oid in(".implode(",",$order_id_array).") group by od.oid";
			$query = $this->db->query($sql);
			foreach($query->result_array() as $key=>$val){
				$detail[$val["oid"]][]=$val;
			}
		}
		foreach($excel as $key=>$val){
			if(isset($detail[$val["id"]])){
				foreach($detail[$val["id"]] as $keyp=>$valp){
					$k=0;
					foreach($title_array as $key1=>$val1){
						$k+=1;
						if($key1=="address"){
							$value=$val['county'].$val['area'].$val['address'];
						}elseif($key1=="receipt_address"){
							$value=$val['receipt_zip']." ".$val['receipt_county'].$val['receipt_area'].$val['receipt_address'];
						}elseif($key1=="receipt_date"){
							$value=($val["receipt_date"]=="0000-00-00")?"":$val['receipt_date'];
						}elseif($key1=="prd_name" || $key1=="number" || $key1=="total_price"){
							$value=$valp[$key1];
						}else{
							$value=$val[$key1];
						}
						if(substr($value,0,1)=="0" || $key1=="order_id" || $key1=="tracking_num"){
							$objPHPExcel->getActiveSheet()->setCellValueExplicit($word[$k].$i,(string)$value,PHPExcel_Cell_DataType::TYPE_STRING);//加空白可將數值轉出時轉成文字,數值欄位開頭0才不會不見//速度會變慢
						}else{
							$objPHPExcel->getActiveSheet()->setCellValue($word[$k].$i,(string)$value);//加空白可將數值轉出時轉成文字,數值欄位開頭0才不會不見//速度會變慢
						}
						//$this->set_border($objPHPExcel,$word[$k].$i);
					}
					$i+=1;
				}
			}
		}
		$this->set_save($objPHPExcel,'訂購單明細');//excel儲存及匯出
	}
	public function set_border(&$objPHPExcel,$s){//設置excel文件邊框//速度會變慢
		/*$objPHPExcel->getActiveSheet()->getStyle($s)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		 $objPHPExcel->getActiveSheet()->getStyle($s)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle($s)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle($s)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);*/
		$objPHPExcel->getActiveSheet()->getStyle($s)->getBorders()->getAllborders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);//速度比較快
	}
	public function set_attrib(&$objPHPExcel){//設置excel文件屬性
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw");
		$objPHPExcel->getProperties()->setLastModifiedBy("Maarten Balliauw");
		$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
		$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
		$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
		$objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
		$objPHPExcel->getProperties()->setCategory("Test result file");
	}
	public function set_save(&$objPHPExcel,$file_name){//excel儲存及匯出
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		header("Pragma:no-cache");
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
		header("Content-Type:application/force-download");
		header("Content-Type:application/vnd.ms-execl");
		header("Content-Type:application/octet-stream");
		header("Content-Type:application/download");;
		header('Content-Disposition:attachment;filename="'.date("YmdHi",time()).$file_name.'.xlsx"');//出貨明細//退貨明細
		header("Content-Transfer-Encoding:binary");
		$objWriter->save('php://output');
	}
	public function get_order_back_data($where="",$page=''){//抓取退貨訂單資料*
		$data=array();
		$sql="select od.prd_id,od.prd_name,sum(od.number) as number,(od.price) as price,sum(od.total_price) as total_price,count(*) as total_count,pd.prd_sn
			from `order` o
			inner join `order_details` od on o.id=od.oid left join products pd on od.prd_id=pd.prd_id ".$where." group by od.prd_id,od.price";
		if(!empty($_SESSION["AT"]["where"]["sort"])){
			if($_SESSION["AT"]["where"]["sort"]=="total_count"){
				$sql.=" order by count(*) ".$_SESSION["AT"]["where"]["sort_ad"];
			}elseif($_SESSION["AT"]["where"]["sort"]=="number"){
				$sql.=" order by sum(od.number) ".$_SESSION["AT"]["where"]["sort_ad"];
			}else{
				$sql.=" order by sum(if(o.status=1,od.total_price,0)) ".$_SESSION["AT"]["where"]["sort_ad"];
			}
		}

		$sql.=" ".$page;
		$query = $this->db->query($sql);
		foreach($query->result_array() as $key=>$val){
			$data[]=$val;
		}
		return $data;
	}
	public function get_order_sale_data($where="",$page=''){//抓取出貨訂單資料*
		$data=array();
		$sql="select od.prd_id,od.prd_name,sum(od.number) as number,od.price,sum(od.total_price) as total_price,count(*) as total_count,pd.prd_sn from order_details od left join products pd on od.prd_id=pd.prd_id inner join `order` o on od.oid=o.id ".$where." group by prd_id,price";
		if(!empty($_SESSION["AT"]["where"]["sort"])){
			if($_SESSION["AT"]["where"]["sort"]=="total_count"){
				$sql.=" order by count(*) ".$_SESSION["AT"]["where"]["sort_ad"];
			}elseif($_SESSION["AT"]["where"]["sort"]=="number"){
				$sql.=" order by sum(number) ".$_SESSION["AT"]["where"]["sort_ad"];
			}else{
				$sql.=" order by sum(if(status=1,total_price,0)) ".$_SESSION["AT"]["where"]["sort_ad"];
			}
		}
		$sql.=$page;
		$query = $this->db->query($sql);
		foreach($query->result_array() as $key=>$val){
			$data[]=$val;
		}
		return $data;
	}
	public function get_order_supplier_data($where="",$page=''){//抓取銷貨(供應商)訂單資料*20171228
		$data=array();
		$sql="select o.prd_id,o.prd_name,sum(o.number) as number,o.price,sum(o.total_price) as total_price,count(*) as total_count, o.supplier_id ,s.d_name,pd.prd_sn
			from order_details as o
			inner join supplier s on s.d_id=o.supplier_id
			left join products pd on o.prd_id=pd.prd_id
			".$where." group by o.supplier_id,o.prd_id,o.price";

		if(!empty($_SESSION["AT"]["where"]["sort"])){

			if($_SESSION["AT"]["where"]["sort"]=="total_count"){
				$sql.=" order by count(*) ".$_SESSION["AT"]["where"]["sort_ad"];
			}elseif($_SESSION["AT"]["where"]["sort"]=="number"){
				$sql.=" order by sum(o.number) ".$_SESSION["AT"]["where"]["sort_ad"];
			}else{
				$sql.=" order by sum(if(o.status=1,o.total_price,0)) ".$_SESSION["AT"]["where"]["sort_ad"];
			}
		}else{
				$sql.=" order by o.supplier_id";
		}
		$sql.=$page;
		$query = $this->db->query($sql);
		foreach($query->result_array() as $key=>$val){
			$data[]=$val;
		}
		return $data;
	}
	public function get_order_member_data($where="",$page=''){//抓取會員訂購明細資料*
		$data["data"]=array();
		$sql="select by_id,sum(total_price-lway_price) as total_price,count(*) as total_count from `order` ".$where." group by by_id";
		if(!empty($_SESSION["AT"]["where"]["sort"])){
			if($_SESSION["AT"]["where"]["sort"]=="total_count"){
				$sql.=" order by count(*) ".$_SESSION["AT"]["where"]["sort_ad"];
			}elseif($_SESSION["AT"]["where"]["sort"]=="number" || $_SESSION["AT"]["where"]["sort"]=="total_price"){
				$sql.=" order by sum(".$_SESSION["AT"]["where"]["sort"].") ".$_SESSION["AT"]["where"]["sort_ad"];
			}
		}

		$sql.=$page;
		$query = $this->db->query($sql);
		$by_id_array=array();
		foreach($query->result_array() as $key=>$val){
			$by_id_array[$val["by_id"]]=$val["by_id"];
			$data["data"][]=$val;
		}
		$data["buyer"]=$this->buyer($by_id_array);
		$data["city"]=$this->city();
		$data["bytype"]=$this->get_buyer_data();
		return $data;
	}
	public function city(){
		$data=array();
		$sql="select * from city_category";
		$query = $this->db->query($sql);
		foreach($query->result_array() as $key=>$val){
			$data[$val["s_id"]]=$val;
		}
		return $data;
	}
	public function buyer($by_id=array()){
		$data=array();
		$sql="select by_id,d_account,d_is_member,name,by_email,telphone,city,countory,address from buyer";
		if(!empty($by_id)){
			$sql.=" where by_id in(".implode(",",$by_id).")";
		}
		$query = $this->db->query($sql);
		foreach($query->result_array() as $key=>$val){
			$data[$val["by_id"]]=$val;
		}
		return $data;
	}
	public function get_order_data($where="",$page=''){//抓取訂單資料*
		$data=array();
		$payment_way=$this->get_payment_way_data('');//付款方式
		$logistics_way=$this->get_logistics_way_data('');//寄送方式
		$status=$this->get_status_data(); //付款狀態
		$product_flow=$this->get_product_flow_data();  //訂單狀態

		$sql = "select * from `order` ".$where." group by order_id order by id Desc";
		$sql.=$page;
		$query = $this->db->query($sql);
		$by_id=array();
		foreach($query->result_array() as $key=>$val){
			$by_id[$val["by_id"]]=$val["by_id"];
			if($val["member_id"]!=0)
				$member_id[$val["member_id"]]=$val["member_id"];
		}
		$buyer=$this->buyer($by_id);
		if(!empty($member_id))
			$member=$this->get_member_data($member_id);

		foreach($query->result_array() as $key=>$val){
			$by_id[$val["by_id"]]=$val["by_id"];
			$val["status_txt"]=isset($status[$val["status"]])?$status[$val["status"]]:"";
			$val["product_flow_txt"]=isset($product_flow[$val["product_flow"]])?$product_flow[$val["product_flow"]]:"";
			$val["pay_way_txt"]=isset($payment_way[$val["pay_way_id"]])?$payment_way[$val["pay_way_id"]]:"";
			$val["lway_txt"]=isset($logistics_way[$val["lway_id"]])?$logistics_way[$val["lway_id"]]:"";
			$val["date_txt"]=!empty($val['date'])?date("Y-m-d H:i:s",$val['date']):"";
			$val["name"]=isset($buyer[$val["by_id"]]["name"])?$buyer[$val["by_id"]]["name"]:"";
			$val["email"]=isset($buyer[$val["by_id"]]["by_email"])?$buyer[$val["by_id"]]["by_email"]:"";
			$val["account"]=isset($buyer[$val["by_id"]]["d_account"])?$buyer[$val["by_id"]]["d_account"]:"";

			//20160922新增退刷功能-付款方式為刷卡 付款為退款 訂單為申請退貨 則顯示退刷
			$val['backpay']=($val['status']==2 and $val['product_flow']==7 and $val['pay_way_id']==8)?'1':'0';
			//20170426 新增註冊APP帳號
			$val["sendapp"]=!empty($member[$val["member_id"]])?$member[$val["member_id"]][0]."(".$member[$val["member_id"]][1].")":"";
			$data[$val["id"]]=$val;
		}

		return $data;
	}

	// 出貨明細
	public function saleList($where = "", $page = '')
	{
		$data=array();
		$payment_way=$this->get_payment_way_data('');//付款方式
		$logistics_way=$this->get_logistics_way_data('');//寄送方式
		$status=$this->get_status_data(); //付款狀態
		$product_flow=$this->get_product_flow_data();  //訂單狀態

		$sql = "select * from `order` ".$where." order by id Desc";
		$sql.=$page;

		$query = $this->db->query($sql);
		$by_id=array();
		foreach($query->result_array() as $key=>$val){
			$by_id[$val["by_id"]]=$val["by_id"];
			if($val["member_id"]!=0)
				$member_id[$val["member_id"]]=$val["member_id"];
		}
		$buyer=$this->buyer($by_id);
		if(!empty($member_id))
			$member=$this->get_member_data($member_id);

		foreach($query->result_array() as $key=>$val){
			$by_id[$val["by_id"]]=$val["by_id"];
			$val["status_txt"]=isset($status[$val["status"]])?$status[$val["status"]]:"";
			$val["product_flow_txt"]=isset($product_flow[$val["product_flow"]])?$product_flow[$val["product_flow"]]:"";
			$val["pay_way_txt"]=isset($payment_way[$val["pay_way_id"]])?$payment_way[$val["pay_way_id"]]:"";
			$val["lway_txt"]=isset($logistics_way[$val["lway_id"]])?$logistics_way[$val["lway_id"]]:"";
			$val["date_txt"]=!empty($val['date'])?date("Y-m-d H:i:s",$val['date']):"";
			$val["name"]=isset($buyer[$val["by_id"]]["name"])?$buyer[$val["by_id"]]["name"]:"";
			$val["email"]=isset($buyer[$val["by_id"]]["by_email"])?$buyer[$val["by_id"]]["by_email"]:"";

			//20160922新增退刷功能-付款方式為刷卡 付款為退款 訂單為申請退貨 則顯示退刷
			$val['backpay']=($val['status']==2 and $val['product_flow']==7 and $val['pay_way_id']==8)?'1':'0';
			//20170426 新增註冊APP帳號
			$val["sendapp"]=!empty($member[$val["member_id"]])?$member[$val["member_id"]][0]."(".$member[$val["member_id"]][1].")":"";
			$data[$val["id"]]=$val;
		}

		return $data;
	}

	//20180202
	public function get_order_supplier_list($where="",$page=''){
		$data=array();
		$payment_way=$this->get_payment_way_data('');//付款方式
		$logistics_way=$this->get_logistics_way_data('');//寄送方式
		$status=$this->get_status_data(); //付款狀態
		$product_flow=$this->get_product_flow_data();  //訂單狀態

		$sql="select o.id,o.order_id,o.product_flow,o.date,o.by_id,o.pay_way_id,o.lway_id,o.status,o.date,o.receipt_code,o.receipt_county,o.receipt_area,o.receipt_address,w.d_name";
		$sql.=",o.phone,o.zip,o.county,o.area,o.address,o.receipt_date,o.receipt_num,o.receipt_title,o.tracking_num,o.note,atmno,o.member_id,o.create_time from `order` as o
		inner join warehouse w on w.d_id=o.warehouse_id
		inner join order_details od on od.oid=o.id ".$where." group by o.order_id order by o.id Desc";
		$sql.=$page;
		$query = $this->db->query($sql);
		$by_id=array();
		foreach($query->result_array() as $key=>$val){
			$by_id[$val["by_id"]]=$val["by_id"];
			if($val["member_id"]!=0)
				$member_id[$val["member_id"]]=$val["member_id"];
		}
		$buyer=$this->buyer($by_id);
		if(!empty($member_id))
			$member=$this->get_member_data($member_id);

		foreach($query->result_array() as $key=>$val){
			$by_id[$val["by_id"]]=$val["by_id"];
			$val["status_txt"]=isset($status[$val["status"]])?$status[$val["status"]]:"";
			$val["product_flow_txt"]=isset($product_flow[$val["product_flow"]])?$product_flow[$val["product_flow"]]:"";
			$val["pay_way_txt"]=isset($payment_way[$val["pay_way_id"]])?$payment_way[$val["pay_way_id"]]:"";
			$val["lway_txt"]=isset($logistics_way[$val["lway_id"]])?$logistics_way[$val["lway_id"]]:"";
			$val["date_txt"]=!empty($val['date'])?date("Y-m-d H:i:s",$val['date']):"";
			$val["name"]=isset($buyer[$val["by_id"]]["name"])?$buyer[$val["by_id"]]["name"]:"";
			$val["email"]=isset($buyer[$val["by_id"]]["by_email"])?$buyer[$val["by_id"]]["by_email"]:"";

			//20160922新增退刷功能-付款方式為刷卡 付款為退款 訂單為申請退貨 則顯示退刷
			$val['backpay']=($val['status']==2 and $val['product_flow']==7 and $val['pay_way_id']==8)?'1':'0';
			//20170426 新增註冊APP帳號
			$val["sendapp"]=!empty($member[$val["member_id"]])?$member[$val["member_id"]][0]."(".$member[$val["member_id"]][1].")":"";
			$data[$val["id"]]=$val;
		}

		return $data;
	}
	public function get_order_back_list_data($where="",$page=''){//抓取退貨訂單資料*
		$data=array();
		$payment_way=$this->get_payment_way_data('');//付款方式
		$logistics_way=$this->get_logistics_way_data('');//寄送方式
		$status=$this->get_status_data(); //付款狀態
		$product_flow=$this->get_product_flow_data();  //訂單狀態

		$sql="select id,order_id,product_flow,date,by_id,pay_way_id,lway_id,status,date,receipt_code,receipt_county,receipt_area,receipt_address";
		$sql.=",phone,zip,county,area,address,receipt_date,receipt_num,receipt_title,tracking_num,note,atmno,back_date,back_name,back_bank,back_account,apply_back_date,back_note from `order` ".$where." order by id desc";
		$sql.=$page;
		$query = $this->db->query($sql);
		$by_id=array();
		foreach($query->result_array() as $key=>$val){
			$by_id[$val["by_id"]]=$val["by_id"];
		}
		$buyer=$this->buyer($by_id);
		foreach($query->result_array() as $key=>$val){
			$by_id[$val["by_id"]]=$val["by_id"];
			$val["status_txt"]=isset($status[$val["status"]])?$status[$val["status"]]:"";
			$val["product_flow_txt"]=isset($product_flow[$val["product_flow"]])?$product_flow[$val["product_flow"]]:"";
			$val["pay_way_txt"]=isset($payment_way[$val["pay_way_id"]])?$payment_way[$val["pay_way_id"]]:"";
			$val["lway_txt"]=isset($logistics_way[$val["lway_id"]])?$logistics_way[$val["lway_id"]]:"";
			$val["date_txt"]=!empty($val['date'])?date("Y-m-d",$val['date']):"";
			$val["name"]=isset($buyer[$val["by_id"]]["name"])?$buyer[$val["by_id"]]["name"]:"";
			$val["email"]=isset($buyer[$val["by_id"]]["by_email"])?$buyer[$val["by_id"]]["by_email"]:"";
			$data[$val["id"]]=$val;
		}
		return $data;
	}
	public function get_order_details_data($id=''){ //抓取詳細訂單資料
		$where=(!empty($id))?$id:"0";
		$sql="select a.id,a.prd_name,a.prd_spec,b.prd_sn,a.price,a.number,a.total_price,a.prd_id,b.prd_lock_amount from order_details a, products b
			where a.prd_id = b.prd_id and a.oid=".$where." order by a.id asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function get_order_details_excel($id=''){//列印折讓單
		//$data=$this->get_order_details_data($id);
		$_SESSION["jeffjuo"]="jeffjuo";
		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel.php');
		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel/Writer/Excel2007.php');
		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel/Writer/Excel5.php');
		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel/IOFactory.php');

		$objReader = new PHPExcel_Reader_Excel2007();
		$objPHPExcel = $objReader->load(dirname(__FILE__)."/discount.xlsx");

		//$objPHPExcel = new PHPExcel();


		$this->set_attrib($objPHPExcel);//Set properties 設置文件屬性
		$objPHPExcel->setActiveSheetIndex(0);

		$word=$rword=array();
		for($i = 0 ; $i<26 ; $i++){
			$word[($i+1)] = chr(ord("A")+$i);
			$rword[$word[($i+1)]] = ($i+1);
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[($i+1)])->setAutoSize(true);//自動寬度
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[($i+1)])->setWidth(30);//設定寬度
		}
		for($i = 0 ; $i<26 ; $i++){
			$word[($i+1+26)] = "A".chr(ord("A")+$i);
			$rword[$word[($i+1+26)]] = ($i+1+26);
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[($i+1)])->setAutoSize(true);//自動寬度
			//$objPHPExcel->getActiveSheet()->getColumnDimension($word[($i+1)])->setWidth(30);//設定寬度
		}
		$main=$this->get_order_data("where id=".$id);



		$title_array=array("n_num"=>"N聯式","Year"=>"年","month"=>"月","day"=>"日","receipt_num_title"=>"發票字軌","receipt_num"=>"發票號碼","prd_name"=>"品名"
				,"number"=>"數量","price"=>"單價","total_price"=>"金額","tax"=>"營業稅額","is_tax"=>"應稅");
		$i=8;

		$excel=$this->get_order_details_data($id);

		$tnum=count($excel);
		if($tnum>4){//超過四筆資料插入一行
			for($tn=1;$tn<=($tnum-4);$tn++){
				$objPHPExcel->getActiveSheet()->insertNewRowBefore((12),1);
			}
			for($tn=1;$tn<=($tnum-4);$tn++){
				$objPHPExcel->getActiveSheet()->insertNewRowBefore((30+$tnum-4),1);
			}
			for($tn=1;$tn<=($tnum-4);$tn++){
				$objPHPExcel->getActiveSheet()->insertNewRowBefore((48+($tnum-4)*2),1);
			}
		}
		foreach($excel as $key=>$val){
			$k=0;
			$price=number_format((floor($val["price"]/1.05)),0,".","");
			$total_ms=number_format((floor($val["total_price"]/1.05)),0,".","");
			$tax=number_format(ceil($total_ms*0.05),0,".","");
			$total_moneys+=$total_ms;
			$total_tax+=$tax;
			foreach($title_array as $key1=>$val1){
				$k+=($word[$k]=="G")?2:1;
				if($key1=="n_num"){
					$value="二";
				}elseif($key1=="Year" || $key1=="month" || $key1=="day"){
					$value=$date_array[$key1];
				}elseif($key1=="receipt_num_title"){
					$value=empty($main[$id]["receipt_num"])?"":substr($main[$id]["receipt_num"],0,2);
				}elseif($key1=="receipt_num"){
					$value=empty($main[$id]["receipt_num"])?"":substr($main[$id]["receipt_num"],2);
				}elseif($key1=="price"){
					$value=$price;
				}elseif($key1=="total_price"){
					$value=$total_ms;
				}elseif($key1=="tax"){
					$value=$tax;
				}elseif($key1=="is_tax"){
					$value="v";
				}else{
					$value=$val[$key1];
				}
				$num1=($tnum<=4)?0:(($tnum-4));
				$num2=($tnum<=4)?0:(($tnum-4)*2);
				if(substr($value,0,1)=="0"){
					$objPHPExcel->getActiveSheet()->setCellValueExplicit($word[$k].$i,(string)$value,PHPExcel_Cell_DataType::TYPE_STRING);//加空白可將數值轉出時轉成文字,數值欄位開頭0才不會不見//速度會變慢
					$objPHPExcel->getActiveSheet()->setCellValueExplicit($word[$k].($i+18+$num1),(string)$value,PHPExcel_Cell_DataType::TYPE_STRING);//加空白可將數值轉出時轉成文字,數值欄位開頭0才不會不見//速度會變慢
					$objPHPExcel->getActiveSheet()->setCellValueExplicit($word[$k].($i+36+$num2),(string)$value,PHPExcel_Cell_DataType::TYPE_STRING);//加空白可將數值轉出時轉成文字,數值欄位開頭0才不會不見//速度會變慢
				}else{
					$objPHPExcel->getActiveSheet()->setCellValue($word[$k].$i,(string)$value);//加空白可將數值轉出時轉成文字,數值欄位開頭0才不會不見//速度會變慢
					$objPHPExcel->getActiveSheet()->setCellValue($word[$k].($i+18+$num1),(string)$value);//加空白可將數值轉出時轉成文字,數值欄位開頭0才不會不見//速度會變慢
					$objPHPExcel->getActiveSheet()->setCellValue($word[$k].($i+36+$num2),(string)$value);//加空白可將數值轉出時轉成文字,數值欄位開頭0才不會不見//速度會變慢
				}
				//$this->set_border($objPHPExcel,$word[$k].$i);
			}
			$i+=1;
		}
		//日期

		$date_array["Year"]=empty($main[$id]["date"])?"":(date("Y",($main[$id]["date"]))-1911);
		$date_array["month"]=empty($main[$id]["date"])?"":date("m",($main[$id]["date"]));
		$date_array["day"]=empty($main[$id]["date"])?"":date("d",($main[$id]["date"]));
		$date_txt="中華民國  ".$date_array["Year"]."   年  ".$date_array["month"]."   月  ".$date_array["day"]."  日";
		foreach(array(0,18,36) as $key=>$val){
			$num1=($tnum<=4)?0:(($tnum-4)*($key));
			$num2=($tnum<=4)?0:(($tnum-4)*($key+1));
			$objPHPExcel->getActiveSheet()->setCellValue("I".(3+$val+$num1),$date_txt);//加空白可將數值轉出時轉成文字,數值欄位開頭0才不會不見//速度會變慢
			$objPHPExcel->getActiveSheet()->setCellValue("K".(12+$val+$num2),(string)$total_moneys);
			$objPHPExcel->getActiveSheet()->setCellValue("L".(12+$val+$num2),(string)$total_tax);
			$objPHPExcel->getActiveSheet()->setCellValue("M".(12+$val+$num2),(string)"v");
			$objPHPExcel->getActiveSheet()->setCellValue("K".(13+$val+$num2),(string)($total_moneys+$total_tax));
			$objPHPExcel->getActiveSheet()->setCellValue("F".(14+$val+$num2),(string)$main[$id]["name"]);
			$objPHPExcel->getActiveSheet()->setCellValue("F".(15+$val+$num2),(string)$main[$id]["receipt_code"]);
			$objPHPExcel->getActiveSheet()->setCellValue("F".(16+$val+$num2),(string)$main[$id]["receipt_county"].(string)$main[$id]["receipt_area"].(string)$main[$id]["receipt_address"]);
		}
		$i+=1;
		$this->set_save($objPHPExcel,'折讓單');//excel儲存及匯出
	}
	//會員身份*
	public function get_buyer_data(){
		//$data=array('0'=>'一般會員','1'=>'經銷會員','2'=>'待審核會員');
		$data=array();
		$command="select d_val,d_title from config where d_type='bytype'";
		$get_sInvoice=$this->db->query($command);
		foreach($get_sInvoice->result_array() as $key=>$val){
			$data[$val["d_val"]]=$val["d_title"];
		}
		return $data;
	}
	//會員身份*
	public function get_member_data($mid=array()){
		$data=array();
		$command="select m.member_id,b.name,m.member_num from member m inner join buyer b on b.by_id=m.by_id  where m.member_id in (".implode(',', $mid).")";
		$get_member=$this->db->query($command);
		foreach($get_member->result_array() as $key=>$val){
			$data[$val["member_id"]]=array($val["name"],$val["member_num"]);
		}
		return $data;
	}
	//付款狀態*
	public function get_status_data($id=''){
		//$data=array('0'=>'未付款','1'=>'已付款','2'=>'退款');
		$data=array();
		$command="select d_val,d_title from config where d_type='paystatus'";
		if(!empty($id)){
			$command.=" and d_val in (".$id.")";
		}
		$get_sInvoice=$this->db->query($command);
		foreach($get_sInvoice->result_array() as $key=>$val){
			$data[$val["d_val"]]=$val["d_title"];
		}
		return $data;
	}
	//訂單狀態*
	public function get_product_flow_data($id=''){
		//$data=array('0'=>'新訂單','1'=>'處理中','2'=>'已出貨','3'=>'取消訂單','4'=>'交易完成','5'=>'已退貨','6'=>'未付款取消','7'=>'申請退貨','8'=>'交易失敗','9'=>'退貨處理中');
		$data=array();
		$command="select d_val,d_title from config where d_type='orderstatus'";
		if(!empty($id)){
			$command.=" and d_val in (".$id.")";
		}
		$get_sInvoice=$this->db->query($command);
		foreach($get_sInvoice->result_array() as $key=>$val){
			$data[$val["d_val"]]=$val["d_title"];
		}
		return $data;
	}
	//付款方式*
	public function get_payment_way_data($id=''){
		$data=array();
		$where=(!empty($id))?"where pway_id=".$id." AND active=1":"where default_active=1";
		$sql="select pway_id,pway_name from payment_way ".$where;
		$query = $this->db->query($sql);
		foreach($query->result_array() as $key=>$val){
			$data[$val["pway_id"]]=$val["pway_name"];
		}
		return $data;print_r($data);
	}
	//寄送方式*
	public function get_logistics_way_data($id=''){
		$data=array();
		$where=(!empty($id))?" and lway_id=".$id:"";

		$sql="select lway_id,lway_name from logistics_way where lway_id<>4 ".$where;
		$query = $this->db->query($sql);
		foreach($query->result_array() as $key=>$val){
			$data[$val["lway_id"]]=$val["lway_name"];
		}
		return $data;
	}
	//訂單資料(單筆)
	public function get_order_sign($id=''){
		$data=array();
		$sql="select o.*,b.name bname,b.telphone bphone,b.by_email bemail,b.zip bzip,c1.s_name bcounty,c2.s_name barea,b.address baddress,b.vehicle_type,b.vehicle_no from `order` o left join buyer b on b.by_id=o.by_id left join city_category c1 on b.city=c1.s_id left join city_category c2 on b.countory=c2.s_id where id=".$id;
		$query = $this->db->query($sql);
		foreach($query->result_array() as $key=>$val){
			$val["zip_buy"]				=	$val["zip"];//收件者郵遞區號
			$val["county_buy"]			=	$val["county"];//收件者縣市
			$val["area_buy"]			=	$val["area"];//收件者鄉鎮
			$val["address_buy"]			=	$val["address"] ;//收件者地址

			$val["vehicle_type"]		=	$val["vehicle_type"] ;//載具類型
			$val["vehicle_no"]			=	$val["vehicle_no"] ;//載具號碼

			$val["name_buy"]			=	$val["name"];//收件者名稱
			$val["phone_buy"]			=	$val["phone"];//收件者電話
			$val["email_buy"]			=	$val["email"];//收件者mail

			$val["zip_order"]				=	$val["bzip"];//訂購人郵遞區號
			$val["county_order"]			=	$val["bcounty"];//訂購人縣市
			$val["area_order"]			=	$val["barea"];//訂購人鄉鎮
			$val["address_order"]			=	$val["baddress"] ;//訂購人地址

			$val["name_order"]			=	$val["bname"];//訂購人名稱
			$val["phone_order"]			=	$val["bphone"];//訂購人電話
			$val["email_order"]			=	$val["bemail"];//訂購人mail

			$data["use_dividend"]		=	$val["use_dividend"];//紅利
			$data["use_dividend_cost"]	=	$val["use_dividend_cost"];//紅利換算價錢
			$data["price_money"]		=	$val["price_money"];//付款金額
			$data["shop_id"]			=	$val["shop_id"];//門市取貨ID

			$data["tax_card_no"]		=	$val["tax_card_no"];//稅卡編號
			$data["back_bank_branch"]	=	$val["back_bank_branch"];//匯款分行



			
			


			$buyer=$this->buyer(array($val["by_id"]=>$val["by_id"]));
			//$val["name"]=isset($buyer[$val["by_id"]]["name"])?$buyer[$val["by_id"]]["name"]:"";

			//$val["email"]=isset($buyer[$val["by_id"]]["by_email"])?$buyer[$val["by_id"]]["by_email"]:"";
			//$val["phone"]=isset($buyer[$val["by_id"]]["telphone"])?$buyer[$val["by_id"]]["telphone"]:"";
			//$val["d_account"]=isset($buyer[$val["by_id"]]["d_account"])?$buyer[$val["by_id"]]["d_account"]:"";
			//$city=$this->city();
			//$val["county"]=isset($city[$buyer[$val["by_id"]]["city"]]["s_name"])?$city[$buyer[$val["by_id"]]["city"]]["s_name"]:"";
			//$val["area"]=isset($city[$buyer[$val["by_id"]]["countory"]]["s_name"])?$city[$buyer[$val["by_id"]]["countory"]]["s_name"]:"";
			//$val["address"]=isset($buyer[$val["by_id"]]["address"])?$buyer[$val["by_id"]]["address"]:"";

			$data=$val;
		}
		return $data;
	}
	public function dividend($id){
		$dividend=0;//紅利
		// $command="select sum(d_val) as d_val from dividend where OID=".$id." and d_type=20";
		$command="select bonus_sub as d_val from order_sub where OID=".$id."";
		$query=$this->db->query($command);
		foreach($query->result_array() as $key=>$val){
			$dividend=empty($val["d_val"])?0:$val["d_val"];
		}
		return $dividend;
	}
	//發mail
	public function send_mail($id,$host){
		//語言包
		$language=$this->config('24',$this->setlang);

		$cdata=$this->GetConfig('atm','',$this->setlang);

		if(empty($id)){
			return;
		}
		$dbdata=$this->get_order_sign($id);//主訂單資料
		if(empty($dbdata)){
			return;
		}
		//詳細訂單資料
		$oddata=$this->get_order_details_data($id);
		$payment_way=$this->get_payment_way_data('');//付款方式
		$logistics_way=$this->get_logistics_way_data('');//寄送方式
		$status=$this->get_status_data(); //付款狀態
		$product_flow=$this->get_product_flow_data();  //訂單狀態
		/*$member=array();
		$command="select member_id,account from member where member_id =".$dbdata["member_id"];
		$query=$this->db->query($command);
		foreach($query->result_array() as $key=>$val){
			$member=$val;
		}*/
		$config=array();
		$command="select d_id,d_val,d_title from config where d_type in('atm','about')";
		$query=$this->db->query($command);
		foreach($query->result_array() as $key=>$val){
			$config[$val["d_id"]]=$val;
		}
		//規格是否開啟

		$control_setting="select cart_spec_status from `control_setting` where setting_id = 1 ";
		$query_control_setting=$this->db->query($control_setting);
		$control_setting=$query_control_setting->row_array();

		$status_txt=isset($status[$dbdata["status"]])?$status[$dbdata["status"]]:"";
		$product_flow_txt=isset($product_flow[$dbdata["product_flow"]])?$product_flow[$dbdata["product_flow"]]:"";
		$cartInfo = $this->db->query('SELECT * FROM iqr_cart WHERE lang_type = "'.$this->setlang.'"')->result_array()[0];
		$subject = '【'.$this->lang_menu['jcymall'].'】'.' '.$language['title'].'('.$dbdata['order_id'].')';
		$message='
					<p><span style="font-weight: 400;">'.$language['DearMember'].'： </span></p>
					<p>&nbsp;</p>
					<p><span style="font-weight: 400;">'.$language['o3'].'</span></p>
					<p><span style="font-weight: 400;">'.$language['o4'].'</span></p>
					<table>
					<tbody>
					<tr>
					<td colspan="2">
					<p><span style="font-weight: 400;">'.$language['OrderNumber'].'：</span><span style="font-weight: 400;">'.$dbdata['order_id'].'</span></p>
					</td>
					</tr>
					<tr>
					<td>
					<p><span style="font-weight: 400;">'.$language['ProductName'].'</span></p>
					</td>
					<td>
					<p><span style="font-weight: 400;">'.$language['Quantity'].'</span></p>
					</td>
					</tr>';
					if (!empty($oddata)){
						if ($control_setting['cart_spec_status']==1){//有規格
								foreach ($oddata as $key => $value){
									$message.='
										<tr>
										<td>
										<p><span style="font-weight: 400;">'.$value['prd_name'].'('.$value['prd_spec'].')</span></p>
										</td>
										<td>
										<p><span style="font-weight: 400;">'.$value['number'].'</span></p>
										</td>
										</tr>';
								}
							}else{
								foreach ($oddata as $key => $value){
									$message.='
										<tr>
										<td>
										<p><span style="font-weight: 400;">'.$value['prd_name'].'</span></p>
										</td>
										<td>
										<p><span style="font-weight: 400;">'.$value['number'].'</span></p>
										</td>
										</tr>';
								}
							}
					}
					$message.='
					</tbody>
					</table>
					<p><span style="font-weight: 400;">'.$language['o5'].'</span><a href="http://naturefa.com/order"><span style="font-weight: 400;">'.$language['o6'].'</span><span style="font-weight: 400;">&rarr;'.$language['o7'].'</span></a><span style="font-weight: 400;">。 </span></p>
					<p>&nbsp;</p>
					<p><span style="font-weight: 400;">'.$language['o8'].'</span></p>
					<p>&nbsp;</p>
					<p><em><span style="font-weight: 400;">'.$language['DoNotDirectlyReply'].'</span></em></p>
					<p><em><span style="font-weight: 400;">'.$language['OrderQuestions'].'</span></em></p>
					<p><span style="font-weight: 400;">----------------------------------------------------------</span></p>
					<p><span style="font-weight: 400;">'.$language['natureFAPhone'].': </span><span style="font-weight: 400;">'.$cartInfo['cset_telphone'].'</span></p>
					<p><span style="font-weight: 400;">'.$language['natureFAAddress'].': </span><span style="font-weight: 400;">'.$cartInfo['cset_address'].'</span></p>
					<p><span style="font-weight: 400;">'.$language['natureFAMail'].': </span><a href="mailto:service@supergoods.com.tw"><span style="font-weight: 400;">service@supergoods.com.tw</span></a></p>
					<p><span style="font-weight: 400;">'.$language['natureFAUrl'].'：</span><a href="https://supergoods.com.tw/"><span style="font-weight: 400;">https://supergoods.com.tw/</span></a></p>';
					// <p><span style="font-weight: 400;">'.$language['natureFAFB'].'：</span><a href="https://www.facebook.com/FragranceAesthetics"><span style="font-weight: 400;">https://www.facebook.com/FragranceAesthetics</span></a></p>';
		// 寄信
		$this->mod_index->send_mail($host['domain'], $this->lang_menu['jcymall'], $dbdata["email"], $subject, $message);
	}
	public function send_mail1($id,$host){
		//語言包
		$language=$this->config('24',$this->setlang);

		$cdata=$this->GetConfig('atm','',$this->setlang);

		if(empty($id)){
			return;
		}
		$dbdata=$this->get_order_sign($id);//主訂單資料
		if(empty($dbdata)){
			return;
		}
		//詳細訂單資料
		$oddata=$this->get_order_details_data($id);
		$payment_way=$this->get_payment_way_data('');//付款方式
		$logistics_way=$this->get_logistics_way_data('');//寄送方式
		$status=$this->get_status_data(); //付款狀態
		$product_flow=$this->get_product_flow_data();  //訂單狀態
		/*$member=array();
		$command="select member_id,account from member where member_id =".$dbdata["member_id"];
		$query=$this->db->query($command);
		foreach($query->result_array() as $key=>$val){
			$member=$val;
		}*/
		$config=array();
		$command="select d_id,d_val,d_title from config where d_type in('atm','about')";
		$query=$this->db->query($command);
		foreach($query->result_array() as $key=>$val){
			$config[$val["d_id"]]=$val;
		}
		//規格是否開啟

		$control_setting="select cart_spec_status from `control_setting` where setting_id = 1 ";
		$query_control_setting=$this->db->query($control_setting);
		$control_setting=$query_control_setting->row_array();
		$cartInfo = $this->db->query('SELECT * FROM iqr_cart WHERE lang_type = "'.$this->setlang.'"')->result_array()[0];
		$status_txt=isset($status[$dbdata["status"]])?$status[$dbdata["status"]]:"";
		$product_flow_txt=isset($product_flow[$dbdata["product_flow"]])?$product_flow[$dbdata["product_flow"]]:"";
		$subject = '【'.$this->lang_menu['jcymall'].'】'.' '.$language['title1'].'('.$dbdata['order_id'].')';
		$message='
					<p><span style="font-weight: 400;">'.$language['DearMember'].'： </span></p>
					<p>&nbsp;</p>
					<p><span style="font-weight: 400;">'.$language['o9'].'</span></p>
					<p><span style="font-weight: 400;">'.$language['o10'].'</span><a href="http://naturefa.com/order"><span style="font-weight: 400;">'.$language['o6'].'</span><span style="font-weight: 400;">&rarr;'.$language['o7'].'</span></a><span style="font-weight: 400;">'.$language['o11'].'</span></p>
					<p><span style="font-weight: 400;">'.$language['o4'].'</span></p>
					<table>
					<tbody>
					<tr>
					<td colspan="2">
					<p><span style="font-weight: 400;">'.$language['OrderNumber'].'：</span><span style="font-weight: 400;">'.$dbdata['order_id'].'</span></p>
					</td>
					</tr>
					<tr>
					<td>
					<p><span style="font-weight: 400;">'.$language['ProductName'].'</span></p>
					</td>
					<td>
					<p><span style="font-weight: 400;">'.$language['Quantity'].'</span></p>
					</td>
					</tr>';
					if (!empty($oddata)){
						if ($control_setting['cart_spec_status']==1){//有規格
								foreach ($oddata as $key => $value){
									$message.='
										<tr>
										<td>
										<p><span style="font-weight: 400;">'.$value['prd_name'].'('.$value['prd_spec'].')</span></p>
										</td>
										<td>
										<p><span style="font-weight: 400;">'.$value['number'].'</span></p>
										</td>
										</tr>';
								}
							}else{
								foreach ($oddata as $key => $value){
									$message.='
										<tr>
										<td>
										<p><span style="font-weight: 400;">'.$value['prd_name'].'</span></p>
										</td>
										<td>
										<p><span style="font-weight: 400;">'.$value['number'].'</span></p>
										</td>
										</tr>';
								}
							}
					}
					$lway_txt=isset($logistics_way[$dbdata['lway_id']])?$logistics_way[$dbdata['lway_id']]:"";
					$payment_way_txt=isset($payment_way[$dbdata['pay_way_id']])?$payment_way[$dbdata['pay_way_id']]:"";
					$message.='
					<tr>
					<td colspan="2">
					<p><span style="font-weight: 400;">'.$language['o13'].'：'.$payment_way_txt.'</span></p>
					<p><span style="font-weight: 400;">'.$language['o14'].'：</span><span style="font-weight: 400;">'.$lway_txt.'</span></p>
					<p><span style="font-weight: 400;">'.$language['o15'].'：</span><span style="font-weight: 400;">'.$dbdata['name_buy'].'</span></p>
					<p><span style="font-weight: 400;">'.$language['o16'].'：NTD</span></p>
					</td>
					</tr>
					</tbody>
					</table>
					<p><span style="font-weight: 400;">'.$language['o5'].'</span><a href="http://naturefa.com/order"><span style="font-weight: 400;">'.$language['o6'].'</span><span style="font-weight: 400;">&rarr;'.$language['o7'].'</span></a><span style="font-weight: 400;">。 </span></p>
					<p>&nbsp;</p>
					<p><span style="font-weight: 400;">'.$language['o12'].'</span></p>
					<p><span style="font-weight: 400;">'.$language['o8'].'</span></p>
					<p>&nbsp;</p>
					<p><em><span style="font-weight: 400;">'.$language['DoNotDirectlyReply'].'</span></em></p>
					<p><em><span style="font-weight: 400;">'.$language['OrderQuestions'].'</span></em></p>
					<p><span style="font-weight: 400;">----------------------------------------------------------</span></p>
					<p><span style="font-weight: 400;">'.$language['natureFAPhone'].': </span><span style="font-weight: 400;">'.$cartInfo['cset_telphone'].'</span></p>
					<p><span style="font-weight: 400;">'.$language['natureFAAddress'].': </span><span style="font-weight: 400;">'.$cartInfo['cset_address'].'</span></p>
					<p><span style="font-weight: 400;">'.$language['natureFAMail'].': </span><a href="mailto:service@supergoods.com.tw"><span style="font-weight: 400;">service@supergoods.com.tw</span></a></p>
					<p><span style="font-weight: 400;">'.$language['natureFAUrl'].'：</span><a href="https://supergoods.com.tw/"><span style="font-weight: 400;">https://supergoods.com.tw/</span></a></p>';
					// <p><span style="font-weight: 400;">'.$language['natureFAFB'].'：</span><a href="https://www.facebook.com/FragranceAesthetics"><span style="font-weight: 400;">https://www.facebook.com/FragranceAesthetics</span></a></p>';
		// 寄信
		$this->mod_index->send_mail($host['domain'], $this->lang_menu['jcymall'], $dbdata["email"], $subject, $message);
	}
	public function send_mail2($id,$host){
		//語言包
		$language=$this->config('24',$this->setlang);

		$cdata=$this->GetConfig('atm','',$this->setlang);

		if(empty($id)){
			return;
		}
		$dbdata=$this->get_order_sign($id);//主訂單資料
		if(empty($dbdata)){
			return;
		}
		//詳細訂單資料
		$oddata=$this->get_order_details_data($id);
		$payment_way=$this->get_payment_way_data('');//付款方式
		$logistics_way=$this->get_logistics_way_data('');//寄送方式
		$status=$this->get_status_data(); //付款狀態
		$product_flow=$this->get_product_flow_data();  //訂單狀態
		/*$member=array();
		$command="select member_id,account from member where member_id =".$dbdata["member_id"];
		$query=$this->db->query($command);
		foreach($query->result_array() as $key=>$val){
			$member=$val;
		}*/
		$config=array();
		$command="select d_id,d_val,d_title from config where d_type in('atm','about')";
		$query=$this->db->query($command);
		foreach($query->result_array() as $key=>$val){
			$config[$val["d_id"]]=$val;
		}
		//規格是否開啟

		$control_setting="select cart_spec_status from `control_setting` where setting_id = 1 ";
		$query_control_setting=$this->db->query($control_setting);
		$control_setting=$query_control_setting->row_array();
		$cartInfo = $this->db->query('SELECT * FROM iqr_cart WHERE lang_type = "'.$this->setlang.'"')->result_array()[0];
		$status_txt=isset($status[$dbdata["status"]])?$status[$dbdata["status"]]:"";
		$product_flow_txt=isset($product_flow[$dbdata["product_flow"]])?$product_flow[$dbdata["product_flow"]]:"";
		$subject = '【'.$this->lang_menu['jcymall'].'】'.' '.$language['title1'].'('.$dbdata['order_id'].')';
		$message='
					<p><span style="font-weight: 400;">'.$language['DearMember'].'： </span></p>
					<p>&nbsp;</p>
					<p><span style="font-weight: 400;">'.$language['o17'].'！</span></p>
					<p><span style="font-weight: 400;">'.$language['o18'].$language['o19'].'</span><a href="http://naturefa.com/order"><span style="font-weight: 400;">'.$language['o6'].'</span><span style="font-weight: 400;">&rarr;'.$language['o7'].'</span></a><span style="font-weight: 400;">'.$language['o11'].'</span></p>
					<p>&nbsp;</p>
					<p><span style="font-weight: 400;">'.$language['o4'].'</span></p>
					<table>
					<tbody>
					<tr>
					<td colspan="2">
					<p><span style="font-weight: 400;">'.$language['OrderNumber'].'：</span><span style="font-weight: 400;">'.$dbdata['order_id'].'</span></p>
					</td>
					</tr>
					<tr>
					<td>
					<p><span style="font-weight: 400;">'.$language['ProductName'].'</span></p>
					</td>
					<td>
					<p><span style="font-weight: 400;">'.$language['Quantity'].'</span></p>
					</td>
					</tr>';
					if (!empty($oddata)){
						if ($control_setting['cart_spec_status']==1){//有規格
								foreach ($oddata as $key => $value){
									$message.='
										<tr>
										<td>
										<p><span style="font-weight: 400;">'.$value['prd_name'].'('.$value['prd_spec'].')</span></p>
										</td>
										<td>
										<p><span style="font-weight: 400;">'.$value['number'].'</span></p>
										</td>
										</tr>';
								}
							}else{
								foreach ($oddata as $key => $value){
									$message.='
										<tr>
										<td>
										<p><span style="font-weight: 400;">'.$value['prd_name'].'</span></p>
										</td>
										<td>
										<p><span style="font-weight: 400;">'.$value['number'].'</span></p>
										</td>
										</tr>';
								}
							}
					}
					$lway_txt=isset($logistics_way[$dbdata['lway_id']])?$logistics_way[$dbdata['lway_id']]:"";
					$payment_way_txt=isset($payment_way[$dbdata['pay_way_id']])?$payment_way[$dbdata['pay_way_id']]:"";
					$message.='
					<tr>
					<td colspan="2">
					<p><span style="font-weight: 400;">'.$language['o13'].'：'.$payment_way_txt.'</span></p>
					<p><span style="font-weight: 400;">'.$language['o14'].'：</span><span style="font-weight: 400;">'.$lway_txt.'</span></p>
					<p><span style="font-weight: 400;">'.$language['o15'].'：</span><span style="font-weight: 400;">'.$dbdata['name_buy'].'</span></p>
					<p><span style="font-weight: 400;">'.$language['o16'].'：NTD</span></p>
					</td>
					</tr>
					</tbody>
					</table>
					<p><span style="font-weight: 400;">'.$language['o5'].'</span><a href="http://naturefa.com/order"><span style="font-weight: 400;">'.$language['o6'].'</span><span style="font-weight: 400;">&rarr;'.$language['o7'].'</span></a><span style="font-weight: 400;">。 </span></p>
					<p>&nbsp;</p>
					<p><span style="font-weight: 400;">'.$language['o12'].'</span></p>
					<p><span style="font-weight: 400;">'.$language['o8'].'</span></p>
					<p>&nbsp;</p>
					<p><em><span style="font-weight: 400;">'.$language['DoNotDirectlyReply'].'</span></em></p>
					<p><em><span style="font-weight: 400;">'.$language['OrderQuestions'].'</span></em></p>
					<p><span style="font-weight: 400;">----------------------------------------------------------</span></p>
					<p><span style="font-weight: 400;">'.$language['natureFAPhone'].': </span><span style="font-weight: 400;">'.$cartInfo['cset_telphone'].'</span></p>
					<p><span style="font-weight: 400;">'.$language['natureFAAddress'].': </span><span style="font-weight: 400;">'.$cartInfo['cset_address'].'</span></p>
					<p><span style="font-weight: 400;">'.$language['natureFAMail'].': </span><a href="mailto:service@supergoods.com.tw"><span style="font-weight: 400;">service@supergoods.com.tw</span></a></p>
					<p><span style="font-weight: 400;">'.$language['natureFAUrl'].'：</span><a href="https://supergoods.com.tw/"><span style="font-weight: 400;">https://supergoods.com.tw/</span></a></p>';
					// <p><span style="font-weight: 400;">'.$language['natureFAFB'].'：</span><a href="https://www.facebook.com/FragranceAesthetics"><span style="font-weight: 400;">https://www.facebook.com/FragranceAesthetics</span></a></p>';
		// 寄信
		$this->mod_index->send_mail($host['domain'], $this->lang_menu['jcymall'], $dbdata["email"], $subject, $message);
	}
	//發mail(to後台 寄信通知email)
	public function send_mail_store($id,$host){
		//語言包
		$language=$this->config('24',$this->setlang);
		$cdata=$this->GetConfig('atm','',$this->setlang);
		if(empty($id)){
			return;
		}
		$dbdata=$this->get_order_sign($id);//主訂單資料
		if(empty($dbdata)){
			return;
		}
		//詳細訂單資料
		$oddata=$this->get_order_details_data($id);
		$payment_way=$this->get_payment_way_data('');//付款方式
		$logistics_way=$this->get_logistics_way_data('');//寄送方式
		$status=$this->get_status_data(); //付款狀態
		$product_flow=$this->get_product_flow_data();  //訂單狀態
		/*$member=array();
		$command="select member_id,account from member where member_id =".$dbdata["member_id"];
		$query=$this->db->query($command);
		foreach($query->result_array() as $key=>$val){
			$member=$val;
		}*/
		$config=array();
		$command="select d_id,d_val,d_title from config where d_type in('atm','about')";
		$query=$this->db->query($command);
		foreach($query->result_array() as $key=>$val){
			$config[$val["d_id"]]=$val;
		}
		//規格是否開啟

		$control_setting="select cart_spec_status from `control_setting` where setting_id = 1 ";
		$query_control_setting=$this->db->query($control_setting);
		$control_setting=$query_control_setting->row_array();

		$status_txt=isset($status[$dbdata["status"]])?$status[$dbdata["status"]]:"";
		$product_flow_txt=isset($product_flow[$dbdata["product_flow"]])?$product_flow[$dbdata["product_flow"]]:"";
		$subject = $this->lang_menu['jcymall'].' '.$language['HaveSingleRecord'].' - 【'.$dbdata['order_id'].'】';
		$message='<div style="width:1000px;padding:0; margin:0; font-family:"微軟正黑體", "新細明體", "標楷體", Arial; font-size:.8em; display:block; text-align:right; font-size:1.1em;">
<table width="0" border="0" cellpadding="0" cellspacing="0" id="info" style="width:100%; color:#000; padding:5px;font-size:.9em; display:block; padding:10px 5px; ">
  <tr>
    <th colspan="4" style="background:rgba(122,161,73,1); padding:8px; color:#FFF;">'.$language['OrderInformation'].'</th>
  </tr>
  <tr>
    <td width="25%" style="border-bottom:1px #CCC solid; padding:8px 5px;text-align:center;background: #f1efef;"><strong>'.$language['OrderNumber'].'</strong></td>
    <td width="25%" style="border-bottom:1px #CCC solid; padding:8px 5px;">'.$dbdata["order_id"].'</td>
    <td width="25%" style="border-bottom:1px #CCC solid; padding:8px 5px;text-align:center;background: #f1efef;"><strong>'.$language['OrderCreationDate'].'</strong></td>
    <td width="25%" style="border-bottom:1px #CCC solid; padding:8px 5px;">'.date("Y-m-d H:i:s",($dbdata["date"])).'</td>
  </tr>
  <tr>
  	<td width="25%" style="border-bottom:1px #CCC solid; padding:8px 5px;text-align:center;background: #f1efef;"><strong>'.$language['UsuallyPeople'].'</strong></td>
    <td width="25%" style="border-bottom:1px #CCC solid; padding:8px 5px;">'.$dbdata['name'].'</td>
    <td width="25%" style="border-bottom:1px #CCC solid; padding:8px 5px;text-align:center;background: #f1efef;"><strong>'.$language['UsuallyPeoplePhone'].'</strong></td>
    <td width="25%" style="border-bottom:1px #CCC solid; padding:8px 5px;">'.$dbdata['phone'].'</td>
  </tr>
  <tr>
  	<td width="25%" style="border-bottom:1px #CCC solid; padding:8px 5px;text-align:center;background: #f1efef;"><strong>'.$language['UsuallyPeopleMailbox'].'</strong></td>
    <td width="25%" style="border-bottom:1px #CCC solid; padding:8px 5px;">'.$dbdata['email'].'</td>
    <td width="25%" style="border-bottom:1px #CCC solid; padding:8px 5px;text-align:center;background: #f1efef;"><strong>'.$language['UsuallyPeopleAddress'].'</strong></td>
    <td width="25%" style="border-bottom:1px #CCC solid; padding:8px 5px;">'.$dbdata['county'].$dbdata['area'].$dbdata['address'].'</td>
  </tr>
  <tr>
    <td style="border-bottom:1px #CCC solid; padding:8px 5px;text-align:center;text-align:center;background: #f1efef;"><strong>'.$language['OrderDetails'].'</strong></td>
    <td colspan="3" style="border-bottom:1px #CCC solid; padding:8px 5px;">'.$language['o1'].'<br />'.$language['o2'].'</td>
  </tr>
</table>
<table width="0" border="0" cellpadding="0" cellspacing="0" id="info" style="width:100%; color:#000; padding:5px;font-size:.9em; display:block; padding:10px 5px; ">
  <tr>
    <th colspan="3" style="width:1000px;background:rgba(122,161,73,1); padding:8px; color:#FFF;">'.$language['OrderDetails'].'</th>
  </tr>
  <tr style="text-align:center;">
    <td width="60%" style="border-bottom:1px #CCC solid; padding:8px 5px;text-align:left;background: #f1efef;"><strong>'.$language['ProductName'].'</strong></td>
    <td width="15%" style="border-bottom:1px #CCC solid; padding:8px 5px;text-align:left;background: #f1efef;"><strong>'.$language['Quantity'].'</strong></td>
    <td width="25%" style="border-bottom:1px #CCC solid; padding:8px 5px;text-align:left;background: #f1efef;"><strong>'.$language['Subtotal'].'</strong></td>
  </tr>';
    	if (!empty($oddata)){
    		if ($control_setting['cart_spec_status']==1){//有規格
	        	foreach ($oddata as $key => $value){
	        		$message.='<tr><td width="60%" style="border-bottom:1px #CCC solid; padding:8px 5px;">'.$value['prd_name'].'('.$value['prd_spec'].')</td>
	        				<td width="15%" style="border-bottom:1px #CCC solid; padding:8px 5px;">'.$value['number'].'</td>
	        				<td width="25%" style="border-bottom:1px #CCC solid; padding:8px 5px;">'.$value['total_price'].'</td></tr>';
	        	}
        	}else{
	        	foreach ($oddata as $key => $value){
	        		$message.='<tr><td width="60%" style="border-bottom:1px #CCC solid; padding:8px 5px;">'.$value['prd_name'].'</td>
	        				<td width="15%" style="border-bottom:1px #CCC solid; padding:8px 5px;">'.$value['number'].'</td>
	        				<td width="25%" style="border-bottom:1px #CCC solid; padding:8px 5px;">'.$value['total_price'].'</td></tr>';
	        	}
        	}
        	$lway_txt=isset($logistics_way[$dbdata['lway_id']])?$logistics_way[$dbdata['lway_id']]:"";
        	$message.='<tr><td width="60%" style="border-bottom:1px #CCC solid; padding:8px 5px;">'.$lway_txt.'</td>
        			<td width="15%" style="border-bottom:1px #CCC solid; padding:8px 5px;">1</td>
        			<td width="25%" style="border-bottom:1px #CCC solid; padding:8px 5px;">'.$dbdata['lway_price'].'</td></tr>';
    	}
    	$payment_way_txt=isset($payment_way[$dbdata['pay_way_id']])?$payment_way[$dbdata['pay_way_id']]:"";
 		$message.='<tr><td colspan="3" style="width:100%;border-bottom:1px #CCC solid; padding:8px 5px;">
 				<div style=" display:block; text-align:right; font-size:1.1em;">'.$language['Bonusoffset'].' <b>'.$dbdata['use_dividend_cost'].'</b> '.$language['NTDollars'].'，
 				<span>'.$language['TotalPrice'].$dbdata['total_price'].'</b> '.$language['NTDollars'].'</span></div></td></tr>
</table>
<table width="0" border="0" cellpadding="0" cellspacing="0" id="info" style="width:100%; color:#000; padding:5px;font-size:.9em; display:block; padding:10px 5px; ">
  <tr>
    <th colspan="4" style="background:rgba(122,161,73,1); padding:8px; color:#FFF;">'.$language['Precautions'].'</th>
  </tr>
  <tr>
  	<td style="border-bottom:1px #CCC solid; padding:8px 5px;text-align:center;background: #f1efef;"><strong>'.$language['PaymentMethod'].'</strong></td>
    <td colspan="3" style="border-bottom:1px #CCC solid; padding:8px 5px;"><div><b style="color:#F60; display:block;">'.$payment_way_txt.'</b>';
 		if($dbdata['pay_way_id']=="4"){
    		$message.=$cdata['0']['d_title'].'：'.$cdata['0']['d_val'].'<br />'.$cdata['3']['d_title'].'：'.$cdata['3']['d_val'].'<br />'.$cdata['2']['d_title'].'：'.$cdata['2']['d_val'].'<br />'.$cdata['1']['d_title'].'：'.$cdata['1']['d_val'].'<br />
    		<p style="display:block; background:#CCC; padding:5px; color:#333;">'.$language['completedATMremittance'].'<a style="color:#00F; margin:0 3px;" href="'.$_SERVER["SERVER_NAME"]."/order/detail/".$dbdata["id"].'" target="_blank">'.$language['notice'].'</a>'.$language['cooperation'].'</p>';
 		}
    	$message.='</div></td></tr>
    	<tr>
	    	<td style="border-bottom:1px #CCC solid; padding:8px 5px;text-align:center;background: #f1efef;"><strong>'.$language['status'].'</strong></td>
	    	<td colspan="3" style="border-bottom:1px #CCC solid; padding:8px 5px;">'.$status_txt.'</td>
		</tr>
	</table>
	<div style="font-size:.9em; display:block; padding:10px 5px; font-style:italic;">'.$language['DoNotDirectlyReply'].'</div></div>';

		// 寄信
		$this->mod_index->send_mail($host['domain'], $this->lang_menu['jcymall'], $this->iqr_cart['cset_email'], $subject, $message);
	}

	//20160622-排程API專用
	public function api_range($type='',$start='',$end=''){
		if($type==1){
			$sql='select id,product_flow,status from `order` ';
			$sql.=' where (product_flow=0 or product_flow=7 or status=3) ';
			$sql.=' and update_time BETWEEN '.$start.' and '.$end.'';
		}
		if($type==2){
			$sql='select d_id from `contact` ';
			$sql.=' where UNIX_TIMESTAMP(create_time) BETWEEN '.$start.' and '.$end.'';
		}
		if($type==3){
			$sql='select d_id from `member_apply` ';
			$sql.=' where UNIX_TIMESTAMP(create_time) BETWEEN '.$start.' and '.$end.'';
		}
		if($type==4){
			$sql='select d_id from `reviews` ';
			$sql.=' where d_status=1 and UNIX_TIMESTAMP(create_time) BETWEEN '.$start.' and '.$end.'';
		}


		$query=$this->db->query($sql);
		return $query->result_array();
	}

  public function config($type,$lang,$is_title=''){
  	$sql='select '.$lang.',d_filed,d_is_title from language_pack where (d_type="'.$type.'" or d_type=9999)';
    if($is_title!='')
      $sql.=' and d_is_title=1';

  	$query = $this->db->query($sql)->result_array();
  	foreach ($query as $key => $value) {
  		$alang[$value['d_filed']]=$value[$lang];
  	}
  	return $alang;
  }

  //抓取系統資料
	public function GetConfig($Type='',$Cid='',$Lang='TW'){
		$sql='select d_id,d_title,d_val,d_type from config';
		$sql.=' where 1=1 ';
		if($Lang!='')
			$sql.=' and lang_type="'.$Lang.'"';
		if($Cid!=''){
			$sql.=' and d_id=?';
			$query = $this->db->query($sql,$Cid);
			return $query->row_array();
		}
		$sql.=' and d_type=?';
		$query = $this->db->query($sql,$Type);
		return $query->result_array();
	}

	// 前台取消訂單/後台訂單退貨 歸還紅利、購物金與商品庫存
	public function revertBuyerBonus($oid)
	{
		$orderInfo = $this->db->query("SELECT * FROM `order` WHERE id = ?", $oid)->result_array()[0];

		$orderDetail = $this->db->query("SELECT * FROM `order_details` WHERE `oid` = ?", $oid)->result_array();

		// 歸還商品庫存
		foreach ($orderDetail as $key => $data) {
			$this->db->query("UPDATE products SET prd_amount = prd_amount + ? WHERE prd_id = ?", [$data['number'], $data['prd_id']]);
		}

		// 歸還買家紅利與購物金
		$this->db->query("UPDATE buyer
			SET d_dividend = d_dividend + ?, d_shopping_money = d_shopping_money + ?
			WHERE by_id = ?"
		, [$orderInfo['use_dividend'], $orderInfo['use_shopping_money'], $orderInfo['by_id']]);

		if ($orderInfo['use_dividend'] > 0) {
			$this->db->insert('dividend', [
				'OID' => $oid,
				'buyer_id' => $orderInfo['by_id'],
				'd_type' => 66,
				'd_val' => $orderInfo['use_dividend'],
				'd_des' => '訂單編號 ['.$orderInfo['order_id'].']',
				'is_send' => 'Y',
				'create_time' => date('Y-m-d H:i:s'),
				'update_time' => date('Y-m-d H:i:s'),
				'is_del' => 'N'
			]);
		}

		if ($orderInfo['use_shopping_money'] > 0) {
			$this->db->insert('shopping_money', [
				'd_shopping_money' => $orderInfo['use_shopping_money'],
				'd_member_id' => $orderInfo['by_id'],
				'd_guest_id' => $orderInfo['by_id'],
				'd_content' => '+'.$orderInfo['use_shopping_money'].' 訂單編號 ['.$orderInfo['order_id'].'] - 退還購物金',
				'create_time' => date('Y-m-d H:i:s')
			]);
		}

		$this->db->query("UPDATE dividend SET d_val = 0, is_del = 'Y', update_time = ? WHERE `OID` = ? AND d_type = 19", [
			date('Y-m-d H:i:s'), $oid
		]);
	}

	public function adjustOrderSaleOut(array $data)
	{
		foreach ($data as $key => $order) {
			$this->db->where('order_id', $order['order_id']);
			$this->db->update('order', $order);
		}
	}

	public function deliverDividend($id, $by_id, $bonus)
	{
		$this->db->where('OID', $id);
		$this->db->where('d_type', 19);
		$this->db->where('is_send', 'N');
		$this->db->update('dividend', ['is_send' => 'Y', 'update_time' => date('Y-m-d H:i:s')]);

		$this->db->query("UPDATE buyer SET d_dividend = d_dividend + ? WHERE by_id = ?", [$bonus, $by_id]);
	}
}
