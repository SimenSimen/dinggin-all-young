<?php
class Bonus extends MY_Controller
{
    public function __construct()//初始化
    {
        parent::__construct();

        //model
        $this->load->model('admin_model', 'mod_admin');

        //helper
        $this->load->helper('url');

        //domain
        if($this->session->userdata('session_domain') != '')
        {
            $this->data['session_domain']=$this->session->userdata('session_domain');
        }
        else
        {
            $this->data['session_domain']=$this->session->set_userdata('session_domain', 1);
            $this->session->set_userdata('session_domain', 1);
        }
        $domain=$this->mod_admin->select_from('domain', array('domain_id'=>$this->data['session_domain']));
        $this->session->set_userdata('session_domain_name', $domain['domain']);
        $this->data['session_domain_name']=$this->session->userdata('session_domain_name');

        //web config
        $this->data['web_config']=$this->get_web_config($this->session->userdata('session_domain'));
        $this->data['style_config'] =   $this->get_style_config($this->session->userdata('session_domain'));
        $this->style                =   (!empty($this->data['style_config']['style_id']))?$this->data['style_config']['style_id']:'';

        //model
        $this->load->model('bonus_model','bmodel');
        $this->load->model('member_model','mmodel');
        $this->load->model('banner_model');
        $this->load->model('/MyModel/mymodel');

        //語言包設置
        $this->load->model('lang_model',lmodel);
        $this -> load -> helper('form');
        $this->load->library('/mylib/comment');
        $this->load->library('/mylib/useful');
        $this->data['banner'] = $this->banner_model->getMyAd();
        $this->setlang=(!empty($_SESSION['LA']))?$_SESSION['LA']['lang']:'TW';        
    }
    //前台紅利
    public function dividend(){        
        @session_start();
        //語言包        
        $this->lang=$this->lmodel->config('11',$this->setlang);
        // 判斷是否登入
        if($_SESSION['MT']['is_login']==1){
            // $this->useful->iconfig();
            $this->DataName='bonus';
            $data['path_title'] ='<li><a href="/gold/member"><span>'.$this->lang_menu['member'].'</span></a></li>'.
                                '<li><a href="/'.$this->DataName.'/dividend"><span>'.$this->lang_menu['dividend'].'</span></a></li>';
            //推薦人
            $by_id = $_SESSION['MT']['by_id'];
            $buyer= $this->mymodel->OneSearchSql('buyer','PID',array('by_id'=>$by_id));
            $PID    =   $buyer['PID'];
            if($by_id<>4){
                $memberName = $this->mymodel->OneSearchSql('buyer','name',array('by_id'=>$PID));
                $data['memberName'] =   $this->lang_menu['yourAccount'].'<b>'.$memberName['name'].'</b>';
            }

            //會員剩餘紅利
            $bdata=$this->mymodel->OneSearchSql('buyer','birthday,d_dividend',array('by_id'=>$by_id));
						$mdata=$this->mymodel->SelectSearch('dividend','','buyer_id,(select SUM(d_val) from dividend d2 WHERE d2.buyer_id='.$by_id.' AND d2.d_type IN (18,19,43,44,66) and d2.is_send="Y" and d2.is_del="N" and d2.d_val!=0 and d2.send_dt<=dividend.send_dt) d_val,send_dt','WHERE buyer_id='.$by_id.' AND d_type IN (18,19,43,44,66) and is_send="Y" and is_del="N" and d_val!=0 and send_dt is not null GROUP BY send_dt','send_dt ASC');
            //有效期限
            $mdata1=$this->mymodel->OneSearchSql('dividend','sum(d_val) d_val',array('is_send'=>"Y",'is_del'=>"N",'d_type'=>20,'buyer_id'=>$by_id));
						if(!empty($mdata1['d_val'])){
							foreach($mdata as $val){
								if($mdata1['d_val']<$val['d_val']){
									$data['send_dt']=date("Y-m-d", strtotime($val['send_dt']."+1 year"));
									$data['send_dividend']=number_format($val['d_val']-$mdata1['d_val'],2);
									break;
								}
							}
						}else{
							$data['send_dt']=!empty($mdata)?date("Y-m-d", strtotime($mdata[0]['send_dt']."+1 year")):'';
							$data['send_dividend']=!empty($mdata)?$mdata[0]['d_val']:'';
						}
            $data['dividend']=($bdata['d_dividend']=='')?'0':$bdata['d_dividend'];
            $dbirthday=(date('Y')).'-'.substr($bdata['birthday'],5);
            //分頁
            $dbname = 'dividend';
            $data['ToPage']=$Topage=!empty($_POST['ToPage'])?$_POST['ToPage']:1;
            $page_limit     =   20  ;// 每頁顯示筆數

            $qpage=$this->useful->setPageJcy($dbname,$Topage,$page_limit,array('buyer_id'=>"$by_id"));
            $data['page']=$this->useful->getPageJcy($qpage);
            $dbdata=$this->bmodel->get_dividend_data($by_id,$dbirthday,$page_limit,$Topage);
            foreach ($dbdata as $key => $value) {
                $dtype=$this->mymodel->GetConfig('',$value['d_type']);
								$dbdata[$key]['d_des'] = str_replace("\'","'",$value['d_des']);
                $dbdata[$key]['contitle']=$dtype['d_title'];    
                $dbdata[$key]['d_val']=($dtype['d_val']=='+')?'<span style="color:GREEN">+'.$value['d_val'].'</span>':'<span style="color:RED">-'.$value['d_val'].'</span>';
                $dbdata[$key]['update_time']=substr($value['update_time'],0,10);
                $odata=$this->mymodel->OneSearchSql('`order`','status,product_flow',array('id'=>$value['OID']));
                // if(in_array($odata['status'],array(0,1,3)) and in_array($odata['product_flow'],array(0,1,3,4))){
                    if ($value['d_type'] == 19) {
                        // $dbdata[$key]['is_send']=($value['is_send']=='Y')?$this->lang['sended']:$this->lang['nosend']; //已發送 發送
                        if ($value['is_del'] == 'Y') {
                            $dbdata[$key]['is_send'] = '取消發送';
                        } else {
                            if ($value['is_send'] == 'Y') {
                                $dbdata[$key]['is_send'] = '<span style="color: green;">'.$this->lang['sended'].'</span>';
                            } else {
                                $dbdata[$key]['is_send'] = '尚未發送';
                            }
                        }
                    } elseif ($value['d_type'] == 20) {  //是否扣除紅利
                        // $dbdata[$key]['is_send']=($value['is_send']=='Y')?$this->lang['deduct']:$this->lang['nodeduct'];
                        $dbdata[$key]['is_send']=($value['is_send']=='Y')?'<span style="color: red;">'.$this->lang['deduct'].'</span>':'';
                    } elseif ($value['d_type'] == 66) {
                        $dbdata[$key]['is_send'] = '<span style="color: green;">'.$dbdata[$key]['contitle'].'</span>';
                    }
                // }             
            }
            $data['dbdata']=$dbdata;
            $data['banner'] = $this->data['banner'];
            //view
            $this->load->view('index/header', $data);
            $this->load->view('index/member/member_nav', $data);
            $this->load->view('index/bonus/dividend', $data);
            $this->load->view('index/footer', $data);
        }else{
            $_SESSION['url']    =   'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $this->useful->AlertPage('/gold/login',$this->lang_menu['Login']);            
        }
    }

