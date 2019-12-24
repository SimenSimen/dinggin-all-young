<!doctype html>
<html>
<head>

  <!–[if IE]>
  <script src='https://html5shiv.googlecode.com/svn/trunk/html5.js'></script>
  <![endif]–>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=1024">

  <!-- seo -->
  <title><?=$_StytleSet?> - <?=$web_config['title']?></title>
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
  <link type="text/css" rel="stylesheet" href="/css/edit_iqr_style.css">
  <link type="text/css" rel="stylesheet" href="/css/global.css" media="screen">
  
  <!-- jQuery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

  <!-- js -->
  <script type="text/javascript" src="/js/pageguide.js"></script>
  <script type="text/javascript" src="/js/edit_iqr_style_head.js"></script>

  <!--colorpicker-->
  <script type='text/javascript' src="/js/colpick.js"></script>
  <link rel="stylesheet" type="text/css" href="/css/colpick.css">

  <!-- validate -->
  <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
  <script type="text/javascript" src="/js/messages_tw.js" charset="utf-8"></script>
  <script type="text/javascript" src="/js/edit_integrate_validation.js" charset="utf-8"></script>

  <!--預覽區內容縮放修正-->
  <style type="text/css">
    <? if($user_theme_id >= 2):?>
    #preview_integrate {
      zoom: 0.71;
      -moz-transform: scale(0.376);
      -moz-transform-origin: 0 0;
      -o-transform: scale(0.71);
      -o-transform-origin: 0 0;
      -webkit-transform: scale(0.38);
      -webkit-transform-origin: 0 0;
    }
    <?else:?>
    #preview_integrate {
       width:264px;
       height:444px;
    }
    <?endif?>
  </style>
  <script type="text/javascript">
    var browser = (/Firefox/i.test(navigator.userAgent)) ? 'Firefox' :
    (/Chrome/i.test(navigator.userAgent)) ? 'Chrome' :
    (/MSIE/i.test(navigator.userAgent)) ? 'IE' :
    '<?=$NotFirefoxChromIE?>';

    $(function(){
      <?if($user_theme_id >= 2):?>
        if(browser == 'IE')
        {
          $('#preview_integrate').css('zoom', '0.3763');
          $('#preview_integrate').css('width', '696px');
          $('#preview_integrate').css('height', '1227px');
        }
        else if(browser == 'Firefox')
        {
          $('#preview_integrate').css('width', '696px');
          $('#preview_integrate').css('height', '1227px');
        }
        else
        {
          $('#preview_integrate').css('width', '972px');
          $('#preview_integrate').css('height', '1708px');
        }
      <?php else: ?>
        $('#preview_integrate').css('width', '262px');
        $('#preview_integrate').css('height', '460px');
      <?php endif; ?>
      
    });
  </script>
  
</head>

<body scroll="yes" style="overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

<?
  //header
  $this->load->view('business/header', $data);
?>
<div id="container"><div class="w1024">

  <h1 style="font-size:1.09em;"><?=$SelectStoreSystem?></h1>
  <h1>&nbsp;</h1>
  
  <div id="con-L">

    <!--系統版型選擇區-->
    <? echo form_open_multipart("/business/edit_iqr_style", array('id'=>'form_iqr_style'));?>
    <!--user-->
    <input type='hidden' id='user_theme_id'         value='<?=$user_theme_id?>'>
    <input type='hidden' id='user_jqm_button_color' value='<?=$user_jqm_button_color?>'>
	
