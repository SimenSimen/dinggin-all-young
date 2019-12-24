<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
  <!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
  <!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
  <!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <!-- seo -->
  <title><?=$_CheckoutPage?> <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>

  <!-- wookmark -->
  <link rel="stylesheet" href="/css/wookmark/reset.css">
  <link rel="stylesheet" href="/css/wookmark/main.css">
  <link rel="stylesheet" href="/css/wookmark/style.css">
  <link href="/css/bootstrap.css" rel="stylesheet">

  <!-- product -->
  <link rel="stylesheet" href="/css/cart_list.css">

</head>

<body>

  <div id="container">
    
    <div id="main" role="main">
    <h1 style="text-align: center;"><?=$WillNotModified?></h1>
      <table id='check_table' style="border: 0px;">

        <tr>
          <td style="border: 0px;">
            <div class="order_div">

              <div style='float: left;'><h3><?=$ShoppingDetail?></h3></div>

              <div class="order_list">

                <table id='cart_list_table'>

                  <tr>

                    <td><?=$Commodity?></td>
                    <td><?=$UnitPrice?></td>
                    <td><?=$Quantity?></td>
                    <td><?=$Subtotal?></td>

                  </tr>

                  <?php foreach ($prd as $key => $value): ?>
                    <tr>

                      <td class="prd_name_td">
                      <?php if($value['prd_id'] != ''):?>
                        <a href="/cart/product_info/<?=$cset_code?>/<?=$value['prd_id']?>" target='_blank'>
                      <?php endif;?>
                          <div class="prd_img_div"><img class="prd_img" src="<?=$value['prd_image']?>"></div>
                          <div class="prd_name_div" style="text-align: left;"><?=$value['prd_name']?></div>
                      <?php if($value['prd_id'] != ''):?>
                        </a>
                      <?php endif;?>
                      </td>

                      <td class="prd_price00_td"><?=$value['prd_price00']?></td>

                      <td class="prd_amount_td">
                        <?=$prd_num[$key]?>
                        <!-- <select name="prd_amount">
                          <option value="0">0</option>
                          <option value="1" selected="">1</option>
                        </select> -->
                      </td>

                      <td class="cart_item_total"><?=$prd_total[$key]?></td>

                    </tr>
                  <?php endforeach; ?>

                </table>
