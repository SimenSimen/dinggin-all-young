<div id="tt-pageContent" class="main-content ">
    <div class="container-indent">
        <div class="container">
            <main class="main-content">
                <div class="container openside pall0">

                    <?php $this->load->view($indexViewPath . '/members/_sidenav'); ?>

                    <form action="<?= base_url('member/info/update') ?>" class="" method="post" onsubmit="" )>
                        <section class="content has-side">
                            <div class="title"><?= $this->lang['basic'] ?></div>
                            <div class="editor mg">
                                <div class="form-box">
                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-id"></i>
                                            <label class="control-label"><span>*</span><?= $this->lang['account'] ?></label>
                                            <input class="form-control" type="text" name="d_account" value="<?= $dbdata['d_account'] ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-lock"></i>
                                            <label class="control-label"><span>*</span><?= $this->lang['password'] ?></label>
                                            <p class="form-control"><a href="<?= base_url('member/change_password') ?>"><?= $this->lang['editpwd'] ?> Password</a></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-name"></i>
                                            <label class="control-label"><span>*</span><?= $this->lang['name'] ?></label>
                                            <input class="form-control" type="text" name="name" value="<?= $dbdata['name'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-phone"></i>
                                            <label class="control-label"><span>*</span><?= $this->lang['mobile'] ?></label>
                                            <input class="form-control" type="text" maxlength="10" name="mobile" value="<?= $dbdata['mobile'] ?>" onkeyup="value=value.replace(/[^\d]/g,'')" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-phone-call"></i>
                                            <label class="control-label"></label>
                                            <select name="country_num" class="form-control selectBg" style="padding-left:50px">
                                                <option value="" selected><?= $this->lang['country_num'] ?></option>
                                                <? foreach ($country_num as $codeArray) : ?>
                                                    <option value="<?= $codeArray['country_num'] ?>" <?= ($dbdata['country_num'] == $codeArray['country_num']) ? 'selected' : ''; ?>><?= $codeArray['country_num'] ?></option>
                                                <? endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-phone-call"></i>
                                            <label class="control-label ml-2"><span></span><?= $this->lang['phone'] ?></label>
                                            <input class="form-control" type="text" maxlength="11" name="telphone" value="<?= !empty($dbdata['telphone']) ? $dbdata['telphone'] : '' ?>" onkeyup="value=value.replace(/[^\d]/g,'')">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-cake"></i>
                                            <label class="control-label"><span>*</span><?= $this->lang['brithday'] ?></label>
                                            <input style="pointer-events: none;" class="form-control bar_content date-object birthday" type="text" name="birthday" value="<?= $dbdata['birthday'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-mail"></i>
                                            <label class="control-label"><span>*</span><?= $this->lang['email'] ?></label>
                                            <input class="form-control" type="text" name="by_email" value="<?= $dbdata['by_email'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-placeholder"></i>
                                            <label class="control-label ml-2"><?= $this->lang['address'] ?></label>
                                            <input class="form-control" type="text" name="address" value="<?= !empty($dbdata['address']) ? $dbdata['address'] : '' ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-placeholder"></i>
                                            <label class="control-label"></label>
                                            <select name="countory" id="county" class="form-control selectBg" style="padding-left:50px">
                                                <option value="" selected><?= $this->lang['county'] ?></option>
                                                <? foreach ($countory as $cvalue) : ?>
                                                    <option value="<?= $cvalue['s_id'] ?>" <?= ($dbdata['countory'] == $cvalue['s_id']) ? 'selected' : ''; ?>><?= $cvalue['s_name'] ?></option>
                                                <? endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-placeholder"></i>
                                            <label class="control-label"></label>
                                            <select name="city" id="city" class="form-control selectBg" style="padding-left:50px">
                                                <option value="" selected><?= $this->lang['city'] ?></option>
                                                <? foreach ($city as $cvalue) : ?>
                                                    <option value="<?= $cvalue['s_id'] ?>" <?= ($dbdata['city'] == $cvalue['s_id']) ? 'selected' : ''; ?>><?= $cvalue['s_name'] ?></option>
                                                <? endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-placeholder"></i>
                                            <label class="control-label"></label>
                                            <select name="country" id="buyer_State" class="form-control selectBg" style="padding-left:50px">
                                                <option value="" selected><?= $this->lang['country'] ?></option>
                                                <? foreach ($country as $cvalue) : ?>
                                                    <option value="<?= $cvalue['s_id'] ?>" <?= ($dbdata['country'] == $cvalue['s_id']) ? 'selected' : ''; ?>><?= $cvalue['s_name'] ?></option>
                                                <? endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-placeholder"></i>
                                            <label class="control-label ml-2"><?= $this->lang['zip'] ?></label>
                                            <input class="form-control" type="text" name="zip" id="buyer_postcode" value="<?= $dbdata['zip'] ?>">
                                        </div>
                                    </div>

                                    <?php if ($dbdata['d_is_member'] == Member_model::BUYER_ROLE_SALE) : ?>

                                        <div class="managemenbox">
                                            <p class="c_red"><?= $this->lang['change_message'] ?></p>

                                            <div class="form-group">
                                                <div class="control-box">
                                                    <i name="icon02" class="icon-name"></i>
                                                    <label class="control-label"><span>*</span><?= $this->lang['idnum'] ?></label>
                                                    <input class="form-control w200" type="text" value="<?= $mdbdata['identity_num'] ?>" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="managemenbox">
                                            <p>*<?= $this->lang['account_setting'] ?><small class="c_red">(<?= $this->lang['setting_desc'] ?>)</small></p>

                                            <div class="form-group">
                                                <div class="control-box">
                                                    <i name="icon02" class="icon-id"></i>
                                                    <label class="control-label"><span>*</span><?= $this->lang['bankname'] ?></label>
                                                    <input class="form-control w200" type="text" name="bank_name" value="<?= $mdbdata['bank_name'] ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="control-box">
                                                    <i name="icon02" class="icon-id"></i>
                                                    <label class="control-label"><span>*</span><?= $this->lang['bank_branch'] ?></label>
                                                    <input class="form-control w200" type="text" name="bank_branch" value="<?= $mdbdata['bank_branch'] ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="control-box">
                                                    <i name="icon02" class="icon-id"></i>
                                                    <label class="control-label"><span>*</span><?= $this->lang['accountname'] ?></label>
                                                    <input class="form-control w200" type="text" name="bank_account_name" value="<?= $mdbdata['bank_account_name'] ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="control-box">
                                                    <i name="icon02" class="icon-id"></i>
                                                    <label class="control-label"><span>*</span><?= $this->lang['bankaccount'] ?></label>
                                                    <input class="form-control w200" type="text" name="bank_account" value="<?= $mdbdata['bank_account'] ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="managemenbox">
                                            <div class="form-group">
                                                <div class="control-box">
                                                    <div class="radio-box">
                                                        <label class="form-radio">
                                                            <input type="radio" name="tax_card_free" value="2" <?= $mdbdata['tax_card_free'] == 2 ? 'checked' : '' ?>>
                                                            <i></i><?= $this->lang['tax_free_card'] ?>
                                                        </label>
                                                        <label class="form-radio" style="margin-left:20px;">
                                                            <input type="radio" name="tax_card_free" value="1" <?= $mdbdata['tax_card_free'] == 1 ? 'checked' : '' ?>>
                                                            <i></i><?= $this->lang['tax_card'] ?>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="control-box">
                                                    <input class="form-control form-control03" value="<?= $mdbdata['tax_card'] ?>" type="text" name="tax_card" id="tax-number" placeholder="<?= $this->lang['tax_card_num'] ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="is_member" value="Y">
                                    <?php endif ?>
                                    <div class="form-group checbox">
                                        <input type="checkbox" name="d_service" value="1" id="checkbox02" <?= $dbdata['d_service'] == 'Y' ? 'checked' : '' ?>>
                                        <label for="checkbox"><?= $this->lang['agree_offers'] ?></label>
                                    </div>

                                    <input type="hidden" name="dbname" value="<?= $dbname ?>">
                                    <p class="ml-3"><?= $this->lang['current_have'] ?><span class="color01"><?= number_format(intval($dbdata['d_bonus'])) ?></span><?= $this->lang['dividend'] ?> <span class="color01"><?= number_format(intval($dbdata['d_shopping_money'])) ?></span><?= $this->lang['shopping_gold'] ?></p>

                                    <div class="pagination_box">
                                        <input type="hidden" name="dbname" value="buyer">
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

<? $this->load->view($indexViewPath . '/include_ajax_area') ?>