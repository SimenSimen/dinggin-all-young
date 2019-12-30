<div class="container">
    <main class="main-content wow fadeInUp" data-wow-delay="0.4s">
        <div class="container-indent center">
            <form action="<?= base_url('member_register') ?>" class="j-forms" method="post" onsubmit="return check_form(this)" )>
                <input type="hidden" name="PID" value="<?= $upline_by_id ?>">
                <section class="content">
                    <div class="title"><?= $lang['regidter'] ?></div>

                    <div class="editor mg">
                        <div class="benefits">
                            <strong class="c_green">Event title!!!!</strong><br />
                            <span>Activity context 1</span>
                            <span>Activity context 2</span>
                            <span>Activity context 3</span>
                        </div>
                        <div class="form-box">
                            <div class="form-group">

                            </div>
                            <div class="form-group">
                                <div class="control-box">
                                    <i name="icon02" class="icon-id"></i>
                                    <label class="control-label"><span>*</span><?= $lang['account'] ?></label>
                                    <input class="form-control" type="text" name="d_account" value="" placeholder="<?= $lang['input_mobile'] ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="control-box">
                                    <i name="icon02" class="icon-lock"></i>
                                    <label class="control-label"><span>*</span><?= $lang['password'] ?></label>
                                    <input class="form-control" type="password" name="by_pw" placeholder="<?= $lang['pwdfive'] ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="control-box">
                                    <i name="icon02" class="icon-lock"></i>
                                    <label class="control-label"><span>*</span><?= $lang['confirm_pw'] ?></label>
                                    <input class="form-control w200" type="password" name="confirm_pw" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="control-box">
                                    <i name="icon02" class="icon-name"></i>
                                    <label class="control-label"><span>*</span><?= $lang['dname'] ?></label>
                                    <input class="form-control" type="text" name="name" value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="control-box">
                                    <i name="icon02" class="icon-cake"></i>
                                    <label class="control-label"><span>*</span><?= $lang['brithday'] ?></label>
                                    <input class="form-control bar_content date-object birthday" type="text" name="birthday" id="d_birthday" value="" autocomplete="off" onKeyUp="value=value.replace(/[^\d]/g,'')" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="control-box">
                                    <i name="icon02" class="icon-mail"></i>
                                    <label class="control-label"><span>*</span><?= $lang['plsmail'] ?></label>
                                    <input class="form-control" type="text" name="by_email" value="" required>
                                </div>
                                <div class="form-group checbox c_green02H">
                                    <input type="checkbox" name="chk_ok" value="ok" id="checkbox" required>
                                    <label for="checkbox"><?= $lang['iread'] ?>
                                        <a href="_inni_note-service.php" class="fancybox-share"><?= $lang['msevice'] ?></a>
                                        <?= $lang['and'] ?> <a href="_inni_note-privacy.php" class="fancybox-share"><?= $lang['privacy'] ?></a>
                                    </label>
                                </div>
                                <div class="form-group checbox">
                                    <input type="checkbox" name="d_service" value="1" id="checkbox02">
                                    <label for="checkbox"><?= $lang['receive_offers'] ?></label>
                                </div>
                                <div class="pagination_box">
                                    <input type="hidden" name="dbname" value="buyer">
                                    <input type="hidden" name="member_register" value="yes">
                                    <input type="reset" class="btn simple" value="<?= $lang['refill'] ?>">
                                    <input type="submit" class="btn simple bg2 b_green" value="<?= $lang['next'] ?>">
                                </div>
                            </div>

                        </div>
                    </div>
                </section>
            </form>
        </div>
    </main>
</div>