<?php

class Gomypay_model extends MY_Model {
	
	public function __construct()
	{
		$this->load->database();
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：generatorPassword($str_len, $strings)
	// 作 用 ：產生亂數(A~9)字串
	// 參 數 ：$str_len 亂數字串長度
	//		   $strings 初始字串
	// 返回值：初始字串 + 亂數字串
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	function generatorPassword($str_len, $strings)
	{
		$word = 'ab0123456789cdefghijklmn0123456789opqrstuvwxyzABCD0123456789EFGHIJKLMNO0123456789PQRSTUVWKYZ0123456789';
	    $len = strlen($word);

	    for ($i = 0; $i < $str_len; $i++) {
	        $strings .= $word[rand() % $len];
	    }

	    return $strings;
	}
}
