<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>行動名片系統</title>

  <!-- css -->
  <link type="text/css" rel="stylesheet" href="/css/admin.css">


  <!-- 預覽的css -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <link type="text/css" rel="stylesheet" href="/css/uform_add.css">
  
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
<body background="<?=$style_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form method="post" id='system_config_form' action='/admin/style_config'>
  <div class="config-div">
    <fieldset class="config-border">
        <legend class="config-border">版型設定檔</legend>
        <table id="member_list" class="table table-bordered table-condensed" style="width:100%;">          
            <tr>
              <td class='member_list_title_td'>版型選擇</td>
                <td>
                  <input type="radio" id="style_id" name="style_id" value="0" <?=($style_config['style_id']==0)?'checked':'';?>>
                    <label>版型一
                      <a class="why" id="why_panel1" style="">?</a>                          
                        <div class='prompt-box' id='prompt_panel1' style="border:0; background-color:transparent;">
                          <img src="/images/style_config/001.jpg" style="height: 400px;width: 200px">
                        </div>
                    </label><br>
                  <input type="radio" id="style_id" name="style_id" value="2" <?=($style_config['style_id']==2)?'checked':'';?>>
                    <label>版型二
                      <a class="why" id="why_panel1" style="">?</a>                          
                        <div class='prompt-box' id='prompt_panel1' style="border:0; background-color:transparent;">
                          <img src="/images/style_config/002.jpg" style="height: 400px;width: 200px">
                          <p>註:版型一的左選單項目、設定項目在會員裡</p>
                        </div>
                    </label>
                </td>     
            </tr>
            <tr>
              <td colspan="4" style="text-align:right;">
                <input class="btn btn-info btn-large" type="submit" name='form_submit' id='form_submit' style="width: 100px;font-size: 18px;" value='設定'>
              </td>
            </tr>
        </table>
    </fieldset>
  </div>
</form>


<p style="height:200px;"></p>

</body>
</html>
