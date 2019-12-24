 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head id="<?=$db?>">

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
<script src="/js/myjava/post_url.js"></script>
</head>
<center>
<?=form_open($form,array('enctype'=>"multipart/form-data","id"=>"search_form"));?>

<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center">
  <form method="post">
  <table >
    <tr>
      <td>
        <?=$toyear?>
        <input type="hidden" name="search_year" value="<?=$toyear?>">
        <!-- <select name="search_year">
          <? for ($i=$toyear; $i <=$toyear ; $i++):?>
            <option value="<?=$i?>"><?=$i?></option>
          <? endfor;?>
        </select> -->年
        <select name="search_month" >
          <? for ($i=1; $i <=12 ; $i++):?>
            <option value="<?=substr('00'.$i,-2)?>"  <?=($s_month==$i)?'selected':'';?>><?=substr('00'.$i,-2)?></option>
          <? endfor;?>
        </select>月
        <input type="submit" value="搜尋" style=" font-size:14px;" />
      </td>
    </tr>
  </table>

  <!--會員資料列表-->
  <table id='member_list' class='table table-hover table-bordered table-condensed' style="width:80%;">

    <tr id='member_list_title_tr'>
      <td>會員編號</td>
      <td>姓名</td>
      <td>入會日期</td>
      <td>年度消費金額</td>
      <td>消費記錄</td>
      <td>晉昇</td>
    </tr>

    <!--for-->
    <?php if (!empty($dbdata)): ?>

        <?php foreach ($dbdata as $key => $value): ?>
          <tr bgcolor='<?=$member_auth_color[$key]?>'>
            <td class='center_td white_td'><?=$value['member_num']?></td>
            <td class='center_td white_td'><?=$value['name']?></td>
            <td class='center_td white_td'><?=substr($value['mcreate_time'],0,10)?></td>
            <td class='center_td white_td'><?=$value['stotal']?></td>
            <td class='center_td white_td'> 
              <a href="javascript:void(0);" onclick="window.open('/bonus/grade_info/<?=$s_year?>/<?=$s_month?>/<?=$value['member_id']?>', '查看消費記錄', config='height=500, width=1000');">
              
                <i class="fa fa-cogs"></i>
              </a>
            </td>
            <td class='center_td white_td'> 
              <!-- <a href="javascript:void(0);" onclick="top.frames['content-frame'].location='/bonus/upmember/<?=$value['member_id']?>'"> -->
                  <a href="javascript:void(0);" onclick="month_total('<?=$value['member_id']?>','<?=$value['stotal']?>','<?=$s_year?>','<?=$s_month?>')">
                <i class="fa fa-cogs"></i>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>

    <?php endif; ?>

  </table>

  </form>
<p style="height:200px;"></p>

</body>
</html>
<script>
function month_total(member_id,total,year,month){
  post_to_url('/bonus/upmember','', {'member_id':member_id,'total':total,'year':year,'month':month});
}
</script>