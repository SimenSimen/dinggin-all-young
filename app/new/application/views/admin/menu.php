<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<!-- bootstrap -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>

	<!-- css -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
	<link type="text/css" rel="stylesheet" href="/css/admin.css">

  <!-- accordion -->
  <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
  <script src="/css/accordion/accordion.js"></script>
  <link type="text/css" rel="stylesheet" href="/css/accordion/accordion.css">
	
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
  <select style="float: right;" id="setlang">
        <option value="TW" <?=($this->setlang=='TW')?'selected':'';?>>中文繁體</option>
        <option value="ENG" <?=($this->setlang=='ENG')?'selected':'';?>>英文</option>
        <option value="JAP" <?=($this->setlang=='JAP')?'selected':'';?>>日文</option>
    </select>
  <!--推播管理-->
  <p><button class="btn btn-primary" type="button" onclick="top.frames['content-frame'].location='/push/index'">推播訊息</button></p>
  

  <?php if($_SESSION['AT']['account_name'] == 'super' || $_SESSION['AT']['account_name'] == 'admin' || $_SESSION['AT']['account_name'] == 'goldenbiotech'): ?>
    <!--會員資料、新增會員、期限管理-->
    <p><button class="btn btn-success" type="button" onclick="top.frames['content-frame'].location='/admin/member_management'">App憑證管理</button></p>
    <!-- 信件通知設定 -->
    <p><button class="btn btn-warning" style="background: indianred;" type="button" onclick="top.frames['content-frame'].location='/admin/mail_config'">通知設定</button></p>
      
    <!--系統設定檔、控管總會員數-->
    <p><button class="btn btn-warning" type="button" onclick="top.frames['content-frame'].location='/admin/system_config'">系統設定</button></p>
  <?php endif; ?>
  <div id="accordion" class="accordion">
    <?php foreach ($menu_title as $key => $value):?>
      <p class="link">
        <button class="btn btn-success" type="button"><?=$key?>
          <i class="fa fa-angle-down" aria-hidden="true"></i>
        </button>
      </p>
      <div class="submenu">
        <?php foreach ($value as $jkey => $jvalue): ?>
          <?php if(is_numeric($jkey)): ?>
            <!-- <div >
              <a onclick="top.frames['content-frame'].location='<?=$jvalue['d_link'].'?menu_title='.$key.'-'.$jvalue['d_name'].''?>'">
                <?=$jvalue['d_name']?>
              </a>
            </div> -->
            <div ><?php $d_link=(preg_match("/\?/",$jvalue['d_link']))?"&":"?";?>
              <a onclick="top.frames['content-frame'].location='<?=$jvalue['d_link'].$d_link.'menu_title='.$key.'-'.$jvalue['d_name'].''?>'">
                <?=$jvalue['d_name']?>
              </a>
            </div>
          <?php endif;?>
        <?php endforeach; ?>
      </div>
    <?php endforeach;?>
  </div>

  <p><button class="btn btn-warning" type="button" onclick="window.open('/translation')">翻譯I</button></p>
  <p><button class="btn btn-warning" type="button" onclick="window.open('/translation_v2')">翻譯II</button></p>
  <!--登出-->
	<p><button class="btn btn-default" type="button" onclick="top.window.location.href='/index/logout'">登出</button></p>

</div>

</body>

</html>

<script>
$('#setlang').change(function(){
    $.ajax({
        type: "post",
        url: '/gold/setlang',
        cache: false,
        data: {
            lang: $('#setlang').val(),
            type:'admin'
        },
        dataType: "text",
        success: function(response) {
            top.frames['content-frame'].location.reload();
        }
    });   
});
</script>
