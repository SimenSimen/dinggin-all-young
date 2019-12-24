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
			<header class="header  set_header">
				<a href="#menu"></a>
				MENU
			</header>
			
            
			<?php $this -> load -> view('template/template3_menu', $data); ?>
            
          
            
                 <div class="wrapper">
                 
                        <section class="about-box">
                            <div class="about-me"> 
                               <div class="about-photo"><!--<img src="<?=$base_url?>template/temp3/images/people-photo.jpg" width="400" height="400" align="center">--></div>
                               <h1><?=$iqr_name?></h1><p>關於我</p>    
                            </div> 
                            
                           <div class="index-nav-menu">
                              <ul>
			<?php $this -> load -> view('template/template3_lip', $data); ?>
                                     
                              </ul>                                                                          
                           </div>     
                        </section>       
                         
                          <section class="team-box"> 
                               <h1>團隊情報<i><img src="<?=$base_url?>template/temp3/images/team-icon.png" align="center"></i></h1>
                               <p class="line"></p>
                               <div class="index-nav-menu">
                                 <ul> 
			<?php $this -> load -> view('template/template3_lic', $data); ?>
                                 </ul>
                               </div>
                               
                          </section>
         
                </div><!--/wrapper-->
                  
          
            
            
	   </div><!--/page-->
  </body>
</html>