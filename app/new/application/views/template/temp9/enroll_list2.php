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
		<?php $this -> load -> view('template/template4_headmenu2', $data); ?>
			

                 
                 <div class="wrapper">
  
                   <section class="content animated2 fadeInDown">
                        
                        

                                <?php foreach ($uform as $key => $value): ?>
                           <article class="enroll-list">
                                <a href="<? echo '/form/index8/',$value['ufm_id'],'/',$value['member_id'],'/',$id,'/',$viewtype?>">                                                             
                                  <h2 class="set-title01"><?=$value['ufm_name']?></h2> 
                                  
                                </a>  
                           </article>
                                <?php endforeach; ?>
                           
                           
                           
                   </section>
                   
               </div><!--/wrapper-->
              
               
               
  </body>
</html>