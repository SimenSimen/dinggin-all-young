<!-- ytb_link -->
<?php if ($ytb_link_num != 0 || !empty($quote_data['ytb_link']['value'])): ?>
<?php
    switch ($iqr['theme_id'])
    {
        case 1: ?>

            <?php if ($ytb_link_num != 0): ?>
                <?php foreach ($ytb_link as $key => $value): ?>
                    <p class='user_text'>
                        <?=$ytb_link_name[$key]?>
                        <iframe class='video_iframe' src="http://www.youtube.com/embed/<?=$value?>"></iframe>
                    </p>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['ytb_link']['value'])): ?>
                <?php foreach ($quote_data['ytb_link']['value'] as $key => $value): ?>
                    <p class='user_text'>
                        <?=$quote_data['ytb_link']['btnname'][$key]?>
                        <iframe class='video_iframe' src="http://www.youtube.com/embed/<?=$value?>"></iframe>
                    </p>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 2: ?>

            <?php if ($ytb_link_num != 0): ?>
                <?php foreach ($ytb_link as $key => $value): ?>
                    <p style="background:rgba(255,255,255,0.01);" class='user_text'>
                        <?=$ytb_link_name[$key]?>
                        <iframe allowfullscreen="" frameborder="0"  width="100%" height="350" src="http://www.youtube.com/embed/<?=$value?>"></iframe>
                    </p>
                    <p>&nbsp;</p>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['ytb_link']['value'])): ?>
                <?php foreach ($quote_data['ytb_link']['value'] as $key => $value): ?>
                    <p style="background:rgba(255,255,255,0.01);" class='user_text'>
                        <?=$quote_data['ytb_link']['btnname'][$key]?>
                        <iframe allowfullscreen="" frameborder="0"  width="100%" height="350" src="http://www.youtube.com/embed/<?=$value?>"></iframe>
                    </p>
                    <p>&nbsp;</p>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 3: ?>

            <?php if ($ytb_link_num != 0): ?>
                <?php foreach ($ytb_link as $key => $value): ?>
                    <h1 style="background:rgba(255,255,255,0.01);"><?=$ytb_link_name[$key]?></h1>
                    <iframe allowfullscreen="" frameborder="0"  width="100%" height="350" src="http://www.youtube.com/embed/<?=$value?>"></iframe>
                    <p>&nbsp;</p>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['ytb_link']['value'])): ?>
                <?php foreach ($quote_data['ytb_link']['value'] as $key => $value): ?>
                    <h1 style="background:rgba(255,255,255,0.01);"><?=$quote_data['ytb_link']['btnname'][$key]?></h1>
                    <iframe allowfullscreen="" frameborder="0"  width="100%" height="350" src="http://www.youtube.com/embed/<?=$value?>"></iframe>
                    <p>&nbsp;</p>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 4: ?>

            <?php if ($ytb_link_num != 0): ?>
                <?php foreach ($ytb_link as $key => $value): ?>
                    <h2 style="background:rgba(255,255,255,0.01);"><?=$ytb_link_name[$key]?></h2>
                    <iframe allowfullscreen="" frameborder="0"  width="100%" height="350" src="http://www.youtube.com/embed/<?=$value?>"></iframe>
                    <p>&nbsp;</p>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['ytb_link']['value'])): ?>
                <?php foreach ($quote_data['ytb_link']['value'] as $key => $value): ?>
                    <h2 style="background:rgba(255,255,255,0.01);"><?=$quote_data['ytb_link']['btnname'][$key]?></h2>
                    <iframe allowfullscreen="" frameborder="0"  width="100%" height="350" src="http://www.youtube.com/embed/<?=$value?>"></iframe>
                    <p>&nbsp;</p>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 5: ?>

            <?php if ($ytb_link_num != 0): ?>
                <?php foreach ($ytb_link as $key => $value): ?>
                    <h3 style="background:rgba(255,255,255,0.01);"><?=$ytb_link_name[$key]?></h3>
                    <iframe allowfullscreen="" frameborder="0"  width="100%" height="350" src="http://www.youtube.com/embed/<?=$value?>"></iframe>
                    <p>&nbsp;</p>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['ytb_link']['value'])): ?>
                <?php foreach ($quote_data['ytb_link']['value'] as $key => $value): ?>
                    <h3 style="background:rgba(255,255,255,0.01);"><?=$quote_data['ytb_link']['btnname'][$key]?></h3>
                    <iframe allowfullscreen="" frameborder="0"  width="100%" height="350" src="http://www.youtube.com/embed/<?=$value?>"></iframe>
                    <p>&nbsp;</p>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;

        case 6: ?>

            <?php if ($ytb_link_num != 0): ?>
                <?php foreach ($ytb_link as $key => $value): ?>
                    <h2 style="background:rgba(255,255,255,0.01);"><?=$ytb_link_name[$key]?></h2>
                    <iframe allowfullscreen="" frameborder="0"  width="100%" height="350" src="http://www.youtube.com/embed/<?=$value?>"></iframe>
                    <p>&nbsp;</p>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($quote_data['ytb_link']['value'])): ?>
                <?php foreach ($quote_data['ytb_link']['value'] as $key => $value): ?>
                    <h2 style="background:rgba(255,255,255,0.01);"><?=$quote_data['ytb_link']['btnname'][$key]?></h2>
                    <iframe allowfullscreen="" frameborder="0"  width="100%" height="350" src="http://www.youtube.com/embed/<?=$value?>"></iframe>
                    <p>&nbsp;</p>
                <?php endforeach; ?>
            <?php endif; ?>

        <?  break;
    }
?>
<?php endif; ?>