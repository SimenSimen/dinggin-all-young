<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title><?=$header_title?> - <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <!--Touch Icon-->
  <link rel="apple-touch-icon" href="/images/vCard.orange.noshadow.gif" />

  <meta name="viewport" content="width=device-width"> 

  <!-- fb -->
  <meta property="og:url"         content="<?=$actual_link?>"></meta>
  <meta property="og:title"       content="<?=$header_title?>"></meta>
  <meta property="og:description" content="<?=$header_title?>"></meta>
  <?php if ($first_img['img_status']): ?><meta property="og:image" content="<?=$first_img['first_img']?>"/><?php endif; ?>

  <!--icon-->
  <link href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

  <!--js-->
  <link rel="stylesheet" href="/js/jqm/jquery.mobile-1.4.2.min.css">
  <script src="/js/jqm/jquery.js"></script>
  <script src="/js/jqm/jquery.mobile-1.4.2.min.js"></script>

  <script type="text/javascript">
    //圖片縮圖
    $(window).load(function(){
      $("img").each(function(i){
        if($(this).attr('class') != 'share')
        {
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
        }
      });

      $('#share_btn_table').css('width', ($(window).width()*91/100));
      $('#share_btn_table').css('text-align', 'center');
      $('#share_btn_table').css('padding-right', '1px');
      $('#share_btn_table').css('padding-bottom', '20px');
    });
  </script>

</head> 
<body> 

<!-- page -->
<div data-role="page" class="type-interior ui-page ui-body-c ui-page-active" id="page1">

  <!-- header -->
  <div data-role="header" class="ui-header ui-bar-b" data-theme="b" role="banner">
    <a href="#" onclick="javascript:window.location.href='<?=$iqr_url?>'" data-icon="arrow-l" class="ui-btn-left ui-btn ui-shadow ui-btn-corner-all ui-btn-icon-left ui-btn-up-a" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="a"><span class="ui-btn-inner ui-btn-corner-all"><span class="ui-btn-text"><i class="fa fa-arrow-left"></i></span><span class="ui-icon ui-icon-arrow-l ui-icon-shadow">&nbsp;</span></span></a>
    <h1><?=$header_title?></h1>
  </div>

  <div role="main" class="ui-content jqm-content" data-theme="d" id="contentMain" name="contentMain">

    <table id='share_btn_table'>
      <tr>
          <td>
              <!-- fb -->
              <a href="javascript: void(window.open('https://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href)) ));">
                  <img class='share' id='fb' title="<?=$ShareFacebook?>" src="<?=$base_url?>/images/share_btn/facebook_35x35.png" />
              </a>
          </td>
          <td>
              <!-- weibo -->
              <a href="javascript:(function(){window.open('https://v.t.sina.com.cn/share/share.php?title='+encodeURIComponent(document.title)+'&url='+encodeURIComponent(location.href)+'&source=bookmark','_blank','width=450,height=400');})()">
                  <img class='share' id='weibo' title="<?=$ShareWeibo?>" src="<?=$base_url?>/images/share_btn/weibo_35x35.png" />
              </a>
          </td>
          <td>
              <!-- googleplus -->
              <a href="javascript: void(window.open('https://plus.google.com/share?url='.concat(encodeURIComponent(location.href)), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));">
                  <img class='share' id='google' title="<?=$ShareGoogle?>" src="<?=$base_url?>/images/share_btn/googleplus_35x35.png" />
              </a>
          </td>
          <td>
              <!-- plurk -->
              <a href="javascript: void(window.open('https://www.plurk.com/?qualifier=shares&status=' .concat(encodeURIComponent(location.href)) .concat(' ') .concat('&#40;') .concat(encodeURIComponent(document.title)) .concat('&#41;')));">
                  <img class='share' id='plurk' title="<?=$SharePlurk?>" src="<?=$base_url?>/images/share_btn/plurk_35x35.png" />
              </a>
          </td>
          <td>
              <!-- twitter -->
              <a href="javascript: void(window.open('https://twitter.com/home/?status='.concat(encodeURIComponent(document.title)) .concat(' ') .concat(encodeURIComponent(location.href))));">
                  <img class='share' id='twitter' title="<?=$ShareTwitter?>" src="<?=$base_url?>/images/share_btn/twitter_35x35.png" />
              </a>
          </td>
          <td>
              <a href="https://line.naver.jp/R/msg/text/?<?=$header_title?>%0D%0A<?=$actual_link?>" rel="nofollow" ><img src="<?=$base_url?>/images/share_btn/line_35x35.png" class='share' style='border:0;'/></a>
          </td>
          <td>
              <!-- Email -->
              <a href="mailto:?subject=<?=$header_title?>&body=<?=$header_title?><?=$Site?><br><?=$actual_link?>">
                  <img class='share' id='email' title="<?=$UseEmail?>" src="<?=$base_url?>/images/share_btn/email_35x35.png" />
              </a>
          </td>
      </tr>
    </table>

    <?=$content?>
  </div>
  
  <!-- footer -->
  <div data-role="footer" class="ui-header ui-bar-b" data-theme="b" id="ftrMain" name="ftrMain" role="banner"><h4><?=$web_config['iqr_footer_text']?></h4></div>

</div><!-- page -->

</body>
</html>