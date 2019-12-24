<!doctype html>
<html>
<head>

  <!–[if IE]>
  <script src=https://html5shiv.googlecode.com/svn/trunk/html5.js></script>
  <![endif]–>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=1024">

  <!-- seo -->
  <title><?=$_ActionStore?> <?=$web_config['title']?></title>
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
  <link type="text/css" rel="stylesheet" href="/css/global.css" media="screen">
  <link type="text/css" rel="stylesheet" href="/css/cart.css">   
  
  <!-- jQuery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>

  <!-- js -->
  <!-- <script type="text/javascript" src="/js/pageguide.js"></script> -->
  <script type="text/javascript" src="/js/json2html.js"></script>
  <script type="text/javascript" src="/js/jquery.json2html.js"></script>
  <script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script>
	<style>
	#cart_table tr td ,table.personal-info{
    font-size: .8rem;
}
</style>
</head>

<body scroll="yes" style="overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

<?
  //header
  $this->load->view('business/header', $data);
?>
  
<div id="container"><div class="w1024">
 
  <p style="font-size:20px;"><?=$StoreBasicSettings?>
    <a  class="why" id='why_panel'>?</a>
    <a href='/cart/store/<?=$setting['cset_code']?>' target='_blank' class="aa5" style="font-size:20px; margin-left: 0px; padding: 9px 10px;"><?=$GoStoreAction?> <i class="fa fa-external-link"></i></a>&nbsp;
    <!-- <input type="text" class="form-control" placeholder="搜尋商品" /><i class="fa fa-search"></i> -->
    <div class='prompt-box' id='prompt_panel'>
      <p><?=$InterfaceDescription?></p>
      <p><?=$ShopButtonName_1?></p>
      <p><?=$CashFlowSetting_2?></p>
      <p><?=$LogisticsSet_2?></p>
      <p><?=$ShippingEdit_3?></p>
    </div>
  </p>
  <br>
  
  <!--主介面區-->
  <table id='cart_table'>
    <tr>

      <!-- product_class -->
      <td style="word-break:break-all; width: 20%;" valign="top">
        <div id='nav' style="height: 500px; width: 188px;">
          <p><a class='link2 aa5' id='start'><?=$ShopSettings?></a></p>
          <? if($iqr_trans_td_show): ?><p><a class='link2 aa5'><?=$CashFlowSetting?></a></p><? endif ?>
          <?php if($iqr_logistics_td_show):?><p><a class='link2 aa5'><?=$LogisticsSet?></a></p><?php endif; ?>
          <p><a class='link2 aa5'><?=$ShippingEditInstructions?></a></p>
          <p><a class='link2 aa5'><?=$BuyExplanationEdit?></a></p>
          <!-- <p><a href='#' id='other_info'>其他設定</a></p> -->
        </div>
      </td>

      <!-- content -->
      <td id='content' style="word-break:break-all;" valign="top">
        <div>
          <div style="overflow: hidden; height: 700px;">

            <!--內容顯示區-->
            <div class='content_list' id='content_list' style="margin: 5px 0px 0px 0px;font-size:.7rem">

              <span id='first_show'><?=$WelcomeSystem?></span>

              <div class="store_setting">
                <table id='store_setting_table' class="personal-info" style="width: 100%;">
                  <tr><td style="width: 200px;"><?=$StoreDisplay?></td>
                      <td>
                          <input type='button' class="aa3" value='<?=$StoreButtonNoShow?>' id='close_store' style="<?=$cset_active_close_show?> margin: 0px 0px; font-size: .8rem; padding: 6px 14px; width: auto;">
                          <input type='button' class="aa6" value='<?=$StoreButtonShow?>' id='open_store' style="<?=$cset_active_open_show?> margin: 0px 0px; font-size: .8rem; padding: 6px 14px; width: auto;">
                          &nbsp;<span id='store_edit_info'></span>
                      </td>
                  </tr>
                  <tr id='cset_share_td' style="<?=$cset_share_td_show?>"><td style="width: 200px;"><?=$ShareButton?></td>
                      <td>
                          <input type='button' class="aa3" value='<?=$OnOpen?>' id='close_share' style="<?=$cset_share_close_show?> margin: 0px 0px; font-size: .8rem; padding: 6px 14px;">
                          <input type='button' class="aa6" value='<?=$CloseIn?>' id='open_share' style="<?=$cset_share_open_show?> margin: 0px 0px; font-size: .8rem; padding: 6px 14px;">
                          &nbsp;<span id='share_edit_info'></span>
                      </td>
                  </tr>
                  <tr id='cset_receipt_td' style="<?=$cset_receipt_td_show?>"><td style="width: 200px;"><?=$Invoice?></td>
                      <td>
                          <input type='button' class="aa3" value='<?=$OnOpen?>' id='close_receipt' style="<?=$cset_receipt_close_show?> margin: 0px 0px; font-size: .8rem; padding: 6px 14px;">
                          <input type='button' class="aa6" value='<?=$CloseIn?>' id='open_receipt' style="<?=$cset_receipt_open_show?> margin: 0px 0px; font-size: .8rem; padding: 6px 14px;">
                          &nbsp;<span id='receipt_edit_info'></span>
                      </td>
                  </tr>
                  <tr id='cset_name_td' style="<?=$cset_name_td_show?>"><td><?=$ButtonName?></td>
                      <td>
                          <a  class="why" id="why_panel1" style="margin:0px 12px 0px -15px;">?</a>
                          <div class='prompt-box' id='prompt_panel1'>
                            <p><?=$ButtonsNameCards_1?></p>
                            <p><?=$MobileStoreName_2?></p>
                            <p><?=$SenderName_3?></p>
                          </div>
                          <input type='hidden' name='cset_active' id='cset_active' value='<?=$setting['cset_active']?>'>
                          <input type='text' placeholder='<?=$ShowButtonName?>' maxlength="15" style="margin: 0px 0px; padding: 5px; width:43%; font-family: 'Microsoft Jhenghei'; display:inline;" class="dd3" name='cset_name' id='cset_name' value='<?=$setting['cset_name']?>'>
                          <input type='button' class="aa6" id='save_btn_name' value='<?=$_SaveButtonName?>' style="margin: 0px 0px; font-size: .8rem; padding: 6px 14px;">
                          &nbsp;<span id='save_btn_name_info'></span>
                      </td>
                  </tr>
                  <tr id='cset_email_td' style="<?=$cset_email_td_show?>"><td><?=$ReceiverMail?></td>
                      <td>
                          <a  class="why" id="why_panel2" style="margin:0px 12px 0px -15px;">?</a>
                          <div class='prompt-box' id='prompt_panel2'>
                            <p><?=$FillReceiveMailFunction?></p>
                            <p><?=$FooterMailbox_1?></p>
                            <p><?=$SystemWillSendLetter_2?></p>
                          </div>
                          <input type='text' placeholder='<?=$ReceiverMail?>' maxlength="64" style="margin: 0px 0px; padding: 5px; width:43%; font-family: 'Microsoft Jhenghei'; display:inline;" class="dd3" name='cset_email' id='cset_email' value='<?=$setting['cset_email']?>'>
                          <input type='button' class="aa6 cset" id='save_cset_email' value='<?=$SaveEmail?>' style="margin: 0px 0px; font-size: .8rem; padding: 6px 14px;">
                          &nbsp;<span id='save_cset_email_info'></span>
                      </td>
                  </tr>
                  <tr id='cset_company_td' style="<?=$cset_company_td_show?>"><td><?=$CompanyName?></td>
                      <td>
                          <a  class="why" id="why_panel3" style="margin:0px 12px 0px -15px;">?</a>
                          <div class='prompt-box' id='prompt_panel3'>
                            <p><?=$EndViewCompanyName?></p>
                          </div>
                          <input type='text' placeholder='<?=$CompanyName?>' maxlength="32" style="margin: 0px 0px; padding: 5px; width:43%; font-family: 'Microsoft Jhenghei'; display:inline;" class="dd3" name='cset_company' id='cset_company' value='<?=$setting['cset_company']?>'>
                          <input type='button' class="aa6 company" id='save_cset_company' value='<?=$SaveCompany?>' style="margin: 0px 0px; font-size: .8rem; padding: 6px 14px;">
                          &nbsp;<span id='save_cset_company_info'></span>
                      </td>
                  </tr>
                  <tr id='cset_address_td' style="<?=$cset_address_td_show?>"><td><?=$ContactAddress?></td>
                      <td>
                          <a  class="why" id="why_panel4" style="margin:0px 12px 0px -15px;">?</a>
                          <div class='prompt-box' id='prompt_panel4'>
                            <p><?=$EndViewCompanyAddress?></p>
                          </div>
                          <input type='text' placeholder='<?=$ContactAddress?>' maxlength="64" style="margin: 0px 0px; padding: 5px; width:43%; font-family: 'Microsoft Jhenghei'; display:inline;" class="dd3" name='cset_address' id='cset_address' value='<?=$setting['cset_address']?>'>
                          <input type='button' class="aa6 address" id='save_cset_address' value='<?=$SaveAddress?>' style="margin: 0px 0px; font-size: .8rem; padding: 6px 14px;">
                          &nbsp;<span id='save_cset_address_info'></span>
                      </td>
                  </tr>
                  <tr id='cset_telphone_td' style="<?=$cset_telphone_td_show?>"><td><?=$LocalCalls?></td>
                      <td>
                          <a  class="why" id="why_panel5" style="margin:0px 12px 0px -15px;">?</a>
                          <div class='prompt-box' id='prompt_panel5'>
                            <p><?=$EndViewCompanyPhone?></p>
                          </div>
                          <input type='text' placeholder='<?=$LocalCalls?>' maxlength="10" style="margin: 0px 0px; padding: 5px; width:43%; font-family: 'Microsoft Jhenghei'; display:inline;" class="dd3" name='cset_telphone' id='cset_telphone' value='<?=$setting['cset_telphone']?>'>
                          <input type='button' class="aa6 telphone" id='save_cset_telphone' value='<?=$SaveLocalCalls?>' style="margin: 0px 0px; font-size: .8rem; padding: 6px 14px;">
                          &nbsp;<span id='save_cset_telphone_info'></span>
                      </td>
                  </tr>
                  <tr id='cset_mobile_td' style="<?=$cset_mobile_td_show?>"><td><?=$PhoneNumber?></td>
                      <td>
                          <a class="why" id="why_panel6" style="margin:0px 12px 0px -15px;">?</a>
                          <div class='prompt-box' id='prompt_panel6'>
                            <p><?=$EndViewCompanyNumber?></p>
                          </div>
                          <input type='text' placeholder='<?=$PhoneNumber?>' maxlength="10" style="margin: 0px 0px; padding: 5px; width:43%; font-family: 'Microsoft Jhenghei'; display:inline;" class="dd3" name='cset_mobile' id='cset_mobile' value='<?=$setting['cset_mobile']?>'>
                          <input type='button' class="aa6 mobile" id='save_cset_mobile' value='<?=$SavePhoneNum?>' style="margin: 0px 0px; font-size: .8rem; padding: 6px 14px;">
                          &nbsp;<span id='save_cset_mobile_info'></span>
                      </td>
                  </tr>
                  <?php if($iqr['cart_id'] > 1): ?>
                    <form method="post" enctype="multipart/form-data">
                      <tr id='cset_logo_td' style="<?=$cset_logo_td_show?>"><td><?=$StoreLogo?></td>
                        <?php if($iqr['cart_logo_url'] != NULL): ?>
                          <td>
                              <a class="why" id="why_panel7" style="margin:0px 12px 0px -15px;">?</a>
                              <div class='prompt-box' id='prompt_panel7'>
                                <p><?=$WebAboveBannerImage_1?></p>
                                <p><?=$AboveBannerImage_2?></p>
                                <p><?=$PictureSize2000_3?></p>
                              </div>
                              <a style="width: 292px; text-align: center; display: inline-block;" href="<?=$iqr['cart_logo_url']?>" target="_blank"><img src="<?=$iqr['cart_logo_url']?>" style="vertical-align:middle; height:45px;"></a>
                              <input type='submit' class="aa6 del" id='del_cset_logo' name="del_cset_logo"value='<?=$RemoveStoreIcon?>' style="margin: 0px 0px; font-size: .8rem; padding: 6px 14px;">
                          </td>
                        <?php  else: ?>
                          <td>
                              <a  class="why" id="why_panel7" style="margin:0px 12px 0px -15px;">?</a>
                              <div class='prompt-box' id='prompt_panel7'>
                                <p><?=$WebAboveBannerImage_1?></p>
                                <p><?=$AboveBannerImage_2?></p>
                                <p><?=$PictureSize2000_3?></p>
                              </div>
                              <input type='file' style="margin: 0px 0px; padding: 5px; width:43%; font-family: 'Microsoft Jhenghei'; display:inline;" class="limit-pic" data-cset_logo-width="2000" data-cset_logo-height="450" data-cset_logo-display="cset_logo_display" name='cset_logo' id='cset_logo'>
                              <input type='submit' class="aa6 logo" id='save_cset_logo' value='<?=$ShopIconUpload?>' style="margin: 0px 0px; font-size: .8rem; padding: 6px 14px;">
                              &nbsp;<span id='save_cset_logo_info'></span>
                              &nbsp;<br><span style="color:red; font-size:0.8em;padding-left:30px;"><?=$Size2000?></span>
                              <img id='cset_logo_display' class='hidden_image'>
                          </td>
                        <?php endif; ?>
                      </tr>
                    </form>

                    <form method="post" enctype="multipart/form-data">
                      <tr id='mobile_logo_td' style="<?=$mobile_logo_td_show?>"><td><?=$_PhoneLogo?></td>
                        <?php if($iqr['cart_mobile_logo_url'] != NULL): ?>
                          <td>
                              <a  class="why" id="why_panel8" style="margin:0px 12px 0px -15px;">?</a>
                              <div class='prompt-box' id='prompt_panel8'>
                                <p><?=$PhoneAboveBannerImage_1?></p>
                                <p><?=$AboveBannerImage_2?></p>
                                <p><?=$PictureSize1200_3?></p>
                              </div>
                              <a style="width: 292px; text-align: center; display: inline-block;" href="<?=$iqr['cart_mobile_logo_url']?>" target="_blank"><img src="<?=$iqr['cart_mobile_logo_url']?>" style="vertical-align:middle; height:45px;"></a>
                              <input type='submit' class="aa6 del" id='del_mobile_logo' name="del_mobile_logo"value='<?=$RemoveStoreIcon?>' style="margin: 0px 0px; font-size: .8rem; padding: 6px 14px;">
                          </td>
                        <?php  else: ?>
                          <td> 
                              <a  class="why" id="why_panel8" style="margin:0px 12px 0px -15px;">?</a>
                              <div class='prompt-box' id='prompt_panel8'>
                                <p><?=$PhoneAboveBannerImage_1?></p>
                                <p><?=$AboveBannerImage_2?></p>
                                <p><?=$PictureSize1200_3?></p>
                              </div>
                              <input type='file' style="margin: 0px 0px; padding: 5px; width:43%; font-family: 'Microsoft Jhenghei'; display:inline;" class="limit-pic" data-mobile_logo-width="1200" data-mobile_logo-height="450" data-mobile_logo-display="mobile_logo_display" name='mobile_logo' id='mobile_logo'>
                              <input type='submit' class="aa6 logo" id='save_cset_logo' value='<?=$ShopIconUpload?>' style="margin: 0px 0px; font-size: .8rem; padding: 6px 14px;">
                              &nbsp;<span id='save_cset_logo_info'></span>
                              &nbsp;<br><span style="color:red; font-size:0.8em;padding-left:30px;"><?=$Size1200?></span>
                              <img id='mobile_logo_display' class='hidden_image'>
                          </td>
                        <?php endif; ?>
                      </tr>
                    </form>
                  <?php endif; ?>

                </table>
              </div>
              <? if($iqr_trans_td_show): ?>
                <div class="pay_setting">
                  <table id='pay_setting_table' class="personal-info" style="width: 100%;">
                    <tr><td colspan="3"><?=$SystemCashFlowSeries?></td></tr>
                    <?php foreach ($iqr_trans as $key => $value): ?>
                      <tr>
                        <td style="width: 45%;">
                          <input type='button' class="<?=$pway_active_class[$key]?> change_iqrt_active" id='change_iqrt_active_<?=$value['iqrt_id']?>' value='<?=$pway_active_name[$key]?>' style="margin: 0px 0px; font-size: .8rem; padding: 6px 14px;">&nbsp;&nbsp;
                          <?=$pway_name[$key]?><? if($pway_id[$key] > 1): ?>, <?=$pway_code[$key]?><? endif ?>
                          (
                          <span id='iqrt_active_prompt_<?=$value['iqrt_id']?>' style="width: 15%; color: #B2A171;"><?=$pway_active[$key]?></span>
                          )
                        </td>
                        <td style="width: 38%;">
                        <?php if ($custome_account[$key] == 1 && $value['pway_id'] != 5): ?>
                          <input placeholder='<?=$pway_placeholder[$key]?>' style='width: 90%;' type='text' id='change_business_account_<?=$value['iqrt_id']?>' value='<?=$business_account[$key]?>'>
                        <?php endif; ?>
                        <?php if($value['pway_id'] == 5 && $business_account[$key]):?>
                          <input placeholder='<?=$pway_placeholder[$key]?>' style='width: 90%;' type='hidden' id='change_business_account_<?=$value['iqrt_id']?>' value='<?=$business_account[$key]?>'>
                          <span><?=$InstallmentPeriods_No?></span>&nbsp;&nbsp;<select style="padding: 7px;border: 1px solid #CAC2A9;border-radius: 3px;margin: 0px 3px;font-size: 0.77em;font-family: 'Microsoft Jhenghei';" id='change_creditinstallment_<?=$value['iqrt_id']?>'>
                            <?php foreach ($select_credit as $m_key => $val): ?>
                              <option value="<?=$val?>" <?=$selected_credit[$val]?>><?=$val?></option>
                            <?php endforeach;?>
                          </select> 
                        <?php elseif($value['pway_id'] == 5 && empty($business_account[$key]) || $value['pway_id'] == 6 && empty($business_account[$key])): ?>
                          <span style="margin-left:40px;"><?=$IndustryApplication?></span>
                        <?php endif; ?>
                        </td>
                        <td style="width: 17%;">
                          <?php if ($custome_account[$key] == 1 && $key != 4): ?>
                           <input type='button' value='<?=$Save?>' class="aa6 business_account" id='change_business_account_button_<?=$value['iqrt_id']?>' style="margin: 0px 0px; font-size: .8rem; padding: 6px 14px;">&nbsp;&nbsp;<span id='business_account_edit_info_<?=$value['iqrt_id']?>'></span>
                          <? endif ?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </table>
                </div>
              <? endif ?>

              <?php if($iqr_logistics_td_show):?>
              <div class="logistics_info">
                <table id='logistics_info_table' class="personal-info" style="width: 100%;">
                  <tr><td style="width: 200px;"><?=$SystemLogisticsInformation?></td>
                  <?php foreach ($iqr_logistics as $log_key => $log_value): ?>
                    <tr>
                      <td style="width: 45%;">
                        <input type='button' class="<?=$lway_active_class[$log_key]?> change_lway_active" id='change_lway_active_<?=$log_value['iqrt_id']?>' value='<?=$lway_active_name[$log_key]?>' style="margin: 0px 0px; font-size: .8rem; padding: 6px 14px;">&nbsp;&nbsp;
                        <?=$lway_name[$log_key]?>
                        (
                        <span id='lway_active_prompt_<?=$log_value['iqrt_id']?>' style="width: 15%; color: #B2A171;"><?=$lway_active[$log_key]?></span>
                        )
                        <? if($lway_id[$log_key] > 1 && $lway_code[$log_key] !=''): ?>, <?=$lway_code[$log_key]?><? endif ?>
                      </td>
                      <td style="width: 38%;"><?php if ($lway_account[$log_key] == 1): ?><input placeholder='<?=$lway_placeholder[$log_key]?>' onKeyUp="value=value.replace(/[^\d]/g,'')" style='width: 80%; text-align: center;' type='text' id='change_lway_account_<?=$log_value['iqrt_id']?>' value='<?=$lway_business_account[$log_key]?>'> <?=$Yuan?><? endif ?></td>
                      <td style="width: 17%;"><?php if ($lway_account[$log_key] == 1): ?><input type='button' value='<?=$Save?>' class="aa6 lway_account" id='change_lway_account_button_<?=$log_value['iqrt_id']?>' style="margin: 0px 0px; font-size: .8rem; padding: 6px 14px;">&nbsp;&nbsp;<span id='lway_account_edit_info_<?=$log_value['iqrt_id']?>'></span><? endif ?></td>
                    </tr>
                  <?php endforeach; ?>
                  </tr>
                </table>
              </div>
              <?php endif; ?>

              <div class="ship_info">
                <p style="padding: 0px 0px 5px 0px;">
                  <?=$ShippingInstructions?><a  class="why" id='why_ship' style="top: 0px;">?</a>
                  <input type='button' class="aa3" style="margin: 0px 0px; font-size: .8rem; padding: 4px 14px;" name='ship_edit_send' id='ship_edit_send' value='<?=$SaveEditContent?>'> <span id='ship_edit_info'></span>
                </p>
                <div class='prompt-box' id='prompt_ship'>
                  <ul>
                    <li><?=$ClickCopy?></li>
                    <li> -- </li>
                    <li><?=$OnlyTaiwan?></li>
                    <li><?=$DeliveryWorkingDays?></li>
                    <li><?=$NotTakeRecord?></li>
                    <li> -- </li>
                    <li><?=$NeedContentBased?></li>
                  </ul>
                </div>
                <p><textarea name='cset_ship' id='cset_ship'><?=$setting['cset_ship']?></textarea></p>
              </div>

              <div class="order_info">
                <p style="padding: 0px 0px 5px 0px;">
                  <?=$_BuyExplanation?><a  class="why" id='why_paid' style="top: 0px;">?</a>
                  <input type='button' class="aa3" style="margin: 0px 0px; font-size: .8rem; padding: 4px 14px;" name='paying_edit_send' id='paying_edit_send' value='<?=$SaveEditContent?>'> <span id='paying_edit_info'></span>
                </p>
                <div class='prompt-box' id='prompt_paid'>
                  <ul>
                    <li><?=$SuggestStayInformation?></li>
                    <li><?=$ClickCopy?></li>
                    <li> -- </li>
                    <li><?=$InvoiceSend?></li>
                    <ul>
                      <li><?=$InvoiceSendEmail?></li>
                    </ul>
                    <br>
                    <li><?=$Service?></li>
                    <ul>
                      <li><?=$WantReplaceGood_1?></li>
                      <li><?=$WriteContact_2?></li>
                    </ul>
                    <br>
                    <li><?=$WaysContact?></li>
                    <ul>
                      <li><?=$Cheng?></li>
                      <li><?=$phone888?></li>
                    </ul>
                    <li> -- </li>
                    <li><?=$NeedContentBased?></li>
                  </ul>
                </div>
                <p><textarea name='cset_paid' id='cset_paid'><?=$setting['cset_paid']?></textarea></p>
              </div>

            </div>
            <!--原始顯示區結束-->

          </div>
        </div>
      </td>

    </tr>
  </table>
  <!--主介面區結束-->

  <!--cannot delete~ it's useful -->
  <div class="clear"></div>  

  </div><!--the end of w1024(container) -->

  <div id="advertisement">  <!--go top-->
    <a ><img style="border:0px;" src="/images/style_01/gotop.png"></a>
  </div>

</div><!--the end of container -->

<?
  //footer
  $this->load->view('business/footer', $data);
?>

<!--bottom script-->
<span class='hidden_text' id='click_start'><?=$click_start?></span>
<script type="text/javascript" src="/js/jquery-limit-size.js"></script>
<script type="text/javascript" src="/js/store_setting_<?echo $this -> data['lang']?>.js"></script>
<script type="text/javascript">
  $(function()
  {
    $('.hidden_image').hide();
    if($('#click_start').text() == 1)
    {
      $('#start').get(0).click();
      $('#store_edit_info').html('<i class="fa fa-arrow-left"></i> <?=$StoresNotEnabled?>');
      $('#store_edit_info').css('color', '#ff6600');
    }
  });
</script>
</body>
</html>
