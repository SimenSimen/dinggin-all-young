<script src='/js/myjava/page.js'></script>
<div id="pagination">
	<ul>
		<?php if($CurrectPage>1):?>
		<li><a href = "javascript:void(0);" onclick="changepage(1)">&lt;&lt; <?=isset($lang['FirstPage'])?$lang['FirstPage']:'第一頁'?></a></li>
		<li><a href="javascript:void(0);" onclick="changepage(<?=$CurrectPage-1?>)">&lt;<?=isset($lang['PrePage'])?$lang['PrePage']:'上一頁'?></a></li>
		<?php endif;?>
		<li>
		<?php if($TotalPage==0):?>
			<li><a href="javascript:void(0);" value="1" >1</a></li>
		<?php else:?>
			<?php //for($i=1;$i<=$TotalPage;$i++):?>
			<?php for($i=$PageToLink["pstar"];$i<=$PageToLink["pend"];$i++):?>
			<!-- <option value="<?php echo $i;?>" <?php if(($CurrectPage)==$i):?>selected<?php endif;?>><?php echo $i;?></option> -->
			<li><a href="javascript:void(0);" onclick="changepage(<?php echo $i;?>)"><?php echo $i;?></a></li>
		    <?php endfor;?>
		<?php endif;?>
		</select></li>
		<?php if($CurrectPage<$TotalPage):?>
		<li><a href="javascript:void(0);" onclick="changepage(<?=$CurrectPage+1?>)"><?=isset($lang['NextPage'])?$lang['NextPage']:'下一頁'?> &gt;</a></li>
		<li><a href="javascript:void(0);" onclick="changepage(<?=$TotalPage?>)" rel="<?php echo $TotalPage;?>"><?=isset($lang['LastPage'])?$lang['LastPage']:'最後一頁'?> &gt;&gt;</a></li>
		<?php endif;?>
		<li><?php echo $PageView; ?></li>
	</ul>
</div>
<style>
#pagination {
	float: right;
}

#pagination ul li {
	float: left;
	list-style-type: none;
	padding: 0px 5px;
}

#pagination ul li a {
	text-decoration: none;
	color: #757575;
}

#pagination ul .mark a {
	text-decoration: none;
	color: black;
	font-weight: bold;
}

</style>                                                                                                          