<?php $this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. 'temp10' .DIRECTORY_SEPARATOR. 'temp10_css'); ?>

<body class="bg-style">
<header class="header"><a href="javascript:history.back();">&lt;</a><?=$list['name']?></header>
<?php $this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. 'temp10' .DIRECTORY_SEPARATOR. 'share_btn'); ?>
<div class="wrapper">
      <section class="content">
        <h2 class="content-title set-c-title"><?=$list['name']?></h2>
        <div class="word-area share"><img src="<?=$f_path?><?=$list['filename']?>"></div>
     	  <?=$list['content']?>
        <!--分享-->
        <div class="btn-share" id="ngehe" data-target="#modal2"><a href="<?=$s_link?>"><?=$list['btn_name']?></a></div>
   </section>
</div><!--/wrapper-->               

<!--分享彈出窗 JS-->
<script src="js/baze.modal.js"></script> 
<script>
    var elems = $('[data-baze-modal]');
    elems.bazeModal({
    onOpen: function () {
    alert('opened');
    },
    onClose: function () {
    alert('closed');
    }
    });
    $('#ngehe').bazeModal();
</script>
