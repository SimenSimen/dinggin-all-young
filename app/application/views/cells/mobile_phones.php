<!-- cpn_phone -->
<?php if ($mobile_phones_num || !empty($quote_data['mobile_phones']['value'])): ?>
<?php
    switch ($iqr['theme_id'])
    {
        case 1: ?>

            <?php if ($mobile_phones_num != 0): ?>
                <?php foreach ($mobile_phones as $key => $value): ?>
                    <a href="tel:<?=$value?>" data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>"><?=$mobile_phones_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['mobile_phones']['value'])): ?>
                <?php foreach ($quote_data['mobile_phones']['value'] as $key => $value): ?>
                    <a href="tel:<?=$value?>" data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>"><?=$quote_data['cpn_phone']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 2: ?>

            <?php if ($mobile_phones_num != 0): ?>
                <?php foreach ($mobile_phones as $key => $value): ?>
                    <a class="aa01" href="tel:<?=$value?>"><?=$mobile_phones_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['mobile_phones']['value'])): ?>
                <?php foreach ($quote_data['mobile_phones']['value'] as $key => $value): ?>
                    <a class="aa01" href="tel:<?=$value?>"><?=$quote_data['mobile_phones']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 3: ?>

            <?php if ($mobile_phones_num != 0): ?>
                <?php foreach ($mobile_phones as $key => $value): ?>
                    <a class="aa02" href="tel:<?=$value?>"><?=$mobile_phones_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['mobile_phones']['value'])): ?>
                <?php foreach ($quote_data['mobile_phones']['value'] as $key => $value): ?>
                    <a class="aa02" href="tel:<?=$value?>"><?=$quote_data['mobile_phones']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 4: ?>

            <?php if ($mobile_phones_num != 0): ?>
                <?php foreach ($mobile_phones as $key => $value): ?>
                    <a class="aa02" href="tel:<?=$value?>"><?=$mobile_phones_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['mobile_phones']['value'])): ?>
                <?php foreach ($quote_data['mobile_phones']['value'] as $key => $value): ?>
                    <a class="aa02" href="tel:<?=$value?>"><?=$quote_data['mobile_phones']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;

        case 5: ?>

            <?php if ($mobile_phones_num != 0): ?>
                <?php foreach ($mobile_phones as $key => $value): ?>
                    <a class="aa04" id="icon08" onclick="javascript:window.location.href='tel:<?=$value?>';"><?=$mobile_phones_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['mobile_phones']['value'])): ?>
                <?php foreach ($quote_data['mobile_phones']['value'] as $key => $value): ?>
                    <a class="aa04" id="icon08" onclick="javascript:window.location.href='tel:<?=$value?>';"><?=$quote_data['mobile_phones']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;

        case 6: ?>

            <?php if ($mobile_phones_num != 0): ?>
                <?php foreach ($mobile_phones as $key => $value): ?>
                    <a class="aa02" href="tel:<?=$value?>"><?=$mobile_phones_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['mobile_phones']['value'])): ?>
                <?php foreach ($quote_data['mobile_phones']['value'] as $key => $value): ?>
                    <a class="aa02" href="tel:<?=$value?>"><?=$quote_data['mobile_phones']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;
    }
?>
<?php endif; ?>