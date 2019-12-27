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
                                <?= $keyword ? $keyword : 'All Products' ?> <span class="tt-title-total">(<?= $pageData['total_rows'] ?>)</span>
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
                        <div id="items-area" class="tt-product-listing row">
                            <?= $this->load->view($indexViewPath . '/products/_item_list', ['dbdata' => $dbdata]) ?>
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
    /** Handle loading the items temp @todo 2200*/
    // $(document).ready(function() {
    //     var loadButton = $('#load-more');
    //     var currentPage = parseInt(qs('pageNumber')) || 1;

    //     loadButton.on('click', function() {
    //         var url = updateUrlParameter(window.location.href, 'pageNumber', currentPage += 1);
    //         $.get(url, function(result) {
    //             $('#items-area').append(result);
    //         });
    //     });
    // })
</script>