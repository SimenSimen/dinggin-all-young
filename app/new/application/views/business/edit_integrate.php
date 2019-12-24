<!doctype html>
<html>
<head>

  <!–[if IE]>
  <script src='http://html5shiv.googlecode.com/svn/trunk/html5.js'></script>
  <![endif]–>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=1024">

  <!-- seo -->
  <title><?=$_PersonalInformation?> <?=$web_config['title']?></title>
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
  <link type="text/css" rel="stylesheet" href="/css/validation.css">
  <link type="text/css" rel="stylesheet" href="/css/pageguide/edit_integrate.css">   
  <link type="text/css" rel="stylesheet" href="/css/pageguide/pageguide.css">
  <link type="text/css" rel="stylesheet" href="/css/pageguide/main.css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="/css/global.css" media="screen">
  
  <!-- jQuery -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">
  <!-- js -->
  <script>
    var language = "<?=$lang?>";
    switch (language) {
      case 'zh-tw':
        var _SetCkeditorLanguage = 'zh';
        break;
      case 'zh-cn':
        var _SetCkeditorLanguage = 'zh-cn';
        break;
      case 'english':
        var _SetCkeditorLanguage = 'en';
        break;
      default:
        var _SetCkeditorLanguage = '';
        break;
    }
  </script>
  <script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script>
  <!--<script type="text/javascript" src="/js/pageguide.js"></script>-->

  <!-- validate -->
  <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
  <script type="text/javascript" src="/js/messages_tw.js" charset="utf-8"></script>
  <script type="text/javascript" src="/js/edit_integrate_validation.js" charset="utf-8"></script>

  <style type="text/css">
    .ui-dialog-titlebar-close
    {
      background-image: url(/images/close-icon.png);
      background-size: cover;
    }

    /* 預覽區內容縮放修正 */
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

    /* 編輯區塊分類 fieldset */
    #app-fieldset {
      border: 1px groove rgb(0, 0, 0, 1) !important;
      padding: 0 1.4em 1.4em 1.4em !important;
      margin: 0 0 1.5em 0 !important;
      -webkit-box-shadow: 0px 0px 0px 0px #ffffff;
      box-shadow: 0px 0px 0px 0px #ffffff;
    }

    legend { text-align: right; }
  </style>

  <script type="text/javascript">
    $(function () {
      $(window).scroll(function () {
        if($(window).scrollTop() > $('#container').offset().top +10)
        {
          $('nav').addClass('visible');
        // alert($(window).scrollTop() +'#'+ $('nav').offset().top)
        }
        else
          $('nav').removeClass('visible');
      });
    });

    //leave check
    // window.onbeforeunload = function()
    // { 
    // 　　return "請確認您已儲存編輯資料"; 
    // }

    var browser = (/Firefox/i.test(navigator.userAgent)) ? 'Firefox' :
    (/Chrome/i.test(navigator.userAgent)) ? 'Chrome' :
    (/MSIE/i.test(navigator.userAgent)) ? 'IE' :
    '非 Firefox/Chrom/IE 瀏覽器';

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
      
      $('#chk_to_cpy_data').attr('disabled', 'disabled');
      $('.mcard_tr').hide();

      //sortable ui
      $('#titlename_tbody').sortable();
      $('#address_tbody').sortable();
      $('#website_tbody').sortable();
      $('#ytb_category_tbody').sortable();
      $('#mobile_phones_tbody').sortable();
      $('#iqr_classify_tbody').sortable();
      $('#ytb_link_tbody').sortable();
    });
  </script>

</head>

<body scroll="yes" style="overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

<?
  //header
  $this->load->view('business/header', $data);
?>
  
