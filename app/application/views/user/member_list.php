<!doctype html>
<html>
<head>

  <!–[if IE]>
  <script src=」https://html5shiv.googlecode.com/svn/trunk/html5.js」></script>
  <![endif]–>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=1024">

  <!-- seo -->
  <title><?=$_MemberAccount?> <?=$web_config['title']?></title>
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
  <link type="text/css" rel="stylesheet" href="/css/pageguide/edit_integrate.css">   
  <link type="text/css" rel="stylesheet" href="/css/pageguide/pageguide.css">
  <link type="text/css" rel="stylesheet" href="/css/pageguide/main.css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="/css/user_member_list.css"> 
  <link type="text/css" rel="stylesheet" href="/css/global.css" media="screen">
  
  <!-- jQuery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>

  <!-- js -->
  <script type="text/javascript" src="/js/pageguide.js"></script>
  <script type='text/javascript' src="/js/share_list.js"></script>

  <!--密碼不事先顯示-->
  <script type="text/javascript">
  $(function()
  {
    $('.password_title_td').click(function(){
        $('.password_td').each(function(){
          $(this).toggle();
        });
        $('.password_ori').each(function(){
          $(this).toggle();
        });
      });
  });
  </script>
  <style type="text/css">
    .password_title_td { cursor: pointer; color: #FF9999; }
    #title_td { text-align: center; padding-bottom: 30px; }
    #title_td p { text-align: center; font-size: 22px; }
  </style>

</head>

<body scroll="yes" style="overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

<?
  //header
  $this->load->view('business/header', $data);
?>
  
<div id="container" style="min-height:400px;"><div class="w1024">
    
        <table class='list_table'>
          <tr><td colspan="4" id='title_td'><p><?=$MemberList?> (<?=$Click?><span class='password_title_td'><?=$Password?></span><?=$Display?>)</p></td></tr>
        
        <tr>
          <td style="width:25%;"><?=$AccountNumber?></td>
          <td style="width:25%;"><span class='password_title_td'><?=$Password?></span></td>
          <td><?=$Mailbox?></td>
        </tr>

        <?php if (!empty($user)): ?>

          <?php foreach ($user as $key => $value): ?>
            <tr>
              <td><a href='<?=$member_iqr_link[$key]?>' onclick="window.open(this.href, '', config='scrollbars=1,outerWidth=300,innerWidth=300,height=640,width=300,left=900,scrollbar=yes'); return false;"><?=$value['account']?></td>
              <td><div class='password_td'>****</div><div class='password_ori' style='display:none;color:#EFEFEF;'><?=$password[$key]?></div></td>
              <td><?=$value['email']?></td>
            </tr>
          <?php endforeach; ?>

        <?php endif; ?>

      </table>

      <br>
      <br>
      <br>
      <br>
      <br>

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
