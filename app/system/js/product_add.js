//ckeditor
var prd_content_ck;
var prd_content = document.getElementById('prd_content');
function createEditor( languageCode )
{
  if(prd_content != null)
  {
    if ( prd_content_ck )
    {
      prd_content_ck.destroy();
    }

    prd_content_ck = CKEDITOR.replace( 'prd_content', {
      filebrowserImageBrowseUrl : '/js/ckfinder/ckfinder.html?Type=Images',
      width : 900,
      height: 600,
      resize_enabled:false,
      enterMode: 2,
      forcePasteAsPlainText :true,
      toolbar :
      [
        ['Source', '-', 'Undo','Redo'],
        ['Cut','Copy' , 'Table', 'NumberedList','BulletedList'],
        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
        ['Bold','Italic','Underline','Strike', 'TextColor', 'BGColor', '-', 'Font','FontSize', '-', 'Image']
      ]
    });
  }   
}
createEditor( '' );

//離開頁面確認
window.onbeforeunload = function()
{ 
　　return "您即將離開本頁面，商品將不會被新增"; 
}

$(function()
{
  $('#prd_describe_prompt_p').hide();
  $('#prd_specification_prompt_p').hide();
  $('#prd_video_prompt_p').hide();

  $('#prd_amount').change(function()
  {
    if(parseInt($('#prd_safe_amount').val()) > parseInt($(this).val()))
    {
      $('#prd_safe_amount').val($(this).val());
    }
    if(0 >= parseInt($('#prd_safe_amount').val()))
    {
      $('#prd_safe_amount').val(1);
    }
  });
  $('#prd_safe_amount').change(function()
  {
    if(parseInt($(this).val()) > parseInt($('#prd_amount').val()))
    {
      $(this).val($('#prd_amount').val());
    }
    if(0 >= parseInt($(this).val()))
    {
      $(this).val(1);
    }
  });

  //取消按鈕
  $('#cancel').click(function(){
    if(confirm('您確定要取消新增嗎?'))
    {
      window.onbeforeunload=null;
      window.close();
      return true;
    }
  });

  $('#prd_price00').change(function(){
    if($('#prd_price00').val() > 99999999)
      $('#prd_price00').val(99999999);
  });
  $('#prd_price01').change(function(){
    if($('#prd_price01').val() > 99999999)
      $('#prd_price01').val(99999999);
  });

  //商品特點
  //sortable
  $('#prd_describe_table_tbody').sortable();

  //onchange column number
  $('#add_prd_describe_col').click(function(){
    $("#prd_describe_table").append(
      "<tr>"+
            "<td style='width: 441px;'>"+
            "  <input type='text' class='form-control prd_describe' style='display:inline; width: 71%;' name='prd_describe[]' id='prd_describe[]' maxlength='128'>"+
            "  &nbsp;排序&nbsp;<button type='button' class='btn btn-danger del_prd_describe_col' onclick='javascript:void(0);'>移除</button>"+
            "</td>"+
            "</tr>"
        );
  });
  //delete
  $("#prd_describe_table_tbody").on('click', '.del_prd_describe_col', function()
  {
    $(this).parent().parent().remove();
  });
  //商品特點結束

  //商品規格
  //sortable
  $('#prd_specification_table_tbody').sortable();

  //onchange column number
  $('#add_prd_specification_col').click(function(){
    $("#prd_specification_table").append(
      "<tr>"+
            "<td>"+
            "  <input type='text' placeholder='規格名稱' class='form-control prd_specification_name' style='display:inline; width: 26%;' name='prd_specification_name[]' id='prd_specification_name[]' maxlength='16'>"+
            "  <input placeholder='規格內容' type='text' class='form-control prd_specification_content' style='display:inline; width: 40%;' name='prd_specification_content[]' id='prd_specification_content[]' maxlength='128'>"+
            "  &nbsp;排序&nbsp;<button type='button' class='btn btn-danger del_prd_specification_col' onclick='javascript:void(0);'>移除</button>"+
            "</td>"+
            "</tr>"
        );
  });
  //delete
  $("#prd_specification_table_tbody").on('click', '.del_prd_specification_col', function()
  {
    $(this).parent().parent().remove();
  });
  //商品規格結束

  //介紹影片
  //sortable
  $('#prd_video_table_tbody').sortable();

  //onchange column number
  $('#add_prd_video_col').click(function(){
    $("#prd_video_table").append(
      "<tr>"+
            "<td>"+
            "  <input type='text' placeholder='影片標題' class='form-control prd_video_name' style='display:inline; width: 26%;' name='prd_video_name[]' id='prd_video_name[]' maxlength='32'>"+
            "  <input placeholder='影片網址' type='text' class='form-control prd_video_link' style='display:inline; width: 40%;' name='prd_video_link[]' id='prd_video_link[]' maxlength='255'>"+
            "  &nbsp;排序&nbsp;<button type='button' class='btn btn-danger del_prd_video_col' onclick='javascript:void(0);'>移除</button>"+
            "</td>"+
            "</tr>"
        );
  });
  //delete
  $("#prd_video_table_tbody").on('click', '.del_prd_video_col', function()
  {
    $(this).parent().parent().remove();
  });
  //介紹影片結束

  //新增完成
  if($('#success').val() == 1)
  {
    alert('新增成功');
    opener.window.parent.location.reload(); 
    window.onbeforeunload=null;
    window.close();
  }

  //驗證必填欄位
  $('#form_product_add').validate({
      success: function(label) {
          label.addClass("success").text("");
      }
  });

  // 檔案開始上傳狀態偵測
  // 驗證表單合法     $('#form_product_add').valid()
  // 驗證商品分類合法 vaild_status

  $('#form_product_add').submit(function(event)
  {
    if($("#class_group").get(0).selectedIndex == 0)
    {
        $('#select_class_group').text(' ↑ 您必須選擇商品分類');
        $('#select_class_group').css('color', '#ff6600');
        $('html, body').scrollTop(0);
        event.preventDefault();
    }
    else
    {
      $('#select_class_group').text('');
    }

    //商品特點
    $('.prd_describe').each(function()
    {
      if($(this).val().length == 0)
      {
        $('#prd_describe_prompt_p').show();
        event.preventDefault();
      }
      else
      {
        $('#prd_describe_prompt_p').hide();
      }
    });

    //商品規格
    var show_prd_specification_prompt_p_1 = false;
    var show_prd_specification_prompt_p_2 = false;
    $('.prd_specification_name').each(function()
    {
      if($(this).val().length == 0)
      {
        show_prd_specification_prompt_p_1 = true;
        return false;
      }
      else
        show_prd_specification_prompt_p_1 = false;
    });

    $('.prd_specification_content').each(function()
    {
      if($(this).val().length == 0)
      {
        show_prd_specification_prompt_p_2 = true;
        return false;
      }
      else
        show_prd_specification_prompt_p_2 = false;
    });
    if(show_prd_specification_prompt_p_1 || show_prd_specification_prompt_p_2)
    {
      $('#prd_specification_prompt_p').show();
      event.preventDefault();
    }
    else
      $('#prd_specification_prompt_p').hide();

    //介紹影片
    var show_prd_video_prompt_p_1 = false;
    var show_prd_video_prompt_p_2 = false;
    $('.prd_video_name').each(function()
    {
      if($(this).val().length == 0)
      {
        show_prd_video_prompt_p_1 = true;
        return false;
      }
      else
        show_prd_video_prompt_p_1 = false;
    });
    $('.prd_video_link').each(function()
    {
      if($(this).val().length == 0)
      {
        show_prd_video_prompt_p_2 = true;
        return false;
      }
      else
        show_prd_video_prompt_p_2 = false;
    });
    if(show_prd_video_prompt_p_1 || show_prd_video_prompt_p_2)
    {
      $('#prd_video_prompt_p').show();
      event.preventDefault();
    }
    else
      $('#prd_video_prompt_p').hide();
  });

  $('#blah').css('display', 'none');
});

