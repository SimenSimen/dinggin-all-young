<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width">
    <!-- seo -->
    <title><?=$iqr_name?> 行動商務系統</title>
    <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
    <meta name="keywords" content='行動商務系統'>
    <meta name="description" content=''>
    <meta name="author" content=''>
    <meta name="copyright" content=''>
    <!--js-->
    <script src="https://code.jquery.com/jquery-1.8.3.min.js"></script>
    <!--PHOTO-->
    <link rel="stylesheet" type="text/css" href="<?=$base_url?>template/css/photo_demo.css" />
    <link rel="stylesheet" type="text/css" href="<?=$base_url?>template/css/photo_style.css" />
    <link rel="stylesheet" type="text/css" href="<?=$base_url?>template/css/photo_elastislide.css" />
    <!-- footer -->
    <link type="text/css" rel="stylesheet" href="<?=$base_url?>template/css/footerStyle.css">
    <style>
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
</head>

<body scroll="yes" class="bg_01" style="overflow-x: hidden;overflow: -moz-scrollbars-vertical;">
    <div class="container">
        <div class="content">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <!--頂端列設定處 class="topcolor1" footerstyle.css-->
                    <td height="35" align="center" class="topcolor1">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="40" align="center">
                                    <a href="<?=$iqr_url?>"><img class="backtag" src="<?=$base_url?>template/images/back.png" alt="back" /></a>
                                </td>
                                <td align="center"> <?=$photo_category['d_name']?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <br />
            <div id="rg-gallery" class="rg-gallery">
                <div class=" ">
                    <!-- Elastislide Carousel Thumbnail Viewer -->
                    <div class="es-carousel-wrapper">
                        <div class="es-nav">
                            <span class="es-nav-prev">Previous</span>
                            <span class="es-nav-next">Next</span>
                        </div>
                        <div class="es-carousel">
                            <ul>
                            <?php foreach ($photos as $key => $value): ?>
                                <li>
                                    <a href="#"><img src="<?=$value['img_path']?>" data-large="<?=$value['img_path']?>" alt="image03" data-description="<?=$value['note']?>" /></a>
                                </li>
                            <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <!-- End Elastislide Carousel Thumbnail Viewer -->
                </div>
                <!-- rg-thumbs -->
            </div>
            <!-- rg-gallery -->
        </div>
        <!-- content -->
    </div>
    <!-- container -->
    <!-- footer  -->
    <div style="border:none;" data-role="footer">
        <div id="stickBottom">
            <ul class="itemFooter">
                <li><a rel="external" href="index_6.html"><i></i>關於我</a></li>
                <li><a rel="external" href="info.html"><i></i>資訊</a></li>
                <li><a rel="external" href="video.html"><i></i>影片</a></li>
                <li><a rel="external" href="event.html"><i></i>活動</a></li>
                <li><a rel="external" href="g.html"><i></i>照片</a></li>
                <li><a rel="external" href="shop.html"><i></i>購物車</a></li>
            </ul>
            <div class="clear"></div>
        </div>
    </div>
    <!-- footer  -->
    </div>
    <!-- page  -->
</body>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="<?=$base_url?>template/js/jquery.tmpl.min.js"></script>
<script type="text/javascript" src="<?=$base_url?>template/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?=$base_url?>template/js/jquery.elastislide.js"></script>
<script type="text/javascript" src="<?=$base_url?>template/js/gallery.js"></script>
</html>
