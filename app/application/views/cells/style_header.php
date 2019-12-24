<style type="text/css">
  table.personal-info td.dd2 { width: 18%;}
  fieldset { min-height: 750px; }
  table.personal-info input[type='text'] {
    width: 250px;
    padding: 7px;
    border: 1px solid #CAC2A9;
    border-radius: 3px;
    margin: 0px 3px;
    font-size: 1em;
    font-family: 'Microsoft Jhenghei';
  }
</style>
<table border="0" cellspacing="0" cellpadding="0" class="personal-info">
  <?php switch ($iqr['theme_id']): 
    case 1: ?>
      <div style="float:left;">你選擇的風格無法設定標題</div> <a href="/business/edit_iqr_style" style="margin: 50px; background: #4E9CAF; padding: 10px; text-align: center; border-radius: 5px; color: white;">前往更換風格</a>
      <input type='hidden' class="colspan2" maxlength="12" name='strings_array[]'  value=''>
    <?php break; ?>

    <?php case 2: ?>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">About</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='About' maxlength="12" name='strings_array[]'  value='<?=$header_text[0]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">Video</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='Video' maxlength="12" name='strings_array[]'  value='<?=$header_text[1]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">附件</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='附件' maxlength="12" name='strings_array[]'  value='<?=$header_text[2]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">企業形象</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='企業形象' maxlength="12" name='strings_array[]'  value='<?=$header_text[3]?>'>
        </td>
      </tr>
    <?php break; ?>

    <?php case 3: ?>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">QRcode</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='QRcode' maxlength="12" name='strings_array[]'  value='<?=$header_text[0]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">聯絡資訊</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='聯絡資訊' maxlength="12" name='strings_array[]'  value='<?=$header_text[1]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">地圖</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='地圖' maxlength="12" name='strings_array[]'  value='<?=$header_text[2]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">網站網址</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='網站網址' maxlength="12" name='strings_array[]'  value='<?=$header_text[3]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">我的網頁</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='我的網頁' maxlength="12" name='strings_array[]'  value='<?=$header_text[4]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">好友分享券</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='好友分享券' maxlength="12" name='strings_array[]'  value='<?=$header_text[5]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">附件</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='附件' maxlength="12" name='strings_array[]'  value='<?=$header_text[6]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">企業形象</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='企業形象' maxlength="12" name='strings_array[]'  value='<?=$header_text[7]?>'>
        </td>
      </tr>
    <?php break; ?>

    <?php case 4: ?>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">地圖</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='地圖' maxlength="12" name='strings_array[]'  value='<?=$header_text[0]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">網站網址</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='網站網址' maxlength="12" name='strings_array[]'  value='<?=$header_text[1]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">我的網頁</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='我的網頁' maxlength="12" name='strings_array[]'  value='<?=$header_text[2]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">好友分享券</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='好友分享券' maxlength="12" name='strings_array[]'  value='<?=$header_text[3]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">附件</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='附件' maxlength="12" name='strings_array[]'  value='<?=$header_text[4]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">企業形象</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='企業形象' maxlength="12" name='strings_array[]'  value='<?=$header_text[5]?>'>
        </td>
      </tr>
    <?php break; ?>

    <?php case 5: ?>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">聯絡我</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='聯絡我' maxlength="12" name='strings_array[]'  value='<?=$header_text[0]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">關於我</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='關於我' maxlength="12" name='strings_array[]'  value='<?=$header_text[1]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">分享</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='分享' maxlength="12" name='strings_array[]'  value='<?=$header_text[2]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">形象圖</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='形象圖' maxlength="12" name='strings_array[]'  value='<?=$header_text[3]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">Video</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='Video' maxlength="12" name='strings_array[]'  value='<?=$header_text[4]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">地圖</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='地圖' maxlength="12" name='strings_array[]'  value='<?=$header_text[5]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">網站網址</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='網站網址' maxlength="12" name='strings_array[]'  value='<?=$header_text[6]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">我的網頁</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='我的網頁' maxlength="12" name='strings_array[]'  value='<?=$header_text[7]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">好友分享券</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='好友分享券' maxlength="12" name='strings_array[]'  value='<?=$header_text[8]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">附件</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='附件' maxlength="12" name='strings_array[]'  value='<?=$header_text[9]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">企業形象</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='企業形象' maxlength="12" name='strings_array[]'  value='<?=$header_text[10]?>'>
        </td>
      </tr>
    <?php break; ?>

    <?php case 6: ?>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">企業形象</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='企業形象' maxlength="12" name='strings_array[]'  value='<?=$header_text[0]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">Qrcode</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='Qrcode' maxlength="12" name='strings_array[]'  value='<?=$header_text[1]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">聯絡資訊</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='聯絡資訊' maxlength="12" name='strings_array[]'  value='<?=$header_text[2]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">地圖</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='地圖' maxlength="12" name='strings_array[]'  value='<?=$header_text[3]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">網站網址</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='網站網址' maxlength="12" name='strings_array[]'  value='<?=$header_text[4]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">我的網頁</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='我的網頁' maxlength="12" name='strings_array[]'  value='<?=$header_text[5]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">好友分享券</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='好友分享券' maxlength="12" name='strings_array[]'  value='<?=$header_text[6]?>'>
        </td>
      </tr>
      <tr>
        <td class="dd1"></td>
        <td class="dd2">附件</td>
        <td class="dd3">
          <input type='text' class="colspan2" placeholder='附件' maxlength="12" name='strings_array[]'  value='<?=$header_text[7]?>'>
        </td>
      </tr>
    <?php break; ?>
  <?php endswitch; ?>
  <input type="hidden" name="theme_id" value="<?=$iqr['theme_id']?>">
</table>