<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title><?=$my_e_coupon['name']?> - <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <!-- fb -->
  <meta property="og:url"         content="<?=$actual_link?>"></meta>
  <meta property="og:title"       content="<?=$my_e_coupon['name']?>"></meta>
  <meta property="og:description" content="<?=$my_e_coupon['content']?>"></meta>
  <meta property="og:image"       content="<?=$base_url.substr($img_url, 2).$my_e_coupon['filename']?>"></meta>

  <!--Touch Icon-->
  <link rel="apple-touch-icon" href="/images/vCard.orange.noshadow.gif" />

  <script type="text/javascript">
    $(window).load(function(){
      $('#share_btn_table').css('text-align', 'center');
      $('#share_btn_table').css('padding-right', '1px');
      $('#share_btn_table').css('padding-bottom', '20px');
    });
  </script>

  <!--css-->
  <style type="text/css">
    * { font-family: 'Microsoft Jhenghei'; }
    a { text-decoration: none; }
  </style>

  <!--icon-->
  <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

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
    <a href="#" onclick="javascript:window.location.href='<?=$web_return?>'" data-icon="arrow-l" class="ui-btn-left ui-btn ui-shadow ui-btn-corner-all ui-btn-icon-left ui-btn-up-a" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="a"><span class="ui-btn-inner ui-btn-corner-all"><span class="ui-btn-text"><i class="fa fa-arrow-left"></i></span><span class="ui-icon ui-icon-arrow-l ui-icon-shadow">&nbsp;</span></span></a>
    <h1><?=$TellFriendVoucher?></h1>
  </div>

  <div role="main" class="ui-content jqm-content" data-theme="d" id="contentMain" name="contentMain" style="text-align:center;">
    
    <table id='share_btn_table' style="width: 100%;">
      <tr>
          <td>
              <!-- fb -->
              <a href="javascript: void(window.open('http://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href)) ));">
                  <img class='share' id='fb' title="<?=$ShareOnFacebook?>" src="<?=$base_url?>/images/share_btn/facebook_35x35.png" />
              </a>
          </td>
          <td>
              <!-- weibo -->
              <a href="javascript:(function(){window.open('http://v.t.sina.com.cn/share/share.php?title='+encodeURIComponent(document.title)+'&url='+encodeURIComponent(location.href)+'&source=bookmark','_blank','width=450,height=400');})()">
                  <img class='share' id='weibo' title="<?=$ShareOnWeibo?>" src="<?=$base_url?>/images/share_btn/weibo_35x35.png" />
              </a>
          </td>
          <td>
              <!-- googleplus -->
              <a href="javascript: void(window.open('https://plus.google.com/share?url='.concat(encodeURIComponent(location.href)), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));">
                  <img class='share' id='google' title="<?=$ShareOnGoogle?>" src="<?=$base_url?>/images/share_btn/googleplus_35x35.png" />
              </a>
          </td>
          <td>
              <!-- plurk -->
              <a href="javascript: void(window.open('http://www.plurk.com/?qualifier=shares&status=' .concat(encodeURIComponent(location.href)) .concat(' ') .concat('&#40;') .concat(encodeURIComponent(document.title)) .concat('&#41;')));">
                  <img class='share' id='plurk' title="<?=$ShareOnPlurk?>" src="<?=$base_url?>/images/share_btn/plurk_35x35.png" />
              </a>
          </td>
          <td>
              <!-- twitter -->
              <a href="javascript: void(window.open('http://twitter.com/home/?status='.concat(encodeURIComponent(document.title)) .concat(' ') .concat(encodeURIComponent(location.href))));">
                  <img class='share' id='twitter' title="<?=$ShareOnTwitter?>" src="<?=$base_url?>/images/share_btn/twitter_35x35.png" />
              </a>
          </td>
          <td>
              <a href="http://line.naver.jp/R/msg/text/?<?=$my_e_coupon['name']?>%0D%0A<?=$actual_link?>" rel="nofollow" ><img src="<?=$base_url?>/images/share_btn/line_35x35.png" class='share' style='border:0;'/></a>
          </td>
          <td>
              <!-- Email -->
              <a href="mailto:?subject=<?=$my_e_coupon['name']?>&body=<?=$my_e_coupon['content']?><br>網址：<br><?=$actual_link?>">
                  <img class='share' id='email' title="<?=$EmailTellFriend?>" src="<?=$base_url?>/images/share_btn/email_35x35.png" />
              </a>
          </td>
      </tr>
    </table>

    <p style="font-size: 1.3em; font-family:'微軟正黑體';"><?=$my_e_coupon['name']?></p>

    <img style="width:100%;" src='<?=$base_url.substr($img_url, 2).$my_e_coupon['filename']?>'>
    
    <p style="font-size: 1.3em; font-family:'微軟正黑體';"><?=$my_e_coupon['content']?></p>

  </div>

  <div data-position="fixed" data-role="footer" class="ui-header ui-bar-b" data-theme="b" style="text-align: center; margin: 0px auto;">
    <button data-theme="a" id='download' style="font-size: 18px;border: 0px;display: inline;width: 97%;"><?=$my_e_coupon['btn_name']?></button>
    <input type="hidden" id="mode" value="<?=$my_e_coupon['mode']?>">
    <h4><?=$web_config['iqr_footer_text']?></h4>
  </div>
  <script type="text/javascript">
    $(function(){
      $('#download').click(function()
      {
        var mode = $("#mode").val();
        <?php if($mode_1_btn): ?>
          var url = '<?=$mode_1?>';
        <?php endif; ?>
        
        <?php if($mode_2_btn): ?>
          var url = '<?=$mode_2?>';
        <?php endif; ?>
        
        <?php if($mode_3_btn): ?>
          var url = '<?=$mode_3?>';
        <?php endif; ?>
        
        window.location.href = ""+url+"";
      });
    });
  </script>

</div><!-- page -->

</body>
</html>