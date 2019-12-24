$(function(){

  //當原始資料有值時 mecard預設打開
  if($('#mecard_show').val() == 1)
  {
    //打開通訊錄狀態設為打勾
    $('#open_contact').prop("checked", true);
    $('.mcard_tr').show();//Show出通訊錄欄位
    $("#chk_to_cpy_data").attr("disabled", false);//資料同上打勾框啟用
    $("#chk_to_cpy_data").attr("checked", false);//資料同上打勾框不打勾
  }
  else
  {
    //打開通訊錄的打勾狀態設為不勾
    $('#open_contact').prop("checked", false);
  }

  //當打開通訊錄打勾狀態改變
  $('#open_contact').change(function ()
  {
    //如果打勾
    if (this.checked)
    {
      $("#chk_to_cpy_data").removeAttr("disabled");
      $('.mcard_tr').show();
    }
    else
    {
      $("#chk_to_cpy_data").attr("disabled", true);//資料同上打勾框停用
      $("#chk_to_cpy_data").attr("checked", false);//資料同上設為不勾選
      $('.mcard_tr').each(function(){
        $(this).find('input').val('');//清空通訊錄欄位值
      });
      $('.mcard_tr').hide();//隱藏通訊錄使用欄位
    }
  });

  //當資料同上打勾狀態改變
  $('#chk_to_cpy_data').change(function ()
  {
    //當打勾
    if (this.checked)
    {
      //其他清空
      // $('#iqr_cpn_name').val('');
      // $('#iqr_cpn_fax').val('');
      // $('#iqr_cpn_addr').val('');

      //姓名
      $('#iqr_lastname').val($('#l_name').val());
      $('#iqr_firstname').val($('#f_name').val());

      // 傳真
      $('#iqr_cpn_fax').val($('#cpn_cfax').val());
      // 手機
      $('#iqr_mphone').val($('#mobile').val());

      //公司電話
      $('#iqr_cpn_tel').val($('#cpn_phone').val());
      $('#iqr_cpn_tel_ext').val($('#cpn_extension').val());

      //信箱
      $('#iqr_ecard_mail').val($('#email').val());
    }
    else
    {
      $('#iqr_lastname').val('');
      $('#iqr_firstname').val('');
      $('#iqr_mphone').val('');
       $('#iqr_cpn_fax').val('');
      $('#iqr_cpn_tel').val('');
      $('#iqr_ecard_mail').val('');
    }
  });

  //ytb_link
  //add 
    var ytb_link_num = $('#ytb_link_num').val();
    $('#add_ytb_link').on('click', function()
    {
      ytb_link_num++;
      if($("#video_num").val() == $('#ytb_link_num').val()-1)
      {
        alert('影片數量已達上限');
      }
      else
      {
        $('#prompt_0').html('');
        $("#add_ytb_link_form input[type=reset]").trigger("click");
        $( "#dialog-form-ytb-link" ).dialog( "open" );
      }
    });
  //delete
    $("#ytb_link_table").on('mousedown', '.del_ytb_link', function()
    {
      $("#ytb_link_table").mouseup();
      var id_prefix = 'del_ytb_link_';
      var this_id = $(this).attr('id').substr(id_prefix.length);

      if(confirm('影片標題：'+$('#ytb_link_name_'+this_id).val()+'\n影片網址：'+$('#ytb_link_'+this_id).val()+'\n\n確定移除?'))
      {
        $.ajax({
          type: "post",
          url: '/dynamic/delete',
          data: {
              mid:  $('#member_id').val(),
              id:   this_id,
              type: 0
          },
          cache: false,
          error: function(XMLHttpRequest, textStatus, errorThrown)
          {
          },
          success: function (response) {
            $('#ytb_link_'+this_id).closest('tr').remove();
            $('#ytb_link_num').val(--ytb_link_num);
            if($('#ytb_link_tbody tr').length == 0)
              $('.ytb_link_empty_text').html('尚未新增任何影片網址');
          }
        });
      }
    });
  //ajax
    $( "#dialog-form-ytb-link" ).dialog({
      autoOpen: false,
      height: 450,
      width: 650,
      modal: true,
      buttons: {
        "Add": {
          text: '新增 Youtube 影片', class: 'btn btn-default', click: function() {
            if($('#add_ytb_link_form input[name=str_name]').val().length != 0 && $('#add_ytb_link_form input[name=str]').val().length != 0)
            {
              $.post("/dynamic/add", $('#add_ytb_link_form').serialize(), function(data){
                var strings = data.split("*#");
                $("#ytb_link_table").append(""+
                ""+
                "<tr>"+
                "<td>"+
                "  <input type='text' style='width: 280px;' value='"+strings[0]+"' placeholder='影片標題' name='ytb_link_name["+strings[2]+"]' id='ytb_link_name_"+strings[2]+"' maxlength='32'>&nbsp;<a href='#' class='why'>?</a><div class='prompt-box'>您可以填入「影片標題」與「Youtube 網址」，以自訂內嵌影片</div>"+
                "  <span style='padding: 0px 10px 0 0;margin-left:30px;'>分類</span><span style=''>"+strings[3]+"</span><input type='hidden' name='ytb_link_cid["+strings[2]+"]' value='"+strings[4]+"'>"+
                "  <input type='text' style='width: 340px;' value='"+strings[1]+"' class='iii2' placeholder='影片網址必填' name='ytb_link["+strings[2]+"]' id='ytb_link_"+strings[2]+"'>"+
                "  &nbsp;<a class='aa2' href='javascript:void(0);' title='按此拖曳排序'>排序</a>&nbsp;<a href='javascript:void(0);' class='aa2 del_ytb_link' id='del_ytb_link_"+strings[2]+"'>移除</a>"+
                "</td>"+
                "</tr>"+
                "");
                $( "#dialog-form-ytb-link" ).dialog( "close" );
                $('.ytb_link_empty_text').html('');
              });
            }
            else
            {
              $('#prompt_0').html('請填寫所有欄位');
            }
          }
        },
        "Cancel": {
          text: '取消', class: 'btn btn-default', click: function() {
            $( "#dialog-form-ytb-link" ).dialog( "close" );
          }
        }
      }
    });

  //website
  //add 
    var website_num=$('#website_num').val();
    $('#add_website').on('click', function()
    {
      website_num++;
      if($("#sys_website_num").val() == $('#website_num').val()-1)
      {
        alert('網址數量已達上限');
      }
      else
      {
        $('#prompt_1').html('');
        $("#add_website_form input[type=reset]").trigger("click");
        $( "#dialog-form-website" ).dialog( "open" );
      }
    });
  //delete
    $("#website_table").on('mousedown','.del_website',function()
    {
      $("#website_table").mouseup();
      var id_prefix = 'del_website_';
      var this_id = $(this).attr('id').substr(id_prefix.length);

      if(confirm('按鈕名稱：'+$('#website_name_'+this_id).val()+'\n網站網址：'+$('#website_'+this_id).val()+'\n\n確定移除?'))
      {
        $.ajax({
          type: "post",
          url: '/dynamic/delete',
          data: {
              mid:  $('#member_id').val(),
              id:   this_id,
              type: 1
          },
          cache: false,
          error: function(XMLHttpRequest, textStatus, errorThrown)
          {
          },
          success: function (response) {
            $('#website_'+this_id).closest('tr').remove();
            $('#website_num').val(--website_num);
            if($('#website_tbody tr').length == 0)
              $('.website_empty_text').html('尚未新增任何網站網址');
          }
        });
      }
    });
  //ajax
    $( "#dialog-form-website" ).dialog({
      autoOpen: false,
      height: 300,
      width: 650,
      modal: true,
      buttons: {
        "Add": {
          text: '新增 網站網址', class: 'btn btn-default', click: function() {
            if($('#add_website_form input[name=str_name]').val().length != 0 && $('#add_website_form input[name=str]').val().length != 0)
            {
              $.post("/dynamic/add", $('#add_website_form').serialize(), function(data){
                var strings = data.split("*#");
                $("#website_table").append(""+
                ""+
                "<tr>"+
                "<td>"+
                "  <input type='text' value='"+strings[0]+"' placeholder='按鈕顯示名稱' name='website_name["+strings[2]+"]' id='website_name_"+strings[2]+"' maxlength='15'>&nbsp;<a href='#' class='why'>?</a><div class='prompt-box'>您可以填入「網站按鈕名稱」與「網址」來新增超連結按鈕</div>"+
                "  <input type='text' value='"+strings[1]+"' class='iii2' placeholder='網站網址必填' name='website["+strings[2]+"]' id='website_"+strings[2]+"'>"+
                "  &nbsp;<a class='aa2' href='javascript:void(0);' title='按此拖曳排序'>排序</a>&nbsp;<a href='javascript:void(0);' class='aa2 del_website' id='del_website_"+strings[2]+"'>移除</a>"+
                "</td>"+
                "</tr>"+
                "");
                $( "#dialog-form-website" ).dialog( "close" );
                $('.website_empty_text').html('');
              });
            }
            else
            {
              $('#prompt_1').html('請填寫所有欄位');
            }
          }
        },
        "Cancel": {
          text: '取消', class: 'btn btn-default', click: function() {
            $( "#dialog-form-website" ).dialog( "close" );
          }
        }
      }
    });

  //address
  //add 
    var address_num=$('#address_num').val();
    $('#add_address').on('click', function()
    {
      address_num++;
      if($("#sys_address_num").val() == $('#address_num').val()-1)
      {
        alert('地址數量已達上限');
      }
      else
      {
        $('#prompt_2').html('');
        $("#add_address_form input[type=reset]").trigger("click");
        $( "#dialog-form-address" ).dialog( "open" );
      }
    });
  //delete
    $("#address_table").on('mousedown','.del_address',function()
    {
      $("#address_table").mouseup();
      var id_prefix = 'del_website_';
      var this_id = $(this).attr('id').substr(id_prefix.length);

      if(confirm('按鈕名稱：'+$('#address_name_'+this_id).val()+'\n地圖地址：'+$('#address_'+this_id).val()+'\n\n確定移除?'))
      {
        $.ajax({
          type: "post",
          url: '/dynamic/delete',
          data: {
              mid:  $('#member_id').val(),
              id:   this_id,
              type: 2
          },
          cache: false,
          error: function(XMLHttpRequest, textStatus, errorThrown)
          {
          },
          success: function (response) {
            $('#address_'+this_id).closest('tr').remove();
            $('#address_num').val(--address_num);
            if($('#address_tbody tr').length == 0)
              $('.address_empty_text').html('尚未新增任何地圖地址');
          }
        });
      }
    });
  //ajax
    $( "#dialog-form-address" ).dialog({
      autoOpen: false,
      height: 300,
      width: 650,
      modal: true,
      buttons: {
        "Add": {
          text: '新增 地圖地址', class: 'btn btn-default', click: function() {
            if($('#add_address_form input[name=str_name]').val().length != 0 && $('#add_address_form input[name=str]').val().length != 0)
            {
              $.post("/dynamic/add", $('#add_address_form').serialize(), function(data){
                var strings = data.split("*#");
                $("#address_table").append(""+
                "<tr>"+
                "<td>"+
                "  <input type='text' value='"+strings[0]+"' placeholder='按鈕顯示名稱' name='address_name["+strings[2]+"]' id='address_name_"+strings[2]+"' maxlength='15'>&nbsp;<a href='#' class='why'>?</a><div class='prompt-box'><p>您可以填入「地圖按鈕名稱」與「地址」以新增地圖按鈕</p><p>地址內容可以省略郵遞區號，但請您盡量輸入完整</p></div>"+
                "  <input type='text' value='"+strings[1]+"' class='iii2' placeholder='地圖地址必填' name='address["+strings[2]+"]' id='address_"+strings[2]+"'>"+
                "  &nbsp;<a class='aa2' href='javascript:void(0);' title='按此拖曳排序'>排序</a>&nbsp;<a href='javascript:void(0);' class='aa2 del_address' id='del_address_"+strings[2]+"'>移除</a>"+
                "</td>"+
                "</tr>"+
                "");
                $( "#dialog-form-address" ).dialog( "close" );
                $('.address_empty_text').html('');
              });
            }
            else
            {
              $('#prompt_2').html('請填寫所有欄位');
            }
          }
        },
        "Cancel": {
          text: '取消', class: 'btn btn-default', click: function() {
            $( "#dialog-form-address" ).dialog( "close" );
          }
        }
      }
    });

  //titlename
  //add 
    var titlename_num=$('#titlename_num').val();
    $('#add_titlename').on('click', function()
    {
      titlename_num++;
      if($("#sys_titlename_num").val() == $('#titlename_num').val()-1)
      {
        alert('頭銜數量已達上限');
      }
      else
      {
        $('#prompt_3').html('');
        $("#add_titlename_form input[type=reset]").trigger("click");
        $( "#dialog-form-titlename" ).dialog( "open" );
      }
    });
  //delete
    $("#titlename_table").on('mousedown','.del_titlename',function()
    {
      $("#titlename_table").mouseup();
      var id_prefix = 'del_titlename_';
      var this_id = $(this).attr('id').substr(id_prefix.length);

      if(confirm('頭銜：'+$('#titlename_'+this_id).val()+'\n\n確定移除?'))
      {
        $.ajax({
          type: "post",
          url: '/dynamic/delete',
          data: {
              mid:  $('#member_id').val(),
              id:   this_id,
              type: 3
          },
          cache: false,
          error: function(XMLHttpRequest, textStatus, errorThrown)
          {
          },
          success: function (response) {
            $('#titlename_'+this_id).closest('tr').remove();
            $('#titlename_num').val(--titlename_num);
            if($('#titlename_tbody tr').length == 0)
              $('.titlename_empty_text').html('尚未新增任何頭銜');
          }
        });
      }
    });
  //ajax
    $( "#dialog-form-titlename" ).dialog({
      autoOpen: false,
      height: 250,
      width: 650,
      modal: true,
      buttons: {
        "Add": {
          text: '新增 頭銜', class: 'btn btn-default', click: function() {
            if($('#add_titlename_form input[name=str]').val().length != 0)
            {
              $.post("/dynamic/add", $('#add_titlename_form').serialize(), function(data){
                var strings = data.split("*#");
                $("#titlename_table").append(""+
                "<tr>"+
                "<td>"+
                "  <input type='text' value='"+strings[1]+"' class='iii3' placeholder='頭銜必填' name='titlename["+strings[2]+"]' id='titlename_"+strings[2]+"'>&nbsp;<a href='#' class='why'>?</a><div class='prompt-box'>請填入您需要的頭銜，例如「總經理」</div>"+
                "  &nbsp;<a class='aa2' href='javascript:void(0);' title='按此拖曳排序'>排序</a>&nbsp;<a href='javascript:void(0);' class='aa2 del_titlename' id='del_titlename_"+strings[2]+"'>移除</a>"+
                "</td>"+
                "</tr>"+
                "");
                $( "#dialog-form-titlename" ).dialog( "close" );
                $('.titlename_empty_text').html('');
              });
            }
            else
            {
              $('#prompt_3').html('請填寫所有欄位');
            }
          }
        },
        "Cancel": {
          text: '取消', class: 'btn btn-default', click: function() {
            $( "#dialog-form-titlename" ).dialog( "close" );
          }
        }
      }
    });
  
  $('#add_iqr_html').click(function()
  {
    if($("#count_classify").val() > 0)
    {
      window.open('/business/iqr_html_add', '新增自訂網頁', config='height=650,width=1200,left=300,top=50,resizable=yes,scrollbar=yes,scrollbars=1');
    }
    else
    {
      $("#add_iqr_classify").focus();
      $("#add_iqr_classify").stop(true).animate({
        backgroundColor: '#E6D933',
        color: '#E32636'
      }, 1500, 'swing', function() {
        $("#add_iqr_classify").animate({
          backgroundColor : "#B2A171",
          color : ""
        }, 1500);
      });
    }
  });

  $('.html_edit').each(function()
  {
    var class_name = 'html_edit';
    var edit_id = $(this).attr('id').substr(class_name.length + 1);
    $(this).click(function()
    {
      window.open('/business/iqr_html_edit/'+edit_id, '編輯自訂網頁', config='height=650,width=1200,left=300,top=50,resizable=yes,scrollbar=yes,scrollbars=1');
    });
  });

  $('.html_preview').each(function()
  {
    var class_name = 'html_preview';
    var preview_id = $(this).attr('id').substr(class_name.length + 1);
    $(this).click(function()
    {
      window.open('/business/html_web/'+preview_id, '', config='height=650,width=320,left=500,top=50,resizable=yes,scrollbar=yes,scrollbars=1');
    });
  });

  $('.html_del').each(function()
  {
    var class_name = 'html_del';
    var del_id = $(this).attr('id').substr(class_name.length + 1);
    $(this).click(function()
    {
      if(confirm('您確定要刪除此自訂網頁?'))
      {
        window.onbeforeunload=null;
        window.location.href = '/business/iqr_html_del/'+del_id;
      }
    });
  });

  $('#add_iqr_classify').click(function() {
    window.open('/business/iqr_classify_add', '新增自訂類別', config = 'height=250,width=750,left=300,top=50,resizable=yes,scrollbar=yes,scrollbars=1');
  });

  $('.classify_edit').each(function() {
    var class_name = 'classify_edit';
    var edit_id = $(this).attr('id').substr(class_name.length + 1);
    $(this).click(function() {
      window.open('/business/iqr_classify_edit/' + edit_id, '編輯自訂類別', config = 'height=250,width=750,left=300,top=50,resizable=yes,scrollbar=yes,scrollbars=1');
    });
  });

  $('.classify_del').each(function() {
    var class_name = 'classify_del';
    var del_id = $(this).attr('id').substr(class_name.length + 1);
    $(this).click(function() {
      $.ajax({
        url: "/business/ajax_chk_classify",
        type: "post",
        data: {
          classifyID: del_id
        },
        cache: false,
        async: false,
        success: function(response) {
          // alert(response);
          if (response) {
            if (confirm('您確定要刪除此產品分類?')) {
              window.onbeforeunload = null;
              window.location.href = '/business/iqr_classify_del/' + del_id;
            }
          } else {
            alert("此分類正在使用，無法刪除");
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {}
      });
    });
  });

  $('#add_ytb_category').click(function() {
    window.open('/business/ytb_category_add', '新增自訂類別', config = 'height=250,width=750,left=300,top=50,resizable=yes,scrollbar=yes,scrollbars=1');
  });

  $('.ytb_category_edit').each(function() {
    var class_name = 'ytb_category_edit';
    var edit_id = $(this).attr('id').substr(class_name.length + 1);
    $(this).click(function() {
      window.open('/business/ytb_category_edit/' + edit_id, '編輯自訂類別', config = 'height=250,width=750,left=300,top=50,resizable=yes,scrollbar=yes,scrollbars=1');
    });
  });

  $('.ytb_category_del').each(function() {
    var class_name = 'ytb_category_del';
    var del_id = $(this).attr('id').substr(class_name.length + 1);
    $(this).click(function() {
      $.ajax({
        url: "/business/ajax_chk_category",
        type: "post",
        data: {
          classifyID: del_id
        },
        cache: false,
        async: false,
        success: function(response) {
          if (response) {
            if (confirm('您確定要刪除此產品分類?')) {
              window.onbeforeunload = null;
              window.location.href = '/business/ytb_category_del/' + del_id;
            }
          } else {
            alert("此分類正在使用，無法刪除");
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {}
      });
    });
  });

  //mobile phones
  //add 
    var mobile_phones_num = $('#mobile_phones_num').val();
    $('#add_mobile_phones').on('click', function()
    {
      mobile_phones_num++;
      if($("#sys_mobile_phones_num").val() == $('#mobile_phones_num').val()-1)
      {
        alert('網址數量已達上限');
      }
      else
      {
        if($('#mobile').val() == '')
        {
          alert('請先輸入手機號碼，才允許新增數筆。');
          $('#mobile').focus();
          return false;
        }
        else
        {
          $('#prompt_4').html('');
          $("#add_mobile_phones_form input[type=reset]").trigger("click");
          $( "#dialog-form-mobile-phones" ).dialog( "open" );
        }
      }
    });
  //delete
    $("#mobile_phones_table").on('mousedown','.del_mobile_phones',function()
    {
      $("#mobile_phones_table").mouseup();
      var id_prefix = 'del_mobile_phones_';
      var this_id = $(this).attr('id').substr(id_prefix.length);

      if(confirm('按鈕名稱：'+$('#mobile_phones_name_'+this_id).val()+'\n網站網址：'+$('#mobile_phones_'+this_id).val()+'\n\n確定移除?'))
      {
        $.ajax({
          type: "post",
          url: '/dynamic/delete',
          data: {
              mid:  $('#member_id').val(),
              id:   this_id,
              type: 4
          },
          cache: false,
          error: function(XMLHttpRequest, textStatus, errorThrown)
          {
          },
          success: function (response) {
            $('#mobile_phones_'+this_id).closest('tr').remove();
            $('#mobile_phones_num').val(--mobile_phones_num);
              if($('#mobile_phones_tbody tr').length() == 0)
                $('.mobile_phones_empty_text').html('');
          }
        });
      }
    });
  //ajax
    $("#dialog-form-mobile-phones").dialog({
      autoOpen: false,
      height: 300,
      width: 650,
      modal: true,
      buttons: {
        "Add": {
          text: '新增', class: 'btn btn-default', click: function() {
            if($('#add_mobile_phones_form input[name=str_name]').val().length != 0 && $('#add_mobile_phones_form input[name=str]').val().length != 0)
            {
              $.post("/dynamic/add", $('#add_mobile_phones_form').serialize(), function(data){
                var strings = data.split("*#");
                $("#mobile_phones_table").append(""+
                ""+
                "<tr>"+
                "<td>"+
                "  <input type='text' value='"+strings[0]+"' placeholder='按鈕顯示名稱' name='mobile_phones_name["+strings[2]+"]' id='mobile_phones_name_"+strings[2]+"' maxlength='15'>&nbsp;<a href='#' class='why'>?</a><div class='prompt-box'>請輸入按鈕名稱，例如「直撥我的手機號碼」</div>"+
                "  <input type='text' value='"+strings[1]+"' class='iii2' placeholder='手機號碼必填' maxlength='10' minlengh='8' name='mobile_phones["+strings[2]+"]' id='mobile_phones_"+strings[2]+"'>&nbsp;<a href='#' class='why'>?</a><div class='prompt-box'>請輸入您的「手機號碼數字8-10碼」，例如「0941xxx083」</div>"+
                "  &nbsp;<a href='javascript:void(0);' class='aa2 del_mobile_phones' id='del_mobile_phones_"+strings[2]+"'>移除</a>"+
                "</td>"+
                "</tr>"+
                "");
                $( "#dialog-form-mobile-phones" ).dialog( "close" );
                $('.mobile_phones_empty_text').html('');
              });
            }
            else
            {
              $('#prompt_4').html('請填寫所有欄位');
            }
          }
        },
        "Cancel": {
          text: '取消', class: 'btn btn-default', click: function() {
            $( "#dialog-form-mobile-phones" ).dialog( "close" );
          }
        }
      }
    });

});