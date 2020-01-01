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

                                <li class="<?= intval($_GET['minPrice']) == 0 && intval($_GET['maxPrice']) == 50 ? 'active' : '' ?>"><a href="javascript:void(0);" onclick="forwardWithFilters({minPrice:0, maxPrice: 50 });">>$0 — $50</a></li>
                                <li class="<?= intval($_GET['minPrice']) == 50 && intval($_GET['maxPrice']) == 100 ? 'active' : '' ?>"><a href="javascript:void(0);" onclick="forwardWithFilters({minPrice: 50, maxPrice: 100});">$50 — $100</a></li>
                                <li class="<?= intval($_GET['minPrice']) == 100 && intval($_GET['maxPrice']) == 150 ? 'active' : '' ?>"><a href="javascript:void(0);" onclick="forwardWithFilters({minPrice: 100, maxPrice: 150});">$100 — $150</a></li>
                                <li class="<?= intval($_GET['minPrice']) == 150 && intval($_GET['maxPrice']) == 200 ? 'active' : '' ?>"><a href="javascript:void(0);" onclick="forwardWithFilters({minPrice: 150, maxPrice: 200});">$150 — $200</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-9 col-xl-9">
                    <div class="title02"><?= $brandData['d_name'] ?></div>
                    <div class="tt-post-single">
                        <div class="tt-post-content">
                            <div class="title03">Commodity story</div>
                            <h2 class="tt-title02"><?= $brandData['d_title'] ?></h2>
                            <span class="line b_green"></span>
                            <p> <?= $brandData['brand_content'] ?></p>
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
                                <?= $brandData['d_name'] ?> <span class="tt-title-total">(<?= $pageData['total_rows'] ?>)</span>
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
                                <a href="#" class="tt-col-one" data-value="tt-col-one"></a>
                                <a href="#" class="tt-col-two" data-value="tt-col-two"></a>
                                <a href="#" class="tt-col-three" data-value="tt-col-three"></a>
                                <a href="#" class="tt-col-four" data-value="tt-col-four"></a>
                                <!-- <a href="#" class="tt-col-six" data-value="tt-col-six"></a> -->
                            </div>
                        </div>
                        <div class="tt-product-listing row">
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