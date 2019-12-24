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
                          <h2 class="content-title set-c-title"><?=$data[0]['html_name']?></h2>
                                    
                          <div class="word-area set-c-word"><?=$data[0]['html_content']?>
                          </div>   
                    </section>
                   
               </div><!--/wrapper-->
              
             
	 
  </body>
</html>