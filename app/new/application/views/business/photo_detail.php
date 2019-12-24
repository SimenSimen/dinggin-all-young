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

       <!-- 相簿 內頁 輪播Owl Carousel Assets -->
       <link href="<?=$base_url?>template/temp3/css/owl.carousel.css" rel="stylesheet">
       <link href="<?=$base_url?>template/temp3/css/owl.theme.css" rel="stylesheet">

	   
		<?php $this -> load -> view('template/template3_css', $data); ?>
	</head>
    
	<body class="bg-style">
		<div id="page">
			<header class="header set_header">
			    <div ref="<?=$public_share_buttom_url?>" id="head_share_buttom" style="position:absolute;top:0;right:0;margin:.3rem 1rem 0 0"><span class="finger_point"><img src="<?=$base_url?>template/temp3/images/share_btn.png"></span></div>
				<a href="#menu"></a>
				<?=$AboutMe?> / <?=$viewname?><?=$Photo?>
			</header>

		<?php $this -> load -> view('template/public_share', $data); ?>
		<?php $this -> load -> view('template/template3_menu', $data); ?>
          
                 
                 <div class="wrapper">                  
 
                   
                    <section class="content">
                    
                        <h2 class="content-title"><?=$photo_category_name?></h2>
                        
                         <!--------上面小圖---------------------------------------------------> 
                        <div id="sync2" class="owl-carousel">
                        <? if(!empty($myphoto)){ 
								foreach($myphoto as $key => $val){ ?>
                          <div class="item0" > <img src="<?=$val?>"></div>
                        <? }}?>

                        </div> 
                        
                        
                        <div class="customNavigation">
                          <a class="btn prev">prev</a>
                          <a class="btn next">next</a>
                         
                        </div>
                       
                        
                        <div id="sync1" class="owl-carousel">
                        <? if(!empty($myphoto)){ 
								foreach($myphoto as $key => $val){ ?>
                          <div class="item0"><img src="<?=$val?>"><p><?=$myphoto_name[$key]?></p></div>
                        <? }}?>
                        </div><!--owl-carousel END-->
                        
                          
                     <!------------分享------------->
                        <div class="btn-share">
                          <a href="javascript:avoid(0)" onclick="gobarcodeurl()">收藏</a>
                        </div>
    <script language="javascript">
    function gobarcodeurl(){
//		alert('<?=$public_barcodeurl?>');
		location ='<?=$public_barcodeurl?>';
     }
    function gobarcodeurl2(linktype){
		outstr='<?=$public_share_buttom_url?>'+'&linktype='+linktype;
//		alert(outstr);
		location =outstr;
     }
    </script>
             
                          
                   </section><!--/content-->
                   
           </div><!--/wrapper-->
                 
    
	   </div><!--/page-->
   <!------相簿 內頁 輪播------------>
    <script src="<?=$base_url?>template/temp3/js/owl.carousel.js"></script>
    <script>
    $(document).ready(function() {

      var sync1 = $("#sync1");
      var sync2 = $("#sync2");

      sync1.owlCarousel({
        singleItem : true,
        slideSpeed : 1000,
        navigation: false,//NO JS
        pagination:false,
		
        afterAction : syncPosition,
        responsiveRefreshRate : 200,
      });

      sync2.owlCarousel({
        items : 15,
        itemsDesktop      : [1199,10],
        itemsDesktopSmall     : [979,10],
        itemsTablet       : [768,8],
        itemsMobile       : [479,4],
        pagination:false,
        responsiveRefreshRate : 100,
        afterInit : function(el){
          el.find(".owl-item").eq(0).addClass("synced");
        }
      });

      function syncPosition(el){
        var current = this.currentItem;
        $("#sync2")
          .find(".owl-item")
          .removeClass("synced")
          .eq(current)
          .addClass("synced")
        if($("#sync2").data("owlCarousel") !== undefined){
          center(current)
        }

      }

      $("#sync2").on("click", ".owl-item", function(e){
        e.preventDefault();
        var number = $(this).data("owlItem");
        sync1.trigger("owl.goTo",number);
      });

      function center(number){
        var sync2visible = sync2.data("owlCarousel").owl.visibleItems;

        var num = number;
        var found = false;
        for(var i in sync2visible){
          if(num === sync2visible[i]){
            var found = true;
          }
        }

        if(found===false){
          if(num>sync2visible[sync2visible.length-1]){
            sync2.trigger("owl.goTo", num - sync2visible.length+2)
          }else{
            if(num - 1 === -1){
              num = 0;
            }
            sync2.trigger("owl.goTo", num);
          }
        } else if(num === sync2visible[sync2visible.length-1]){
          sync2.trigger("owl.goTo", sync2visible[1])
        } else if(num === sync2visible[0]){
          sync2.trigger("owl.goTo", num-1)
        }
      }

    });
    </script>
   <!---------------------------------------------------->
      
     <script>
    $(document).ready(function() {
      var owl = $("#sync1");
      // Custom Navigation Events
      $(".next").click(function(){
        owl.trigger('owl.next');
      })
      $(".prev").click(function(){
        owl.trigger('owl.prev');
      })
    });
    </script>
	   
  </body>
</html>
