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
			<header class="header set_header">
				<a href="#menu"></a>
				關於我 / <?=$viewname?>附件
			</header>
			
            
			<?php $this -> load -> view('template/template3_menu', $data); ?>
          
                 
                 
            <div class="wrapper">                  

                    <section class="content">
                           <div class="annex-list">
                            <ul>
                              <?php foreach ($doc_path as $key => $value): ?>
                              <li><a onclick="location.href='<?=$base_url?><?=substr($value, 1)?>'"><?=$doc_name[$key]?></a></li>
                              <?php endforeach; ?>							
                            </ul>
                         </div> 
                   </section>
                   
           </div><!--/wrapper-->
    
	   </div><!--/page-->
  </body>
</html>
