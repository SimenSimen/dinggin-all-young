<!-- skype -->
<?php if ($skype_show || !empty($quote_data['skype']['value'])): ?>
<?php
    switch ($iqr['theme_id'])
    {
        case 1: ?>

            <?php if ($skype_show): ?>
                <a href="skype:<?=$iqr['skype']?>" data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>"><?=$skype_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['skype']['value'])): ?>
                <?php foreach ($quote_data['skype']['value'] as $key => $value): ?>
                    <a href="skype:<?=$value?>" data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>"><?=$quote_data['skype']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 2: ?>

            <?php if ($skype_show): ?>
                <a class="aa01" href="skype:<?=$iqr['skype']?>"><?=$skype_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['skype']['value'])): ?>
                <?php foreach ($quote_data['skype']['value'] as $key => $value): ?>
                    <a class="aa01" href="skype:<?=$value?>"><?=$quote_data['skype']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 3: ?>

            <?php if ($skype_show): ?>
                <a class="aa02" href="skype:<?=$iqr['skype']?>"><?=$skype_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['skype']['value'])): ?>
                <?php foreach ($quote_data['skype']['value'] as $key => $value): ?>
                    <a class="aa01" href="skype:<?=$value?>"><?=$quote_data['skype']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 4: ?>

            <?php if ($skype_show): ?>
                <a class="aa02" href="skype:<?=$iqr['skype']?>"><?=$skype_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['skype']['value'])): ?>
                <?php foreach ($quote_data['skype']['value'] as $key => $value): ?>
                    <a class="aa02" href="skype:<?=$value?>"><?=$quote_data['skype']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 5: ?>

            <?php if ($skype_show): ?>
                <a class="aa04" id="icon09" onclick="javascript:window.location.href='skype:<?=$iqr['skype']?>';"><?=$skype_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['skype']['value'])): ?>
                <?php foreach ($quote_data['skype']['value'] as $key => $value): ?>
                    <a class="aa04" id="icon09" onclick="javascript:window.location.href='skype:<?=$value?>';"><?=$quote_data['skype']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 6: ?>

            <?php if ($skype_show): ?>
                <a class="aa02" href="skype:<?=$iqr['skype']?>"><?=$skype_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['skype']['value'])): ?>
                <?php foreach ($quote_data['skype']['value'] as $key => $value): ?>
                    <a class="aa02" href="skype:<?=$value?>"><?=$quote_data['skype']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;
    }
?>
<?php endif; ?>