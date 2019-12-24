//ckeditor
var cset_ship_ck, cset_paid_ck;
var cset_ship = document.getElementById('cset_ship');
var cset_paid = document.getElementById('cset_paid');

function createEditor(languageCode) {
  if (cset_ship != null) {
    if (cset_ship_ck) {
      cset_ship_ck.destroy();
    }

    cset_ship_ck = CKEDITOR.replace('cset_ship', {
      filebrowserImageBrowseUrl: '/js/ckfinder/ckfinder.html?Type=Images',
      width: 750,
      height: 300,
      resize_enabled: false,
      enterMode: 2,
      forcePasteAsPlainText: true,
      toolbar: [
        ['Undo', 'Redo', 'Bold', 'Italic', 'Underline', 'TextColor', 'BGColor', 'Font', 'FontSize', 'JustifyLeft', 'JustifyCenter']
      ]
    });
  }
  if (cset_paid != null) {
    if (cset_paid_ck) {
      cset_paid_ck.destroy();
    }

    cset_paid_ck = CKEDITOR.replace('cset_paid', {
      filebrowserImageBrowseUrl: '/js/ckfinder/ckfinder.html?Type=Images',
      width: 750,
      height: 300,
      resize_enabled: false,
      enterMode: 2,
      forcePasteAsPlainText: true,
      toolbar: [
        ['Undo', 'Redo', 'Bold', 'Italic', 'Underline', 'TextColor', 'BGColor', 'Font', 'FontSize', 'JustifyLeft', 'JustifyCenter']
      ]
    });
  }
}
createEditor('');


