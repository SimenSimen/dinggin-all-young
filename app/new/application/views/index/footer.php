        <footer>
            <div class="info_box">
				<div class="container">
					<div class="link">
						<ul class="list-v">
							<li><a href="/gold/about"><?=$this->lang_menu['about'];//關於聚彩源?></a></li>
							<li><a href="/gold/service"><?=$this->lang_menu['servicearea'];//服務專區?></a></li>
							<li><a href="/gold/media/C/video"><?=$this->lang_menu['movie'];//影音專區?></a></li>
							<li><a href="/gold/photo/C/photo"><?=$this->lang_menu['album'];//活動花絮?></a></li>
							<li><a href="/gold/archive/C/annex"><?=$this->lang_menu['download'];//文件下載?></a></li>
							<li><a href="/gold/member_announcement/service"><?=$this->lang_menu['member_announcement'];//會員權益公告?></a></li>
							<li><a href="/gold/announce"><?=$this->lang_menu['business_member_announcement'];//經營會員權益公告?></a></li>
							<li><a href="/gold/member_announcement/privacy"><?=$this->lang_menu['privacy'];//隱私權政策?></a></li>
						</ul>
					</div>
					<div class="map">
					<iframe width="100%" height="100" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src=http://maps.google.com.tw/maps?f=q&hl=zh-TW&geocode=&q=<?=$this->iqr_cart['cset_address'];?>&z=16&output=embed&t=></iframe>
					</div>
					<div class="info">
						E-mail : <a href="mailto:<?=$this->iqr_cart['cset_email'];?>"><?=$this->iqr_cart['cset_email'];?></a><br>
						Phone : <a href="tel:<?=$this->iqr_cart['cset_telphone'];?>"><?=$this->iqr_cart['cset_telphone'];?></a><br>
						FAX: <a href="tel:<?=$this->iqr_cart['cset_fax'];?>"><?=$this->iqr_cart['cset_fax'];?></a><br>
						<?=$this->iqr_cart['cset_address'];?><br>
					</div>
				</div>
			</div>
			<div class="copyright">
				<div class="container">
					Copyright © <?=$this->iqr_cart['cset_company'];?> All Rights Reserved.
				</div>
			</div>
        </footer>
    </div>
	<div class="floating top-hide">
		<a href="/cart" class="icart" title="<?=$this->lang_menu['cart'];//購物車?>"><i class="icon-shopping-cart"></i></a>
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
        <div class="site-title"><a href="/products/index" class="logo ibtn"><?=$this->lang_menu['jcymall'];//聚彩源商城?></a></div>
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
			<li><a href="/products"><?=$this->lang_menu['products'];//購物商城?></a>
				<ul><?=$this->product_type;?></ul>
			</li>
			<li><a href="/gold/contact"><?=$this->lang_menu['contact'];//與聚彩源對話?></a></li>
			<li><a href="/gold/register"><?=$this->lang_menu['register'];//加入我們?></a></li>
			<li><a href="/gold/link/C/link"><?=$this->lang_menu['link'];//友善連結?></a>
				<ul>
					<?php if(!empty($this->data['list_link'])): ?>
						<?php foreach ($this->data['list_link'] as $key => $value): ?>
							<li><a href="/gold/link/C/link/<?=$value['id']?>"><?=$value['name']?></a></li>
			    		<?php endforeach; ?>
			    	<?php endif; ?>
				</ul>
			</li>
			<li><a href="/gold/news/C/news"><?=$this->lang_menu['news'];//最新消息?></a>
				<ul>
					<?php if(!empty($this->data['list_news'])): ?>
						<?php foreach ($this->data['list_news'] as $key => $value): ?>
							<li><a href="/gold/news/C/news/<?=$value['id']?>"><?=$value['name']?></a></li>
			    		<?php endforeach; ?>
			    	<?php endif; ?>
				</ul>
			</li>
			<li><a href="/gold/activity/C/enroll"><?=$this->lang_menu['activity'];//活動與報名?></a>
				<ul>
					<?php if(!empty($this->data['list_enroll'])): ?>
						<?php foreach ($this->data['list_enroll'] as $key => $value): ?>
							<li><a href="/gold/activity/C/enroll/<?=$value['id']?>"><?=$value['name']?></a></li>
			    		<?php endforeach; ?>
			    	<?php endif; ?>
				</ul>
			</li>
			<li><a href="/gold/media/C/video"><?=$this->lang_menu['movie'];//影音專區?></a>
				<ul>
					<?php if(!empty($this->data['list_video'])): ?>
						<?php foreach ($this->data['list_video'] as $key => $value): ?>
							<li><a href="/gold/media/C/video/<?=$value['id']?>"><?=$value['name']?></a></li>
			    		<?php endforeach; ?>
			    	<?php endif; ?>
				</ul>
			</li>
			<li><a href="/gold/photo/C/photo"><?=$this->lang_menu['album'];//活動花絮?></a>
				<ul>
					<?php if(!empty($this->data['list_photo'])): ?>
						<?php foreach ($this->data['list_photo'] as $key => $value): ?>
							<li><a href="/gold/photo/C/photo/<?=$value['id']?>"><?=$value['name']?></a></li>
			    		<?php endforeach; ?>
			    	<?php endif; ?>
				</ul>
			</li>
			<li><a href="/gold/archive/c/annex"><?=$this->lang_menu['download'];//文件下載?></a>
				<ul>
					<?php if(!empty($this->data['list_annex'])): ?>
						<?php foreach ($this->data['list_annex'] as $key => $value): ?>
							<li><a href="/gold/archive/c/annex/<?=$value['id']?>"><?=$value['name']?></a></li>
			    		<?php endforeach; ?>
			    	<?php endif; ?>
				</ul>
			</li>
			<li><a href="/gold/about"><?=$this->lang_menu['about'];//關於聚彩源?></a>
				<ul>
					<li><a href="/gold/about"><?=$this->lang_menu['about'];//關於聚彩源?></a></li>
					<li><a href="/gold/service"><?=$this->lang_menu['servicearea'];//服務專區?></a></li>
					<li><a href="/gold/member_announcement/service"><?=$this->lang_menu['member_announcement'];//會員權益公告?></a></li>
					<li><a href="/gold/announce"><?=$this->lang_menu['business_member_announcement'];//經營會員權益公告?></a></li>
					<li><a href="/gold/member_announcement/privacy"><?=$this->lang_menu['privacy'];//隱私權政策?></a></li>
				</ul>
			</li>
			<li><a href="/gold/member"><?=$this->lang_menu['member'];//會員專區?></a>
				<ul>
					<?if($_SESSION['MT']['is_login']==1){?>
					<li><a href="#"><?=$_SESSION['MT']['name']?><?=$this->lang_menu['logged_in'];//已登入?></a></li>
					<?}else{?>
					<li><a href="/gold/login"><?=$this->lang_menu['login'];//會員登入?></a></li>
					<?}?>
                    <li><a href="/products"><?=$this->lang_menu['products'];//購物商城?></a></li>
                    <li><a href="/favorite"><?=$this->lang_menu['favorite'];//最愛商品?></a></li>
                    <li><a href="/order"><?=$this->lang_menu['order'];//個人訂單查詢?></a></li>
                    <li><a href="/bonus/dividend"><?=$this->lang_menu['dividend'];//紅利點數查詢?></a></li>
                    <li><a href="/gold/member_dividend_fun"><?=$this->lang_menu['member_dividend_fun'];//購物金查詢?></a></li>
                    <li><a href="/gold/member_info"><?=$this->lang_menu['member_info'];//基本資料?></a></li>
                    <li><a href="/gold/member_address"><?=$this->lang_menu['member_address'];//常用寄貨地址?></a></li>
                    <li><a href="/gold/member_announcement"><?=$this->lang_menu['member_announcement'];//會員權益公告?></a></li>
                    <li><a href="/gold/invite_share"></i><?=$this->lang_menu['invite_share'];//邀請碼分享?></a></li>
                    <li><a href="<?if($_SESSION['MT']['d_is_member']=="0")echo"/gold/member_upgrade";else{echo"javascript:";}?>"> <?=$this->lang_menu['member_upgrade'];//升級經營會員?>
                    	<?if($_SESSION['MT']['d_is_member']=="2")
                    		echo "(".$this->lang_menu['under_review'].")";//審核中
                    	?>
                    	<?if($_SESSION['MT']['d_is_member']=="1")
                    		echo "(".$this->lang_menu['under_review'].")";//已升級
                    	?>
                    	</a></li>
					<?if($_SESSION['MT']['d_is_member']=="1"){?>
                    <li><a href="/gold/member_active"><?=$this->lang_menu['member_active'];//活躍指標?></a></li>
                    <li><a href="/order/member_sale"><?=$this->lang_menu['member_sale'];//經營會員銷售訂單查詢?></a></li>
                    <li><a href="/gold/organization"><?=$this->lang_menu['organization'];//組織表?></a></li>
                    <li><a href="/gold/invoice"><?=$this->lang_menu['invoice'];//我要請款?></a></li>
                    <li><a href="/gold/member_bonus"><?=$this->lang_menu['member_bonus'];//佣金查詢?></a></li>
                    <li><a href="/gold/announce"><?=$this->lang_menu['business_member_announcement'];//經營會員權益公告?></a></li>
                    <?}?>
                    <?if($_SESSION['MT']['is_login']==1){?>
                    <li><a href="/gold/logout"><?=$this->lang_menu['logout'];//會員登出?></a></li>
                    <?}?>
				</ul>
			</li>
			<li><a href="#"><?=$this->lang_menu['choose_language'];//選擇語言?></a>
				<ul>
					<li><a href="javascript:void();" id="selectsortid_cn">簡体中文</a></li>
					<li><a href="javascript:void();" id="selectsortid_tw">繁體中文</a></li>
					<li><a href="javascript:void();" id="selectsortid_eng">English</a></li>
				</ul>
			</li>
		</ul>
    </div>
    <div class="share-menu">
    </div>
