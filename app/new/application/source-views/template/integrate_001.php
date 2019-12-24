<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="content-type" content="text/html;charset=utf-8" />
  <meta name="viewport" content="width=device-width">

  <!-- seo -->
  <title><?=$iqr_name?> 行動商務系統</title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content='行動商務系統'>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <!--js-->
  <script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
  <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script src="<?=$base_url?>template/js/jquery.touchSlider.js"></script>
  <!--區塊滑動效果-->
  <script type="text/javascript" src="<?=$base_url?>template/js/tabulous.js"></script>
  <!--主題css-->
  <link rel="stylesheet" href="<?=$base_url?>template/css/integrate/<?=$theme_css?>">
  <!-- footer -->
  <link type="text/css" rel="stylesheet" href="<?=$base_url?>template/css/footerStyle.css">
  <!-- user style -->
    <style type="text/css">
        .link {
          max-width: 140px;
          max-height: 140px;
          border: 0;
        }
        /* font color */
        .user_text
        {
          color:<?=$font_color?>;
          font-size:<?=$font_size?>px;
          font-family:"<?=$font_family?>";
        }
        <?php if ($bg_type == 0 || $bg_image_path == ''): ?>
            body
            {
              background-color:<?=$bg_color?>;
            }
        <?php elseif($bg_image_path != ''): ?>
            /* 背景圖 */
            body
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

  <script>
    $(document).ready(function($) {
      $("#tabs").tabs();
      $("#tabs").tabulous({
        effect: 'slideLeft'
      });
    });
  </script>

</head> 
<body class="bg_01" scroll="yes" style="overflow-x: hidden;">

