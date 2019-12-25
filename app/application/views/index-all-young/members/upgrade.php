<div id="tt-pageContent" class="main-content ">
    <div class="container-indent">
        <div class="container">

            <main class="main-content">
                <div class="container openside pall0">

                    <?php $this->load->view($indexViewPath . '/members/_sidenav'); ?>

                    <form action="<?= base_url('member/upgrade/submit') ?>" class="" method="post" onsubmit="">
                        <section class="content has-side">
                            <div class="title">Upgrade Management Member</div>
                            <div class="editor mg">
                                <div class="form-box">

                                    <div class="managemenbox">

                                        <div class="form-group name">
                                            <i name="icon02" class="icon-genders"></i> <label class="control-label">Identity</label>
                                            <div class="control-box">
                                                <div class="radio-box">
                                                    <label class="form-radio checked"><input type="radio" name="identity" checked="" value="General"> General</label>
                                                    <label class="form-radio"><input type="radio" name="identity" value="Legal Person">Legal Person</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="control-box">
                                                <i name="icon02" class="icon-name"></i>
                                                <label class="control-label">Identity Card Number</label>
                                                <input class="form-control w200" type="text" maxlength="10" name="identity_num" value="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="managemenbox">
                                        <p>Account Settings</p>

                                        <div class="form-group">
                                            <div class="control-box">
                                                <i name="icon02" class="icon-id"></i>
                                                <label class="control-label"><span>*</span>Bank Name</label>
                                                <input class="form-control w200" type="text" name="bank_name" value="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="control-box">
                                                <i name="icon02" class="icon-id"></i>
                                                <label class="control-label"><span>*</span>Branch Bank</label>
                                                <input class="form-control w200" type="text" name="" value="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="control-box">
                                                <i name="icon02" class="icon-id"></i>
                                                <label class="control-label"><span>*</span>Account Title</label>
                                                <input class="form-control w200" type="text" name="" value="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="control-box">
                                                <i name="icon02" class="icon-id"></i>
                                                <label class="control-label"><span>*</span>Bank Account</label>
                                                <input class="form-control w200" type="text" name="bank_account" value="">
                                            </div>
                                        </div>

                                        <div class="form-group name">
                                            <i name="icon02" class="icon-genders"></i> <label class="control-label">Identity</label>
                                            <div class="control-box">
                                                <div class="radio-box">
                                                    <label class="form-radio checked">
                                                        <input type="radio" name="" checked=""> General
                                                    </label>
                                                    <label class="form-radio">
                                                        <input type="radio" name=""> Legal Person
                                                    </label>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="managemenbox">
                                            <div class="form-group">
                                                <div class="control-box">
                                                    <div class="radio-box">
                                                        <label class="form-radio checked">
                                                            <input type="radio" name="" value="tax-free"> Tax-Free Card
                                                        </label>
                                                        <label class="form-radio" style="margin-left:20px;">
                                                            <input type="radio" name="" value="tax"> Tax Card
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="control-box">
                                                    <input class="form-control form-control03" type="text" name="" id="tax-number" placeholder="Please Enter the Tax Card Number">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group checbox c_green02H">
                                        <input type="checkbox" name="chk_ok" value="ok" id="checkbox">
                                        <label for="checkbox">I have read the
                                            <a href="_inni_note-service.php" class="fancybox-share">Member Terms of Service</a>
                                        </label>
                                    </div>

                                    <div class="pagination_box">
                                        <input type="hidden" name="dbname" value="member_apply">
                                        <input type="reset" class="btn simple" value="Refill">
                                        <input type="submit" class="btn simple bg2 btn-green-bg" value="Send out">
                                    </div>
                                </div>
                            </div>
                        </section>
                    </form>
                </div>
            </main>
        </div>
    </div>
</div>