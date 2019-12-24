<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="content-type" content="text/html;charset=utf-8" />
  <meta name="viewport" content="width=device-width">

  <!-- seo -->
  <title><?=$iqr_name?> 行動商務系統</title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content='行動商務系統'>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>
  <link rel="stylesheet" type="text/css" href="/css/form.css">
  	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="/css/integrate/integrate_003.css" />
  <!--js-->
  
  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
  <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script src="/js/jquery.touchSlider.js"></script>
  <script type="text/javascript" src="/js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="/js/messages_tw.js" charset="utf-8"></script>
	<script type="text/javascript" src="/js/jquery.mask.min.js"></script>

  <!--側欄選單效果-->
  <script type="text/javascript" src="/js/jqmeun/jquery.mmenu.min.all.js"></script> 
  <script type="text/javascript" src="/js/jqmeun/jquery.mmenu.fixedelements.min.js"></script>
  <link type="text/css" rel="stylesheet" href="/js/jqmeun/jquery.mmenu.css" />
  <!--css-->
  <link rel="stylesheet" href="/css/style_area.css">
  
  <!--主題css-->

  <!-- footer -->
  <link type="text/css" rel="stylesheet" href="/css/integrate/integrate_003.css" />
  <link type="text/css" rel="stylesheet" href="/css/activity_info.css">
  
  <!-- user style -->
  <style type="text/css">
    .link {
      max-width: 140px;
      max-height: 140px;
      border: 0;
    }
    /* font color */
    .user_text
    {
      color:<?=$font_color?>;
      font-size:<?=$font_size?>px;
      font-family:"<?=$font_family?>";
    }
    <?php if ($bg_type == 0 || $bg_image_path == ''): ?>
        body, fieldset
        {
          background-color:<?=$bg_color?>;
        }

    <?php elseif($bg_image_path != ''): ?>
        /* 背景圖 */
        body, fieldset
        {
          background:url('<?=$base_url?><?=$bg_image_path?>') no-repeat center 0px;
          -moz-background-size:cover;
          -webkit-background-size:cover;
          -o-background-size:cover;
          background-size:cover;
          background-attachment: fixed;
          background-position: center center;
        }
    <?php endif; ?>
  </style>
<script type="text/javascript">
$(function() {
	$('nav#menu').mmenu({
		extensions	: [ 'effect-slide-menu', 'pageshadow' ],
		navbar 		: {
			title		: '影片分類'
		}
	});
});
</script>
<!--script-->
  
</head>
<script type="text/javascript">
	$(function(){
		// 幫 #qaContent 的 ul 子元素加上 .accordionPart
		// 接著再找出 li 中的第一個 div 子元素加上 .qa_title
		// 並幫其加上 hover 及 click 事件
		// 同時把兄弟元素加上 .qa_content 並隱藏起來
		$('#qaContent ul').addClass('accordionPart').find('li div:nth-child(1)').addClass('qa_title').hover(function(){
			$(this).addClass('qa_title_on');
		}, function(){
			$(this).removeClass('qa_title_on');
		}).click(function(){
			// 當點到標題時，若答案是隱藏時則顯示它，同時隱藏其它已經展開的項目
			// 反之則隱藏
			var $qa_content = $(this).next('div.qa_content');
			if(!$qa_content.is(':visible')){
				$('#qaContent ul li div.qa_content:visible').slideUp();
			}
			$qa_content.slideToggle();
		}).siblings().addClass('qa_content').hide();
	});
</script>

</head> 
<body scroll="yes" style="overflow-x: hidden;">
     
    <div id="header" class="Fixed">
            <div class="header-left" ><a id="hamburger" href="#menu"></a></div>
                <div class="header-logo" onclick="var sharearea = getElementById('sharearea'); sharearea.style.display=sharearea.style.display=='none'?'':'none'">早鳥報名</div>
 <div class="header-right"><a style="cursor:pointer" onclick="var sharearea = getElementById('sharearea'); sharearea.style.display=sharearea.style.display=='none'?'':'none'">
           <img src="/images/apppic/sharebtn.png"></a>
           </div>
                    
		</div><!--header-->
		<?php $this -> load -> view('company/left_1', $data); ?>
    
