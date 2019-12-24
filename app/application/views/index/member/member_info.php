				<form action="/gold/data_AED" class="j-forms" method="post" onsubmit="return check_form(this)")>
				<section class="content has-side">
					<div class="title"><?=$this->lang['basic'];//基本資料?></div>
					<div class="editor mg">
						<div class="form-box">
							<?if($dbdata['is_alipay']==0){?>
							<div class="form-group">
	                            <div class="control-box">
	                            	<i class="icon-id"></i>
	                            	<label class="control-label"><span>*</span><?=$this->lang['account'];//帳號?></label>
	                                <input class="form-control" type="text" name="d_account" id="" value="<?=$dbdata['d_account']?>" disabled>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <div class="control-box">
	                            <i class="icon-lock"></i>
	                            <label class="control-label"><span>*</span><?=$this->lang['password'];//密碼?></label>
	                                <p class="form-control"><a href="/gold/member_password"><?=$this->lang['editpwd'];//修改密碼?></a></p>
	                            </div>
	                        </div>
	                        <?}?>
	                        <div class="form-group">
	                            <div class="control-box">
	                            <i class="icon-cake"></i>
	                            <label class="control-label"><span>*</span><?=$this->lang['brithday'];//生日?></label>
	                                <input style="pointer-events: none;" class="form-control bar_content date-object birthday" type="text" name="birthday" id="" value="<?=$dbdata['birthday']?>">
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <div class="control-box">
	                            <i class="icon-name"></i>
	                            <label class="control-label"><span>*</span><?=$this->lang['name'];//姓名?></label>
	                                <input class="form-control" type="text" name="name" id="" value="<?=$dbdata['name']?>" disabled>
	                            </div>
	                        </div>
	                        <div class="form-group">
								<div class="control-box">
								<i class="icon-cake"></i>
				                	<label class="control-label"><span>*</span><?=$this->lang['email'];//Email?></label>
				                    <input class="form-control" type="text" name="by_email" value="<?=$dbdata['by_email']?>">
				    			</div>
				            </div>
				            <div class="form-group">
	                            <div class="control-box">
	                            <i class="icon-placeholder"></i>
									<label class="control-label">*<?=$this->lang['country'];//請選擇地區?></label>
		                            <select name="country" id="country" class="form-control" style="padding-left:48px">
		                                <?foreach ($country as $ccvalue):?>
		                                    <option value="<?=$ccvalue['s_id']?>" <?=($dbdata['country']==$ccvalue['s_id'])?'selected':'';?>><?=$ccvalue['s_name']?></option>
		                                <? endforeach;?>
		                            </select>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <div class="control-box">
	                            <i class="icon-placeholder"></i>
	                            	<label class="control-label"><span>*</span><?=$this->lang['address'];//地址?></label>
	                                <input class="form-control" type="text" name="address" id="" value="<?=$dbdata['address']?>">
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <div class="control-box">
	                            <i class="icon-phone-call"></i>
	                            <label class="control-label"><span>*</span><?=$this->lang['phone'];//電話?></label>
	                                <input class="form-control" type="text" maxlength="11" name="telphone" id="" value="<?=$dbdata['telphone']?>" onkeyup="value=value.replace(/[^\d]/g,'')">
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <div class="control-box">
	                            <i class="icon-phone"></i>
	                            <label class="control-label"><span>*</span><?=$this->lang['mobile'];//手機?></label>
	                                <p class="form-control"><?php echo $dbdata['mobile'];?> <a href="/member_mobile"><?=$this->lang['editMobile'];//修改手機號碼?></a></p>
	                            </div>
	                        </div>
	                        <div class="form-group">
								<div class="form-group radio">
									<input type="radio" name="d_service" value="Y" id="checkbox2"<?php echo ($dbdata['d_service'] == 'Y')?' checked':'';?>>
									<label for="checkbox2"><?php echo $this->lang['getService'];?></label>
									<input type="radio" name="d_service" value="N" id="checkbox2"<?php echo ($dbdata['d_service'] == 'N')?' checked':'';?>>
									<label for="checkbox2"><?php echo $this->lang['getService2'];?></label>
								</div>
							</div>
                            <p ><?=$this->lang['youhave'];//您目前有?><span class="color01"><?=number_format($dbdata['d_dividend'])?></span><?=$this->lang['dividend'];//紅利點數?> <span class="color01"><?=number_format($dbdata['d_shopping_money'])?></span><?=$this->lang['shoppingmoney'];//購物金?>
                            <!-- 10/5拿掉(<?=$this->lang['limit'];//有效期限?><?=$birthday?>)<a href="/gold/dividend"><?=$this->lang['ddtaile'];//紅利明細?></a></p> -->

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
$(document).ready(function() {
	$('.fancybox-share').fancybox({
        margin: 5,
        padding: 0,
        width: '100%',
        maxWidth: 650,
        type: 'iframe',
        wrapCSS: 'search',
        helpers : {
            overlay : {
                css : {
                    'background' : 'rgba(0,0,0,0.8)'
                }
            }
        }
    });

});
<? if($_SESSION['RT']['country']!=''):?>
    //sel_area(<?=$_SESSION['RT']['country']?>,<?=$_SESSION['RT']['city']?>,'city');
<? endif;?>
<? if($_SESSION['RT']['city']!=''):?>
    //sel_area(<?=$_SESSION['RT']['city']?>,<?=$_SESSION['RT']['countory']?>,'countory');
<? endif;?>
function check_form(frm)
{
    var re = /^\d{8,11}$/;
	var rezip = /^\d{3,6}$/;
	var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(frm.elements['d_account'].value==''){
        alert("<?=$this->lang['plsacc'];//請輸入帳號?>");
        frm.elements['d_account'].focus();
        return false;
    }else if((frm.elements['nickname'].value).length>10){
        alert("<?=$this->lang['upto10'];//暱稱最多十個字?>");
        frm.elements['nickname'].focus();
        return false;
    }else if(frm.elements['name'].value==''){
        alert("<?=$this->lang['plsname'];//請輸入姓名?>");
        frm.elements['name'].focus();
        return false;
    }else if(frm.elements['country_num'].value==''){
        alert("<?=$this->lang['country_num'];//請選擇國碼?>");
        frm.elements['country_num'].focus();
        return false;
    }else if(frm.elements['mobile'].value=='' || !re.test(frm.elements['mobile'].value)){
        alert("<?=$this->lang['input_mobile'];//請輸入手機?>"+','+"<?=$this->lang['ten_or_elevenphone'];//手機號碼需要8-11碼?>");
        frm.elements['mobile'].focus();
        return false;
    }else if(!rezip.test(frm.elements['zip'].value)){
        alert("<?=$this->lang['plszip'];//請輸入郵遞區號?>");
        frm.elements['zip'].focus();
        return false;
    }else if(frm.elements['address'].value==''){
        alert("<?=$this->lang['plsaddress'];//請輸入完整地址?>");
        frm.elements['address'].focus();
        return false;
    }else if(frm.elements['by_email'].value==''||(!regex.test(frm.elements['by_email'].value))){
        alert("<?=$this->lang['plsmail'];//請輸入信箱?>");
        frm.elements['by_email'].focus();
        return false;
    }
    else
        return true;
}
</script>
<script src="/js/myjava/region.js"></script>
<link href="/js/admin_sys/jquery-ui_1_11_2/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="/js/admin_sys/jquery-ui_1_11_2/jquery-ui.js"></script>
<script src="/js/admin_sys/jquery-ui_1_11_2/lang/datepicker-zh-TW.js"></script>
<script>
  $(".date-object").datepicker({dateFormat: "yy-mm-dd",yearRange :"c-100:c+100"});//生日時間"年"份軸
</script>

<script src="/js/handle_address.js"></script>
