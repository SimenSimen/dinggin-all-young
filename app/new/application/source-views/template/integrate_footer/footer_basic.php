<!-- footer  -->
<div style="border:none;" data-role="footer">
    <div id="stickBottom" >
       <ul class="itemFooter">      
          <li><a rel="external" href="<?=$base_url.'business/iqr/'.$id?>" style="font-weight:inherit;"><i></i>關於我</a></li>
         <li><a rel="external"  href="<?=$base_url.'company/news_list/'.$id?>"><i></i>資訊</a></li>
          <li><a rel="external" href="<?=$base_url.'company/film_list/'.$id?>"><i></i>影片</a></li>
          <li><a rel="external" href="<?=$base_url.'company/activity_list/'.$id?>"><i></i>活動</a></li>
          <li><a rel="external" href="<?=$base_url.'company/picture_list/'.$id?>"><i></i>照片</a></li>
          <?php if($store['cset_active'] == 1): ?><li><a rel="external" href="<?=$base_url.'cart/store/'.$store['cset_code']?>"><i></i><?=$store['cset_name']?></a></li><?php endif; ?>
       </ul>
    <div class="clear"></div>
    </div>
</div>