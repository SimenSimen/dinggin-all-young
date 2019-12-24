//離開頁面確認
window.onbeforeunload = function()
{ 
　　return "您即將離開本頁面，網頁將不會被新增"; 
}

$(function()
{
  
  //取消按鈕
  $('#cancel').click(function(){
    if(confirm('您確定要取消新增嗎?'))
    {
      window.onbeforeunload=null;
      window.close();
      return true;
    }
  });

  //新增完成
  if($('#success').val() == 1)
  {
    // $('#iqr_classify_empty', opener.document).remove();

    alert('新增成功');
    // $('#iqr_classify_tbody', opener.document).append(""+
    // " <tr>"+
    // " <td style='text-align:center; width: 15%;'>New</td>"+
    // " <td>"+$('#html_name').val()+"</td>"+
    // " <td style='text-align:center; width: 30%;'>"+
    // " <span style='font-size:10px; color:#bbbbbb;'>操作功能請重新整理</span>"+
    // " </td>"+
    // " </tr>"+
    // "");
    window.opener.location.reload();
    window.onbeforeunload=null;
    window.close();
  }

  //驗證必填欄位
  $('#form_iqr_classify_add').validate({
      success: function(label) {
        label.addClass("success").text("");
      }
  });
});