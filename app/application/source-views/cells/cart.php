<!-- cart -->
<?php if ($web_config['cart_status'] == 1 && $cset_active != 0): ?>
<?php
    switch ($iqr['theme_id'])
    {
        case 1: ?>

            <a href="<?=$cart_link?>" target='_self' data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>"><?=$cset_name?></a>
            
        <?  break;

        case 2: ?>

            <a class="aa01" href="<?=$cart_link?>" target='_self'><?=$cset_name?></a>

        <?  break;

        case 3: ?>

            <a class="aa02" href="<?=$cart_link?>" target='_self'><?=$cset_name?></a>

        <?  break;

        case 4: ?>

            <a class="aa02" href="<?=$cart_link?>" target='_self'><?=$cset_name?></a>

        <?  break;

        case 5: ?>

            <a href="#" class="aa04" id="icon04" onclick="javascript:window.location.href='<?=$cart_link?>';"><?=$cset_name?></a>

        <?  break;

        case 6: ?>

            <a class="aa02" href="<?=$cart_link?>" target='_self'><?=$cset_name?></a>

        <?  break;
    }
?>
<?php endif; ?>