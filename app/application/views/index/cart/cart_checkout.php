<link rel="stylesheet" type="text/css" href="/css/cart.css">
<div class="container">
                <section class="content">
                    <div class="title"><?=$this->lang['cart'];//購物車?></div>
                    <form action='/webpay/pay' method='post'>
                    <table class="table table-h cart-table">
                        <thead>
                            <tr>
                                <th class="align-left" colspan="2"><?=$this->lang['c_name'];//商品名稱?></th>
                                <th><?=$this->lang['c_price'];//金額?></th>
                                <th><?=$this->lang['c_num'];//數量?></th>
                                <th><?=$this->lang['c_sum'];//小計?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($productList as  $key=>$value) {?>
                            <tr>
                                <td class="img">
                                    <a href="/products/detail/<?=$value['prd_id'];?>" class="pic"><img style="height: 3.9em;" src="<?=$Spath;?><?=$value['prd_image'];?>" alt="<?=$value['prd_name'];?>"></a>
                                </td>
                                <td class="info align-left">
                                    <a href="/products/detail/<?=$value['prd_id'];?>">
                                        <span class="pd-name"><?=$value['prd_name'];?>
                                           <?=($this->data['web_config']['cart_spec_status']==1)?'('.$value['spec_name'].')':'';?>
                                        </span>
                                    </a>
                                </td>
                                <td data-title="金額："><?=$this->data['web_config']['currency'];?><?=$value['price'];?></td>
                                <td data-title="數量："><?=$value['num'];?></td>
                                <td data-title="小計："><?=$this->data['web_config']['currency'];?><?=$value['total'];?></td>
                            </tr>
                            <?php } ?>                            
                        </tbody>
                    </table>
                    <div class="sum-box">
                        <table class="table table-h sum-table">
                            <tfoot>
                                <tr>
                                    <td><?=$this->lang['c_total'];//小計?></td>
                                    <td><?=$this->data['web_config']['currency'];?><?=number_format($PriceSum,2);?></td>
                                </tr>
                                <?=$ship_cost;?>
                                <tr>
                                    <td><?=$this->lang['c_totalpay'];//總計?></td>
                                    <td><?=$this->data['web_config']['currency'];?><?=number_format($totalPrice,2);?></td>
                                </tr>
                                <tr>
                                    <td><?=$this->lang['c_20'];//現金?></td>
                                    <td><?=$this->data['web_config']['currency'];?><?=ceil($only_money);?></td>
                                </tr>
                                <tr>
                                    <td><?=$this->lang['c_19'];//紅利?></td>
                                    <td><?=$use_dividend?></td>
                                </tr>
																<tr>
																	<td><?=$this->lang['c_52'];//使用購物金?></td>
																	<td><?=$use_shopping_money?></td>
																</tr>
                                <tr><td colspan="2"><?=$this->lang['c_26'];//目前積點： 紅利?><span class="color01"><?=$d_dividend;?><?=$this->lang['c_27'];//點?></span></td></tr>
                                <tr><td colspan="2"><?=$this->lang['c_28'];//本次購買可再護得:紅利?><span class="color01"><?=$bonus;?><?=$this->lang['c_27'];//點?></span></td></tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="title"><?=$this->lang['c_1'];//運送 & 付款資訊?></div>
                    <div class="shopping-form">
                        <div class="row">
                            <div class="col col1">
                                <div class="shopping-title"><?=$this->lang['c_2'];//收件人資訊?></div>
                                <div class="form-box02">                                   
                                    <div class="form-group">
                                        <label class="control-label"><?=$this->lang['c_4'];//姓名?></label>
                                        <div class="control-box">
                                            <?=$buyer_name;?>
                                        </div>
                                    </div>                          
                                    <div class="form-group">
                                        <label class="control-label"><?=$this->lang['c_email'];//email?></label>
                                        <div class="control-box">
                                            <?=$buyer_email;?>
                                        </div>
                                    </div>                                            
                                    <div class="form-group address">
                                        <label class="control-label"><?=$this->lang['c_5'];//聯絡地址?></label>
                                        <div class="control-box">
                                            <div class="input-group">
                                                <div class="input-box">
                                                    <?=$country.' '.$county.' '.$area.'<br/>'.$buyer_address;?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <label class="control-label"><?=$this->lang['c_6'];//聯絡電話?></label>
                                        <div class="control-box">
                                            <?=$buyer_phone;?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col col2">
                                <div class="shopping-title"><?=$this->lang['c_7'];//運送方式：?><?=$this->lang['c_8'];//滿?><?=$freeShip;?><?=$this->lang['c_9'];//則免運費?></div>
                                <div class="form-box02">
                                    <div class="input-box"><?=$logistics_way['lway_name'];?></div>
                                    <?=$shop_address;?>
                                </div>
                                <div class="shopping-title"><?=$this->lang['c_10'];//付款方式?></div>
                                <div class="form-box02">
                                    <div class="input-box"><?=$payment_way['pway_name'];?></div>
                                </div>
                                <div class="shopping-title"><?=$this->lang['buyer_note'];//備註?></div>
                                <div class="form-box02">
                                    <div class="input-box"><?=$buyer_note;?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="title"><?=$this->lang['invoice'];//發票開立?></div>
                    <div class="invoice-info-box">
                        <div class="invoice-info"><?=$this->lang['receipt_title'];//公司抬頭?>:<?=$receipt_title;?></div>
                        <div class="invoice-info"><?=$this->lang['receipt_code'];//統一編號?>:<?=$receipt_code;?></div>
                        <div class="invoice-info"><?=$this->lang['receipt_zip'];//郵遞區號?>:<?=$receipt_zip;?></div>
                        <div class="invoice-info"><?=$this->lang['receipt_address'];//郵遞地址?>:<?=$receipt_address;?></div>                        
                    </div>
                    <input type='hidden' name='by_id' value='<?=$by_id?>'>
                    <input type='hidden' name='buyer_name' value='<?=$buyer_name;?>'>
                    <input type='hidden' name='buyer_email' value='<?=$buyer_email;?>'>
                    <input type='hidden' name='buyer_phone' value='<?=$buyer_phone;?>'>
                    <input type='hidden' name='buyer_zip' value='<?=$buyer_zip;?>'>
                    <input type='hidden' name='country' id='country' value='<?=$country;?>'>
                    <input type='hidden' name='county' id='county' value='<?=$county;?>'>
                    <input type='hidden' name='area' id='area' value='<?=$area;?>'>
                    <input type='hidden' name='buyer_address' id='buyer_address' value='<?=$buyer_address;?>'>
                    <input type='hidden' name='lway_id' id='lway_id' value="<?=$logistics_way['lway_id'];?>">
                    <input type='hidden' name='pway_id' id='pway_id' value="<?=$payment_way['pway_id'];?>">
                    <input type='hidden' name='shop_id' id='shop_id' value="<?=$shop_id;?>">
                    <input type='hidden' name='receipt_title' value="<?=$receipt_title;?>">
                    <input type='hidden' name='receipt_code' value="<?=$receipt_code;?>">
                    <input type='hidden' name='receipt_zip' value="<?=$receipt_zip;?>">
                    <input type='hidden' name='receipt_address' value="<?=$receipt_address;?>">
                    <input type='hidden' name='buyer_note' value="<?=$buyer_note;?>">
                    <input type="hidden" name="d_dividend" value="<?=$bonus?>">
                    <div class="pagination_box">
                        <a href="/cart/cart_checkout" class="btn simple"><i class="icon-chevron-left"></i> <?=$this->lang['c_13'];//回上一步?></a>
                        <button type="submit" class="btn simple bg2" style="visibility: visible;"><span style="display: block; min-height: 30px;">Pay with Card</span></button>
						<?php if($payment_way['pway_id']==8){ ?>
                        <input type='submit' class="btn simple bg2" value="<?=$this->lang['c_14'];//確認訂單?>">
						<?php }elseif($payment_way['pway_id']==2){ ?>
                        <!-- <form action="/webpay/pay" method="POST" id="paymentFrm"> -->
                            <!-- <script -->
                                <!-- src="https://checkout.stripe.com/checkout.js" class="stripe-button" -->
                                <!-- data-key="pk_test_1Rj3QEA26zCpbQIOW1Jvic5p" -->
                                <!-- data-amount="<//?=$stripe_money;?>" -->
                                <!-- data-name="supergoods.com.tw" -->
                                <!-- data-description="<//?=$this->lang_menu['jcymall'];//商城名稱?>" -->
                                <!-- data-image="/images/logo_s.svg" -->
                                <!-- data-zip-code="true" -->
                                <!-- data-currency="usd"> -->
                            <!-- </script><?/*data-locale="auto"*/?> -->
							<!-- <script> -->
								<!-- // $(".stripe-button-el").attr('class', 'btn simple bg2'); -->
							<!-- // </script> -->
                        <!-- </form> -->
						<?php } ?>
                    </div>
                </form>
                </section>
            </div>
        </main>
