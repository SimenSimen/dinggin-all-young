<?php $this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. 'temp10' .DIRECTORY_SEPARATOR. 'temp10_css'); ?>
<body class="bg-style">
<header class="header"><a href="javascript:history.back();">&lt;</a><?=$title?></header>                 
<div class="wrapper">
 <section class="content">
    <div class="info-list">
        <ul>
          <?php if(!empty($list)): ?>
            <?php foreach ($list as $key => $value): ?>
              <li class="fader">
                <a href="/views/d/<?=$aid?>/<?=$element?>/<?=$value['id']?>" class="set-title01">
                  <span class="list-img fix"><img src="<?=$value['first_img']?>"></span><!--.fix讓不同長寬大小的圖片，截取中間-->
                  <span class="list-word"><?=$value['name']?></span>
                </a>
              </li>
            <?php endforeach; ?>
          <?php endif; ?>
        </ul>
     </div>     
</section>
</div>