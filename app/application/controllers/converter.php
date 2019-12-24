<?php
class Converter extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		//model
		$this -> load -> model('index_model', 'mod_index');

		//亂碼
		header("Content-Type:text/html; charset=utf-8");

		//helper
		$this->load->helper('url');
	}

	public function Time_Zone_Converter()
	{
		$data = $this -> data;


		$time = $this -> input -> get('time');
		$add  = $this -> input -> get('add');
		$now_time = time();
		$finishing = $now_time + $add;
		$compiler = date('Y-m-d H:i:s', $time);

		echo 'Past:'. $compiler .'<br>';
		echo 'Now:' . $now_time . '<br>';
		echo 'Now Unix add dates time:'. $finishing .'<br>';
		echo 'News Time_Zone_Converter:' . date('Y-m-d H:i:s', $finishing);
		phpinfo();
		$this -> load -> view('converter', $data);
	}
}
