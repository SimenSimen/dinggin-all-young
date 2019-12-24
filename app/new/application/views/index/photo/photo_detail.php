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
				<section class="content has-side">
					<div class="title"><?=$photo['d_name']?></div>
					<ul class="photo-list list-h">
		        	<?php if(!empty($list_photo)): ?>
		        		<?php foreach ($list_photo as $key => $value): ?>
                        <li class="item wow fadeIn" data-wow-delay="<?=$i*0.2+0.1?>s">
							<div class="box">
								<figure class="pic">
									<a class="fancybox-thumbs" data-fancybox-group="thumb" href="<?=base_url()?><?=$value['img_path']?>" title="<?=$value['img_note']?>">
										<img src="<?=base_url()?><?=$value['img_path']?>" alt="<?=$value['img_note']?>">
									</a>
								</figure>
							</div>
                        </li>
		          		<?php endforeach; ?>
		          	<?php endif; ?>
                    </ul>
                    <div class="pagination_box">
                    <a href="/gold/photo/C/photo" class="btn back"><i class="icon-chevron-left"></i> 回列表</a>
                    </div>
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