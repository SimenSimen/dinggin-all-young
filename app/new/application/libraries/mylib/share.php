<?
class Share extends MY_Model {

	public function config($ShareTitle,$Account,$isshareurl='',$docallapp='',$member_id){
		$data['Saccount']=$Account;
		$data['get_device_type']=$this->get_device_type();
		$data['public_share_title']   = $ShareTitle;		
		$data['public_share_pict_Ppath'] = $this->chksharepict($data['logo_path_url']);
		$data['public_share_url']   = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$data['public_barcodeurl']   = '/app/route/' .$member_id;

		// print_r($data['public_share_url']);
		$chkflag='isshareurl';
		if ($isshareurl==$chkflag){//表示是分享來的網址
			$data['isshareurl']=true;
		}
		$pos = strpos($data['public_share_url'],$chkflag );//自動加上分享字串
		if ($pos === false) { // 比對一定要用  !== false 或 ===false  其他都不好
			$data['public_share_url'].='/'.$chkflag;
		}

		
		$callappurl=$data['public_share_url'];
		$chkflag='docallapp';
		if ($docallapp==$chkflag){ 
			//表示是由網頁呼叫APP.所以沒經由首頁的檢查APP手續.由程式直接設為APP模式
			$this->session->set_userdata('isapp',true);
		}
		$pos = strpos($callappurl,$chkflag);
		if ($pos === false) { // 比對一定要用  !== false 或 ===false  其他都不好
			$callappurl.='/'.$chkflag;
			//加上callapp
		}else{
			$data['public_share_url']=str_replace('/'.$chkflag, '', $data['public_share_url']);
			//url 移除callapp
		}

		$callappurl=$this->getcallappurl($callappurl,$Account,$member_id);		
		// print_r($callappurl);
		$data['callappurl'] =$callappurl['script_url'];	
		$data['public_share_buttom_url']   = 'jecp://path='.$data['public_share_pict_Ppath'].'&ecp_url='.$data['public_share_url'].'&ecp_title='.$data['public_share_title'];
		return $data;
	}

	public function getcallappurl($uri,$Account,$member_id)
	{
		$newsletter = 'kuoting';        //通訊名


		if (substr($uri,0,7)=='http://') $uri=substr($uri,7);//不要有HTTP://
		
		//手機APP
		$this -> load -> library('Specific', 'specific');
		$specific = new Specific();
		// Agreement
		$specific -> IOS_SCHEMES = ''.$newsletter.$member_id.'://';
		$specific -> ANDROID_SCHEMES = ''.$newsletter.$member_id.'://';
		
		// if ($this->data['son_account']=='hshouse'){//hshouseg上架時沒有加A.所以後來都不能加A...哀+A是因為$member['account']如果是數值時會不能打包
		// 	$apphostname= $Account .'C'. $this->data['son_member_id'];
		// }else{
			$apphostname= 'A'.$Account .'C'. $member_id;
		// }

		$specific -> ANDROID_HOST = 'com.appplus.'.$apphostname.'/';//要依帳號修改
		// $specific -> ELEMENTS = array($uri, 'http://www.gbshop.com.tw/');
		// $specific -> I_ELEMENTS = array('web', $uri);
		// $specific -> GOOGLE_STORE = $specific -> ITUNES_STORE = $this -> input -> get('download');
		//$specific -> index();
		return $specific-> get_url();
	}
	public function get_device_type()
	{
		$mobile_browser = '0';

		if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|Android|iPhone|iPad|iPod)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
		{
		    $mobile_browser++;
		}
		 
		if((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml')>0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE']))))
		{
		    $mobile_browser++;
		}    
		 
		$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));
		$mobile_agents = array(
		    'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
		    'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
		    'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
		    'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
		    'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
		    'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
		    'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
		    'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
		    'wapr','webc','winw','winw','xda','xda-','Googlebot-Mobile');
		 
		if(in_array($mobile_ua,$mobile_agents))
		{
		    $mobile_browser++;
		}
		 
		if (strpos(strtolower($_SERVER['ALL_HTTP']),'OperaMini')>0)
		{
		    $mobile_browser++;
		}
		 
		if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows')>0)
		{
			$mobile_browser=0;
		}

		return $mobile_browser;
	}

	public function chksharepict($url) 
	{
		if (empty($url)) return base_url().$this->data['icon'];
		else return base_url().$url;
	}
}