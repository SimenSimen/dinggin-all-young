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
		$data['htmltitle']='網路連結';
		$this -> load -> view('template/template4_headmenu2', $data); ?>

            <?php if ($website_num != 0){ ?>
                 
                 <div class="wrapper">
  
                        <section class="content">
                             <div class="link-list">
                                <ul>
                                <?php foreach ($website as $key => $value): ?>
                                  <li><a href="<?=$value?>" class="set-title01"><?=$website_name[$key]?></a></li>
                                <?php endforeach; ?>
                                </ul>
                             </div>            
                       </section>
   
                    
               </div><!--/wrapper-->
			<? } else  echo '<center>','尚無分類資料','</center>'; ?>
               
               
         	 
  </body>
</html>