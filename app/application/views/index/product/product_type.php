<?foreach ($product_type1 as $value) {
	$prd_cid=$value->prd_cid;?>
	<? if (
			(!$value->is_hot && !$value->start_at && !$value->end_at) ||
				($value->is_hot && date('Y-m-d H:i:s') >= $value->start_at) && date('Y-m-d H:i:s') <= $value->end_at) { ?>
		<li>
			<a href="/products/<?=$prd_cid;?>">
				<?=$value->prd_cname;?>
			</a>
			<?foreach ($product_type2 as $type) {?>
				<?if($prd_cid==$type->PID){?>
					<ul>
				<? } ?>
				<?if($prd_cid==$type->PID){?>
					<li class="active"><a href="/products/<?=$type->prd_cid;?>"><?=$type->prd_cname;?></a></li>
				<?}?>
				<?if($prd_cid==$type->PID){?>
					</ul>
				<? } ?>
			<?}//endforeach?>
		</li>
	<? } ?>
<?}//endforeach?>