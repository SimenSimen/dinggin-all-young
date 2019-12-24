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
        
		<?php $this -> load -> view('template/template3_css', $data); ?>
       <!--下拉選單 -->
       <script type="text/javascript" src="<?=$base_url?>template/temp3/js/dropdown.js"></script>
       <link type="text/css" rel="stylesheet" href="<?=$base_url?>template/temp3/css/dropdown.css" />
<style type="text/css">	   
<? 
$film_cate=$this->mod_business->select_from_order('strings_category', 'member_id', 'desc', array('member_id'=>$chkmemberid, 'type' => 'ytb_link')); 

foreach($film_cate as $val){ ?>
a[data-filter="<?=$val['cid']?>"]:focus ~ div:not([data-filter="<?=$val['cid']?>"]){
	display:none;
}
<?     } ?>
</style>

	</head>
    
	<body class="bg-style">
		<div id="page">
			<header class="header">
				<a href="#menu"></a>
				關於我 / <?=$viewname?>影片
			</header>
			
            
			<?php $this -> load -> view('template/template3_menu', $data); ?>
          
                 
                 
            <div class="wrapper">                  
                    
        <? 
            if(!empty($film_cate)){ 
		
			?>

                   <section class="content">
                    <!---------下拉選單---------------->
						<article class="dropdownContent-B2B-Mobile">
							<div class="dropdownTop-B2B"><?=$film_cate[0]['name']?><i class="IconDown fa fa-angle-down"></i></div>
							<ul id="category" class="MobileMenu">
		<?		$first=true;
                foreach($film_cate as $val){
					if ($first) {
						$first=false;
						$outstr=' dropdownControl';
					}else $outstr='';?>
								<li class="brand<?=$outstr?>"><a date-name="<?=$val['name']?>" href="#" data-filter="<?=$val['cid']?>" ><?=$val['name']?></a></li>
         <?     } //foreach($film_cate as $val){?>
							</ul> 
							<!--row END----->
						</article>

			<div style="width:100%;height:30px"></div>

						

			<?	foreach($film_cate as $val){?>
						<a date-name="<?=$val['name']?>" href="#" data-filter="<?=$val['cid']?>" ><?=$val['name']?></a>
			<?  } //foreach($film_cate as $val){
			
			foreach($film as $val){?>
						<div data-filter="<?=$val['cid']?>">
						<article class="info-list w-half">
							<i class="icon-go-vedio"></i>
							<a href="<? echo '/company/film_info/',$account,'/',$val['str_id'],'/',$viewtype?>"><!----.fix讓不同長寬大小的圖片，截取中間------------------------->
								<!-- <iframe width="435" height="244" src="https://www.youtube.com/embed/<?=get_ytb_id($val['str'])?>" frameborder="0" allowfullscreen></iframe> -->
								<h2><?=$val['str_name']?></h2> 
							</a>  
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
<?
	function get_ytb_id($url)
	{
		//去除首尾空白
		$url=trim($url);

		//擷取id
		if($pos = strpos($url, '?v=') !== false)
		{
			//後綴參數檢查
			$pos=strpos($url, '?v=');
			$and_mark=strpos($url, '&');
			if($and_mark != false)
			{
				$id=substr($url, $pos+3, ($and_mark-$pos-3));
			}
			else
			{
				$id=substr($url, $pos+3);
			}
		}
		else
		{
			//youtu.be檢查
			if($pos = strpos($url, 'youtu.be') !== false)
			{
				$pos=strrpos($url, '/');
				$and_mark=strpos($url, '&');
				if($and_mark != false)
				{
					$id=substr($url, $pos+1, ($and_mark-$pos-1));
				}
				else
				{
					$id=substr($url, $pos+1);
				}
			}
			else
			{
				$id='';
			}
		}
		return $id;
	}

?>