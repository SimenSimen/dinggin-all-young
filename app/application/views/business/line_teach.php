<!doctype html>
<html>
<head>

  <!–[if IE]>
  <script src='https://html5shiv.googlecode.com/svn/trunk/html5.js'></script>
  <![endif]–>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=1024">

  <!-- seo -->
  <title><?=$_PersonalInformation?> <?=$web_config['title']?></title>
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
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="/css/global.css" media="screen">
  
  <!-- jQuery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">

  <style type="text/css">
    #line_table tr td
    { 
      padding: 20px;
      border-top:#E7D293 solid 1px;
      border-right:0px;
      border-left:0px;

      font-size: 1.2em;
      line-height: 24px;
    }
  </style>
  
</head>

<?
  //Header Bar
  $this->load->view('business/header', $data);
?>

<div id="container"><div class="w1024">

<center>
  <!-- Line 加好友網址教學內容 -->
  <table id='line_table' style="width:70%;">
    <tr><td align="center" colspan="3" style="height:50px;"><h3><?=$LineTeaching?></h3></td></tr>
    <tr><td align="center" width="20%"><?=$Step_1?></td><td align="left"><?=$OpenLineApp?></td><td align="center"width="32%"><img height="350" src='/images/line_teach/1.jpg'></td></tr>
    <tr><td align="center"><?=$Step_2?></td><td align="left"><?=$ChooseAther?><br><?=$ChooseSet_2?></td><td align="center"><img height="350" src='/images/line_teach/2.jpg'></td></tr>
    <tr><td align="center"><?=$Step_3?></td><td align="left"><?=$SelectSelfData?></td><td align="center"><img height="350" src='/images/line_teach/3.jpg'></td></tr>
    <tr><td align="center"><?=$Step_4?></td><td align="left"><?=$ScrollBottom?></td><td align="center"><img height="350" src='/images/line_teach/4.jpg'></td></tr>
    <tr><td align="center"><?=$Step_5?></td><td align="left"><?=$SelectShowBarcode?></td><td align="center"><img height="350" src='/images/line_teach/5.jpg'></td></tr>
    <tr><td align="center"><?=$Step_6?></td>
    <td align="left">
      <p><?=$UseEmailSend?></p>
      <br>
      <p><?=$LineUiIos?></p>
    </td>
    <td align="center"><img height="350" src='/images/line_teach/6.jpg'><br><img height="350" src='/images/line_teach/7.jpg'></td></tr>
    <tr><td align="center"><?=$Step_7?></td><td align="left"><?=$LineFieldFinish?></td><td align="center"><img height="350" src='/images/line_teach/8.jpg'></td></tr>
    <tr><td align="center" colspan="3"><input class='aa3' type='button' onclick="javascript:window.close();" value='<?=$CloseWondows?>'></td></tr>
  </table>
  <!-- Line 加好友網址教學內容結束 -->
</center>

  <!--cannot delete~ it's useful -->
  <div class="clear"></div>  

  </div><!--the end of w1024(container) -->

  <div id="advertisement">  <!--go top-->
    <a href="#"><img src="/images/style_01/gotop.png"></a>
  </div>
  
</div><!--the end of container -->

<?
  //footer
  $this->load->view('business/footer', $data);
?>

</body>
</html>
