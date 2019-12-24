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
           
           
                 
                 <div class="wrapper">
  
                        <section class="content">
                         
                         <h2 class="content-title set-c-title"><?=$film['str_name']?></h2> 
                         
                         <section class="vedio-box">   
                            <div class="video-container">
                              <iframe src="https://www.youtube.com/embed/<?=$film['str']?>" frameborder="0" allowfullscreen="" fs="1" scrolling="no"></iframe>
                            </div> 
                            
                             <section class="shadow"><img src="images/shadow.png"></section>
                         </section>  
                         
                         
                       </section>         
                </div><!--/wrapper-->    
           
           
           
              
            
	 
  </body>
</html>