<div class="index-bill"><!--內容開始-->
  							 <!--分享按鈕 footerstyle.css-->
                <div id="sharearea" class="sharearea" style="display:none;">
                  <table width="100%" bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" id='share_btn_table'>
                    <tr>
                      <td>
                        <p>&nbsp;</p>
                        <p>將此內容分享至：</p>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <table width="100%" height="100" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="center"><!-- fb -->
                              <a href="javascript: void(window.open('http://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href)) ));">
                                <img class='share' id='fb' title="分享到臉書" src="/images/share_btn/facebook_35x35.png" />
                              </a>
                            </td>
                            <td align="center"><!-- weibo -->
                              <a href="javascript:(function(){window.open('http://v.t.sina.com.cn/share/share.php?title='+encodeURIComponent(document.title)+'&url='+encodeURIComponent(location.href)+'&source=bookmark','_blank','width=450,height=400');})()">
                                <img src="/images/share_btn/weibo_35x35.png" name="weibo" class='share' id='weibo' title="分享到微博" />
                              </a>
                            </td>
                            <td align="center"><!-- googleplus -->
                              <a href="javascript: void(window.open('https://plus.google.com/share?url='.concat(encodeURIComponent(location.href)), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));">
                                <img class='share' id='google' title="分享到Google+" src="/images/share_btn/googleplus_35x35.png" />
                              </a>
                            </td>
                            <td align="center"><!-- plurk -->
                              <a href="javascript: void(window.open('http://www.plurk.com/?qualifier=shares&status=' .concat(encodeURIComponent(location.href)) .concat(' ') .concat('&#40;') .concat(encodeURIComponent(document.title)) .concat('&#41;')));">
                                <img class='share' id='plurk' title="分享到Plurk" src="/images/share_btn/plurk_35x35.png" />
                              </a>
                            </td>
                            <td align="center"><!-- twitter -->
                              <a href="javascript: void(window.open('http://twitter.com/home/?status='.concat(encodeURIComponent(document.title)) .concat(' ') .concat(encodeURIComponent(location.href))));">
                                <img class='share' id='twitter' title="分享到Twitter" src="/images/share_btn/twitter_35x35.png" />
                              </a>
                            </td>
                            <td align="center"><!-- line -->
                              <a href="http://line.naver.jp/R/msg/text/?<?=$data['ufm_name']?>%0D%0A<?=$actual_link?>" rel="nofollow" >
                                <img class='share' src="/images/share_btn/line_35x35.png" />
                              </a>
                            </td>
                            <td align="center"><!-- Email -->
                              <a href="mailto:?subject=<?=$data['ufm_name']?>&body=<?=$data['ufm_name']?>網址：<?=$actual_link ?>">
                                <img class='share' src="/images/share_btn/email_35x35.png" />
                              </a>
                            </td>
                          </tr>
                        </table>
                      </td>
  									</tr>
									</table>
                    <div class="sharelocse" style="cursor:pointer" onclick="var sharearea = getElementById('sharearea'); sharearea.style.display=sharearea.style.display=='none'?'':'none'">
                      <br /> close area
                    </div>
                </div>
         <!--分享按鈕-->
     <table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td align="center" height="50" ></td>
           </tr>
           <tr>
             <td align="center"><br />
               <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                 <tr>
                  <td>
                   <?=$data['ufm_name']?>
                   <br />
                  </td>
                 </tr>
                 <tr>
                   <td colspan="2" align="center"><p>&nbsp;</p>
                     <p><br />
                     </p>
                     <table width="90%" border="0" cellspacing="3" cellpadding="0">
                       <tr>
                         <td></td>
                       </tr>
                       <tr>
                         <td colspan="2"> <!--圖文編輯器內容-->
                         	<?=$data['ufm_aim']?>
                         </td><!--圖文編輯器內容-->
                       </tr>
                      <tr>
                        <td colspan="2">
                          <fieldset>
                          <!-- <legend> <?=$data['ufm_name']?></legend>-->
                            <form action='/company/signup/0' method='post' name='bottom_form' id='bottom_form'>
                              <div class="BusinessC_reg">
                                <div>
                                  <span class='red_star'>*</span><?=$ufm_title[0]?>
                                </div>
                                <div>
                                  <input type='text' name='name_r' id='u_name' class="required form-control" minlength="2" maxlength="16">
                                </div>
                                <div>
                                  <span class='red_star'>*</span><?=$ufm_title[1]?>
                                </div>
                                <div>
                                  <input type='text' name='mphone_r' id='u_mphone' class="required number form-control" minlength="10" maxlength="10">
                                </div>
                                <div>
                                  <span class='red_star'>*</span><?=$ufm_title[2]?>
                                </div>
                                <div>
                                  <input type='text' name='email_r' id='u_email' class="required email form-control" maxlength="255">
                                </div>
                                <?php if (!empty($ufm_title) && count($ufm_title) > 3): ?>
                                  <?php foreach ($ufm_title as $key => $value): ?>
                                    <?php if ($key > 2): ?>
                                      <?php $index=($key-3);?>
                                      <div>
                                        <div>
                                          <?=$ufm_required_star[$index]?><?=$value?>
                                        </div>
                                        <div>
                                          <?php if ($ufm_content[$index][0] == 2): ?>
                                            <!-- <span>text</span> -->
                                            <input type='text' class='form-control <?=$ufm_required[$index]?>' name='customerInput[<?=$key?>]' value=''>
                                          <?php elseif ($ufm_content[$index][0] == 1): ?>
                                            <!-- <span>date</span> -->
                                            <input type='text' class="form-control datepicker <?=$ufm_required[$index]?>" name='customerInput[<?=$key?>]' readonly="true" style='display: inline; width: 338px;' placeholder='請點選右側圖示選取日期'>
                                          <?php elseif ($ufm_content[$index][0] == 6): ?>
                                            <!-- <span>number</span> -->
                                            <input type='number' class='form-control <?=$ufm_required[$index]?> number' name='customerInput[<?=$key?>]' value=''>
                                          <?php else: ?>
                                            multi
                                              <?php if ($ufm_content[$index][0] == 3): ?>
                                                單選
                                                <?php foreach ($ufm_content[$index] as $content_key => $content_value): ?>
                                                  <?php if ($content_key > 0): ?>
                                                    <label><input type='radio' class="form-control <?=$ufm_required[$index]?>" name='customerInput[<?=$key?>]' style='display: inline; width: 20px; margin-right: 5px;' value='<?=$content_key?>'><?=$content_value?></label>
                                                  <?php endif; ?>
                                                <?php endforeach; ?>

                                              <?php elseif ($ufm_content[$index][0] == 4): ?>

                                                下拉
                                                <select class="form-control <?=$ufm_required[$index]?>" name='customerInput[<?=$key?>]' style='width: 338px;'>
                                                  <option value=''>請選擇</option>
                                                  <?php foreach ($ufm_content[$index] as $content_key => $content_value): ?>
                                                    <?php if ($content_key > 0): ?>
                                                      <option value='<?=$content_key?>'><?=$content_value?></option>
                                                    <?php endif; ?>
                                                  <?php endforeach; ?>
                                                </select>

                                              <?php else: ?>

                                                複選
                                                <?php foreach ($ufm_content[$index] as $content_key => $content_value): ?>
                                                  <?php if ($content_key > 0): ?>
                                                    <p><input type='checkbox' class="form-control <?=$ufm_required[$index]?>" name='customerInput[<?=$key?>][]' style='display: inline; width: 20px; margin-right: 5px;' value='<?=$content_key?>'><?=$content_value?></p>
                                                  <?php endif; ?>
                                                <?php endforeach; ?>

                                              <?php endif; ?>

                                          <?php endif; ?>
                                          
                                        </div>
                                      </div>
                                    <?php endif; ?>
                                  <?php endforeach; ?>
                                  <?php endif; ?>
                      	    	<!-- <table border='0' id='form_table'>
                                <tr>
                                  <td style="white-space: nowrap;" class='right_td'>
                                    <span class='red_star'>*</span><?=$ufm_title[0]?>
                                  </td>
                                  <td style="white-space: nowrap;">
                                    <input type='text' name='name_r' id='u_name' class="required form-control" minlength="2" maxlength="16">
                                  </td>
                                </tr>
                                <tr>
                                  <td class='right_td'>
                                    <span class='red_star'>*</span><?=$ufm_title[1]?>
                                  </td>
                                  <td>
                                    <input type='text' name='mphone_r' id='u_mphone' class="required number form-control" minlength="10" maxlength="10">
                                  </td>
                                </tr>
                                <tr>
                                  <td class='right_td'>
                                    <span class='red_star'>*</span><?=$ufm_title[2]?>
                                  </td>
                                  <td>
                                    <input type='text' name='email_r' id='u_email' class="required email form-control" maxlength="255">
                                  </td>
                                </tr>
                                  <?php if (!empty($ufm_title) && count($ufm_title) > 3): ?>
                                  <?php foreach ($ufm_title as $key => $value): ?>
                                    <?php if ($key > 2): ?>
                                      <?php $index=($key-3);?>
                                      <tr>
                                        <td class='right_td' style="word-break:break-all; width: 100px;">
                                          <?=$ufm_required_star[$index]?><?=$value?>
                                        </td>
                                        <td>
                                          <?php if ($ufm_content[$index][0] == 2): ?>
                                            text<input type='text' class='form-control <?=$ufm_required[$index]?>' name='customerInput[<?=$key?>]' value=''>
                                          <?php elseif ($ufm_content[$index][0] == 1): ?>
                                            date<input type='text' class="form-control datepicker <?=$ufm_required[$index]?>" name='customerInput[<?=$key?>]' readonly="true" style='display: inline; width: 338px;' placeholder='請點選右側圖示選取日期'>
                                          <?php elseif ($ufm_content[$index][0] == 6): ?>
                                            number<input type='number' class='form-control <?=$ufm_required[$index]?> number' name='customerInput[<?=$key?>]' value=''>
                                          <?php else: ?>
                                            multi
                                              <?php if ($ufm_content[$index][0] == 3): ?>
                                                單選
                                                <?php foreach ($ufm_content[$index] as $content_key => $content_value): ?>
                                                  <?php if ($content_key > 0): ?>
                                                    <p><input type='radio' class="form-control <?=$ufm_required[$index]?>" name='customerInput[<?=$key?>]' style='display: inline; width: 20px; margin-right: 5px;' value='<?=$content_key?>'><?=$content_value?></p>
                                                  <?php endif; ?>
                                                <?php endforeach; ?>

                                              <?php elseif ($ufm_content[$index][0] == 4): ?>

                                                下拉
                                                <select class="form-control <?=$ufm_required[$index]?>" name='customerInput[<?=$key?>]' style='width: 338px;'>
                                                  <option value=''>請選擇</option>
                                                  <?php foreach ($ufm_content[$index] as $content_key => $content_value): ?>
                                                    <?php if ($content_key > 0): ?>
                                                      <option value='<?=$content_key?>'><?=$content_value?></option>
                                                    <?php endif; ?>
                                                  <?php endforeach; ?>
                                                </select>

                                              <?php else: ?>

                                                複選
                                                <?php foreach ($ufm_content[$index] as $content_key => $content_value): ?>
                                                  <?php if ($content_key > 0): ?>
                                                    <p><input type='checkbox' class="form-control <?=$ufm_required[$index]?>" name='customerInput[<?=$key?>][]' style='display: inline; width: 20px; margin-right: 5px;' value='<?=$content_key?>'><?=$content_value?></p>
                                                  <?php endif; ?>
                                                <?php endforeach; ?>

                                              <?php endif; ?>

                                          <?php endif; ?>
                                          
                                        </td>
                                      </tr>
                                    <?php endif; ?>
                                  <?php endforeach; ?>
                                  <?php endif; ?>
                                <tr>
                                  <td colspan="2" align="center">
                                    <input type='hidden' name='base' value='<?=$base?>'>
                                    <input type='hidden' name='ufm_id' value='<?=$id?>'>
                                    <input type='hidden' name='member_id' value='<?=$member_id?>'>
                                    <input type='hidden' name='ufm_col_num' value='<?=$uform['ufm_col_num']?>'>
                                    <input type='submit' class="goow" name='send' id='send' value='送　出' style="font-size: 24px; height: 46px; width: 200px;">
                                  </td>
                                  <td align="right"><input type='submit' class="goow" name='send' id='send' value='重 設' style="font-size: 24px; height: 46px; width: 200px;"></td>
                                </tr>
                              </table> -->
                    			  <input type='hidden' name='base' value='<?=$base?>'>
                            <input type='hidden' name='ufm_id' value='<?=$id?>'>
                            <input type='hidden' name='member_id' value='<?=$member_id?>'>
                            <input type='hidden' name='ufm_col_num' value='<?=$uform['ufm_col_num']?>'>
                            <input type='submit' class="goow" name='send' id='send' value='送　出' style="font-size: 24px; margin: 20px;">
                              </div>
                      			</form>
                          </fieldset>
                        </td>
                       </tr>
                     </table>
                     <p><br />
                       <br />
                   </p></td>
                 </tr>
             </table>
             </td>
           </tr>
             <tr>
               <td >&nbsp;
               </td>
                   </tr>
         </table>
   			  <!--確保下方內容被看見-->
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td height="55" align="center" >&nbsp;</td>
           </tr>
           </table><!--確保下方內容被看見-->
       </div>
     <!--index-bill-->


