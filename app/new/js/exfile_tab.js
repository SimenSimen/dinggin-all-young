$(function(){

  var doc_id;

  //選取照片變色
  $('.photoadd').each(function(){
    $(this).change(function(){
      if($(this).is(":checked")){
        $(this).parent().removeClass("photo_box");  
        $(this).parent().addClass("greenBackground"); 
      }else{
        $(this).parent().removeClass("greenBackground");  
        $(this).parent().addClass("photo_box"); 
      }
    });
  });

  //關閉視窗
  $('.cancle').each(function(){
    $(this).click(function(){
      window.close();
    });
  });

  //tr checkbox
  $('#exfile_table tr').click(function(event) {
      if (event.target.type !== 'checkbox') {
          $(':checkbox', this).trigger('click');
      }
  });
  //全選與全不選
  $("#clickAll").click(function() {
     if($("#clickAll").prop("checked"))
     {
       $(".exfile_add1").each(function() {
          $(this).prop("checked", true);
          $(this).closest('tr').removeClass("normal");  
          $(this).closest('tr').addClass("green"); 
       });
     }
     else
     {
       $(".exfile_add1").each(function() {
          $(this).prop("checked", false);
          $(this).closest('tr').removeClass("green");  
          $(this).closest('tr').addClass("normal"); 
       });       
     }
  });

  $("#clickAll2").click(function() {
     if($("#clickAll2").prop("checked"))
     {
       $(".exfile_add2").each(function() {
          $(this).prop("checked", true);
          $(this).closest('tr').removeClass("normal");  
          $(this).closest('tr').addClass("green"); 
       });
     }
     else
     {
       $(".exfile_add2").each(function() {
          $(this).prop("checked", false);
          $(this).closest('tr').removeClass("green");  
          $(this).closest('tr').addClass("normal"); 
       });       
     }
  });

  //選取附件變色
  $('.exfile_add1').each(function(){
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
  $('.exfile_add2').each(function(){
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

  //送出前檢查是否選取至少一張照片
  $('#form_exfile_add1').submit(function(event){
    if($('#tabs-1').find('.exfile_add1:checked').length == 0)
    {
        alert('請您選取至少一張照片重新送出');
        event.preventDefault();
    }
  });
  $('#form_exfile_add2').submit(function(event){
    if($('#tabs-1').find('.exfile_add2:checked').length == 0)
    {
        alert('請您選取至少一張照片重新送出');
        event.preventDefault();
    }
  });

  $('#form_server_del1').click(function(){
    if($('#tabs-1').find('.exfile_add1:checked').length == 0)
    {
        alert('請您選取至少一張照片重新送出');
        event.preventDefault();
    }
    else
    {
      if(confirm('提醒您，刪除網路空間中的附件，將無法復原，您確定要從網路空間刪除嗎?'))
      {
        $(".exfile_add1").each(function(){
          if($(this).is(":checked"))
          {
            doc_id=$(this).val();
            ajax_delete();
          }
        });
        alert('刪除成功');  
        opener.window.parent.location.reload(); 
        window.location.reload();
      }
    }
  });

  $('#form_server_del2').click(function(){
    if($('#tabs-1').find('.exfile_add2:checked').length == 0)
    {
        alert('請您選取至少一張照片重新送出');
        event.preventDefault();
    }
    else
    {
      if(confirm('提醒您，刪除網路空間中的附件，將無法復原，您確定要從網路空間刪除嗎?'))
      {
        $(".exfile_add2").each(function(){
          if($(this).is(":checked"))
          {
            doc_id=$(this).val();
            ajax_delete();
          }
        });
        alert('刪除成功');  
        opener.window.parent.location.reload(); 
        window.location.reload();
      }
    }
  });

  ajax_delete = function(){
    $.ajax(
    { 
      type: "post", 
      url : $('#base_url').text()+'business/exfile_delete',
      cache: false,
      data:
      {
        doc_id: doc_id,
        member_id:$('#member_id').val()
      },
      async: false,
      error: function(XMLHttpRequest, textStatus, errorThrown)
      {
      },
      success: function(response)
      {
          $('#info').html(response);
          $('#info').css('color', 'red');
      }
    });
  };
});