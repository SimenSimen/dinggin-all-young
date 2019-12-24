<?php $this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. 'temp10' .DIRECTORY_SEPARATOR. 'temp10_detail_css'); ?>
<body class="bg-style">
  <header class="header"><a href="javascript:history.back();">&lt;</a><? //=$list['name']?></header>
  <?php $this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. 'temp10' .DIRECTORY_SEPARATOR. 'share_btn'); ?>
  <div class="wrapper">
    <section class="content">
    	<h2 class="content-title set-c-title"><?=$list['name']?></h2>
        <div class="word-area set-c-word"><?=$list['content']?></div>
        <? if(!empty($list['d_img'])):?>
          <div id="viewimg" style="text-align:center;"><img src="<? echo '/'.$list['d_img']?>" width='50%'></div>
        <? endif;?>
    </section>
  </div>
<!--分享彈出窗 JS-->
<script src="/template/temp10/js/baze.modal.js"></script>
<script>
  var elems = $('[data-baze-modal]');
  elems.bazeModal({
      onOpen: function() {
          alert('opened');
      },
      onClose: function() {
          alert('closed');
      }
  });
  $('#ngehe').bazeModal();
$(function() {
  $("#viewimg img").each(function() {//控制文字編輯器的圖不隨RWD變大變小的問題
    var width_txt=($(this).css("width")=="")?"":$(this).css("width");
    var height_txt=($(this).css("height")=="")?"":$(this).css("height");
    $(this).css({"width":"100%","height":"auto","max-width":width_txt,"max-height":height_txt});
    
  });
});
</script>
