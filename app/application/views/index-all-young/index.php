
<div id="tt-pageContent">
	<div class="container-indent nomargin">
		<div class="container-fluid">
			<div class="row">
				<div class="slider-revolution revolution-default">
					<div class="tp-banner-container">
						<div class="tp-banner revolution">
							<ul>
								<li data-thumb="images/slides/14/slide-01.jpg" data-transition="fade" data-slotamount="1" data-masterspeed="1000" data-saveperformance="off"  data-title="Slide">
									<img src="images/slides/14/slide-01.jpg"  alt="slide1"  data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" >
									<div class="tp-caption tp-caption1 lft stb"
										data-x="center"
										data-y="center"
										data-hoffset="0"
										data-voffset="0"
										data-speed="600"
										data-start="900"
										data-easing="Power4.easeOut"
										data-endeasing="Power4.easeIn">
										<div class="tp-caption1-wd-1 tt-white-color">Ready To</div>
										<div class="tp-caption1-wd-2 tt-white-color">Use Unique<br>Demos</div>
										<div class="tp-caption1-wd-3">Optimized for speed, website that sells</div>
										<div class="tp-caption1-wd-4"><a href="listing-left-column.html" class="btn btn-dark btn-xl" data-text="SHOP NOW!">SHOP NOW!</a></div>
									</div>
								</li>
								<li data-thumb="images/slides/14/slide-02.jpg" data-transition="fade" data-slotamount="1" data-masterspeed="1000" data-saveperformance="off"  data-title="Slide">
									<img src="images/slides/14/slide-02.jpg"  alt="slide1"  data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" >
									<div class="tp-caption tp-caption1 lft stb"
										data-x="center"
										data-y="center"
										data-hoffset="0"
										data-voffset="0"
										data-speed="600"
										data-start="900"
										data-easing="Power4.easeOut"
										data-endeasing="Power4.easeIn">
										<div class="tp-caption1-wd-1 tt-base-color">Multipurpose</div>
										<div class="tp-caption1-wd-2">Premium<br>Html Template</div>
										<div class="tp-caption1-wd-3">30 skins, powerful features, great support, exclusive offer</div>
										<div class="tp-caption1-wd-4"><a href="listing-left-column.html" class="btn btn-xl" data-text="SHOP NOW!">SHOP NOW!</a></div>
									</div>
								</li>
								<li data-thumb="video/video_img.jpg" data-transition="fade" data-slotamount="1" data-masterspeed="1000" data-saveperformance="off"  data-title="Slide">
									<img src="video/blank.png"  alt="slide1"  data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" >
									<!-- LAYER NR. 1 -->
									<div class="tp-caption tp-fade fadeout fullscreenvideo"
										data-x="0"
										data-y="0"
										data-speed="600"
										data-start="0"
										data-easing="Power4.easeOut"
										data-endspeed="1500"
										data-endeasing="Power4.easeIn"
										data-autoplay="true"
										data-autoplayonlyfirsttime="false"
										data-nextslideatend="true"
										data-forceCover="1"
										data-dottedoverlay="twoxtwo"
										data-aspectratio="16:9">
										<video class="video-js vjs-default-skin" preload="none"
											poster='video/video_img.jpg' data-setup="{}">
											<source src='video/video.mp4' type='video/mp4'>
										</video>
									</div>
									<div class="tp-caption  tp-fade"
										data-x="right"
										data-y="bottom"
										data-voffset="-60"
										data-hoffset="-90"
										data-speed="600"
										data-start="900"
										data-easing="Power4.easeOut"
										data-endeasing="Power4.easeIn">
										<div class="video-play">
											<a class="icon-f-29 btn-play" href="#"></a>
											<a class="icon-f-28 btn-pause" href="#"></a>
										</div>
									</div>
									<!-- TEXT -->
									<div class="tp-caption lfb lft text-center"
										data-x="center"
										data-y="center"
										data-voffset="-20"
										data-hoffset="0"
										data-speed="600"
										data-start="900"
										data-easing="Power4.easeOut"
										data-endeasing="Power4.easeIn">
										<div class="tp-caption1-wd-1 tt-base-color">Oberlo</div>
										<div class="tp-caption1-wd-2 tt-white-color">Find Products for<br>Shop Store</div>
										<div class="tp-caption1-wd-3 tt-white-color">Oberlo allows you to easily import dropshipped products directly into your ecommerce store</div>
										<div class="tp-caption1-wd-4"><a href="listing-left-column.html" class="btn btn-xl" data-text="SHOP NOW!">SHOP NOW!</a></div>
									</div>
								</li>
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
				<h1 class="tt-title"><?= lang('newProduct')?></h1>
				<!-- <div class="tt-description">New Arrival</div> -->
			</div>
			<div class="tt-carousel-products row arrow-location-tab arrow-location-tab01 tt-alignment-img tt-collection-listing mt0 ">
				<?php foreach($newProducts as $index => $product) { ?>
				<div class="col-6 col-md-4 col-lg-3">
					<div class="tt-product thumbprod-center">
						<div class="tt-image-box">
							<a href="#" class="tt-btn-quickview" data-toggle="modal" data-target="#ModalquickView"	data-tooltip="Quick View" data-tposition="left"></a>
							<a href="#" class="tt-btn-wishlist" data-tooltip="Add to Wishlist" data-tposition="left"></a>
							<a href="#" class="tt-btn-compare" data-tooltip="Add to Compare" data-tposition="left"></a>
							<a href="product.html">
								<span class="tt-img"><img src="<?= base_url('images/loader.svg')?>" data-src="<?= base_url($product['prd_image'])?>" alt=""></span>
								<span class="tt-img-roll-over"><img src="<?= base_url('images/loader.svg')?>" data-src="<?= base_url($product['prd_image'])?>" alt=""></span>
							</a>
						</div>
						<div class="tt-description">
							<h2 class="tt-title"><a href="product.html"><?= $product['prd_name'] ?></a></h2>
							<div class="tt-price">
								<span class="new-price">NT$<?= $product['prd_price00']?></span>
								<span class="old-price">NT$<?= $product['prd_price01']?></span>
							</div>
							<div class="tt-product-inside-hover">
								<div class="tt-row-btn">
									<a href="#" class="tt-btn-addtocart thumbprod-button-bg" data-toggle="modal" data-target="#modalAddToCartProduct"><?= lang('ADD_TO_CARD')?></a>
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
				<?php }?>
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

				<?//會員未登入顯示?>
				<div class="col-6 col-sm-6 col-md-6 bonus-box">
					<a href="#" class="tt-btn-info tt-layout-03">
						<div class="tt-title">
							<i class="icon-h-59"></i>
							<span>Bonus Points</span>
						</div>
						<div class="tt-title02">Inquire Now</div>
					</a>
				</div>

				<div class="col-6 col-sm-6 col-md-6 bonus-box">
					<a href="#" class="tt-btn-info tt-layout-03">
						<div class="tt-title">
							<i class="icon-e-47"></i>
							<span>Bonus</span>
						</div>
						<div class="tt-title02">Inquire Now</div>
					</a>
				</div>

				<?//一般會員登入顯示?>
				<div class="col-6 col-sm-6 col-md-6 bonus-box">
					<a href="#" class="tt-btn-info tt-layout-03">
						<div class="tt-title">
							<i class="icon-h-59"></i>
							<span>Bonus Points</span>
						</div>
						<div class="tt-title02 c_green">1,000 Point</div>
					</a>
				</div>

				<div class="col-6 col-sm-6 col-md-6 bonus-box">
					<a href="#" class="tt-btn-info tt-layout-03">
						<div class="tt-title">
							<i class="icon-e-47"></i>
							<span>Bonus</span>
						</div>
						<div class="tt-title02">How to Get a Bonus?</div>
					</a>
				</div>

				<?//經營會員登入顯示?>
				<div class="col-6 col-sm-6 col-md-6 bonus-box">
					<a href="#" class="tt-btn-info tt-layout-03">
						<div class="tt-title">
							<i class="icon-h-59"></i>
							<span>Bonus Points</span>
						</div>
						<div class="tt-title02">1,000 Point</div>
					</a>
				</div>

				<div class="col-6 col-sm-6 col-md-6 bonus-box">
					<a href="#" class="tt-btn-info tt-layout-03">
						<div class="tt-title">
							<i class="icon-e-47"></i>
							<span>Bonus</span>
						</div>
						<div class="tt-title02">rp 250,000</div>
					</a>
				</div>
				
			</div>
		</div>
	</div>


	<div class="container-indent">
		<div class="container">
			<div class="tt-block-title">
				<h4 class="tt-title"><?= lang('brand')?></h4>
			</div>
			<div class="row">
				<div class="col-sm-12 col-6_end-inrow-lg">
					<div class="tt-carousel-products row arrow-location-center-03 index-arrow tt-alignment-img tt-product-listing slick-animated-show-js">
						
						<div class="col-6 col-sm-4 col-md-2">
							<a href="#" class="tt-btn-info tt-layout-03">
								<img src="images/custom/brand-img-08.png" alt="">
							</a>
						</div>
						<div class="col-6 col-sm-4 col-md-2">
							<a href="#" class="tt-btn-info tt-layout-03">
								<img src="images/custom/brand-img-07.png" alt="">
							</a>
						</div>	
						<div class="col-6 col-sm-4 col-md-2">
							<a href="#" class="tt-btn-info tt-layout-03">
								<img src="images/custom/brand-img-06.png" alt="">
							</a>
						</div>	
						<div class="col-6 col-sm-4 col-md-2">
							<a href="#" class="tt-btn-info tt-layout-03">
								<img src="images/custom/brand-img-05.png" alt="">
							</a>
						</div>	
						<div class="col-6 col-sm-4 col-md-2">
							<a href="#" class="tt-btn-info tt-layout-03">
								<img src="images/custom/brand-img-04.png" alt="">
							</a>
						</div>	
						<div class="col-6 col-sm-4 col-md-2">
							<a href="#" class="tt-btn-info tt-layout-03">
								<img src="images/custom/brand-img-03.png" alt="">
							</a>
						</div>				
					</div>


				</div>


			</div>


		</div>
	</div>



	<div class="container-indent">
		<div class="container container-fluid-custom-mobile-padding">
			<div class="tt-block-title">
				<h2 class="tt-title"><?= lang('productCate')?></h2>
			</div>						
					
			<div class="row tt-layout-promo-box">
				<div class="col-sm-12 col-md-6">
					<div class="row">
						<div class="col-6">
							<a href="listing-left-column.html" class="tt-promo-box tt-one-child hover-type-2">
								<img src="images/loader.svg" data-src="images/promo/index-promo-img-01.jpg" alt="">
								<div class="tt-description">									
								</div>
							</a>
							<a href="listing-left-column.html" class="tt-promo-box tt-one-child hover-type-2">
								<img src="images/loader.svg" data-src="images/promo/index-promo-img-02.jpg" alt="">
								<div class="tt-description">
								</div>
							</a>
						</div>
						<div class="col-6">
							<a href="listing-left-column.html" class="tt-promo-box tt-one-child hover-type-2">
								<img src="images/loader.svg" data-src="images/promo/index-promo-img-03.jpg" alt="">
								<div class="tt-description">
								</div>
							</a>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-6">
					<div class="row">
						<div class="col-6">
							<a href="listing-left-column.html" class="tt-promo-box tt-one-child hover-type-2">
								<img src="images/loader.svg" data-src="images/promo/index-promo-img-04.jpg" alt="">
								<div class="tt-description">
								</div>
							</a>
						</div>
						<div class="col-6">
							<a href="listing-left-column.html" class="tt-promo-box tt-one-child hover-type-2">
								<img src="images/loader.svg" data-src="images/promo/index-promo-img-05.jpg" alt="">
								<div class="tt-description">
								</div>
							</a>
						</div>
						<div class="col-sm-12">
							<a href="listing-left-column.html" class="tt-promo-box tt-one-child">
								<img src="images/loader.svg" data-src="images/promo/index-promo-img-06.jpg" alt="">
								<div class="tt-description">
								</div>
							</a>
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