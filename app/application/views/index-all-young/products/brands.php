<div id="tt-pageContent">
    <div class="container-indent">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-lg-3 col-xl-3 leftColumn aside" id="js-leftColumn-aside">
                    <div class="tt-btn-col-close">
                        <a href="#">Close</a>
                    </div>
                    <div class="tt-collapse open tt-filter-detach-option">
                        <div class="tt-collapse-content">
                            <div class="filters-mobile">
                                <div class="filters-row-select">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tt-collapse open">
                        <h3 class="tt-collapse-title">Categories</h3>
                        <div class="tt-collapse-content">
                            <ul class="tt-list-row">
                                <?php foreach ($productClasses as $productClasses) : ?>
                                    <li class="<?= $activeClass == $productClasses['prd_cid'] ? 'active' : '' ?>"><a href="<?= base_url('brands') ?>?classId=<?= $productClasses['prd_cid'] ?>"><?= $productClasses['prd_cname'] ?></a></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                    <div class="tt-collapse open">
                        <h3 class="tt-collapse-title">Price Range</h3>
                        <div class="tt-collapse-content">
                            <ul class="tt-list-row">
                                <li class="active"><a href="<?= base_url('brands?maxPrice=50') ?>">$0 — $50</a></li>
                                <li><a href="<?= base_url('brands?minPrice=50&maxPrice=100') ?>">$50 — $100</a></li>
                                <li><a href="<?= base_url('brands?minPrice=100&maxPrice=150') ?>">$100 — $150</a></li>
                                <li><a href="<?= base_url('brands?minPrice=150&maxPrice=200') ?>">$150 — $200</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-9 col-xl-9">
                    <div class="title02">Brand name</div>
                    <div class="tt-post-single">
                        <div class="tt-post-content">
                            <div class="title03">Commodity story</div>
                            <h2 class="tt-title02">This is title, This is title</h2>
                            <span class="line b_green"></span>
                            <p>Pellentesque tempor ut dui a sollicitudin. Quisque diam lectus, dignissim et vestibulum fringilla, dictum et metus. Quisque condimentum dui augue, quis pellentesque ipsum interdum ultrices. Phasellus tempor aliquet molestie. Nulla pellentesque finibus risus, a mattis magna fermentum id. Cras dictum egestas diam, non interdum tortor blandit sit amet. Praesent aliquam nulla at diam vehicula, vel eleifend felis rutrum. Curabitur velit tortor, ultrices eu turpis ac, imperdiet luctus enim. Fusce sit amet diam sed felis feugiat sagittis sit amet et elit. Phasellus dapibus dolor ac mi ultrices, vel auctor lorem sollicitudin. Nullam congue velit ac nibh fermentum, quis egestas ante laoreet. Morbi tempus magna eu vehicula eleifend.</p>
                            <img src="images/loader.svg" data-src="images/blog/blog-single-img-01.jpg" alt="">
                        </div>
                    </div>

                    <? // 站內影片模式 
                    ?>
                    <div class="tt-post-single videobox">
                        <div class="tt-post-content">
                            <div class="tt-video-block">
                                <a href="#" class="link-video"></a>
                                <video class="movie" src="video/video.mp4" poster="video/video_img.jpg"></video>
                            </div>
                        </div>
                    </div>

                    <? // 外連影片模式 
                    ?>
                    <div class="videobox">
                        <iframe src="https://www.youtube.com/embed/AclADUkYWBk" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

                    </div>


                    <div class="content-indent container-fluid-custom-mobile-padding-02">
                        <div class="tt-filters-options" id="js-tt-filters-options">
                            <h1 class="tt-title text-center">
                                Brand name <span class="tt-title-total">(69)</span>
                            </h1>
                            <div class="tt-btn-toggle">
                                <a href="#">FILTER</a>
                            </div>
                            <div class="tt-sort">
                                <select>
                                    <option value="Default Sorting">Sort</option>
                                    <option value="Default Sorting">Low to high price</option>
                                    <option value="Default Sorting">High to low price</option>
                                </select>
                            </div>
                            <div class="tt-quantity">
                                <a href="#" class="tt-col-one" data-value="tt-col-one"></a>
                                <a href="#" class="tt-col-two" data-value="tt-col-two"></a>
                                <a href="#" class="tt-col-three" data-value="tt-col-three"></a>
                                <a href="#" class="tt-col-four" data-value="tt-col-four"></a>
                                <!-- <a href="#" class="tt-col-six" data-value="tt-col-six"></a> -->
                            </div>
                        </div>
                        <div class="tt-product-listing row">
                            <?php for ($i = 0; $i < 4; $i++) { ?>
                                <div class="col-6 col-md-3 tt-col-item">
                                    <div class="tt-product thumbprod-center">
                                        <div class="tt-image-box">
                                            <a href="#" class="tt-btn-quickview" data-toggle="modal" data-target="#ModalquickView" data-tooltip="Quick View" data-tposition="left"></a>
                                            <a href="#" class="tt-btn-wishlist" data-tooltip="Add to Wishlist" data-tposition="left"></a>
                                            <a href="#" class="tt-btn-compare" data-tooltip="Add to Compare" data-tposition="left"></a>
                                            <a href="product.html">
                                                <span class="tt-img"><img src="images/loader.svg" data-src="images/product/product-15.jpg" alt=""></span>
                                                <span class="tt-img-roll-over"><img src="images/loader.svg" data-src="images/product/product-15-01.jpg" alt=""></span>
                                            </a>
                                        </div>
                                        <div class="tt-description">
                                            <h2 class="tt-title"><a href="product.html">Product Name</a></h2>
                                            <div class="tt-price">
                                                <span class="new-price">$14</span>
                                                <span class="old-price">$24</span>
                                            </div>
                                            <div class="tt-product-inside-hover">
                                                <div class="tt-row-btn">
                                                    <a href="#" class="tt-btn-addtocart thumbprod-button-bg" data-toggle="modal" data-target="#modalAddToCartProduct">ADD TO CART</a>
                                                </div>
                                                <div class="tt-row-btn">
                                                    <a href="#" class="tt-btn-quickview" data-toggle="modal" data-target="#ModalquickView"></a>
                                                    <a href="#" class="tt-btn-wishlist"></a>
                                                    <a href="#" class="tt-btn-compare"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="text-center tt_product_showmore">
                            <a href="#" class="btn btn-green">LOAD MORE</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>