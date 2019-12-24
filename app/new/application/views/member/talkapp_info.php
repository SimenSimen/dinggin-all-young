<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>行動名片系統</title>
  <!-- css -->
  <link type="text/css" rel="stylesheet" href="/css/admin.css">
  <!-- jQuery -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <!-- bootstrap -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
  <style type="text/css">
    div.config-div {margin-top: 20px;margin-left: 40px;}
    div.config-div-img {margin-left: 68%;}
    div.config-div-encrypt {margin-left: 68%;}
    div.config-div fieldset {display: inline;float: left;}
    fieldset.config-border {
      width: 65%;
      border: 1px groove #ddd !important;
      padding: 0 1.4em 1.4em 1.4em !important;
      margin: 0 0 1.5em 0 !important;
      -webkit-box-shadow:  0px 0px 0px 0px #000;
              box-shadow:  0px 0px 0px 0px #000;
    }
    fieldset.config-border-img, fieldset.config-border-encrypt {
      width: 100px;
      border: 1px groove #ddd !important;
      padding: 0 1.4em 1.4em 1.4em !important;
      margin: 0 0 1.5em 0 !important;
      -webkit-box-shadow:  0px 0px 0px 0px #000;
              box-shadow:  0px 0px 0px 0px #000;
              text-align: center;
              vertical-align: middle;
    }
    legend.config-border {
      font-size: 1.2em !important;
      font-weight: bold !important;
      text-align: left !important;
      width:auto;
      padding:0 10px;
      border-bottom:none;
      width: 130px;
    }
    .member_list_title_td{
      text-align: center;
      background-color: #333;
      color: #fff;
      width:150px;
    }
    #member_list tr td{vertical-align: middle;}
    .member_list_input_td{width:180px;}
    input[type=text], .input_select{
      background-color: #FDFFE2;
      font-size: 16px;
      color: #000;
    }
	
/*-----------------------------*/
.header{
	font-size: 20px;
	text-align: center;
	/* color: #1093dd; */
	color:#000;
	line-height: 50px;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
	width: 100%;
	margin:auto;
	height: 50px;
	padding: 0 10%;
	background-color: #fff;
	background-image: url(/images/gold/header-bg.jpg);
	background-repeat: repeat-x;
	background-position: left bottom;
	
	overflow:hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.header a{
	font-size:30px;
	font-family:"微軟正黑體", "新細明體", "標楷體", Arial;
	display:inline;
	left:5px;
	position:absolute;
	width:35px;
	text-align:center;
}
/*--BG樣式----*/
.bg-style{
	 background:url(../images/bg.png) no-repeat center 0px;
    -moz-background-size:100%;
    -webkit-background-size:100%;
    -o-background-size:100%;
     background-size:100%;
}
.wrapper{ 
	width:94%;
	margin:auto;
	margin:20px 3% 70px 3%;
	text-align:justify;
}
/*-------------------**/
#talk{
	overflow:hidden;
}
.our-logo {
    height: 40px;
    display: inline;
    width: 10%;
    position: absolute;
    z-index: 1000;
}
.our-logo img {
    max-width: 40px;
	margin:0 0 0 -5px;
}
.our-talk {
    float: left;
    width: 100%;
    margin: 8px 0;
    position: relative;
}
.our-text {
    width: 88%;
    display: inline-block;
    /* margin-left: 12%; */
}
.our-text h6{ font-family:"微軟正黑體", "新細明體", "標楷體", Arial; font-size:.9em; color:#333; display:block; padding:0 0 5px;}
.our-text .o-word {
	color:#000;
    display: inline-block;
    background-color: #8eda4a;
	box-shadow:0 2px 2px #666;
    padding: 5px 10px;
    border-radius: 5px;
    -o-border-radius: 5px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
}
.your-talk {
    float: right;
    text-align: right;
    width: 100%;
    margin: 8px 0;
    position: relative;
}
.your-text {
    width: 88%;
    display: inline-block;
}
.your-text .y-word {
	color:#000;
    display: inline-block;
    background-color: #fff;
	box-shadow:0 2px 2px #666;
    padding: 5px 10px;
    border-radius: 5px;
    -o-border-radius: 5px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
}
.our-text time, .your-text time {
    font-size: 12px;
    color: #a3a3a3;
    display: block;
	padding:5px 0 0;
}

  </style>
  <!-- 地區AJAX -->
  <script src="/js/myjava/post_url.js"></script>
</head>
<left>
<body background="<?=$web_config['admin_background_image']?>" bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="scrollTo(0,document.body.scrollHeight)">
<header class="header">EBH留言</header>
  <div class="wrapper">
    <div id="talk">
      <? 
      foreach ($dbdata as $value):
          if($value['d_type']=='M'):
      ?>
              <div class="our-talk">
                  <span class="our-text">
                      <h6><?=$value['d_name']?></h6>
                      <div class="o-word"><?=$value['d_content']?></div>
                      <time><?=$value['create_time']?></time>
                  </span>
              </div>
      <?  endif;
          if($value['d_type']=='B'):
      ?>
              <div class="your-talk">
                  <span class="your-text">
                      <div class="y-word">
                          <?=$value['d_content']?>
                      </div>
                      <time><?=$value['create_time']?></time>
                  </span>
              </div>

      <?  endif;
      endforeach;
      ?>
    </div>
  </div><!--/wrapper-->
</body>
</html>
