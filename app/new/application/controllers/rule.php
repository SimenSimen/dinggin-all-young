<?php
class Rule extends MY_Controller
{
	public $message = '';
	function __construct()
	{
		parent::__construct();

		// helper
        $this -> load -> helper('url');

        $this -> load -> library('/mylib/useful');

        $this -> load -> model('rule_model', 'mod_rule');

        if(!$this -> session -> userdata('lang'))
		{
			$this -> session -> set_userdata('lang', 'TW');
		}
	}

	public function editor($tag)
	{
		if (!$this -> input -> post('type'))
		{
			$data['type'] = $tag;
			switch ($tag) {
				case 1:
					$this -> useful -> CheckComp('j_csetPaid');
					$data['iqr_cart'] =  $iqr_cart = $this -> mod_rule -> select_from('iqr_cart', array('member_id', 'cset_paid_' .$this -> session -> userdata('lang'). ' AS content'), array('member_id' => '1'));
					$data['iqr_cart']['title'] = '購買說明';
					break;
				
				case 2:
					$this -> useful -> CheckComp('j_csetShip');
					$data['iqr_cart'] =  $iqr_cart = $this -> mod_rule -> select_from('iqr_cart', array('member_id', 'cset_ship_' .$this -> session -> userdata('lang'). ' AS content'), array('member_id' => '1'));
					$data['iqr_cart']['title'] = '運送規則';
					break;
			}
			$this -> load -> view('admin' .DIRECTORY_SEPARATOR. 'system_center' .DIRECTORY_SEPARATOR. 'rule' .DIRECTORY_SEPARATOR. 'CU', $data);
		}
		else
		{
			$U_return = $this -> mod_rule -> edit($this -> input -> post('type'));
			if ($U_return)
				$this -> script_message('編輯成功', DIRECTORY_SEPARATOR.'rule' .DIRECTORY_SEPARATOR. 'editor' .DIRECTORY_SEPARATOR. $this -> input -> post('type'), 'top');
			else
				$this -> script_message('編輯失敗', DIRECTORY_SEPARATOR.'rule' .DIRECTORY_SEPARATOR. 'editor' .DIRECTORY_SEPARATOR. $this -> input -> post('type'), 'top');
		}
	}

	public function cart_setting()
	{

		$this -> useful -> CheckComp('j_cartSetting');
		$data['member_id'] = '1';
		if($this -> input -> post('form_submit'))
		{
			$this -> event_setting($this -> input -> post());
			$this -> script_message($this -> message);
		}
		$data['iqr_cart'] = $this -> mod_rule -> select_from('iqr_cart', array('cset_active', 'cset_name', 'cset_email', 'cset_company', 'cset_address', 'cset_telphone', 'cset_mobile','cset_fax'), array('member_id' => '1','lang_type'=>$this -> session -> userdata('lang')));
		$data['payment_way'] = $this -> mod_rule -> select_from('payment_way', array('pway_name', 'active', 'pway_id'), array('default_active' => 1), 'array');
		foreach ($data['payment_way'] as $key => $value) {
			$data['payment_way'][$key]['selected_open'] = ($value['active'] == 1) ? 'checked' : '';
			$data['payment_way'][$key]['selected_close'] = ($value['active'] == 0) ? 'checked' : '';
		}
		$this -> load -> view('admin' .DIRECTORY_SEPARATOR. 'system_center' .DIRECTORY_SEPARATOR. 'rule' .DIRECTORY_SEPARATOR. 'cart_setting', $data);
	}

	private function event_setting($post)
	{
		$update_data = array(
			'cset_name'		=> $post['cset_name'],
			'cset_email'	=> (filter_var($post['cset_email'], FILTER_VALIDATE_EMAIL)) ? $post['cset_email'] : '',
			'cset_company'	=> $post['cset_company'],
			'cset_address'	=> $post['cset_address'],
			'cset_telphone'	=> (is_numeric($post['cset_telphone'])) ? $post['cset_telphone'] : '',
			'cset_mobile'	=> (is_numeric($post['cset_mobile'])) ? $post['cset_mobile'] : '',
			'cset_fax'		=> ($post['cset_fax']) ? $post['cset_fax'] : '',
			'lang_type'		=> $this -> session -> userdata('lang')
		);
		$update_id = $this -> mod_rule -> update_set('iqr_cart', array('member_id' => '1','lang_type'=> $this -> session -> userdata('lang')), $update_data);
		
		// payment update
		foreach ($post['pway'] as $key => $value) {
			$this -> mod_rule -> update_set('payment_way', array('pway_id' => $key), array('active' => $value));
		}

		if($update_id)
			$this -> message = '編輯成功';
		else
			$this -> message = '編輯失敗';
	}
}