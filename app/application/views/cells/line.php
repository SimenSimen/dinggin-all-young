<!-- line -->
<?php if ($line_show || !empty($quote_data['line']['value'])): ?>
<?php
    switch ($iqr['theme_id'])
    {
        case 1: ?>

            <?php if ($line_show): ?>
                <a href="<?=$line?>" target='_top' data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>"><?=$line_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['line']['value'])): ?>
                <?php foreach ($quote_data['line']['value'] as $key => $value): ?>
                    <a href="<?=$value?>" target='_top' data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>"><?=$quote_data['line']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 2: ?>

            <?php if ($line_show): ?>
                <a class="aa01" href="<?=$line?>" target='_self'><?=$line_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['line']['value'])): ?>
                <?php foreach ($quote_data['line']['value'] as $key => $value): ?>
                    <a class="aa01" href="<?=$value?>" target='_self'><?=$quote_data['line']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 3: ?>

            <?php if ($line_show): ?>
                <a class="aa02" href="<?=$line?>" target='_self'><?=$line_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['line']['value'])): ?>
                <?php foreach ($quote_data['line']['value'] as $key => $value): ?>
                    <a class="aa02" href="<?=$value?>" target='_self'><?=$quote_data['line']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;

        case 4: ?>

            <?php if ($line_show): ?>
                <a class="aa02" href="<?=$line?>" target='_self'><?=$line_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['line']['value'])): ?>
                <?php foreach ($quote_data['line']['value'] as $key => $value): ?>
                    <a class="aa02" href="<?=$value?>" target='_self'><?=$quote_data['line']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;

        case 5: ?>

            <?php if ($line_show): ?>
                <a class="aa04-line" onclick="javascript:window.location.href='<?=$line?>';"  target='_self'><?=$line_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['line']['value'])): ?>
                <?php foreach ($quote_data['line']['value'] as $key => $value): ?>
                    <a class="aa04-line" onclick="javascript:window.location.href='<?=$value?>';"  target='_self'><?=$quote_data['line']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 6: ?>

            <?php if ($line_show): ?>
                <a class="aa02" href="<?=$line?>" target='_self'><?=$line_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['line']['value'])): ?>
                <?php foreach ($quote_data['line']['value'] as $key => $value): ?>
                    <a class="aa02" href="<?=$value?>" target='_self'><?=$quote_data['line']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;
    }
?>
<?php endif; ?>