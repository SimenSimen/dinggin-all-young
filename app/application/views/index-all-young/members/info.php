<div id="tt-pageContent" class="main-content ">
    <div class="container-indent">
        <div class="container">

            <main class="main-content">
                <div class="container openside pall0">

                    <?php require_once('_inni_include_sidenav.php'); ?>

                    <form action="" class="" method="post" onsubmit="" )>
                        <section class="content has-side">
                            <div class="title">Information</div>
                            <div class="editor mg">
                                <div class="form-box">
                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-id"></i>
                                            <label class="control-label"><span>*</span>Account</label>
                                            <input class="form-control" type="text" name="d_account" id="" value="0987654321" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-lock"></i>
                                            <label class="control-label"><span>*</span>Password</label>
                                            <p class="form-control"><a href="member_password.php">Change Password</a></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-name"></i>
                                            <label class="control-label"><span>*</span>Name</label>
                                            <input class="form-control" type="text" name="name" id="" value="joy" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-phone"></i>
                                            <label class="control-label"><span>*</span>Mobile</label>
                                            <input class="form-control" type="text" maxlength="10" name="mobile" id="" value="0987654321" onkeyup="value=value.replace(/[^\d]/g,'')">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-phone-call"></i>
                                            <label class="control-label"></label>
                                            <select name="country_num" id="" class="form-control selectBg" style="padding-left:50px">
                                                <option value="" selected>Please Select Country Code</option>
                                                <option value="886">Taiwan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-phone-call"></i>
                                            <label class="control-label ml-2"><span></span>Telephone</label>
                                            <input class="form-control" type="text" maxlength="11" name="telphone" id="" value="229956488" onkeyup="value=value.replace(/[^\d]/g,'')">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-cake"></i>
                                            <label class="control-label"><span>*</span>Birthday</label>
                                            <input style="pointer-events: none;" class="form-control bar_content date-object birthday" type="text" name="birthday" id="" value="0000-00-00">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-mail"></i>
                                            <label class="control-label"><span>*</span>E-mail</label>
                                            <input class="form-control" type="text" name="by_email" value="jay@netnews.com.tw">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-placeholder"></i>
                                            <label class="control-label ml-2">Address</label>
                                            <input class="form-control" type="text" name="address" id="" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-placeholder"></i>
                                            <label class="control-label"></label>
                                            <select name="city" id="city" onChange="sel_area(this.value,'','countory')" class="form-control selectBg" style="padding-left:50px">
                                                <option value="" selected>City</option>
                                                <option value="1">基隆市</option>
                                                <option value="2">台北市</option>
                                                <option value="3">新北市</option>
                                                <option value="4">桃園市</option>
                                                <option value="5">新竹市</option>
                                                <option value="6">新竹縣</option>
                                                <option value="7">苗栗縣</option>
                                                <option value="8">台中市</option>
                                                <option value="9">彰化縣</option>
                                                <option value="10">南投縣</option>
                                                <option value="11">雲林縣</option>
                                                <option value="12">嘉義市</option>
                                                <option value="13">嘉義縣</option>
                                                <option value="14">台南市</option>
                                                <option value="15">高雄市</option>
                                                <option value="16">屏東縣</option>
                                                <option value="17">台東縣</option>
                                                <option value="18">花蓮縣</option>
                                                <option value="19">宜蘭縣</option>
                                                <option value="20">澎湖縣</option>
                                                <option value="21">金門縣</option>
                                                <option value="22">連江縣</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-placeholder"></i>
                                            <label class="control-label"></label>
                                            <select name="countory" id="countory" class="form-control selectBg" style="padding-left:50px">
                                                <option value="0" selected>County/Region</option>
                                                <option value="168">萬里區</option>
                                                <option value="376">金山區</option>
                                                <option value="323">板橋區</option>
                                                <option value="264">汐止區</option>
                                                <option value="135">深坑區</option>
                                                <option value="273">石碇區</option>
                                                <option value="364">瑞芳區</option>
                                                <option value="35">平溪區</option>
                                                <option value="272">雙溪區</option>
                                                <option value="54">貢寮區</option>
                                                <option value="300">新店區</option>
                                                <option value="275">坪林區</option>
                                                <option value="159">烏來區</option>
                                                <option value="131">永和區</option>
                                                <option value="157">中和區</option>
                                                <option value="93">土城區</option>
                                                <option value="44">三峽區</option>
                                                <option value="292">樹林區</option>
                                                <option value="47">鶯歌區</option>
                                                <option value="146">三重區</option>
                                                <option value="366">新莊區</option>
                                                <option value="330">泰山區</option>
                                                <option value="283">林口區</option>
                                                <option value="81">蘆洲區</option>
                                                <option value="322">五股區</option>
                                                <option value="128">八里區</option>
                                                <option value="115">淡水區</option>
                                                <option value="253">三芝區</option>
                                                <option value="100">石門區</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-placeholder"></i>
                                            <label class="control-label"></label>
                                            <select name="buyer_State" id="buyer_State" class="form-control selectBg" style="padding-left:50px">
                                                <option value="0" selected>State/territory</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="control-box">
                                            <i name="icon02" class="icon-placeholder"></i>
                                            <label class="control-label ml-2">Postcode</label>
                                            <input class="form-control" type="text" name="buyer_postcode" id="buyer_postcode" value="">
                                        </div>
                                    </div>




                                    <? // 經營會員資料欄位 
                                    ?>

                                    <div class="managemenbox">
                                        <p class="c_red">In order to maintain account security, please contact the administrator below if you want to change the membership information.</p>

                                        <div class="form-group">
                                            <div class="control-box">
                                                <i name="icon02" class="icon-name"></i>
                                                <label class="control-label"><span>*</span>Identity Card Number</label>
                                                <input class="form-control w200" type="text" name="id-number" id="" value="A123456789" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="managemenbox">
                                        <p>*Account settings<small class="c_red">(The bonus will be remitted from Taiwan. Please provide relevant information about international remittance.)</small></p>

                                        <div class="form-group">
                                            <div class="control-box">
                                                <i name="icon02" class="icon-id"></i>
                                                <label class="control-label">Bank Name</label>
                                                <input class="form-control w200" type="text" name="bank" id="" value="City Bank">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="control-box">
                                                <i name="icon02" class="icon-id"></i>
                                                <label class="control-label">Branch Bank</label>
                                                <input class="form-control w200" type="text" name="branch" id="" value="Taichung Branch">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="control-box">
                                                <i name="icon02" class="icon-id"></i>
                                                <label class="control-label">Account Title</label>
                                                <input class="form-control w200" type="text" name="ccountTit" id="" value="Joy">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="control-box">
                                                <i name="icon02" class="icon-id"></i>
                                                <label class="control-label">Bank Account</label>
                                                <input class="form-control w200" type="text" name="bankAccount" id="" value="12345678912345">
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




                                    <div class="form-group checbox">
                                        <input type="checkbox" name="chk_sale_ok" value="ok" id="checkbox02">
                                        <label for="checkbox">Agree to receive offers</label>
                                    </div>

                                    <input type="hidden" name="is_member" value="Y">
                                    <p class="ml-3">You Currently have<span class="color01">9,643</span>Bonus Points <span class="color01">1,921</span>Shopping Gold
                                    </p>

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