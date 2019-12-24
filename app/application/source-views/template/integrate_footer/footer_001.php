<div style="border:none;" data-role="footer">
    <div id="stickBottom">
        <ul class="itemFooter">
            <li><a rel="external" href="<?=$base_url.'company/news_list/'.$id?>"><i></i>資料庫</a></li>
            <li><a rel="external" href="<?=$base_url.'company/film_list/'.$id?>"><i></i>影片</a></li>
            <li><a rel="external" href="<?=$base_url.'company/picture_list/'.$id?>"><i></i>相簿</a></li>
            <?php if($store['cset_active'] == 1): ?><li><a rel="external" href="<?=$base_url.'cart/store/'.$store['cset_code']?>"><i></i><?=$store['cset_name']?></a></li><?php endif; ?>
            <li><a rel="external" href="<?=$base_url.'business/iqr/'.$id?>"><i></i>關於我</a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>
