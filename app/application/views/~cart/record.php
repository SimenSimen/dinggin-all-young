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
  <title><?=$OrderTracking?> - <?=$store['cset_name']?> - <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <!-- include jQuery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="/css/pagination.css">
  <!-- wookmark -->
  <link rel="stylesheet" href="/css/wookmark/reset.css">
  <link rel="stylesheet" href="/css/wookmark/main.css">
  <link rel="stylesheet" href="/css/wookmark/style.css">
  <style type="text/css">
    * { font-family: 'Microsoft Jhenghei'; }
    .clear{clear:both;}
    a { text-decoration: none; }
    #list { width: 30%; margin: 0px auto; }
    #list tr td { border: 1px solid #ccc; font-size: 1.4em; padding: 7px 10px; }
    .record_detail { cursor: pointer; }
    .record_detail { color: black; }
  </style>
</head>

<body>

  <div id="container">
    
    <header>
      <h1>
      <?php if (!empty($order)): ?>
        <?=$OrderTracking?>
        <a title='<?=$BackStoreHome?>' style="display: inline-block;" href="/cart/store/<?=$cset_code?>"><img style="width:50px;" src="/images/home.png"></a>
        <a id="cart_link" title="<?=$ShoppingDetail?>" style="display: inline-block;" href="/cart/check/<?=$cset_code?>/1" data-content="<span style='font-size:1.7em;'><?=$CartHas?><span style='color:red;'>0</span><?=$Items?></span><br><span style='font-size:1.7em;'>共<span style='color:red;'>0</span><?=$Yuan_TWD?></span>" data-placement="bottom" data-trigger="hover"><img style="width:50px;" src="/images/cart/cart.png"></a>
        <?php if ($user_login): ?>
          <a style="display: inline-block;" href="/cart/user_logout/<?=$cset_code?>" ><img style="width: 47px;position: relative;top: -3px;" src="/images/cart/cart_logout.png" title="<?=$Logout?>"></a>
        <?php else: ?>
          <a style="display: inline-block;" href="/cart/user_login/<?=$cset_code?>/record" ><img style="width: 47px;position: relative;top: -3px;" src="/images/cart/cart_login.png" title="<?=$Login?>"></a>
        <?php endif; ?>
      <?php else: ?>
        <?=$NoOrders?>
      <?php endif; ?>
      </h1>
    </header>

    <!--
      These are our filter options. The "data-filter" classes are used to identify which
      grid items to show.
      -->
    <br/>

    <div class="clear"></div>
    <br/>

    <div id="main" role="main">

      <?php if (!empty($order)): ?>
          <table id='list'>
              <tr>
                  <td colspan="3"><?=$_SignMail?><?=$buyer['by_email']?></div></td>
              </tr>
              <tr>
                  <td><?=$OrderNum?></td>
                  <td><?=$PaymentStatus?></td>
                  <td><?=$OrderDetails_1?></td>
              </tr>
              <?php foreach ($page_data as $key => $value): ?>
                <tr>
                    <td><?=$value['order_id']?></td>
                    <td><?=$status[$key]?></td>
                    <td><a class="record_detail" style="margin-left:0px;" id="rd_<?=$value['id']?>" title="<?=$OpenOrderDetails?>"><i class="fa fa-file-text-o" style=" font-size: 1.3em;"></i></a></td>
                </tr>
              <?php endforeach; ?>
              <tr>
                <td colspan="3">
                  <div class="pagination" style="position: relative; left: -40px;">
                      <ul>
                          <?=$create_links?>
                      </ul>    
                  </div>
                </td>
              </tr>
          </table>

      <?php endif; ?>

    </div>

  </div>

  <script type="text/javascript">
    // 開啟訂單狀態變更視窗
    $('.record_detail').click(function(){
        window.open('/cart/record_detail/<?=$cset_code?>/'+$(this).attr('id').substr(3), '<?=$OrderStatus?>', config='height=750,width=800,left=400,top=50,resizable=yes,scrollbar=yes,scrollbars=1');
    });
  </script>

</body>
</html>
