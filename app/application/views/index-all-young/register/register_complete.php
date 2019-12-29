<div class="container">
    <main class="main-content wow fadeInUp" data-wow-delay="0.4s">
        <div class="container-indent center">
            <form action="" method="post" class="j-forms">
                <section class="content">
                    <div class="title"><?= $lang['register_compelete'] ?></div>
                    <div class="editor mg">
                        <div class="form-box">
                            <div class="form-group">
                                <div class="control-box02 text-center">
                                    <label class="control-label c_greenA"><?= $lang['customer_if_ques'] ?>
                                        <a href="#"><?= $lang['customer_service'] ?></a> <?= $lang['customer_msg'] ?>
                                        <br class="br"> <?= $lang['customer_contact'] ?> </label>

                                </div>
                            </div>

                            <div class="pagination_box">
                                <input type="hidden" name="dbname" value="buyer">
                                <input type="hidden" name="member_register" value="yes">
                                <input type="submit" class="btn simple bg2 b_green" value="<?= $lang['home_back'] ?>">
                                <input type="submit" class="btn simple bg2 b_green" value="<?= $lang['member_center'] ?>">
                            </div>
                        </div>

                    </div>
                </section>
            </form>
        </div>
    </main>
</div>