<?php $this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. 'temp10' .DIRECTORY_SEPARATOR. 'temp10_css'); ?>
<body class="bg-style">
<header class="header"><a href="javascript:history.back();">&lt;</a><?=$title?></header>
<div class="wrapper">
    <ul class="common-item-ul">
    	<li class="fader" ><a href="/views/d/<?=$aid?>/1/0" <?=$about_data?>><h2 class="set-title01"><?=$AboutGoldenbiotech?></h2></a></li>
        <li class="fader" ><a href="/views/d/<?=$aid?>/2/0" <?=$hot_data?>><h2 class="set-title01"><?=$HotNews?></h2></a></li>
        <?php if($is_login): ?>
        	<li class="fader"><a href="/views/d/<?=$aid?>/3/0"  <?=$HE_data?>><h2 class="set-title01"><?=$HEInformation?></h2></a></li>
        	<li class="fader"><a href="/views/d/<?=$aid?>/10/0" <?=$reviews_data?>><h2 class="set-title01"><?=$ReviewsList?></h2></a></li>
        <?php endif; ?>
   </ul>
</div>