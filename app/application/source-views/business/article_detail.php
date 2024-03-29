<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<?php $this -> load -> view('template/template3_seo', $data); ?>

		<link type="text/css" rel="stylesheet" href="<?=$base_url?>template/temp3/css/header.css" />
		<link type="text/css" rel="stylesheet" href="<?=$base_url?>template/temp3/css/layout.css" />
		<script type="text/javascript" src="<?=$base_url?>template/temp3/js/jquery-1.9.0.min.js"></script>
        <link href="<?=$base_url?>template/temp3/css/font-awesome.min.css" rel="stylesheet">
        
        <!------左側欄-------->
        <link type="text/css" rel="stylesheet" href="<?=$base_url?>template/temp3/css/jquery.mmenu.all.css" />
		<script type="text/javascript" src="<?=$base_url?>template/temp3/js/jquery.mmenu.min.all.js"></script>
		<script type="text/javascript">
			$(function() {
				$('nav#menu').mmenu();
			});
		</script>
        
       <!--下拉選單 -->
       <script type="text/javascript" src="<?=$base_url?>template/temp3/js/dropdown.js"></script>
       <link type="text/css" rel="stylesheet" href="<?=$base_url?>template/temp3/css/dropdown.css" />

		<?php $this -> load -> view('template/template3_css', $data); ?>
	</head>
    
	<body class="bg-style">
		<div id="page">
			<header class="header set_header">
			    <div ref="<?=$public_share_buttom_url?>" id="head_share_buttom" style="position:absolute;top:0;right:0;margin:.3rem 1rem 0 0"><span class="finger_point"><img src="<?=$base_url?>template/temp3/images/share_btn.png"></span></div>
				<a href="#menu"></a>
				關於我 / <?=$viewname?>文章
			</header>
			<?php $this -> load -> view('template/public_share', $data); ?>
			<?php $this -> load -> view('template/template3_menu', $data); ?>
          
                 
                 
            <div class="wrapper">                  


                    <section class="content">
                        <h2 class="content-title"><?=$data[0]['html_name']?></h2>
                                  
                        <div class="word-area">
							<?=$data[0]['html_content']?>
                        </div>   
                     <!------------分享------------->
                        <div class="btn-share">
                          <a href="javascript:avoid(0)" onclick="gobarcodeurl()">收藏</a>
                        </div>
                   </section>
                   
    <script language="javascript">
    function gobarcodeurl(){
		location ='<?=$public_barcodeurl?>';
     }
    </script>
			
           </div><!--/wrapper-->
    
	   </div><!--/page-->
  </body>
</html>
