<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>行動名片系統</title>

  <!-- css -->
  <link type="text/css" rel="stylesheet" href="/css/admin.css">
  
  <!-- jQuery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <script type="text/javascript">
    $(function(){
      $('#system_config_form').submit(function(event){
        if($('#global_deadline_status').val() == 1 && $('#global_deadline').val().length == 0)
        {
          alert('全局時間不可空');
          $('#global_deadline').focus();
          event.preventDefault();
        }
      });
    });
  </script>

  <!-- bootstrap -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
  <style type="text/css">
    div.config-div {
      margin-top: 20px;
      margin-left: 40px;
    }
    div.config-div-img {
      margin-left: 68%;
    }
    div.config-div-encrypt {
      margin-left: 68%;
    }
    div.config-div fieldset {
      display: inline;
      float: left;
    }
    fieldset.config-border {
      width: 65%;
      border: 1px groove #ddd !important;
      padding: 0 1.4em 1.4em 1.4em !important;
      margin: 0 0 1.5em 0 !important;
      -webkit-box-shadow:  0px 0px 0px 0px #000;
              box-shadow:  0px 0px 0px 0px #000;
    }
    fieldset.config-border-img, fieldset.config-border-encrypt {
      width: 100px;
      border: 1px groove #ddd !important;
      padding: 0 1.4em 1.4em 1.4em !important;
      margin: 0 0 1.5em 0 !important;
      -webkit-box-shadow:  0px 0px 0px 0px #000;
              box-shadow:  0px 0px 0px 0px #000;
              text-align: center;
              vertical-align: middle;
    }
    legend.config-border {
      font-size: 1.2em !important;
      font-weight: bold !important;
      text-align: left !important;
      width:auto;
      padding:0 10px;
      border-bottom:none;
      width: 130px;
    }
    .member_list_title_td
    {
      text-align: center;
      background-color: #333;
      color: #fff;
      width:150px;
    }
    #member_list tr td
    {
      vertical-align: middle;
    }
    .member_list_input_td
    {
      width:180px;
    }
    input[type=text], .input_select
    {
      background-color: #FDFFE2;
      font-size: 16px;
      color: #000;
    }
  </style>

</head>

