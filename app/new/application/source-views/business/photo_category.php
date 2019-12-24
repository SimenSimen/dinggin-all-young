<!doctype html>
<html>
<head>

  <!–[if IE]>
  <script src='http://html5shiv.googlecode.com/svn/trunk/html5.js'></script>
  <![endif]–>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=1024">

  <!-- seo -->
  <title><?=$_AddAlbum?> <?=$web_config['title']?></title>
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
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
  <link type="text/css" rel="stylesheet" href="/css/pageguide/edit_integrate.css">   
  <link type="text/css" rel="stylesheet" href="/css/pageguide/pageguide.css">
  <link type="text/css" rel="stylesheet" href="/css/pageguide/main.css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="/css/photo_management.css">
  <link type="text/css" rel="stylesheet" href="/css/global.css" media="screen">
  
  <!-- jQuery -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

  <!-- js -->
  <script type="text/javascript" src="/js/pageguide.js"></script>
  <script type="text/javascript" src="/js/photo_management.js" charset="utf-8"></script>

  <!--預覽區內容縮放修正-->
  <style type="text/css">
    <?if($iqr['theme_id'] >= 2):?>
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

      $("#gallery-sortable").sortable();
    });
  </script>

</head>

<body scroll="yes" style="overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

<?
  //header
  $this->load->view('business/header', $data);
?>
  
<div id="container"><div class="w1024">
    
<!--左-->
  <div id="con-L">
   
   <div class="step-imgUP-1">
		<h2><?=$AlbumAdd?></h2>
		<input class="gallery_name" style="width: 176px;" type='text' placeholder="<?=$AlbumName?>" name="d_name" id="d_name_0" value="" maxlength="20">
    <input type='button' class="aa2" name="add_edit_data" d_id="0" value='+ <?=$Add?>'></span>
    <input class="aa6" style="padding: 6px 12px; font-family: '微軟正黑體'; font-size: 13.3333px; margin: 0 auto;" type="button" name="gallery_sort" value="<?=$SortSave?>">
    <span style="padding: 6px 12px; font-family: '微軟正黑體'; font-size: 13.3333px; margin: 0 auto;" id="_text"></span>
      <div class="imgUPss">
     
        <!--原始顯示區-->
        <div class='switch_myphoto'>
          <?php if(!empty($list_data)): ?>
            <ul id="gallery-sortable">
              <?php foreach ($list_data as $key => $value): ?>
                <li style="padding-bottom: 10px;">
                  <input class="gallery_name" type="text" name="d_name" placeholder="<?=$AlbumName?>" id="d_name_<?php echo $key?>" value="<?php echo $value["d_name"];?>" maxlength="20">
                  <input class="aa2" type='button' name="add_edit_data" d_id="<?php echo $key;?>" value='<?=$Modify?>'>
                  <input class="aa2" type='button' name="del_edit_data" d_id="<?php echo $key;?>" value='<?=$Delete?>'>
                  <a class="aa6" style="padding: 6px 12px; font-family: '微軟正黑體'; font-size: 13.3333px; margin: 0 auto;" href="javascript:void(0);"><?=$Sort?></a>
                  <input type="hidden" name="sort_id[]" value="<?=$key?>">
                </li>
              <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>
        <!--原始顯示區結束-->
	   </div>
                                                  
   </div>  <!--step-imgUP-2 結束--> 
   
 </div> <!-- 左   結束 --> 
<style>
  .gallery_name {
    width: 300px;
    padding: 7px;
    border: 1px solid #CAC2A9;
    border-radius: 3px;
    margin: 0px 3px;
    font-size: 1em;
    font-family: 'Microsoft Jhenghei';
    -webkit-box-shadow: inset 3px 3px 5px #eee;
    -moz-box-shadow: inset 3px 3px 5px #eee;
    box-shadow: inset 3px 3px 5px #eee;
  }

</style>  


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
<?php if(!empty($error)):?><script>alert('<?php echo $error;?>');</script><?php endif;?>
<script>
  function post_to_url(path, targets, params) {
      var form = document.createElement("form");
      form.setAttribute("method", "post");
      if (targets != "") {
          form.setAttribute("target", targets);
      }
      form.setAttribute("action", path);
      form.setAttribute("name", "newForm");
      form.setAttribute("id", "newForm");
      //加入時間參數以免讀到舊資料
      var hiddenField = document.createElement("input");
      hiddenField.setAttribute("type", "hidden");
      hiddenField.setAttribute("name", "parm");
      hiddenField.setAttribute("value", new Date().getTime());
      form.appendChild(hiddenField);
      for (var key in params) {
          var hiddenField = document.createElement("input");
          hiddenField.setAttribute("type", "hidden");
          hiddenField.setAttribute("name", key);
          hiddenField.setAttribute("value", params[key]);
          form.appendChild(hiddenField);
      }
      document.body.appendChild(form);
      form.submit();
      document.body.removeChild(document.getElementById("newForm"));
  }

  $(function() {
      $("input[name='add_edit_data']").click(function() {
          var d_id = $(this).attr("d_id");
          var path = "add_data";
          if (d_id > 0) {
              path = "edit_data";
          }
          post_to_url("/photo_category/" + path, "", {
              "d_name": $("#d_name_" + d_id).val(),
              "d_id": d_id
          });
      });

      $("input[name='del_edit_data']").click(function() {
          post_to_url("/photo_category/del_data", "", {
              "d_id": $(this).attr("d_id")
          });
      });

      $("input[name='gallery_sort']").click(function() {
        var data = $('input[name="sort_id[]"]').serializeArray();
        $.post("/photo_category/sort_data", { sort_data: data }, function (response) {
          if(response === 'refresh')
          {
            $("#_text").fadeIn();
            $("#_text").text("儲存成功").css({"background": "green", "color" : "white"}).fadeOut(1500);
          }
        });
      });
  });
</script>