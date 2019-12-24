 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>行動名片系統</title>

  <!-- css -->
  <link type="text/css" rel="stylesheet" href="/css/admin.css">
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">  

  <!-- jQuery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">
  
  <!-- bootstrap -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
  <style type="text/css">
    .ui-dialog-titlebar-close
    {
      background-image: url(/images/close-icon.png);
      background-size: cover;
    }
    .btn
    {
      font-size: 18px;
    }
    #button_table
    {
      width:80%;
      margin-top: 10px;
    }
    #button_table tr td
    {
      padding-top:5px;
      padding-bottom: 5px;
      padding-left: 5px;
    }
    #member_list tr td
    {
      padding: 5px;
    }
    #member_list_title_tr td
    {
      text-align: center;
      background-color: #333;
      color: #fff;
    }
    .white_td
    {
      color: <?=$web_config['admin_font_color']?>;
    }
    .center_td
    {
      text-align: center;
    }
    #password_title_td
    {
      cursor: pointer;
      color: #F99;
    }
    .checkbox_td
    {
      zoom: 150%;
      text-align: center;
      vertical-align: middle;
    }
    .mycheckbox
    {
      cursor: pointer;
    }
    .info_prompt
    {
      text-align: right;
      color: #F60;
      font-size: 14px;
    }
    #list_content {
        border-left-width: 1px;
        border-left-style: solid;
        border-left-color: #BDC3C7;
        min-height: 200px;
    }
    .MonthBox, a.MonthBox:hover {
        width: 110px;
        height: 80px;
        line-height: 80px;
        text-align: center;
        border: 1px solid #CCCCCC;
        border-radius: 5px;
        /*float: left;*/
        margin: 10px;
        text-decoration: none;
    }
    h1 {
      color: #222222;
      font-size: 14pt;
      border-bottom: 4px solid #DEDEDE;
      display: block;
      padding-bottom: 5px;
      margin: 12px auto 3px auto;
  }
  </style>
  <script src="/js/myjava/post_url.js"></script>
</head>

<center>
<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center">

  <table id='button_table'>
    <tr style="text-align:right;">

      <td style="width:96%; color:#5A0087;">請選取要查詢或編輯的月份</td>
      
    </tr>
  </table>

  <!--會員資料列表-->
  <? foreach ($bdate as $value):
      if($iYear != $value["d_Year"]):
        $iYear = $value["d_Year"]; 
    ?>
      <div class="Line01"></div><h1><?=$iYear?> 年度</h1>
    <?endif;?>
      <a href="javascript:void(0)" onclick="month_total(<?=$iYear.$value['iMonth']?>)" target="_self" class="MonthBox">
        第<?=$value['iMonth']?>工作月
      </a>
  <? endforeach;?>



</body>
</html>
<script>
function month_total(date){
  if(confirm('確定統計'+date+'總表?'))
  $.ajax({
        type: 'POST',
        scriptCharset: 'utf-8',
        cache: false,
        url: '/bonus/total_hand',
        data: 'date=' + date,
        success: function(json){
           if(json=='ok'){
             alert('第 ' + date+ ' 工作月已統計!!');
           }
        }
     });
}
</script>