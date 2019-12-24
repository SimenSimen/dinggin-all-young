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
		$data['htmltitle']='影片列表';
		$this -> load -> view('template/template4_headmenu2', $data); ?>
			

                 
                 <div class="wrapper">
                      <section class="content animated fadeInUp">
                      

<?	
			foreach($film as $val){?>
                           <article class="info-list w-half">
                                <a href="<? echo '/company/film_info/',$account,'/',$val['str_id'],'/',$viewtype?>"><!----.fix讓不同長寬大小的圖片，截取中間------------------------->
                                  <div class="item-img fix"><img src="https://i.ytimg.com/vi/<?=$this->mod_index->public_get_ytb_id($val['str'])?>/default.jpg"></div>                                                              
                                  <h2><?=$val['str_name']?></h2> 
                                </a>  
                           </article>
		<? 	} //foreach($film as $val){ 			?>

                     </section>
               </div><!--/wrapper-->
              
               
               
	 
  </body>
</html>