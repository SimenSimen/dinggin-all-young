$(function(){

  var img_id;

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

  $('.photoadd2').each(function(){
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

  //全選與全不選
  $("#clickAll").click(function() {
     if($("#clickAll").prop("checked"))
     {
       $(".photoadd").each(function() {
          $(this).prop("checked", true);
          $(this).parent().removeClass("photo_box");  
          $(this).parent().addClass("greenBackground"); 
       });
     }
     else
     {
       $(".photoadd").each(function() {
          $(this).prop("checked", false);
          $(this).parent().removeClass("greenBackground");  
          $(this).parent().addClass("photo_box"); 
       });           
     }
  });

  $("#clickAll2").click(function() {
     if($("#clickAll2").prop("checked"))
     {
       $(".photoadd2").each(function() {
          $(this).prop("checked", true);
          $(this).parent().removeClass("photo_box");  
          $(this).parent().addClass("greenBackground"); 
       });
     }
     else
     {
       $(".photoadd2").each(function() {
          $(this).prop("checked", false);
          $(this).parent().removeClass("greenBackground");  
          $(this).parent().addClass("photo_box"); 
       });           
     }
  });

  //送出前檢查是否選取至少一張照片
  $('#form_server1').submit(function(event){
    if($('#tabs-1').find('.photoadd:checked').length == 0)
    {
        alert('請您選取至少一張照片重新送出2');
        event.preventDefault();
    }
  });
  $('#form_server2').submit(function(event){
    if($('#tabs-1').find('.photoadd2:checked').length == 0)
    {
        alert('請您選取至少一張照片重新送出3');
        event.preventDefault();
    }
  });

  $('#form_server_del1').click(function(){
    if($('#tabs-1').find('.photoadd:checked').length == 0)
    {
        alert('請您選取至少一張照片重新送出');
        event.preventDefault();
    }
    else
    {
      if(confirm('提醒您，刪除網路空間圖片，將同時刪除相簿照片，您確定要從網路空間刪除嗎?'))
      {
        $(".photoadd").each(function(){
          if($(this).is(":checked"))
          {
            img_id=$(this).val();
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
    if($('#tabs-1').find('.photoadd2:checked').length == 0)
    {
        alert('請您選取至少一張照片重新送出');
        event.preventDefault();
    }
    else
    {
      if(confirm('提醒您，刪除網路空間圖片，將同時刪除相簿照片，您確定要從網路空間刪除嗎?'))
      {
        $(".photoadd").each(function(){
          if($(this).is(":checked"))
          {
            img_id=$(this).val();
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
      url : $('#base_url').text()+'business/photo_delete',
      cache: false,
      data:
      {
        img_id: img_id,
        typ_n: $("#typ_n").val(),
        member_id: $("#member_id").val()
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