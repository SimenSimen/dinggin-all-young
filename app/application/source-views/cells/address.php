<!-- address -->
<?php if ($address_num != 0 || !empty($quote_data['address']['value'])): ?>
<?php
    switch ($iqr['theme_id'])
    {
        case 1: ?>

            <?php if ($address_num != 0): ?>
                <?php foreach ($address as $key => $value): ?>
                    <a href="https://maps.google.com.tw/maps?q=<?=$value?>" target='_self' data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>"><?=$address_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
            <?php if (!empty($quote_data['address']['value'])): ?>
                <?php foreach ($quote_data['address']['value'] as $key => $value): ?>
                    <a href="https://maps.google.com.tw/maps?q=<?=$value?>" target='_self' data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>"><?=$quote_data['address']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 2: ?>

            <?php if ($address_num != 0): ?>
                <?php foreach ($address as $key => $value): ?>
                    <a class="aa01" href="https://maps.google.com.tw/maps?q=<?=$value?>" target='_self'><?=$address_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['address']['value'])): ?>
                <?php foreach ($quote_data['address']['value'] as $key => $value): ?>
                    <a class="aa01" href="https://maps.google.com.tw/maps?q=<?=$value?>" target='_self'><?=$quote_data['address']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 3: ?>

            <?php if ($address_num != 0): ?>
                <?php foreach ($address as $key => $value): ?>
                    <a class="aa02" href="https://maps.google.com.tw/maps?q=<?=$value?>" target='_self'><?=$address_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['address']['value'])): ?>
                <?php foreach ($quote_data['address']['value'] as $key => $value): ?>
                    <a class="aa02" href="https://maps.google.com.tw/maps?q=<?=$value?>" target='_self'><?=$quote_data['address']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;

        case 4: ?>

            <?php if ($address_num != 0): ?>
                <?php foreach ($address as $key => $value): ?>
                    <a class="aa02" href="https://maps.google.com.tw/maps?q=<?=$value?>" target='_self'><?=$address_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['address']['value'])): ?>
                <?php foreach ($quote_data['address']['value'] as $key => $value): ?>
                    <a class="aa02" href="https://maps.google.com.tw/maps?q=<?=$value?>" target='_self'><?=$quote_data['address']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;

        case 5: ?>

            <?php if ($address_num != 0): ?>
                <?php foreach ($address as $key => $value): ?>
                    <a href="#" class="aa04" id="icon03" onclick="javascript:window.location.href='https://maps.google.com.tw/maps?q=<?=$value?>';"><?=$address_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['address']['value'])): ?>
                <?php foreach ($quote_data['address']['value'] as $key => $value): ?>
                    <a href="#" class="aa04" id="icon03" onclick="javascript:window.location.href='https://maps.google.com.tw/maps?q=<?=$value?>';"><?=$quote_data['address']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;

        case 6: ?>

            <?php if ($address_num != 0): ?>
                <?php foreach ($address as $key => $value): ?>
                    <a class="aa02" href="https://maps.google.com.tw/maps?q=<?=$value?>" target='_self'><?=$address_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['address']['value'])): ?>
                <?php foreach ($quote_data['address']['value'] as $key => $value): ?>
                    <a class="aa02" href="https://maps.google.com.tw/maps?q=<?=$value?>" target='_self'><?=$quote_data['address']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;
    }
?>
<?php endif; ?>