$(function(){

  $('#form_iqr_style').submit(function(event) {
      if ($('.theme_radio:radio', this).is(':checked')) {
      } else {
          alert('請選擇版型');
          $(window).scrollTop(0);
          event.preventDefault();
      }
  });

  //基本版型使用按鈕顏色[theme_radio_1]欄位
  $('.ui-state-default input[type=radio]').change(
  function(){
      if ($('#theme_radio_2').is(':checked') || $('#theme_radio_3').is(':checked') || $('#theme_radio_4').is(':checked') || $('#theme_radio_5').is(':checked') || $('#theme_radio_6').is(':checked')) {
        $('#menu_style').show();
        $('.menu_selection').show();
      }
      else{
        $('#menu_style').hide();
        $('.menu_selection').hide();
      }
  });

  //當li被點擊，選取radio
  $('#iqr_theme_ul li').click(function(event) {
      if (event.target.type !== 'radio') {
          $(':radio', this).trigger('click');
      }
  });
  $('#iqr_theme_background_ul li').click(function(event) {
      if (event.target.type !== 'radio') {
          $(':radio', this).trigger('click');
      }
  });

  $('#iqr_menu_ul li').click(function(event) {
      if (event.target.type !== 'radio') {
          $(':radio', this).trigger('click');
      }
  });


  // $('#iqr_menu_ul li').click(function(event) {
  //     $(".ui-menu-status").removeClass('highlight');
  //     $(this).addClass('highlight');
  //     $(this).children("input[name='menu_radio']").attr("checked","checked")
  //     alert($(this).children("input[name='menu_radio']").val());
  // });
  // $('#iqr_menu_background_ul li').click(function(event) {
  //     if (event.target.type !== 'radio') {
  //         $(':radio', this).trigger('click');
  //     }
  // });


//   $("xxx li").click(function(){

//   $(".ui-menu-status").removeClass("heightlight");
//   $(this).addClass("heightlight");
//   $(this).children("input[type='radio']").attr("checked","checked");
// })

  //當radio被點擊，li變色
  var radios = $('#iqr_theme_ul input[type=radio]');
  var mradios = $('#iqr_menu_ul input[type=radio]');
 
  radios.on('change', function() {
      radios.each(function() {
          var radio = $(this);
          radio.closest('li')[radio.is(':checked') ? 'addClass' : 'removeClass']('highlight');
      });
  });

  mradios.on('change', function(){
      mradios.each(function() {
          var radio = $(this);
          radio.closest('li')[radio.is(':checked') ? 'addClass' : 'removeClass']('highlight');
      });
      $('#jqm_button_color').val($(this).val());
  });
  var radios2 = $('#iqr_theme_background_ul input[type=radio]');

  radios2.on('change', function() {
      radios2.each(function() {
          var radio2 = $(this);
          radio2.closest('li')[radio2.is(':checked') ? 'addClass' : 'removeClass']('highlight');
      });
  });
  // $('#theme_background_radio_basic').change(function(){
  //   $('#iqr_theme_background_ul li').each(function(){
  //     $(this).removeClass("highlight");  
  //   });
  // });

  //系統版型預設顏色讀取
  var tid;
  var ajax_id;
  $('.theme_radio').change(function(){
    $.blockUI({ 
      message: '讀取系統版型預設值',
      css: { 
        border: 'none', 
        padding: '15px', 
        backgroundColor: '#000', 
        '-webkit-border-radius': '10px', 
        '-moz-border-radius': '10px', 
        opacity: .5, 
        color: '#fff' 
      } 
    }); 
    $.ajax(
    { 
      type: "post", 
      url : $('#base_url').val()+'business/cart_default_style',
      cache: false,
      data:
      {
        cart_id: $('#'+$(this).attr('id')+':radio').val()
      },
      dataType: "json",
      async: false,
      error: function(XMLHttpRequest, textStatus, errorThrown)
      {
      },
      success: function(response)
      {
        $.unblockUI();
        tid           = $('#'+$(this).attr('id')+':radio').val();
        ajax_id       = response.cart_id;
        // 系統版型
        $('#theme_radio_'+ajax_id+':radio').click();
        // 按鈕顏色
        $('#menu_radio_'+$('#user_cart_id').val()+':radio').click();
        $('#jqm_button_color option[value="'+$('#user_cart_id').val()+'"]').attr('selected', true);
      }
    });
  });
  $('#theme_radio_'+$('#user_cart_id').val()+':radio').click();
  //初始按鈕顏色
  $('#menu_radio_'+$('#user_menu_id').val()+':radio').click();
  $('#jqm_button_color option[value="'+$('#user_menu_id').val()+'"]').attr('selected', true);

  //恢復系統預設值
  $('#reset_style').click(function(){
    if(confirm('您確定要恢復系統預設值?'))
    {
      //系統版型
      $('#theme_radio_'+$('#user_cart_id').val()+':radio').click();
      //按鈕顏色
      $('#menu_radio_demo-1:radio').click();
      $('#jqm_button_color option[value="demo-1"]').attr('selected', true);
    }
  });

  // 還原編輯前狀態
  $('#reset_edit').click(function(){
    if(confirm('您確定要重新設定?'))
    {
      if($('#bg_type').val() == 0)
      {
        $('#color_background_tr').show();
        $('#image_background_tr').hide();
        $('#system_background_tr').hide();
      }
      else
      {
        $('#image_background_tr').show();
        $('#system_background_tr').show();
        $('#color_background_tr').hide();
      }
      //theme_id
      $('#theme_radio_'+$('#user_cart_id').val()+':radio').click();
      //初始按鈕顏色
      $('#menu_radio_'+$('#user_menu_id').val()+':radio').click();
      $('#jqm_button_color option[value="'+$('#user_menu_id').val()+'"]').attr('selected', true);
    }
  });
});

