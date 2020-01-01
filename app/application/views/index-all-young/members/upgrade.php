<div id="tt-pageContent" class="main-content ">
    <div class="container-indent">
        <div class="container">
            <main class="main-content">
                <div class="container openside pall0">
                    <?php $this->load->view($indexViewPath . '/members/_sidenav'); ?>
                    <form action="<?= base_url('member/upgrade/submit') ?>" class="" method="post" onsubmit="">
                        <section class="content has-side">
                            <div class="title"><?= $this->lang['upgrade_title'] ?></div>
                            <div class="editor mg">
                                <div class="form-box">

                                    <div class="managemenbox">

                                        <div class="form-group name">
                                            <i name="icon02" class="icon-genders"></i> <label class="control-label"><?= $this->lang['identity'] ?></label>
                                            <div class="control-box">
                                                <div class="radio-box">
                                                    <label class="form-radio checked"><input type="radio" name="identity" checked="" value="1"> <?= $this->lang['general'] ?></label>
                                                    <label class="form-radio"><input type="radio" name="identity" value="2"><?= $this->lang['legal_person'] ?></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="control-box">
                                                <i name="icon02" class="icon-name"></i>
                                                <label class="control-label"><span>*</span><?= $this->lang['idnum'] ?></label>
                                                <input class="form-control w200" type="text" maxlength="10" name="identity_num" value="" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="managemenbox">
                                        <p><?= $this->lang['accconfig'] ?></p>

                                        <div class="form-group">
                                            <div class="control-box">
                                                <i name="icon02" class="icon-id"></i>
                                                <label class="control-label"><span>*</span><?= $this->lang['bname'] ?></label>
                                                <input class="form-control w200" type="text" name="bank_name" value="" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="control-box">
                                                <i name="icon02" class="icon-id"></i>
                                                <label class="control-label"><span>*</span><?= $this->lang['bank_branch'] ?></label>
                                                <input class="form-control w200" type="text" name="bank_branch" value="" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="control-box">
                                                <i name="icon02" class="icon-id"></i>
                                                <label class="control-label"><span>*</span><?= $this->lang['accountname'] ?></label>
                                                <input class="form-control w200" type="text" name="bank_account_name" value="" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="control-box">
                                                <i name="icon02" class="icon-id"></i>
                                                <label class="control-label"><span>*</span><?= $this->lang['bacc'] ?></label>
                                                <input class="form-control w200" type="text" name="bank_account" value="" required>
                                            </div>
                                        </div>

                                        <div class="managemenbox">
                                            <div class="form-group">
                                                <div class="control-box">
                                                    <div class="radio-box">
                                                        <label class="form-radio checked">
                                                            <input type="radio" name="tax_card_free" value="2"> <?= $this->lang['tax_free_card'] ?>
                                                        </label>
                                                        <label class="form-radio" style="margin-left:20px;">
                                                            <input type="radio" name="tax_card_free" value="1"> <?= $this->lang['tax_card'] ?>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="control-box">
                                                    <input class="form-control form-control03" type="text" name="tax_card" id="tax-number" placeholder="<?= $this->lang['tax_card_num'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group checbox c_green02H">
                                        <input type="checkbox" value="ok" id="checkbox" required>
                                        <label for="checkbox"><?= $this->lang['I_have_read'] ?>
                                            <a href="_inni_note-service.php" class="fancybox-share"><?= $this->lang['term'] ?></a>
                                        </label>
                                    </div>

                                    <div class="pagination_box">
                                        <input type="hidden" name="dbname" value="member_apply">
                                        <input type="reset" class="btn simple" value="<?= $this->lang['refill'] ?>">
                                        <input type="submit" class="btn simple bg2 btn-green-bg" value="<?= $this->lang['send_out'] ?>">
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