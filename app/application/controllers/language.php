<?php
class Language extends MY_Controller
{
	public $message = '';
	function __construct()
	{
		parent::__construct();

		// helper
        $this -> load -> helper('url');

        $this -> load -> library('/mylib/useful');

        $this -> load -> model('language_model', 'mod_language');

        if(!$this -> session -> userdata('lang'))
		{
			$this -> session -> set_userdata('lang', 'TW');
		}
	}

	public function language_setting()
	{

		$this -> useful -> CheckComp('j_language');
		if($this -> input -> post('form_submit'))
		{
			$this -> event_setting($this -> input -> post());
			$this -> script_message($this -> message);
		}

		$data['language_type'] = $this -> mod_language -> select_from('language_type', array('d_id', 'd_title', 'd_enable'), array('default_active' => 1),'array');
		foreach ($data['language_type'] as $key => $value) {
			$data['language_type'][$key]['selected_open'] = ($value['d_enable'] == 'Y') ? 'checked' : '';
			$data['language_type'][$key]['selected_close'] = ($value['d_enable'] == 'N') ? 'checked' : '';
		}
		$this -> load -> view('admin' .DIRECTORY_SEPARATOR. 'system_center' .DIRECTORY_SEPARATOR. 'language' .DIRECTORY_SEPARATOR. 'language_setting', $data);
	}

	private function event_setting($post)
	{
		// language_type update
		foreach ($post['language'] as $key => $value) {
			$update_id=$this -> mod_language -> update_set('language_type', array('d_id' => $key), array('d_enable' => $value));
		}

		if($update_id)
			$this -> message = '編輯成功';
		else
			$this -> message = '編輯失敗';
	}
}