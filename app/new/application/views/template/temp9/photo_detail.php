<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<?php $this -> load -> view('template/template4_seo', $data); ?>
        <link type="text/css" rel="stylesheet" href="css/header.css" />
		<link type="text/css" rel="stylesheet" href="css/layout.css" />
		
        <link href="css/font-awesome.min.css" rel="stylesheet">
        
    
        <!-------相簿輪播----------->
            <link type="text/css" rel="stylesheet" href="css/photo-slide.css" />
        

        <!-------設定檔------------>
        <link href="css/setting.css" rel="stylesheet" type="text/css">
        
		<?php $this -> load -> view('template/template4_css', $data); ?>
	</head>
    
	<body class="bg-style">
		<?php $this -> load -> view('template/template4_headmenu', $data); ?>
           
			

                 
           <div class="wrapper">
               <section class="content">
                   
                  
                    <h1 class="content-title set-c-title"><?=$photo_category_name?></h1>
                    
                                 <section class="cntr photo-word set-c-word">
                                      <div class="cntr">
                                          <ul class="pgwSlideshow">
                                              
                        <? if(!empty($myphoto)){ 
								foreach($myphoto as $key => $val){ ?>
                                              <li><img src="<?=$val?>" data-description="<?=$myphoto_name[$key]?>"></li>
                        <? }}?>

                                          </ul>
                                      </div>
                                     
                               </section>
              </section><!-- content -->               
         </div><!--/wrapper-->
        
             
        <!--相簿輪播 JS 要寫在 底下才有用-->     
        <script src="js/jquery.min.js" type="text/javascript"></script> 
  </body>
</html>