		 <li><a href="<?=$base_url?>business/about/<?=$account?>">個人資料</a></li>
	<!--影片-->
	<?php if ($ytb_link_num != 0): ?>
		 <li><a href="<?=$base_url?>business/two_temp_list/<?=$account?>/P/film_list_8">影片</a></li>
	<?php endif; ?>
	<!--相本-->
	<?php if ($photo_show):?>
		 <li><a href="<?=$base_url?>business/two_temp_list/<?=$account?>/P/photo_list">相簿</a></li>
	<?php endif; ?>
	<!--分類-->
	<?php if(!empty($iqr_html_page)):?>
		 <li><a href="<?=$base_url?>business/two_temp_list/<?=$account?>/P/article_list">文章</a></li>
	<?php endif; ?>
	<!--表單-->
	<?php if ($uform_show): ?>
		 <li><a href="<?=$base_url?>business/two_temp_list/<?=$account?>/P/enroll_list">報名表單</a></li>
	<?php endif; ?>
	<!--網站-->
	<?php if ($website_num != 0): ?>
		 <li><a href="<?=$base_url?>business/two_temp_list/<?=$account?>/P/website_list">網路連結</a></li>
	<?php endif; ?>
	<!--附件-->
	<?php if ($exfile_show): ?>
		 <li><a href="<?=$base_url?>business/two_temp_list/<?=$account?>/P/annex_list">附件</a></li>
	<?php endif; ?>
	<!--好康分享 -->
	<?php if($ecp_show): ?>
<!--                                     <li><a href="<?=$base_url?>business/publicpage/coupon_list/<?=$account?>">好友分享券</a></li> -->
			 <li><a href="<?=$base_url?>business/two_temp_list/<?=$account?>/P/coupon_list">好友分享券</a></li>
	<?php endif; ?>
	<!--購物車 -->
	<?php if($store['cset_active'] == 1): ?><li><a href="<?=$base_url.'cart/store/'.$store['cset_code']?>"><?=$store['cset_name']?></a></li><?php endif; ?>
