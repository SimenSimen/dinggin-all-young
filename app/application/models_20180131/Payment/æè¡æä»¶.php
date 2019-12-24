<?
// 技術文件

//玉山----------------------------------------------------------------
$this->load->model('Payment/Payment_model');
// 玉山付款----------------------------------------------------------------
$PayArray=array(
	'MID'=>'8089016896',
	'ONO'=>'2017032700001',
	'TA'=>'500',
	'U'=>'http://59.125.75.222:8055/admin_sys/payment/payment/post',
	'M'=>'4R7266J1Z1AJUY6HF6J6DSXJNBRIM5XT',
);

$BankArray=array('Bank'=>'Esun','BankFunc'=>'Pay');
// 玉山取消授權----------------------------------------------------------------
$PayArray=array(
	'MID'=>'8089016896', //特店代碼
	'ONO'=>'2017032700001', //訂單號碼
	'M'=>'4R7266J1Z1AJUY6HF6J6DSXJNBRIM5XT', //押碼Key
);
$BankArray=array('Bank'=>'Esun','BankFunc'=>'Cancel');
// 玉山查詢訂單----------------------------------------------------------------
$PayArray=array(
	'MID'=>'8089016896', //特店代碼
	'ONO'=>'2017032700001', //訂單號碼
	'M'=>'4R7266J1Z1AJUY6HF6J6DSXJNBRIM5XT', //押碼Key
);
$BankArray=array('Bank'=>'Esun','BankFunc'=>'Search');
// 玉山----------------------------------------------------------------
$payment= new Payment_model();
$payment->index($BankArray,$PayArray);