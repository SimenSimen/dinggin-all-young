 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head id='invoice'>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>行動名片系統</title>

  <!-- css --> 
  <link type="text/css" rel="stylesheet" href="/css/admin.css">
  
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">  

  <!-- jQuery -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">
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
  <center>
    <?=form_open($form,array('enctype'=>"multipart/form-data"));?>

  <table >
    <tr>
      <td>
        <select name="show_num" id="show_num" >
          <option value="no">請選擇</option>
          <option value="Y">批次上架</option>
          <option value="N">批次下架</option>            
        </select>
        <input type="button" value="修改" style=" font-size:14px;"  onclick="allcheck()"/>
      </td>
      <td >
        <!-- <button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/bonus/invoice_info'"> -->
        <button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/bonus/invoice_info'">
          新增發票
        </button>
      </td>
    </tr>
  </table>

  <!--會員資料列表-->
  <table id='member_list' class='table table-hover table-bordered table-condensed' style="width:80%;">

    <tr id='member_list_title_tr'>
      <td>選取<input type="checkbox" onclick="check_all(this,'allid[]')"></td>
      <td>啟用</td>
      <td>發票編碼</td>
      <td>發票日期</td>
      <td>起始號碼</td>
      <td>結束號碼</td>
      <td>新增時間</td>
      <!-- <td>修改</td> -->
      <td>刪除</td>
    </tr>

    <!--for-->
    <?php if (!empty($dbdata)): ?>

        <?php foreach ($dbdata as $key => $value): ?>
          <tr bgcolor='<?=$member_auth_color[$key]?>'>
            <td class='center_td white_td'><input type="checkbox" name="allid[]" value="<?=$value['d_id']?>"></td>
            <td class='center_td white_td'> <?=($value['d_is_open']=='Y')?'是':'否';?></td>
            <td class='center_td white_td'><?=$value['d_code']?></td>
            <td class='center_td white_td'><?=$value['d_year'].'年'.$value['d_month'].'-'.($value['d_month']+1).'月'?></td>
            <td class='center_td white_td'><?=$value['d_start']?></td>
            <td class='center_td white_td'><?=$value['d_end']?></td>
            <td class='center_td white_td'><?=$value['create_time']?></td>            
            <td class='center_td white_td'> 
              <a href="javascript:void(0);" onclick="del_file('<?=$value['d_year'].'-'.$value['d_month']?>','<?=$value['d_id']?>')">
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
      window.location.href='/bonus/data_AED/invoice/'+id;
  }
  
</script>