	<ul  style="display: none;">
		<li class="hover-on"><a href="/products/new_list"><?=$this->lang_menu['products_new'];//新品推薦?></a></li>
		<li class="hover-on"><a href="/products/hot_list"><?=$this->lang_menu['products_hot'];//好物精選?></a></li>
		<li class="hover-on"><a href="/products/prebuy_list">預購商品</a></li>
		<?foreach ($product_type1 as $value) {
			$prd_cid=$value->prd_cid;
			$sql3="SELECT `prd_cid`, `prd_cname`, `PID` FROM `product_class` where lang_type ='$this->setlang' and PID ='$prd_cid'";
			$query = $this->db->query($sql3);?>
			<li class="hover-on"><a href="/products/<?=$prd_cid;?>"><?=$value->prd_cname;?></a></li>
		<?}?>
	</ul>
</li>
