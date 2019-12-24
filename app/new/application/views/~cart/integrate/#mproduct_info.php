<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title><?=$prd['prd_name']?> - <?=$web_config['title']?></title>
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
    .hr_div { 
      margin: 5px 0 0;
      padding-bottom: 10px;
      border-bottom: 1px solid #e4e4e8;
      border-bottom-width: 1px;
      border-bottom-style: solid;
      border-bottom-color: rgb(228, 228, 232);
      width: 250%;
      position: relative;
      left: -30%;
    }
    a { text-decoration: none; }
    #img_tr td { background-color: #ffffff; text-align: center; vertical-align: middle; padding: 10px; }
    #img_tr { background-color: #ffffff; }
    .another_prd { width: 73px; height: 73px; }
    .p_title { font-weight: bold; }
    .img_text { font-size: 14px; text-align: left; line-height: 20px; word-break:break-all;}
    .ui-dialog-titlebar-close { background-image: url(/images/close-icon.png); background-size: cover; }
  </style>

  <!--icon-->
  <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

  <!--js-->
  <link rel="stylesheet" href="/js/jqm/jquery.mobile-1.4.2.min.css">
  <script src="/js/jqm/jquery.js"></script>
  <script src="/js/jqm/jquery.mobile-1.4.2.min.js"></script>
  <script type="text/javascript" src="/js/jquery.blockUI.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <script type='text/javascript' src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.1.0/bootstrap.min.js"></script>
  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/flick/jquery-ui.min.css" rel="stylesheet">

  <script type="text/javascript">
    $(function(){
      //庫存不足
      $('#bottom_2').click(function(){
        alert('商品數量不足\n建議您直接聯繫商品提供廠商');
      });
      //下架
      $('#bottom_3').click(function(){
        alert('商品已經下架\n建議您直接聯繫商品提供廠商');
      });
      $('#page1').css('padding-bottom', '65px');
    });
  </script>

</head> 
<body> 

