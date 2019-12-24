<div id="con-R">
	<div id="preview_screen" style="position:relative">
          <div  class="coverdiv" id="coverdiv" style="position:absolute;width:262px;height:460px">
          </div>
		  
	  <!--預覽區    262x460    264x444-->
<!--	  <iframe id="preview_integrate" src="<?=$base_url?>business/iqr_preview/<?=$account?>" frameborder="0" width="262" height="460"></iframe>-->
		<iframe src="<?=$base_url?>business/iqr_preview/<?=$account?>" frameborder="0" width="262" height="460"></iframe>
	</div>
</div>
<script>
$(function() {
	$("div[id='coverdiv']").click(function(){
		window.open('/business/iqr/<?=$account?>', '', config='height=620,width=420,left=470');
//		window.location.href=$(this).attr("ref");
	});
});
</script>
