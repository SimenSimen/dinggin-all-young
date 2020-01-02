<div id="tt-pageContent">
    <div class="container-indent">

        <!-- mobile product slider  -->
        <div class="tt-mobile-product-layout visible-xs">
            <div class="tt-mobile-product-slider arrow-location-center slick-animated-show-js">
                <?php $image = explode(',', $dbdata['prd_image']); ?>
                <?php foreach ($image as $key =>  $img_val) : ?>
                    <div><img src="<?= $this->Spath; ?><?= $img_val; ?>" alt=""></div>
                <?php endforeach ?>
                <!-- <div>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="http://www.youtube.com/embed/GhyKqj_P2E4" allowfullscreen></iframe>
                    </div>
                </div>
                <div>
                    <div class="tt-video-block">
                        <a href="#" class="link-video"></a>
                        <video class="movie" src="video/video.mp4" poster="video/video_img.jpg"></video>
                    </div>
                </div> -->
            </div>
        </div>
        <!-- /mobile product slider  -->
        <div class="container container-fluid-mobile">
            <div class="row">
                <div class="col-6 hidden-xs">
                    <div class="tt-product-single-img">
                        <div>
                            <button class="tt-btn-zomm tt-top-right"><i class="icon-f-86"></i></button>
                            <?php $zoomImage = @$image[0] ? ($this->Spath . $image[0]) : base_url('/images/nodata.jpg') ?>
                            <img class="zoom-product" src='<?= $zoomImage ?>' data-zoom-image="<?= $zoomImage ?>" alt="">
                        </div>
                    </div>
                    <div class="product-images-carousel">
                        <ul id="smallGallery" class="arrow-location-02  slick-animated-show-js">
                            <?php foreach ($image as $key =>  $img_val) : ?>
                                <li><a class="<?= $key === 0 ? 'zoomGalleryActive' : '' ?>" href="javascript:void(0);" data-image="<?= $this->Spath; ?><?= $img_val; ?>" data-zoom-image="<?= $this->Spath; ?><?= $img_val; ?>"><img src="<?= $this->Spath; ?><?= $img_val; ?>" alt="" /></a></li>
                            <?php endforeach ?>
                            <!-- <li>
                                <div class="video-link-product" data-toggle="modal" data-type="youtube" data-target="#modalVideoProduct" data-value="http://www.youtube.com/embed/GhyKqj_P2E4">
                                    <img src="images/product/product-small-empty.png" alt="" />
                                    <div>
                                        <i class="icon-f-32"></i>
                                    </div>
                                </div>
                            </li> -->
                        </ul>
                    </div>
                </div>
                <div class="col-6">
                    <div class="tt-product-single-info">
                        <h1 class="tt-title"><?= $dbdata['prd_name'] ?></h1>
                        <div class="tt-price">
                            <?php if ($dbdata['prd_new'] === 'Y') : ?>
                                <span class="new-price c_green02">$<?= $price ?></span>
                                <span class="old-price">$<?= $dbdata['prd_price01'] ?></span>
                            <?php else : ?>
                                <span class="price">$<?= $price ?></span>
                            <?php endif ?>
                        </div>
                        <!-- <div class="tt-wrapper">Ut enim ad minim veniam.</div> -->

                        <div class="tt-wrapper">
                            <div class="tt-row-custom-01">
                                <?php if (intval($prd_amount) > 0) : ?>
                                    <div class="col-item">
                                        <div class="tt-input-counter style-01">
                                            <span class="minus-btn"></span>
                                            <input id="cart-info-number" type="text" value="1" size="<?= $prd_amount > $prd_lock_amount ? $prd_lock_amount : $prd_amount ?>" />
                                            <span class="plus-btn"></span>
                                        </div>
                                    </div>
                                    <div class="col-item">
                                        <a href="javascript:void(0);" onclick="cart_add_in_list('<?= $dbdata['prd_id'] ?>',window['cart-info-number'].value);" class="btn btn-lg btn-green-bg"><i class="icon-f-39"></i><?= $this->lang['p_car'] ?></a>
                                    </div>
                                <?php else : ?>
                                    <? // 缺貨中按鈕 
                                    ?>
                                    <div class="col-item">
                                        <span class="sold-out"><?= $this->lang['sale_out'] ?></span>
                                    </div>
                                    <div class="col-item">
                                        <a href="javascript:void(0);" class="btn btn-lg btn-green-bg"><?= $this->lang['out_of_stock'] ?></a>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="tt-wrapper">
                            <ul class="tt-list-btn">
                                <li id="favo-area-in-page">
                                    <?php $like = in_array($dbdata['prd_id'], $faIds) ?>
                                    <div style="cursor: pointer; <?= !$like ? 'display: none;' : '' ?>" class="unfavorite" onclick="ajax_add_favorate_info('<?= $dbdata['prd_id'] ?>');">unfavorite</div>
                                    <a style="<?= $like ? 'display: none;' : '' ?>" class="btn-link btn-green favorite" href="javascript:void(0);" onclick="ajax_add_favorate_info('<?= $dbdata['prd_id'] ?>');">
                                        <i class="icon-n-072"></i><?= $this->lang['p_unlike'] ?>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="tt-collapse-block">
                            <div class="tt-item active">
                                <div class="tt-collapse-title"><?= $this->lang['p_describe'] ?></div>
                                <div class="tt-collapse-content">
                                    <? foreach ($prd_describe as $key => $value) : ?>
                                        <?= $value ?><br>
                                    <? endforeach ?>
                                </div>
                            </div>

                            <div class="tt-item active">
                                <div class="tt-collapse-title"><?= $this->lang['p_spec'] ?></div>
                                <div class="tt-collapse-content">
                                    <div class="tt-add-info">
                                        <ul>
                                            <? foreach ($prd_specification_content as $key => $value) : ?>
                                                <li><span><?= $prd_specification_name[$key] ?></span> <?= $value ?></li>
                                            <? endforeach ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="tt-item active">
                                <div class="tt-collapse-title"><?= $this->lang['p_buy'] ?></div>
                                <div class="tt-collapse-content">
                                    <?= $buy_content; ?>
                                </div>
                            </div>
                            <div class="tt-item active">
                                <div class="tt-collapse-title"><?= $this->lang['p_ship'] ?></div>
                                <div class="tt-collapse-content">
                                    <?= $ship_rule; ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="container container-fluid-custom-mobile-padding">
            <div class="tt-block-title">
                <h1 class="tt-title"><?= $this->lang['p_like'] ?></h1>
                <!-- <div class="tt-description">New Arrival</div> -->
            </div>
            <div class="tt-carousel-products row arrow-location-tab arrow-location-tab01 tt-alignment-img tt-collection-listing mt0 ">

                <?php foreach ($dbdataLike as $key => $value) : ?>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="tt-product thumbprod-center">
                            <div class="tt-image-box">
                                <a href="javascript:void(0);" onclick="quickView('<?= $value['prd_id'] ?>');" class="tt-btn-quickview" data-toggle="modal" data-tooltip="Quick View" data-tposition="left"></a>
                                <a href="javascript:void(0);" onclick="ajax_add_favorate('<?= $value['prd_id'] ?>');" class="tt-btn-wishlist <?= in_array($value['prd_id'], $faIds) ? 'active' : '' ?>" data-tooltip="Add to Wishlist" data-tposition="left"></a>
                                <a href="javascript:void(0);" class="tt-btn-compare" data-tooltip="Add to Compare" data-tposition="left"></a>
                                <a href="/products/detail/<?= $value['prd_id']; ?>">
                                    <?php $image = $value['prd_image'] !== '' ? $value['prd_image'] : '/images/nodata.jpg'; ?>
                                    <span class="tt-img"><img src="images/loader.svg" data-src="<?= $image ?>" alt="<?= stripslashes($value['prd_name']); ?>" alt=""></span>
                                    <span class="tt-img-roll-over"><img src="images/loader.svg" data-src="<?= $image ?> ?>" alt="<?= stripslashes($value['prd_name']); ?>" alt=""></span>
                                </a>
                            </div>
                            <div class="tt-description">
                                <h2 class="tt-title"><a href="/products/detail/<?= $value['prd_id']; ?>"><?= stripslashes($value['prd_name']); ?></a></h2>
                                <div class="tt-price">
                                    <span class="old-price normal-price">$<?= ($d_spec_type == 1) ? $value['d_mprice'] : $value['prd_price00']; ?></span>
                                </div>
                                <div class="tt-product-inside-hover">
                                    <div class="tt-row-btn">
                                        <a href="javascript:void(0);" class="tt-btn-addtocart thumbprod-button-bg btn btn-green-bg" data-toggle="modal" onclick="cart_add_in_list('<?= $value['prd_id'] ?>',1);">ADD TO CART</a>
                                    </div>
                                    <div class="tt-row-btn">
                                        <a href="#" onclick="quickView('<?= $value['prd_id'] ?>');" class="tt-btn-quickview" data-toggle="modal" data-target="#ModalquickView"></a>
                                        <a href="#" class="tt-btn-wishlist"></a>
                                        <a href="#" class="tt-btn-compare"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>

        <div class="pagination_box">
            <div id="qrcodeCanvas"></div>
            <script>
                document.addEventListener("DOMContentLoaded", function(event) {
                    /** set to the next tick */
                    setTimeout(function() {
                        $.ajax({
                            url: '<?= base_url('js/jqrcode/jquery.qrcode-0.7.0.js') ?>',
                            dataType: 'script',
                            success: function() {
                                $('#qrcodeCanvas').qrcode({
                                    width: 240,
                                    height: 240,
                                    text: "https://<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"
                                });
                            },
                            async: true
                        });
                    }, 1);
                });
            </script>
        </div>

        <div class="text-center tt_product_showmore">
            <a href="#" class="btn btn-green-bg"><i name="icon02" class="icon-chevron-left" aria-hidden="true"></i><?= $this->lang['back'] ?></a>
        </div>

    </div>
</div>