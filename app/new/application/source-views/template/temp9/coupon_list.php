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
		<?php 
		$data['htmltitle']='好友分享券';
		$this -> load -> view('template/template4_headmenu2', $data); ?>




        <!--好康分享 -->
                 <div class="wrapper">
                       <section class="content">
        <?php if($ecp_show){ ?>
                       
                    <?php foreach ($ecp_url as $key => $value): ?>
                           <article class="share-list">
                                <a href="<? echo $ecp_url_detail[$key],'/',$viewtype;?>">
                                  <div class="item-img fix"><img src="<?=$ecp_img[$key]?>"></div>                                                              
                                  <h2><?=$ecp_content[$key]?></h2> 
                                </a>  
                           </article>
                    <?php endforeach; ?>
                               
                           
		<? }else{ ?>
        		<center><font color="red">尚無資料!!</font></center>
		<?php } ?>
                      </section>
                   
               </div><!--/wrapper-->
               
             
	 
  </body>
</html>