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