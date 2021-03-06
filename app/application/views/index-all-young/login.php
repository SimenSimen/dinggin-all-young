<div class="container">
	<main class="main-content wow fadeInUp" data-wow-delay="0.4s">
		<div class="container-indent center">
			<form action="<?= base_url('member/login') ?>" class="j-forms" method="post">
				<section class=" content c_green02H">
					<div class="title"><?= $lang['login'] ?></div>

					<div class="editor mg" name="loginbox">
						<div class="form-box">
							<div class="form-group">
								<div class="control-box">
									<i name="icon02" class="icon-id"></i>
									<label class="control-label"><?= $lang['account'] ?></label>
									<input class="form-control" type="text" placeholder="" name="d_account" value="" required>
								</div>
							</div>
							<div class="form-group">
								<div class="control-box">
									<i name="icon02" class="icon-lock"></i>
									<label class="control-label"><?= $lang['password'] ?></label>
									<input class="form-control" type="password" placeholder="<?= $lang['worderror'] ?>" name="password" value="" maxlength="16" required>
								</div>
							</div>
							<div class="form-group checbox">
								<input type="checkbox" name="remember" value="1" id="checkbox"></label>
								<label for="checkbox"><?= $lang['remember'] ?></label>
							</div>

							<input type="submit" class="btn normal send b_green02" value="<?= $lang['login'] ?>">
							<p align="center"><a href="<?= base_url('register') ?>" class=""><?= $lang['regidter'] ?></a> / <a href="<?= base_url('forget_pass') ?>" class=""><?= $lang['fotget'] ?></a></p>

						</div>
					</div>
				</section>
			</form>
		</div>
	</main>
</div>