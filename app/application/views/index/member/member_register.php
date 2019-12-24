<script src="/js/myjava/region.js"></script>
<div class="container center">
	<form action="/member_register" class="j-forms" method="post" onsubmit="return check_form(this)" )>
		<input type="hidden" name="PID" value="<?=$upline_by_id?>">
		<section class="content">
			<div class="title">
				<?=$this->lang['regidter'];//註冊會員?>
			</div>
			<div class="editor mg">
				<div class="form-box">
					<div class="form-group">
						<?php
							// 這裡放 Terms of us
							echo $registerDesc;
						?>
					</div>
					<div class="form-group">
						<div class="control-box">
							<i class="icon-id"></i>
							<label class="control-label"><span>*</span>
								<?=$this->lang['account'];//帳號?></label>
							<input class="form-control"  onKeyUp="value=value.replace(/[^\d]/g,'')" type="text" name="d_account" value="<?=$_SESSION['RT']['d_account']?>">
						</div>
					</div>
					<div class="form-group">
						<div class="control-box">
							<i class="icon-lock"></i>
							<label class="control-label"><span>*</span>
								<?=$this->lang['password'];//密碼?></label>
							<input class="form-control" onkeyup="value=value.replace(/[\W]/g,'') " type="password" name="by_pw" placeholder="<?=$this->lang['pwdfive']?>">
						</div>
					</div>
					<div class="form-group">
						<div class="control-box">
							<i class="icon-lock"></i>
							<label class="control-label"><span>*</span>
								<?=$this->lang['confirm_pw'];//確認密碼?></label>
							<input class="form-control" onkeyup="value=value.replace(/[\W]/g,'') " type="password" name="confirm_pw">
						</div>
					</div>
					<div class="form-group">
						<div class="control-box">
							<i class="icon-cake"></i>
							<label class="control-label"><span>*</span>
								<?=$this->lang['brithday'];//生日?></label>
							<input class="form-control bar_content date-object birthday" type="text" name="birthday" id="d_birthday" value="<?=$_SESSION['RT']['birthday']?>" autocomplete="off" onKeyUp="value=value.replace(/[^\d]/g,'')" readonly>
						</div>
						<div class="control-box">
							<i class="icon-name"></i>
							<label class="control-label"><span>*</span>
								<?=$this->lang['dname'];//姓名?></label>
							<input class="form-control" type="text" name="name" value="<?=$_SESSION['RT']['name']?>">
						</div>
						<div class="control-box">
							<i class="icon-cake"></i>
							<label class="control-label"><span>*</span>
								<?=$this->lang['email'];//Email?></label>
							<input class="form-control" type="text" name="by_email" value="<?=$_SESSION['RT']['by_email']?>">
						</div>
						<div class="control-box">
							<i class="icon-placeholder"></i>
							<label class="control-label">
								<?=$this->lang['country'];//請選擇國家?></label>
								<select name="country" id="country" class="form-control">
								<option value=""> </option>
								<?foreach ($country as $cvalue):?>
								<option value="<?=$cvalue['s_id']?>" <?=($_SESSION['RT']['country']==$cvalue['s_id'])?'selected':'';?>>
									<?=$cvalue['s_name']?>
								</option>
								<? endforeach;?>
							</select>
						</div>
						<div class="form-group">
						<div class="control-box">
							<i class="icon-placeholder"></i>
							<label class="control-label">
								<?=$this->lang['address'];//地址?></label>
							<input class="form-control" type="text" name="address" value="<?=$_SESSION['RT']['address']?>">
						</div>
						<div class="control-box">
							<i class="icon-phone-call"></i>
							<label class="control-label">
								<?=$this->lang['phone'];//電話?></label>
							<input class="form-control" type="text" maxlength="11" name="telphone" onKeyUp="value=value.replace(/[^\d]/g,'')" value="<?=$_SESSION['RT']['telphone']?>">
						</div>

						<div class="control-box">
							<i class="icon-share2"></i>
							<label class="control-label">
								<?=$this->lang['content'];//會員註冊說明?>會員註冊說明</label><br>
								<textarea class="control-box" rows="6" cols="60" name="d_content" id="d_content" style="width:100%;"><?php echo $_SESSION['RT']['_content'];?></textarea>
						</div>
					</div>
					<div class="form-group">

						<div class="form-group checbox">
							<input type="checkbox" name="chk_ok" value="ok" id="checkbox">
							<label for="checkbox">
								<?=$this->lang['iread'];//我已詳閱?>
								<a href="/gold/policies/service" class="fancybox-share">
									<?=$this->lang['msevice'];//會員服務條款?></a>
								<?=$this->lang['and'];//和?>
								<a href="/gold/policies/privacy" class="fancybox-share">
									<?=$this->lang['privacy'];//隱私權政策?></a>
							</label>
						</div>
						<div class="form-group checbox">
							<input type="checkbox" name="d_service" value="Y" id="checkbox2" checked>
							<label for="checkbox2"><?php echo $this->lang['getService'];?></label>
						</div>

						<div class="pagination_box">
							<input type="hidden" name="dbname" value="<?=$dbname?>">
							<input type="hidden" name="member_register" value="yes">
							<input type="reset" class="btn simple" value="<?=$this->lang['s_restart'];//重填?>">
							<input type="submit" class="btn simple bg2" value="<?=$this->lang['s_send'];//送出?>">
						</div>
					</div>
				</div>
			</div>
		</section>
	</form>
