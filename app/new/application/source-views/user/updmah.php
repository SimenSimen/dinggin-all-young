<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title>帳戶管理 - <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <!-- script -->
  <script>
    function over(imgObj,picname) { imgObj.src=picname; }
    function out(imgObj,picname) { imgObj.src=picname; }
  </script>

  <!-- css -->
  <link type="text/css" rel="stylesheet" href="/css/front_homepage.css">
  <style type="text/css">
    #updmah_table
    {
      border-collapse: collapse;
    }
    #updmah_table tr td
    {
      font-family: '微軟正黑體';
      font-size: 16px;
      text-align: center;
      vertical-align: middle;
    }
    .checkbox_td
    {
      zoom: 150%;
      text-align: center;
      vertical-align: middle;
    }
  </style>

  <!-- bootstrap -->
  <link href="/css/bootstrap.css" rel="stylesheet">
  <script type='text/javascript' src="/js/bootstrap.min.js"></script>

  <!-- jQuery -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>

  <script type="text/javascript">
    $(function()//onload
    {
      //前往行動名片網址
      $('#open_iqr_window').click(function(){
        window.open('<?=$base_url?>business/iqrc/<?=$id?>', '手機快速掃描<?=$l_name.$f_name?>的行動名片', config='height=620,width=420,left=470');//left700
      });

      
    });
  </script>

</head>

<center>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center">

<table width="1048" border="0" cellspacing="0" cellpadding="0">

  <?=$common_bar?>

  <!-- 會員設定區 -->
  <tr  width="1048" height="420">
    <td width="1048" height="420" align="center" valign="top">
      <table class='table' id='updmah_table'>
        <tr><td rowspan="<?=$rowspan?>" style="width:10%;"></td><td align="center" colspan="5"><h4>子帳戶列表 (請勾選帳戶並點選您要設定的層級)</h4></td><td rowspan="<?=$rowspan?>" style="width:10%;"></td></tr>
        
        <tr>
          <td>層級</td>
          <td>級別</td>
          <td>名片姓名</td>
          <td>帳號</td>
          <td>電子信箱</td>
        </tr>

        <!--for-->
        <?echo form_open('/user/update/updmah', array('id'=>'form_updmah'))?>
          <?php if (!empty($member)): ?>

            <?php foreach ($member as $key => $value): ?>
              <tr>
                <td class='checkbox_td'><input type='checkbox' class='mycheckbox' name='update_webmin[]' value='<?=$value['member_id']?>'></td>
                <td><?=intval($value['auth'])?></td>
                <td><?=$user_name[$key]?></td>
                <td><?=$value['account']?></td>
                <td><?=$value['email']?></td>
              </tr>
            <?php endforeach; ?>

          <?php endif; ?>

          <tr>
            <td align="center" colspan="5">

              <select name="auth_level" id="auth_level" class="text ui-widget-content ui-corner-all" style="position: relative;top: 6px;">
                <?php foreach ($auth_level as $key => $value): ?>
                  <option value='0<?=$value['value']?>'><?=$value['name']?></option>
                <?php endforeach; ?>
              </select>

              <input class='myButton' type='submit' name='form_submit' value='送出修改'>
              &nbsp;
              <input class='myButton' type='button' name='cancle' value='取消' onclick='window.location.href="/user/setting"'>
            </td>
          </tr>
        </form>

      </table>

    </td>
  </tr>
  <!-- 會員設定區結束 -->

  <?=$footer?>

</table>

<div id="advertisement">
  <a href="#"><img src="/images/front/gotop.png"></a>
</div>


</body>
</html>
