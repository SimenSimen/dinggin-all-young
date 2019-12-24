<?php $this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. 'temp10' .DIRECTORY_SEPARATOR. 'temp10_css'); ?>
<body class="bg-style">
<header class="header"><a href="javascript:history.back();">&lt;</a><?=$title?></header>                 
<div class="wrapper">
  <section class="content">
       <div class="annex-list">
        <ul>
			<?php if(!empty($list)): ?>
				<?php foreach ($list as $key => $value): ?>
          			<li><a href="<?=$value['path']?>" class="set-title01" download="<?=$value['name']?>"><?=$value['name']?></a></li>
          		<?php endforeach; ?>
          	<?php endif; ?>
        </ul>
     </div> 
 </section>                   
</div>