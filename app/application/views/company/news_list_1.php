<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="content-type" content="text/html;charset=utf-8" />
  <meta name="viewport" content="width=device-width">

  <!-- seo -->
  <title><?=$iqr_name?> <?=$ActionBusinessSystem?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content='<?=$ActionBusinessSystem?>'>
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
			title		: '<?=$ArticleClass?>'
		}
	});
});
</script>
</head>

<body scroll="yes" style="overflow-x: hidden;">

    <div id="header" class="Fixed">
    <div class="header-left" ><a id="hamburger" href="#menu"></a></div>
    <div class="header-logo" >
    <?=$CompanyArticles?>
    </div>
</div><!--header-->
<?php $this -> load -> view('company/left_1', $data); ?>
    
     <div class="index-bill">
         
         <table width="100%" id="table_knowledge"  border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td height="45" align="center" bgcolor="#338585" >&nbsp;</td>
           </tr>
           <tr>
             <td>
             	<table width="100%" border="0" align="right" cellpadding="0" cellspacing="0">
                 <!--<tr onclick="location.href='info_c.html'">
                   <td align="center"><img src="atmandcs/images/cmp_pic/list_pic2_06.jpg" width="50" height="50" class="infoimg" /></td>
                   <td>會員註冊說明<br />
                     2015-06-11</td>
                 <td align="right" valign="bottom"><br />
                       <img src="atmandcs/images/lll.png" />23</td>
                 </tr>-->
                 <!--無圖排版方式參考這-->
                 <? if(!empty($data)){
					 foreach($data as $val){?>
                 <tr onclick="location.href='<? echo $url.$id.'/'.$val['html_id']?>'">
                   <td colspan="2" valign="middle"><?=$val['html_name']?></td>
                   <td align="right" valign="bottom"><br />  
                 </tr>
                 <? }}?>
                  <!--無圖排版方結尾-->                
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

 
</body>

<!-- Mirrored from i-qrcode.org/business/style_view/5 by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 02 Jun 2015 06:40:32 GMT -->
</html>