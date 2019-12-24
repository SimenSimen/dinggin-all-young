<!-- text_edit02 -->
<?php if ($text_edit02_show): ?>
<?php
    switch ($iqr['theme_id'])
    {
        case 1: ?>

            <a href="<?=$base_url?>business/web/<?=$mid?>/2" target='_self' data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>"><?=$text_edit02_name?></a>

        <?  break;

        case 2: ?>

            <a class="aa01" href="<?=$base_url?>business/web/<?=$mid?>/2" target='_self'><?=$text_edit02_name?></a>

        <?  break;

        case 3: ?>

            <a class="aa02" href="<?=$base_url?>business/web/<?=$mid?>/2" target='_self'><?=$text_edit02_name?></a>

        <?  break;

        case 4: ?>

            <a class="aa02" href="<?=$base_url?>business/web/<?=$mid?>/2" target='_self'><?=$text_edit02_name?></a>

        <?  break;

        case 5: ?>

            <a onclick="javascript:window.location.href='<?=$base_url?>business/web/<?=$mid?>/2';" target='_self' id="icon11" class="aa04"><?=$text_edit02_name?></a>
    
        <?  break;

        case 6: ?>

            <a class="aa02" href="<?=$base_url?>business/web/<?=$mid?>/2" target='_self'><?=$text_edit02_name?></a>

        <?  break;
    }
?>
<?php endif; ?>