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
  <script src="/js/ajaxupload.min.js" type="text/javascript"></script>

</head>

<left>
<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
  <table id='button_table'>
    <tr style="text-align:right;">
      <td style="width:96%;">
        <button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/bonus/account_rule'">
          獎金規則管理
        </button>
      </td>
      <td style="width:1%;">
        <button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/bonus/invoice_list'">
          電子發票管理
        </button>
      </td>
      <td style="width:1%;">
        <button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/bonus/twohisetting'">
          二代健保代扣更新
        </button>
      </td>
    </tr>
  </table>
<form method="post" action="/bonus/invoice_AED" >

  <div class="config-div">
    <fieldset class="config-border">
        <legend class="config-border" style="width:160px">二代健保代扣更新</legend>

        <table id="member_list" class="table table-bordered table-condensed">
            <tr>
                1. 下載目前系統中全部個人會員身份證檔：<input type="button" class="" name="BtnDow" id="BtnDow" value="下載身份證檔"><br>

                2. 將下載的個人會員身份證檔案提交到健保局確認應代扣二代健保人員<br><br>

                3. 上傳二代健保代扣身份證檢查檔到本系統：  <input type="button" class="" name="BtnAtt" id="BtnAtt" value="選取檢查檔"> <br>
            </tr>
            
        </table>

    </fieldset>
  </div>

</form>


<p style="height:200px;"></p>

</body>
</html>
<script>
var oButton = $('#BtnAtt'), iInterval;
new AjaxUpload(oButton, {
 action: '/bonus/uploads_id',
 name: 'filetmp',
 onSubmit : function(file, ext){
    if (ext && /^(txt|csv|dat)$/.test(ext.toLowerCase())){
      
    } else {
      alert('僅允許文字類型檔案');
      return false;
    }
 },
 onComplete: function(file, response){
    window.clearInterval(iInterval);
    this.enable();
    if ( response != 'error') {
       alert(response);
    }else{
       alert('傳送時發生錯誤!!');
    }
 }
});

$('#BtnDow').click(function(){
     window.open('/bonus/report_userid');
  });
</script>