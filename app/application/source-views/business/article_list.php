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
				關於我 / <?=$viewname?>文章
			</header>
			
            
			<?php $this -> load -> view('template/template3_menu', $data); ?>
          
                 
            <div class="wrapper">                  
                    
        <?  if(!empty($data_cate)){ ?>

            <section class="content">
                    <!---------下拉選單---------------->
						<article class="dropdownContent-B2B-Mobile">
							<div class="dropdownTop-B2B set_03list"><?=$data_cate[0]['classify_name']?><i class="IconDown fa fa-angle-down"></i></div>
							<ul id="category" class="MobileMenu">
		<?		$first=true;
                foreach($data_cate as $val){
					if ($first) {
						$first=false;
						$selectfirst=$val['classify_id'];
						$outstr=' dropdownControl';
					}else $outstr='';
					?>
								<li class="brand<?=$outstr?>"  data-filter="<?=$val['classify_id']?>"><a date-name="<?=$val['classify_name']?>"><?=$val['classify_name']?></a></li>
         <?     } //foreach($film_cate as $val){?>
         

							</ul> 
							<!--row END----->
						</article>

						
						
				<div style="width:100%;height:30px"></div>                 
<? /*
<? foreach($data_cate as $val){ ?>
	<a  href="javascript:void(0);" data-filter="<?=$val['classify_id']?>" ><?=$val['classify_name']?></a>
<?     } ?>
*/?>

                 <? if(!empty($data)){
					 foreach($data as $val){?>
				<div  data-filter="<?=$val['classify_id']?>" id="a1" ref="<? echo '/business/data_detail/',$id,'/',$val['html_id'],'/',$viewtype,'/article_detail'?>">
			   <article class="article-list">
					<a href="javascript:void(0);">
					  <h2><?=$val['html_name']?></h2> 
					  <!-----css設定超出約2行高度，隱藏多的字------>
					  <div><?//=val['html_content']?></div>
					</a>  
			   </article>
				</div>	 
                 <? }}?>

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