<? 		for($i=0;$i<4;$i++){
			if ($i>0) $outinum=$i;
			else $outinum='';
?>    
	<input type='hidden' id='user_font_color<?=$outinum?>' value='<?=${'user_theme_font_color'.$outinum}?>'>
    <input type='hidden' id='user_font_size<?=$outinum?>' value='<?=${'user_theme_font_size'.$outinum}?>'>
    <input type='hidden' id='user_font_family<?=$outinum?>' value='<?=${'user_theme_font_family'.$outinum}?>'>
<?		} ?>
	

  	<input type='hidden' id='set_header' value='<?=$set_header?>'>
  	<input type='hidden' id='set_03list' value='<?=$set_03list?>'>
	
    <input type='hidden' id='bg_type'               value='<?=$bg_type?>'>
    <input type='hidden' id='user_bg_color'         value='<?=$user_theme_bg_color?>'>
    <input type='hidden' id='user_bg_image_path'    value='<?=$user_theme_bg_image_path?>'>
    <input type='hidden' id='user_bg_image_path_id' value='<?=$user_theme_bg_image_path_id?>'>
    
    <!--default-->
    <input type='hidden' id='dfu_font_color'        value='<?=$dfu_theme['dfu_font_color']?>'>
    <input type='hidden' id='dfu_font_size'         value='<?=$dfu_theme['dfu_font_size']?>'>
    <input type='hidden' id='dfu_font_family'       value='<?=$dfu_theme['dfu_font_family']?>'>
    <input type='hidden' id='dfu_bg_type'           value='<?=$dfu_theme['dfu_bg_type']?>'>
    <input type='hidden' id='dfu_bg_color'          value='<?=$dfu_theme['dfu_bg_color']?>'>
    <input type='hidden' id='dfu_bg_image_path'     value='<?=$dfu_theme['dfu_bg_image_path']?>'>
    <input type='hidden' id='dfu_bg_image_path_id'  value='<?=$dfu_bg_image_path_id?>'>
    <!-- user -->
    <?php for($i = 2; $i < 6; $i++): ?>
      <input type='hidden' id='user_font_color_<?=$i?>' value='<?=${'user_font_color_'.$i}?>'>
      <input type='hidden' id='user_font_size_<?=$i?>' value='<?=${'user_font_size_'.$i}?>'>
      <input type='hidden' id='user_font_family_<?=$i?>' value='<?=${'user_font_family_'.$i}?>'>
    <?php endfor; ?>
    <!-- default theme 8 -->
    <?php for($i = 2; $i < 6; $i++): ?>
      <input type="hidden" id='dfu_font_color_<?=$i?>'        value="<?=$dfu_theme['dfu_font_color_'.$i]?>">
      <input type='hidden' id='dfu_font_size_<?=$i?>'         value='<?=$dfu_theme['dfu_font_size_'.$i]?>'>
      <input type='hidden' id='dfu_font_family_<?=$i?>'       value='<?=$dfu_theme['dfu_font_family_'.$i]?>'>
    <?php endfor; ?>
    
    <!--base_url-->
    <input type='hidden' id='base_url'  value='<?=$base_url?>'>
    <!--default end-->
  
  	<!--原始顯示區-->
    <div class="step-style-1">
      <?php if (!empty($theme)): ?>
        <ul id="iqr_theme_ul">
          <?php foreach ($theme as $key => $value): ?>
            <?php if($key < 4 ): ?>
            <li class="ui-state-default">
              <img src='<?=$thumb_path[$key]?>'><br>
              <span class='theme_display_name'><?=$value['theme_display_name']?>&nbsp;
                <a onclick='pop_theme_preview("<?=$base_url.$value['theme_preview_link']?>", "<?=$value['theme_display_name']?>");' class='theme_preview aa5' title='<?=$ClickShow?>'><?=$Show?></a>
                <input type='radio' class='theme_radio' name='theme_radio' id='theme_radio_<?=$value['theme_id']?>' value='<?=$value['theme_id']?>'>
              </span>
            </li>
            <?php endif;?>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
      <div class="clear"></div>
    </div>

    <!--風格編輯區-->
    <div class="step-style-2">
      <table border="0" cellspacing="0" cellpadding="0" class="table-theme">
        
        <!--按鈕顏色-->
          <tr id='jqm_button_select_div' style="display:none;">
            <td class="dd1"><?=$ButtonColor?></td>
            <td class="dd2">
              <select name='jqm_button_color' id='jqm_button_color'>
              <option value='a' <?=$jqm_button_selected['a']?>><?=$Black?></option>
              <option value='b' <?=$jqm_button_selected['b']?>><?=$Blue?></option>
              <option value='c' <?=$jqm_button_selected['c']?>><?=$Gray?></option>
              <option value='d' <?=$jqm_button_selected['d']?>><?=$White?></option>
              <option value='e' <?=$jqm_button_selected['e']?>><?=$Yellow?></option>
              </select>
            </td>
          </tr>
    
        <!--title風格-->
