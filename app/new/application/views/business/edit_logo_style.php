<!doctype html>
<html>
<head>

  <!–[if IE]>
  <script src='http://html5shiv.googlecode.com/svn/trunk/html5.js'></script>
  <![endif]–>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=1024">

  <!-- seo -->
  <title><?=$Edit_Cover_photo_set?> - <?=$web_config['title']?></title>
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
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="/css/global.css" media="screen">
  
  <!-- jQuery -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

  <!--colorpicker-->
  <script type='text/javascript' src="/js/colpick.js"></script>
  <link rel="stylesheet" type="text/css" href="/css/colpick.css">

  <!-- validate -->
  <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
  <script type="text/javascript" src="/js/messages_tw.js" charset="utf-8"></script>
  <script type="text/javascript" src="/js/edit_integrate_validation.js" charset="utf-8"></script>

  <!--預覽區內容縮放修正-->
  <style type="text/css">
    <?if($user_theme_id >= 2):?>
    #preview_integrate {
      zoom: 0.71;
      -moz-transform: scale(0.376);
      -moz-transform-origin: 0 0;
      -o-transform: scale(0.71);
      -o-transform-origin: 0 0;
      -webkit-transform: scale(0.38);
      -webkit-transform-origin: 0 0;
    }
    <?else:?>
    #preview_integrate {
       width:264px;
       height:444px;
    }
    <?endif?>
  </style>
  <script type="text/javascript">
    var browser = (/Firefox/i.test(navigator.userAgent)) ? 'Firefox' :
    (/Chrome/i.test(navigator.userAgent)) ? 'Chrome' :
    (/MSIE/i.test(navigator.userAgent)) ? 'IE' :
    '非 Firefox/Chrom/IE 瀏覽器';

    $(function(){
      $("img").each(function(i) {
        if ($(this).attr('class') == 'show_img') {
          $(this).removeAttr('width');
          $(this).removeAttr('height');

          //取得影像實際的長寬
          var imgW = $(this).width();
          var imgH = $(this).height();

          if(imgW > imgH)
          {
            $(this).width('300px');
          }
          else if(imgH > imgW)
          {
            $(this).height('240px');
          }
          else
          {
            $(this).width('300px');
            $(this).height('240px');
          }
        }
      });
      
      $("#del_image").click(function(){
        var i = $(".show_img").attr('src');
        $.ajax({
          url: '/business/del_logo',
          type: 'post',
          cache: false,
          async: false,
          data: { image_path: i.substr(1) },
          error: function (response) {
          },
          success: function (response) {
            alert(response);
            window.location.reload();
          }
        });
      });
    });

    
  </script>
  
</head>

<body scroll="yes" style="overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

<?
  //header
  $this->load->view('business/header', $data);
?>
<div id="container"><div class="w1024">

<div id="con-L">
  <div style="width:300px; height:240px; margin-bottom: 40px; padding: 10px; background: #333;">
    <?php if(!empty($iqr['logo_path'])):?>
      <input style="position: absolute; padding: 0 5px; margin-left: 260px;" type="button" id="del_image" value="<?=$Edit_delete?>">
      <img style="border-radius: 10px;" class="show_img" src="/<?=$iqr['logo_path']?>">
      <?php else: ?>
      <span id="sp" style="text-align: center; color: white; vertical-align: center; position: absolute; margin: 120px;"><?=$Edit_Please_upload_photos?></span>
    <?php endif ;?>
  </div>
  
  <?php if(empty($iqr['logo_path'])):?>
    <form id='f' name="form_submit" action="/business/logo" method="post" enctype="multipart/form-data">
      <input type="file" name='t' value="">
      <input style="padding: 0 10px;" type="submit" id='e' value="<?=$Edit_Send?>">
    </form>
  <?php endif; ?>
</div>

<?
  //preview_iframe
  $this->load->view('business/preview_iframe', $data);
?>

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
