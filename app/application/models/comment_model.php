<?php
require_once('./application/core/MY_Sql.php');
class Comment_model extends MY_Sql
{
	
	function __construct()
	{
		$this -> load -> database();
	}
}