$(function(){

  //開啟新增附件視窗
  $('#add_exfile').click(function(){
    window.open('/business/exfile_tab/0', '新增附件', config='height=500,width=750,left=300,top=50,resizable=yes,scrollbar=yes,scrollbars=1');
  });
  setTimeout("$('#msg').fadeOut()", 1500);
  
  //切換區
  //exfile
  //原始顯示區 exfile_view
  //排序附件區 exfile_sort
  //編輯附件區 exfile_name_edit
  //移除附件區 exfile_delete

  //uform
  //原始顯示區 uform_view
  //排序附件區 uform_sort
  //編輯附件區 uform_name_edit
  //移除附件區 uform_delete

  //當進入附件管理顯示原始顯示區
  $('#exfile_view').toggle();

  //exfile
  //按下取消
  $('.exfile_cancel_btn').click(function(){
    $('.switch_exfile').hide();
    $('#add_exfile').toggle();
    $('#exfile_view').toggle();
    $('#exfile_bottom_button').toggle();
    $('#exfile_sort_button').hide();
    $('#exfile_edit_note_button').hide();
    $('#exfile_remove_button').hide();
  });
  //按下排序附件
  $('#exfile_sort_btn').click(function(){
    $('.switch_exfile').hide();
    $('#add_exfile').toggle();
    $('#exfile_sort').toggle();
    $('#exfile_bottom_button').toggle();
    $('#exfile_sort_button').show();
    $('#exfile_edit_note_button').hide();
    $('#exfile_remove_button').hide();
  });
  //按下編輯附件按鈕名稱
  $('#exfile_edit_btn').click(function(){
    $('.switch_exfile').hide();
    $('#add_exfile').toggle();
    $('#exfile_name_edit').toggle();
    $('#exfile_bottom_button').toggle();
    $('#exfile_sort_button').hide();
    $('#exfile_edit_note_button').show();
    $('#exfile_remove_button').hide();
  });
  //按下移除附件
  $('#exfile_del_btn').click(function(){
    $('.switch_exfile').hide();
    $('#add_exfile').toggle();
    $('#exfile_delete').toggle();
    $('#exfile_bottom_button').toggle();
    $('#exfile_sort_button').hide();
    $('#exfile_edit_note_button').hide();
    $('#exfile_remove_button').show();
  });

  //sortable
  $( "#exfile_sortable" ).sortable();
  $('#exfile_sort_submit').click(function(){
    $('#form_exfile_sort').submit();
  });

  //edit_note
  $('#exfile_edit_note_submit').click(function(){
    $('#form_exfile_edit_btn_name').submit();
  });
  //remove
  $('#exfile_remove_submit').click(function(){
    $('#form_exfile_remove').submit();
  });
  $('#remove_table tr').click(function(event) {
      if (event.target.type !== 'checkbox') {
          $(':checkbox', this).trigger('click');
      }
  });

  //全選與全不選
  $("#clickAll").click(function() {
     if($("#clickAll").prop("checked"))
     {
       $(".exfile_remove").each(function() {
          $(this).prop("checked", true);
          $(this).closest('tr').removeClass("normal");  
          $(this).closest('tr').addClass("green"); 
       });
     }
     else
     {
       $(".exfile_remove").each(function() {
          $(this).prop("checked", false);
          $(this).closest('tr').removeClass("green");  
          $(this).closest('tr').addClass("normal"); 
       });       
     }
  });

  //選取附件變色
  $('.exfile_remove').each(function(){
    $(this).change(function(){
      if($(this).is(":checked")){
        $(this).closest('tr').removeClass("normal");  
        $(this).closest('tr').addClass("green"); 
      }else{
        $(this).closest('tr').removeClass("green");  
        $(this).closest('tr').addClass("normal"); 
      }
    });
  });
});