<div id="container"><div class="w1024">
    
  <div class="bar">
    <p>
      <span class="star">*</span><?=$RequiredField?>&nbsp;&nbsp;&nbsp;
      <span class="dd3"></span><?=$MoveMouse?>&nbsp;<a href="#" class="why" tabindex = "-1">?</a><?=$ShowDataEx?>
    </p>
  </div>
        
    
  <?echo form_open_multipart("/business/edit", array('id'=>'form_business'));?>
    
  <div id="con-L">

    <div>   

      <table border="0" cellspacing="0" cellpadding="0" class="personal-info">

        <tr>
          <td class="step-info-01">

            <fieldset id='app-fieldset' style='border: 1px groove #ffffff;'>
            <legend align="right">&nbsp;<?=$BriefIntroduction?>&nbsp;<input style="font-size: 17px; padding: 5px 10px 5px 10px; margin: 0px;" class="aa3" type='submit' name='form_submit' onclick="window.onbeforeunload=null;return true;" value='<?=$SaveEdit?>'>&nbsp;</legend>

              <p>&nbsp;</p>
              <p>

                <table border="0" cellspacing="0" cellpadding="0" class="personal-info">

                  <tr>
                    <td class="dd1"><span class="star">*</span></td>
                    <td class="dd2"><?=$FullName?></td>
                    <td class="dd3">
                      <input type='text' placeholder='<?=$Surname?>' maxlength="16" name='l_name' id='l_name' value='<?=$iqr['l_name']?>'>
                      <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$ScanSurname?></div>
                      <input type='text' class="required" placeholder='<?=$Name?>' maxlength="16" name='f_name' id='f_name' value='<?=$iqr['f_name']?>'>
                      <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$ScanChName?></div>
                    </td>
                  </tr>

                  <!--手機-->
                  <tr>
                    <td>&nbsp;</td>
                    <td class="dd2"><?=$Phone?><br><br><a class="aa7" href="javascript:void(0);" id="add_mobile_phones"><?=$Add?></a></td>
                    <td>
                      <input type='text' placeholder='<?=$ButtonShowName?>' name='mobile_name' id='mobile_name' value='<?=$iqr['mobile_name']?>' maxlength='15'>
                      <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$ScanPhoneNumber?></div>
                      <input type='text' class="number" placeholder='<?=$PhoneNumber?>' name='mobile' id='mobile' value='<?=$iqr['mobile']?>'>
                      <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$ScanPhoneNumberEx?></div>

                        <table id="mobile_phones_table">
                          <tbody id="mobile_phones_tbody">
                            <?php if(!empty($mobile_phones)): ?>
                              <?php foreach ($mobile_phones as $key => $value): ?>
                                <tr>
                                  <td>
                                    <input style="width:140px;" type='text' class='iii3' placeholder='<?=$_ButtonShowName?>' name='mobile_phones_name[<?=$mobile_phones_id[$key]?>]' id='mobile_phones_name_<?=$mobile_phones_id[$key]?>' value='<?=$mobile_phones_name[$key]?>'>&nbsp;<a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$ScanPhoneNumber?></div>
                                    <input style="width:140px;" type='text' class='iii3' placeholder='<?=$PhoneNumber?>' name='mobile_phones[<?=$mobile_phones_id[$key]?>]' id='mobile_phones_<?=$mobile_phones_id[$key]?>' value='<?=$value?>'>&nbsp;<a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$ScanPhoneNumberEx?></div>
                                    &nbsp;<a href='javascript:void(0);' class='aa2 del_mobile_phones' id='del_mobile_phones_<?=$mobile_phones_id[$key]?>'><?=$Remove?></a>
                                  </td>
                                </tr>
                              <?php endforeach; ?>
                                <span class='mobile_phones_empty_text'></span>
                            <?php endif; ?>
                          </tbody>
                        </table>
                        <input type='hidden' name='mobile_phones_num' id='mobile_phones_num' value='<?=$mobile_phones_num?>'>
                        <input type='hidden' value='<?=$sys_mobile_phones_num?>' id='sys_mobile_phones_num'>
                    </td>
                  </tr>

                  <!--英文名-->
                  <tr>
                    <td>&nbsp;</td>
                    <td class="dd2"><?=$EnglishName?></td>
                    <td>
                      <input type='text' placeholder='<?=$EnName?>' maxlength="16" name='f_en_name' id='f_en_name' value='<?=$iqr['f_en_name']?>'>
                      <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$ScanEnName?></div>
                      <input type='text' placeholder='<?=$EnFirstName?>' maxlength="16" name='l_en_name' id='l_en_name' value='<?=$iqr['l_en_name']?>'>
                      <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$ScanEnSurname?></div>
                    </td>
                  </tr>

                  <!--<?=$Title?>-->
                  <tr>
                    <td>&nbsp;</td>
                    <td class="dd2"><?=$Title?><br><br><a class="aa7" href="javascript:void(0);" id="add_titlename"><?=$Add?></a></td>
                      <td>
                        <table id='titlename_table'>
                          <tbody id='titlename_tbody'>
                            
                            <?php if (!empty($titlename)): ?>
                              <?php foreach ($titlename as $key => $value): ?>
                                <tr>
                                    <td>
                                      <input type='text' class='iii3' placeholder='<?=$RequiredTitle?>' name='titlename[<?=$titlename_id[$key]?>]' id='titlename_<?=$titlename_id[$key]?>' value='<?=$value?>'>&nbsp;<a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$FillTitle?></div>
                                      &nbsp;<a class="aa2" href="javascript:void(0);" title='<?=$ClickSortingBoxes?>'><?=$Sequence?></a>&nbsp;<a href='javascript:void(0);' class='aa2 del_titlename' id='del_titlename_<?=$titlename_id[$key]?>'><?=$Remove?></a>
                                    </td>
                                </tr>
                              <?php endforeach; ?>
                                <span class='titlename_empty_text'></span>
                              <?php else: ?>
                                <span class='titlename_empty_text'><?=$NotAnyTitle?></span>
                              <?php endif; ?>

                          </tbody>
                        </table>
                        <input type='hidden' name='titlename_num' id='titlename_num' value='<?=$titlename_num?>'>
                        <input type='hidden' value='<?=$sys_titlename_num?>' id='sys_titlename_num'>
                      </td>
                  </tr>

                  <!--自我介紹-->
                  <tr>
                    <td>&nbsp;</td>
                    <td class="dd2"><?=$SelfIntroduction?><br><br><a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$FillSelfIntroduction?></div></td>
                    <td><textarea name='introduce' id='introduce' maxlength='255'><?=$iqr['introduce']?></textarea>
                  </tr>

                </table>
              </p>

            </fieldset>
          </td>
        </tr>

        <tr>
          <td class="step-info-02">

            <fieldset id='app-fieldset' style='border: 1px groove #ffffff;'>
            <legend align="right">&nbsp;<?=$CompanyInformation?>&nbsp;<input style="font-size: 17px; padding: 5px 10px 5px 10px; margin: 0px;" class="aa3" type='submit' name='form_submit' onclick="window.onbeforeunload=null;return true;" value='<?=$SaveEdit?>'>&nbsp;</legend>

              <p>&nbsp;</p>
              <p>

                <table border="0" cellspacing="0" cellpadding="0" class="personal-info">

                  <!--公司電話-->
                  <tr>
                    <td class="dd1">&nbsp;</td>
                    <td class="dd2"><?=$CompanyPhone?></td>
                    <td class="dd3">
                      <input type='text' placeholder='<?=$ButtonShowName?>' name='cpn_phone_name' id='cpn_phone_name' value='<?=$iqr['cpn_phone_name']?>' maxlength='15'>
                      <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$ScanService?></div>
                      <input type='text' class="number" placeholder='<?=$CompanyPhone?>&nbsp;<?=$HaveAreaCode?>' name='cpn_phone' id='cpn_phone' value='<?=$iqr['cpn_phone']?>'>#
                      <input type='text' class="number" placeholder='<?=$Extension?>' name='cpn_extension' id='cpn_extension' value='<?=$iqr['cpn_extension']?>' style='width:80px;'>
                      <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$ScanFhone?></div>
                    </td>
                  </tr>
                  <!--傳真號碼-->
                  <tr>
                    <td class="dd1">&nbsp;</td>
                    <td class="dd2"><?=$Fax?></td>
                    <td class="dd3">
                      <input type='text' placeholder='<?=$ButtonShowName?>' name='cpn_fax_name' id='cpn_fax_name' value='<?=$iqr['cpn_fax_name']?>' maxlength='15'>
                      <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$ScanCompany?></div>
                      <input type='text' class="number" placeholder='<?=$Fax?>&nbsp;<?=$HaveAreaCode?>' name='cpn_cfax' id='cpn_cfax' value='<?=$iqr['cpn_cfax']?>'>
                      <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$ScanFax?></div>
                    </td>
                  </tr>
                  <!--公司統編-->
                  <tr>
                    <td class="dd1">&nbsp;</td>
                    <td class="dd2"><?=$CompanyNum?></td>
                    <td class="dd3">
                      <input type='text' placeholder='<?=$ButtonShowName?>' name='cpn_number_name' id='cpn_number_name' value='<?=$iqr['cpn_number_name']?>' maxlength='15'>
                      <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$ScanShow?></div>
                      <input type='text' class="number" placeholder='<?=$CompanyNum?>' name='cpn_number' id='cpn_number' value='<?=$iqr['cpn_number']?>' minlength='8' maxlength='8'>
                      <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$ScanTongBian?></div>
                    </td>
                  </tr>

                </table>
              </p>

            </fieldset>
          </td>
        </tr>

        <tr>
          <td class="step-info-03">

            <fieldset id='app-fieldset' style='border: 1px groove #ffffff;'>
            <legend align="right">&nbsp;<?=$Communication?>&nbsp;<input style="font-size: 17px; padding: 5px 10px 5px 10px; margin: 0px;" class="aa3" type='submit' name='form_submit' onclick="window.onbeforeunload=null;return true;" value='<?=$SaveEdit?>'>&nbsp;</legend>

              <p>&nbsp;</p>
              <p>

                <table border="0" cellspacing="0" cellpadding="0" class="personal-info">

                  <!--email-->
                  <tr>
                    <td class="dd1">&nbsp;</td>
                    <td class="dd2"><?=$Email?></td>
                    <td class="dd3">
                      <input type='text' placeholder='<?=$ButtonShowName?>' name='email_name' id='email_name' value='<?=$iqr['email_name']?>' maxlength='15'>
                      <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$ScanEmail?></div>
                      <input type='text' class="iii1" placeholder='<?=$Email?> E-mail' name='email' id='email' value='<?=$iqr['email']?>'>
                      <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$ScanOftenEmail?></div>
                    </td>
                  </tr>

                  <!--Skype-->
                  <tr>
                    <td>&nbsp;</td>
                    <td class="dd2">Skype</td>
                    <td>
                      <input type='text' placeholder='<?=$ButtonShowName?>' name='skype_name' id='skype_name' value='<?=$iqr['skype_name']?>' maxlength='15'>
                      <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$ScanSkype?></div>
                      <input class="iii1" placeholder='<?=$Skype_ios?>' type='text' name='skype' id='skype' value='<?=$iqr['skype']?>'>
                      <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$SetSkype?></div>
                    </td>
                  </tr>

                  <!--Facebook-->
                  <tr>
                    <td>&nbsp;</td>
                    <td class="dd2">Facebook</td>
                    <td>
                      <input type='text' placeholder='<?=$ButtonShowName?>' name='facebook_name' id='facebook_name' value='<?=$iqr['facebook_name']?>' maxlength='15'>
                      <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$ScanFacebook?></div>
                      <input type='text' class="iii1" placeholder='<?=$FBFansBlog?>' name='facebook' id='facebook' value='<?=$iqr['facebook']?>'>
                      <a href="#" class="why" tabindex = "-1">?</a>
                      <div class='prompt-box'>
                        <p><?=$SetFacebook?></p>
                        <p><?=$FansUrlEx?></p>
                        <p><?=$FBSetUrl?></p>
                        <p><?=$NotSetUrl_2?></p>
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;<?=$OriginalUrl?></p>
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;<?=$AfterRemoval?></p>
                        <p></p>
                      </div>
                    </td>
                  </tr>

                  <!--Line-->
                  <tr>
                    <td>&nbsp;</td>
                    <td class="dd2">Line<br><br><a class="aa7" href='/business/line_teach' target='_blank'><?=$Teach?></a></td>
                    <td>
                      <input type='text' placeholder='<?=$ButtonShowName?>' name='line_name' id='line_name' value='<?=$iqr['line_name']?>' maxlength='15'>
                      <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$ScanLine?></div>
                      <input class="iii1" placeholder='<?=$LineUrl?>' type='text' name='line' id='line' value='<?=$iqr['line']?>'>
                      <a href="#" class="why" tabindex = "-1">?</a>
                      <div class='prompt-box'>
                        <p><?=$SetLineQrcode?></p>
                        <p><?=$OpenGetLineUrl?></p>
                      </div>
                    </td>
                  </tr>

                </table>
              </p>

            </fieldset>
          </td>
        </tr>
        
      <?php if(0): ?>    
        <tr>
          <td class="step-info-06">

            <fieldset id='app-fieldset' style='border: 1px groove #ffffff;'>
            <legend align="right">&nbsp;<?=$MovieType?>&nbsp;<?=$DraggableSorting?>
            <input type='button' style="font-size: 17px; padding: 5px 10px 5px 10px; margin: 0px; border: none; cursor: pointer;" class="aa7" id="add_ytb_category" value='<?=$Add?>'>
            <input style="font-size: 17px; padding: 5px 10px 5px 10px; margin: 0px;" class="aa3" type='submit' name='form_submit' onclick="window.onbeforeunload=null;return true;" value='<?=$SaveEdit?>'></legend>
              <p>&nbsp;</p>
              <p>
              <table id='ytb_category_table'>
                  <tr>
                    <td style="text-align:center; width: 12%;"><?=$Number?></td>
                    <td><?=$ClassName?></td>
                    <td style="text-align:center; width: 22%;"><?=$Operating?></td>
                  </tr>
                <tbody id='ytb_category_tbody'>

                  <?php if (!empty($ytb_category)): ?>
                    <?php foreach ($ytb_category as $key => $value): ?>
                      <tr>
                        <input type="hidden" name="ytb_category[]" value="<?=$value['cid']?>">
                        <td style="text-align:center; width: 15%;"><?=($key+1)?></td>
                        <td id='class_name_<?=$value['cid']?>'><?=$value['name']?></td>
                        <td style="text-align:center; width: 30%;">
                          <a class='aa5 ytb_category_edit' id='ytb_category_edit_<?=$value['cid']?>' title='<?=$Modify?>'><i class='fa fa-pencil-square-o'></i></a>
                          <a class='aa5 ytb_category_del'  id='ytb_category_del_<?=$value['cid']?>' title='<?=$Delete?>'><i class='fa fa-times'></i></a>
                        </td>
                      </tr>
                    <?php endforeach; ?>

                  <?php else: ?>
                    <tr id='ytb_category_empty'><td colspan="3"><?=$NotAnyMovieClass?></td></tr>
                  <?php endif; ?>
                  <input type="hidden" id="ytb_category_count" value="<?=$ytb_category_count?>">
                </tbody>
              </table>
              <style type="text/css">
                #ytb_category_table { width: 100%; }
                #ytb_category_table td { border-bottom:1px solid #cccccc; }
                .aa5 {margin-left: 0px; cursor: pointer;}
              </style>
              </p>

            </fieldset>
          </td>
        </tr>

        <tr>
          <td class="step-info-04">

            <fieldset id='app-fieldset' style='border: 1px groove #ffffff;'>
            <legend align="right">&nbsp;<?=$CustomMovieLinkMap?>&nbsp;<input style="font-size: 17px; padding: 5px 10px 5px 10px; margin: 0px;" class="aa3" type='submit' name='form_submit' onclick="window.onbeforeunload=null;return true;" value='<?=$SaveEdit?>'>&nbsp;</legend>

              <p>&nbsp;</p>
              <p>

                <table border="0" cellspacing="0" cellpadding="0" class="personal-info">

                  <!--Youtube-->
                  <tr>
                    <td class="dd1">&nbsp;</td>
                    <td class="dd2">Youtube<br><br><a class="aa7" href="javascript:void(0);" id="add_ytb_link"><?=$Add?></a></td>
                    <td class="dd3">
                        <table id='ytb_link_table'>
                          <tbody id='ytb_link_tbody'>

                            <?php if (!empty($ytb_link)): ?>
                              <?php foreach ($ytb_link as $key => $value): ?>
                                <tr>
                                    <td>
                                      <input style="width:308px;" type='text' placeholder='<?=$MovieTitle?>' name='ytb_link_name[<?=$ytb_link_id[$key]?>]' id='ytb_link_name_<?=$ytb_link_id[$key]?>' value='<?=$ytb_link_name[$key]?>' maxlength='32'>&nbsp;<a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$FillMovieTitle?></div>
                                      <select style="width: 140px;padding: 7px;border: 1px solid #CAC2A9;border-radius: 3px;margin: 0px 3px;font-size: 1em;font-family: 'Microsoft Jhenghei';" name="ytb_link_cid[<?=$ytb_link_id[$key]?>]" id="ytb_link_cid_<?=$ytb_link_id[$key]?>">
                    										<?php foreach ($ytb_category as $c_key => $val): ?>
                    											<option value="<?=$val['cid']?>" <?php if($ytb_link_cid[$key] == $val['cid']):?>selected<?php endif; ?>><?=$val['name']?></option>
                  									    <?php endforeach;?>
                                      </select><br>
                                      <input style="width:342px;" type='text' class="iii2" placeholder='<?=$MovieUrlRequired?>' name='ytb_link[<?=$ytb_link_id[$key]?>]' id='ytb_link_<?=$ytb_link_id[$key]?>' value='<?=$value?>'>
                                      &nbsp;<a class="aa2" href="javascript:void(0);" title='<?=$ClickSortingBoxes?>'><?=$Sequence?></a>&nbsp;<a href='javascript:void(0);' class='aa2 del_ytb_link' id='del_ytb_link_<?=$ytb_link_id[$key]?>'><?=$Remove?></a>
                                    </td>
                                </tr>
                              <?php endforeach; ?>
                                <span class='ytb_link_empty_text'></span>
                              <?php else: ?>
                                <span class='ytb_link_empty_text'><?=$NotAnyMovieUrl?></span>
                              <?php endif; ?>

                          </tbody>
                        </table>
                        <input type='hidden' name='ytb_link_num' id='ytb_link_num' value='<?=$ytb_link_num?>'>
                        <input type='hidden' value='<?=$video_num?>' id='video_num'>
                    </td>
                  </tr>

                  <!--website-->
                  <tr>
                    <td class="dd1">&nbsp;</td>
                    <td class="dd2"><?=$WebSite?><br><br><a class="aa7" href="javascript:void(0);" id="add_website"><?=$Add?></a></td>
                    <td class="dd3">
                        <table id='website_table'>
                          <tbody id='website_tbody'>

                              <?php if (!empty($website)): ?>
                                <?php foreach ($website as $key => $value): ?>
                                  <tr>
                                      <td>
                                        <input type='text' placeholder='<?=$_ButtonShowName?>' name='website_name[<?=$website_id[$key]?>]' id='website_name_<?=$website_id[$key]?>' value='<?=$website_name[$key]?>' maxlength='15'>&nbsp;<a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$FillButtonName?></div>
                                        <input type='text' class="iii2" placeholder='<?=$WebUrlRequired?>' name='website[<?=$website_id[$key]?>]' id='website_<?=$website_id[$key]?>' value='<?=$value?>'>
                                        &nbsp;<a class="aa2" href="javascript:void(0);" title='<?=$ClickSortingBoxes?>'><?=$Sequence?></a>&nbsp;<a href='javascript:void(0);' class='aa2 del_website' id='del_website_<?=$website_id[$key]?>'><?=$Remove?></a>
                                      </td>
                                  </tr>
                              <?php endforeach; ?>
                                <span class='website_empty_text'></span>
                              <?php else: ?>
                                <span class='website_empty_text'><?=$NotAnyUrl?></span>
                              <?php endif; ?>

                          </tbody>
                        </table>
                        <input type='hidden' name='website_num' id='website_num' value='<?=$website_num?>'>
                        <input type='hidden' value='<?=$sys_website_num?>' id='sys_website_num'>
                      </td>
                  </tr>

                  <!--address-->
                  <!-- <tr>
                    <td class="dd1">&nbsp;</td>
                    <td class="dd2">地圖<br><br><a class="aa7" href="javascript:void(0);" id="add_address">新增</a></td>
                    <td class="dd3">
                        <table id='address_table'>
                          <tbody id='address_tbody'>
                                <?php if (!empty($address)): ?>
                                <?php foreach ($address as $key => $value): ?>
                                  <tr>
                                      <td>
                                        <input type='text' placeholder='按鈕顯示名稱' name='address_name[<?=$address_id[$key]?>]' id='address_name_<?=$address_id[$key]?>' value='<?=$address_name[$key]?>' maxlength='15'>&nbsp;<a href="#" class="why" tabindex = "-1">?</a>
                                        <div class='prompt-box'><p>您可以填入「地圖按鈕名稱」與「地址」以新增地圖按鈕</p><p>地址內容可以省略郵遞區號，但請您盡量輸入完整</p></div>
                                        <input type='text' class="iii2" placeholder='地圖地址必填' name='address[<?=$address_id[$key]?>]' id='address_<?=$address_id[$key]?>' value='<?=$value?>'>
                                        &nbsp;<a class="aa2" href="javascript:void(0);" title='按此拖曳排序'>排序</a>&nbsp;<a href='javascript:void(0);' class='aa2 del_address' id='del_address_<?=$address_id[$key]?>'>移除</a>
                                      </td>
                                  </tr>
                              	<?php endforeach; ?>
                                <span class='address_empty_text'></span>
                              <?php else: ?>
                                <span class='address_empty_text'>尚未新增任何地圖地址</span>
                              <?php endif; ?>

                          </tbody>
                        </table>
                        <input type='hidden' name='address_num' id='address_num' value='<?=$address_num?>'>
                        <input type='hidden' value='<?=$sys_address_num?>' id='sys_address_num'>
                      </td>
                  </tr> -->
				  <tr>
                    <td class="dd1">&nbsp;</td>
                    <td class="dd2"><?=$Map?></td>
                    <td class="dd3">
                        <table id='address_table'>
                          <tbody id='address_tbody'>
							<tr>
								<td>
							    	<input type='text' style="width: 490px;" placeholder='<?=$Address?>' name='addr'  value='<?=$iqr['address']?>' maxlength='255'>
								</td>
							</tr>
                          </tbody>
                        </table>
                        <input type='hidden' name='address_num' id='address_num' value='<?=$address_num?>'>
                        <input type='hidden' value='<?=$sys_address_num?>' id='sys_address_num'>
                      </td>
                  </tr>
                </table>
              </p>

            </fieldset>
          </td>
        </tr>
      <?php endif; ?>

        <tr>
          <td class="step-info-05">

            <fieldset id='app-fieldset' style='border: 1px groove #ffffff;'>
            <legend align="right">&nbsp;<?=$_ContactsQRcode?>&nbsp;<input style="font-size: 17px; padding: 5px 10px 5px 10px; margin: 0px;" class="aa3" type='submit' name='form_submit' onclick="window.onbeforeunload=null;return true;" value='<?=$SaveEdit?>'>&nbsp;</legend>

              <p>&nbsp;</p>
              <p>

                <table border="0" cellspacing="0" cellpadding="0" class="personal-info">

                  <!--通訊錄-->
                  <tr>
                    <td class="dd1">&nbsp;</td>
                    <td class="dd2"><?=$Contact?></td>
                    <td class="dd3">
                      <input type='hidden'   id='mecard_show' value='<?=$mecard_show?>'>
                      <input type='checkbox' id='open_contact' style="zoom: 150%;position: relative;top: 3px;">
                      <label for='open_contact' style="display:inline;"><?=$NewContactsQRcode?></label>
                      <input type='checkbox' id='chk_to_cpy_data' style="zoom: 150%;position: relative;top: 3px;">
                      <label for='chk_to_cpy_data' style="display:inline;"><?=$DataDitto?></label>
                    </td>
                  </tr>

                  <!--通訊姓名-->
                  <tr class='mcard_tr'>
                    <td class="dd1"><span class="star">*</span></td>
                    <td class="dd2"><?=$CommunicationFullName?></td>
                    <td class="dd3">
                      <input type='text' placeholder='<?=$CommunicationSurname?>' maxlength="16" name='iqr_lastname' id='iqr_lastname' value='<?=$iqr['lastname']?>'>
                      <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$_scanSurname?></div>
                      <input type='text' placeholder='<?=$CommunicationName?>' maxlength="16" name='iqr_firstname' id='iqr_firstname' value='<?=$iqr['firstname']?>'><span class='prompt' id='firstname_span'></span>
                      <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$_scanName?></div>
                    </td>
                  </tr>

                  <!--通訊手機-->
                  <tr class='mcard_tr'>
                    <td class="dd1">&nbsp;</td>
                    <td class="dd2"><?=$CommunicationPhone?></td>
                    <td class="dd3">
                      <input type='text' class="iii1 number" placeholder='<?=$CommunicationPhone?>&nbsp;(只允許數字)' minlength='10' maxlength="10" name='iqr_mphone' id='iqr_mphone' value='<?=$iqr['mphone']?>'>
                      <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$_ScanPhone?></div>
                    </td>
                    </td>
                  </tr>

                  <!--電子信箱-->
                  <tr class='mcard_tr'>
                    <td class="dd1">&nbsp;</td>
                    <td class="dd2"><?=$CommunicationEmail?></td>
                    <td class="dd3">
                      <input type='text' class="iii1" placeholder='<?=$CommunicationEmail?>' maxlength="255" name='iqr_ecard_mail' id='iqr_ecard_mail' value='<?=$iqr['ecard_mail']?>'>
                      <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$_ScanEmail?></div>
                    </td>
                  </tr>

                  <!--公司電話-->
                  <tr class='mcard_tr'>
                    <td class="dd1">&nbsp;</td>
                    <td class="dd2"><?=$CommunicationTelephone?></td>
                    <td class="dd3">
                      <input type='text' placeholder='<?=$CommunicationTelephone?>&nbsp;<?=$HaveAreaCode?>' class="number"  name='iqr_cpn_tel' id='iqr_cpn_tel' value='<?=$iqr['cpn_tel']?>' style='width: 160px;'>
                      <input type='text' placeholder='<?=$CommunicationExtension?>' class="number" name='iqr_cpn_tel_ext' id='iqr_cpn_tel_ext' value='<?=$iqr['cpn_tel_ext']?>' style='width: 120px;'>
                      <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$ScanTelephone?></div>
                    </td>
                  </tr>

                  <!--公司傳真-->
                  <tr class='mcard_tr'>
                    <td class="dd1">&nbsp;</td>
                    <td class="dd2"><?=$CommunicationFax?></td>
                    <td class="dd3">
                      <input type='text' class="iii1 number" placeholder='<?=$ContactsFax?>' name='iqr_cpn_fax' id='iqr_cpn_fax' value='<?=$iqr['cpn_fax']?>'>
                      <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$_ScanFax?></div>
                    </td>
                  </tr>

                  <!--公司地址-->
                  <tr class='mcard_tr'>
                    <td class="dd1">&nbsp;</td>
                    <td class="dd2"><?=$CommunicationAddress?></td>
                    <td class="dd3">
                      <input type='text' class="iii1" placeholder='<?=$CommunicationAddress?>' maxlength="255" name='iqr_cpn_addr' id='iqr_cpn_addr' value='<?=$iqr['cpn_addr']?>'>
                      <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$ScanAddress?></div>
                    </td>
                  </tr>

                  <!--公司名稱-->
                  <tr class='mcard_tr'>
                    <td class="dd1">&nbsp;</td>
                    <td class="dd2"><?=$CommunicationRemark?></td>
                    <td class="dd3">
                      <input type='text' class="iii1" placeholder='<?=$CommunicationRemark?>' maxlength="64" name='iqr_cpn_name' id='iqr_cpn_name' value='<?=$iqr['cpn_name']?>'>
                      <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'><?=$ScanRemark?></div>
                    </td>
                  </tr>

                </table>
              </p>

            </fieldset>
          </td>
        </tr>
      
      <?php if(0): ?>

        <tr>
          <td class="step-info-06">

            <fieldset id='app-fieldset' style='border: 1px groove #ffffff;'>
            <legend align="right">&nbsp;<?=$CustomClass?>&nbsp;<?=$DraggableSorting?>
            <input type='button' style="font-size: 17px; padding: 5px 10px 5px 10px; margin: 0px; border: none; cursor: pointer;" class="aa7" id="add_iqr_classify" value='<?=$Add?>'>
            <input style="font-size: 17px; padding: 5px 10px 5px 10px; margin: 0px;" class="aa3" type='submit' name='form_submit' onclick="window.onbeforeunload=null;return true;" value='<?=$SaveEdit?>'></legend>
              <p>&nbsp;</p>
              <p>
              <table id='iqr_classify_table'>
                  <tr>
                    <td style="text-align:center; width: 12%;"><?=$Number?></td>
                    <td><?=$ClassName?></td>
                    <td style="text-align:center; width: 22%;"><?=$Operating?></td>
                  </tr>
                <tbody id='iqr_classify_tbody'>

                  <?php if (!empty($iqr_classify)): ?>
                    <?php foreach ($iqr_classify as $key => $value): ?>
                      <tr>
                        <input type="hidden" name="iqr_classify[]" value="<?=$value['classify_id']?>">
                        <td style="text-align:center; width: 15%;"><?=($key+1)?></td>
                        <td id='class_name_<?=$value['classify_id']?>'><?=$value['classify_name']?></td>
                        <td style="text-align:center; width: 30%;">
                          <a class='aa5 classify_edit'    id='classify_edit_<?=$value['classify_id']?>' title='<?=$Modify?>'><i class='fa fa-pencil-square-o'></i></a>
                          <a class='aa5 classify_del'     id='classify_del_<?=$value['classify_id']?>' title='<?=$Delete?>'><i class='fa fa-times'></i></a>
                        </td>
                      </tr>
                    <?php endforeach; ?>

                  <?php else: ?>
                    <tr id='iqr_classify_empty'><td colspan="3"><?=$NotAddType?></td></tr>
                  <?php endif; ?>
                  <input type="hidden" id="count_classify" value="<?=$count_classify?>">
                </tbody>
              </table>
              <style type="text/css">
                #iqr_classify_table { width: 100%; }
                #iqr_classify_table td { border-bottom:1px solid #cccccc; }
                .aa5 {margin-left: 0px; cursor: pointer;}
              </style>
              </p>

            </fieldset>
          </td>
        </tr>

      
        <tr>
          <td class="step-info-06">

            <fieldset id='app-fieldset' style='border: 1px groove #ffffff;'>
            <legend align="right">&nbsp;<?=$CustomWeb?>
            <input type='button' style="font-size: 17px; padding: 5px 10px 5px 10px; margin: 0px; border: none; cursor: pointer;" class="aa7" id="add_iqr_html" value='<?=$Add?>'>
            <input style="font-size: 17px; padding: 5px 10px 5px 10px; margin: 0px;" class="aa3" type='submit' name='form_submit' onclick="window.onbeforeunload=null;return true;" value='<?=$SaveEdit?>'></legend>
              <p>&nbsp;</p>
                <?php if(!empty($iqr_classify)): ?>
                    <?php foreach ($iqr_classify as $key => $value): ?>
                      <div id="iqr_html_sort" style="width:100%">
                      <script>
                        $(function() {
                          $('.html_sort_<?=$key?>').sortable({
                            cancel : "#iqr_html_empty, .classify_name",
                          });
                        });
                      </script>
                      <div class="classify_name"><?=$value['classify_name']?></div>
                      <?php if(!empty($value['iqr_html'])): ?>
                        <div class="html_sort_<?=$key?>">
                        <?php foreach ($value['iqr_html'] as $i_key => $i_value): ?>
                        <div id="html_box">
                          <div class="html_key"><?=($i_key+1)?></div>
                          <div id='html_name_<?=$i_value['html_id']?>' title="<?=$i_value['html_name']?>" class="html_name">
                          	<?=$i_value['html_name']?>
							            <input type="hidden" name="html_sort[]" value="<?=$i_value['html_id']?>">
                          </div>
                          <div class="html_btn">
                            <a class="aa5 html_preview" id='html_preview_<?=$i_value['html_id']?>' title="<?=$View?>"><i class="fa fa-eye"></i></a>
                            <a class="aa5 html_edit" id='html_edit_<?=$i_value['html_id']?>' title="<?=$Modify?>"><i class="fa fa-pencil-square-o"></i></a> 
                            <a class="aa5 html_del" id='html_del_<?=$i_value['html_id']?>' title="<?=$Delete?>"><i class="fa fa-times"></i></a>
                          </div>
                      	</div>
                        <?php endforeach; ?>
                      	</div>
                        <?php else: ?>
                          <div id="iqr_html_empty"><?=$NotAddWeb?></div>
                      <?php endif; ?>
                  </div>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <div id="iqr_html_empty"><?=$NotAddWeb?></div>
                <?php endif; ?>  

              <style type="text/css">
                .classify_name {
                  background: #999; 
                  color: white;
                  text-align: center;
                  padding: 10px;
                  border-radius: 5px;
                   margin: 15px 0 5px 0;
                }
                .html_name {
                  text-overflow: ellipsis;
                  white-space: nowrap;
                  overflow: hidden; 
                  width: 60%; 
                  display: inline-block;
                }
                #html_box {
                  border-bottom: 1px solid #cccccc;
                  width:100%;
                  margin: 10px 0 10px 0;
                }
                .html_key {
                  width:9%; 
                  display:inline-block; 
                  text-align: center;
                }
                .html_btn {
                  display: inline-block;
                  width: 27%;
                }
                .aa5 {margin-left: 0px; cursor: pointer;}
              </style>
              </p>

            </fieldset>
          </td>
        </tr>
      <?php endif; ?>
        <!--<tr>
          <td class="step-info-07">

            <fieldset id='app-fieldset' style='border: 1px groove #ffffff;'>
            <legend align="right">&nbsp;自訂網頁&nbsp;(此區域資料無法設定共享)&nbsp;<input style="font-size: 17px; padding: 5px 10px 5px 10px; margin: 0px;" class="aa3" type='submit' name='form_submit' onclick="window.onbeforeunload=null;return true;" value='儲存編輯'>&nbsp;</legend>

              <p>&nbsp;</p>
              <p>

                <table border="0" cellspacing="0" cellpadding="0" class="personal-info">-->

                  <!--自訂網頁A-->
                  <!--<tr>
                    <td class="dd1">&nbsp;</td>
                    <td class="dd2" style="width: 250px;">自訂網頁A</td>
                    <td class="dd3">
                      <input type="text" class="iii1" placeholder='按鈕的顯示名稱' type='text' name='text_edit01_name' id='text_edit01_name' value='<?=$iqr['text_edit01_name']?>' maxlength='15'>
                      <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'>請輸入按鈕名稱，例如「行動商務系統宣傳文宣」、「活動簡章」</div>
                      <br><br>
                      <textarea id="text_edit01" name="text_edit01"><?=$iqr['text_edit01']?></textarea>
                    </td>
                  </tr>-->

                <!--自訂網頁B-->
                  <!--<tr>
                    <td class="dd1">&nbsp;</td>
                    <td class="dd2">自訂網頁B</td>
                    <td class="dd3">
                      <input type="text" class="iii1" placeholder='按鈕的顯示名稱' type='text' name='text_edit02_name' id='text_edit02_name' value='<?=$iqr['text_edit02_name']?>' maxlength='15'>
                      <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'>請輸入按鈕名稱，例如「展覽活動流程」、「產品型錄」</div>
                      <br><br>
                      <textarea id="text_edit02" name="text_edit02"><?=$iqr['text_edit02']?></textarea>
                    </td>
                  </tr>-->

                <!--自訂網頁C-->
                  <!--<tr>
                    <td class="dd1">&nbsp;</td>
                    <td class="dd2">自訂網頁C</td>
                    <td class="dd3">
                      <input type="text" class="iii1" placeholder='按鈕的顯示名稱' type='text' name='text_edit03_name' id='text_edit03_name' value='<?=$iqr['text_edit03_name']?>' maxlength='15'>
                      <a href="#" class="why" tabindex = "-1">?</a><div class='prompt-box'>請輸入按鈕名稱，例如「懷舊主題介紹」、「主題菜單」</div>
                      <br><br>
                      <textarea id="text_edit03" name="text_edit03"><?=$iqr['text_edit03']?></textarea>
                    </td>
                  </tr>

                </table>
              </p>

            </fieldset>
          </td>
        </tr>-->

        <tr>
          <td class="step-info-08">

            <fieldset id='app-fieldset' style='border: 1px groove #ffffff;'>
            <legend align="right">&nbsp;<?=$SaveEdit?>&nbsp;<input style="font-size: 17px; padding: 5px 10px 5px 10px; margin: 0px;" class="aa3" type='submit' name='form_submit' onclick="window.onbeforeunload=null;return true;" value='<?=$SaveEdit?>'>&nbsp;</legend>

              <p>&nbsp;</p>
              <p>

                <table border="0" cellspacing="0" cellpadding="0" class="personal-info">

                  <tr>
                  <td><?=$RightSaveAll?> ↑
                    <input type='hidden' id='member_id' value='<?=$mid?>'>
                    <span id='info'></span>
                    </td>
                  </tr>

                </table>
              </p>

            </fieldset>
          </td>
        </tr>

      </table>

    </div>

  </div>
  
