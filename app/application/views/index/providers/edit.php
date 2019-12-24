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
  <!-- 地區AJAX -->
  <script src="/js/myjava/region.js"></script>
</head>
<left>
<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form method="post" action="/providers/update/<?=$id?>" enctype="multipart/form-data" onsubmit="return check(this)">
  <div class="config-div">
    <fieldset class="config-border">
        <legend class="config-border" style="width:160px">個人設定</legend>
        <table id="member_list" class="table table-bordered table-condensed">
            <tr>
              <td class='member_list_title_td'>供應商名稱(中)</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" name="chinese_name" value="<?=$chinese_name?>"/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>供應商名稱(英)</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" name="english_name" value="<?=$english_name?>"/>
              </td>
            </tr>

            <tr>
              <td class='member_list_title_td'>統一編號</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" value="<?=$tax_id?>" readonly/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>負責人</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" name="principal" value="<?=$principal?>"/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>電話</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" name="phone" value="<?=$phone?>"/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>傳真</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" name="fax" value="<?=$fax?>"/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>登記地址</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" name="registration_address" value="<?=$registration_address?>"/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>聯絡地址</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" name="contact_address" value="<?=$contact_address?>"/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>公司網址</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" name="website" value="<?=$website?>"/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>設立日期</td>
              <td class='member_list_input_td'>
                <input class="form-control date-object" type="date" name="found_date" value="<?=$found_date?>">
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>資本額</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" name="capital_amount" value="<?=$capital_amount?>"/>
              </td>
            </tr>


            <tr>
              <td class='member_list_title_td'>營利事業登記證影本</td>
              <td class='member_list_input_td'>
                  <input type="file" name="registration_certificate" value="<?=$registration_certificate?>" />
                  <div id="fileList2"></div>
                  <br>原始圖檔:<br>
                  <div id="sort">
                    <img src="<?= $registration_certificate ? base_url().$registration_certificate : ''?>" style="max-width: 175px;"/>
                  </div>
                </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>聯絡人</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" name="contact_person_name" value="<?=$contact_person_name?>"/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>職稱</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" name="contact_person_job" value="<?=$contact_person_job?>"/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>聯絡電話</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" name="contact_person_phone" value="<?=$contact_person_phone?>"/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>行動電話</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" name="contact_person_mobile" value="<?=$contact_person_mobile?>"/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>電子郵件</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" name="contact_person_email" value="<?=$contact_person_email?>"/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>收款銀行</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" name="bank_name" value="<?=$bank_name?>"/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>分行名稱</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" name="bank_branch" value="<?=$bank_branch?>"/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>銀行代碼</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" name="bank_id" value="<?=$bank_id?>"/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>帳號</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" name="bank_account" value="<?=$bank_account?>"/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>結帳日</td>
              <td class='member_list_input_td'>
                <input class="form-control date-object" type="date" name="checkout_date" value="<?=$checkout_date?>">
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>付款條件</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" name="pay_condition" value="<?=$pay_condition?>"/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>存摺封面影本</td>
              <td class='member_list_input_td'>
                  <input type="file" name="passbook" value="<?=$passbook?>" />
                  <div id="fileList2"></div>
                  <br>原始圖檔:<br>
                  <div id="sort">
                    <img src="<?=$passbook ? base_url().$passbook : ''?>" style="max-width: 175px;"/>
                  </div>
                </td>
            </tr>
            


            <tr>
              <td colspan="4" style="text-align:right;">
                <input class="btn btn-info btn-large" type="submit" style="width: 100px;font-size: 18px;" value='儲存'>
              </td>
            </tr>       
        </table>

    </fieldset>
  </div>
</form>
<p style="height:200px;"></p>
</body>
</html>

<script>
  function check(frm) {
      if(frm.elements['d_name'].value==''){
        alert('供應商名稱不能空白');  
        return false;
      }
  }
 </script>