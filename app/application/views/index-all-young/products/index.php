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
                        <h3 class="tt-collapse-title"><?= $this->lang['p_type'] ?></h3>
                        <div class="tt-collapse-content">
                            <ul class="tt-list-row">
                                <?php foreach ($productClasses as $productClasses) : ?>
                                    <li class="<?= $activeClass == $productClasses['prd_cid'] ? 'active' : '' ?>"><a href="<?= base_url('products') ?>/<?= $productClasses['prd_cid'] ?>"><?= $productClasses['prd_cname'] ?></a></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                    <div class="tt-collapse open">
                        <h3 class="tt-collapse-title"><?= $this->lang['p_price'] ?></h3>
                        <div class="tt-collapse-content">
                            <ul class="tt-list-row">
                                <li class="<?= intval($_GET['minPrice']) == 0 && intval($_GET['maxPrice']) == 50 ? 'active' : '' ?>"><a href="javascript:void(0);" onclick="forwardWithFilters({minPrice:0, maxPrice: 50 });">>$0 — $50</a></li>
                                <li class="<?= intval($_GET['minPrice']) == 50 && intval($_GET['maxPrice']) == 100 ? 'active' : '' ?>"><a href="javascript:void(0);" onclick="forwardWithFilters({minPrice: 50, maxPrice: 100});">$50 — $100</a></li>
                                <li class="<?= intval($_GET['minPrice']) == 100 && intval($_GET['maxPrice']) == 150 ? 'active' : '' ?>"><a href="javascript:void(0);" onclick="forwardWithFilters({minPrice: 100, maxPrice: 150});">$100 — $150</a></li>
                                <li class="<?= intval($_GET['minPrice']) == 150 && intval($_GET['maxPrice']) == 200 ? 'active' : '' ?>"><a href="javascript:void(0);" onclick="forwardWithFilters({minPrice: 150, maxPrice: 200});">$150 — $200</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="tt-collapse open">
                        <h3 class="tt-collapse-title"><?= $this->lang['supplier'] ?></h3>
                        <div class="tt-collapse-content">
                            <ul class="tt-list-row">
                                <?php foreach ($suppliers as $supplier) : ?>
                                    <li class="<?= @$_GET['providerId'] == $supplier['id'] ? 'active' : '' ?>">
                                        <a href="javascript:void(0);" onclick="forwardWithFilters({providerId: <?= $supplier['id'] ?>});"><?= $supplier['english_name'] ?></a>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                            <!-- <a href="#" class="btn-link-02">+ More</a> -->
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-9 col-xl-9">
                    <div class="content-indent container-fluid-custom-mobile-padding-02">
                        <div class="tt-filters-options" id="js-tt-filters-options">
                            <h1 class="tt-title">
                                <?= $keyword ? $keyword : $this->lang['all'] ?> <span class="tt-title-total">(<?= $pageData['total_rows'] ?>)</span>
                            </h1>
                            <div class="tt-btn-toggle">
                                <a href="#">FILTER</a>
                            </div>
                            <div class="tt-sort">
                                <select onchange="forwardWithFilters({sortType: this.value == 0 ? null : this.value})">
                                    <option value="0"><?= $this->lang['d_sort'] ?></option>
                                    <option value="2" <?= @$_GET['sortType'] == 2 ? 'selected' : '' ?>><?= $this->lang['p_high'] ?></option>
                                    <option value="1" <?= @$_GET['sortType'] == 1 ? 'selected' : '' ?>><?= $this->lang['p_low'] ?></option>
                                </select>
                            </div>
                            <div class="tt-quantity">
                                <a href="javascript:void(0);" class="tt-col-one" data-value="tt-col-one"></a>
                                <a href="javascript:void(0);" class="tt-col-two" data-value="tt-col-two"></a>
                                <a href="javascript:void(0);" class="tt-col-three" data-value="tt-col-three"></a>
                                <a href="javascript:void(0);" class="tt-col-four" data-value="tt-col-four"></a>
                                <!-- <a href="#" class="tt-col-six" data-value="tt-col-six"></a> -->
                            </div>
                        </div>
                        <div id="items-area" class="tt-product-listing row">
                            <?= $this->load->view($indexViewPath . '/products/_item_list', ['dbdata' => $dbdata]) ?>
                        </div>
                        <div class="text-center tt_product_showmore">
                            <a id="load-more" href="javascript:void(0);" class="btn btn-green"><?= $this->lang['load_more'] ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>