<left>
<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<form method="post" id='system_config_form' action='/admin/system_config'>

  <div class="config-div">
    <fieldset class="config-border">
        <legend class="config-border">系統設定檔</legend>

        <table id="member_list" class="table table-bordered table-condensed" style="width:100%;">

            <tr><td class='member_list_title_td'>網站Logo</td><td class='member_list_input_td'><input type="text" class="form-control" id="logo" name="logo" placeholder="請把對應圖檔丟到設定路徑：/images/logo.gif" value='<?=$web_config['logo']?>' maxlength='64' /></td>
                <td class='member_list_title_td'>系統名稱</td><td class='member_list_input_td'><input type="text" class="form-control" id="title" name="title" placeholder="系統名稱：行動名片系統" value='<?=$web_config['title']?>'  maxlength='64'/></td>
            </tr>
            <tr><td class='member_list_title_td'>註冊入口</td><td class='member_list_input_td'><input type="text" class="form-control" id="register_code" name="register_code" value='<?=$register_code?>' maxlength='16' /></td>
                <td class='member_list_title_td'>層級數量</td>
                <td class='member_list_input_td'>
                  <select class="form-control input_select" id="auth_level_num" name="auth_level_num"/>
                    <option value='2' <?=$auth_level_num_selected[2]?>>2</option>
                    <option value='3' <?=$auth_level_num_selected[3]?>>3</option>
                    <!-- <option value='4' <?=$auth_level_num_selected[4]?>>4</option> -->
                  </select>
                </td>
            </tr>
            <tr><td class='member_list_title_td'>頭銜數量</td><td class='member_list_input_td'><input type="text" class="form-control" id="titlename_num" name="titlename_num" value='<?=$web_config['titlename_num']?>' maxlength='2'/></td>
                <td class='member_list_title_td'>影片數量</td><td class='member_list_input_td'><input type="text" class="form-control" id="video_num" name="video_num" value='<?=$web_config['video_num']?>' maxlength='2'/></td>
            </tr>
            <tr><td class='member_list_title_td'>網址數量</td><td class='member_list_input_td'><input type="text" class="form-control" id="website_num" name="website_num" value='<?=$web_config['website_num']?>' maxlength='2'/></td>
                <td class='member_list_title_td'>地址數量</td><td class='member_list_input_td'><input type="text" class="form-control" id="address_num" name="address_num" value='<?=$web_config['address_num']?>' maxlength='2'/></td>
            </tr>
            <tr><td class='member_list_title_td'>名片連結</td><td><select class="form-control input_select" id="iqr_link_type" name="iqr_link_type"/><option value='0' <?=$iqr_link_type_selected[0]?>>長網址</option><option value='1' <?=$iqr_link_type_selected[1]?>>短網址</option></select></td>
                <td class='member_list_title_td'>註冊連結</td><td><select class="form-control input_select" id="register_status" name="register_status"/><option value='0' <?=$register_status_selected[0]?>>不顯示</option><option value='1' <?=$register_status_selected[1]?>>顯示</option></select></td>
            </tr>
            <tr><td class='member_list_title_td'>網頁背景</td><td class='member_list_input_td'><select class="form-control input_select" id="web_banner" name="web_banner"/><option value='0' <?=$web_banner_selected[0]?>>使用預設</option><option value='1' <?=$web_banner_selected[1]?>>使用域名資料夾</option></select></td>
                <td class='member_list_title_td'>上文字色</td><td class='member_list_input_td'><input type="text" class="form-control" id="web_banner_color" name="web_banner_color" value='<?=$web_config['web_banner_color']?>' maxlength='7'/></td>
            </tr>
            <tr><td class='member_list_title_td'>底部文字</td><td class='member_list_input_td'><input type="text" class="form-control" id="web_footer_text" name="web_footer_text" value='<?=$web_config['web_footer_text']?>' maxlength='64'/></td>
                <td class='member_list_title_td'>名片底字</td><td class='member_list_input_td'><input type="text" class="form-control" id="iqr_footer_text" name="iqr_footer_text" value='<?=$web_config['iqr_footer_text']?>' maxlength='64'/></td>
            </tr>
            <tr>
                <td class='member_list_title_td'>貨幣符號</td><td class='member_list_input_td'><input type="text" class="form-control" id="currency" name="currency" value='<?=$web_config['currency']?>' maxlength='64'/></td>
                <td class='member_list_title_td'>分類數量</td>
                <td><input type="text" class="form-control" id="prd_class_num" name="prd_class_num" value='<?=$web_config['prd_class_num']?>' maxlength='2'/></td>
            </tr>

            <tr><td class='member_list_title_td'>訂單功能</td>
                <td>
                  <select class="form-control input_select" id="cart_status" name="cart_status"/>
                    <option value='1' <?=$cart_status_selected[1]?>>授權使用購物車</option>
                    <option value='0' <?=$cart_status_selected[0]?>>關閉購物車</option>
                  </select>
                </td>
                <td class='member_list_title_td'>購買商品是否可選擇規格</td>
                <td>
                  <select class="form-control input_select" id="cart_spec_status" name="cart_spec_status"/>
                    <option value='1' <?=$cart_spec_status_selected[1]?>>可選擇規格</option>
                    <option value='0' <?=$cart_spec_status_selected[0]?>>不可選擇規格</option>
                  </select>
                </td>
            </tr>

            <tr><td class='member_list_title_td'>預設引用</td>
                <td>
                  <select class="form-control input_select" id="quoted_default" name="quoted_default"/>
                    <option value='1' <?=$quoted_default_selected[1]?>>是</option>
                    <option value='0' <?=$quoted_default_selected[0]?>>否</option>
                  </select>
                </td>

                <td class='member_list_title_td'>群體推播</td>
                <td>
                  <select class="form-control input_select" id="quoted_default" name="group_push"/>
                    <option value='1' <?=$group_push_selected[1]?>>開啟</option>
                    <option value='0' <?=$group_push_selected[0]?>>關閉</option>
                  </select>
                </td>
            </tr>

            <tr>
              <td class='member_list_title_td'>首頁是否轉址</td>
                <td>
                  <input type="radio" id="is_transfer" name="is_transfer" value="0" <?=($web_config['is_transfer']==0)?'checked':'';?>><label>否</label>
                  <input type="radio" id="is_transfer" name="is_transfer" value="1" <?=($web_config['is_transfer']==0)?'':'checked';?>><label>是</label>
                  <select style="width:128px;display: inline;" class="form-control input_select" id="transfer" name="transfer"/>
                    <option value="products" <?=($web_config['transfer']=='products')?'selected':'';?>>購物商城</option>
                    <option value="gold/member" <?=($web_config['transfer']=='gold/member')?'selected':'';?>>會員專區</option>
                    <option value="gold/news/C/news" <?=($web_config['transfer']=='gold/news/C/news')?'selected':'';?>>最新消息</option>
                  </select>
                </td>                
                <td class='member_list_title_td'>產品首頁</td>
                <td>
                  <input type="radio" id="product_home" name="product_home" value="0" <?=($web_config['product_home']==0)?'checked':'';?>><label>最新商品</label>
                  <input type="radio" id="product_home" name="product_home" value="1" <?=($web_config['product_home']==0)?'':'checked';?>><label>熱銷商品</label>
                </td>
            </tr>

            <tr>               
                <td class='member_list_title_td'>產品分類是否開啟圖片</td>
                <td>
                  <input type="radio" id="prd_class_img" name="prd_class_img" value="0" <?=($web_config['prd_class_img']==0)?'checked':'';?>><label>否</label>
                  <input type="radio" id="prd_class_img" name="prd_class_img" value="1" <?=($web_config['prd_class_img']==0)?'':'checked';?>><label>是</label>
                <td class='member_list_title_td'>有推薦人才可購物</td>
                <td>
                  <input type="radio" id="is_PID" name="is_PID" value="0" <?=($web_config['is_PID']==0)?'checked':'';?>><label>否</label>
                  <input type="radio" id="is_PID" name="is_PID" value="1" <?=($web_config['is_PID']==0)?'':'checked';?>><label>是</label>
                </td>
            </tr>


            <tr>               
                <td class='member_list_title_td'>使用支付寶註冊</td>
                <td>
                  <input type="radio" id="is_alipay" name="is_alipay" value="0" <?=($web_config['is_alipay']==0)?'checked':'';?>><label>否</label>
                  <input type="radio" id="is_alipay" name="is_alipay" value="1" <?=($web_config['is_alipay']==0)?'':'checked';?>><label>是</label>
                </td>
            </tr>

            <tr><td class='member_list_title_td'>全局期限</td>
                <td colspan="3">
                  <select style="width:128px;display: inline;" class="form-control input_select" id="global_deadline_status" name="global_deadline_status"/>
                    <option value='0' <?=$g_deadline_status_selected[0]?>>個別期限</option>
                    <option value='1' <?=$g_deadline_status_selected[1]?>>全局期限</option>
                  </select>
                  <input style="width:371px;display: inline;" type="text" class="form-control" id="global_deadline" name="global_deadline" placeholder="全局時間戳記" value='<?=$web_config['global_deadline']?>' maxlength='10' />
                </td>
              </tr>
            
            <tr><td class='member_list_title_td'>G-FreeLink</td>
                <td colspan="3">
                  <select style="width:128px;display: inline;" class="form-control input_select" id="g_free_link_status" name="g_free_link_status"/>
                    <option value='0' <?=$g_free_link_status_selected[0]?>>設為個別</option>
                    <option value='1' <?=$g_free_link_status_selected[1]?>>設為全局</option>
                  </select>
                  <input style="width:371px;display: inline;" type="text" class="form-control" id="free_link_name" name="free_link_name" placeholder="名稱:不顯示請設為空值" value='<?=$web_config['free_link_name']?>' maxlength='10' />
                </td>
              </tr>
            <tr><td class='member_list_title_td'>註冊自動升級經營會員</td>
                <td>
                  <select class="form-control input_select" id="is_auto_upgrade_member" name="is_auto_upgrade_member"/>
                    <option value='1' <?=$is_auto_upgrade_member[1]?>>開啟</option>
                    <option value='0' <?=$is_auto_upgrade_member[0]?>>關閉</option>
                  </select>
                </td>
                <td class='member_list_title_td'>註冊自動申請wowpay</td>
                <td>
                  <select class="form-control input_select" id="is_auto_register_wowpay" name="is_auto_register_wowpay"/>
                    <option value='1' <?=$is_auto_register_wowpay[1]?>>開啟</option>
                    <option value='0' <?=$is_auto_register_wowpay[0]?>>關閉</option>
                  </select>
                </td>
            </tr>
            <tr><td class='member_list_title_td'>商品是否顯示福寶價格</td>
                <td>
                  <select class="form-control input_select" id="is_show_fb" name="is_show_fb"/>
                    <option value='1' <?=$is_show_fb[1]?>>開啟</option>
                    <option value='0' <?=$is_show_fb[0]?>>關閉</option>
                  </select>
                </td>
                <td class='member_list_title_td'>商品是否顯示PV</td>
                <td>
                  <select class="form-control input_select" id="is_show_pv" name="is_show_pv"/>
                    <option value='1' <?=$is_show_pv[1]?>>開啟</option>
                    <option value='0' <?=$is_show_pv[0]?>>關閉</option>
                  </select>
                </td>
            </tr>
            <tr><td class='member_list_title_td'>會員是否可互轉紅利</td>
                <td>
                  <select class="form-control input_select" id="is_givebonus" name="is_givebonus"/>
                    <option value='1' <?=$is_givebonus[1]?>>開啟</option>
                    <option value='0' <?=$is_givebonus[0]?>>關閉</option>
                  </select>
                </td>
                <td class='member_list_title_td'>是否寄信通知會員註冊購物</td>
                <td>
                  <select class="form-control input_select" id="is_notice_email" name="is_notice_email"/>
                    <option value='1' <?=$is_notice_email[1]?>>開啟</option>
                    <option value='0' <?=$is_notice_email[0]?>>關閉</option>
                  </select>
                </td>
            </tr>
            <tr><td class='member_list_title_td'>會員註冊購物寄信通知email</td>
                <td colspan=3>
					<input style="width:500px;display: inline;" type="text" class="form-control" id="notice_email" name="notice_email" placeholder="" value='<?=$web_config['notice_email']?>' maxlength='255' />
                </td>
            </tr>
            <tr>
              <td colspan="4" style="text-align:right;">
                <input class="btn btn-default btn-large" onclick="top.frames['content-frame'].location='/admin/make_register_code'" type="button" name='mrlc' id='mrlc' style="width: 100px;font-size: 18px;" value='MRLC'>
                <input class="btn btn-info btn-large" type="submit" name='form_submit' id='form_submit' style="width: 100px;font-size: 18px;" value='設定'>
              </td>
            </tr>

        </table>

    </fieldset>
  </div>

</form>

<div class="config-div-img">
  <fieldset class="config-border-img">
      <legend class="config-border">網站Logo</legend>
      <img style="width:100px;" src='<?=$web_config['logo']?>'>
  </fieldset>
</div>

<form action='/admin/make_code' method='post' name='encrypt_form'>

  <div class="config-div-encrypt">
    <fieldset class="config-border-encrypt">
        <legend class="config-border">編碼</legend>
          <input type="text" class="form-control" id="encrypt_code" name="encrypt_code"/>
          <p style="padding-top:2px;"><input class="btn btn-primary" type="submit" value='make' style="width:100%;font-size: 18px;"></p>
    </fieldset>
  </div>
  
</form>

<p style="height:200px;"></p>

</body>
</html>
