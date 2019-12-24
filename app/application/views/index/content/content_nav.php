			<div class="container openside">
				<aside class="side">
					<div class="nice-select">
					<span class="current"><a href="#"> </a></span>
						<ul class="side-nav list-v">
					    	<?php if(!empty($list)): ?>
					    		<?php foreach ($list as $key => $value): ?>
									<li <?=($value['id']==$category_id)?' class="active select"':''?>><a href="/index/content/<?=$element;?>/<?=$value['id']?>"><?=$value['name']?></a></li>
					    		<?php endforeach; ?>
					    	<?php endif; ?>
						</ul>
					</div>
                </aside>