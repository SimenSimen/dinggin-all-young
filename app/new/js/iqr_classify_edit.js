//離開頁面確認
window.onbeforeunload = function()
{ 
　　return "您即將離開本頁面，網頁將不會被新增"; 
}

$(function()
{
  
  //取消按鈕
  $('#cancel').click(function(){
    if(confirm('您確定要取消編輯嗎?'))
    {
      window.onbeforeunload=null;
      window.close();
      return true;
    }
  });

  //新增完成
  if($('#success').val() == 1)
  {
    alert('編輯成功');
    window.onbeforeunload=null;
    window.close();
    self.opener.location.reload();
  }

  //驗證必填欄位
  $('#form_iqr_html_edit').validate({
      success: function(label) {
        label.addClass("success").text("");
      }
  });
});