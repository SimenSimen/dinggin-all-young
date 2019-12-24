<!doctype html>
<html>
<head>

  <!–[if IE]>
  <script src='https://html5shiv.googlecode.com/svn/trunk/html5.js'></script>
  <![endif]–>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=1024">

  <!-- seo -->
  <title><?=$_CustomForms?> <?=$web_config['title']?></title>
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
  <link type="text/css" rel="stylesheet" href="/css/pageguide/edit_integrate.css">   
  <link type="text/css" rel="stylesheet" href="/css/pageguide/pageguide.css">
  <link type="text/css" rel="stylesheet" href="/css/pageguide/main.css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="/css/eform.css">
  <link type="text/css" rel="stylesheet" href="/css/global.css" media="screen">
  
  <!-- jQuery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

  <!-- js -->
  <script type="text/javascript" src="/js/pageguide.js"></script>
  <script type="text/javascript" src="/js/eform.js"></script>

  <!--預覽區內容縮放修正-->
  <style type="text/css">
    <?if($iqr['theme_id'] >= 2):?>
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
    .set_center { text-align: center; }
  </style>
  <script type="text/javascript">
    var browser = (/Firefox/i.test(navigator.userAgent)) ? 'Firefox' :
    (/Chrome/i.test(navigator.userAgent)) ? 'Chrome' :
    (/MSIE/i.test(navigator.userAgent)) ? 'IE' :
    '<?=$NotFirefoxChromIE?>';

    $(function(){
      <?if($iqr['theme_id'] >= 2):?>
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
    
    
<!--左-->
  <div id="con-eform" style="height: 1332px;">
   <div class="step-docUP-1">
    <?php if($uform_category_num == 0): ?>
      <h2 class="boxs_title"><?=$NoAnyClassType?></h2>
    <?php else: ?>
      <h2 class="boxs_title"><?=$NowHave?><?=$uform_category_num?><?=$_ClassType?></h2>
    <?php endif; ?>
    <input type='button' class='aa2' id='add_uform_category' value='+ <?=$NewClassType?>'>
    <table id="uform_category_table" style="width: 98%;">
      <tr>
        <td style="width:70px;" align="center"><?=$Number?></td>
        <td style="width:230px;" align="center"><?=$Name_2?></td>
        <td style="width:90px;" align="center"><?=$Operating?></td>
      </tr>
      <?php if(!empty($uform_category)): ?>
        <?php foreach ($uform_category as $key => $value): ?>
          <tr>
              <td align="center"><?=$key+1?></td>
              <td align="center"><?=$value['name']?></td>
              <td align="center">
                <a class="edit_category aa5" style="cursor:pointer;margin-left:0px;" id="<?=$value['cid']?>" title='<?=$ModifyClassName?>'><i class="fa fa-pencil-square-o" style="font-size: 1.3em;"></i></a>
                <a class="del_category aa5" style="cursor:pointer;margin-left:0px;" id="<?=$value['cid']?>" title='<?=$DeleteClass?>'><i class="fa fa-times" style="font-size: 1.3em;"></i></a>
                <input type="hidden" id='del_mid_<?=$value['cid']?>' title="<?=$value['name']?>" value="<?=$value['member_id']?>">
              </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td align="center" colspan="3"><?=$NoInformation?></td>
        </tr>
      <?php endif; ?>
    </table>
   </div>
    <div class="step-docUP-1">

      <?php if ($uform_num == 0): ?>
        <h2 class="boxs_title" id='uform_boxs_title'><?=$NoAnyFrom?></h2>
      <?php else: ?>
        <h2 class="boxs_title" id='uform_boxs_title'><?=$NowHave?><?=$uform_num?><?=$_RegistrationForm?></h2>
      <?php endif; ?>
      <input type='button' class='aa2' id='add_uform' value='+ <?=$AddSignUpForm?>'>

      <div class="imgUPss">

        <!--原始顯示區-->
        <div class='switch_uform' id='uform_view' style="display:none;">
          <?php if (!empty($uform)): ?>
            <table id='ori_uform_table' class='uform_management_table'>

              <?php foreach ($uform as $key => $value): ?>

                  <?php if ($key % 10 == 0): ?>
                    <tr>
                      <td align="center" style="width:50px;"><?=$Number?></td>
                      <td align="center" style="width:110px;"><?=$ClassType?></td>
                      <td style="width:230px;"><?=$SignUpEnrollment?></td>
                      <td align="center" style="width:50px;"><?=$PeopleNum?></td>
                      <td align="center" style="width:70px;"><?=$ButtonStatus?></td>
                      <td align="center" style="width:130px;"><?=$Operating?></td>
                    </tr>
                  <?php endif; ?>

                  <tr>
                    <td align="center"><?=($key+1)?></td>
                    <td align="center" title="<?=$value['category_name']?>"><?=mb_substr($value['category_name'], 0, 8, 'utf-8')?><?php if(strlen($value['category_name']) > 10):?>...<?php endif; ?></td>
                    <td><div class='uform_ori_name'><a title='<?=$value['ufm_name']?>' class='sign_up aa5' style="margin-left:0px;" id='sign_up_<?=$value['ufm_id']?>'><?=$value['ufm_name']?></a><input type='hidden' id='mid' value='<?=$mid?>'></div></td>
                    <td align="center">
                      <?php if ($ufm_sudata[$key] == 1): ?>
                        <a class='download_excel aa5' style="margin-left:0px;" href='/business/export/sign_up_<?=$value['ufm_id']?>/<?=$mid?>' title='<?=$DownloadExcel?>'><?=$ufm_su_number[$key]?></a>
                      <?php else: ?>
                        無
                      <?php endif; ?>
                    </td>
                    <td align="center"><?=$ufm_status[$key]?></td>
                    <td align="center">

                      <a class='sign_up_page aa5' style="margin-left:0px;" id='p<?=$value['ufm_id']?>' title='<?=$QuickLink?>'><i class="fa fa-qrcode" style=' font-size: 1.3em;'></i></a>
                      <a class='edit_page aa5' style="margin-left:0px;" id='ed<?=$value['ufm_id']?>' title='<?=$ModifyFormContent?>'><i class="fa fa-pencil-square-o" style=' font-size: 1.3em;'></i></a>
                      <a class='copy_page aa5' style="margin-left:0px;" id='cp<?=$value['ufm_id']?>' title='<?=$CopyForm?>'><i class="fa fa-files-o" style=' font-size: 1.3em;'></i></i></a>
                      
                    </td><!--/form/index/<?=$value['ufm_id']?>-->
                  </tr>
              <?php endforeach; ?>
            </table>
          <?php endif; ?>
        </div>
        <!--原始顯示區結束-->
        
        <!--排序區-->
        <div class='switch_uform' id='uform_sort' style="display:none;">
          <?php if (!empty($uform)): ?>
          <?echo form_open("/business/uform_sort", array('name'=>'form_uform_sort', 'id'=>'form_uform_sort'));?>
            <table id='uform_sort_table' class='uform_management_table'>

              <tr>
                <td align="center" width="10%"><?=$Number?></td>
                <td><?=$SignUpName?></td>
              </tr>

              <tbody id='uform_sortable'>
              <?php foreach ($uform as $key => $value): ?>

                  <tr>
                    <td align="center"><?=($key+1)?></td>
                    <td>
                        <div class='uform_name_td'><?=$value['ufm_name']?></div>
                        <input type='hidden' name='uform_sort_id[]' value='<?=$value['ufm_id']?>'>
                    </td>
                  </tr>

              <?php endforeach; ?>
              </tbody>

            </table>
          </form>
          <?php endif; ?>
        </div>
        <!--排序區結束-->

        <!--編輯按鈕名稱區-->
        <div class='switch_uform' id='uform_name_edit' style="display:none;">
          <?php if (!empty($uform)): ?>
          <?echo form_open("/business/uform_edit_btn_name", array('name'=>'form_uform_edit_btn_name', 'id'=>'form_uform_edit_btn_name'));?>
            <table id='uform_edit_btn_table' class='uform_management_table personal-info'>

              <tr>
                <td align="center" width="10%"><?=$Number?></td>
                <td><?=$SignUpName?></td>
                <td><?=$CustomButtonsName?></td>
              </tr>

              <tbody id='uform_sortable'>
              <?php foreach ($uform as $key => $value): ?>
                    
                    <tr>
                      <td align="center"><?=($key+1)?></td>
                      <td><div class='uform_name_td'><?=$value['ufm_name']?></div></td>
                      <td>
                        <input type='text' placeholder='<?=$StrNum15?>' class='iii2' style="width:80%;" maxlength="15" name='uform_name[<?=$value['ufm_id']?>]' value='<?=$value['ufm_btn_name']?>'>
                        <a href="#" class="why">?</a>
                        <div class='prompt-box'>
                          <p><?=$LimitButtonName?></p>
                          <p><?=$NotShowAllName?></p>
                        </div>
                      </td>
                    </tr>

              <?php endforeach; ?>
              </tbody>

            </table>
          </form>
          <?php endif; ?>
        </div>
        <!--編輯按鈕名稱結束-->

        <!--移除報名表單區-->
        <div class='switch_uform' id='uform_delete' style="display:none;">
          <?php if (!empty($uform)): ?>
          <?echo form_open("/business/uform_switch", array('name'=>'form_uform_remove', 'id'=>'form_uform_remove'));?>
            <table id='uform_remove' class='uform_management_table'>
              <tr>
                <td style="width: 15%;"><input type="checkbox" name='clickAll2' id='clickAll2' />&nbsp;<?=$SelectAll?></td>
                <td>報名表單<?=$Name_2?></td>
                <td width="14%" align="center"><?=$ButtonStatus?></td>
              </tr>
              <?php foreach ($uform as $key => $value): ?>
                  <tr class='<?=$ufm_status_color[$key]?>'>
                    <td><input type="checkbox" name='uform_switch_id[]' class='uform_switch_id' value='<?=$value['ufm_id']?>' />&nbsp;&nbsp;<?=($key+1)?></td>
                    <td>
                        <div class='uform_ori_name'><?=$value['ufm_name']?></div>
                    </td>
                    <td align="center"><?=$ufm_status[$key]?></td>
                  </tr>
              <?php endforeach; ?>
            </table>
            <input type='hidden' name='uform_ctrl_type' id='uform_ctrl_type'>
          </form>
          <?php endif; ?>
        </div>
        <!--移除報名表單結束-->

      </div>
      <!--imgUPss  結束-->

      <!--切換按鈕-->
      <div class="aaCenter">
        <div class="bottom_uform_button" id='bottom_uform_button'>
          <input type='button' class='aa6' id='uform_sort_btn' value='<?=$SequenceFrom?>'>
          <input type='button' class='aa6' id='uform_edit_btn' value='<?=$EditButtonName?>'>
          <input type='button' class='aa6' id='uform_del_btn' value='<?=$StatusEditDel?>'>
        </div>
        <div class="bottom_uform_button" id='uform_sort_button' style="display:none;">
            <input type='button' class='aa6' id='uform_sort_submit' value='<?=$SaveSingUpSequence?>'>
            <input type='button' class='aa6 uform_cancel_btn' value='<?=$Cancle?>'>
        </div>
        <div class="bottom_uform_button" id='uform_edit_note_button' style="display:none;">
            <input type='button' class='aa6' id='uform_btn_name_submit' value='<?=$SaveSingUpName?>'>
            <input type='button' class='aa6 uform_cancel_btn' value='<?=$Cancle?>'>
        </div>
        <div class="bottom_uform_button" id='uform_remove_button' style="display:none;">
            <input type='button' class='aa6' id='uform_open_submit' value='<?=$Open?>'>
            <input type='button' class='aa6' id='uform_remove_submit' value='<?=$Close?>'>
            <input type='button' class='aa6' id='uform_delete_submit' value='<?=$Delete?>'>
            <input type='button' class='aa6 uform_cancel_btn' value='<?=$Cancle?>'>
        </div>
      </div>
                                    
    </div><!-- step-docUP-1 結束 --> 

    <?php if (intval($user_auth) > 1): ?>
      <!-- step-docUP-2 --> 
      <div class="step-docUP-2">
        <?php if (empty($quote_uform)): ?>
          <h2 class="boxs_title" id='uform_boxs_title'><?=$NoQuoteAnyFrom?></h2>
        <?php else: ?>
          <h2 class="boxs_title" id='uform_boxs_title'><?=$RegistrationFormNum?><?=count($quote_uform)?></h2>
        <?php endif; ?>
        <div class="imgUPss">
          <!--原始顯示區-->
          <div>
            <?php if (!empty($quote_uform)): ?>
              <table id='ori_uform_table' class='uform_management_table'>
                <?php foreach ($quote_uform as $key => $value): ?>
                  <?php if ($key % 10 == 0): ?>
                    <tr>
                      <td class='set_center'><?=$Number?></td>
                      <td><?=$SignUpEnrollment?></td>
                      <td class='set_center'><?=$PeopleNum?></td>
                      <td class='set_center'><?=$Operating?></td>
                    </tr>
                  <?php endif; ?>
                  <tr>
                    <td class='set_center'><?=($key+1)?></td>
                    <td><a title='<?=$value['ufm_name']?>' class='sign_up aa5' style="margin-left:0px;" id='sign_up_<?=$value['ufm_id']?>'><?=$value['ufm_name']?></a></td>
                    <td class='set_center'>
                      <?php if ($quote_uform_sudata[$key] == 1): ?>
                        <a class='download_excel aa5' style="margin-left:0px;" href='/business/export/sign_up_<?=$value['ufm_id']?>/<?=$mid?>' title='<?=$DownloadExcel?>'><?=$quote_uform_sunumber[$key]?></a>
                      <?php else: ?>
                        <?=$No?>
                      <?php endif; ?>
                    </td>
                    <td class='set_center'><a class='sign_up_page aa5' style="margin-left:0px;" id='p<?=$value['ufm_id']?>' title='<?=$QuickLink?>'><i class="fa fa-qrcode" style=' font-size: 1.3em;'></i></a></td>
                  </tr>
                <?php endforeach; ?>
              </table>
            <?php endif; ?>
          </div>
          <!--原始顯示區結束-->
        </div>
      </div><!-- step-docUP-2 結束 --> 
    <?php endif; ?>



  </div><!-- 左   結束 -->

<?
  //preview_iframe
  // $this->load->view('business/preview_iframe', $data);
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

</body>
</html>
