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
		$photolist=$data;
		$data['htmltitle']='相簿列表';
	
		$this -> load -> view('template/template4_headmenu2', $data); ?>

                 
                 <div class="wrapper">
                       <section class="content animated fadeInUp">
       	<? 
			if(!empty($photolist)){
				foreach($photolist as $val){?>
            
                          <article class="info-list w-half">
                               
                                <a href="<? echo '/business/data_detail/',$id,'/',$val['d_id'],'/',$viewtype,'/photo_detail'?>"><!----.fix讓不同長寬大小的圖片，截取中間------------------------->
                                  <div class="item-img fix"><img src="<?=$val['first_img']?>"></div>                                                              
                                  <h2><?=$val['d_name']?></h2> 
                                </a>  
                           </article>
			<? 	} //foreach($data as $val){ 	?>
         <? } else   echo '<center>','尚無分類資料','</center>'; ?>


                     </section>
               </div><!--/wrapper-->
  </body>
</html>