function readURL(input) {
  if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function (e) {
          $('#blah').attr('src', e.target.result);
      }
      
      reader.readAsDataURL(input.files[0]);
  }
  $('#blah').css('display', '');
}

$("#prd_image").change(function()
{

  var iSize = ($("#prd_image")[0].files[0].size / 1024); 
  if (iSize / 1024 > 1) 
  { 
    if (((iSize / 1024) / 1024) > 1) 
    { 
      iSize = (Math.round(((iSize / 1024) / 1024) * 100) / 100);
      iSIzeType = "Gb";
    }
    else
    { 
      iSize = (Math.round((iSize / 1024) * 100) / 100);
      iSIzeType = "Mb";
    } 
  } 
  else 
  {
    iSize = (Math.round(iSize * 100) / 100);
    iSIzeType = "kb";
  } 
  if(iSIzeType == 'kb' || (iSIzeType == 'Mb' && iSize <= 3))
  {
    var type = /(.png|.PNG|.jpg|.JPG|.jpeg|.JPEG|.gif|.GIF)$/i;
    if(type.test($("#prd_image").val()))
    {
      readURL(this);
      $('#blah').css('max-width', '175px');
    }
    else
    {
      alert('僅允許*.png, *.jpg, *.gif類型圖檔上傳');
      $('#blah').css('display', 'none');
      $('#prd_image').val('');
      $('#prd_image').get(0).click();
    }
  }
  else
  {
    alert('您使用的圖檔過大，請使用3MB以下圖檔');
    $('#blah').css('display', 'none');
    $('#prd_image').val('');
    $('#prd_image').get(0).click();
  }
});