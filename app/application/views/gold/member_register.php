		<script src="/js/myjava/region.js"></script>
<script src="/js/jquery.1.11.1.min.js"></script>
<link href="/css/reset.css" rel="stylesheet">
<link href="/css/drawer.css" rel="stylesheet">
<link href="/css/style.css" rel="stylesheet">
<!-- -->
<link rel="stylesheet" type="text/css" href="/css/input-style.css">
<link rel="stylesheet" href="/css/form.css">
<!-- 時間格式 -->
<link href="/js/admin_sys/jquery-ui_1_11_2/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
		<main class="main-content wow fadeInUp" data-wow-delay="0.4s">
			<div class="container">
				<aside class="side">
				<ul class="side-nav list-v">
					<li class="active"><a href="products.php">進入商城</a></li>
					<li><a href="member_wishlist.php">最愛商品</a></li>
					<li><a href="order.php">個人訂單查詢</a></li>
					<li><a href="member_dividend.php">紅利點數查詢</a></li>
					<li><a href="member_info.php">基本資料</a></li>
					<li><a href="member_address.php">常用寄貨地址</a></li>
					<li><a href="member_announcement.php">會員權益公告</a></li>
					<li><a href="invite_share.php">邀請碼分享</a></li>
					<!--<li><a href="member_active.php">活躍指標</a></li>-->
					<li><a href="member_upgrade.php">升級經營會員</a></li>
					<li><a href="member_order.php">經營會員銷售訂單查詢</a></li>
					<li><a href="organization.php">組織表</a></li>
					<li><a href="invoice.php">我要請款</a></li>
					<li><a href="member_bonus.php">佣金查詢</a></li>
					<li><a href="member_dividend_fun.php">購物金查詢</a></li>
					<li><a href="member_leader_announcement.php">經營會員權益公告</a></li>
				</ul>
                </aside>
                <form action="/gold/data_AED" class="j-forms" method="post" onsubmit="return check_form(this)")>
				<section class="content has-side">
					<div class="title"><?=$this->lang['regidter'];//註冊會員?></div>
					<div class="editor mg">
					<div class="form-box">
							<div class="form-group">
	                            <div class="control-box">
	                            	<i class="icon-id"></i>
	                            	<label class="control-label"><span>*</span><?=$this->lang['account'];//帳號?></label>
	                                <input class="form-control" type="text" name="d_account" placeholder="" value="<?=$_SESSION['RT']['d_account']?>" required>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <div class="control-box">
	                            	<i class="icon-lock"></i>
	                            	<label class="control-label"><span>*</span><?=$this->lang['password'];//密碼?></label>
	                                <input class="form-control" type="password" name="by_pw" placeholder="<?=$this->lang['worderror'];//文字長度不超過16字元?>" required>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <div class="control-box">
	                            <i class="icon-name"></i>
	                            	<label class="control-label"><span>*</span><?=$this->lang['dname'];//姓名?></label>
	                                <input class="form-control" type="text" name="name" placeholder="<?=$this->lang['plsname'];//請輸入姓名?>" value="<?=$_SESSION['RT']['name']?>" required>
	                            </div>
	                        </div>
	                        <div class="form-group name">
	                        	<i class="icon-genders"></i> <label class="control-label"><span>*</span><?=$this->lang['sex'];//性別?></label>
                                <div class="control-box">
                                    <div class="radio-box">
                                        <label class="form-radio"><input type="radio" name="sex" value="male" checked> <?=$this->lang['male'];//先生?></label>
                                        <label class="form-radio"><input type="radio" name="sex" value="female"> <?=$this->lang['female'];//小姐?></label>
                                    </div>
                                </div>
                            </div>
	                        <div class="form-group w170">
	                            <div class="control-box">
	                            <i class="icon-nickname"></i>
	                            	<label class="control-label">暱稱(最多十個字)</label>
	                                <input class="form-control" type="text" name="" id="" placeholder="">
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <div class="control-box">
	                            <i class="icon-phone"></i>
	                            <label class="control-label">手機</label>
	                                <input class="form-control" type="text" maxlength="10" name="mobile" placeholder="<?=$this->lang['plsmobile'];//請輸入正確的聯絡電話?>" onKeyUp="value=value.replace(/[^\d]/g,'')">
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <div class="control-box">
	                            <i class="icon-phone-call"></i>
	                            <label class="control-label"><?=$this->lang['phone'];//電話?></label>
	                                <input class="form-control" type="text" maxlength="10" placeholder="<?=$this->lang['plsphone'];//請輸入正確的聯絡電話?>" name="telphone" onKeyUp="value=value.replace(/[^\d]/g,'')" value="<?=$_SESSION['RT']['telphone']?>">
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <div class="control-box">
	                            <i class="icon-placeholder"></i>
		                            <select name="city" onChange="sel_area(this.value,'','countory')" required class="form-control">
		                                <option value="0">請選擇城市</option>
		                                <?foreach ($city as $cvalue):?>
		                                    <option value="<?=$cvalue['s_id']?>" <?=($_SESSION['RT']['city']==$cvalue['s_id'])?'selected':'';?>><?=$cvalue['s_name']?></option>  
		                                <? endforeach;?>
		                            </select>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <div class="control-box">
	                            <i class="icon-placeholder"></i>
                            		<select name="countory" id="countory" class="form-control" required>
                                		<option value="0">請選擇鄉鎮地區</option>
                            		</select><i></i></label>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <div class="control-box">
	                            <i class="icon-placeholder"></i>
	                            	<label class="control-label">地址</label>
	                                <input class="form-control" type="text" placeholder="<?=$this->lang['plsaddress'];//請填寫正確地址?>" name="address" required value="<?=$_SESSION['RT']['address']?>">
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <div class="control-box">
	                            <i class="icon-cake"></i>
	                            	<label class="control-label"><?=$this->lang['brithday'];//生日?></label>
	        						<input class="form-control bar_content date-object birthday" type="text" name="birthday" id="d_birthday" required value=""> 
	                            </div>
	                        </div>
				            <div class="form-group">
								<div class="control-box">
								<i class="icon-cake"></i>
				                	<label class="control-label">Email</label>
				                    <input class="form-control" type="text" placeholder="<?=$this->lang['plsmail'];//請輸入個人信箱?>" name="by_email" value="<?=$_SESSION['RT']['by_email']?>">
				            </div>
	                        <div class="form-group checbox">
		    					<input type="checkbox" name="chk_ok" value="ok">
	  							<label for="checkbox"><?=$this->lang['iread'];//我已詳閱?>
                        		<a href="/gold/policies/service" class="link" target="_blank"><?=$this->lang['msevice'];//會員服務條款?></a> <?=$this->lang['and'];//和?> 
                        		<a href="/gold/policies/privacy" class="link" target="_blank"><?=$this->lang['privacy'];//隱私權政策?></a>
  							 </div>
	                        
	                        <div class="pagination_box">
                			<input type="hidden" name="dbname" value="<?=$dbname?>">
                			<input type="reset" class="btn simple" value="<?=$this->lang['s_restart'];//重填?>">
                			<input type="submit"  class="btn simple bg2" value="<?=$this->lang['s_send'];//送出?>">
                            </div>


					</div>
					</div>
				</section>
				</form>
			</div>
		</main>
