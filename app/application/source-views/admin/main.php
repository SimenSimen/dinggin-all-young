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
    ul li, h3
    {
        color: <?=$web_config['admin_font_color']?>;
    }
  </style>

</head>

<left>
<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<div style="margin-left:20px;">
  <h3 style="font-family:'微軟正黑體';">請從左欄選擇操作項目</h3>
  <ul>
    <li>帳戶管理：
      <ul>
        <li>會員資料列表</li>
        <li>新增會員</li>
        <li>設定層級</li>
        <li>直接登入</li>
      </ul>
    </li>
    <li>金鑰管理：
      <ul>
        <li>金鑰產生</li>
        <li>匯入金鑰</li>
        <li>金鑰刪修</li>
      </ul>
    </li>
    <li>SEO管理：設定網站 Meta Content</li>
    <li>常見問題：問題增刪修</li>
    <li>系統設定：網站相關設定資料</li>
    <li>網站風格資訊：
      <ul>
        <li>登入畫面：1920 x 1200</li>
        <li>網站後台上方背景：1600 x 270</li>
        <li>網站後台上方logo：186 x 77</li>
      </ul>
    </li>
  </ul>
</div>

<p style="height:200px;"></p>

</body>
</html>
