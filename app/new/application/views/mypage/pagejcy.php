<script src='/js/myjava/page.js'></script>
<? if($TotalRecord<>0) {?>
	<div class="pagination_box" id="pagination">
		<ul class="pagination">
			<?php if($CurrectPage>1):?>
			<!--<li><a href = "javascript:void(0);" onclick="changepage(1)">&lt;&lt; 第一頁</a></li>-->
			<li><a class="controls prev" href="javascript:void(0);" onclick="changepage(<?=$CurrectPage-1?>)"><i class="icon-chevron-left"></i></a></li>
			<?php endif;?>
			<li>
			<?php if($TotalPage==0):?>
				<li><a href="javascript:void(0);" value="1" >1</a></li>
			<?php else:?>
				<?php //for($i=1;$i<=$TotalPage;$i++):?>
				<?php for($i=$PageToLink["pstar"];$i<=$PageToLink["pend"];$i++):?>
				<!-- <option value="<?php echo $i;?>" <?php if(($CurrectPage)==$i):?>selected<?php endif;?>><?php echo $i;?></option> -->
				<li <? if($CurrectPage==$i){ ?>class="active"<?}?> ><a href="javascript:void(0);" onclick="changepage(<?php echo $i;?>)"><?php echo $i;?></a></li>
			    <?php endfor;?>
			<?php endif;?>
			</select></li>
			<?php if($CurrectPage<$TotalPage):?>
			<li><a class="controls next" href="javascript:void(0);" onclick="changepage(<?=$CurrectPage+1?>)"><i class="icon-chevron-right"></i></a></li>
			<!--<li><a href="javascript:void(0);" onclick="changepage(<?=$TotalPage?>)" rel="<?php echo $TotalPage;?>">最後一頁 &gt;&gt;</a></li>-->
			<?php endif;?>
		</ul>
	</div>
<?}else{
		echo $nototal;//無資料
	}?>                                                                                                    