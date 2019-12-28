<div id="tt-pageContent">
    <div class="container-indent">
        <div class="container">
            <h1 class="tt-title-subpages noborder">SHOPPING CART</h1>
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
                                        <th>Product Name</th>
                                        <th>Amount</th>
                                        <th class="text-center">Quantity</th>
                                        <th>Subtotal</th>
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
                                    <a class="btn-link" href="<?= base_url('/products') ?>"><i class="icon-e-19"></i>CONTINUE SHOPPING</a>
                                </div>
                            </div>
                        </div>

                        <div class="sum-box">
                            <table class="table table-h sum-table">
                                <tfoot>
                                    <tr>
                                        <td>Subtotal</td>
                                        <td>$<span><?= number_format($subTotal) ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>Use Bonus</td>
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
                                        <td>Use Shopping Gold</td>
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
                                        <td>Total</td>
                                        <td class="price-b">$<span><?= number_format($subTotal) ?></span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">This Purchase is Available: Bonus 0
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
                                        <div class="radio-box">
                                            <label class="form-radio"><input type="checkbox" name="gender" id="somemember">Recipient and subscriber information</label>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-box">
                                                <select name="select_address" id="select_address" class="form-control">
                                                    <option value="0">Common Address</option>
                                                    <option value="15">台灣新北市萬里區重新路五段609巷4號8樓之8</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Name</label>
                                            <div class="control-box">
                                                <input class="form-control" type="text" name="buyer_name" id="buyer_name">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">email</label>
                                            <div class="control-box">
                                                <input class="form-control" type="text" name="buyer_email" id="buyer_email">
                                            </div>
                                        </div>
                                        <div class="form-group address">
                                            <label class="control-label">Contact Address</label>
                                            <div class="control-box">
                                                <div class="input-group">
                                                    <div class="input-box">
                                                        <input class="form-control" type="text" name="buyer_address" id="buyer_address" placeholder="Address">
                                                    </div>
                                                    <div class="input-box" id="city_select">
                                                        <select name="city" id="city" onChange="sel_area(this.value,'','countory')" class="form-control">
                                                            <option value="0"> City</option>
                                                            <div class="city-box">
                                                                <h4>A PHP Error was encountered</h4>
                                                                <p>Severity: Warning</p>
                                                                <p>Message: Invalid argument supplied for foreach()</p>
                                                                <p>Filename: cart/cart.php</p>
                                                                <p>Line Number: 211</p>
                                                            </div>
                                                        </select>
                                                    </div>
                                                    <div class="input-box" id="countory_select">
                                                        <select name="countory" id="countory" class="form-control">
                                                            <option value="0"> County/Region</option>
                                                        </select>
                                                    </div>
                                                    <div class="input-box">
                                                        <input class="form-control" type="text" name="buyer_State" id="buyer_State" placeholder="State/territory">
                                                    </div>
                                                    <div class="input-box">
                                                        <input class="form-control" type="text" name="buyer_postcode" id="buyer_postcode" placeholder="Postcode">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Contact Phone</label>
                                            <div class="control-box">
                                                <input class="form-control" type="text" name="buyer_phone" id="buyer_phone">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col2">
                                    <div class="shopping-title">Shipping Method</div>
                                    <div class="form-box02">
                                        <div class="form-group">
                                            <div class="input-box">
                                                <select name="lway_id" id="lway_id" class="form-control">
                                                    <option value="3">Mail/Home Delivery</option>
                                                </select>
                                                <div id='shop'></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="shopping-title">Payment Method</div>
                                    <div class="form-box02">
                                        <div class="form-group">
                                            <div class="input-box">
                                                <select name="pway_id" id="" class="form-control">
                                                    <option value="2">Online Card</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="shopping-title">Remarks</div>
                                    <div class="form-box02">
                                        <div class="form-group">
                                            <div class="input-box">
                                                <textarea cols="50" rows="5" class="form-control" name="buyer_note" id="buyer_note" placeholder="Do You Want to Tell the Seller?"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="title">Invoice Opening</div>
                        <div class="invoice-info-box">
                            <div class="invoice-form">
                                <div class="form-box02">
                                    <div class="row clearfix">
                                        <div class="col">
                                            <div class="form-group">
                                                <div class="control-box">
                                                    <div class="input-group">
                                                        <div class="input-box" id="invoice_select">
                                                            <select name="city" id="invoice" class="form-control">
                                                                <option value="0">Electronic Invoice</option>
                                                                <option value="1">Two-way Invoice</option>
                                                                <option value="2">Triple Invoice</option>
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
                                                            <select name="city" id="invoice carrier" class="form-control">
                                                                <option value="0">Member Vehicle</option>
                                                                <option value="0">Mobile Phone Carrier</option>
                                                                <option value="0">Natural Person Carrier</option>
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
                                                    <input class="form-control" type="text" name="receipt_address" id="receipt_address" placeholder="Company Letterhead">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="control-box">
                                                    <input class="form-control" type="text" name="receipt_address" id="receipt_address" placeholder="Uniform Numbers">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="form-group">
                                                <div class="control-box">
                                                    <input class="form-control" type="text" name="receipt_address" id="receipt_address" placeholder="Enter the Vehicle Number">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pagination_box">
                            <a href="<?= base_url('/products') ?>" class="btn simple en desktop"><i name="icon02" class="icon-chevron-left"></i> CONTINUE SHOPPING</a>

                            <a class="btn simple en bg2 btn-green-bg" onclick="checkForm.submit()">PROCEED TO CHECKOUT </i></a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>