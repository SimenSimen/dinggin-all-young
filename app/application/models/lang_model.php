<?php
class Lang_model extends MY_Model {

  public $web_title;
  public function __construct()
  {
    parent::__construct();

    $this->load->database();
  }
  
  public function config($type,$lang,$is_title=''){
  	$sql='select '.$lang.',d_filed,d_is_title from language_pack where (d_type="'.$type.'" or d_type=9999)';
    if($is_title!='')
      $sql.=' and d_is_title=1';
		$sql.=' order by d_type desc';
  	$query = $this->db->query($sql)->result_array();
  	foreach ($query as $key => $value) {
  		$alang[$value['d_filed']]=$value[$lang];
  	}
  
  	return $alang;
  }
}