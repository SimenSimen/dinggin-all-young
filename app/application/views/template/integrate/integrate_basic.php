<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
  <script src="https://code.jquery.com/jquery-1.8.3.min.js"></script>
  <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script src="<?=$base_url?>template/js/jquery.touchSlider.js"></script>
  <!--區塊滑動效果-->
  <script type="text/javascript" src="<?=$base_url?>template/js/tabulous.js"></script>
  <!--主題css-->
  <link rel="stylesheet" href="<?=$base_url?>template/css/integrate/<?=$theme_css?>">
  <!-- footer -->
  <link type="text/css" rel="stylesheet" href="<?=$base_url?>template/css/<?=$slider_css?>">
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
<body scroll="yes" style="overflow-x: hidden;">

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
                    <td align="center" height="250"><?php if(!empty($logo_path)):?><img src="<?=$logo_path?>" height="240" width="300"/><?php endif; ?></td>
                </tr>
            </table>
        </div>
        <!--tabs-1-->
        <!--附件-->
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

        <!--tabs-3-->
        <!--相本-->
        <?php if ($photo_show):?>
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
        <?php endif; ?>

        <!--tabs-4-->
        <!--表單-->
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

        <!--tabs-5-->
        <!--影片-->
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
                                <iframe width="320" height="240" src="https://www.youtube.com/embed/<?=$value?>" frameborder="0" allowfullscreen></iframe>
                                <br />
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>

        <!--tabs-6-->
        <!--網站-->
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

        <!--tabs-7-->
        <!--分類-->
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
        
        <!--tabs-8-->
        <!--好康分享 -->
        <?php if($ecp_show): ?>
            <div class='tabs' id="tabs-8">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php foreach ($ecp_url as $key => $value): ?>
                    <tr>
                        <td height="35" align="center" class="topcolor1"><?=$ecp_url_name[$key]?></td>
                    </tr>
                    <tr>
                        <td height="180" valign="top">
                           <img src="<?=$ecp_img[$key]?>" class="tableimg" align="middle" width="95%"><br />
                           <span style="text-align:center;"><?=$ecp_content[$key]?></span>
                           <a class="goob" href="jecp://<?=$jecp[$key]?>" onclick="getShareEncode(this)" style="margin:5px auto;padding:3px;line-height:20px;height:26px"><?=$ecp_btn_name[$key]?></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
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
                <a target="_blank" onclick="location.href='https://maps.google.com.tw/maps/place/<?=$iqr['address']?>'"><img class='link' src="<?=$base_url?>template/images/about-3.png" width="75" alt="地址" /></a>
            <?php endif; ?>
            
            <?php if ($photo_show):?>
                <a href="#tabs-3"><img class='link' src="<?=$base_url?>template/images/about-6.png" width="75" alt="相簿" /></a>
                <br />
            <?php endif; ?>
            
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

            <?php if($ecp_show) : ?>
                <a href="#tabs-8"><img class='link' src="<?=$base_url?>template/images/about-9.png" width="75" alt="好康分享" /></a>
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

    function getShareEncode(obj){
        var val   = obj.getAttribute('href');
        var i_val = "jecp://"+obj.getAttribute('href').substr(12);
        if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) {
            location.href = i_val;
        } else if (/(Android)/i.test(navigator.userAgent)) {
            NetNewsAndroidShare.receiveValueFromJs(val);
        } else {
        };
    }
</script>
</body>
</html>