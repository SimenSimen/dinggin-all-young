<!-- mobile qrcode -->
<?php if ($mobile_show): ?>
<?php
    switch ($iqr['theme_id'])
    {
        case 1: ?>

            <a href="tel:<?=$iqr['mobile']?>" data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>"><?=$mobile_name?></a>

        <?  break;

        case 2: ?>

            <a class="aa01" href="tel:<?=$iqr['mobile']?>"><?=$mobile_name?></a>

        <?  break;

        case 3: ?>

            <a class="aa02" href="tel:<?=$iqr['mobile']?>"><?=$mobile_name?></a>

        <?  break;

        case 4: ?>

            <a class="aa02" href="tel:<?=$iqr['mobile']?>"><?=$mobile_name?></a>

        <?  break;

        case 5: ?>

            <a class="aa04" id="icon09" onclick="javascript:window.location.href='tel:<?=$iqr['mobile']?>';"><?=$mobile_name?></a>

        <?  break;

        case 6: ?>

            <a class="aa02" href="tel:<?=$iqr['mobile']?>"><?=$mobile_name?></a>

        <?  break;
    }
?>
<?php endif; ?>