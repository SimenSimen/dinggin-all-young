<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- seo -->
  <title><?=$CheckoutPage?> - <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>
  <!--icon-->
  <link href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <!-- css -->
  <!-- js -->
  <link rel="stylesheet" href="/css/colors.css">
  <link rel="stylesheet" href="/js/jqm/jquery.mobile-1.4.2.min.css">
  <script src="/js/jqm/jquery.js"></script>
  <script src="/js/jqm/jquery.mobile-1.4.2.min.js"></script>
  <style type="text/css">* { font-family: '微軟正黑體';}</style>
</head>
<body>
<div data-role="page" class="type-interior ui-page ui-body-c ui-page-active" id="page1">
  <div data-role="header" class="ui-header ui-bar-b" data-theme="b" role="banner">
    <a onclick="window.location.href='<?=$cart_link?>'" data-icon="home" class="ui-btn-left ui-btn ui-shadow ui-btn-corner-all ui-btn-icon-left ui-btn-up-a" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="a"><span class="ui-btn-inner ui-btn-corner-all"><span class="ui-btn-text"><i class="fa fa-home"></i></span><span class="ui-icon ui-icon-arrow-l ui-icon-shadow">&nbsp;</span></span></a>
    <h1><?=$OrderCheck?></h1>
    <a onclick="window.location.href='/cart/check/<?=$cset_code?>/1'" data-icon="home" class="ui-btn-right ui-btn ui-shadow ui-btn-corner-all ui-btn-icon-right ui-btn-up-a" data-corners="true" data-shadow="true" data-iconshadow="true" data-theme="a"><i class="fa fa-shopping-cart"></i></a>
  </div>
 
  <div data-role="content" data-theme="d">
    <div id='return_div' style="display:none;">
      <button type="button" data-theme="b" name='back' id='back' class="ui-btn-hidden" aria-disabled="false" onclick="javascript:window.location.href='/cart/store/<?=$cset_code?>';"><?=$OrderSent?></button>
    </div>
 	<!-- It's needed to set `data-ajax='false'` in order to disabled Async. `cause its default is true. -->
    <form id='form1' data-ajax='false' action="/cart/check/<?=$cset_code?>/3" method='post'>
      <h2 style="text-align: center;"><?=$WillNotModified?></h2>
      <table id="check_table" style="border: 0px; width:100%;">
      <tr>
        <td style="border: 0px;">
          <div class="order_div">
            <div style='float: left;'><h3><?=$ShoppingDetail?></h3></div><br><br>
            <div class="order_list">
              <table id='cart_list_table' style="width: 100%; border: 1px solid #cccccc; ">
                <?php foreach ($prd as $key => $value): ?>
                  <tr><td colspan="2"><? if($key > 0):?><hr style="border-color: #ffffff;"><?endif?></td></tr>
                  <tr>
                    <td style="width: 80%;"><div class="prd_name_div" style="text-align: left;"><?=$value['prd_name']?></div></td>
                  </tr>
                  <tr>
                    <td>
                      <table style="width: 100%;">
                        <tr>
                          <td><div class="prd_img_div"><img style="width:150px;" class="prd_img" src="<?=$value['prd_image']?>"></div></td>
                          <td><p><?=$_Quantity?><?=$prd_num[$key]?></p>
                            <p><?=$_Subtotal?><span class='price_style'>$ <?=$prd_total[$key]?></span></p></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </table>
              <div class="price_info_div">
              <p>
                <span class="item"><?=$Altogether?></span>
                <span class="item_num"><?=$user_cart_num?></span>
                <span class="item"><?=$Item?></span>
              </p>
              <p>
                <span class="total"><?=$TotalMoneyTWD?></span>
                <span class="price_style">$ <?=$total?><?=$Yuan?></span>
              </p>
              </div>
            </div>
          </div>
          
          <table width="0" border="0" class="bonus">
            <tr>
              <th>紅利折抵</th>
              <td><input name="subdivid" id="subdivid" type="number" min="0" max="<?=$dividend?>" value="0" /><span>目前紅利：<em><?=$dividend?>點</em> (1紅利 = NT$1元)</span></td>
            </tr>
            <tr>
              <th>運費</th>
              <td><?=$lway_info['business_account']?>元 (<?=$lway_info['lway_name']?>)</td>
            </tr>

            <tr>
              <td colspan="2"><p>總計：<font id="alltotal"><?=$alltotal?></font>元</p></td>
              <input type="hidden" name="alltotal" id="alltotal1" value="<?=$alltotal?>">
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td><div style='float: left;'><h3><?=$ReceiverInformation?></h3></div></td>
      </tr>
      <tr>
        <td>
          <form action="/cart/check/<?=$cset_code?>/3" method='post' id='buyer_info_form'>
          <input type="hidden" name="total_price" value="<?=$total?>">
            <table id='buyer_table'>
              <tr>
                <td><?=$_FullName?><?=$post['buyer_name_r']?><input type='hidden' name='buyer_name' value='<?=$post['buyer_name_r']?>'></td>
              </tr>
              <tr>
                <td><?=$_Phone?><?=$post['buyer_phone_r']?><input type='hidden' name='buyer_phone' value='<?=$post['buyer_phone_r']?>'></td>
              </tr>
              <tr>
                <td><?=$_Mailbox?><?=$post['buyer_email_r']?><input type='hidden' name='buyer_email' value='<?=$post['buyer_email_r']?>'></td>
              </tr>
              <tr>
                <td>
                  <?=$_Address?><?=$post['addr_zip']?> <?=$post['addr_county']?><?=$post['addr_area']?><?=$post['buyer_address_r']?>
                  <input type='hidden' name='buyer_address' value='<?=$post['buyer_address_r']?>'>
                  <input type='hidden' name='addr_zip' value='<?=$post['addr_zip']?>'>
                  <input type='hidden' name='addr_county' value='<?=$post['addr_county']?>'>
                  <input type='hidden' name='addr_area' value='<?=$post['addr_area']?>'>
                </td>
              </tr>
              <tr>
                <td>
                  <?=$_PaymentMethods?><?=$pway_info['pway_name']?>
                  <?php if ($pway_info['pway_image'] != ''): ?><p><img src='<?=$pway_info['pway_image']?>' style="width:40%;"></p><?php endif; ?>
                  <input type='hidden' name='iqrt_id' value='<?=$buyer_pay_way['iqrt_id']?>'>
                  <input type='hidden' name="pway_id" value="<?=$buyer_pay_way['pway_id']?>">
                </td>
              </tr>
              <?php if(!empty($buyer_logist_way) && !empty($lway_info)):?>
              <tr>
                <td>
                  <?=$_DeliveryMethod?><?=$lway_info['lway_name']?>
                  <?php if ($lway_info['lway_image'] != ''): ?><p><img src='<?=$lway_info['lway_image']?>' style="width:10%;"></p><?php endif; ?>
                </td>
              </tr>
              <?php endif;?>
              <input type='hidden' name='lway_iqrt_id'    value="<?=$buyer_logist_way['iqrt_id']?>">
              <input type='hidden' name="lway_id"         value="<?=$lway_info['lway_id']?>">
              <input type="hidden" name="cart_fee"      value="<?=$cart_paying?>">
            <?php if($store['cset_receipt_btn']): ?>
              <tr>
                <td><?=$_InvoiceTitle?><?=$post['receipt_title']?><input type='hidden' name='receipt_title' value='<?=$post['receipt_title']?>'></td>
              </tr>
              <tr>
                <td><?=$_TongBian?><?=$post['receipt_code']?><input type='hidden' name='receipt_code' value='<?=$post['receipt_code']?>'></td>
              </tr>
              <tr>
                <td>
                  <?=$_InvoiceAddress?><?=$post['receipt_zip']?> <?=$post['receipt_county']?><?=$post['receipt_area']?><?=$post['receipt_address']?>
                  <input type='hidden' name='receipt_address' value='<?=$post['receipt_address']?>'>
                  <input type='hidden' name='receipt_zip' value='<?=$post['receipt_zip']?>'>
                  <input type='hidden' name='receipt_county' value='<?=$post['receipt_county']?>'>
                  <input type='hidden' name='receipt_area' value='<?=$post['receipt_area']?>'>
                </td>
              </tr>
              <?php if ($post['receipt_title'] != '' && $post['receipt_code'] != '' && $post['receipt_zip'] != '' && $post['receipt_county'] != '' && $post['receipt_area'] != '' && $post['receipt_address'] != ''): ?>
               
              <?php else: ?>
                <tr>
                  <td><p style="color: red;"><?=$NotFilledInvoice?></p></td>
                </tr>
              <?php endif; ?>
            <?php endif; ?>
              <tr>
                <td colspan="2">
                  <p><?=$ProtectGoodsNum?></p>
                  <input type="hidden" name="total_price" value="<?=$total?>">
                  <input type="hidden" name="total_pv" value="<?=$total_pv?>">
                  <input type='hidden' name='by_id' id='by_id' value='<?=$post['by_id']?>'>
                  <button type="button" data-theme="b" name='back' id='back' class="ui-btn-hidden" aria-disabled="false" onclick="javascript:window.location.href='/cart/check/<?=$cset_code?>/1';"><?=$ReturnReFill?></button>
                  <input type="submit" data-theme="b" value="<?=$SendOrders?>">
                </td>
              </tr>
            </table>
          </form>
        </td>
      </tr>
    </table>
    <p style="height: 30px;">&nbsp;</p>
    </form>
  </div>
</div>
<style type="text/css">
	.bonus{	clear:both; padding:10px 0; width:100%;}
	.bonus span{ font-size:.8em; display:block; text-align:right;}
	.bonus em{ color:#F00; margin:0 10px 0 0;}
	.bonus tr th, .bonus tr td{ border-bottom:1px #CCC solid; padding:10px 3px;}
	.bonus tr th:last, .bonus tr td:last { border-bottom:none;}
	.bonus tr td input{ width:200px; margin:0 20px 0 0;}
	.bonus tr td{ text-align:left !important;}
	.bonus p{ display:inline-block; float:right; font-weight:bold;}
	.bonus font{ color:#F00;}
</style>
</body>
</html>
<script>
$('#subdivid,#subpv').blur(function(){
    total=<?=$alltotal?>;
    var divid=<?=$dividend?>;
    plv=$('#subdivid').val();
    if(plv>divid){
      alert('已超過目前紅利折抵');
      $(this).val('0'); 
    }
    else{
      $.ajax({
          url:'/cart/subprice',
          type:'POST',
          data: 'pval=' + plv+'&total='+total,
          dataType: 'json',
          success: function( json ) 
          {
             $('#alltotal').text(json);
             $('#alltotal1').val(json);
          }
      });
     }
});
</script>