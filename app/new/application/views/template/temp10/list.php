<?php $this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. 'temp10' .DIRECTORY_SEPARATOR. 'temp10_css'); ?>
<body class="bg-style">
<header class="header"><a href="javascript:history.back();">&lt;</a><?=$title?></header>
<div class="wrapper">
    <ul class="common-item-ul">
    	<?php if(!empty($list)): ?>
    		<?php foreach ($list as $key => $value): ?>
    			<li class="fader"><a href="/views/d/<?=$aid?>/<?=$element?>/<?=$value['id']?>"><h2 class="set-title01"><?=$value['name']?></h2></a></li>
    		<?php endforeach; ?>
    	<?php endif; ?>
   </ul>
</div>