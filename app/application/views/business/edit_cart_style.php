<!doctype html>
<html>
<head>

  <!–[if IE]>
  <script src='https://html5shiv.googlecode.com/svn/trunk/html5.js'></script>
  <![endif]–>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=1024">

  <!-- seo -->
  <title><?=$_ActionStoreSet?> <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>
  
  <!-- css -->
  <link rel="stylesheet" href="/css/dropdowns/style.css" type="text/css" media="screen, projection"/>
  <!--[if lte IE 7]>
        <link rel="stylesheet" type="text/css" href="/css/dropdowns/ie.css" media="screen" />
    <![endif]-->
  <link type="text/css" rel="stylesheet" href="/css/pageguide/edit_iqr_style.css">
  <link type="text/css" rel="stylesheet" href="/css/pageguide/pageguide.css">
  <link type="text/css" rel="stylesheet" href="/css/pageguide/main.css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="/css/edit_cart_style.css">
  <link type="text/css" rel="stylesheet" href="/css/global_cart.css" media="screen">
  
  <!-- jQuery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

  <!-- js -->
  <!-- <script type="text/javascript" src="/js/pageguide.js"></script> -->
  <script type="text/javascript" src="/js/edit_iqr_style_head.js"></script>

  <!--colorpicker-->
  <script type='text/javascript' src="/js/colpick.js"></script>
  <link rel="stylesheet" type="text/css" href="/css/colpick.css">

  <!-- validate -->
  <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
  <script type="text/javascript" src="/js/messages_tw.js" charset="utf-8"></script>
  <script type="text/javascript" src="/js/edit_integrate_validation.js" charset="utf-8"></script>

  <!--預覽區內容縮放修正-->
 
  <script type="text/javascript">
    var browser = (/Firefox/i.test(navigator.userAgent)) ? 'Firefox' :
    (/Chrome/i.test(navigator.userAgent)) ? 'Chrome' :
    (/MSIE/i.test(navigator.userAgent)) ? 'IE' :
    '非 Firefox/Chrom/IE 瀏覽器';

    // $(function(){
    //   <?if($user_theme_id >= 2):?>
    //     if(browser == 'IE')
    //     {
    //       $('#preview_integrate').css('zoom', '0.3763');
    //       $('#preview_integrate').css('width', '696px');
    //       $('#preview_integrate').css('height', '1227px');
    //     }
    //     else if(browser == 'Firefox')
    //     {
    //       $('#preview_integrate').css('width', '696px');
    //       $('#preview_integrate').css('height', '1227px');
    //     }
    //     else
    //     {
    //       $('#preview_integrate').css('width', '972px');
    //       $('#preview_integrate').css('height', '1708px');
    //       $('.pName').css('font-size','1500%');
    //     }
    //   <?php else: ?>
    //     $('#preview_integrate').css('width', '262px');
    //     $('#preview_integrate').css('height', '460px');
    //   <?php endif; ?>
      
    // });
  </script>
  
</head>

<body scroll="yes" style="overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

<?
  //header
  $this->load->view('business/header', $data);
?>
  
