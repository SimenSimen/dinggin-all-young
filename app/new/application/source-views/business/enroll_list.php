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
				關於我 / <?=$viewname?>報名表單
			</header>
			
            
			<?php $this -> load -> view('template/template3_menu', $data); ?>
          
                 
                 
            <div class="wrapper">                  
				<section class="content">
				<? if (!empty($data_cate)){?>
                    <!---------下拉選單---------------->
						<article class="dropdownContent-B2B-Mobile">
							<div class="dropdownTop-B2B set_03list"><?=$data_cate[0]['name']?><i class="IconDown fa fa-angle-down"></i></div>
							<ul id="category" class="MobileMenu">
						<?		$first=true;
								foreach($data_cate as $val){
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
						<? }//if (!empty($data_cate)){?>
			<div style="width:100%;height:30px"></div>
				
			<?/*	foreach($data_cate as $val){?>
						<a href="#" data-filter="<?=$val['cid']?>" ><?=$val['name']?></a>
			<?  } //foreach($data_cate as $val){ */?>

                            <?php if ($uform_show): ?>
                                <?php foreach ($uform as $key => $value): ?>
					<div data-filter="<?=$value['ufm_cid']?>" id="a1" ref="<? echo '/form/index8/',$value['ufm_id'],'/',$value['member_id'],'/',$id,'/',$viewtype?>">
<? /* 					<div data-filter="<?=$value['ufm_cid']?>" id="a1" ref="<? echo '/form/index8_1/',$id,'/',$value['ufm_id'],'/',$value['member_id'],'/',$viewtype?>"> 
*/?>					
                           <article class="enroll-list"><a>
                                  <h2><?=$value['ufm_name']?></h2> </a>
                           </article>
					</div>
                                <?php endforeach; ?>
                            <?php endif; ?>
					
                               
                </section>
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