    //會員紅利轉出
    public function givebonus(){
    	if($this->data['web_config']['is_givebonus'] == 0){
    		$this->useful->AlertPage('/bonus/dividend','目前不能互轉紅利');//設定不能互轉紅利
    	}
        $this->load->library('/mylib/CheckInput');
        $check=new CheckInput;
        @session_start();
        //語言包        
        $this->lang=$this->lmodel->config('11',$this->setlang);
        
		if(!empty($_POST)){
			$dbname=$_POST['dbname'];
            // 紅利LOG
            if($dbname=='dividend_log'){
                $check->fname[]=array('_String',Comment::SetValue('BID'),'會員帳號');
                $check->fname[]=array('_String',Comment::SetValue('d_type'),'項目類型');
                $check->fname[]=array('_String',Comment::SetValue('d_bonus'),'點數');
            }

            //if(!empty($check->main())){
            //    echo $check->main();
            //    return '';
            //}
			
			
            // 紅利LOG
            if($dbname=='dividend_log'){
                @session_start();
           
                $odata=$this->mymodel->OneSearchSql('buyer','by_id,d_dividend',array('by_id'=>$_SESSION['MT']['by_id']));
                $mdata=$this->mymodel->OneSearchSql('buyer','by_id,d_dividend',array('d_account'=>Comment::SetValue('BID')));
                if(!empty($mdata)){
                    $o_dividend=$odata['d_dividend']-Comment::SetValue('d_bonus');
                    $d_dividend=($_POST['d_type']==1)?($mdata['d_dividend']+Comment::SetValue('d_bonus')):($mdata['d_dividend']-Comment::SetValue('d_bonus'));
                    if($d_dividend>=0 && $o_dividend>=0){
                        
                        // 寫入LOG 轉入紅利
                        $logdata=array(
                            'BID'=>$mdata['by_id'],
                            'EID'=>$_SESSION['MT']['by_id'],
                            'd_type'=>$_POST['d_type'],
                            'd_bonus'=>Comment::SetValue('d_bonus'),
                            'd_content'=>Comment::SetValue('d_content'),
                            'create_time'=>$this->useful->get_now_time(),
                            'update_time'=>$this->useful->get_now_time(),
                        );
						$this->mymodel->insert_into($dbname,$logdata);
                        // 寫入LOG 轉出紅利
                        $logdata=array(
                            'BID'=>$_SESSION['MT']['by_id'],
                            'EID'=>$_SESSION['MT']['by_id'],
                            'd_type'=>2,
                            'd_bonus'=>Comment::SetValue('d_bonus'),
                            'd_content'=>Comment::SetValue('d_content'),
                            'create_time'=>$this->useful->get_now_time(),
                            'update_time'=>$this->useful->get_now_time(),
                        );

                        $this->mymodel->insert_into($dbname,$logdata);
                        
                        // 寫入會員紅利轉入
                        $didata=array(
                            'buyer_id'=>$mdata['by_id'],
                            'd_type'=>19,
                            'd_val'=>Comment::SetValue('d_bonus'),
                            'd_des'=>"會員紅利轉入:".Comment::SetValue('d_content'),
                            'is_send'=>'Y',
                            'create_time'=>$this->useful->get_now_time(),
                            'update_time'=>$this->useful->get_now_time(),
                            'send_dt'=>$this->useful->get_now_time(),
                        );
                        $this->mymodel->insert_into('dividend',$didata);
                        $this->mymodel->update_set('buyer','by_id',$mdata['by_id'],array('d_dividend'=>$d_dividend));
                        
                        // 寫入會員紅利轉出
                        $didata=array(
                            'buyer_id'=>$_SESSION['MT']['by_id'],
                            'd_type'=>75,
                            'd_val'=>Comment::SetValue('d_bonus'),
                            'd_des'=>"會員紅利轉出:".Comment::SetValue('d_content'),
                            'is_send'=>'Y',
                            'create_time'=>$this->useful->get_now_time(),
                            'update_time'=>$this->useful->get_now_time(),
                            'send_dt'=>$this->useful->get_now_time(),
                        );
                        $this->mymodel->insert_into('dividend',$didata);
                        $this->mymodel->update_set('buyer','by_id',$_SESSION['MT']['by_id'],array('d_dividend'=>$o_dividend));

						
                        echo '<script>alert("轉出成功");window.location.href="/bonus/dividend";</script>';
                        return '';
                    }else{
                        echo '<script>alert("會員點數不得扣除低於零，無法操作");history.go(-1);</script>';
                        return '';
                    }
                }else{
                    echo '<script>alert("查無此會員");history.go(-1);</script>';
                    return '';
                }
            }
			
		}
        
        // 判斷是否登入
        if($_SESSION['MT']['by_id']!=""){
            $this->useful->iconfig();
            $this->DataName='bonus';
            $this->data['banner']   = $this->banner_model->getMyAd();
            $data['path_title']     ='<li><a href="/gold/member"><span>'.$this->lang_menu['member'].'</span></a></li>'.
                                '<li><a href="/'.$this->DataName.'/dividend"><span>'.$this->lang['didetail'].'</span></a></li><span>會員紅利轉出</span><li></li>';
            
            //推薦人
            $by_id = $_SESSION['MT']['by_id'];
            $buyer= $this->mymodel->OneSearchSql('buyer','PID',array('by_id'=>$by_id));
            $PID    =   $buyer['PID'];
            if($by_id<>4){
                $memberName = $this->mymodel->OneSearchSql('buyer','name',array('by_id'=>$PID));
                $data['memberName'] =   $this->lang['yourAccount'].'<b>'.$memberName['name'].'</b>';
            }

            //會員剩餘紅利
            $bdata=$this->mymodel->OneSearchSql('buyer','birthday,d_dividend',array('by_id'=>$by_id));
            //有效期限
            $data['birthday']=(date('Y')+1).'-'.date("m-d", strtotime($bdata['birthday']."-1 day")).'  23:59';
            $data['dividend']=($bdata['d_dividend']=='')?'0':$bdata['d_dividend'];
            $dbirthday=(date('Y')).'-'.substr($bdata['birthday'],5);
            
            $data['dbdata']=$dbdata;
            $data['banner']=$this->data['banner'];
            
            //view
            $this->load->view('index/header'.$this->style, $data);
            $this->load->view('index/member/member_nav', $data);
            $this->load->view('index/bonus/givebonus', $data);
            $this->load->view('index/footer'.$this->style, $data);
        }else{
            $_SESSION['url']    =   'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $this->useful->AlertPage('/gold/login',$this->lang['Login']);            
        }
    }

    //後台---------------------------------------------------------------------------------------------------------
    
    // 補訂單獎金歸屬ID
    public function test(){
        $sql='select id,by_id from `order` where member_id=0 and create_time between "2017-04-26" and "2017-04-30" ';
        // $sql=" select PID from buyer"; 
        $dbdata=$this->mymodel->WriteSQL($sql);
        foreach ($dbdata as $key => $value) {
            $sql2=" select PID from buyer where by_id=".$value['by_id'].""; 
            $bdata=$this->mymodel->WriteSQL($sql2,1);
            // print_r($bdata);
           $sql1=" update `order` set member_id=".$bdata['PID']." where id=".$value['id']."";
           echo $sql1;
           $this->mymodel->SimpleWriteSQL($sql1);
        }
        print_r($dbdata);
    }

    //APP銷售明細
    public function sale(){
        
        //權限判斷
        $this->useful->CheckComp('j_saleorder');
        if(!empty($_POST['sort_ad'])){
            $data["sort"]=$_POST['sort'];
            $data["sort_ad"]=$_POST['sort_ad'];
        }
        if(!empty($_POST['date_start_member'])){
            $_SESSION["AT"]["where"]["date_start"]=$_POST['date_start_member'];
            $_SESSION["AT"]["where"]["date_end"]=$_POST['date_end_member'];
        }
        $dbdata=$this->bmodel->salesql($_POST['member_d_is_member'],$_POST['date_start_member'],$_POST['date_end_member'],$_POST['txt_member'],$_POST['sort'],$_POST['sort_ad']);

        foreach ($dbdata as $key => $value) {
            $dbdata[$key]['d_spec_type']=($value['d_spec_type']==0)?'無特殊身分':'員工';
        }

        $data['dbdata']=$dbdata;
        //view
        $this->load->view('bonus/sale', $data);
    }
    //APP銷售明細內文
    public function sale_list($mid){
         //權限判斷
        $this->useful->CheckComp('j_saleorder');
        //model
        $this->load->model('order_model','omodel');

        //資料庫名稱
        $data['dbname']=$dbname='`order`';

        if(empty($mid)){
            echo '<script>alert("ID錯誤");history.go(-1);</script>';
            return '';
        }
        //預設查詢
        $_POST["by_id"]=$mid;
        $search_default_array=array("ToPage","select_type","txt","product_flow_select","payment_way_select","status_select","logistics_way_select","date_start","date_end","by_id");
        $this->omodel->search_session($search_default_array);
        
        
        $where_array=array();
        $where_array[]="product_flow=4";
        $where_array[]="status=1";
        $where_array[]="member_id=".$mid;
        if($_SESSION["AT"]["where"]["txt"]!=""){
            $where_array[]="(order_id like '%".$_SESSION["AT"]["where"]["txt"]."%' or by_id in(select by_id from buyer where concat(name,'|',by_email) like '%".$_SESSION["AT"]["where"]["txt"]."%'))";
        }
        if($_SESSION["AT"]["where"]["product_flow_select"]!=""){
            $where_array[]="product_flow=".$_SESSION["AT"]["where"]["product_flow_select"];
        }
        if($_SESSION["AT"]["where"]["payment_way_select"]!=""){
            $where_array[]="pay_way_id=".$_SESSION["AT"]["where"]["payment_way_select"];
        }
        if($_SESSION["AT"]["where"]["status_select"]!=""){
            $where_array[]="status=".$_SESSION["AT"]["where"]["status_select"];
        }
        if($_SESSION["AT"]["where"]["logistics_way_select"]!=""){
            $where_array[]="lway_id=".$_SESSION["AT"]["where"]["logistics_way_select"];
        }
        if($_SESSION["AT"]["where"]["date_start"]!=""){
            $where_array[]="date>='".strtotime($_SESSION["AT"]["where"]["date_start"]." 00:00:00")."'";
        }
        if($_SESSION["AT"]["where"]["date_end"]!=""){
            $where_array[]="date<='".strtotime($_SESSION["AT"]["where"]["date_end"]." 23:59:59")."'";
        }
        $where=!empty($where_array)?"where ".implode(" and ",$where_array):"";
        //分頁程式 start
        $data['ToPage']=$Topage=!empty($_POST['ToPage'])?$_POST['ToPage']:1;
        $qpage=$this->useful->SetPage($dbname." ".$where,'',20);
        $data['page']=$this->useful->get_page($qpage);
        //分頁程式 end
        //訂單資料
        $data['dbdata']=$this->omodel->get_order_data($where,$qpage['result']);
        $data["payment_way"]=$this->omodel->get_payment_way_data('');//付款方式
        $data["logistics_way"]=$this->omodel->get_logistics_way_data('');//寄送方式
        $data["status"]=$this->omodel->get_status_data(); //付款狀態
        $data["product_flow"]=$this->omodel->get_product_flow_data();  //訂單狀態

        //view
        $this->load->view('bonus/sale_list', $data);
    }
    public function sale_info($id=''){//會員訂購明細內頁
        @session_start();
    
        //權限判斷
        $this->useful->CheckComp('j_orderinfo');
        //model
        $this->load->model('order_model','omodel');
        
        $data['dbname']=$dbname='`order`';
        if(empty($id)){
            echo '<script>alert("ID錯誤");history.go(-1);</script>';
            return '';
        }
        $dbdata=$this->omodel->get_order_sign($id);
        $data['dbdata']=$dbdata;
    
        $data["payment_way"]=$this->omodel->get_payment_way_data('');//付款方式
        $data["logistics_way"]=$this->omodel->get_logistics_way_data('');//寄送方式
        $data["status"]=$this->omodel->get_status_data(); //付款狀態
        $data["product_flow"]=$this->omodel->get_product_flow_data();  //訂單狀態

        //詳細訂單資料
        $data["oddata"]=$this->omodel->get_order_details_data($id);
        //發票號碼
        $command="select * from invoice where ";
        $command.="d_is_open='Y'";
        $command.=" and d_year=".(date("Y",time())-1911);
        $command.=" and d_month=".((ceil(date("m",time())/2)*2)-1);
        $command.=" and d_date<='".date("Y-m-d",time())."'";
        $command.=" and (d_now_num=0 or (d_now_num>=d_start and d_now_num<d_end))";
        $get_sInvoice=$this->db->query($command);
        $data["get_sInvoice"]=$get_sInvoice->result_array();
        $data["dividend"]=$this->omodel->dividend($id);//紅利
        //view
        $this->load->view('bonus/sale_info', $data);
    }

