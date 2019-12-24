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
                     <section class="content animated fadeInUp">
                     

                 <? if(!empty($iqr_html)){
					 foreach($iqr_html as $val){?>

                           <article class="article-list">
                                <a href="<? echo '/business/data_detail/',$id,'/',$val['html_id'],'/',$viewtype,'/article_detail'?>">
                                  <h2><?=$val['html_name']?></h2> 
                                  <div><? echo mb_substr(strip_tags($val['html_content']),0,30);?></div>
                                </a>  
                           </article>

                 <? }}?>

                               

                     </section>
               </div><!--/wrapper-->
              
               
            
	 
  </body>
</html>