<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<?php $this -> load -> view('template/template3_seo', $data); ?>

        <link type="text/css" rel="stylesheet" href="/template/temp3/css/header.css" />
		<link type="text/css" rel="stylesheet" href="/template/temp3/css/layout.css" />
		<script type="text/javascript" src="/template/temp3/js/jquery-1.9.0.min.js"></script>
        <link href="/template/temp3/css/font-awesome.min.css" rel="stylesheet">
        
        <!------左側欄-------->
        <link type="text/css" rel="stylesheet" href="/template/temp3/css/jquery.mmenu.all.css" />
		<script type="text/javascript" src="/template/temp3/js/jquery.mmenu.min.all.js"></script>
		<script type="text/javascript">
			$(function() {
				$('nav#menu').mmenu();
			});
		</script>
 
        
       <!--下拉選單 -->
       <script type="text/javascript" src="/template/temp3/js/dropdown.js"></script>
       <link type="text/css" rel="stylesheet" href="/template/temp3/css/dropdown.css" />
		<?php $this -> load -> view('template/template3_css', $data); ?>
	</head>
    
	<body class="bg-style">
		<div id="page">
			<header class="header">
				<a href="#menu"></a>
				關於我 / 好友分享券
			</header>
			
        <?php $this -> load -> view('template/template3_menu', $data); ?>
            
          
                 
        <!--好康分享 -->
        <?php if($ecp_show): ?>

            <div class="wrapper">                  
   
                    
                 <section class="content">

                    <?php foreach ($ecp_url as $key => $value): ?>
					  <article class="share-list w-half">
							<a href="<?=$ecp_url_detail[$key]?>"><!----.fix讓不同長寬大小的圖片，截取中間------------------------->
							  <div class="item-img fix"><img src="<?=$ecp_img[$key]?>"></div>                                                              
							  <h2><?=$ecp_content[$key]?></h2> 
							</a>  
					   </article>
                    <?php endforeach; ?>
                               
                </section>
                   
           </div><!--/wrapper-->

			

		<?php endif; ?>

                 
    
	   </div><!--/page-->
  </body>
</html>