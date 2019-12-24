<!-- mecard qrcode -->
<?php if ($mecard_show && $contact_btn['qrcode_btn']): ?>
<?php
    switch ($iqr['theme_id']) {
        case 1: ?>

            <a href="<?=$base_url?>business/view_qrcode/<?=$mid?>/1" target='_self' data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-theme="<?=$jqm_button?>"><?=$contact_btn_name?></a>

        <?  break;

        case 2: ?>

            <a class="aa01" href="<?=$base_url?>business/view_qrcode/<?=$mid?>/1" target='_self'><?=$contact_btn_name?></a>

        <?  break;

        case 3: ?>

            <a class="aa02" href="<?=$base_url?>business/view_qrcode/<?=$mid?>/1" target='_self'><?=$contact_btn_name?></a>

        <?  break;

        case 4: ?>
        
            <a class="aa02" href="<?=$base_url?>business/view_qrcode/<?=$mid?>/1" target='_self'><?=$contact_btn_name?></a>

        <?  break;

        case 5: ?>

            <a class="aa04-QR" herf='#' onclick="javascript:window.location.href='<?=$base_url?>business/view_qrcode/<?=$mid?>/1';" target='_self'><?=$contact_btn_name?></a>

        <?  break;

        case 6: ?>

            <a class="aa02" href="<?=$base_url?>business/view_qrcode/<?=$mid?>/1" target='_self'><?=$contact_btn_name?></a>

        <?  break;
    }
?>
<?php endif; ?>