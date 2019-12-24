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
  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
  <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
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
			title		: '文章分類'
		}
	});
});
</script>
</head>
<script type="text/javascript">
	$(function(){
		// 幫 #qaContent 的 ul 子元素加上 .accordionPart
		// 接著再找出 li 中的第一個 div 子元素加上 .qa_title
		// 並幫其加上 hover 及 click 事件
		// 同時把兄弟元素加上 .qa_content 並隱藏起來
		$('#qaContent ul').addClass('accordionPart').find('li div:nth-child(1)').addClass('qa_title').hover(function(){
			$(this).addClass('qa_title_on');
		}, function(){
			$(this).removeClass('qa_title_on');
		}).click(function(){
			// 當點到標題時，若答案是隱藏時則顯示它，同時隱藏其它已經展開的項目
			// 反之則隱藏
			var $qa_content = $(this).next('div.qa_content');
			if(!$qa_content.is(':visible')){
				$('#qaContent ul li div.qa_content:visible').slideUp();
			}
			$qa_content.slideToggle();
		}).siblings().addClass('qa_content').hide();
	});
</script>

</head> 
<body scroll="yes" style="overflow-x: hidden;">

    <div id="header" class="Fixed">
                <div class="header-left" ><a id="hamburger" href="#menu"></a></div>
                <div class="header-logo" >
                公司相簿
                <!--
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
             <td>
                 <table width="100%" border="0" align="right" cellpadding="0" cellspacing="0">
                 	<? 
        						if(!empty($data)){
        						foreach($data as $val){?>
                      <tr onclick="location.href='<? echo $url.$id.'/'.$val['d_id']?>'">
                        <td>
                          <img src="<?=$val['first_img']?>" width="50" height="50" class="infoimg" />
                        </td>
                        <td><?=$val['d_name']?></td>                    
                      </tr> 
                           <? }
      					 	}?>
                     <!--<tr onclick="location.href='<? echo $url.$id.'/2'?>'">
                       <td>公司相簿</td>
                    
                     </tr>  -->       
                 </table>
             </td>
          
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