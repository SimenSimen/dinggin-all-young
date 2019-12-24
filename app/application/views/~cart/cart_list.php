<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
  <!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
  <!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
  <!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
  <!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <!-- seo -->
  <title><?=$CheckoutPage?> - <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script type="text/javascript" src="/js/jquery.validate.min.js"></script>
  <script type="text/javascript" src="/js/messages_tw.js" charset="utf-8"></script>
  <script type="text/javascript" src="/js/jquery.twzipcode.min.js"></script>

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
    <h1 style="text-align: center;"><?=$CheckoutPage?>&nbsp;
      <a title='<?=$BackStoreHome?>' style="display: inline-block;" href="/cart/store/<?=$cset_code?>"><img style="width:50px;" src="/images/home.png"></a>
      <?php if ($user_login): ?><a style="display: inline-block;" href="/cart/user_logout/<?=$cset_code?>/cart_list" ><img style="width: 47px;position: relative;top: -3px;" src="/images/cart/cart_logout.png" title="<?=$SignOut?>"></a><?php endif; ?>
    </h1>
      
      <form action='/cart/check/<?=$cset_code?>/2' method='post' id='buyer_info_form'>
             
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
                    <td><?=$Change?></td>

                  </tr>

                  <?php foreach ($prd as $key => $value): ?>
                    <tr>
                    <input type='hidden' id='amount<?=$key?>' value="<?=$value['prd_amount']?>">
                    <input type="hidden" id="price<?=$key?>" value="<?=$value['prd_price00']?>">
                      <td class="prd_name_td">
                        <a href="/cart/product_info/<?=$cset_code?>/<?=$value['prd_id']?>" target='_blank'>
                          <div class="prd_img_div"><img class="prd_img" src="<?=$img_url?>set_<?=substr($value['prd_image'],1)?>"></div>
                          <div class="prd_name_div" style="text-align: left;"><?=$value['prd_name']?></div>
                        </a>
                      </td>

                      <td class="prd_price00_td"><?=$value['prd_price00']?></td>

                      <td class="prd_amount_td">
                      <?php if($value['prd_lock_amount'] < $value['prd_amount']): ?>
                        <input type="number" style="width: 45px; text-align: center;" min='1' max="<?=$value['prd_lock_amount']?>" id="buy<?=$key?>" name="buy[<?=$key?>]" value="<?=$prd_num[$key]?>">
                      <?php else: ?>
                        <input type="number" style="width: 45px; text-align: center;" min='1' max="<?=$value['prd_amount']?>" id="buy<?=$key?>" name="buy[<?=$key?>]" value="<?=$prd_num[$key]?>">
                      <?php endif; ?>  
                        <!-- <select name="prd_amount">
                          <option value="0">0</option>
                          <option value="1" selected="">1</option>
                        </select> -->
                      </td>

                      <td class="cart_item_total"><span id="count<?=$key?>"><?=$prd_total[$key]?></span></td>

                      <td class="cart_item_delete"><a style="cursor: pointer;" class="del_prd" id='del_prd_<?=$key?>'><img src='/images/_close.png' style="width: 30px;" title='<?=$RemoveItem?>'></a></td>

                    </tr>
