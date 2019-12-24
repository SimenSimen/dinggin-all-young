$(function(){
  $( "#dialog" ).dialog({
    autoOpen: false,
    height: 450,
    width: 750,
    modal: true,
    buttons: {
      "Yes": {
        text: '儲存並套用到子帳戶', class: 'btn btn-default', click: function() {
          $('#default_quote').val(1);
          $( "#dialog" ).dialog( "close" );
          $('#form_submit').click();
        }
      },
      "No": {
        text: '僅儲存', class: 'btn btn-default', click: function() {
          $('#default_quote').val(0);
          $( "#dialog" ).dialog( "close" );
          $('#form_submit').click();
        }
      },
      "Cancel": {
        text: '取消', class: 'btn btn-default', click: function() {
          $( "#dialog" ).dialog( "close" );
          $('#reset').click();
        }
      }
    }
  });
  $( ".opendialog" ).each(function(){
    $(this).click(function() {
      // 設定預設引用模式
      $( "#dialog" ).dialog( "open" );
    });
  });
});