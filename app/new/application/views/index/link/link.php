				<section class="content has-side">
					<div class="title"><?=$title?></div>
					<ul class="link-list list-v">
			        	<?php if(!empty($list_detail)): ?>
			        		<?php foreach ($list_detail as $key => $value): ?>
	                        <li class="item wow fadeIn" data-wow-delay="<?=$i*0.2+0.1?>s">
	                            <div class="box">
	                        		<a href="<?=$value['content']?>" target=_blank class="clearfix">
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