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
		$data['htmltitle']='影片分類';
		$this -> load -> view('template/template4_headmenu2', $data); ?>
                 
                 <div class="wrapper">
                        <ul class="common-item-ul">


					<?	
					if (!empty($film_cate)){
						foreach($film_cate as $val){ ?>
                           <li class="animated2 fadeInDown">
                                <a href="<? echo '/business/film_cate/',$account,'/',$val['cid'],'/',$viewtype?>">                                  <h2 class="set-title01"><?=$val['name']?></h2> 
                                </a>  
                           </li>
						<?     } //foreach($film_cate as $val){
					}else  echo '<center>','尚無分類資料','</center>'; 
					?>

                       </ul>
                 </div><!--/wrapper-->
               
	 
</body>
</html>