<?php $this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. 'temp10' .DIRECTORY_SEPARATOR. 'temp10_detail_css'); ?>

<body class="bg-style">
<header class="header"><a href="javascript:history.back();">&lt;</a><?=$dbdata['name']?></header>

<div class="wrapper">
<section class="content">
	<h2 class="content-title set-c-title"><?=$dbdata['name']?></h2>
    <div class="word-area set-c-word">
    <?=$dbdata['content']?>
    </div>
</section>
</div><!--/wrapper-->               
</body>
</html>