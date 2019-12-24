<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title><?=$title?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <!--Touch Icon-->
  <link rel="apple-touch-icon" href="/images/vCard.orange.noshadow.gif" />
  <!-- gallery -->
  <link rel="stylesheet" type="text/css" href="/template/css/photo_demo.css" />
  <link rel="stylesheet" type="text/css" href="/template/css/photo_style.css" />
  <link rel="stylesheet" type="text/css" href="/template/css/photo_elastislide.css" />
  <!--icon-->
  <link href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <!--js-->
  <link rel="stylesheet" href="/js/jqm/jquery.mobile-1.4.2.min.css">
  <script src="/js/jqm/jquery.js"></script>
  <script src="/js/jqm/jquery.mobile-1.4.2.min.js"></script>
  <!-- g -->
  <script id="img-wrapper-tmpl" type="text/x-jquery-tmpl">
    <div class="rg-image-wrapper">
      {{if itemsCount > 1}}
      <div class="rg-image-nav">
        <a href="#" class="rg-image-nav-prev">Previous Image</a>
        <a href="#" class="rg-image-nav-next">Next Image</a>
      </div>
      {{/if}}
      <div class="rg-image"></div>
      <div class="rg-loading"></div>
      <div class="rg-caption-wrapper">
        <div class="rg-caption" style="display:none;">
            <p></p>
        </div>
      </div>
    </div>
  </script>
  <script type="text/javascript" src="/template/js/jquery.tmpl.min.js"></script>
  <script type="text/javascript" src="/template/js/jquery.elastislide.js"></script>
  <script type="text/javascript" src="/template/js/S-gallery.js"></script>

  <script type="text/javascript">
    $(function(){
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
          var w=($(window).width()*0.8)/imgW;
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

      $("#footer").click(function() {
        location.href="<?=$download_href?>";
      });
    });
  </script>
  <style>
    /* font color */
    #contentMain
    {
      color:<?=$font_color?>;
      font-size:<?=$font_size?>px;
      font-family:"<?=$font_family?>";
    }
    <?php if ($bg_type == 0 || $bg_image_path == ''): ?>
        #page1
        {
          background-color:<?=$bg_color?>;
        }
    <?php elseif($bg_image_path != ''): ?>
        /* 背景圖 */
        #page1
        {
          background:url('<?=$base_url?><?=$bg_image_path?>') no-repeat center 0px;
          -moz-background-size:cover;
          -webkit-background-size:cover;
          -o-background-size:cover;
          background-size:cover;
          background-attachment: fixed;
          background-position: center center;
        }
    <?php endif; ?>
  </style>
</head> 

<body> 
  <!-- page -->
  <div data-role="page" class="type-interior ui-page ui-body-c ui-page-active" id="page1">

    <!-- header -->
    <div data-position="fixed" data-role="header" class="ui-header ui-bar-b" data-theme="b" role="banner">
      <h1><?=$title?></h1>
    </div>

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
          <a href="https://line.naver.jp/R/msg/text/?<?=$title?> <?=$iqr_url?>" rel="nofollow"><img src="<?=$base_url?>/images/share_btn/line_35x35.png" class='share' style='border:0;'/></a>
        </td>
        <td align="center">
          <a href="whatsapp://send?text=<?=$title?> <?=$share_link?>" data-action="share/whatsapp/share">
            <img class='share' src="/images/share_btn/whatsApp_35x35.png" />
          </a>
        </td>
        <td>
          <!-- Email -->
          <a href="mailto:?subject=<?=$title?> &body=<?=$MySystemUrl?>：<br><?=$iqr_url?>">
              <img class='share' id='email' title="<?=$UseEmail?>" src="<?=$base_url?>/images/share_btn/email_35x35.png" />
          </a>
        </td>
      </tr>
    </table>
    
    <div role="main" class="ui-content jqm-content" data-theme="d" id="contentMain" name="contentMain" style="text-shadow:none;">
      <div id="rg-gallery" class="rg-gallery">
        <div class="rg-thumbs">
          <div class="es-carousel-wrapper" style="padding:0; background: none;">
              <!--<div class="es-nav">
                  <span class="es-nav-prev">Previous</span>
                  <span class="es-nav-next">Next</span>
              </div> -->
              <div class="es-carousel">
                <ul>
                  <? if(!empty($myphoto)){ 
                    foreach($myphoto as $key => $val){ ?>
                      <li>
                        <a href="#">
                          <img src="<?=$val?>" data-large="<?=$val?>" alt="image<?=$key?>" data-description="<?=($myphoto_name[$key]!='')?$myphoto_name[$key]:' ';?>" />
                        </a>
                      </li>
                  <? }}?>
                </ul>
              </div>
          </div>
        </div>
      </div>
    </div>

    <div data-position="fixed" id="footer" data-role="footer" class="ui-header ui-bar-b" data-theme="b" style="text-align: center; margin: 0px auto;">
      <h4><?=$ClickCollectApp?></h4>
    </div>
  </div>
</body>
</html>