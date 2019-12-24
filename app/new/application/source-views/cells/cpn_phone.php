<!-- cpn_phone -->
<?php if ($cpn_phone_show || !empty($quote_data['cpn_phone']['value'])): ?>
<?php
    switch ($iqr['theme_id'])
    {
        case 1: ?>

            <?php if ($cpn_phone_show): ?>
                <a href="tel:<?=$iqr['cpn_phone']?><?=$cpn_extension?>" data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>"><?=$cpn_phone_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['cpn_phone']['value'])): ?>
                <?php foreach ($quote_data['cpn_phone']['value'] as $key => $value): ?>
                    <a href="tel:<?=$value?>" data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>"><?=$quote_data['cpn_phone']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 2: ?>

            <?php if ($cpn_phone_show): ?>
                <a class="aa01" href="tel:<?=$iqr['cpn_phone']?><?=$cpn_extension?>"><?=$cpn_phone_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['cpn_phone']['value'])): ?>
                <?php foreach ($quote_data['cpn_phone']['value'] as $key => $value): ?>
                    <a class="aa01" href="tel:<?=$value?>"><?=$quote_data['cpn_phone']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 3: ?>

            <?php if ($cpn_phone_show): ?>
                <a class="aa02" href="tel:<?=$iqr['cpn_phone']?><?=$cpn_extension?>"><?=$cpn_phone_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['cpn_phone']['value'])): ?>
                <?php foreach ($quote_data['cpn_phone']['value'] as $key => $value): ?>
                    <a class="aa02" href="tel:<?=$value?>"><?=$quote_data['cpn_phone']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 4: ?>

            <?php if ($cpn_phone_show): ?>
                <a class="aa02" href="tel:<?=$iqr['cpn_phone']?><?=$cpn_extension?>"><?=$cpn_phone_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['cpn_phone']['value'])): ?>
                <?php foreach ($quote_data['cpn_phone']['value'] as $key => $value): ?>
                    <a class="aa02" href="tel:<?=$value?>"><?=$quote_data['cpn_phone']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;

        case 5: ?>

            <?php if ($cpn_phone_show): ?>
                <a class="aa04" id="icon08" onclick="javascript:window.location.href='tel:<?=$iqr['cpn_phone']?><?=$cpn_extension?>';"><?=$cpn_phone_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['cpn_phone']['value'])): ?>
                <?php foreach ($quote_data['cpn_phone']['value'] as $key => $value): ?>
                    <a class="aa04" id="icon08" onclick="javascript:window.location.href='tel:<?=$value?>';"><?=$quote_data['cpn_phone']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;

        case 6: ?>

            <?php if ($cpn_phone_show): ?>
                <a class="aa02" href="tel:<?=$iqr['cpn_phone']?><?=$cpn_extension?>"><?=$cpn_phone_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['cpn_phone']['value'])): ?>
                <?php foreach ($quote_data['cpn_phone']['value'] as $key => $value): ?>
                    <a class="aa02" href="tel:<?=$value?>"><?=$quote_data['cpn_phone']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;
    }
?>
<?php endif; ?>