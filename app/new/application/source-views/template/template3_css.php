<!-- user style -->
<style type="text/css">
    /* font color */
    .user_text
    {
      color:<?=$font_color?>;
      font-size:<?=$font_size?>px;
      font-family:"<?=$font_family?>";
    }
    <?php if ($bg_type == 0 || $bg_image_path == ''): ?>
      body
      {
        background-color:<?=$bg_color?>;
      }
    <?php elseif($bg_image_path != ''): ?>
      /* �I���� */
      body
      {
        background:url('<?=$base_url?><?=$bg_image_path?>') no-repeat center 0px;
        -moz-background-size:cover;
        -webkit-background-size:cover;
        -o-background-size:cover;
        background-size:cover;
        background-attachment: fixed;
        background-position: center center;
      }
	  .bg-style {
		background-image: url('<?=$base_url?><?=$bg_image_path?>');
		background-repeat: repeat;
	  }
    <?php endif; ?>
	
    <? if (!empty($set_03list)){ ?>
	.set_03list{
		background-color:<?=$set_03list?>;
	}
    <? }?>

    <? if (!empty($set_header)){ ?>
	.set_header{
		background-color:<?=$set_header?>;
	}
    <? }?>
	
	
</style>