</div>
</main>
<style>
	.j-forms {
		width: 100%;
	}

	.form-box .form-control {
		background: #e7e7e7;
		color: #666;
	}

</style>
<script>
	<?php if(!empty($_SESSION['RT']['country']) and !empty($_SESSION['RT']['city']) and !empty($_SESSION['RT']['countory'])){?>
    sel_area(<?=$_SESSION['RT']['country']?>,<?=$_SESSION['RT']['city']?>,'city');
    sel_area(<?=$_SESSION['RT']['city']?>,<?=$_SESSION['RT']['countory']?>,'countory');
<?php }?>
function check_form(frm)
{
	if(frm.elements['country_num'].value==886){
		re = /^[09]{2}[0-9]{8}$/;
	}else{
	var re = /^\d{8,11}$/;
	}
	var rezip = /^\d{3,6}$/;
	var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(frm.elements['d_account'].value==''){
        alert("<?=$this->lang['plsacc'];//請輸入帳號?>");
        frm.elements['d_account'].focus();
        return false;
    }
    else if(frm.elements['by_pw'].value==''){
        alert("<?=$this->lang['plspwd'];//請輸入密碼?>");
        frm.elements['by_pw'].focus();
        return false;
    }else if((frm.elements['by_pw'].value).length<6 || (frm.elements['by_pw'].value).length>12){
        alert("<?=$this->lang['pwdfive'];//密碼請輸入6-12碼?>");
        frm.elements['by_pw'].focus();
        return false;
    }else if(frm.elements['confirm_pw'].value==''){
    	alert("<?=$this->lang['plsconfirmpwd'];//請輸入確認密碼?>");
        frm.elements['confirm_pw'].focus();
        return false;
    }else if(frm.elements['by_pw'].value != '' && frm.elements['confirm_pw'].value != '' && (frm.elements['by_pw'].value != frm.elements['confirm_pw'].value)){
    	alert("<?=$this->lang['confirmpassworong'];//確認密碼不符合?>");
        frm.elements['confirm_pw'].focus();
        return false;
//    }else if((frm.elements['nickname'].value).length>10){
//        alert("<?=$this->lang['upto10'];//暱稱最多十個字?>");
//        frm.elements['nickname'].focus();
//        return false;
    }else if(frm.elements['name'].value==''){
        alert("<?=$this->lang['plsname'];//請輸入姓名?>");
        frm.elements['name'].focus();
        return false;
    }else if(typeof($("input[name=sex]:checked").val()) === "undefined" ){
        alert("<?=$this->lang['plssex'];//請選擇性別?>");
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
    }else if(frm.elements['country'].value==''){
        alert("<?=$this->lang['country'];//請選擇地區?>");
        frm.elements['country'].focus();
        return false;
    }else if(frm.elements['country'].value==''){
        alert("<?=$this->lang['country'];//請選擇省分城市?>");
        frm.elements['country'].focus();
        return false;
    }else if(frm.elements['countory'].value==''){
        alert("<?=$this->lang['county'];//請選擇鄉鎮地區?>");
        frm.elements['countory'].focus();
        return false;
    }else if(frm.elements['address'].value==''){
        alert("<?=$this->lang['plsadd'];//請輸入完整地址?>");
        frm.elements['address'].focus();
        return false;
    }else if(frm.elements['birthday'].value==''){
        alert("<?=$this->lang['plsday'];//請輸入正確日期?>");
        frm.elements['birthday'].focus();
        return false;
    }else if(frm.elements['by_email'].value==''||(!regex.test(frm.elements['by_email'].value))){
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

$(function() {
	$('.fancybox-share').fancybox({
		margin: 5,
		padding: 0,
		width: '100%',
		maxWidth: 650,
		type: 'iframe',
		wrapCSS: 'search',
			beforeShow: function(){
				$("body").css({'overflow-y':'hidden'});
			},
			afterClose: function(){
				$("body").css({'overflow-y':'visible'});
			},
		helpers : {
			overlay : {
			    css : {
			        'background' : 'rgba(0,0,0,0.8)'
			    }
			}
		}
	});

	$(document).tooltip();

	$("#countory").on('change', function() {
		var s_id = $("#countory").val();
		$.ajax({
			url:'/member/getZipCodeBySid',
			type:'POST',
			data: 's_id='+s_id,
			success: function(result)
			{
    			$('#zip').val(result);
			}
		});
	});
});
</script>

<link href="/js/admin_sys/jquery-ui_1_11_2/css/jquery-ui.css" rel="stylesheet" type="text/css" />
<script src="/js/admin_sys/jquery-ui_1_11_2/jquery-ui.js"></script>
<script src="/js/admin_sys/jquery-ui_1_11_2/lang/datepicker-zh-TW.js"></script>
<script>
	//$(".date-object").datepicker({dateFormat: "yy-mm-dd",yearRange :"c-100:c+0",maxDate : "+0d"});//生日時間"年"份軸
	$(".date-object").datepicker({
		dateFormat: "yy-mm-dd",
		yearRange: "c-100:c+100",
		maxDate: "+0d"
	}); //生日時間"年"份軸

</script>

<script src="/js/handle_address.js"></script>
