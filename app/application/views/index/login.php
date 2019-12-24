		
			<div class="container center">
                <form action="/gold/login_set" class="j-forms" method="post" onSubmit="return check_form(this)">
				<section class="content">
					<div class="title"><?=$this->lang['login'];//會員登入?></div>
					
					<div class="editor mg">
					<div class="form-box">
							<div class="form-group">
	                            <div class="control-box">
	                            	<i class="icon-id"></i>
	                            	<label class="control-label"><?=$this->lang['account'];//帳號?></label>
	                                <input class="form-control" type="text" onkeyup="value=value.replace(/[\W]/g,'') "  placeholder="" name="d_account" value="<?=$account?>">
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <div class="control-box">
	                            <i class="icon-lock"></i>
	                            <label class="control-label"><?=$this->lang['password'];//密碼?></label>
	                                <input class="form-control" type="password" onkeyup="value=value.replace(/[\W]/g,'') " placeholder="<?=$this->lang['worderror'];//文字長度不超過16字元?>" name="password" value="<?=$password?>" maxlength="16">
	                            </div>
	                        </div>
	                        <div class="form-group checbox">
	                    		<input type="checkbox" name="remember" value="1" <?=(empty($remember))?'':'checked';?> id="checkbox"></label>
	  							<label for="checkbox"><?=$this->lang['remember'];//記住我?></label>
  							 </div>
	                        
							<input type="submit" class="btn normal send" value="<?=$this->lang['login'];//會員登入?>">
                            <p align="center"><a href="/gold/register" class="link"><?=$this->lang['regidter'];//註冊會員?></a>  /  <a href="/gold/forgot" class="link"><?=$this->lang['fotget'];//忘記密碼?></a></p>

					</div>
					</div>
				</section>
				</form>
			</div>
		</main>
<style>
.j-forms{
  width: 80%;
}
.form-box .form-control{
  background: #e7e7e7;
  color: #666;
}
</style>