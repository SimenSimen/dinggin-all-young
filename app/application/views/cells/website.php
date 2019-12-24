<!-- website -->
<?php if ($website_num != 0 || !empty($quote_data['website']['value'])): ?>
<?php
    switch ($iqr['theme_id'])
    {
        case 1: ?>

            <?php if ($website_num != 0): ?>
                <?php foreach ($website as $key => $value): ?>
                    <a href="<?=$value?>" target='_self' data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>"><?=$website_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['website']['value'])): ?>
                <?php foreach ($quote_data['website']['value'] as $key => $value): ?>
                    <a href="<?=$value?>" target='_self' data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>"><?=$quote_data['website']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 2: ?>

            <?php if ($website_num != 0):?>
                <?php foreach ($website as $key => $value): ?>
                    <a class="aa01" href="<?=$value?>" target='_self'><?=$website_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
        
            <?php if (!empty($quote_data['website']['value'])): ?>
                <?php foreach ($quote_data['website']['value'] as $key => $value): ?>
                    <a class="aa01" href="<?=$value?>" target='_self'><?=$quote_data['website']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;

        case 3: ?>

            <?php if ($website_num != 0):?>
                <?php foreach ($website as $key => $value): ?>
                    <a class="aa02" href="<?=$value?>" target='_self'><?=$website_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
        
            <?php if (!empty($quote_data['website']['value'])): ?>
                <?php foreach ($quote_data['website']['value'] as $key => $value): ?>
                    <a class="aa02" href="<?=$value?>" target='_self'><?=$quote_data['website']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;

        case 4: ?>

            <?php if ($website_num != 0):?>
                <?php foreach ($website as $key => $value): ?>
                    <a class="aa02" href="<?=$value?>" target='_self'><?=$website_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
        
            <?php if (!empty($quote_data['website']['value'])): ?>
                <?php foreach ($quote_data['website']['value'] as $key => $value): ?>
                    <a class="aa02" href="<?=$value?>" target='_self'><?=$quote_data['website']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;

        case 5: ?>

            <?php if ($website_num != 0):?>
                <?php foreach ($website as $key => $value): ?>
                    <a href="#" class="aa04" id="icon04" onclick="javascript:window.location.href='<?=$value?>';"><?=$website_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
        
            <?php if (!empty($quote_data['website']['value'])): ?>
                <?php foreach ($quote_data['website']['value'] as $key => $value): ?>
                    <a href="#" class="aa04" id="icon04" onclick="javascript:window.location.href='<?=$value?>';"><?=$quote_data['website']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;

        case 6: ?>

            <?php if ($website_num != 0):?>
                <?php foreach ($website as $key => $value): ?>
                    <a class="aa02" href="<?=$value?>" target='_self'><?=$website_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
        
            <?php if (!empty($quote_data['website']['value'])): ?>
                <?php foreach ($quote_data['website']['value'] as $key => $value): ?>
                    <a class="aa02" href="<?=$value?>" target='_self'><?=$quote_data['website']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;
    }
?>
<?php endif; ?>