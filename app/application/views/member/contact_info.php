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
</head>
<script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script>
<left>
<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

  <div class="config-div">
    <fieldset class="config-border">
        <legend class="config-border" style="width:160px">詢問資料</legend>

        <table id="member_list" class="table table-bordered table-condensed">
            <tr>
              <td class='member_list_title_td'>姓名</td>
              <td class='member_list_input_td'><?=$dbdata['d_name']?></td>
            </tr>
            <tr>
              <td class='member_list_title_td'>性別</td>
              <td class='member_list_input_td'><?=$dbdata['d_sex']?></td>
            </tr>
            <tr>
              <td class='member_list_title_td'>電話</td>
              <td class='member_list_input_td'><?=$dbdata['d_mobile']?></td>
            </tr>
            <tr>
              <td class='member_list_title_td'>手機</td>
              <td class='member_list_input_td'><?=$dbdata['d_phone']?></td>
            </tr>
            <tr>
              <td class='member_list_title_td'>電子信箱</td>
              <td class='member_list_input_td'><?=$dbdata['d_mail']?></td>
            </tr>
            <tr>
              <td class='member_list_title_td'>內容</td>
              <td class='member_list_input_td'><?=$dbdata['d_content']?></td>
            </tr>
            <tr>
              <td class='member_list_title_td'>詢問時間</td>
              <td class='member_list_input_td'><?=$dbdata['create_time']?></td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="config-border">
      <legend class="config-border" style="width:160px">回覆資料</legend>
      <form method="post" action="/member/data_AED" >
      <table id="member_list" class="table table-bordered table-condensed">
        <?if($dbdata['d_is_send']=='Y'):?>
          <tr>
            <td class='member_list_title_td'>回覆內容</td>
            <td class='member_list_input_td'><?=$dbdata['d_send_content']?></td>
          </tr>
          <tr>
            <td class='member_list_title_td'>回覆時間</td>
            <td class='member_list_input_td'><?=$dbdata['update_time']?></td>
          </tr>
        <?else:?>
          <tr>
            <td class='member_list_title_td'>回覆</td>
            <td class='member_list_input_td'>
              <textarea name="d_send_content" id='prd_content'></textarea>
            </td>
          </tr>
        <?endif;?>
        
      </table>
      <tr>
        <td colspan="4" style="text-align:right;">
          <input type="hidden" name="d_mail" value="<?=$dbdata['d_mail']?>">
          <input type="hidden" name="d_content" value="<?=$dbdata['d_content']?>">
          <input type="hidden" name="d_id" value="<?=$dbdata['d_id']?>">
          <input type="hidden" name="dbname" value="<?=$dbname?>">
          <?if($dbdata['d_is_send']=='Y'):?>
            <input class="btn btn-info btn-large" type="button" onclick="javascript:history.go(-1);" style="width: 100px;font-size: 18px;" value='回到上頁'>
          <?else:?>
            <input class="btn btn-info btn-large" type="submit" style="width: 100px;font-size: 18px;" value='寄信'>
          <?endif;?>
          
        </td>
      </tr>     
  </form>
    </fieldset>
  </div>
  
<script src="/js/myjava/product.js"></script>

<p style="height:200px;"></p>

</body>
</html>
