<!DOCTYPE html>
<html>
   <head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php $this -> load -> view('template/template4_seo', $data); ?>
        <link type="text/css" rel="stylesheet" href="css/header.css" />
		<link type="text/css" rel="stylesheet" href="css/layout.css" />
		<script type="text/javascript" src="js/jquery-1.9.0.min.js"></script>
        <link href="css/font-awesome.min.css" rel="stylesheet">        
        <link href="css/animateCSS.css" rel="stylesheet">
        
        <!-------設定檔------------>
        <link href="css/setting.css" rel="stylesheet" type="text/css">
		<?php $this -> load -> view('template/template4_css', $data); ?>
	</head>
    
	<body class="bg-style">
		<?php $this -> load -> view('template/template4_headmenu', $data); ?>
    
           
		
			<header class="header">	
				<?=$iqr_name?> <?=$iqr_en_name?>
			</header>
			
            <div class="cover-img">
			<?php if(!empty($logo_path)){?>
                <img src="<?=$logo_path?>">
            <?php }else{ ?>
                <img src="images/cover-image.jpg" >
            <?php } ?>
            </div>

             <div class="wrapper">
                   
                  <div class="index-nav-menu">
                      <ul>
         <li><a href="/business/about/<?=$account?>">個人資訊</a></li>
	<!--影片-->
	<?php if ($ytb_link_num != 0): ?>
		 <li><a href="<?=$base_url?>business/two_temp_list/<?=$account?>/P/film_list">影片</a></li>
	<?php endif; ?>
	<!--相本-->
	<?php if ($photo_show):?>
		 <li><a href="<?=$base_url?>business/two_temp_list/<?=$account?>/P/photo_list">相簿</a></li>
	<?php endif; ?>
	<!--分類-->
	<?php if(!empty($iqr_html_page)):?>
		 <li><a href="<?=$base_url?>business/two_temp_list/<?=$account?>/P/article_list">文章</a></li>
	<?php endif; ?>
	<!--表單-->
	<?php if ($uform_show): ?>
		 <li><a href="<?=$base_url?>business/two_temp_list/<?=$account?>/P/enroll_list">報名表單</a></li>
	<?php endif; ?>
	<!--網站-->
	<?php if ($website_num != 0): ?>
		 <li><a href="<?=$base_url?>business/two_temp_list/<?=$account?>/P/website_list">網路連結</a></li>
	<?php endif; ?>
	<!--附件-->
	<?php if ($exfile_show): ?>
		 <li><a href="<?=$base_url?>business/two_temp_list/<?=$account?>/P/annex_list">附件</a></li>
	<?php endif; ?>
	<!--好康分享 -->
	<?php if($ecp_show): ?>
			 <li><a href="<?=$base_url?>business/two_temp_list/<?=$account?>/P/coupon_list">好友分享券</a></li>
	<?php endif; ?>
	<!--購物車 -->
	<?php if($store['cset_active'] == 1): ?><li><a href="<?=$base_url.'cart/store/'.$store['cset_code']?>"><?=$store['cset_name']?></a></li><?php endif; ?>


                            
                      
                      </ul>
                  </div>
            </div><!--/wrapper-->
                  
          
      
           
      
            
	  
  </body>
</html>