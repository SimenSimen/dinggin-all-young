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
      
        <!--設定檔-->
        <link href="css/setting.css" rel="stylesheet" type="text/css">
		<?php $this -> load -> view('template/template4_css', $data); ?>
	</head>
    
	<body class="bg-style">
		<?php $this -> load -> view('template/template4_headmenu', $data); ?>
            
			<header class="header">	
				<?=$TeamData?>
			</header>
            

             <div class="wrapper">

                    <div class="index-nav-menu animated2 fadeIn">
                      <ul>
	<!--分類-->
		 <li><a href="<?=$base_url?>business/two_temp_list/<?=$account?>/C/article_list"><?=$CompanyPage?></a></li>
	<!--影片-->
		 <li><a href="<?=$base_url?>business/two_temp_list/<?=$account?>/C/film_list"><?=$CompanyVideo?></a></li>
	<!--相本-->
		 <li><a href="<?=$base_url?>business/two_temp_list/<?=$account?>/C/photo_list"><?=$CompanyGallery?></a></li>
	<!--表單-->
		 <li><a href="<?=$base_url?>business/two_temp_list/<?=$account?>/C/enroll_list"><?=$CompanyForm?></a></li>
	<!--附件-->
		 <li><a href="<?=$base_url?>business/two_temp_list/<?=$account?>/C/annex_list"><?=$CompanyExfile?></a></li>
	<!--網站-->
		 <li><a href="<?=$base_url?>business/two_temp_list/<?=$account?>/C/website_list"><?=$WebLink?></a></li>
	<!--好康分享 -->
			 <li><a href="<?=$base_url?>business/two_temp_list/<?=$account?>/C/coupon_list"><?=$FriendTicket?></a></li>

<?php if($store['cset_active'] == 1){ ?>
	<li><a href="<?=$base_url.'cart/store/'.$mother_cset_code?>"><?=$ShoppingCart?></a></li>
<? } //php if($store['cset_active'] == 1){ ?>

                            
                      
                      </ul>
                  </div>

     
            </div><!--/wrapper-->
	  
  </body>
</html>