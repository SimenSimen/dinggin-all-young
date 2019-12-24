<script src="/js/myjava/region.js"></script>
<div class="container center">
	<form action="/providers/store" class="j-forms" method="POST" id="form" onsubmit="return false;">
		<section class="content">
			<div class="title">
				<?=$this->lang['provider_register'];//註冊會員?>
			</div>
			<div style="font-size: 1rem;font-weight: bold;text-align: center;">
				填表日期：<span><?=$now_at?></span>
			</div>
			<div class="editor mg">
				<div class="form-box">

                    <div class="form-group w-100 float-left">
                        <span style="font-size: 1rem;font-weight: bold;"><?=$this->lang['provider_information'];//廠商資訊?></span>
                        <div class="control-box">
                            <div class="input-group">
                                <div class="input-box float-left w-100">
                                    <i class="fa fa-building-o fa-fw"></i>
                                    <label class="control-label"><span>*</span><?=$this->lang['p_cn_name'];//廠商名稱（中文）?></label>
                        			<input class="form-control" type="text" id="chinese_name">
                                </div>
                                <div class="input-box float-left w-100">
                                    <i class="fa fa-building-o fa-fw"></i>
                                    <label class="control-label"><span>*</span><?=$this->lang['p_en_name'];//廠商名稱（英文）?></label>
                        			<input class="form-control" type="text" id="english_name">
                                </div>
                               	<div class="input-box float-left w-50 left">
                                    <i class="fa fa-credit-card fa-fw"></i>
                                    <label class="control-label"><span>*</span><?=$this->lang['GUI_number'];//統一編號?></label>
                        			<input class="form-control" type="text" id="tax_id">
                            	</div>
                               	<div class="input-box float-left w-50 right">
                               		<i class="fa fa-user fa-fw"></i>
                                    <label class="control-label"><span>*</span><?=$this->lang['responsible_person'];//負責人?></label>
                        			<input class="form-control" type="text" id="principal">
                            	</div>
                               	<div class="input-box float-left w-50 left">
                                    <i class="fa fa-phone fa-fw"></i>
                                    <label class="control-label"><span>*</span><?=$this->lang['phone'];//電話?></label>
                        			<input class="form-control" type="text" id="phone">
                            	</div>
                               	<div class="input-box float-left w-50 right">
                                    <i class="fa fa-fax fa-fw"></i>
                                    <label class="control-label"><span>*</span><?=$this->lang['fax'];//傳真?></label>
                        			<input class="form-control" type="text" id="fax">
                            	</div>
                                <div class="input-box float-left w-100">
                                    <i class="fa fa-map-marker fa-fw"></i>
                                    <label class="control-label"><span>*</span><?=$this->lang['provider_add'];//登記地址?></label>
                        			<input class="form-control" type="text" id="registration_address">
                                </div>
                                <div class="input-box float-left w-100">
                                    <i class="fa fa-map-marker fa-fw"></i>
                                    <label class="control-label"><span>*</span><?=$this->lang['contact_add'];//聯絡地址?></label>
                        			<input class="form-control" type="text" id="contact_address">
                                </div>
                                <div class="input-box float-left w-100">
                                    <i class="fa fa-laptop fa-fw"></i>
                                    <label class="control-label"><span>*</span><?=$this->lang['website'];//公司網址?></label>
                        			<input class="form-control" type="text" id="website">
                                </div>
                               	<div class="input-box float-left w-50 left">
                                    <i class="fa fa-calendar fa-fw"></i>
                                    <label class="control-label"><span>*</span><?=$this->lang['create_date'];//設立日期?></label>
                        			<input class="form-control date-object" type="text" id="found_date">
                            	</div>
                               	<div class="input-box float-left w-50 right">
                                    <i class="fa fa-bar-chart fa-fw"></i>
                                    <label class="control-label"><span>*</span><?=$this->lang['capital'];//資本額?></label>
                        			<input class="form-control" type="text" id="capital_amount">
                            	</div>
                                <div class="input-box float-left w-100">
                                    <i class="fa fa-newspaper-o fa-fw"></i>
                                    <label class="control-label"><span>*</span><?=$this->lang['reg_certificate'];//營利事業登記證影本?></label>
                        			<input class="form-control"  type="file" id="registration_certificate" accept="image/jpeg,application/pdf" multiple>
                                </div>
                            </div>
                    	</div>
                    </div>
                    <hr class="float-left w-100 float-left">
                    <div class="form-group w-100">
                        <span style="font-size: 1rem;font-weight: bold;"><?=$this->lang['contact_information'];//聯絡人資訊?></span>
                        <div class="control-box">
                            <div class="input-group">
                                <div class="input-box float-left w-50 left">
                                    <i class="icon-id"></i>
                                    <label class="control-label"><span>*</span><?=$this->lang['contact_person'];//聯絡人?></label>
                        			<input class="form-control" type="text" id="contact_person_name">
                                </div>
                                <div class="input-box float-left w-50 right">
                                    <i class="icon-name"></i>
                                    <label class="control-label"><span>*</span><?=$this->lang['position'];//職稱?></label>
                        			<input class="form-control" type="text" id="contact_person_job">
                                </div>
                               <div class="input-box float-left w-50 left">
                                    <i class="icon-phone"></i>
                                    <label class="control-label"><span>*</span><?=$this->lang['contact_phone'];//聯絡電話?></label>
                        			<input class="form-control" type="text" id="contact_person_phone">
                            	</div>
                               <div class="input-box float-left w-50 right">
                                    <i class="icon-phone-call"></i>
                                    <label class="control-label"><span>*</span><?=$this->lang['contact_cell'];//行動電話?></label>
                        			<input onkeyup="value=value.replace(/[^\d]/g,'') " class="form-control" type="text" id="contact_person_mobile">
                            	</div>
                               <div class="input-box float-left w-100">
                                    <i class="icon-mail"></i>
                                    <label class="control-label"><span>*</span><?=$this->lang['mail'];//電子郵件?></label>
                        			<input class="form-control" type="text" id="contact_person_email">
                            	</div>
                        	</div>
                    	</div>
                    </div>
                    <hr class="float-left w-100 float-left">
                    <div class="form-group w-100">
                        <span style="font-size: 1rem;font-weight: bold;"><?=$this->lang['financial_institution'];//收款金融機構資訊?></span>
                        <div class="control-box">
                            <div class="input-group">
                                <div class="input-box float-left w-50 left">
                                    <i class="fa fa-university"></i>
                                    <label class="control-label"><span>*</span><?=$this->lang['bank'];//收款銀行?></label>
                        			<input class="form-control" type="text" id="bank_name">
                                </div>
                                <div class="input-box float-left w-50 right">
                                    <i class="fa fa-building"></i>
                                    <label class="control-label"><span>*</span><?=$this->lang['branch'];//分行名稱?></label>
                        			<input class="form-control" type="text" id="bank_branch">
                                </div>
                               	<div class="input-box float-left w-50 left">
                                    <i class="fa fa-check-circle-o"></i>
                                    <label class="control-label"><span>*</span><?=$this->lang['code'];//銀行代碼?></label>
                        			<input class="form-control" type="text" id="bank_id">
                            	</div>
                               	<div class="input-box float-left w-50 right">
                                    <i class="fa fa-user"></i>
                                    <label class="control-label"><span>*</span><?=$this->lang['id'];//帳號?></label>
                        			<input onkeyup="value=value.replace(/[^\d]/g,'') " class="form-control" type="text" id="bank_account">
                            	</div>
                               	<div class="input-box float-left w-50 left">
                                    <i class="fa fa-calendar"></i>
                                    <label class="control-label"><span>*</span><?=$this->lang['closing_date'];//結帳日?></label>
                        			<input class="form-control date-object" type="text" id="checkout_date">
                            	</div>
                               	<div class="input-box float-left w-50 right">
                                    <i class="fa fa-money"></i>
                                    <label class="control-label"><span>*</span><?=$this->lang['payway'];//付款條件?></label>
                        			<input class="form-control" type="text" id="pay_condition">
                            	</div>
                                <div class="input-box float-left w-100">
                                    <i class="fa fa-credit-card"></i>
                                    <label class="control-label"><span>*</span><?=$this->lang['bankbook'];//存摺封面影本?></label>
                        			<input class="form-control"  type="file" id="passbook" id="passbook" accept="image/jpeg">
                                </div>
                        	</div>
                    	</div>
                    </div>

					<div class="pagination_box">
						<input type="reset" class="btn simple" value="<?=$this->lang['s_restart'];//重填?>">
						<input type="submit" class="btn simple bg2" id="send" value="<?=$this->lang['s_send'];//送出?>">
					</div>
				</div>
			</div>
		</section>
	</form>
