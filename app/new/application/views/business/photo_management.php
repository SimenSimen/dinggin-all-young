<!doctype html>
<html>
<head>

  <!–[if IE]>
  <script src='http://html5shiv.googlecode.com/svn/trunk/html5.js'></script>
  <![endif]–>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=1024">

  <!-- seo -->
  <title><?=$_AlbumManagement?> <?=$web_config['title']?></title>
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
   <?php /*舊?>
   <div class="step-imgUP-1">

      <?php if ($myphoto_num == 0): ?>
        <h2>形象圖相簿：目前沒有任何照片</h2>
      <?php else: ?>
        <h2>形象圖相簿 (共<?=$myphoto_num?>張)</h2>
      <?php endif; ?>
      <input type='button' class="aa2" id='add_myphoto' value='+ 新增照片'><span class='introdution_prompt' id='msg'><?=$msg?></span>
      
      <div class="imgUPss">
     
        <!--原始顯示區-->
        <div class='switch_myphoto' id='myphoto_album' style="display:none;">

          <?php if (!empty($myphoto)): ?>
            <ul id="myphoto_ori">
              <?php foreach ($myphoto as $key => $value): ?>
                  <li class="ui-state-default">
                    <img src='<?=$value?>'>
                  </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>
        <!--原始顯示區結束-->

        <!--排序區-->
        <div class='switch_myphoto' id='myphoto_sort' style="display:none;">
          <span class='introdution_prompt'>照片順序為由左至右，由上至下排序</span>
          <?echo form_open("/business/photo_sort", array('name'=>'form_myphoto_sort', 'id'=>'form_myphoto_sort'));?>
           <?php if (!empty($myphoto)): ?>
            <ul id="myphoto_sortable">
              <?php foreach ($myphoto as $key => $value): ?>
                  <li class="ui-state-default">
                    <img src='<?=$value?>'>
                    <input type='hidden' name='photo_sort[]' value='<?=$myphoto_id[$key]?>'>
                  </li>
              <?php endforeach; ?>
            </ul>
            <?php endif; ?>
            <input type='hidden' name='typ_n' value='0'>
          </form>
        </div>

        <!--編輯註解區-->
        <div class='switch_myphoto' id='myphoto_name_edit' style="display:none;">
          <?php if (!empty($myphoto)): ?>
            <?echo form_open("/business/photo_edit_note", array('name'=>'form_myphoto_edit_note', 'id'=>'form_myphoto_edit_note'));?>
              <table style="width:100%;margin-left: 10px;margin-top: 10px;">
                <?php foreach ($myphoto as $key => $value): ?>
                  <tr>
                    <td class='edit_photo_box'><img src='<?=$value?>'></td>
                    <td>
                      <input value='<?=$myphoto_name[$key]?>' class='edit_photo_name_area iii4' name='photo_name[<?=$myphoto_id[$key]?>]' placeholder='照片註解(最多32個字)' maxlength='32'>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </table>
              <input type='hidden' name='typ_n' value='0'>
            </form>
          <?php endif; ?>
        </div>

        <!--移除照片區-->
        <div class='switch_myphoto' id='myphoto_delete' style="display:none;">
          <span class='introdution_prompt'>請勾選您要從相簿移除的照片</span><input name="clickAll" id="clickAll" type="checkbox"><label for='clickAll'>全選</label>
          <?echo form_open("/business/photo_remove", array('name'=>'form_myphoto_remove', 'id'=>'form_myphoto_remove'));?>
           <?php if (!empty($myphoto)): ?>
            <ul class="myphoto_remove">
              <?php foreach ($myphoto as $key => $value): ?>
                  <li class="ui-state-default">
                    <label for='remove_checkbox_<?=$key?>'><img src='<?=$value?>'></label><br><input class='myphoto_remove_checkbox' id='remove_checkbox_<?=$key?>' type='checkbox' name='photo_remove[]' value='<?=$myphoto_id[$key]?>'>
                  </li>
              <?php endforeach; ?>
            </ul>
            <?php endif; ?>
            <input type='hidden' name='typ_n' value='0'>
          </form>
        </div>
   
      </div>  <!--imgUPss  結束-->
        
      <!--切換按鈕-->
      <div class="aaCenter">
        <div class="bottom_button" id='bottom_button'>
          <input type='button' class='aa6' id='myphoto_sort_btn' value='排序照片'>
          <input type='button' class='aa6' id='myphoto_edit_btn' value='編輯註解'>
          <input type='button' class='aa6' id='myphoto_del_btn' value='移除照片'>
        </div>
        <div class="bottom_button" id='sort_button' style="display:none;">
            <input type='button' class='aa6' id='myphoto_sort_submit' value='儲存排序'>
            <input type='button' class='aa6 myphoto_cancle_btn' value='取消'>
        </div>
        <div class="bottom_button" id='edit_note_button' style="display:none;">
            <input type='button' class='aa6' id='myphoto_edit_note_submit' value='儲存照片註解'>
            <input type='button' class='aa6 myphoto_cancle_btn' value='取消'>
        </div>
        <div class="bottom_button" id='remove_button' style="display:none;">
            <input type='button' class='aa6' id='myphoto_remove_submit' value='移除所選照片'>
            <input type='button' class='aa6 myphoto_cancle_btn' value='取消'>
        </div>
      </div>
                                                  
   </div>  <!--step-imgUP-1 個人相簿 結束--> 
   
   
    <div class="step-imgUP-2">

      <?php if ($cpnphoto_num == 0): ?>
        <h2>公司相簿：目前沒有任何照片</h2>
      <?php else: ?>
        <h2>公司相簿 (共<?=$cpnphoto_num?>張)</h2>
      <?php endif; ?>
      <input type='button' class="aa2" id='add_cpnphoto' value='+ 新增照片'>
      
      <div class="imgUPss">

       <!--原始顯示區-->
        <div class='switch_cpnphoto' id='cpnphoto_album' style="display:none;">

          <?php if (!empty($cpnphoto)): ?>
            <ul id="cpnphoto_ori">
              <?php foreach ($cpnphoto as $key => $value): ?>
                  <li class="ui-state-default">
                    <img src='<?=$value?>'>
                  </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>
        <!--原始顯示區結束-->

        <!--排序區-->
        <div class='switch_cpnphoto' id='cpnphoto_sort' style="display:none;">
          <span class='introdution_prompt'>照片順序為由左至右，由上至下排序</span>
          <?echo form_open("/business/photo_sort", array('name'=>'form_cpnphoto_sort', 'id'=>'form_cpnphoto_sort'));?>
           <?php if (!empty($cpnphoto)): ?>
            <ul id="cpnphoto_sortable">
              <?php foreach ($cpnphoto as $key => $value): ?>
                  <li class="ui-state-default">
                    <img src='<?=$value?>'>
                    <input type='hidden' name='photo_sort[]' value='<?=$cpnphoto_id[$key]?>'>
                  </li>
              <?php endforeach; ?>
            </ul>
            <?php endif; ?>
            <input type='hidden' name='typ_n' value='1'>
          </form>
        </div>

        <!--編輯註解區-->
        <div class='switch_cpnphoto' id='cpnphoto_name_edit' style="display:none;">
          <?php if (!empty($cpnphoto)): ?>
            <?echo form_open("/business/photo_edit_note", array('name'=>'form_cpnphoto_edit_note', 'id'=>'form_cpnphoto_edit_note'));?>
              <table style="width:100%;margin-left: 10px;margin-top: 10px;">
                <?php foreach ($cpnphoto as $key => $value): ?>
                  <tr>
                    <td class='edit_photo_box'><img src='<?=$value?>'></td>
                    <td>
                      <input value='<?=$cpnphoto_name[$key]?>' class='edit_photo_name_area iii4' name='photo_name[<?=$cpnphoto_id[$key]?>]' placeholder='照片註解(最多32個字)' maxlength='32'>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </table>
              <input type='hidden' name='typ_n' value='1'>
            </form>
          <?php endif; ?>
        </div>

        <!--移除照片區-->
        <div class='switch_cpnphoto' id='cpnphoto_delete' style="display:none;">
          <span class='introdution_prompt'>請勾選您要從相簿移除的照片</span><input name="clickAll2" id="clickAll2" type="checkbox"><label for='clickAll2'>全選</label>
          <?echo form_open("/business/photo_remove", array('name'=>'form_cpnphoto_remove', 'id'=>'form_cpnphoto_remove'));?>
           <?php if (!empty($cpnphoto)): ?>
            <ul class="cpnphoto_remove">
              <?php foreach ($cpnphoto as $key => $value): ?>
                  <li class="ui-state-default">
                    <label for='cpnphoto_remove_checkbox_<?=$key?>'><img src='<?=$value?>'></label><br><input class='cpnphoto_remove_checkbox' id='cpnphoto_remove_checkbox_<?=$key?>' type='checkbox' name='photo_remove[]' value='<?=$cpnphoto_id[$key]?>'>
                  </li>
              <?php endforeach; ?>
            </ul>
            <?php endif; ?>
            <input type='hidden' name='typ_n' value='1'>
          </form>
        </div>

     </div>  <!--imgUPss  結束-->
        
      <!--切換按鈕-->
      <div class="aaCenter">
        <div class="bottom_button" id='cpnphoto_bottom_button'>
          <input type='button' class='aa6' id='cpnphoto_sort_btn' value='排序照片'>
          <input type='button' class='aa6' id='cpnphoto_edit_btn' value='編輯註解'>
          <input type='button' class='aa6' id='cpnphoto_del_btn' value='移除照片'>
        </div>
        <div class="bottom_button" id='cpnphoto_sort_button' style="display:none;">
            <input type='button' class='aa6' id='cpnphoto_sort_submit' value='儲存排序'>
            <input type='button' class='aa6 cpnphoto_cancle_btn' value='取消'>
        </div>
        <div class="bottom_button" id='cpnphoto_edit_note_button' style="display:none;">
            <input type='button' class='aa6' id='cpnphoto_edit_note_submit' value='儲存照片註解'>
            <input type='button' class='aa6 cpnphoto_cancle_btn' value='取消'>
        </div>
        <div class="bottom_button" id='cpnphoto_remove_button' style="display:none;">
            <input type='button' class='aa6' id='cpnphoto_remove_submit' value='移除所選照片'>
            <input type='button' class='aa6 cpnphoto_cancle_btn' value='取消'>
        </div>
      </div>
                                                  
   </div>  <!--step-imgUP-2 結束--> 
   */?>
   <!-- new -->
   <?php $pnum=0;?>
   <?php foreach($photo_list as $d_id=>$val): ?>
   <?php $pnum+=1;?>
   <div class="step-imgUP-1">
	  
      <?php if ($photo_num[$d_id] == 0): ?>
        <h2><?php echo $val["d_name"];?><?=$NowNoPhoto?></h2>
      <?php else: ?>
        <h2><?php echo $val["d_name"];?> (<?=$All?><?=$photo_num[$d_id]?><?=$Zhang?>)</h2>
      <?php endif; ?>
      <input type='button' class="aa2" id='add_newphoto' d_id='<?php echo $d_id;?>' value='+ <?=$AddPhoto?>'><?php if($pnum==1):?><span class='introdution_prompt' id='msg'><?=$msg?></span><?php endif;?>
      
      <div class="imgUPss">
     
        <!--原始顯示區-->
        <div class='switch_newphoto' id='newphoto_album' d_id="<?php echo $d_id;?>" style="display:none;">

          <?php if (!empty($photo[$d_id])):?>
            <ul id="myphoto_ori">
              <?php foreach ($photo[$d_id] as $key => $value): ?>
                  <li class="ui-state-default">
                    <img src='<?=$value?>'>
                  </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>
        <!--原始顯示區結束-->

        <!--排序區-->
        <div class='switch_newphoto' id='newphoto_sort' d_id="<?php echo $d_id;?>" style="display:none;">
          <span class='introdution_prompt'><?=$FromLeftToRight?></span>
          <?echo form_open("/business/photo_sort", array('name'=>'form_newphoto_sort', 'id'=>'form_newphoto_sort', 'd_id'=>$d_id));?>
           <?php if (!empty($photo[$d_id])): ?>
            <ul id="newphoto_sortable">
              <?php foreach ($photo[$d_id] as $key => $value): ?>
                  <li class="ui-state-default">
                    <img src='<?=$value?>'>
                    <input type='hidden' name='photo_sort[]' value='<?=$photo_id[$d_id][$key]?>'>
                  </li>
              <?php endforeach; ?>
            </ul>
            <?php endif; ?>
            <input type='hidden' name='typ_n' value='<?php echo $d_id;?>'>
          </form>
        </div>

        <!--編輯註解區-->
        <div class='switch_newphoto' id='newphoto_name_edit' d_id="<?php echo $d_id;?>" style="display:none;">
          <?php if (!empty($photo[$d_id])): ?>
            <?echo form_open("/business/photo_edit_note", array('name'=>'form_newphoto_edit_note', 'id'=>'form_newphoto_edit_note', 'd_id'=>$d_id));?>
              <table style="width:100%;margin-left: 10px;margin-top: 10px;">
                <?php foreach ($photo[$d_id] as $key => $value): ?>
                  <tr>
                    <td class='edit_photo_box'><img src='<?=$value?>'></td>
                    <td>
                      <input value='<?=$photo_name[$d_id][$key]?>' class='edit_photo_name_area iii4' name='photo_name[<?=$photo_id[$d_id][$key]?>]' placeholder='<?=$PhotoCaption64words?>' maxlength='64'>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </table>
              <input type='hidden' name='typ_n' value='<?php echo $d_id;?>'>
            </form>
          <?php endif; ?>
        </div>

        <!--移除照片區-->
        <div class='switch_newphoto' id='newphoto_delete' d_id="<?php echo $d_id;?>" style="display:none;">
          <span class='introdution_prompt'><?=$CheckRemovePhoto?></span><input name="clickAll3<?php echo $d_id;?>" id="clickAll3<?php echo $d_id;?>" d_id="<?php echo $d_id;?>" type="checkbox"><label for='clickAll3<?php echo $d_id;?>'><?=$SelectAll?></label>
          <?echo form_open("/business/photo_remove", array('name'=>'form_newphoto_remove', 'id'=>'form_newphoto_remove', 'd_id'=>$d_id));?>
           <?php if (!empty($photo[$d_id])): ?>
            <ul class="newphoto_remove">
              <?php foreach ($photo[$d_id] as $key => $value): ?>
                  <li class="ui-state-default">
                    <label for='remove_checkbox_<?php echo $d_id;?>_<?=$key?>'><img src='<?=$value?>'></label><br><input class='newphoto_remove_checkbox' id='remove_checkbox_<?php echo $d_id;?>_<?=$key?>' d_id="<?php echo $d_id;?>" type='checkbox' name='photo_remove[]' value='<?=$photo_id[$d_id][$key]?>'>
                  </li>
              <?php endforeach; ?>
            </ul>
            <?php endif; ?>
            <input type='hidden' name='typ_n' value='<?php echo $d_id;?>'>
          </form>
        </div>
   
      </div>  <!--imgUPss  結束-->
        
      <!--切換按鈕-->
      <div class="aaCenter">
        <div class="bottom_button" id='newphoto_bottom_button' d_id="<?php echo $d_id;?>">
          <input type='button' class='aa6' id='newphoto_sort_btn' d_id="<?php echo $d_id;?>" value='<?=$SequencePhoto?>'>
          <input type='button' class='aa6' id='newphoto_edit_btn' d_id="<?php echo $d_id;?>" value='<?=$EditAnnotation?>'>
          <input type='button' class='aa6' id='newphoto_del_btn' d_id="<?php echo $d_id;?>" value='<?=$RemovPhoto?>'>
        </div>
        <div class="bottom_button" id='newphoto_sort_button' d_id="<?php echo $d_id;?>" style="display:none;">
            <input type='button' class='aa6' id='newphoto_sort_submit' d_id="<?php echo $d_id;?>" value='<?=$SaveSequence?>'>
            <input type='button' class='aa6 newphoto_cancle_btn' d_id="<?php echo $d_id;?>" value='<?=$Cancle?>'>
        </div>
        <div class="bottom_button" id='newphoto_edit_note_button' d_id="<?php echo $d_id;?>" style="display:none;">
            <input type='button' class='aa6' id='newphoto_edit_note_submit' d_id="<?php echo $d_id;?>" value='<?=$SavePhotoAnnotation?>'>
            <input type='button' class='aa6 newphoto_cancle_btn' d_id="<?php echo $d_id;?>" value='<?=$Cancle?>'>
        </div>
        <div class="bottom_button" id='newphoto_remove_button' d_id="<?php echo $d_id;?>" style="display:none;">
            <input type='button' class='aa6' id='newphoto_remove_submit' d_id="<?php echo $d_id;?>" value='<?=$RemoveSelectePhoto?>'>
            <input type='button' class='aa6 newphoto_cancle_btn' d_id="<?php echo $d_id;?>" value='<?=$Cancle?>'>
        </div>
      </div>
                                      
   </div> 
   <?php endforeach;?>  
   <!-- new end -->
 </div> <!-- 左   結束 --> 
  


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
