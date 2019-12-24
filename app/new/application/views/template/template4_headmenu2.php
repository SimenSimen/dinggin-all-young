		<?php $this -> load -> view('template/template4_headmenu', $data); ?>

            <header class="header">	
	<?php if($viewtype!='C'){?>
			<i class="icon-my">
			<?php if(!empty($logo_path)){?>
                <img src="<?=$logo_path?>">
            <?php }else{ ?>
                <img src="images/cover-image.jpg" >
            <?php } ?>
            </i>
                
	<? } ?>
                <?=$htmltitle?>
			</header>
