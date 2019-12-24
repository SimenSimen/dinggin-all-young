	<link rel="stylesheet" type="text/css" href="js/jquery-nice-select-1.1.0/nice-select.css">
	<script>
		$(document).ready(function() {
			
			$('.fancybox-thumbs').fancybox({
				openEffect  : 'none',
				closeEffect : 'none',
				prevEffect : 'none',
				nextEffect : 'none',
				closeBtn  : true,
				arrows    : true,
				nextClick : true,
				helpers : {
				 title : {
				  type : 'inside'
				 },
				 buttons : {},
				 thumbs : {
				  width : 50,
				  height : 50
				 }
				},
				afterLoad : function() {
				 this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
				}
			   });
		});
	</script>
	<style>
	.product img {
	  max-height: 100%;
	  max-width: 100%;
	  width: auto;
	  height: auto;
	  position: absolute;
	  top: 0;
	  bottom: 0;
	  left: 0;
	  right: 0;
	  margin: auto;
	}
	</style>
		<section class="content has-side">
			<div class="title"><?=$photo['d_name']?></div>
			<div><?=$photo['d_content']?></div><?//=print_r($d_video_link['0']);?>
			<hr>
			<div class="products-detail clearfix">
				<article class="editor clearfix">
					<div id="tabwrap">
						<ul id="tabs" class="list-h">
							<li class="current"><a href="#page1"><?=$this->lang['photo'];//活動花絮?></a></li>
							<? if(!empty($d_video_link['1'])): ?><li><a href="#page2"><?=$this->lang['video'];//影音專區?></a></li><? endif; ?>
						</ul>
					</div>
					<!-- TAB 内容 -->
					<div id="content">
						<div id="page1" class="animated current">
							<ul class="products-list list-h">
					       	<?php if(!empty($list_photo)): ?>
					       		<?php foreach ($list_photo as $key => $value): ?>
					       			<li id="prd_list_img">
											<a class="fancybox-thumbs" data-fancybox-group="thumb" href="<?=base_url()?><?=$value['img_path']?>" title="<?=$value['img_note']?>">	
										<figure class="pic product">									
												<img class="lazy" src="<?=base_url()?><?=$value['img_path']?>" alt="<?=$value['img_note']?>">
										</figure>
											</a>
				                    </li>
						        <?php endforeach; ?>
						    <?php endif; ?>
				            </ul>
						</div>
						<?php if(!empty($d_video_link['1'])): ?>
							<div id="page2" class="animated">
					       		<?php foreach ($d_video_name as $key => $value): 
					       			if($value<>''){?>
										<iframe src="<?=str_replace('watch?v=','embed/',$d_video_link[$key]);?>?rel=0&hd=1&vq=hd720" frameborder="0" allowfullscreen></iframe>
										<br><center><?=stripslashes($value);?></center><br><br><br><br>
					                <?}?>
						        <?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>                             
				</article>
			</div>
            <div class="pagination_box"><a href="/index/photo/<?=$category_id;?>" class="btn back"><i class="icon-chevron-left"></i> <?=$this->lang['back_list'];//回列表?></a></div>
		</section>

	</div>
</main>
<style>
/* 活動花絮styling starts */
body.activity-body .fancybox-close {
    background: url(/js/fancyBox/source/fancybox_sprite.png);
    width: 44px;
    height: 40px;
    right: -20px;
    top:-20px;
}

.photo-list li {
  float: left;
  width: 33.33%;
  padding: 10px;
  text-align: center;
}

.photo-list li a .box .pic:after {
  content:"";
  position: absolute;
  width: 100%;
  height: auto;
  top:0;
  bottom: 0;
  left: 0;
  right: 0;
  opacity: 0;
  background: rgba(0,0,0,.2);
}

.photo-list li a:hover .box .pic:after {
  opacity: 1;
}

.photo-list li a .box .txt .name {
  line-height: 20px;
  height: 40px;
  overflow: hidden;
}

@media (max-width:480px) {
  .photo-list li {
    width: 50%;
  
  }
  
}
/* 活動花絮styling ends */
</style>
<script>
$(document).ready(function() {
    a=$('.pic.product').width();
    b=a*0.9015126338842596;
    $('.pic.product').height(b);
});

$(function(){
    
    $('#tabs li a').click(function(e){
     
        $('#tabs li, #content .current').removeClass('current').removeClass('fadeInLeft');
        $(this).parent().addClass('current');
        var currentTab = $(this).attr('href');
        $(currentTab).addClass('current fadeInLeft');
        e.preventDefault();
     
    }); 

});
</script>