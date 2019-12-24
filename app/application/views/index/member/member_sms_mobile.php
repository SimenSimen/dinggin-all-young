<script src="/js/myjava/region.js"></script>
<div class="container center">
	<form action="/sms_mobile" class="j-forms" method="post" onsubmit="return check_form(this)")>
		<input type="hidden" name="action" value="check_code">
		<section class="content">
			<div class="title"><?=$this->lang['regidter'];//簡訊驗證?></div>
			<div class="editor mg">
				<div class="form-box">
					<div class="form-group">
						<div class="control-box">
							<i class="icon-id"></i> <label class="control-label"><?=$this->lang['account'];//簡訊驗證碼?></label>
							<input class="form-control" onKeyUp="value=value.replace(/[^\d]/g,'')" type="text" name="check_code" value="">
						</div>
					</div>
					<div class="pagination_box">
						<input type="reset" class="btn simple" value="<?=$this->lang['s_restart'];//重填?>">
						<input type="submit" class="btn simple bg2" value="<?=$this->lang['s_send'];//送出?>">
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
function check_form(frm)
{
        return true;
}

</script>

<link href="/js/admin_sys/jquery-ui_1_11_2/css/jquery-ui.css" rel="stylesheet" type="text/css" />
<script src="/js/admin_sys/jquery-ui_1_11_2/jquery-ui.js"></script>
<script src="/js/admin_sys/jquery-ui_1_11_2/lang/datepicker-zh-TW.js"></script>
<script src="/js/handle_address.js"></script>