<?		
//	for($i=0;$i<4;$i++){
	for($i=0;$i<1;$i++){
		if ($i>0) $outinum=$i;
		else $outinum='';
?>		
          <tr>
            <td class="dd1"><?=$FontSet?></td>
            <td class="dd2">
              <?=$Color?>
              <input type="text"  name="fonts_color<?=$outinum?>" style='width:70px;' id="fonts_colorUSER<?=$outinum?>1" value='<?=${'fonts_color'.$outinum}?>'/>
              <input type="color" name="fonts_color<?=$outinum?>" style='width:71px;' id="fonts_colorUSER<?=$outinum?>2" value='<?=${'fonts_color'.$outinum}?>' />

              <?=$Size?>
              <select name='fonts_size<?=$outinum?>' id='fonts_size<?=$outinum?>'>
				<?	for($j=8;$j<40;$j=$j+2){		
						$temparrayname='font_size_selected'.$outinum;
						if(${$temparrayname}==$j) $outtempstr="selected='selected'";
						else $outtempstr="";
				?>			  
					<option value='<?=$j?>' <?=$outtempstr;?>><?=$j?></option>
				<?	}//for($i=2;$i<40;$i=$i+2)		?>			  
              </select>
              <?=$Font?>
              <select name='fonts_family<?=$outinum?>' id='fonts_family<?=$outinum?>'>
				<?
				$outarraystr=array('Times New Roman','Arial','Lucida Grande','Helvetica','Cambria','新細明體','標楷體','微軟正黑體');
				foreach ($outarraystr as $key => $value){
					$temparrayname='font_family_selected'.$outinum;
					if(${$temparrayname}==$value) $outtempstr="selected='selected'";
					else $outtempstr="";
				?>			  
					<option value='<?=$value?>' <?=$outtempstr;?>><?=$value?></option>
				<?}//	foreach ($theme as $key => $value){?>
              </select>
            </td>
          </tr>
<?		
	}//for($i=0;$i<4;$i++){
