$(function()//onload
{
  //前往行動名片網址
  // $('#open_iqr_window').click(function(){
  //   window.open('<?=$base_url?>business/iqrc/<?=$id?>', '手機快速掃描<?=$l_name.$f_name?>的行動名片', config='height=620,width=420,left=470');//left700
  // });

  // //valid
  // $('input[name=old_password]').focus();
  $('#form_updp').submit(function(event){
    if($('input[name=password]').val() != $('input[name=check_password]').val())
    {
      $('#info').html('新密碼與重複密碼不符');
      $('#info').css('color', 'red');
      $('#info').css('position', 'relative');
      $('#info').css('top', '10px');
      event.preventDefault();
    }
    if($('input[name=password]').val().length == 0 || $('input[name=check_password]').val().length == 0 || $('input[name=old_password]').val().length == 0)
    {
      $('#empty_info').html('請輸入必須資料');
      $('#empty_info').css('color', 'red');
      $('#empty_info').css('position', 'relative');
      $('#empty_info').css('top', '10px');
      event.preventDefault();
    }
  });
});