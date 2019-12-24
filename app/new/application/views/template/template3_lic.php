	<li><a href="<?=$base_url?>business/two_temp_list/<?=$account?>/C/article_list">公司文章</a></li>
	<li><a href="<?=$base_url?>business/two_temp_list/<?=$account?>/C/film_list_8">公司影片</a></li>

<?php if ($mother_photo_show){ ?>
	<li><a href="<?=$base_url?>business/two_temp_list/<?=$account?>/C/photo_list">公司相簿</a></li>
<? } ?>

<?php if ($mother_uform_show){ ?>
	<li><a href="<?=$base_url?>business/two_temp_list/<?=$account?>/C/enroll_list">公司表單</a></li>
<?}//php if ($mother_uform_show): ?>

	<li><a href="<?=$base_url?>business/two_temp_list/<?=$account?>/C/annex_list">公司附件</a></li>
	<li><a href="<?=$base_url?>business/two_temp_list/<?=$account?>/C/website_list">網路連結</a></li>

<?php if($mother_ecp_show){ ?>
	<li><a href="<?=$base_url?>business/two_temp_list/<?=$account?>/C/coupon_list/">好友分享券</a></li>
<?}//php if($ecp_show): ?>

	<li><a href="#">留言諮詢</a></li>

<?php if($store['cset_active'] == 1){ ?>
	<li><a href="<?=$base_url.'cart/store/'.$mother_cset_code?>">購物車</a></li>
<?}//php if($store['cset_active'] == 1){ ?>
