<script type="text/javascript">
  var browser_detecting = (/Firefox/i.test(navigator.userAgent)) ? 'firefox' :
    (/Chrome/i.test(navigator.userAgent)) ? 'chrome' :
    (/MSIE/i.test(navigator.userAgent)) ? 'ie' :
    'other';
  $(function()
  {
      $('#'+browser_detecting).html('<br>本系統部分功能不適用於您目前使用的瀏覽器，建議您使用Firefox, Chrome進行操作<br>');
  });
</script>
<div id="header-bg1" style="background: url('/images/web_style_images/<?=$web_banner_dir?>/bg-h1.png') repeat 0px 0px;">
  <div id="header-bg2" style="background: url('/images/web_style_images/<?=$web_banner_dir?>/bg-header.png') no-repeat center 0px; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;">

    <div class="w1024">
      <div id="menu">
      <a href="<?=$iqr_qrcode_box?>" onclick="window.open(this.href, '', config='height=620,width=420,left=470'); return false;" >網頁版</a>
      <a href="<?=$app_qrcode_box?>" onclick="window.open(this.href, '', config='height=620,width=420,left=510,top=70'); return false;">APP版</a>
      <a href="/index/logout">登出</a>
      </div>
      <div class="clear"></div>
    </div>

    <header style="background: url('/images/web_style_images/<?=$web_banner_dir?>/logo.png') no-repeat center 0px;">
      <span style='color: <?=$web_config['web_banner_color']?>'>登入身分：<?=$account?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$deadline?> 到期 (還有約<?=$days?>天)</span>
      <span id='ie' style="line-height: 30px; color: red;"></span>
    </header>

    <nav>
      <div class="w1024">

        <ul class="dropdown" style="z-index: 2;">
          
          <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/business/edit" title="編輯您的行動商務系統資訊" alt="個人資訊" id='<?=$id_on['edit']?><?=$id_on['line_teach']?>'>個人資訊</a></li>
          
          <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" id='<?=$id_on['edit_logo_style']?><?=$id_on['edit_iqr_style']?><?=$id_on['edit_cart_style']?>'>樣式設定</a>
            <ul class="sub_menu">
              <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/business/edit_logo_style" title="編輯您的行動商務系統封面照樣式" alt="封面照設定" >封面照設定</a></li>
              <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/business/edit_iqr_style" title="編輯您的行動商務系統風格樣式" alt="風格設定" >風格設定</a></li>
              <?php if ($web_config['cart_status'] == 1): ?>
                <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/business/edit_cart_style" title="編輯您的行動商務系統行動商店樣式" alt="行動商店設定" >行動商店設定</a></li>
              <?php endif; ?>
            <?php if(0): ?>
              <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/business/edit_header_str" title="編輯您的行動商務系統風格分類標題文字" alt="分類標題文字設定" >分類文字設定</a></li>
            <?php endif; ?>
            </ul>
          </li>

          <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" id='<?=$id_on['photo_management']?><?=$id_on['exfile_management']?>'>相簿與附件</a>
            <ul class="sub_menu">
              <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/photo_category/main" title="編輯您的行動商務系統相簿類別" alt="新增相簿">新增相簿</a></li>
              <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/business/photo_management" title="編輯您的行動商務系統相簿內容" alt="相簿管理">相簿管理</a></li>
              <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/business/exfile_management" title="編輯您的行動商務系統附件內容" alt="附件管理">附件管理</a></li>
            </ul>
          </li>

          <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" id='<?=$id_on['edit_qrcode']?>'>QRcode樣式</a>
            <ul class="sub_menu">
              <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/business/edit_qrcode/2" title="編輯您的行動商務系統(APP版)QRcode風格樣式" alt="行動商務系統(APP版)">APP版</a></li>
              <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/business/edit_qrcode/0" title="編輯您的行動商務系統(網頁版)QRcode風格樣式" alt="行動商務系統(網頁版)">網頁版</a></li>
              <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/business/edit_qrcode/1" title="編輯您的通訊錄QRcode風格樣式" alt="通訊錄">通訊錄</a></li>
            </ul>
          </li>

          <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" id='<?=$id_on['eform']?><?=$id_on['ecoupon']?><?=$id_on['ediscount']?>'>表單工具</a>
            <ul class="sub_menu">
              <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/business/eform" title="編輯您的行動商務系統自訂表單" alt="自訂表單">自訂表單</a></li>
              <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/business/ecoupon" title="編輯您的行動商務系統好友分享券" alt="好友分享券">好友分享券</a></li>
              <!-- <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/business/ediscount" title="編輯您的行動商務系統優惠券" alt="自訂優惠券">自訂優惠券</a></li> -->
            </ul>
          </li>

          <?php if ($web_config['cart_status'] == 1): ?>
            <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" id='<?=$id_on['cart_management']?><?=$id_on['store_setting']?><?=$id_on['order_management']?>'>行動商店</a>
              <ul class="sub_menu">
                <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/cart/store_setting" title="基本設定" alt="基本設定">基本設定</a></li>
                <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/cart/cart_management" title="商品管理" alt="商品管理">商品管理</a></li>
                <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/cart/order_management" title="訂單管理" alt="訂單管理">訂單管理</a></li>
                <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/generator/order" title="訂單查詢/匯出" alt="訂單查詢/匯出">訂單查詢/匯出</a></li>
              </ul>
            </li>
          <?php endif; ?>
          
          <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" id='<?=$id_on['update']?><?=$id_on['iqr_views']?><?=$id_on['setting']?><?=$id_on['member_list']?><?=$id_on['key_list']?><?=$id_on['web_config']?>'>管理中心</a>
            <ul class="sub_menu">
              <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/user/update/updp" title="修改密碼" alt="修改密碼">修改密碼</a></li>
              <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/user/iqr_views" title="系統流量" alt="系統流量">系統流量</a></li>

                <?php if ($domain_id != 2 && $domain_id != ''): ?>
                  <li style="width: <?=$menu_width?>;"><?=$auth_cols?></li>
                <?php endif; ?>

              <?php if ($user_auth == '01'): ?><li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/user/member_list" title="管理會員" alt="管理會員">管理會員</a></li><?php endif; ?>
              <?php if ($user_auth == '01'): ?><li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/user/key_list" title="金鑰狀態" alt="金鑰狀態">金鑰狀態</a></li><?php endif; ?>
              <?php if ($user_auth == '01'): ?><!-- <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/user/web_config" title="網站設定" alt="網站設定">網站設定</a></li> --><?php endif; ?>
            </ul>
          </li>

          <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" id='<?=$id_on['build']?><?=$id_on['release']?><?=$id_on['notification']?><?=$id_on['release_setting']?>'>APP設定</a>
            <ul class="sub_menu">
              <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/appui/build" title="利用自動打包功能來更新您的APP安裝程式" alt="自動打包">自動打包</a></li>
              <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/appui/release" title="透過申請上架到 Google Play" alt="申請上架">申請上架</a></li>
              <?php if ($real_ip == '118.170.54.170'): ?>
                <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/appui/notification" title="透過申請推播讓您的APP享有此功能" alt="申請推播">申請推播</a></li>
              <?php endif; ?>

              <?php //if ($release_setting): ?>
              <?php if (0): ?>
                <li style="width: <?=$menu_width?>;"><a style="width: <?=$menu_width?>;" href="/appui/release_setting" title="在此設定上架網址與下載頁面" alt="上架管理">上架管理</a></li>
              <?php endif; ?>

            </ul>
          </li>
          
        </ul>

      </div>
    </nav>

  </div><!--<div id="header-bg2">-->
</div><!--<div id="header-bg1">-->