    //獎金規則管理
    public function account_rule(){
        //權限判斷
        $this->useful->CheckComp('j_account');

        $data['rule']=$this->mymodel->GetConfig('rule'); 
        if(!empty($_POST)){
            foreach ($_POST['rule'] as $key => $value) {
                $this->mymodel->update_set('config','d_id',$key,array('d_val'=>$value));
            }
            $_POST=array();
            echo '<script>alert("更新成功");window.location.href="/bonus/account_rule";</script>';
        }
        //view
        $this->load->view('bonus/account_rule', $data);
    }
    //電子發票管理
    public function invoice_list(){
        //權限判斷
        $this->useful->CheckComp('j_account');

        //資料庫名稱
        $data['dbname']=$dbname='invoice';  

        $dbdata=$this->mymodel->select_page_form($dbname,'','*','','create_time','desc');
        foreach ($dbdata as $key => $value) {
            $dbdata[$key]['d_start']=substr('00000000'.$value['d_start'],-8);
            $dbdata[$key]['d_end']=substr('00000000'.$value['d_end'],-8);
        }
        $data['dbdata']=$dbdata;

        //分頁程式 start
        $data['ToPage']=$Topage=!empty($_POST['ToPage'])?$_POST['ToPage']:1;
        $qpage=$this->useful->SetPage($dbname,'',20,'','',count($dbdata));        
        $data['page']=$this->useful->get_page($qpage);
        //分頁程式 end  

        //view
        $this->load->view('bonus/invoice_list', $data);
    }
    //電子發票內頁
    public function invoice_info(){
        //權限判斷
        $this->useful->CheckComp('j_account');

        //發票年份(取今年跟去年)
        $data['toyear']=array((date('Y')-1911),(date('Y')-1912));
        //發票月份
        $data['tomonth']=$this->mymodel->GetConfig('invoice');
        //資料庫名稱
        $data['dbname']='invoice';
        // $data['dbdata']=$this->bmodel->select_from('invoice',array('d_id'=>$id));
        

        //view
        $this->load->view('bonus/invoice_info', $data);
    }
    
    //獎金列表
    public function bonus_total_list(){
        //權限判斷
        $this->useful->CheckComp('j_bonus');

        //找出有結算紀錄的最新一筆(月)
        $last_month=$this->bmodel->get_bonus_date();

        $month=strtotime('now -1 month',time());
        $last_record=$last_month['d_Year'].'-'.substr('00'.$last_month['d_Month'],-2); // 把 $last_month 對應到 MySql 格式

        if($last_record!=date('Y-m',$month)){ // 最後一筆不等於這個月
            $chmonth=explode('-',date('Y-m',strtotime('now +1 month',strtotime($last_record.'-01'))));
            $last_month['d_Year']=$chmonth[0];
            $last_month['d_Month']=$chmonth[1];
            $data['data']=$last_month;
        }
        //view
        $this->load->view('bonus/bonus_total_list', $data);
    }
    //獎金結算
    public function bonus_total(){
        //權限判斷
        $this->useful->CheckComp('j_bonus');
        
        $date=$_POST['year'].'-'.substr('00'.$_POST['month'],-2);

        $new_data=$this->bmodel->get_order_data($date,1);

        //有值才動作
        if(!empty($new_data)){
            //撈取獎金計算值(一代)
            $oneline=$this->mymodel->GetConfig("",'1');
            //撈取獎金計算值(二代)
            $twoline=$this->mymodel->GetConfig("",'2');
            //撈取獎金計算值(KV值)
            $kv=$this->mymodel->GetConfig("",'3');
            

           
            foreach ($new_data as $nvalue) {
                $orderstr='';
                if($nvalue['member_id']!=0){
                    //一代獎金
                    $bdata=$this->bmodel->get_buyer_data($nvalue['by_id']);
                    $mdata=$this->bmodel->get_member_data($nvalue['member_id']);
                    if($mdata[0]['name'] == ''){
                        continue;
                    }
                        
                    $odata=$this->mymodel->select_page_form('order_details','','prd_name',array('order_id'=>$nvalue['order_id']));
                    foreach ($odata as $okey => $ovalue) {
                        $orderstr.=$ovalue['prd_name'].',';
                    }
                    $orderstr=$this->useful->del_string_last($orderstr);
          
                    $pv=$nvalue['total_pv']*($oneline['d_val']/100);
                    $one_data=array(
                        'OID'=>$nvalue['order_id'],
                        'd_pvper'=>$oneline['d_val'],
                        'd_pv'=>$pv,
                        'd_kv'=>$kv['d_val'],
                        'd_bonus'=>$pv*$kv['d_val'],
                        'MID'=>$nvalue['member_id'],
                        'sName'=>$mdata[0]['name'],
                        'd_type_id'=>1,
                        'd_type'=>'一代獎金',
                        'd_content'=>'來自推薦訂單號碼['.$nvalue['order_id'].'] - 姓名：'.$bdata['name'].' - 商品：'. $orderstr.' ',
                        'd_date'=>$nvalue['create_time'],
                        'd_year'=>$_POST['year'],
                        'd_month'=>substr('00'.$_POST['month'],-2)
                    );
                    $bdata=$this->bmodel->get_bdata($nvalue['member_id'],$_POST['year'],$_POST['month'],1,$nvalue['order_id']);
                    if(!empty($bdata))
                        $this->bmodel->update_set('bonus','d_id',$bdata['d_id'],$one_data); 
                    else
                        $this->bmodel->insert_into('bonus',$one_data);
                    
                  
                    //一代獎金
                    //二代獎金
                    $two=$this->bmodel->get_up_data($nvalue['member_id']);

                    if($two[0]['upline']!=0){
                        $twoid=$two[0]['upline'];
                        if($twoid!=0){
                            $mdata=$this->bmodel->get_member_data($twoid);
                            // print_r($mdata);

                            $pv=$nvalue['total_pv']*($twoline['d_val']/100);
                            $two_data=array(
                                'OID'=>$nvalue['order_id'],
                                'd_pvper'=>$twoline['d_val'],
                                'd_kv'=>$kv['d_val'],
                                'd_pv'=>$pv,
                                'd_bonus'=>$pv*$kv['d_val'],
                                'MID'=>$twoid,
                                'sName'=>$mdata[0]['name'],
                                'd_type_id'=>2,
                                'd_type'=>'二代獎金',
                                'd_content'=>'來自推薦訂單號碼['.$nvalue['order_id'].'] - 姓名：'.$bdata['name'].' - 商品：'. $orderstr.' ',
                                'd_date'=>$nvalue['create_time'],
                                'd_year'=>$_POST['year'],
                                'd_month'=>substr('00'.$_POST['month'],-2)
                            );
                            $bdata=$this->bmodel->get_bdata($twoid,$_POST['year'],$_POST['month'],2,$nvalue['order_id']);
                            if(!empty($bdata))
                                $this->bmodel->update_set('bonus','d_id',$bdata['d_id'],$two_data); 
                            else
                                $this->bmodel->insert_into('bonus',$two_data);
                        }
                    }
                    //二代獎金
                }
            }

            //體系獎金
            foreach ($new_data as $fvalue) {
                $orderstr='';
                if($fvalue['member_id']!=0){
                    $gid=$this->bmodel->get_up_data($fvalue['member_id']);  
                    $gid=$gid[0]['GID'];

                    if($gid!=0){
                        $gdata=$this->bmodel->get_family_data($gid);
                        $gmid=$gdata['MID'];
                        $gper=$gdata['d_pernum'];
                        $mdata=$this->bmodel->get_member_data($gmid);

                        //是否已有寫入
                        $bdata=$this->bmodel->get_bdata($gmid,$_POST['year'],$_POST['month'],3,$fvalue['order_id']);

                        
                        $odata=$this->mymodel->select_page_form('order_details','','prd_name',array('order_id'=>$fvalue['order_id']));
                        foreach ($odata as $okey => $ovalue) {
                            $orderstr.=$ovalue['prd_name'].',';
                        }
                        $orderstr=$this->useful->del_string_last($orderstr);

                        $pv=$fvalue['total_pv']*($gper/100);

                        $grade_data=array(
                            'OID'=>$fvalue['order_id'],
                            'd_pvper'=>$gper,
                            'd_kv'=>$kv['d_val'],
                            'd_pv'=>$pv,
                            'd_bonus'=>$pv*$kv['d_val'],
                            'MID'=>$gmid,
                            'sName'=>$mdata[0]['name'],
                            'd_type_id'=>3,
                            'd_type'=>'體系獎金',
                            'd_content'=>'來自推薦訂單號碼['.$fvalue['order_id'].'] - 姓名：'.$bdata['name'].' - 商品：'. $orderstr.' ',
                            'd_date'=>$nvalue['create_time'],
                            'd_year'=>$_POST['year'],
                            'd_month'=>substr('00'.$_POST['month'],-2)
                        );
                        
                        if(!empty($bdata))
                            $this->bmodel->update_set('bonus','d_id',$bdata['d_id'],$grade_data);   
                        else
                            $this->bmodel->insert_into('bonus',$grade_data);
                    }
                }
            }

    
            $last=array(
                'd_Year'=>$_POST['year'],
                'd_Month'=>$_POST['month'],
            );
            $this->bmodel->insert_into('bonus_last',$last);
              
        }else{
            echo '<script>if(confirm("此月無訂單，確定結算?"))window.location.href="/bonus/WriteMonth/'.$_POST['year'].'/'.$_POST['month'].'";</script>';     
        }
        echo '<script>alert("結算完畢");window.location.href="/bonus/bonus_total_list";</script>';  
    }

