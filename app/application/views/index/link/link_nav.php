			<div class="container openside">
				<aside class="side">
					<div class="nice-select">
					<span class="current"><a href="#"> </a></span>
						<ul class="side-nav list-v">
					    	<?php if(!empty($list)): ?>
					    		<?php foreach ($list as $key => $value): ?>
									<?if($value['id']==$category_id){?>
										<li class="active select"><a href="/gold/link/C/link/<?=$value['id']?>"><?=$value['name']?></a></li>
									<?}else{?>
										<li><a href="/gold/link/C/link/<?=$value['id']?>"><?=$value['name']?></a></li>
									<?}?>
					    		<?php endforeach; ?>
					    	<?php endif; ?>
						</ul>
					</div>
                </aside>