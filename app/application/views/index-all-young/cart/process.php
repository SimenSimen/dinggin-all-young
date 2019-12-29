<div id="tt-pageContent">
    <div class="container-indent">
        <div class="container">
            <h1 class="tt-title-subpages noborder"><?= $this->lang['cart'] ?></h1>
            <div class="row">
                <form id="checkoutForm" action="<?= base_url('webpay/pay') ?>" method="POST">
                    <div class="col-12 main-content mt-0">
                        <div class="tt-shopcart-table">
                            <table>
                                <tbody>
                                    <tr class="cart-tit">
                                        <th></th>
                                        <th></th>
                                        <th><?= $this->lang['c_name'] ?></th>
                                        <th><?= $this->lang['c_price'] ?></th>
                                        <th class="text-center"><?= $this->lang['c_num'] ?></th>
                                        <th><?= $this->lang['c_sum'] ?></th>
                                    </tr>
                                    <?php $subTotal = 0; ?>
                                    <?php foreach ($productList as $uuid => $item) : ?>
                                        <?php $sum = floatval($item['price']) * floatval($item['num']); ?>
                                        <?php $subTotal += $sum; ?>
                                        <tr>
                                            <td></td>
                                            <td>
                                                <div class="tt-product-img">
                                                    <img src="images/loader.svg" data-src="<?= $item['prd_image'] ?>" alt="">
                                                </div>
                                            </td>
                                            <td>
                                                <h2 class="tt-title">
                                                    <a href="<?= base_url('/products/detail/' . $item['prd_id']) ?>"><?= $item['prd_name'] ?></a>
                                                </h2>
                                                <ul class="tt-list-parameters">
                                                    <li>
                                                        <div class="detach-quantity-mobile"><?= $this->lang['c_num'] ?>：<sapn><?= intval($item['num']) ?></sapn>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="tt-price subtotal"><?= $this->lang['c_price'] ?>：$<?= number_format($item['total']) ?></div>
                                                    </li>
                                                </ul>
                                            </td>
                                            <td>
                                                <div class="tt-price">$<?= number_format($item['price']) ?></div>
                                            </td>
                                            <td>
                                                <div class="list-qty"><?= intval($item['num']) ?></div>
                                            </td>
                                            <td>
                                                <div class="tt-price subtotal">
                                                    $<?= number_format($item['total']) ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="sum-box">
                            <table class="table table-h sum-table unborder">
                                <tfoot>
                                    <tr>
                                        <td><?= $this->lang['c_sum'] ?></td>
                                        <td>$<span><?= number_format($subTotal) ?></span></td>
                                    </tr>
                                    <tr>
                                        <td><?= $this->lang['c_19'] ?></td>
                                        <td>$<?= $use_dividend ?><span></span></td>
                                    </tr>
                                    <tr>
                                        <td><?= $this->lang['c_52'] ?></td>
                                        <td>$<span><?= $use_shopping_money ?></span></td>
                                    </tr>
                                    <tr>
                                        <td><?= $this->lang['c_totalpay'] ?></td>
                                        <td class="price-b">$<span><?= number_format($only_money) ?></span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><?= $this->lang['c_28'] ?>: <?= $this->lang['bonus'] ?> <?= number_format($bonus) ?>
                                            <span class="color01"><span id="total_bonus"></span>Points</span>
                                        </td>
                                    </tr>

                                </tfoot>
                            </table>
                        </div>

                        <div class="title"><?= $this->lang['c_1'] ?></div>
                        <div class="shopping-form">
                            <div class="row">
                                <div class="col col1">
                                    <div class="shopping-title"><?= $this->lang['c_2'] ?></div>
                                    <div class="form-box02">
                                        <div class="form-group">
                                            <label class="control-label"><?= $this->lang['c_4'] ?>：</label>
                                            <div class="control-box"><?= $buyer_name ?></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"><?= $this->lang['c_email'] ?>：</label>
                                            <div class="control-box"><?= $buyer_email ?></div>
                                        </div>
                                        <div class="form-group address">
                                            <label class="control-label"><?= $this->lang['c_5'] ?>：</label>

                                            <div class="control-box">
                                                <div class="input-group">
                                                    <div class="input-box"><?= $country ?> <?= $country ?> <?= $area ?><br><?= $buyer_address ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"><?= $this->lang['c_6'] ?>：</label>
                                            <div class="control-box"><?= $buyer_phone ?></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col col2">
                                    <div class="shopping-title"><?= $this->lang['c_7'] ?></div>
                                    <div class="form-box02">
                                        <div class="input-box"><?= $logistics_way ?></div>
                                    </div>
                                    <div class="shopping-title"><?= $this->lang['c_10'] ?></div>
                                    <div class="form-box02">
                                        <div class="input-box"><?= $payment_way ?></div>
                                    </div>
                                    <div class="shopping-title"><?= $this->lang['tell_saler'] ?></div>
                                    <div class="form-box02">
                                        <div class="input-box">
                                            <?= $buyer_note ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="title"><?= $this->lang['invoice'] ?></div>
                        <?php $invoiceTypeArray = ['Electronic Invoice', 'Two-way Invoice', 'Triple Invoice'] ?>
                        <?php $carrierTypeArray = ['Member Vehicle', 'Mobile Phone Carrier', 'Natural Person Carrier'] ?>
                        <?php if ($invoice_type !== 2) : ?>
                            <div class="invoice-info-box">
                                <div class="invoice-info info-text">
                                    <?= $this->lang['invoice_type'] ?>：<span><?= $invoiceTypeArray[$invoice_type] ?></span>
                                </div>
                                <div class="invoice-info info-text">
                                    <?= $this->lang['carrier_type'] ?>：<span><?= $carrierTypeArray[$carrier_type] ?>
                                </div>
                                <div class="invoice-info info-text">
                                    <?= $this->lang['phone_carrier'] ?>：<span><?= $vehicle_number ?></span>
                                </div>
                            </div>

                        <?php else : ?>
                            <!-- 三聯式發票填寫欄位  -->
                            <div class="invoice-info-box">
                                <div class="invoice-info info-text">
                                    <?= $this->lang['invoice_type'] ?>：<span><?= $invoiceTypeArray[$invoice_type] ?></span>
                                </div>
                                <div class="invoice-info info-text">
                                    <?= $this->lang['3_invoice_com'] ?>：<span><?= $triple_letter_head ?></span>
                                </div>
                                <div class="invoice-info info-text">
                                    <?= $this->lang['3_invoice_uni'] ?>：<span><?= $triple_uniform_numbers ?></span>
                                </div>
                            </div>
                        <?php endif  ?>

                        <div class="pagination_box">
                            <a href="<?= base_url('cart') ?>" class="btn simple en"><i name="icon02" class="icon-chevron-left"></i> <?= $this->lang['c_13'] ?></a>
                            <a class="btn simple en bg2F btn-green-bg" onclick="checkoutForm.submit()"><?= $this->lang['c_12'] ?></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>