<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title><?=$_Order_Details?> <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <!-- css -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">

  <!--icon-->
  <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

  <!-- jQuery -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script><!--jQuery library-->
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  
  <!-- bootstrap -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>

</head>

<center>
<body scroll="yes" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center; overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

  <div>

    <h3 style="font-family: '微軟正黑體';"><?=$OrderNo?><?=$order['order_id']?></h3>
    <h5 style="font-family: '微軟正黑體'; padding-top: 3px;"><?=$_CreationDate?><?=date('Y-m-d H:i', $order['date'])?></h5>
    <p style="padding-bottom: 10px;"></p>

    <table class='table' id='mian_table'>
      <tr>
        <td width="25%" class='th'><?=$UsuallyPeopleName?></td>
        <td width="25%" class='th'><?=$UsuallyPeoplePhone?></td>
        <td width="25%" class='th'><?=$PaymentStatus?></td>
        <td width="25%" class='th'><?=$OrderStatus?></td>
      </tr>
      <tr>
        <td><?=$order['name']?></td>
        <td><?=$order['phone']?></td>
        <td><span id='<?=$jquery_status?>' title='<?=$ClickChange?>'><?=$status?></span></td>
        <td><span id='<?=$jquery_id?>' title='<?=$ClickChange?>'><?=$product_flow?></span></td>
      </tr>
      <tr>
        <td colspan="1" class='th'><?=$PaymentMethod?></td>
        <td colspan="1" class='th'><?=$UsuallyPeopleMail?></td>
        <td colspan="2" class='th'><?=$UsuallyPeopleAddress?></td>
      </tr>
      <tr>
        <td colspan="1"><?=$pway_name?></td>
        <td colspan="1"><?=$order['email']?></td>
        <td colspan="2"><?=$order['zip'].' '.$order['county'].$order['area'].$order['address']?></td>
      </tr>
      <tr>
        <td colspan="4"class='th'><?=$OrderProductDetails?></td>
      </tr>
      <tr>
        <td colspan="4">
            <table class='table' id='sub_table'>
              <tr>
                <td style="width: 400px; border-bottom: 1px solid #cccccc; border-left: 1px solid #ffffff; border-right: 1px solid #ffffff;"><?=$ProductName?></td>
                <td style="border-bottom: 1px solid #cccccc; border-right: 1px solid #ffffff;"><?=$Price?></td>
                <td style="border-bottom: 1px solid #cccccc; border-right: 1px solid #ffffff;"><?=$Quantity?></td>
                <td style="border-bottom: 1px solid #cccccc; border-right: 1px solid #ffffff;"><?=$Subtotal?></td>
              </tr>
              <?php foreach ($items as $key => $value): ?>
                <?php if ($key != (count($items) - 1)): ?>
                  <tr>
                    <td style="border-bottom: 1px solid #cccccc; border-left: 1px solid #ffffff; border-right: 1px solid #ffffff;"><div style='word-break:break-all; text-align: center;'><?=$value['name']?></div></td>
                    <td style="border-bottom: 1px solid #cccccc; border-right: 1px solid #ffffff;"><?=$value['amount']?></td>
                    <td style="border-bottom: 1px solid #cccccc; border-right: 1px solid #ffffff;"><?=$value['quantity']?></td>
                    <td style="border-bottom: 1px solid #cccccc; border-right: 1px solid #ffffff;"><?=($value['quantity'] * $value['amount'])?></td>
                  </tr>
                <?php else: ?>
                  <tr>
                  <td style="border-right: 1px solid #ffffff; border-left: 1px solid #ffffff; border-bottom: 1px solid #cccccc;"><div style='word-break:break-all; text-align: center;'><?=$value['name']?></div></td>
                  <td style="border-right: 1px solid #ffffff; border-bottom: 1px solid #cccccc;"><?=$value['amount']?></td>
                  <td style="border-right: 1px solid #ffffff; border-bottom: 1px solid #cccccc;"><?=$value['quantity']?></td>
                  <td style="border-right: 1px solid #ffffff; border-bottom: 1px solid #cccccc;"><?=($value['quantity'] * $value['amount'])?></td>
                </tr>
                <?php endif; ?>
              <?php endforeach; ?>
              <tr>
                <td colspan='4' style="text-align: right;border: 1px solid #ffffff;"><?=$_TotalAmount?><span class='dollar'>$<?=$total?> <?=$Yuan?></span></td>
              </tr>
            </table>
        </td>
      </tr>
      <?php if (!empty($ipn)): ?>
        <!-- paypal -->
        <tr>
          <td colspan="4"class='th'><?=$CheckoutInformation?></td>
        </tr>
        <?php if ($order['pay_way_id'] == 2): ?>
          <tr>
            <td colspan="4">
              <table class='table' id='receipt_table'>
                <tr>
                  <td style="width:18%; border-bottom: 1px solid #cccccc; text-align: center; border-right: 1px solid #ffffff; border-left: 1px solid #ffffff;"><?=$TransactionIdPaypal?></td>
                  <td style="width:26%; border-bottom: 1px solid #cccccc; text-align: center; border-right: 1px solid #ffffff;"><?=$TransactionHour?></td>
                  <td style="width:18%; border-bottom: 1px solid #cccccc; text-align: center; border-right: 1px solid #ffffff;"><?=$AmountTransaction?></td>
                  <td style="width:40%; border-bottom: 1px solid #cccccc; text-align: center; border-right: 1px solid #ffffff;">交易信箱</td>
                </tr>
                <tr>
                  <td style="border-right: 1px solid #ffffff; text-align: center; border-left: 1px solid #ffffff; border-bottom: 1px solid #ffffff;"><?=$ipn['txn_id']?></td>
                  <td style="border-right: 1px solid #ffffff; text-align: center; border-bottom: 1px solid #ffffff;"><?=date('Y-m-d H:i', $ipn['addtime'])?></td>
                  <td style="border-right: 1px solid #ffffff; text-align: center; border-bottom: 1px solid #ffffff;"><?=$ipn['mc_gross']?></td>
                  <td style="border-right: 1px solid #ffffff; border-bottom: 1px solid #ffffff;"><div style='word-break:break-all; text-align: center;'><?=$ipn['payer_email']?></div></td>
                </tr>
              </table>
            </td>
          </tr>
        <?php endif; ?>

        <?php if ($order['pay_way_id'] == 5): ?>
          <tr>
            <td colspan="4">
              <table class='table' id='receipt_table'>
                <tr>
                  <td style="width:18%; border-bottom: 1px solid #cccccc; text-align: center; border-right: 1px solid #ffffff; border-left: 1px solid #ffffff;"><?=$AuthorizeSingle?></td>
                  <td style="width:40%; border-bottom: 1px solid #cccccc; text-align: center; border-right: 1px solid #ffffff;"><?=$TransferTime?></td>
                  <td style="width:18%; border-bottom: 1px solid #cccccc; text-align: center; border-right: 1px solid #ffffff;"><?=$AmountTransaction?></td>
                  <td style="width:20%; border-bottom: 1px solid #cccccc; text-align: center; border-right: 1px solid #ffffff;"><?=$TradingStatus?></td>
                </tr>
                <tr>
                  <td style="border-right: 1px solid #ffffff; text-align: center; border-left: 1px solid #ffffff; border-bottom: 1px solid #fff;"><?=$ipn['gwsr']?></td>
                  <td style="border-right: 1px solid #ffffff; text-align: center; border-bottom: 1px solid #fff;"><?=$ipn['payment_time']?></td>
                  <td style="border-right: 1px solid #ffffff; text-align: center; border-bottom: 1px solid #fff;">$<?=$ipn['trade_amt']?></td>
                  <td style="border-right: 1px solid #ffffff; border-bottom: 1px solid #fff;;"><div style='word-break:break-all; text-align: center;'><?=$ipn['rtncode']?></div></td>
                </tr>
                <tr>
                  <td style="border-bottom: 1px solid #cccccc; text-align: center; border-right: 1px solid #ffffff; border-left: 1px solid #ffffff;"><?=$InstallmentPeriods?></td>
                  <td style="border-bottom: 1px solid #cccccc; text-align: center; border-right: 1px solid #ffffff;"><?=$HeadOfAmount?></td>
                  <td style="border-bottom: 1px solid #cccccc; text-align: center; border-right: 1px solid #ffffff;"><?=$EachAmount?></td>
                  <td style="border-bottom: 1px solid #cccccc; text-align: center; border-right: 1px solid #ffffff;"><?=$CardsEndFourNum?></td>
                </tr>
                <tr>
                  <td style="border-right: 1px solid #ffffff; text-align: center; border-left: 1px solid #ffffff; border-bottom: 1px solid #ffffff;"><?php if($ipn['stage'] != 0):?><?=$ipn['stage']?><?php endif;?></td>
                  <td style="border-right: 1px solid #ffffff; text-align: center; border-bottom: 1px solid #ffffff;"><?php if($ipn['stast'] != 0):?>$<?=$ipn['stast']?><?php endif;?></td>
                  <td style="border-right: 1px solid #ffffff; text-align: center; border-bottom: 1px solid #ffffff;"><?php if($ipn['staed'] != 0):?>$<?=$ipn['staed']?><?php endif;?></td>
                  <td style="border-right: 1px solid #ffffff; border-bottom: 1px solid #ffffff;"><div style='word-break:break-all; text-align: center;'><?=$ipn['card4no']?></div></td>
                </tr>
              </table>
            </td>
          </tr>
        <?php endif; ?>

        <?php if($order['pay_way_id'] == 6): ?>
          <tr>
            <td colspan="5">
              <table class='table' id='receipt_table'>
                <tr>
                  <td style="width:20%; border-bottom: 1px solid #cccccc; text-align: center; border-right: 1px solid #ffffff; border-left: 1px solid #ffffff;"><?=$GomypayTransactionNum?></td>
                  <td style="width:20%; border-bottom: 1px solid #cccccc; text-align: center; border-right: 1px solid #ffffff;"><?=$GomypayOrderFormNum?></td>
                  <td style="width:15%; border-bottom: 1px solid #cccccc; text-align: center; border-right: 1px solid #ffffff;"><?=$TransactionHour?></td>
                  <td style="width:22%; border-bottom: 1px solid #cccccc; text-align: center; border-right: 1px solid #ffffff;"><?=$AmountTransaction?></td>
                  <td style="width:22%; border-bottom: 1px solid #cccccc; text-align: center; border-right: 1px solid #ffffff;"><?=$Fee?></td>
                </tr>
                <tr>
                  <td style="border-right: 1px solid #ffffff; text-align: center; border-left: 1px solid #ffffff; border-bottom: 1px solid #ffffff;"><?=$ipn['str_no']?></td>
                  <td style="border-right: 1px solid #ffffff; text-align: center; border-bottom: 1px solid #ffffff;"><?=$ipn['e_orderno']?></td>
                  <td style="border-right: 1px solid #ffffff; text-align: center; border-bottom: 1px solid #ffffff;"><?=$ipn['e_datetime']?></td>
                  <td style="border-right: 1px solid #ffffff; border-bottom: 1px solid #ffffff;"><div style='word-break:break-all; text-align: center;'>$ <?=$ipn['e_money']?></div></td>
                  <td style="border-right: 1px solid #ffffff; border-bottom: 1px solid #ffffff;"><div style='word-break:break-all; text-align: center;'>$ <?=$ipn['e_outlay']?></div></td>
                </tr>
              </table>
            </td>
          </tr>
        <?php endif; ?>
        
      <?php endif; ?>
      <tr>
        <td colspan="4"class='th'><?=$InvoiceInformation?></td>
      </tr>
      <tr>
        <td colspan="4">
          <table class='table' id='receipt_table'>
            <tr>
              <td style="width:25%; border-bottom: 1px solid #cccccc; text-align: center; border-right: 1px solid #ffffff; border-left: 1px solid #ffffff;"><?=$InvoiceTitle?></td>
              <td style="width:25%; border-bottom: 1px solid #cccccc; text-align: center; border-right: 1px solid #ffffff;"><?=$TongBian?></td>
              <td style="border-bottom: 1px solid #cccccc; text-align: center; border-right: 1px solid #ffffff;"><?=$InvoiceAddress?></td>
            </tr>
            <tr>
              <td style="border-right: 1px solid #ffffff; text-align: center; border-left: 1px solid #ffffff; border-bottom: 1px solid #ffffff;"><?=$order['receipt_title']?></td>
              <td style="border-right: 1px solid #ffffff; text-align: center; border-bottom: 1px solid #ffffff;"><?=$order['receipt_code']?></td>
              <td style="border-right: 1px solid #ffffff; border-bottom: 1px solid #ffffff;"><div style='word-break:break-all; text-align: center;'><?=$order['receipt_zip'].' '.$order['receipt_county'].$order['receipt_area'].$order['receipt_address']?></div></td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan="4" class='th' style="color:red;"><?=$Remark?><input style="padding: 0px 3px;float: right;font-size: 0.85em;font-family: '微軟正黑體';" value="<?=$Edit?>" type="button" id="note_edit"></td>
      </tr>
      <tr>
        <td colspan="4"><?=$order['note']?></td>
      </tr>
    </table>

    <p style="height: 20px;"></p>
  </div>

  <style type="text/css">
    #mian_table { width: 95%; margin: 0px auto; }
    #mian_table tr td { text-align: center; vertical-align: middle; font-size: 1.2em; font-family: '微軟正黑體'; border: 1px solid #bbbbbb; }
    #sub_table { width: 100%; margin: 0px auto; }
    #sub_table tr td { text-align: center; vertical-align: middle; font-size: 1.1em; font-family: '微軟正黑體'; border-top: 0px; }
    #receipt_table { width: 100%; margin: 0px auto; }
    #receipt_table tr td { text-align: center; vertical-align: middle; font-size: 1.1em; font-family: '微軟正黑體'; border-top: 0px; text-align: left; }
    .dollar { font-weight: bold; color: red; }
    .th { font-weight: bold; }
    #product_flow { border-bottom: 2px dashed red; color: red; }
    #status_edit  { border-bottom: 2px dashed red; color: red; }
    #status_edit:hover { color:#aaaaaa; border-bottom: 2px dashed #aaaaaa; cursor: pointer; }
    #product_flow:hover { color:#aaaaaa; border-bottom: 2px dashed #aaaaaa; cursor: pointer; }
  </style>
  <script type="text/javascript">
    $(function()
    {
      $('#note_edit').click(function(){
        window.open('/cart/order_note/<?=$order["id"]?>/0', '', config='height=250,width=535,left=450,top=150,resizable=yes,scrollbar=yes,scrollbars=1')
      });
      // 開啟訂單狀態變更視窗
      $('#product_flow').click(function(){
        window.open('/cart/product_flow_edit/<?=$order["id"]?>', '', config='height=250,width=500,left=450,top=150,resizable=yes,scrollbar=yes,scrollbars=1');
      });
      $('#status_edit').click(function(){
        window.open('/cart/status_edit/<?=$order["id"]?>', '', config='height=250,width=500,left=450,top=150,resizable=yes,scrollbar=yes,scrollbars=1');  
      });
    });
  </script>

</body>
</html>