$(function() {

  $('.why').each(function() {
    var prompt = '#prompt_' + $(this).attr('id').substr(4);
    $(this).hover(function() {
      $(prompt).show();
    }, function() {
      $(prompt).hide();
    });
    $(this).click(function() {
      var text_content;
      var pos_1 = $(prompt).text().search("--");
      text_content = $(prompt).text().substr(pos_1 + 2);
      var pos_2 = text_content.search("--");
      text_content = text_content.substr(0, pos_2);
      var ctrl = 'CKEDITOR.instances.' + 'cset_' + $(this).attr('id').substr(4) + '.setData(text_content);';
      eval(ctrl);
    });
  });

  $('.content_list div').hide();

  $('#nav a').click(function() {
    $('#first_show').hide();
    // console.log($(this).index('a'));
    var $div = $('.content_list > div').eq($(this).index('#nav a'));
    $div.show();
    $('.content_list > div').not($div).hide();
  });

  //store setting ajax
  $('#open_store').click(function() {
    if ($('#cset_name').val().length == 0)
      var cset_name_text = 'Action Shop';
    else
      var cset_name_text = $('#cset_name').val();

    $.ajax({
      type: "post",
      url: '/cart/store_setting',
      cache: false,
      async: false,
      data: {
        cset_active: 1,
        cset_name: cset_name_text,
        setting_type: 3
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {},
      success: function(response) {
        $('#open_store').hide();
        $('#close_store').show();
        $('#cset_share_td').show();
        $('#cset_name_td').show();
        $('#cset_email_td').show();
        $('#cset_company_td').show();
        $('#cset_address_td').show();
        $('#cset_telphone_td').show();
        $('#cset_mobile_td').show();
        $('#cset_logo_td').show();
        $('#mobile_logo_td').show();
        $('#cset_active').val(1);
        if (response != '編輯成功') {
          $('#store_edit_info').html('');
          $('#cset_name').val('Action Shop');
          alert('Congratulations, your store to Enable Success');
          location.reload();
        } else {
          $('#cset_name').val(cset_name_text);
          $('#store_edit_info').css('color', '#F60');
          $('#store_edit_info').show();
          $('#store_edit_info').html('Edited successfully');
          setTimeout("$('#store_edit_info').fadeOut()", 1500);
        }
      }
    });
  });

  //store setting ajax
  $('#close_store').click(function() {
    $.ajax({
      type: "post",
      url: '/cart/store_setting',
      cache: false,
      async: false,
      data: {
        cset_active: 0,
        setting_type: 3
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {},
      success: function(response) {
        $('#close_store').hide();
        $('#open_store').show();
        $('#cset_share_td').hide();
        $('#cset_name_td').hide();
        $('#cset_email_td').hide();
        $('#cset_company_td').hide();
        $('#cset_address_td').hide();
        $('#cset_telphone_td').hide();
        $('#cset_mobile_td').hide();
        $('#cset_logo_td').hide();
        $('#mobile_logo_td').hide();
        $('#cset_active').val(0);
        $('#store_edit_info').css('color', '#F60');
        $('#store_edit_info').show();
        $('#store_edit_info').html(response);
        setTimeout("$('#store_edit_info').fadeOut()", 1500);
      }
    });
  });

  //ship ajax
  $('#ship_edit_send').click(function() {
    $.ajax({
      type: "post",
      url: '/cart/store_setting',
      cache: false,
      async: false,
      data: {
        cset_ship: CKEDITOR.instances.cset_ship.getData(),
        setting_type: 0
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {},
      success: function(response) {
        $('#ship_edit_info').css('color', '#F60');
        $('#ship_edit_info').show();
        $('#ship_edit_info').html(response);
        setTimeout("$('#ship_edit_info').fadeOut()", 1500);
      }
    });
  });

  //pay ajax
  $('#paying_edit_send').click(function() {
    $.ajax({
      type: "post",
      url: '/cart/store_setting',
      cache: false,
      async: false,
      data: {
        cset_paid: CKEDITOR.instances.cset_paid.getData(),
        setting_type: 1
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {},
      success: function(response) {
        $('#paying_edit_info').css('color', '#F60');
        $('#paying_edit_info').show();
        $('#paying_edit_info').html(response);
        setTimeout("$('#paying_edit_info').fadeOut()", 1500);
      }
    });
  });

  // 變更金流狀態 ajax
  $('.change_iqrt_active').each(function() {
    $(this).click(function() {
      var target = 'change_iqrt_active';
      var iqrt_id = $(this).attr('id').substr(target.length + 1);
      $.ajax({
        type: "post",
        url: '/cart/store_setting',
        cache: false,
        async: false,
        data: {
          iqrt_id: iqrt_id,
          setting_type: 2
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {},
        success: function(response) {
          if (response.substr(19) == 1) {
            $('#change_iqrt_active_' + iqrt_id).val('Enable');
            $('#change_iqrt_active_' + iqrt_id).removeClass('aa3');
            $('#change_iqrt_active_' + iqrt_id).addClass('aa6');
            $('#iqrt_active_prompt_' + iqrt_id).text('Disable');
          } else {
            $('#change_iqrt_active_' + iqrt_id).val('Disable');
            $('#change_iqrt_active_' + iqrt_id).removeClass('aa6');
            $('#change_iqrt_active_' + iqrt_id).addClass('aa3');
            $('#iqrt_active_prompt_' + iqrt_id).text('Enable');
          }
        }
      });
    });
  });

  //save cart btn_name ajax
  $('#save_btn_name').click(function() {
    $.ajax({
      type: "post",
      url: '/cart/store_setting',
      cache: false,
      async: false,
      data: {
        cset_active: $('#cset_active').val(),
        cset_name: $('#cset_name').val(),
        setting_type: 3
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {},
      success: function(response) {
        $('#save_btn_name_info').css('color', '#F60');
        $('#save_btn_name_info').show();
        $('#save_btn_name_info').html(response);
        setTimeout("$('#save_btn_name_info').fadeOut()", 1500);
      }
    });
  });

  //save cset
  $('.cset').each(function() {
    $(this).click(function() {
      var cset_item = $(this).attr('id').substr(5);
      $.ajax({
        type: "post",
        url: '/cart/store_setting',
        cache: false,
        async: false,
        data: {
          cset_value: $('#' + cset_item).val(),
          setting_type: 4
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {},
        success: function(response) {
          $('#save_' + cset_item + '_info').css('color', '#F60');
          $('#save_' + cset_item + '_info').show();
          $('#save_' + cset_item + '_info').html(response);
          setTimeout("$('#save_" + cset_item + "_info').fadeOut()", 1500);
        }
      });
    });
  });

  // 變更金流帳戶 ajax
  $('.business_account').each(function() {
    $(this).click(function() {
      var target = 'change_business_account_button';
      var iqrt_id = $(this).attr('id').substr(target.length + 1);
      $.ajax({
        type: "post",
        url: '/cart/store_setting',
        cache: false,
        async: false,
        data: {
          iqrt_id: iqrt_id,
          business_account: $('#change_business_account_' + iqrt_id).val(),
          // business_hashkey : $('#change_business_hashkey_'+iqrt_id).val(),
          // business_hashiv  : $('#change_business_hashiv_'+iqrt_id).val(),
          creditinstallment: $('#change_creditinstallment_' + iqrt_id).val(),
          setting_type: 5
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {},
        success: function(response) {
          $('#business_account_edit_info_' + iqrt_id).css('color', '#F60');
          $('#business_account_edit_info_' + iqrt_id).show();
          $('#business_account_edit_info_' + iqrt_id).html(response);
          setTimeout("$('#business_account_edit_info_" + iqrt_id + "').fadeOut()", 1500);
        }
      });
    });
  });

  // 公司名稱
  $('.company').each(function() {
    $(this).click(function() {
      var cset_item = $(this).attr('id').substr(5);
      $.ajax({
        type: "post",
        url: '/cart/store_setting',
        cache: false,
        async: false,
        data: {
          company_value: $('#' + cset_item).val(),
          setting_type: 6
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {},
        success: function(response) {
          $('#save_' + cset_item + '_info').css('color', '#F60');
          $('#save_' + cset_item + '_info').show();
          $('#save_' + cset_item + '_info').html(response);
          setTimeout("$('#save_" + cset_item + "_info').fadeOut()", 1500);
        }
      });
    });
  });

  // 聯絡地址
  $('.address').each(function() {
    $(this).click(function() {
      var cset_item = $(this).attr('id').substr(5);
      $.ajax({
        type: "post",
        url: '/cart/store_setting',
        cache: false,
        async: false,
        data: {
          address_value: $('#' + cset_item).val(),
          setting_type: 7
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {},
        success: function(response) {
          $('#save_' + cset_item + '_info').css('color', '#F60');
          $('#save_' + cset_item + '_info').show();
          $('#save_' + cset_item + '_info').html(response);
          setTimeout("$('#save_" + cset_item + "_info').fadeOut()", 1500);
        }
      });
    });
  });

  // 電話
  $('.telphone').each(function() {
    $(this).click(function() {
      var cset_item = $(this).attr('id').substr(5);
      $.ajax({
        type: "post",
        url: '/cart/store_setting',
        cache: false,
        async: false,
        data: {
          telphone_value: $('#' + cset_item).val(),
          setting_type: 8
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {},
        success: function(response) {
          $('#save_' + cset_item + '_info').css('color', '#F60');
          $('#save_' + cset_item + '_info').show();
          $('#save_' + cset_item + '_info').html(response);
          setTimeout("$('#save_" + cset_item + "_info').fadeOut()", 1500);
        }
      });
    });
  });

  // 手機號碼
  $('.mobile').each(function() {
    $(this).click(function() {
      var cset_item = $(this).attr('id').substr(5);
      $.ajax({
        type: "post",
        url: '/cart/store_setting',
        cache: false,
        async: false,
        data: {
          mobile_value: $('#' + cset_item).val(),
          setting_type: 9
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {},
        success: function(response) {
          $('#save_' + cset_item + '_info').css('color', '#F60');
          $('#save_' + cset_item + '_info').show();
          $('#save_' + cset_item + '_info').html(response);
          setTimeout("$('#save_" + cset_item + "_info').fadeOut()", 1500);
        }
      });
    });
  });

  $('.lway_account').each(function() {
    $(this).click(function() {
      var target = 'change_lway_account_button';
      var iqrt_id = $(this).attr('id').substr(target.length + 1);
      $.ajax({
        type: "post",
        url: '/cart/store_setting',
        cache: false,
        async: false,
        data: {
          iqrt_id: iqrt_id,
          lway_count: $('#change_lway_account_' + iqrt_id).val(),
          setting_type: 10
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {},
        success: function(response) {
          $('#lway_account_edit_info_' + iqrt_id).css('color', '#F60');
          $('#lway_account_edit_info_' + iqrt_id).show();
          $('#lway_account_edit_info_' + iqrt_id).html(response);
          setTimeout("$('#lway_account_edit_info_" + iqrt_id + "').fadeOut()", 1500);
        }
      });
    });
  });

  $('.change_lway_active').each(function() {
    $(this).click(function() {
      var target = 'change_lway_active';
      var iqrt_id = $(this).attr('id').substr(target.length + 1);
      $.ajax({
        type: "post",
        url: '/cart/store_setting',
        cache: false,
        async: false,
        data: {
          iqrt_id: iqrt_id,
          setting_type: 11
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {},
        success: function(response) {
          if (response == 'close-logistics') {
            $('#change_lway_active_' + iqrt_id).val('Set Enable');
            $('#change_lway_active_' + iqrt_id).removeClass('aa3');
            $('#change_lway_active_' + iqrt_id).addClass('aa6');
            $('#lway_active_prompt_' + iqrt_id).text('Disable');
          } else {
            $('#change_lway_active_' + iqrt_id).val('Set Disable');
            $('#change_lway_active_' + iqrt_id).removeClass('aa6');
            $('#change_lway_active_' + iqrt_id).addClass('aa3');
            $('#lway_active_prompt_' + iqrt_id).text('Enable');
          }
        }
      });
    });
  });

  $("#open_share").click(function() {
    $.ajax({
      type: "post",
      url: '/cart/store_setting',
      cache: false,
      async: false,
      data: {
        share_active: 1,
        setting_type: 12
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {},
      success: function(response) {
        if (response == '編輯成功') {
          $('#open_share').hide();
          $('#close_share').show();
          $('#share_edit_info').css('color', '#F60');
          $('#share_edit_info').show();
          $('#share_edit_info').html('Edited successfully');
          setTimeout("$('#share_edit_info').fadeOut()", 1500);
        }
      }
    });
  });

  $("#close_share").click(function() {
    $.ajax({
      type: "post",
      url: '/cart/store_setting',
      cache: false,
      async: false,
      data: {
        share_active: 0,
        setting_type: 12
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {},
      success: function(response) {
        if (response == '編輯成功') {
          $('#close_share').hide();
          $('#open_share').show();
          $('#share_edit_info').css('color', '#F60');
          $('#share_edit_info').show();
          $('#share_edit_info').html('Edited successfully');
          setTimeout("$('#share_edit_info').fadeOut()", 1500);
        }
      }
    });
  });
});