    //無訂單時跳轉此頁，記錄此月已結算完畢，寫入bonus_last資料庫
    public function WriteMonth($year='',$month=''){
        $last=array(
            'd_Year'=>$year,
            'd_Month'=>$month,
        );
        $this->mymodel->insert_into('bonus_last',$last);
        $this->useful->AlertPage('/bonus/bonus_total_list');
        return '';
    }

    //獎金明細列表
    public function bonus_list(){
        //權限判斷
        $this->useful->CheckComp('j_month');
        
        $dbdata=$this->bmodel->get_bonus_date('1');
        foreach ($dbdata as $key => $value) {
            $dbdata[$key]['iMonth']=substr('00'.$value['d_Month'],-2);
        }
        $data['bdate']=$dbdata;
        $data['iYear']= 0;

        //view
        $this->load->view('bonus/bonus_list', $data);
    }
    //獎金明細列表
    public function bonus_list2(){
        //權限判斷
		$this->useful->CheckComp('j_bonus_list');
			
		$search_default_array=array('s_account','s_name','s_type','date_start','date_end');
		$this->mymodel->search_session($search_default_array);

		$where_array=array();
		$where_array[]="bonus.d_type_id=0";
		if($_SESSION["AT"]["where"]['s_account']!=""){
		    $where_array[]="buyer.d_account like '%".$_SESSION["AT"]["where"]['s_account']."%'";
		}
		if($_SESSION["AT"]["where"]['s_name']!=""){
		    $where_array[]="buyer.name like '%".$_SESSION["AT"]["where"]['s_name']."%'";
		}
		if($_SESSION["AT"]["where"]['s_type']!=""){
		    $where_array[]="bonus.d_type like '%".$_SESSION["AT"]["where"]['s_type']."%'";
		}
		if($_SESSION["AT"]["where"]["date_start"]!=""  and $_SESSION["AT"]["where"]["date_end"]!=""){
			$where_array[]="bonus.d_date between '".$_SESSION["AT"]["where"]["date_start"]."' and '".$_SESSION["AT"]["where"]["date_end"]."'";
		}
		$where=!empty($where_array)?" where ".implode(" and ",$where_array):"";
		// 分頁程式 start
		$this->load->library('/mylib/PageNew');
	    $page=new PageNew();
	    $page->SetMySQL($this->db);
		$page->SetPagSize(20);
		$qpage=$page->PageStar('bonus left join member on bonus.MID=member.member_id left join buyer on buyer.by_id=member.by_id','',$where);
		$data['page']=$this->load->view('mypage/page',$qpage,true);
		// print_r($_POST);
        //分頁程式 end
		$this->load->model('shoppingmoney_model','smodel');
		$dbdata=$this->smodel->GetShoppingmoney1($where,$qpage['result']);
		$data['dbdata']=$dbdata;
		//view
		$this->load->view('bonus/bonus_list2', $data);
    }
	
	public function dl_moneytransfer(){
		//權限判斷
		$this->useful->CheckComp('j_moneytransfer');

		$title_array=array('時間','會員帳號','會員姓名','付款方式','請款金額','狀態');
		
		$where_array=array();
		$where_array[]="bonus.d_type_id=0";
		if($_SESSION["AT"]["where"]['s_account']!=""){
		    $where_array[]="buyer.d_account like '%".$_SESSION["AT"]["where"]['s_account']."%'";
		}
		if($_SESSION["AT"]["where"]['s_name']!=""){
		    $where_array[]="buyer.name like '%".$_SESSION["AT"]["where"]['s_name']."%'";
		}
		if($_SESSION["AT"]["where"]['s_type']!=""){
		    $where_array[]="bonus.d_type like '%".$_SESSION["AT"]["where"]['s_type']."%'";
		}
		if($_SESSION["AT"]["where"]["date_start"]!=""  and $_SESSION["AT"]["where"]["date_end"]!=""){
			$where_array[]="bonus.d_date between '".$_SESSION["AT"]["where"]["date_start"]."' and '".$_SESSION["AT"]["where"]["date_end"]."'";
		}
		$where=!empty($where_array)?" where ".implode(" and ",$where_array):"";
		$this->load->model('shoppingmoney_model','smodel');
		$dbdata=$this->smodel->GetShoppingmoney1($where,$qpage['result']);
		
		foreach ($dbdata as $value){
			$data_array[]=array(
				$value['d_date'],
				$value['d_account'],
				$value['name'],
				$value['d_type'],
				$value['d_bonus'],
				$value['d_send'],
				);						
		}
		$this->export_xls($title_array,$data_array,date('Y-m-d').'資金紀錄');
	}

    //獎金統計記算端
    public function total_hand(){
        $date=$_POST['date'];
        // $date=$_GET['date'];
        $year=substr($date,0,4);
        $month=substr($date,4,2);

    
        $this->bmodel->del_total($year,$month);

        $date=$year.'-'.$month;
        $this->bmodel->adjustBonusLastStatus($year, $month);
        $dbdata=$this->bmodel->bonus_pay($year,$month);
        // print_r($dbdata);
        foreach ($dbdata as $key => $value) {
            if($value['d_block']=='N'){
                $mdata=$this->mymodel->OneSearchSql('member','iInsurance',array('member_id'=>$value['MID']));
                $idata=array(
                    'MID' =>$value['MID'] ,
                    'sName' =>$value['sName'] ,
                    'iInsurance' =>$mdata['iInsurance'] ,
                    'd_year' => $year ,
                    'd_month' =>$month ,
                    'd_date' =>$year.'-'.$month.'-01',
                    'create_time' =>$this->useful->get_now_time()
                );
             
                // 如果不是一代二代體系，則是其他或扣款
                if($value['d_type_id']!=1 and $value['d_type_id']!=2 and $value['d_type_id']!=3){
                    $pvname=$this->mymodel->GetConfig('',$value['d_type_id']);
                    if($pvname['d_type']=='reissue')
                        $value['d_type_id']=4;
                    else
                        $value['d_type_id']=5;    
                }

                $sdata=$this->mymodel->OneSearchSql('bonus_pay','*',array('MID'=>$value['MID'],'d_year'=>$year,'d_month'=>$month));
                if(!empty($sdata)){
                    $idata['pv'.substr('00'.$value['d_type_id'],-2).'']=$sdata['pv'.substr('00'.$value['d_type_id'],-2).'']+$value['d_pv'];
                    $idata['bonus'.substr('00'.$value['d_type_id'],-2).'']=$sdata['bonus'.substr('00'.$value['d_type_id'],-2).'']+$value['d_bonus'];
                   $this->mymodel->update_set('bonus_pay','d_id',$sdata['d_id'],$idata);
                }else{
                    $idata['pv'.substr('00'.$value['d_type_id'],-2).'']=$value['d_pv'];
                    $idata['bonus'.substr('00'.$value['d_type_id'],-2).'']=$value['d_bonus'];
                   $this->mymodel->insert_into('bonus_pay',$idata);
                }
            }
        }

        $pdata=$this->mymodel->select_page_form('bonus_pay','','*',array('d_year'=>$year,'d_month'=>$month));

        if(!empty($pdata)){
            foreach($pdata as $value){
                $iOTotal = 0;
                $iTax = 0;
                $i2nhi = 0;

                for ($i=1; $i <=4 ; $i++) { 
                    $iOTotal = $iOTotal + $value["bonus".substr('00'.$i,-2).""];
                }
                //扣款
                $iOTotal=$iOTotal-$value["bonus05"];

                //所得稅
                if($iOTotal>20000)
                    $iTax = $iOTotal * 10 / 100;
                /*
                    二代健保
                    2016年前為高過五千則扣2%
                    2016年後為高於兩萬則扣1.91%
                */              
                if($value["iInsurance"]=='Y'){
                    if($year<2016){
                        if($iOTotal >5000){
                            $i2nhi = $iOTotal * 2 / 100; //原扣2%
                        }
                    }else{
                        if($iOTotal>20000)
                            $i2nhi = $iOTotal * 1.91 / 100; //2016年扣 1.91%
                    }
                }
                
                $idata=array(
                    'iOTotal'=>$iOTotal,
                    'iTax'=>$iTax,
                    'i2nhi'=>round($i2nhi),
                    'iTotal'=>$iOTotal-$iTax-$i2nhi,
                );
               $this->mymodel->update_set('bonus_pay','d_id',$value['d_id'],$idata);
        			$member=$this->mymodel->OneSearchSql('member','by_id',array('member_id'=>$value['MID']));
							$buyer=$this->mymodel->OneSearchSql('buyer','*',array('by_id'=>$member['by_id']));
							$d_difference=$buyer['d_bonus']+$iOTotal-$iTax-$i2nhi;
							$this->mymodel->update_set('buyer','by_id',$buyer['by_id'],array('d_bonus'=>$d_difference));
            }
        }
        echo 'ok';      
    }

    //獎金明細內頁
    public function bonus_info(){
        //權限判斷
        $this->useful->CheckComp('j_month');

        $bonus_data=$this->bmodel->get_bonus_data($_POST['year'],$_POST['month'],'');
        
        foreach ($bonus_data as $key => $value) {
            $bdata=$this->bmodel->get_buyer_data($value['m_id']);
            if($value['d_type']==1){
                $d_type='推薦人獎金來自'.$bdata['name'];
            }elseif($value['d_type']==2){
                $d_type='推薦人上線獎金來自'.$bdata['name'];
            }elseif($value['d_type']==3){
                $d_type='體系獎金來自'.$bdata['name'];
            }elseif($value['d_type']==4){
                $d_type='折抵';
            }elseif($value['d_type']==5){
                $d_type='手動新增';
            }
            $bonus_data[$key]['d_type']=$d_type;
        }
        $data['dbdata']=$bonus_data;
        //view
        $this->load->view('bonus/bonus_info', $data);
    }

