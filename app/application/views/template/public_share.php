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
		  <table width="100%" height="100" border="0" align="center" cellpadding="0" cellspacing="0"  onclick="var sharearea = getElementById('sharearea'); sharearea.style.display=sharearea.style.display=='none'?'':'none'">
			<tr>
			  <td>
				<td align="center">
				  <a href="javascript: void(window.open('https://www.facebook.com/share.php?u=<?=$public_share_url?>'));">
					<img class='share' id='fb' title="分享到臉書" src="/images/share_btn/facebook_35x35.png" />
				  </a>
				</td>
				<td align="center">
				  <a href="javascript:(function(){window.open('https://v.t.sina.com.cn/share/share.php?title=<?=$public_share_title?>&url=<?=$public_share_url?>&source=bookmark','_blank','width=450,height=400');})()">
					<img src="/images/share_btn/weibo_35x35.png" name="weibo" class='share' id='weibo' title="分享到微博" />
				  </a>
				</td>
				<td align="center">
				  <a href="javascript: void(window.open('https://plus.google.com/share?url=<?=$public_share_url?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));">
					<img class='share' id='google' title="分享到Google+" src="/images/share_btn/googleplus_35x35.png" />
				  </a>
				</td>
				<td align="center">
				  <a href="javascript: void(window.open('https://www.plurk.com/?qualifier=shares&status=<?=$public_share_url?>' .concat(' ') .concat('&#40;') <?=$public_share_title?> .concat('&#41;')));">
					<img class='share' id='plurk' title="分享到Plurk" src="/images/share_btn/plurk_35x35.png" />
				  </a>
				</td>
				<td align="center">
				  <a href="javascript: void(window.open('https://twitter.com/home/?status=<?=$public_share_title?>' .concat(' ') <?=$public_share_url?>));">
					<img class='share' id='twitter' title="分享到Twitter" src="/images/share_btn/twitter_35x35.png" />
				  </a>
				</td>
				<td align="center">
				  <a href="https://line.naver.jp/R/msg/text/?<?=$public_share_title?>%0D%0A<?=$public_share_url?>" rel="nofollow" >
					<img class='share' src="/images/share_btn/line_35x35.png" />
				  </a>
				</td>
				<td align="center">
				  <a href="whatsapp://send?text=<?=$public_share_title?> <?=$public_share_url?>" data-action="share/whatsapp/share">
					<img class='share' src="/images/share_btn/whatsApp_35x35.png" />
				  </a>
				</td>
				<td align="center">
				  <a href="mailto:?subject=<?=$public_share_title?>&body=<?=$public_share_title?>網址：<?=$public_share_url?>">
					<img class='share' src="/images/share_btn/email_35x35.png" />
				  </a>
				</td>   
			  </td>
			</tr>
		  </table>
		</td>
	  </tr>
	</table>
	<!--關閉分享區塊-->
	<div class="sharelocse" onclick="var sharearea = getElementById('sharearea'); sharearea.style.display=sharearea.style.display=='none'?'':'none'">
	  <br /> close area
	  </div>
	</div>
     <script>
    $(document).ready(function() {
	 $("div[id='head_share_buttom']").click(function(){
		<? if ($get_device_type>=1){ ?>
			getShareEncode2($(this).attr("ref"));
		<? }else{?>
			var sharearea = document.getElementById('sharearea'); 
			sharearea.style.display=sharearea.style.display=='none'?'':'none';
		<? } ?>
	 });
    });
    function getShareEncode2(val){
            var i_val = "jecp://"+val.substr(12);
            if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) {
//				alert(i_val);
                location.href = i_val;
            } else if (/(Android)/i.test(navigator.userAgent)) {
//				alert(val);
                NetNewsAndroidShare.receiveValueFromJs(val);
            } else {
            };
     }

    </script>
						
