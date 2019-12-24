<?php
class Translation_v2 extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
        $this->load->helper('url');
		$this -> load -> model('language_model', 'mod_language');
		if ($this -> session -> userdata('auth') != "00")
			$this -> script_message('請先登入', '/index/login');
	}

	public function index($category = '')
	{
		$data['lang_bar'] = $this -> mod_language -> select_bar();
		if (!empty($category))
		{
			foreach ($data['lang_bar'] as $key => $value) {
				$data['lang_bar'][$key]['selected'] = ($value['category'] == $category) ? 'selected' : '';
			}
			$data['language'] = $this -> mod_language -> select_from_order_limit('language', array('id', 'tw', 'eng', 'jap'), array('category' => $category), 'id', 'ASC');
			$data['category'] = $category;
		}
		$this -> load -> view(DIRECTORY_SEPARATOR. 'language' .DIRECTORY_SEPARATOR. 'index', $data);
	}

	public function index2($category = '')
	{
		$data['lang_bar'] = $this -> mod_language -> select_bar();
		if (!empty($category))
		{
			foreach ($data['lang_bar'] as $key => $value) {
				$data['lang_bar'][$key]['selected'] = ($value['category'] == $category) ? 'selected' : '';
			}
			if ($category == 996)
			{
				$data = $this -> specific_category($data, $key, $category);
				$data['language_tw'] = $this -> mod_language -> select_from_order_limit('web_config_TW', array('id', 'front', 'middle', 'end'), array(), 'id', 'ASC');
				$data['language_eng'] = $this -> mod_language -> select_from_order_limit('web_config_ENG', array('id', 'front', 'middle', 'end'), array(), 'id', 'ASC');
				$data['language_jap'] = $this -> mod_language -> select_from_order_limit('web_config_JAP', array('id', 'front', 'middle', 'end'), array(), 'id', 'ASC');
				$this -> load -> view(DIRECTORY_SEPARATOR . 'language' .DIRECTORY_SEPARATOR. 'web_title', $data);
			}
			else
			{
				$data['language'] = $this -> mod_language -> select_from_order_limit('language', array('id', 'tw', 'eng', 'jap'), array('category' => $category), 'id', 'ASC');
				$data['category'] = $category;
				$this -> load -> view(DIRECTORY_SEPARATOR. 'language' .DIRECTORY_SEPARATOR. 'index', $data);
			}
		}
	}

	private function specific_category($data, $key, $category)
	{
		$data['lang_bar'][$key + 1]['selected'] = ($category == 996) ? 'selected' : '';
		$data['lang_bar'][$key + 1]['category'] = 996;
		$data['lang_bar'][$key + 1]['category_name'] = "FE - Title";
		$data['lang_bar'][$key + 1]['page'] = "/";
		return $data;
	}

	public function data_action()
	{
		$eng_array = $this -> input -> post('eng');
		$jap_array = $this -> input -> post('jap');
		$id = $this -> input -> post('id');
		$category = $this -> input -> post('category');

		foreach ($id as $key => $value) {
			$this -> mod_language -> update_set('language', array('id' => $value), array('eng' => $eng_array[$key], 'jap' => $jap_array[$key]));
		}

		$this -> script_message('Successful', '/translation_v2/index/' . $category);
	}

	public function set_language()
	{
		if ($this -> input -> post('lang')) {
			$this -> session -> set_userdata('lang', $this -> input -> post('lang'));
		}
	}
}