<?php
class Common
{
	//----------------------------------------------------------------------------------- 
	// 編號	 ：1
	// 函數名：get_data_uri()
	// 作 用 ：Data URI 轉換程式
	// 參 數 ：$filename 圖片路徑 ( image/logo_1.jpg)
	// 返回值：圖片 data URI path
	// 備 注 ：無
	//----------------------------------------------------------------------------------- 
	static function get_data_uri($filename = "")
	{
		if(file_exists($filename))
		{
			if (function_exists('mime_content_type'))
			{
	        	$mime = mime_content_type($filename);
		    }
		    else
		    {
		        $finfo = finfo_open(FILEINFO_MIME_TYPE);
		        $mime  = finfo_file($finfo, $filename);
		        // $finfo = new finfo();
		        // $mime  = $finfo->file($filename, FILEINFO_MIME_TYPE);
		    }
	    	$path = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($filename));
		}
	    else
	    	$path = "";
	    return 	$path;
	}
	public function test($outstr = "")
	{
		echo $outstr,'<BR>';
	}
	
}