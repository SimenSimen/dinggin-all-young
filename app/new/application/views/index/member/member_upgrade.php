				<?if($_SESSION['MT']['d_is_member']=="0"){?>
				<script src="/js/myjava/region.js"></script>
				<form action="/gold/data_AED" class="j-forms" method="post" onsubmit="return check_form(this)")>
				<section class="content has-side">
					<div class="title"><?=$this->lang['update'];//升級經營會員?></div>
					<div class="editor mg">
					<div class="form-box">
						<div class="form-group name">
	                        	<i class="icon-genders"></i> <label class="control-label"><?=$this->lang['identity'];//身份?></label>
                                <div class="control-box">
                                    <div class="radio-box">
                                        <label class="form-radio"><input type="radio" name="identity" id="identity" value="natural person" checked> <?=$this->lang['general'];//一般?></label>
                                        <label class="form-radio"><input type="radio" name="identity" id="identity" value="juristic person"> <?=$this->lang['legal_person'];//法人?></label>
                                    </div>
                                </div>
                            </div>
                        <div class="form-group w130">
	                            <div class="control-box">
	                            <i class="icon-name"></i>
	                            <label class="control-label"><?=$this->lang['idnum'];//身份證字號?></label>
	                                <input class="form-control" type="text" placeholder="<?=$this->lang['iidnum'];//請輸入身份證字號?>" name="identity_num" maxlength="16" required >
	                            </div>
	                        </div>


							 <div class="form-group">
                                <?=$this->lang['raddress'];//戶籍地址?>
                                
		                        <input type="checkbox" id="somemember" value="1">
	  							<label for="checkbox"><?=$this->lang['sameadd'];//同通訊地址?></label>

                                <div class="control-box">
                                    <div class="input-group">
                                        <div class="input-box">
                                        	<i class="icon-placeholder"></i>
				                            <select name="country" id="country" onChange="sel_area(this.value,'','city')" class="form-control" required >
				                                <option value=""><?=$this->lang['country'];//請選擇地區?></option>
				                                <?foreach ($country as $avalue):?>
				                                    <option value="<?=$avalue['s_id']?>" <?=($_SESSION['RT']['country']==$avalue['s_id'])?'selected':'';?>><?=$avalue['s_name']?></option>  
				                                <? endforeach;?>
				                            </select>
                                        </div>
                                        <div class="input-box">
                                        	<i class="icon-placeholder"></i>
				                            <select name="city" id="city" onChange="sel_area(this.value,'','countory')" class="form-control" required >
				                                <option value=""><?=$this->lang['city'];//請選擇省份城市?></option>
				                                <?foreach ($city as $cvalue):?>
				                                    <option value="<?=$cvalue['s_id']?>" <?=($_SESSION['RT']['city']==$cvalue['s_id'])?'selected':'';?>><?=$cvalue['s_name']?></option>  
				                                <? endforeach;?>
				                            </select>
                                        </div>
                                        <div class="input-box">
                                        	<i class="icon-placeholder"></i>
				                            <select name="countory" id="countory" class="form-control" required >
				                                <option value=""><?=$this->lang['county'];//請選擇地級市鄉鎮地區?></option>
				                            </select>
                                        </div>
                                        <div class="input-box w110">
                                            <i class="icon-placeholder"></i>
                                            <label class="control-label"><?=$this->lang['address'];//地址?></label>
                                    		<input class="form-control" type="text" placeholder="<?=$this->lang['realadd'];//請填寫正確地址?>" name="address" id="address" required >
                                    	</div>
                                	</div>
                            	</div>
                            </div>

	                        <div class="form-group w150">
                                <?=$this->lang['accconfig'];//帳戶設定?>
                                <div class="control-box">
                                    <div class="input-group">
                                        <div class="input-box">
                                            <i class="icon-id"></i>
                                            <label class="control-label"><?=$this->lang['bname'];//銀行名稱?></label>
                                			<input class="form-control" type="text" placeholder="<?=$this->lang['bname'];//銀行名稱?>" name="bank_name" required >
                                        </div>
                                       <div class="input-box">
                                            <i class="icon-id"></i>
                                            <label class="control-label"><?=$this->lang['accountname'];//帳戶名稱?></label>
                                			<input class="form-control" type="text" placeholder="<?=$this->lang['accountname'];//帳戶名稱?>" name="bank_account_name" required">
                                    	</div>
                                       <div class="input-box">
                                            <i class="icon-id"></i>
                                            <label class="control-label"><?=$this->lang['bacc'];//銀行帳號?></label>
                                			<input class="form-control" type="text" placeholder="<?=$this->lang['bacc'];//銀行帳號?><?=$this->lang['inputnum'];//(請輸入數字)?>" name="bank_account" required onKeyUp="value=value.replace(/[^0-9]/g,'')">
                                    	</div>
                                	</div>
                            	</div>
                            </div>
							<div class="form-group checbox">
		                        <input type="checkbox" name="agree" id="agree" />
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
  padding: 5px 10px 5px 150px;
}
</style>
<script>
<? if($_SESSION['RT']['countory']!=''):?>
    sel_area(<?=$_SESSION['RT']['city']?>,<?=$_SESSION['RT']['countory']?>,'countory');
<? endif;?>
function check_form(frm){
    if(frm.elements['country'].value=='0'){
        alert("請選擇國家地區");
        frm.elements['country'].focus();
        return false;   
    }
    else if(frm.elements['city'].value=='0'){
        alert("請選擇省份城市");
        frm.elements['city'].focus();
        return false;   
    }
    else if(frm.elements['countory'].value=='0'){
        alert("請選擇地級市鄉鎮地區");
        frm.elements['countory'].focus();
        return false;   
    }
    else
        return true;    
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
      	  $('select[name=country]').val(json.country);
          $('select[name=city] option').remove();
          $('select[name=city]').prepend("<option value='"+json.city_id+"'>"+json.city+"</option>");
          $('select[name=countory] option').remove();
          $('select[name=countory]').prepend("<option value='"+json.countory_id+"'>"+json.countory+"</option>");
          $('#address').val(json.address);
      }
    });
  });
</script>
