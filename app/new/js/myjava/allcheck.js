function check_all(obj,cName) 
{ 
    var checkboxs = document.getElementsByName(cName); 
    for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = obj.checked;} 
} 
//全選函式
function allcheck(){
  var str=''; 
  var DB=$('head').attr("id");     //資料庫
  var Field='d_id'; //欄位名稱
  var show=$('#show_num').val();
  if(show=='no'){
    alert("請選擇動作");
    return '';
  }
  $("input[name='allid[]']:checked").each(function(){   
      str+=$(this).val()+';';   
  })   
  if(str==''){
      alert('請選取項目');
      return  '';
  }

  $.ajax({
      url:'/bonus/oc_data',
      type:'POST',
      data: 'DB='+DB+'&field='+Field+'&id='+str+'&oc='+show,
      dataType: 'text',
      success: function( json ) 
      {
          alert(json);
          window.location.reload();
      }
  });
}
