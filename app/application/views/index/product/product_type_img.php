<div class="row row-horizon">
	<?foreach ($product_type1 as $value) {
		$prd_cid=$value->prd_cid;
		$prd_ty1=0;?>
		<li class="col-xs-4 col-sm-3 col-md-2 col-lg-2 flip_prd prd_cid<?=$prd_cid;?>" id="flip_prd" value="<?=$prd_cid;?>" ref="<?=$prd_cid;?>" style="background:#ffffff;border:0px;">			
			<a href="/products/<?=$prd_cid;?>">
				<figure></figure>
				<img style="height: 4.5em;display:block; margin:auto;" src="<?=$this->Spath_class;?><?=(!empty($value->prd_cimage))?'set_'.substr($value->prd_cimage,1):'nodata.jpg';?>">	
				<div class="name"><?=$value->prd_cname;?></div>
			</a>
			<? foreach ($product_type2 as $k=>$type) {?>
				<?if($prd_cid==$type->PID){?>
					<?if ($prd_ty1==0) {?><ul class="dis" style="display: none;"><?$prd_ty1++;}?>						
				<?}//end if?>
			<?}//end foreach?>
			<?if ($prd_ty1==1) {?></ul><?}?>
		</li>
	<?}//endforeach?>
</div>
	<?foreach ($product_type1 as $value) {
		$prd_cid=$value->prd_cid;
		$prd_ty1=0;?>
		<? foreach ($product_type2 as $k=>$type) {?>
			<?if($prd_cid==$type->PID){?>
				<?if ($prd_ty1==0) {?><div class="row row-horizon panel" id="panel<?=$prd_cid;?>"><?$prd_ty1++;}?>
					<li class="col-xs-3 col-sm-2 col-md-2 col-lg-2 circle" style="background:#ffffff;">
						<a href="/products/<?=$type->prd_cid;?>">
							<img style="height: 3em;display:block; margin:auto;" src="<?=$this->Spath_class;?><?=(!empty($type->prd_cimage))?'set_'.substr($type->prd_cimage,1):'nodata.jpg';?>">
							<div class="name"><?=$type->prd_cname;?></div>
						</a>
					</li>
			<?}//end if?>
		<?}//end foreach?>
		<?if ($prd_ty1==1) {?></div><?}?>
	<?}//endforeach?>
<!--橫幅選單-->
<link rel="stylesheet" type="text/css" href="/css/bootstrap-horizon.css" />
<!--展開收合-->
<style>
.panel{
		display:none;
	}
.dis{
        display:none !important;
    }
.name{    
    text-align: center;
}
.circle{
    border-radius:50%;
}
</style>
<script>
$(function(){
	$(".flip_prd").click(function(){
	var prd_cid =$(".prd_cid"+$(this).attr("ref")).val();
	var block = document.getElementById('panel'+prd_cid).style.display;
	if(block=='block'){
	    $('#panel'+prd_cid).slideToggle('3000');    
	}else{
	    $('.panel').attr("style","display:none;");
	    $('#panel'+prd_cid).slideToggle('3000');    
	    $('#panel'+prd_cid).attr("class","row row-horizon panel");
	}
  });
});
</script>