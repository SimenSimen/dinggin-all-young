				<section class="content has-side">
					<div class="title"><?=$about['name']?></div>
					<div class="share"><a <? if (!empty($this->session->userdata['isapp'])){?> onclick="getShareEncode3()" class="btn share"<?}else{?> href="/share_link" class="btn share fancybox-share"<?}?>><i class="icon-share2"></i><?=$this->lang['share_link'];?></a></div>
					<div class="editor">
						<?=$about['content']?>
					</div>
					<div class="pagination_box">
                    <a onclick="history.back();" class="btn back"><i class="icon-chevron-left" aria-hidden="true"></i><?=$this->lang['back'];?></a>
                    </div>
				</section>
			</div>
		</main>
						<!--分享彈出窗 JS-->
<script src="/template/temp10/js/baze.modal.js"></script>
<script>
  var elems = $('[data-baze-modal]');
  elems.bazeModal({
      onOpen: function() {
          alert('opened');
      },
      onClose: function() {
          alert('closed');
      }
  });
  $('#ngehe').bazeModal();
$(function() {
  $("#viewimg img").each(function() {//控制文字編輯器的圖不隨RWD變大變小的問題
    var width_txt=($(this).css("width")=="")?"":$(this).css("width");
    var height_txt=($(this).css("height")=="")?"":$(this).css("height");
    $(this).css({"width":"100%","height":"auto","max-width":width_txt,"max-height":height_txt});
    
  });
});
</script>
<script>
$(document).ready(function() {
    $('.fancybox-share').fancybox({
        margin: 5,
        padding: 0,
        width: '100%',
        maxWidth: 650,
        type: 'iframe',
        wrapCSS: 'search',
        helpers : {
            overlay : {
                css : {
                    'background' : 'rgba(0,0,0,0.8)'
                }
            }
        }
    });
});
//APP分享
function getShareEncode3(){
    //alert(navigator.userAgent);
    var val  = 'jecp://ecp_url=<?=$this->share_url?>&ecp_title=<?=$this->lang["$this->DataName"];?>&ecp_img=<?=$this->share_prd_image;?>';
    var i_val = "jecp://<?=$share_prd_image?>&ecp_title=<?=$this->lang["$this->DataName"];?>&ecp_url=<?=$share_url?>";
    if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) {
            location.href = i_val;
    } else if (/(Android)/i.test(navigator.userAgent)) {
            NetNewsAndroidShare.receiveValueFromJs(val);
    };
}
</script>