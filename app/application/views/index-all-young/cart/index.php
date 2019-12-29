<div id="tt-pageContent">
    <div class="container-indent">
        <div class="container">
            <h1 class="tt-title-subpages noborder"><?= $this->lang['cart'] ?></h1>
            <div class="row">
                <form id="checkForm" action="<?= base_url('/cart/checkout') ?>" method="POST">
                    <input type='hidden' name='by_id' id='by_id' value='<?= $by_id ?>'>
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

                                        <tr class="cart-item" data-uuid="<?= $uuid ?>">
                                            <td>
                                                <a data-key="<?= $uuid ?>" href="#" class="tt-btn-close"></a>
                                            </td>
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
                                                        <div class="tt-price" data-price="<?= $item['price'] ?>">$<?= number_format($item['price']) ?></div>
                                                    </li>
                                                    <li>
                                                        <div class="detach-quantity-mobile"></div>
                                                    </li>
                                                    <li>
                                                        <div class="tt-price subtotal">$<?= number_format($sum) ?></div>
                                                    </li>
                                                </ul>
                                            </td>
                                            <td>
                                                <div class="tt-price" data-price="<?= $item['price'] ?>">$<?= number_format($item['price']) ?></div>
                                            </td>
                                            <td>
                                                <div class="detach-quantity-desctope">
                                                    <div class="tt-input-counter style-01">
                                                        <span class="minus-btn"></span>
                                                        <input type="text" value="<?= $item['num'] ?>" size="<?= $item['prd_lock_amount'] ?>">
                                                        <span class="plus-btn"></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="tt-price subtotal">
                                                    $<?= number_format($sum) ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                            <div class="tt-shopcart-btn">
                                <div class="col-left">
                                    <a class="btn-link" href="<?= base_url('/products') ?>"><i class="icon-e-19"></i><?= $this->lang['c_11'] ?></a>
                                </div>
                            </div>
                        </div>

                        <div class="sum-box">
                            <table class="table table-h sum-table">
                                <tfoot>
                                    <tr>
                                        <td><?= $this->lang['c_sum'] ?></td>
                                        <td>$<span><?= number_format($subTotal) ?></span></td>
                                    </tr>
                                    <tr>
                                        <td><?= $this->lang['c_19'] ?></td>
                                        <td class="qty-box02">
                                            <div class="detach-quantity-desctope">
                                                <div class="tt-input-counter style-01" data-amount="<?= intval($d_dividend); ?>">
                                                    <span class="minus-btn"></span>
                                                    <input type="text" value="0" size="300">
                                                    <span class="plus-btn"></span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= $this->lang['c_52'] ?></td>
                                        <td class="qty-box02">
                                            <div class="detach-quantity-desctope">
                                                <div class="tt-input-counter style-01" data-amount="<?= intval($d_shopping_money); ?>">
                                                    <span class="minus-btn"></span>
                                                    <input type="text" value="0" size="300">
                                                    <span class="plus-btn"></span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?= $this->lang['c_totalpay'] ?></td>
                                        <td class="price-b">$<span><?= number_format($subTotal) ?></span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><?= $this->lang['c_28'] ?>: <?= $this->lang['bonus'] ?> <?= $dataBonus ?>
                                            <span class="color01"><span id="total_bonus"></span><?= $this->lang['c_27'] ?></span>
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
                                        <div class="radio-box">
                                            <label class="form-radio"><input type="checkbox" name="Recipient" id="somemember"><?= $this->lang['c_3'] ?></label>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-box">
                                                <select name="select_address" id="select_address" class="form-control">
                                                    <option value="0"><?= $this->lang['c_25'] ?></option>

                                                    <? foreach ($address as $avalue) : ?>
                                                        <option value="<?= $avalue['d_id']; ?>">
                                                            <?= $avalue['country'] . $avalue['city'] . $avalue['countory'] . $avalue['address'] ?>
                                                        </option>
                                                    <? endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"><?= $this->lang['c_4'] ?></label>
                                            <div class="control-box">
                                                <input class="form-control" type="text" name="buyer_name" id="buyer_name">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"><?= $this->lang['c_email'] ?></label>
                                            <div class="control-box">
                                                <input class="form-control" type="text" name="buyer_email" id="buyer_email">
                                            </div>
                                        </div>
                                        <div class="form-group address">
                                            <label class="control-label"><?= $this->lang['c_5'] ?></label>
                                            <div class="control-box">
                                                <div class="input-group">
                                                    <div class="input-box">
                                                        <input class="form-control" type="text" name="buyer_address" id="buyer_address" placeholder="<?= $this->lang['c_5'] ?>">
                                                    </div>
                                                    <div class="input-box" id="city_select">
                                                        <select name="city" id="city" onChange="sel_area(this.value,'','countory')" class="form-control">
                                                            <!-- //請選擇縣市; -->
                                                            <option value="0"><?= $this->lang["c_23"] ?></option>
                                                            <? foreach ($city as $cvalue) : ?>
                                                                <option value="<?= $cvalue['s_id'] ?>">
                                                                    <?= $cvalue['s_name'] ?>
                                                                </option>
                                                            <? endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="input-box" id="countory_select">
                                                        <select name="countory" id="countory" class="form-control">
                                                            <option value="0"><?= $this->lang["c_24"] ?></option>
                                                        </select>
                                                    </div>
                                                    <div class="input-box">
                                                        <input class="form-control" type="text" name="buyer_State" id="buyer_State" placeholder="<?= $this->lang['c_22'] ?>">
                                                    </div>
                                                    <div class="input-box">
                                                        <input class="form-control" type="text" name="buyer_postcode" id="buyer_postcode" placeholder="<?= $this->lang['receipt_zip'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"><?= $this->lang['c_6'] ?></label>
                                            <div class="control-box">
                                                <input class="form-control" type="text" name="buyer_phone" id="buyer_phone">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col2">
                                    <div class="shopping-title"><?= $this->lang['c_7'] ?></div>
                                    <div class="form-box02">
                                        <div class="form-group">
                                            <div class="input-box">
                                                <select name="lway_id" id="lway_id" class="form-control">
                                                    <?php foreach ($logistics_way as $key => $value) : ?>
                                                        <option value="<?= $value['lway_id']; ?>">
                                                            <?= $value['lway_name']; ?>
                                                        </option>
                                                    <?php endforeach ?>
                                                </select>
                                                <div id='shop'></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="shopping-title"><?= $this->lang['c_10'] ?></div>
                                    <div class="form-box02">
                                        <div class="form-group">
                                            <div class="input-box">
                                                <select name="pway_id" id="" class="form-control">
                                                    <?php foreach ($payment_way as $key => $value) : ?>
                                                        <option value="<?= $value['pway_id']; ?>">
                                                            <?= $value['pway_name']; ?>
                                                        </option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="shopping-title"><?= $this->lang['c_59'] ?></div>
                                    <div class="form-box02">
                                        <div class="form-group">
                                            <div class="input-box">
                                                <textarea cols="50" rows="5" class="form-control" name="buyer_note" id="buyer_note" placeholder="<?= $this->lang['tell_saler'] ?>"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="title"><?= $this->lang['invoice'] ?></div>
                        <div class="invoice-info-box">
                            <div class="invoice-form">
                                <div class="form-box02">
                                    <div class="row clearfix">
                                        <div class="col">
                                            <div class="form-group">
                                                <div class="control-box">
                                                    <div class="input-group">
                                                        <div class="input-box" id="invoice_select">
                                                            <select name="invoice_type" id="invoice" class="form-control">
                                                                <option value="0"><?= $this->lang['e_invoice'] ?></option>
                                                                <option value="1"><?= $this->lang['2_invoice'] ?></option>
                                                                <option value="2"><?= $this->lang['3_invoice'] ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="form-group">
                                                <div class="control-box">
                                                    <div class="input-group">
                                                        <div class="input-box" id="invoice carrier_select">
                                                            <select name="carrier_type" id="invoice carrier" class="form-control">
                                                                <option value="0"><?= $this->lang['m_vehicle'] ?></option>
                                                                <option value="1"><?= $this->lang['phone_carrier'] ?></option>
                                                                <option value="2"><?= $this->lang['natural_carrier'] ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <? // 三聯式發票填寫欄位 
                                        ?>
                                        <div class="col">
                                            <div class="form-group">
                                                <div class="control-box">
                                                    <input class="form-control" type="text" name="triple_letter_head" placeholder="<?= $this->lang['3_invoice_com'] ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="control-box">
                                                    <input class="form-control" type="text" name="triple_uniform_numbers" placeholder="<?= $this->lang['3_invoice_uni'] ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="form-group">
                                                <div class="control-box">
                                                    <input class="form-control" type="text" name="vehicle_number" placeholder="<?= $this->lang['3_invoice_num'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pagination_box">
                            <a href="<?= base_url('/products') ?>" class="btn simple en desktop"><i name="icon02" class="icon-chevron-left"></i> <?= $this->lang['c_11'] ?></a>

                            <a class="btn simple en bg2 btn-green-bg" onclick="checkForm.submit()"> <?= $this->lang['c_14'] ?></i></a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>