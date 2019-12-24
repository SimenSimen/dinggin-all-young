<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>行動名片系統</title>

  <!-- css -->
  <link type="text/css" rel="stylesheet" href="/css/admin.css">
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">  

  <!-- jQuery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">

  <!-- bootstrap -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="/css/member_setting.css">

</head>

<center>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center">
  <form id="member_setting_form" name="member_setting_form" method='post' action='/admin/member_setting/<?=$member['account']?>/1' enctype="multipart/form-data">
  <table id='button_table'>
    <tr style="text-align:right;">
      <td style="width:95%; color:#5A0087;">警告，請勿重複開啟不同會員視窗，以免資料錯置導致遺失</td>
      <td style="width:2%;"><button class="btn btn-default" type="button" onclick="top.frames['content-frame'].location='/admin/member_management'">返回上層</button></td>
      <td style="width:2%;"><button class="btn btn-success" type="submit" id='member_setting_submit'>儲存編輯</button></td>
    </tr>
  </table>

  <!--會員資料列表-->
    <table id='member_list' class='table table-hover table-bordered table-condensed' cellpadding="0" cellspacing="0" style="width:80%;">
      <tr>
        <td class="table-cell-right">帳號</td>
        <td><?=$member['account']?></td>
      </tr>
      <tr>
        <td class="table-cell-right">期限天數</td>
        <td>餘 <?=round(($member['deadline'] - time()) / 86400)?> 天 + <input type="number" name="add_date"></td>
      </tr>
      <tr>
      	<td class="table-cell-right">推播功能</td>
      	<td>
      		<select name="push">
      			<option value="0" <?php if($member['push'] == 0):?>selected<?php endif; ?>>關閉</option>
      			<option value="1" <?php if($member['push'] == 1):?>selected<?php endif; ?>>開啟</option>
  			</select>
		</td>
      </tr>
      <tr>
        <td class="table-cell-right">推播系統</td>
        <td>
        <label><input type="radio" value="1" NAME="sys_push" onclick="changsys_push(1)" <?=$selected1?> >百度</label>
        <label><input type="radio" value="2" NAME="sys_push" onclick="changsys_push(2)" <?=$selected2?>>Google</label></td>
      </tr>
      <tr>
        <td class="table-cell-right">package name</td>
        <td><div id="packnameid"><?=$packname?></div></td>
      </tr>
      <tr>
        <td class="table-cell-right">Android Client Key</td>
        <td><input type="text" name="apk_client_key" value="<?=$member['client_key']?>" placeholder="Client Key"></td>
      </tr>
      <tr>
        <td class="table-cell-right">Android Server key</td>
        <td><input type="text" name="apk_server_key" value="<?=$member['gcm_key']?>" placeholder="Server Key"></td>
      </tr>
      <tr>
        <td class="table-cell-right">百度 api Key</td>
        <td><input type="text" name="apikey" value="<?=$member['apikey']?>" placeholder="api Key"></td>
      </tr>
      <tr>
        <td class="table-cell-right">百度 secret key</td>
        <td><input type="text" name="secretkey" value="<?=$member['secretkey']?>" placeholder="secret Key"></td>
      </tr>
    <?php if(!empty($ios_deadline)): ?>
      <tr>
        <td class="table-cell-right">iOS 憑證到期日</td>
        <td><?=$ios_deadline?></td>
      </tr>
    <?php endif; ?>
      <tr>
        <td class="table-cell-right">iOS Pem (*.pem)</td>
        <td><input type="file" name="ios_pem" value=""></td>
      </tr>
    <?php if(!empty($pem_name)): ?>
      <tr style="background: #ffe4b8;">
        <td class="table-cell-right">當前 Pem 檔案</td>
        <td><?=$pem_name?></td>
        <input type="hidden" name="pem_name" value="<?=$pem_name?>">
      </tr>
    <?php endif ;?>
      <tr>
        <td class="table-cell-right">iOS UniversalDistribution (*.mobileprovision)</td>
        <td><input type="file" name="ios_mobileprovision" value=""></td>
      </tr>
    <?php if(!empty($mobileprovision_name)): ?>
      <tr style="background: #ffe4b8;">
        <td class="table-cell-right">當前 UniversalDistribution 檔案</td>
        <td><?=$mobileprovision_name?></td>
        <input type="hidden" name="mobileprovision_name" value="<?=$mobileprovision_name?>">
      </tr>
    <?php endif ;?>
      <tr>
        <td class="table-cell-right">iOS app id <br>
          <span class="font16">(com 為企業發佈使用, store 為上架發佈使用)</span>
        </td>
        <td>
          <label><input type="radio" name="app_id" value="default" <?php if($member['app_id'] == 'default'): ?>checked <?php endif; ?>>&nbsp;com.appplus.KuoTing.<?=$member['account']?></label>
          <label><input type="radio" name="app_id" value="store" <?php if($member['app_id'] == 'store'): ?>checked <?php endif; ?>>&nbsp;store.appplus.KuoTing.<?=$member['account']?></label>
        </td>
      </tr>
    <?php if($zipBtn): ?>
      </tr>
        <td class="table-cell-right">iOS (.zip)</td>
        <td>
          <a class="cp" href="<?=$member['img_url']?>app/<?=$member['account']?>.zip"><i class="fa fa-files-o"> 點我下載</i></a>
        </td>
      <tr>
    <?php endif; ?>
    </table>
    <input type="hidden" id="suc" value="<?=$suc?>">
  </form>
<p style="height:200px;"></p>

</body>
</html>

<script>
function changsys_push(sys_push)
{
    $.ajax(
    {
      url: '/s/ajaxallpackagename/',
      data: { sys_push: sys_push,member_id:<?=$member['member_id']?>},
      type: 'post',
      cache: false,
      async: false,
    dataType: 'json', // Choosing a JSON datatype
      success: function (data)
      {
    $('#packnameid').html(data.packagename);
      }
    });
}
</script>