<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title>訂單明細 - <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <!-- css -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">

  <!--icon-->
  <link href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

  <!-- jQuery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script><!--jQuery library-->
  <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  
  <!-- bootstrap -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>

</head>

<center>
<body scroll="yes" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center; overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

  <div>

    <h3 style="font-family: '微軟正黑體';">訂單明細</h3>
    <p style="padding-bottom: 10px;"></p>

    <table class='table table-bordered' id='mian_table'>
      <tr>
        <td>訂單編號</td>
        <td style="text-align: left;"><?=$order['order_id']?></td>
      </tr>
      <tr>
        <td>建立日期</td>
        <td style="text-align: left;"><?=date('Y-m-d H:i', $order['date'])?></td>
      </tr>
      <tr>
        <td>訂購人姓名</td>
        <td style="text-align: left;"><?=$order['name']?></td>
      </tr>
      <tr>
        <td>訂購人電話</td>
        <td style="text-align: left;"><?=$order['phone']?></td>
      </tr>
      <tr>
        <td>訂購人信箱</td>
        <td style="text-align: left;"><?=$order['email']?></td>
      </tr>
      <tr>
        <td>訂購人地址</td>
        <td style="text-align: left;"><?=$order['zip'].' '.$order['county'].$order['area'].$order['address']?></td>
      </tr>
      <tr>
        <td>發票資訊</td>
        <td style="text-align: left;">
            <table class='table' id='receipt_table'>
              <tr>
                <td style="width:20%; border-bottom: 1px solid #ddd;">發票抬頭</td>
                <td style="border-bottom: 1px solid #ddd;"><?=$order['receipt_title']?></td>
              </tr>
              <tr>
                <td style="border-bottom: 1px solid #ddd;">統編</td>
                <td style="border-bottom: 1px solid #ddd;"><?=$order['receipt_code']?></td>
              <tr>
                <td style="border-bottom: 1px solid #ddd; ">發票地址</td>
                <td style="border-bottom: 1px solid #ddd;"><div style='word-break:break-all; text-align: left;'><?=$order['receipt_zip'].' '.$order['receipt_county'].$order['receipt_area'].$order['receipt_address']?></div></td>
              </tr>
              </tr>
            </table>
        </td>
      </tr>
      <tr>
        <td>訂購商品明細</td>
        <td>
            <table class='table' id='sub_table'>
              <tr>
                <td style="width: 350px; border-bottom: 1px solid #ddd;">商品名稱</td>
                <td style="border-bottom: 1px solid #ddd;">價錢</td>
                <td style="border-bottom: 1px solid #ddd;">數量</td>
                <td style="border-bottom: 1px solid #ddd;">小計</td>
              </tr>
              <?php foreach ($items as $key => $value): ?>
                <tr>
                  <td><div style='word-break:break-all; text-align: left;'><?=$value['name']?></div></td>
                  <td><?=$value['amount']?></td>
                  <td><?=$value['quantity']?></td>
                  <td><?=($value['quantity'] * $value['amount'])?></td>
                </tr>
              <?php endforeach; ?>
            </table>
        </td>
      </tr>
      <tr>
        <td>訂購總金額</td>
        <td style="text-align: left;"><span class='dollar'>$<?=$total?> 元</span></td>
      </tr>
      <tr>
        <td>付款方式</td>
        <td style="text-align: left;"><?=$pway_name?></td>
      </tr>
      <tr>
        <td>訂單狀態</td>
        <td style="text-align: left;"><?=$product_flow?></td>
      </tr>
    </table>

    <p style="height: 20px;"></p>
  </div>

  <style type="text/css">
    #mian_table { width: 95%; margin: 0px auto; }
    #mian_table tr td { text-align: center; vertical-align: middle; font-size: 1.2em; font-family: '微軟正黑體'; }
    #sub_table { width: 100%; margin: 0px auto; }
    #sub_table tr td { text-align: center; vertical-align: middle; font-size: 1.1em; font-family: '微軟正黑體'; border-top: 0px; }
    #receipt_table { width: 100%; margin: 0px auto; }
    #receipt_table tr td { text-align: center; vertical-align: middle; font-size: 1.1em; font-family: '微軟正黑體'; border-top: 0px; text-align: left; }
    .dollar { font-weight: bold; color: red; }
  </style>

</body>
</html>
