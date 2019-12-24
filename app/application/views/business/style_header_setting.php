<!doctype html>
<html>
<head>

  <!–[if IE]>
  <script src='https://html5shiv.googlecode.com/svn/trunk/html5.js'></script>
  <![endif]–>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=1024">

  <!-- seo -->
  <title><?=$_ClassTitleName?> <?=$web_config['title']?></title>
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
  <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">
  <script type="text/javascript" src="/js/ajax_upload/ajaxfileupload.js"></script>

  <!-- js -->
  <script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script>
  <!-- <script type="text/javascript" src="/js/pageguide.js"></script> -->

  <!-- validate -->
  <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
  <script type="text/javascript" src="/js/messages_tw.js" charset="utf-8"></script>
  <script type="text/javascript" src="/js/edit_integrate_validation.js" charset="utf-8"></script>

  <style type="text/css">

    .ui-dialog-titlebar-close
    {
      background-image: url(/images/close-icon.png);
      background-size: cover;
    }

    /* 編輯區塊分類 fieldset */
    #app-fieldset {
      border: 1px groove rgb(0, 0, 0, 1) !important;
      padding: 0 1.4em 1.4em 1.4em !important;
      margin: 0 0 1.5em 0 !important;
      -webkit-box-shadow: 0px 0px 0px 0px #ffffff;
      box-shadow: 0px 0px 0px 0px #ffffff;
    }

    legend { text-align: right; }

  </style>

  <script type="text/javascript">
    var browser = (/Firefox/i.test(navigator.userAgent)) ? 'Firefox' :
    (/Chrome/i.test(navigator.userAgent)) ? 'Chrome' :
    (/MSIE/i.test(navigator.userAgent)) ? 'IE' :
    '<?=$NotFirefoxChromIE?>';

    $(function(){
      <?if($iqr['theme_id'] >= 2):?>
        if(browser == 'IE')
        {
          $('#preview_integrate').css('zoom', '0.3763');
          $('#preview_integrate').css('width', '696px');
          $('#preview_integrate').css('height', '1227px');
        }
        else if(browser == 'Firefox')
        {
          $('#preview_integrate').css('width', '696px');
          $('#preview_integrate').css('height', '1227px');
        }
        else
        {
          $('#preview_integrate').css('width', '972px');
          $('#preview_integrate').css('height', '1708px');
        }
      <?php else: ?>
        $('#preview_integrate').css('width', '262px');
        $('#preview_integrate').css('height', '460px');
      <?php endif; ?>
      
      $('#chk_to_cpy_data').attr('disabled', 'disabled');
      $('.mcard_tr').hide();
    });
  </script>

</head>

<body scroll="yes" style="overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

<?
  //header
  $this->load->view('business/header', $data);
?>
  
<div id="container"><div class="w1024">
    
  <div class="bar">
    <p>
      <span class="star">*</span><?=$RequiredField?>&nbsp;&nbsp;&nbsp;
      <span class="dd3"></span><?=$MoveMouse?>&nbsp;<a href="#" class="why" tabindex = "-1">?</a><?=$ShowDataEx?>
    </p>
  </div>
        
    
  <form action="/business/edit_header_str" method="post">
    
  <div id="con-L">
    <div>   
      <table border="0" cellspacing="0" cellpadding="0" class="personal-info">
        <tr>
          <td class="step-info-01">
            <fieldset id='app-fieldset' style='border: 1px groove #ffffff;'>
            <legend align="right">&nbsp;<?=$ClassTitleName?>&nbsp;<input style="font-size: 17px; padding: 5px 10px 5px 10px; margin: 0px;" class="aa3" type='submit' name='form_submit' value='<?=$SaveEdit?>'>&nbsp;</legend>

              <p>&nbsp;</p>
              <p>
                <?php $this -> load -> view('cells/style_header'); ?>
              </p>
            </fieldset>
          </td>
        </tr>
      </table>
    </div>
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

  <style type="text/css">
    form * { font-family: '微軟正黑體'; }
    form input { font-family: '微軟正黑體'; }
    .ui-button-text { font-family: '微軟正黑體'; }
    .ui-dialog-title { height: 18px; }
    legend {   font-size: 1.1em;}
  </style>

</body>
</html>
