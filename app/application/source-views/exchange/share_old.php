<!doctype html>
<html>
  <head>
    
    <!–[if IE]>
    <script src=」http://html5shiv.googlecode.com/svn/trunk/html5.js」>
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
  
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
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
            <p style="line-height: 36px; text-align: left; font-size: 1.5em;">共享設定
            <a href="#" class="why" id="why_panel" style="position: relative; top: 6px;">?</a>
            全選所有分頁項目&nbsp;<input type='checkbox' title='全選所有分頁項目' class='checkbox_zoom check_tabs_all'>
            <div class="prompt-box" id="prompt_panel" style="display: none;">
              <p>提醒您</p>
              <p>1. 使用表格右上(或上)方「全選」時，系統只會勾選當個分頁的所有可勾選欄位，並不會跨分頁或跨表格勾選</p>
              <p>2. 使用「全選所有分頁項目」時，系統會變更所有分頁的勾選欄位</p>
              <p>3. 「設定共享」按鈕是儲存所有分頁中的勾選狀態的；例如說，當您在「A分頁」勾選某項目之後，</p>
              <p>　&nbsp;直接切換到「B分頁」進行勾選，並於「B分頁」設定共享，此時「A、B分頁」已勾選的共享項目將同時被儲存</p>
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
                        <p style="line-height: 36px; text-align: left; font-size: 1em;">勾選您要共享的圖片然後按「設定共享」</p><!-- prompt -->
                        <?php foreach ($sg_value as $key => $value): ?><!-- foreach album -->

                          <p style="line-height: 36px; text-align: left; font-size: 1em;"><?=$share_item_string[$value]?></p><!-- album name -->

                          <table class='listing_table'>

                            <tr><td colspan="5" style="text-align: center; cursor: pointer;" class='checkall_td'>點此全選&nbsp;&nbsp;<input style="display: none;" type='checkbox' title='全選' class='checkbox_zoom checkall'></tr>

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

                              <td style="padding: 20px;" colspan="5">您尚未有任何資料可以共享</td>

                            <?php endif; ?>

                          </table>
                          <p>&nbsp;</p>

                        <?php endforeach; ?><!-- 特製 table for images-->

                      <?php elseif ($sg_key == 'files'): ?>

                        <!-- 特製 table for files -->
                        <p style="line-height: 36px; text-align: left; font-size: 1em;">勾選您要共享的檔案然後按「設定共享」</p><!-- prompt -->
                        <table class='listing_table'>

                          <tr>
                            <td style="width: 20%;">共享項目</td>
                            <td style="width: 30%;">原始名稱</td>
                            <td style="width: 30%;">按鈕名稱</td>
                            <td style="width: 10%;">連結</td>
                            <td style="width: 10%;"><input type='checkbox' title='全選' class='checkbox_zoom checkall'></td>
                          </tr>
                          
                          <!-- item foreach -->
                          <?php foreach ($sg_value as $key => $value): ?>

                            <?php if (!empty($share_data[$value]['id'])): ?>

                              <?php foreach ($share_data[$value]['id'] as $sd_key => $sd_value): ?>

                                <tr>
                                  <td style="width: 20%;"><?=$share_item_string[$value]?></td>
                                  <td style="width: 30%;"><div class='shorter_string' title='<?=$share_data[$value]['oriname'][$sd_key]?>'><?=$share_data[$value]['oriname'][$sd_key]?></div></td>
                                  <td style="width: 30%;"><div class='shorter_string' title='<?=$share_data[$value]['btnname'][$sd_key]?>'><?=$share_data[$value]['btnname'][$sd_key]?></div></td>
                                  <td style="width: 10%;"><a class='aa8' href='<?=$share_data[$value]['value'][$sd_key]?>' target='_blank'>檔案連結<!-- <img src='/images/document_icon.png' style='width: 20px;'> --></a></td>
                                  <td style="width: 10%;">
                                    <input type='checkbox' class='checkbox_zoom' name='check_share[]' value='^#<?=$value?>^#<?=$sd_value?>' <?=$share_data[$value]['checked'][$sd_key]?>>
                                  </td>
                                </tr>
                            
                              <?php endforeach; ?>

                            <?php else: ?>

                              <td style="padding: 20px;" colspan="5">您尚未有任何資料可以共享</td>

                            <?php endif; ?>

                          <?php endforeach; ?><!-- item foreach -->

                        </table>
                        
                      <?php elseif ($sg_key == 'uform'): ?>

                        <!-- 特製 table for ufrom -->
                        <p style="line-height: 36px; text-align: left; font-size: 1em;">勾選您要共享的報名表然後按「設定共享」</p><!-- prompt -->
                        <table class='listing_table'>

                          <tr>
                            <td style="width: 16%;">共享項目</td>
                            <td style="width: 32%;">按鈕名稱</td>
                            <td >共享項目內容 (沒有內容時不能共享)</td>
                            <td style="width: 16%;">報名情形</td>
                            <td style="width: 7%;"><input type='checkbox' title='全選' class='checkbox_zoom checkall'></td>
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
                              
                              <td style="padding: 20px;" colspan="5">您尚未有任何資料可以共享</td>
                            
                            <?php endif; ?>

                          <?php endforeach; ?><!-- item foreach -->

                        </table>

                      <?php else: ?>

                        <!-- 條列式 table -->
                        <p style="line-height: 36px; text-align: left; font-size: 1em;">勾選您要共享的項目然後按「設定共享」</p><!-- prompt -->
                        <table class='listing_table'>

                          <tr>
                            <td style="width: 16%;">共享項目</td>
                            <td style="width: 27%;">按鈕名稱</td>
                            <td >共享項目內容 (沒有內容時不能共享)</td>
                            <td style="width: 7%;"><input type='checkbox' title='全選' class='checkbox_zoom checkall'></td>
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
                                    <td style="padding: 20px;" colspan="4">您尚未有任何資料可以共享</td>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php else: ?>
                                <td style="padding: 20px;" colspan="4">您尚未有任何資料可以共享</td>
                              <?php endif; ?>

                            <?php endif; ?>

                          <?php endforeach; ?><!-- item foreach -->

                        </table>

                      <?php endif; ?>

                      <div style="text-align: center;"><input class="aa3 opendialog" type='button' name='opendialog' value='設定共享'></div>
                      <input type='submit' name='form_submit' id='form_submit' style="display: none;">

                    </div>
                  <?php endforeach; ?><!-- 群組 foreach -->

                </div>

              <?php else: ?>

                沒有任何資料可以共享

              <?php endif; ?>

            </p><br><span style='color: #888888; font-size: 1.2em;'>※ 舊版共享引用功能已停用，請重新設定您的共享資料或引用資料，很抱歉造成您的不便。新版使用方式於大標題右方問號說明</span>
            

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

  <div id="dialog" title="設定說明">
    <p style="line-height: 26px;">當您選擇「儲存並套用到子帳戶」，您的網域中所有子帳戶，將直接套用您所設定的共享資料，若您取消勾選了某些資料，則該資料將在所有帳戶被取消引用，<span style="color: red;">特別提醒：當您取消勾選某些資料，請使用「儲存並套用到子帳戶」，才能將子帳戶已經引用的狀態移除</span></p>
    <p style="line-height: 26px;">&nbsp;</p>
    <p style="line-height: 26px;">選擇建議：</p>
    <p style="line-height: 26px;">1. 您需要開啟共享新的資料給子帳戶，卻不想直接設定他們引用 → 「僅儲存」</p>
    <p style="line-height: 26px;">2. 您需要開啟共享新的資料給子帳戶，想直接設定他們引用 → 「儲存並套用到子帳戶」</p>
    <p style="line-height: 26px;">3. 您需要取消勾選，以關閉共享資料 → 「儲存並套用到子帳戶」</p>
    <p style="line-height: 26px;">4. 若您選擇「取消」，您方才於每個分頁所勾選的狀態將會重置，恢復成上一次的設定</p>
    <p style="line-height: 26px;">5. 若您需要繼續設定，請選擇右上角close對話框</p>
  </div>

  <?php
    // footer
    $this->load->view('business/footer', $data);
  ?>
  <script type='text/javascript' src="/js/share_setting.js"></script>
  <script type='text/javascript' src="/js/exchange.js"></script>

  </body>
</html>
