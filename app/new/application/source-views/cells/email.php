<!-- email -->
<?php if ($email_show || !empty($quote_data['email']['value'])): ?>
<?php
    switch ($iqr['theme_id'])
    {
        case 1: ?>

            <?php if ($email_show): ?>
                <a href="mailto:<?=$iqr['email']?>" data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>"><?=$email_name?></a>
            <?php endif; ?>
            
            <?php if (!empty($quote_data['email']['value'])): ?>
                <?php foreach ($quote_data['email']['value'] as $key => $value): ?>
                    <a href="mailto:<?=$value?>" data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>"><?=$quote_data['email']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 2: ?>

            <?php if ($email_show): ?>
                <a class="aa01" href="mailto:<?=$iqr['email']?>"><?=$email_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['email']['value'])): ?>
                <?php foreach ($quote_data['email']['value'] as $key => $value): ?>
                    <a class="aa01" href="mailto:<?=$value?>"><?=$quote_data['email']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 3: ?>

            <?php if ($email_show): ?>
                <a class="aa02" href="mailto:<?=$iqr['email']?>"><?=$email_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['email']['value'])): ?>
                <?php foreach ($quote_data['email']['value'] as $key => $value): ?>
                    <a class="aa02" href="mailto:<?=$value?>"><?=$quote_data['email']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 4: ?>

            <?php if ($email_show): ?>
                <a class="aa02" href="mailto:<?=$iqr['email']?>"><?=$email_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['email']['value'])): ?>
                <?php foreach ($quote_data['email']['value'] as $key => $value): ?>
                    <a class="aa02" href="mailto:<?=$value?>"><?=$quote_data['email']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 5: ?>

            <?php if ($email_show): ?>
                <a class="aa04" id="icon06" onclick="javascript:window.location.href='mailto:<?=$iqr['email']?>';"><?=$email_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['email']['value'])): ?>
                <?php foreach ($quote_data['email']['value'] as $key => $value): ?>
                    <a class="aa04" id="icon06" onclick="javascript:window.location.href='mailto:<?=$value?>';"><?=$quote_data['email']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 6: ?>

            <?php if ($email_show): ?>
                <a class="aa02" href="mailto:<?=$iqr['email']?>"><?=$email_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['email']['value'])): ?>
                <?php foreach ($quote_data['email']['value'] as $key => $value): ?>
                    <a class="aa02" href="mailto:<?=$value?>"><?=$quote_data['email']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;
    }
?>
<?php endif; ?>
