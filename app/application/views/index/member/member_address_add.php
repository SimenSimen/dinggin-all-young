				<form action="/gold/data_AED" class="j-forms" method="post" onsubmit="return check_form(this)")>
				<section class="content has-side">
					<div class="title"><?=$this->lang_menu['member_address'];//常用寄貨地址?></div>
                        <div class="editor mg">
                        <div class="form-box">
					        <div class="form-group w110">
                                <div class="control-box">
                                <i class="icon-name"></i>
                                    <label class="control-label"><span>*</span><?=$this->lang['name'];//姓名?></label>
                                    <input class="form-control" type="text" name="name" placeholder="<?=$this->lang['plsname'];//請輸入姓名?>" value="<?=$_SESSION['RT']['name']?>">
                                </div>
                            </div>
                            <div class="form-group w110">
                                <div class="control-box">
                                <i class="icon-phone"></i>
                                <label class="control-label"><span>*</span><?=$this->lang['phone'];//電話?></label>
                                    <input class="form-control" type="text" maxlength="11" name="telphone" placeholder="<?=$this->lang['plstelphone'];//請輸入正確的聯絡電話?>" onKeyUp="value=value.replace(/[^\d]/g,'')" value="<?=$_SESSION['RT']['telphone']?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <span>*</span><?=$this->lang['mailingaddress'];//通訊地址?>
                                <div class="control-box">
                                    <div class="input-group">
                                        <div class="input-box">
                                            <i class="icon-placeholder"></i>
                                            <label class="control-label"><?=$this->lang['zip'];//郵遞區號?></label>
                                            <input class="form-control" type="text" id="zip" placeholder="<?=$this->lang['plszip'];//請填寫正確郵遞區號?>" name="zip">
                                        </div>
                                        <div class="input-box">
                                            <i class="icon-placeholder"></i>
                                            <label class="control-label"><?=$this->lang['country'];//請選擇地區?></label>
				                            <select name="country" id="country" onChange="" required class="form-control">
				                                <option value=""> </option>
				                                <?foreach ($country as $cvalue):?>
				                                    <option value="<?=$cvalue['s_id']?>" <?=($_SESSION['RT']['country']==$cvalue['s_id'])?'selected':'';?>><?=$cvalue['s_name']?></option>  
				                                <? endforeach;?>
				                            </select>
                                        </div>
                                        <div class="input-box">
                                            <i class="icon-placeholder"></i>
                                            <label class="control-label"><?=$this->lang['city'];//請選擇城市?></label>
				                            <select name="city" id="city" onChange="" required class="form-control">
				                                <option value=""> </option>
				                            </select>
                                        </div>
                                        <div class="input-box">
                                            <i class="icon-placeholder"></i>
                                            <label class="control-label"><?=$this->lang['county'];//請選擇鄉鎮地區?></label>
		                            		<select name="countory" id="countory" class="form-control" required>
		                                		<option value=""> </option>
		                            		</select>
                                        </div>
                                        <div class="input-box w110">
                                            <i class="icon-placeholder"></i>
                                            <label class="control-label"><?=$this->lang['address'];//地址?></label>
                    						<input class="form-control" type="text" placeholder="<?=$this->lang['plsaddress'];//請填寫正確地址?>" name="address" required value="<?=$_SESSION['RT']['address']?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pagination_box">
                            <input type="hidden" name="dbname" value="<?=$dbname?>">
                            <input type="hidden" name="by_id" value="<?=$_SESSION['MT']['by_id']?>">
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
    var rephone = /^\d{8,11}$/;
    var rezip = /^\d{3,6}$/;
    if(frm.elements['name'].value==''){
        alert("<?=$this->lang['plsname'];//請輸入姓名?>");
        frm.elements['name'].focus();
        return false;   
    }else if(!rephone.test(frm.elements['telphone'].value)){
        alert("<?=$this->lang['plstelphone'];//請輸入正確電話?>");
        frm.elements['telphone'].focus();
        return false;   
    }else if(!rezip.test(frm.elements['zip'].value)){
        alert("<?=$this->lang['plszip'];//請輸入郵遞區號?>");
        frm.elements['zip'].focus();
        return false;   
    }
    else
        return true;    
}
</script>
<script src="/js/myjava/region.js"></script>
<script>
<? if($_SESSION['RT']['country']!=''):?>
    sel_area(<?=$_SESSION['RT']['country']?>,<?=$_SESSION['RT']['city']?>,'city');
<? endif;?>
<? if($_SESSION['RT']['city']!=''):?>
    sel_area(<?=$_SESSION['RT']['city']?>,<?=$_SESSION['RT']['countory']?>,'countory');
<? endif;?>
</script>

<script src="/js/handle_address.js"></script>