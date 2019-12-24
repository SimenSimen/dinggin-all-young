<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<!-- bootstrap -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>

	<!-- css -->
	<link type="text/css" rel="stylesheet" href="/css/admin.css">
	<style type="text/css">
		.btn
		{
			width: 170px;
			font-size: 18px;
		}
		#menu_title
		{
			margin-top:0px;
			font-family: '微軟正黑體';
      color: <?=$web_config['admin_font_color']?>;
      cursor: pointer;
		}
	</style>

  <!--js-->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script type="text/javascript">
  $(function()
  {
    $('#domain_id').on('change', function()
    {
      window.location.href='/admin/domain_switch/'+$( "#domain_id option:selected" ).val();
    });
  });
  </script>

</head>
<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center">

<div id='menu-link-table'>

	<h3 id='menu_title' onclick="top.frames['content-frame'].location='/admin/main'">超級管理者後台</h3>

  <p style="word-break:break-all; color: #888888;">
    <?php if (!empty($domain)): ?>
      <select name="domain_id" id="domain_id" class="form-control" style="display: inline; width: 169px;">
        <?php foreach ($domain as $key => $value): ?>
          <option value='<?=$value['domain_id']?>' <?=$domain_selected[$value['domain_id']]?>><?=str_replace("有限公司", "", $value['company']).' ( '.$value['domain'].' )'?></option>
        <?php endforeach; ?>
      </select>
    <?php endif; ?>
  </p>
  
  <!--網域切換-->
  <p><button class="btn btn-success" type="button" onclick="top.frames['content-frame'].location='/admin/domain_management'">網域管理</button></p>

	<!--會員資料、新增會員、期限管理-->
	<p><button class="btn btn-success" type="button" onclick="top.frames['content-frame'].location='/admin/member_management'">帳戶管理</button></p>
	
  <!--金鑰管理-->
  <p><button class="btn btn-primary" type="button" onclick="top.frames['content-frame'].location='/admin/key_management'">金鑰管理</button></p>

  <!--SEO管理-->
  <!-- <p><button class="btn btn-success" type="button" onclick="#">SEO管理(C.S.)</button></p> -->

  <!--常見問題管理-->
  <p><button class="btn btn-primary" type="button" onclick="top.frames['content-frame'].location='/admin/qaa_management'">常見問題</button></p>
  
  <!-- Qrcode 設定；推播設定 -->
  <p><button class="btn btn-warning" style="background: indianred;" type="button" onclick="top.frames['content-frame'].location='/admin/qrcode_direct'">上架設定</button></p>
	<!-- 加值系統設定 -->
  <p><button class="btn btn-warning" style="background: lightseagreen;border-color: lightseagreen;" type="button" onclick="top.frames['content-frame'].location='/admin/addon'">Allpay 金流設定</button></p>
  <p><button class="btn btn-warning" style="background: lightseagreen;border-color: lightseagreen;" type="button" onclick="top.frames['content-frame'].location='/admin/addon_gomypay'">萬事達刷卡設定</button></p>
  
  <!-- 信件通知設定 -->
  <p><button class="btn btn-warning" style="background: indianred;" type="button" onclick="top.frames['content-frame'].location='/admin/mail_config'">通知設定</button></p>
  
  <!--系統設定檔、控管總會員數-->
	<p><button class="btn btn-warning" type="button" onclick="top.frames['content-frame'].location='/admin/system_config'">系統設定</button></p>
	
  <!--登出-->
	<p><button class="btn btn-default" type="button" onclick="top.window.location.href='/index/logout'">登出</button></p>

</div>

</body>

</html>