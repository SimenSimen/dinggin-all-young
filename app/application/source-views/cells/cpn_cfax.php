<!-- cpn_cfax -->
<?php if ($cpn_cfax_show || !empty($quote_data['cpn_cfax']['value'])): ?>
<?php
    switch ($iqr['theme_id'])
    {
        case 1: ?>

            <?php if ($cpn_cfax_show): ?>
                <a href="javascript:void(0);" onclick="alert('<?=$cpn_fax_name?>：<?=$iqr['cpn_cfax']?>');" data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>"><?=$cpn_fax_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['cpn_cfax']['value'])): ?>
                <?php foreach ($quote_data['cpn_cfax']['value'] as $key => $value): ?>
                    <!-- <a href="tel:<?=$value?>" data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>"><?=$quote_data['cpn_cfax']['btnname'][$key]?></a> -->
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 2: ?>

            <?php if ($cpn_cfax_show): ?>
                <a class="aa01" href="javascript:void(0);" onclick="alert('<?=$cpn_fax_name?>：<?=$iqr['cpn_cfax']?>');"><?=$cpn_fax_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['cpn_cfax']['value'])): ?>
                <?php foreach ($quote_data['cpn_cfax']['value'] as $key => $value): ?>
                    <!-- <a class="aa01" href="tel:<?=$value?>"><?=$quote_data['cpn_cfax']['btnname'][$key]?></a> -->
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 3: ?>

            <?php if ($cpn_cfax_show): ?>
                <a class="aa02" href="javascript:void(0);" onclick="alert('<?=$cpn_fax_name?>：<?=$iqr['cpn_cfax']?>');"><?=$cpn_fax_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['cpn_cfax']['value'])): ?>
                <?php foreach ($quote_data['cpn_cfax']['value'] as $key => $value): ?>
                    <!-- <a class="aa02" href="tel:<?=$value?>"><?=$quote_data['cpn_cfax']['btnname'][$key]?></a> -->
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 4: ?>

            <?php if ($cpn_cfax_show): ?>
                <a class="aa02" href="javascript:void(0);" onclick="alert('<?=$cpn_fax_name?>：<?=$iqr['cpn_cfax']?>');"><?=$cpn_fax_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['cpn_cfax']['value'])): ?>
                <?php foreach ($quote_data['cpn_cfax']['value'] as $key => $value): ?>
                    <!-- <a class="aa02" href="tel:<?=$value?>"><?=$quote_data['cpn_cfax']['btnname'][$key]?></a> -->
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;

        case 5: ?>

            <?php if ($cpn_cfax_show): ?>
                <a class="aa04" id="icon08" onclick="javascript:alert('<?=$cpn_fax_name?>：<?=$iqr['cpn_cfax']?>');"><?=$cpn_fax_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['cpn_cfax']['value'])): ?>
                <?php foreach ($quote_data['cpn_cfax']['value'] as $key => $value): ?>
                    <!-- <a class="aa04" id="icon08" onclick="javascript:window.location.href='tel:<?=$value?>';"><?=$quote_data['cpn_cfax']['btnname'][$key]?></a> -->
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;

        case 6: ?>

            <?php if ($cpn_cfax_show): ?>
                <a class="aa02" href="javascript:void(0);" onclick="alert('<?=$cpn_fax_name?>：<?=$iqr['cpn_cfax']?>');"><?=$cpn_fax_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['cpn_cfax']['value'])): ?>
                <?php foreach ($quote_data['cpn_cfax']['value'] as $key => $value): ?>
                    <!-- <a class="aa02" href="tel:<?=$value?>"><?=$quote_data['cpn_cfax']['btnname'][$key]?></a> -->
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;
    }
?>
<?php endif; ?>