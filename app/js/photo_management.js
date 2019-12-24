$(function()
{
  //開啟新增形象圖視窗
 /* $('#add_myphoto').click(function(){
    window.open('/business/photo_tab/0/0', '新增形象圖', config='height=500,width=800,left=290,top=50,resizable=yes,scrollbar=yes,scrollbars=1');
  });
  $('#add_cpnphoto').click(function(){
    window.open('/business/photo_tab/1/0', '新增公司照片', config='height=500,width=800,left=290,top=50,resizable=yes,scrollbar=yes,scrollbars=1');
  }); */
  $('input[id="add_newphoto"]').click(function(){
	    window.open('/business/photo_tab_new/'+$(this).attr("d_id")+'/0', '新增形象圖', config='height=500,width=800,left=290,top=50,resizable=yes,scrollbar=yes,scrollbars=1');
  });
  setTimeout("$('#msg').fadeOut()", 1500);
  
  //切換區
  //原始顯示區 myphoto_album
  //排序區     myphoto_sort
  //編輯註解區 myphoto_name_edit
  //移除照片區 myphoto_delete

/*  $('#myphoto_album').toggle();//當進入相簿管理顯示原始顯示區
  //按下取消
  $('.myphoto_cancle_btn').click(function(){
    $('.switch_myphoto').hide();
    $('#add_myphoto').toggle();
    $('#myphoto_album').toggle();
    $('#bottom_button').toggle();
    $('#sort_button').hide();
    $('#edit_note_button').hide();
    $('#remove_button').hide();
  });
  //按下排序形象圖
  $('#myphoto_sort_btn').click(function(){
    $('.switch_myphoto').hide();
    $('#add_myphoto').toggle();
    $('#myphoto_sort').toggle();
    $('#bottom_button').toggle();
    $('#sort_button').show();
    $('#edit_note_button').hide();
    $('#remove_button').hide();
  });
  //按下編輯形象圖註解
  $('#myphoto_edit_btn').click(function(){
    $('.switch_myphoto').hide();
    $('#add_myphoto').toggle();
    $('#myphoto_name_edit').toggle();
    $('#bottom_button').toggle();
    $('#sort_button').hide();
    $('#edit_note_button').show();
    $('#remove_button').hide();
  });
  //按下移除形象圖
  $('#myphoto_del_btn').click(function(){
    $('.switch_myphoto').hide();
    $('#add_myphoto').toggle();
    $('#myphoto_delete').toggle();
    $('#bottom_button').toggle();
    $('#sort_button').hide();
    $('#edit_note_button').hide();
    $('#remove_button').show();
  });

  //sortable
  $( "#myphoto_sortable" ).sortable();
  $( "#cpnphoto_sortable" ).sortable();*/
  $( "ul[id='newphoto_sortable']" ).sortable();
  /*$('#myphoto_sort_submit').click(function(){
    $('#form_myphoto_sort').submit();
  });
  $('#cpnphoto_sort_submit').click(function(){
    $('#form_cpnphoto_sort').submit();
  });*/
  $('input[id="newphoto_sort_submit"]').click(function(){
	    $('form[id="form_newphoto_sort"][d_id="'+$(this).attr("d_id")+'"]').submit();
  });
  
  //edit_note
/*  $('#myphoto_edit_note_submit').click(function(){
    $('#form_myphoto_edit_note').submit();
  });
  $('#cpnphoto_edit_note_submit').click(function(){
    $('#form_cpnphoto_edit_note').submit();
  });*/
  $('input[id="newphoto_edit_note_submit"]').click(function(){
	    $('form[id="form_newphoto_edit_note"][d_id="'+$(this).attr("d_id")+'"]').submit();
  });
  //remove
 /* $('#myphoto_remove_submit').click(function(){
    $('#form_myphoto_remove').submit();
  });
  $('#cpnphoto_remove_submit').click(function(){
    $('#form_cpnphoto_remove').submit();
  });*/
  $('input[id="newphoto_remove_submit"]').click(function(){
	    $('form[id="form_newphoto_remove"][d_id="'+$(this).attr("d_id")+'"]').submit();
  });
  //全選與全不選
/*  $("#clickAll").click(function() {
     if($("#clickAll").prop("checked"))
     {
       $(".myphoto_remove_checkbox").each(function() {
          $(this).prop("checked", true);
          $('.myphoto_remove_checkbox').parent().removeClass("myphoto_remove");  
          $('.myphoto_remove_checkbox').parent().addClass("myphoto_remove_chk"); 
       });
     }
     else
     {
       $(".myphoto_remove_checkbox").each(function() {
          $(this).prop("checked", false);
          $('.myphoto_remove_checkbox').parent().removeClass("myphoto_remove_chk");  
          $('.myphoto_remove_checkbox').parent().addClass("myphoto_remove"); 
       });           
     }
  });

  $("#clickAll2").click(function() {
     if($("#clickAll2").prop("checked"))
     {
       $(".cpnphoto_remove_checkbox").each(function() {
          $(this).prop("checked", true);
          $('.cpnphoto_remove_checkbox').parent().removeClass("cpnphoto_remove");  
          $('.cpnphoto_remove_checkbox').parent().addClass("cpnphoto_remove_chk"); 
       });
     }
     else
     {
       $(".cpnphoto_remove_checkbox").each(function() {
          $(this).prop("checked", false);
          $('.cpnphoto_remove_checkbox').parent().removeClass("cpnphoto_remove_chk");  
          $('.cpnphoto_remove_checkbox').parent().addClass("cpnphoto_remove"); 
       });           
     }
  });*/
  $("input[id^='clickAll3']").click(function() {
	     if($(this).prop("checked"))
	     {
	       $(".newphoto_remove_checkbox[d_id='"+$(this).attr("d_id")+"']").each(function() {
	          $(this).prop("checked", true);
	          $('.newphoto_remove_checkbox[d_id="'+$(this).attr("d_id")+'"]').parent().removeClass("newphoto_remove");  
	          $('.newphoto_remove_checkbox[d_id="'+$(this).attr("d_id")+'"]').parent().addClass("newphoto_remove_chk"); 
	       });
	     }
	     else
	     {
	       $(".newphoto_remove_checkbox[d_id='"+$(this).attr("d_id")+"']").each(function() {
	          $(this).prop("checked", false);
	          $('.newphoto_remove_checkbox[d_id="'+$(this).attr("d_id")+'"]').parent().removeClass("newphoto_remove_chk");  
	          $('.newphoto_remove_checkbox[d_id="'+$(this).attr("d_id")+'"]').parent().addClass("newphoto_remove"); 
	       });           
	     }
	  });

  //選取照片變色
 /* $('.myphoto_remove_checkbox').each(function(){
    $(this).change(function(){
      if($(this).is(":checked")){
        $(this).parent().removeClass("myphoto_remove");  
        $(this).parent().addClass("myphoto_remove_chk"); 
      }else{
        $(this).parent().removeClass("myphoto_remove_chk");  
        $(this).parent().addClass("myphoto_remove"); 
      }
    });
  });
  $('.cpnphoto_remove_checkbox').each(function(){
    $(this).change(function(){
      if($(this).is(":checked")){
        $(this).parent().removeClass("cpnphoto_remove");  
        $(this).parent().addClass("cpnphoto_remove_chk"); 
      }else{
        $(this).parent().removeClass("cpnphoto_remove_chk");  
        $(this).parent().addClass("cpnphoto_remove"); 
      }
    });
  });*/
  $('.newphoto_remove_checkbox').each(function(){
	    $(this).change(function(){
	      if($(this).is(":checked")){
	        $(this).parent().removeClass("newphoto_remove");  
	        $(this).parent().addClass("newphoto_remove_chk"); 
	      }else{
	        $(this).parent().removeClass("newphoto_remove_chk");  
	        $(this).parent().addClass("newphoto_remove"); 
	      }
	    });
	  });

  //公司照片
 /* $('#cpnphoto_album').toggle();//當進入相簿管理顯示原始顯示區

  //按下取消
  $('.cpnphoto_cancle_btn').click(function(){
    $('.switch_cpnphoto').hide();
    $('#add_cpnphoto').toggle();
    $('#cpnphoto_album').toggle();
    $('#cpnphoto_bottom_button').toggle();
    $('#cpnphoto_sort_button').hide();
    $('#cpnphoto_edit_note_button').hide();
    $('#cpnphoto_remove_button').hide();
  });
  //按下排序形象圖
  $('#cpnphoto_sort_btn').click(function(){
    $('.switch_cpnphoto').hide();
    $('#add_cpnphoto').toggle();
    $('#cpnphoto_sort').toggle();
    $('#cpnphoto_bottom_button').toggle();
    $('#cpnphoto_sort_button').show();
    $('#cpnphoto_edit_note_button').hide();
    $('#cpnphoto_remove_button').hide();
  });
  //按下編輯形象圖註解
  $('#cpnphoto_edit_btn').click(function(){
    $('.switch_cpnphoto').hide();
    $('#add_cpnphoto').toggle();
    $('#cpnphoto_name_edit').toggle();
    $('#cpnphoto_bottom_button').toggle();
    $('#cpnphoto_sort_button').hide();
    $('#cpnphoto_edit_note_button').show();
    $('#cpnphoto_remove_button').hide();
  });
  //按下移除形象圖
  $('#cpnphoto_del_btn').click(function(){
    $('.switch_cpnphoto').hide();
    $('#add_cpnphoto').toggle();
    $('#cpnphoto_delete').toggle();
    $('#cpnphoto_bottom_button').toggle();
    $('#cpnphoto_sort_button').hide();
    $('#cpnphoto_edit_note_button').hide();
    $('#cpnphoto_remove_button').show();
  });*/

  //new照片
  $('div[id="newphoto_album"]').toggle();//當進入相簿管理顯示原始顯示區
  //按下取消
  $('.newphoto_cancle_btn').click(function(){
      $('.switch_newphoto[d_id="'+$(this).attr("d_id")+'"]').hide();
      $('input[id="add_newphoto"][d_id="'+$(this).attr("d_id")+'"]').toggle();
      $('div[id="newphoto_album"][d_id="'+$(this).attr("d_id")+'"]').toggle();
      $('div[id="newphoto_bottom_button"][d_id="'+$(this).attr("d_id")+'"]').toggle();
      $('div[id="newphoto_sort_button"][d_id="'+$(this).attr("d_id")+'"]').hide();
      $('div[id="newphoto_edit_note_button"][d_id="'+$(this).attr("d_id")+'"]').hide();
      $('div[id="newphoto_remove_button"][d_id="'+$(this).attr("d_id")+'"]').hide();
  });
  //按下排序形象圖
  $('input[id="newphoto_sort_btn"]').click(function(){
	  $('.switch_newphoto[d_id="'+$(this).attr("d_id")+'"]').hide();
	  $('input[id="add_newphoto"][d_id="'+$(this).attr("d_id")+'"]').toggle();
	  $('div[id="newphoto_sort"][d_id="'+$(this).attr("d_id")+'"]').toggle();
	  $('div[id="newphoto_bottom_button"][d_id="'+$(this).attr("d_id")+'"]').toggle();
	  $('div[id="newphoto_sort_button"][d_id="'+$(this).attr("d_id")+'"]').show();
	  $('div[id="newphoto_edit_note_button"][d_id="'+$(this).attr("d_id")+'"]').hide();
	  $('div[id="newphoto_remove_button"][d_id="'+$(this).attr("d_id")+'"]').hide();
  });
  //按下編輯形象圖註解
  $('input[id="newphoto_edit_btn"]').click(function(){
	  $('.switch_newphoto[d_id="'+$(this).attr("d_id")+'"]').hide();
	  $('input[id="add_newphoto"][d_id="'+$(this).attr("d_id")+'"]').toggle();
	  $('div[id="newphoto_name_edit"][d_id="'+$(this).attr("d_id")+'"]').toggle();
	  $('div[id="newphoto_bottom_button"][d_id="'+$(this).attr("d_id")+'"]').toggle();
	  $('div[id="newphoto_sort_button"][d_id="'+$(this).attr("d_id")+'"]').hide();
	  $('div[id="newphoto_edit_note_button"][d_id="'+$(this).attr("d_id")+'"]').show();
	  $('div[id="newphoto_remove_button"][d_id="'+$(this).attr("d_id")+'"]').hide();
  });
  //按下移除形象圖
  $('input[id="newphoto_del_btn"]').click(function(){
	  $('.switch_newphoto[d_id="'+$(this).attr("d_id")+'"]').hide();
	  $('input[id="add_newphoto"][d_id="'+$(this).attr("d_id")+'"]').toggle();
	  $('div[id="newphoto_delete"][d_id="'+$(this).attr("d_id")+'"]').toggle();
	  $('div[id="newphoto_bottom_button"][d_id="'+$(this).attr("d_id")+'"]').toggle();
	  $('div[id="newphoto_sort_button"][d_id="'+$(this).attr("d_id")+'"]').hide();
	  $('div[id="newphoto_edit_note_button"][d_id="'+$(this).attr("d_id")+'"]').hide();
	  $('div[id="newphoto_remove_button"][d_id="'+$(this).attr("d_id")+'"]').show();
  });
});