<!-- ecoupon -->
<?php if ($ecp_show || !empty($quote_data['ecoupon']['value'])): ?>
<?php
    switch ($iqr['theme_id'])
    {
        case 1: ?>

            <?php if ($ecp_show): ?>
                <?php foreach ($ecp_url as $key => $value): ?>
                    <a href="<?=$value?>" target='_self' data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>"><?=$ecp_url_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['ecoupon']['value'])): ?>
                <?php foreach ($quote_data['ecoupon']['value'] as $key => $value): ?>
                    <a href="<?=$value?>" target='_self' data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>"><?=$quote_data['ecoupon']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 2: ?>

            <?php if ($ecp_show): ?>
                <?php foreach ($ecp_url as $key => $value): ?>
                    <a class="aa01" href="<?=$value?>" target='_self'><?=$ecp_url_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['ecoupon']['value'])): ?>
                <?php foreach ($quote_data['ecoupon']['value'] as $key => $value): ?>
                    <a class="aa01" href="<?=$value?>" target='_self'><?=$quote_data['ecoupon']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 3: ?>

            <?php if ($ecp_show): ?>
                <?php foreach ($ecp_url as $key => $value): ?>
                    <a class="aa02" href="<?=$value?>" target='_self'><?=$ecp_url_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['ecoupon']['value'])): ?>
                <?php foreach ($quote_data['ecoupon']['value'] as $key => $value): ?>
                    <a class="aa02" href="<?=$value?>" target='_self'><?=$quote_data['ecoupon']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;

        case 4: ?>

            <?php if ($ecp_show): ?>
                <?php foreach ($ecp_url as $key => $value): ?>
                    <a class="aa02" href="<?=$value?>" target='_self'><?=$ecp_url_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['ecoupon']['value'])): ?>
                <?php foreach ($quote_data['ecoupon']['value'] as $key => $value): ?>
                    <a class="aa02" href="<?=$value?>" target='_self'><?=$quote_data['ecoupon']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;

        case 5: ?>

            <?php if ($ecp_show): ?>
                <?php foreach ($ecp_url as $key => $value): ?>
                    <a class="aa04" id="icon04" onclick="javascript:window.location.href='<?=$value?>';" target='_self'><?=$ecp_url_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['ecoupon']['value'])): ?>
                <?php foreach ($quote_data['ecoupon']['value'] as $key => $value): ?>
                    <a class="aa04" id="icon04" onclick="javascript:window.location.href='<?=$value?>';" target='_self'><?=$quote_data['ecoupon']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;

        case 6: ?>

            <?php if ($ecp_show): ?>
                <?php foreach ($ecp_url as $key => $value): ?>
                    <a class="aa02" href="<?=$value?>" target='_self'><?=$ecp_url_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['ecoupon']['value'])): ?>
                <?php foreach ($quote_data['ecoupon']['value'] as $key => $value): ?>
                    <a class="aa02" href="<?=$value?>" target='_self'><?=$quote_data['ecoupon']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;
    }
?>
<?php endif; ?>