<script type='text/javascript'>
$(function() {
  $('#buy<?=$key?>').change(function() {
    var $_buy = Number($("#buy<?=$key?>").val()), $_price = $("#price<?=$key?>"), $_amount = Number($('#amount<?=$key?>').val());
    if($_buy != '' || $_buy != '0')
    {
      if ($_buy > $_amount)
      {
        alert('您輸入的數量過大，目前庫存為：' + $_amount);
        return false;
      }
      else
      {
        var price = $('#buy<?=$key?>').val() * $('#price<?=$key?>').val();
        $('#count<?=$key?>').text(price).change();
      }
    }
    else
    {

      if($_buy == Number(0))
      {
        alert('數量不可以是 0');
        value_return();
      }
      else
      {
        alert('請輸入數量');
        value_return();
      }
    }
  });

  function value_return() {
    $('#buy<?=$key?>').focus();
    $('#buy<?=$key?>').val(1);
    var price = $('#buy<?=$key?>').val() * $('#price<?=$key?>').val();
    $('#count<?=$key?>').text(price).change();
    return false;
  }
});
</script>   
                  <?php endforeach; ?>

                </table>

                <div class="price_info_div">

                  <span class="item"><?=$Altogether?></span>
                  <span class="item_num"><?=$user_cart_num?></span>
                  <span class="item"><?=$Item?></span>

                  <!-- <span class="total">消費總金額(TWD)：</span>
                  <span class="total_price"><?=$total?>元</span> -->

                </div>

              </div>
              <p style="height: 70px;">&nbsp;</p>
              <div class="buyer_div">
              
                <div >
                  <h3><?=$ReceiverInformation?><h4><input type="checkbox" id="somemember" value="1">同會員資料</h4>&nbsp;&nbsp;
                    <?php //if ($by_id == 0): ?>
                      <!-- <a id='login_switch' href='/cart/login_switch/<?=$cset_code?>'><?=$_SignIn?></a> -->
                    <?php //endif; ?>
                  </h3>
                </div>
                <!-- <?php if ($by_id != 0): ?><div style='float:right;color: #aaaaaa;'><h3><?=$SignIn_2?><?=$buyer['by_email']?></div></h3><?php endif; ?> -->

                  <table id='buyer_table'>

                    <?php if ($by_id != 0): ?>
                      <!-- <tr id='history_tr'>
                        <td><?=$HistoricalOrderDetails?></td>
                        <td style="text-align:left;">
                          <?php if (!empty($history)): ?>
                            <select id="history_select">
                              <option value=""><?=$Select?></option>
                              <?php foreach ($history as $key => $value): ?>
                                <option value="<?=$value['id']?>"><?=$value['name'].' - '.$value['zip'].' '.$value['county'].$value['area'].$value['address']?></option>
                              <?php endforeach; ?>
                            </select>
                          <?php else: ?>
                            <?=$HistoricalOrderDeta?>
                          <?php endif; ?>
                      </tr>
                    <?php endif; ?> -->

                    <tr>
                      <td class='buyer_left_td'><span class='red_star'>*</span><?=$FullName?></td>
                      <td style="text-align:left;"><input type="text" name='buyer_name_r' id='buyer_name' class="required" maxlength='32'></td>
                    </tr>

                    <tr>
                      <td class='buyer_left_td'><span class='red_star'>*</span><?=$Phone?></td>
                      <td style="text-align:left;font-size:0.8em;"><?php if($by_id == 0):?><?//=$ThisNumberPasseword?><br/><?php endif;?><input type="text" name='buyer_phone_r' id='buyer_phone' class="required number" minlength='10' maxlength='10'></td>
                    </tr>

                    <tr>
                      <td class='buyer_left_td'><?=$Mailbox?></td>
                      <td style="text-align:left;font-size:0.8em;"><? //=$MailFillInCorrect?><?php if($by_id == 0):?><?//=$MailThereafterLogin?><?php endif;?><br><input type="text" name='buyer_email_r' id='buyer_email' class=" email" maxlength='255'></td>
                    </tr>

                    <tr>
                      <td class='buyer_left_td'><span class='red_star'>*</span><?=$Address?></td>
                      <td style="text-align:left;">
                        <div id="twzipcode">
                          <div data-role="zipcode" style="float:left;width: 15%;"></div>
                          <div data-role="county" style="float:left;margin-right: 5px;"></div>&nbsp;
                          <div data-role="district" style="float:left;"></div>
                        </div>
                        <input type="text" name='buyer_address_r' id='buyer_address' class="required" maxlength='255'>
                      </td>
                    </tr>

                    <tr>
                      <td class='buyer_left_td'><span class='red_star'>*</span><?=$PaymentMethods?></td>
                      <td style="text-align:left;">
                        <p>
                          <select name='buyer_pay_way' id='buyer_pay_way' class="required">
                            <option value=''><?=$Select?></option>
                            <?php if (!empty($payment_way)): ?>
                              <?php foreach ($payment_way as $key => $value): ?>
                                <option value='<?=$value['pway_id']?>'><?=$value['pway_name'].' ('.$value['pway_code'].')'?></option>
                              <?php endforeach; ?>
                            <?php endif; ?>
                          </select>
                        </p>
                      </td>
                    </tr>

                    <?php if (!empty($logistics_way)): ?>
                    <tr>
                      <td class='buyer_left_td'><span class='red_star'>*</span><?=$DeliveryMethod?></td>
                      <td style="text-align:left;">
                        <p>
                          <select name='buyer_logist_way' id='buyer_logist_way' class="required">
                            <option value=''><?=$Select?></option>
                            <?php foreach ($logistics_way as $log_key => $log_value): ?>
                              <?php if($log_value['lway_id'] != 4): ?>
                                <option value='<?=$log_value['lway_id']?>'><?=$log_value['lway_name']?><?php if($log_value['business_account'] != ''):?> (<?=$Shipment?> <?=$log_value['business_account']?> <?=$Yuan?>)<?php endif; ?></option>
                              <?php endif; ?>
                            <?php endforeach; ?>
                          </select>
                        </p>
                      </td>
                    </tr>
                    <?php endif; ?>

                    <?php if($store['cset_receipt_btn']): ?>
                    <tr>
                      <td class='buyer_left_td'><?=$InvoiceTitle?></td>
                      <td style="text-align:left;"><input type="text" name='receipt_title' id='receipt_title' maxlength='64'></td>
                    </tr>

                    <tr>
                      <td class='buyer_left_td'><?=$TongBian?></td>
                      <td style="text-align:left;"><input type="text" name='receipt_code' id='receipt_code' class="number" minlength='8' maxlength='8'></td>
                    </tr>

                    <tr>
                      <td class='buyer_left_td'><span class='red_star'>*</span><?=$InvoiceAddress?></td>
                      <td style="text-align:left;">
                        <div id="receipt">
                          <div data-role="zipcode" style="float:left;width: 15%;"></div>
                          <div data-role="county" style="float:left;margin-right: 5px;"></div>&nbsp;
                          <div data-role="district" style="float:left;"></div>
                        </div>
                        <input type="text" name='receipt_address' id='receipt_address' maxlength='255'>
                        <input type="radio" name="someadd" id='same_address'>同收貨地址
                        <input type="radio" name="someadd" id='member_address'>同會員地址
                      </td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                      <td colspan="2">
                        <input type='hidden' name='by_id' id='by_id' value='<?=$by_id?>'>
                        <input type='submit' name='send' id='send' value='<?=$PreviewOrder?>' class='btn btn-warning btn-large' style="color:#000000;font-weight:bold;">
                      </td>
                    </tr>

                  </table>

              </div>


            </div>

          </td>
        </tr>
        
      </table>
      </form>

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
    input[type=text]{width:65%;}
    input[name=text]{width:65%;}
    select{width:68%;}
    .buyer_left_td{width: 30%;}
    .red_star{color: red;}
    label.error {
      color:red;
      font-size: 1.1em;
      font-family: "微軟正黑體", Arial,Century Gothic,sans-serif;
      line-height: 160%;
      letter-spacing: 1pt;
      text-indent: 5px;
    }
    label.success {
      display: inline;
    }
    #login_switch:hover{ text-decoration: none;}
  </style>
  
  <script src="/js/cart_check.js"></script>

