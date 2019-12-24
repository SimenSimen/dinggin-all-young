			<div class="container openside">
				<aside class="side">
					<div class="nice-select">
						<span class="current">　</span>
						<ul class="side-nav list-v">
							<?foreach($side_link_type as $key => $value):?>
								<li><a href="<?=$value['ck_id'];?>"><?=$value['name'];?></a></li>
							<?endforeach?>
						</ul>
					</div>
                </aside>