</div>
</main>
<style type="text/css">
	.float-left{
		float: left;
	}
	.w-100{
		width: 100%;
	}
	.w-50{
		width: 49.5%;
	}
	.w-50.left{
		margin-right: 0.5%;
	}
	.w-50.right{
		margin-left: 0.5%;
	}
	.control-box i {
	    position: relative;
	    left: 18px;
	    top: 6px;
	    font-size: 16px;
	    color: #828282;
	}
	.j-forms {
		width: 100%;
	}
	.form-box .form-control {
		background: #e7e7e7;
		color: #666;
	}
	@media screen and (max-width: 624px) {
		.w-50{
			width: 100%;
		}
		.w-50.left{
			margin-right: 0;
		}
		.w-50.right{
			margin-left: 0;
		}
	}
</style>

<script>
const check_form = () => {
    if($('#chinese_name').val()==''){
        alert("請輸入<?=$this->lang['p_cn_name'];//廠商名稱（中文）?>");
        $('#chinese_name').focus();  
        return false;
    }
    else if($('#english_name').val()==''){
        alert("請輸入<?=$this->lang['p_en_name'];//廠商名稱（英文）?>");
        $('#english_name').focus();  
        return false;
    }
    else if($('#tax_id').val()==''){
        alert("請輸入<?=$this->lang['GUI_number'];//統一編號?>");
        $('#tax_id').focus();  
        return false;
    }
    else if($('#principal').val()==''){
        alert("請輸入<?=$this->lang['responsible_person'];//負責人?>");
        $('#principal').focus();  
        return false;
    }
    else if($('#phone').val()==''){
        alert("請輸入<?=$this->lang['phone'];//電話?>");
        $('#phone').focus();  
        return false;
    }
    else if($('#fax').val()==''){
        alert("請輸入<?=$this->lang['fax'];//傳真?>");
        $('#fax').focus();  
        return false;
    }
    else if($('#registration_address').val()==''){
        alert("請輸入<?=$this->lang['provider_add'];//登記地址?>");
        $('#registration_address').focus();  
        return false;
    }
    else if($('#contact_address').val()==''){
        alert("請輸入<?=$this->lang['contact_add'];//聯絡地址?>");
        $('#contact_address').focus();  
        return false;
    }
    else if($('#website').val()==''){
        alert("請輸入<?=$this->lang['website'];//公司網址?>");
        $('#website').focus();  
        return false;
    }
    else if($('#found_date').val()==''){
        alert("請輸入<?=$this->lang['create_date'];//設立日期?>");
        $('#found_date').focus();  
        return false;
    }
    else if($('#capital_amount').val()==''){
        alert("請輸入<?=$this->lang['capital'];//資本額?>");
        $('#capital_amount').focus();  
        return false;
    }
    else if($('#registration_certificate').val()==''){
        alert("請上傳<?=$this->lang['reg_certificate'];//營利事業登記證影本?>");
        $('#registration_certificate').focus();  
        return false;
    }
    else if($('#contact_person_name').val()==''){
        alert("請輸入<?=$this->lang['contact_person'];//聯絡人?>");
        $('#contact_person_name').focus();  
        return false;
    }
    else if($('#contact_person_job').val()==''){
        alert("請輸入<?=$this->lang['position'];//職稱?>");
        $('#contact_person_job').focus();  
        return false;
    }
    else if($('#contact_person_phone').val()==''){
        alert("請輸入<?=$this->lang['contact_phone'];//聯絡電話?>");
        $('#contact_person_phone').focus();  
        return false;
    }
    else if($('#contact_person_mobile').val()==''){
        alert("請輸入<?=$this->lang['contact_cell'];//行動電話?>");
        $('#contact_person_mobile').focus();  
        return false;
    }
    else if($('#contact_person_email').val()==''){
        alert("請輸入<?=$this->lang['mail'];//電子郵件?>");
        $('#contact_person_email').focus();  
        return false;
    }
    else if(IsEmail($('#contact_person_email').val())){
        alert("請輸入正確<?=$this->lang['mail'];//電子郵件?>格式");
        $('#contact_person_email').focus();  
        return false;
    }
    else if($('#bank_name').val()==''){
        alert("請輸入<?=$this->lang['bank'];//收款銀行?>");
        $('#bank_name').focus();  
        return false;
    }
    else if($('#bank_branch').val()==''){
        alert("請輸入<?=$this->lang['branch'];//分行名稱?>");
        $('#bank_branch').focus();  
        return false;
    }
    else if($('#bank_id').val()==''){
        alert("請輸入<?=$this->lang['code'];//銀行代碼?>");
        $('#bank_id').focus();  
        return false;
    }
    else if($('#bank_account').val()==''){
        alert("請輸入<?=$this->lang['id'];//帳號?>");
        $('#bank_account').focus();  
        return false;
    }
    else if($('#checkout_date').val()==''){
        alert("請輸入<?=$this->lang['closing_date'];//結帳日?>");
        $('#checkout_date').focus();  
        return false;
    }
    else if($('#pay_condition').val()==''){
        alert("請輸入<?=$this->lang['payway'];//付款條件?>");
        $('#pay_condition').focus();  
        return false;
    }
    else if($('#passbook').val()==''){
        alert("請上傳<?=$this->lang['bankbook'];//存摺封面影本?>");
        $('#passbook').focus();  
        return false;
    }
    else if (isNaN($('#capital_amount').val())) {
        alert('請輸入數字');
        $('#capital_amount').focus();
        return false;
    }
    return true;
}

