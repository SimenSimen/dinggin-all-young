<!doctype html>
<html>
<head>

  <!–[if IE]>
  <script src=」https://html5shiv.googlecode.com/svn/trunk/html5.js」></script>
  <![endif]–>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=1024">

  <!-- seo -->
  <title>上架管理 - <?=$web_config['title']?></title>
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
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

  <!-- validate -->
  <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
  <script type="text/javascript" src="/js/messages_tw.js" charset="utf-8"></script>
  <script type="text/javascript" src="/js/edit_integrate_validation.js" charset="utf-8"></script>

  <style type="text/css">
    legend { text-align: right; }
    input[type=file]{height: 100%;width: 100%;}
    table.personal-info td.dd3{width: 60%;}
  </style>

</head>

<body scroll="yes" style="overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

<?
  //header
  $this->load->view('business/header', $data);
?>
  
<div id="container"><div class="w1024">
    
  <form action="/appui/release_setting" method="post">    
    
  <div id="con-L" style="width: 100%; height: 1050px;">

    <div class="step-docUP-1" style="height: 1020px;">
      
      <p style="line-height: 36px; text-align: center; font-size: 1.5em;">APP 上架管理</p>
      <p>&nbsp;</p>
      <p style="line-height: 36px; text-align: center;font-size: 1.1em;">由此設定上架成功後的下載網址，您的 APP QRcode 可切換連結至對應Store下載</p>
      <p>&nbsp;</p>
      

      <table border="0" cellspacing="0" cellpadding="0" class="personal-info" style="width: 70%;font-size: 1.1em;margin: 0px auto;">

        <tr>
          <td class="dd1"><span class="star">*</span></td>
          <td class="dd2">Google Play</td>
          <td class="dd3">
            <input type='text' placeholder='Google Play - APP 網址，保留空白將使用原始下載頁面' name='apk_release' value='<?=$iqr['apk_release']?>' style='width: 100%;'>
          </td>
        </tr>
             
        <tr>
          <td class="dd1"><span class="star">*</span></td>
          <td class="dd2">Apple Store</td>
          <td class="dd3">
            <input type='text' placeholder='Apple Store - APP 網址，保留空白將使用原始下載頁面' name='ipa_release' value='<?=$iqr['ipa_release']?>' style='width: 100%;'>
          </td>
        </tr>
             
        <tr>
          <td align="center" colspan="4">
            <input type='hidden' id='success' value='<?=$success?>'>
            <input type='hidden' name='iqr_id' value='<?=$iqr['iqr_id']?>'>
            <input style="font-size: 1.2em; margin: 20px 5px;padding: 9px 29px 9px 29px;" class="aa3" type='submit' name='form_submit' value='儲存'>
            <span style='color: #ff6600' id='success_prompt'></span>
          </td>
        </tr>

      </table>

    </div>

  </div>

  </form>
  
  </div>

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

<script type="text/javascript">
  $(function()
  {
    if($('#success').val())
    {
      $('#success_prompt').html('編輯成功');
      $('#success_prompt').delay(2000).fadeOut();
      $('#success').val('');
    }
  });
</script>

</body>
</html>
