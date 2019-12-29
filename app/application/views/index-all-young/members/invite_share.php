<div id="tt-pageContent" class="main-content ">
    <div class="container-indent">
        <div class="container">

            <main class="main-content">
                <div class="container openside pall0">
                    <?php $this->load->view($indexViewPath . '/members/_sidenav'); ?>
                    <section class="content has-side">
                        <div class="title"><?= $this->lang['share_three_steps'] ?>Invitation Code Sharing</div>
                        <div class="invite-share">
                            <div class="code center">
                                <span><?= $this->lang['my_invitation_code'] ?><br>
                                    <font>
                                        <?php $url = base_url('register/' . base64_encode($_SESSION['AT']['d_account'])); ?>
                                        <?= $url ?>
                                    </font><br>
                                    <input type="button" id="GoURL" value="<?= $this->lang['invite_url'] ?>" onclick="location.href='<?= $url ?>'" class="btn simple en180">
                                    <input type="button" id="CopyURL" value="<?= $this->lang['copy_inivte_code'] ?>" onclick="copy_url('<?= $url ?>')" class="btn simple bg2 en180 b_green" onmousedown="this.style.backgroundColor='#884e64';this.style.border='#884e64';" onmouseup="this.style.backgroundColor='#d96893';this.style.border='#d96893';">
                                </span>
                            </div>
                            <div class="social-link">
                                <ul class="share-box list-h">
                                    <li><a href="javascript: void(window.open('https://www.facebook.com/share.php?u='.concat(encodeURIComponent('<?= $url ?>')) ));"><i><img src="<?= base_url('images/share_link/icon-fb.png') ?>" align="center"></i></a></li>
                                    <li><a href="javascript:(function(){window.open('https://v.t.sina.com.cn/share/share.php?title='+encodeURIComponent(document.title)+'&url='+encodeURIComponent('<?= $url ?>')+'&source=bookmark','_blank','width=450,height=400');"><i><img src="<?= base_url('images/share_link/icon-weibo.jpg') ?>" align="center"></i></a></li>
                                    <li><a href="javascript: void(window.open('https://www.plurk.com/?qualifier=shares&content='.concat(encodeURIComponent('<?= $url ?>')).concat(' ').concat('&#40;').concat(encodeURIComponent(document.title)).concat('&#41;')));"><i><img src="<?= base_url('images/share_link/icon-plurk.png') ?>" align="center"></i></a></li>
                                    <li><a href="javascript: void(window.open('https://twitter.com/home/?status='.concat(encodeURIComponent(document.title)) .concat(' ') .concat(encodeURIComponent('<?= $url ?>'))));"><i><img src="<?= base_url('images/share_link/icon-twitter.png') ?>" align="center"></i></a></li>
                                    <li><a href="javascript: void(window.open('https://line.naver.jp/R/msg/text/?'+encodeURIComponent(document.title)+' - '+encodeURIComponent('<?= $url ?>') ));"><i><img src="<?= base_url('images/share_link/icon-line.png') ?>" align="center"></i></a></li>
                                    <li><a href="javascript: void(window.open('whatsapp://send?text='+encodeURIComponent(document.title)+' - '+encodeURIComponent('<?= $url ?>') ));"><i><img src="<?= base_url('images/share_link/icon-wechat.png') ?>" align="center"></i></a></li>
                                    <li><a href="javascript: void(window.open('mailto:?subject='+encodeURIComponent(document.title)+'&body=網址：<br>'+encodeURIComponent('<?= $url ?>') ));"><i><img src="<?= base_url('images/share_link/icon-mail.png') ?>" align="center"></i></a></li>
                                </ul>
                            </div>
                            <div class="pagination_box">
                                <script src="/js/jqrcode/jquery.qrcode-0.7.0.js"></script>
                                <canvas id="qrcodeCanvas" width="240" height="240"></canvas>
                                <script>
                                    jQuery('#qrcodeCanvas').qrcode({
                                        width: 240,
                                        height: 240,
                                        text: "<?= $url; ?>"
                                    });
                                    var canvas = document.getElementById('qrcodeCanvas'),
                                        context = canvas.getContext('2d');
                                </script>
                                <br>

                                <a href="#" download="<?= $_SESSION['MT']['name'] ?>.png" onclick="this.href=canvas.toDataURL();"><b><?= $this->lang['qrcode_download'] ?></b></a> <br>
                            </div>
                        </div>
                    </section>

                </div>
            </main>


        </div>
    </div>
</div>