<div id="tt-pageContent">
	<div class="container-indent nomargin">
		<div class="container-fluid">
			<div class="row">
				<div class="slider-revolution revolution-default">
					<div class="tp-banner-container">
						<div class="tp-banner revolution">
							<ul>
								<?php foreach ($banners as $banner) { ?>

									<li data-thumb="/uploads/000/000/0000/0000000000/banner/<?= $banner["filename"] ?>" data-transition="fade" data-slotamount="1" data-masterspeed="1000" data-saveperformance="off" data-title="Slide">
										<img src="/uploads/000/000/0000/0000000000/banner/<?= $banner["filename"] ?>" alt="slide1" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat">
										<div class="tp-caption tp-caption1 lft stb" data-x="center" data-y="center" data-hoffset="0" data-voffset="0" data-speed="600" data-start="900" data-easing="Power4.easeOut" data-endeasing="Power4.easeIn">
											<div class="tp-caption1-wd-1 tt-white-color">Ready To</div>
											<div class="tp-caption1-wd-2 tt-white-color">Use Unique<br>Demos</div>
											<div class="tp-caption1-wd-3">Optimized for speed, website that sells</div>
											<div class="tp-caption1-wd-4"><a href="<?= $banner["content"] ?>" class="btn btn-dark btn-xl" data-text="SHOP NOW!">SHOP NOW!</a></div>
										</div>
									</li>

									<?php pathinfo($banner['filename'], PATHINFO_EXTENSION); ?>
								<? } ?>

							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container-indent">
		<div class="container container-fluid-custom-mobile-padding">
			<div class="tt-block-title">
				<h1 class="tt-title"><?= $indexLang['products_new'] ?></h1>
				<!-- <div class="tt-description">New Arrival</div> -->
			</div>
			<div class="tt-carousel-products row arrow-location-tab arrow-location-tab01 tt-alignment-img tt-collection-listing mt0 ">
				<?php foreach ($newProducts as $index => $product) { ?>
					<div class="col-6 col-md-4 col-lg-3">
						<div class="tt-product thumbprod-center">
							<div class="tt-image-box">
								<a href="javascript:void(0);" onclick="quickView('<?= $product['prd_id'] ?>');" class="tt-btn-quickview" data-toggle="modal" data-tooltip="Quick View" data-tposition="left"></a>
								<a href="javascript:void(0);" onclick="ajax_add_favorate('<?= $product['prd_id'] ?>');" class="tt-btn-wishlist <?= in_array($product['prd_id'], $faIds) ? 'active' : '' ?>" data-tooltip="Add to Wishlist" data-tposition="left"></a>
								<a href="javascript:void(0);" class="tt-btn-compare" data-tooltip="Add to Compare" data-tposition="left"></a>
								<a href="<?= base_url('/products/detail/' . $product['prd_id']) ?>">
									<?php $image = explode(',', $product['prd_image'])[0] ?>
									<span class="tt-img"><img src="<?= base_url('images/loader.svg') ?>" data-src="<?= base_url($productPath . $image) ?>" alt=""></span>
									<span class="tt-img-roll-over"><img src="<?= base_url('images/loader.svg') ?>" data-src="<?= base_url($productPath . $image)  ?>" alt=""></span>
								</a>
							</div>
							<div class="tt-description">
								<h2 class="tt-title"><a href="product.html"><?= $product['prd_name'] ?></a></h2>
								<div class="tt-price">
									<span class="new-price">$<?= $isSaleMember ? $product['d_mprice'] : $product['prd_price00'] ?></span>
									<span class="old-price">$<?= $product['prd_price01'] ?></span>
								</div>
								<div class="tt-product-inside-hover">
									<div class="tt-row-btn">
										<a href="javascript:void(0);" class="tt-btn-addtocart thumbprod-button-bg b_green02" data-toggle="modal" onclick="cart_add_in_list('<?= $product['prd_id'] ?>',1);"><?= $indexLang['add_cart'] ?></a>
									</div>
									<div class="tt-row-btn">
										<a href="javascript:void(0);" class="tt-btn-quickview" data-toggle="modal" onclick="quickView('<?= $product['prd_id'] ?>');"></a>
										<a href="#" class="tt-btn-wishlist"></a>
										<a href="#" class="tt-btn-compare"></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>


	<div class="container-indent">
		<div class="container">
			<div class="row  tt-layout-promo-box">
				<div class="col-7 bounsAd">
					<a href="#" class="tt-promo-box">
						<img src="http://fakeimg.pl/1180x80/?text=AD images" alt="">
					</a>
				</div>
				<div class="col-5 bounsAd">
					<a href="#" class="tt-promo-box">
						<img src="http://fakeimg.pl/1180x80/?text=AD images" alt="">
					</a>
				</div>

				<?php if (!$isLogin) : ?>
					<div class="col-6 col-sm-6 col-md-6 bonus-box">
						<a href="<?= base_url('/login') ?>" class="tt-btn-info tt-layout-03">
							<div class="tt-title">
								<i class="icon-h-59"></i>
								<span><?= $indexLang['dividend'] ?></span>
							</div>
							<div class="tt-title02"><?= $indexLang['inquire_now'] ?></div>
						</a>
					</div>

					<div class="col-6 col-sm-6 col-md-6 bonus-box">
						<a href="<?= base_url('/login') ?>" class="tt-btn-info tt-layout-03">
							<div class="tt-title">
								<i class="icon-e-47"></i>
								<span><?= $indexLang['bonus'] ?></span>
							</div>
							<div class="tt-title02"><?= $indexLang['inquire_now'] ?></div>
						</a>
					</div>
				<? endif ?>

				<?php if ($isLogin && !$isSaleMember) : ?>
					<div class="col-6 col-sm-6 col-md-6 bonus-box">
						<a href="<?= base_url('/member/dividend') ?>" class="tt-btn-info tt-layout-03">
							<div class="tt-title">
								<i class="icon-h-59"></i>
								<span><?= $indexLang['dividend'] ?></span>
							</div>
							<div class="tt-title02 c_green"><?= number_format($userData['d_dividend']) ?> Point</div>
						</a>
					</div>

					<div class="col-6 col-sm-6 col-md-6 bonus-box">
						<a href="<?= base_url('/member/upgrade') ?>" class="tt-btn-info tt-layout-03">
							<div class="tt-title">
								<i class="icon-e-47"></i>
								<span><?= $indexLang['bonus'] ?></span>
							</div>
							<div class="tt-title02"><?= $indexLang['how_get_bonus'] ?></div>
						</a>
					</div>

				<? endif ?>

				<?php if ($isSaleMember) : ?>
					<div class="col-6 col-sm-6 col-md-6 bonus-box">
						<a href="<?= base_url('/member/dividend') ?>" class="tt-btn-info tt-layout-03">
							<div class="tt-title">
								<i class="icon-h-59"></i>
								<span><?= $indexLang['dividend'] ?></span>
							</div>
							<div class="tt-title02 c_green"><?= number_format($userData['d_dividend']) ?> Point</div>
						</a>
					</div>

					<div class="col-6 col-sm-6 col-md-6 bonus-box">
						<a href="<?= base_url('/member/member_dividend_fun') ?>" class="tt-btn-info tt-layout-03">
							<div class="tt-title">
								<i class="icon-e-47"></i>
								<span><?= $indexLang['bonus'] ?></span>
							</div>
							<div class="tt-title02">rp <?= number_format($userData['d_bonus']) ?></div>
						</a>
					</div>

				<? endif ?>
			</div>
		</div>
	</div>


	<div class="container-indent">
		<div class="container">
			<div class="tt-block-title">
				<h4 class="tt-title"><?= $indexLang['brand'] ?></h4>
			</div>
			<div class="row">
				<div class="col-sm-12 col-6_end-inrow-lg">
					<div class="tt-carousel-products row arrow-location-center-03 index-arrow tt-alignment-img tt-product-listing slick-animated-show-js">
						<?php foreach ($brandList as $brand) : ?>
							<div class="col-6 col-sm-4 col-md-2">
								<a href="<?= base_url('/brands/' . $brand['prd_cid']) ?>" class="tt-btn-info tt-layout-03">
									<img src="<?= base_url('/' . $brandsPath . $brand['brand_image_s']) ?>" alt="">
								</a>
							</div>
						<?php endforeach ?>
					</div>
				</div>
			</div>
		</div>
	</div>



	<div class="container-indent">
		<div class="container container-fluid-custom-mobile-padding">
			<div class="tt-block-title">
				<h2 class="tt-title"><?= $indexLang['products_type'] ?></h2>
			</div>

			<div class="row tt-layout-promo-box">
				<div class="col-sm-12 col-md-6">
					<div class="row">
						<div class="col-6">
							<?php for ($i = 0; $i < 2; $i++) : ?>
								<?php if (@$productCategorys[$i]) : ?>
									<a href="<?= base_url('products/' . $productCategorys[$i]['prd_cid']) ?>" class="tt-promo-box tt-one-child hover-type-2">
										<img src="images/loader.svg" data-src="<?= base_url($catePath . $productCategorys[$i]['prd_cimage']) ?>" alt="">
										<div class="tt-description">
										</div>
									</a>
								<?php endif ?>
							<?php endfor ?>
						</div>
						<div class="col-6">
							<?php $i = 2 ?>
							<?php if (@$productCategorys[$i]) : ?>
								<a href="<?= base_url('products/' . $productCategorys[$i]['prd_cid']) ?>" class="tt-promo-box tt-one-child hover-type-2">
									<img src="images/loader.svg" data-src="<?= base_url($catePath . $productCategorys[$i]['prd_cimage']) ?>" alt="">
									<div class="tt-description">
									</div>
								</a>
							<?php endif ?>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-6">
					<div class="row">
						<div class="col-6">
							<?php $i = 3 ?>
							<?php if (@$productCategorys[$i]) : ?>
								<a href="<?= base_url('products/' . $productCategorys[$i]['prd_cid']) ?>" class="tt-promo-box tt-one-child hover-type-2">
									<img src="images/loader.svg" data-src="<?= base_url($catePath . $productCategorys[$i]['prd_cimage']) ?>" alt="">
									<div class="tt-description">
									</div>
								</a>
							<?php endif ?>
						</div>
						<div class="col-6">
							<?php $i = 4 ?>
							<?php if (@$productCategorys[$i]) : ?>
								<a href="<?= base_url('products/' . $productCategorys[$i]['prd_cid']) ?>" class="tt-promo-box tt-one-child hover-type-2">
									<img src="images/loader.svg" data-src="<?= base_url($catePath . $productCategorys[$i]['prd_cimage']) ?>" alt="">
									<div class="tt-description">
									</div>
								</a>
							<?php endif ?>
						</div>
						<div class="col-sm-12">
							<?php $i = 5 ?>
							<?php if (@$productCategorys[$i]) : ?>
								<a href="<?= base_url('products/' . $productCategorys[$i]['prd_cid']) ?>" class="tt-promo-box tt-one-child hover-type-2">
									<img src="images/loader.svg" data-src="<?= base_url($catePath . $productCategorys[$i]['prd_cimage']) ?>" alt="">
									<div class="tt-description">
									</div>
								</a>
							<?php endif ?>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>

	<div class="container-indent">
		<div class="container">
			<div class="row  tt-layout-promo-box">
				<div class="col-6 col-sm-6 col-md-3 time-box">
					<a href="#" class="tt-btn-info tt-layout-03">
						<div class="tt-title">
							<span>Fajr</span>
						</div>
						<div class="tt-title">
							<span>04:07</span>
						</div>
					</a>
				</div>

				<div class="col-6 col-sm-6 col-md-3 time-box">
					<a href="#" class="tt-btn-info tt-layout-03">
						<div class="tt-title">
							<span>Sunrise</span>
						</div>
						<div class="tt-title">
							<span>05:22</span>
						</div>
					</a>
				</div>

				<div class="col-6 col-sm-6 col-md-3 time-box">
					<a href="#" class="tt-btn-info tt-layout-03">
						<div class="tt-title">
							<span>Dhuhr</span>
						</div>
						<div class="tt-title">
							<span>11:40</span>
						</div>
					</a>
				</div>

				<div class="col-6 col-sm-6 col-md-3 time-box">
					<a href="#" class="tt-btn-info tt-layout-03">
						<div class="tt-title">
							<span>Asr</span>
						</div>
						<div class="tt-title">
							<span>14:57</span>
						</div>
					</a>
				</div>
			</div>
		</div>
	</div>


</div>