?>
      <?php foreach ($setting_array as $key => $value): ?>
        <tr class="radio_8">
          <td class="dd1">
            <?=$FontSet?>
            <!-- <img id="help1" src="/images/front/help1.gif" title="<?=$DefaulBack?>" /> -->
            <!-- <img id="dfu_background" style="display:none; width:200px; height: 300px; position: absolute;" src=""> -->
          </td>
          <td class="dd2">
            <?=$Color?>
            <input type="text" name="colorPick" style='width:70px;' id="fonts_color_<?=$value?>1" value='<?=${'user_font_color_'.$value}?>'/>
            <input type="color" name="fonts_color_<?=$value?>" style='width:71px;' id="fonts_color_<?=$value?>2" value='<?=${'user_font_color_'.$value}?>' />
            <?=$Size?>
            <select name='fonts_size_<?=$value?>' id='fonts_size_<?=$value?>'>
            <?php for($i = 8; $i < 40; $i = $i + 2): ?>
              <option value='<?=$i?>'  <?=${'font_size_selected_'. $value}[$i]?>><?=$i?></option>
            <?php endfor; ?>
            </select>
            <?=$Font?>
            <select name='fonts_family_<?=$value?>' id='fonts_family_<?=$value?>'>
              <option value='Times New Roman' <?=${'font_family_selected_'. $value}['Times New Roman']?>>Times New Roman</option>
              <option value='Arial' <?=${'font_family_selected_'. $value}['Arial']?>>Arial</option>
              <option value='Lucida Grande' <?=${'font_family_selected_'. $value}['Lucida Grande']?>>Lucida Grande</option>
              <option value='Helvetica' <?=${'font_family_selected_'. $value}['Helvetica']?>>Helvetica</option>
              <option value='Cambria' <?=${'font_family_selected_'. $value}['Cambria']?>>Cambria</option>
              <option value='新細明體' <?=${'font_family_selected_'. $value}['新細明體']?>>新細明體</option>
              <option value='標楷體' <?=${'font_family_selected_'. $value}['標楷體']?>>標楷體</option>
              <option value='微軟正黑體' <?=${'font_family_selected_'. $value}['微軟正黑體']?>>微軟正黑體</option>
            </select>
          </td>
        </tr>
      <?php endforeach; ?>

        <!--分類抬頭背景顏色-->   
          <tr class='showthem8class'>
            <td class="dd1"><?=$CategoryTitle?></td>
            <td class="dd2">
              <input type="text"  name="set_header" style='width:70px;' id="set_header1" value='<?=$set_header?>'/>
              <input type="color" name="set_header" style='width:71px;' id="set_header2" value='<?=$set_header?>'/>
            </td>
          </tr>
          
        <!--選項背景顏色-->   
          <tr class='showthem8class'>
            <td class="dd1"><?=$Radios?></td>
            <td class="dd2">
              <input type="text"  name="set_03list" style='width:70px;' id="set_03list1" value='<?=$set_03list?>'/>
              <input type="color" name="set_03list" style='width:71px;' id="set_03list2" value='<?=$set_03list?>'/>
            </td>
          </tr>


        <!--背景顏色-->
          <tr>
            <td class="dd1"><?=$BackSet?></td>
            <td class="dd2">
              <input type='radio' name='background_type' class='switch_background_type' id='color_background' <?=$bg_type_checked[0]?> value='0'><label class='switch_background_label' for='color_background'><?=$UseColor?></label>&nbsp;
              <input type='radio' name='background_type' class='switch_background_type' id='image_background' <?=$bg_type_checked[1]?> value='1'><label class='switch_background_label' for='image_background'><?=$UseMaterial?></label>
            </td>
          </tr>

        <!--背景顏色-->   
          <tr>
            <td class="dd1"><?=$BackColor?></td>
            <td class="dd2">
              <input type="text"  name="background_color" style='width:70px;' id="background_color1" value='<?=$background_color?>'/>
              <input type="color" name="background_color" style='width:71px;' id="background_color2" value='<?=$background_color?>' />
            </td>
          </tr>

      </table>
    </div>

    <!--背景素材選擇區-->
    <div class="step-style-3">
      <table border="0" cellspacing="0" cellpadding="0" class="table-theme">
        <?php if ($dfu_theme['dfu_bg_type'] != 0): ?><!--預設為圖形模式，顯示預設背景欄位-->
          <tr class='theme_background_tr' style="display:none;" id='image_background_tr'>

            <td width="100" class="font_crm_list"><?=$BackMaterial?></td>
            <td style="text-align:left;" class="font_crm_list">
              <input type='radio' class='theme_background_radio' name='theme_background_radio' id='theme_background_radio_basic' value='0'>
              <label for='theme_background_radio_basic' class='theme_background_label'><?=$UseDefultBack?></label>
              <img id="help1" src="/images/front/help1.gif" title="<?=$DefaulBack?>" />
              <img id="dfu_background" style="display:none; width:200px; height: 300px; position: absolute;" src="">
            </td>

          </tr>
        <?php endif; ?>

        <tr class='theme_background_tr' style="display:none;" id='system_background_tr'>
          <td colspan="2" valign="top" height="400" width="652">

            <table height="400" width="652" class='ftw_003'>
              <tr>
                <td>
                  <div style="overflow: hidden;">
                    <div style="overflow: scroll; overflow-x:hidden; height: 400px;">
                      <div class='iqr_theme_background'>
                        <?php if (!empty($theme_background)): ?>
                          <ul id="iqr_theme_background_ul">
                            <?php foreach ($theme_background as $key => $value): ?>
                                <li class="ui-state-default">
                                  <img src='<?=$value?>'><br>
                                  <span class='theme_display_name'><?=($key+1)?><input type='radio' class='theme_background_radio' name='theme_background_radio' id='theme_background_radio_<?=$key?>' value='<?=$value?>'></span>
                                </li>
                            <?php endforeach; ?>
                          </ul>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
              </table>
          </td>
        </tr>
      </table>
    </div>

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
  $this->load->view('business/preview_iframe', $data);
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
<script type="text/javascript" src="/js/edit_iqr_style.js" charset="utf-8"></script>
<script>
$(function()
{
	$('.theme_radio').change(function(){
		if ($('input[name="theme_radio"]:checked').val()==8){//顯示只有第8版才有的功能
			 $('.showthem8class').show();
		}else{
			 $('.showthem8class').hide();
		}
	});
	<? if($user_theme_id == 8){
		echo "$('.showthem8class').show();";
	}else{
		echo "$('.showthem8class').hide();";
	}?>
	
});
</script>
</body>
</html>
