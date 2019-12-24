<?php
//金鑰
class Keymaker extends MY_Controller
{
	public $data='';

	public function __construct()//初始化
	{
		parent::__construct();
	}

	public function get_ip()
	{
		echo $this->get_realip();
	}

	//產生金鑰excel
	public function generate($t_n)
	{
		if($this->session->userdata('auth') == '00')
		{
			//model
			$this->load->model('admin_model', 'mod_admin');

			//excel檔案名稱
			$filename=date('YmdHis', time()).'_keymaker';

			//excel標題陣列
			$title_array=array(0=>'卡號', 1=>'金鑰');

			//卡號
			$card_amount=0;
			do
			{
				$v=$this->random_num_code(6);
				if(!@in_array($v, $card_number))//陣列中不允許重複
				{
					//資料庫檢查
					$v_check=$this->mod_admin->select_from('keys', array('key_number'=>$v));
					if(empty($v_check))//資料庫中不允許重複
					{
						$card_number[$card_amount]=$v;
						$card_amount++;
					}
				}
			}while((count($card_number) != $t_n));
			
			//金鑰
			$key_amount=0;
			do
			{
				$k=$this->random_key(8);
				if(!@in_array($k, $key_number))//不允許重複
				{
					//資料庫檢查
					$k_check=$this->mod_admin->select_from('keys', array('key_value'=>$k));
					if(empty($k_check))//資料庫中不允許重複
					{
						$key_number[$key_amount]=$k;
						$key_amount++;
					}
				}
			}while((count($key_number) != $t_n));

			//excel內容陣列
			foreach($card_number as $key => $value)
			{
				$data_array[$key][0]=$value;
				$data_array[$key][1]=$key_number[$key];
			}

			//匯出
			$this->export_xls($title_array, $data_array, $filename);
		}
	}
}