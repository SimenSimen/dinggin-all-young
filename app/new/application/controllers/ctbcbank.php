<?php	//中國信託金流
class Ctbcbank extends MY_Controller
{
	public $taishin_no = '', 
		   $order_id = '';

	public function __construct()
	{
		parent::__construct();
		$this->load->library('/Ctbcbank/auth');
		$this -> load -> model('business_model', 'mod_business');
	}
	public function pay($oid){
		$this->load->model('/Payment/Payment_model');
		$PayArray=array(
			'MERID'=>'10534',
			'LIDM'=>'2017032700002',
			'PAN'=>'3111555487413265',
			'ExpDate'=>'201708',
			'purchAmt'=>'500',
		);

		$BankArray=array('Bank'=>'Ctbc','BankFunc'=>'Pay');
		$payment= new Payment_model();
		$payment->index($BankArray,$PayArray);
		// $Auth=new auth();
		// $Auth->creditcard($oid);
	}
}