    //獎金編輯
    public function bonus_fix(){
        //權限判斷
        $this->useful->CheckComp('j_bonusedit');
        $dbdata=$this->bmodel->get_bonus_date('1');
        foreach ($dbdata as $key => $value) {
            $dbdata[$key]['iMonth']=substr('00'.$value['d_Month'],-2);
        }
        $data['bdate']=$dbdata;
        $data['iYear']= 0;
        //view
        $this->load->view('bonus/bonus_fix', $data);
    }
    //獎金編輯列表
    public function bonus_fix_list(){
        //權限判斷
        $this->useful->CheckComp('j_bonusedit');
        if(empty($_POST['ToPage'])){
            $_SESSION['d_year']=$_POST['year'];
            $_SESSION['d_month']=substr('00'.$_POST['month'],-2);
        }
        $data['year']= $_SESSION['d_year'];
        $data['month']= $_SESSION['d_month'];
        // $data['year']=$_POST['year'];
        // $data['month']=substr('00'.$_POST['month'],-2);
        // $dbdata=$this->bmodel->get_bonus_data($_POST['year'],$_POST['month']);
        // 分頁程式 start
        $data['ToPage']=$Topage=!empty($_POST['ToPage'])?$_POST['ToPage']:1;
        $page_limit     =   30  ;// 每頁顯示筆數
        $qpage=$this->useful->SetPage('bonus','',$page_limit,array('d_Year'=>$_SESSION['d_year'], 'd_Month'=>$_SESSION['d_month']));
        $data['page']=$this->useful->get_page($qpage);
        //分頁程式 end  
        $dbdata=$this->bmodel->get_bonus_data($_SESSION['d_year'],$_SESSION['d_month'],'',$Topage,$page_limit);
        foreach ($dbdata as $key => $value) {
            $dbdata[$key]['d_bonus']=number_format($value['d_bonus'],2);
            $dbdata[$key]['d_send']=($value['d_send']=='N')?"未發送":"已發送";
            $dbdata[$key]['rd_type']=($value['rd_type']=='0')?"<span style='color:red'>":"<span style='color:green'>";
        }

        $data['is_calculated'] = $this->bmodel->getCalculatedStatus($_POST['year'], $_POST['month'])['is_calculated'];
        $data['dbdata']=$dbdata;
        //view
        $this->load->view('bonus/bonus_fix_list', $data);
    }
    //獎金編輯內頁
    public function bonus_fix_info($id=''){
        //權限判斷
        $this->useful->CheckComp('j_bonusedit');
        
        $data['dbname']='bonus';

        $data['year']=$_POST['year'];
        $data['month']=substr('00'.$_POST['month'],-2);

        //補發項目
        $data['reissue']=$this->mymodel->GetConfig('reissue');
        //扣除項目
        $data['deduction']=$this->mymodel->GetConfig('deduction');

        if($id!=''){
            $dbdata=$this->bmodel->get_bonus_data('','',$id);
            //撈取會員編號
            $mnum=$this->mymodel->OneSearchSql('member','member_num',array('member_id'=>$dbdata['MID']));
            $dbdata['member_num']=$mnum['member_num'];
            
        }
        $data['dbdata']=$dbdata;
        //view
        $this->load->view('bonus/bonus_fix_info', $data);
    }
    //手動獎金寫入
    public function bonus_AE(){
        if($_POST['d_id']!=''){
            $d_block=($_POST['d_block']!='')?$_POST['d_block']:'N';

            $data=array(
                'd_block'=>$d_block,
                'd_bcontent'=>$_POST['d_bcontent']
            );
            $this->mymodel->update_set('bonus','d_id',$_POST['d_id'],$data);
            echo '<script>alert("修改成功");window.location.href="/bonus/bonus_fix";</script>';
        }else{
        $this->load->library('/mylib/CheckInput');
        $check=new CheckInput;
        $check->fname[]=array('_String',Comment::SetValue('member_id'),'會員名稱');
        // $check->fname[]=array('_String',Comment::SetValue('d_date'),'生效日期');
        $check->fname[]=array('_CheckRadio',Comment::SetValue('rd_type'),'獎金類型');
        if(!empty($check->main())){
            echo $check->main();
            return '';
        }
            $data=$this->useful->DB_Array($_POST);
            //撈取會員ID
            $member=$this->mymodel->OneSearchSql('member','member_id,by_id',array('member_num'=>$data['member_id']));
            ////撈取會員姓名
            $mname=$this->mymodel->OneSearchSql('buyer','name',array('by_id'=>$member['by_id']));

            $data['MID']=$member['member_id'];
            $data['sName']=$mname['name'];
            $data['d_pv']=($data['r_pv']!='')?$data['r_pv']:$data['e_pv'];

            //獎金說明
            $type_id=($data['rd_type']==0)?$data['r_type_id']:$data['e_type_id'];
            $type=$this->mymodel->GetConfig('',$type_id);
            $data['d_type']=$type['d_title'];
            $data['d_type_id']=$type_id;

            
            //撈取KV
            $kv=$this->mymodel->GetConfig('','3');
            $data['d_kv']=$kv=$kv['d_val'];
            //計算獎金
            $data['d_bonus']=$data['d_pv']*$kv;
            //日期拆解
            $data['d_year']=substr($data['year_month'],0,4);
            $data['d_month']=substr($data['year_month'],4,2);
          
            $data=$this->useful->UnsetArray($data,array('year_month','d_id','member_id','r_pv','e_pv','r_type_id','e_type_id','update_time'));

            $this->mymodel->insert_into('bonus',$data);

            echo '<script>alert("新增成功");window.location.href="/bonus/bonus_fix";</script>';
        }
    }

    //二代健保代扣更新
    public function twohisetting(){
        //權限判斷
        $this->useful->CheckComp('j_account');

        //view
        $this->load->view('bonus/twohisetting', $data);
    }
    //下載身分證
    public function report_userid(){
        //權限判斷
        $this->useful->CheckComp('j_account');

        $member_data=$this->bmodel->get_member_data();
        $filename=date('Ym').'_個人會員身份證.txt';
        $myfile = fopen("uploads/newfile.txt", "w") or die("Unable to open file!");
        foreach ($member_data as $key => $value) {
            $txt = $value['identity_num']."\r\n";
            fwrite($myfile, $txt);
        }
        fclose($myfile);
        if(file_exists("uploads/newfile.txt") and is_file("uploads/newfile.txt")){
            header("Content-type: ".filetype("uploads/newfile.txt"));//指定類型
            header("Content-Disposition: attachment; filename='".$filename."'");//指定下載時的檔名
            header('Content-Type: application/octet-stream');
            readfile("uploads/newfile.txt");//輸出下載的內容。
            unlink("uploads/newfile.txt");
          }
        else{
            echo "查無此檔案";
        }
    }
    // 上傳二代健保代扣身份證檢查檔到本系統
    public function uploads_id(){
        //權限判斷
        $this->useful->CheckComp('j_account');

        $file=$_FILES['filetmp'];
        $file_data=file_get_contents($file['tmp_name']);
        // $file_data=file_get_contents('http://tester.rich899.net/uploads/test.txt');
        $data = explode("\r\n",$file_data);
        $id_array=array();
        foreach ($data as $key => $value) {
            if(!empty($value)){
                $val=explode(",",$value);
                $val[4]=trim($val[4]);
                $val[5]=trim($val[5]);
                if($val[4]=="Y" || $val[5]=="06"){
                    $id_array[$val[1]]="'".$val[1]."'";
                }
            }
        }
        $this->bmodel->set_insur();
        if(!empty($id_array)){
            $this->bmodel->set_insur(implode(",",$id_array));
        }
        echo "分析完成，共 ".count($id_array)." 人需代扣二代健保";
    }

