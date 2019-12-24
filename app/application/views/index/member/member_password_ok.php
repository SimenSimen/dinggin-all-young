<!DOCTYPE html>
<html lang="zh-Hant-TW" class="no-js">
<head>
	<meta charset="UTF-8">
	<?php include('include_head.php'); ?>
	<title>聚彩源商城</title>
</head>
<body class="member">
	<?php include('include_preloader.php'); ?>
	<div class="wrapper">
		<header class="site-header">
			<?php include('include_header.php'); ?>
		</header>
		<?php include('include_banner.php'); ?>
		
		<main class="main-content wow fadeInUp" data-wow-delay="0.4s">
			<header class="main-top">
            <div class="container">
                <ol class="breadcrumb list-inline">
                    <li><a href="/products/index"><span>首頁</span></a></li>
                    <li><a href="/gold/member"><span>會員專區</span></a></li>
                    <li><a href="#"><span>忘記密碼</span></a></li>
                </ol>
            </div>
        	</header>
			<div class="container">
				<aside class="side">
					<?php include('member_nav.php'); ?>
					
                </aside>
				<section class="content has-side">
					<div class="title">忘記密碼</div>
					<div class="success-wrap">
                        <div class="success-box">
                            <div class="success-msg">您的密碼已送出，請至信箱查看</div>
                            <div class="success-txt">
                               
                                有任何問題，請使用 <a href="/gold/contact">聯絡我們</a> 留言，我們收到您的留言後，會盡快與您連絡。
                            </div>
                        </div>

                   
					<div class="pagination_box">
                        <a href="/products" class="btn simple bg2">回首頁 <i class="icon-chevron-right"></i></a>
                        <a href="/products" class="btn simple bg2">購物商城 <i class="icon-chevron-right"></i></a>
                    </div>
					
				</section>
			</div>
		</main>

		<footer>
			<?php include('include_footer.php'); ?>
		</footer>
	</div>
<?php include('include_body_bottom.php'); ?>

</body>
</html>

