<footer>
	<div class="info_box">
		<div class="container">
			<div style="width:20%;float:left;">
				<h3> <?=$this->lang['MemberCentre'];//會員中心?> </h3>
				<ul class="list-v">
					<li>
						<?if ($_SESSION['MT']['is_login'] != 1) {?>
							<a href="/gold/login" style="display:inline;"><i class="fa fa-caret-right" aria-hidden="true"></i> <?=$this->lang['Signin'];//登入?> </a> | 
							<a href="/gold/register" style="display:inline;"> <?=$this->lang['registered'];//註冊?> </a>
						<?}?>
					</li>
					<li><a href="/gold/member_announcement/announcement"><i class="fa fa-caret-right" aria-hidden="true"></i><?=$this->lang['announcement'];//會員權益公告?></a></li>
					<li><a href="/gold/member_announcement/service"><i class="fa fa-caret-right" aria-hidden="true"></i> <?=$this->lang['MemberTerms'];//會員條款?> </a></li>
					<li><a href="/gold/member_announcement/privacy"><i class="fa fa-caret-right" aria-hidden="true"></i> <?=$this->lang['privacy'];//隱私權政策?> </a></li>
				</ul>
			</div>
			<div style="width:20%;float:left;">
				<h3><?=$this->lang['contact'];//聯絡我們?></h3>
				<ul class="list-v">
					<li><a href="/gold/contact"><i class="fa fa-caret-right" aria-hidden="true"></i> <?=$this->lang['CustomerService'];//客服信箱?> </a></li>
					<li><a href="/gold/qa"><i class="fa fa-caret-right" aria-hidden="true"></i> <?=$this->lang['problem'];//常見問題?> </a></li>
					<?php if(!empty($_SESSION['MT'])){ ?>
						<li><a href="/providers/create"><i class="fa fa-caret-right" aria-hidden="true"></i> <?=$this->lang['provider_register'];//加入供應商?> </a></li>
						<li><a href="/providers/login"><i class="fa fa-caret-right" aria-hidden="true"></i> <?=$this->lang['SupplierLogin'];//供應商登入?> </a></li>
					<?php } ?>
				</ul>
			</div>
			<!-- <div style="width:30%;float:left;">
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3640.0554371050343!2d120.69976981498935!3d24.16978848438436!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x346917f072b7223b%3A0x979f55e6bb01e1ba!2zNDA25Y-w5Lit5biC5YyX5bGv5Y2A5p2x5bGx6Lev5LiA5q61NTAtMTjomZ8!5e0!3m2!1szh-TW!2stw!4v1562295135000!5m2!1szh-TW!2stw" frameborder="0" style="border:0;margin-top: 15px;width:90% !important;height:145px !important;" allowfullscreen></iframe>
			</div> -->
			<div style="width:30%;float:left;">
				<h3><?=$this->lang['Contactinfo'];//聯絡資訊?> </h3>
				E-mail : <a href="mailto:info@jcy.com" id="email"></a><br>
				Phone : <a href="tel:+88642223535" id="phone"></a><br>
				FAX: <a href="tel:+88642223536" id="fax"></a><br>
				<span id="address"></span><br>
			</div>
		</div>
	</div>
	<div class="copyright">
		<div class="container">
			Copyright ©
			<?=$this->lang_menu['jcymall'];//聚彩源商城?> All Rights Reserved.
		</div>
	</div>
</footer>
</div>
<div class="floating top-hide">
	<a href="/cart" class="icart" title="<?=$this->lang_menu['cart'];//購物車?>">
		<?php if(!empty($_SESSION['join_car'])){ ?>
		<span class='join_car_count' style="position: absolute;z-index: 99;font-size: 1.1em;color: #fff;margin: -25px 0 0 0.7em;background: #F00;padding: .4em;border-radius: 99px;box-shadow: 0 2px 2px rgba(0,0,0,.8);cursor: default;">
			<?=array_sum($_SESSION['join_car']);?></span>
		<?php } ?>
		<i class="icon-shopping-cart"></i></a>
	<a href="#" class="ibtn gotop" title="TOP">TOP</a>
</div>
<div id="mobile-fixed">
	<ul>
		<li><a href="body" class="btn toggle-mmenu toggleBtn" data-toggletag="mmenu-open"><i class="icon-menu"></i></a></li>
	</ul>
