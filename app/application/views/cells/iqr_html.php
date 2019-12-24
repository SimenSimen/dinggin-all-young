<!-- iqr_html_page -->
<?php if (!empty($iqr_html_page) || !empty($quote_data['iqr_html']['value'])): ?>
<?php
    switch ($iqr['theme_id'])
    {
        case 1: ?>

            <?php if (!empty($iqr_html_page)): ?>
                <?php foreach ($iqr_html_page as $key => $value): ?>
                    <a href="<?=$base_url?>business/html_web/<?=$value['html_id']?>" target='_self' data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>"><?=$value['html_name']?></a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['iqr_html']['value'])): ?>
                <?php foreach ($quote_data['iqr_html']['value'] as $key => $value): ?>
                    <a href="<?=$value?>" target='_self' data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>"><?=$quote_data['iqr_html']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 2: ?>

            <?php if (!empty($iqr_html_page)): ?>
                <?php foreach ($iqr_html_page as $key => $value): ?>
                    <a class="aa01" href="<?=$base_url?>business/html_web/<?=$value['html_id']?>" target='_self'><?=$value['html_name']?></a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['iqr_html']['value'])): ?>
                <?php foreach ($quote_data['iqr_html']['value'] as $key => $value): ?>
                    <a class="aa01" href="<?=$value?>" target='_self'><?=$quote_data['iqr_html']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 3: ?>

            <?php if (!empty($iqr_html_page)): ?>
                <?php foreach ($iqr_html_page as $key => $value): ?>
                    <a class="aa02" href="<?=$base_url?>business/html_web/<?=$value['html_id']?>" target='_self'><?=$value['html_name']?></a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['iqr_html']['value'])): ?>
                <?php foreach ($quote_data['iqr_html']['value'] as $key => $value): ?>
                    <a class="aa02" href="<?=$value?>" target='_self'><?=$quote_data['iqr_html']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 4: ?>

            <?php if (!empty($iqr_html_page)): ?>
                <?php foreach ($iqr_html_page as $key => $value): ?>
                    <a class="aa02" href="<?=$base_url?>business/html_web/<?=$value['html_id']?>" target='_self'><?=$value['html_name']?></a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['iqr_html']['value'])): ?>
                <?php foreach ($quote_data['iqr_html']['value'] as $key => $value): ?>
                    <a class="aa02" href="<?=$value?>" target='_self'><?=$quote_data['iqr_html']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 5: ?>

            <?php if (!empty($iqr_html_page)): ?>
                <?php foreach ($iqr_html_page as $key => $value): ?>
                    <a class="aa04" id="icon04" onclick="javascript:window.location.href='<?=$base_url?>business/html_web/<?=$value['html_id']?>';" target='_self'><?=$value['html_name']?></a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['iqr_html']['value'])): ?>
                <?php foreach ($quote_data['iqr_html']['value'] as $key => $value): ?>
                    <a class="aa04" id="icon04" onclick="javascript:window.location.href='<?=$value?>';" target='_self'><?=$quote_data['iqr_html']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 6: ?>

            <?php if (!empty($iqr_html_page)): ?>
                <?php foreach ($iqr_html_page as $key => $value): ?>
                    <a class="aa02" href="<?=$base_url?>business/html_web/<?=$value['html_id']?>" target='_self'><?=$value['html_name']?></a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['iqr_html']['value'])): ?>
                <?php foreach ($quote_data['iqr_html']['value'] as $key => $value): ?>
                    <a class="aa02" href="<?=$value?>" target='_self'><?=$quote_data['iqr_html']['btnname'][$key]?></a>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;
    }
?>
<?php endif; ?>