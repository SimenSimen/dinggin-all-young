<div id="tt-pageContent">
    <div class="container-indent">
        <div class="container">
            <div class="success-wrap cart-checkout-ok-fix pt-sm-5">
                <div class="success-box">
                    <div class="success-msg"><?= $this->lang['c_success'] ?></div>
                    <div class="success-txt c_greenA">
                        <?= $this->lang['c_56'] ?>
                        <div class="order-id b_green">Order Number: <?= $order_id ?></div>

                        <?= $this->lang['c_58'] ?>
                        <a href="contact.php"><?= $this->lang['c_59'] ?></a> <?= $this->lang['c_60'] ?>
                    </div>
                    <div class="pagination_box">
                        <a href="<?= base_url('/') ?>" class="btn simple bg2 en bg2 btn-green-bg"><i name="icon02" class="icon-chevron-left"></i> <?= $this->lang['c_61'] ?></a>
                        <a href="<?= base_url('/member/order/' . $order_id) ?>" class="btn simple bg2 en bg2 btn-green-bg"><?= $this->lang['c_62'] ?> <i name="icon02" class="icon-chevron-right"></i></a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>