<div id="tt-pageContent" class="main-content ">
    <div class="container-indent">
        <div class="container">
            <main class="main-content">
                <div class="container openside pall0">

                    <?php $this->load->view($indexViewPath . '/members/_sidenav'); ?>

                    <form action="<?= base_url('member/info/update') ?>" class="" method="post" onsubmit="" )>
                        <section class="content has-side">
                            <div class="title">Information</div>
                            <div class="editor mg">
                                <div class="form-box">
                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-id"></i>
                                            <label class="control-label"><span>*</span>Account</label>
                                            <input class="form-control" type="text" name="d_account" value="<?= $dbdata['d_account'] ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-lock"></i>
                                            <label class="control-label"><span>*</span>Password</label>
                                            <p class="form-control"><a href="<?= base_url('member/change_password') ?>">Change Password</a></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-name"></i>
                                            <label class="control-label"><span>*</span>Name</label>
                                            <input class="form-control" type="text" name="name" value="<?= $dbdata['name'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-phone"></i>
                                            <label class="control-label"><span>*</span>Mobile</label>
                                            <input class="form-control" type="text" maxlength="10" name="mobile" value="<?= $dbdata['mobile'] ?>" onkeyup="value=value.replace(/[^\d]/g,'')" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-phone-call"></i>
                                            <label class="control-label"></label>
                                            <select name="country_num" class="form-control selectBg" style="padding-left:50px">
                                                <option value="" selected>Please Select Country Code</option>
                                                <? foreach ($country_num as $codeArray) : ?>
                                                    <option value="<?= $codeArray['country_num'] ?>" <?= ($dbdata['country_num'] == $codeArray['country_num']) ? 'selected' : ''; ?>><?= $codeArray['country_name'] ?></option>
                                                <? endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-phone-call"></i>
                                            <label class="control-label ml-2"><span></span>Telephone</label>
                                            <input class="form-control" type="text" maxlength="11" name="telphone" value="<?= $dbdata['telphone'] ?>" onkeyup="value=value.replace(/[^\d]/g,'')">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-cake"></i>
                                            <label class="control-label"><span>*</span>Birthday</label>
                                            <input style="pointer-events: none;" class="form-control bar_content date-object birthday" type="text" name="birthday" value="<?= $dbdata['birthday'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-mail"></i>
                                            <label class="control-label"><span>*</span>E-mail</label>
                                            <input class="form-control" type="text" name="by_email" value="<?= $dbdata['by_email'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-placeholder"></i>
                                            <label class="control-label ml-2">Address</label>
                                            <input class="form-control" type="text" name="address" value="<?= $dbdata['address'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-placeholder"></i>
                                            <label class="control-label"></label>
                                            <select name="city" id="city" onChange="sel_area(this.value,'','countory')" class="form-control selectBg" style="padding-left:50px">
                                                <option value="" selected>City</option>
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
                                            <select name="countory" id="countory" class="form-control selectBg" style="padding-left:50px">
                                                <option value="0" selected>County/Region</option>
                                                <? foreach ($countory as $cvalue) : ?>
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
                                                <option value="0" selected>State/territory</option>
                                                <? foreach ($country as $cvalue) : ?>
                                                    <option value="<?= $cvalue['s_id'] ?>" <?= ($dbdata['city'] == $cvalue['s_id']) ? 'selected' : ''; ?>><?= $cvalue['s_name'] ?></option>
                                                <? endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-placeholder"></i>
                                            <label class="control-label ml-2">Postcode</label>
                                            <input class="form-control" type="text" name="zip" id="buyer_postcode" value="<?= $dbdata['zip'] ?>">
                                        </div>
                                    </div>



                                    <? // 經營會員資料欄位 
                                    ?>

                                    <?php if ($dbdata['d_is_member'] == Member_model::BUYER_ROLE_SALE) : ?>

                                        <div class="managemenbox">
                                            <p class="c_red">In order to maintain account security, please contact the administrator below if you want to change the membership information.</p>

                                            <div class="form-group">
                                                <div class="control-box">
                                                    <i name="icon02" class="icon-name"></i>
                                                    <label class="control-label"><span>*</span>Identity Card Number</label>
                                                    <input class="form-control w200" type="text" name="id-number" value="A123456789" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="managemenbox">
                                            <p>*Account settings<small class="c_red">(The bonus will be remitted from Taiwan. Please provide relevant information about international remittance.)</small></p>

                                            <div class="form-group">
                                                <div class="control-box">
                                                    <i name="icon02" class="icon-id"></i>
                                                    <label class="control-label">Bank Name</label>
                                                    <input class="form-control w200" type="text" name="bank" value="City Bank">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="control-box">
                                                    <i name="icon02" class="icon-id"></i>
                                                    <label class="control-label">Branch Bank</label>
                                                    <input class="form-control w200" type="text" name="branch" value="Taichung Branch">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="control-box">
                                                    <i name="icon02" class="icon-id"></i>
                                                    <label class="control-label">Account Title</label>
                                                    <input class="form-control w200" type="text" name="ccountTit" value="Joy">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="control-box">
                                                    <i name="icon02" class="icon-id"></i>
                                                    <label class="control-label">Bank Account</label>
                                                    <input class="form-control w200" type="text" name="bankAccount" value="12345678912345">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="managemenbox">
                                            <div class="form-group">
                                                <div class="control-box">
                                                    <div class="radio-box">
                                                        <label class="form-radio"><input type="radio" name="tax" value="tax-free"><i></i>Tax-Free Card</label>
                                                        <label class="form-radio" style="margin-left:20px;"><input type="radio" name="tax" value="tax"><i></i>Tax Card</label>
                                                    </div>
                                                </div>
                                                <div class="control-box">
                                                    <input class="form-control form-control03" type="text" name="tax-number" id="tax-number" placeholder="Please Enter the Tax Card Number">
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="is_member" value="Y">
                                    <?php endif ?>
                                    <div class="form-group checbox">
                                        <input type="checkbox" name="chk_sale_ok" value="ok" id="checkbox02">
                                        <label for="checkbox">Agree to receive offers</label>
                                    </div>

                                    <input type="hidden" name="dbname" value="<?= $dbname ?>">
                                    <p class="ml-3">You Currently have<span class="color01"><?= number_format(intval($dbdata['d_bonus'])) ?></span>Bonus Points <span class="color01"><?= number_format(intval($dbdata['d_shopping_money'])) ?></span>Shopping Gold</p>

                                    <div class="pagination_box">
                                        <input type="hidden" name="dbname" value="buyer">
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