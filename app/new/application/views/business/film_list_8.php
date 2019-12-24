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
				<?=$AboutMe?> / <?=$viewname?><?=$Film?>
			</header>
			
            
			<?php $this -> load -> view('template/template3_menu', $data); ?>
          
                 
                 
            <div class="wrapper">                  
                    
        <? 
//		$film_cate=$this->mod_business->select_from_order('strings_category', 'member_id', 'desc', array('member_id'=>$chkmemberid, 'type' => 'ytb_link')); 
//		print_r($film_cate);
//		exit;

		if(!empty($film_cate)){ 	?>

                   <section class="content">
                    <!---------下拉選單---------------->
						<article class="dropdownContent-B2B-Mobile">
							<div class="dropdownTop-B2B set_03list"><?=$film_cate[0]['name']?><i class="IconDown fa fa-angle-down"></i></div>
							<ul id="category" class="MobileMenu">
						<?		$first=true;
								foreach($film_cate as $val){
									if ($first) {
										$first=false;
										$selectfirst=$val['cid'];
										$outstr=' dropdownControl';
									}else $outstr='';?>
								<li class="brand<?=$outstr?>" data-filter="<?=$val['cid']?>"><a date-name="<?=$val['name']?>" href="javascript:void(0);"  ><?=$val['name']?></a></li>
						<?     } //foreach($film_cate as $val){?>
							</ul> 
							<!--row END----->
						</article>

			<div style="width:100%;height:30px"></div>


			
<?	
			foreach($film as $val){?>
						<div data-filter="<?=$val['cid']?>" id="a1" ref="<? echo '/company/film_info/',$account,'/',$val['str_id'],'/',$viewtype?>">
						<article class="info-list w-half">
							<i class="icon-go-vedio"></i>
							<a href="javascript:void(0);"><!----.fix讓不同長寬大小的圖片，截取中間------------------------->
								<img style="width:100%;height:auto" src="https://i.ytimg.com/vi/<?=$this->mod_index->public_get_ytb_id($val['str'])?>/default.jpg">
								<h2><?=$val['str_name']?></h2> 
							</a>  
						</article>
						</div>
						
						
		<? 	} //foreach($film as $val){ 			?>
						   
                   </section>
                   
     <? }//if(!empty($film_cate) && !empty($data) ){ ?>
                  
                   
           </div><!--/wrapper-->
    
	   </div><!--/page-->
  </body>
</html>
<!--data_filter -->
<script type="text/javascript" src="<?=$base_url?>template/js/data_filter.js"></script>
<script>
$(function() {
	data_filter_display(<?=$selectfirst?>);
});
</script>
