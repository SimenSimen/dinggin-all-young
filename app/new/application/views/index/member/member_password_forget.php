		<main class="main-content wow fadeInUp" data-wow-delay="0.4s">
			<div class="container center">
				<form action="/gold/forgot_set" method="post" onsubmit="return check_form(this)" class="j-forms">
				<section class="content">
					<div class="title"><?=$this->lang['fotget'];//忘記密碼?></div>
					<div class="editor mg">
					<div class="form-box">
							<div class="form-group w110">
	                            <div class="control-box">
	                            	<i class="icon-id"></i>
	                            	<label class="control-label"><?=$this->lang['account'];//帳號?></label>
	                				<input class="form-control" type="text" name="acconut">
	                            </div>
	                        </div>
							<div class="form-group w110">
	                            <div class="control-box">
	                            	<i class="icon-id"></i>
	                            	<label class="control-label">E-mail</label>
	                				<input class="form-control" type="text" placeholder="<?=$this->lang['plsmail'];//請輸入個人信箱?>" name="email">
	                            </div>
	                        </div>
                            <input type="submit" class="btn normal send" value="<?=$this->lang['s_send'];//送出?>">
					</div>
					</div>
				</section>
				</form>
			</div>
		</main>
<style>
.j-forms{
  width: 50%;
}
.form-box .form-control{
  padding: 5px 10px 5px 90px;
  background: #e7e7e7;
  color: #666;
}
</style>