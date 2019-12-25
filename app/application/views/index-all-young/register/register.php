<div class="container">
    <main class="main-content wow fadeInUp" data-wow-delay="0.4s">
        <div class="container-indent center">
            <form action="<?= base_url('member_register') ?>" class="j-forms" method="post" onsubmit="return check_form(this)" )>
                <input type="hidden" name="PID" value="4">
                <section class="content">
                    <div class="title">Registered</div>

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
                                    <label class="control-label"><span>*</span>Account</label>
                                    <input class="form-control" type="text" name="d_account" value="" placeholder="Enter mobile number">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="control-box">
                                    <i name="icon02" class="icon-lock"></i>
                                    <label class="control-label"><span>*</span>Password</label>
                                    <input class="form-control" type="password" name="by_pw" placeholder="Please enter 6-12 yards for the password.">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="control-box">
                                    <i name="icon02" class="icon-lock"></i>
                                    <label class="control-label"><span>*</span>Confirm Password</label>
                                    <input class="form-control w200" type="password" name="confirm_pw">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="control-box">
                                    <i name="icon02" class="icon-name"></i>
                                    <label class="control-label"><span>*</span>Name</label>
                                    <input class="form-control" type="text" name="name" value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="control-box">
                                    <i name="icon02" class="icon-cake"></i>
                                    <label class="control-label"><span>*</span>Birthday</label>
                                    <input class="form-control bar_content date-object birthday" type="text" name="birthday" id="d_birthday" value="" autocomplete="off" onKeyUp="value=value.replace(/[^\d]/g,'')" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="control-box">
                                    <i name="icon02" class="icon-mail"></i>
                                    <label class="control-label"><span>*</span>E-mail</label>
                                    <input class="form-control" type="text" name="by_email" value="">
                                </div>
                                <div class="form-group checbox c_green02H">
                                    <input type="checkbox" name="chk_ok" value="ok" id="checkbox">
                                    <label for="checkbox">I have read the
                                        <a href="_inni_note-service.php" class="fancybox-share">Member Terms of Service</a>
                                        and <a href="_inni_note-privacy.php" class="fancybox-share">Privacy Policy</a>
                                    </label>
                                </div>
                                <div class="form-group checbox">
                                    <input type="checkbox" name="chk_sale_ok" value="ok" id="checkbox02">
                                    <label for="checkbox">Agree to receive offers</label>
                                </div>
                                <div class="pagination_box">
                                    <input type="hidden" name="dbname" value="buyer">
                                    <input type="hidden" name="member_register" value="yes">
                                    <input type="reset" class="btn simple" value="Refill">
                                    <input type="submit" class="btn simple bg2 b_green" value="Next">
                                </div>
                            </div>

                        </div>
                    </div>
                </section>
            </form>
        </div>
    </main>
</div>