<span class=""><?=$buy_tips?> </span>
                <div class="price_info_div">
                  <span class="item"><?=$Altogether?></span>
                  <span class="item_num"><?=$user_cart_num?></span>
                  <span class="item"><?=$Item?></span>

                  <span class="total"><?=$TotalMoneyTWD?></span>
                  <span class="total_price"><?=$total?><?=$Yuan?></span>

                </div>

              </div>
              <p style="height: 70px;">&nbsp;</p>
              <div class="buyer_div">
              
              <div style='float: left;'><h3><?=$ReceiverInformation?></h3></div>

                <form action='/cart/check/<?=$cset_code?>/3' method='post' id='buyer_info_form'>
                  <input type="hidden" name="total_price" value="<?=$total?>">
                  <table id='buyer_table'>

                    <tr>
                      <td class='buyer_left_td'><span class='red_star'>*</span><?=$FullName?></td>
                      <td><?=$post['buyer_name_r']?><input type='hidden' name='buyer_name' value='<?=$post['buyer_name_r']?>'></td>
                    </tr>

                    <tr>
                      <td class='buyer_left_td'><span class='red_star'>*</span><?=$Phone?></td>
                      <td><?=$post['buyer_phone_r']?><input type='hidden' name='buyer_phone' value='<?=$post['buyer_phone_r']?>'></td>
                    </tr>

                    <tr>
                      <td class='buyer_left_td'><span class='red_star'>*</span><?=$Mailbox?></td>
                      <td><?=$post['buyer_email_r']?><input type='hidden' name='buyer_email' value='<?=$post['buyer_email_r']?>'></td>
                    </tr>

                    <tr>
                      <td class='buyer_left_td'><span class='red_star'>*</span><?=$Address?></td>
                      <td>
                        <?=$post['addr_zip']?> <?=$post['addr_county']?><?=$post['addr_area']?><?=$post['buyer_address_r']?>
                        <input type='hidden' name='buyer_address' value='<?=$post['buyer_address_r']?>'>
                        <input type='hidden' name='addr_zip' value='<?=$post['addr_zip']?>'>
                        <input type='hidden' name='addr_county' value='<?=$post['addr_county']?>'>
                        <input type='hidden' name='addr_area' value='<?=$post['addr_area']?>'>
                      </td>
                    </tr>

                    <tr>
                      <td class='buyer_left_td'><span class='red_star'>*</span><?=$PaymentMethods?></td>
                      <td>
                        <?=$pway_info['pway_name']?>
                        <?php if ($pway_info['pway_image'] != ''): ?><p><img src='<?=$pway_info['pway_image']?>' style="width:40%;"></p><?php endif; ?>
                        <input type='hidden' name='iqrt_id' value='<?=$buyer_pay_way['iqrt_id']?>'>
                        <input type='hidden' name="pway_id" value="<?=$buyer_pay_way['pway_id']?>">
                      </td>
                    </tr>

                    <?php if(!empty($buyer_logist_way) && !empty($lway_info)):?>
                    <tr>
                      <td class='buyer_left_td'><span class='red_star'>*</span><?=$DeliveryMethod?></td>
                      <td>
                        <?=$lway_info['lway_name']?>
                        <?php if ($lway_info['lway_image'] != ''): ?><p><img style="padding: 5px;" src='<?=$lway_info['lway_image']?>'></p><?php endif; ?>
                      </td>
                    </tr>
                    <?php endif;?>
                    <input type='hidden' name='lway_iqrt_id'    value="<?=$buyer_logist_way['iqrt_id']?>">
                    <input type='hidden' name="lway_id"         value="<?=$lway_info['lway_id']?>">
                    <input type="hidden" name="cart_fee"      value="<?=$cart_paying?>">
                    
                    <?php if($store['cset_receipt_btn']): ?>
                    <tr>
                      <td class='buyer_left_td'><?=$InvoiceTitle?></td>
                      <td><?=$post['receipt_title']?><input type='hidden' name='receipt_title' value='<?=$post['receipt_title']?>'></td>
                    </tr>

                    <tr>
                      <td class='buyer_left_td'><?=$TongBian?></td>
                      <td><?=$post['receipt_code']?><input type='hidden' name='receipt_code' value='<?=$post['receipt_code']?>'></td>
                    </tr>

                    <tr>
                      <td class='buyer_left_td'><?=$InvoiceAddress?></td>
                      <td>
                        <?=$post['receipt_zip']?> <?=$post['receipt_county']?><?=$post['receipt_area']?><?=$post['receipt_address']?>
                        <input type='hidden' name='receipt_address' value='<?=$post['receipt_address']?>'>
                        <input type='hidden' name='receipt_zip' value='<?=$post['receipt_zip']?>'>
                        <input type='hidden' name='receipt_county' value='<?=$post['receipt_county']?>'>
                        <input type='hidden' name='receipt_area' value='<?=$post['receipt_area']?>'>
                      </td>
                    </tr>

                    <?php if ($post['receipt_title'] != '' && $post['receipt_code'] != '' && $post['receipt_zip'] != '' && $post['receipt_county'] != '' && $post['receipt_area'] != '' && $post['receipt_address'] != ''): ?>
               
                    <?php else: ?>

                      <tr>
                        <td colspan="2">
                          <p style="color: red;"><?=$NotFilledInvoice?></p>
                        </td>
                      </tr>

                    <?php endif; ?>
                    <?php endif; ?>

                    <tr>
                      <td colspan="2">
                        <p><?=$ProtectGoodsNum?></p>
                        <input type='hidden' name='by_id' id='by_id' value='<?=$post['by_id']?>'>
                        <input type='button' name='back' id='back' value='<?=$ReturnModifyInformation?>' onclick="window.history.back();" class='btn btn-warning btn-large' style="color:#000000;font-weight:bold;">
                        <input type='submit' name='send' id='send' value='<?=$SendOrders?>' class='btn btn-warning btn-large' style="color:#000000;font-weight:bold;">
                      </td>
                    </tr>

                  </table>

                </form>

              </div>


            </div>

          </td>
        </tr>
        
      </table>
      <p style="height: 30px;">&nbsp;</p>
    </div>

  </div>
  <p id='cset_code' style="display:none;"><?=$cset_code?></p>
  <!-- This jsPlugin of Filter © jQuery Wookmark -->

  <style type="text/css">
    #main {
      font-size: 18px;
      width: 900px;
      padding: 55px 0px 20px 0px;
      margin: 0px auto;
    }
    input[type=text]{width:90%;}
    select{width:93%;}
    .buyer_left_td{width: 30%;}
    #buyer_table tr td {vertical-align: middle;}
    .red_star{color: red;}
    * { font-family: '微軟正黑體';}
  </style>

  <script src="/js/cart_check.js"></script>

</body>
</html>
