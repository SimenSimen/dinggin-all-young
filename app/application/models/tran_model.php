<?php
class Tran_model extends MY_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function get_list(){
		$sql="select * from lapack_list where d_enable='Y' ORDER BY `d_sort` ASC ";
		return $this->db->query($sql)->result_array();
	}

	public function get_data($id=''){
		$sql='select * from language_pack where d_type='.$id;
		return $this->db->query($sql)->result_array();
	}

	public function get_excel(){
		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel.php');
		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel/Writer/Excel2007.php');
		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel/Writer/Excel5.php');
		include_once(dirname(dirname(__FILE__)).'/libraries/PHPExcel/IOFactory.php');
		$lapack_list=$this->get_list();
		$amount=count($lapack_list);
		foreach ($lapack_list as $key => $value) {
			if($key==0){
				$objPHPExcel = new PHPExcel();		
				$this->set_attrib($objPHPExcel);//Set properties 設置文件屬性
			}else{
				//新创建的工作表
		        $msgWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'card_message');
		        $objPHPExcel->addSheet($msgWorkSheet); //插入工作表
			}

			$objPHPExcel->setActiveSheetIndex($key);
			$word=$rword=array();
			for($i = 0 ; $i<26 ; $i++){
				$word[($i+1)] = chr(ord("A")+$i);
				$rword[$word[($i+1)]] = ($i+1);
			}
			for($i = 0 ; $i<26 ; $i++){
				$word[($i+1+26)] = "A".chr(ord("A")+$i);
				$rword[$word[($i+1+26)]] = ($i+1+26);
			}
			$title_array=array("SYS"=>"名稱", "TW"=>'繁體中文', "ENG"=>'英文', "JAP"=>'日文', "CN"=>'簡體中文');
			$i=1;
			$objPHPExcel->getActiveSheet()->setTitle($value['d_title']);
			$objPHPExcel->getActiveSheet()->setCellValue('A'.($i), '翻譯系統');
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
				$objPHPExcel->getActiveSheet()->getColumnDimension($word[$k])->setWidth(30);//設定寬度
				$this->set_border($objPHPExcel,$word[$k].$i);
				$send_data["column"][$key]=$key;
			}
			$i+=1;
			$detail=array();
			$excel=$this->get_data($value['d_id']);
			$order_id_array=array();
			foreach($excel as $key=>$val){
				$k=0;
				foreach($title_array as $key1=>$val1){
					$k+=1;
					$value=$val[$key1];
					$objPHPExcel->getActiveSheet()->setCellValue($word[$k].$i,(string)$value);//加空白可將數值轉出時轉成文字,數值欄位開頭0才不會不見//速度會變慢
				}
				$i+=1;
				$d++;
			}
		}
		
		//其他 d_type=999
		//新创建的工作表
        $msgWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'd_type');
        $objPHPExcel->addSheet($msgWorkSheet); //插入工作表
		$objPHPExcel->setActiveSheetIndex($amount);
		$word=$rword=array();
		for($i = 0 ; $i<26 ; $i++){
			$word[($i+1)] = chr(ord("A")+$i);
			$rword[$word[($i+1)]] = ($i+1);
		}
		for($i = 0 ; $i<26 ; $i++){
			$word[($i+1+26)] = "A".chr(ord("A")+$i);
			$rword[$word[($i+1+26)]] = ($i+1+26);
		}
		$title_array=array("SYS"=>"名稱", "TW"=>'繁體中文', "ENG"=>'英文', "JAP"=>'日文', "CN"=>'簡體中文');
		$i=1;
		$objPHPExcel->getActiveSheet()->setTitle('其他');
		$objPHPExcel->getActiveSheet()->setCellValue('A'.($i), '翻譯系統');
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
			$objPHPExcel->getActiveSheet()->getColumnDimension($word[$k])->setWidth(30);//設定寬度
			$this->set_border($objPHPExcel,$word[$k].$i);
			$send_data["column"][$key]=$key;
		}
		$i+=1;
		$detail=array();
		$excel=$this->get_data('9999');
		$order_id_array=array();
		foreach($excel as $key=>$val){
			$k=0;
			foreach($title_array as $key1=>$val1){
				$k+=1;
				$value=$val[$key1];
				$objPHPExcel->getActiveSheet()->setCellValue($word[$k].$i,(string)$value);//加空白可將數值轉出時轉成文字,數值欄位開頭0才不會不見//速度會變慢
			}
			$i+=1;
			$d++;
		}
		$this->set_save($objPHPExcel,'翻譯系統');//excel儲存及匯出
	}

	public function set_border(&$objPHPExcel,$s){//設置excel文件邊框//速度會變慢
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
		header('Content-Disposition:attachment;filename="'.$file_name.'.xlsx"');//出貨明細//退貨明細
		header("Content-Transfer-Encoding:binary");
		$objWriter->save('php://output');
	}	
}