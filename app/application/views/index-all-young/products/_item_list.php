<?php foreach ($dbdata as $product) : ?>
    <?php $loadingImage = base_url('images/loader.svg'); ?>
    <?php $prdImage = (!empty($product['prd_image'])) ? '/uploads/000/000/0000/0000000000/products/' . $product['prd_image'] : '/images/nodata.jpg'; ?>
    <div class="col-6 col-md-4 tt-col-item">
        <div class="tt-product thumbprod-center">
            <div class="tt-image-box">
                <a href="javascript:void(0);" onclick="quickView('<?= $product['prd_id'] ?>');" class="tt-btn-quickview" data-toggle="modal" data-tooltip="Quick View" data-tposition="left"></a>
                <a href="javascript:void(0);" onclick="ajax_add_favorate('<?= $product['prd_id'] ?>');" class="tt-btn-wishlist <?= in_array($product['prd_id'], $faIds) ? 'active' : '' ?>" data-tooltip="Add to Wishlist" data-tposition="left"></a>
                <a href="javascript:void(0);" class="tt-btn-compare" data-tooltip="Add to Compare" data-tposition="left"></a>
                <a href="<?= base_url('/products/detail/' . $product['prd_id']) ?>">
                    <span class="tt-img"><img src="<?= $isAjax ? $prdImage : $loadingImage ?>" data-src="<?= $prdImage ?>" alt="<?= stripslashes($product['prd_name']); ?>" alt=""></span>
                    <span class="tt-img-roll-over"><img src="<?= $isAjax ? $prdImage : $loadingImage ?>" data-src="<?= $prdImage ?>" alt="<?= stripslashes($product['prd_name']); ?>" alt=""></span>
                </a>
            </div>
            <div class="tt-description">
                <h2 class="tt-title"><a href="<?= base_url('/products/detail/' . $product['prd_id']) ?>"><?= stripslashes($product['prd_name']); ?></a></h2>
                <div class="tt-price">
                    <?php if ($product['prd_new'] === 'Y') : ?>
                        <span class="new-price">$<?= $product['price']; ?></span>
                        <span class="old-price">$<?= $product['prd_price01']; ?></span>
                    <?php else : ?>
                        <span class="price">$<?= $product['price']; ?></span>
                    <?php endif ?>
                </div>
                <div class="tt-product-inside-hover">
                    <div class="tt-row-btn">
                        <a href="javascript:void(0);" class="tt-btn-addtocart thumbprod-button-bg b_green02" data-toggle="modal" onclick="cart_add_in_list('<?= $product['prd_id'] ?>',1);">ADD TO CART</a>
                    </div>
                    <div class="tt-row-btn">
                        <a href="javascript:void(0);" class="tt-btn-quickview" data-toggle="modal" onclick="quickView('<?= $product['prd_id'] ?>');"></a>
                        <a href="javascript:void(0);" class="tt-btn-wishlist"></a>
                        <a href="javascript:void(0);" class="tt-btn-compare"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>