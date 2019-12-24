				<section class="content has-side">
					<? if(!empty($this->style==2)){?>
					<div class="archive_type">
						<aside class="side" style="display:block; opacity:1; width:100%;">
							<div class="nice-select">
							<span class="current"><a href="#"> </a></span>
								<ul class="side-nav list-v">
							    	<?php if(!empty($list)): ?>
							    		<?php foreach ($list as $key => $value): ?>
											<?if($value['id']==$category_id){?>
												<li class="active select"><a href="/gold/archive/C/annex/<?=$value['id']?>"><?=$value['name']?></a></li>
											<?}else{?>
												<li><a href="/gold/archive/C/annex/<?=$value['id']?>"><?=$value['name']?></a></li>
											<?}?>
							    		<?php endforeach; ?>
							    	<?php endif; ?>
								</ul>
							</div>
						</aside>
					</div>
					<?}?>
					<div class="title"><?=$title?></div>
					<ul class="link-list list-v">
			        	<?php if(!empty($archive_detail)): ?>
			        		<?php foreach ($archive_detail as $key => $value): ?>
	                        <li class="item wow fadeIn" data-wow-delay="<?=$i*0.2+0.1?>s">
	                            <div class="box">
	                        		<a href="<?=base_url()?><?=$value['path']?>" target=_blank class="clearfix">
	                                    <div class="name"><?=$value['name']?></div>
	                                </a>
	                            </div>
	                        </li>
			          		<?php endforeach; ?>
			          	<?php endif; ?>
                    </ul>
                    <!--
                    <div class="pagination_box">
						<ul class="pagination">
						    <li><a class="controls prev" href="#" title="上一頁"><i class="icon-chevron-left"></i></a></li>
						    <li><a href="#">1</a></li>
						    <li><a href="#">2</a></li>
						    <li class="active"><a href="#">3</a></li>
						    <li><a href="#">4</a></li>
						    <li><a href="#">5</a></li>
						    <li><a class="controls next" href="#" title="下一頁"><i class="icon-chevron-right"></i></a></li>
						</ul>
						<div class="page-info">
						    <select class="form-control" name="" id="">
						        <option value="">第 1 頁</option>
						        <option value="">第 2 頁</option>
						        <option value="">第 3 頁</option>
						    </select>
						</div>
                    </div>
                    -->
				</section>
			</div>
		</main>
<style>
    @media (min-width:980px) {
      .archive_type {
        display: none;
      }
    }
</style>   
