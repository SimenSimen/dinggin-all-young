<!doctype html>
<html>
  <head>

  <!–[if IE]>
  <script src=」http://html5shiv.googlecode.com/svn/trunk/html5.js」></script>
  <![endif]–>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=1024">

  <!-- seo -->
  <title><?=$ApplicationShelves?> - <?=$web_config['title']?></title>
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
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <script type="text/javascript">
    function check_form()
    {
        if($('#brief').val() == '')
        {          
          alert('<?=$BriefFillIn?>');
          return false;
        }
        
        if($('#description').val() == '')
        {
          alert('<?=$DescriptionFillIn?>');
          return false;
        }

        if($('.type').val() == 0)
        {
          alert('<?=$SelectClass?>');
          return false;
        }

        alert('<?=$UploadPhoto?>');
        return false;
    }

    $(function(){
      $('.hidden_image').hide();
      if($('#pre_quantity').width() != 512 || $('#pre_quantity').height() != 512)
      {
        if(confirm('<?=$RemindYou512?>'))
        {
          window.location="<?php echo base_url().'appui/build';?>";
        }
      }

      if($('#user_apk').val() == 0 || $('#user_apk').val() == 2)
      {
        if(confirm('<?=$GoToBuild?>'))
        {
          window.location="<?php echo base_url().'appui/build';?>";
        }
        else
        {
        }
      }
    });
  </script>
  <style type="text/css">
      #push_apply_table {
      	width: 95%;
      	margin: 0px auto;
      }
      #push_apply_table trtd {
      	font-family: 'Microsoft JhengHei';
      	font-size: 16px;
      	text-align: center;
      	border: 1px solid #ddd;
      	padding: 15px 7px 10px 7px;
      	background: #ffffff;
      	vertical-align: middle;
      }
      #list_table tr{
      	line-height:24px;
      }
      #list_table th {
      	width:30%;
      	text-align:right;
      	border-right:1px solid #eee;
      }
      #list_table td span { color:#F90;
      }
      #list_table td {
      	width:70%;
      	text-align:left;
      	padding:20px;
      }
  </style>
  </head>

  <body scroll="yes" style="overflow-x: hidden;overflow: -moz-scrollbars-vertical;">
<?
  //header
  $this->load->view('business/header', $data);