<!-- page -->
<div data-role="page" class="type-interior ui-page ui-body-c ui-page-active" id="page1">

  <!-- header -->
  <div data-position="fixed" data-role="header" class="ui-header ui-bar-b" data-theme="b" role="banner">
    <a onclick="window.location.href='<?=$cart_link?>'" data-icon="arrow-l" class="ui-btn-left ui-btn ui-shadow ui-btn-corner-all ui-btn-icon-left ui-btn-up-a" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="a"><span class="ui-btn-inner ui-btn-corner-all"><span class="ui-btn-text"><i class="fa fa-arrow-left"></i></span></span></a>
    <h1><?=$prd['prd_name']?></h1>
    <a onclick="window.location.href='/cart/check/<?=$cset_code?>/1'" data-icon="home" class="ui-btn-right ui-btn ui-shadow ui-btn-corner-all ui-btn-icon-right ui-btn-up-a" data-corners="true" data-shadow="true" data-iconshadow="true" data-theme="a"><i class="fa fa-shopping-cart"></i></a>
  </div>

  <div role="main" class="ui-content jqm-content" data-theme="d" id="contentMain" name="contentMain">

    <table style='width:100%;'>

      <!--商品名稱-->
      <tr>
        <td style='font-weight: bold; font-size: 22px;'><?=$prd['prd_name']?></td>
      </tr>

      <!--商品售價-->
      <tr>
        <td>
          <span style='color: red; font-weight: bold; font-size: 22px;'>$<?=$prd['prd_price00']?></span>
          <?php if ($prd['prd_price01'] != ''): ?>
            <strike>$<?=$prd['prd_price01']?></strike>
          <?php endif; ?>
        </td>
      </tr>

      <!--商品圖片-->
      <tr>
        <td><img id='prd_img' src='<?=$img_url.substr($prd['prd_image'], 1)?>' style='width:100%; height:auto;'></td>
      </tr>
        
    </table>

    <div class='hr_div'></div>

    <!--商品特點-->
    <p>
    <p class="p_title">商品特點</p>
      <?php if (!empty($prd_describe)): ?>
        <?php foreach ($prd_describe as $key => $value): ?>
          <p style="font-size: 16px; line-height: 24px;">● <?=$value?></p>
        <?php endforeach; ?>
      <?php endif; ?>
    </p>

    <div class='hr_div'></div>
    
    <p><a style='cursor: pointer;' onclick="window.location.href='/cart/product_content/<?=$store['cset_code']?>/<?=$prd['prd_id']?>'" style="font-size: 18px;">查看詳細商品內容介紹  <i class="fa fa-chevron-right"></i></a></p>

    <div class='hr_div'></div>
    
    <!--付款方式-->
    <p class="p_title">付款方式</p>

    <div class='hr_div'></div>

    <!--運送規則與購買說明-->
    <p class="p_title">購買說明</p>
    <p style="line-height: 24px;"><?=$store['cset_paid']?></p>

    <div class='hr_div'></div>

    <!--運送規則與購買說明-->
    <p class="p_title">運送規則</p>
    <p style="line-height: 24px;"><?=$store['cset_ship']?></p>

    <div class='hr_div'></div>

    <!--share-->
    <p class="p_title">
      商品分享
      <br><br>
        <!-- fb -->
        <a href="javascript: void(window.open('http://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href)) ));">
            <img class='share' id='fb' title="分享到臉書" src="<?=$base_url?>/images/share_btn/facebook_35x35.png" />
        </a>&nbsp;
        <!-- line -->
        <a href="http://line.naver.jp/R/msg/text/?<?=$prd['prd_name']?>%0D%0A<?=$actual_link?>" rel="nofollow" >
            <img src="<?=$base_url?>/images/share_btn/line_35x35.png" class='share' style='border:0;'/>
        </a>&nbsp;
        <!-- Email -->
        <a href="mailto:?subject=<?=$header_title?>&body=<?=$prd['prd_name']?>網址：<br><?=$actual_link?>">
            <img class='share' id='email' title="使用Email告訴朋友" src="<?=$base_url?>/images/share_btn/email_35x35.png" />
        </a>&nbsp;
        <!-- googleplus -->
        <a href="javascript: void(window.open('https://plus.google.com/share?url='.concat(encodeURIComponent(location.href)), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));">
            <img class='share' id='google' title="分享到Google+" src="<?=$base_url?>/images/share_btn/googleplus_35x35.png" />
        </a>&nbsp;
        <!-- plurk -->
        <a href="javascript: void(window.open('http://www.plurk.com/?qualifier=shares&status=' .concat(encodeURIComponent(location.href)) .concat(' ') .concat('&#40;') .concat(encodeURIComponent(document.title)) .concat('&#41;')));">
            <img class='share' id='plurk' title="分享到Plurk" src="<?=$base_url?>/images/share_btn/plurk_35x35.png" />
        </a>&nbsp;
        <!-- weibo -->
        <a href="javascript:(function(){window.open('http://v.t.sina.com.cn/share/share.php?title='+encodeURIComponent(document.title)+'&url='+encodeURIComponent(location.href)+'&source=bookmark','_blank','width=450,height=400');})()">
            <img class='share' id='weibo' title="分享到微博" src="<?=$base_url?>/images/share_btn/weibo_35x35.png" />
        </a>&nbsp;
    </p>

    <?php if (!empty($another_prd)): ?>
      <!--其他商品-->
      <div class='hr_div'></div>

        <p class="p_title">其他商品</p>
        <table>
          <tr id='img_tr'>
          <?php foreach ($another_prd as $key => $value): ?>
            <td>
              <a href='#' onclick='javascript:window.location.href="/cart/product_info/<?=$store['cset_code']?>/<?=$value['prd_id']?>"'>
                <img class='another_prd' src='<?=$img_url.substr($value['prd_image'], 1)?>'>
              </a>
            </td>
          <?php endforeach; ?>
          </tr>
          <tr id='img_tr'>
          <?php foreach ($another_prd as $key => $value): ?>
            <td style="vertical-align: top;">
              <a href='#' onclick='javascript:window.location.href="/cart/product_info/<?=$store['cset_code']?>/<?=$value['prd_id']?>"'>
                <div class='img_text'><?=$value['prd_name']?></div>
              </a>
            </td>
          <?php endforeach; ?>
          </tr>
        </table>

      <?php endif; ?>
  </div>
  
  <!-- footer -->
  <div data-role="footer" data-position="fixed" data-theme="a" id="ftrMain" name="ftrMain" role="banner">
    <?php if ($prd['prd_active'] == 0): ?>
      <div style="text-align: center;">

        <select name='amount' id='prd_num' class="form-control">
          <?=$prd_num_option?>
        </select>

        <button data-theme="b" id='add_to_cart' style="margin-right: 15px;width: 60%;font-size: 18px;border: 0px;display: inline;float: right;">加入購物車 <i class="fa fa-shopping-cart"></i></button>
      </div>
    <?php elseif ($prd['prd_active'] == 1): ?>
      <div style="text-align: center;"><button data-theme="b" id='bottom_2' style="opacity:0.5; width: 98%; font-size: 18px;border:0px;">庫存不足</button></div>
    <?php else: ?>
      <div style="text-align: center;"><button data-theme="b" id='bottom_3' style="opacity:0.5; width: 98%; font-size: 18px;border:0px;">商品已下架</button></div>
    <?php endif; ?>
  </div>

<div id="dialog-message" title=""></div>
<span id='prd_id' style='display: none;'><?=$prd['prd_id']?></span>
<span id='cset_code' style='display: none;'><?=$cset_code?></span>
<span id='iqr_url' style='display: none;'><?=$iqr_url?></span>

</div><!-- page -->
<script src="/js/cart_processing.js"></script>
<script type="text/javascript">
  $(function()
  {
    $('#prd_num').closest('.ui-select').css('float', 'left');
    $('#prd_num').closest('div').css('margin-left', '15px');
    $('#prd_num').closest('div').css('font-size', '18px');
    $('#dialog-message').css('border', '1px solid #ddd');
    $('#dialog-message').css('background', '#fff');
  });
</script>
<style type="text/css">
  .ui-dialog .ui-dialog-buttonpane { margin-top: 0px; }
</style>
</body>
</html>