<div id="container"><div class="w1024">
  <h1 style="font-size:1.09em;"><?=$SelectStore?></h1>
  <h1>&nbsp;</h1>
  
  <div id="con-L">

    <!--系統版型選擇區-->
    <?echo form_open_multipart("/business/edit_cart_style", array('id'=>'form_iqr_style'));?>
    <!--user-->
    <input type='hidden' id='user_cart_id' value="<?=$user_cart_id?>">
    <input type='hidden' id='user_menu_id' value='<?=$user_menu_id?>'>
    <!--base_url-->
    <input type='hidden' id='base_url'  value='<?=$base_url?>'>
    <!--default end-->
  
  	<!--原始顯示區-->
    <div class="step-style-1">
      <?php if (!empty($theme)): ?>
        <ul id="iqr_theme_ul">
          <?php foreach ($theme as $key => $value): ?>
            <li class="ui-state-default">
              <img src='<?=$thumb_path[$key]?>'><br>
              <span class='theme_display_name'><?=$value['cart_display_name']?></span>
                <a onclick='pop_theme_preview("<?=$base_url.$value['cart_preview_link']?>", "<?=$value['cart_display_name']?>");' class='theme_preview aa5' style='margin-left: 4px; padding:7px 10px;' title='<?=$ClickView?>'><?=$View?></a>
                <input type='radio' class='theme_radio' name='theme_radio' id='theme_radio_<?=$value['cart_id']?>' value='<?=$value['cart_id']?>'>
              
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
      <div class="clear"></div>
    </div>

    <!--風格編輯區-->
    <div class="menu_selection" style="display:none;">
        <table border="0" cellspacing="0" cellpadding="0" class="table-theme">
          <tr>
            <td class="dd1"><?=$MenuColor?></td>
          </tr>
        </table>
        <ul id="iqr_menu_ul">
          <?php foreach ($theme as $key => $value): ?>
            <li class="ui-menu-status">
              <img src="<?=$menu_path[$key]?>">&nbsp;&nbsp;&nbsp;
              <input type='radio' class="menu_radio" name='menu_radio' id='menu_radio_<?=$value['cart_menu_type']?>' value='<?=$value['cart_menu_type']?>'>
            </li>
          <?php endforeach;?>
              <select name='jqm_button_color' id='jqm_button_color' style="display:none;">
              <option value='demo-1' <?=$jqm_button_selected['demo-1']?>><?=$Pink?></option>
              <option value='demo-2' <?=$jqm_button_selected['demo-2']?>><?=$Orange?></option>
              <option value='demo-3' <?=$jqm_button_selected['demo-3']?>><?=$Black?></option>
              <option value='demo-4' <?=$jqm_button_selected['demo-4']?>><?=$Green?></option>
              <option value='demo-5' <?=$jqm_button_selected['demo-5']?>><?=$Purple?></option>
              <option value='demo-6' <?=$jqm_button_selected['demo-5']?>><?=$Gray?></option>
              </select>
          </ul>
    </div>
    <!-- <div class="step-style-1">
      <table border="0" cellspacing="0" cellpadding="0" class="table-theme">
        <tr id='jqm_button_select_div' style="display:none;">
        <label id='menu_style' style="display:none;"><img src="/images/integrate/cart_thumb/style_view/menu_style.jpg"></img></label>
          <td class="dd1">Menu 按鈕顏色</td>
          <td class="dd2">
            <select name='jqm_button_color' id='jqm_button_color'>
            <option value='demo-1' <?=$jqm_button_selected['demo-1']?>>桃紅色</option>
            <option value='demo-2' <?=$jqm_button_selected['demo-2']?>>橘色</option>
            <option value='demo-3' <?=$jqm_button_selected['demo-3']?>>黑色</option>
            <option value='demo-4' <?=$jqm_button_selected['demo-4']?>>綠色</option>
            <option value='demo-5' <?=$jqm_button_selected['demo-5']?>>紫色</option>
            </select>
          </td>
        </tr>
      </table>
    </div> -->
    <!--儲存按鈕-->
    <div class="aaCenter">
      <input type='button' class='aa3' id='reset_style' value='<?=$Restore?>'>
      <input type='button' class='aa3' id='reset_edit' value='<?=$Reset?>'>
      <input type='submit' class="aa3" name='form_submit' onclick="window.onbeforeunload=null;return true;" value='<?=$Save?>'>
    </div>
    
  </div>
    
  </form>

<?
  //preview_iframe
  $this->load->view('business/preview_cart_iframe', $data);
?>

  <!--cannot delete~ it's useful -->
  <div class="clear"></div>  

  </div><!--the end of w1024(container) -->

  <div id="advertisement">  <!--go top-->
    <a href="#"><img style="border:0px;" src="/images/style_01/gotop.png"></a>
  </div>

</div><!--the end of container -->

<?
  //footer
  $this->load->view('business/footer', $data);
?>

<!--bottom script-->
<script type="text/javascript" src="/js/jquery.blockUI.js"></script>
<script type="text/javascript" src="/js/edit_cart_style.js" charset="utf-8"></script>

</body>
</html>