?>
<div id="container">
    <div class="w1024">
    <div id="con-L" style="width: 100%; height: 1800px;">
        <div class="step-docUP-1" style="height: 1720px;">
        <input type="hidden" id="user_apk" value="<?=$iqr['apk']?>" >
        <form id='upload_data' method='post'  enctype="multipart/form-data">
            <table id='list_table' style="width:100%;">
            <tr>
              <th><?=$ApplicationName?></th>
              <td style="width: 70%; height: 25px; font-family: 'Microsoft JhengHei';"><?=$iqr['l_name']?><?=$iqr['f_name']?>
              <span><?=$ByBuildNameLoad?></span>
              </td>
            </tr>
            
            <tr>
              <th><?=$ShortDescription?></th>
              <td><textarea id='brief' name="brief_r" style="width: 60%; height: 80px; font-family: 'Microsoft JhengHei';" type="text" maxlength="80"   placeholder='<?=$ShortDescription?>' ><?=$shelf['shelf_brief']?></textarea>
              <span><?=$Most80Char?></span></td>
            </tr>
            
            <tr>
              <th><?=$FullDescription?></th>
              <td><textarea rows="6" cols="50" id='description' name="description_r" style="width:60%; height: 150px; font-family: 'Microsoft JhengHei';" type="text"  maxlength="4000" placeholder='<?=$FullDescription?>' ><?=$shelf['shelf_description']?></textarea>
              <span><?=$Most4KChar?></span></td>
            </tr>
            
            <tr>
              <th><?=$PhoneScreenshot_1?>
              <a href="#" class="why" tabindex = "-1">?</a>
                <div class='prompt-box'>
                  <p style='color: #ff6600'><?=$Provision?></p>
                  <p><?=$Jepg24BitPng?></p>
                  <p><?=$Size320?></p>
                  <p><?=$Size3840?></p>
                  <p><?=$LongNotExceed?></p>
                  <p style='color: #ff6600'><?=$DisplayLocation?></p>
                  <p><img src="https://storage.googleapis.com/support-kms-prod/SNP_FCD84192F36591CEB4F1237A19CCD8F76F7F_4509843_en_v2" style="width:400px;"></p>
                </div><br>
              </th>
              <?php if($shelf['shelf_capture_url1']): ?>
                <td>
                  <img id="mobile1" src="/<?=$shelf['shelf_capture_url1']; ?>"  style="width: 10%;height: 10%;">
                  <input style="position: absolute;margin: 55px 0px 0px 30px; font-family: Microsoft JhengHei;padding: 1px 7px 1px 7px" type="submit" name="del_mobile1" id="del_mobile1" value="<?=$DeleteTheImage?>">
                </td>
              <?php else: ?>
                <td><input class='limited_img' id='mobile1' name="mobile1" type="file" data-mobile1-width="320" data-mobile1-maxwidth="3840" data-mobile1-height="320" data-mobile1-maxheight="3840" data-mobile1-display="mobile1_display"  ><br>
                <span><?=$Jepg24Bit?></span></td>
                <img id='mobile1_display' class='hidden_image'>
              <?php endif; ?>
            </tr>
            
            <tr>
              <th><?=$PhoneScreenshot_2?>
              <a href="#" class="why" tabindex = "-1">?</a>
                <div class='prompt-box'>
                  <p style='color: #ff6600'><?=$Provision?></p>
                  <p><?=$Jepg24BitPng?></p>
                  <p><?=$Size320?></p>
                  <p><?=$Size3840?></p>
                  <p><?=$LongNotExceed?></p>
                  <p style='color: #ff6600'><?=$DisplayLocation?></p>
                  <p><img src="https://storage.googleapis.com/support-kms-prod/SNP_FCD84192F36591CEB4F1237A19CCD8F76F7F_4509843_en_v2" style="width:400px;"></p>
                </div><br>
              </th>
              <?php if($shelf['shelf_capture_url2']): ?>
                <td>
                  <img id='mobile2' src="/<?=$shelf['shelf_capture_url2']; ?>"  style="width: 10%;height: 10%;">
                  <input style="position: absolute;margin: 55px 0px 0px 30px; font-family: Microsoft JhengHei;padding: 1px 7px 1px 7px" type="submit" name="del_mobile2" id="del_mobile2" value="<?=$DeleteTheImage?>">
                </td>
              <?php else: ?>
                <td><input class='limited_img' id='mobile2' name="mobile2" type="file" data-mobile2-width="320" data-mobile2-maxwidth="3840" data-mobile2-height="320" data-mobile2-maxheight="3840" data-mobile2-display="mobile2_display"  ><br>
                <span><?=$Jepg24Bit?></span></td>
                <img id='mobile2_display' class='hidden_image'>
              <?php endif; ?>
            </tr>

            <tr>
              <th><?=$PhoneScreenshot_3?>
              <a href="#" class="why" tabindex = "-1">?</a>
                <div class='prompt-box'>
                  <p style='color: #ff6600'><?=$Provision?></p>
                  <p><?=$Jepg24BitPng?></p>
                  <p><?=$Size320?></p>
                  <p><?=$Size3840?></p>
                  <p><?=$LongNotExceed?></p>
                  <p style='color: #ff6600'><?=$DisplayLocation?></p>
                  <p><img src="https://storage.googleapis.com/support-kms-prod/SNP_FCD84192F36591CEB4F1237A19CCD8F76F7F_4509843_en_v2" style="width:400px;"></p>
                </div><br>
              </th>
              <?php if($shelf['shelf_capture_url3']): ?>
                <td>
                  <img id='mobile3' src="/<?=$shelf['shelf_capture_url3']; ?>"  style="width: 10%;height: 10%;">
                  <input style="position: absolute;margin: 55px 0px 0px 30px; font-family: Microsoft JhengHei;padding: 1px 7px 1px 7px" type="submit" name="del_mobile3" id="del_mobile3" value="<?=$DeleteTheImage?>">
                </td>
              <?php else: ?>
                <td><input class='limited_img' id='mobile3' name="mobile3" type="file" data-mobile3-width="320" data-mobile3-maxwidth="3840" data-mobile3-height="320" data-mobile3-maxheight="3840" data-mobile3-display="mobile3_display"  ><br>
                <span><?=$Jepg24Bit?></span></td>
                <img id='mobile3_display' class='hidden_image'>
              <?php endif; ?>
            </tr>

            <tr>
              <th><?=$PhoneScreenshot_4?>
              <a href="#" class="why" tabindex = "-1">?</a>
                <div class='prompt-box'>
                  <p style='color: #ff6600'><?=$Provision?></p>
                  <p><?=$Jepg24BitPng?></p>
                  <p><?=$Size320?></p>
                  <p><?=$Size3840?></p>
                  <p><?=$LongNotExceed?></p>
                  <p style='color: #ff6600'><?=$DisplayLocation?></p>
                  <p><img src="https://storage.googleapis.com/support-kms-prod/SNP_FCD84192F36591CEB4F1237A19CCD8F76F7F_4509843_en_v2" style="width:400px;"></p>
                </div><br>
              </th>
              <?php if($shelf['shelf_capture_url4']): ?>
                <td>
                  <img id='mobil4' src="/<?=$shelf['shelf_capture_url4']; ?>"  style="width: 10%;height: 10%;">
                  <input style="position: absolute;margin: 55px 0px 0px 30px; font-family: Microsoft JhengHei;padding: 1px 7px 1px 7px" type="submit" name="del_mobile4" id="del_mobile4" value="<?=$DeleteTheImage?>">
                </td>
              <?php else: ?>
                <td><input class='limited_img' id='mobile4' name="mobile4" type="file" data-mobile4-width="320" data-mobile4-maxwidth="3840" data-mobile4-height="320" data-mobile4-maxheight="3840" data-mobile4-display="mobile4_display"  ><br>
                <span><?=$Jepg24Bit?></span></td>
                <img id='mobile4_display' class='hidden_image'>
              <?php endif; ?>
            </tr>

            <tr>
              <th><?=$PhoneScreenshot_5?>
              <a href="#" class="why" tabindex = "-1">?</a>
                <div class='prompt-box'>
                  <p style='color: #ff6600'><?=$Provision?></p>
                  <p><?=$Jepg24BitPng?></p>
                  <p><?=$Size320?></p>
                  <p><?=$Size3840?></p>
                  <p><?=$LongNotExceed?></p>
                  <p style='color: #ff6600'><?=$DisplayLocation?></p>
                  <p><img src="https://storage.googleapis.com/support-kms-prod/SNP_FCD84192F36591CEB4F1237A19CCD8F76F7F_4509843_en_v2" style="width:400px;"></p>
                </div><br>
              </th>
              <?php if($shelf['shelf_capture_url5']): ?>
                <td>
                  <img id='mobile5' src="/<?=$shelf['shelf_capture_url5']; ?>"  style="width: 10%;height: 10%;">
                  <input style="position: absolute;margin: 55px 0px 0px 30px; font-family: Microsoft JhengHei;padding: 1px 7px 1px 7px" type="submit" name="del_mobile5" id="del_mobile5" value="<?=$DeleteTheImage?>">
                </td>
              <?php else: ?>
                <td><input class='limited_img' id='mobile5' name="mobile5" type="file" data-mobile5-width="320" data-mobile5-maxwidth="3840" data-mobile5-height="320" data-mobile5-maxheight="3840" data-mobile5-display="mobile5_display"  ><br>
                <span><?=$Jepg24Bit?></span></td>
                <img id='mobile5_display' class='hidden_image'>
              <?php endif; ?>
            </tr>

            <tr>
              <th><?=$PhoneAppIcon?>
              <a href="#" class="why" tabindex = "-1">?</a>
                <div class='prompt-box'>
                  <p style='color: #ff6600'><?=$Provision?></p>
                  <p><?=$A32Bit_3?></p>
                  <p><?=$Size512?></p>
                  <p><?=$FileSize1024?></p>
                  <p style='color: #ff6600'><?=$DisplayLocation?></p>
                  <p><img src="https://storage.googleapis.com/support-kms-prod/SNP_58239E7DEB1B96C3C9E75D607C6178026F04_4509860_en_v2" style="width:400px;"></p>
                </div><br>
              </th>

                <td>
                  <img id='quantity' src="/<?=$shelf['shelf_HD_url']?>"  style="width: 20%;">
                  <span><?=$ReplacesAPPIcon?></span>
                  <img src="/<?=$shelf['shelf_HD_url']?>" id="pre_quantity" class='hidden_image' >
                </td>
            </tr>
            
            <tr>
              <th><?=$PlayStoreImage?>
              <a href="#" class="why" tabindex = "-1">?</a>
                <div class='prompt-box'>
                  <p><img src="https://storage.googleapis.com/support-kms-prod/SNP_0EB3F1E9CE8FBE0055660FF66D7438F25CB7_6071289_en_v0" style="width:400px;"></p>
                </div><br>
              </th>
              <?php if($shelf['shelf_topic_url']): ?>
                <td>
                  <img id='topic' src="/<?=$shelf['shelf_topic_url']; ?>"  style="width: 25%;">
                  <input style="position: absolute;margin: 55px 0px 0px 30px; font-family: Microsoft JhengHei;padding: 1px 7px 1px 7px" type="submit" name="del_topic" id="del_topic" value="<?=$Delete?>">
                </td>
              <?php else: ?>
                <td><input class='quantity_img' id='topic' name="topic" type="file" data-topic-width="1024" data-topic-height="500" data-topic-display="topic_display"  ><br>
                <span><?=$W1024_500JPG24Bit?></span></td>
                <img id='topic_display' class='hidden_image'>
              <?php endif; ?>
            </tr>
            
            <tr>
              <th><?=$TheClass?>
              <td>
              <select name='type' class='type'>
              <?php foreach ($type as $key => $value): ?>
                <option  style="font-size: 0.9em;font-family: 微軟正黑體;" value='<?=$key?>' <?=$type_selected[$key]?>><?=$value?></option>
              <?php endforeach; ?>
              </select>
              </td>
              </th>
            </tr>


            <tr>
              <td style="text-align: center;" colspan="4">
                  <input class='aa3' style='font-size: 1.2em; margin: 20px 5px;padding: 9px 29px 9px 29px;' id='save_data' type='submit' name='save_data' value='<?=$Save?>'>
                  <?php if($shelf['shelf_brief'] && $shelf['shelf_description'] && $shelf['shelf_capture_url1'] && $shelf['shelf_capture_url2'] && $shelf['shelf_capture_url3'] && $shelf['shelf_capture_url4'] && $shelf['shelf_capture_url5'] && $shelf['shelf_HD_url'] && $shelf['shelf_topic_url'] && $shelf['type'] != 0 && $shelf['type'] != NULL && $iqr['apk'] == 1 && $icon_size == 0):?>
                    <input class='aa3' style='font-size: 1.2em; margin: 20px 5px;padding: 9px 29px 9px 29px;' id='upload' type='submit' name='upload' value='<?=$ApplicationShelves?>' >
                  <?php elseif(!$shelf['shelf_brief'] || !$shelf['shelf_description'] || !$shelf['shelf_capture_url1'] || !$shelf['shelf_capture_url2'] || !$shelf['shelf_capture_url3'] || !$shelf['shelf_capture_url4'] || !$shelf['shelf_capture_url5'] || !$shelf['shelf_HD_url'] || !$shelf['shelf_topic_url'] || $shelf['type'] == '0' || $shelf['type'] == NULL): ?>
                    <input class='aa3lock' style='font-size: 1.2em; margin: 20px 5px;padding: 9px 29px 9px 29px;' id='upload' type='submit' name='upload' value='<?=$PleaseUploadAndSave?>' onclick="return check_form();" title="<?=$PleaseBeWritten?>" >
                  <?php elseif($iqr['apk'] == 2 || $iqr['apk'] == 0 || $icon_size ):?>
                    <input class='aa3lock' style='font-size: 1.2em; margin: 20px 5px;padding: 9px 29px 9px 29px;' id='upload' type='submit' name='upload' value='<?=$AppUpdateAndUpload?>' onclick="return check_form();" title="<?=$GoToAPPBuild?>" >
                  <?php endif; ?>
              </td>
          </table>
          </form>
        
      </div>
        <!--step-docUP-1  結束--> 
        
      </div>
    </form>
    
    <!--cannot delete~ it's useful -->
    <div class="clear"></div>
  </div>
    <!--the end of w1024(container) -->
    
    <div id="advertisement"> <!--go top--> 
    <a href="#"><img style="border:0px;" src="/images/style_01/gotop.png"></a> </div>
  </div>
<!--the end of container -->

<?
  //footer
  $this->load->view('business/footer', $data);
?>

<script type="text/javascript" src="/js/jquery-image-limitation.js"></script>
<!-- <script type="text/javascript" src="/js/release.js"></script> -->
</body>
</html>
