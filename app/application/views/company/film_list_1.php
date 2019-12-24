<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="content-type" content="text/html;charset=utf-8" />
  <meta name="viewport" content="width=device-width">

  <!-- seo -->
  <title><?=$iqr_name?> <?=$BusinessSystem?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content='<?=$BusinessSystem?>'>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>
  <!--js-->
  <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
  <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script src="/js/jquery.touchSlider.js"></script>
  
  <!--側欄選單效果-->
  <script type="text/javascript" src="/js/jqmeun/jquery.mmenu.min.all.js"></script> 
  <script type="text/javascript" src="/js/jqmeun/jquery.mmenu.fixedelements.min.js"></script>
<link rel="stylesheet" type="text/css" href="/css/menuA.css" />
<link type="text/css" rel="stylesheet" href="/js/jqmeun/jquery.mmenu.css" />

  <!--css-->
  <link rel="stylesheet" href="/css/style_area.css">
  
  <!--主題css-->

 <!-- footer -->
    <link type="text/css" rel="stylesheet" href="/css/footerStyle.css">

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
<script type="text/javascript">
$(function() {
	$('nav#menu').mmenu({
		extensions	: [ 'effect-slide-menu', 'pageshadow' ],
		navbar 		: {
			title		: '<?=$ArticleCategory?>'
		}
	});
});
</script>
</head>

<body scroll="yes" style="overflow-x: hidden;">

    <div id="header" class="Fixed">
                <div class="header-left" ><a id="hamburger" href="#menu"></a></div>
                <div class="header-logo" >
                <?=$CompanyFilm?><!--
                <img src="../../system/media/app_shop/tem/entIMG/mobile_logo.png" />
                -->
                </div>
                <!--SHOP取消
                    <div class="header-right"><a href="https://www.177buy.com.tw/index.php/mobile_order/all_shopping_list"><img src="../../images/apppic/shop_0.png"></a></div>
                    -->
</div><!--header-->
<?php $this -> load -> view('company/left_1', $data); ?>
    
     <div class="index-bill">
         
         <table width="100%" id="table_knowledge"  border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td height="45" align="center" bgcolor="#338585" >&nbsp;</td>
           </tr>
           <tr>
             <td><table width="100%" border="0" align="right" cellpadding="0" cellspacing="0">
                 <? if(!empty($data)){
					 foreach($data as $val){?>
                 <tr onclick="location.href='<? echo $url.$id.'/'.$val['str_id']?>'">
                   <!--<td width="80" align="center"></td>-->
                   <td><?=$val['str_name']?></td>
				   <!--<td width="80" align="right" valign="bottom">
                   </td>-->
                 </tr>
                 <? }} else echo '<center>','<?=$NoCategory?>','</center>'; ?>

             </table></td>
           </tr>
         </table>
           <!--確保下方內容被看見-->
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td height="55" align="center">&nbsp;</td>
           </tr>
           </table><!--確保下方內容被看見-->
       </div>
     <!--index-bill-->
        
     
             <!-- footer  -->
<!-- <div style="border:none;" data-role="footer">
                <div id="stickBottom" >
                   <ul class="itemFooter">
                     
                      <li><a rel="external" href="index_6.html" style="font-weight:inherit;"><i></i>關於我</a></li>
                     <li><a rel="external" href="info.html"><i></i>資訊</a></li>
                      <li><a rel="external" href="video.html"><i></i>影片</a></li>
                      <li><a rel="external" href="event.html"><i></i>活動</a></li>
                      <li><a rel="external" href="g.html"><i></i>照片</a></li>
                      <li><a rel="external" href="shop.html"><i></i>購物車</a></li>
                   </ul>
                    <div class="clear"></div>
                </div>
</div> -->
 
</body>

<!-- Mirrored from i-qrcode.org/business/style_view/5 by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 02 Jun 2015 06:40:32 GMT -->
</html>