</div>
<a href="body" class="btn toggle-mmenu-cover toggleBtn" data-toggletag="mmenu-open"></a>
<div id="mobile-menu">
	<div class="language-menu">
		<div class="site-title"><a href="/products/index" class="logo ibtn">
				<?=$this->lang_menu['jcymall'];//聚彩源商城?></a></div>
		<div class="language">
			<a href="#" class="btn">EN</a>
			<ul class="list-inline">
				<li><a href="#">EN</a></li>
				<li><a href="#">繁中</a></li>
			</ul>
		</div>
		<a href="body" class="btn toggle-mmenu-close toggleBtn" data-toggletag="mmenu-open"><i class="icon-close"></i></a>
	</div>
	<div class="main-menu">
		<ul class="menu list-h">
			<? foreach ($this->mobile_link_list as $key => $value):?>
			<?if($value['d_lang']=="products"){?>
			<li><a href="<?=$value['d_link']?>">
					<?=$this->lang_menu[$value['d_lang']];?></a>
				<ul>
					<li><a href="/products/hot_list">
							<?=$this->lang_menu['products_hot'];//好物精選?></a></li>
					<?=$this->product_type;?>
				</ul>
			</li>
			<?}else if($value['d_lang']=="link"){?>
			<li><a href="<?=$value['d_link']?>">
					<?=$this->lang_menu[$value['d_lang']];?></a>
				<ul>
					<?php if(!empty($this->data['list_link'])): ?>
					<?php foreach ($this->data['list_link'] as $key => $value): ?>
					<li><a href="/gold/link/C/link/<?=$value['id']?>">
							<?=$value['name']?></a></li>
					<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</li>
			<?}else if($value['d_lang']=="news"){?>
			<li><a href="<?=$value['d_link']?>">
					<?=$this->lang_menu[$value['d_lang']];//農業關懷?></a>
				<ul>
					<?php if(!empty($this->data['list_news'])): ?>
					<?php foreach ($this->data['list_news'] as $key => $value): ?>
					<li><a href="/index/content/news/<?=$value['id']?>">
							<?=$value['name']?></a></li>
					<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</li>
			<?}else if($value['d_lang']=="aesthetic"){?>
			<li><a href="<?=$value['d_link']?>">
					<?=$this->lang_menu[$value['d_lang']];//美學生活?></a>
				<ul>
					<?php if(!empty($this->data['list_aesthetic'])): ?>
					<?php foreach ($this->data['list_aesthetic'] as $key => $value): ?>
					<li><a href="/index/content/aesthetic/<?=$value['id']?>">
							<?=$value['name']?></a></li>
					<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</li>
			<?}else if($value['d_lang']=="album"){?>
			<li><a href="<?=$value['d_link']?>">
					<?=$this->lang_menu[$value['d_lang']];//活動花絮?></a>
				<ul>
					<?php if(!empty($this->data['list_photo_type'])): ?>
					<?php foreach ($this->data['list_photo_type'] as $key => $value): ?>
					<li><a href="/index/photo/<?=$value['id']?>">
							<?=$value['name']?></a></li>
					<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</li>
			<?}else if($value['d_lang']=="about"){?>
			<li><a href="<?=$value['d_link']?>">
					<?=$this->lang_menu[$value['d_lang']];//關於聚彩源?></a>
				<ul>
					<?php if(!empty($this->mymodel->get_about_data($this->setlang))): ?>
					<?php foreach ($this->mymodel->get_about_data($this->setlang) as $key => $val): ?>
					<li><a href="/index/about/<?=$val['did']?>">
							<?=$val['name']?></a></li>
					<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</li>
			<?}else if($value['d_lang']=="member"){?>
			<li><a href="<?=$value['d_link']?>">
					<?=$this->lang_menu[$value['d_lang']];//會員專區?></a>
				<ul>
					<?if($_SESSION['MT']['is_login']==1){?>
					<li><a href="#">
							<?=$_SESSION['MT']['name']?>
							<?=$this->lang_menu['logged_in'];//已登入?></a></li>
					<li><a href="/products">
							<?=$this->lang_menu['products'];//購物商城?></a></li>
					<li><a href="/favorite">
							<?=$this->lang_menu['favorite'];//最愛商品?></a></li>
					<li><a href="/order">
							<?=$this->lang_menu['order'];//個人訂單查詢?></a></li>
					<li><a href="/bonus/dividend">
							<?=$this->lang_menu['dividend'];//紅利點數查詢?></a></li>
					<li><a href="/gold/member_dividend_fun">
							<?=$this->lang_menu['member_dividend_fun'];//購物金查詢?></a></li>
					<li><a href="/gold/member_info">
							<?=$this->lang_menu['member_info'];//基本資料?></a></li>
					<li><a href="/gold/member_address">
							<?=$this->lang_menu['member_address'];//常用寄貨地址?></a></li>
					<li><a href="<?if($_SESSION['MT']['d_is_member']==" 0")echo"/gold/member_upgrade";else{echo"javascript:";}?>"> <?=$this->lang_menu['member_upgrade'];//升級經營會員?>
							<?if($_SESSION['MT']['d_is_member']=="2")
                    				echo "(".$this->lang_menu['under_review'].")";//審核中
                    			?>
							<?if($_SESSION['MT']['d_is_member']=="1")
                    				echo "(".$this->lang_menu['upgraded'].")";//已升級
                    			?>
						</a></li>
					<?}else{?>
					<li><a href="/gold/login">
							<?=$this->lang_menu['login'];//會員登入?></a></li>
					<?}?>
					<?if($_SESSION['MT']['d_is_member']=="1"){?>
					<li><a href="/gold/invite_share">
							<?=$this->lang_menu['invite_share'];//邀請碼分享?></a></li>
					<li><a href="/order/member_sale">
							<?=$this->lang_menu['member_sale'];//經營會員銷售訂單查詢?></a></li>
					<li><a href="/gold/organization">
							<?=$this->lang_menu['organization'];//組織表?></a></li>
					<li><a href="/gold/invoice">
							<?=$this->lang_menu['invoice'];//我要請款?></a></li>
					<li><a href="/gold/invoice_list">
							<?=$this->lang_menu['invoice_list'];//請款記錄?></a></li>
					<li><a href="/gold/member_bonus">
							<?=$this->lang_menu['member_bonus'];//佣金查詢?></a></li>
					<li><a href="/gold/announce">
							<?=$this->lang_menu['business_member_announcement'];//經營會員權益公告?></a></li>
					<?}?>
					<?if($_SESSION['MT']['is_login']==1){?>
					<li><a href="/gold/logout">
							<?=$this->lang_menu['logout'];//會員登出?></a></li>
					<?}?>
				</ul>
			</li>
			<?}else if($value['d_lang']=="choose_language"){?>
			<li><a href="#">
					<?=$this->lang_menu[$value['d_lang']];//選擇語言?></a>
				<ul>
					<? foreach ($this->lang_list as $key => $value):?>
					<li><a href="javascript:void();" id="selectsortid_<?=$value['d_code']?>">
							<?=$value['d_title']?></a></li>
							<span style="display: none;" id="span_<?=$value['d_code']?>"><?=$value['d_code']?></span>
					<? endforeach;?>
				</ul>
			</li>
			<?}else{//單獨一項?>
			<li><a href="<?=$value['d_link']?>">
					<?=$this->lang_menu[$value['d_lang']];?></a></li>
			<?}?>
			<? endforeach;?>
		</ul>
	</div>
	<div class="share-menu">
	</div>
