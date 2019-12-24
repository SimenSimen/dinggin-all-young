<!doctype html>
<html>
<head>

  <!–[if IE]>
  <script src=」http://html5shiv.googlecode.com/svn/trunk/html5.js」></script>
  <![endif]–>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=1024">

  <!-- seo -->
  <title>修改密碼 - <?=$web_config['title']?></title>
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
  <link type="text/css" rel="stylesheet" href="/css/updp.css">   
  <link type="text/css" rel="stylesheet" href="/css/pageguide/edit_integrate.css">   
  <link type="text/css" rel="stylesheet" href="/css/pageguide/pageguide.css">
  <link type="text/css" rel="stylesheet" href="/css/pageguide/main.css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="/css/global.css" media="screen">
  
  <!-- jQuery -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>

  <!-- js -->
  <script type="text/javascript" src="/js/pageguide.js"></script>

  <!--css-->
  <style type="text/css">
    /*input*/
    .password_text {
      padding:7px;
      border:1px solid #CAC2A9;
      border-radius:3px;
      margin:0px 3px;
      font-size:1em;
      
      -webkit-box-shadow: inset 3px 3px 5px  #eee;
        -moz-box-shadow: inset 3px 3px 5px #eee;
      box-shadow: inset 3px 3px 5px #eee;
    }
  </style>

</head>

<body scroll="yes" style="overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

<?
  //header
  $this->load->view('business/header', $data);
?>
  
<div id="container" style="min-height:400px;"><div class="w1024">
    

  <div id="con-L" style="width:100%; text-align:center;">
    <div class="step-info-01">   

    <?echo form_open('/user/update/updp', array('id'=>'form_updp'))?>
      <h2>修改密碼</h2>
      <br>
      <br>
      <table border="0" cellspacing="0" cellpadding="0" class="personal-info" style="width:50%; margin:0px auto;">

        <tr>
          <td class="dd1"><span class="star">*</span></td>
          <td class="dd2">原始密碼</td>
          <td class="dd3">
            <input class='password_text' type='password' name='old_password'>
            <a href="#" class="why">?</a><div class='prompt-box'>請輸入原始密碼</div>
            <br><span id='empty_info'></span>
          </td>
        </tr>

        <tr>
          <td class="dd1"><span class="star">*</span></td>
          <td class="dd2">新密碼</td>
          <td class="dd3">
            <input class='password_text' type='password' name='password'>
            <a href="#" class="why">?</a><div class='prompt-box'>請輸入新密碼</div>
            <br><span id='info'></span>
          </td>
        </tr>

        <tr>
          <td class="dd1"><span class="star">*</span></td>
          <td class="dd2">重複密碼</td>
          <td class="dd3">
            <input class='password_text' type='password' name='check_password'>
            <a href="#" class="why">?</a><div class='prompt-box'>請重新輸入新密碼</div>
            <br>
          </td>
        </tr>

      </table>
    
    <div>
      <br>
      <br>
      <input class='aa3' type='submit' name='form_submit' value='送出修改'>&nbsp;
    </div>

    </form>

  </div>
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

<!--bottom script-->
<script type="text/javascript" src="/js/updp.js"></script>

</body>
</html>
