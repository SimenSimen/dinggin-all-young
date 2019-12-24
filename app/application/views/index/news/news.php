				<section class="content container" style="float: unset;">
					<div class="title"><?=$title?></div>
					<ul class="link-list list-v" style="margin-left:5%; margin-right:5%;">
						<?php if(!empty($list)): ?>
							<?php foreach ($list as $key => $value): ?>
                        <li class="item wow fadeIn">
                            <div class="box">
                                <a href="/index/news_detail/<?=$value['did']?>" class="clearfix">
                                    <div class="name"><?=$value['name']?></div>
                                </a>
                            </div>
                        </li>
				      		<?php endforeach; ?>
				      	<?php endif; ?>
                    </ul>
				</section>
			</div>
		</main>