<?php $this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. 'temp10' .DIRECTORY_SEPARATOR. 'temp10_css'); ?>
<body class="bg-style">
<header class="header"><a href="javascript:history.back();">&lt;</a><?=$title?></header>                 
<div class="wrapper">
    <div class="info-list">
        <ul>
        	<?php if(!empty($list)): ?>
        		<?php foreach ($list as $key => $value): ?>
          			<li class="fader"><a href="/views/d/<?=$aid?>/<?=$category_type?>/<?=$category_id?>/<?=$value['did']?>" class="set-title01"><?=$value['name']?></a></li>
          		<?php endforeach; ?>
          	<?php endif; ?>
        </ul>
     </div>     
</div>