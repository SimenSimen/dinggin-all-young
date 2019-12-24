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
 
        
		<?php $this -> load -> view('template/template3_css', $data); ?>
	   
	</head>
    
	<body class="bg-style">
		<div id="page">
			<header class="header <?=$set_header?>">
				<a href="#menu"></a>
				關於我 / <?=$viewname?>影片
			</header>
			
            
			<?php $this -> load -> view('template/template3_menu', $data); ?>
            
          
                 
                 
                 <div class="wrapper">                  
          
                  
                    <section class="content">
                         
                         <h2 class="content-title"><?=$film['str_name']?></h2>
                         <section class="vedio-box">   
                            <div class="video-container">
                              <iframe src="https://www.youtube.com/embed/<?=$film['str']?>" frameborder="0" allowfullscreen>
                            </div> 
                         </section>  
                         
                         
                   </section>
                   
           </div><!--/wrapper-->
    
	   </div><!--/page-->
  </body>
</html>
