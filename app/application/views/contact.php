		<main class="main-content wow fadeInUp" data-wow-delay="0.4s">
        	<form action="/gold/data_AED" method="post">
			<div class="container">
				<section class="content">
					<div class="title"><?=$title?></div>
					<div class="editor mg">
						<div class="form-box">
						<div class="form-group">
	                            <div class="control-box">
	                            <i class="icon-name"></i>
	                            	<label class="control-label"><span>*</span><?=$this->lang['name'];//姓名?></label>
	        						<input class="form-control" type="text" placeholder="<?=$this->lang['iname'];//請輸入姓名?>" name="d_name">
	                            </div>
	                        </div>
						<div class="form-group name">
	                        	<i class="icon-genders"></i> <label class="control-label"><?=$this->lang['sex'];//性別?></label>
                                <div class="control-box">
                                    <div class="radio-box">
                                        <label class="form-radio"><input type="radio" name="d_sex" value="male"><i></i><?=$this->lang['male'];//先生?></label>
                                        <label class="form-radio"><input type="radio" name="d_sex" value="female"><i></i><?=$this->lang['female'];//小姐?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
	                            <div class="control-box">
	                            <i class="icon-phone-call"></i>
	                            <label class="control-label"><?=$this->lang['phone'];//電話?></label>
	        						<input class="form-control" type="text" name="d_mobile" placeholder="<?=$this->lang['iphone'];//請輸入正確的聯絡電話?>" onKeyUp="value=value.replace(/[^\d]/g,'')">
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <div class="control-box">
	                            <i class="icon-phone"></i>
	                            <label class="control-label"><span>*</span><?=$this->lang['mobile'];//手機?></label>
	        						<input class="form-control" type="text" name="d_phone" maxlength="10" placeholder="<?=$this->lang['imobile'];//請輸入正確的手機號碼?>" onKeyUp="value=value.replace(/[^\d]/g,'')">
	                            </div>
	                        </div>
	                        <div class="form-group w100">
	                            <div class="control-box">
	                            <i class="icon-mail"></i>
	                            <label class="control-label"><span>*</span>E-mail</label>
	        						<input class="form-control" type="text" placeholder="<?=$this->lang['imail'];//請輸入個人信箱?>" name="d_mail">
	                            </div>
	                        </div>
	                        <div class="form-group w110">
	                        	<div class="control-box">
	                        	<i class="icon-chat"></i>
                                <label class="control-label"><span>*</span><?=$this->lang['content'];//內容?></label>
            						<textarea class="form-control" style="height:210px" name="d_content" cols="" rows="" placeholder="<?=$this->lang['icontent'];//請輸入您的訊息?>"></textarea>
                                </div>
                            </div>


							
                			<input type="hidden" name="dbname" value="<?=$dbname?>">
                			<input type="submit" class="btn normal send" value="<?=$this->lang['s_send'];//送出?>">
                            
						</div>
					</div>
				</section>
			</div>
			</form>
		</main>
