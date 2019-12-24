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
		background:<?=$bg_color?> top left;
      }
	  .bg-style {
		background:<?=$bg_color?> top left;
	  }
    <?php elseif($bg_image_path != ''): ?>
      /* ­I´º¹Ï */
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
		background: url('<?=$base_url?><?=$bg_image_path?>') repeat scroll center top;
	  }
    <?php endif; ?>
</style>