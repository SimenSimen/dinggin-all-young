<!-- exfile -->
<?php if ($exfile_show || !empty($quote_data['exfile']['value'])): ?>
<?php
    switch ($iqr['theme_id'])
    {
        case 1: ?>

            <?php if ($exfile_show): ?>
                <?php foreach ($doc_path as $key => $value): ?>
                    <a href="<?=$base_url?><?=substr($value, 1)?>" target='_blank' data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>" data-icon='arrow-d' data-iconpos="right"><?=$doc_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['exfile']['value'])): ?>
                <?php foreach ($quote_data['exfile']['value'] as $key => $value): ?>
                    <a href="<?=$value?>" target='_blank' data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>" data-icon='arrow-d' data-iconpos="right"><?=$quote_data['exfile']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 2: ?>

            <?php if ($exfile_show): ?>
                <?php foreach ($doc_path as $key => $value): ?>
                    <a href="<?=$base_url?><?=substr($value, 1)?>" target='_blank' class="aa02"><?=$doc_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['exfile']['value'])): ?>
                <?php foreach ($quote_data['exfile']['value'] as $key => $value): ?>
                    <a href="<?=$value?>" target='_blank' class="aa02"><?=$quote_data['exfile']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;

        case 3: ?>

            <?php if ($exfile_show): ?>
                <?php foreach ($doc_path as $key => $value): ?>
                    <a href="<?=$base_url?><?=substr($value, 1)?>" target='_blank' class="aa02"><?=$doc_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['exfile']['value'])): ?>
                <?php foreach ($quote_data['exfile']['value'] as $key => $value): ?>
                    <a href="<?=$value?>" target='_blank' class="aa02"><?=$quote_data['exfile']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;

        case 4: ?>

            <?php if ($exfile_show): ?>
                <?php foreach ($doc_path as $key => $value): ?>
                    <a href="<?=$base_url?><?=substr($value, 1)?>" target='_blank' class="aa02"><?=$doc_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['exfile']['value'])): ?>
                <?php foreach ($quote_data['exfile']['value'] as $key => $value): ?>
                    <a href="<?=$value?>" target='_blank' class="aa02"><?=$quote_data['exfile']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;

        case 5: ?>

            <?php if ($exfile_show): ?>
                <?php foreach ($doc_path as $key => $value): ?>
                    <a onclick="javascript:window.location.href='<?=$base_url?><?=substr($value, 1)?>';" target='_blank' id="icon13" class="aa04"><?=$doc_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['exfile']['value'])): ?>
                <?php foreach ($quote_data['exfile']['value'] as $key => $value): ?>
                    <a onclick="javascript:window.location.href='<?=$value?>';" target='_blank' id="icon13" class="aa04"><?=$quote_data['exfile']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;

        case 6: ?>

            <?php if ($exfile_show): ?>
                <?php foreach ($doc_path as $key => $value): ?>
                    <a href="<?=$base_url?><?=substr($value, 1)?>" target='_blank' class="aa02"><?=$doc_name[$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['exfile']['value'])): ?>
                <?php foreach ($quote_data['exfile']['value'] as $key => $value): ?>
                    <a href="<?=$value?>" target='_blank' class="aa02"><?=$quote_data['exfile']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        <?  break;
    }
?>
<?php endif; ?>