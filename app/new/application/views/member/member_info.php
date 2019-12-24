<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>行動名片系統</title>

  <!-- css -->
  <link type="text/css" rel="stylesheet" href="/css/admin.css">
  
  <!-- jQuery -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>


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
<form method="post" action="/member/user_AED" >

  <div class="config-div">
    <fieldset class="config-border">
        <legend class="config-border" style="width:160px"><?=$title?></legend>

        <table id="member_list" class="table table-bordered table-condensed">
            <tr>
              <td class='member_list_title_td'>帳號(限用英數)</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" name="account" value='<?=$dbdata['account']?>' <?=($dbdata['account']!='')?'readonly':'';?>/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>姓名</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" name="d_name" value='<?=$dbdata['d_name']?>'/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>電子信箱</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" name="email" value='<?=$dbdata['email']?>'/>
              </td>
            </tr>
            <tr>
              <td class='member_list_title_td'>登入密碼</td>
              <td class='member_list_input_td'>
                <input type="text" class="form-control" name="password" value='<?=$dbdata['password']?>'/>
              </td>
            </tr>
            <tr>
                <td class='member_list_title_td'>權限設定</td>
                <td class='member_list_input_td'>
                  <select name="d_action">
                    <? foreach ($jurisdicer as $value):?>
                      <option value="<?=$value['d_id']?>" <?=($dbdata['d_action']==$value['d_id'])?'selected':'';?>><?=$value['d_name']?></option>
                    <? endforeach;?>
                  </select>
                </td>
            </tr>
            
            <tr>
                <td class='member_list_title_td'>狀態</td>
                <td class='member_list_input_td'>
                  <input type="radio" name="d_is_open" value='Y' <?=($dbdata['d_is_open']=='Y')?'checked':'';echo ($dbdata['d_is_open']=='')?'checked':'';?> />開啟
                  <input type="radio" name="d_is_open" value='N' <?=($dbdata['d_is_open']=='N')?'checked':'';?> />關閉
                </td>
            </tr>
            </table>

            
          <tr>
            <td colspan="4" style="text-align:right;">
              <input type="hidden" name="d_id" value="<?=$dbdata['member_id']?>">
              <input type="hidden" name="dbname" value="<?=$dbname?>">
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
