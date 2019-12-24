<!-- cpn_number -->
<?php if ($cpn_number_show || !empty($quote_data['cpn_number']['value'])): ?>
<?php
    switch ($iqr['theme_id'])
    {
        case 1: ?>

            <?php if ($cpn_number_show): ?>
                <a href="#" onclick='alert("統編："+<?=$iqr['cpn_number']?>);' data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>"><?=$cpn_number_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['cpn_number']['value'])): ?>
                <?php foreach ($quote_data['cpn_number']['value'] as $key => $value): ?>
                    <a href="#" onclick='alert("統編："+<?=$value?>);' data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>"><?=$quote_data['cpn_number']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 2: ?>

            <?php if ($cpn_number_show): ?>
                <a class="aa01" href="#" onclick='alert("統編："+<?=$iqr['cpn_number']?>);'><?=$cpn_number_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['cpn_number']['value'])): ?>
                <?php foreach ($quote_data['cpn_number']['value'] as $key => $value): ?>
                    <a class="aa01" href="#" onclick='alert("統編："+<?=$value?>);'><?=$quote_data['cpn_number']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 3: ?>

            <?php if ($cpn_number_show): ?>
                <a class="aa02" href="#" onclick='alert("統編："+<?=$iqr['cpn_number']?>);'><?=$cpn_number_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['cpn_number']['value'])): ?>
                <?php foreach ($quote_data['cpn_number']['value'] as $key => $value): ?>
                    <a class="aa02" href="#" onclick='alert("統編："+<?=$value?>);'><?=$quote_data['cpn_number']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 4: ?>

            <?php if ($cpn_number_show): ?>
                <a class="aa02" href="#" onclick='alert("統編："+<?=$iqr['cpn_number']?>);'><?=$cpn_number_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['cpn_number']['value'])): ?>
                <?php foreach ($quote_data['cpn_number']['value'] as $key => $value): ?>
                    <a class="aa02" href="#" onclick='alert("統編："+<?=$value?>);'><?=$quote_data['cpn_number']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 5: ?>

            <?php if ($cpn_number_show): ?>
                <a class="aa04" id="icon01" onclick='javascript:alert("統編："+<?=$iqr['cpn_number']?>);'><?=$cpn_number_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['cpn_number']['value'])): ?>
                <?php foreach ($quote_data['cpn_number']['value'] as $key => $value): ?>
                <a class="aa04" id="icon01" onclick='alert("統編："+<?=$value?>);'><?=$quote_data['cpn_number']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 6: ?>

            <?php if ($cpn_number_show): ?>
                <a class="aa02" href="#" onclick='alert("統編："+<?=$iqr['cpn_number']?>);'><?=$cpn_number_name?></a>
            <?php endif; ?>

            <?php if (!empty($quote_data['cpn_number']['value'])): ?>
                <?php foreach ($quote_data['cpn_number']['value'] as $key => $value): ?>
                    <a class="aa02" href="#" onclick='alert("統編："+<?=$value?>);'><?=$quote_data['cpn_number']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;
    }
?>
<?php endif; ?>