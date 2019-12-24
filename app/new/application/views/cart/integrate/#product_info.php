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
  <title><?=$prd['prd_name']?> - <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script type="text/javascript" src="/js/jquery.blockUI.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/flick/jquery-ui.min.css" rel="stylesheet">
  <script type='text/javascript' src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.1.0/bootstrap.min.js"></script>
  <script type="text/javascript">
    $(function() {
      $( "#tabs" ).tabs({ active: 0 });
      $('#cart_link').popover({ trigger: "hover" });

      $(".prd_content img").css('width', '100%');
      $(".prd_content img").css('height', 'auto');
    });
  </script>

  <!-- wookmark -->
  <link rel="stylesheet" href="/css/wookmark/reset.css">
  <link rel="stylesheet" href="/css/wookmark/main.css">
  <link rel="stylesheet" href="/css/wookmark/style.css">
  <style type="text/css">
    .ui-dialog-titlebar-close { background-image: url(/images/close-icon.png); background-size: cover; }
  </style>

  <!-- product -->
  <link rel="stylesheet" href="/css/product_info_style.css">

</head>

<body>

  <div id="container">
    
    <div id="main" role="main">
    <div style="float:right;">
      <a title='回商店首頁' style="display: inline-block;" href="/cart/store/<?=$cset_code?>"><img style="width:50px;" src="/images/home.png"></a>
      <a id="cart_link" style="display: inline-block;" href="/cart/check/<?=$cset_code?>/1" data-content="<span style='font-size:1.7em;'>購物車內有<span style='color:red;'>0</span>件商品</span><br><span style='font-size:1.7em;'>共<span style='color:red;'>0</span>元(TWD)</span>" data-placement="bottom" data-trigger="hover"><img style="width:50px;" src="/images/cart.png"></a>
    </div><br><br>
    <h1 style="text-align: center;"><?=$prd['prd_name']?></h1>
      <table id='prd_info_table'>

        <tr><td style="text-align: center; vertical-align: middle; width: 416px; min-height: 390px;" rowspan="<?php if (!empty($prd_describe)): ?><?php if ($prd['prd_active'] == 0): ?>8<?php else: ?>7<?php endif; ?><?php else: ?><?php if ($prd['prd_active'] == 0): ?>7<?php else: ?>6<?php endif; ?><?php endif; ?>"><img id='prd_img' style="width: 95%;" src='<?=$img_url.substr($prd['prd_image'], 1)?>'></td></tr>
        
        <tr><!--名稱--><td><b><?=$prd['prd_name']?></b></td></tr>
        
        <tr><!--建議售價01-->
          <td style="color: #aeaeae; margin-right: 5px;">
          <?php if ($prd['prd_price01'] != ''): ?>
            建議售價：$<strike><?=$prd['prd_price01']?></strike>
          <?php else: ?>
            建議售價：無
          <?php endif; ?>
          </td>
        </tr>

        <tr><!--售價00--><td><span style='color: red;'>特價：$<?=$prd['prd_price00']?></span></td></tr>
        
        <!--商品特點-->
        <?php if (!empty($prd_describe)): ?>
          <tr>
            <td>
              <ul style="padding: 0px 0px 0px 20px;">
                <?php foreach ($prd_describe as $key => $value): ?>
                  <li style="list-style-type: square;"><?=$value?></li>
                <?php endforeach; ?>
              </ul>
            </td>
          </tr>
        <?php endif; ?>

        <?php if ($prd['prd_active'] == 0): ?>
        <tr><!--商品庫存-->
          <td>
              庫存數量：<?=$prd['prd_amount']?> <span class='note_text' id='prd_amount'>僅供參考</span>
              <div id='prd_amount_div' style="display: none;">實際商品數量以訂購銷存順序為準</div>
              <script type="text/javascript">
              $(function(){
                $('#prd_amount').hover(function() {
                  $('#prd_amount_div').show();
                }, function() {
                  $('#prd_amount_div').hide();
                });
              });
              </script>
          </td>
        </tr>
        <?php endif; ?>

        <tr><!--付款方式-->
          <td>
            付款方式
          </td>
        </tr>
        
        <tr>
          <td>
            <?php if ($prd['prd_active'] == 0): ?>數量：<?php elseif ($prd['prd_active'] == 1): ?>數量不足<?php else: ?><?php endif; ?><input type='number' name='amount' id='prd_num' min='1' max='<?=$prd['prd_amount']?>' value='1' style="width: 70px; <?php if ($prd['prd_active'] != 0): ?>display: none;<?php endif; ?>" class="form-control">
            <button class='aa3' id='add_to_cart' <?php if ($prd['prd_active'] != 0): ?> style='opacity:0.5; background-color: #DA5049;'<?php endif; ?>><?php if ($prd['prd_active'] == 0): ?>加入購物車 <i class="fa fa-shopping-cart"></i><?php elseif($prd['prd_active'] == 1): ?>補貨中<?php else: ?>商品已下架<?php endif; ?></button>
            <div id="dialog-message" title=""></div><span id='prd_id' style='display: none;'><?=$prd['prd_id']?></span><span id='cset_code' style='display: none;'><?=$cset_code?></span><span id='iqr_url' style='display: none;'><?=$iqr_url?></span><!-- <p id='info'></p> -->
          </td>
        </tr>

        <tr>
          <td colspan="2">
            <div id="tabs">
              <ul>
                <li><a href="#tabs-1" style="font-size: 20px; font-weight: normal;">商品介紹</a></li><!--商品內容、商品影片-->
                <li><a href="#tabs-2" style="font-size: 20px; font-weight: normal;">商品規格</a></li><!--商品規格、保固範圍-->
                <li><a href="#tabs-3" style="font-size: 20px; font-weight: normal;">購買說明</a></li><!--購買說明-->
                <li><a href="#tabs-4" style="font-size: 20px; font-weight: normal;">運送規則</a></li><!--運送說明-->
              </ul>
              <div class='div-tabs' id="tabs-1">
                <!--商品內容、商品影片-->
                <?php if ($prd['prd_content'] != '' || !empty($prd_video_link)): ?>
                  
                  <!--商品內容-->
                  <p class='prd_content'><?=$prd['prd_content']?></p>
                
                  <!--商品影片-->
                  <?php if (!empty($prd_video_link)): ?>
                    <?php foreach ($prd_video_link as $key => $value): ?>
                    <p style="padding-top: 25px; font-weight: bold;"><?=$prd_video_name[$key]?></p>
                    <p><iframe class='video_iframe' style="width: 100%; height: 350px;" src="<?=$value?>"></iframe></p>
                    <?php endforeach; ?>
                  <?php endif; ?>

                <?php else: ?>
                  無
                <?php endif; ?>
              </div>
              <div class='div-tabs' id="tabs-2">

                <!--商品規格-->
                <?php if (!empty($prd_specification_content)): ?>
                  <table class='prd'>
                    <?php foreach ($prd_specification_content as $key => $value): ?>
                      <tr>
                        <td style="width: 35%; background-color: #f3f3f3;"><?=$prd_specification_name[$key]?></td>
                        <td><?=$value?></td>
                      </tr>
                    <?php endforeach; ?>
                  </table>
                <?php else: ?>
                  目前沒有任何關於商品規格的資訊
                <?php endif; ?>
                <br>
                <!--保固範圍-->
                <?php if ($prd['prd_assurance_range'] != '' || $prd['prd_assurance_date'] != ''): ?>
                  <table class='prd'>
                    <?php if ($prd['prd_assurance_range'] != ''): ?>
                      <tr>
                        <td style="width: 35%; background-color: #f3f3f3;">保固範圍</td>
                        <td><?=$prd['prd_assurance_range']?></td>
                      </tr>
                    <?php endif; ?>
                    <?php if ($prd['prd_assurance_date'] != ''): ?>
                      <tr>
                        <td style="width: 35%; background-color: #f3f3f3;">保固期限</td>
                        <td><?=$prd['prd_assurance_date']?></td>
                      </tr>
                    <?php endif; ?>
                  </table>
                <?php else: ?>
                  <br>
                  保固範圍：無任何保固
                <?php endif; ?>
              </div>
              <div class='div-tabs' id="tabs-3">
                <?php if ($store['cset_paid'] != ''): ?>
                  <p class='prd_content'><?=$store['cset_paid']?></p>
                <?php else: ?> 
                  無
                <?php endif; ?>
              </div>
              <div class='div-tabs' id="tabs-4">
                <?php if ($store['cset_ship'] != ''): ?>
                  <p class='prd_content'><?=$store['cset_ship']?></p>
                <?php else: ?> 
                  無
                <?php endif; ?>
              </div>
            </div>
          </td>
        </tr>
        
      </table>
      <p style="height: 30px;">&nbsp;</p>
    </div>

    <div class="fix_button" id="cart">
      
    </div>
  </div>

  <p style="text-align:center;color:#777"><?=$web_config['iqr_footer_text']?></p>
  <script src="/js/cart_processing.js"></script>

</body>
</html>
