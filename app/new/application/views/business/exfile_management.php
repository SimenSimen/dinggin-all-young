<!doctype html>
<html>
<head>

  <!–[if IE]>
  <script src='http://html5shiv.googlecode.com/svn/trunk/html5.js'></script>
  <![endif]–>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=1024">

  <!-- seo -->
  <title><?=$_AnnexManagement?> <?=$web_config['title']?></title>
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
  <link type="text/css" rel="stylesheet" href="/css/exfile_management.css">
  <link type="text/css" rel="stylesheet" href="/css/global.css" media="screen">
  
  <!-- jQuery -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

  <!-- js -->
  <script type="text/javascript" src="/js/pageguide.js"></script>
  <script type="text/javascript" src="/js/exfile_management.js"></script>

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
    '非 Firefox/Chrom/IE 瀏覽器';

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
  <div id="con-L" style="height: 1332px;">
   
   <div class="step-docUP-1">

      <?php if ($exfile_num == 0): ?>
        <h2 class="boxs_title" id='exfile_boxs_title'><?=$NoAnyAnnex?></h2>
      <?php else: ?>
        <h2 class="boxs_title" id='exfile_boxs_title'><?=$NowHave?><?=$exfile_num?><?=$_Annex?></h2>
      <?php endif; ?>
      <input type='button' class="aa2" id='add_exfile' value='+ <?=$AddAnnex?>'><span class='introdution_prompt' id='msg'><?=$msg?></span>

     <div class="imgUPss">
     
        <!--原始顯示區-->
        <div class='switch_exfile' id='exfile_view' style="display:none;">
          <?php if (!empty($exfile)): ?>
            <table class='exfile_management_table'>
              <tr>
                <td width="10%" align="center"><?=$Number?></td>
                <td><?=$OriginalFilename?></td>
                <td><?=$ButtonName?></td>
                <td style="text-align:center;"><?=$Download?></td>
              </tr>
              <?php foreach ($exfile as $key => $value): ?>
                  <tr>
                    <td align="center"><?=($key+1)?></td>
                    <td><div class='exfile_ori_name' title="<?=$exfile_ori_name[$key]?>"><?=$exfile_ori_name[$key]?></div></td>
                    <td><div class='exfile_name_td' title="<?=$exfile_name[$key]?>"><?=$exfile_name[$key]?></div></td>
                    <td style="text-align:center;"><a class='aa7' target="_blank" href='<?=$value?>'><?=$Download?></a></td><!-- download='<?=$doc_ori_name[$key]?>' download='<?=$exfile_name[$key]?>'-->
                  </tr>
              <?php endforeach; ?>
            </table>
          <?php endif; ?>
        </div>
        <!--原始顯示區結束-->

        <!--排序區-->
        <div class='switch_exfile' id='exfile_sort' style="display:none;">
          <?php if (!empty($exfile)): ?>
          <?echo form_open("/business/exfile_sort", array('name'=>'form_exfile_sort', 'id'=>'form_exfile_sort'));?>
            <table class='exfile_management_table'>
              <tr>
                <td width="10%" align="center"><?=$Number?></td>
                <td><?=$OriginalFilename?></td>
                <td><?=$ButtonName?></td>
              </tr>
              <tbody id='exfile_sortable'>
                <?php foreach ($exfile as $key => $value): ?>
                    <tr>
                      <td align="center"><?=($key+1)?></td>
                      <td><div class='exfile_ori_name'><?=$exfile_ori_name[$key]?></div></td>
                      <td>
                        <div class='exfile_name_td'><?=$exfile_name[$key]?></div>
                        <input type='hidden' name='exfile_sort_id[]' value='<?=$exfile_id[$key]?>'>
                      </td>
                    </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </form>
          <?php endif; ?>
        </div>
        <!--排序區結束-->

        <!--編輯按鈕名稱區-->
        <div class='switch_exfile' id='exfile_name_edit' style="display:none;">
          <?php if (!empty($exfile)): ?>
          <?echo form_open("/business/exfile_edit_btn_name", array('name'=>'form_exfile_edit_btn_name', 'id'=>'form_exfile_edit_btn_name'));?>
            <table class='exfile_management_table personal-info'>
              <tr>
                <td width="10%" align="center"><?=$Number?></td>
                <td><?=$OriginalFilename?></td>
                <td><?=$ButtonName?></td>
              </tr>
              <tbody>
                <?php foreach ($exfile as $key => $value): ?>
                    <tr>
                      <td align="center"><?=($key+1)?></td>
                      <td><div class='exfile_ori_name'><?=$exfile_ori_name[$key]?></div></td>
                      <td>
                        <input type='text' class='iii2' placeholder='<?=$StrNum15?>' style="width:75%;" maxlength="15" name='exfile_name[<?=$exfile_id[$key]?>]' value='<?=$exfile_name[$key]?>'>
                        <a href="#" class="why">?</a>
                        <div class='prompt-box'>
                          <p><?=$LimitButtonName?></p>
                          <p><?=$NotShowAllName?></p>
                        </div>
                      </td>
                    </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </form>
          <?php endif; ?>
        </div>
        <!--編輯按鈕名稱結束-->

        <!--移除附件區-->
        <div class='switch_exfile' id='exfile_delete' style="display:none;">
          <?php if (!empty($exfile)): ?>
          <?echo form_open("/business/exfile_remove", array('name'=>'form_exfile_remove', 'id'=>'form_exfile_remove'));?>
            <table class='exfile_management_table' id='remove_table'>
              <tr>
                <td><input type="checkbox" name='clickAll' id='clickAll' />&nbsp;<?=$SelectAll?></td>
                <td><?=$OriginalFilename?></td>
                <td><?=$ButtonName?></td>
              </tr>
              <?php foreach ($exfile as $key => $value): ?>
                  <tr>
                    <td><input type="checkbox" name='exfile_remove[]' class='exfile_remove' value='<?=$exfile_id[$key]?>' /></td>
                    <td><div class='exfile_ori_name'><?=$exfile_ori_name[$key]?></div></td>
                    <td><?=$exfile_name[$key]?></td>
                  </tr>
              <?php endforeach; ?>
            </table>
          </form>
          <?php endif; ?>
        </div>
        <!--移除附件結束-->

   
    </div>  <!--imgUPss  結束-->
        
    <!--切換按鈕-->
    <div class="aaCenter">
      <div class="bottom_button" id='exfile_bottom_button'>
        <input type='button' class='aa6' id='exfile_sort_btn' value='<?=$SequenceAnnex?>'>
        <input type='button' class='aa6' id='exfile_edit_btn' value='<?=$EditButtonName?>'>
        <input type='button' class='aa6' id='exfile_del_btn' value='<?=$RemoveAnnex?>'>
      </div>
      <div class="bottom_button" id='exfile_sort_button' style="display:none;">
          <input type='button' class='aa6' id='exfile_sort_submit' value='<?=$SaveAnnexSequence?>'>
          <input type='button' class='aa6 exfile_cancel_btn' value='<?=$Cancle?>'>
      </div>
      <div class="bottom_button" id='exfile_edit_note_button' style="display:none;">
          <input type='button' class='aa6' id='exfile_edit_note_submit' value='<?=$SaveAnnexName?>'>
          <input type='button' class='aa6 exfile_cancel_btn' value='<?=$Cancle?>'>
      </div>
      <div class="bottom_button" id='exfile_remove_button' style="display:none;">
          <input type='button' class='aa6' id='exfile_remove_submit' value='<?=$RemoveSelecteAnnex?>'>
          <input type='button' class='aa6 exfile_cancel_btn' value='<?=$Cancle?>'>
      </div>
    </div>
                                                  
   </div>  <!--step-docUP-1  結束--> 
   

   </div>   <!-- 左   結束 -->
   
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