<!--分享按鈕圖層閉合-->
<script type="text/javascript" language="javascript">
    function showHide() {
        $('.sharearea').css('display', 'block');
    }
	function Hideshow() {
        $('.sharearea').css('display', 'none');
    }
	 $(document).ready( function(){
            $('#bottom_form').validate({
		        success: function(label) {
		            label.addClass("success").text("");
		        }
		    });

		    $('#u_mphone').mask('0000000000');

		    $.datepicker.regional['zh-TW']={
				dayNames:["星期日","星期一","星期二","星期三","星期四","星期五","星期六"],
				dayNamesMin:["日","一","二","三","四","五","六"],
				monthNames:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
				monthNamesShort:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
				prevText:"上月",
				nextText:"次月",
				weekHeader:"週",
				dateFormat:"yy-mm-dd"
			};
			$.datepicker.setDefaults($.datepicker.regional["zh-TW"]);
			$(".datepicker").datepicker({
				showOtherMonths: true, 
				selectOtherMonths: true,
				showOn: "button",
				buttonImage: "/images/calendar.png",
			    buttonImageOnly: true,
			    buttonText: '日期',
			    changeMonth: true,
      			changeYear: true, 
      			yearRange:"1911:+10"
			});

        });
	
</script>

</body>

<!-- Mirrored from i-qrcode.org/business/style_view/5 by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 02 Jun 2015 06:40:32 GMT -->
</html>