    //晉升清單&手動晉升
    public function grade_list(){

        //權限判斷
        $this->useful->CheckComp('j_upfamily');
        //今年
        $data['toyear']=date('Y');
     
        if(!empty($_POST)){
            $data['s_year']=$s_year=$_POST['search_year'];
            $data['s_month']=$s_month=$_POST['search_month'];

            //-1找尋上月份資訊
            // $s_month=$s_month-1;

            $order_data=$this->bmodel->get_grade_data($s_year,substr('00'.$s_month,-2));
            $ostr='';
           // print_r($order_data);
            foreach ($order_data as $ovalue) {       

                $mdata=$this->mymodel->OneSearchSql('member','member_id,upline',array('member_id'=>$ovalue['member_id']));
                  
                //回饋上線
                if(!empty($mdata)){
                    if($mdata['upline']!=0){
                        $updata[$mdata['upline']]+=$ovalue['total_price'];
                    }
                    $upupdata=$this->mymodel->OneSearchSql('member','upline',array('member_id'=>$mdata['upline']));
                    if($upupdata['upline']!=0){
                       $updata[$upupdata['upline']]+=$ovalue['total_price']; 
                    }
                    if(!empty($updata)){
                        foreach ($updata as $key=>$uvalue) {
                            if($uvalue>=5000000)
                                $okchk[$key]=$uvalue;
                        }   
                    }
                }
                //所有下線總合
                if(!empty($mdata)){
                    $downdata=$this->mymodel->select_page_form('member','','member_id',array('upline'=>$mdata['member_id']));
                    foreach ($downdata as $dvalue) {
                        $ostr.=$dvalue['member_id'].',';
                        $dododata=$this->mymodel->select_page_form('member','','member_id',array('upline'=>$dvalue['member_id']));
                        foreach($dododata as $ddvalue){
                             $ostr.=$ddvalue['member_id'].',';
                        }
                    }
                    $ostr=$this->useful->del_string_last($ostr);
                    $order_total=$this->bmodel->get_grade_data($s_year,substr('00'.$s_month,-2),$ostr,1);
                    if($order_total[0]['stotal']>=5000000)
                        $okchk[$ovalue['member_id']]=$order_total[0]['stotal'];
                   
                    $ostr='';
                }


                //單筆超過的話
                if($ovalue['total_price']>=5000000)
                    $okchk[$ovalue['member_id']]=$ovalue['total_price'];
            }
        }
        // print_r($okchk);
        $o=0;
        if(!empty($okchk)){
            foreach ($okchk as $okey=> $ovalue) {
                if($ovalue!='' or $ovalue>=5000000){
                    $chkme=$this->mmodel->get_member_sign($okey,'','1');
                    if(!empty($chkme)){
                        $chkmember[$o]=$chkme;
                        $chkmember[$o]['stotal']=$ovalue;
                        $o++;           
                    }
                }
            }
        }

        $data['dbdata']=$chkmember;
        //view
        $this->load->view('bonus/grade_list', $data);
    }
    //晉升消費記錄
    public function grade_info($s_year='',$s_month='',$mid=''){
        //權限判斷
        $this->useful->CheckComp('j_upfamily');
        $s_month=$s_month+1;

        $downdata=$this->mymodel->select_page_form('member','','member_id',array('upline'=>$mid));
        foreach ($downdata as $dvalue) {
            $ostr.=$dvalue['member_id'].',';
            $dododata=$this->mymodel->select_page_form('member','','member_id',array('upline'=>$dvalue['member_id']));
            foreach($dododata as $ddvalue){
                 $ostr.=$ddvalue['member_id'].',';
            }
        }
        $ostr=$ostr.$mid;

        $data['dbdata']=$this->bmodel->get_grade_order($s_year,$s_month,$ostr);
        
        //view
        $this->load->view('bonus/grade_info', $data);
    }

    //晉升內頁
    public function upmember(){
        //權限判斷
        $this->useful->CheckComp('j_upfamily');


        //撈取無負責人之體系
        $dbdata=$this->bmodel->select_from_array('family',array('d_member_name'=>''));
        $data['dbdata']=$dbdata;

        $data['mid']=$_POST['member_id'];
        $data['total']=$_POST['total'];
        $data['year']=$_POST['year'];
        $data['month']=$_POST['month'];
        //view
        $this->load->view('bonus/upmember', $data);
    }
    //晉升處理函式
    public function upinfo(){
        $mid=$_POST['mid'];
        $total=$_POST['total'];
        $grand_id=$_POST['grand_id'];
        $year=$_POST['year'];
        $month=$_POST['month'];
       
        //撈取無負責人之體系 
        $dbdata=$this->mymodel->OneSearchSql('family','*',array('d_id'=>$grand_id));
       
        //撈取會員資料
        $mdata=$this->bmodel->select_from('member',array('member_id'=>$mid));
        $member_num=$mdata['member_num'];
        //撈取姓名
        $bdata=$this->mymodel->OneSearchSql('buyer','name',array('by_id'=>$mdata['by_id']));
        $name=$bdata['name'];
        $this->bmodel->update_set('family','d_id',$_POST['grand_id'],array('d_member_name'=>$member_num));
        $this->bmodel->update_set('member','member_id',$mid,array('is_family_boss'=>'Y'));
        $fdata=$this->bmodel->select_from('family',array('d_id'=>$_POST['grand_id']));
        $this->useful->write_log('j_upfamily',"".$_SESSION['AT']['account_name']."授權給".$member_num."擔任".$fdata['d_name']."之負責人");
       
        //LOG寫入資料庫
        $idata=array(
            'member_num'=>$mdata['member_num'],
            'sName'=>$name,
            'old_family'=>$mdata['GID'],
            'new_family'=>$dbdata['d_id'],
            'bonus_per'=>$dbdata['d_pernum'],
            'total_bonus'=>$total,
            'd_year'=>$year,
            'd_month'=>$month,
            'create_time'=>$this->useful->get_now_time(),
        );
        
        $this->mymodel->insert_into('family_log',$idata);
        
        echo "<script>alert('修改成功');window.location.href='/bonus/family_list';</script>";
       
    }

    //體系列表
    public function family_list(){
        //權限判斷
        $this->useful->CheckComp('j_family');

        //資料庫名稱
        $data['dbname']=$dbname='family';

        //分頁程式 start
        $data['ToPage']=$Topage=!empty($_POST['ToPage'])?$_POST['ToPage']:1;
        $qpage=$this->useful->SetPage($dbname,'');        
        $data['page']=$this->useful->get_page($qpage);
        //分頁程式 end  

        $dbdata=$this->mymodel->select_page_form('family',$qpage['result'],'*','','update_time','desc');
        foreach ($dbdata as $key => $value) {
            if($value['d_member_name']!=''){
                $d_name=$this->mmodel->get_member_data('',$value['d_member_name']);
                $dbdata[$key]['d_member_name']=$d_name[0]['bname'];
            }
        }
        $data['dbdata']=$dbdata;
        //view
        $this->load->view('bonus/family_list', $data);
    }
    //體系內頁
    public function family_info($id=''){
        //權限判斷
        $this->useful->CheckComp('j_family');
        
        if($id!='')
            $data['title']='體系總覽';
        else
            $data['title']='新增體系';

        $data['dbname']='family';
        $dbdata=$this->bmodel->select_from('family',array('d_id'=>$id));
        if($dbdata['d_member_name']!=''){
            $d_name=$this->mmodel->get_member_data('',$dbdata['d_member_name']);
            $dbdata['member_name']=$d_name[0]['bname'];
        }
        $data['dbdata']=$dbdata;
        //view
        $this->load->view('bonus/family_info', $data);
    }

    //獎金撥款
    public function report_list(){
        //權限判斷
        $this->useful->CheckComp('j_dlmonth');

        $dbdata=$this->bmodel->get_bonus_date('1');
        foreach ($dbdata as $key => $value) {
            $dbdata[$key]['iMonth']=substr('00'.$value['d_Month'],-2);
        }
        $data['bdate']=$dbdata;
        $data['iYear']= 0;

        //view
        $this->load->view('bonus/report_list', $data);
    }
    public function report_info($date=''){
        //權限判斷
        $this->useful->CheckComp('j_dlmonth');
        $data['date']=$date;
        //view
        $this->load->view('bonus/report_info', $data);
    }
    //獎金撥款下載
    public function edi_download($date='',$type=''){
        //權限判斷
        $this->useful->CheckComp('j_dlmonth');

        // $sQueryMonth=date('Y-m');
        
        // $iSetYear=date('Y');

        $iSetYear=substr($date,0,4);
        $iSetMonth=substr($date,4,2);
        //抓取明天日期
        $today=date("Ymd",strtotime("+1 day"));
        $myfile = fopen("uploads/newfile.txt", "w") or die("Unable to open file!");

        if($type=='big5'||$type=='utf8'){
            

            $sTemp1 = "28872054000015 ".$iSetYear.$today."                                   ";
            $sTemp2 = "5610717273151 006561028872054  龍寶生命禮儀股份有限公司                                                        ";
            $sTemp3 = "";
            $sTemp4 = "";
            $sTemp5 = "EI                                                                       SAL";
            $sTemp6 = "";
            
            // foreach ($ddata as $value) {
                // $itotal=str_pad($value['iTotal'],14,'0',STR_PAD_LEFT);
                // $idlen=strlen(strtoupper($value['sUserID']));
                // $b3len=strlen($value["sBank3"]) * 2;
                // $sTemp6=$sTemp1.$itotal.$sTemp2.$value['sBank5']." ".$value['sBank4'];
                // if($idlen==10){
                //  $sTemp6.=strtoupper($value['sUserID']);
                // }else{
                //  for($i=1;$i<=(10-$idlen);$i++){ 
                //      $sTemp3.=" ";
                //  }
                //  $sTemp6.=strtoupper($value['sUserID']).$sTemp3;
                // }
                // for($i=1;$i<=(115-$b3len);$i++){ 
                //  $sTemp4 .=" ";
                // }
                $temp = $sTemp6.'123'.$sTemp4.$sTemp5."\r\n";

                fwrite($myfile, $temp);
            // }
            if($type=='big5')
                $filename=$iSetYear.'_合庫_EDI_B.txt';
            if($type=='utf8')
                $filename=$iSetYear.'_合庫_EDI_U.txt';
        }
        
        if($type=='post'){
            // $ddata=$this->rmodel->get_edi_data($iSetYear,$iSetMonth,'700');
            $sTemp = "0330081041      22739962".($iSetYear - 1911).$today;
            $sTemp2 = "";
            // foreach ($ddata as $value) {
            //  $itotal=str_pad($value['iTotal'],8,'0',STR_PAD_LEFT);
                $temp =$sTemp."00               "."\r\n";
                fwrite($myfile, $temp);
            // }
            $filename=$iSetYear.'_郵局_EDI.txt';
            $type='utf-8';
        }

        fclose($myfile);

        if(file_exists("uploads/newfile.txt") and is_file("uploads/newfile.txt")){
            header("Content-type: ".filetype("uploads/newfile.txt"));//指定類型
            header("Content-Disposition: attachment; filename='".$filename."'");//指定下載時的檔名
            header('Content-Type: application/octet-stream');
            header("Content-type: text/html; charset=".$type.""); 
            readfile("uploads/newfile.txt");//輸出下載的內容。

         }
    }

