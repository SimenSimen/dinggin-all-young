<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title>好友分享券快速連結 - <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <!-- jquery.mobile -->
  <link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.1/jquery.mobile-1.2.1.min.css" />
  <script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
  <script src="http://code.jquery.com/mobile/1.2.1/jquery.mobile-1.2.1.min.js"></script>

  <!-- jquery.qrcode -->
  <script src="/js/jqrcode/jquery.qrcode-0.7.0.js"></script>
  <script src="/js/jqrcode/ff-range.js"></script>
  <script src="/js/jqrcode/script_for_ecp.js"></script>

  <!--jQuery-->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script><!--library-->
  <script type="text/javascript">
    $(window).load(function(){
      $("img").each(function(i){
        //移除目前設定的影像長寬
          $(this).removeAttr('width');
          $(this).removeAttr('height');
     
          //取得影像實際的長寬
          var imgW = $(this).width();
          var imgH = $(this).height();
     
          //計算縮放比例
          var w=($(window).width()*70/100)/imgW;
          var h=w;
          var pre=1;
          if(w>h){
            pre=h;
          }else{
            pre=w;
          }
     
          //設定目前的縮放比例
          $(this).width(imgW*pre);
          $(this).height(imgH*pre);
      });
    });

<?	if($theme_id==8){ 
//		$outurlstr=$base_url.'form/index8/'.$ecp_id.'/'.$mid.'/'.$account.'/'.$viewtype;
		$outurlstr=$base_url.'business/ecoupon_editor/'.$mid.'/'.$ecp_id.'/ecoupon_detail';
	}else{ 
		$outurlstr=$base_url.'business/my_ecoupon/'.$mid.'/'.$ecp_id;
	} ?>	
	
    $(function(){
      $('#text').click(function(){
        window.open('<?=$outurlstr?>', '好友分享券', config='scrollbars=1,height=616,width=420,left=870,resizable=yes,scrollbar=yes');
      });
    });
  </script>

</head>

<center>
<body style="overflow:hidden;">
<div data-role="page" data-theme='z'>

<!-- header -->
<div data-role="header">
  <h1>好友分享券QRcode</h1>
</div>

<div data-role="content" data-theme='c'>

<span style="font-family:'微軟正黑體';font-size:1.05em;">使用智慧型手機掃描<br>快速開啟好友分享券<br>或點圖下載<br></span>

    <div id="container" class="viewer_container" style='display:none;'>   

    </div>

    <input type='hidden' name="base_url" id="base_url" value='<?=$base_url?>'/>
    <input type='hidden' name="ecp_id" id="ecp_id" value='<?=$ecp_id?>'/>
    <input type='hidden' name="mid" id="mid" value='<?=$mid?>'/>

    <input name="size"          id="size"       type="hidden" value='450'  />
    <input name="fill"          id="fill"       type="hidden" value='<?=$style['fill']?>' />
    <input name="background"    id="background" type="hidden" value='<?=$style['background']?>' />
    <input name="minversion"    id="minversion" type="hidden" value='<?=$style['minversion']?>' />
    <input name="eclevel"       id="eclevel"    type="hidden" value='<?=$style['eclevel']?>'  />
    <input name="quiet"         id="quiet"      type="hidden" value='<?=$style['quiet']?>'  />
    <input name="radius"        id="radius"     type="hidden" value='<?=$style['radius']?>'  />
    <input name="mode"          id="mode"       type="hidden" value='<?=$style['mode']?>'  />
    <input name="msize"         id="msize"      type="hidden" value='<?=$style['msize']?>' />
    <input name="mposx"         id="mposx"      type="hidden" value='<?=$style['mposx']?>' />
    <input name="mposy"         id="mposy"      type="hidden" value='<?=$style['mposy']?>'  />

    <a style='cursor: pointer;' title='點此下載' id="download" download="<?=$uform['ufm_name']?>.png">
    <img id="img-buffer" src="<?=$img_content?>" style='max-width: 400px; max-height: 400px;'/>
    </a>
<br>
<!-- qrcode url -->
<textarea readonly="true" style="resize:none;width:85%;cursor: pointer;height:62.8px;" name="iqr_url" id="text">※ 您也可以點此直接開啟 <?=$outurlstr?></textarea>
<a onclick="javascript:window.close();" style="width:85%;" data-role="button" data-corners="false" data-shadow="true" data-iconshadow="true" data-icon="delete" data-theme="a">關閉本視窗</a>

</div>
</div><!-- /page -->

</body>
</html>