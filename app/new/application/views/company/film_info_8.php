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
	   
	</head>
    
	<body class="bg-style">
		<div id="page">
			<header class="header set_header">
			    <div ref="<?=$public_share_buttom_url?>" id="head_share_buttom" style="position:absolute;top:0;right:0;margin:.3rem 1rem 0 0"><span class="finger_point"><img src="<?=$base_url?>template/temp3/images/share_btn.png"></span></div>
				<a href="#menu"></a>
				<?=$AboutMe?> / <?=$viewname?><?=$Film?>
			</header>
			<?php $this -> load -> view('template/public_share', $data); ?>
			<?php $this -> load -> view('template/template3_menu', $data); ?>
            
          
                 
                 
                 <div class="wrapper">                  
          
                  
                    <section class="content">
                         
                         <h2 class="content-title"><?=$film['str_name']?></h2>
                         <section class="vedio-box">   
                            <div class="video-container">
                              <iframe src="https://www.youtube.com/embed/<?=$film['str']?>" frameborder="0" allowfullscreen></iframe>
                            </div> 
                        <div class="btn-share">
                          <a href="javascript:avoid(0)" onclick="gobarcodeurl()"><?=$Collect?></a>
                        </div>
                         </section>  
                     <!------------分享------------->
    <script language="javascript">
    function gobarcodeurl(){
//		alert('<?=$public_barcodeurl?>');
		location ='<?=$public_barcodeurl?>';
     }
    </script>                         
                         
                   </section>
                   
           </div><!--/wrapper-->
    
	   </div><!--/page-->
  </body>
</html>
