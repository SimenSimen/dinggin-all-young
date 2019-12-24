				<form action="/gold/data_AED" class="j-forms" method="post" onsubmit="return check_form(this)")>
				<section class="content has-side">
					<div class="title"><?=$this->lang['basic'];//基本資料?></div>
					<div class="editor mg">
						<div class="form-box">
							<div class="form-group w130">
	                            <div class="control-box">
	                            	<i class="icon-id"></i>
	                            	<label class="control-label"><?=$this->lang['account'];//帳號?></label>
	                                <input class="form-control" type="text" name="d_account" id="" value="<?=$dbdata['d_account']?>" disabled>
	                            </div>
	                        </div>
	                        <div class="form-group w130">
	                            <div class="control-box">
	                            <i class="icon-lock"></i>
	                            <label class="control-label"><?=$this->lang['password'];//密碼?></label>
	                                <p class="form-control"><a href="/gold/member_password"><?=$this->lang['editpwd'];//修改密碼?></a></p>
	                            </div>
	                        </div>
	                        <div class="form-group w130">
	                            <div class="control-box">
	                            <i class="icon-name"></i>
	                            <label class="control-label"><?=$this->lang['name'];//姓名?></label>
	                                <input class="form-control" type="text" name="name" id="" value="<?=$dbdata['name']?>" disabled>
	                            </div>
	                        </div>
	                        <div class="form-group w130">
	                            <div class="control-box">
	                            <i class="icon-name"></i>
	                            <label class="control-label"><?=$this->lang['sex'];//性別?></label>
	                				<input class="form-control" type="text" name="sex" id="" value="<?=$dbdata['sex']?>" disabled>
	                            </div>
	                        </div>
	                        <div class="form-group w130">
	                            <div class="control-box">
	                            <i class="icon-nickname"></i>
	                            	<label class="control-label"><?=$this->lang['nickname'];//暱稱?></label>
	                                <input class="form-control" type="text" name="nickname" id="nickname" value="<?=$dbdata['nickname']?>"  placeholder="<?=$this->lang['upto10'];//最多十個字?>" maxlength="10">
	                            </div>
	                        </div>
	                        <div class="form-group w130">
	                            <div class="control-box">
	                            <i class="icon-phone"></i>
	                            <label class="control-label"><?=$this->lang['mobile'];//手機?></label>
	                                <input class="form-control" type="text" maxlength="11" name="mobile" id="" value="<?=$dbdata['mobile']?>" onkeyup="value=value.replace(/[^\d]/g,'')">
	                            </div>
	                        </div>
	                        <div class="form-group w130">
	                            <div class="control-box">
	                            <i class="icon-phone-call"></i>
	                            <label class="control-label"><?=$this->lang['phone'];//電話?></label>
	                                <input class="form-control" type="text" maxlength="11" name="telphone" id="" value="<?=$dbdata['telphone']?>" onkeyup="value=value.replace(/[^\d]/g,'')">
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <div class="control-box">
	                            <i class="icon-placeholder"></i>
		                            <select name="country" id="country" onChange="sel_area(this.value,'','city')" class="form-control">
		                                <option value=""><?=$this->lang['country'];//請選擇地區?></option>
		                                <?foreach ($country as $ccvalue):?>
		                                    <option value="<?=$ccvalue['s_id']?>" <?=($dbdata['country']==$ccvalue['s_id'])?'selected':'';?>><?=$ccvalue['s_name']?></option>  
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
		                            </select>
	                            </div>
	                        </div>
	                        <div class="form-group w130">
	                            <div class="control-box">
	                            <i class="icon-placeholder"></i>
	                            	<label class="control-label"><?=$this->lang['address'];//地址?></label>
	                                <input class="form-control" type="text" name="address" id="" value="<?=$dbdata['address']?>">
	                            </div>
	                        </div>
	                        <div class="form-group w130">
	                            <div class="control-box">
	                            <i class="icon-cake"></i>
	                            <label class="control-label"><?=$this->lang['brithday'];//生日?></label>
	                                <input class="form-control bar_content date-object birthday" type="text" name="birthday" id="" value="<?=$dbdata['birthday']?>">
	                            </div>
	                        </div>
				            <div class="form-group w130">
								<div class="control-box">
								<i class="icon-cake"></i>
				                	<label class="control-label">Email</label>
				                    <input class="form-control" type="text" name="by_email" value="<?=$dbdata['by_email']?>">
				    			</div>
				            </div>
				    		<?if($_SESSION['MT']['d_is_member']=="1"){?>
	                         <div class="form-group">
                                <span>*</span><?=$this->lang['saddress'];//戶籍地址?>
                                <div class="control-box">
                                    <div class="input-group">
                                        <div class="input-box">
                                        	<i class="icon-placeholder"></i>
				                            <select name="cen_country" id="cen_country" onChange="sel_area(this.value,'','cen_city')" class="form-control">
				                 				<option value="0"><?=$this->lang['country'];//請選擇國家地區?></option>
				                              <?foreach ($country as $xccvalue):?>
				                                <option value="<?=$xccvalue['s_id']?>" <?=($mdbdata['country']==$xccvalue['s_id'])?'selected':'';?>><?=$xccvalue['s_name']?></option>  
				                              <? endforeach;?>
				                            </select>
                                        </div>
                                        <div class="input-box">
                                        	<i class="icon-placeholder"></i>
				                            <select name="cen_city" id="cen_city" onChange="sel_area(this.value,'','cen_countory')" class="form-control">
				                                <option value="0"><?=$this->lang['city'];//請選擇省份城市?></option>  
				                            </select>
                                        </div>
                                        <div class="input-box">
                                        	<i class="icon-placeholder"></i>
				                            <select name="cen_countory" id="cen_countory" class="form-control" required>
				                                <option value="0"><?=$this->lang['county'];//請選擇地級市鄉鎮地區?></option>  
				                            </select>
                                        </div>
                                        <div class="input-box w130">
                                            <i class="icon-placeholder"></i>
                                            <label class="control-label"><?=$this->lang['address'];//地址?></label>
                                 			<input class="form-control" type="text" value="<?=$mdbdata['address']?>" name="cen_address">
                                    	</div>
                                	</div>
                            	</div>
                            </div>

	                        <div class="form-group w170">
                                <span>*</span><?=$this->lang['accconfig'];//帳戶設定?>
                                <div class="control-box">
                                    <div class="input-group">
                                        <div class="input-box">
                                            <i class="icon-id"></i>
                                            <label class="control-label"><?=$this->lang['bankname'];//銀行名稱?></label>
                                			<input class="form-control" type="text" value="<?=$mdbdata['bank_name']?>" name="bank_name">
                                        </div>
                                        <div class="input-box">
                                            <i class="icon-id"></i>
                                            <label class="control-label"><?=$this->lang['accountname'];//帳戶名稱?></label>
                                			<input class="form-control" type="text" value="<?=$mdbdata['bank_account_name']?>" name="bank_account_name">
                                        </div>
                                       <div class="input-box">
                                            <i class="icon-id"></i>
                                            <label class="control-label"><?=$this->lang['bankaccount'];//銀行帳號?></label>
                                			<input class="form-control" type="text" value="<?=$mdbdata['bank_account']?>" name="bank_account">
                                    	</div>
                                	</div>
                            	</div>
                            </div>
                            <input type="hidden" name="is_member" value="Y">
                            <div class="form-group">
                                <?=$this->lang['storeaddress'];//門市取貨地址?>
                                <div class="control-box">
                                    <div class="input-group">
                                        <div class="input-box">
                                        	<i class="icon-placeholder"></i>
				                            <select name="shop_country" id="shop_country" onChange="sel_area(this.value,'','shop_city')" class="form-control">
				                                <option value="0"><?=$this->lang['country'];//請選擇國家地區?></option>
				                                <?foreach ($country as $cvalue):?>
				                                    <option value="<?=$cvalue['s_id']?>" <?=($mdbdata['shop_country']==$cvalue['s_id'])?'selected':'';?>><?=$cvalue['s_name']?></option>  
				                                <? endforeach;?>
				                            </select>
                                        </div>
                                        <div class="input-box">
                                        	<i class="icon-placeholder"></i>
				                            <select name="shop_city" id="shop_city" onChange="sel_area(this.value,'','shop_countory')" class="form-control">
				                                <option value="0"><?=$this->lang['city'];//請選擇省份城市?></option>
				                            </select>
                                        </div>
                                        <div class="input-box">
                                        	<i class="icon-placeholder"></i>
		                            		<select name="shop_countory" id="shop_countory" class="form-control">
		                                		<option value="0"><?=$this->lang['county'];//請選擇地級市鄉鎮地區?></option>
		                            		</select>
                                        </div>
                                        <div class="input-box w130">
                                            <i class="icon-placeholder"></i>
                                            <label class="control-label"><?=$this->lang['address'];//地址?></label>
                                        	<input class="form-control" type="text" name="shop_address" id="" value="<?=$mdbdata['shop_address']?>">
                                    	</div>
                                	</div>
                            	</div>
                            </div>
							<?}?>
                            <p ><?=$this->lang['youhave'];//您目前有?><span class="color01"><?=number_format($dbdata['d_dividend'])?></span><?=$this->lang['dividend'];//紅利點數?> <span class="color01"><?=number_format($dbdata['d_shopping_money'])?></span><?=$this->lang['shoppingmoney'];//購物金?>  (<?=$this->lang['limit'];//有效期限?><?=$birthday?>)<a href="/gold/member_dividend"><?=$this->lang['ddtaile'];//紅利明細?></a></p>
	                        
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
<script src="/js/myjava/region.js"></script>
<link href="/js/admin_sys/jquery-ui_1_11_2/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="/js/admin_sys/jquery-ui_1_11_2/jquery-ui.js"></script>
<script src="/js/admin_sys/jquery-ui_1_11_2/lang/datepicker-zh-TW.js"></script>
<script>
  $(".date-object").datepicker({dateFormat: "yy-mm-dd",yearRange :"c-100:c+100"});//生日時間"年"份軸