<script>
<? if($_SESSION['RT']['city']!=''):?>
    sel_area(<?=$_SESSION['RT']['city']?>,<?=$_SESSION['RT']['countory']?>,'countory');
<? endif;?>
function check_form(frm)
{

    if(frm.elements['d_account'].value==''){
        alert("<?=$this->lang['plsacc'];//請輸入帳號?>");
        frm.elements['d_account'].focus();
        return false;   
    }
    else if(frm.elements['by_pw'].value==''){
        alert("<?=$this->lang['plspwd'];//請輸入密碼?>");
        frm.elements['by_pw'].focus();
        return false;   
    }else if((frm.elements['by_pw'].value).length<5){
        alert("<?=$this->lang['pwdfive'];//密碼至少五位數?>");
        frm.elements['by_pw'].focus();
        return false;   
    }
    else if(frm.elements['name'].value==''){
        alert("<?=$this->lang['plsname'];//請輸入姓名?>");
        frm.elements['name'].focus();
        return false;   
    }else if(frm.elements['by_email'].value==''){
        alert("<?=$this->lang['plsmail'];//請輸入信箱?>");
        frm.elements['by_email'].focus();
        return false;   
    }else if($("input[name=chk_ok]:checked").val()!='ok'){
        alert("<?=$this->lang['plsview'];//請勾選已詳閱條款和政策?>");
        frm.elements['chk_ok'].focus();
        return false;   
    }
    else
        return true;    
}
</script>
<script src="/js/admin_sys/jquery-ui_1_11_2/jquery-ui.js"></script>
<script src="/js/admin_sys/jquery-ui_1_11_2/lang/datepicker-zh-TW.js"></script>
<script>
  $(".date-object").datepicker({dateFormat: "yy-mm-dd",yearRange :"c-100:c+100"});//生日時間"年"份軸
</script>