    //月報表下載
    public function report_download($date='',$type=''){
    
        // $sQueryMonth=date('Y-m');
        
        // $iSetYear=date('Y');
        $iSetYear=substr($date,0,4);
        $iSetMonth=substr($date,4,2);

        //未稅獎金明細
        if($type=='detail'){    
            $dbdata=$this->mymodel->select_page_form('bonus','','*',array('d_year'=>$iSetYear,'d_month'=>$iSetMonth));
           
            $title_array=array('訂單單號','會員編號','會員名稱','獎金名稱','PV值','獎金','K值','佣金說明','擋佣','擋佣原因','年份','月份');
            if(!empty($dbdata)){
                foreach ($dbdata as $value) {
                    $mnum=$this->mymodel->OneSearchSql('member','member_num',array('member_id'=>$value['MID']));
                    $d_content=str_replace (" ","\r\n",trim($value['d_content']));
                    $d_bcontent=str_replace (" ","\r\n",trim($value['d_bcontent']));
                    $d_block=($value['d_block']=="Y")?'是':'否';
                    
                    $data_array[]=array($value['OID'],$mnum['member_num'],$value['sName'],$value['d_type'],$value['d_pv'],round($value['d_bonus']),$value['d_kv'],$d_content,$d_block,$d_bcontent,$value['d_year'],$value['d_month']);
                }        
            }else
                $data_array[]=array('本月無資料');
            $xls_name='未稅獎金明細';
        }
        //全部獎金統計
        if($type=='total'){ 
            $dbdata=$this->mymodel->select_page_form('bonus_pay','','*',array('d_year'=>$iSetYear,'d_month'=>$iSetMonth));

            $title_array=array('會員代碼','會員名稱','身份證','一代獎金','二代獎金','體系獎金','其它','扣款','原佣總計','所得稅','2代健保','總計','銀行名稱','帳號','年份','月份');
            if(!empty($dbdata)){                                                                                                                                                                                           
                foreach ($dbdata as $value) {
                    $mdata=$this->mymodel->OneSearchSql('member','bank_name,bank_account,member_num,identity_num',array('member_id'=>$value['MID']));    
                  
                    $data_array[]=array($mdata['member_num'],$value['sName'],$mdata['identity_num'],$value['bonus01'],$value['bonus02'],$value['bonus03'],$value['bonus04'],$value['bonus05'],$value['iOTotal'],$value['itax'],$value['i2nhi'],$value['iTotal'],$mdata['bank_name'],$mdata['bank_account'],$value['d_year'],$value['d_month']);
                }        
            }else
                $data_array[]=array('本月無資料');
            $xls_name='全部獎金統計';
        }
        //晉昇名單
        if($type=='grade'){ 
            $dbdata=$this->mymodel->select_page_form('family_log','','*',array('d_year'=>$iSetYear,'d_month'=>$iSetMonth));
            $title_array=array('會員代碼','會員名稱','原體系','新體系','獎金%數','營業額','年份','月份','建檔日期');
            if(!empty($dbdata)){
                foreach ($dbdata as $value) {
                    $odata=$this->mymodel->OneSearchSql('family','d_name',array('d_id'=>$value['old_family']));
                    $ndata=$this->mymodel->OneSearchSql('family','d_name',array('d_id'=>$value['new_family']));
                    $data_array[]=array($value['member_num'],$value['sName'],$odata['d_name'],$ndata['d_name'],$value['bonus_per'],$value['total_bonus'],$value['d_year'],$value['d_month'],substr($value['create_time'],0,10));
                }        
            }else
                $data_array[]=array('本月無資料');
            $xls_name='晉升名單';
        }
        //本期損益
        if($type=='sell'){  
            $dbdata=$this->bmodel->get_product_data();
            
            $iDayStart=$iSetYear.'-'.$iSetMonth.'-01';

            $iDayEnd=$this->useful->getCurMonthLastDay($iDayStart);
            

            $title_array=array('銷售日期','產品分類','產品名稱','產品金額','產品PV','總銷售PV','總銷售數量','總營業額');
            if(!empty($dbdata)){                       
                foreach ($dbdata as $value) {
                     $total=$this->bmodel->get_amount_total($value['prd_id'],$iDayStart,$iDayEnd);
                     $iPV=0;
                     $iTotalAmount=0;
                     $iPrice=0;
                     $iCost=0;
                     if(!empty($total)){
                         if(trim($total['iTotalAmount'])!=""){
                             $iPV=$total['iTotalAmount']*$value['prd_pv'];
                             $iTotalAmount=$total['iTotalAmount'];
                             $iPrice=$total['iTotalAmount']*$value['prd_price01'];
                         }
                     }
                     $data_array[]=array($iDayStart.'~'.$iDayEnd,$value['prd_cname'],$value['prd_name'],$value['prd_price00'],$value['prd_pv'],$iPV,$iTotalAmount,$iPrice);
                }  
            }else
                $data_array[]=array('本月無資料');      
            $xls_name='本期產品銷售報表';
        }
            $this->export_xls($title_array,$data_array,$iSetYear.$iSetMonth.$xls_name);
    }

    // 獎金試算
    public function trypay(){
        //權限判斷
        $this->useful->CheckComp('j_trypay');

        //撈取獎金計算最後個月
        $last_month=$this->bmodel->get_bonus_date();

        $month=strtotime('now -1 month',time());
        $year=$last_month['d_Year'].'-'.substr('00'.$last_month['d_Month'],-2);
        

        // if($year!=date('Y-m',$month)){    // 最後一筆不等於這個月
            $chmonth=explode('-',date('Y-m',strtotime('now +1 month',strtotime($year.'-01'))));
            $last_month['d_Year']=$chmonth[0];
            $last_month['d_Month']=$chmonth[1];
            $data['data']=$last_month;
        // }

        //view
        $this->load->view('bonus/trypay', $data);
    }
    // 下載獎金試算EXCEL
    public function bonus_total_try(){
        //權限判斷
        $this->useful->CheckComp('j_trypay');

        $date=$_POST['year'].'-'.substr('00'.$_POST['month'],-2);

        $new_data=$this->bmodel->get_order_data($date,1);
        // print_r($new_data);exit; 
      
        // $new_data=$this->bmodel->get_order_data($date,1);

        //有值才動作
        $down=array();
        if(!empty($new_data)){
            //撈取獎金計算值(一代)
            $oneline=$this->mymodel->GetConfig("",'1');
            //撈取獎金計算值(二代)
            $twoline=$this->mymodel->GetConfig("",'2');
            //撈取獎金計算值(KV值)
            $kv=$this->mymodel->GetConfig("",'3');
            

           
            foreach ($new_data as $nvalue) {
                $orderstr='';
                if($nvalue['member_id']!=0){
                    //一代獎金
                    $bdata=$this->bmodel->get_buyer_data($nvalue['by_id']);
                    $mdata=$this->bmodel->get_member_data($nvalue['member_id']);
                       
                    $odata=$this->mymodel->select_page_form('order_details','','prd_name',array('order_id'=>$nvalue['order_id']));
                    foreach ($odata as $okey => $ovalue) {
                        $orderstr.=$ovalue['prd_name'].',';
                    }
                    $orderstr=$this->useful->del_string_last($orderstr);
          
                    $pv=$nvalue['total_pv']*($oneline['d_val']/100);
                    $down[]=array(
                        'OID'=>$nvalue['order_id'],
                        'd_pv'=>$pv,
                        'd_kv'=>$kv['d_val'],
                        'd_bonus'=>$pv*$kv['d_val'],
                        'MID'=>$nvalue['member_id'],
                        'sName'=>$mdata[0]['name'],
                        'd_type_id'=>1,
                        'd_type'=>'一代獎金',
                        'd_content'=>'來自推薦訂單號碼['.$nvalue['order_id'].'] - 姓名：'.$bdata['name'].' - 商品：'. $orderstr.' ',
                        'member_num'=>$mdata[0]['member_num']
                    );

                    
                  
                    //一代獎金
                    //二代獎金
                    $two=$this->bmodel->get_up_data($nvalue['member_id']);

                    if($two[0]['upline']!=0){
                        $twoid=$two[0]['upline'];
                        if($twoid!=0){
                            $mdata=$this->bmodel->get_member_data($twoid);
                            // print_r($mdata);

                            $pv=$nvalue['total_pv']*($twoline['d_val']/100);
                            $down[]=array(
                                'OID'=>$nvalue['order_id'],
                                'd_kv'=>$kv['d_val'],
                                'd_pv'=>$pv,
                                'd_bonus'=>$pv*$kv['d_val'],
                                'MID'=>$twoid,
                                'sName'=>$mdata[0]['name'],
                                'd_type'=>'二代獎金',
                                'd_content'=>'來自推薦訂單號碼['.$nvalue['order_id'].'] - 姓名：'.$bdata['name'].' - 商品：'. $orderstr.' ',
                                'member_num'=>$mdata[0]['member_num']
                            );

                        }
                    }
                    //二代獎金
                }
            }

            //體系獎金
            foreach ($new_data as $fvalue) {
                $orderstr='';
                if($fvalue['member_id']!=0){
                    $gid=$this->bmodel->get_up_data($fvalue['member_id']);  
                    $gid=$gid[0]['GID'];

                    if($gid!=0){
                        $gdata=$this->bmodel->get_family_data($gid);
                        $gmid=$gdata['MID'];
                        $gper=$gdata['d_pernum'];
                        $mdata=$this->bmodel->get_member_data($gmid);

                        //是否已有寫入
                        $bdata=$this->bmodel->get_buyer_data($fvalue['by_id']);

                        
                        $odata=$this->mymodel->select_page_form('order_details','','prd_name',array('order_id'=>$fvalue['order_id']));
                        foreach ($odata as $okey => $ovalue) {
                            $orderstr.=$ovalue['prd_name'].',';
                        }
                        $orderstr=$this->useful->del_string_last($orderstr);

                        $pv=$fvalue['total_pv']*($gper/100);

                        $down[]=array(
                            'OID'=>$fvalue['order_id'],
                            'd_kv'=>$kv['d_val'],
                            'd_pv'=>$pv,
                            'd_bonus'=>$pv*$kv['d_val'],
                            'MID'=>$gmid,
                            'sName'=>$mdata[0]['name'],
                            'd_type'=>'體系獎金',
                            'd_content'=>'來自推薦訂單號碼['.$fvalue['order_id'].'] - 姓名：'.$bdata['name'].' - 商品：'. $orderstr.' ',
                            'member_num'=>$mdata[0]['member_num']
                        );

                    }
                }
            }

        }else{
            echo '<script>if(confirm("此月無訂單，確定結算?"))window.location.href="/bonus/WriteMonth/'.$_POST['year'].'/'.$_POST['month'].'";</script>';     
        }
        
         
        //未稅獎金明細
        $title_array=array('訂單單號','會員編號','會員名稱','獎金名稱','PV值','獎金','K值','佣金說明','年份','月份');
        $data_array=array();
        foreach ($down as $key => $value) {
            $d_content=str_replace (" ","\r\n",trim($value['d_content']));
            $data_array[]=array($value['OID'],$value['member_num'],$value['sName'],$value['d_type'],round($value['d_pv'],2),round($value['d_bonus'],2),$value['d_kv'],$d_content,$_POST['year'],substr('00'.$_POST['month'],-2));
        }
     
        $xls_name='未稅獎金明細(試算)';
        
        $this->export_xls($title_array,$data_array,$_POST['year'].substr('00'.$_POST['month'],-2).$xls_name);
    }

