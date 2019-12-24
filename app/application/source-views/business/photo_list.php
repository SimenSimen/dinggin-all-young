<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<?php $this -> load -> view('template/template3_seo', $data); ?>

		<link type="text/css" rel="stylesheet" href="<?=$base_url?>template/temp3/css/header.css" />
		<link type="text/css" rel="stylesheet" href="<?=$base_url?>template/temp3/css/layout.css" />
		<script type="text/javascript" src="<?=$base_url?>template/temp3/js/jquery-1.9.0.min.js"></script>
        <link href="<?=$base_url?>template/temp3/css/font-awesome.min.css" rel="stylesheet">
        
        <!------左側欄-------->
        <link type="text/css" rel="stylesheet" href="<?=$base_url?>template/temp3/css/jquery.mmenu.all.css" />
		<script type="text/javascript" src="<?=$base_url?>template/temp3/js/jquery.mmenu.min.all.js"></script>
		<script type="text/javascript">
			$(function() {
				$('nav#menu').mmenu();
			});
		</script>
        
       <!--下拉選單 -->
       <script type="text/javascript" src="<?=$base_url?>template/temp3/js/dropdown.js"></script>
       <link type="text/css" rel="stylesheet" href="<?=$base_url?>template/temp3/css/dropdown.css" />
		<?php $this -> load -> view('template/template3_css', $data); ?>
	</head>
    
	<body class="bg-style">
		<div id="page">
			<header class="header set_header">
				<a href="#menu"></a>
				關於我 / <?=$viewname?>相簿
			</header>
			
            
			<?php $this -> load -> view('template/template3_menu', $data); ?>
          
                 
                 
            <div class="wrapper">                  
                   
                   <section class="content">
                    <!---------下拉選單---------------->
						<article class="dropdownContent-B2B-Mobile">
							<div class="dropdownTop-B2B set_03list"><?=$data[0]['d_name']?><i class="IconDown fa fa-angle-down"></i></div>
							<ul id="category" class="MobileMenu">
						<?		$first=true;
								foreach($data as $val){
									if ($first) {
										$first=false;
										$outstr=' dropdownControl';
										$selectfirst=$val['d_id'];
									}else $outstr='';?>
								<li class="brand<?=$outstr?>" data-filter="<?=$val['d_id']?>"><a date-name="<?=$val['d_name']?>" href="javascript:void(0);"  ><?=$val['d_name']?></a></li>
						<?     } //foreach($film_cate as $val){?>
							</ul> 
							<!--row END----->
						</article>
				   
			<div style="width:100%;height:30px"></div>

						

       	<? 
			if(!empty($data)){
/*				foreach($data as $val){?>
						<a date-name="<?=$val['name']?>" data-filter="<?=$val['']?>" ><?=$val['']?></a>
			<?  } //foreach($film_cate as $val){
*/			
				foreach($data as $val){?>
						<div data-filter="<?=$val['d_id']?>" id="a1" ref="<? echo '/business/data_detail/',$id,'/',$val['d_id'],'/',$viewtype,'/photo_detail'?>">
						
                                <article class="info-list w-half">
                                      <!----.fix讓不同長寬大小的圖片，截取中間------------------------->
                                        <div class="item-img fix"><img src="<?=$val['first_img']?>"></div>                                                              
                                        <h2><?=$val['d_name']?></h2> 
                                 </article>

						</div>
			<? 	
				} //foreach($data as $val){ 
			?>
						   
                   </section>
                   
         <? }//if(!empty($film_cate) && !empty($data) ){ ?>
                  
                   
           </div><!--/wrapper-->
    
	   </div><!--/page-->
  </body>
</html>
<script type="text/javascript" src="<?=$base_url?>template/js/data_filter.js"></script>
<script>
$(function() {
	data_filter_display(<?=$selectfirst?>);
});
</script>