</div>
<script>
$("#selectsortid_tw").click(function () {
    $.ajax({
        type: "post",
        url: '/gold/setlang',
        cache: false,
        data: {
            lang: 'TW'
        },
        dataType: "text",
        success: function(response) {
            location.reload();
        }
    });   
});
$("#selectsortid_cn").click(function () {
    $.ajax({
        type: "post",
        url: '/gold/setlang',
        cache: false,
        data: {
            lang: 'CN'
        },
        dataType: "text",
        success: function(response) {
            location.reload();
        }
    });   
});
$("#selectsortid_eng").click(function () {
    $.ajax({
        type: "post",
        url: '/gold/setlang',
        cache: false,
        data: {
            lang: 'ENG'
        },
        dataType: "text",
        success: function(response) {
            location.reload();
        }
    });   
});
</script>
<script src="/js/jquery.scrollTo/jquery.scrollTo.min.js"></script>
<script src="/js/jquery.bxslider/jquery.bxslider.min.js"></script>
<script src="/js/WOW/dist/wow.min.js"></script>
<script src="/js/fancyBox/source/jquery.fancybox.pack.js"></script>
<script src="/js/slick/slick/slick.js"></script>

<script src="/js/basic.js"></script>
<script src="/js/main.js"></script>
<script>
	new WOW().init();
</script>
<script>
	$('.bxslider').bxSlider({
	  mode: 'fade',
	  captions: true,
	  auto: true,
	  stopAutoOnClick: true,
      stopAuto: false
	});
</script>
<script>
$(document).ready(function() {
    $('.fancybox-search').fancybox({
        margin: 5,
        padding: 0,
        width: '100%',
        maxWidth: 650,
        type: 'iframe',
        wrapCSS: 'search',
        helpers : {
            overlay : {
                css : {
                    'background' : 'rgba(0,0,0,0.8)'
                }
            }
        }
    });
});
</script>
</body>
</html>