</script>
<script>
<? if($dbdata['by_id']!=''):?>
	<? if($dbdata['country']!='' && $dbdata['country']!='0'):?>
	sel_area(<?=$dbdata['country']?>,<?=$dbdata['city']?>,'city');
    <? endif;?>
	<? if($dbdata['city']!='' && $dbdata['city']!='0'):?>
    sel_area(<?=$dbdata['city']?>,<?=$dbdata['countory']?>,'countory');
    <? endif;?>
<? endif;?>
<?if($_SESSION['MT']['d_is_member']=="1"){?>
	<? if($mdbdata['country']!='' && $mdbdata['country']!='0'):?>
	sel_area(<?=$mdbdata['country']?>,<?=$mdbdata['city']?>,'cen_city');
	<? endif;?>
	<? if($mdbdata['city']!='' && $mdbdata['city']!='0'):?>
    sel_area(<?=$mdbdata['city']?>,<?=$mdbdata['countory']?>,'cen_countory');
    <? endif;?>
    <? if($mdbdata['shop_country']!='' && $mdbdata['shop_country']!='0'):?>
    sel_area(<?=$mdbdata['shop_country']?>,<?=$mdbdata['shop_city']?>,'shop_city');
    <? endif;?>
    <? if($mdbdata['shop_city']!='' && $mdbdata['shop_city']!='0'):?>
	sel_area(<?=$mdbdata['shop_city']?>,<?=$mdbdata['shop_countory']?>,'shop_countory');
	<? endif;?>
<?}?>
</script>