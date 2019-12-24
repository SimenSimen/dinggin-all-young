<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title><?=$this -> web_title?></title>
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
  <script type="text/javascript">
    $(window).load(function(){
      $('#share_btn_table').css('width', Math.round($(window).width()));
      $('#share_btn_table').css('text-align', 'center');
      $('#share_btn_table').css('padding', '15px 1px 10px 0');

      $("#contentMain img").each(function(i){
          $(this).removeAttr('width');
          $(this).removeAttr('height');
     
          //取得影像實際的長寬
          var imgW = $(this).width();
          var imgH = $(this).height();
     
          //計算縮放比例
          var w=($(window).width()*91/100)/imgW;
          var h=w;
          var pre=1;
          if(w>h){
            pre=h;
          }else{
            pre=w;
          }
     
          //設定目前的縮放比例
          $(this).width(imgW*pre);
          $(this).height(imgH*pre);
      });
    });
  </script>
</head> 
<body> 

<!-- page -->
<div data-role="page" class="type-interior ui-page ui-body-c ui-page-active" id="page1">

  <!-- header -->
  <div data-position="fixed" data-role="header" class="ui-header ui-bar-b" data-theme="b" role="banner">
    <h1><?=$this -> web_title?></h1>
  </div>

  <table id='share_btn_table'>
    <tr>
      <td>
        <!-- fb -->
        <a href="javascript: void(window.open('http://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href)) ));">
            <img class='share' id='fb' title="<?=$ShareByFB?>" src="<?=$base_url?>/images/share_btn/facebook_35x35.png" />
        </a>
      </td>
      <td>
        <!-- weibo -->
        <a href="javascript:(function(){window.open('http://v.t.sina.com.cn/share/share.php?title='+encodeURIComponent(document.title)+'&url='+encodeURIComponent(location.href)+'&source=bookmark','_blank','width=450,height=400');})()">
            <img class='share' id='weibo' title="<?=$ShareByWebio?>" src="<?=$base_url?>/images/share_btn/weibo_35x35.png" />
        </a>
      </td>
      <td>
        <!-- googleplus -->
        <a href="javascript: void(window.open('https://plus.google.com/share?url='.concat(encodeURIComponent(location.href)), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));">
            <img class='share' id='google' title="<?=$ShareByGoogle?>" src="<?=$base_url?>/images/share_btn/googleplus_35x35.png" />
        </a>
      </td>
      <td>
        <!-- plurk -->
        <a href="javascript: void(window.open('http://www.plurk.com/?qualifier=shares&status=' .concat(encodeURIComponent(location.href)) .concat(' ') .concat('&#40;') .concat(encodeURIComponent(document.title)) .concat('&#41;')));">
            <img class='share' id='plurk' title="<?=$ShareByPlurk?>" src="<?=$base_url?>/images/share_btn/plurk_35x35.png" />
        </a>
      </td>
      <td>
        <!-- twitter -->
        <a href="javascript: void(window.open('http://twitter.com/home/?status='.concat(encodeURIComponent(document.title)) .concat(' ') .concat(encodeURIComponent(location.href))));">
            <img class='share' id='twitter' title="<?=$ShareByTwitter?>" src="<?=$base_url?>/images/share_btn/twitter_35x35.png" />
        </a>
      </td>
      <td>
        <a href="javascript: void(window.open('http://line.naver.jp/R/msg/text/?'+encodeURIComponent(document.title)+' - '+encodeURIComponent(location.href) ));" rel="nofollow"><img src="<?=$base_url?>/images/share_btn/line_35x35.png" class='share' style='border:0;'/></a>
      </td>
      <td>
        <!-- Email -->
        <a href="javascript: void(window.open('mailto:?subject='+encodeURIComponent(document.title)+'&body=網址：<br>'+encodeURIComponent(location.href) ));">
            <img class='share' id='email' title="<?=$ShareByEmail?>" src="<?=$base_url?>/images/share_btn/email_35x35.png" />
        </a>
      </td>
    </tr>
  </table>
  
  <div role="main" class="ui-content jqm-content" data-theme="d" id="contentMain" name="contentMain">
    <?=$my_e_coupon['mode_3']?>
  </div>
  
    <a href="<?=$download_href?>" rel="external" data-ajax="false" data-inline="true" class="ui-btn ui-btn-b"><?=$DownloadTheAPP?></a>
  
  <div data-position="fixed" data-role="footer" class="ui-header ui-bar-b" data-theme="b" style="text-align: center; margin: 0px auto;">
    <h4><?=$web_config['iqr_footer_text']?></h4>
  </div>
  
</div><!-- page -->

</body>
</html>