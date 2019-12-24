<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<?php $this -> load -> view('template/template3_seo', $data); ?>

		<link type="text/css" rel="stylesheet" href="/template/temp3/css/header.css" />
		<link type="text/css" rel="stylesheet" href="/template/temp3/css/layout.css" />
		<script type="text/javascript" src="/template/temp3/js/jquery-1.9.0.min.js"></script>
        <link href="/template/temp3/css/font-awesome.min.css" rel="stylesheet">
        
        <!--左側欄-->
        <link type="text/css" rel="stylesheet" href="/template/temp3/css/jquery.mmenu.all.css" />
		<script type="text/javascript" src="/template/temp3/js/jquery.mmenu.min.all.js"></script>
		<script type="text/javascript">
			$(function() {
				$('nav#menu').mmenu();
			});
		</script>
 
        
       <!--下拉選單 -->
       <script type="text/javascript" src="/template/temp3/js/dropdown.js"></script>
       <link type="text/css" rel="stylesheet" href="/template/temp3/css/dropdown.css" />
		<?php $this -> load -> view('template/template3_css', $data); ?>
	</head>
    
	<body class="bg-style">
		<div id="page">
			<header class="header">
				<a href="#menu"></a>
				<?=$AboutMeURL?>
			</header>
			
            
			<?php $this -> load -> view('template/template3_menu', $data); ?>
                 
            <?php if ($website_num != 0): ?>
              
                 <div class="wrapper">                 
         
                    
                    <section class="content">
                         <div class="link-list">
                            <ul>
                                <?php foreach ($website as $key => $value): ?>
                             <li><a href="<?=$value?>"><?=$website_name[$key]?></a></li>
                                <?php endforeach; ?>
							
                            </ul>
                         </div>            
                   </section>
                   
				</div><!--/wrapper-->
			<?php endif; ?>
    
	   </div><!--/page-->
  </body>
</html>