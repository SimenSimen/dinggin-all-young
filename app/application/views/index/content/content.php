				<section class="content has-side">
					<? if(!empty($this->style==2)){?>
					<div class="news_type">
						<aside class="side" style="display:block; opacity:1; width:100%;">
						<div class="nice-select">
						<span class="current"><a href="#"> </a></span>
							<ul class="side-nav list-v">
						    	<?php if(!empty($list)): ?>
						    		<?php foreach ($list as $key => $value): ?>
										<?if($value['id']==$category_id){?>
											<li class="active select"><a href="/index/content/C/<?=$element;?>/<?=$value['id']?>"><?=$value['name']?></a></li>
										<?}else{?>
											<li><a href="/index/content/C/<?=$element;?>/<?=$value['id']?>"><?=$value['name']?></a></li>
										<?}?>
						    		<?php endforeach; ?>
						    	<?php endif; ?>
							</ul>
						</div>
	                	</aside>
	                </div>
					<?}?>
					<div class="title"><?=$category_name?></div>
					<ul class="share-list list-v">
			        	<?php if(!empty($list_detail)): ?>
			        		<?php foreach ($list_detail as $key => $value): ?>
	                       <li class="item wow fadeIn" data-wow-delay="0.1s">
	                            <div class="box">
	                				<a href="/index/content_detail/<?=$category_type?>/<?=$category_id?>/<?=$value['enews_id']?>" class="clearfix">
	                                    <figure class="pic"><img class="lazy" src="/uploads/000/000/0000/0000000000/news/<?=$value['filename']?>" alt="<?=$value['name']?>"></figure>
	                                    <div class="name"><b><?=$value['name']?></b></div>
	                                    <div class="name" style="-webkit-line-clamp:4; max-height:100%;"><?=mb_substr(strip_tags($value['content']),1,120,"UTF-8").'......';?><?=$this->lang['more'];//更多?></div>
	                                </a>
	                            </div>
	                        </li>

			          		<?php endforeach; ?>
			          	<?php endif; ?>
                    </ul>
				</section>
			</div>
		</main>
<style>
    @media (min-width:980px) {
      .news_type {
        display: none;
      }
    }
</style>		
