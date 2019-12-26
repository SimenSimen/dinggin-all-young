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
                                    <li class="<?= $activeClass == $productClasses['prd_cid'] ? 'active' : '' ?>"><a href="<?= base_url('products') ?>/<?= $productClasses['prd_cid'] ?>"><?= $productClasses['prd_cname'] ?></a></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                    <div class="tt-collapse open">
                        <h3 class="tt-collapse-title">Price Range</h3>
                        <div class="tt-collapse-content">
                            <ul class="tt-list-row">
                                <li class="active"><a href="#">$0 — $50</a></li>
                                <li><a href="#">$50 — $100</a></li>
                                <li><a href="#">$100 — $150</a></li>
                                <li><a href="#">$150 — $200</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="tt-collapse open">
                        <h3 class="tt-collapse-title">Supplier</h3>
                        <div class="tt-collapse-content">
                            <ul class="tt-list-row">
                                <?php foreach ($suppliers as $supplier) : ?>
                                    <li><a href="#"><?= $supplier['english_name'] ?></a></li>
                                <?php endforeach ?>
                            </ul>
                            <a href="#" class="btn-link-02">+ More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-9 col-xl-9">
                    <div class="content-indent container-fluid-custom-mobile-padding-02">
                        <div class="tt-filters-options" id="js-tt-filters-options">
                            <h1 class="tt-title">
                                <?= $keyword ? $keyword : 'All Products' ?> <span class="tt-title-total">(<?= $pageData['TotalRecord'] ?>)</span>
                            </h1>
                            <div class="tt-btn-toggle">
                                <a href="#">FILTER</a>
                            </div>
                            <div class="tt-sort">
                                <select>
                                    <option value="Default Sorting">Default Sorting</option>
                                    <option value="Default Sorting">Low to High Price</option>
                                    <option value="Default Sorting">High to Low Price</option>
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
                            <?php foreach ($dbdata as $product) : ?>
                                <div class="col-6 col-md-4 tt-col-item">
                                    <div class="tt-product thumbprod-center">
                                        <div class="tt-image-box">
                                            <a href="#" class="tt-btn-quickview" data-toggle="modal" data-target="#ModalquickView" data-tooltip="Quick View" data-tposition="left"></a>
                                            <a href="#" class="tt-btn-wishlist" data-tooltip="Add to Wishlist" data-tposition="left"></a>
                                            <a href="#" class="tt-btn-compare" data-tooltip="Add to Compare" data-tposition="left"></a>
                                            <a href="<?= base_url('/products/detail/' . $product['prd_id']) ?>">
                                                <span class="tt-img"><img src="images/loader.svg" data-src="<?= (!empty($product['prd_image'])) ? '/uploads/000/000/0000/0000000000/products/' . $product['prd_image'] : '/images/nodata.jpg'; ?>" alt="<?= stripslashes($product['prd_name']); ?>" alt=""></span>
                                                <span class="tt-img-roll-over"><img src="images/loader.svg" data-src="<?= (!empty($product['prd_image'])) ? '/uploads/000/000/0000/0000000000/products/' . $product['prd_image'] : '/images/nodata.jpg'; ?>" alt="<?= stripslashes($product['prd_name']); ?>" alt=""></span>
                                            </a>
                                        </div>
                                        <div class="tt-description">
                                            <h2 class="tt-title"><a href="<?= base_url('/products/detail/' . $product['prd_id']) ?>"><?= stripslashes($product['prd_name']); ?></a></h2>
                                            <div class="tt-price">
                                                <span class="new-price">$<?= $product['price']; ?></span>
                                                <span class="old-price">$<?= $product['price']; ?></span>
                                            </div>
                                            <div class="tt-product-inside-hover">
                                                <div class="tt-row-btn">
                                                    <a href="#" class="tt-btn-addtocart thumbprod-button-bg b_green02" data-toggle="modal" data-target="#modalAddToCartProduct">ADD TO CART</a>
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
                            <?php endforeach ?>
                        </div>
                        <div class="text-center tt_product_showmore">
                            <a id="load-more" href="#" class="btn btn-green">LOAD MORE</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var loadButton = $('#load-more');

        loadButton.on('click', function() {

        });
    })
</script>