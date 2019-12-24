<?php $this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. 'temp10' .DIRECTORY_SEPARATOR. 'temp10_css', $data); ?>
<body class="bg-style">
<header class="header"><a href="javascript:history.back();">&lt;</a><?=$title?></header>                 
 <div class="wrapper">
        <ul class="common-item-ul link-list">
			<?php if(!empty($list)): ?>
				<?php foreach ($list as $key => $value): ?>
	           		<li class="fader"><a href="<?=$value['content']?>"><h2 class="set-title01"><?=$value['name']?></h2></a></li>
	           	<?php endforeach; ?>
       		<?php endif; ?>
       </ul>                    
</div>