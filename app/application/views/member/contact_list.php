 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head id=<?=$dbname?>>

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
  </style>

</head>
<script src='/js/myjava/allcheck.js'></script>
<center>
    <?=form_open($form,array('enctype'=>"multipart/form-data","id"=>"search_form"));?>

<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center">
  <table >
    <tr>
      <td>
        <select name="s_type">
          <option value="">請選擇</option>
          <option value="Y" <?=($s_type=='Y')?'selected':'';?>>已回覆</option>
          <option value="N" <?=($s_type=='N')?'selected':'';?>>未回覆</option>
        </select>
        <input type="button" value="搜尋" style=" font-size:14px;"  onclick="$(this).closest('form').submit()"/>
      </td>
    </tr>
  </table>
  <!--會員資料列表-->
  <table id='member_list' class='table table-hover table-bordered table-condensed' style="width:80%;">
    <tr id='member_list_title_tr'>
      <td>狀態</td>
      <td>姓名</td>
      <td>Email</td>
      <td>手機</td>
      <td>詢問日期</td>
      <td>回覆日期</td>
      <td>回覆</td>
      <td>刪除</td>
    </tr>
    <!--for-->
    <?php if (!empty($dbdata)): ?>
        <?php foreach ($dbdata as $key => $value): ?>
          <tr bgcolor='<?=$member_auth_color[$key]?>'>
            <td class='center_td white_td'><?=$value['d_is_send']?></td>
            <td class='center_td white_td'><?=$value['d_name']?></td>
            <td class='center_td white_td'><?=$value['d_mail']?></td>
            <td class='center_td white_td'><?=$value['d_phone']?></td>
            <td class='center_td white_td'><?=$value['create_time']?></td>
            <td class='center_td white_td'><?=$value['update_time']?></td>
            <td class='center_td white_td'> 
              <a href="javascript:void(0);" onclick="top.frames['content-frame'].location='/member/<?=$dbname?>_info/<?=$value['d_id']?>'">
                <i class="fa fa-cogs"></i>
              </a>
            </td>
            <td class='center_td white_td'> 
              <a href="javascript:void(0);" onclick="del_file('<?=$value['d_name']?>','<?=$value['d_id']?>')">
                <i class="fa fa-trash-o"></i>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>

    <?php endif; ?>
    <input type="hidden" name="ToPage" id="ToPage" value="<?=$ToPage?>">    
  </table>
    <?=$page?>
  </form>
<p style="height:200px;"></p>

</body>
</html>
<script>

  function del_file(name,id){
    if(confirm('確定刪除['+name+']資料?'))
      window.location.href='/member/data_AED/<?=$dbname?>/'+id;
  }
  
</script>