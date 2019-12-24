<?php $this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. 'temp10' .DIRECTORY_SEPARATOR. 'temp10_detail_css'); ?>
<body class="bg-style">
    <header class="header"><a href="javascript:history.back();">&lt;</a><? //=$list['name']?></header>
    <?php $this -> load -> view(DIRECTORY_SEPARATOR. 'template' .DIRECTORY_SEPARATOR. 'temp10' .DIRECTORY_SEPARATOR. 'share_btn'); ?>
    
    <div class="wrapper">
        <section class="content">
            <h2 class="content-title set-c-title"><?=$list['name']?></h2>
            <section class="vedio-box">
                <div class="video-container">
                    <iframe src="http://www.youtube.com/embed/<?=$list['content']?>?rel=0&amp;autoplay=0" frameborder="0" allowfullscreen="" fs="1" scrolling="no"></iframe>
                </div>
            </section>
        </section>
    </div>
   
    <!-- 分享彈出窗 JS -->
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
    </script>
