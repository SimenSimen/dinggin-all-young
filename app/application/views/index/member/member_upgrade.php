				<?if($_SESSION['MT']['d_is_member']=="0"){?>
				<script src="/js/myjava/region.js"></script>
				<form action="/gold/data_AED" class="j-forms" method="post" onsubmit="return check_form(this)")>
				<section class="content has-side">
					<div class="title"><?=$this->lang_menu['member_upgrade'];//升級經營會員?></div>
					<div class="editor mg">
					<div class="form-box">
                        <div class="control-box" style="margin-bottom: -15px;">
                            <i class="icon-genders"></i> <label class="control-label"><span>*</span><?=$this->lang['identity'];//身份?></label>
                        </div>
						<div class="form-group name">
                                <i class="icon-genders" style="visibility: hidden;"></i>
                                <label class="control-label" style="visibility: hidden;"><?=$this->lang['identity'];//身份?></label>
                                <div class="control-box">
                                    <div class="radio-box">
                                        <label class="form-radio"><input type="radio" name="identity" id="identity" value="natural person" checked><font> <?=$this->lang['general'];//一般?></font></label>
                                        <label class="form-radio"><input type="radio" name="identity" id="identity" value="juristic person"><font> <?=$this->lang['legal_person'];//法人?></font></label>
                                    </div>
                                </div>
                            </div>

                        <div class="form-group w130">
	                            <div class="control-box">
	                            <i class="icon-name"></i>
	                            <label class="control-label"><span>*</span><?=$this->lang['idnum'];//身份證字號?></label>
	                                <input class="form-control" type="text" placeholder="<?=$this->lang['iidnum'];//請輸入身份證字號?>" name="identity_num" maxlength="16">
	                            </div>
	                        </div>


							 <div class="form-group">
                                <?=$this->lang['raddress'];//戶籍地址?>
                                
		                        <input type="checkbox" id="somemember" value="1">
	  							<label for="checkbox"><?=$this->lang['sameadd'];//同通訊地址?></label>

                                <div class="control-box">
                                    <div class="input-group">
                                        <div class="input-box" id="country_select">
                                            <i class="icon-placeholder"></i>
                                            <label class="control-label"><span>*</span>
                                                <?=$this->lang['country'];//請選擇地區?></label>
				                            <select name="country" id="country" onChange="sel_area(this.value,'','city'); sel_area(this.value,'','countory')" class="form-control" style="padding-left:48px">
				                                <option value=""> </option>
				                                <?foreach ($country as $avalue):?>
				                                    <option value="<?=$avalue['s_id']?>" <?=($_SESSION['RT']['country']==$avalue['s_id'])?'selected':'';?>><?=$avalue['s_name']?></option>  
				                                <? endforeach;?>
				                            </select>
                                        </div>
                                        <div class="input-box" id="city_select">
                                            <i class="icon-placeholder"></i>
                                            <label class="control-label"><span>*</span>
                                                <?=$this->lang['city'];//請選擇省份城市?></label>
				                            <select name="city" id="city" onChange="sel_area(this.value,'','countory')" class="form-control" style="padding-left:48px">
				                                <option value=""> </option>
				                                <?foreach ($city as $cvalue):?>
				                                    <option value="<?=$cvalue['s_id']?>" <?=($_SESSION['RT']['city']==$cvalue['s_id'])?'selected':'';?>><?=$cvalue['s_name']?></option>  
				                                <? endforeach;?>
				                            </select>
                                        </div>
                                        <div class="input-box" id="countory_select">
                                            <i class="icon-placeholder"></i>
                                            <label class="control-label"><span>*</span>
                                                <?=$this->lang['county'];//請選擇地級市鄉鎮地區?></label>
				                            <select name="countory" id="countory" class="form-control" style="padding-left:48px">
				                                <option value=""> </option>
				                            </select>
                                        </div>
                                        <div class="input-box w110">
                                            <i class="icon-placeholder"></i>
                                            <label class="control-label"><span>*</span><?=$this->lang['address'];//地址?></label>
                                    		<input class="form-control" type="text" placeholder="<?=$this->lang['realadd'];//請填寫正確地址?>" name="address" id="address">
                                    	</div>
                                	</div>
                            	</div>
                            </div>

	                        <div class="form-group w150">
                                <?=$this->lang['accconfig'];//帳戶設定?>
														<span style="color:red;font-size: 8px; */"><?=$this->lang['accconfig_info'];//(獎金將由新加坡匯出，請提供國際匯款相關資料。)?></span>
                                <div class="control-box">
                                    <div class="input-group">
                                        <div class="input-box">
                                            <i class="icon-id"></i>
                                            <label class="control-label"><span>*</span><?=$this->lang['bname'];//銀行名稱?></label>
                                			<input class="form-control" type="text" placeholder="<?=$this->lang['bname'];//銀行名稱?>" name="bank_name" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')">
                                        </div>
                                        <div class="input-box">
                                            <i class="icon-id"></i>
                                            <label class="control-label"><span>*</span><?=$this->lang['baddress'];//銀行地址?></label>
                                			<input class="form-control" type="text" placeholder="<?=$this->lang['baddress'];//銀行地址?>" name="bank_address" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')">
                                        </div>
                                       <div class="input-box">
                                            <i class="icon-id"></i>
                                            <label class="control-label"><span>*</span><?=$this->lang['accountname'];//帳戶名稱?></label>
                                			<input class="form-control" type="text" placeholder="<?=$this->lang['accountname'];//帳戶名稱?>" name="bank_account_name" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')">
                                    	</div>
                                       <div class="input-box">
                                            <i class="icon-id"></i>
                                            <label class="control-label"><span>*</span><?=$this->lang['bacc'];//銀行帳號?></label>
                                			<input onkeyup="value=value.replace(/[^\d]/g,'') " class="form-control" type="text" placeholder="<?=$this->lang['bacc'];//銀行帳號?><?=$this->lang['inputnum'];//(請輸入數字)?>" name="bank_account" onKeyUp="value=value.replace(/[^0-9]/g,'')">
                                    	</div>
                                       <div class="input-box">
                                            <i class="icon-id"></i>
                                            <label class="control-label"><span>*</span><?=$this->lang['swiftcode'];//swiftcode?></label>
                                			<input class="form-control" type="text" placeholder="<?=$this->lang['swiftcode'];//swiftcode?>" name="swift_code" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')">
                                    	</div>
                                	</div>
                            	</div>
                            </div>
							<div class="form-group checbox">
		                        <input type="checkbox" name="agree" id="agree" value="ok" />
	  							<label for="checkbox"><?=$this->lang['I_have_read'];//我已詳閱?><a href="/gold/announce" target=_blank><?=$this->lang['term'];//會員同意條款?></a></label>
  							 </div>
	                        
	                        <div class="pagination_box">
                			<input type="hidden" name="dbname" value="<?=$dbname?>">
	                        <input type='hidden' name='by_id' id='by_id' value='<?=$by_id?>'>
                			<input type="reset" class="btn simple" value="<?=$this->lang['s_restart'];//重填?>">
                			<input type="submit"  class="btn simple bg2" value="<?=$this->lang['s_send'];//送出?>">
                            </div>


					</div>
					</div>
				</section>
				</form>
				<?}else if($_SESSION['MT']['d_is_member']=="1"){?>
					<center>已升級為經營會員</center>
				<?}else if($_SESSION['MT']['d_is_member']=="2"){?>
					<center>升級經營會員資料審核中...</center>
				<?}?>
			</div>
		</main>
