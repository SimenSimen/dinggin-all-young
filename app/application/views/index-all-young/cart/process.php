<div id="tt-pageContent">
    <div class="container-indent">
        <div class="container">
            <h1 class="tt-title-subpages noborder">SHOPPING CART</h1>
            <div class="row">
                <form id="checkoutForm" action="<?= base_url('webpay/pay') ?>" method="POST">
                    <div class="col-12 main-content mt-0">
                        <div class="tt-shopcart-table">
                            <table>
                                <tbody>
                                    <tr class="cart-tit">
                                        <th></th>
                                        <th></th>
                                        <th>Product Name</th>
                                        <th>Amount</th>
                                        <th class="text-center">Quantity</th>
                                        <th>Subtotal</th>
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
                                                        <div class="detach-quantity-mobile">Quantity：<sapn><?= intval($item['num']) ?></sapn>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="tt-price subtotal">Amount：$<?= number_format($item['total']) ?></div>
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
                                        <td>Subtotal</td>
                                        <td>$<span><?= number_format($subTotal) ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>Use Bonus</td>
                                        <td>$<?= $use_dividend ?><span></span></td>
                                    </tr>
                                    <tr>
                                        <td>Use Shopping Gold</td>
                                        <td>$<span><?= $use_shopping_money ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td class="price-b">$<span><?= number_format($only_money) ?></span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">This Purchase is Available: Bonus <?= number_format($bonus) ?>
                                            <span class="color01"><span id="total_bonus"></span>Points</span>
                                        </td>
                                    </tr>

                                </tfoot>
                            </table>
                        </div>

                        <div class="title">Shipping & Payment Information</div>
                        <div class="shopping-form">
                            <div class="row">
                                <div class="col col1">
                                    <div class="shopping-title">Recipient information</div>
                                    <div class="form-box02">
                                        <div class="form-group">
                                            <label class="control-label">Name：</label>
                                            <div class="control-box"><?= $buyer_name ?></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">email：</label>
                                            <div class="control-box"><?= $buyer_email ?></div>
                                        </div>
                                        <div class="form-group address">
                                            <label class="control-label">Contact Address：</label>

                                            <div class="control-box">
                                                <div class="input-group">
                                                    <div class="input-box"><?= $country ?> <?= $country ?> <?= $area ?><br><?= $buyer_address ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Contact Phone：</label>
                                            <div class="control-box"><?= $buyer_phone ?></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col col2">
                                    <div class="shopping-title">Shipping Method</div>
                                    <div class="form-box02">
                                        <div class="input-box"><?= $logistics_way ?></div>
                                    </div>
                                    <div class="shopping-title">Payment Method</div>
                                    <div class="form-box02">
                                        <div class="input-box"><?= $payment_way ?></div>
                                    </div>
                                    <div class="shopping-title">Remarks</div>
                                    <div class="form-box02">
                                        <div class="input-box">
                                            <?= $buyer_note ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="title">Invoice Opening</div>
                        <div class="invoice-info-box">
                            <div class="invoice-info info-text">
                                Invoice type：<span>Two-way Invoice</span>
                            </div>
                            <div class="invoice-info info-text">
                                Vehicle Type：<span>Mobile Phone Carrier</span>
                            </div>
                            <div class="invoice-info info-text">
                                Mobile Phone Carrier：<span>XX34V61</span>
                            </div>
                        </div>

                        <? // 三聯式發票填寫欄位 
                        ?>
                        <!-- <div class="invoice-info-box">
                        <div class="invoice-info info-text">
                        	Invoice type：<span>Triple Invoice</span>
                        </div>
                        <div class="invoice-info info-text">
                        	Company Letterhead：<span>netnews co.</span>
                        </div>
                        <div class="invoice-info info-text">
                        	Uniform Numbers：<span>89765432</span>
                        </div> 									             
                    </div> -->

                        <div class="pagination_box">
                            <a href="<?= base_url('cart') ?>" class="btn simple en"><i name="icon02" class="icon-chevron-left"></i> BACK</a>
                            <a class="btn simple en bg2F btn-green-bg" onclick="checkoutForm.submit()">PAYMENT</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>