<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title><?=$_OrderDetails?> <?=$web_config['title']?></title>
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

    <h3 style="font-family: '微軟正黑體';"><?=$OrderDetailsNo?><?=$order['order_id']?></h3>
    <h5 style="font-family: '微軟正黑體'; padding-top: 3px;"><?=$_CreationDate?><?=date('Y-m-d H:i', $order['date'])?></h5>
    <p style="padding-bottom: 10px;"></p>

    <table class='table' id='mian_table'>
      <tr>
        <td width="25%" class='th'><?=$ReceiverName?></td>
        <td width="25%" class='th'><?=$ReceiverPhone?></td>
        <td width="25%" class='th'><?=$PaymentMethod?></td>
        <td width="25%" class='th'><?=$OrderStatus?></td>
      </tr>
      <tr>
        <td><?=$order['name']?></td>
        <td><?=$order['phone']?></td>
        <td><?=$pway_name?></td>
        <td><?=$product_flow?></td>
      </tr>
      <tr>
        <td colspan="2" class='th'><?=$YourEmail?></td>
        <td colspan="2" class='th'><?=$ReceiverAddress?></td>
      </tr>
      <tr>
        <td colspan="2"><?=$order['email']?></td>
        <td colspan="2"><?=$order['zip'].' '.$order['county'].$order['area'].$order['address']?></td>
      </tr>
      <tr>
        <td colspan="4" class='th'><?=$OrderProductDetails?></td>
      </tr>
      <tr>
        <td colspan="4">
            <table class='table' id='sub_table'>
              <tr>
                <td style="font-weight: bold; width: 400px; border-bottom: 1px solid #cccccc; border-left: 1px solid #ffffff; border-right: 1px solid #ffffff;"><?=$ProductName?></td>
                <td style="font-weight: bold; border-bottom: 1px solid #cccccc; border-right: 1px solid #ffffff;"><?=$Price?></td>
                <td style="font-weight: bold; border-bottom: 1px solid #cccccc; border-right: 1px solid #ffffff;"><?=$Quantity?></td>
                <td style="font-weight: bold; border-bottom: 1px solid #cccccc; border-right: 1px solid #ffffff;"><?=$Subtotal?></td>
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
      <tr>
        <td colspan="4" class='th'><?=$InvoiceInformation?></td>
      </tr>
      <tr>
        <td colspan="4">
          <table class='table' id='receipt_table'>
            <tr>
              <td style="font-weight: bold; width:25%; border-bottom: 1px solid #cccccc; text-align: center; border-right: 1px solid #ffffff; border-left: 1px solid #ffffff;"><?=$InvoiceTitle?></td>
              <td style="font-weight: bold; width:25%; border-bottom: 1px solid #cccccc; text-align: center; border-right: 1px solid #ffffff;"><?=$TongBian?></td>
              <td style="font-weight: bold; border-bottom: 1px solid #cccccc; text-align: center; border-right: 1px solid #ffffff;"><?=$InvoiceAddress?></td>
            </tr>
            <tr>
              <td style="border-right: 1px solid #ffffff; text-align: center; border-left: 1px solid #ffffff; border-bottom: 1px solid #ffffff;"><?=$order['receipt_title']?></td>
              <td style="border-right: 1px solid #ffffff; text-align: center; border-bottom: 1px solid #ffffff;"><?=$order['receipt_code']?></td>
              <td style="border-right: 1px solid #ffffff; border-bottom: 1px solid #ffffff;"><div style='word-break:break-all; text-align: center;'><?=$order['receipt_zip'].' '.$order['receipt_county'].$order['receipt_area'].$order['receipt_address']?></div></td>
            </tr>
          </table>
        </td>
      </tr>
      
      <?php if ($pay_way_id == 2): ?>
      <!-- 2 paypal-->
        <tr>
          <td colspan="<?php if($pay_status == 0):?>2<?php else:?>4<?php endif;?>" class='th'><?=$pway_name?>：<?php if ($pay_status): ?><?=$AlreadyPaid?><?php elseif($pay_status == 0): ?><?=$Unpaid?><?php else:?><?php endif; ?></td>
          
          <?php if($pay_status == 0 ):?>
            <td colspan="4" class="th"><a href="/paypal/form/<?=$cset_code?>/<?=$order['id']?>/<?=$order['order_id']?>" target="_blank"><?=$ClickPayment?></a></td>
          <?php endif; ?>
        </tr>
      <?php endif; ?>

      <?php if ($pay_way_id == 5): ?>
      <!-- 5 Allpay-->
        <tr>
          <td colspan="<?php if($pay_status == 0):?>2<?php else:?>4<?php endif;?>" class='th'><?=$pway_name?>：<?php if ($pay_status): ?><?=$AlreadyPaid?><?php elseif($pay_status == 0): ?><?=$Unpaid?><?php else:?><?php endif; ?></td>
          <?php if($pay_status == 0 ):?>
            <td colspan="4" class="th"><a href="/allpay/trade/<?=$cset_code?>/<?=$order['id']?>/<?=$order['order_id']?>" target="_blank"><?=$ClickPayment?></a></td>
          <?php endif; ?>
        </tr>
      <?php endif; ?>

      <?php if ($pay_way_id == 6): ?>
      <!-- 6 Gomypay credit-->
        <tr>
          <td colspan="<?php if($pay_status == 0):?>2<?php else:?>4<?php endif;?>" class='th'><?=$pway_name?>：<?php if ($pay_status): ?><?=$AlreadyPaid?><?php elseif($pay_status == 0): ?><?=$Unpaid?><?php else:?><?php endif; ?></td>
          <?php if($pay_status == 0 ):?>
            <td colspan="4" class="th"><a href="/gomypay/trade/<?=$cset_code?>/<?=$order['id']?>/<?=$order['order_id']?>" target="_blank"><?=$ClickPayment?></a></td>
          <?php endif; ?>
        </tr>
      <?php endif; ?>
      
      <?php if ($pay_way_id == 7): ?>
      <!-- 7 Esun-->
        <tr>
          <td colspan="<?php if($pay_status == 0):?>2<?php else:?>4<?php endif;?>" class='th'><?=$pway_name?>：<?php if ($pay_status): ?><?=$AlreadyPaid?><?php elseif($pay_status == 0): ?><?=$Unpaid?><?php else:?><?php endif; ?></td>
          <?php if($pay_status == 0 ):?>
            <td colspan="4" class="th"><a href="/esun/trade/<?=$cset_code?>/<?=$order['id']?>/<?=$order['order_id']?>" target="_blank"><?=$ClickPayment?></a></td>
          <?php endif; ?>
        </tr>
      <?php endif; ?>
    </table>
    <button class='form-control' style="font-size: 1.2em; width: 20%; margin-top: 15px; font-family: '微軟正黑體';" name='close_this' onclick="window.open('', '_self', ''); window.close();"><?=$CloseWindow?></button>

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
  </style>

</script>
</body>
</html>