<div id="tabs">
    <div id="tabs_container">
        <!--div tabs_container-->
        <!--歡迎大頭貼or 圖 tabs-1-->
        <div id="tabs-1" class="tabsarea">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <!--頂端列設定處 class="topcolor1" 若改色 尚有style_area.css第80行需修改-->
                    <td height="35" align="center" class="topcolor1">歡迎您!</td>
                </tr>
                <tr>
                    <td align="center" height="240"><?php if(!empty($iqr['logo_path'])):?><img src="<?=$base_url?><?=$iqr['logo_path']?>" width="300"/><?php endif; ?></td>
                </tr>
            </table>
        </div>
        <!--tabs-1-->
        <!--分享-->
        <?php if ($exfile_show): ?>
            <div id="tabs-2">
                <!--tabs-2-->
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <!--頂端列設定處 class="topcolor1" 若改色 尚有style_area.css第80行需修改-->
                        <td height="35" align="center" class="topcolor1"> 附件下載 </td>
                    </tr>
                    <tr>
                        <td align="center" height="270">
                            <BR />
                                <?php if ($exfile_show): ?>
                                    <?php foreach ($doc_path as $key => $value): ?>
                                        <a class="aa04" id="icon13" onclick="location.href='<?=$base_url?><?=substr($value, 1)?>'"> <?=$doc_name[$key]?></a>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        <?php endif; ?>
        <!--tabs-2-->
        <!--分享-->
        <!--相本-->
        <!--tabs-3-->
        <?php if($photo_show): ?>
        <div id="tabs-3">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <!--頂端列設定處 class="topcolor1" 若改色 尚有style_area.css第80行需修改-->
                        <td height="35" align="center" class="topcolor1">點圖進入相本</td>
                    </tr>
                <?php foreach ($photo_category as $key => $value): ?>
                    <?php if($value['show']): ?>
                    <tr>
                        <td align="center" height="30">
                            <p class="name"><?=$d_name?></p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" height="240">
                            <a href onclick="location.href='<?=$base_url?>business/photo/<?=$account?>/<?=$value['d_id']?>'"><img src="<?=$value['L_image']?>" width="300" /></a>
                        </td>
                    </tr>
                    <?php endif;?>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif;?>
        <!--tabs-3-->
        <!--表單-->
        <!--tabs-4-->
        <?php if ($uform_show): ?>
            <div class='tabs' id="tabs-4">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <!--頂端列設定處 class="topcolor1" 若改色 尚有style_area.css第80行需修改-->
                        <td height="35" align="center" class="topcolor1">表單</td>
                    </tr>
                    <tr>
                        <td height="250" valign="top">
                            <center>
                                <?php if ($uform_show): ?>
                                    <?php foreach ($ufm_id as $key => $value): ?>
                                        <a class="aa00" id="icon14" href="#" onclick="location.href='<?=$base_url?>form/index/<?=$value?>/<?=$mid?>'"><?=$ufm_btn_name[$key]?></a>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </center>
                        </td>
                    </tr>
                </table>
            </div>
        <?php endif; ?>
        <!--表單-->
        <!--tabs-4-->
        <!--影片-->
        <!--tabs-5-->
        <?php if ($ytb_link_num != 0): ?>
            <div class='tabs' id="tabs-5">
                <table width="100%" height="300" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <!--頂端列設定處 class="topcolor1" 若改色 尚有style_area.css第80行需修改-->
                        <td height="35" align="center" class="topcolor1">影片</td>
                    </tr>
                    <?php foreach ($ytb_link as $key => $value): ?>
                        <tr>
                            <td align="center" height="30"><?=$ytb_link_name[$key]?>!</td>
                        </tr>
                        <tr>
                            <td align="center" height="240">
                                <iframe width="320" height="240" src="http://www.youtube.com/embed/<?=$value?>" frameborder="0" allowfullscreen></iframe>
                                <br />
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
        <!--影片-->
        <!--tabs-5-->
        <!--網站-->
        <!--tabs-6-->
        <?php if ($website_num != 0): ?>
            <div class='tabs' id="tabs-6">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <!--頂端列設定處 class="topcolor1" 於footerstyle.css-->
                        <td height="35" align="center" class="topcolor1">網站</td>
                    </tr>
                    <tr>
                        <td height="250" valign="top">
                            <center>
                            <?php foreach ($website as $key => $value): ?>
                                <a class="aa00" id="icon14" onclick="location.href='<?=$value?>'"><?=$website_name[$key]?></a>
                            <?php endforeach; ?>
                            </center>
                        </td>
                    </tr>
                </table>
            </div>
        <?php endif; ?>
        <!--網站-->
        <!--tabs-6-->

        <!--分類-->
        <!--tabs-7-->
        <?php if(!empty($iqr_html_page)):?>
            <div class='tabs' id="tabs-7">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td height="35" align="center" class="topcolor1">分類</td>
                    </tr>
                    <tr>
                        <td height="250" valign="top">
                            <center>
                            <?php foreach ($iqr_html_page as $key => $value): ?>
                                <a class="aa00" id="icon14" onclick="location.href='<?=$base_url?>business/html_web/<?=$value['html_id']?>'"><?=$value['html_name']?></a>
                            <?php endforeach; ?>
                            </center>
                        </td>
                    </tr>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <!--End tabs container-->
    <center>
        <ul>
            <!--8個以下的按鈕程式判斷需變動頁面-->
            <!--8個按鈕於第四個按鈕斷行、7個於第三個按鈕斷行、六個於第三個按鈕斷行、五個於第二個按鈕斷行、4個於第二個按鈕斷行-->
            <a href="#tabs-1" onclick="location.href='<?=$base_url?>business/about/<?=$account?>'"><img class='link' src="<?=$base_url?>template/images/about-1.png" width="75" alt="me" /></a>
            
            <?php if ($exfile_show): ?>
                <a href="#tabs-2"><img class='link' src="<?=$base_url?>template/images/about-2.png" width="75" alt="下載" /></a>
            <?php endif; ?>
            
            <?php if (!empty($iqr['address'])): ?>
                <a onclick="location.href='http://maps.google.com.tw/maps/place/<?=$iqr['address']?>'"><img class='link' src="<?=$base_url?>template/images/about-3.png" width="75" alt="地址" /></a>
            <?php endif; ?>
            <?php if (!empty(var)):?>
            <a href="#tabs-3"><img class='link' src="<?=$base_url?>template/images/about-6.png" width="75" alt="相簿" /></a>
            <br />
            
            <?php if ($uform_show): ?>
                <a href="#tabs-4"><img class='link' src="<?=$base_url?>template/images/about-5.png" width="75" alt="表單" /></a>
            <?php endif; ?>
            
            <?php if ($ytb_link_num != 0): ?>
                    <a href="#tabs-5"><img class='link' src="<?=$base_url?>template/images/about-4.png" width="75" alt="影片" /></a>
            <?php endif; ?>
            
            
            <?php if ($website_num != 0): ?>
                <a href="#tabs-6"><img class='link' src="<?=$base_url?>template/images/about-7.png" width="75" alt="網站" /></a>
            <?php endif; ?>
            <?php if(!empty($iqr_html_page)) :?>
                <a href="#tabs-7"><img class='link' src="<?=$base_url?>template/images/about-8.png" width="75" alt="分類" /></a>
            <?php endif; ?>
        </ul>
        <br>
        <br>
        <br>
        <br>
    </center>
</div>
<!--End tabs-->
     
<!--script-->
<script type="text/javascript">
  //圖片縮圖
  $(window).load(function() {
    $("img").each(function(i) {
      if ($(this).attr('class') == 'link') {
        $(this).removeAttr('width');
        $(this).removeAttr('height');

        //取得影像實際的長寬
        var imgW = $(this).width();

        var imgH = $(this).height();

        //計算縮放比例
        var w = ($(window).width() * 22 / 100) / imgW;
        var h = w;
        var pre = 1;
        if (w > h) {
          pre = h;
        } else {
          pre = w;
        }
        //設定目前的縮放比例
        $(this).width(imgW * pre);
        $(this).height(imgH * pre);
      }
    });
  });
</script>
</body>
</html>