</body>
</html>
<script>
  $('#somemember').click(function(){    

    var bid=$('#by_id').val();
   
    $.ajax({
      url:'/gold/get_member',
      type:'POST',
      data: 'bid='+bid,
      dataType: 'json',
      success: function( json ) 
      {
        console.log(json);
          $('#buyer_name').val(json.name);
          $('#buyer_phone').val(json.mobile);
          $('#buyer_email').val(json.by_email);
          $('input[name=addr_zip]').val(json.zipcode);
          $('select[name=addr_county]').val(json.city);
          $('select[name=addr_area] option').remove();
          $('select[name=addr_area]').prepend("<option value='"+json.countory+"'>"+json.countory+"</option>");
          $('#buyer_address').val(json.address);

      }
    });
  });
  $('#member_address').click(function(){
    var bid=$('#by_id').val();
    $.ajax({
      url:'/gold/get_member',
      type:'POST',
      data: 'bid='+bid,
      dataType: 'json',
      success: function( json ) 
      {
          $('input[name=receipt_zip]').val(json.zipcode);
          $('select[name=receipt_county]').val(json.city);
          $('select[name=receipt_area] option').remove();
          $('select[name=receipt_area]').prepend("<option value='"+json.countory+"'>"+json.countory+"</option>");
          $('#receipt_address').val(json.address);
      }
    });
  });
</script>