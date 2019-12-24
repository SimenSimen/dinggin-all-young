<!-- facebook -->
<?php if ($facebook_show || !empty($quote_data['facebook']['value'])): ?>
<?php
    switch ($iqr['theme_id'])
    {
        case 1: ?>

            <?php if ($facebook_show): ?>
                <a href="<?=$facebook?>" target='_top' data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>"><?=$facebook_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['facebook']['value'])): ?>
                <?php foreach ($quote_data['facebook']['value'] as $key => $value): ?>
                    <a href="<?=$value?>" target='_top' data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>"><?=$quote_data['facebook']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 2: ?>

            <?php if ($facebook_show): ?>
                <a class="aa01" href="<?=$facebook?>" target='_self'><?=$facebook_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['facebook']['value'])): ?>
                <?php foreach ($quote_data['facebook']['value'] as $key => $value): ?>
                    <a class="aa01" href="<?=$value?>" target='_self'><?=$quote_data['facebook']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 3: ?>

            <?php if ($facebook_show): ?>
                <a class="aa02" href="<?=$facebook?>" target='_self'><?=$facebook_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['facebook']['value'])): ?>
                <?php foreach ($quote_data['facebook']['value'] as $key => $value): ?>
                    <a class="aa02" href="<?=$value?>" target='_self'><?=$quote_data['facebook']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 4: ?>

            <?php if ($facebook_show): ?>
                <a class="aa02" href="<?=$facebook?>" target='_self'><?=$facebook_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['facebook']['value'])): ?>
                <?php foreach ($quote_data['facebook']['value'] as $key => $value): ?>
                    <a class="aa02" href="<?=$value?>" target='_self'><?=$quote_data['facebook']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 5: ?>

            <?php if ($facebook_show): ?>
                <a class="aa04-fb" onclick="javascript:window.location.href='<?=$facebook?>';" target='_self'><?=$facebook_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['facebook']['value'])): ?>
                <?php foreach ($quote_data['facebook']['value'] as $key => $value): ?>
                    <a class="aa04-fb" onclick="javascript:window.location.href='<?=$value?>';" target='_self'><?=$quote_data['facebook']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 6: ?>

            <?php if ($facebook_show): ?>
                <a class="aa02" href="<?=$facebook?>" target='_self'><?=$facebook_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['facebook']['value'])): ?>
                <?php foreach ($quote_data['facebook']['value'] as $key => $value): ?>
                    <a class="aa02" href="<?=$value?>" target='_self'><?=$quote_data['facebook']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;
    }
?>
<?php endif; ?>