	<link rel="stylesheet" type="text/css" href="/js/jquery-nice-select-1.1.0/nice-select.css">
	<link rel="stylesheet" href="/js/jquery-ui-1.12.1.custom/jquery-ui.css">
				<section class="content has-side">
					<div class="title">常見問題</div>
					<?php foreach($group as $key=>$val){ ?>
					<p><?=$key+1?>、<?=$val['qaag_name']?></p>
					<div id="accordion<?=$val['qaag_id']?>" class="accordion">
						<?php foreach($news as $val1){ ?>
						<?php if($val1['qaag_id']==$val['qaag_id']){ ?>
						<h3><?=$val1['qaa_title']?></h3>
						<div>
						  <?=$val1['qaa_content']?>
						</div>
						<?php } ?>
						<?php } ?>
					</div>
					<?php } ?>
				</section>
			</div>
		</main>
<script src="/js/jquery-nice-select-1.1.0/jquery.nice-select.min.js"></script>
<script src="/js/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script>
/*
    $(document).ready(function() {
        $('select').niceSelect();
    });
*/
	<?php foreach($group as $key=>$val){ ?>
	$( "#accordion<?=$val['qaag_id']?>" ).accordion({ header: "h3", collapsible: true, active: false, autoHeight: false });
	<?php } ?>
	$(".accordion div").css({ 'height': 'auto' });
</script>
