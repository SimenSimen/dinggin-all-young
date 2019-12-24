<!doctype html>
<html>
<head>

  <!–[if IE]>
  <script src=」http://html5shiv.googlecode.com/svn/trunk/html5.js」></script>
  <![endif]–>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=1024">

  <!-- seo -->
  <title>申請推播 - <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>
  
  <!-- css -->
  <link rel="stylesheet" href="/css/dropdowns/style.css" type="text/css" media="screen, projection"/>
  <!--[if lte IE 7]>
        <link rel="stylesheet" type="text/css" href="/css/dropdowns/ie.css" media="screen" />
    <![endif]-->
  <link type="text/css" rel="stylesheet" href="/css/validation.css">
  <link type="text/css" rel="stylesheet" href="/css/pageguide/edit_integrate.css">   
  <link type="text/css" rel="stylesheet" href="/css/pageguide/pageguide.css">
  <link type="text/css" rel="stylesheet" href="/css/pageguide/main.css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="/css/global.css" media="screen">
  
  <!-- jQuery -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

  <style type="text/css">
    #push_apply_table { width: 95%; margin: 0px auto; }
    #push_apply_table tr td {
      font-family: 'Microsoft JhengHei';
      font-size: 16px;
      text-align: center;
      border: 1px solid #ddd;
      padding: 15px 7px 10px 7px;
      background: #ffffff;
      vertical-align: middle;
    }
  </style>

</head>

<body scroll="yes" style="overflow-x: hidden;overflow: -moz-scrollbars-vertical;">
<?
  $this->load->view('business/header', $data);
?>
  
<div id="container"><div class="w1024">
    
  <div id="con-L" style="width: 100%; height: 850px;">

    <div class="step-docUP-1" style="height: 800px;">
      
      <p style="line-height: 36px; text-align: center; font-size: 1.5em;">申請推播</p>
      <p style="line-height: 36px; text-align: center; font-size: 1.5em;">&nbsp;</p>
      
      <p style="line-height: 36px; text-align: center; font-size: 1.2em;">您好，如果您需要開通推播功能，請點選「前往開通」按鈕，系統推播開通費用: 3000元(測試)<br>快速開啟好友分享券<br>或點圖下載<br></p>
      <p style="line-height: 36px; text-align: center; font-size: 1.2em;">提醒您，推播開通後需要重新自動打包，您的APP安裝檔才會更新，請重新打包並重新安裝，方可使用推播。</p>
      <p style="line-height: 36px; text-align: center; font-size: 1.5em;">&nbsp;</p>
      <p style="text-align: center;"><input class='aa3' type='button' onclick='javascript: window.location.href="/push/apply_payment"' value='前往開通'></p>

    </div>  <!--step-docUP-1  結束--> 

  </div>
  
</form>

  <!--cannot delete~ it's useful -->
  <div class="clear"></div>  

  </div><!--the end of w1024(container) -->

  <div id="advertisement">  <!--go top-->
    <a href="#"><img style="border:0px;" src="/images/style_01/gotop.png"></a>
  </div>

</div><!--the end of container -->

<?
  //footer
  $this->load->view('business/footer', $data);
?>

</body>
</html>
