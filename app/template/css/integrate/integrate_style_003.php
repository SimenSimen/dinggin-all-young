<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
    <!-- seo -->
    <title><?=$iqr_name?> 行動商務系統</title>
    <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
    <meta name="keywords"     content='行動商務系統'/>
    <meta name="description"  content=''/>
    <meta name="author"       content=''/>
    <meta name="copyright"    content=''/>


	<link type="text/css" rel="stylesheet" href="<?=$base_url?>template/temp3/css/header.css" />
		<link type="text/css" rel="stylesheet" href="<?=$base_url?>template/temp3/css/layout.css" />
		<script type="text/javascript" src="<?=$base_url?>template/temp3/js/jquery-1.9.0.min.js"></script>
        <link href="<?=$base_url?>template/temp3/css/font-awesome.min.css" rel="stylesheet">
        
        <!------左側欄-------->
        <link type="text/css" rel="stylesheet" href="<?=$base_url?>template/temp3/css/jquery.mmenu.all.css" />
		<script type="text/javascript" src="<?=$base_url?>template/temp3/js/jquery.mmenu.min.all.js"></script>
		<script type="text/javascript">
			$(function() {
				$('nav#menu').mmenu();
			});
		</script>
	</head>
    
	<body class="bg-style">
		<div id="page">
			<header class="header">
				<a href="#menu"></a>
				MENU
			</header>
			
            
			<nav id="menu">
				<ul>
					<li><a href="index.html">首頁</a></li>
					<li><a href="#mm-1" data-target="#mm-1" onclick="location.href='<?=$base_url?>business/about/<?=$account?>'"><i class="people-photo"><img src="<?=$base_url?>template/temp3/images/people-photo.jpg" width="400" height="400" align="center"></i><span class="m-about-me">關於我</span></a>
						<ul id="mm-1">
							<li><a href="i-about.html">個人資訊</a></li>
                            <li><a href="i-vedio.html">影片</a></li>	
                            <li><a href="i-photo.html">相簿</a></li>
                            <li><a href="i-article.html">文章</a></li>
                            <li><a href="i-enroll.html">報名表單</a></li>	
                            <li><a href="i-link.html">網路連結</a></li>
                            <li><a href="i-annex.html">附件</a></li>
                            <li><a href="i-share.html">好友分享券</a></li>
                            <li><a href="#">購物車</a></li>
						</ul>
					</li>
                    
					<li class="m-our-team"><i class="team-icon"><img src="<?=$base_url?>template/temp3/images/team-icon.png" align="center"></i>團隊情報<i class="fa fa-angle-down icon-down"></i></li>
                    
                    <li><a href="#">公司文章</a></li>
                    <li><a href="#">公司影片</a></li>
                    <li><a href="#">公司相簿</a></li>
                    <li><a href="#">公司表單</a></li>
                    <li><a href="#">公司附件</a></li>
                    <li><a href="#">網路連結</a></li>
                    <li><a href="#">好友分享券</a></li>
                    <li><a href="#">留言諮詢</a></li>
                    <li><a href="#">購物車</a></li>
				</ul>
			</nav>
            
          
            
                 <div class="wrapper">
                 
                        <section class="about-box">
                            <div class="about-me"> 
                               <div class="about-photo"><img src="<?=$base_url?>template/temp3/images/people-photo.jpg" width="400" height="400" align="center"></div>
                               <h1><?=$iqr_name?></h1><p>關於我</p>    
                            </div> 
                            
                           <div class="index-nav-menu">
                              <ul>
                                     
                                     <li><a href="#tabs-1" onclick="location.href='<?=$base_url?>business/about/<?=$account?>'">個人資料</a></li>
                                     <li><a href="i-vedio.html">影片</a></li>
                                     <li><a href="i-photo.html">相簿</a></li>
                                     <li><a href="i-article.html">文章</a></li>
                                     <li><a href="i-enroll.html">報名表單</a></li>
                                     <li><a href="i-link.html">網路連結</a></li>
                                     <li><a href="i-annex.html">附件</a></li>
                                     <li><a href="i-share.html">好友分享券</a></li>
                                     <li><a href="#">購物車</a></li>
                              </ul>                                                                          
                           </div>     
                        </section>       
                         
                          <section class="team-box"> 
                               <h1>團隊情報<i><img src="<?=$base_url?>template/temp3/images/team-icon.png" align="center"></i></h1>
                               <p class="line"></p>
                               <div class="index-nav-menu">
                                 <ul> 
                                   <li><a href="#">公司文章</a></li>
                                   <li><a href="#">公司影片</a></li>
                                   <li><a href="#">公司相簿</a></li>
                                   <li><a href="#">公司表單</a></li>
                                   <li><a href="#">公司附件</a></li>
                                   <li><a href="#">網路連結</a></li>
                                   <li><a href="#">好友分享券</a></li>
                                   <li><a href="#">留言諮詢</a></li>
                                   <li><a href="#">購物車</a></li>
                                   
                                 </ul>
                               </div>
                               
                          </section>
         
                </div><!--/wrapper-->
                  
          
            
            
	   </div><!--/page-->
  </body>
</html>