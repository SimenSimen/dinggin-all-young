<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
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
  <meta property="og:url"         content="<?=$share_link?>"></meta>
  <meta property="og:title"       content="<?=$share_title?>"></meta>
  <meta property="og:description" content="<?=$share_title?>"></meta>
  <meta property="og:image"       content="<?=$base_url?><?=$icon?>"></meta>

  <!--icon-->
  <link href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

  <!--js-->
  <link rel="stylesheet" href="/js/jqm/jquery.mobile-1.4.2.min.css">
  <script src="/js/jqm/jquery.js"></script>
  <script src="/js/jqm/jquery.mobile-1.4.2.min.js"></script>

  <!-- jquery.qrcode -->
  <script src="/js/jqrcode/jquery.qrcode-0.7.0.js"></script>
  <script src="/js/jqrcode/ff-range.js"></script>
  <script src="/js/jqrcode/script_for_iqr.js"></script>
  <script type="text/javascript">
    $(window).load(function(){
      // $('canvas').css('width', '800px');
      $("img").each(function(i){
        if($(this).attr('class') != 'share')
        {
          //移除目前設定的影像長寬
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

      $('#text').click(function(){
          window.open('<?=$share_link?>', '<?=$share_title?>', config='scrollbars=1,outerWidth=300,innerWidth=300,height=640,width=300,left=900,scrollbar=yes');
      });
      $('#share_btn_table').css('width', ($(window).width()*91/100));
      $('#share_btn_table').css('text-align', 'center');
      $('#share_btn_table').css('padding-right', '1px');
      // $('#share_btn_table').css('padding-bottom', '20px');
    });
  </script>

</head>

<center>
<body>
<!-- page -->
<div data-role="page" class="type-interior ui-page ui-body-c ui-page-active" id="page1">

  <!-- header -->
  <div data-role="header" class="ui-header ui-bar-b" data-theme="b" role="banner">
    <a href="<?=$iqr_url?>" data-ajax="false" data-icon="arrow-l" class="ui-btn-left ui-btn ui-shadow ui-btn-corner-all ui-btn-icon-left ui-btn-up-a" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="a"><span class="ui-btn-inner ui-btn-corner-all"><span class="ui-btn-text"><i class="fa fa-arrow-left"></i></span><span class="ui-icon ui-icon-arrow-l ui-icon-shadow">&nbsp;</span></span></a>
    <h1><?=$this -> web_title?></h1>
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
              <a href="https://line.naver.jp/R/msg/text/?<?=$share_title?> <?=$share_link?>" rel="nofollow" ><img src="<?=$base_url?>/images/share_btn/line_35x35.png" class='share' style='border:0;'/></a>
          </td>
          <td>
              <!-- Email -->
              <a href="mailto:?subject=<?=$share_title?>&body=<?=$share_title?>：<br><?=$share_link?>">
                  <img class='share' id='email' title="<?=$UseEmail?>" src="<?=$base_url?>/images/share_btn/email_35x35.png" />
              </a>
          </td>
      </tr>
    </table>
    <?php if($button): ?>
      <button style="width:85%;height:62.8px;text-shadow:none; background:#333" name="iqr_url" id="text"><span style="text-shadow:none; color: white;"><?=$ClickDownload?></span></button>
    <?endif;?>
    <div id="container" class="viewer_container" style='display:none;'>   

    </div>

    <!-- edit qrcode target -->
    <input type='hidden' name='edit_target' id="edit_target" value='<?=$edit_target?>'>
    <input type='hidden' name='mode_value' id="mode_value" value='<?=$mode_value?>'>
    <input type='hidden' name="base_url" id="base_url" value='<?=$base_url?>'/>
    <input type='hidden' name="id" id="id" value='<?=$account?>'/>
    <input type='hidden' name="mid" id="mid" value='<?=$mid?>'/>
    <input type='hidden' name="iqr_url" id="iqr_url" value='<?=$iqr_url?>'/>

    <input name="size"          id="size"       type="hidden" value='450'  />
    <input name="fill"          id="fill"       type="hidden" value='<?=$style['fill']?>' />
    <input name="background"    id="background" type="hidden" value='<?=$style['background']?>' />
    <input name="minversion"    id="minversion" type="hidden" value='<?=$style['minversion']?>' />
    <input name="eclevel"       id="eclevel"    type="hidden" value='<?=$style['eclevel']?>'  />
    <input name="quiet"         id="quiet"      type="hidden" value='<?=$style['quiet']?>'  />
    <input name="radius"        id="radius"     type="hidden" value='<?=$style['radius']?>'  />
    <input name="mode"          id="mode"       type="hidden" value='<?=$style['mode']?>'  />
    <input name="msize"         id="msize"      type="hidden" value='<?=$style['msize']?>' />
    <input name="mposx"         id="mposx"      type="hidden" value='<?=$style['mposx']?>' />
    <input name="mposy"         id="mposy"      type="hidden" value='<?=$style['mposy']?>'  />
    <input name="label"         id="label"      type="hidden" value="<?=$style['label']?>" />
    <input name="fontcolor"     id="fontcolor"  type="hidden" value='<?=$style['fontcolor']?>' />
    <input name="font"          id="font"       type="hidden" value='<?=$style['font']?>' />

  <!-- mecard -->
  <?php if ($edit_target == 1): ?>
    <script>
    $(function(){
      $("#img-buffer").click( function() {
        $.get('/business/ajax_qrcode_content', { mid: $("#mid").val(), iqr_url: encodeURIComponent($("#iqr_url").val()) }, function(response) {
          if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) {
            i_target_Qrcode(response);
        } else if (/(Android)/i.test(navigator.userAgent)) {
            NetNewsAndroid.targetQrcode(response);
        } else {
        }
        });
      });
    });
    </script>
    <input name="lastname"      id="lastname"   type="hidden"  value='<?=$iqr['lastname']?>'/>
    <input name="firstname"     id="firstname"  type="hidden"  value='<?=$iqr['firstname']?>'/>
    <input name="mphone"        id="mphone"     type="hidden"  value='<?=$mphone?>'/>
    <input name="cpn_name"      id="cpn_name"   type="hidden"  value='<?=$iqr['cpn_name']?>'/>
    <input name="cpn_tel"       id="cpn_tel"    type="hidden"  value='<?=$cpn_tel?>'/>
    <input name="cpn_fax"       id="cpn_fax"    type="hidden"  value='<?=$cpn_fax?>'/>
    <input name="cpn_addr"      id="cpn_addr"   type="hidden"  value='<?=$iqr['cpn_addr']?>'/>
    <input name="ecard_mail"    id="ecard_mail" type="hidden"  value='<?=$iqr['ecard_mail']?>'/>
    <input name="cpn_website"   id="cpn_website"type="hidden"  value='<?=$iqr_url?>'/>

  <?php endif; ?>
  
    <img id="img-buffer" src="<?=$img_content?>"/>
    <p style="font-family:'微軟正黑體';"><?=$EmbedImageNotShow?></p>
    
    <?php if(!$button): ?>
      <h3><span style="text-shadow:none; color: red;"><?=$ClickDownload?></span></h3>
    <?php endif; ?>

</div>


<div data-role="footer" class="ui-header ui-bar-b" data-theme="b" id="ftrMain" name="ftrMain" role="banner"><h4><a onClick="window.location.href=window.location.href"><?=$web_config['iqr_footer_text']?></a></h4></div>

</div><!-- /page -->

</body>
</html>