</div>


<script>
	<? foreach($this->lang_list as $key=>$value): ?>
		$("#selectsortid_<?=$value['d_code']?>").click(function() {
			$.ajax({
				type: "post",
				url: '/gold/setlang',
				cache: false,
				data: {
					lang: $("#span_<?=$value['d_code']?>").text()
				},
				dataType: "text",
				success: function(response) {
					location.reload();
				}
			});
		});
	<? endforeach; ?>

</script>

<script src="/js/jquery.scrollTo/jquery.scrollTo.min.js"></script>
<script src="/js/jquery.bxslider/jquery.bxslider.min.js"></script>
<script src="/js/WOW/dist/wow.min.js"></script>
<script src="/js/fancyBox/source/jquery.fancybox.pack.js"></script>
<script src="/js/slick/slick/slick.js"></script>
<script src="/js/basic.js"></script>
<script src="/js/main.js"></script>
<script src="/js/jquery.lazyload.js"></script>
<script>
	new WOW().init();
</script>
<script>
	$(function() {
		$("img.lazy").lazyload();
	});

	$('.bxslider').bxSlider({
		mode: 'fade',
		captions: true,
		auto: true,
		stopAutoOnClick: true,
		stopAuto: false
	});

</script>
<script type="text/javascript" src="https://cdn.vbtrax.com/javascripts/va.js"></script>
<script>
	VA.remoteLoad({
		whiteLabel: { id: 8, siteId: 1484, domain: 'vbtrax.com' },
		locale: "en-US", mkt: true
	});
</script>

<script>
	$.ajax({
		url: '/rule/get_contact',
		type: 'GET',
		dataType: 'JSON',
		success: (response) => {
			const contactInfo = response;
			const emailElement = document.getElementById('email');
			const phoneElement = document.getElementById('phone');
			const faxElement = document.getElementById('fax');

			emailElement.innerHTML = contactInfo.cset_email;
			emailElement.href = `mailto:${contactInfo.cset_email}`;

			phoneElement.innerHTML = contactInfo.cset_telphone;
			phoneElement.href = `tel:${contactInfo.cset_telphone}`;

			faxElement.innerHTML = contactInfo.cset_fax;
			faxElement.href = `tel:${contactInfo.cset_fax}`;

			document.getElementById('address').innerHTML = contactInfo.cset_address;
		}
	})
</script>
</body>
</html>
