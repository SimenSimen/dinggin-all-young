<!doctype html>
<html>
  <head>
    
    <!–[if IE]>
    <script src=」https://html5shiv.googlecode.com/svn/trunk/html5.js」>
    </script>
    <![endif]–>
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=1024">
    
    <!-- seo -->
    <title><?=$auth_title?> - <?=$web_config['title']?></title>
    <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
    <meta name="keywords"     content=''>
    <meta name="description"  content=''>
    <meta name="author"       content=''>
    <meta name="copyright"    content=''>
  
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="/js/tabs/jquery-ui-1.10.4.custom.js"></script>
    <script type="text/javascript" src="/js/pageguide.js"></script>
    <script type='text/javascript' src="/js/share_list.js"></script>

    <!-- css -->
    <link rel="stylesheet" href="/css/dropdowns/style.css" type="text/css" media="screen, projection"/>
    <!--[if lte IE 7]>
    <link rel="stylesheet" type="text/css" href="/css/dropdowns/ie.css" media="screen" />
    <![endif]-->
    <link type="text/css" rel="stylesheet" href="/css/pageguide/edit_integrate.css">
    <link type="text/css" rel="stylesheet" href="/css/pageguide/pageguide.css">
    <link type="text/css" rel="stylesheet" href="/css/pageguide/main.css">
    <link type="text/css" rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link type="text/css" rel="stylesheet" href="/css/global.css" media="screen">
    <link type="text/css" rel="stylesheet" href="/css/share_setting.css">
    <link href="/css/tabs/jquery-ui-1.10.4.custom.css" rel="stylesheet">

  </head>
  
  <body scroll="yes" style="overflow-x: hidden;overflow: -moz-scrollbars-vertical;">
    
  <?php
    // header
    $this->load->view('business/header', $data);
  ?>
  
  <div id="container">
    <div class="w1024">
      <form action="/share/setting/<?=$user_auth?>" method="post" accept-charset="utf-8" id="form_share_list">
        <div id="con-L" style="width: 100%; min-height: 850px;">
          <div style="min-height: 850px;">
            <p style="line-height: 36px; text-align: left; font-size: 1.5em;"><?=$SharingPreferences?>
            <a href="#" class="why" id="why_panel" style="position: relative; top: 6px;">?</a>
            <?=$SelectAllPagingItems?>&nbsp;<input type='checkbox' title='<?=$SelectAllPagingItems?>' class='checkbox_zoom check_tabs_all'>
            <div class="prompt-box" id="prompt_panel" style="display: none;">
              <p><?=$RemindYou?></p>
              <p><?=$UseFormTopRight_1?></p>
              <p><?=$ChangeAllPagingCheck_2?></p>
              <p><?=$SettingShare_3?></p>
              <p>　&nbsp;<?=$SwitchTabA?></p>
            </div>
            </p>
            <p>&nbsp;</p>

            <p>

              <?php if (!empty($share_data)): ?>

                <div id="tabs">
                  <ul>

                    <!-- 群組 foreach -->
                    <?php $number = 0;?>
                    <?php foreach ($share_groups as $sg_key => $sg_value): ?>
                      <li><a href="#tabs-<?=$number++;?>"><?=$share_item_string[$sg_key]?></a></li>
                    <?php endforeach; ?><!-- 群組 foreach -->

                  </ul>

                  <!-- 群組 foreach -->
                  <?php $number = 0;?>
                  <?php foreach ($share_groups as $sg_key => $sg_value): ?>
                    <div id="tabs-<?=$number++;?>">

                      <?php if ($sg_key == 'images'): ?>

                        <!-- 特製 table for images -->
                        <p style="line-height: 36px; text-align: left; font-size: 1em;"><?=$ShareImage?></p><!-- prompt -->
                        <?php foreach ($sg_value as $key => $value): ?><!-- foreach album -->

                          <p style="line-height: 36px; text-align: left; font-size: 1em;"><?=$share_item_string[$value]?></p><!-- album name -->

                          <table class='listing_table'>

                            <tr><td colspan="5" style="text-align: center; cursor: pointer;" class='checkall_td'><?=$ClickAll?>&nbsp;&nbsp;<input style="display: none;" type='checkbox' title='<?=$SelectAll?>' class='checkbox_zoom checkall'></tr>

                            <?php $rows = 0;?>

                            <?php if (!empty($share_data[$value]['id'])): ?>
                              
                              <?php foreach ($share_data[$value]['id'] as $sd_key => $sd_value): ?>

                                <?php if (($rows % 5) == 0 && ($rows > 0)): ?><tr><?php endif; ?><!-- enter per five images -->

                                  <td style="width: 20%; padding: 20px;" class='db_checkbox'>
                                    
                                    <img src='<?=$share_data[$value]['value'][$sd_key]?>' class='db_images'>
                                    <div class='db_images_note' title='<?=$share_data[$value]['btnname'][$sd_key]?>'><?=$share_data[$value]['btnname'][$sd_key]?></div>
                                    <input type='checkbox' class='checkbox_zoom' name='check_share[]' value='^#<?=$value?>^#<?=$sd_value?>' <?=$share_data[$value]['checked'][$sd_key]?>>

                                  </td>

                              <?php $rows++;?>
                              <?php endforeach; ?>

                              <!-- 補齊 -->
                              <?php if ($rows < 5): ?>
                              <?php for($i = 0; $i < (5 - $rows); $i++) echo '<td style="width: 20%;"></td>';?>
                              <?php endif; ?>

                            <?php else: ?>

                              <td style="padding: 20px;" colspan="5"><?=$NoInformationShared?></td>

                            <?php endif; ?>

                          </table>
                          <p>&nbsp;</p>

                        <?php endforeach; ?><!-- 特製 table for images-->

                      <?php elseif ($sg_key == 'files'): ?>

                        <!-- 特製 table for files -->
                        <p style="line-height: 36px; text-align: left; font-size: 1em;"><?=$ShareFile?></p><!-- prompt -->
                        <table class='listing_table'>

                          <tr>
                            <td style="width: 20%;"><?=$SharedProject?></td>
                            <td style="width: 30%;"><?=$OriginalName?></td>
                            <td style="width: 30%;"><?=$ButtonName?></td>
                            <td style="width: 10%;"><?=$Link?></td>
                            <td style="width: 10%;"><input type='checkbox' title='<?=$SelectAll?>' class='checkbox_zoom checkall'></td>
                          </tr>
                          
                          <!-- item foreach -->
                          <?php foreach ($sg_value as $key => $value): ?>

                            <?php if (!empty($share_data[$value]['id'])): ?>

                              <?php foreach ($share_data[$value]['id'] as $sd_key => $sd_value): ?>

                                <tr>
                                  <td style="width: 20%;"><?=$share_item_string[$value]?></td>
                                  <td style="width: 30%;"><div class='shorter_string' title='<?=$share_data[$value]['oriname'][$sd_key]?>'><?=$share_data[$value]['oriname'][$sd_key]?></div></td>
                                  <td style="width: 30%;"><div class='shorter_string' title='<?=$share_data[$value]['btnname'][$sd_key]?>'><?=$share_data[$value]['btnname'][$sd_key]?></div></td>
                                  <td style="width: 10%;"><a class='aa8' href='<?=$share_data[$value]['value'][$sd_key]?>' target='_blank'><?=$FileLink?><!-- <img src='/images/document_icon.png' style='width: 20px;'> --></a></td>
                                  <td style="width: 10%;">
                                    <input type='checkbox' class='checkbox_zoom' name='check_share[]' value='^#<?=$value?>^#<?=$sd_value?>' <?=$share_data[$value]['checked'][$sd_key]?>>
                                  </td>
                                </tr>
                            
                              <?php endforeach; ?>

                            <?php else: ?>

                              <td style="padding: 20px;" colspan="5"><?=$NoInformationShared?></td>

                            <?php endif; ?>

                          <?php endforeach; ?><!-- item foreach -->

                        </table>
                        
                      <?php elseif ($sg_key == 'uform'): ?>

                        <!-- 特製 table for ufrom -->
                        <p style="line-height: 36px; text-align: left; font-size: 1em;"><?=$ShareRegistrationForm?></p><!-- prompt -->
                        <table class='listing_table'>

                          <tr>
                            <td style="width: 16%;"><?=$SharedProject?></td>
                            <td style="width: 32%;"><?=$ButtonName?></td>
                            <td ><?=$ShareProjectContent?></td>
                            <td style="width: 16%;"><?=$Enrollment?></td>
                            <td style="width: 7%;"><input type='checkbox' title='<?=$SelectAll?>' class='checkbox_zoom checkall'></td>
                          </tr>
                          
                          <!-- item foreach -->
                          <?php foreach ($sg_value as $key => $value): ?>

                            <?php if (!empty($share_data[$value]['id'])): ?>
                              
                              <?php foreach ($share_data[$value]['id'] as $sd_key => $sd_value): ?>

                                <tr>
                                  <td><?=$share_item_string[$value]?></td>
                                  <td><?=$share_data[$value]['btnname'][$sd_key]?></td>
                                  <td><div class='ufrom_link'><?=$share_data[$value]['value'][$sd_key]?></div></td>
                                  <td><div><?=$share_data[$value]['signup'][$sd_key]?></div></td>
                                  <td>
                                    <? if(!$share_data[$value]['disabled'][$sd_key]): ?>
                                      <input type='checkbox' class='checkbox_zoom' name='check_share[]' value='^#<?=$value?>^#<?=$sd_value?>' <?=$share_data[$value]['checked'][$sd_key]?>>
                                    <?php endif; ?>
                                  </td>
                                </tr>
                            
                              <?php endforeach; ?>

                            <?php else: ?>
                              
                              <td style="padding: 20px;" colspan="5"><?=$NoInformationShared?></td>
                            
                            <?php endif; ?>

                          <?php endforeach; ?><!-- item foreach -->

                        </table>

                      <?php else: ?>

                        <!-- 條列式 table -->
                        <p style="line-height: 36px; text-align: left; font-size: 1em;"><?=$ShareProject?></p><!-- prompt -->
                        <table class='listing_table'>

                          <tr>
                            <td style="width: 16%;"><?=$SharedProject?></td>
                            <td style="width: 27%;"><?=$ButtonName?></td>
                            <td ><?=$ShareProjectContent?></td>
                            <td style="width: 7%;"><input type='checkbox' title='<?=$SelectAll?>' class='checkbox_zoom checkall'></td>
                          </tr>
                          
                          <!-- item foreach -->
                          <?php foreach ($sg_value as $key => $value): ?>

                            <?php if (!empty($share_data[$value]['id'])): ?>

                              <?php foreach ($share_data[$value]['id'] as $sd_key => $sd_value): ?>

                                <tr>
                                  <td><?=$share_item_string[$value]?></td>
                                  <td><?=$share_data[$value]['btnname'][$sd_key]?></td>
                                  <td><div class='shorter' title='<?=$share_data[$value]['link'][$sd_key]?>'><?=$share_data[$value]['value'][$sd_key]?></div></td>
                                  <td>
                                    <? if(!$share_data[$value]['disabled'][$sd_key]): ?>
                                      <input type='checkbox' class='checkbox_zoom' name='check_share[]' value='^#<?=$value?>^#<?=$sd_value?>' <?=$share_data[$value]['checked'][$sd_key]?>>
                                    <?php endif; ?>
                                  </td>
                                </tr>
                            
                              <?php endforeach; ?>

                            <?php else: ?>
                              
                              <?php if ($value == 'website' || $value == 'iqr_html'): ?>
                                <?php if ($pages_all_empty): ?>
                                  <?php if ($value == 'website'): ?>
                                    <td style="padding: 20px;" colspan="4"><?=$NoInformationShared?></td>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php else: ?>
                                <td style="padding: 20px;" colspan="4"><?=$NoInformationShared?></td>
                              <?php endif; ?>

                            <?php endif; ?>

                          <?php endforeach; ?><!-- item foreach -->

                        </table>

                      <?php endif; ?>

                      <div style="text-align: center;"><input class="aa3 opendialog" type='button' name='opendialog' value='<?=$SetShare?>'></div>
                      <input type='submit' name='form_submit' id='form_submit' style="display: none;">

                    </div>
                  <?php endforeach; ?><!-- 群組 foreach -->

                </div>

              <?php else: ?>

                沒有任何資料可以共享

              <?php endif; ?>

            </p><br><span style='color: #888888; font-size: 1.2em;'><?=$QuestionRightDescription?></span>
            

          </div>
        </div>

        <div class="clear"></div>
        <input type='hidden' name='auth_type' id='auth_type' value='<?=$auth_type?>'>
        <input type='hidden' name='default_quote' id='default_quote' value=''>
        <input type='reset'  name='reset' id='reset' style="display:none;">
      </form>
    </div><!-- w1024 -->
    <div id="advertisement"><a href="#"><img style="border:0px;" src="/images/style_01/gotop.png"></a></div>
  </div><!-- container -->

  <div id="dialog" title="<?=$SetDescription?>">
    <p style="line-height: 26px;"><?=$WhenSelectSave?><span style="color: red;"><?=$SpecialTips?></span></p>
    <p style="line-height: 26px;">&nbsp;</p>
    <p style="line-height: 26px;"><?=$SelectSuggest?></p>
    <p style="line-height: 26px;"><?=$StoreOnly_1?></p>
    <p style="line-height: 26px;"><?=$ApplySubAccount_2?></p>
    <p style="line-height: 26px;"><?=$ApplySubAccount_3?></p>
    <p style="line-height: 26px;"><?=$SelectCancel_4?></p>
    <p style="line-height: 26px;"><?=$ContinueSetting_5?></p>
  </div>

  <?php
    // footer
    $this->load->view('business/footer', $data);
  ?>
  <script type='text/javascript' src="/js/share_setting.js"></script>
  <script type='text/javascript' src="/js/exchange.js"></script>

  </body>
</html>