$('#send').on('click', () => {
    if (check_form()) {
        const fileUploader = document.querySelector('#passbook');
        const registrationUploader = document.querySelector('#registration_certificate');
        const rawData = {
            chinese_name: $('#chinese_name').val(),
            english_name: $('#english_name').val(),
            tax_id: $('#tax_id').val(),
            principal: $('#principal').val(),
            phone: $('#phone').val(),
            fax: $('#fax').val(),
            registration_address: $('#registration_address').val(),
            contact_address: $('#contact_address').val(),
            website: $('#website').val(),
            found_date: $('#found_date').val(),
            capital_amount: $('#capital_amount').val(),
            registration_certificate: $('#registration_certificate').val(),
            contact_person_name: $('#contact_person_name').val(),
            contact_person_job: $('#contact_person_job').val(),
            contact_person_phone: $('#contact_person_phone').val(),
            contact_person_mobile: $('#contact_person_mobile').val(),
            contact_person_email: $('#contact_person_email').val(),
            bank_name: $('#bank_name').val(),
            bank_branch: $('#bank_branch').val(),
            bank_id: $('#bank_id').val(),
            bank_account: $('#bank_account').val(),
            checkout_date: $('#checkout_date').val(),
            pay_condition: $('#pay_condition').val()
        };
        let data = new FormData();
        for (i in rawData) {
            data.append(i, rawData[i])
        }
        data.append('passbook', fileUploader.files[0]);
        data.append('registration_certificate', registrationUploader.files[0]);

        $.ajax({
            url: '/providers/store',
            method: 'POST',
            data: data,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'JSON',
            success: response => {
                alert('申請成功！敬請等待審核結果');
                location.href = '/';
            },
            error: xhr => {
                let { responseJSON } = xhr;
                let { status } = xhr;

                switch (status) {
                    case 401:
                        alert('請重新登入');
                        location.href = '/gold/login';
                        break;
                    case 422:
                        if (responseJSON.message === 'tax_id has already exists') {
                            alert('統一編號已被註冊');
                        }
                        break;
                }
            }
        })
    }
})


const IsEmail = (email) => {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!regex.test(email)) {
        return true;
    } else {
        return false;
    }
}
$(function() {
	$(document).tooltip();
});
</script>

<link href="/js/admin_sys/jquery-ui_1_11_2/css/jquery-ui.css" rel="stylesheet" type="text/css" />
<script src="/js/admin_sys/jquery-ui_1_11_2/jquery-ui.js"></script>
<script src="/js/admin_sys/jquery-ui_1_11_2/lang/datepicker-zh-TW.js"></script>
<script>
	$(".date-object").datepicker({
		dateFormat: "yy-mm-dd",
		yearRange: "c-100:c+100",
		maxDate: "+0d"
	}); //生日時間"年"份軸

</script>

<script src="/js/handle_address.js"></script>
