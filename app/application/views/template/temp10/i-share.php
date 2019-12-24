<?php $this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. 'temp10' .DIRECTORY_SEPARATOR. 'temp10_css'); ?>
<body class="bg-style">
<header class="header"><a href="javascript:history.back();">&lt;</a>好友分享券</header>
<div class="wrapper">
<section class="content">
<div class="info-list">
    <ul>
      <li class="fader">
      	<?php if(!empty($list)): ?>
      		<?php foreach ($list as $key => $value): ?>
		        <a href="/views/d/<?=$aid?>/<?=$category_type?>/<?=$category_id?>/<?=$value['ecp_id']?>" class="set-title01">
			        <span class="list-img fix"><img src="<?=$img_url.$value['filename']?>"></span><!--fix讓不同長寬大小的圖片，截取中間-->
			        <span class="list-word"><?=$value['name']?></span>
		        </a>
		    <?php endforeach; ?>
	    <?php endif; ?>
      </li>
    </ul>
 </div>     
</section>
</div>