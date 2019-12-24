                <form action="/gold/member_password" class="j-forms" method="post" onsubmit="return check_form(this)")>
				<section class="content has-side">
					<div class="title">修改密碼</div>
					<div class="editor mg">
					<div class="form-box">
							<div class="form-group">
	                            <div class="control-box">
	                            	<i class="icon-id"></i>
	                            	<label class="control-label">舊密碼</label>
	                                <input class="form-control" type="password" placeholder="　<?=$this->lang['ioldpw'];//請輸入舊密碼?>" name="old_pw" required>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <div class="control-box">
	                            	<i class="icon-lock"></i>
	                            	<label class="control-label">新密碼</label>
	                                <input class="form-control" type="password" placeholder="　<?=$this->lang['inewpwd'];//請輸入新密碼?>" name="new_pw" required>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <div class="control-box">
	                            <i class="icon-name"></i>
	                            	<label class="control-label">再次輸入新密碼</label>
	                                <input class="form-control" type="password" placeholder="　　　　　　<?=$this->lang['rnewpwd'];//再次輸入新密碼?>" name="re_new_pw" required>
	                            </div>
	                        </div>
	                        
	                        <div class="pagination_box">
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
function check_form(frm)
{
    if(frm.elements['old_pw'].value==''){
        alert("<?=$this->lang['ioldpw']?>");  //請輸入舊密碼
        frm.elements['old_pw'].focus();
        return false;   
    }else if((frm.elements['old_pw'].value).length<5){
        alert("<?=$this->lang['fiveold']?>");  //舊密碼至少五位數
        frm.elements['old_pw'].focus();
        return false;   
    }
    else if(frm.elements['new_pw'].value==''){
        alert("<?=$this->lang['inewpwd']?>");  //請輸入新密碼
        frm.elements['new_pw'].focus();
        return false;   
    }else if((frm.elements['new_pw'].value).length<5){
        alert("<?=$this->lang['fivenew']?>");  //新密碼至少五位數
        frm.elements['new_pw'].focus();
        return false;   
    }
    else if(frm.elements['re_new_pw'].value==''){
        alert("<?=$this->lang['irpwd']?>");   //請輸入再次密碼
        frm.elements['re_new_pw'].focus();
        return false;   
    }
    else
        return true;    
}
</script>