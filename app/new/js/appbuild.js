$(function() {
  $('#update_apk').on('click',function()
  {
    if($(this).val() == 'Android 已更新')
    {
      alert('您的APP已是最新版本，若您需要重新打包，您可以進行資料或圖片變更來進一步更新APP');
    }
    else if($(this).val() == 'Android 更新中')
    {
      alert('APP 更新中，請稍後約 30秒 - 1分鐘');
    }
    else
    {
      //Update App 確認
      if($('#vertify_name').val() != '' )
      {
        if(confirm('APP 更新\n若您有以下項目變更，請更新APP：\n\n1. 您的姓名變更\n2. 您的icon變更\n3. 您的歡迎頁變更\n\n此更新作業將花費您約: 30秒至1分鐘等待時間，\n請問您是否確定要更新APP?'))
        {
          update_app_apk();
        }
      }
      else
      {
        alert('名字不可空白，請輸入名字後按儲存編輯，再進行APP更新');
      }
    }
  });

  $('#update_ios').on('click',function()
  {
    if($(this).val() == 'IOS 已更新')
    {
      alert('您的IOS已是最新版本，若您需要重新打包，您可以進行資料或圖片變更來進一步更新APP');
    }
    else if($(this).val() == 'IOS 更新中')
    {
      alert('APP 更新中，請稍後約 30秒 - 1分鐘');
    }
    else if($(this).val() == 'IOS 憑證失效')
    {
      alert('請更新您的 IOS APP 憑證');
    }
    else
    {
      //Update App 確認
      if($('#vertify_name').val() != '' )
      {
        if(confirm('APP 更新\n若您有以下項目變更，請更新APP：\n\n1. 您的姓名變更\n2. 您的icon變更\n3. 您的歡迎頁變更\n\n此更新作業將花費您約: 30秒至1分鐘等待時間，\n請問您是否確定要更新APP?'))
        {
          update_app_ios();
        }
      }
      else
      {
        alert('名字不可空白，請輸入名字後按儲存編輯，再進行APP更新');
      }
    }
  });
});

var android_text_show = false;
var ios_text_show = false;

update_app_apk = function ()
{
  $.blockUI({ 
    message: 'Android更新中，需時約1分鐘，您可以稍後重新整理，以確認更新狀態',
    css: { 
      border: 'none', 
      padding: '15px', 
      backgroundColor: '#000', 
      '-webkit-border-radius': '10px', 
      '-moz-border-radius': '10px', 
      opacity: .7,
      color: '#fff' 
    } 
  });
  // $('body').scrollTop(0);
  $('#update_apk').val('Android 更新中');
  $('#update_apk').css('background', '#B2A171');
  update_apk();
  setTimeout(function(){$.unblockUI();}, 5000);
  $('.blockOverlay').attr('title','點一下關閉提示').click($.unblockUI);
}

update_app_ios = function ()
{
  $.blockUI({ 
    message: 'IOS更新中，需時約1分鐘，您可以稍後重新整理，以確認更新狀態',
    css: { 
      border: 'none', 
      padding: '15px', 
      backgroundColor: '#000', 
      '-webkit-border-radius': '10px', 
      '-moz-border-radius': '10px', 
      opacity: .7,
      color: '#fff' 
    } 
  });
  // $('body').scrollTop(0);
  $('#update_ios').val('IOS 更新中');
  $('#update_ios').css('background', '#B2A171');
  update_ipa();
  setTimeout(function(){$.unblockUI();}, 5000);
  $('.blockOverlay').attr('title','點一下關閉提示').click($.unblockUI);
}
update_apk = function ()
{
  $.ajax({
    type: "post",
    url: '/app/ajax/android',
    data: {
        project:  'android',
        name:     'AppPlusNetnewsWeb',
        id:       $('#member_id').val(),
        app_name: $('#l_name').val()+$('#f_name').val(),
        app_icon: $('#preview_icon').attr('src'),
        app_a_wp: $('#preview_a_wp').attr('src')
    },
    cache: false,
    error: function(XMLHttpRequest, textStatus, errorThrown)
    {
    },
    success: function (response) {
      // $('#info').fadeIn();
      // $('#info').html(response);
      $.blockUI({ 
        message: 'Android APP 更新完成',
        css: { 
          border: 'none', 
          padding: '15px', 
          backgroundColor: '#000', 
          '-webkit-border-radius': '10px', 
          '-moz-border-radius': '10px', 
          opacity: .7,
          color: '#fff' 
        } 
      });
      setTimeout(function(){$.unblockUI();}, 1200);
      $('.blockOverlay').attr('title','點一下關閉提示').click($.unblockUI);
      
      android_text_show = true;
      if(android_text_show)
      {
        $('#update_apk').val('Android 已更新');
        $('#update_apk').css('background', '#cccccc');
      }

    }
  });
}

update_ipa = function ()
{
  $.ajax({
    type: "post",
    url: '/app/ajax/ios',
    data: {
        project:    'ios',
        name:       'AppPlusNetnewsWeb',
        id:         $('#member_id').val(),
        app_name:   $('#l_name').val()+$('#f_name').val(),
        app_icon:   $('#preview_icon').attr('src'),
        app_i_wp_0: $('#preview_i_wp_0').attr('src'),
        app_i_wp_1: $('#preview_i_wp_1').attr('src')
    },
    cache: false,
    error: function(XMLHttpRequest, textStatus, errorThrown)
    {
    },
    success: function (response) {
      if(response != 'iOS 憑證失效')
      {
        // $('#info').fadeIn();
        // $('#info').html(response);
        $.blockUI({ 
          message: 'iOS APP 更新完成',
          css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .7,
            color: '#fff' 
          } 
        });
        setTimeout(function(){$.unblockUI();}, 1200);
        $('.blockOverlay').attr('title','點一下關閉提示').click($.unblockUI);

        ios_text_show = true;
        if(ios_text_show)
        {
          $('#update_ios').val('IOS 已更新');
          $('#update_ios').css('background', '#cccccc');
        }
      }
      else
      {
        $.blockUI({ 
          message: 'iOS APP 憑證失效',
          css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .7,
            color: '#fff' 
          } 
        });
        $('#update_ios').val('IOS 憑證失效');
      }
    }
  });
}