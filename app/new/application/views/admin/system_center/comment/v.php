<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- seo -->
    <title><?=$reviews['d_title']?></title>
    <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
    <meta name="keywords"     content=''>
    <meta name="description"  content=''>
    <meta name="author"       content=''>
    <meta name="copyright"    content=''>

    <!-- css -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <link type="text/css" rel="stylesheet" href="/css/uform_add.css">

    <!--icon-->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

    <!-- jQuery -->
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script><!--jQuery library-->
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/jquery.validate.min.js"></script>

    <!-- bootstrap -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="/css/admin/system_center/form.css">
</head>

    <body>
        <button type="button" id="cancel" class="btn btn-default">返回列表</button>
        <form method="post" enctype="multipart/form-data" >

        <table style="width: 80%;">
            <tr>
                <td class="title_td">名稱</td>
                <td><?=$reviews['d_title']?></td>
            </tr>
            <tr>
                <td class="title_td">內容</td>
                <td><?=$reviews['d_content']?></td>
            </tr>
            <tr>
                <td class="title_td">圖片</td>
                <td>
                    <input type="file"   name="d_img" id="d_img"/>
                    <? if(!empty($reviews['d_img'])):?>
                      <a href="/<?php echo !empty($reviews['d_img'])?$reviews['d_img']:'';?>" target="_BALNK">
                        <img src="/<?php echo !empty($reviews['d_img'])?$reviews['d_img']:'';?>" width="10%" >
                      </a>
                      <input type="button" value="刪除圖片" id="DelPic">
                      <input type="hidden" name="<?=$reviews['d_img'].'_ImgHidden'?>" value="<?php echo !empty($reviews['d_img'])?$dbdata['d_img']:'';?>"/>
                    <? endif;?>  
                </td>
            </tr>
            
        </table>    
        <input type="submit" value="確定">
    </body>
</html>

<script type="text/javascript">
    (function() {
        $('#cancel').click(function() {
            window.location.href = '<?=$back?>';
        });
    })(jQuery);
$('#DelPic').click(function(){
  if(confirm('確定刪除此圖片?')){
    $.ajax({
      url:'/comment/DelPic',
      type:'POST',
      data: 'Did='+<? echo $_GET['e']?>,
      dataType: 'text',
      success: function(response){
        if(response=='OK'){
          alert('刪除成功');
          location.reload()
        }
      }
    });
  }
});
</script>