    //  紅利發送記錄
    public function sendbonus_list(){
         //權限判斷
        $this->useful->CheckComp('j_sendbonus');

        //資料庫名稱
        $data['dbname']=$dbname='dividend_log';

        //分頁程式 start
        $data['ToPage']=$Topage=!empty($_POST['ToPage'])?$_POST['ToPage']:1;
        $qpage=$this->useful->SetPage($dbname,'');        
        $data['page']=$this->useful->get_page($qpage);
        //分頁程式 end  

        // $dbdata=$this->mymodel->select_page_form('dividend_log',$qpage['result'],'*','');
        $dbdata=$this->mymodel->WriteSQL('
            select b.d_account,if(d_type=1,"新增紅利","扣除紅利") as d_type,d.d_bonus,m.account,d.create_time,b.name,d.d_content from dividend_log d
            inner join buyer b on b.by_id=d.BID
            inner join member m on m.member_id =d.EID order by create_time desc
            '.$qpage['result'].' ');
        $data['dbdata']=$dbdata;

        //view
        $this->load->view('bonus/sendbonus_list', $data);
    }
    // data_AED編輯
    public function sendbonus(){
         //權限判斷
        $this->useful->CheckComp('j_sendbonus');
        //view
        $this->load->view('bonus/sendbonus', $data);
    }
    //--AJAX 開啟關閉資料專用
    public function oc_data(){
        $DB=$this->input->post('DB');       //資料表
        $field=$this->input->post('field'); //欄位名稱
        $id=$this->input->post('id');       //修改ID 需有分號區隔
        $oc=$this->input->post('oc');       //Open Close Value

        $id_val=explode(';',$id);

        foreach ($id_val as $value) {
            $this->mymodel->update_set($DB,$field,$value,array('d_is_open'=>$oc));
        }
        echo '修改成功';
    }
    //--AJAX 開啟關閉資料專用

    //資料增刪修
    public function data_AED($DB='',$del_id=''){
        $this->load->library('/mylib/CheckInput');
        $check=new CheckInput;


            
        if($del_id!=''){
            $dbname=$DB;
            $this->bmodel->delete_where($DB,array('d_id'=>$del_id));
            $msg='刪除成功';
        }else{
            $id=$_POST['d_id'];
            $dbname=$_POST['dbname'];

            if($dbname=='family'){

                $check->fname[]=array('_String',Comment::SetValue('d_code'),'體系代碼');
                $check->fname[]=array('_String',Comment::SetValue('d_name'),'體系名稱');
                $check->fname[]=array('_String',Comment::SetValue('d_pernum'),'體系趴數');
				
				
				if(Comment::SetValue('d_member_name') != ''){
					$member_data=$this->mmodel->select_from('member',array('member_num'=>Comment::SetValue('d_member_name')));
					if(empty($member_data)){
						$this->useful->AlertPage('','該會員不存在，請重新');
						return '';
					}
				}
				
                $dbdata=$this->mmodel->select_from('family',array('d_member_name'=>Comment::SetValue('d_member_name')));
				
				if(!empty($dbdata) and Comment::SetValue('d_member_name')!=''){
                    echo '<script>alert("該會員已是體系負責人");history.go(-1);</script>';
                    return '';
                }

				if(Comment::SetValue('d_code') != ''){
					$cdata=$this->bmodel->check_family($id,Comment::SetValue('d_code'),'');				   
					if(!empty($cdata)){
						echo '<script>alert("體系代碼重覆");history.go(-1);</script>';
						return '';
					}
				}
				
				if(Comment::SetValue('d_name') != ''){
					$ndata=$this->bmodel->check_family($id,'',Comment::SetValue('d_name'));
					if(!empty($ndata)){
						echo '<script>alert("體系名稱重覆");history.go(-1);</script>';
						return '';
					}
				}
				
                if($_POST['d_member_name']=='')
                    $_POST['d_member_name']=$_POST['old_num'];
                

                $d_name=$this->mmodel->get_member_data('',$_POST['old_num']);
                $this->bmodel->update_set('member','by_id',$d_name[0]['by_id'],array('is_family_boss'=>'N'));
                $this->bmodel->update_set('member','member_num',$_POST['d_member_name'],array('is_family_boss'=>'Y','GID'=>$_POST['d_id']));

                unset($_POST['old_num']);
            }

            if($dbname=='invoice'){
				$check->fname[]=array('_String',Comment::SetValue('d_code'),'發票編碼');
				$check->fname[]=array('_String',Comment::SetValue('d_start'),'發票起始號碼');
				$check->fname[]=array('_String',Comment::SetValue('d_end'),'發票結束號碼');
                $data=$this->useful->DB_Array($_POST,1);
                $data['d_now_num']=$_POST['d_start'];
            }else{
                if($id){
                    $data=$this->useful->DB_Array($_POST);
                }else{
                    $data=$this->useful->DB_Array($_POST,1);
                }
            }

            if($dbname=='family'){
                $d_id=$this->mmodel->get_member_data('',$data['d_member_name']);
                $data['MID']=$d_id[0]['member_id'];
    
            }

            // 紅利LOG
            if($dbname=='dividend_log'){
                $check->fname[]=array('_String',Comment::SetValue('BID'),'會員帳號');
                $check->fname[]=array('_String',Comment::SetValue('d_type'),'項目類型');
                $check->fname[]=array('_String',Comment::SetValue('d_bonus'),'點數');
            }

            if(!empty($check->main())){
                echo $check->main();
                return '';
            }

            unset($data['dbname']);
            unset($data['d_id']);
            
            // 紅利LOG
            if($dbname=='dividend_log'){
                @session_start();
           
                $mdata=$this->mymodel->OneSearchSql('buyer','by_id,d_dividend',array('d_account'=>Comment::SetValue('BID')));
                if(!empty($mdata)){
                    $d_dividend=($_POST['d_type']==1)?($mdata['d_dividend']+Comment::SetValue('d_bonus')):($mdata['d_dividend']-Comment::SetValue('d_bonus'));
                    if($d_dividend>=0){
                        
                        // 寫入LOG
                        $logdata=array(
                            'BID'=>$mdata['by_id'],
                            'EID'=>$_SESSION['AT']['account_id'],
                            'd_type'=>$_POST['d_type'],
                            'd_bonus'=>Comment::SetValue('d_bonus'),
                            'd_content'=>Comment::SetValue('d_content'),
                            'create_time'=>$this->useful->get_now_time(),
                            'update_time'=>$this->useful->get_now_time(),
                        );

                        $this->mymodel->insert_into($dbname,$logdata);
                        // 寫入會員紅利
                        $didata=array(
                            'buyer_id'=>$mdata['by_id'],
                            'd_type'=>($_POST['d_type']==1)?'19':'75',
                            'd_val'=>Comment::SetValue('d_bonus'),
                            'd_des'=>Comment::SetValue('d_content'),
                            'is_send'=>'Y',
                            'create_time'=>$this->useful->get_now_time(),
                            'update_time'=>$this->useful->get_now_time(),
                            'send_dt'=>$this->useful->get_now_time(),
                        );

                        $this->mymodel->insert_into('dividend',$didata);
                        $this->mymodel->update_set('buyer','by_id',$mdata['by_id'],array('d_dividend'=>$d_dividend));

                        echo '<script>alert("編輯成功");window.location.href="/bonus/sendbonus";</script>';
                        return '';
                    }else{
                        echo '<script>alert("此會員點數不得扣除低於零，無法操作");history.go(-1);</script>';
                        return '';
                    }
                }else{
                    echo '<script>alert("查無此會員");history.go(-1);</script>';
                    return '';
                }
            }
            if($id){
                $this->bmodel->update_set($dbname,'d_id',$id,$data);
                $msg='修改成功';
            }else{
                
                $create_id=$this->bmodel->insert_into($dbname,$data);
                if($dbname=='family'){
                    $this->bmodel->update_set('member','member_num',$data['d_member_name'],array('is_family_boss'=>'Y','GID'=>$create_id));
                }
                if($create_id)
                    $msg='新增成功';
                else
                    $msg='新增失敗';
            }
        }
        echo '<script>alert("'.$msg.'");window.location.href="/bonus/'.$dbname.'_list";</script>';
    }

    // 搜尋一般會員帳號
    public function GetBuyer(){
        $name1=$_POST['keyword'];
        $member_data=$this->mmodel->get_member_data('','','','','','','',$name1);
        foreach ($member_data as $key => $value) {
            echo "<li>"."[".$value['d_account']."]".$value['name']."(目前紅利:".$value['d_dividend'].")</li>";
        }
    }
}
