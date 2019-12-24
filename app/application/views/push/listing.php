<!doctype html>
<html>
<head>

  <!–[if IE]>
  <script src=」https://html5shiv.googlecode.com/svn/trunk/html5.js」></script>
  <![endif]–>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=1024">

  <!-- seo -->
  <title><?=$view_push_listing_1?> - <?=$web_config['title']?></title>
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
  <link type="text/css" rel="stylesheet" href="/css/pagination.css" media="screen">
  
  <!-- jQuery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

  <style type="text/css">
    #push_list_table { width: 95%; margin: 0px auto; }
    #push_list_table tr td {
      font-family: 'Microsoft JhengHei';
      font-size: 16px;
      text-align: center;
      border: 1px solid #ddd;
      padding: 15px 7px 10px 7px;
      background: #ffffff;
      vertical-align: middle;
    }
    .aa5 { cursor: pointer; }
    .push_title{
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      width: 215px;
    }
    .push_message{
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      width: 446px;
    }
  </style>

</head>

<body scroll="yes" style="overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

<?
  //header
  $this->load->view('business/header', $data);
?>
  
<div id="container"><div class="w1024">
    
  <div id="con-L" style="width: 100%; height: 850px;">

    <div class="step-docUP-1" style="height: 800px;">
      
      <p style="line-height: 36px; text-align: center; font-size: 1.5em;"><?=$view_push_listing_2?>&nbsp;<input type='button' class='aa2' id='push_msg_add' value='<?=$view_push_listing_3?>'></p>
      
        <?php if (!empty($page_data)): ?>
          <table id='push_list_table'>

            <tr>
              <td style="width: 25%;"><?=$view_push_listing_4?></td>
              <td style="width: 25%;"><?=$view_push_listing_5?></td>
              <td style="width: 50%;"><?=$view_push_listing_6?></td>
            </tr>

            <?php foreach ($page_data as $key => $value): ?>

                <tr>
                  <td align="center"><?=date('Y-m-d H:i:s', $value['date'])?></td>
                  <td align="center"><div class='push_title' title="<?=$value['title']?>"><?=$value['title']?></div></td>
                  <td align="center"><div class='push_message' title="<?=$value['message']?>"><?=$value['message']?></div></td>
                </tr>

            <?php endforeach; ?>

          </table>
        <?php endif; ?>
  
        <div class="pagination" style="position: relative; left: 37%;">
          <ul>
              <?=$create_links?>
          </ul>    
        </div>
  
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

<script type="text/javascript">
  $(function()
  {
    //開啟新增推播視窗
    $('#push_msg_add').click(function(){
      window.open('/push/add', '新增推播文字', config='height=500,width=800,left=290,top=50,resizable=yes,scrollbar=yes,scrollbars=1');
    });
  });

</script>

</body>
</html>
