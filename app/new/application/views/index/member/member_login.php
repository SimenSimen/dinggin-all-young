<!DOCTYPE html>
<html lang="zh-Hant-TW" class="no-js">
<head>
	<meta charset="UTF-8">
	<?php include('include_head.php'); ?>
	<title>商城</title>
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
                    <li><a href="index.php"><span>首頁</span></a></li>
                    <li><a href="member.php"><span>會員專區</span></a></li>
                    <li><a href="#"><span>會員登入</span></a></li>
                </ol>
            </div>
        	</header>
			<div class="container">
				<aside class="side">
					<?php include('member_nav.php'); ?>
					
                </aside>
				<section class="content has-side">
					<div class="title">會員登入</div>
					
					<div class="editor mg">
					<div class="form-box">
							<div class="form-group">
	                            <div class="control-box">
	                            	<i class="icon-id"></i>
	                            	<label class="control-label">帳號</label>
	                                <input class="form-control" type="text" name="" id="">
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <div class="control-box">
	                            <i class="icon-lock"></i>
	                            <label class="control-label">密碼</label>
	                                <input class="form-control" type="password" name="" id="">
	                            </div>
	                        </div>
	                        <div class="form-group checbox">
		                        <input type="checkbox" name="checkbox" id="checkbox" />
	  							<label for="checkbox">記住帳密</label>
  							 </div>
	                        
                            <a href="member.php" class="btn normal send">登入</a>

                            <p align="center"><a href="member_register.php">註冊會員</a>  /  <a href="member_password.php">忘記密碼</a></p>

					</div>
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

