<script type="text/javascript">
  var browser_detecting = (/Firefox/i.test(navigator.userAgent)) ? 'firefox' :
    (/Chrome/i.test(navigator.userAgent)) ? 'chrome' :
    (/MSIE/i.test(navigator.userAgent)) ? 'ie' :
    'other';
  $(function()
  {
      $('#'+browser_detecting).html('<br>本系統部分功能不適用於您目前使用的瀏覽器，建議您使用Firefox, Chrome進行操作<br>');
  });

  function ChangeLang($value) {
    $.ajax({
        type: "post",
        url: '/translation_v2/set_language',
        cache: false,
        data: {
            lang: $value
        },
        dataType: "text",
        success: function(response) {
            location.reload();
        }
    });
  }
</script>
<div id="header-bg1" style="background: url('/images/web_style_images/<?=$web_banner_dir?>/bg-h1.png') repeat 0px 0px;">
  <div id="header-bg2" style="background: url('/images/web_style_images/<?=$web_banner_dir?>/bg-header.png') no-repeat center 0px; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;">

    <div class="w1024">
      <div id="menu">
      <select onchange="ChangeLang(this.value);">
        <option value="TW"  <?php if ($this->session->userdata('lang') == 'TW') echo 'selected'; ?>>繁體</option>
        <option value="ENG" <?php if ($this->session->userdata('lang') == 'ENG') echo 'selected'; ?>>英文</option>
        <option value="JAP" <?php if ($this->session->userdata('lang') == 'JAP') echo 'selected'; ?>>日語</option>
      </select>
      <a href="<?=$iqr_qrcode_box?>" onclick="window.open(this.href, '', config='height=620,width=420,left=470'); return false;" ><?=$Edit_Web_version?></a>
      <a href="<?=$app_qrcode_box?>" onclick="window.open(this.href, '', config='height=620,width=420,left=510,top=70'); return false;"><?=$Edit_APP_version?></a>
      <a href="/index/logout"><?=$Edit_Sign_out?></a>
      </div>
      <div class="clear"></div>
    </div>

    <header style="background: url('/images/web_style_images/<?=$web_banner_dir?>/logo.png') no-repeat center 0px;">
      <span style='color: <?=$web_config['web_banner_color']?>'><?=$Edit_Signed_in?><?=$account?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$deadline?> <?=$Edit_Maturity?>&nbsp;&nbsp;<?=$days?>&nbsp;&nbsp;<?=$Edit_Day?>)</span>
      <span id='ie' style="line-height: 30px; color: red;"></span>
    </header>

    <nav>
      <div class="w1024">

        <ul class="dropdown" style="z-index: 2;">
          
          <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/business/edit" title="<?=$Edit_Business_Information_Systemsnt?>" alt="<?=$Edit_Personal_information?>" id='<?=$id_on['edit']?><?=$id_on['line_teach']?>'><?=$Edit_Personal_information?></a></li>
          
          <li style="width: <?=$menu_width?>;"><a href="#" style="width: <?=$menu_width?>;" id='<?=$id_on['edit_logo_style']?><?=$id_on['edit_iqr_style']?><?=$id_on['edit_cart_style']?>'><?=$Edit_Style_Settings?></a>
            <ul class="sub_menu">
              <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/business/edit_logo_style" title="<?=$Edit_still_cover_formula?>" alt="<?=$Edit_Cover_photo_set?>" ><?=$Edit_Cover_photo_set?></a></li>
              <?php if (0): ?>
              <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/business/edit_iqr_style" title="<?=$Edit_commerce_system_styles?>" alt="<?=$Edit_Style_setting?>" ><?=$Edit_Style_setting?></a></li>
                <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/business/edit_cart_style" title="<?=$Edit_store_style_action?>" alt="<?=$Edit_settings_action_Stores?>" ><?=$Edit_settings_action_Stores?></a></li>
              <?php endif; ?>
            <?php if(0): ?>
              <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/business/edit_header_str" title="<?=$Edit_title_text_style?>" alt="<?=$Edit_Text_classification_set?>" ><?=$Edit_Text_classification_set?></a></li>
            <?php endif; ?>
            </ul>
          </li>
          
          <?php if(0): ?>
            <li style="width: <?=$menu_width?>;"><a href="#" style="width: <?=$menu_width?>;" id='<?=$id_on['photo_management']?><?=$id_on['exfile_management']?>'><?=$Edit_Albums_and_Accessories?></a>
              <ul class="sub_menu">
                <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/photo_category/main" title="
                <?=$Edit_systems_albums_Category?>" alt="<?=$Edit_New_Album?>"><?=$Edit_New_Album?></a></li>
                <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/business/photo_management" title="<?=$Edit_commerce_system_Album?>" alt="<?=$Edit_Album_Management?>"><?=$Edit_Album_Management?></a></li>
                <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/business/exfile_management" title="<?=$Edit_business_systems_Accessories?>" alt="<?=$Edit_Attachment_Manager?>"><?=$Edit_Attachment_Manager?></a></li>
              </ul>
            </li>
          <?php endif; ?>

          <li style="width: <?=$menu_width?>;"><a href="#" style="width: <?=$menu_width?>;" id='<?=$id_on['edit_qrcode']?>'><?=$Edit_QR_code_style?></a>
            <ul class="sub_menu">
              <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/business/edit_qrcode/2" title="<?=$Edit_APP_version_QRcode?>" alt="<?=$Edit_APP_Edition?>"><?=$Edit_APP_Edition?></a></li>
              <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/business/edit_qrcode/0" title="<?=$Edit_web_version_QRcode?>" alt="<?=$Edit_Web_version?>"><?=$Edit_Web_version?></a></li>
              <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/business/edit_qrcode/1" title="<?=$Edit_contacts_QRcode_styles?>" alt="<?=$Edit_Contacts?>"><?=$Edit_Contacts?></a></li>
            </ul>
          </li>
          
          <?php if(0): ?>
            <li style="width: <?=$menu_width?>;"><a href="#" style="width: <?=$menu_width?>;" id='<?=$id_on['eform']?><?=$id_on['ecoupon']?><?=$id_on['ediscount']?>'><?=$Edit_Form_Tools?></a>
              <ul class="sub_menu">
                <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/business/eform" title="<?=$Edit_system_custom_form?>" alt="<?=$Edit_Custom_Forms?>"><?=$Edit_Custom_Forms?></a></li>
                <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/business/ecoupon" title="<?=$Edit_commerce_system?>" alt="<?=$Edit_Tell_a_friend_Voucher?>"><?=$Edit_Tell_a_friend_Voucher?></a></li>
                <!-- <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/business/ediscount" title="編輯您的行動商務系統優惠券" alt="自訂優惠券">自訂優惠券</a></li> -->
              </ul>
            </li>
          <?php endif; ?>

          <?php if(0): ?>
            <?php if ($web_config['cart_status'] == 1): ?>
              <li style="width: <?=$menu_width?>;"><a href="#" style="width: <?=$menu_width?>;" id='<?=$id_on['cart_management']?><?=$id_on['store_setting']?><?=$id_on['order_management']?>'><?=$Edit_Action_Shop?></a>
                <ul class="sub_menu">
                  <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/cart/store_setting" title="<?=$Edit_Basic_settings?>" alt="<?=$Edit_Basic_settings?>"><?=$Edit_Basic_settings?></a></li>
                  <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/cart/cart_management" title="<?=$Edit_Commodity_Management?>" alt="<?=$Edit_Commodity_Management?>"><?=$Edit_Commodity_Management?></a></li>
                  <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/cart/order_management" title="<?=$Edit_Order_Management?>" alt="<?=$Edit_Order_Management?>"><?=$Edit_Order_Management?></a></li>
                  <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/generator/order" title="<?=$Edit_Orders_Search?>" alt="<?=$Edit_Orders_Search?>"><?=$Edit_Orders_Search?></a></li>
                </ul>
              </li>
            <?php endif; ?>
          <?php endif; ?>
          
          <li style="width: <?=$menu_width?>;"><a href="#" style="width: <?=$menu_width?>;" id='<?=$id_on['update']?><?=$id_on['iqr_views']?><?=$id_on['setting']?><?=$id_on['member_list']?><?=$id_on['key_list']?><?=$id_on['web_config']?>'><?=$Edit_control_center?></a>
            <ul class="sub_menu">
              <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/user/update/updp" title="<?=$Edit_change_Password?>" alt="<?=$Edit_change_Password?>"><?=$Edit_change_Password?></a></li>
              <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/user/iqr_views" title="<?=$Edit_System_flow?>" alt="<?=$Edit_System_flow?>"><?=$Edit_System_flow?></a></li>
              
            <?php if(0): ?>
                <?php if ($domain_id != 2 && $domain_id != ''): ?>
                  <li style="width: <?=$menu_width?>;"><?=$auth_cols?></li>
                <?php endif; ?>

              <?php if ($user_auth == '01'): ?><li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/user/member_list" title="<?=$Edit_Member_Management?>" alt="<?=$Edit_Member_Management?>"><?=$Edit_Member_Management?></a></li><?php endif; ?>
              <?php if ($user_auth == '01'): ?><li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/user/key_list" title="<?=$Edit_Key_state?>" alt="<?=$Edit_Key_state?>"><?=$Edit_Key_state?></a></li><?php endif; ?>
              <?php if ($user_auth == '01'): ?><!-- <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/user/web_config" title="網站設定" alt="網站設定">網站設定</a></li> --><?php endif; ?>
            <?php endif;?> 
            </ul>
          </li>

          <li style="width: <?=$menu_width?>;"><a href="#" style="width: <?=$menu_width?>;" id='<?=$id_on['build']?><?=$id_on['release']?><?=$id_on['notification']?><?=$id_on['release_setting']?>'><?=$Edit_APP_setting?></a>
            <ul class="sub_menu">
              <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/appui/build" title="<?=$Edit_APP_installer?>" alt="<?=$Edit_Automatic_packing?>"><?=$Edit_Automatic_packing?></a></li>
              <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/appui/release" title="<?=$Edit_apply_through?>" alt="<?=$Edit_Application_shelves?>"><?=$Edit_Application_shelves?></a></li>
              <?php if ($real_ip == '118.170.54.170'): ?>
                <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/appui/notification" title="<?=$Edit_application_APP?>" alt="<?=$Edit_Push_application?>"><?=$Edit_Push_application?></a></li>
              <?php endif; ?>

              <?php //if ($release_setting): ?>
              <?php if (0): ?>
                <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/appui/release_setting" title="<?=$Edit_URL_shelves?>" alt="<?=$Edit_Added_Management?>"><?=$Edit_Added_Management?></a></li>
              <?php endif; ?>

            </ul>
          </li>
          
        </ul>

      </div>
    </nav>

  </div><!--<div id="header-bg2">-->
</div><!--<div id="header-bg1">-->
