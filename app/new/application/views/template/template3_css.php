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

  ._TitleText {
    font-family: "<?=$font_family?>";
    color: <?=$font_color?>;
    font-size: <?=$font_size?>px;
  }
  .index-nav-menu li a {
    font-family: "<?=$font_family_2?>";
    color: <?=$font_color_2?>;
    font-size: <?=$font_size_2?>px;
  }
	
  .header {
    font-family: "<?=$font_family_3?>";
    color: <?=$font_color_3?>;
    font-size: <?=$font_size_3?>px;
  }

  .dropdownTop-B2B {
    font-family: "<?=$font_family_4?>";
    color: <?=$font_color_4?>;
    font-size: <?=$font_size_4?>px;
  }

  .article-list h2 {
    font-family: "<?=$font_family_5?>";
    color: <?=$font_color_5?>;
    font-size: <?=$font_size_5?>px;
  }
	
</style>