<style>
.form-box .w150 .form-control{
  padding: 5px 10px 5px 40px;
}
</style>
<script>
<? if($_SESSION['RT']['countory']!=''):?>
    sel_area(<?=$_SESSION['RT']['city']?>,<?=$_SESSION['RT']['countory']?>,'countory');
<? endif;?>
function check_form(frm){
    if(frm.elements['identity_num'].value==''){
        alert("<?=$this->lang['iidnum'];//請輸入身份證字號?>");
        frm.elements['identity_num'].focus();
        return false;   
    }else if(frm.elements['country'].value=='0' || frm.elements['country'].value==''){
        alert("<?=$this->lang['country'];//請選擇地區?>");
        frm.elements['country'].focus();
        return false;   
    }
    else if(frm.elements['city'].value=='0' || frm.elements['city'].value==''){
        alert("<?=$this->lang['city'];//請選擇省份城市?>");
        frm.elements['city'].focus();
        return false;   
    }
    else if(frm.elements['countory'].value=='0' || frm.elements['countory'].value==''){
        alert("<?=$this->lang['county'];//請選擇地級市鄉鎮地區?>");
        frm.elements['countory'].focus();
        return false;   
    }else if(frm.elements['address'].value==''){
        alert("<?=$this->lang['realadd'];//請填寫正確地址?>");
        frm.elements['address'].focus();
        return false;   
    }else if(frm.elements['bank_name'].value==''){
        alert("<?=$this->lang['re_bank_name'];//請填銀行名稱?>");
        frm.elements['bank_name'].focus();
        return false;   
    }else if(frm.elements['bank_account_name'].value==''){
        alert("<?=$this->lang['re_bank_account_name'];//請填帳戶名稱?>");
        frm.elements['bank_account_name'].focus();
        return false;   
    }else if(frm.elements['bank_account'].value==''){
        alert("<?=$this->lang['re_bank_account'];//請填銀行帳號?>");
        frm.elements['bank_account'].focus();
        return false;
    }else if(frm.elements['bank_address'].value==''){
        alert("<?=$this->lang['re_bank_address'];//請填銀行帳號?>");
        frm.elements['bank_address'].focus();
        return false;
    }else if(frm.elements['swift_code'].value==''){
        alert("<?=$this->lang['re_bank_swiftcode'];//請填銀行帳號?>");
        frm.elements['swift_code'].focus();
        return false;   
    }else if($("input[name=agree]:checked").val()!='ok'){
        alert("<?=$this->lang['read_agree'];//請勾選已詳閱條款和政策?>");
        frm.elements['agree'].focus();
        return false;   
    }
    else{
        if(confirm("<?=$this->lang['confirm'];//為了維護帳戶安全,請您確認輸入的資料無誤,之後若要更改請洽管理員?>")){            
            return true;
        }else{
            return false;
        }
    }
}

  $('#somemember').click(function(){
    var bid=$('#by_id').val();
    $.ajax({
      url:'/gold/get_member',
      type:'POST',
      data: 'type=upgrade&bid='+bid,
      dataType: 'json',
      success: function( json ) 
      {
        $('#address').val(json.address);
        ajax_area(json.country,json.city_id,json.countory_id);
      }
    });
  });
  //同會員資料    
function ajax_area(country,city,countory){
  $.post("/cart/ajax_area",{country:country,city:city,countory:countory},  
    function(data){ 
      var area_array = JSON.parse(data);
        $("#country_select").html(area_array['country']);
        $("#city_select").html(area_array['city']);
        $("#countory_select").html(area_array['countory']);
    }
  );
}
</script>
