<!-- footer  -->
<div style="border:none;" data-role="footer">
    <div id="stickBottom" >
       <ul class="itemFooter">      
          <li><a rel="external" href="<?=$base_url.'business/iqr/'.$id?>" style="font-weight:inherit;"><i></i><?=$AboutMe?></a></li>
         <li><a rel="external"  href="<?=$base_url.'company/news_list/'.$id?>"><i></i><?=$Information?></a></li>
          <li><a rel="external" href="<?=$base_url.'company/film_list/'.$id?>"><i></i><?=$Film?></a></li>
          <li><a rel="external" href="<?=$base_url.'company/activity_list/'.$id?>"><i></i><?=$Activity?></a></li>
          <li><a rel="external" href="<?=$base_url.'company/picture_list/'.$id?>"><i></i><?=$Photo?></a></li>
          <?php if($store['cset_active'] == 1): ?><li><a rel="external" href="<?=$base_url.'cart/store/'.$store['cset_code']?>"><i></i><?=$store['cset_name']?></a></li><?php endif; ?>
       </ul>
    <div class="clear"></div>
    </div>
</div>