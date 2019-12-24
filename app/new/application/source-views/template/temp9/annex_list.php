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
		$data['htmltitle']='附件';
		$this -> load -> view('template/template4_headmenu2', $data); ?>
           

                 
                 <div class="wrapper">
  
                      <section class="content">
                           <div class="annex-list">
                            <ul>
						<? if (!empty($doc_path)){ ?>
                              <?php foreach ($doc_path as $key => $value): ?>
                              <li><a href="javascript: void(0)" class="set-title01" onclick="location.href='<?=$base_url?><?=substr($value, 1)?>'"><?=$doc_name[$key]?></a></li>
                              <?php endforeach; ?>							
						<? } else  echo '<center>','尚無分類資料','</center>'; ?>
                            </ul>
                         </div> 
                     </section>
   
                   
               </div><!--/wrapper-->
               
              
	 
  </body>
</html>