<div class="container">
	<aside class="side">
		<ul class="side-nav list-v">
			<li class="active"><a><?=$this->lang['p_type'];?></a></li>
			<li <?=($new_active=='Y')?' class="active"':'';?>><a href="/products/new_list"><?=$this->lang_menu['products_new'];//新品推薦?></a></li>
			<li <?=($hot_active=='Y')?' class="active"':'';?>><a href="/products/hot_list"><?=$this->lang_menu['products_hot'];//好物精選?></a></li>
			<li <?=($prebuyer_active=='Y')?' class="active"':'';?>><a href="/products/prebuy_list">預購商品</a></li>
			<?=stripslashes($this->product_type);?>
		</ul>
