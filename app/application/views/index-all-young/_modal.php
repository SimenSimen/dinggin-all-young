<!-- modal (AddToCartProduct) -->
<div class="modal fade" id="modalAddToCartProduct" tabindex="-1" role="dialog" aria-label="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="icon icon-clear"></span></button>
            </div>
            <div class="modal-body">
                <div class="tt-modal-addtocart mobile">
                    <div class="tt-modal-messages">
                        <i class="icon-f-68"></i> Added to cart successfully!
                    </div>
                    <a href="#" class="btn-link btn-close-popup">CONTINUE SHOPPING</a>
                </div>
                <div class="tt-modal-addtocart desctope">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="tt-modal-messages">
                                <i class="icon-f-68"></i> Added to cart successfully!
                            </div>
                            <div class="tt-modal-product">
                                <div class="tt-img">
                                    <img class="cart-item-image" src="" data-src="" alt="">
                                </div>
                                <h2 class="tt-title"><a class="cart-item-name" href="product.html">Flared Shift Dress</a></h2>
                                <div class="tt-qty">
                                    QTY: <span class="cart-item-amount">1</span>
                                </div>
                            </div>
                            <div class="tt-product-total">
                                <div class="tt-total">
                                    TOTAL: <span class="tt-price"><span class="cart-item-price"></span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <a href="#" class="tt-cart-total">
                                There are <span class="cart-total-amount"></span> items in your cart
                                <div class="tt-total">
                                    TOTAL: <span class="tt-price">$<span class="cart-total-price"></span></span>
                                </div>
                            </a>
                            <a href="#" class="btn btn-border btn-close-popup">CONTINUE SHOPPING</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal (quickViewModal) -->
<div class="modal fade" id="ModalquickView" tabindex="-1" role="dialog" aria-label="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="icon icon-clear"></span></button>
            </div>
            <div class="modal-body">
                <div class="tt-modal-quickview desctope">
                    <div class="row">
                        <div class="col-12 col-md-5 col-lg-6">
                            <div class="tt-mobile-product-slider arrow-location-center quick-view-image">
                                <!-- <div><img src="images/loader.svg" data-src="/images/product/product-01.jpg" alt=""></div>
                                <div><img src="images/loader.svg" data-src="/images/product/product-01-02.jpg" alt=""></div>
                                <div><img src="images/loader.svg" data-src="/images/product/product-01-03.jpg" alt=""></div>
                                <div><img src="images/loader.svg" data-src="/images/product/product-01-04.jpg" alt=""></div> -->
                                <!--
								//video insertion template
								<div>
									<div class="tt-video-block">
										<a href="#" class="link-video"></a>
										<video class="movie" src="video/video.mp4" poster="video/video_img.jpg"></video>
									</div>
								</div> -->
                            </div>
                        </div>
                        <div class="col-12 col-md-7 col-lg-6">
                            <div class="tt-product-single-info">
                                <div class="tt-add-info">
                                    <ul>
                                        <li><span>SKU:</span> <span class="quick-view-id"></span></li>
                                        <li><span>Availability:</span> <span class="quick-view-stock"></span> in Stock</li>
                                    </ul>
                                </div>
                                <h2 class="tt-title"><span class="quick-view-name"></span></h2>
                                <div class="tt-price">
                                    <span class="new-price">$<span class="quick-view-price"></span></span>
                                    <!-- <span class="old-price"></span> -->
                                </div>
                                <!-- <div class="tt-review">
                                    <div class="tt-rating">
                                        <i class="icon-star"></i>
                                        <i class="icon-star"></i>
                                        <i class="icon-star"></i>
                                        <i class="icon-star-half"></i>
                                        <i class="icon-star-empty"></i>
                                    </div>
                                    <a href="#">(1 Customer Review)</a>
                                </div> -->
                                <div class="tt-wrapper quick-view-content">

                                </div>

                                <div class="tt-wrapper quick-view-spec">
                                </div>
                                <!-- <div class="tt-swatches-container">
                                    <div class="tt-wrapper">
                                        <div class="tt-title-options">SIZE</div>
                                        <form class="form-default">
                                            <div class="form-group">
                                                <select class="form-control">
                                                    <option>21</option>
                                                    <option>25</option>
                                                    <option>36</option>
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tt-wrapper">
                                        <div class="tt-title-options">COLOR</div>
                                        <form class="form-default">
                                            <div class="form-group">
                                                <select class="form-control">
                                                    <option>Red</option>
                                                    <option>Green</option>
                                                    <option>Brown</option>
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tt-wrapper">
                                        <div class="tt-title-options">TEXTURE:</div>
                                        <ul class="tt-options-swatch options-large">
                                            <li><a class="options-color" href="#">
                                                    <span class="swatch-img">
                                                        <img src="images/loader.svg" data-src="images/custom/texture-img-01.jpg" alt="">
                                                    </span>
                                                    <span class="swatch-label color-black"></span>
                                                </a></li>
                                            <li class="active"><a class="options-color" href="#">
                                                    <span class="swatch-img">
                                                        <img src="images/loader.svg" data-src="images/custom/texture-img-02.jpg" alt="">
                                                    </span>
                                                    <span class="swatch-label color-black"></span>
                                                </a></li>
                                            <li><a class="options-color" href="#">
                                                    <span class="swatch-img">
                                                        <img src="images/loader.svg" data-src="images/custom/texture-img-03.jpg" alt="">
                                                    </span>
                                                    <span class="swatch-label color-black"></span>
                                                </a></li>
                                            <li><a class="options-color" href="#">
                                                    <span class="swatch-img">
                                                        <img src="images/loader.svg" data-src="images/custom/texture-img-04.jpg" alt="">
                                                    </span>
                                                    <span class="swatch-label color-black"></span>
                                                </a></li>
                                            <li><a class="options-color" href="#">
                                                    <span class="swatch-img">
                                                        <img src="images/loader.svg" data-src="images/custom/texture-img-05.jpg" alt="">
                                                    </span>
                                                    <span class="swatch-label color-black"></span>
                                                </a></li>
                                        </ul>
                                    </div>
                                </div>
                                -->
                                <div class="tt-wrapper">
                                    <input id="productID" type="hidden">
                                    <div class="tt-row-custom-01">
                                        <div class="col-item">
                                            <div class="tt-input-counter style-01">
                                                <span class="minus-btn"></span>
                                                <input id="productNum" type="text" value="1" size="5">
                                                <span class="plus-btn"></span>
                                            </div>
                                        </div>
                                        <div class="col-item">
                                            <a id="out-of-stock-button" style="display: none;" href="javascript:void(0)" class="btn btn-lg bg-secondary"><i class="icon-f-39"></i>OUT OF STOCK</a>
                                            <a id="add-cart-button" href="javascript:void(0)" onclick="cart_add_in_quick(productID.value, productNum.value);" class="btn btn-lg add-cart"><i class="icon-f-39"></i>ADD TO CART</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modalVideoProduct -->
<div class="modal fade" id="modalVideoProduct" tabindex="-1" role="dialog" aria-label="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-video">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="icon icon-clear"></span></button>
            </div>
            <div class="modal-body">
                <div class="modal-video-content">

                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal (ModalSubsribeGood) -->
<div class="modal  fade" id="ModalSubsribeGood" tabindex="-1" role="dialog" aria-label="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xs">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="icon icon-clear"></span></button>
            </div>
            <div class="modal-body">
                <div class="tt-modal-subsribe-good">
                    <i class="icon-f-68"></i> You have successfully signed!
                </div>
            </div>
        </div>
    </div>
</div>