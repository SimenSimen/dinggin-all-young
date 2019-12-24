$(function(){

  //開啟新增報名表單視窗
  $('#add_uform').click(function(){
    window.open('/business/uform_add', '新增報名表單', config='height=500,width=750,left=300,top=50,resizable=yes,scrollbar=yes,scrollbars=1');
  });
  //開啟報名表單qrcode視窗
  $('.sign_up_page').click(function(){
    window.open('/form/view_qrcode/'+$(this).attr('id').substr(1), '報名表單連結', config='height=616,width=420,left=470');
  });
  //開啟編輯報名表單視窗
  $('.edit_page').click(function(){
    window.open('/business/uform_edit/'+$(this).attr('id').substr(2), '編輯報名表單', config='height=500,width=750,left=300,top=50,resizable=yes,scrollbar=yes,scrollbars=1');
  });
  //開啟編輯報名表單視窗
  $('.copy_page').click(function(){
    window.open('/business/uform_copy/'+$(this).attr('id').substr(2), '複製報名表單', config='height=500,width=750,left=300,top=50,resizable=yes,scrollbar=yes,scrollbars=1');
  });
  //彈出報名情形
  $('.sign_up').click(function(){
    window.open('/business/uform_sign_up_show/'+$(this).attr('id')+'/'+$('#mid').val(), '報名情況', config='height=500,width=770,left=300,top=50,resizable=yes,scrollbar=yes,scrollbars=1');
  });
  // 開啟新增報名表單分類視窗
  $('#add_uform_category').click(function () {
    window.open('/business/uform_category_add', '新增分類類別', config='height=200,width=750,left=300,top=50,resizable=no,scrollbar=yes,scrollbars=1');
  });
  // 開啟修改報名表單分類視窗
  $('.edit_category').click(function () {
      window.open('/business/uform_category_edit/' + $(this).attr('id'), '修改分類類別', config='height=200,width=750,left=300,top=50,resizable=no,scrollbar=yes,scrollbars=1')
  });
  $('.del_category').click(function () {
    var name = $('#del_mid_' + $(this).attr('id'));
    if(confirm('確定要刪除【'+ name.attr('title') + '】分類 ?'))
    {
      $.ajax({
        url:  '/business/uform_category_del',
        type: 'post',
        async: false,
        cache: false,
        data:{
          cid: $(this).attr('id'),
          member_id: name.val()
        },
        error: function() {
        },
        success: function(response) {
          if(response)
            alert('刪除成功');
          else
            alert('刪除失敗');
          window.location.reload();
        }
      });
    }
  });

  setTimeout("$('#msg').fadeOut()", 1500);
  
  //切換區
  //exfile
  //原始顯示區 view
  //排序附件區 sort
  //編輯附件區 name_edit
  //移除附件區 delete

  //uform
  //原始顯示區 uform_view
  //排序附件區 uform_sort
  //編輯附件區 uform_name_edit
  //移除附件區 uform_delete

  //當進入附件管理顯示原始顯示區
  $('#uform_view').show();

  //uform
  //按下取消
  $('.uform_cancel_btn').click(function(){
    $('.switch_uform').hide();
    $('#add_uform').toggle();
    $('#uform_view').toggle();
    $('#bottom_uform_button').toggle();
    $('#uform_sort_button').hide();
    $('#uform_edit_note_button').hide();
    $('#uform_remove_button').hide();
  });
  //按下排序附件
  $('#uform_sort_btn').click(function(){
    $('.switch_uform').hide();
    $('#add_uform').toggle();
    $('#uform_sort').toggle();
    $('#bottom_uform_button').toggle();
    $('#uform_sort_button').show();
    $('#uform_edit_note_button').hide();
    $('#uform_remove_button').hide();
  });
  //按下編輯附件按鈕名稱
  $('#uform_edit_btn').click(function(){
    $('.switch_uform').hide();
    $('#add_uform').toggle();
    $('#uform_name_edit').toggle();
    $('#bottom_uform_button').toggle();
    $('#uform_sort_button').hide();
    $('#uform_edit_note_button').show();
    $('#uform_remove_button').hide();
  });
  //按下移除附件
  $('#uform_del_btn').click(function(){
    $('.switch_uform').hide();
    $('#add_uform').toggle();
    $('#uform_delete').toggle();
    $('#bottom_uform_button').toggle();
    $('#uform_sort_button').hide();
    $('#uform_edit_note_button').hide();
    $('#uform_remove_button').show();
  });

  //sortable
  $( "#uform_sortable" ).sortable();
  $('#uform_sort_submit').click(function(){
    $('#form_uform_sort').submit();
  });

  //edit_note
  $('#uform_btn_name_submit').click(function(){
    $('#form_uform_edit_btn_name').submit();
  });
  
  //uform
  $('#uform_open_submit').click(function(){//開啟所選報名表單
    $('#uform_ctrl_type').val(0);
    $('#form_uform_remove').submit();
  });
  $('#uform_remove_submit').click(function(){//關閉所選報名表單活動
    if(confirm('提醒您，關閉報名表單後您的名片將不會顯示此按鈕，您確定要關閉所選報名活動嗎？'))
    {
      $('#uform_ctrl_type').val(1);
      $('#form_uform_remove').submit();
    }
  });
  $('#uform_delete_submit').click(function(){//刪除所選報名表單
    if(confirm('提醒您，刪除報名表單將無法復原，報名資料也會一併移除，您確定要完全刪除所選報名活動嗎？'))
    {
      $('#uform_ctrl_type').val(2);
      $('#form_uform_remove').submit();
    }
  });
  $('#uform_remove tr').click(function(event) {
      if (event.target.type !== 'checkbox') {
          $(':checkbox', this).trigger('click');
      }
  });

  //全選與全不選
  $("#clickAll2").click(function() {
     if($("#clickAll2").prop("checked"))
     {
       $(".uform_switch_id").each(function() {
          $(this).prop("checked", true);
          $(this).closest('tr').removeClass("normal");  
          $(this).closest('tr').addClass("green"); 
       });
     }
     else
     {
       $(".uform_switch_id").each(function() {
          $(this).prop("checked", false);
          $(this).closest('tr').removeClass("green");  
          $(this).closest('tr').addClass("normal"); 
       });       
     }
  });

  //選取附件變色
  $('.uform_switch_id').each(function(){
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