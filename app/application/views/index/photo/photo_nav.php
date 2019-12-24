			<div class="container openside">
				<aside class="side">
					<div class="nice-select">
						<span class="current">　</span>
						<ul class="side-nav list-v">
							<?foreach($side_link_type as $key => $value):?>
								<li <?=($category_id==$value['d_id'])?' class="active select"':''?>><a href="/index/photo/<?=$value['d_id'];?>"><?=$value['d_name'];?></a></li>
							<?endforeach?>
						</ul>
					</div>
                </aside>