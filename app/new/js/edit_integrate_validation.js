$(function()//onload
{
  //form business validation
  var form_business = $('#form_business');
  form_business.validate(
  {
    success: function(label)
    {
      label.addClass("success").text("");
    }
  });

  //before submit
  $('.prompt').hide();
  $('.prompt').css('color', 'red');

  var form_business = $('#form_business');
  form_business.submit( function( event )
  {
    if($('#open_contact').is(':checked'))
    {
      if(($('#iqr_firstname').val().length == 0 && $('#iqr_lastname').val().length == 0) && ($('#iqr_mphone').val().length == 0 && $('#iqr_cpn_tel').val().length == 0))
      {
        $('#firstname_span').html("姓氏名字請選填其中之一");
        $('#firstname_span').fadeIn();
        $('#mphone_span').html("手機與電話請選填其中之一");
        $('#mphone_span').fadeIn();
        $('#iqr_firstname').focus();
        event.preventDefault();
      }
      else if($('#iqr_firstname').val().length == 0 && $('#iqr_lastname').val().length == 0)
      {
        $('#firstname_span').html("姓氏名字請選填其中之一");
        $('#firstname_span').fadeIn();
        $('#iqr_firstname').focus();
        event.preventDefault();
      }
      else if($('#iqr_mphone').val().length == 0 && $('#iqr_cpn_tel').val().length == 0)
      {
        $('#mphone_span').html("手機與電話請選填其中之一");
        $('#mphone_span').fadeIn();
        $('#iqr_mphone').focus();
        event.preventDefault();
      }
    }
  });

});