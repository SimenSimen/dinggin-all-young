<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title><?=$OrderDetails?> - <?=$store['cset_name']?> - <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <!--Touch Icon-->
  <link rel="apple-touch-icon" href="/images/vCard.orange.noshadow.gif" />

  <!--css-->
  <style type="text/css">
    * { font-family: 'Microsoft Jhenghei'; }
    #list { width: 100%; margin: 0px auto; }
    #list tr td { padding-bottom: 10px; padding-top: 10px; padding-right: 5px; }
  </style>
  <link type="text/css" rel="stylesheet" href="/css/pagination.css">

  <!--icon-->
  <link href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

  <!--js-->
  <link rel="stylesheet" href="/js/jqm/jquery.mobile-1.4.2.min.css">
  <script src="/js/jqm/jquery.js"></script>
  <script src="/js/jqm/jquery.mobile-1.4.2.min.js"></script>

</head> 
<body> 

<!-- page -->
<div data-role="page" class="type-interior ui-page ui-body-c ui-page-active" id="page1">

  <!-- header -->
  <div data-position="fixed" data-role="header" class="ui-header ui-bar-b" data-theme="b" role="banner">
    <h1><?=$OrderDetails?></h1>
  </div>

  <div role="main" class="ui-content jqm-content" data-theme="d" id="contentMain" name="contentMain">

    <?php if (!empty($order)): ?>
      <table id='list'>
        <tr>
          <td class='th' width="32%"><?=$OrderNum?></td>
          <td style="text-align: left;"><?=$order['order_id']?></td>
        </tr>
        <tr>
          <td class='th'><?=$CreationDate?></td>
          <td style="text-align: left;"><?=date('Y-m-d H:i', $order['date'])?></td>
        </tr>
        <tr>
          <td class='th'><?=$UsuallyPeopleName?></td>
          <td style="text-align: left;"><?=$order['name']?></td>
        </tr>
        <tr>
          <td class='th'><?=$UsuallyPeoplePhone?></td>
          <td style="text-align: left;"><?=$order['phone']?></td>
        </tr>
        <tr>
          <td class='th'><?=$UsuallyPeopleMail?></td>
          <td style="text-align: left;"><?=$order['email']?></td>
        </tr>
        <tr>
          <td class='th'><?=$UsuallyPeopleAddress?></td>
          <td style="text-align: left;"><?=$order['zip'].' '.$order['county'].$order['area'].$order['address']?></td>
        </tr>
        <tr>
          <td colspan="2">
            <span class='th'><?=$InvoiceInformation?></span>
            <table class='table' id='receipt_table'>
              <tr>
                <td style="border-bottom: 1px solid #ddd;"><?=$_InvoiceTitle?><br><?=$order['receipt_title']?></td>
              </tr>
              <tr>
                <td style="border-bottom: 1px solid #ddd;"><?=$_TongBian?><br><?=$order['receipt_code']?></td>
              <tr>
                <td style="border-bottom: 1px solid #ddd;"><?=$_InvoiceAddress?><br><div style='word-break:break-all; text-align: left;'><?=$order['receipt_zip'].' '.$order['receipt_county'].$order['receipt_area'].$order['receipt_address']?></div></td>
              </tr>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <span class='th'><?=$OrderProductDetails?></span>
            <table class='table' id='sub_table'>
              <tr>
                <td style="width: 300px; border-bottom: 1px solid #ddd;"><?=$ProductName?></td>
                <td style="border-bottom: 1px solid #ddd;white-space: nowrap; text-align: center;"><?=$Price?></td>
                <td style="border-bottom: 1px solid #ddd;white-space: nowrap;"><?=$Quantity?></td>
                <td style="border-bottom: 1px solid #ddd;white-space: nowrap;"><?=$Subtotal?></td>
              </tr>
              <?php foreach ($items as $key => $value): ?>
                <tr>
                  <td><div style='word-break:break-all; text-align: left;'><?=$value['name']?></div></td>
                  <td align="center"><?=$value['amount']?></td>
                  <td align="center"><?=$value['quantity']?></td>
                  <td align="center"><?=($value['quantity'] * $value['amount'])?></td>
                </tr>
              <?php endforeach; ?>
            </table>
          </td>
        </tr>
        <tr>
          <td class='th'><?=$TotalAmount?></td>
          <td style="text-align: left;"><span class='dollar'>$<?=$total?> <?=$Yuan?></span></td>
        </tr>
        <tr>
          <td class='th'><?=$PaymentMethod?></td>
          <td style="text-align: left;"><?=$pway_name?></td>
        </tr>
        
        <?php if($lway_name != ''):?>
        <tr>
          <td class='th'><?=$PickupMode?></td>
          <td style="text-align: left;"><?=$lway_name?></td>
        </tr>
        <?php endif;?>
        
        <tr>
          <td class='th'><?=$OrderStatus?></td>
          <td style="text-align: left;"><?=$product_flow?></td>
        </tr>
        <?php if ($pay_way_id == 2): ?>
          <!--paypal-->
          <tr>
            <td colspan="2"class='th'><?=$pway_name?>：<?php if ($pay_status): ?><?=$AlreadyPaid?><?php elseif($pay_status == 0): ?><?=$Unpaid?><?php endif; ?></td>
          </tr>
          <?php if($pay_status == 0 ):?>
            <td colspan="2" class="th"><a id="paypal_btn" href="/paypal/form/<?=$cset_code?>/<?=$order['id']?>/<?=$order['order_id']?>" target="_blank"><?=$GoToPay?></a></td>
          <?php endif; ?>
        <?php endif; ?>

        <?php if ($pay_way_id == 5): ?>
          <!--allpay-->
          <tr>
            <td colspan="2"class='th'><?=$pway_name?>：<?php if ($pay_status): ?><?=$AlreadyPaid?><?php elseif($pay_status == 0): ?><?=$Unpaid?><?php endif; ?></td>
          </tr>
          <?php if($pay_status == 0 ):?>
            <td colspan="2" class="th"><a id="paypal_btn" href="/allpay/trade/<?=$cset_code?>/<?=$order['id']?>/<?=$order['order_id']?>" target="_blank"><?=$GoToPay?></a></td>
          <?php endif; ?>
        <?php endif; ?>

        <?php if ($pay_way_id == 6): ?>
          <!--gomypay-->
          <tr>
            <td colspan="2"class='th'><?=$pway_name?>：<?php if ($pay_status): ?><?=$AlreadyPaid?><?php elseif($pay_status == 0): ?><?=$Unpaid?><?php endif; ?></td>
          </tr>
          <?php if($pay_status == 0 ):?>
            <td colspan="2" class="th"><a id="paypal_btn" href="/gomypay/trade/<?=$cset_code?>/<?=$order['id']?>/<?=$order['order_id']?>" target="_blank"><?=$GoToPay?></a></td>
          <?php endif; ?>
        <?php endif; ?>

        <?php if ($pay_way_id == 7): ?>
          <!--Esun-->
          <tr>
            <td colspan="2"class='th'><?=$pway_name?>：<?php if ($pay_status): ?><?=$AlreadyPaid?><?php elseif($pay_status == 0): ?><?=$Unpaid?><?php endif; ?></td>
          </tr>
          <?php if($pay_status == 0 ):?>
            <td colspan="2" class="th"><a id="paypal_btn" href="/esun/trade/<?=$cset_code?>/<?=$order['id']?>/<?=$order['order_id']?>" target="_blank"><?=$GoToPay?></a></td>
          <?php endif; ?>
        <?php endif; ?>
      </table>

    <?php endif; ?>

  </div>
  
  <!-- footer -->
  <div data-role="footer" data-position="fixed" data-theme="a" id="ftrMain" name="ftrMain" role="banner" style="text-align: center;">
    <button class='form-control' data-theme="b" style="font-size:1.2em;width: 98%; margin: 5px auto; font-family: '微軟正黑體';" name='close_this' onclick="window.open('','_self').close()"><?=$CloseWindow?></button>
  </div>

  <script type="text/javascript">
    // 開啟訂單狀態變更視窗
    $('.record_detail').click(function(){
        window.open('/cart/record_detail/<?=$cset_code?>/'+$(this).attr('id').substr(3), '<?=$OrderStatus?>', config='height=750,width=800,left=400,top=50,resizable=yes,scrollbar=yes,scrollbars=1');
    });
  </script>

  <style type="text/css">
    .dollar { font-weight: bold; color: red; }
    .th { font-weight: bold; }
    #paypal_btn{
      background: #DA5049;
      color: white;
      padding: 6px 14px;
      display: inline-block;
      text-shadow: none;
      font-family: '微軟正黑體';
      border-radius: 30px;
      text-decoration: none;
      text-align: center;
    }
  </style>

</div><!-- page -->
</body>
</html>