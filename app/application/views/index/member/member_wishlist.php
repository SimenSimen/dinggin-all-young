				<section class="content has-side">
					<div class="title">最愛商品</div>
					<ul class="products-list list-h">
                        <?php for($i=0; $i<9; $i++) { ?>
                        <li class="item wow fadeIn" data-wow-delay="<?=$i*0.2+0.1?>s">
                            <div class="box">
                            	<a href="#" class="btn delete" title="刪除此項目"><i class="icon-close"></i></a>
                                <a href="/products/detail">
                                    <figure class="pic"><img src="/images/pro/pic<?=$i%4+1?>.jpg" alt=""></figure>
                                    <div class="name">產品名稱</div>
                                    <div class="offers">¥2,400.00</div>
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