</form>

<?
  //preview_iframe
//  echo 'business/preview_iframe';
//  exit;
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

  <style type="text/css">
    form * { font-family: '微軟正黑體'; }
    form input { font-family: '微軟正黑體'; }
    .ui-button-text { font-family: '微軟正黑體'; }
    .ui-dialog-title { height: 18px; }
  </style>

  <!--新增影片-->
  <div id="dialog-form-ytb-link" title="<?=$AddVideo?>">
    <form method="post" id='add_ytb_link_form'>
      <table class="personal-info">
        <tr><td class='dd3' style="width:30%;"><?=$MovieType?><td class='dd3'>
            <select style="  padding: 7px; border: 1px solid #CAC2A9; border-radius: 3px; margin: 0px 3px; font-size: 1em; font-family: 'Microsoft Jhenghei';" name="select_mode">
              <?php foreach ($ytb_category as $key => $value): ?>
                <option value="<?=$value['cid']?>"><?=$value['name']?></option>
              <?php endforeach; ?>
            </select>
        <tr><td class='dd3' style="width:30%;"><?=$YoutubeTitle?><td class='dd3'><input type='text' style="width:93%;" placeholder='<?=$YoutubeTitle?>' name='str_name' maxlength='32'>
        <tr><td class='dd3' style="width:30%;"><?=$YoutubeUrl?><td class='dd3'><input style="width:93%;" type='text' class="iii2" style="" placeholder='<?=$YoutubeUrl?>' name='str'>
      </table>
      <input type='hidden' name='type' value='0'>
      <input type='hidden' name='member_id' value='<?=$mid?>'>
      <input type='reset' style="display:none;">
      <p style="text-align:center; color:#F60; font-size:20px;" id='prompt_0'></p>
    </form>
  </div>

  <!--新增網址-->
  <div id="dialog-form-website" title="<?=$AddUrl?>">
    <form method="post" id='add_website_form'>
      <table class="personal-info">
        <tr><td class='dd3' style="width:30%;"><?=$_ButtonShowName?><td class='dd3'><input type='text' style="width:93%;" placeholder='<?=$_ButtonShowName?>' name='str_name' maxlength='15'>
        <tr><td class='dd3' style="width:30%;"><?=$WebUrl?><td class='dd3'><input type='text' style="width:93%;" class="iii2" placeholder='<?=$WebUrl?>' name='str'>
      </table>
      <input type='hidden' name='type' value='1'>
      <input type='hidden' name='member_id' value='<?=$mid?>'>
      <input type='reset' style="display:none;">
      <p style="text-align:center; color:#F60; font-size:20px;" id='prompt_1'></p>
    </form>
  </div>

  <!--新增地址-->
  <div id="dialog-form-address" title="<?=$NewAddress?>">
    <form method="post" id='add_address_form'>
      <table class="personal-info">
        <tr><td class='dd3' style="width:30%;"><?=$_ButtonShowName?><td class='dd3'><input type='text' style="width:93%;" placeholder='<?=$_ButtonShowName?>' name='str_name' maxlength='15'>
        <tr><td class='dd3' style="width:30%;"><?=$MapAddress?><td class='dd3'><input type='text' style="width:93%;" class="iii2" placeholder='<?=$MapAddress?>' name='str'>
      </table>
      <input type='hidden' name='type' value='2'>
      <input type='hidden' name='member_id' value='<?=$mid?>'>
      <input type='reset' style="display:none;">
      <p style="text-align:center; color:#F60; font-size:20px;" id='prompt_2'></p>
    </form>
  </div>

  <!--新增頭銜-->
  <div id="dialog-form-titlename" title="<?=$AddTitle?>">
    <form method="post" id='add_titlename_form'>
      <table class="personal-info">
        <tr><td class='dd3' style="width:20%;"><?=$Title?><td class='dd3'><input type='text' style="width:98%;" class="iii2" placeholder='<?=$Title?>' name='str'>
      </table>
      <input type='hidden' name='type' value='3'>
      <input type='hidden' name='member_id' value='<?=$mid?>'>
      <input type='reset' style="display:none;">
      <p style="text-align:center; color:#F60; font-size:20px;" id='prompt_3'></p>
    </form>
  </div>

  <!--新增手機號碼-->
  <div id="dialog-form-mobile-phones" title="<?=$_NewPhoneNumber?>">
    <form method="post" id='add_mobile_phones_form'>
      <table class="personal-info">
        <tr><td class='dd3' style="width:30%;"><?=$_ButtonShowName?><td class='dd3'><input type='text' style="width:93%;" placeholder='<?=$_ButtonShowName?>' name='str_name' maxlength='15'>
        <tr><td class='dd3' style="width:30%;"><?=$PhoneNumber?><td class='dd3'><input type='text' style="width:93%;" class="iii2" placeholder='<?=$PhoneNumber?>' name='str'>
      </table>
      <input type='hidden' name='type' value='4'>
      <input type='hidden' name='member_id' value='<?=$mid?>'>
      <input type='reset' style="display:none;">
      <p style="text-align:center; color:#F60; font-size:20px;" id='prompt_4'></p>
    </form>
  </div>

<!--bottom script-->
<script type="text/javascript" src="/js/edit_integrate.js" charset="utf-8"></script>
<script type="text/javascript" src="/js/edit_integrate_ckeditor.js" charset="utf-8"></script>

</body>
</html>
<script></script>