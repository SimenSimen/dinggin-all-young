<!doctype html>
<html>
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=1024">

  <!-- seo -->
  <title>推播功能 - <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="" />
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
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="/css/global.css" media="screen">
  
  <link rel="stylesheet" href="/css/pagination.css">
  <!-- jQuery -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">
  <style>
    #push_table { width: 100%; }
    #push_table tr td { text-align: center; border: 1px solid #ddd; padding: 8px 10px 8px 10px; background: #ffffff; vertical-align: middle; font-size: 1.1em; font-family: '微軟正黑體'; }
    .aa5 { cursor: pointer; }
  </style>
  <script>
    $(function () {
      $("#container").css('min-height', $(window).height()*0.65);
    });
  </script>
</head>

<body scroll="yes" style="overflow-x: hidden;overflow: -moz-scrollbars-vertical; background:none;">
<div id="container">
  <div class="w1024" style="width:90%;">
  <div style="width: 85px; border-radius: 5px; border: 2px solid #B2A171; padding: 5px; float:left;"><p style="font-size:20px;">推播列表</p></div>
  <?php if($add_push): ?>
    <a href='/push/add' target='_blank' class="aa5" style="float:right; font-size:20px; margin-left: 0px; padding: 10px;">新增推播訊息 <i class="fa fa-commenting-o"></i></a>
  <?php endif; ?>
  <br>
  
  <!-- <table style="width: 100%;"> -->
    <!-- <tr> -->
      <!-- content -->
      <!-- <td id='content' style="white-space: nowrap; overflow:hidden; width: 100%;" valign="top"> -->
        <!-- <div style="height: 500px;"> -->

          <!--內容顯示區-->
          <div class='content_list' id='content_list'>
            <table id="push_table">
              <tr>
                <td style="width:12%;">建立時間</td>
                <td style="width:7%;">圖片</td>
                <td style="width:15%;">標題</td>
                <td style="width:15%;">訊息</td>
                <td style="width:10%;">狀態</td>
                <td style="width:10%;">操作</td>
              </tr>
              <?php if(!empty($page_data)): ?>
                <?php foreach ($page_data as $key => $value): ?>
                <tr>
                  <td><?=$value['create_time']?></td>
                  <td><?php if(!empty($value['image'])):?><img src="<?=$value['image']?>" width="70" height="70"><?php endif; ?></td>
                  <td id="del_<?=$value['p_id']?>"><?=$value['title']?></td>
                  <td><?=$value['message']?></td>
                  <td><?=$value['status']?></td>
                  <td>
                  <a class="aa5" style="cursor: pointer; font-size: 22px;" href="/push/R/<?=$value['p_id']?>/<?=$page?>">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                  </a>
                  <?php if($value['edit']): ?>
                    <a href="/push/edit/<?=$value['p_id']?>" class="aa5" style="cursor:pointer; font-size: 22px;" target='_blank'>
                      <i class="fa fa-pencil-square-o"></i>
                    </a>
                  <?php endif; ?>
                    <a class="aa5" style="cursor: pointer; font-size: 22px;" onclick="del_check(<?=$value['p_id']?>)">
                      <i class="fa fa-trash"></i>
                    </a>
                  </td>
                </tr> 
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="8">暫無資訊</td>
                </tr>
              <?php endif; ?>
            </table>
            <div class="pagination" style="position: relative; left: -40px;">
              <ul>
                <?=$create_links?>
              </ul>    
            </div>
          </div>
        <!-- </div> -->
      <!-- </td> -->

    <!-- </tr> -->
  <!-- </table> -->
  <!--cannot delete~ it's useful -->
  <div class="clear"></div>  

  </div><!--the end of w1024(container) -->
</div>

<script>
  function del_check(del_id, title) {
    if(confirm('您將要刪除 標題：' + $('#del_'+del_id).text() +'\n此筆紀錄是否刪除 ?'))
    {
      $.ajax({
        type: "post",
        url: '/push/del_push_log',
        data: {
            mode:  '0',
            p_id:  del_id,
        },
        cache: false,
        error: function(XMLHttpRequest, textStatus, errorThrown)
        {
        },
        success: function (response) {
          if(response)
            alert('刪除成功');
          else
            alert('刪除失敗');
          location.reload();
        } 
      });
    }
  }
</script>

</body>
</html>
