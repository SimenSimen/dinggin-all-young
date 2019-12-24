<script src="/js/myjava/region.js"></script>
		<main class="main-content wow fadeInUp" data-wow-delay="0.4s">
			<div class="container center">
                <form action="/gold/data_AED" class="j-forms" method="post" onsubmit="return check_form(this)")>
            	<input type="hidden" name="PID" value="<?=$upline_by_id?>">
				<section class="content">
					<div class="title"><?=$this->lang['regidter'];//註冊會員?></div>
					<div class="editor mg">
					<div class="form-box">
							<div class="form-group w130">
	                            <div class="control-box">
	                            	<i class="icon-id"></i>
	                            	<label class="control-label"><span>*</span><?=$this->lang['account'];//帳號?></label>
	                                <input class="form-control" type="text" name="d_account" placeholder="<?=$this->lang['plsacc'];//請輸入帳號?>" value="<?=$_SESSION['RT']['d_account']?>">
	                            </div>
	                        </div>
	                        <div class="form-group w130">
	                            <div class="control-box">
	                            	<i class="icon-lock"></i>
	                            	<label class="control-label"><span>*</span><?=$this->lang['password'];//密碼?></label>
	                                <input class="form-control" type="password" name="by_pw" placeholder="<?=$this->lang['worderror'];//文字長度不超過16字元?>">
	                            </div>
	                        </div>
	                        <div class="form-group w130">
	                            <div class="control-box">
	                            <i class="icon-name"></i>
	                            	<label class="control-label"><span>*</span><?=$this->lang['dname'];//姓名?></label>
	                                <input class="form-control" type="text" name="name" placeholder="<?=$this->lang['plsname'];//請輸入姓名?>" value="<?=$_SESSION['RT']['name']?>">
	                            </div>
	                        </div>
	                        <div class="form-group name">
	                        	<i class="icon-genders"></i> <label class="control-label"><span>*</span><?=$this->lang['sex'];//性別?></label>
                                <div class="control-box">
                                    <div class="radio-box">
                                        <label class="form-radio"><input type="radio" name="sex" value="male" <?if($_SESSION['RT']['sex']=="male") echo"checked";?>> <?=$this->lang['male'];//先生?></label>
                                        <label class="form-radio"><input type="radio" name="sex" value="female" <?if($_SESSION['RT']['sex']=="female") echo"checked";?>> <?=$this->lang['female'];//小姐?></label>
                                    </div>
                                </div>
                            </div>
	                        <div class="form-group w130">
	                            <div class="control-box">
	                            <i class="icon-nickname"></i>
	                            	<label class="control-label"><?=$this->lang['nickname'];//暱稱?></label>
	                                <input class="form-control" type="text" name="nickname" id="nickname" placeholder="<?=$this->lang['upto10'];//最多十個字?>" maxlength="10" value="<?=$_SESSION['RT']['nickname']?>">
	                            </div>
	                        </div>
	                        <div class="form-group w130">
	                            <div class="control-box">
	                            <i class="icon-phone"></i>
	                            <label class="control-label">*<?=$this->lang['mobile'];//手機?></label>
	                                <input class="form-control" type="text" maxlength="11" name="mobile" placeholder="<?=$this->lang['plsmobile'];//請輸入正確的聯絡電話?>" onKeyUp="value=value.replace(/[^\d]/g,'')" value="<?=$_SESSION['RT']['mobile']?>">
	                            </div>
	                        </div>
	                        <div class="form-group w130">
	                            <div class="control-box">
	                            <i class="icon-phone-call"></i>
	                            <label class="control-label"><?=$this->lang['phone'];//電話?></label>
	                                <input class="form-control" type="text" maxlength="11" placeholder="<?=$this->lang['plsphone'];//請輸入正確的聯絡電話?>" name="telphone" onKeyUp="value=value.replace(/[^\d]/g,'')" value="<?=$_SESSION['RT']['telphone']?>">
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <div class="control-box">
	                            <i class="icon-placeholder"></i>
		                            <select name="country" id="country" onChange="sel_area(this.value,'','city')" class="form-control">
		                                <option value=""><?=$this->lang['country'];//請選擇地區?></option>
		                                <?foreach ($country as $cvalue):?>
		                                    <option value="<?=$cvalue['s_id']?>" <?=($_SESSION['RT']['country']==$cvalue['s_id'])?'selected':'';?>><?=$cvalue['s_name']?></option>  
		                                <? endforeach;?>
		                            </select>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <div class="control-box">
	                            <i class="icon-placeholder"></i>
		                            <select name="city" id="city" onChange="sel_area(this.value,'','countory')" class="form-control">
		                                <option value=""><?=$this->lang['city'];//請選擇省份城市?></option>
		                            </select>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <div class="control-box">
	                            <i class="icon-placeholder"></i>
                            		<select name="countory" id="countory" class="form-control">
                                		<option value=""><?=$this->lang['county'];//請選擇地級市鄉鎮地區?></option>
                            		</select><i></i></label>
	                            </div>
	                        </div>
	                        <div class="form-group w110">
	                            <div class="control-box">
	                            <i class="icon-placeholder"></i>
	                            	<label class="control-label"><?=$this->lang['address'];//地址?></label>
	                                <input class="form-control" type="text" placeholder="<?=$this->lang['plsaddress'];//請填寫正確地址?>" name="address" value="<?=$_SESSION['RT']['address']?>">
	                            </div>
	                        </div>
	                        <div class="form-group w110">
	                            <div class="control-box">
	                            <i class="icon-cake"></i>
	                            	<label class="control-label"><?=$this->lang['brithday'];//生日?></label>
	        						<input class="form-control bar_content date-object birthday" type="text" name="birthday" id="d_birthday" value="<?=$_SESSION['RT']['birthday']?>"> 
	                            </div>
	                        </div>
				            <div class="form-group w110">
								<div class="control-box">
								<i class="icon-cake"></i>
				                	<label class="control-label">*Email</label>
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
                			<input type="hidden" name="member_register" value="yes">
                			<input type="reset" class="btn simple" value="<?=$this->lang['s_restart'];//重填?>">
                			<input type="submit"  class="btn simple bg2" value="<?=$this->lang['s_send'];//送出?>">
                            </div>


					</div>
					</div>
				</section>
				</form>
			</div>
		</main>
<style>
.j-forms{
  width: 100%;
}
.form-box .form-control{
  padding: 5px 10px 5px 90px;
  background: #e7e7e7;
  color: #666;
}
</style>
<script>
<? if($_SESSION['RT']['country']!=''):?>
    sel_area(<?=$_SESSION['RT']['country']?>,<?=$_SESSION['RT']['city']?>,'city');
<? endif;?>
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
    }else if((frm.elements['nickname'].value).length>10){
        alert("<?=$this->lang['upto10'];//暱稱最多十個字?>");
        frm.elements['nickname'].focus();
        return false;   
    }else if(frm.elements['name'].value==''){
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
<link href="/js/admin_sys/jquery-ui_1_11_2/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="/js/admin_sys/jquery-ui_1_11_2/jquery-ui.js"></script>
<script src="/js/admin_sys/jquery-ui_1_11_2/lang/datepicker-zh-TW.js"></script>
<script>
  $(".date-object").datepicker({dateFormat: "yy-mm-dd",yearRange :"c-100:c+0",maxDate : "+0d"});//生日時間"年"份軸
</script>
