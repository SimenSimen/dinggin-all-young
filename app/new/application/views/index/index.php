<div class="container">
                <aside class="side">
                    <ul class="side-nav list-v">
                        <li class="active"><a href="#">產品分類</a></li>
                        <li><a href="#">產品分類</a></li>
                        <li><a href="#">產品分類</a>
                            <ul>
                                <li class="active"><a href="#">產品次分類</a></li>
                                <li><a href="#">產品次分類</a></li>
                                <li><a href="#">產品次分類</a></li>
                                <li><a href="#">產品次分類</a></li>
                            </ul>
                        </li>
                        <li><a href="#">產品分類</a></li>
                    </ul>                    
                </aside>
                <section class="content has-side">
                    <div class="title">購物商城</div>
                    <div class="select-bar clearfix">
                        <div class="search-box list-h">
                            <input type="text" id="Search" class="form-control" name="name" placeholder="關鍵字搜尋">
                            <a href="#" class="search"><i class="icon-search"></i></a>
                        </div>
                        <a  href="products_search.php" class="more-search fancybox-search">進階搜尋</a>
                        <div class="select-select">
                            <select class="form-control" name="" id="">
                                <option value="">品牌選擇</option>
                            </select>
                            <select class="form-control" name="" id="">
                                <option value="">品牌次選擇</option>
                            </select>
                            <select class="form-control" name="" id="">
                                <option value="">類別選擇</option>
                            </select>
                            <select class="form-control" name="" id="">
                                <option value="">次類別選擇</option>
                            </select>
                        </div>
                    </div>
                    <ul class="products-list list-h">
                        <?php for($i=0; $i<8; $i++) { ?>
                        <li class="item wow fadeIn" data-wow-delay="<?=$i*0.2+0.1?>s">
                            <div class="box">
                                <a href="products_detail.php">
                                    <figure class="pic"><img src="images/pro/pic<?=$i%4+1?>.jpg" alt=""></figure>
                                    <div class="name">產品名稱</div>
                                    <div class="offers">RMB.$2,400.00</div>
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