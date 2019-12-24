		<main class="main-content wow fadeInUp" data-wow-delay="0.4s">
			<div class="container openside">
				<aside class="side">
					<div class="nice-select">
					<span class="current">次選項</span>
						<ul class="side-nav list-v">
							<li class="active select"><a href="link.php">友善連結一</a></li>
							<li><a href="link.php">友善連結二</a></li>
							<li><a href="link.php">友善連結三</a></li>
						</ul>
					</div>
                </aside>
				<section class="content has-side">
					<div class="title">友善連結</div>
					<ul class="link-list list-v">
                        <?php for($i=0; $i<8; $i++) { ?>
                        <li class="item wow fadeIn" data-wow-delay="<?=$i*0.2+0.1?>s">
                            <div class="box">
                                <a href="link_detail" class="clearfix">
                                    <div class="name">文章一</div>
                                </a>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
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
				</section>
			</div>
		</main>