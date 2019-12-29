<div class="container">
	<main class="main-content wow fadeInUp" data-wow-delay="0.4s">
		<div class="container-indent center">
			<form action="<?= base_url('member_sms_code') ?>" method="post" class="j-forms">
				<input type="hidden" name="action" value="check_code">
				<section class="content">
					<div class="title"><?= $this->lang1['sms_valid'] ?></div>
					<div class="editor mg">
						<div class="form-box">
							<div class="form-group">
								<div class="control-box02">
									<label class="control-label"><?= $this->lang1['sms_code_is'] ?></label>
									<input class="form-control" type="text" name="check_code">
								</div>
							</div>

							<div class="pagination_box">
								<input type="hidden" name="dbname" value="buyer">
								<input type="hidden" name="member_register" value="yes">
								<input type="reset" class="btn simple" value="<?= $this->lang1['refill'] ?>">
								<input type="submit" class="btn simple bg2 b_green" value="<?= $this->lang1['send_out'] ?>">
							</div>
						</div>

					</div>
				</section>
			</form>
		</div>
	</main>
</div>