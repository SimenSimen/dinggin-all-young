<!-- uform -->
<?php if ($uform_show || !empty($quote_data['uform']['value'])): ?>
<?php
    switch ($iqr['theme_id'])
    {
        case 1: ?>

            <?php if ($uform_show): ?>
                <?php foreach ($ufm_id as $key => $value): ?>
                    <a href="<?=$base_url?>form/index/<?=$value?>/<?=$mid?>" target='_self' data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>"><?=$ufm_btn_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['uform']['value'])): ?>
                <?php foreach ($quote_data['uform']['value'] as $key => $value): ?>
                    <a href="<?=$value?>" target='_self' data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>"><?=$quote_data['uform']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 2: ?>

            <?php if ($uform_show): ?>
                <?php foreach ($ufm_id as $key => $value): ?>
                    <a class="aa01" href="<?=$base_url?>form/index/<?=$value?>/<?=$mid?>" target='_self'><?=$ufm_btn_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
            <?php if (!empty($quote_data['uform']['value'])): ?>
                <?php foreach ($quote_data['uform']['value'] as $key => $value): ?>
                    <a class="aa01" href="<?=$value?>" target='_self'><?=$quote_data['uform']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 3: ?>

            <?php if ($uform_show): ?>
                <?php foreach ($ufm_id as $key => $value): ?>
                    <a class="aa02" href="<?=$base_url?>form/index/<?=$value?>/<?=$mid?>" target='_self'><?=$ufm_btn_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
            <?php if (!empty($quote_data['uform']['value'])): ?>
                <?php foreach ($quote_data['uform']['value'] as $key => $value): ?>
                    <a class="aa02" href="<?=$value?>" target='_self'><?=$quote_data['uform']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;

        case 4: ?>

            <?php if ($uform_show): ?>
                <?php foreach ($ufm_id as $key => $value): ?>
                    <a class="aa02" href="<?=$base_url?>form/index/<?=$value?>/<?=$mid?>" target='_self'><?=$ufm_btn_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
            <?php if (!empty($quote_data['uform']['value'])): ?>
                <?php foreach ($quote_data['uform']['value'] as $key => $value): ?>
                    <a class="aa02" href="<?=$value?>" target='_self'><?=$quote_data['uform']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;

        case 5: ?>

            <?php if ($uform_show): ?>
                <?php foreach ($ufm_id as $key => $value): ?>
                    <a class="aa04" id="icon12" href="#" onclick="javascript:window.location.href='<?=$base_url?>form/index/<?=$value?>/<?=$mid?>';"><?=$ufm_btn_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
            <?php if (!empty($quote_data['uform']['value'])): ?>
                <?php foreach ($quote_data['uform']['value'] as $key => $value): ?>
                    <a class="aa04" id="icon12" href="#" onclick="javascript:window.location.href='<?=$value?>';"><?=$quote_data['uform']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;

        case 6: ?>

            <?php if ($uform_show): ?>
                <?php foreach ($ufm_id as $key => $value): ?>
                    <a class="aa02" href="<?=$base_url?>form/index/<?=$value?>/<?=$mid?>" target='_self'><?=$ufm_btn_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
            <?php if (!empty($quote_data['uform']['value'])): ?>
                <?php foreach ($quote_data['uform']['value'] as $key => $value): ?>
                    <a class="aa02" href="<?=$value?>" target='_self'><?=$quote_data['uform']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;
    }
?>
<?php endif; ?>