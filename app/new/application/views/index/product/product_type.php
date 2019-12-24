<?foreach ($product_type1 as $value) {
	$prd_cid=$value->prd_cid;?>
	<li><a href="/products/<?=$prd_cid;?>"><?=$value->prd_cname;?></a>
		<?foreach ($product_type2 as $type) {?>
		<?if($prd_cid==$type->PID){?><ul><? } ?>
			<?if($prd_cid==$type->PID){?>
				<li class="active"><a href="/products/<?=$type->prd_cid;?>"><?=$type->prd_cname;?></a></li>
			<?}?>
			<?if($prd_cid==$type->PID){?></ul><? } ?>
		<?}//endforeach?>
	</li>
<?}//endforeach?>